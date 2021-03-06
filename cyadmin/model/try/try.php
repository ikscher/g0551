<?php
class ModelTryTry extends Model {

	//删除试用的产品
	public function deleteTryProduct($try_id){
	    $sql="delete from ".DB_PREFIX."try where try_id={$try_id}";
		return $this->db->query($sql);
		 
	}
	
	public function getCustomer($customer_id,$store_id=0) {
	    if(!empty($store_id)){
			$sql="SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$customer_id . "' and store_id='{$store_id}'";
		}else{
		    $sql="SELECT a.*,c.* FROM `" . DB_PREFIX . "customer` c left join `".DB_PREFIX."address` a on c.customer_id=a.customer_id WHERE  c.customer_id = '" . (int)$customer_id . "'";
		}

		$query = $this->db->query($sql);

		return $query->row;
	}
	
	public function getTryList($data){
		
		$product_id=isset($data['product_id'])?$this->db->escape($data['product_id']):"";
		$customer_id=isset($data['customer_id'])?$this->db->escape($data['customer_id']):"";
		$is_try = $data['is_try'];
		$trytime=isset($data['trytime'])?strtotime($data['trytime']):"";
		
		
		
		$where =" where 1";
		
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

		
		
		$where =" where 1";
	
		if($product_id!="") $where.=" And product_id='{$product_id}'";
		if(!empty($customer_id)) $where.=" And customer_id='{$customer_id}'";
		if($is_try===1 || $is_try===0) $where.=" And is_try='{$is_try}'";
		if(!empty($trytime)) $where.=" And trytime<={$trytime}";
		
		$sql="select count(try_id) as total from ".DB_PREFIX."`try`  ".$where;
		$query=$this->db->query($sql);
		return $query->row["total"];
	}

	
}
?>