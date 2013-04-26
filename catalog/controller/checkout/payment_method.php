<?php  
/**店铺支付方法**/

class ControllerCheckoutPaymentMethod extends Controller {
  	public function index() {
		//$this->language->load('checkout/checkout');
		
		//$this->load->model('account/address');
		
		$flag=$this->session->data['dbuy_flag'];
	
		$product=$this->cart->getProducts($flag);
		
		$store_id=$product['store_id'];
		
		
		
		/* if ($this->customer->isLogged() && isset($this->session->data['payment_address_id'])) {
			$payment_address = $this->model_account_address->getAddress($this->session->data['payment_address_id']);		
		} elseif (isset($this->session->data['guest'])) {
			$payment_address = $this->session->data['guest']['payment'];
		} */	
		
		//if (!empty($payment_address)) {
			// Totals
			
			$total_data = array();					
			$total = array();
			
			$this->load->model('setting/extension');
			
			$sort_order = array(); 
			
			$results = $this->model_setting_extension->getExtensions('total');
		
			foreach ($results as $key => $value) {
				$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
			}
			
			array_multisort($sort_order, SORT_ASC, $results);
			
			foreach ($results as $result) {
				if ($this->config->get($result['code'] . '_status')) {
					$this->load->model('total/' . $result['code']);
		
					$this->{'model_total_' . $result['code']}->getTotal($total_data, $total,$flag,true );
				}
			}
			
			$results=null;
			
			// Payment Methods
			$method_data = array();
			
			$this->load->model('payment/payment_method');
			
			$results = $this->model_payment_payment_method->getMethod($store_id);
	
			foreach ($results as $result) {
				$method_data[$result['code']] = $result;
			}
			
			
			//var_dump($method_data);
			/***====method_data's format is the following as :
			array
			  'cod' => 
				array
				  'code' => string 'cod' (length=3)
				  'title' => string '货到付款' (length=12)
				  'sort_order' => string '5' (length=1)
			*/
			
			//硬编码
			//$method_data=array('cod'=>array('code'=>'cod','title'=>'货到付款','sort_order'=>'5'));
			                         
			
			$sort_order = array(); 
		  
			foreach ($method_data as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}
	
			array_multisort($sort_order, SORT_ASC, $method_data);			
			
			$this->session->data['payment_methods'] = $method_data;			
		//}		
		return $method_data;
        //$this->response->setOutput(json_encode($method_data));
		
		/* $this->data['text_payment_method'] = $this->language->get('text_payment_method');
		$this->data['text_comments'] = $this->language->get('text_comments');

		$this->data['button_continue'] = $this->language->get('button_continue');
   
		if (empty($this->session->data['payment_methods'])) {
			$this->data['error_warning'] = sprintf($this->language->get('error_no_payment'), $this->url->link('information/contact'));
		} else {
			$this->data['error_warning'] = '';
		}	

		
	  
		if (isset($this->session->data['payment_method']['code'])) {
			$this->data['code'] = $this->session->data['payment_method']['code'];
		} else {
			$this->data['code'] = '';
		}
		
		if (isset($this->session->data['comment'])) {
			$this->data['comment'] = $this->session->data['comment'];
		} else {
			$this->data['comment'] = '';
		}
		
		if ($this->config->get('config_checkout_id')) {
			$this->load->model('catalog/information');
			
			$information_info = $this->model_catalog_information->getInformation($this->config->get('config_checkout_id'));
			
			if ($information_info) {
				$this->data['text_agree'] = sprintf($this->language->get('text_agree'), $this->url->link('information/information/info', 'information_id=' . $this->config->get('config_checkout_id'), 'SSL'), $information_info['title'], $information_info['title']);
			} else {
				$this->data['text_agree'] = '';
			}
		} else {
			$this->data['text_agree'] = '';
		}
		
		if (isset($this->session->data['agree'])) { 
			$this->data['agree'] = $this->session->data['agree'];
		} else {
			$this->data['agree'] = '';
		}
			
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/payment_method.html')) {
			$this->template = $this->config->get('config_template') . '/template/checkout/payment_method.html';
		} else {
			$this->template = 'default/template/checkout/payment_method.html';
		}
		
		$this->response->setOutput($this->render()); */
  	}
	
	public function validate() {
		$this->language->load('checkout/checkout');
		
		$json = array();
		
		// Validate if payment address has been set.
		$this->load->model('account/address');
		
		if ($this->customer->isLogged() && isset($this->session->data['payment_address_id'])) {
			$payment_address = $this->model_account_address->getAddress($this->session->data['payment_address_id']);		
		} elseif (isset($this->session->data['guest'])) {
			$payment_address = $this->session->data['guest']['payment'];
		}	
				
		if (empty($payment_address)) {
			$json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');
		}		
		
		// Validate cart has products and has stock.			
		if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
			$json['redirect'] = $this->url->link('checkout/cart');				
		}	
		
		// Validate minimum quantity requirments.			
		$products = $this->cart->getProducts();
				
		foreach ($products as $product) {
			$product_total = 0;
			
			$product_total += $product['quantity'];
			/* foreach ($products as $product_2) {
				if ($product_2['product_id'] == $product['product_id']) {
					$product_total += $product_2['quantity'];
				}
			} */		
			
			if ($product['minimum'] > $product_total) {
				$json['redirect'] = $this->url->link('checkout/cart');
				
				break;
			}				
		}
											
		if (!$json) {
			if (!isset($this->request->post['payment_method'])) {
				$json['error']['warning'] = $this->language->get('error_payment');
			} else {
				if (!isset($this->session->data['payment_methods'][$this->request->post['payment_method']])) {
					$json['error']['warning'] = $this->language->get('error_payment');
				}
			}	
							
			if ($this->config->get('config_checkout_id')) {
				$this->load->model('catalog/information');
				
				$information_info = $this->model_catalog_information->getInformation($this->config->get('config_checkout_id'));
				
				if ($information_info && !isset($this->request->post['agree'])) {
					$json['error']['warning'] = sprintf($this->language->get('error_agree'), $information_info['title']);
				}
			}
			
			if (!$json) {
				$this->session->data['payment_method'] = $this->session->data['payment_methods'][$this->request->post['payment_method']];
			  
				$this->session->data['comment'] = strip_tags($this->request->post['comment']);
			}							
		}
		
		$this->response->setOutput(json_encode($json));
	}
}
?>