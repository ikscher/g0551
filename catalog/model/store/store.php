<?php
    /**
	 *店铺相关信息*
	 */
Class ModelStoreStore extends Model {
	 
	 /**店铺产品列表**/
	 public function getStoreProduct($data=array()){

		//$sql = "select pd.name as name,p.price,p.image,p.product_id,p2s.store_id,p.hots from " . DB_PREFIX . " product p LEFT JOIN " . DB_PREFIX . " product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . " product_to_store p2s ON (p.product_id = p2s.product_id) ";
        $sql = "select pd.name as name,p.price,p.image,p.product_id,p.store_id,p.hots from " . DB_PREFIX . " product p LEFT JOIN " . DB_PREFIX . " product_description pd ON (p.product_id = pd.product_id) ";
        
		
		if(!empty($data['category_id'])){
		    $sql.=" left join product_to_category p2c on p.product_id=p2c.product_id ";
		}
		
		$sql.=" WHERE p.store_id = '" . (int)$data['store_id']  . "' AND p.status = '1' ";
		
		if(!empty($data['keyword1'])) {
		    $sql.=" AND pd.name like '%".$data['keyword1']."%'";
		}elseif (!empty($data['keyword2'])){
		    $sql.=" AND pd.name like '%".$data['keyword2']."%'";
		}
		if(!empty($data['priceLower'])) $sql.=" AND p.price >{$data['priceLower']}";
		if(!empty($data['priceUp'])) $sql.=" AND p.price <{$data['priceUp']}";
		if(!empty($data['category_id'])) $sql.=" AND p2c.category_id={$data['category_id']}";

		$sql.=" order by p.date_added desc";
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
					$data['start'] = 0;
			}				
	
			if ($data['limit'] < 1) {
					$data['limit'] = 9;
			}	
			
				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}
  
		$query = $this->db->query($sql);

		return $query->rows;

	 }

    /**店铺产品列表总数**/
	 public function getStoreProductTotal($data=array()){
		$sql = "SELECT COUNT(DISTINCT p.product_id) AS total FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)  ";
       
        if(!empty($data['category_id'])){
		    $sql.=" left join product_to_category p2c on p.product_id=p2c.product_id ";
		}
        
		$sql.=" where p.store_id = '" . (int)$data['store_id']   . "' AND p.status = '1' ";
		
	    // if(!empty($data['keyword'])) $sql.=" AND pd.name like '".$data['keyword']."%'";
		if(!empty($data['keyword1'])) {
		    $sql.=" AND pd.name like '%".$data['keyword1']."%'";
		}elseif (!empty($data['keyword2'])){
		    $sql.=" AND pd.name like '%".$data['keyword2']."%'";
		}
		
		if(!empty($data['priceLower'])) $sql.=" AND p.price >{$data['priceLower']}";
		if(!empty($data['priceUp'])) $sql.=" AND p.price <{$data['priceUp']}";
		if(!empty($data['category_id'])) $sql.=" AND p2c.category_id={$data['category_id']}";
		
		$query = $this->db->query($sql);

		return $query->row;
	 
	 
	 }
	
    
	/**店铺产品分类**/
	 public function getStoreCategories($store_id){
	
		$sql = "select c.category_id as cid,c.parent_id as pid,cd.name as cname,c.top from " . DB_PREFIX . " category c ";

		$sql .= "left join " . DB_PREFIX . " category_to_store c2s on (c.category_id = c2s.category_id) ";

		$sql .= "left join " . DB_PREFIX . " category_description cd on (c.category_id = cd.category_id) ";

		$sql .= "where c2s.store_id = '" .(int)$store_id. "' and c.status = '1'";
		
		$query = $this->db->query($sql);
		
		return $query->rows;
	
	}
    
	
	public function getProductByStoreCategory($data){
	
		$sql ="select pd.name as name,p.price,p.image,p.product_id,p2s.store_id from " . DB_PREFIX . " product p LEFT JOIN " . DB_PREFIX . " product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . " product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . " product_to_category p2c ON (p.product_id = p2c.product_id) WHERE p2s.store_id = '" . (int)$data['store_id']  . "' AND p.status = '1' AND p2c.category_id = '" . (int)$data['category_id'] . "' ";

			if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
					$data['start'] = 0;
			}				
	
			if ($data['limit'] < 1) {
					$data['limit'] = 20;
			}	
			
				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}
	
		$query = $this->db->query($sql);
		
		return $query->rows;
	
	}
    
	public function getStore($store_id){
	    $data=array();
		if(empty($store_id)) return $data;
	    $sql="select * from ".DB_PREFIX."store where store_id='{$store_id}'";
		$query=$this->db->query($sql);
		$data=$query->row;
		
		return $data;
	
	}
	
	/**
	*获取店铺的货运方式
	*/
	public function getStoreShippingMethod($store_id){
	    $result =array();
		$result_=array();
	    $sql="select shipping_fee from ".DB_PREFIX."shipping where store_id='{$store_id}' and enabled=1 order by shipping_id asc limit 1";
	
		$query=$this->db->query($sql);
		
		$result=$query->row;
		
		if (empty($result)) return;
		$s__=unserialize($result['shipping_fee']);
		
		unset($result['shipping_fee']);
		
		$result_['express']['start']=isset($s__['express']['express_start'])?$s__['express']['express_start']:'';
		$result_['ems']['start']=isset($s__['ems']['ems_start'])?$s__['ems']['ems_start']:'';
		$result_['post']['start']=isset($s__['post']['post_start'])?$s__['post']['post_start']:'';
		
			
		$result_['express']['postage']=isset($s__['express']['express_postage'])?$s__['express']['express_postage']:'';
		$result_['ems']['postage']=isset($s__['ems']['ems_postage'])?$s__['ems']['ems_postage']:'';
		$result_['post']['postage']=isset($s__['post']['post_postage'])?$s__['post']['post_postage']:'';
		
		
		$result_['express']['plus']=isset($s__['express']['express_plus'])?$s__['express']['express_plus']:'';
		$result_['ems']['plus']=isset($s__['ems']['ems_plus'])?$s__['ems']['ems_plus']:'';
		$result_['post']['plus']=isset($s__['post']['post_plus'])?$s__['post']['post_plus']:'';
		
		
		$result_['express']['postageplus']=isset($s__['express']['express_postageplus'])?$s__['express']['express_postageplus']:'';
		$result_['ems']['postageplus']=isset($s__['ems']['ems_postageplus'])?$s__['ems']['ems_postageplus']:'';
		$result_['post']['postageplus']=isset($s__['post']['post_postageplus'])?$s__['post']['post_postageplus']:'';
	    
		$result_['express']['name']='快递';
		$result_['ems']['name']='EMS';
		$result_['post']['name']='平邮';
		
		
		return $result_;
	
	}

	public function getProductTotalByStoreCategory($data=array()){
	 
		$sql = "SELECT COUNT(DISTINCT p.product_id) AS total FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . " product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . " product_to_category p2c ON (p.product_id = p2c.product_id) where p2s.store_id = '" . (int)$data['store_id']  . "' and p2c.category_id = '" .(int)$data['category_id']. "' ";

		$query = $this->db->query($sql);

		return $query->row;
	 
	 
	}
     
    /**销量排行**/
	public function getSaleTopByStore($store_id) {
	    $sql = "select pd.name as name,p.price,p.image,p.product_id,p2s.store_id,p.hots from " . DB_PREFIX . " product p LEFT JOIN " . DB_PREFIX . " product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . " product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p2s.store_id = '" . (int)$store_id . "' AND p.status = '1'  order by hots desc limit 5";
        
		$query = $this->db->query($sql);
		
		return $query->rows;
	}
    
    


}
?>