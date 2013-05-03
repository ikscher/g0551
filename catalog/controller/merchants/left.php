<?php 
/**
 *商家中心左侧列表
 */
class ControllerMerchantsLeft extends Controller {

	public function index() {
	    $this->load->language('merchants/left');
		
		$this->data['text_store_management']=$this->language->get('text_store_management');
		$this->data['text_store_list']=$this->language->get('text_store_list');
		$this->data['text_trade_management']=$this->language->get('text_trade_management');
		$this->data['text_iopenstore']=$this->language->get('text_iopenstore');
		$this->data['text_store_setup']=$this->language->get('text_store_setup');
		$this->data['text_soldproduct']=$this->language->get('text_soldproduct');
		$this->data['text_remark_management']=$this->language->get('text_remark_management');
		$this->data['text_product_management']=$this->language->get('text_product_management');
		$this->data['text_releaseproduct']=$this->language->get('text_releaseproduct');
		$this->data['text_sellingproduct']=$this->language->get('text_sellingproduct');
		$this->data['text_baseproduct']=$this->language->get('text_baseproduct');
		$this->data['text_order_management']=$this->language->get('text_order_management');
		$this->data['text_waitingorder']=$this->language->get('text_waitingorder');
		$this->data['text_dealingorder']=$this->language->get('text_dealingorder');
		$this->data['text_createorder']=$this->language->get('text_createorder');
		$this->data['text_dealedorder']=$this->language->get('text_dealedorder');
		$this->data['text_discount_management']=$this->language->get('text_discount_management');
		$this->data['text_coupons']=$this->language->get('text_coupons');
		$this->data['text_return']=$this->language->get('text_return');
		$this->data['text_payment_management']=$this->language->get('text_payment_management');
		
		$this->data['text_vouchers']=$this->language->get('text_vouchers');
		$this->data['text_coupon_adds']=$this->language->get('text_coupon_adds');
		
		
		
	    if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/merchants/left.html')) {
			$this->template = $this->config->get('config_template') . '/template/merchants/left.html';
		} else {
			$this->template = 'default/template/merchants/left.html';
		}
		
		if(!$this->customer->getId()){
		    $this->redirect($this->url->link('account/login','','SSL'));
		}
		
		
		/* $store_id=$this->cookie->OCAuthCode($this->request->cookie['storeid'],'DECODE');
		if(empty($store_id)){
			$this->showMessage("您还未登陆");
		} */
		
		//会员是否有店铺
		$customer=array();
		$this->data['hasShop']='';
		if(isset($this->request->cookie['customer']))  {
		    $customer=unserialize($this->cookie->OCAuthCode($this->request->cookie['customer'],'DECODE'));
			if($customer['store_id']) {
			    $store_id=$customer['store_id'];
			}else{
			    $store_id=$this->customer->getStoreId();
			}
		}
		
		if($customer['hasshop']){
		    $this->data['hasShop']=$customer['hasshop'];
		}else{ 
		    $this->load->model('account/customer');
			$customer=$this->model_account_customer->getCustomer($this->customer->getId(),$store_id);
			if(!empty($customer['hasshop']))  $this->data['hasShop']=$customer['hasshop'];
		}	

		$this->data['merchants'] = $this->url->link('merchants/merchants', '', 'SSL');
		$this->data['store']=$this->url->link('store/store&store_id='.$store_id,'','SSL');
		$this->data['sold'] = $this->url->link('merchants/sold', '', 'SSL');
		$this->data['return']=$this->url->link('merchants/return','','SSL');
		$this->data['payment']=$this->url->link('merchants/payment','','SSL');
    	$this->data['release'] = $this->url->link('merchants/release', '', 'SSL');
		$this->data['remark'] = $this->url->link('merchants/remark', '', 'SSL');
		$this->data['sell'] = $this->url->link('merchants/sell');
		$this->data['order_'] = $this->url->link('merchants/order_create');
		$this->data['order'] = $this->url->link('merchants/order');
		$this->data['ordering'] = $this->url->link('merchants/ordering');
		$this->data['ordered'] = $this->url->link('merchants/ordered');
        $this->data['coupon_add'] = $this->url->link('merchants/coupon/add');
		$this->data['coupon'] = $this->url->link('merchants/coupon');
		$this->data['voucher'] = $this->url->link('merchants/voucher');
		$this->data['warehouse'] = $this->url->link('merchants/warehouse');
		
		$this->response->setOutput($this->render());
  	}


}
?>