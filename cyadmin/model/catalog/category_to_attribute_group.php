<?php 
class ModelCatalogCategoryToAttributeGroup extends Model {
    /*属性组*/
	public function addAttributeGroup($data) {
	    $this->load->model('catalog/category');
	    $cid0=isset($data['attribute_cid0'])?$data['attribute_cid0']:0;
		$cid1=isset($data['attribute_cid1'])?(int)$data['attribute_cid1']:0;
		$cid2=isset($data['attribute_cid2'])?(int)$data['attribute_cid2']:0;
		$cid3=isset($data['attribute_cid3'])?(int)$data['attribute_cid3']:0;
		$attribute_group_id=isset($data['attribute_group_id'])?$data['attribute_group_id']:0;
		$category_id=isset($data['category_id'])?$data['category_id']:0;
	    
	   
		
		return $this->db->query("REPLACE INTO " . DB_PREFIX . "category_to_attribute_group SET attribute_group_id='{$attribute_group_id}',category_id='{$category_id}',is_pa='1'");
		
	
	}

	/* public function editAttributeGroup($attribute_group_id, $data) {
	    $this->load->model('catalog/category');
	    $cid0=isset($data['attribute_cid0'])?$data['attribute_cid0']:0;

		$cid1=isset($data['attribute_cid1'])?(int)$data['attribute_cid1']:0;
		$cid2=isset($data['attribute_cid2'])?(int)$data['attribute_cid2']:0;
		$cid3=isset($data['attribute_cid3'])?(int)$data['attribute_cid3']:0;
		
		$category_id='';
		if(!empty($cid0)){
		    $category_id=$cid0;
		}
		if(!empty($cid1)){
		    $category_id=$cid1;
		}
		if(!empty($cid2)){
		    $category_id=$cid2;
		}
		if(!empty($cid3)){
		    $category_id=$cid3;
		}
		
		
	
	} */
	
	
	public function deleteAttributeGroup($id) {
		return $this->db->query("DELETE FROM " . DB_PREFIX . "category_to_attribute_group WHERE id = '" . (int)$id . "'");
	}
	
	public function getAttributeGroupById($id){
	    $sql="select c2ag.attribute_group_id,c2ag.category_id,agd.name from ".DB_PREFIX."category_to_attribute_group  c2ag left join ".DB_PREFIX."attribute_group_description agd on c2ag.attribute_group_id=agd.attribute_group_id left join ".DB_PREFIX."category c on c2ag.category_id=c.category_id where c2ag.id='{$id}'";
		$query = $this->db->query($sql);
		
		return $query->row;
	}

		
	public function getAttributeGroup($attribute_group_id,$category_id) {
	    $sql="select c2ag.attribute_group_id,c2ag.category_id,agd.name from ".DB_PREFIX."category_to_attribute_group  c2ag left join ".DB_PREFIX."attribute_group_description agd on c2ag.attribute_group_id=agd.attribute_group_id left join ".DB_PREFIX."category c on c2ag.category_id=c.category_id where c2ag.category_id='{$category_id}' and c2ag.attribute_group_id='{$attribute_group_id}'";
		$query = $this->db->query($sql);
		
		return $query->row;
	}
	
	public function getAttributeGroups($data = array()) {
		//$sql = "SELECT ag.attribute_group_id,ag.type,ag.sort_order,agd.name,agd.description,agd.text0,agd.text1,ag.isShow,ag.cid0 FROM " . DB_PREFIX . "attribute_group ag inner JOIN " . DB_PREFIX . "attribute_group_description agd ON (ag.attribute_group_id = agd.attribute_group_id)";
	    $sql="select c2ag.id,c2ag.attribute_group_id,c2ag.category_id,agd.name,c2ag.is_pa,ag.type from ".DB_PREFIX."category_to_attribute_group  c2ag left join ".DB_PREFIX."attribute_group_description agd on c2ag.attribute_group_id=agd.attribute_group_id left join ".DB_PREFIX."category c on c2ag.category_id=c.category_id left join ".DB_PREFIX."attribute_group ag on c2ag.attribute_group_id=ag.attribute_group_id";
	
		$sql .=" where 1 ";
		if(!empty($data['filter_name'])){
		    $sql.= " and agd.name ='{$data['filter_name']}'";
		}
		
		if(!empty($data['category_id'])){
		    $sql.= " and c2ag.category_id ='{$data['category_id']}'";
		}
		
	
		$sort_data = array(
			'agd.name',
			'c2ag.attribute_group_id'
		);	
		
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY agd.name";	
		}	
			
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}
		
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
		
		//原先不考虑添加 category_to_attribute_group表 ，所使用到的语句
		/* foreach($query->rows as $v){
		    $sql="select category_id FROM ".DB_PREFIX."category where find_in_set({$v['attribute_group_id']},attribute_group)";
			$query_=$this->db->query($sql);
			
			
		} */
		return $query->rows;
	}
	
	
	
	public function getTotalAttributeGroups($data=array()) {
		$sql="select count(c2ag.attribute_group_id) as total from ".DB_PREFIX."category_to_attribute_group  c2ag left join ".DB_PREFIX."attribute_group_description agd on c2ag.attribute_group_id=agd.attribute_group_id left join ".DB_PREFIX."category c on c2ag.category_id=c.category_id";
		
		$where =" where 1 ";
		
		$sql .=$where;
		if(!empty($data['filter_name'])){
		    $sql.= " and agd.name ='{$data['filter_name']}'";
		}
		
		if(!empty($data['category_id'])){
		    $sql.= " and c2ag.category_id ='{$data['category_id']}'";
		}

      	$query = $this->db->query($sql);

		return $query->row['total'];
	}	
	
	/**设置价格属性是否有效**/
	public function setPriceAttributeValid($id,$is_pa){
		$sql="update ".DB_PREFIX."category_to_attribute_group set is_pa='{$is_pa}' where id='{$id}'";
		return $this->db->query($sql);
	}
	
}
?>