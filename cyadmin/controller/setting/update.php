<?php
class ControllerSettingUpdate extends Controller {
	private $error = array();
 
	public function index() {
	    $this->load->language('setting/update');
	    $this->data['heading_title']=$this->language->get('heading_title');
		$this->data['button_update']= $this->language->get('button_update');
		$this->data['button_refresh']= $this->language->get('button_refresh');
		$this->template = 'setting/update.html';
		
		$this->data['token']=$this->session->data['token'];
		$this->data['refresh']=$this->url->link('setting/update', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->response->setOutput($this->render());
	}
	
	public function option(){
	    $this->load->model('setting/update');
		$this->model_setting_update->updateOption();
		
		$this->response->setOutput('ok');
	}
	
	public function storeCategory(){
	    $this->load->model('setting/update');
		$this->model_setting_update->updateStoreCategory();
		
		$this->response->setOutput('ok');
	
	}
}

?>