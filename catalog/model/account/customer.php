<?php
class ModelAccountCustomer extends Model {
    
	/**
	*  新增用户
	*/
	public function addCustomer($data) {
		/* if (isset($data['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) && in_array($data['customer_group_id'], $this->config->get('config_customer_group_display'))) {
			$customer_group_id = $data['customer_group_id'];
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}

		$this->load->model('account/customer_group');

		$customer_group_info = $this->model_account_customer_group->getCustomerGroup($customer_group_id); 
		*/
        
		//$store_id=(int)$this->config->get('config_store_id') ;
		
		$isMerchants=$this->request->post['isMerchants'];
		
		if($isMerchants==1){ //店铺注册
		    $store=$this->db->escape($this->request->post['store']);
			$owner=$this->db->escape($this->request->post['yourname']);
			$telphone=$this->db->escape($this->request->post['telphone']);
		    $email=$this->db->escape($this->request->post['email']);
			$mobile=$this->db->escape($this->request->post['mobile']);
			$password=md5($this->db->escape($this->request->post['password']));
			$ip=$this->db->escape($this->request->server['REMOTE_ADDR']);
			$time=time();
			
			//注册店铺
			$this->db->query("INSERT INTO `" . DB_PREFIX. "store` set name='{$store}',owner='{$owner}',tel='{$telphone}',mobile='{$mobile}',createtime='{$time}',map_x='117.346448',map_y='31.904115'");
			
			$store_id=$this->db->getLastId();
			//同时注册会员
			$this->db->query("INSERT INTO `" . DB_PREFIX . "customer` SET  store_id='{$store_id}', email = '{$email}', mobile = '{$mobile}',  password = '{$password}', newsletter = '0', customer_group_id = '1', ip = '{$ip}', status = '1', approved = '1', date_added = {$time}");
			
		}else{  //会员注册
		
			$email=$this->db->escape($this->request->post['email']);
			$mobile=$this->db->escape($this->request->post['mobile']);
			$password=md5($this->db->escape($this->request->post['password']));
			$ip=$this->db->escape($this->request->server['REMOTE_ADDR']);
			$time=time();
			$this->db->query("INSERT INTO " . DB_PREFIX . "customer SET   email = '{$email}', mobile = '{$mobile}',  password = '{$password}', newsletter = '0', customer_group_id = '1', ip = '{$ip}', status = '1', approved = '1', date_added = {$time}");
			
		}
		
		
		/*
		$customer_id = $this->db->getLastId();

      	$this->db->query("INSERT INTO " . DB_PREFIX . "address SET customer_id = '" . (int)$customer_id . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', company = '" . $this->db->escape($data['company']) . "', company_id = '" . $this->db->escape($data['company_id']) . "', tax_id = '" . $this->db->escape($data['tax_id']) . "', address_1 = '" . $this->db->escape($data['address_1']) . "', address_2 = '" . $this->db->escape($data['address_2']) . "', city = '" . $this->db->escape($data['city']) . "', postcode = '" . $this->db->escape($data['postcode']) . "', country_id = '" . (int)$data['country_id'] . "', zone_id = '" . (int)$data['zone_id'] . "'");

		 $address_id = $this->db->getLastId();

      	$this->db->query("UPDATE " . DB_PREFIX . "customer SET address_id = '" . (int)$address_id . "' WHERE customer_id = '" . (int)$customer_id . "'"); */

		
		
		
		/* if (!$customer_group_info['approval']) { //需要通过审核才能登录
			$message .= $this->language->get('text_login') . "\n";
		} else {
			$message .= $this->language->get('text_approval') . "\n";
		}  */
        
		//以下给注册用户发送邮件
		/*
		$this->language->load('mail/customer');

		$subject = sprintf($this->language->get('text_subject'), $this->config->get('config_name'));

		$message = sprintf($this->language->get('text_welcome'), $this->config->get('config_name')) . "\n\n";
        
	   
		$message .= $this->language->get('text_login') . "\n";
		
		$message .= $this->url->link('account/login', '', 'SSL') . "\n\n";
		$message .= $this->language->get('text_services') . "\n\n";
		$message .= $this->language->get('text_thanks') . "\n";
		$message .= $this->config->get('config_name');

		
		$mail = new Mail();
		$mail->protocol = $this->config->get('config_mail_protocol');
		$mail->parameter = $this->config->get('config_mail_parameter');
		$mail->hostname = $this->config->get('config_smtp_host');
		$mail->username = $this->config->get('config_smtp_username');
		$mail->password = $this->config->get('config_smtp_password');
		$mail->port = $this->config->get('config_smtp_port');
		$mail->timeout = $this->config->get('config_smtp_timeout');
		$mail->setTo($data['email']);
		$mail->setFrom($this->config->get('config_email'));
		$mail->setSender($this->config->get('config_name'));
		$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
		$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
		$mail->send();

		// Send to main admin email if new account email is enabled
		if ($this->config->get('config_account_mail')) {
			$mail->setTo($this->config->get('config_email'));
			$mail->send();

			// Send to additional alert emails if new account email is enabled
			$emails = explode(',', $this->config->get('config_alert_emails'));

			foreach ($emails as $email) {
				if (strlen($email) > 0 && preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $email)) {
					$mail->setTo($email);
					$mail->send();
				}
			}
		}
		*/
	}
    
	/**
	* 编辑用户
	*/
	public function editCustomer($data) {
	    $uid=(int)$this->customer->getId();
		$username=$this->db->escape($data['username']);
	    $nickname=$this->db->escape($data['nickname']);
		//$postcode=$this->db->escape($data['postcode']);
		$mobile=$this->db->escape($data['mobile']);
		$telphone=$this->db->escape($data['telphone']);
		$email=$this->db->escape($data['email']);
		//$address=$this->db->escape($data['address']);
		
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET username='{$username}', nickname ='{$nickname}', mobile = '{$mobile}', email = '{$email}', telphone = '{$telphone}' WHERE customer_id = '{$uid}'");
	}

	public function editPassword($password,$email='') {
	    $uid=$this->cookie->OCAuthCode($this->request->cookie['memberid'],'DECODE');
		$pwd=md5($password);
		if(!empty($uid) &&　empty($email)){
			return $this->db->query("UPDATE " . DB_PREFIX . "customer SET   password ='{$pwd}'  WHERE customer_id = '{$uid}'");
		}elseif(!empty($email)){
		    return $this->db->query("UPDATE " . DB_PREFIX . "customer SET   password ='{$pwd}'  WHERE email = '{$email}'");
		}
	}

	public function editNewsletter($newsletter) {
	    $sql="UPDATE " . DB_PREFIX . "customer SET newsletter = '" . (int)$newsletter . "' WHERE customer_id = '" . (int)$this->customer->getId() . "'";
		$this->customer->setNewsLetter($newsletter);
		$this->db->query($sql);
	}
    
	
	public function getCustomer($customer_id,$store_id=0) {
	    if(!empty($store_id)){
			$sql="SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$customer_id . "' and store_id='{$store_id}'";
		}else{
		    $sql="SELECT a.*,c.* FROM `" . DB_PREFIX . "customer` c left join `".DB_PREFIX."address` a on c.customer_id=a.customer_id WHERE  c.customer_id = '" . (int)$customer_id . "'";
		}

		$query = $this->db->query($sql);

		return $query->row;
	}

	public function getCustomerByEmail($email) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE email = '" . $this->db->escape($email) . "'");

		return $query->row;
	}

	public function getCustomerByToken($token) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE token = '" . $this->db->escape($token) . "' AND token != ''");

		$this->db->query("UPDATE " . DB_PREFIX . "customer SET token = ''");

		return $query->row;
	}

	public function getCustomers($data = array()) {
		$sql = "SELECT *, c.username AS name, cg.name AS customer_group FROM " . DB_PREFIX . "customer c LEFT JOIN " . DB_PREFIX . "customer_group cg ON (c.customer_group_id = cg.customer_group_id) ";

		$implode = array();

		if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
			$implode[] = "LCASE(CONCAT(c.firstname, ' ', c.lastname)) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
		}

		if (isset($data['filter_email']) && !is_null($data['filter_email'])) {
			$implode[] = "c.email = '" . $this->db->escape($data['filter_email']) . "'";
		}

		if (isset($data['filter_customer_group_id']) && !is_null($data['filter_customer_group_id'])) {
			$implode[] = "cg.customer_group_id = '" . $this->db->escape($data['filter_customer_group_id']) . "'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$implode[] = "c.status = '" . (int)$data['filter_status'] . "'";
		}

		if (isset($data['filter_approved']) && !is_null($data['filter_approved'])) {
			$implode[] = "c.approved = '" . (int)$data['filter_approved'] . "'";
		}

		if (isset($data['filter_ip']) && !is_null($data['filter_ip'])) {
			$implode[] = "c.customer_id IN (SELECT customer_id FROM " . DB_PREFIX . "customer_ip WHERE ip = '" . $this->db->escape($data['filter_ip']) . "')";
		}

		if (isset($data['filter_date_added']) && !is_null($data['filter_date_added'])) {
			$implode[] = "DATE(c.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}

		$sort_data = array(
			'name',
			'c.email',
			'customer_group',
			'c.status',
			'c.ip',
			'c.date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY name";
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

	public function getTotalCustomersByEmail($email) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(strtolower($email)) . "'");

		return $query->row['total'];
	}

	public function getIps($customer_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "customer_ip` WHERE customer_id = '" . (int)$customer_id . "'");

		return $query->rows;
	}

	public function isBlacklisted($ip) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "customer_ip_blacklist` WHERE ip = '" . $this->db->escape($ip) . "'");

		return $query->num_rows;
	}
	
	/**
	*  数据库中电话是否已经存在
	*/
	public function isMobileExist($mobile){
	   $mobile= $this->db->escape($mobile);
	   $query = $this->db->query("SELECT customer_id FROM `" . DB_PREFIX . "customer` WHERE mobile = '{$mobile}' limit 1");
	   
	   return $query->num_rows;
	
	}
	
	
	/**
	*  数据库中邮箱是否已经存在
	*/
	public function isEmailExist($email){
	   $email= $this->db->escape($email);
	   $query = $this->db->query("SELECT customer_id FROM `" . DB_PREFIX . "customer` WHERE email = '{$email}' limit 1");
	   
	   return $query->num_rows;
	
	}
}
?>