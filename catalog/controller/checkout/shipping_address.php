<?php 
class ControllerCheckoutShippingAddress extends Controller {
	public function index() {
		$this->language->load('checkout/checkout');
		
		$this->data['text_address_existing'] = $this->language->get('text_address_existing');
		$this->data['text_address_new'] = $this->language->get('text_address_new');
		$this->data['text_select'] = $this->language->get('text_select');
		$this->data['text_none'] = $this->language->get('text_none');

		$this->data['entry_username'] = $this->language->get('entry_username');
		
		$this->data['entry_company'] = $this->language->get('entry_company');
		$this->data['entry_address'] = $this->language->get('entry_address');
		$this->data['entry_telphone'] = $this->language->get('entry_telphone');
		$this->data['entry_postcode'] = $this->language->get('entry_postcode');
		$this->data['entry_mobile'] = $this->language->get('entry_mobile');
		// $this->data['entry_city'] = $this->language->get('entry_city');
		// $this->data['entry_country'] = $this->language->get('entry_country');
		// $this->data['entry_zone'] = $this->language->get('entry_zone');
	
		$this->data['button_continue'] = $this->language->get('button_continue');
			
		if (isset($this->session->data['shipping_address_id'])) {
			$this->data['address_id'] = $this->session->data['shipping_address_id'];
		} else {
			$this->data['address_id'] = $this->customer->getAddressId();
		}

		$this->load->model('account/address');

		$this->data['addresses'] = $this->model_account_address->getAddresses();

		/* if (isset($this->session->data['shipping_postcode'])) {
			$this->data['postcode'] = $this->session->data['shipping_postcode'];		
		} else {
			$this->data['postcode'] = '';
		} */
				


		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/shipping_address.html')) {
			$this->template = $this->config->get('config_template') . '/template/checkout/shipping_address.html';
		} else {
			$this->template = 'default/template/checkout/shipping_address.html';
		}
				
		$this->response->setOutput($this->render());
  	}	
	
	public function validate() {
		$this->language->load('checkout/checkout');
		
		$json = array();
		
		// Validate if customer is logged in.
		if (!$this->customer->isLogged()) {
			$json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');
		}
		
		// Validate if shipping is required. If not the customer should not have reached this page.
		if (!$this->cart->hasShipping()) {
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
			if ($this->request->post['shipping_address'] == 'existing') {
				$this->load->model('account/address');
				
				if (empty($this->request->post['address_id'])) {
					$json['error']['warning'] = $this->language->get('error_address');
				} elseif (!in_array($this->request->post['address_id'], $this->model_account_address->getAddresses(false))) {
					$json['error']['warning'] = $this->language->get('error_address');
				}
						
				//if (!$json) {			
					$this->session->data['shipping_address_id'] = $this->request->post['address_id'];
					
					// Default Shipping Address
					$this->load->model('account/address');

					$address_info = $this->model_account_address->getAddress($this->request->post['address_id']);
					
					if ($address_info) {
					    $this->session->data['shipping_address']=$address_info['address'];
						//$this->session->data['shipping_country_id'] = $address_info['country_id'];
						//$this->session->data['shipping_zone_id'] = $address_info['zone_id'];
						//$this->session->data['shipping_postcode'] = $address_info['postcode'];						
					} else {
					      unset($this->session->data['shipping_address']);
						//unset($this->session->data['shipping_country_id']);	
						//unset($this->session->data['shipping_zone_id']);	
						//unset($this->session->data['shipping_postcode']);
					}
					
					unset($this->session->data['shipping_method']);							
					unset($this->session->data['shipping_methods']);
				//}
			} 
			
			if ($this->request->post['shipping_address'] == 'new') {
				if ((utf8_strlen($this->request->post['username']) < 3) || (utf8_strlen($this->request->post['username']) > 32)) {
					$json['error']['username'] = $this->language->get('error_username');
				}
		
		
				if ((utf8_strlen($this->request->post['address']) < 5) || (utf8_strlen($this->request->post['address']) > 128)) {
					$json['error']['address'] = $this->language->get('error_address');
				}
		
				if ((utf8_strlen($this->request->post['mobile']) !=13) || !is_numberic($this->request->post['mobile'])) {
					$json['error']['mobile'] = $this->language->get('error_mobile');
				}
				
				
				
				//if (!$json) {						
					// Default Shipping Address
					$this->load->model('account/address');		
					
					$this->session->data['shipping_address_id'] = $this->model_account_address->addAddress($this->request->post);
					//$this->session->data['shipping_country_id'] = $this->request->post['country_id'];
					//$this->session->data['shipping_zone_id'] = $this->request->post['zone_id'];
					//$this->session->data['shipping_postcode'] = $this->request->post['postcode'];
									
					unset($this->session->data['shipping_method']);						
					unset($this->session->data['shipping_methods']);
				//}
			}
		}
		
		$this->response->setOutput(json_encode($json));
	}
}
?>