<?php
/**所有操作**/
class ModelUserUserAction extends Model {
	public function addUserAction($data) {
	    $navcode = $this->db->escape($data['navcode']);
		$navdesc = $this->db->escape($data['navdesc']);
		$actioncode = $this->db->escape($data['actioncode']);
		$actiondesc = $this->db->escape($data['actiondesc']);
	    $sql="INSERT INTO " . DB_PREFIX . "user_action SET  navcode = '{$navcode}',navdesc='{$navdesc}',actioncode='{$actioncode}',actiondesc='{$actiondesc}'";
		$this->db->query($sql);
	}
	
	public function editUserAction($id, $data) {
	    $sql="UPDATE " . DB_PREFIX . "user_action SET navcode = '" . $this->db->escape($data['navcode']) . "', navdesc = '" . $this->db->escape($data['navdesc']) . "', actioncode = '" . $this->db->escape($data['actioncode']). "', actiondesc = '" . $this->db->escape($data['actiondesc']) ."'  WHERE id = '" . (int)$id . "'";
		$this->db->query($sql);
	}
	
	public function deleteUserAction($id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "user_action WHERE id = '" . (int)$id . "'");
	}
    
	/*
	public function addPermission($user_id, $type, $page) {
		$user_query = $this->db->query("SELECT DISTINCT user_group_id FROM " . DB_PREFIX . "user WHERE user_id = '" . (int)$user_id . "'");
		
		if ($user_query->num_rows) {
			$user_group_query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "user_group WHERE user_group_id = '" . (int)$user_query->row['user_group_id'] . "'");
		
			if ($user_group_query->num_rows) {
				$data = unserialize($user_group_query->row['permission']);
		
				$data[$type][] = $page;
		
				$this->db->query("UPDATE " . DB_PREFIX . "user_group SET permission = '" . serialize($data) . "' WHERE user_group_id = '" . (int)$user_query->row['user_group_id'] . "'");
			}
		}
	}
	*/
	
	
	public function getUserAction($id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "user_action WHERE id = '" . (int)$id . "'");
		
		$user_action = array(
			'navcode'       => $query->row['navcode'],
			'navdesc' =>     $query->row['navdesc'],
			'actioncode' => $query->row['actioncode'],
			'actiondesc' => $query->row['actiondesc']
		);
		
		return $user_action;
	}
	
	public function getUserActions($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "user_action";
		
		if(!empty($data['navdesc'])){
		    $sql .= " where navdesc='{$data['navdesc']}'";
		}
		
		if(!empty($data['sort'])){
		    $sql .=" order by {$data['sort']}";
		}else{
		    $sql .= " ORDER BY navdesc";	
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
	
	public function getTotalUserActions($data=array()) {
	    $sql="SELECT COUNT(id) AS total FROM " . DB_PREFIX . "user_action";
		
		if(!empty($data['navdesc'])){
		    $sql .= " where navdesc='{$data['navdesc']}'";
		}
	   
      	$query = $this->db->query($sql);
		
		return $query->row['total'];
	}	
	
	public function getAllActions(){
	    $result=array();
	    $sql="select id,navcode,navdesc,actioncode,actiondesc from ".DB_PREFIX."user_action ";
		$query=$this->db->query($sql);
		$result=$query->rows;
	    return $result;
	}
}
?>