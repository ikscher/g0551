<?php 
class ControllerAccountAddress extends Controller {
	private $error = array();
	  
  	public function index() {
    	if (!$this->customer->isLogged()) {
	  		$this->session->data['redirect'] = $this->url->link('account/address', '', 'SSL');

	  		$this->redirect($this->url->link('account/login', '', 'SSL')); 
			$this->data['username']='';
    	}else{
		    //登录的用户名
		
		    // $customer=isset($this->session->data['customer'])?$this->session->data['customer']:'';
			if(isset($this->request->cookie['oc_customer'])){
				$customer=$this->cookie->OCAuthCode($this->request->cookie['oc_customer'],'DECODE');
				$customer=unserialize($customer);
				
				$this->data['username']=$customer['email'];
			}else{
			    $this->redirect($this->url->link('account/login', '', 'SSL')); 
			}
		}
		
		
	
    	$this->language->load('account/address');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('account/address');
		
		$this->getList();
  	}
    
	/**
	*  新增地址
	*/
  	public function insert() {
    	if (!$this->customer->isLogged()) {
	  		$this->session->data['redirect'] = $this->url->link('account/address', '', 'SSL');

	  		$this->redirect($this->url->link('account/login', '', 'SSL')); 
    	} 

    	$this->language->load('account/address');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('account/address');
			
    	
		$result=$this->model_account_address->addAddress($this->request->post);
		
		$this->response->setOutPut(json_encode($result));
		//echo $result;
		
		//$this->session->data['success'] = $this->language->get('text_insert');

		//$this->redirect($this->url->link('account/address', '', 'SSL'));
    	
	  	
		
  	}
    
	/**
	* 编辑地址
	*/
  	public function update() {
    	if (!$this->customer->isLogged()) {
	  		$this->session->data['redirect'] = $this->url->link('account/address', '', 'SSL');

	  		$this->redirect($this->url->link('account/login', '', 'SSL')); 
    	} 
		
    	$this->language->load('account/address');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('account/address');
		
    	
		$result=$this->model_account_address->editAddress($this->request->post);
		$this->response->setOutPut(json_encode($result));
		//echo $result;
		
		/* // Default Shipping Address
		if (isset($this->session->data['shipping_address_id']) && ($this->request->get['address_id'] == $this->session->data['shipping_address_id'])) {
			$this->session->data['shipping_country_id'] = $this->request->post['country_id'];
			$this->session->data['shipping_zone_id'] = $this->request->post['zone_id'];
			$this->session->data['shipping_postcode'] = $this->request->post['postcode'];
			
			unset($this->session->data['shipping_method']);	
			unset($this->session->data['shipping_methods']);
		}
		
		// Default Payment Address
		if (isset($this->session->data['payment_address_id']) && ($this->request->get['address_id'] == $this->session->data['payment_address_id'])) {
			$this->session->data['payment_country_id'] = $this->request->post['country_id'];
			$this->session->data['payment_zone_id'] = $this->request->post['zone_id'];
			
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
		} */
		
		//$this->session->data['success'] = $this->language->get('text_update');
  
		//$this->redirect($this->url->link('account/address', '', 'SSL'));
 
  	}
    
	/**
	* 删除指定的收货地址
	*/
  	public function delete() {
    	if (!$this->customer->isLogged()) {
	  		$this->session->data['redirect'] = $this->url->link('account/address', '', 'SSL');

	  		$this->redirect($this->url->link('account/login', '', 'SSL')); 
    	} 
			
    	$this->language->load('account/address');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('account/address');
		
		if ($this->model_account_address->getTotalAddresses() == 1) {
		    echo 2;exit;
	    }
		
	    $dataid=$this->request->post['dataid'];
	    //if(!empty($data)){
	   //    $x=explode("|",$data);
		//   $address_id=$x[0];
	    //}
    	if (isset($dataid)) {
			$result=$this->model_account_address->deleteAddress($dataid);	
			echo $result;exit;
			/* // Default Shipping Address
			if (isset($this->session->data['shipping_address_id']) && ($this->request->get['address_id'] == $this->session->data['shipping_address_id'])) {
				unset($this->session->data['shipping_address_id']);
				unset($this->session->data['shipping_country_id']);
				unset($this->session->data['shipping_zone_id']);
				unset($this->session->data['shipping_postcode']);				
				unset($this->session->data['shipping_method']);
				unset($this->session->data['shipping_methods']);
			}
			
			// Default Payment Address
			if (isset($this->session->data['payment_address_id']) && ($this->request->get['address_id'] == $this->session->data['payment_address_id'])) {
				unset($this->session->data['payment_address_id']);
				unset($this->session->data['payment_country_id']);
				unset($this->session->data['payment_zone_id']);				
				unset($this->session->data['payment_method']);
				unset($this->session->data['payment_methods']);
			} */
			
			//$this->session->data['success'] = $this->language->get('text_delete');
	  
	  		//$this->redirect($this->url->link('account/address', '', 'SSL'));
    	}
	
		//$this->getList();	
  	}

  	private function getList() {

    	$this->data['addresses'] = array();
		
		$results = $this->model_account_address->getAddresses();
    
    	foreach ($results as $result) {


      		$this->data['addresses'][] = array(
        		'address_id' => $result['address_id'],
				'customer_id'=> $result['customer_id'],
				'username'   => $result['username'],
				'telphone'  => $result['telphone'],
				'mobile'     => $result['mobile'],
				'company'    => $result['company'],
				'address'    => $result['address'],
				'postcode'   => $result['postcode'],
				'status'     => $result['status'],
        		'update'     => $this->url->link('account/address/update', 'address_id=' . $result['address_id'], 'SSL'),
				'delete'     => $this->url->link('account/address/delete', 'address_id=' . $result['address_id'], 'SSL')
      		);
    	}
        
        
		$this->data['home'] = $this->url->link('common/home', '', 'SSL');
    	$this->data['insert'] = $this->url->link('account/address/insert', '', 'SSL');
		$this->data['back'] = $this->url->link('account/account', '', 'SSL');
		$this->data['logout']=$this->url->link('account/logout','','SSL');
				
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/address_list.html')) {
			$this->template = $this->config->get('config_template') . '/template/account/address_list.html';
		} else {
			$this->template = 'default/template/account/address_list.html';
		}
		
		$this->children = array(
			'account/left',
			'account/footer',
			'account/header'		
		);
						
		$this->response->setOutput($this->render());		
  	}

  	
  

  	private function validateDelete() {
    	if ($this->model_account_address->getTotalAddresses() == 1) {
      		$this->error['warning'] = $this->language->get('error_delete');
    	}

    	if ($this->customer->getAddressId() == $this->request->get['address_id']) {
      		$this->error['warning'] = $this->language->get('error_default');
    	}

    	if (!$this->error) {
      		return true;
    	} else {
      		return false;
    	}
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
	
	/**
	*  设置默认地址
	*/
	
	public function setDefault(){
	   $address_id=$this->request->post['dataid'];
	  
	   
	   $this->load->model("account/address");
	   
	   $result=$this->model_account_address->setDefaultAddress($address_id);
	   
	   echo $result;
     
	}
	
	/**
	*   取唯一地址信息
	*/
	public function getAddress(){
	   $address_id=$this->request->post['dataid'];
	  // if(!empty($data)){
	   //   $x=explode("|",$data);
		//  $address_id=$x[0];
		//  $customer_id=$x[1];
	   //}
	   
	   $this->load->model("account/address");
	   
	   $result=$this->model_account_address->getAddress($address_id);
	   
	   
	   $this->response->setOutPut(json_encode($result));

	}
}
?>