<?php

/**
*  会员收货地址
*/
class ModelAccountAddress extends Model {
    
	/**
	* 新增收货地址
	*/
	public function addAddress($data) {
	    //$str=array();
		$username   =$this->db->escape($data['username']);
		$mobile     =$this->db->escape($data['mobile']);
		$telphone  =$this->db->escape($data['username']);
		$address    =$this->db->escape($data['address']);
		if(!empty($data['postcode'])){
			$postcode   =$this->db->escape($data['postcode']);
		}else{
		    $postcode  ='';
		}
		
		//$company    =$this->db->escape($data['company']);
		$customer_id=$this->db->escape($this->customer->getId());
	    
		//note update other address status
		$this->db->query("update ".DB_PREFIX."address set status=0");
		$query=$this->db->query("INSERT INTO " . DB_PREFIX . "address SET customer_id = '{$customer_id}', username = '{$username}',telphone = '{$telphone}', mobile = '{$mobile}',  address = '{$address}', postcode = '{$postcode}' ,status=1");
		
		
		if($query===true){
		   $address_id=$this->db->getLastId();
		}
		
		return $address_id;
		
	}
	
	/**
	* 编辑地址
	*/
	public function editAddress($data) {
	    $address_id =$this->db->escape($data['address_id']);
		$username   =$this->db->escape($data['username']);
		$mobile     =$this->db->escape($data['mobile']);
		$telphone  =$this->db->escape($data['telphone']);
		$address    =$this->db->escape($data['address']);
		$postcode   =$this->db->escape($data['postcode']);
		$company    =$this->db->escape($data['company']);
		
		
		$query=$this->db->query("UPDATE " . DB_PREFIX . "address SET username = '{$username}',address='{$address}', company = '{$company}', postcode = '{$postcode}', mobile = '{$mobile}', telphone = '{$telphone}'  WHERE address_id  = '{$address_id}'");
	    
		if($query===true){
		   return 1;
		}else{
		   return 0;
		}
	}
	
	public function deleteAddress($address_id) {
	    
		$query=$this->db->query("DELETE FROM " . DB_PREFIX . "address WHERE address_id = '" . (int)$address_id . "' AND customer_id = '" . (int)$this->customer->getId() . "'");
		if($query===true) return 1; else return 0;
	}	
	

	
	/** 
	* 取用户地址
	*/
	public function getAddresses($type=true) {
		$address_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "address WHERE customer_id = '" . (int)$this->customer->getId() . "' order by status desc");
		
		$address_data=$query->rows;
		
		if($type==false){
		  $address_id=array();
		  foreach($address_data as $key=>$value){
		    $address_id[]=$value['address_id'];
		  }
		  return $address_id;
		}
		
		return $address_data;
	}	
	
	/**
	*  取对应的收货地址
	*  address_id   :地址ID
	*/
	public function getAddress($address_id){
	   $res=array();
	   
	   $query=$this->db->query("select * from " . DB_PREFIX . "address where address_id='{$address_id}'");
       $res=$query->row;
	   
	   
	   return $res;
	
	}
	
	
	/**
	*  根据customer_id和status=1 取对应的收货地址
	*  status        :1
	*  customer_id   :会员ID
	*/
	public function getAddressByCustomerid($customer_id){
	   $res=array();
	   
	   $query=$this->db->query("select * from " . DB_PREFIX . "address where customer_id='{$customer_id}' and status=1");
       $res=$query->row;

	   return $res;
	
	}
	
	
	public function getTotalAddresses() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "address WHERE customer_id = '" . (int)$this->customer->getId() . "'");
	
		return $query->row['total'];
	}
	
	/**
	* 更新地址
	*/
	public function setDefaultAddress($address_id){
	   $customer_id=$this->customer->getId();
	   $query1=$this->db->query("update ". DB_PREFIX . "address  set status=0 where customer_id='{$customer_id}'");	   
	   $query2=$this->db->query("update ". DB_PREFIX . "address  set status=1 where address_id='{$address_id}'");
	   
	   if($query1===true && $query2===true){
	       return 1;
		}else{
		   return 0;
		}
	
	}
}
?>