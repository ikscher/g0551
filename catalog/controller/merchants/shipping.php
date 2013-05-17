<?php 
	/**
	* 货运配送方式管理
	*/
class ControllerMerchantsShipping extends Controller { 
	//身份验证
	private function check_customer(){
		if (!$this->customer->isLogged()) {
	  		$this->session->data['redirect'] = $this->url->link('merchants/merchants', '', 'SSL');
	  		$this->redirect($this->url->link('account/login', '', 'SSL')); 
    	} 

		
	}
	
	public function index() {
		$this->check_customer();
		
		$this->load->model('merchants/shipping');
		
		$store_id=$this->cookie->OCAuthCode($this->request->cookie['storeid'],'DECODE');
		if(empty($store_id)){
			$this->showMessage("您还未登陆");
		}
		
		$page=isset($this->request->get['page'])?$this->request->get['page']:1;
		$data=array();
		$limit=5;
		$data=array(
		        'store_id'=>$store_id,
		        'status'=>1,
		        'start'=>($page-1)*$limit,
				'limit'=>$limit
			);
		
		$shippings=$this->model_merchants_shipping->getStoreShippings($data);
		$total=$this->model_merchants_shipping->getTotalStoreShippings($data);
		
		$this->data['shippings']=$shippings;
	
		
		$pagination = new Pagination('results','links');
		$pagination->total = $total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('merchants/shipping', 'page={page}', 'SSL');
		
		$this->data['pagination'] = $pagination->render();
		
		$this->children = array(
			'merchants/left',
			'merchants/footer',
			'merchants/header'		
		);
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/merchants/merchants_shipping.html')) {
			$this->template = $this->config->get('config_template') . '/template/merchants/merchants_shipping.html';
		} else {
			$this->template = 'default/template/merchants/merchants_shipping.html';
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
	    //$this->load->language('merchants/shipping');
	    $this->load->model('merchants/shipping');
        
		$shipping_id=$this->request->get['shipping_id'];
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
		    
			if(!empty($shipping_id)){
				if($this->model_merchants_payment->editStoreShipping($shipping_id,$this->request->post)){
                    $this->redirect($this->url->link('merchants/shipping/update', '','SSL'));
				}
			}
		}
		
	    $this->getForm($shipping_id);
	}
	
	
	public function insert(){
        //$this->load->language('merchants/payment');
		$this->load->model('merchants/shipping');
        
		
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if($this->model_merchants_shipping->addStoreShipping($this->request->post)){
				$this->redirect($this->url->link('merchants/shipping/insert','','SSL'));
			}
		}
		
	    $this->getForm();
	}
	
	
	
	public function getForm($shipping_id='') {
	
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

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
 		if (isset($this->error['email'])) {
			$this->data['error_email'] = $this->error['email'];
		} else {
			$this->data['error_email'] = '';
		}
        
		$shipping_info=array();
		if (empty($shipping_id)) {
			$this->data['action'] = $this->url->link('merchants/shipping/insert', '', 'SSL');
			$this->data['heading_title'] = '新增';//$this->language->get('heading_title');
		} else {
			$this->data['action'] = $this->url->link('merchants/shipping/update','&shipping_id=' . $shipping_id, 'SSL');
			$this->data['heading_title'] = '修改';
			$shipping_info=$this->model_merchants_shipping->getStoreShipping($shipping_id);
		}
        $this->data['shipping_info']=$shipping_info;
		
		$this->children = array(
			'merchants/left',
			'merchants/footer',
			'merchants/header'		
		);
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/merchants/merchants_shipping_form.html')) {
			$this->template = $this->config->get('config_template') . '/template/merchants/merchants_shipping_form.html';
		} else {
			$this->template = 'default/template/merchants/merchants_shipping_form.html';
		}
		
		$this->response->setOutput($this->render());
	}
	
	
	private function validateForm() {
	
		if (!$this->request->post['seller_email']) {
			$this->error['email'] = $this->language->get('error_email');
		}

		if (!$this->request->post['security_code']) {
			$this->error['secrity_code'] = $this->language->get('error_secrity_code');
		}

		if (!$this->request->post['partner']) {
			$this->error['partner'] = $this->language->get('error_partner');
		}

		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	} 

	
}
?>