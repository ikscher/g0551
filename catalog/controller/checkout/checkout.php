<?php  
class ControllerCheckoutCheckout extends Controller { 
	public function index() {
        //$flag=isset($this->session->data['dbuy_flag'])?$this->session->data['dbuy_flag']:true;
	
        $dbuy=isset($this->request->get['dbuy'])?$this->request->get['dbuy']:'';
		if ($dbuy==1){ //直接购买的
		    $products = $this->cart->getProducts(TRUE);
			$flag=true;
		}else{//购物车的
			// Validate cart has products and has stock.
			if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
				$this->redirect($this->url->link('checkout/cart'));
			}	
			$flag=false;
			// Validate minimum quantity requirments.			
			$products = $this->cart->getProducts();
		}	
        
        $this->data['flag']=$flag;		
	    
		
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
		$this->load->controller('checkout/payment_method');
		
	
		
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
		$this->load->model('store/store');
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
			
													
		

            $this->data['products'][$product['store_id']]['product'][] = array(
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

            $this->data['products'][$product['store_id']]['store'] = $this->model_store_store->getStore($product['store_id']);//店铺信息
			$this->data['products'][$product['store_id']]['payment_methods']= $this->controller_checkout_payment_method->index($product['store_id']);//店铺支付方式
		}
       
	    // var_dump($this->data['products']);
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
		
		//$this->data['payment_method_code']=isset($this->session->data['payment_method']['code'])?$this->session->data['payment_method']['code']:'';
	    $this->data['payment_method_code']='alipay';
		
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
	
	
	
	/**设置货运方法**/
	public function shippingMethod(){
	    $sm='';
		$arr=array();
	    $sm=strtolower($this->request->post['shipping_method']);
		$arr=explode(',',$sm);
	
		//$this->session->data['shipping_method']=array();
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
			$this->session->data['shipping_method']['cost']=0.00;
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
	
	
	/**刷新总计  已删除的函数**/
	public function refreshTotal(){
	    $flag=isset($this->session->data['dbuy_flag'])?$this->session->data['dbuy_flag']:true;
	   
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