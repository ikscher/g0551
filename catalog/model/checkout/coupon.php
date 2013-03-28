<?php
class ModelCheckoutCoupon extends Model {
    /** 
	*  根据优惠券代码$code取到 优惠信息 当客户购物时输入此代码技能享受相应优惠
	*/
	public function getCoupon($code) {
	    $time=time();
		$status = true;
		
		
		$coupon_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "coupon WHERE code = '" . $this->db->escape($code) . "' AND date_start <= {$time} AND date_end > {$time} AND status = '1'");
			
		if ($coupon_query->num_rows) {
			if ($coupon_query->row['total'] >= $this->cart->getSubTotal()) {//优惠券的金额大于购买产品的总金额
				$status = false;
			}
		
			$coupon_history_query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "coupon_history` ch WHERE ch.coupon_id = '" . (int)$coupon_query->row['coupon_id'] . "'");
            
			//使用过优惠券 并且累计使用的优惠券 大于等于 允许使用的总次数（优惠券使用的次数有限制）
			if ($coupon_query->row['uses_total'] > 0 && ($coupon_history_query->row['total'] >= $coupon_query->row['uses_total'])) {
				$status = false;
			}
			
			if ($coupon_query->row['logged'] && !$this->customer->getId()) {
				$status = false;
			}
			
			//会员使用优惠券的次数有限制
			if ($this->customer->getId()) {
				$coupon_history_query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "coupon_history` ch WHERE ch.coupon_id = '" . (int)$coupon_query->row['coupon_id'] . "' AND ch.customer_id = '" . (int)$this->customer->getId() . "'");
				
				if ($coupon_query->row['uses_customer'] > 0 && ($coupon_history_query->row['total'] >= $coupon_query->row['uses_customer'])) {
					$status = false;
				}
			}
			
			//优惠券只针对商品使用，即对应于商品（一对多的关系）
			$coupon_product_data = array();
				
			$coupon_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "coupon_product WHERE coupon_id = '" . (int)$coupon_query->row['coupon_id'] . "'");

			foreach ($coupon_product_query->rows as $result) {
				$coupon_product_data[] = $result['product_id'];
			}
				
			if ($coupon_product_data) {
				$coupon_product = false;
					
				foreach ($this->cart->getProducts() as $product) {
					if (in_array($product['product_id'], $coupon_product_data)) {
						$coupon_product = true;
							
						break;
					}
				}
					
				if (!$coupon_product) {
					$status = false;
				}
			}
		} else {
			$status = false;
		}
		
		if ($status) {
			return array(
				'coupon_id'     => $coupon_query->row['coupon_id'],
				'code'          => $coupon_query->row['code'],
				'name'          => $coupon_query->row['name'],
				'type'          => $coupon_query->row['type'],
				'discount'      => $coupon_query->row['discount'],
				'shipping'      => $coupon_query->row['shipping'],
				'total'         => $coupon_query->row['total'],
				'product'       => $coupon_product_data,
				'date_start'    => $coupon_query->row['date_start'],
				'date_end'      => $coupon_query->row['date_end'],
				'uses_total'    => $coupon_query->row['uses_total'],
				'uses_customer' => $coupon_query->row['uses_customer'],
				'status'        => $coupon_query->row['status'],
				'date_added'    => $coupon_query->row['date_added']
			);
		}
	}
	
	public function redeem($coupon_id, $order_id, $customer_id, $amount) {
	    $time=time();
		$this->db->query("INSERT INTO `" . DB_PREFIX . "coupon_history` SET coupon_id = '" . (int)$coupon_id . "', order_id = '" . (int)$order_id . "', customer_id = '" . (int)$customer_id . "', amount = '" . (float)$amount . "', date_added ={$time}");
	}
}
?>