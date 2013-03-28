<?php
class ControllerCommonBrand extends Controller {
	protected function index() {
		

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/brand.html')) {
			$this->template = $this->config->get('config_template') . '/template/common/brand.html';
		} else {
			$this->template = 'default/template/common/brand.html';
		}

		$this->render();
	}
}
?>