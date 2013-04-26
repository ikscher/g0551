<?php 
class ControllerAccountHeader extends Controller {

	public function index() {
	  
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
	
		
		
		//$this->data['showType']='member'; //头部控制显示标志（公共部分，暂时不用）
		
		$this->data['logout'] =$this->url->link('account/logout','','SSL');
		$this->data['home'] = $this->url->link('common/home');//首页
		$this->data['clothes'] = $this->url->link('common/home/clothes');//衣服首页
		$this->data['foods'] = $this->url->link('common/home/foods');//食品首页
		$this->data['house'] = $this->url->link('common/home/house');//住房首页
		$this->data['travel'] = $this->url->link('common/home/travel');//行首页
		$this->data['joy'] = $this->url->link('common/home/joy');//爽首页
		
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
		
		//
		$this->data['telphone']=$this->language->get('telphone');
		
		//是否有店铺
		$store_id=isset($this->request->cookie['storeid'])?$this->cookie->OCAuthCode($this->request->cookie['storeid'],'DECODE'):'';
		$this->data['store_id']=isset($store_id)?$store_id:'';
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/header.html')) {
			$this->template = $this->config->get('config_template') . '/template/account/header.html';
		} else {
			$this->template = 'default/template/account/header.html';
		}
		
		
		$this->response->setOutput($this->render());
  	}


}
?>