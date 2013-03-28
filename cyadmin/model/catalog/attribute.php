<?php 
class ModelCatalogAttribute extends Model {
    /*目录属性编辑*/
	public function addAttribute($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "attribute SET attribute_group_id = '" . (int)$data['attribute_group_id'] . "', sort_order = '" . (int)$data['sort_order'] . "'");
		
		$attribute_id = $this->db->getLastId();
		
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "attribute_description SET attribute_id = '" . (int)$attribute_id . "', name = '" . $this->db->escape($data['attribute_name']) . "'");
	}

	public function editAttribute($data) {
		$this->db->query("UPDATE " . DB_PREFIX . "attribute SET attribute_group_id = '" . (int)$data['attribute_group_id'] . "', sort_order = '" . (int)$data['sort_order'] . "' WHERE attribute_id = '" . (int)$data['attribute_id'] . "'");
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "attribute_description WHERE attribute_id = '" . (int)$data['attribute_id'] . "'");

		$name=$data['attribute_name'];
		$this->db->query("INSERT INTO " . DB_PREFIX . "attribute_description SET attribute_id = '" . (int)$data['attribute_id']  . "', name = '" . $this->db->escape($name) . "'");
		
	}
	
	public function deleteAttribute($attribute_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "attribute WHERE attribute_id = '" . (int)$attribute_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "attribute_description WHERE attribute_id = '" . (int)$attribute_id . "'");
	}
		
	public function getAttribute($attribute_id) {
		$query = $this->db->query("SELECT a.attribute_id,a.sort_order,a.attribute_group_id,agd.name FROM " . DB_PREFIX . "attribute a inner join ".DB_PREFIX."attribute_group_description agd  on a.attribute_group_id=agd.attribute_group_id and a.attribute_id = '" . (int)$attribute_id . "'");
		
		return $query->row;
	}
	
    public function filter($var){
	    if(empty($var)){
    		return false;
		}
		return true;
	}	
	
	
	public function getAttributes($data = array()) {
		$sql = "SELECT a.attribute_id,a.attribute_group_id,a.sort_order,ad.`name`,agd.name AS attribute_group,ag.type,agd.`description`,agd.`text0`,agd.`text1`,a.isShow  FROM " . DB_PREFIX . "attribute a inner JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) inner join ".DB_PREFIX."attribute_group_description agd on  a.attribute_group_id=agd.attribute_group_id inner join ".DB_PREFIX."attribute_group ag on  ag.attribute_group_id=a.attribute_group_id";
        
		$filterName=isset($data['filter_name'])?$data['filter_name']:'';
	    
		$where=" where 1";
		
		$sql .=$where;
		if(!empty($filterName))   $sql .= " AND agd.name LIKE '%" . $this->db->escape(utf8_strtolower($filterName)) . "%'";

		//取产品所在属性组
		if(isset($data['productId'])){
		    $categoryId=array();
			$group=array();
			$attribute_group='';
			
		    $this->load->model('catalog/product');
			$this->load->model('catalog/category');
			$categoryId=$this->model_catalog_product->getProductCategories($data['productId']);//产品属于的分类（包括子类和父类）

			if(!empty($categoryId)){
			    $results=array();
				$groups=array();
			    foreach($categoryId as $v){
			        $result=$this->model_catalog_category->getCategory($v);
					$result=array_filter($result,"filter");
					//过滤，只包括本类别的属性
					if(!empty($result['top']) && !empty($result['category_id'])){
					    $top=$result['top']-1;
					    $sql.=" and ag.cid{$top}={$result['category_id']}";
					}
					
					if(!empty($result['attribute_group'])) $groups[]=$result['attribute_group'];
			    }
			}

			if(!empty($groups)){
				$group=array_unique($groups);
				$attribute_group=implode(',',$group);
			}
		}

		$filterAttributeGroupId=isset($data['filter_attribute_group_id'])?$data['filter_attribute_group_id']:'';
		if (!empty($filterAttributeGroupId)) {
			$sql .= " AND a.attribute_group_id ='" . $this->db->escape($filterAttributeGroupId) . "'";
		}
		
		$filterType=isset($data['filter_type'])?$data['filter_type']:'';
		if (!empty($filterType)) {
			$sql .= " AND ag.type= '" . $this->db->escape($filterType) . "'";
		}
		
		if (!empty($attribute_group)){
		    $sql.=" AND a.attribute_group_id in ({$attribute_group}) ";
		}

   
		$sort_data = array(
			'ad.name',
			'attribute_group',
			'a.sort_order',
			'ag.type',
			'a.attribute_group_id'
		);	
		
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY attribute_group,ad.name";	
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
				$data['limit'] = 100;
			}	
		
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}	

		$query = $this->db->query($sql);
		
		return $query->rows;
	}
	
	public function getTotalAttributes($data=array()) {
	    $sql = "SELECT count(a.attribute_id) as total  FROM " . DB_PREFIX . "attribute a LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) inner join ".DB_PREFIX."attribute_group_description agd on  a.attribute_group_id=agd.attribute_group_id inner join ".DB_PREFIX."attribute_group ag on  ag.attribute_group_id=a.attribute_group_id";
        
		if (!empty($data['filter_name'])) {
			$sql .= " and LCASE(agd.name) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
		}
		
		if (!empty($data['filter_type'])) {
			$sql .= " and LCASE(ag.type) ='" . $this->db->escape(utf8_strtolower($data['filter_type'])) . "'";
		}
	    
		$filterAttributeGroupId=isset($data['filter_attribute_group_id'])?$data['filter_attribute_group_id']:'';
		if (!empty($filterAttributeGroupId)) {
			$sql .= " AND a.attribute_group_id like '%" . $this->db->escape($filterAttributeGroupId) . "%'";
		}

      	$query = $this->db->query($sql);
		
		return $query->row['total'];
	}	
	
		
	public function getAttributeDescriptions($attribute_id) {
		$attribute_data = array();
		
		$query = $this->db->query("SELECT name FROM " . DB_PREFIX . "attribute_description WHERE attribute_id = '" . (int)$attribute_id . "' limit 1");
		
		
		return isset($query->row['name'])?$query->row['name']:'';
	}
		
	public function getAttributesByAttributeGroupId($data = array()) {
		$sql = "SELECT *, (SELECT agd.name FROM " . DB_PREFIX . "attribute_group_description agd WHERE agd.attribute_group_id = a.attribute_group_id ) AS attribute_group FROM " . DB_PREFIX . "attribute a LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) ";

		if (!empty($data['filter_name'])) {
			$sql .= " AND LCASE(ad.name) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
		}

		if (!empty($data['filter_attribute_group_id'])) {
			$sql .= " AND a.attribute_group_id = '" . $this->db->escape($data['filter_attribute_group_id']) . "'";
		}
								
		$sort_data = array(
			'ad.name',
			'attribute_group',
			'a.sort_order'
		);	
		
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY ad.name";	
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
		
		return $query->rows;
	}
	
	
	
	public function getTotalAttributesByAttributeGroupId($attribute_group_id) {
      	$query = $this->db->query("SELECT COUNT(attribute_id) AS total FROM " . DB_PREFIX . "attribute WHERE attribute_group_id = '" . (int)$attribute_group_id . "'");
		
		return $query->row['total'];
	}	
	
	
}
?>