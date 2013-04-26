<?php 
class ControllerModuleLeft extends Controller {

	public function index() {
	
		
		$this->data['text_manual'] = $this->language->get('text_manual');
		$this->data['text_register'] = $this->language->get('text_register');
		$this->data['text_shoppingProcess'] = $this->language->get('text_shoppingProcess');
		$this->data['text_shoppingMethod'] = $this->language->get('text_shoppingMethod');
		$this->data['text_diy'] = $this->language->get('text_diy');
		$this->data['text_transport'] = $this->language->get('text_transport');
		$this->data['text_arrivedIntime'] = $this->language->get('text_arrivedIntime');
		$this->data['text_payMethod'] = $this->language->get('text_payMethod');
		$this->data['text_payment'] = $this->language->get('text_payment');
		$this->data['text_onlinePay'] = $this->language->get('text_onlinePay');
		$this->data['text_installments'] = $this->language->get('text_installments');
		$this->data['text_support'] = $this->language->get('text_support');
		$this->data['text_exchange'] = $this->language->get('text_exchange');
		$this->data['text_warrant'] = $this->language->get('text_warrant');
		$this->data['text_help'] = $this->language->get('text_help');
		$this->data['text_forgotten'] = $this->language->get('text_forgotten');
		$this->data['text_faq'] = $this->language->get('text_faq');
		$this->data['text_feedback'] = $this->language->get('text_feedback');
		$this->data['text_contact'] = $this->language->get('text_contact');
		$this->data['text_aboutus'] = $this->language->get('text_aboutus');
		$this->data['text_company'] = $this->language->get('text_company');
		$this->data['text_imageUpload'] = $this->language->get('text_imageUpload');
		
		$this->data['telphone']=$this->language->get('telphone');
		$this->data['address']=$this->language->get('address');
		$this->data['icp']=$this->language->get('icp');
		$this->data['bottom']=$this->language->get('bottom');
        
		
		$this->data['register'] = $this->url->link('account/register', '', 'SSL');
		$this->data['shoppingProcess'] = $this->url->link('module/general/shoppingProcess', '', 'SSL');
		$this->data['diy'] = $this->url->link('module/general/diy', '', 'SSL');
		$this->data['transport'] = $this->url->link('module/general/transport', '', 'SSL');
		$this->data['arrivedIntime'] = $this->url->link('module/general/arrivedIntime', '', 'SSL');
		$this->data['payment'] = $this->url->link('module/general/payment', '', 'SSL');
		$this->data['onlinePay'] = $this->url->link('module/general/onlinePay', '', 'SSL');
		$this->data['installments'] = $this->url->link('module/general/installments', '', 'SSL');
		$this->data['exchange'] = $this->url->link('module/general/exchange', '', 'SSL');
		$this->data['warrant'] = $this->url->link('module/general/warrant', '', 'SSL');
		$this->data['forgotten'] = $this->url->link('account/forgotten', '', 'SSL');
		$this->data['faq'] = $this->url->link('module/general/faq', '', 'SSL');
		$this->data['feedback'] = $this->url->link('module/general/feedback', '', 'SSL');
		$this->data['contact'] = $this->url->link('module/general/contact', '', 'SSL');
		$this->data['company'] = $this->url->link('module/general/company', '', 'SSL');
		$this->data['imageUpload'] = $this->url->link('module/general/imageUpload', '', 'SSL');


		//$this->data['powered'] = sprintf($this->language->get('text_powered'), $this->config->get('config_name'), date('Y', time()));

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/general/left.html')) {
			$this->template = $this->config->get('config_template') . '/template/module/general/left.html';
		} else {
			$this->template = 'default/template/module/general/left.html';
		}

		$this->render();
	}

}
?>