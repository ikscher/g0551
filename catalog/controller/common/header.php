<?php
class ControllerCommonHeader extends Controller {
    
    /**
     * show 
     **/
    public function index(){   
	    $title=$this->document->getTitle();
	    $this->data['title'] = isset($title)?$title:'穿悦商城，衣食住行爽';
		$this->data['description'] = $this->document->getDescription();
		$this->data['keywords'] = $this->document->getKeywords();
		$this->data['links'] = $this->document->getLinks();
		$this->data['styles'] = $this->document->getStyles();
		$this->data['scripts'] = $this->document->getScripts();
		$this->data['lang'] = $this->language->get('code');
		$this->data['direction'] = $this->language->get('direction');
		$this->data['google_analytics'] = html_entity_decode($this->config->get('config_google_analytics'), ENT_QUOTES, 'UTF-8');

		
		
	    $this->data['list_channel_title']='clothes';
		$flag=true; //标志位
	    $this->load->model('catalog/category');	
        
		$uri=$this->request->server['REQUEST_URI'];
		
		$category_id=isset($this->request->get['category_id'])?$this->request->get['category_id']:null;
		
        $this->data['subCategoryList']=array();
		/**衣 默认*/ 
		if($flag==true){
			$clothes_cid=$this->model_catalog_category->getCategories(ModelCatalogCategory::$CATEGORY_CLOTHES);
			$this->data['subCategoryList']=$this->model_catalog_category->getSubCategories(ModelCatalogCategory::$CATEGORY_CLOTHES);
			
			if(preg_match('/clothes/i',$uri)){
				$this->data['list_channel_title']='clothes';
			}
			foreach($clothes_cid as $v){
				if($category_id==$v['category_id'] || $category_id==ModelCatalogCategory::$CATEGORY_CLOTHES ){
					$this->data['list_channel_title']='clothes';
					$flag=false;
					break;
				 
				}
			}
			$clothes_cid=null;
		}
	
		/**食*/
		if($flag==true){
			$foods_cid=$this->model_catalog_category->getCategories(ModelCatalogCategory::$CATEGORY_FOODS);
			if(preg_match('/foods/i',$uri)){
				$this->data['list_channel_title']='foods';
				$this->data['subCategoryList']=$this->model_catalog_category->getSubCategories(ModelCatalogCategory::$CATEGORY_FOODS);
			}
		
			foreach($foods_cid as $v){
				if($category_id==$v['category_id'] || $category_id==ModelCatalogCategory::$CATEGORY_FOODS){
				    $this->data['list_channel_title']='foods';
					$flag=false;
					$this->data['subCategoryList']=$this->model_catalog_category->getSubCategories(ModelCatalogCategory::$CATEGORY_FOODS);
				    break;
				}
			}
			$foods_cid=null;
		}
		
		
		/**住*/
		if($flag==true){
			$house_cid=$this->model_catalog_category->getCategories(ModelCatalogCategory::$CATEGORY_HOUSE);
			if(preg_match('/house/i',$uri)){
				$this->data['list_channel_title']='house';
				$this->data['subCategoryList']=$this->model_catalog_category->getSubCategories(ModelCatalogCategory::$CATEGORY_HOUSE);
			}
		
			foreach($house_cid as $v){
				if($category_id==$v['category_id'] || $category_id==ModelCatalogCategory::$CATEGORY_HOUSE){
				    $this->data['list_channel_title']='house';
					$flag=false;
					$this->data['subCategoryList']=$this->model_catalog_category->getSubCategories(ModelCatalogCategory::$CATEGORY_HOUSE);
				    break;
				}
			}
			$house_cid=null;
		}
		
		
		/**行*/
		if($flag==true){
			$travel_cid=$this->model_catalog_category->getCategories(ModelCatalogCategory::$CATEGORY_TRAVEL);
			if(preg_match('/travel/i',$uri)){
				$this->data['list_channel_title']='travel';
				$this->data['subCategoryList']=$this->model_catalog_category->getSubCategories(ModelCatalogCategory::$CATEGORY_TRAVEL);
			}
		
			foreach($travel_cid as $v){
			   if($category_id==$v['category_id'] || $category_id==ModelCatalogCategory::$CATEGORY_TRAVEL){
				    $this->data['list_channel_title']='travel';
					$flag=false;
					$this->data['subCategoryList']=$this->model_catalog_category->getSubCategories(ModelCatalogCategory::$CATEGORY_TRAVEL);
				  	break;
				}
			}
			$travel_cid=null;
		}
		
		
		/**爽*/
		if($flag==true){
			$joy_cid=$this->model_catalog_category->getCategories(ModelCatalogCategory::$CATEGORY_JOY);
			if(preg_match('/joy/i',$uri)){
			   $this->data['list_channel_title']='joy';
			   $this->data['subCategoryList']=$this->model_catalog_category->getSubCategories(ModelCatalogCategory::$CATEGORY_JOY);
			}
		
		    
			foreach($joy_cid as $v){
			   if($category_id==$v['category_id'] || $category_id==ModelCatalogCategory::$CATEGORY_JOY){
				    $this->data['list_channel_title']='joy';
					$flag=false;
					$this->data['subCategoryList']=$this->model_catalog_category->getSubCategories(ModelCatalogCategory::$CATEGORY_JOY);
				  	break;
				}
			}
			$joy_cid=null;
		}
		
		
		
		//依据对应的产品显示对应的头部=====================>>>>>>>
		$pid=isset($this->request->get['product_id'])?$this->request->get['product_id']:0;
		$topPid='';
		if(!empty($pid)){
			$this->load->model('catalog/product');
			$topPid=$this->model_catalog_product->getTopCidByPid($pid);
	    }
		
		/****************************************************************************
		static $CATEGORY_CLOTHES = 148; //衣
		static $CATEGORY_FOODS = 219; //食
		static $CATEGORY_HOUSE = 279; //住
		static $CATEGORY_TRAVEL = 324; //行
		static $CATEGORY_JOY = 332; //爽
		*****************************************************************************/
		switch($topPid){
		    case ModelCatalogCategory::$CATEGORY_CLOTHES:
			    $this->data['list_channel_title']='clothes';
				$this->data['subCategoryList']=$this->model_catalog_category->getSubCategories(ModelCatalogCategory::$CATEGORY_CLOTHES);
				break;
			case ModelCatalogCategory::$CATEGORY_FOODS:
			    $this->data['list_channel_title']='foods';
				$this->data['subCategoryList']=$this->model_catalog_category->getSubCategories(ModelCatalogCategory::$CATEGORY_FOODS);
				break;
			case ModelCatalogCategory::$CATEGORY_HOUSE :
			    $this->data['list_channel_title']='house';
				$this->data['subCategoryList']=$this->model_catalog_category->getSubCategories(ModelCatalogCategory::$CATEGORY_HOUSE);
				break;
			case ModelCatalogCategory::$CATEGORY_TRAVEL:
			    $this->data['list_channel_title']='travel';
				$this->data['subCategoryList']=$this->model_catalog_category->getSubCategories(ModelCatalogCategory::$CATEGORY_TRAVEL);
				break;
			case ModelCatalogCategory::$CATEGORY_JOY:
			    $this->data['list_channel_title']='joy';
				$this->data['subCategoryList']=$this->model_catalog_category->getSubCategories(ModelCatalogCategory::$CATEGORY_JOY);
				break;
		}
		//<<<<=============================================================
		
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$this->data['base'] = $this->config->get('config_ssl');
		} else {
			$this->data['base'] = $this->config->get('config_url');
		}

		// Whos Online
		if ($this->config->get('config_customer_online')) {
			$this->load->model('tool/online');

			if (isset($this->request->server['REMOTE_ADDR'])) {
				$ip = $this->request->server['REMOTE_ADDR'];
			} else {
				$ip = '';
			}

			if (isset($this->request->server['HTTP_HOST']) && isset($this->request->server['REQUEST_URI'])) {
				$url = 'http://' . $this->request->server['HTTP_HOST'] . $this->request->server['REQUEST_URI'];
			} else {
				$url = '';
			}

			if (isset($this->request->server['HTTP_REFERER'])) {
				$referer = $this->request->server['HTTP_REFERER'];
			} else {
				$referer = '';
			}

			$this->model_tool_online->whosonline($ip, $this->customer->getId(), $url, $referer);
		}

		$this->language->load('common/header');

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

		$this->data['name'] = $this->config->get('config_name');

		if ($this->config->get('config_logo') && file_exists(DIR_IMAGE . $this->config->get('config_logo'))) {
			$this->data['logo'] = $server . $this->config->get('config_logo');
		} else {
			$this->data['logo'] = '';
		}
  
		$this->data['text_home'] = $this->language->get('text_home');
		$this->data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
		$this->data['text_shopping_cart'] = $this->language->get('text_shopping_cart');
    	$this->data['text_search'] = $this->language->get('text_search');
		$this->data['text_welcome'] = sprintf($this->language->get('text_welcome'), $this->url->link('account/login', '', 'SSL'), $this->url->link('account/register', '', 'SSL'));
		$this->data['text_logged'] = sprintf($this->language->get('text_logged'), $this->url->link('account/account', '', 'SSL'), $this->customer->getUserName(), $this->url->link('account/logout', '', 'SSL'));
		$this->data['text_account'] = $this->language->get('text_account');
    	$this->data['text_checkout'] = $this->language->get('text_checkout');
        
		$this->data['text_login']=$this->url->link('account/login', '', 'SSL');
		$this->data['text_register']=$this->url->link('account/register', '', 'SSL');
		$this->data['text_logout']=$this->url->link('account/logout', '', 'SSL');
		$this->data['home'] = $this->url->link('common/home');
		$this->data['wishlist'] = $this->url->link('account/wishlist', '', 'SSL');
		$this->data['logged'] = $this->customer->isLogged();
		$this->data['account'] = $this->url->link('account/account', '', 'SSL');
		$this->data['merchants'] = $this->url->link('merchants/merchants', '', 'SSL');
		$this->data['shoppingcart'] = $this->url->link('checkout/cart','','SSL');
		$this->data['checkout'] = $this->url->link('checkout/checkout', '', 'SSL');		
		
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
		
		//购物车的物品数量（件）
		$this->data['countProducts']=$this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0);


		if (isset($this->request->get['filter_name'])) {
			$this->data['filter_name'] = $this->request->get['filter_name'];
		} else {
			$this->data['filter_name'] = '';
		}
        
		//子模板加载
		$this->children = array(
			//'module/language',
			//'module/currency',
			'module/cart'
		);
		
		//是否有店铺
		$store_id=isset($this->request->cookie['storeid'])?$this->cookie->OCAuthCode($this->request->cookie['storeid'],'DECODE'):'';
		$this->data['store_id']=isset($store_id)?$store_id:'';
		
		
		//登录的用户名
		if ($this->customer->isLogged()){
		    // $customer=isset($this->session->data['customer'])?$this->session->data['customer']:'';
			if(isset($this->request->cookie['oc_customer'])){
				$customer=$this->cookie->OCAuthCode($this->request->cookie['customer'],'DECODE');
				$customer=unserialize($customer);
				
				if(!empty($store_id)){
				    $this->data['username']=$customer['shortname'];
				}else{
				    $this->data['username']=$customer['email'];
				}
			}
		}else{
		    $this->data['username']='';
			//$this->redirect($this->url->link('account/login'));
		}
		
		
		
		//
		$this->data['telphone']=$this->language->get('telphone');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/header.html')) {
			$this->template = $this->config->get('config_template') . '/template/common/header.html';
		} else {
			$this->template = 'default/template/common/header.html';
		}

    	$this->render();
    }
    
}
?>