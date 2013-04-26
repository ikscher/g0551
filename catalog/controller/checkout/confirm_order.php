<?php 
/**确认订单**/
class ControllerCheckoutConfirmOrder extends Controller { 
	public function index() {
		$redirect = '';
	    $json=array();
		$data = array();
		$data['username']=$data['postcode']=$data['email']=$data['telphone']=$date['mobile']=$data['address']='';

		$flag=$this->session->data['dbuy_flag'];
		
	
		$this->load->model('account/address');
		if($this->customer->isLogged()){
		    $data['customer_id'] = $this->customer->getId();
		    $shipping_address = $this->model_account_address->getAddressByCustomerid($this->customer->getId());		
				
			$data['username'] = isset($shipping_address['username'])?$shipping_address['username']:'';
			$data['postcode'] = isset($shipping_address['postcode'])?$shipping_address['postcode']:'';
			$data['email'] = isset($shipping_address['email'])?$shipping_address['email']:'';
			$data['telphone'] = isset($shipping_address['telphone'])?$shipping_address['telphone']:'';
			$data['mobile'] = isset($shipping_address['mobile'])?$shipping_address['mobile']:'';
			$data['address'] = isset($shipping_address['address'])?$shipping_address['address']:'';
		}

		
			
		if (empty($shipping_address)) {								
			$redirect = $this->url->link('checkout/cart', '', 'SSL');
		}
		
		
	    
		if ($this->cart->hasShipping($flag) && $this->customer->isLogged()){
		   $data['shipping_username']=$data['username'];
		   $data['shipping_postcode']=$data['postcode'];
		   $data['shipping_email']=$data['email'];
		   $data['shipping_mobile']=$data['mobile'];
		   $data['shipping_address']=$data['address'];
		   $data['shipping_telphone']=$data['telphone'];
		
		}
	
		// Validate cart has products and has stock.	
		if ((!$this->cart->hasProducts($flag) && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock($flag) && !$this->config->get('config_stock_checkout'))) {
			$redirect = $this->url->link('checkout/cart');				
		}	
		
		
		// Validate minimum quantity requirments.			
		$products = $this->cart->getProducts($flag);
				
		foreach ($products as $product) {	
			
			if ($product['minimum'] > $product['quantity']) {
				$redirect = $this->url->link('checkout/cart');
				
				break;
			}				
		}
			
		if (!$redirect) {
		    
		
			
			$total_data = array();
			$total = array();//注意这里的total不是total=0;
			 
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
		            
					$this->{'model_total_' . $result['code']}->getTotal($total_data, $total,$flag,true);
				}
			}

			$this->language->load('checkout/checkout');
			
			

			if(isset($this->request->post['shipping_method'])){
			   $shippingmethod=explode(',',$this->request->post['shipping_method']);
			   $data['shipping_method']=$shippingmethod[1];
			   $data['shipping_code']=$shippingmethod[0];
			}else{
			   $data['shipping_method'] = '';
			   $data['shipping_code']='';
			}
            
			$data['payment_method']=$this->request->post['payment_method'];
			
			$product_data = array();
		
			
			
			foreach ($this->cart->getProducts($flag) as $product) {
				//$option_data = array();
	
				/* foreach ($product['option'] as $option) {
					if ($option['type'] != 'file') {
						$value = $option['option_value'];	
					} else {
						$filename = $this->encryption->decrypt($option['option_value']);
						
						$value = utf8_substr($filename, 0, utf8_strrpos($filename, '.'));
					}
										
					$option_data[] = array(
						'product_option_id'       => $option['product_option_id'],
						'product_option_value_id' => $option['product_option_value_id'],
						'option_id'               => $option['option_id'],
						'attribute_id'            => $option['attribute_id'],
						'option_value_id'         => $option['option_value_id'],								   
						'name'                    => $option['name'],
						'value'                   => $value,
						'type'                    => $option['type']
					);		
				}   */
	 
				$product_data[$product['store_id']][] = array(
					'product_id' => $product['product_id'],
					'store_id'   => $product['store_id'],
					'name'       => $product['name'],
					'model'      => $product['model'],
					//'option'     => $option_data,
					'attribute'  => $product['attribute'],
					'quantity'   => $product['quantity'],
					'subtract'   => $product['subtract'],
					'reward'     => $product['reward'],
					'price'      => $product['price'],
					'total'      => $product['total'],
					'href'       => $this->url->link('product/product', 'product_id=' . $product['product_id'])
				); 
			} 
			
			// Gift Voucher
			$voucher_data = array();
			
			if (!empty($this->session->data['vouchers'])) {
				foreach ($this->session->data['vouchers'] as $voucher) {
					$voucher_data[] = array(
						'description'      => $voucher['description'],
						'code'             => substr(md5(mt_rand()), 0, 10),
						'to_name'          => $voucher['to_name'],
						'to_email'         => $voucher['to_email'],
						'from_name'        => $voucher['from_name'],
						'from_email'       => $voucher['from_email'],
						'voucher_theme_id' => $voucher['voucher_theme_id'],
						'message'          => $voucher['message'],						
						'amount'           => $voucher['amount']
					);
				}
			}  
						
			$data['products'] = $product_data;
			$data['vouchers'] = $voucher_data;
			$data['totals'] = $total_data;
			//$data['comment'] = $this->session->data['comment'];
			$data['total'] = $total;
			
			
			
			if (isset($this->request->cookie['tracking'])) {
				$this->load->model('affiliate/affiliate');
				
				$affiliate_info = $this->model_affiliate_affiliate->getAffiliateByCode($this->request->cookie['tracking']);
				$subtotal = $this->cart->getSubTotal();
				
				if ($affiliate_info) {
					$data['affiliate_id'] = $affiliate_info['affiliate_id']; 
					$data['commission'] = ($subtotal / 100) * $affiliate_info['commission']; 
				} else {
					$data['affiliate_id'] = 0;
					$data['commission'] = 0;
				}
			} else {
				$data['affiliate_id'] = 0;
				$data['commission'] = 0;
			}
			
			
			$data['ip'] = $this->request->server['REMOTE_ADDR'];
			
			if (!empty($this->request->server['HTTP_X_FORWARDED_FOR'])) {
				$data['forwarded_ip'] = $this->request->server['HTTP_X_FORWARDED_FOR'];	
			} elseif(!empty($this->request->server['HTTP_CLIENT_IP'])) {
				$data['forwarded_ip'] = $this->request->server['HTTP_CLIENT_IP'];	
			} else {
				$data['forwarded_ip'] = '';
			}
			
			if (isset($this->request->server['HTTP_USER_AGENT'])) {
				$data['user_agent'] = $this->request->server['HTTP_USER_AGENT'];	
			} else {
				$data['user_agent'] = '';
			}
			
			if (isset($this->request->server['HTTP_ACCEPT_LANGUAGE'])) {
				$data['accept_language'] = $this->request->server['HTTP_ACCEPT_LANGUAGE'];	
			} else {
				$data['accept_language'] = '';
			}
						
			$this->load->model('checkout/order');
			
			
			
			$this->session->data['order_id']=$this->model_checkout_order->addOrder($data);
			
           
			$this->response->setOutput(json_encode($json));
			
		} else {
			
			$json['redirect']=$redirect;
			$this->response->setOutput(json_encode($json));
		}			
       
  	}
}
?>