<?php 
class ControllerAccountRegister extends Controller {
	private $error = array();

  	public function index() {
		/* if ($this->customer->isLogged()) {
	  		$this->redirect($this->url->link('account/account', '', 'SSL'));
    	} */
		
		//登录的用户名
		if ($this->customer->isLogged()){
		    // $customer=isset($this->session->data['customer'])?$this->session->data['customer']:'';
			if(isset($this->request->cookie['oc_customer'])){
				$customer=$this->cookie->OCAuthCode($this->request->cookie['oc_customer'],'DECODE');
				$customer=unserialize($customer);
				
				$this->data['username']=$customer['email'];
			}
		}else{
		    $this->data['username']='';
			//$this->redirect($this->url->link('account/register', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		
   
    	$this->language->load('account/register');
		
		// $this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('account/customer');
		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
		    
			$this->model_account_customer->addCustomer($this->request->post);

			$this->customer->login($this->request->post['email'], $this->request->post['password']);
			
			unset($this->session->data['guest']);
			 
	  		$this->redirect($this->url->link('account/success'));
    	} 

    
		
    	$this->data['action'] = $this->url->link('account/register', '', 'SSL');
		
		
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$server = HTTPS_IMAGE;
		} else {
			$server = HTTP_IMAGE;
		}

		
		if ($this->config->get('config_icon') && file_exists(DIR_IMAGE . $this->config->get('config_icon'))) {
			$this->data['icon'] = $server . $this->config->get('config_icon');
		} else {
			$this->data['icon'] = '';
		}
		
		$this->data['home']=$this->url->link("common/home","","SSL");
		$this->data['login']=$this->url->link("account/login","","SSL");
		
		$this->data['bottom']=$this->language->get('bottom');
		$this->data['icp']=$this->language->get('icp');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/register.html')) {
			$this->template = $this->config->get('config_template') . '/template/account/register.html';
		} else {
			$this->template = 'default/template/account/register.html';
		}
				
		$this->response->setOutput($this->render());	
  	}

  	private function validate() {
    	if ((utf8_strlen($this->request->post['username']) < 1) || (utf8_strlen($this->request->post['username']) > 32)) {
      		$this->error['username'] = $this->language->get('error_username');
    	}


    	if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
      		$this->error['email'] = $this->language->get('error_email');
    	}

    	if ($this->model_account_customer->getTotalCustomersByEmail($this->request->post['email'])) {
      		$this->error['warning'] = $this->language->get('error_exists');
    	}
		
    	if ((utf8_strlen($this->request->post['telphone']) < 3) || (utf8_strlen($this->request->post['telphone']) > 32)) {
      		$this->error['telphone'] = $this->language->get('error_telphone');
    	}
		
		// Customer Group
		$this->load->model('account/customer_group');
		
		if (isset($this->request->post['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) && in_array($this->request->post['customer_group_id'], $this->config->get('config_customer_group_display'))) {
			$customer_group_id = $this->request->post['customer_group_id'];
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}

		$customer_group = $this->model_account_customer_group->getCustomerGroup($customer_group_id);
			
		if ($customer_group) {	
			// Company ID
			if ($customer_group['company_id_display'] && $customer_group['company_id_required'] && empty($this->request->post['company_id'])) {
				$this->error['company_id'] = $this->language->get('error_company_id');
			}
			
			// Tax ID 
			if ($customer_group['tax_id_display'] && $customer_group['tax_id_required'] && empty($this->request->post['tax_id'])) {
				$this->error['tax_id'] = $this->language->get('error_tax_id');
			}						
		}
		
    	if ((utf8_strlen($this->request->post['address_1']) < 3) || (utf8_strlen($this->request->post['address_1']) > 128)) {
      		$this->error['address_1'] = $this->language->get('error_address_1');
    	}

    	if ((utf8_strlen($this->request->post['city']) < 2) || (utf8_strlen($this->request->post['city']) > 128)) {
      		$this->error['city'] = $this->language->get('error_city');
    	}

		$this->load->model('localisation/country');
		
		$country_info = $this->model_localisation_country->getCountry($this->request->post['country_id']);
		
		if ($country_info) {
			if ($country_info['postcode_required'] && (utf8_strlen($this->request->post['postcode']) < 2) || (utf8_strlen($this->request->post['postcode']) > 10)) {
				$this->error['postcode'] = $this->language->get('error_postcode');
			}
			
			// VAT Validation
			$this->load->helper('vat');
			
			if ($this->config->get('config_vat') && $this->request->post['tax_id'] && (vat_validation($country_info['iso_code_2'], $this->request->post['tax_id']) == 'invalid')) {
				$this->error['tax_id'] = $this->language->get('error_vat');
			}
		}

    	if ($this->request->post['country_id'] == '') {
      		$this->error['country'] = $this->language->get('error_country');
    	}
		
    	if ($this->request->post['zone_id'] == '') {
      		$this->error['zone'] = $this->language->get('error_zone');
    	}

    	if ((utf8_strlen($this->request->post['password']) < 4) || (utf8_strlen($this->request->post['password']) > 20)) {
      		$this->error['password'] = $this->language->get('error_password');
    	}

    	if ($this->request->post['confirm'] != $this->request->post['password']) {
      		$this->error['confirm'] = $this->language->get('error_confirm');
    	}
		
		if ($this->config->get('config_account_id')) {
			$this->load->model('catalog/information');
			
			$information_info = $this->model_catalog_information->getInformation($this->config->get('config_account_id'));
			
			if ($information_info && !isset($this->request->post['agree'])) {
      			$this->error['warning'] = sprintf($this->language->get('error_agree'), $information_info['title']);
			}
		}
		
    	if (!$this->error) {
      		return true;
    	} else {
      		return false;
    	}
  	}
	
	/**
	*  生成验证码
	*/
	public function captcha(){
	  $this->seccode->outCodeImage ( 125, 30, 4 );
	
	}
	
	/**
	*  返回验证码ajax认证
	*/
	public function ajaxCaptcha(){
	  $json = array();
	  $json=array("yzm"=>$this->memcached->get("codeyzm"));
	  $this->response->setOutput(json_encode($json));
	
	}
	
	
	/**
	*  返回邮箱ajax认证
	*/
	public function ajaxEmail(){
	  $json = array();
	  $email=$this->request->get['email'];
	  $this->load->model('account/customer');
	  $res=$this->model_account_customer->isEmailExist($email);
	  $json=array("email"=>$res);
	  $this->response->setOutput(json_encode($json));
	
	}
	
	
	/**
	*  返回手机ajax认证
	*/
	public function ajaxMobile(){
	  $json = array();
	  $mobile=$this->request->get['mobile'];
	  $this->load->model('account/customer');
	  $res=$this->model_account_customer->isMobileExist($mobile);
	  $json=array("mobile"=>$res);
	  $this->response->setOutput(json_encode($json));
	
	}
	
	
	public function country() {
		$json = array();
		
		$this->load->model('localisation/country');

    	$country_info = $this->model_localisation_country->getCountry($this->request->get['country_id']);
		
		if ($country_info) {
			$this->load->model('localisation/zone');

			$json = array(
				'country_id'        => $country_info['country_id'],
				'name'              => $country_info['name'],
				'iso_code_2'        => $country_info['iso_code_2'],
				'iso_code_3'        => $country_info['iso_code_3'],
				'address_format'    => $country_info['address_format'],
				'postcode_required' => $country_info['postcode_required'],
				'zone'              => $this->model_localisation_zone->getZonesByCountryId($this->request->get['country_id']),
				'status'            => $country_info['status']		
			);
		}
		
		$this->response->setOutput(json_encode($json));
	}	
}
?>