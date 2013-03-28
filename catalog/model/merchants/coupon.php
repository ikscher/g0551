<?php
/**
*  商家商品信息
*/
class ModelMerchantsCoupon extends Model {
	/**
	*  获取商铺优惠券列表
	*  intStart   :起始记录
	*  intCount   ：多少条记录
	*  data       ：搜索条件
	*/
	public function getCouponList($intStart,$intCount,$data){
		$where=isset($data['where'])?$data['where']:"";
		$store_id=$this->cookie->OCAuthCode($this->request->cookie['storeid'],'DECODE');
		if(empty($store_id)){
			$this->showMessage("您还没有开店，或登录已超时，请重新登录！");
		}
		
		$strSql="";
		if($where!="") $strSql.=$where;

		$res=array();
		$query=$this->db->query("select coupon_id,customer_id,name,code,type,discount,total,date_start,date_end,status from `coupon` where store_id={$store_id} ".$strSql." order by coupon_id desc limit {$intStart},{$intCount}");
		if($query->num_rows>0){
	   		return $query->rows;
		}
		return $res;
	}

	/**
	*  获取优惠券总条数
	*  data : 搜索条件
	*/
	public function getTotalCoupon($data){
		$where=isset($data['where'])?$data['where']:"";
		$store_id=$this->cookie->OCAuthCode($this->request->cookie['storeid'],'DECODE');
		if(empty($store_id)){
			$this->showMessage("您还没有开店，或登录已超时，请重新登录！");
		}
		$strSql="";
		if($where!="") $strSql.=$where;
		
		$strSql="select count(coupon_id) as total from `coupon` where store_id={$store_id}".$strSql;
		$query=$this->db->query($strSql);
		return $query->row["total"];
	}
	
	/**
	*  获取优惠券使用用户信息
	*  intCustomerId   :用户ID号
	*/
	public function getCustomerInfo($intCustomerId){
		$query=$this->db->query("select email from `customer` where customer_id={$intCustomerId}");
		if($query->num_rows>0){
	   		return $query->row;
		}
		return "";
	}


	/**
	*  保存优惠券信息
	*  data   :优惠券信息数组
	*/
	public function saveInfo($data) {
	    //$str=array();
		$coupon_id   =$this->db->escape($data['coupon_id']);
		$name   =$this->db->escape($data['name']);
		$code    =$this->db->escape($data['code']);
		$type  =$this->db->escape($data['type']);
		$discount    =$this->db->escape($data['discount']);
		$total   =$this->db->escape($data['total']);
		$date_start   =$this->db->escape($data['date_start']);
	    $date_end   =$this->db->escape($data['date_end']);
	    $date_added   =$this->db->escape($data['date_added']);
		$store_id=$this->cookie->OCAuthCode($this->request->cookie['storeid'],'DECODE');
		if(empty($store_id)){
			$this->showMessage("您还没有开店，或登录已超时，请重新登录！");
		}
		
		if($coupon_id==0){
			$query=$this->db->query("INSERT INTO " . DB_PREFIX . "coupon SET store_id = {$store_id}, name = '{$name}',code = '{$code}', type = '{$type}', discount = {$discount},  total = {$total}, date_start = {$date_start}, date_end = {$date_end}, date_added = {$date_added}");
		}else{
			$query=$this->db->query("UPDATE " . DB_PREFIX . "coupon SET name = '{$name}',code = '{$code}', type = '{$type}', discount = {$discount},  total = {$total}, date_start = {$date_start}, date_end = {$date_end} Where store_id = {$store_id} And coupon_id={$coupon_id}");
		}
		
		if($query===true){
			return "ok";
		}
		return "no";
	}
	
	/**
	*  获取优惠券详细信息
	*  intCouponId   :优惠券ID号
	*/
	public function getCouponInfo($intCouponId){
		$store_id=$this->cookie->OCAuthCode($this->request->cookie['storeid'],'DECODE');
		if(empty($store_id)){
			$this->showMessage("您还没有开店，或登录已超时，请重新登录！");
		}
		$res=array("coupon_id"=>"","name"=>"","code"=>"","type"=>"P","discount"=>"","total"=>"","date_start"=>"","date_end"=>"");
		$query=$this->db->query("select * from " . DB_PREFIX . "coupon where store_id={$store_id} and coupon_id={$intCouponId}");
		if($query->num_rows>0){
			$res=$query->row;
		}
		return $res;
	}
	
	/**
	*  删除店名优惠券详细信息
	*  intCouponId   :优惠券ID号
	*/
	public function delCoupon($intCouponId){
		$store_id=$this->cookie->OCAuthCode($this->request->cookie['storeid'],'DECODE');
		if(empty($store_id)){
			$this->showMessage("您还没有开店，或登录已超时，请重新登录！");
		}
		$query=$this->db->query("delete from " . DB_PREFIX . "coupon where store_id={$store_id} And coupon_id in(". $intCouponId .") And status=1");
		if($query===true){
			return "ok";
		}
		return "no";
	}
}
?>