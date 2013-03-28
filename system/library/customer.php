<?php
class Customer {
    /**
	* 前台会员（及店铺主）类
	*/
	private $customer_id;
	private $username;
	private $nickname;
	private $email;
	private $telephone;
	private $fax;
	private $newsletter;
	private $customer_group_id;
	private $address_id;
	private $store_id;
	
  	public function __construct($registry) {
	    $time=time();
		$this->config = $registry->get('config');
		$this->db = $registry->get('db');
		$this->request = $registry->get('request');
		$this->session = $registry->get('session');
		$this->cookie = $registry->get('cookie');
		$this->memcached = $registry->get('memcached');
		
		// var_dump(unserialize($this->memcached->get('customer')));exit;
		//if (isset($this->session->data['customer_id'])) { 
		
		if(isset($this->request->cookie['memberid'])) $this->customer_id=$this->cookie->OCAuthCode($this->request->cookie['memberid'],'DECODE');
		if(!empty($this->customer_id)){
		    if($this->memcached->get('customer')){
			    $result=unserialize($this->memcached->get('customer'));
			}else{
			    $customer_query = $this->db->query("SELECT store_id,username,nickname,avatar,gender,email,mobile,telephone,fax,password,cart,wishlist,newsletter,customer_group_id,ip,hasshop,status,approved,token,date_modified,date_added FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$this->customer_id . "' AND status = '1'");
			    $result=$customer_query->row;
				$this->memcached->set('customer',serialize($customer_query->row));
			}
			
			
			if (!empty($result)) {
				//$this->customer_id = $result['customer_id'];
				$this->username = $result['username'];
				$this->email = $result['email'];
				$this->nickname =$result['nickname'];
				$this->telephone = $result['telephone'];
				$this->mobile = $result['mobile'];
				$this->newsletter = $result['newsletter'];
				$this->customer_group_id = $result['customer_group_id'];
				//$this->address_id = $customer_query->row['address_id'];
				$sql="select * from " . DB_PREFIX . "address where customer_id='".$this->customer_id."' and status=1";
				$query=$this->db->query($sql);
				
				$res=$query->row;
				if(!empty($res)) $this->address_id = $res['address_id'];
				
      			$this->db->query("UPDATE " . DB_PREFIX . "customer SET cart = '" . $this->db->escape(isset($this->session->data['cart']) ? serialize($this->session->data['cart']) : '') . "', wishlist = '" . $this->db->escape(isset($this->session->data['wishlist']) ? serialize($this->session->data['wishlist']) : '') . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE customer_id = '" . (int)$this->customer_id . "'");
			
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_ip WHERE customer_id = '" . (int)$this->customer_id. "' AND ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "'");
				
				if (!$query->num_rows) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "customer_ip SET customer_id = '" . (int)$this->customer_id . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', date_added = {$time}");
				}
			} else {
				$this->logout();
			}
  		}
	}
		
  	public function login($username, $password, $override = false) {
	    $username=$this->db->escape(strtolower($username));
		$password= $this->db->escape(md5($password)) ;
	    
		if ($override) { //需要通过审核
		    $sql="SELECT * FROM " . DB_PREFIX . "customer WHERE (email ='{$username}' or mobile='{$username}') AND  password = '{$password}' AND status = '1' AND approved = '1'";
		    $customer_query = $this->db->query($sql);
		} else { //不需要通过审核
		    $sql="SELECT * FROM " . DB_PREFIX . "customer where (email ='{$username}' or mobile='{$username}') AND  password = '{$password}'  AND status = '1'";
			$customer_query = $this->db->query($sql);
			
		}
       
		if ($customer_query->num_rows) { 
			$this->session->data['customer_id'] = $customer_query->row['customer_id'];	
		    //$this->session->data['store_id'] = $customer_query->row['store_id'];
		    
			if ($customer_query->row['cart'] && is_string($customer_query->row['cart'])) {
				$cart = unserialize($customer_query->row['cart']);
				
				foreach ($cart as $key => $value) { //$key为产品的ID，$value产品的数量
				    $this->session->data['cart'][$key] = $value;
					/* if (!array_key_exists($key, $this->session->data['cart'])) {
						$this->session->data['cart'][$key] = $value;
					} else {
						$this->session->data['cart'][$key] += $value;
					} */
				}			
			}

			if ($customer_query->row['wishlist'] && is_string($customer_query->row['wishlist'])) {
				if (!isset($this->session->data['wishlist'])) {
					$this->session->data['wishlist'] = array();
				}
								
				$wishlist = unserialize($customer_query->row['wishlist']);
			
				foreach ($wishlist as $product_id) {
					if (!in_array($product_id, $this->session->data['wishlist'])) {
						$this->session->data['wishlist'][] = $product_id;
					}
				}			
			}
			
			$this->customer_id = $customer_query->row['customer_id'];
			$this->username = $customer_query->row['username'];
			$this->nickname =$result['nickname'];
			$this->store_id = $customer_query->row['store_id'];
			$this->mobile=$customer_query->row['mobile'];
			$this->email = $customer_query->row['email'];
			$this->telephone = $customer_query->row['telephone'];
			$this->fax = $customer_query->row['fax'];
			$this->newsletter = $customer_query->row['newsletter'];
			$this->customer_group_id = $customer_query->row['customer_group_id'];
			
			$query=$this->db->query("select * from " . DB_PREFIX . "address where customer_id='{$this->customer_id}' and status=1");
			$res=$query->row;
			$this->address_id = isset($res['address_id'])?($res['address_id']):0;
			
			//$this->session->data['customer']=serialize($customer_query->row);//if use session
			if (isset($this->request->post['remember'])){ //如果记住密码，保存一天的时间
			    $this->cookie->OCSetCookie("customer",$this->cookie->OCAuthCode(serialize($customer_query->row),'ENCODE'),7*24*3600);
				$this->cookie->OCSetCookie("memberid",$this->cookie->OCAuthCode($this->customer_id,'ENCODE'),7*24*3600);
				if(!empty($this->store_id)) $this->cookie->OCSetCookie("storeid",$this->cookie->OCAuthCode($this->store_id,'ENCODE'),7*24*3600);
          	}else{
			    $this->cookie->OCSetCookie("customer",$this->cookie->OCAuthCode(serialize($customer_query->row),'ENCODE'),24*3600);
				$this->cookie->OCSetCookie("memberid",$this->cookie->OCAuthCode($this->customer_id,'ENCODE'),24*3600);
				if(!empty($this->store_id)) $this->cookie->OCSetCookie("storeid",$this->cookie->OCAuthCode($this->store_id,'ENCODE'),24*3600);
			}
			
			
			$this->db->query("UPDATE " . DB_PREFIX . "customer SET ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE customer_id = '" . (int)$this->customer_id . "'");
			
	  		return true;
    	} else {
      		return false;
    	}
  	}
  	
	public function logout() {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET cart = '" . $this->db->escape(isset($this->session->data['cart']) ? serialize($this->session->data['cart']) : '') . "', wishlist = '" . $this->db->escape(isset($this->session->data['wishlist']) ? serialize($this->session->data['wishlist']) : '') . "' WHERE customer_id = '" . (int)$this->customer_id . "'");
		
		unset($this->session->data['customer_id']);
		//unset($this->session->data['store_id']);

		$this->customer_id = '';
		$this->username = '';

		$this->email = '';
		$this->telephone = '';
		$this->fax = '';
		$this->newsletter = '';
		$this->customer_group_id = '';
		$this->address_id = '';
		$this->cookie->OCSetCookie("customer",'');
		$this->cookie->OCSetCookie("memberid",'');
		$this->cookie->OCSetCookie("dbuyproduct",'');
		$this->cookie->OCSetCookie("storeid",'');
  	}
  
  	public function isLogged() {
    	return $this->customer_id;
  	}

  	public function getId() {
    	return $this->customer_id;
  	}
      
  	public function getUserName() {
		return $this->username;
  	}
 
  
  	public function getEmail() {
		return $this->email;
  	}
	
	public function getNickName() {
		return $this->nickname;
  	}
  
  	public function getTelephone() {
		return $this->telephone;
  	}
  
  	public function getMobile() {
		return $this->mobile;
  	}
	
  	public function getNewsletter() {
		return $this->newsletter;	
  	}
	
	public function setNewsLetter($s){
	    $this->newsletter=$s;
	}
	
	public function getStoreId(){
	    return $this->store_id;
	}

  	public function getCustomerGroupId() {
		return $this->customer_group_id;	
  	}
	
  	public function getAddressId() {
		return $this->address_id;	
  	}
	
  	public function getBalance() {
		$query = $this->db->query("SELECT SUM(amount) AS total FROM " . DB_PREFIX . "customer_transaction WHERE customer_id = '" . (int)$this->customer_id . "'");
	
		return $query->row['total'];
  	}	
		
  	public function getRewardPoints() {
		$query = $this->db->query("SELECT SUM(points) AS total FROM " . DB_PREFIX . "customer_reward WHERE customer_id = '" . (int)$this->customer_id . "'");
	
		return $query->row['total'];	
  	}	
}
?>