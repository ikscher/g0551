<?php 
class ControllerAccountLogin extends Controller {
	private $error = array();
	
	public function index() {
		$this->load->model('account/customer');
		
		$username=isset($this->request->post['username'])?$this->request->post['username']:'';
		$password=isset($this->request->post['password'])?$this->request->post['password']:'';	
		
		if ($this->customer->isLogged() && isset($this->request->cookie['customer'])) {  //已经登录过了
      		$this->redirect($this->url->link('common/home', '', 'SSL'));
    	}
		
		$this->data['referer']=isset($this->request->get['referer'])?$this->request->get['referer']:'';
		
	
    	$this->language->load('account/login');

    	$this->document->setTitle($this->language->get('heading_title'));

		
		// Login override for admin users
		$this->data['error_login_info']='';
		
		if ($this->request->server['REQUEST_METHOD'] == 'POST'){
			if ( $this->customer->login($username,$password)) { 
				
				// Default Addresses
				$this->load->model('account/address');
					
				$address_info = $this->model_account_address->getAddress($this->customer->getAddressId());
										
				if ($address_info) {
					if ($this->config->get('config_tax_customer') == 'shipping') {
						$this->session->data['address'] = $address_info['address'];
						//$this->session->data['shipping_zone_id'] = $address_info['zone_id'];
						//$this->session->data['shipping_postcode'] = $address_info['postcode'];	
					}
					
					/* if ($this->config->get('config_tax_customer') == 'payment') {
						$this->session->data['payment_country_id'] = $address_info['country_id'];
						$this->session->data['payment_zone_id'] = $address_info['zone_id'];
					} */
				} else {
					unset($this->session->data['address']);	
					//unset($this->session->data['shipping_zone_id']);	
					//unset($this->session->data['shipping_postcode']);
					//unset($this->session->data['payment_country_id']);	
					//unset($this->session->data['payment_zone_id']);	
				}
									
				if(!empty($this->request->post['referer'])){
					header("location:".html_entity_decode($this->request->post['referer']));exit;
				}else{
					$this->redirect($this->url->link('common/home', '', 'SSL')); 
				}
				
			} else{
			    $this->data['username']=$this->request->post['username'];
			    $this->data['error_login_info']="错误的用户名或密码！";
			
			}
		}	
		

  
				
    	$this->data['heading_title'] = $this->language->get('heading_title');

    	$this->data['text_new_customer'] = $this->language->get('text_new_customer');
    	$this->data['text_register'] = $this->language->get('text_register');
    	$this->data['text_register_account'] = $this->language->get('text_register_account');
		$this->data['text_returning_customer'] = $this->language->get('text_returning_customer');
		$this->data['text_i_am_returning_customer'] = $this->language->get('text_i_am_returning_customer');
    	$this->data['text_forgotten'] = $this->language->get('text_forgotten');

    	$this->data['entry_email'] = $this->language->get('entry_email');
    	$this->data['entry_password'] = $this->language->get('entry_password');

    	$this->data['button_continue'] = $this->language->get('button_continue');
		$this->data['button_login'] = $this->language->get('button_login');
		
		$this->data['bottom']=$this->language->get('bottom');
		$this->data['icp']=$this->language->get('icp');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
	
		$this->data['home'] = $this->url->link('common/home','','SSL');
		$this->data['login']=$this->url->link('account/login','','SSL');
		$this->data['register'] = $this->url->link('account/register','','SSL');
		$this->data['action'] = $this->url->link('account/login', '', 'SSL');
		$this->data['register'] = $this->url->link('account/register', '', 'SSL');
		$this->data['forgotten'] = $this->url->link('account/forgotten', '', 'SSL');

    	// Added strpos check to pass McAfee PCI compliance test (http://forum.opencart.com/viewtopic.php?f=10&t=12043&p=151494#p151295)
		if (isset($this->request->post['redirect']) && (strpos($this->request->post['redirect'], $this->config->get('config_url')) !== false || strpos($this->request->post['redirect'], $this->config->get('config_ssl')) !== false)) {
			$this->data['redirect'] = $this->request->post['redirect'];
		} elseif (isset($this->session->data['redirect'])) {
      		$this->data['redirect'] = $this->session->data['redirect'];
	  		
			unset($this->session->data['redirect']);		  	
    	} else {
			$this->data['redirect'] = '';
		}

		if (isset($this->session->data['success'])) {
    		$this->data['success'] = $this->session->data['success'];
    
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
		if (isset($this->request->post['email'])) {
			$this->data['email'] = $this->request->post['email'];
		} else {
			$this->data['email'] = '';
		}

		if (isset($this->request->post['password'])) {
			$this->data['password'] = $this->request->post['password'];
		} else {
			$this->data['password'] = '';
		}
		
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
		
				
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/login.html')) {
			$this->template = $this->config->get('config_template') . '/template/account/login.html';
		} else {
			$this->template = 'default/template/account/login.html';
		}
		
		
						
		$this->response->setOutput($this->render());
  	}
  
  	/* private function validate($username,$password) {
    	if (!$this->customer->login($username,$password)) {
      		$this->error['warning'] = $this->language->get('error_login');
    	}
	
		
        //$customer=isset($this->session->data['customer'])?$this->session->data['customer']:'';
		if(!empty($this->request->cookie['oc_customer'])){
		  $customer=$this->cookie->OCAuthCode($this->request->cookie['oc_customer'],'DECODE');
		  $customer=unserialize($customer);

		  if(!empty($customer['customer_id']) && !$customer['approved']){
		     $this->error['warning'] = $this->language->get('error_approved');
		  }
		}
		
    	if (!$this->error) {
      		return true;
    	} else {
      		return false;
    	}  	
  	} */
	
	/** 
	*登录AJAX验证
	*/
	public function ajaxLogin(){ //PUTLIC声明 才能用AJAX调用 ，http://test.cy0551.com/cy/index.php?route=account/login/ajaxLogin&username=&password=
	    $json=array();
		$username=$this->request->post['username'];
		$password=$this->request->post['password'];
	    if(!$this->customer->login($username,$password)) {
		    $json=array("key"=>"no");
	    }else{
		    $json=array('key'=>'ok');
		}
		$this->response->setOutput(json_encode($json));
	  
    }

}
?>