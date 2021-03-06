<?php 
	/**
	* 支付方式管理
	*/
class ControllerMerchantsPayment extends Controller { 
    private $error=array();
	//身份验证
	private function check_customer(){
		if (!$this->customer->isLogged()) {
	  		$this->session->data['redirect'] = $this->url->link('merchants/merchants', '', 'SSL');
	  		$this->redirect($this->url->link('account/login', '', 'SSL')); 
    	} 

		/* $store_id=$this->cookie->OCAuthCode($this->request->cookie['storeid'],'DECODE');
		if(empty($store_id)){
			$this->showMessage("您还没有开店，或登录已超时，请重新登录！");
		} */
	}
	
	public function index() {
		$this->check_customer();
		
		$this->load->model('merchants/payment');
		
		$payments=$this->model_merchants_payment->getEnabledPayments();
		
		$this->data['payments']=$payments;
		
		$this->children = array(
			'merchants/left',
			'merchants/footer',
			'merchants/header'		
		);
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/merchants/merchants_payment.html')) {
			$this->template = $this->config->get('config_template') . '/template/merchants/merchants_payment.html';
		} else {
			$this->template = 'default/template/merchants/merchants_payment.html';
		}
		
		$this->response->setOutput($this->render());
  	}
	
	//删除
	public function deleteStorePayment(){
	    $id=$this->request->post['id'];
		$this->load->model('merchants/payment');
		
		if(empty($id)) exit('no');
		
		if($this->model_merchants_payment->deleteStorePayment($id)){
		    exit('ok');//equal  echo 1;exit;
		}else{
		    exit('no');
		}
	
	}
	
	public function update(){
	    $this->load->language('merchants/payment');
	    $this->load->model('merchants/payment');
        
		if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validateForm()) {
		    $id=$this->request->post['id'];
			if(!empty($id)){
				if($this->model_merchants_payment->editStorePayment($id,$this->request->post)){
                    exit('yes');
                }else{
				    exit('no');
				}
			}
		}
		
	    $this->getForm();
	}
	
	
	public function insert(){
        $this->load->language('merchants/payment');
		$this->load->model('merchants/payment');
        
		
		if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validateForm() ) {
		    
			if($this->model_merchants_payment->addStorePayment($this->request->post)){
				exit('yes');
			}
		}
		
	    $this->getForm();
	}
	
	
	
	public function getForm() {
	
		$this->document->settitle($this->language->get('heading_title'));
		
		if (isset($this->error['secrity_code'])) {
			$this->data['error_secrity_code'] = $this->error['secrity_code'];
		} else {
			$this->data['error_secrity_code'] = '';
		}

		if (isset($this->error['email'])) {
			$this->data['error_email'] = $this->error['email'];
		} else {
			$this->data['error_email'] = '';
		}

		if (isset($this->error['partner'])) {
			$this->data['error_partner'] = $this->error['partner'];
		} else {
			$this->data['error_partner'] = '';
		}
		
		if (isset($this->error['description'])) {
			$this->data['error_description'] = $this->error['description'];
		} else {
			$this->data['error_description'] = '';
		}
		
		
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		
	    $this->data['payment_bank']=$this->model_merchants_payment->getPaymentBanks();
		
		
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		
		$this->data['entry_seller_email'] = $this->language->get('entry_seller_email');
		$this->data['entry_security_code'] = $this->language->get('entry_security_code');
		$this->data['entry_partner'] = $this->language->get('entry_partner');
		$this->data['entry_trade_type'] = $this->language->get('entry_trade_type');
		$this->data['entry_anti_phishing'] = $this->language->get('entry_anti_phishing');
		$this->data['entry_order_status'] = $this->language->get('entry_order_status');	
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_store'] = $this->language->get('entry_store');
		$this->data['entry_code'] = $this->language->get('entry_code');
		$this->data['entry_description'] = $this->language->get('entry_description');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');

 		

        $code=isset($this->request->get['code'])?$this->request->get['code']:'';
		$this->data['code']=$code;
		
		if (!isset($this->request->get['id'])) {
			$this->data['action'] = $this->url->link('setting/payment/insert', '', 'SSL');
			
		} else {
			$this->data['action'] = $this->url->link('setting/payment/update','&id=' . $this->request->get['id'], 'SSL');
			
		}
		
		$id=!empty($this->request->get['id'])?$this->request->get['id']:'';
		$this->data['id']=$id;
		if(!empty($id)){
		    $paymentInfo=$this->model_merchants_payment->getStorePayment($id);
		
		}
		
		// $this->data['cancel'] =  HTTPS_SERVER . 'index.php?route=setting/payment';
		
		
		$this->data['payment_code']=isset($paymentInfo['payment_code'])?$paymentInfo['payment_code']:$code;
		//$this->data['store_id']=isset($paymentInfo['store_id'])?$paymentInfo['store_id']:'';
		if (isset($this->request->post['seller_email'])) {
			$this->data['seller_email'] = $this->request->post['seller_email'];
		} else {
			$this->data['seller_email'] = isset($paymentInfo['seller_email'])?$paymentInfo['seller_email']:'';
		}

		if (isset($this->request->post['security_code'])) {
			$this->data['security_code'] = $this->request->post['security_code'];
		} else {
			$this->data['security_code'] = isset($paymentInfo['security_code'])?$paymentInfo['security_code']:'';
		}

		if (isset($this->request->post['partner'])) {
			$this->data['partner'] = $this->request->post['partner'];
		} else {
			$this->data['partner'] = isset($paymentInfo['partner'])?$paymentInfo['partner']:'';
		}		

		if (isset($this->request->post['trade_type'])) {
			$this->data['trade_type'] = $this->request->post['trade_type'];
		} else {
			$this->data['trade_type'] = isset($paymentInfo['trade_type'])?$paymentInfo['trade_type']:'';
		}
		
		if (isset($this->request->post['description'])) {
			$this->data['description'] = $this->request->post['description'];
		} else {
			$this->data['description'] = isset($paymentInfo['description'])?$paymentInfo['description']:'';
		}
		
	/*	if (isset($this->request->post['alipay_anti_phishing'])) {
			$this->data['alipay_anti_phishing'] = $this->request->post['alipay_anti_phishing'];
		} else {
			$this->data['alipay_anti_phishing'] = $this->config->get('alipay_anti_phishing');
		}
		*/
		if (isset($this->request->post['order_status_id'])) {
			$this->data['order_status_id'] = $this->request->post['order_status_id'];
		} else {
			$this->data['order_status_id'] = isset($paymentInfo['order_status_id'])?$paymentInfo['order_status_id']:'';
		} 

	
		$this->data['order_statuses'] = $this->model_merchants_payment->getOrderStatuses();
			
		
		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} else {
			$this->data['status'] = isset($paymentInfo['status'])?$paymentInfo['status']:'';
		}
		
		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} else {
			$this->data['sort_order'] =isset($paymentInfo['sort_order'])?$paymentInfo['sort_order']:'';
		}
		
		
		
		
		$this->children = array(
			'merchants/left',
			'merchants/footer',
			'merchants/header'		
		);
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/merchants/merchants_payment_form.html')) {
			$this->template = $this->config->get('config_template') . '/template/merchants/merchants_payment_form.html';
		} else {
			$this->template = 'default/template/merchants/merchants_payment_form.html';
		}
		
		$this->response->setOutput($this->render());
	}
	
	
	private function validateForm() {
	
		if (isset($this->request->post['seller_email'])) {
			!$this->request->post['seller_email'] &&  $this->error['email'] = $this->language->get('error_email');
		}

		if (isset($this->request->post['security_code'])) {
			!$this->request->post['security_code'] &&  $this->error['secrity_code'] = $this->language->get('error_secrity_code');
		}

		if (isset($this->request->post['partner'])) {
			!$this->request->post['partner'] &&  $this->error['partner'] = $this->language->get('error_partner');
		}
		
		if (isset($this->request->post['description'])) {
			!$this->request->post['description'] && $this->error['description'] = $this->language->get('error_description');
		}
		
		
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}

	
}
?>