<?php 
class ModelLocalisationReturnAction extends Model {
	public function addReturnAction($data) {
		
		if (isset($return_action_id)) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "return_action SET return_action_id = '" . (int)$return_action_id  . "', name = '" . $this->db->escape($data['return_action']) . "'");
		} else {
			$this->db->query("INSERT INTO " . DB_PREFIX . "return_action SET  name = '" . $this->db->escape($data['return_action']) . "'");
			
			$return_action_id = $this->db->getLastId();
		}
		
		
		$this->cache->delete('return_action');
	}

	public function editReturnAction($return_action_id, $data) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "return_action WHERE return_action_id = '" . (int)$return_action_id . "'");

		foreach ($data['return_action'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "return_action SET return_action_id = '" . (int)$return_action_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}
				
		$this->cache->delete('return_action');
	}
	
	public function deleteReturnAction($return_action_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "return_action WHERE return_action_id = '" . (int)$return_action_id . "'");
	
		$this->cache->delete('return_action');
	}
		
	public function getReturnAction($return_action_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "return_action WHERE return_action_id = '" . (int)$return_action_id  . "'");
		
		return $query->row;
	}
		
	public function getReturnActions($data = array()) {
      	if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "return_action";
			
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
			$return_action_data = $this->cache->get('return_action' );
		
			if (!$return_action_data) {
				$query = $this->db->query("SELECT return_action_id, name FROM " . DB_PREFIX . "return_action  ORDER BY name");
	
				$return_action_data = $query->rows;
			
				$this->cache->set('return_action', $return_action_data);
			}	
	
			return $return_action_data;				
		}
	}
	
	public function getReturnActionDescriptions($return_action_id) {
		$return_action_data = array();
		
		$query = $this->db->query("SELECT name FROM " . DB_PREFIX . "return_action WHERE return_action_id = '" . (int)$return_action_id . "'");
		
		/* foreach ($query->rows as $result) {
			$return_action_data = array('name' => $result['name']);
		} */
		
		return $query->row['name'];
	}
	
	public function getTotalReturnActions() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "return_action ");
		
		return $query->row['total'];
	}	
}
?>