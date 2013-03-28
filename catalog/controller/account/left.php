<?php 
class ControllerAccountLeft extends Controller {

	public function index() {
	   
		
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
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/left.html')) {
			$this->template = $this->config->get('config_template') . '/template/account/left.html';
		} else {
			$this->template = 'default/template/account/left.html';
		}
		
		$this->response->setOutput($this->render());
  	}


}
?>