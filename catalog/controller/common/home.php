<?php  
class ControllerCommonHome extends Controller {
    
	/**
	*  首页  
	*/
	public function index(){
	    $time=time();

		$this->document->setTitle($this->config->get('config_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));

		$this->data['heading_title'] = $this->config->get('config_title');
		$this->load->model('catalog/category');	
		$this->load->model('catalog/product');
		$this->load->model('tool/image');
		
		
		//衣
		$clothes_products=array();
		$results=$this->model_catalog_product->getProductByCategoryId(ModelCatalogCategory::$CATEGORY_CLOTHES,20,'date_added');
		foreach($results as $v){
		    if(empty($v)) continue;
		    if ($v['image']) {
				$v['image'] = $this->model_tool_image->resize($v['image'], 160, 160);                    
			} else {
				$v['image'] = false;
			}   
			$v['name']=isset($v['name'])?$v['name']:null;
            $v['shortname']=isset($v['name'])?OcCutstr($v['name'],20):'';	
            $v['price']=isset($v['price'])?$v['price']:null;
			if(isset($v['special']['date_start']) && isset($v['special']['date_end'])){
				if(strtotime($v['special']['date_start'])<$time && strtotime($v['special']['date_end'])>$time){
					$v['special_price']=$v['special']['price'];
				}
            }				
			$products[]=$v;		
		}
		$this->data['clothes_products']=array_slice($products,0,10);
		$results=null;
		$products=null;
		
		//食
		$foods_products=array();
		$results=$this->model_catalog_product->getProductByCategoryId(ModelCatalogCategory::$CATEGORY_FOODS,20,'date_added');
		foreach($results as $v){
		    if(empty($v)) continue;
		    if ($v['image']) {
				$v['image'] = $this->model_tool_image->resize($v['image'], 160, 160);                    
			} else {
				$v['image'] = false;
			}   
			$v['name']=isset($v['name'])?$v['name']:null;
            $v['shortname']=isset($v['name'])?OcCutstr($v['name'],20):'';	
            $v['price']=isset($v['price'])?$v['price']:null;
			if(isset($v['special']['date_start']) && isset($v['special']['date_end'])){
				if(strtotime($v['special']['date_start'])<$time && strtotime($v['special']['date_end'])>$time){
					$v['special_price']=$v['special']['price'];
				}	
            }				
			$products[]=$v;		
		}
		$this->data['foods_products']=array_slice($products,0,10);
		$results=null;
		$products=null;
		
		
		//住
		$house_products=array();
		$results=$this->model_catalog_product->getProductByCategoryId(ModelCatalogCategory::$CATEGORY_HOUSE,20,'date_added');
		foreach($results as $v){
		    if(empty($v)) continue;
		    if ($v['image']) {
				$v['image'] = $this->model_tool_image->resize($v['image'], 160, 160);                    
			} else {
				$v['image'] = false;
			}   
			$v['name']=isset($v['name'])?$v['name']:null;
            $v['shortname']=isset($v['name'])?OcCutstr($v['name'],16):'';	
            $v['price']=isset($v['price'])?$v['price']:null;
			if(isset($v['special']['date_start']) && isset($v['special']['date_end'])){
				if(strtotime($v['special']['date_start'])<$time && strtotime($v['special']['date_end'])>$time){
					$v['special_price']=$v['special']['price'];
				}	
            }				
			$products[]=$v;		
		}
		$this->data['house_products']=array_slice($products,0,10);
		$results=null;
		$products=null;
		
		//行
		$travel_products=array();
		$results=$this->model_catalog_product->getProductByCategoryId(ModelCatalogCategory::$CATEGORY_TRAVEL,20,'date_added');
		foreach($results as $v){
		    if(empty($v)) continue;
		    if ($v['image']) {
				$v['image'] = $this->model_tool_image->resize($v['image'], 160, 160);                    
			} else {
				$v['image'] = false;
			}   
			$v['name']=isset($v['name'])?$v['name']:null;
            $v['shortname']=isset($v['name'])?OcCutstr($v['name'],16):'';	
            $v['price']=isset($v['price'])?$v['price']:null;
			if(isset($v['special']['date_start']) && isset($v['special']['date_end'])){			
				if(strtotime($v['special']['date_start'])<$time && strtotime($v['special']['date_end'])>$time){
					$v['special_price']=$v['special']['price'];
				}			
		    }
			$products[]=$v;		
		}
		$this->data['travel_products']=array_slice($products,0,10);
		$results=null;
		$products=null;
		
		
		
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
		
		$this->data['telphone']=$this->language->get('telphone');
		
		
		$this->data['clothes'] = $this->url->link('product/category','category_id='.ModelCatalogCategory::$CATEGORY_CLOTHES,'SSL');
		$this->data['foods']   = $this->url->link('product/category','category_id='.ModelCatalogCategory::$CATEGORY_FOODS,'SSL');
		$this->data['house']   = $this->url->link('product/category','category_id='.ModelCatalogCategory::$CATEGORY_HOUSE,'SSL');
		$this->data['travel']   = $this->url->link('product/category','category_id='.ModelCatalogCategory::$CATEGORY_TRAVEL,'SSL');
		/* $this->data['joy']   = $this->url->link('product/category','category_id='.ModelCatalogCategory::$CATEGORY_JOY,'SSL'); */
		$this->data['joy']    =  $this->url->link('common/home/joy','','SSL');
		
		$this->load->controller('common/left');
		$this->data['category_list']=$this->controller_common_left->getCategoryList();
		
		
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/home.html')) {
			$this->template = $this->config->get('config_template') . '/template/common/home.html';
		} else {
			$this->template = 'default/template/common/home.html';
		}

        $this->data['header'] = $this->getChild('common/header');
        $this->data['footer'] = $this->getChild('common/footer');
		
	
	    $this->response->setOutput($this->render());
	

	} 
    
	/**
	*   默认首页
	* 
	*/
	
	
	/* public function index() 
    
	{    

		$this->clothes();
    }
     */

	/**
	*  衣服首页 ***********穿
	*/
	/* public function clothes(){
	    $this->load->model('catalog/product');
		$this->load->model('tool/image');
		$this->load->library('func');

		$this->document->setTitle($this->config->get('config_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));

		$this->data['heading_title'] = $this->config->get('config_title');
		
		
		
		//热销榜  =>羽绒服
		$hot_products=array();
		$hot_results=$this->model_catalog_product->getProductByCategoryId('148',8,'hots');
		foreach($hot_results as $v){
		    if(empty($v)) continue;
		    if ($v['image']) {
				$v['image'] = $this->model_tool_image->resize($v['image'], 179, 249);                    
			} else {
				$v['image'] = false;
			}   
			$v['name']=isset($v['name'])?$v['name']:null;
            $v['shortname']=isset($v['name'])?OcCutstr($v['name'],16):'';	
            $v['price']=isset($v['price'])?$v['price']:null;			
			$hot_products[]=$v;		
		}
		$this->data['hot_products']=array_slice($hot_products,0,4);
		$hot_results=null;
		
		//最新产品 
		$new_products=array();
		$new_results=$this->model_catalog_product->getProductByCategoryId('148',8,'date_added');
		foreach($new_results as $v){
		    if(empty($v)) continue;
		    if ($v['image']) {
				$v['image'] = $this->model_tool_image->resize($v['image'], 179, 249);                    
			} else {
				$v['image'] = false;
			}   
			$v['name']=isset($v['name'])?$v['name']:null;
            $v['shortname']=isset($v['name'])?OcCutstr($v['name'],16):'';	
            $v['price']=isset($v['price'])?$v['price']:null;			
			$new_products[]=$v;		
		}
		$this->data['new_products']=array_slice($new_products,0,4);
		$new_results=null;
		
		//人气产品
		$view_products=array();
		$view_results=$this->model_catalog_product->getProductByCategoryId('148',8,'viewed');
		foreach($view_results as $v){
		    if(empty($v)) continue;
		    if ($v['image']) {
				$v['image'] = $this->model_tool_image->resize($v['image'], 179, 249);                    
			} else {
				$v['image'] = false;
			}   
			$v['name']=isset($v['name'])?$v['name']:null;
            $v['shortname']=isset($v['name'])?OcCutstr(isset($v['name'])?$v['name']:'',16):'';	
            $v['price']=isset($v['price'])?$v['price']:null;			
			$view_products[]=$v;		
		}
		$this->data['view_products']=array_slice($view_products,0,4);
		$view_results=null;
		
		
		//女装
		$female_clothes=array();
		$female_results=array();
		$female_results=$this->model_catalog_product->getProductByCategoryId('149',20,'p.product_id');
		foreach($female_results as $v){
		    if(empty($v)) continue;
		    if ($v['image']) {
				$v['image'] = $this->model_tool_image->resize($v['image'], 180, 180);                    
			} else {
				$v['image'] = false;
			}   
            $v['shortname']=OcCutstr(isset($v['name'])?$v['name']:'',20);				
			$female_clothes[]=$v;
			
		}
		$this->data['female_clothes']=$female_clothes;
		$female_results=null;
		
		//男装
		$male_clothes=array();
		$male_results=array();
		$male_results=$this->model_catalog_product->getProductByCategoryId('150',20,'p.product_id');
		
		
		foreach($male_results as $v){
		    if(empty($v)) continue;
			
		    if ($v['image']) {
				$v['image'] = $this->model_tool_image->resize($v['image'], 180, 180);                    
			} else {
				$v['image'] = false;
			}      
            $v['shortname']=OcCutstr(isset($v['name'])?$v['name']:'',20);			
			$male_clothes[]=$v;
			
		}
		$this->data['male_clothes']=$male_clothes;
		$male_results=null;
	
	    //运动
		$sports_clothes=array();
		$sports_results=array();
		$sports_results=$this->model_catalog_product->getProductByCategoryId('151',20,'p.product_id');
		foreach($sports_results as $v){
		    if(empty($v)) continue;
		    if ($v['image']) {
				$v['image'] = $this->model_tool_image->resize($v['image'], 180, 180);                    
			} else {
				$v['image'] = false;
			} 
            $v['shortname']=OcCutstr(isset($v['name'])?$v['name']:'',20);				
			$sports_clothes[]=$v;
			
		}
		$this->data['sports_clothes']=$sports_clothes;
		$sports_results=null;

		
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/clothes.html')) {
			$this->template = $this->config->get('config_template') . '/template/common/clothes.html';
		} else {
			$this->template = 'default/template/common/clothes.html';
		}
        
		$this->data['left']   = $this->getChild('common/left');
        $this->data['header'] = $this->getChild('common/header');
        $this->data['footer'] = $this->getChild('common/footer');	
		$this->data['brand'] = $this->getChild('common/brand');
	
	    $this->response->setOutput($this->render());		
	} */
	
    
	/**
	*  食品首页 *************吃***************
	*/
	/* public function foods(){
	    $this->load->model('catalog/product');
		$this->load->model('tool/image');
        $this->load->library('func');
		
		$this->document->setTitle($this->config->get('config_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));
 
		$this->data['heading_title'] = $this->config->get('config_title');
		
		$gfunc=new func();
        
		$snacks_foods=array();
		$snacks_results=array();
		$snacks_results=$this->model_catalog_product->getProductByCategoryId('585',8);//特产零食
	
		foreach($snacks_results as $v){
		    if(empty($v)) continue;
		    if ($v['image']) {
				$v['image'] = $this->model_tool_image->resize($v['image'], 180, 180);                    
			} else {
				$v['image'] = false;
			}   
            $v['shortname']=$gfunc->OcCutstr($v['name'],16);				
			$snacks_foods[]=$v;
			
		}
		$this->data['snacks_foods']=$snacks_foods;
		$snacks_results=null;
		
		
		$drinks_foods=array();
		$drinks_results=array();
		$drinks_results=$this->model_catalog_product->getProductByCategoryId('580',8);//茶叶饮料
		foreach($drinks_results as $v){
		    if(empty($v)) continue;
		    if ($v['image']) {
				$v['image'] = $this->model_tool_image->resize($v['image'], 180, 180);                    
			} else {
				$v['image'] = false;
			}   
            $v['shortname']=$gfunc->OcCutstr($v['name'],16);				
			$drinks_foods[]=$v;
			
		}
		$this->data['drinks_foods']=$drinks_foods;
		$drinks_results=null;
		
		
		$fruit_foods=array();
		$fruit_results=array();
		$fruit_results=$this->model_catalog_product->getProductByCategoryId('582',8);//绿色蔬果
		foreach($fruit_results as $v){
		    if(empty($v)) continue;
		    if ($v['image']) {
				$v['image'] = $this->model_tool_image->resize($v['image'], 180, 180);                    
			} else {
				$v['image'] = false;
			}   
			$v['name']=isset($v['name'])?$v['name']:null;
            $v['shortname']=isset($v['name'])?$gfunc->OcCutstr($v['name'],16):'';	
            $v['price']=isset($v['price'])?$v['price']:null;			
			$fruit_foods[]=$v;
			
		}
		$this->data['fruit_foods']=$fruit_foods;
		$fruit_results=null;
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/foods.html')) {
			$this->template = $this->config->get('config_template') . '/template/common/foods.html';
		} else {
			$this->template = 'default/template/common/foods.html';
		}
        
		$this->data['left']   = $this->getChild('common/left');
        $this->data['header'] = $this->getChild('common/header');
        $this->data['footer'] = $this->getChild('common/footer');	
		$this->data['brand'] = $this->getChild('common/brand');
	
	    $this->response->setOutput($this->render());		
	} */
	
    
	/**
	*  住房首页  ***************住***************
	*/
	/* public function house(){
	    $this->load->model('catalog/product');
		$this->load->model('tool/image');
		$this->load->library('func');

		$this->document->setTitle($this->config->get('config_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));

		$this->data['heading_title'] = $this->config->get('config_title');
		
		$gfunc=new func();
		
		$house=array();
		$house_results=array();
		$house_results=$this->model_catalog_product->getProductByCategoryId('782',10);//住宅家具
		foreach($house_results as $v){
		    if(empty($v)) continue;
		    if ($v['image']) {
				$v['image'] = $this->model_tool_image->resize($v['image'], 180, 135);                    
			} else {
				$v['image'] = false;
			}   
			$v['name']=isset($v['name'])?$v['name']:null;
            $v['shortname']=isset($v['name'])?$gfunc->OcCutstr($v['name'],16):'';	
            $v['price']=isset($v['price'])?$v['price']:null;			
			$house[]=$v;
			
		}
		$this->data['house']=$house;
		$house_results=null;
		
		
		$hotel=array();
		$hotel_results=array();
		$hotel_results=$this->model_catalog_product->getProductByCategoryId('783',10);//精品家纺
		foreach($hotel_results as $v){
		    if(empty($v)) continue;
		    if ($v['image']) {
				$v['image'] = $this->model_tool_image->resize($v['image'], 180, 135);                    
			} else {
				$v['image'] = false;
			}   
			$v['name']=isset($v['name'])?$v['name']:null;
            $v['shortname']=isset($v['name'])?$gfunc->OcCutstr($v['name'],16):'';	
            $v['price']=isset($v['price'])?$v['price']:null;			
			$hotel[]=$v;
			
		}
		$this->data['hotel']=$hotel;
		$hotel_results=null;
		
		
		$furniture=array();
		$furniture_results=array();
		$furniture_results=$this->model_catalog_product->getProductByCategoryId('785',10);//家装建材
		foreach($furniture_results as $v){
		    if(empty($v)) continue;
		    if ($v['image']) {
				$v['image'] = $this->model_tool_image->resize($v['image'], 180, 135);                    
			} else {
				$v['image'] = false;
			}   
			$v['name']=isset($v['name'])?$v['name']:null;
            $v['shortname']=isset($v['name'])?$gfunc->OcCutstr($v['name'],16):'';	
            $v['price']=isset($v['price'])?$v['price']:null;			
			$furniture[]=$v;
			
		}
		$this->data['furniture']=$furniture;
		$furniture_results=null;
		
        
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/house.html')) {
			$this->template = $this->config->get('config_template') . '/template/common/house.html';
		} else {
			$this->template = 'default/template/common/house.html';
		}
        
		$this->data['left']   = $this->getChild('common/left');
        $this->data['header'] = $this->getChild('common/header');
        $this->data['footer'] = $this->getChild('common/footer');
		$this->data['brand'] = $this->getChild('common/brand');
		
	
	    $this->response->setOutput($this->render());
	
	
	} */
	
    
	/**
	*  旅行首页    ***************行
	*/
	/* public function travel(){
	    $this->load->model('catalog/product');
		$this->load->model('tool/image');
		$this->load->library('func');

		$this->document->setTitle($this->config->get('config_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));

		$this->data['heading_title'] = $this->config->get('config_title');
		
		$gfunc=new func();
		
        $routinMaintain=array();
		$maintain_results=array();
		$maintain_results=$this->model_catalog_product->getProductByCategoryId('1064',10);//汽车保养
		foreach($maintain_results as $v){
		    if(empty($v)) continue;
		    if ($v['image']) {
				$v['image'] = $this->model_tool_image->resize($v['image'], 230, 140);                    
			} else {
				$v['image'] = false;
			}   
			$v['name']=isset($v['name'])?$v['name']:null;
            $v['shortname']=isset($v['name'])?$gfunc->OcCutstr($v['name'],16):'';	
            $v['price']=isset($v['price'])?$v['price']:null;			
			$routinMaintain[]=$v;
			
		}
		$this->data['routinMaintain']=$routinMaintain;
		$maintain_results=null;
		
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/travel.html')) {
			$this->template = $this->config->get('config_template') . '/template/common/travel.html';
		} else {
			$this->template = 'default/template/common/travel.html';
		}
        
		$this->data['left']   = $this->getChild('common/left');
        $this->data['header'] = $this->getChild('common/header');
        $this->data['footer'] = $this->getChild('common/footer');
		$this->data['brand'] = $this->getChild('common/brand');
		
	
	    $this->response->setOutput($this->render());
	
	
	}
	 */
	
	/**
	*  爽首页  ****************玩
	*/
	public function joy(){
	  

		$this->document->setTitle($this->config->get('config_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));

		$this->data['heading_title'] = $this->config->get('config_title');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/joy.html')) {
			$this->template = $this->config->get('config_template') . '/template/common/joy.html';
		} else {
			$this->template = 'default/template/common/joy.html';
		}

        $this->data['header'] = $this->getChild('common/header');
        $this->data['footer'] = $this->getChild('common/footer');
		
	
	    $this->response->setOutput($this->render());
	
	
	}

	
}
?>