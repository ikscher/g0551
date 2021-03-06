<?php
class ModelAccountReturn extends Model {
	public function addReturn($data) {	
        $time=time();	
		$this->db->query("INSERT INTO `" . DB_PREFIX . "return` SET order_id = '".$this->db->escape($data['order_id'])."',product_id='".$this->db->escape($data['product_id'])."', customer_id = '" . (int)$this->customer->getId() . "', username = '" . $this->db->escape($data['username']) . "',  email = '" . $this->db->escape($data['email']) . "', telphone = '" . $this->db->escape($data['telphone']) . "', product = '" . $this->db->escape($data['product']) . "', model = '" . $this->db->escape($data['model']) . "', quantity = '" . (int)$data['quantity'] . "', opened = '" . (int)$data['opened'] . "', return_reason_id = '" . (int)$data['return_reason_id'] . "', return_status_id = '" . (int)$this->config->get('config_return_status_id') . "', comment = '" . $this->db->escape($data['comment']) . "', date_ordered = '" . $this->db->escape(strtotime($data['date_ordered'])) . "', date_added ={$time}, date_modified ={$time}");
	}
	
	public function getReturn($return_id) {
		$query = $this->db->query("SELECT r.return_id, r.order_id,  r.username, r.email, r.telphone, r.product, r.model, r.quantity, r.opened, (SELECT rr.name FROM " . DB_PREFIX . "return_reason rr WHERE rr.return_reason_id = r.return_reason_id ) AS reason, (SELECT ra.name FROM " . DB_PREFIX . "return_action ra WHERE ra.return_action_id = r.return_action_id ) AS action, (SELECT rs.name FROM " . DB_PREFIX . "return_status rs WHERE rs.return_status_id = r.return_status_id ) AS status, r.comment, r.date_ordered, r.date_added, r.date_modified FROM `" . DB_PREFIX . "return` r WHERE return_id = '" . (int)$return_id . "' AND customer_id = '" . $this->customer->getId() . "'");
		
		return $query->row;
	}
	
	public function getReturns($data) {
		
		if ($data['start'] < 0) {
			$data['start'] = 0;
		}
		
		if ($data['limit'] < 1) {
			$data['limit'] = 1;
		}	
	    
		$sql="SELECT r.return_id, r.order_id, r.username, rs.name as status, r.date_added FROM `" . DB_PREFIX . "return` r LEFT JOIN " . DB_PREFIX . "return_status rs ON (r.return_status_id = rs.return_status_id) WHERE r.customer_id = '" . $this->customer->getId()  . "'";
		
		$sql .= " ORDER BY r.return_id DESC LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		$query = $this->db->query($sql);
		
		return $query->rows;
	}
			
	public function getTotalReturns() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "return`WHERE customer_id = '" . $this->customer->getId() . "'");
		
		return $query->row['total'];
	}
	
	public function getReturnHistories($return_id) {
		$query = $this->db->query("SELECT rh.date_added, rs.name AS status, rh.comment, rh.notify FROM " . DB_PREFIX . "return_history rh LEFT JOIN " . DB_PREFIX . "return_status rs ON rh.return_status_id = rs.return_status_id WHERE rh.return_id = '" . (int)$return_id  . "' ORDER BY rh.date_added ASC");

		return $query->rows;
	}			
}
?>