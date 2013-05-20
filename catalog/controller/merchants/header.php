<?php 
	/**
	*   商家中心头部
	*/
class ControllerMerchantsHeader extends Controller {

	public function index() {
	    $this->load->language('merchants/header');
		
		$this->data['homepage']=$this->language->get('homepage');
		$this->data['quit']=$this->language->get('quit');
		$this->data['favoriate']=$this->language->get('favoriate');
		$this->data['welcome']=$this->language->get('welcome');
		$this->data['title']=$this->language->get('title');
		$this->data['telphone']=$this->language->get('telphone');
		
		//==navigation icon===
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$server = HTTPS_IMAGE;
		} else {
			$server = HTTP_IMAGE;
		}

		if ($this->config->get('config_icon') && file_exists(DIR_IMAGE . $this->config->get('config_icon'))) {
			$this->data['icon'] = $server . $this->config->get('config_icon');
		} else {
			$this->data['icon'] = '';
		}
		//==navigation icon===
		
		if (!$this->customer->isLogged() && !$this->request->cookie['customer']) {
			$this->session->data['redirect'] = $this->url->link('account/edit', '', 'SSL');
            $this->data['username']='';
			$this->redirect($this->url->link('account/login', '', 'SSL'));
		}else{
		     //是否有店铺
			$store_id=isset($this->request->cookie['storeid'])?$this->cookie->OCAuthCode($this->request->cookie['storeid'],'DECODE'):'';
			$this->data['store_id']=isset($store_id)?$store_id:'';
		     // $customer=isset($this->session->data['customer'])?$this->session->data['customer']:'';
			if(isset($this->request->cookie['customer'])){
				$customer=$this->cookie->OCAuthCode($this->request->cookie['customer'],'DECODE');
				$customer=unserialize($customer);
				if(!empty($store_id)){
				    $this->data['username']=$customer['shortname'];
				}else{
				    $this->data['username']=$customer['email'];
				}
			}
		
		}
	    
		$this->load->model('catalog/category');
		/* 
		$this->data['logout'] =$this->url->link('account/logout','','SSL');
		$this->data['home'] = $this->url->link('common/home');//首页
		$this->data['clothes'] = $this->url->link('common/home/clothes');//衣服首页
		$this->data['foods'] = $this->url->link('common/home/foods');//食品首页
		$this->data['house'] = $this->url->link('common/home/house');//住房首页
		$this->data['travel'] = $this->url->link('common/home/travel');//行首页 */
        
		$this->data['logout'] =$this->url->link('account/logout','','SSL');
		$this->data['home'] = $this->url->link('common/home');//首页
		$this->data['joy'] = $this->url->link('common/home/joy');//爽首页 
		$this->data['clothes'] = $this->url->link('product/category','category_id='.ModelCatalogCategory::$CATEGORY_CLOTHES,'SSL');
		$this->data['foods']   = $this->url->link('product/category','category_id='.ModelCatalogCategory::$CATEGORY_FOODS,'SSL');
		$this->data['house']   = $this->url->link('product/category','category_id='.ModelCatalogCategory::$CATEGORY_HOUSE,'SSL');
		$this->data['travel']   = $this->url->link('product/category','category_id='.ModelCatalogCategory::$CATEGORY_TRAVEL,'SSL');
		
		
		//我的穿悦
		$this->data['account']=$this->url->link('account/account','','SSL');
		$this->data['wishlist'] = $this->url->link('account/wishlist','','SSL');
    	$this->data['order'] = $this->url->link('account/order', '', 'SSL');
		$this->data['return'] = $this->url->link('account/return', '', 'SSL');
		$this->data['transaction'] = $this->url->link('account/transaction', '', 'SSL');
		
		//卖家中心
		$this->data['merchants']=$this->url->link('merchants/merchants','','SSL');
		$this->data['sell']=$this->url->link('merchants/sell','','SSL');
		$this->data['sold']=$this->url->link('merchants/sold','','SSL');
		$this->data['remark']=$this->url->link('merchants/remark','','SSL');
		$this->data['release']=$this->url->link('merchants/release','','SSL');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/merchants/header.html')) {
			$this->template = $this->config->get('config_template') . '/template/merchants/header.html';
		} else {
			$this->template = 'default/template/merchants/header.html';
		}
		
		
		$this->response->setOutput($this->render());
  	}


}
?>