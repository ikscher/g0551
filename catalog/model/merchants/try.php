<?php

class ModelMerchantsTry extends Model {

	public function getTryList($data){
		
		$product_id=isset($data['product_id'])?$this->db->escape($data['product_id']):"";
		$customer_id=isset($data['customer_id'])?$this->db->escape($data['customer_id']):"";
		$is_try = $data['is_try'];
		$trytime=isset($data['trytime'])?strtotime($data['trytime']):"";
		
		$store_id=$this->cookie->OCAuthCode($this->request->cookie['storeid'],'DECODE');
		if(empty($store_id)){
			$this->showMessage("您还没有开店，或登录已超时，请重新登录！");
		}
		
		$where =" where store_id={$store_id}";
		
		if(!empty($product_id)) $where.=" And product_id='{$product_id}'";
		if(!empty($customer_id)) $where.=" And customer_id='{$customer_id}'";
		if($is_try===1 || $is_try===0) $where.=" And is_try='{$is_try}'";
		if(!empty($trytime)) $where.=" And trytime<={$trytime}";
		
		$res=array();
		
		$sql="select * from ".DB_PREFIX."`try`   ".$where;
	
		if ($data['start'] < 0) {
			$data['start'] = 0;
		}
		
		if ($data['limit'] < 1) {
			$data['limit'] = 1;
		}
		
		$sql.= "  order by try_id desc  LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		
		$query=$this->db->query($sql);
		
	   	$res=$query->rows;
		
		return $res;
	}

	
	public function getTotalTry($data){
		
		$product_id=isset($data['product_id'])?$this->db->escape($data['product_id']):"";
		$customer_id=isset($data['customer_id'])?$this->db->escape($data['customer_id']):"";
		$is_try=$data['is_try'];
		$trytime=isset($data['trytime'])?$this->db->escape($data['trytime']):"";

		$store_id=$this->cookie->OCAuthCode($this->request->cookie['storeid'],'DECODE');
		if(empty($store_id)){
			$this->showMessage("您还没有开店，或登录已超时，请重新登录！");
		}
		
		$where =" where store_id={$store_id}";
	
		if($product_id!="") $where.=" And product_id='{$product_id}'";
		if(!empty($customer_id)) $where.=" And customer_id='{$customer_id}'";
		if($is_try===1 || $is_try===0) $where.=" And is_try='{$is_try}'";
		if(!empty($trytime)) $where.=" And trytime<={$trytime}";
		
		$sql="select count(try_id) as total from ".DB_PREFIX."`try`  ".$where;
		$query=$this->db->query($sql);
		return $query->row["total"];
	}
	
	
		
	public function confirm($try_id,$is_try){
        $sql="update `".DB_PREFIX."try` set is_try={$is_try} where try_id={$try_id}";
		return $this->db->query($sql);

    }	
	
	

}
?>