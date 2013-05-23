<?php 
class ControllerSettingPayment extends Controller {
	private $error = array(); 
    public function index(){
	    $this->load->model('setting/payment');
	    $this->getList();
	}
	
	private function getList(){
	    
	    $this->load->language('setting/payment');
		$this->data['heading_title'] = $this->language->get('heading_title');
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
		$this->data['entry_action'] = $this->language->get('entry_action');
		$this->data['entry_description'] = $this->language->get('entry_description');
		
		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_refresh'] = $this->language->get('button_refresh');
	    $this->data['button_delete'] = $this->language->get('button_delete');
		
		
		$this->data['insert'] = $this->url->link('setting/payment/insert', 'token=' . $this->session->data['token'] , 'SSL');
		$this->data['delete'] = $this->url->link('setting/payment/delete', 'token=' . $this->session->data['token'] , 'SSL');
		$this->data['refresh']=$this->url->link('setting/payment','token=' . $this->session->data['token'] , 'SSL');	
		
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 's.name';
		}
		
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		if(isset($this->request->get['filter_name'])){
		    $filter_name=$this->request->get['filter_name'];
		}else{
		    $filter_name='';
		}
		
		
		$this->data['payments']=array();
		
		$data = array(
		    'filter_name'=>$filter_name,
			'sort'  => $sort,
			'order' => $order,
			'status'=>'',
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);
		
		$url='';
		$this->data['storePayments']=array();
		
		$total = $this->model_setting_payment->getTotalStorePayments($data);
	
		$results = $this->model_setting_payment->getStorePayments($data);
        
    	foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('setting/payment/update', 'token=' . $this->session->data['token'] . '&id=' . $result['id'] . $url, 'SSL')
			);
						
			$this->data['storePayments'][] = array(
				'id'                 => $result['id'],
				'storename'          => $result['name'],
				'store_id'           => $result['store_id'],
				'payment_code'       => $result['payment_code'],
				'trade_type'         => $result['trade_type'],
				'partner'            => $result['partner'],
				'security_code'      => $result['security_code'],
				'seller_email'       => $result['seller_email'],
				'description'        => $result['description'],
				'status'             => $result['status'],
				'selected'           => isset($this->request->post['selected']) && in_array($result['attribute_group_id'], $this->request->post['selected']),
				'action'             => $action
			);
		}	
		$results=null;
		
		
		
		$pagination = new Pagination('results','links');
		$pagination->total = $total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('setting/payment', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();
		
		
	    $this->template = 'setting/payment_list.html';
		
		
		$this->response->setOutput($this->render());
	}
	
	public function update(){
	    $this->load->language('setting/payment');
	    $this->load->model('setting/payment');
        $id=$this->request->get['id'];
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validateForm())) {
			if(!empty($id)){
				$this->model_setting_payment->editStorePayment($id,$this->request->post);				
				
				$this->session->data['success'] = $this->language->get('text_success');

				$this->redirect( HTTPS_SERVER . 'index.php?route=setting/payment&token=' . $this->session->data['token']);
			}
		}
		
	    $this->getForm();
	}
	
	public function delete(){
	    $this->load->language('setting/payment');
	    $this->load->model('setting/payment');
        if (isset($this->request->post['selected'])) {
			foreach ($this->request->post['selected'] as $id) {
				$this->model_setting_payment->deleteStorePayment($id);			
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect( HTTPS_SERVER . 'index.php?route=setting/payment&token=' . $this->session->data['token']);
		}
		
		$this->getList();
	}
	
	public function insert(){
        $this->load->language('setting/payment');
		$this->load->model('setting/payment');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_setting_payment->addStorePayment($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect( HTTPS_SERVER . 'index.php?route=setting/payment&token=' . $this->session->data['token']);
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
		
		$this->load->model('setting/payment_bank');
		
	    $this->data['payment_bank']=$this->model_setting_payment_bank->getPaymentBanks();
		
		
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		
		$this->data['entry_seller_email'] = $this->language->get('entry_seller_email');
		$this->data['entry_security_code'] = $this->language->get('entry_security_code');
		$this->data['entry_partner'] = $this->language->get('entry_partner');
		$this->data['entry_trade_type'] = $this->language->get('entry_trade_type');
		$this->data['entry_anti_phishing'] = $this->language->get('entry_anti_phishing');
		$this->data['entry_order_status'] = $this->language->get('entry_order_status');	
		$this->data['entry_description'] = $this->language->get('entry_description');	
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_store'] = $this->language->get('entry_store');
		$this->data['entry_code'] = $this->language->get('entry_code');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');

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


		if (!isset($this->request->get['id'])) {
			$this->data['action'] = $this->url->link('setting/payment/insert', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$this->data['action'] = $this->url->link('setting/payment/update', 'token=' . $this->session->data['token'] . '&id=' . $this->request->get['id'], 'SSL');
		}
		
		$id=!empty($this->request->get['id'])?$this->request->get['id']:'';
		if(!empty($id)){
		    $paymentInfo=$this->model_setting_payment->getStorePayment($id);
		
		}
		
		$this->data['cancel'] =  HTTPS_SERVER . 'index.php?route=setting/payment&token=' . $this->session->data['token'];
		
		
		$this->data['payment_code']=isset($paymentInfo['payment_code'])?$paymentInfo['payment_code']:'alipay';
		$this->data['store_id']=isset($paymentInfo['store_id'])?$paymentInfo['store_id']:'';
		if (isset($this->request->post['alipay_seller_email'])) {
			$this->data['alipay_seller_email'] = $this->request->post['alipay_seller_email'];
		} else {
			$this->data['alipay_seller_email'] = isset($paymentInfo['seller_email'])?$paymentInfo['seller_email']:'';
		}

		if (isset($this->request->post['alipay_security_code'])) {
			$this->data['alipay_security_code'] = $this->request->post['alipay_security_code'];
		} else {
			$this->data['alipay_security_code'] = isset($paymentInfo['security_code'])?$paymentInfo['security_code']:'';
		}

		if (isset($this->request->post['alipay_partner'])) {
			$this->data['alipay_partner'] = $this->request->post['alipay_partner'];
		} else {
			$this->data['alipay_partner'] = isset($paymentInfo['partner'])?$paymentInfo['partner']:'';
		}		
		
		

		if (isset($this->request->post['alipay_trade_type'])) {
			$this->data['alipay_trade_type'] = $this->request->post['alipay_trade_type'];
		} else {
			$this->data['alipay_trade_type'] = isset($paymentInfo['trade_type'])?$paymentInfo['trade_type']:'';
		}
		
	/*	if (isset($this->request->post['alipay_anti_phishing'])) {
			$this->data['alipay_anti_phishing'] = $this->request->post['alipay_anti_phishing'];
		} else {
			$this->data['alipay_anti_phishing'] = $this->config->get('alipay_anti_phishing');
		}
		*/
		if (isset($this->request->post['alipay_order_status_id'])) {
			$this->data['alipay_order_status_id'] = $this->request->post['alipay_order_status_id'];
		} else {
			$this->data['alipay_order_status_id'] = isset($paymentInfo['order_status_id'])?$paymentInfo['order_status_id']:'';
		} 

		$this->load->model('localisation/order_status');
		
		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
			
		if (isset($this->request->post['description'])) {
			$this->data['description'] = $this->request->post['description'];
		} else {
			$this->data['description'] = isset($paymentInfo['description'])?$paymentInfo['description']:'';
		}
		
		if (isset($this->request->post['alipay_status'])) {
			$this->data['alipay_status'] = $this->request->post['alipay_status'];
		} else {
			$this->data['alipay_status'] = isset($paymentInfo['status'])?$paymentInfo['status']:'';
		}
		
		if (isset($this->request->post['alipay_sort_order'])) {
			$this->data['alipay_sort_order'] = $this->request->post['alipay_sort_order'];
		} else {
			$this->data['alipay_sort_order'] =isset($paymentInfo['sort_order'])?$paymentInfo['sort_order']:'';
		}
		
		$this->load->model('setting/store');
		$data=array('status'=>1);
		$stores=$this->model_setting_store->getStores($data);
		
		$this->data['stores']=$stores;
		
		$this->template = 'setting/payment_form.html';
		
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}


	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'setting/payment')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (isset($this->request->post['alipay_seller_email']) && !$this->request->post['alipay_seller_email']) {
			$this->error['email'] = $this->language->get('error_email');
		}

		if (isset($this->request->post['alipay_security_code']) && !$this->request->post['alipay_security_code']) {
			$this->error['secrity_code'] = $this->language->get('error_secrity_code');
		}

		if (isset($this->request->post['alipay_partner']) && !$this->request->post['alipay_partner']) {
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