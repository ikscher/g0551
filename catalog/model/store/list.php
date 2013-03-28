<?php
    /**
	 *店铺列表页
	 */
Class ModelStoreList extends Model {
    /**所有店铺列表**/
    public function getStoreList($data=array()){
	    $sql="select logo,introduce,store_id,owner,name,shortname,address from ".DB_PREFIX."store ";
		
		$sort='';
		if(!empty($data['sort'])){
			$sort=" order by {$data['sort']}";
		}
		
		$sql.=" where status=1";
		
		if(!empty($data['search'])){
		    $sql.=" and (name like '%{$data['search']}%' or owner like '%{$data['search']}%')";
		}

		$sql.=$sort;
		
		if(!empty($data['order'])){
		    $sql.=" {$data['order']}";
		}
        
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
					$data['start'] = 0;
			}				
	
			if ($data['limit'] < 1) {
					$data['limit'] = 10;
			}	
			
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
        //echo $sql;
		$query = $this->db->query($sql);

		return $query->rows;
	
	}
	
	/**店铺总数**/
	public function getStoreTotal($data=array()){
	    $sql="select count(store_id) as total from ".DB_PREFIX."store where status=1";
		
		if(!empty($data['search'])){
		    $sql.=" and (name like '%{$data['search']}%' or owner like '%{$data['search']}%')";
		}
		
		$query = $this->db->query($sql);

		return $query->row;
	
	}
	
	/**店铺产品的宝贝数量**/
	public function getStoreProductsTotal($storeid){
	    $sql="select count(product_id) as total from ".DB_PREFIX."product where store_id={$storeid} and status=1";
		$query=$this->db->query($sql);
	    
		return $query->row;
	}
	
	/**成交笔数**/
	public function getStoreOrderPaidTotals($storeid){
	    $sql="select count(order_id) as total from `".DB_PREFIX."order` where order_status_id=5 and store_id={$storeid}";
		$query=$this->db->query($sql);
	    
		return $query->row;
	
	}


}
?>