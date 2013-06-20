<?php 
class ControllerTryFooter extends Controller { 
	public function index() {
		   	
		$this->data['telphone']=$this->language->get('telphone');
		$this->data['address']=$this->language->get('address');
		$this->data['icp']=$this->language->get('icp');
		$this->data['bottom']=$this->language->get('bottom');
        
		
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/try/footer.html')) {
			$this->template = $this->config->get('config_template') . '/template/try/footer.html';
		} else {
			$this->template = 'default/template/try/footer.html';
		}
		
				
		$this->response->setOutput($this->render());
 
	
    }
	
	
}
?>