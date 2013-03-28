<?php  
class ControllerCheckoutCheckout extends Controller { 
	public function index() {
	    $flag=false;
		if (isset($this->request->get['dbuy']) && $this->request->get['dbuy']==1){ //直接购买的
		    $products = $this->cart->getProducts(TRUE);
			$this->data['dbuy']='yes'; //和refreshTotal设置一样的
			$flag=true;
			
		}else{ //购物车的
			// Validate cart has products and has stock.
			if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
				$this->redirect($this->url->link('checkout/cart'));
			}	
			
			// Validate minimum quantity requirments.			
			$products = $this->cart->getProducts();
		}		
		
	
		$this->data['shipping_method']=null;
	    $this->data['shippingMethod']=3;//默认货到付款
		
		
		if(isset($this->session->data['shippingMethod'])){
		    $this->data['shippingMethod']=$this->session->data['shippingMethod'];
		}
	
		foreach ($products as $product) {
			$product_total = 0;
			
			$product_total += $product['quantity'];
			/* foreach ($products as $product_2) {
				if ($product_2['product_id'] == $product['product_id']) {
					$product_total += $product_2['quantity'];
				}
			} */		
			
			if ($product['minimum'] > $product_total) {
				$this->redirect($this->url->link('checkout/cart'));
			}				
		}
				
		$this->language->load('checkout/checkout');
		
		$this->document->setTitle($this->language->get('heading_title')); 
		
	
		
		//地址信息
		$this->data['addresses'] = array();
		$this->load->model('account/address');
		$results = $this->model_account_address->getAddresses();
    	foreach ($results as $result) {

      		$this->data['addresses'][] = array(
        		'address_id' => $result['address_id'],
				'customer_id'=> $result['customer_id'],
				'username'   => $result['username'],
				'telephone'  => $result['telephone'],
				'mobile'     => $result['mobile'],
				'company'    => $result['company'],
				'address'    => $result['address'],
				'postcode'   => $result['postcode'],
				'status'     => $result['status']);
	    }
		
		//产品信息
		$this->data['products'] = array();
		$this->load->model('tool/image');
		foreach ($products as $product) {
			if ($product['image']) {
				$image = $this->model_tool_image->resize($product['image'], $this->config->get('config_image_cart_width'), $this->config->get('config_image_cart_height'));
			} else {
				$image = '';
			}
							
			$option_data = array();
			
			foreach ($product['option'] as $option) {
				if ($option['type'] != 'file') {
					$value = $option['option_value'];	
				} else {
					$filename = $this->encryption->decrypt($option['option_value']);
					
					$value = utf8_substr($filename, 0, utf8_strrpos($filename, '.'));
				}				
				
				$option_data[] = array(								   
					'name'  => $option['name'],
					'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value),
					'attribute_group_name' => $option['attribute_group_name'],
					'type'  => $option['type']
				);
			}
			
			// Display prices
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$price = number_format($product['price'],2,'.',',');
			} else {
				$price = false;
			}
			
			// Display prices
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$total = number_format($product['price'] * $product['quantity'],2,'.',',');
			} else {
				$total = false;
			}
													
			$this->data['products'][] = array(
				'key'      => $product['key'],
				'thumb'    => $image,
				'name'  => $product['name'],
				'model'    => $product['model'], 
				'option'   => $option_data,
				'attribute'=> $product['attribute'],
				'quantity' => $product['quantity'],
				'stock'    => $product['stock'] ? true : !(!$this->config->get('config_stock_checkout') || $this->config->get('config_stock_warning')),
				'reward'   => ($product['reward'] ? sprintf($this->language->get('text_points'), $product['reward']) : ''),
				'price'    => $price,	
				'total'    => $total,	
				'href'     => $this->url->link('product/product', 'product_id=' . $product['product_id'])		
			);
		}
		
		
		// Gift Voucher
		$this->data['vouchers'] = array();
		
		if (!empty($this->session->data['vouchers'])) {
			foreach ($this->session->data['vouchers'] as $voucher) {
				$this->data['vouchers'][] = array(
					'description' => $voucher['description'],
					'amount'      => number_format($voucher['amount'],2,'.',',')
				);
			}
		}  
		
		//total
		$total_data = array();
		$total = 0;
		 
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
				
				$this->{'model_total_' . $result['code']}->getTotal($total_data, $total,$flag);
			}
		}
		
		$sort_order = array(); 
	  
		foreach ($total_data as $key => $value) {
			$sort_order[$key] = $value['sort_order'];
		}

		array_multisort($sort_order, SORT_ASC, $total_data);
		$this->data['totals']=$total_data;
		
		
		$this->data['cart']=$this->url->link('checkout/cart','','SSL');
		
        		
	    $this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_checkout_option'] = $this->language->get('text_checkout_option');//'第 1 步： 结帐选项';
		$this->data['text_checkout_account'] = $this->language->get('text_checkout_account');//'第 2 步： 帐户 &amp; 运单详细';
		$this->data['text_checkout_payment_address'] = $this->language->get('text_checkout_payment_address');//'第 2 步： 运单地址';
		$this->data['text_checkout_shipping_address'] = $this->language->get('text_checkout_shipping_address');//'第 3 步： 货运地址';
		$this->data['text_checkout_shipping_method'] = $this->language->get('text_checkout_shipping_method');//'第 4 步： 货运方式';
		$this->data['text_checkout_payment_method'] = $this->language->get('text_checkout_payment_method');	//'第 5 步： 支付方式';	
		$this->data['text_checkout_confirm'] = $this->language->get('text_checkout_confirm');//'第 6 步： 确认订单';
		$this->data['text_modify'] = $this->language->get('text_modify');
		
		$this->data['logged'] = $this->customer->isLogged();
		$this->data['shipping_required'] = $this->cart->hasShipping($flag);	
		
		// $this->data['action']=$this->url->link('checkout/confirm_order','','SSL');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/order.html')) {
			$this->template = $this->config->get('config_template') . '/template/checkout/order.html';
		} else {
			$this->template = 'default/template/checkout/order.html';
		}
		
		$this->children = array(
            'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
  	}
	
	/**直接购买 *ajax*/
	public function dbuy(){
	    $this->language->load('checkout/cart');
	    $product_id=$this->request->post['product_id'];
	    
		$json=array();
		
		$this->load->model('catalog/product');
		$this->load->model('account/customer');
						
		$product_info = $this->model_catalog_product->getProduct($product_id);
		
		if ($product_info ) {
		    //自己不能购买自己的产品
			$storeProduct=$this->model_account_customer->getCustomer($this->customer->getId(),$product_info['store_id']);
			if(!empty($storeProduct)){
			    $json['error']['product']=1;
			}
			
			$qty=isset($this->request->post['quantity'])?$this->request->post['quantity']:1;
		    $option=isset($this->request->post['option'])?$this->request->post['option']:array();
			$attribute=isset($this->request->post['attribute'])?$this->request->post['attribute']:array();
	  
	        if (empty($option)) {
				$key = (int)$product_id;
			} else {
				$key = (int)$product_id . ':' . base64_encode(serialize($option));
			}
			
			if ((int)$qty && ((int)$qty > 0)) {	
				//$this->cookie->data['cart'][$key] = (int)$qty;
				$arrMenu=array($key=>(int)$qty);
				array_walk_recursive($arrMenu,'formatSerialize');
				$this->cookie->OCSetCookie('dbuyproduct',base64_encode(serialize($arrMenu)),24*3600);
				
			}
            
			
			$product_attributes=$this->model_catalog_product->getProductAttributes($product_id,true);
			foreach ($product_attributes as $product_attribute) {
				if (empty($attribute[$product_attribute['attribute_group_id']])) {
					$json['error']['attribute'][$product_attribute['attribute_group_id']] = sprintf($this->language->get('error_required'), $product_attribute['attribute_group_name']);
				}
			}
			
		
			$product_options = $this->model_catalog_product->getProductOptions($product_id);
		
			foreach ($product_options as $product_option) {
				if ($product_option['required'] && empty($option[$product_option['product_option_id']])) {
					$json['error']['option'][$product_option['product_option_id']] = sprintf($this->language->get('error_required'), $product_option['attribute_group_name']);
				}
			}
		
			if (!$json) {
			   
				//$this->cart->add($this->request->post['product_id'], $quantity, $option);
                
				//$json['success'] = sprintf($this->language->get('text_success'), $this->url->link('product/product', 'product_id=' . $product_id), $product_info['name'], $this->url->link('checkout/cart'));
				$json['success'] = 1;
				
				
				// Totals
				$this->load->model('setting/extension');
				
				$total_data = array();					
				$total = 0;
				
				// Display prices
				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$sort_order = array(); 
					
					$results = $this->model_setting_extension->getExtensions('total');
					
					foreach ($results as $key => $value) {
						$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
					}
					
					array_multisort($sort_order, SORT_ASC, $results);
					
					foreach ($results as $result) {
						if ($this->config->get($result['code'] . '_status')) {
							$this->load->model('total/' . $result['code']);
				
							$this->{'model_total_' . $result['code']}->getTotal($total_data, $total);//, $taxes
						}
						
						$sort_order = array(); 
					  
						foreach ($total_data as $key => $value) {
							$sort_order[$key] = $value['sort_order'];
						}
			
						array_multisort($sort_order, SORT_ASC, $total_data);			
					}
				}
				//$json['total'] = sprintf($this->language->get('text_items'), $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0), number_format($total,2,'.',','));
                $vnum=isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0;
				$json['total'] = $this->cart->countProducts()+ $vnum ;
				
			    
			} else {
				$json['redirect'] = str_replace('&amp;', '&', $this->url->link('product/product', 'product_id=' . $product_id));
			
            }
            
           
		}
		
		$this->response->setOutput(json_encode($json));		
		
		//echo 1;
	}
	
	/**设置货运方法**/
	public function shippingMethod(){
	    $sd=$this->request->post['shippingmethod'];
		$arr=explode(',',$sd);
	    $this->session->data['shippingMethod']=$arr[0];
		
		$this->session->data['shipping_method']=array();
        if($arr[0]=='1'){
		    $this->session->data['shipping_method']['title']='快递公司';
			$this->session->data['shipping_method']['cost']=5.00;
		}elseif($arr[0]=='2'){
		    $this->session->data['shipping_method']['title']='EMS邮政专递';
			$this->session->data['shipping_method']['cost']=35.00;
		}elseif($arr[0]=='3'){
		    $this->session->data['shipping_method']=null;
		}elseif($arr[0]=='4'){
		    $this->session->data['shipping_method']=null;
		}
		//$this->response->setOutput(json_encode($this->session->data['shipping_method']));
	}
	
	public function country() {
		$json = array();
		
		$this->load->model('localisation/country');

    	$country_info = $this->model_localisation_country->getCountry($this->request->get['country_id']);
		
		if ($country_info) {
			$this->load->model('localisation/zone');

			$json = array(
				'country_id'        => $country_info['country_id'],
				'name'              => $country_info['name'],
				'iso_code_2'        => $country_info['iso_code_2'],
				'iso_code_3'        => $country_info['iso_code_3'],
				'address_format'    => $country_info['address_format'],
				'postcode_required' => $country_info['postcode_required'],
				'zone'              => $this->model_localisation_zone->getZonesByCountryId($this->request->get['country_id']),
				'status'            => $country_info['status']		
			);
		}
		
		$this->response->setOutput(json_encode($json));
	}
	
	/**刷新总计**/
	public function refreshTotal(){
	    $flag=false;
	    if (isset($this->request->get['dbuy']) && $this->request->get['dbuy']=='yes'){ //直接购买的
		    $flag=true;
		}
	   
		$total_data = array();
		$total = 0;
		 
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
				
				$this->{'model_total_' . $result['code']}->getTotal($total_data, $total,$flag);
			}
		}
		
		$sort_order = array(); 
	  
		foreach ($total_data as $key => $value) {
			$sort_order[$key] = $value['sort_order'];
		}

		array_multisort($sort_order, SORT_ASC, $total_data);
		$this->data['totals']=$total_data;
		
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/total.html')) {
			$this->template = $this->config->get('config_template') . '/template/checkout/total.html';
		} else {
			$this->template = 'default/template/checkout/total.html';
		}
		
		$this->response->setOutput($this->render());
	
	}
}
?>