<?php 
class ControllerAccountLeft extends Controller {

	public function index() {
	    
		$this->load->language('account/left');
		
		$this->data['text_account']=$this->language->get('text_account');
		$this->data['text_password']=$this->language->get('text_password');
		$this->data['text_edit']=$this->language->get('text_edit');
		$this->data['text_bought']=$this->language->get('text_bought');
		$this->data['text_boughtstore']=$this->language->get('text_boughtstore');
		$this->data['text_myshow']=$this->language->get('text_myshow');
		$this->data['text_issueshow']=$this->language->get('text_issueshow');
		$this->data['text_myorder']=$this->language->get('text_myorder');
		$this->data['text_exchange']=$this->language->get('text_exchange');
		$this->data['text_wishlist']=$this->language->get('text_wishlist');
		$this->data['text_address']=$this->language->get('text_address');
		$this->data['text_try']=$this->language->get('text_try');
		
		$this->data['edit'] = $this->url->link('account/edit', '', 'SSL');
    	$this->data['password'] = $this->url->link('account/password', '', 'SSL');
		$this->data['address'] = $this->url->link('account/address', '', 'SSL');
		$this->data['wishlist'] = $this->url->link('account/wishlist');
    	$this->data['order'] = $this->url->link('account/order', '', 'SSL');
    	$this->data['download'] = $this->url->link('account/download', '', 'SSL');
		$this->data['return'] = $this->url->link('account/return', '', 'SSL');
		$this->data['transaction'] = $this->url->link('account/transaction', '', 'SSL');
		//$this->data['newsletter'] = $this->url->link('account/newsletter', '', 'SSL');
		$this->data['myshow'] = $this->url->link('account/myshow','','SSL');
		$this->data['mytry'] = $this->url->link('account/mytry','','SSL');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/left.html')) {
			$this->template = $this->config->get('config_template') . '/template/account/left.html';
		} else {
			$this->template = 'default/template/account/left.html';
		}
		
		$this->response->setOutput($this->render());
  	}


}
?>