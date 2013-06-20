<?php 
class ControllerAccountReturn extends Controller { 
	private $error = array();
	
	public function index() {
    	if (!$this->customer->isLogged()) {
      		$this->session->data['redirect'] = $this->url->link('account/return', '', 'SSL');

	  		$this->redirect($this->url->link('account/login', '', 'SSL'));
    	}
 
    	$this->language->load('account/return');

    	$this->document->setTitle($this->language->get('heading_title'));
			
      
		$url = '';
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
				
      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('account/return', $url, 'SSL'),        	
        	'separator' => $this->language->get('text_separator')
      	);

		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_return_id'] = $this->language->get('text_return_id');
		$this->data['text_order_id'] = $this->language->get('text_order_id');
		$this->data['text_status'] = $this->language->get('text_status');
		$this->data['text_date_added'] = $this->language->get('text_date_added');
		$this->data['text_customer'] = $this->language->get('text_customer');
		$this->data['text_empty'] = $this->language->get('text_empty');

		$this->data['button_view'] = $this->language->get('button_view');
		$this->data['button_continue'] = $this->language->get('button_continue');
		
		$this->load->model('account/return');
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		$data=array();
		$limit=10;
		$data=array( 
					'start'=>($page-1)*$limit,
					'limit'=>$limit);
		
		$this->data['returns'] = array();
		
		$return_total = $this->model_account_return->getTotalReturns();
		
		$results = $this->model_account_return->getReturns($data);
		
		foreach ($results as $result) {
			$this->data['returns'][] = array(
				'return_id'  => $result['return_id'],
				'order_id'   => $result['order_id'],
				'name'       => $result['username'] ,
				'status'     => $result['status'],
				'date_added' => date('Y-m-d',$result['date_added']),
				'href'       => $this->url->link('account/return/info', 'return_id=' . $result['return_id'] . $url, 'SSL')
			);
		}

		$pagination = new Pagination('results','links');
		$pagination->total = $return_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_catalog_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('account/history', 'page={page}', 'SSL');
		
		$this->data['pagination'] = $pagination->render();

		$this->data['continue'] = $this->url->link('account/account', '', 'SSL');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/return_list.html')) {
			$this->template = $this->config->get('config_template') . '/template/account/return_list.html';
		} else {
			$this->template = 'default/template/account/return_list.html';
		}
		
		$this->children = array(
		    'account/left',
			'account/footer',
			'account/header'
		);
						
		$this->response->setOutput($this->render());				
	}
	
	public function info() {
		$this->load->language('account/return');
		
		if (isset($this->request->get['return_id'])) {
			$return_id = $this->request->get['return_id'];
		} else {
			$return_id = 0;
		}
    	
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/return/info', 'return_id=' . $return_id, 'SSL');
			
			$this->redirect($this->url->link('account/login', '', 'SSL'));
    	}
		
		$this->load->model('account/return');
						
		$return_info = $this->model_account_return->getReturn($return_id);

		if ($return_info) {
			$this->document->setTitle($this->language->get('text_return'));

			$this->data['breadcrumbs'] = array();
	
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_home'),
				'href'      => $this->url->link('common/home', '', 'SSL'),
				'separator' => false
			);
	
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_account'),
				'href'      => $this->url->link('account/account', '', 'SSL'),
				'separator' => $this->language->get('text_separator')
			);
			
			$url = '';
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}	
					
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('heading_title'),
				'href'      => $this->url->link('account/return', $url, 'SSL'),
				'separator' => $this->language->get('text_separator')
			);
						
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_return'),
				'href'      => $this->url->link('account/return/info', 'return_id=' . $this->request->get['return_id'] . $url, 'SSL'),
				'separator' => $this->language->get('text_separator')
			);			
			
			$this->data['heading_title'] = $this->language->get('text_return');
			
			$this->data['text_return_detail'] = $this->language->get('text_return_detail');
			$this->data['text_return_id'] = $this->language->get('text_return_id');
			$this->data['text_order_id'] = $this->language->get('text_order_id');
			$this->data['text_date_ordered'] = $this->language->get('text_date_ordered');
			$this->data['text_customer'] = $this->language->get('text_customer');
			$this->data['text_email'] = $this->language->get('text_email');
			$this->data['text_telphone'] = $this->language->get('text_telphone');			
			$this->data['text_status'] = $this->language->get('text_status');
			$this->data['text_date_added'] = $this->language->get('text_date_added');
			$this->data['text_product'] = $this->language->get('text_product');
			$this->data['text_comment'] = $this->language->get('text_comment');
      		$this->data['text_history'] = $this->language->get('text_history');
			
      		$this->data['column_product'] = $this->language->get('column_product');
      		$this->data['column_model'] = $this->language->get('column_model');
      		$this->data['column_quantity'] = $this->language->get('column_quantity');
      		$this->data['column_opened'] = $this->language->get('column_opened');
			$this->data['column_reason'] = $this->language->get('column_reason');
			$this->data['column_action'] = $this->language->get('column_action');
			$this->data['column_date_added'] = $this->language->get('column_date_added');
      		$this->data['column_status'] = $this->language->get('column_status');
      		$this->data['column_comment'] = $this->language->get('column_comment');
							
			$this->data['button_continue'] = $this->language->get('button_continue');
			
			$this->data['return_id'] = $return_info['return_id'];
			$this->data['order_id'] = $return_info['order_id'];
			$this->data['date_ordered'] = date('Y-m-d', $return_info['date_ordered']);
			$this->data['date_added'] = date('Y-m-d', $return_info['date_added']);
			$this->data['username'] = $return_info['username'];

			$this->data['email'] = $return_info['email'];
			$this->data['telphone'] = $return_info['telphone'];						
			$this->data['product'] = $return_info['product'];
			$this->data['model'] = $return_info['model'];
			$this->data['quantity'] = $return_info['quantity'];
			$this->data['reason'] = $return_info['reason'];
			$this->data['opened'] = $return_info['opened'] ? $this->language->get('text_yes') : $this->language->get('text_no');
			$this->data['comment'] = nl2br($return_info['comment']);
			$this->data['action'] = $return_info['action'];
						
			$this->data['histories'] = array();
			
			$results = $this->model_account_return->getReturnHistories($this->request->get['return_id']);
			
      		foreach ($results as $result) {
        		$this->data['histories'][] = array(
          			'date_added' => date('Y-m-d', $result['date_added']),
          			'status'     => $result['status'],
          			'comment'    => nl2br($result['comment'])
        		);
      		}
			
			$this->data['continue'] = $this->url->link('account/return', $url, 'SSL');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/return_info.html')) {
				$this->template = $this->config->get('config_template') . '/template/account/return_info.html';
			} else {
				$this->template = 'default/template/account/return_info.html';
			}
			
			$this->children = array(
			    'account/left',
				'account/footer',
				'account/header'	
			);
									
			$this->response->setOutput($this->render());		
		} else {
			$this->document->setTitle($this->language->get('text_return'));
						
			$this->data['breadcrumbs'] = array();

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_home'),
				'href'      => $this->url->link('common/home'),
				'separator' => false
			);

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_account'),
				'href'      => $this->url->link('account/account', '', 'SSL'),
				'separator' => $this->language->get('text_separator')
			);
			
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('heading_title'),
				'href'      => $this->url->link('account/return', '', 'SSL'),
				'separator' => $this->language->get('text_separator')
			);
			
			$url = '';
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
									
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_return'),
				'href'      => $this->url->link('account/return/info', 'return_id=' . $return_id . $url, 'SSL'),
				'separator' => $this->language->get('text_separator')
			);
			
			$this->data['heading_title'] = $this->language->get('text_return');

			$this->data['text_error'] = $this->language->get('text_error');

			$this->data['button_continue'] = $this->language->get('button_continue');

			$this->data['continue'] = $this->url->link('account/return', '', 'SSL');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.html')) {
				$this->template = $this->config->get('config_template') . '/template/error/not_found.html';
			} else {
				$this->template = 'default/template/error/not_found.html';
			}
			
			$this->children = array(
				'common/footer',
				'common/header'	
			);
						
			$this->response->setOutput($this->render());			
		}
	}
		
	public function insert() {
	
		$this->language->load('account/return');

		$this->load->model('account/return');

    	
							
		$this->document->setTitle($this->language->get('heading_title'));
		
      	$this->data['breadcrumbs'] = array();

      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
        	'separator' => false
      	); 
		
      	$this->data['breadcrumbs'][] = array(       	
        	'text'      => $this->language->get('text_account'),
			'href'      => $this->url->link('account/account', '', 'SSL'),
        	'separator' => $this->language->get('text_separator')
      	);
		
      	$this->data['breadcrumbs'][] = array(       	
        	'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('account/return/insert', '', 'SSL'),
        	'separator' => $this->language->get('text_separator')
      	);
		
    	$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_description'] = $this->language->get('text_description');
		$this->data['text_order'] = $this->language->get('text_order');
		$this->data['text_product'] = $this->language->get('text_product');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		
		$this->data['entry_order_id'] = $this->language->get('entry_order_id');	
		$this->data['entry_date_ordered'] = $this->language->get('entry_date_ordered');	    	
		$this->data['entry_username'] = $this->language->get('entry_username');
    	
    	$this->data['entry_email'] = $this->language->get('entry_email');
    	$this->data['entry_telphone'] = $this->language->get('entry_telphone');
		$this->data['entry_product'] = $this->language->get('entry_product');	
		$this->data['entry_model'] = $this->language->get('entry_model');			
		$this->data['entry_quantity'] = $this->language->get('entry_quantity');				
		$this->data['entry_reason'] = $this->language->get('entry_reason');	
		$this->data['entry_opened'] = $this->language->get('entry_opened');	
		$this->data['entry_fault_detail'] = $this->language->get('entry_fault_detail');	
		$this->data['entry_captcha'] = $this->language->get('entry_captcha');
				
		$this->data['button_continue'] = $this->language->get('button_continue');
		$this->data['button_back'] = $this->language->get('button_back');
        
		if($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validate()){
			$this->model_account_return->addReturn($this->request->post);
			
			$this->redirect($this->url->link('account/return/success', '', 'SSL'));
		}
	    
	
		if (isset($this->error['order_id'])) {
			$this->data['errorinfo']['error_order_id'] = $this->error['order_id'];
		} else {
			$this->data['errorinfo']['error_order_id'] = '';
		}
				
		if (isset($this->error['username'])) {
			$this->data['errorinfo']['error_username'] = $this->error['username'];
		} else {
			$this->data['errorinfo']['error_username'] = '';
		}	

	
		if (isset($this->error['email'])) {
			$this->data['errorinfo']['error_email'] = $this->error['email'];
		} else {
			$this->data['errorinfo']['error_email'] = '';
		}
		
		if (isset($this->error['telphone'])) {
			$this->data['errorinfo']['error_telphone'] = $this->error['telphone'];
		} else {
			$this->data['errorinfo']['error_telphone'] = '';
		}
				
		if (isset($this->error['product'])) {
			$this->data['errorinfo']['error_product'] = $this->error['product'];
		} else {
			$this->data['errorinfo']['error_product'] = '';
		}
		
		if (isset($this->error['model'])) {
			$this->data['errorinfo']['error_model'] = $this->error['model'];
		} else {
			$this->data['errorinfo']['error_model'] = '';
		}
						
		if (isset($this->error['reason'])) {
			$this->data['errorinfo']['error_reason'] = $this->error['reason'];
		} else {
			$this->data['errorinfo']['error_reason'] = '';
		}
		
		if (isset($this->error['captcha'])) {
			$this->data['errorinfo']['error_captcha'] = $this->error['captcha'];
		} else {
			$this->data['errorinfo']['error_captcha'] = '';
		}	
		
		$this->data['flag']=false;
		foreach($this->data['errorinfo'] as $v){
		    if(!empty($v)){
			    $this->data['flag']=true;
				array_unshift($this->data['errorinfo'],$this->language->get('error_warning'));
				break;
			}
		}
    	
		
	
		
		$this->data['action'] = $this->url->link('account/return/insert', '', 'SSL');
	
		$this->load->model('account/order');
		
		if (isset($this->request->get['order_id'])) {
			$order_info = $this->model_account_order->getOrder($this->request->get['order_id']);
		}
		//var_dump($order_info);
		$this->load->model('catalog/product');
		
		if (isset($this->request->get['product_id'])) {
			$product_info = $this->model_catalog_product->getProduct($this->request->get['product_id']);
		}
		
		if (isset($this->request->post['product_id'])) {
    		$this->data['product_id'] = $this->request->post['product_id'];
		} elseif (!empty($product_info)) {
			$this->data['product_id'] = $product_info['product_id'];				
		} else {
			$this->data['product_id'] = '';
		}
		
    	if (isset($this->request->post['order_id'])) {
      		$this->data['order_id'] = $this->request->post['order_id']; 	
		} elseif (!empty($order_info)) {
			$this->data['order_id'] = $order_info['order_id'];
		} else {
      		$this->data['order_id'] = ''; 
    	}
				
    	if (isset($this->request->post['date_ordered'])) {
      		$this->data['date_ordered'] = $this->request->post['date_ordered']; 	
		} elseif (!empty($order_info)) {
			$this->data['date_ordered'] = date('Y-m-d', $order_info['date_added']);
		} else {
      		$this->data['date_ordered'] =  date('Y-m-d');
    	}
				
		if (isset($this->request->post['username'])) {
    		$this->data['username'] = $this->request->post['username'];
		} elseif (!empty($order_info)) {
			$this->data['username'] = $order_info['username'];	
		} else {
			$this->data['username'] = $this->customer->getUserName();
		}

		
		
		if (isset($this->request->post['email'])) {
    		$this->data['email'] = $this->request->post['email'];
		} elseif (!empty($order_info)) {
			$this->data['email'] = $order_info['email'];				
		} else {
			$this->data['email'] = $this->customer->getEmail();
		}
		
		if (isset($this->request->post['telphone'])) {
    		$this->data['telphone'] = $this->request->post['telphone'];
		} elseif (!empty($order_info)) {
			$this->data['telphone'] = $order_info['telphone'];				
		} else {
			$this->data['telphone'] = $this->customer->gettelphone();
		}
		
		if (isset($this->request->post['product'])) {
    		$this->data['product'] = $this->request->post['product'];
		} elseif (!empty($product_info)) {
			$this->data['product'] = $product_info['name'];				
		} else {
			$this->data['product'] = '';
		}
		
		if (isset($this->request->post['model'])) {
    		$this->data['model'] = $this->request->post['model'];
		} elseif (!empty($product_info)) {
			$this->data['model'] = $product_info['model'];				
		} else {
			$this->data['model'] = '';
		}
			
		if (isset($this->request->post['quantity'])) {
    		$this->data['quantity'] = $this->request->post['quantity'];
		} else {
			$this->data['quantity'] = 1;
		}	
				
		if (isset($this->request->post['opened'])) {
    		$this->data['opened'] = $this->request->post['opened'];
		} else {
			$this->data['opened'] = false;
		}	
		
		if (isset($this->request->post['return_reason_id'])) {
    		$this->data['return_reason_id'] = $this->request->post['return_reason_id'];
		} else {
			$this->data['return_reason_id'] = '';
		}	
														
		$this->load->model('localisation/return_reason');
		
    	$this->data['return_reasons'] = $this->model_localisation_return_reason->getReturnReasons();
		
		if (isset($this->request->post['comment'])) {
    		$this->data['comment'] = $this->request->post['comment'];
		} else {
			$this->data['comment'] = '';
		}	
		
		if (isset($this->request->post['captcha'])) {
			$this->data['captcha'] = $this->request->post['captcha'];
		} else {
			$this->data['captcha'] = '';
		}		

		$this->data['back'] = $this->url->link('account/account', '', 'SSL');
				
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/return_form.html')) {
			$this->template = $this->config->get('config_template') . '/template/account/return_form.html';
		} else {
			$this->template = 'default/template/account/return_form.html';
		}
		
		$this->children = array(
			'account/left',
			'account/footer',
			'account/header'	
		);
				
		$this->response->setOutput($this->render());		
  	}
	
  	public function success() {
		$this->language->load('account/return');

		$this->document->setTitle($this->language->get('heading_title')); 
      
	  	$this->data['breadcrumbs'] = array();

      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
        	'separator' => false
      	);

      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('account/return', '', 'SSL'),
        	'separator' => $this->language->get('text_separator')
      	);	
				
    	$this->data['heading_title'] = $this->language->get('heading_title');

    	$this->data['text_message'] = $this->language->get('text_message');

    	$this->data['button_continue'] = $this->language->get('button_continue');
	
    	$this->data['continue'] = $this->url->link('account/account');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/success.html')) {
			$this->template = $this->config->get('config_template') . '/template/common/success.html';
		} else {
			$this->template = 'default/template/common/success.html';
		}
		
		$this->children = array(
		    'account/left',
			'account/footer',
			'account/header'	
		);
				
 		$this->response->setOutput($this->render()); 
	}
		
  	private function validate() {
	   
    	if (!$this->request->post['order_id']) {
      		$this->error['order_id'] = $this->language->get('error_order_id');
    	}
	

    	if ((utf8_strlen($this->request->post['username']) < 1) || (utf8_strlen($this->request->post['username']) > 32)) {
      		$this->error['username'] = $this->language->get('error_username');
    	}

    	if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
      		$this->error['email'] = $this->language->get('error_email');
    	}
		
    	if ((utf8_strlen($this->request->post['telphone']) < 3) || (utf8_strlen($this->request->post['telphone']) > 32)) {
      		$this->error['telphone'] = $this->language->get('error_telphone');
    	}		
		
		if ((utf8_strlen($this->request->post['product']) < 1) || (utf8_strlen($this->request->post['product']) > 255)) {
			$this->error['product'] = $this->language->get('error_product');
		}	
		
		if ((utf8_strlen($this->request->post['model']) < 1) || (utf8_strlen($this->request->post['model']) > 64)) {
			$this->error['model'] = $this->language->get('error_model');
		}							

		if (empty($this->request->post['return_reason_id'])) {
			$this->error['reason'] = $this->language->get('error_reason');
		}	
				
    	if (empty($this->session->data['captcha']) || ($this->session->data['captcha'] != $this->request->post['captcha'])) {
      		$this->error['captcha'] = $this->language->get('error_captcha');
    	}

		if (!$this->error) {
      		return true;
    	} else {
      		return false;
    	}
  	}
	
	public function captcha() {
		$this->load->library('captcha');
		
		$captcha = new Captcha();
		
		$this->session->data['captcha'] = $captcha->getCode();
		
		$captcha->showImage();
	}	
}
?>
