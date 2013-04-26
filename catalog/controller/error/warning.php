<?php   
class ControllerErrorWarning extends Controller {

	
	public  static function  OcMessage($message,$url='',$type='',$time=3){
	    if(!$type) $type='04';

		
		$time = $time * 1000;

		if(!empty($url)) {
			$message .= "<p align='center'><input type=\"button\" class=\"pass_btn\" onclick=\"javascript:location.href='".$url."'\" value=\"确 定\" /></p>";
		}else{
			$message .= "<p align='center'><input type=\"button\" class=\"pass_btn\" onclick=\"history.back()\" value=\"确 定\" /></p>";
		}

		if($time) {
			$message .= "<script>".
				"function redirect() {window.location.href='{$url}';}\n".
				"setTimeout('redirect();', $time);\n".
				"</script>";
		}
		
        $this->data['message'] = $message;
		$this->data['type']    = $type;
		
		//$this->data['button_continue'] = $this->language->get('button_continue');
		
		//$this->data['continue'] = $this->url->link('common/home');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/warning.html')) {
			$this->template = $this->config->get('config_template') . '/template/error/warning.html';
		} else {
			$this->template = 'default/template/error/warning.html';
		}
		
		$this->children = array(
			'common/footer',
			'common/header'
		);
		
		$this->response->setOutput($this->render());
	
	}
}
?>