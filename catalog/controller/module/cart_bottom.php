<?php 
/**底部购物车**/
class ControllerModuleCartBottom extends Controller {
	public function index() {
		
	    
		
		//购物车的物品数量（件）
		$this->data['countProducts']=0;
		$this->data['countProducts']=$this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0);
        $this->data['userid']=$this->customer->getId();
	
		
      	if (isset($this->request->get['remove'])) {
          	$this->cart->remove($this->request->get['remove']);
			
			unset($this->session->data['vouchers'][$this->request->get['remove']]);
      	}	
      
		
		// Totals
		$this->load->model('setting/extension');
		
		$total_data = array();					
		$total=0;//$total = 0;
		
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
		
					$this->{'model_total_' . $result['code']}->getTotal($total_data, $total,isset($this->session->data['dbuy_flag'])?$this->session->data['dbuy_flag']:false);
				}
				
				$sort_order = array(); 
			  
				foreach ($total_data as $key => $value) {
					$sort_order[$key] = $value['sort_order'];
				}
	
				array_multisort($sort_order, SORT_ASC, $total_data);			
			}		
		}
		
		$this->data['totals'] = $total_data;
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		//$this->data['text_items'] = sprintf($this->language->get('text_items'), $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0), $this->currency->format($total));
		$this->data['text_empty'] = $this->language->get('text_empty');
		$this->data['text_cart'] = $this->language->get('text_cart');
		$this->data['text_checkout'] = $this->language->get('text_checkout');
		
		$this->data['button_remove'] = $this->language->get('button_remove');
	
		$this->load->model('tool/image');
		
		$this->data['products'] = array();
			
		foreach ($this->cart->getProducts() as $product) {
			if ($product['image']) {
				$image = $this->model_tool_image->resize($product['image'], $this->config->get('config_image_cart_width'), $this->config->get('config_image_cart_height'));
			} else {
				$image = '';
			}
							
			/* $option_data = array();
			
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
					'type'  => $option['type']
				);
			} */
			
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
				'allname'  => $product['name'],
				'name'     => OcCutstr($product['name'],18,'...'),
				'model'    => $product['model'], 
				//'option'   => $option_data,
				'quantity' => $product['quantity'],
				'price'    => $price,	
				'total'    => $total,	
				'href'     => $this->url->link('product/product', 'product_id=' . $product['product_id'])		
			);
		}
		
		// Gift Voucher
		$this->data['vouchers'] = array();
		
		if (!empty($this->session->data['vouchers'])) {
			foreach ($this->session->data['vouchers'] as $key => $voucher) {
				$this->data['vouchers'][] = array(
					'key'         => $key,
					'description' => $voucher['description'],
					'amount'      => number_format($voucher['amount'],2,'.',',')
				);
			}
		}
					
		$this->data['cart'] = $this->url->link('checkout/cart');
						
		$this->data['checkout'] = $this->url->link('checkout/checkout', '', 'SSL');
	
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/cart_bottom.html')) {
			$this->template = $this->config->get('config_template') . '/template/module/cart_bottom.html';
		} else {
			$this->template = 'default/template/module/cart_bottom.html';
		}
				
		$this->response->setOutput($this->render());		
	}
}
?>