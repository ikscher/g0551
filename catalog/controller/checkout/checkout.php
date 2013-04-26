<?php  
class ControllerCheckoutCheckout extends Controller { 
	public function index() {
        $flag=$this->session->data['dbuy_flag'];
	
		if ($flag==true){ //直接购买的
		    $products = $this->cart->getProducts(TRUE);
		
		}else{ //购物车的
			// Validate cart has products and has stock.
			if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
				$this->redirect($this->url->link('checkout/cart'));
			}	
			
			// Validate minimum quantity requirments.			
			$products = $this->cart->getProducts();
		}		
	     
		
		//支付方式
		$this->load->controller('checkout/payment_method');
		$this->data['payment_methods']=$this->controller_checkout_payment_method->index();
		
		//货运方式
		if(isset($this->session->data['shipping_method'])){
		    $this->data['shipping_method']=$this->session->data['shipping_method'];
		}else{
		    $this->data['shipping_method']=array();
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
				'telphone'  => $result['telphone'],
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
			
			
			
			// Display prices
			$price = number_format($product['price'],2,'.',',');
			$total = number_format($product['price'] * $product['quantity'],2,'.',',');
			
													
			$this->data['products'][] = array(
				'key'      => $product['key'],
				'thumb'    => $image,
				'name'  => $product['name'],
				'model'    => $product['model'], 
				//'option'   => $option_data,
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
		
      
		$this->data['logged'] = $this->customer->isLogged();
		$this->data['shipping_required'] = $this->cart->hasShipping($flag);	
		
		$this->data['payment_method_code']=isset($this->session->data['payment_method']['code'])?$this->session->data['payment_method']['code']:'';
		//$this->data['payment'] = $this->getChild('payment/' . $this->session->data['payment_method']['code']);
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
	    //设置标志位
		$this->session->data['dbuy_flag']=true;
	
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
		    //$option=isset($this->request->post['option'])?$this->request->post['option']:array();
			$price=isset($this->request->post['price'])?$this->request->post['price']:0;
			$attribute=isset($this->request->post['attribute'])?$this->request->post['attribute']:array();
	  
	        /* if (empty($option)) {
				$key = (int)$product_id;
			} else {
				$key = (int)$product_id . ':' . base64_encode(serialize($option));
			} */
			$key = (int)$product_id . '|' . base64_encode(serialize($attribute)).'|'.$price;
		
			 if ((int)$qty && ((int)$qty > 0)) {	
				$arrMenu=array($key=>(int)$qty);
				//array_walk_recursive($arrMenu,'formatSerialize');
				$this->cookie->OCSetCookie('dbuyproduct',base64_encode(serialize($arrMenu)),24*3600);
				
			}
            
			
			$product_attributes=$this->model_catalog_product->getProductAttributes($product_id,'option');
			foreach ($product_attributes as $product_attribute) {
				if (empty($attribute[$product_attribute['attribute_group_id']])) {
					$json['error']['attribute'][$product_attribute['attribute_group_id']] = sprintf($this->language->get('error_required'), $product_attribute['attribute_group_name']);
				}
			}
			
		    
			/* $product_options = $this->model_catalog_product->getProductOptions($product_id);
		
			foreach ($product_options as $product_option) {
				if (empty($option[$product_option['product_option_id']])) {
					$json['error']['option'][$product_option['product_option_id']] = sprintf($this->language->get('error_required'), $product_option['attribute_group_name']);
				}
			} */
			
			
		
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
				
							$this->{'model_total_' . $result['code']}->getTotal($total_data, $total,$this->session->data['dbuy_flag']);//, $taxes
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
	    $sm=strtolower($this->request->post['shipping_method']);
		$arr=explode(',',$sm);
	
		$this->session->data['shipping_method']=array();
        if(in_array('express',$arr)){
		    $this->session->data['shipping_method']['title']='快递公司';
			$this->session->data['shipping_method']['cost']=5.00;
			$this->session->data['shipping_method']['code']='express';
		}elseif(in_array('ems',$arr)){
		    $this->session->data['shipping_method']['title']='EMS邮政专递';
			$this->session->data['shipping_method']['cost']=35.00;
			$this->session->data['shipping_method']['code']='ems';
		}elseif(in_array('diy',$arr)){
		    $this->session->data['shipping_method']['title']='上门自提';
			$this->session->data['shipping_method']['cost']='0.00';
			$this->session->data['shipping_method']['code']='diy';
		}
		$this->response->setOutput(json_encode($this->session->data['shipping_method']));
	}
	
	/**设置支付方式**/
	public function paymentMethod(){
	    $pm=$this->request->post['payment_method'];
		$this->session->data['payment_method']['code']=$pm;
		$this->response->setOutput(json_encode(array('code'=>$pm)));
	}
	
	
	/**刷新总计**/
	public function refreshTotal(){
	    $flag=$this->session->data['dbuy_flag'];
	   
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