<?php
class ModelLocalisationWeightClass extends Model {
	public function addWeightClass($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "weight_class SET value = '" . (float)$data['value'] . "'");
		
		$weight_class_id = $this->db->getLastId();
		
		$value=$data['weight_class_description'];
		//foreach ($data['weight_class_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "weight_class_description SET weight_class_id = '" . (int)$weight_class_id . "', title = '" . $this->db->escape($value['title']) . "', unit = '" . $this->db->escape($value['unit']) . "'");
		//}
		
		$this->cache->delete('weight_class');
	}
	
	public function editWeightClass($weight_class_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "weight_class SET value = '" . (float)$data['value'] . "' WHERE weight_class_id = '" . (int)$weight_class_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "weight_class_description WHERE weight_class_id = '" . (int)$weight_class_id . "'");
        
		$value=$data['weight_class_description'];
		//foreach ($data['weight_class_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "weight_class_description SET weight_class_id = '" . (int)$weight_class_id  . "', title = '" . $this->db->escape($value['title']) . "', unit = '" . $this->db->escape($value['unit']) . "'");
		//}
		
		$this->cache->delete('weight_class');	
	}
	
	public function deleteWeightClass($weight_class_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "weight_class WHERE weight_class_id = '" . (int)$weight_class_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "weight_class_description WHERE weight_class_id = '" . (int)$weight_class_id . "'");	
		
		$this->cache->delete('weight_class');
	}
	
	public function getWeightClasses($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "weight_class wc LEFT JOIN " . DB_PREFIX . "weight_class_description wcd ON (wc.weight_class_id = wcd.weight_class_id) ";
		
			$sort_data = array(
				'title',
				'unit',
				'value'
			);	
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY title";	
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
		} else {
			$weight_class_data = $this->cache->get('weight_class' );

			if (!$weight_class_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "weight_class wc LEFT JOIN " . DB_PREFIX . "weight_class_description wcd ON (wc.weight_class_id = wcd.weight_class_id)");
	
				$weight_class_data = $query->rows;
			
				$this->cache->set('weight_class', $weight_class_data);
			}
			
			return $weight_class_data;
		}
	}
	
	public function getWeightClass($weight_class_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "weight_class wc LEFT JOIN " . DB_PREFIX . "weight_class_description wcd ON (wc.weight_class_id = wcd.weight_class_id) WHERE wc.weight_class_id = '" . (int)$weight_class_id . "' ");
		
		return $query->row;
	}

	public function getWeightClassDescriptionByUnit($unit) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "weight_class_description WHERE unit = '" . $this->db->escape($unit) . "'");
		
		return $query->row;
	}
	
	public function getWeightClassDescriptions($weight_class_id) {
		$weight_class_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "weight_class_description WHERE weight_class_id = '" . (int)$weight_class_id . "'");
			 
        $result=$query->row;			 
		//foreach ($query->rows as $result) {
			$weight_class_data= array(
				'title' => $result['title'],
				'unit'  => $result['unit']
			);
		//}
		
		return $weight_class_data;
	}
			
	public function getTotalWeightClasses() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "weight_class"); 
		
		return $query->row['total'];
	}		
}
?>