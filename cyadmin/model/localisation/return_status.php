<?php 
class ModelLocalisationReturnStatus extends Model {
	public function addReturnStatus($data) {
		
		if (isset($return_status_id)) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "return_status SET return_status_id = '" . (int)$return_status_id .  "', name = '" . $this->db->escape($data['return_status']) . "'");
		} else {
			$this->db->query("INSERT INTO " . DB_PREFIX . "return_status SET  name = '" . $this->db->escape($data['return_status']) . "'");
			
			$return_status_id = $this->db->getLastId();
		}
		
		
		$this->cache->delete('return_status');
	}

	public function editReturnStatus($return_status_id, $data) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "return_status WHERE return_status_id = '" . (int)$return_status_id . "'");

		foreach ($data['return_status'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "return_status SET return_status_id = '" . (int)$return_status_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}
				
		$this->cache->delete('return_status');
	}
	
	public function deleteReturnStatus($return_status_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "return_status WHERE return_status_id = '" . (int)$return_status_id . "'");
	
		$this->cache->delete('return_status');
	}
		
	public function getReturnStatus($return_status_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "return_status WHERE return_status_id = '" . (int)$return_status_id . "'");
		
		return $query->row;
	}
		
	public function getReturnStatuses($data = array()) {
      	if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "return_status";
			
			$sql .= " ORDER BY name";	
			
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
			$return_status_data = $this->cache->get('return_status' );
		
			if (!$return_status_data) {
				$query = $this->db->query("SELECT return_status_id, name FROM " . DB_PREFIX . "return_status ORDER BY name");
	
				$return_status_data = $query->rows;
			
				$this->cache->set('return_status', $return_status_data);
			}	
	
			return $return_status_data;				
		}
	}
	
	public function getReturnStatusDescriptions($return_status_id) {
		$return_status_data = array();
		
		$query = $this->db->query("SELECT name FROM " . DB_PREFIX . "return_status WHERE return_status_id = '" . (int)$return_status_id . "'");
		
		/* foreach ($query->rows as $result) {
			$return_status_data = array('name' => $result['name']);
		} */
		
		return isset($query->row['name'])?$query->row['name']:'';
	}
	
	public function getTotalReturnStatuses() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "return_status ");
		
		return $query->row['total'];
	}	
}
?>