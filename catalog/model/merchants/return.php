<?php
/**
*  买家退换货信息
*/
class ModelMerchantsReturn extends Model {
	/**
	*  获取商铺退换货列表
	*  intStart   :起始记录
	*  intCount   ：多少条记录
	*  data       ：搜索条件
	*/
	public function getReturnList($intStart,$intCount,$data){
		$where=isset($data['where'])?$data['where']:"";
		$store_id=$this->cookie->OCAuthCode($this->request->cookie['storeid'],'DECODE');
		if(empty($store_id)){
			$this->showMessage("您还没有开店，或登录已超时，请重新登录！");
		}
		
		$strSql="";
		if($where!="") $strSql.=$where;

		$res=array();
		$query=$this->db->query("select return_id,product,model,quantity,date_added,orderid,username,telephone,email from `view_return` where store_id={$store_id} ".$strSql." order by return_id desc limit {$intStart},{$intCount}");
		if($query->num_rows>0){
	   		return $query->rows;
		}
		return $res;
	}

	/**
	*  获取退换货总条数
	*  data : 搜索条件
	*/
	public function getTotalReturn($data){
		$where=isset($data['where'])?$data['where']:"";
		$store_id=$this->cookie->OCAuthCode($this->request->cookie['storeid'],'DECODE');
		if(empty($store_id)){
			$this->showMessage("您还没有开店，或登录已超时，请重新登录！");
		}
		
		$strSql="";
		if($where!="") $strSql.=$where;
		
		$strSql="select count(return_id) as total from `view_return` where store_id={$store_id}".$strSql;
		$query=$this->db->query($strSql);
		return $query->row["total"];
	}
	
	/**
	*  获取退换货用户信息
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
	*  获取退换货详细信息
	*  intCouponId   :退换货ID号
	*/
	public function getReturnInfo($intReturnId){
		$store_id=$this->cookie->OCAuthCode($this->request->cookie['storeid'],'DECODE');
		if(empty($store_id)){
			$this->showMessage("您还没有开店，或登录已超时，请重新登录！");
		}
		$res=array();
		$query=$this->db->query("select * from view_return where store_id={$store_id} and return_id={$intReturnId}");
		if($query->num_rows>0){
			$res=$query->row;
		}
		return $res;
	}
	
	/**
	*  设置退换货状态信息
	*  intId   :退换货ID号
	*  intState    :状态ID
	*/
	public function setReturnState($intId,$intState){
		$store_id=$this->cookie->OCAuthCode($this->request->cookie['storeid'],'DECODE');
		if(empty($store_id)){
			$this->showMessage("您还没有开店，或登录已超时，请重新登录！");
		}
		$query=$this->db->query("update " . DB_PREFIX . "`return` set return_status_id={$intState} where order_id in(select order_id from `order` where store_id={$store_id}) And return_id=". $intId);
		if($query===true){
			return "ok";
		}
		return "no";
	}
}
?>