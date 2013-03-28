<?php 
class ModelCatalogAttributeGroup extends Model {
    /*属性组*/
	public function addAttributeGroup($data) {
	    $this->load->model('catalog/category');
	    $cid0=isset($data['attribute_cid0'])?$data['attribute_cid0']:0;
		$type=isset($data['group_type'])?$data['group_type']:1;
		$sort_order=isset($data['sort_order'])?$data['sort_order']:0;
		$cid1=isset($data['attribute_cid1'])?(int)$data['attribute_cid1']:0;
		$cid2=isset($data['attribute_cid2'])?(int)$data['attribute_cid2']:0;
		$cid3=isset($data['attribute_cid3'])?(int)$data['attribute_cid3']:0;
		$option_id=isset($data['option_id'])?(int)$data['option_id']:0;
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "attribute_group SET `type`='{$type}',`option_id`='{$option_id}',sort_order = '{$sort_order}',cid0='{$cid0}',cid1='{$cid1}',cid2='{$cid2}',cid3='{$cid3}'");
		
		$attribute_group_id = $this->db->getLastId();
		
		
	    $this->db->query("INSERT INTO " . DB_PREFIX . "attribute_group_description SET attribute_group_id = '" . (int)$attribute_group_id . "', name = '" . $this->db->escape($data['attribute_group_name'] ) . "' ,`description`='".$this->db->escape($data['attribute_group_description'])."',`text0`='".$this->db->escape($data['attribute_group_text0'])."',`text1`='".$this->db->escape($data['attribute_group_text1'])."'");
		
	}

	public function editAttributeGroup($attribute_group_id, $data) {
	    $this->load->model('catalog/category');
	
		$type=isset($data['group_type'])?$data['group_type']:1;
		$sort_order=isset($data['sort_order'])?$data['sort_order']:0;
		
		$isShow=isset($data['isShow'])?(int)$data['isShow']:0;
		$option_id=isset($data['option_id'])?(int)$data['option_id']:0;
		$original_option_id=isset($data['original_option_id'])?$data['original_option_id']:0;
	
		$this->db->query("UPDATE " . DB_PREFIX . "attribute_group SET `type`='{$type}', sort_order = '{$sort_order}',isShow='{$isShow}',`option_id`='{$option_id}'  WHERE attribute_group_id = '" . (int)$attribute_group_id . "'");
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "attribute_group_description WHERE attribute_group_id = '" . (int)$attribute_group_id . "'");

	
		$this->db->query("INSERT INTO " . DB_PREFIX . "attribute_group_description SET attribute_group_id = '" . (int)$attribute_group_id . "', name = '" . $this->db->escape($data['attribute_group_name']) . "'");
		
		
		
		//设置选项的展现形式，如checkbox,radio,select等 涉及到表option_value,option_value_description,product_option,product_option_value
		$sql="update `".DB_PREFIX."option_value_description` set `option_id`='{$option_id}' where attribute_group_id='{$attribute_group_id}'";
		$this->db->query($sql);
		
		$sql="select option_value_id,option_id,attribute_id,name from ".DB_PREFIX."option_value_description where attribute_group_id='{$attribute_group_id}'";
		$query=$this->db->query($sql);
		$result=$query->rows;
		$comma='';
		$option_value_id='';
		if(!empty($result)){
		    foreach($result as $v){
			    if(!empty($v['option_value_id'])){
				    $option_value_id .= $comma;
					$option_value_id .= $v['option_value_id'];
					$comma=",";
				}
			}
		}

		if(!empty($option_value_id)){
			$sql="update ".DB_PREFIX."option_value  set `option_id`='{$option_id}' where option_value_id in({$option_value_id})";
			$query=$this->db->query($sql);
		}
		
		//设置选项的展现形式，如checkbox,radio,select等 产品对应的选项也修改
		//if(!empty($original_option_id)){
		    //$sql="update `".DB_PREFIX."product_option` set `option_id`='{$option_id}' where `option_id`='{$original_option_id}'";
			$sql="update `".DB_PREFIX."product_option` set `option_id`='{$option_id}' where `attribute_group_id`='{$attribute_group_id}'";
			
		    $this->db->query($sql);
			
			//$sql="update `".DB_PREFIX."product_option_value` set `option_id`='{$option_id}' where `option_id`='{$original_option_id}'";
			$sql="update ".DB_PREFIX."product_option_value,".DB_PREFIX."product_option SET  product_option_value.option_id='{$option_id}' where product_option_value.product_option_id=product_option.product_option_id and product_option.attribute_group_id='{$attribute_group_id}'";
			$this->db->query($sql);
		//}
	}
	
	public function deleteAttributeGroup($attribute_group_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "attribute_group WHERE attribute_group_id = '" . (int)$attribute_group_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "attribute_group_description WHERE attribute_group_id = '" . (int)$attribute_group_id . "'");
	}
		
	public function getAttributeGroup($attribute_group_id) {
		$query = $this->db->query("SELECT ag.`type`,ag.sort_order,cid0,cid1,cid2,cid3,isShow,ag.option_id FROM " . DB_PREFIX . "attribute_group ag left join `".DB_PREFIX."option` op on  ag.option_id=op.option_id WHERE attribute_group_id = '" . (int)$attribute_group_id . "'");
		
		return $query->row;
	}
		
	public function getAttributeGroups($data = array()) {
		$sql = "SELECT ag.attribute_group_id,ag.type,ag.sort_order,agd.name,agd.description,agd.text0,agd.text1,ag.isShow,ag.cid0 FROM " . DB_PREFIX . "attribute_group ag inner JOIN " . DB_PREFIX . "attribute_group_description agd ON (ag.attribute_group_id = agd.attribute_group_id)";
	    
		$sql .=" where 1 ";
		if(!empty($data['filter_name'])){
		    $sql.= "and agd.name ='{$data['filter_name']}'";
		}
		
		if(!empty($data['topid'])){
		    $sql.= "and ag.cid0 ={$data['topid']}";
		}
		
		if(!empty($data['filter_description'])){
		    $filter_description=$data['filter_description'];
		    $sql.= "and agd.description ='{$filter_description}'";
		}
		
		if(!empty($data['filter_text0'])){
		    $filter_text0=$data['filter_text0'];
		    $sql.= "and agd.text0 ='{$filter_text0}'";
		}
		
		if(!empty($data['filter_text1'])){
		    $filter_text1=$data['filter_text1'];
		    $sql.= "and agd.text1 ='{$filter_text1}'";
		}
		
	
		$sort_data = array(
			'agd.name',
			'ag.sort_order',
			'ag.attribute_group_id'
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
		
		foreach($query->rows as $v){
		    $sql="select category_id FROM ".DB_PREFIX."category where find_in_set({$v['attribute_group_id']},attribute_group)";
			$query_=$this->db->query($sql);
			
			
		}
		return $query->rows;
	}
	
	/**取对应的属性组*/
	public function getAttributeGroupDescriptions($attribute_group_id) {
		$attribute_group_data = array();
		
		$sql="SELECT  ag.type,agd.name,agd.`description`,agd.`text0`,agd.`text1`,ag.cid1,ag.cid2,ag.cid3 FROM " . DB_PREFIX. "attribute_group ag inner join ".DB_PREFIX."attribute_group_description agd on ag.attribute_group_id=agd.attribute_group_id and  ag.attribute_group_id = '" . (int)$attribute_group_id . "'";
		$query = $this->db->query($sql);
		$attribute_group_data=$query->row;
		return $attribute_group_data;
        
	}
	
	/**取所有的属性组*/
	public function getAttributeGroupIn($groups){
		$sql="SELECT  ag.type,agd.name,ag.attribute_group_id FROM " . DB_PREFIX. "attribute_group ag inner join ".DB_PREFIX."attribute_group_description agd on ag.attribute_group_id=agd.attribute_group_id and ag.attribute_group_id in({$groups})";
		$query = $this->db->query($sql);
		return $query->rows;
	}
	
	
	public function getTotalAttributeGroups($data=array()) {
		$sql = "SELECT count(ag.attribute_group_id) as total FROM " . DB_PREFIX . "attribute_group ag inner JOIN " . DB_PREFIX . "attribute_group_description agd ON (ag.attribute_group_id = agd.attribute_group_id)";
	    
		if(!empty($data['filter_name'])){
		    $sql.= "and agd.name ='{$data['filter_name']}'";
		}
		
		if(!empty($data['filter_type'])){
		    $sql.= "and ag.type ='{$data['filter_type']}'";
		}
		
		if(!empty($data['filter_description'])){
		    $sql.= "and agd.description ='{$data['filter_description']}'";
		}
		
		if(!empty($data['filter_text0'])){
		    $sql.= "and agd.text0 ='{$data['filter_text0']}'";
		}
		
		if(!empty($data['filter_text1'])){
		    $sql.= "and agd.text1 ='{$data['filter_text1']}'";
		}
		
      	$query = $this->db->query($sql);
		
		return $query->row['total'];
	}	
}
?>