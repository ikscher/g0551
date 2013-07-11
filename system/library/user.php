<?php
class User {
    /**
	*  后台用户登录类
	*/
	private $user_id;
	private $username;
  	private $permission = array();

  	public function __construct($registry) {
		$this->db = $registry->get('db');
		$this->request = $registry->get('request');
		$this->session = $registry->get('session');
		$this->cookie = $registry->get('cookie');
		
		
		$this->user_id=$this->cookie->OCAuthCode(isset($this->request->cookie['adminuserid'])?$this->request->cookie['adminuserid']:'','DECODE');

    	 if(!empty($this->user_id)){
			$user_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "user WHERE user_id = '" . $this->user_id . "' AND status = '1'");
			
			if ($user_query->num_rows) {
				$this->user_id = $user_query->row['user_id'];
				$this->username = $user_query->row['username'];
				
      			$this->db->query("UPDATE " . DB_PREFIX . "user SET ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE user_id = '" . (int)$this->user_id . "'");

      			$user_group_query = $this->db->query("SELECT permission FROM " . DB_PREFIX . "user_group WHERE user_group_id = '" . (int)$user_query->row['user_group_id'] . "'");
				
	  			$permissions = unserialize($user_group_query->row['permission']);

				if (is_array($permissions)) {
	  				foreach ($permissions as $key => $value) {
	    				$this->permission[$key] = $value;
	  				}
				}
			} else {
				$this->logout();
			}
    	}
  	}
		
  	public function login($username, $password) {
	    $username=$this->db->escape($username);
		$password=$this->db->escape(md5($password));
		$sql="SELECT user_id,username,user_group_id FROM " . DB_PREFIX . "user WHERE username ='{$username}'  AND  password = '{$password}' AND status = '1' limit 1";
    	
		$user_query = $this->db->query($sql);
      
    	if ($user_query->num_rows) {
			$this->session->data['user_id'] = $user_query->row['user_id'];
			
			$this->cookie->OCSetCookie("adminuserid",$this->cookie->OCAuthCode($user_query->row['user_id'],'ENCODE'),24*3600);
			$this->cookie->OCSetCookie("adminusername",$this->cookie->OCAuthCode($user_query->row['username'],'ENCODE'),24*3600);
			
			$this->user_id = $user_query->row['user_id'];
			$this->username = $user_query->row['username'];			

      		$user_group_query = $this->db->query("SELECT permission FROM " . DB_PREFIX . "user_group WHERE user_group_id = '" . (int)$user_query->row['user_group_id'] . "'");
            
	  		$permissions = unserialize($user_group_query->row['permission']);
             // print_r($permissions);exit;
			if (is_array($permissions)) {
				foreach ($permissions as $key => $value) {
					$this->permission[$key] = $value;
				}
			}
		
      		return true;
    	} else {
      		return false;
    	}
  	}

  	public function logout() {
		unset($this->session->data['user_id']);
		
		// if(isset($this->request->cookie['user_id'])) $this->cookie->OCSetCookie("user_id","",-24*3600);
	
		$this->user_id = '';
		$this->username = '';
		
		session_destroy();
  	}

  	public function hasPermission($key, $value) {
    	if (isset($this->permission[$key])) {
	  		return in_array($value, $this->permission[$key]);
		} else {
	  		return false;
		}
  	}
  
  	public function isLogged() {
    	return $this->user_id;
  	}
  
  	public function getId() {
    	return $this->user_id;
  	}
	
  	public function getUserName() {
    	return $this->username;
  	}	
}
?>