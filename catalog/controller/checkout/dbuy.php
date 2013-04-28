<?php 
class ControllerCheckoutDbuy extends Controller {
/**直接购买 *ajax*/
	public function index(){
	    //设置标志位
		//$this->session->data['dbuy_flag']=true;
	
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
				//$this->memcached->set('dbuyproduct',base64_encode(serialize($arrMenu)),24*3600);
				
			}
            
			
			$product_attributes=$this->model_catalog_product->getProductAttributes($product_id,'option');
	
			if(!empty($product_attributes)){
				foreach ($product_attributes as $product_attribute) {
					if (empty($attribute[$product_attribute['attribute_group_id']])) {
						$json['error']['attribute'][$product_attribute['attribute_group_id']] = sprintf($this->language->get('error_required'), $product_attribute['attribute_group_name']);
					}
				}
			}
		    
		
		
			if (empty($json)) {
			   
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
				
							$this->{'model_total_' . $result['code']}->getTotal($total_data, $total,true);//, $taxes
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
}
?>