<?php
class ControllerAccountForgotten extends Controller {
	private $error = array();

	public function index() {
		if ($this->customer->isLogged()) {
			$this->redirect($this->url->link('account/account', '', 'SSL'));
		}

		$this->language->load('account/forgotten');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('account/customer');
		
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') ) {//&& $this->validate()
			$this->language->load('mail/forgotten');
			
			$password = substr(sha1(uniqid(mt_rand(), true)), 0, 6);
			
			$this->model_account_customer->editPassword($password,$this->request->post['email']);
			
			$subject = sprintf($this->language->get('text_subject'), $this->config->get('config_name'));
			
			$message  = sprintf($this->language->get('text_greeting'), $this->config->get('config_name')) . "\n\n";
			$message .= $this->language->get('text_password') . "\n\n";
			$message .= $password;
            
			sendMail($subject,$this->request->post['email'],$message);
			
			
			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('account/login', '', 'SSL'));
		}

      
		
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_your_email'] = $this->language->get('text_your_email');
		$this->data['text_email'] = $this->language->get('text_email');

		$this->data['entry_email'] = $this->language->get('entry_email');

		$this->data['button_continue'] = $this->language->get('button_continue');
		$this->data['button_back'] = $this->language->get('button_back');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		$this->data['action'] = $this->url->link('account/forgotten', '', 'SSL');
 
		$this->data['back'] = $this->url->link('account/login', '', 'SSL');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/forgotten.html')) {
			$this->template = $this->config->get('config_template') . '/template/account/forgotten.html';
		} else {
			$this->template = 'default/template/account/forgotten.html';
		}
		
		$this->children = array(
			'common/footer',
			'common/header'	
		);
								
		$this->response->setOutput($this->render());		
	}

	/* private function validate() {
		if (!isset($this->request->post['email'])) {
			$this->error['warning'] = $this->language->get('error_email');
		} elseif (!$this->model_account_customer->getTotalCustomersByEmail($this->request->post['email'])) {
			$this->error['warning'] = $this->language->get('error_email');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	} */
}
?>