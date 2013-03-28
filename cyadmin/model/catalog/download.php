<?php
class ModelCatalogDownload extends Model {
	public function addDownload($data) {
	    $time=time();
      	$this->db->query("INSERT INTO " . DB_PREFIX . "download SET filename = '" . $this->db->escape($data['filename']) . "', mask = '" . $this->db->escape($data['mask']) . "', remaining = '" . (int)$data['remaining'] . "', date_added = {$time}");

      	$download_id = $this->db->getLastId(); 

      	
        $this->db->query("INSERT INTO " . DB_PREFIX . "download_description SET download_id = '" . (int)$download_id . "', name = '" . $this->db->escape($data['download_description']) . "'");
      	
	}
	
	public function editDownload($download_id, $data) {
		if (!empty($data['update'])) {
			$download_info = $this->getDownload($download_id);
        	
			if ($download_info) {
      			$this->db->query("UPDATE " . DB_PREFIX . "order_download SET `filename` = '" . $this->db->escape($data['filename']) . "', mask = '" . $this->db->escape($data['mask']) . "', remaining = '" . (int)$data['remaining'] . "' WHERE `filename` = '" . $this->db->escape($download_info['filename']) . "'");
			}
		}		
		
        $this->db->query("UPDATE " . DB_PREFIX . "download SET filename = '" . $this->db->escape($data['filename']) . "', mask = '" . $this->db->escape($data['mask']) . "', remaining = '" . (int)$data['remaining'] . "' WHERE download_id = '" . (int)$download_id . "'");

      	$this->db->query("DELETE FROM " . DB_PREFIX . "download_description WHERE download_id = '" . (int)$download_id . "'");

      	
        $this->db->query("INSERT INTO " . DB_PREFIX . "download_description SET download_id = '" . (int)$download_id. "', name = '" . $this->db->escape($data['download_description']) . "'");
      	
	}
	
	public function deleteDownload($download_id) {
      	$this->db->query("DELETE FROM " . DB_PREFIX . "download WHERE download_id = '" . (int)$download_id . "'");
	  	$this->db->query("DELETE FROM " . DB_PREFIX . "download_description WHERE download_id = '" . (int)$download_id . "'");	
	}	

	public function getDownload($download_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "download WHERE download_id = '" . (int)$download_id . "'");
		
		return $query->row;
	}

	public function getDownloads($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "download d LEFT JOIN " . DB_PREFIX . "download_description dd ON (d.download_id = dd.download_id) ";
	
		$sort_data = array(
			'dd.name',
			'd.remaining'
		);
	
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY dd.name";	
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
	
	public function getDownloadDescriptions($download_id) {
		$download_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "download_description WHERE download_id = '" . (int)$download_id . "' limit 1");
		
		
		$download_description_data = $query->row['name'];
		
		
		return $download_description_data;
	}
	
	public function getTotalDownloads() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "download");
		
		return $query->row['total'];
	}	
}
?>