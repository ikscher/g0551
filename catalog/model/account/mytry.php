<?php
class ModelAccountMyTry extends Model {	
	
	 /*
	*******所有我的试用******
	*/
	public function getContents($data=array()){
	    $customer_id=$this->customer->getId();
		if (empty($customer_id)) return array();
	    $where=" where customer_id='{$customer_id}'";
	    if(!empty($data['try_id'])){
		    $where.=" and try_id={$data['try_id']}";
		}
		
		$starttime=isset($data['starttime'])?strtotime($data['starttime']):0;
		$endtime=isset($data['endtime'])?strtotime($data['endtime']):0;
		if(!empty($starttime) && !empty($endtime)){
		    $where.=" and trytime>={$starttime}  and trytime<={$endtime}";
		}elseif(!empty($starttime) && empty($endtime)){
		    $where.=" and trytime>{$starttime}";
		}elseif(empty($starttime) && !empty($endtime)){
		    $where.=" and trytime<{$endtime}";
		}
		
		if(!empty($data['product_id'])){
		    $where.=" and product_id={$data['product_id']}";
		}
		
		if(!empty($data['store_id'])){
		    $where.=" and store_id={$data['store_id']}";
		}
		
		
		if(!empty($data['is_try'])){
		    $where.=" and is_try={$data['is_try']}";
		}
		
		
	    $sql="select * from `". DB_PREFIX ."try` ";
		
		$sql .=$where;

		$query = $this->db->query($sql);
		
		return $query->rows;
	}
	
	/**
	*单一内容
	*/
	public function getContent($id){
	    $result=array();
        $sql="select * from `". DB_PREFIX ."try` where try_id = '{$id}' ";
		$query = $this->db->query($sql);
	    $result=$query->row;
		return $result;
	}
	
	
	/**
	*删除内容
	*/
	public function deleteContent($id){
	    $sql="delete from ".DB_PREFIX."try where try_id='{$id}'";
		return $this->db->query($sql);
	
	}
	
	
	
}
?>