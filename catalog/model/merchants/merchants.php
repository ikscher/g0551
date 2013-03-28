<?php
/**
*  商家店铺信息
*/
class ModelMerchantsMerchants extends Model {
	/**
	*  获取店铺信息
	*  address_id   :地址ID
	*/
	public function getInfo(){
	    $user_id   =$this->db->escape($this->customer->getId());
	    $res=array();
	    $query=$this->db->query("select * from " . DB_PREFIX . "store where store_id in(select store_id from " . DB_PREFIX . "customer where customer_id={$user_id})");
        if($query->num_rows>0){
	   	    $res=$query->row;
	    }else{
	        $res['map_x']="117.28428";
	        $res['map_y']="31.861422";
			$res['province']='10106000';
		    $res['city']='10106001';
		}
	   
	    return $res;
	}
	
	
	/**
	* 新增收货地址
	*/
	public function saveInfo($data) {
	    //$str=array();
		$name   =$this->db->escape($data['name']);
		$province    =$this->db->escape($data['province']);
		$city    =$this->db->escape($data['city']);
		$address    =$this->db->escape($data['address']);
		/* $zone  =$this->db->escape($data['zone']); */
		$tel  =$this->db->escape($data['tel']);
		$mobile  =$this->db->escape($data['mobile']);
		$fax    =$this->db->escape($data['fax']);
		$owner   =$this->db->escape($data['owner']);
		$introduce   =$this->db->escape($data['introduce']);
	    $map_x   =$this->db->escape($data['map_x']);
	    $map_y   =$this->db->escape($data['map_y']);
		$logo     =$this->db->escape($data['logo_url']);
		$createtime=strtotime("now");
		$user_id   =$this->db->escape($this->customer->getId());
		
		
		$result=$this->db->query("select customer_id,store_id from " . DB_PREFIX . "customer where customer_id={$user_id} and store_id>0");
		if($result->num_rows==0){
			$query=$this->db->query("INSERT INTO " . DB_PREFIX . "store SET name = '{$name}',province = {$province},city = {$city}, address = '{$address}',tel = '{$tel}',mobile = '{$mobile}', fax = '{$fax}', owner = '{$owner}',  introduce = '{$introduce}', map_x = '{$map_x}', map_y = '{$map_y}', logo = '{$logo}', createtime = '{$createtime}' ");
			//将店铺ID写入会员信息表
			$store_id=$this->db->getLastId();
			$store_id=$this->cookie->OCAuthCode($this->request->cookie['storeid'],'DECODE');
			if(empty($store_id)){
				$this->showMessage("您还没有开店，或登录已超时，请重新登录！");
			}
			$this->db->query("UPDATE " . DB_PREFIX . "customer SET store_id={$store_id} Where customer_id={$user_id}");
		}else{
			$store_id=$result->row["store_id"];
			$query=$this->db->query("UPDATE " . DB_PREFIX . "store SET name = '{$name}',province = {$province},city = {$city}, address = '{$address}',tel = '{$tel}',mobile = '{$mobile}', fax = '{$fax}', owner = '{$owner}',  introduce = '{$introduce}', map_x = '{$map_x}', map_y = '{$map_y}', logo = '{$logo}' Where store_id={$store_id}");
		}
		
		if($query===true){
			return "ok";
		}
		return "no";
	}
	
}
?>