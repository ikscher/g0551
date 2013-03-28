<?php
	class ControllerStoreFooter extends Controller{
	protected function index() {

		
	
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/store/footer.html')) {
			$this->template = $this->config->get('config_template') . '/template/store/footer.html';
		} else {
			$this->template = 'default/template/store/footer.html';
		}

		$this->render();
					
		}
	
	}
?>