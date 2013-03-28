<?php
/**
*  商家商品信息
*/
class ModelMerchantsOrder extends Model {
	/**
	*  获取商铺订单列表
	*  intStart   :起始记录
	*  intCount   ：多少条记录
	*  data       ：搜索条件
	*/
	public function getOrderList($data){
		
		$orderid=isset($data['orderid'])?$this->db->escape($data['orderid']):"";
		$email=isset($data['email'])?$this->db->escape($data['email']):"";
		$mobile=isset($data['mobile'])?$this->db->escape($data['mobile']):"";
		$cname=isset($data['cname'])?$this->db->escape($data['cname']):"";
		$cmobile=isset($data['cmobile'])?$this->db->escape($data['cmobile']):"";
		$ctelephone=isset($data['ctelephone'])?$this->db->escape($data['ctelephone']):"";
		$order_time=isset($data['order_time'])?$this->db->escape($data['order_time']):"";
		$store_id=$this->cookie->OCAuthCode($this->request->cookie['storeid'],'DECODE');
		if(empty($store_id)){
			$this->showMessage("您还没有开店，或登录已超时，请重新登录！");
		}
		
		$where="  AND o.order_status_id in({$data['statusid']})";
		
		if($orderid!="") $where.=" And o.orderid='{$orderid}'";
		if($email!="") $where.=" And c.email='{$email}'";
		if($mobile!="") $where.=" And c.mobile='{$mobile}'";
		if($cname!="") $where.=" And o.username='{$cname}'";
		if($cmobile!="") $where.=" And o.mobile='{$cmobile}'";
		if($ctelephone!="") $where.=" And o.telephone='{$ctelephone}'";
		//if($order_time!="") $where.=" And from_unixtime(a.date_added) like '{$order_time}%'";
		$res=array();
		
		$sql="select o.order_id,o.customer_id,o.orderid,o.username,o.mobile,o.total,o.order_status_id,o.date_added,c.email from ".DB_PREFIX."`order` o inner join ".DB_PREFIX."customer c on o.store_id={$store_id} and o.customer_id=c.customer_id ".$where;
	
		if ($data['start'] < 0) {
			$data['start'] = 0;
		}
		
		if ($data['limit'] < 1) {
			$data['limit'] = 1;
		}
		
		$sql.= "  order by o.order_id desc  LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		
		$query=$this->db->query($sql);
		
	   	$res=$query->rows;
		
		return $res;
	}

	/**
	*  获取订单总条数
	*  data : 搜索条件
	*/
	public function getTotalOrder($data){
		
		$orderid=isset($data['orderid'])?$this->db->escape($data['orderid']):"";
		$email=isset($data['email'])?$this->db->escape($data['email']):"";
		$mobile=isset($data['mobile'])?$this->db->escape($data['mobile']):"";
		$cname=isset($data['cname'])?$this->db->escape($data['cname']):"";
		$cmobile=isset($data['cmobile'])?$this->db->escape($data['cmobile']):"";
		$ctelephone=isset($data['ctelephone'])?$this->db->escape($data['ctelephone']):"";
		$order_time=isset($data['order_time'])?$this->db->escape($data['order_time']):"";
		$store_id=$this->cookie->OCAuthCode($this->request->cookie['storeid'],'DECODE');
		if(empty($store_id)){
			$this->showMessage("您还没有开店，或登录已超时，请重新登录！");
		}
		
		$where="  AND o.order_status_id  in ({$data['statusid']})";
		
		if($orderid!="") $where.=" And o.orderid='{$orderid}'";
		if($email!="") $where.=" And c.email='{$email}'";
		if($mobile!="") $where.=" And c.mobile='{$mobile}'";
		if($cname!="") $where.=" And o.username='{$cname}'";
		if($cmobile!="") $where.=" And o.mobile='{$cmobile}'";
		if($ctelephone!="") $where.=" And o.telephone='{$ctelephone}'";
		//if($order_time!="") $where.=" And from_unixtime(a.date_added) like '{$order_time}%'";
		
		$sql="select count(o.order_id) as total from ".DB_PREFIX."`order`  o inner join ".DB_PREFIX."customer c  on o.customer_id=c.customer_id and o.store_id={$store_id}".$where;
		$query=$this->db->query($sql);
		return $query->row["total"];
	}
	
	/**
	*  获取订单商品列表
	*  intOrderId   :订单ID号
	*/
	public function getOrderProduct($intOrderId){
		$res=array();
		$query=$this->db->query("select a.product_id,a.name,a.model,a.quantity,a.price,a.total,a.attribute,b.image from `order_product` as a,product as b where a.order_id={$intOrderId} and a.product_id=b.product_id order by a.order_product_id desc");
		
	   	$res=$query->rows;
		
		return $res;
	}
		
		
	/**
	*  获取订单详细信息
	*  intOrderId   :订单ID号
	*/
	public function getOrderOnce($intOrderId){
		$store_id=$this->cookie->OCAuthCode($this->request->cookie['storeid'],'DECODE');
		if(empty($store_id)){
			$this->showMessage("您还没有开店，或登录已超时，请重新登录！");
		}
		$query=$this->db->query("select a.order_id,a.customer_id,a.orderid,a.username,a.mobile,a.telephone,a.postcode,a.address,a.total,a.comment,a.order_status_id,a.date_added,b.email,b.username as user_username,b.nickname,b.mobile as user_mobile,b.telephone as user_telephone from `order` as a,customer as b where a.store_id={$store_id} and a.customer_id=b.customer_id and a.order_id={$intOrderId}");
		if($query->num_rows>0){
	   		return $query->row;
		}
		return $res;
	}
		
	/**
	* 设置商品状态信息
	*/
	public function setOrderState($order_id,$NewState,$OldState=0){
		/* $store_id=$this->cookie->OCAuthCode($this->request->cookie['storeid'],'DECODE');
		if(empty($store_id)){
			$this->showMessage("您还没有开店，或登录已超时，请重新登录！");
		} */
		if($OldState>0){
			$query=$this->db->query("select order_status_id from `".DB_PREFIX."order` where order_id={$order_id} and order_status_id={$OldState}");
			if($query->num_rows==0){
				return "no";
			}
		}
		$query=$this->db->query("update `order` SET order_status_id={$NewState} where order_id={$order_id}  and order_status_id={$OldState}");
		if($query){
			return "ok";
		}
		return "no";
	}
	
	

}
?>