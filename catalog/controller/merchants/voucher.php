<?php 
	/**
	* 礼品券设置
	*/
class ControllerMerchantsVoucher extends Controller { 
	public function index() {
		
		
		
		$this->children = array(
			'merchants/left',
			'merchants/footer',
			'merchants/header'		
		);
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/merchants/merchants_voucher.html')) {
			$this->template = $this->config->get('config_template') . '/template/merchants/merchants_voucher.html';
		} else {
			$this->template = 'default/template/merchants/merchants_voucher.html';
		}
		

		
		
				
		$this->response->setOutput($this->render());
  	}
}
?>