<?php 
/**
 *商家中心左侧列表
 */
class ControllerMerchantsLeft extends Controller {

	public function index() {
	    $this->load->language('merchants/left');
		
		$this->data['store_management']=$this->language->get('store_management');
		$this->data['store_list']=$this->language->get('store_list');
		$this->data['trade_management']=$this->language->get('trade_management');
		$this->data['iopenstore']=$this->language->get('iopenstore');
		$this->data['store_setup']=$this->language->get('store_setup');
		$this->data['soldproduct']=$this->language->get('soldproduct');
		$this->data['remark_management']=$this->language->get('remark_management');
		$this->data['product_management']=$this->language->get('product_management');
		$this->data['releaseproduct']=$this->language->get('releaseproduct');
		$this->data['sellingproduct']=$this->language->get('sellingproduct');
		$this->data['baseproduct']=$this->language->get('baseproduct');
		$this->data['order_management']=$this->language->get('order_management');
		$this->data['waitingorder']=$this->language->get('waitingorder');
		$this->data['dealingorder']=$this->language->get('dealingorder');
		$this->data['createorder']=$this->language->get('createorder');
		$this->data['dealedorder']=$this->language->get('dealedorder');
		$this->data['discount_management']=$this->language->get('discount_management');
		$this->data['coupons']=$this->language->get('coupons');
		
		$this->data['vouchers']=$this->language->get('vouchers');
		$this->data['coupon_adds']=$this->language->get('coupon_adds');
		
		
		
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
			if($customer['hasshop'])  $this->data['hasShop']=$customer['hasshop'];
		}	

		$this->data['merchants'] = $this->url->link('merchants/merchants', '', 'SSL');
		$this->data['store']=$this->url->link('store/store&store_id='.$store_id,'','SSL');
		$this->data['sold'] = $this->url->link('merchants/sold', '', 'SSL');
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