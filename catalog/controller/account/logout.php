<?php 
class ControllerAccountLogout extends Controller {
	public function index() {
    	if ($this->customer->isLogged()) {
      		$this->customer->logout();
	  		$this->cart->clear();
			
			unset($this->session->data['wishlist']);
			unset($this->session->data['shipping_address_id']);
			unset($this->session->data['shipping_country_id']);
			unset($this->session->data['shipping_zone_id']);
			unset($this->session->data['shipping_postcode']);
			unset($this->session->data['shippingMethod']);
			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['payment_address_id']);
			unset($this->session->data['payment_country_id']);
			unset($this->session->data['payment_zone_id']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['comment']);
			unset($this->session->data['order_id']);
			unset($this->session->data['coupon']);
			unset($this->session->data['reward']);			
			unset($this->session->data['voucher']);
			unset($this->session->data['vouchers']);
			unset($this->session->data['dbuy_flag']);
			
			unset($this->session->data['customer_id']);

			/* $this->customer_id = '';
			$this->username = '';

			$this->email = '';
			$this->telphone = '';
			$this->fax = '';
			$this->newsletter = '';
			$this->customer_group_id = '';
			$this->address_id = ''; */
			//$this->cookie->OCSetCookie("customer",'');
			//$this->cookie->OCSetCookie("memberid",'');
			//$this->cookie->OCSetCookie("storeid",'');
			//$this->cookie->OCSetCookie("dbuyproduct",'');
			
      		//$this->redirect($this->url->link('account/logout', '', 'SSL'));
    	}
        
		if(isset($this->request->get['referer'])){
		    $referer=urldecode($this->request->get['referer']);
			$this->redirect($this->url->link($referer,'','SSL'));
		}else{
		    
			$this->language->load('account/logout');
			
			$this->document->setTitle($this->language->get('heading_title'));
			
			
			
			$this->data['heading_title'] = $this->language->get('heading_title');

			$this->data['text_message'] = $this->language->get('text_message');

			$this->data['button_continue'] = $this->language->get('button_continue');

			$this->data['continue'] = $this->url->link('common/home');
			
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
		
		
  	}
}
?>