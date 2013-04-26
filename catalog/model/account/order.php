<?php
class ModelAccountOrder extends Model {
	public function getOrder($order_id) {
		$order_query = $this->db->query("SELECT o.*,s.name  as store_name FROM `" . DB_PREFIX . "order` o left join ".DB_PREFIX."store s on o.store_id=s.store_id  WHERE o.order_id = '" . (int)$order_id . "' AND o.customer_id = '" . (int)$this->customer->getId() . "' AND o.order_status_id > '0'");
	
		if ($order_query->num_rows) {
		
			/* $country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$order_query->row['payment_country_id'] . "'");
			
			if ($country_query->num_rows) {
				$payment_iso_code_2 = $country_query->row['iso_code_2'];
				$payment_iso_code_3 = $country_query->row['iso_code_3'];
			} else {
				$payment_iso_code_2 = '';
				$payment_iso_code_3 = '';				
			}
			
			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$order_query->row['payment_zone_id'] . "'");
			
			if ($zone_query->num_rows) {
				$payment_zone_code = $zone_query->row['code'];
			} else {
				$payment_zone_code = '';
			}
			
			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$order_query->row['shipping_country_id'] . "'");
			
			if ($country_query->num_rows) {
				$shipping_iso_code_2 = $country_query->row['iso_code_2'];
				$shipping_iso_code_3 = $country_query->row['iso_code_3'];
			} else {
				$shipping_iso_code_2 = '';
				$shipping_iso_code_3 = '';				
			}
			
			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$order_query->row['shipping_zone_id'] . "'");
			
			if ($zone_query->num_rows) {
				$shipping_zone_code = $zone_query->row['code'];
			} else {
				$shipping_zone_code = '';
			} */
			
			
			return array(
				'order_id'                => $order_query->row['order_id'],
				'orderid'                 => $order_query->row['orderid'],
				// 'invoice_no'              => $order_query->row['invoice_no'],
				// 'invoice_prefix'          => $order_query->row['invoice_prefix'],
				'store_id'                => $order_query->row['store_id'],
				'store_name'              => $order_query->row['store_name'],
				// 'store_url'               => $order_query->row['store_url'],				
				'customer_id'             => $order_query->row['customer_id'],
				'username'               => $order_query->row['username'],
			    
				'telphone'               => $order_query->row['telphone'],
				'mobile'                     => $order_query->row['mobile'],
				'email'                   => $order_query->row['email'],
				'payment_username'       => $order_query->row['payment_username'],
				
				// 'payment_company'         => $order_query->row['payment_company'],
				'payment_address'       => $order_query->row['payment_address'],

				'payment_postcode'        => $order_query->row['payment_postcode'],
				
				'payment_method'          => $order_query->row['payment_method'],
				'shipping_username'      => $order_query->row['shipping_username'],
			    'shipping_mobile'        => $order_query->row['shipping_mobile'],
				// 'shipping_company'        => $order_query->row['shipping_company'],
				'shipping_address'      => $order_query->row['shipping_address'],

				'shipping_postcode'       => $order_query->row['shipping_postcode'],
			
				'shipping_method'         => $order_query->row['shipping_method'],
				'comment'                 => $order_query->row['comment'],
				'total'                   => $order_query->row['total'],
				'order_status_id'         => $order_query->row['order_status_id'],
	
				'date_modified'           => $order_query->row['date_modified'],
				'date_added'              => $order_query->row['date_added'],
				'ip'                      => $order_query->row['ip']
			);
		} else {
			return false;	
		}
	}
	 
	public function getOrders($data=array()) {
		if ($data['start'] < 0) {
			$data['start'] = 0;
		}
		
		if ($data['limit'] < 1) {
			$data['limit'] = 1;
		}	
		
		$sql="SELECT o.order_id,o.payment_method, o.username,os.order_status_id ,os.name as status, o.date_added, o.total,o.store_id,s.name as store_name FROM `" . DB_PREFIX . "order` o LEFT JOIN " . DB_PREFIX . "order_status os ON (o.order_status_id = os.order_status_id) left join `".DB_PREFIX."store` s on o.store_id=s.store_id  WHERE o.customer_id = '" . (int)$this->customer->getId() . "'";
		if (!empty($data['statusid'])) $sql.="  AND o.order_status_id = '".(int)$data['statusid']."'";
		
		
		$sql.= "ORDER BY o.order_id DESC LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		
		$query = $this->db->query($sql);	
	
		return $query->rows;
	}
	
	public function getOrderProducts($order_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");
	
		return $query->rows;
	}
	
	public function getOrderOptions($order_id, $order_product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product_id . "'");
	
		return $query->rows;
	}
	
	public function getOrderVouchers($order_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_voucher` WHERE order_id = '" . (int)$order_id . "'");
		
		return $query->rows;
	}
	
	public function getOrderTotals($order_id,$code='') {
	    if(!empty($code)){
			$sql="SELECT order_total_id,order_id,code,title,text,value,sort_order FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int)$order_id . "' and code='{$code}' ORDER BY sort_order";
			$query = $this->db->query($sql);
		    return $query->row;
		}else{
		    $sql="SELECT order_total_id,order_id,code,title,text,value,sort_order FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int)$order_id . "' ORDER BY sort_order";
			$query = $this->db->query($sql);
			return $query->rows;
        }
	}	

	public function getOrderHistories($order_id) {
		$query = $this->db->query("SELECT date_added, os.name AS status, oh.comment, oh.notify FROM " . DB_PREFIX . "order_history oh LEFT JOIN " . DB_PREFIX . "order_status os ON oh.order_status_id = os.order_status_id WHERE oh.order_id = '" . (int)$order_id . "' ORDER BY oh.date_added");// AND oh.notify = '1' 通知才显示了
	
		return $query->rows;
	}	

	public function getOrderDownloads($order_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_download WHERE order_id = '" . (int)$order_id . "' ORDER BY name");
	
		return $query->rows; 
	}	

	public function getTotalOrders($data=array()) {
	    $sql="SELECT COUNT(order_id) AS total FROM `" . DB_PREFIX . "order` WHERE customer_id = '" . (int)$this->customer->getId() . "'";
		if (!empty($data['statusid'])) $sql.=" AND order_status_id ='".(int)$data['statusid']."'";
      	$query = $this->db->query($sql);
		
		return $query->row['total'];
	}
		
	public function getTotalOrderProductsByOrderId($order_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");
		
		return $query->row['total'];
	}
	
	public function getTotalOrderVouchersByOrderId($order_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order_voucher` WHERE order_id = '" . (int)$order_id . "'");
		
		return $query->row['total'];
	}	
	
	/**
	*  根据$order_status_id获取 订单 状态
	*/
	public function getOrderStatus($order_status_id=''){
	    $data=array();
		if(empty($order_status_id)){
		    $sql="SELECT order_status_id,name  FROM `" . DB_PREFIX . "order_status` where order_status_id<=7";
	        $query = $this->db->query($sql);
	        $data=$query->rows;
	    }else{
		    $sql="SELECT order_status_id,name  FROM `" . DB_PREFIX . "order_status` WHERE order_status_id = '" . (int)$order_status_id . "'";
		    $query = $this->db->query($sql);
	        $data=$query->row;
		}
	    
		return $data;

	}
	
	/**根据订单的状态取订单数**/
	public function getOrderNumByStatus($customerid,$statusid){
	    if(empty($statusid)) return;
		
	    $sql="select count(order_id) as total from `".DB_PREFIX."order` where customer_id='{$customerid}' and order_status_id='{$statusid}'";
       
		$query=$this->db->query($sql);
		return $query->row;
	
	}
	
}
?>