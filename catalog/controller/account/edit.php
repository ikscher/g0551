<?php
class ControllerAccountEdit extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('account/edit');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('account/customer');
		
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$this->model_account_customer->editCustomer($this->request->post);
			
		    $this->data['success'] = $this->language->get('text_success');

			//$this->redirect($this->url->link('account/account', '', 'SSL'));
		}

        $this->data['home'] = $this->url->link('common/home', '', 'SSL');
		$this->data['button_continue'] = $this->language->get('button_continue');
		$this->data['button_back'] = $this->language->get('button_back');


		$this->data['action'] = $this->url->link('account/edit', '', 'SSL');

		if ($this->request->server['REQUEST_METHOD'] != 'POST') {
			$customer_info = $this->model_account_customer->getCustomer($this->customer->getId());
		}

        if (isset($this->request->post['username'])) {
			$this->data['username'] = $this->request->post['username'];
		} elseif (isset($customer_info)) {
			$this->data['username'] = $customer_info['username'];
		} else {
			$this->data['username'] = '';
		}
		
		if (isset($this->request->post['nickname'])) {
			$this->data['nickname'] = $this->request->post['nickname'];
		} elseif (isset($customer_info)) {
			$this->data['nickname'] = $customer_info['nickname'];
		} else {
			$this->data['nickname'] = '';
		}
		
		
		/* if (isset($this->request->post['address'])) {
			$this->data['address'] = $this->request->post['address'];
		} elseif (isset($customer_info)) {
			$this->data['address'] = $customer_info['address'];
		} else {
			$this->data['address'] = '';
		} */
		
		
		
		if (isset($this->request->post['mobile'])) {
			$this->data['mobile'] = $this->request->post['mobile'];
		} elseif (isset($customer_info)) {
			$this->data['mobile'] = $customer_info['mobile'];
		} else {
			$this->data['mobile'] = '';
		}

		if (isset($this->request->post['email'])) {
			$this->data['email'] = $this->request->post['email'];
		} elseif (isset($customer_info)) {
			$this->data['email'] = $customer_info['email'];
		} else {
			$this->data['email'] = '';
		}

		if (isset($this->request->post['telephone'])) {
			$this->data['telephone'] = $this->request->post['telephone'];
		} elseif (isset($customer_info)) {
			$this->data['telephone'] = $customer_info['telephone'];
		} else {
			$this->data['telephone'] = '';
		}

		/* if (isset($this->request->post['postcode'])) {
			$this->data['postcode'] = $this->request->post['postcode'];
		} elseif (isset($customer_info)) {
			$this->data['postcode'] = $customer_info['postcode'];
		} else {
			$this->data['postcode'] = '';
		} */
		
		
		
		
		$this->data['logout'] =$this->url->link('account/logout','','SSL');

		$this->data['back'] = $this->url->link('account/account', '', 'SSL');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/edit.html')) {
			$this->template = $this->config->get('config_template') . '/template/account/edit.html';
		} else {
			$this->template = 'default/template/account/edit.html';
		}
		$this->children = array(
		    'account/header',
			'account/left',
			'account/footer',	
		);
	
						
		$this->response->setOutput($this->render());	
	}

	private function validate() {
		/* if ((utf8_strlen($this->request->post['firstname']) < 1) || (utf8_strlen($this->request->post['firstname']) > 32)) {
			$this->error['firstname'] = $this->language->get('error_firstname');
		}

		if ((utf8_strlen($this->request->post['lastname']) < 1) || (utf8_strlen($this->request->post['lastname']) > 32)) {
			$this->error['lastname'] = $this->language->get('error_lastname');
		}

		if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
			$this->error['email'] = $this->language->get('error_email');
		}
		
		if (($this->customer->getEmail() != $this->request->post['email']) && $this->model_account_customer->getTotalCustomersByEmail($this->request->post['email'])) {
			$this->error['warning'] = $this->language->get('error_exists');
		}

		if ((utf8_strlen($this->request->post['telephone']) < 3) || (utf8_strlen($this->request->post['telephone']) > 32)) {
			$this->error['telephone'] = $this->language->get('error_telephone');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		} */
	}
}
?>