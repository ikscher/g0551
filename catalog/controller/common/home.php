<?php  
class ControllerCommonHome extends Controller {

    
	/**
	*   默认首页
	* 
	*/
	public function index() 
    
	{    

		$this->clothes();
    }
    

	/**
	*  衣服首页 ***********穿
	*/
	public function clothes(){
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
	}
	
    
	/**
	*  食品首页 *************吃***************
	*/
	public function foods(){
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
	}
	
    
	/**
	*  住房首页  ***************住***************
	*/
	public function house(){
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
	
	
	}
	
    
	/**
	*  旅行首页    ***************行
	*/
	public function travel(){
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
	
    

	
    
    /**
    * 返回指定类别的商品
    * 
    * $category_id 商品类别id
    * $limit 返回的商品数量，默认：10
    */
	/*
    public function get_products_by_category()
    {                
        $this->load->model('tool/image');
        $this->load->model('catalog/product');
        
        // default for clothes
        $image_width = 180;
        $image_height = 180;
        $formated = '<div class="clothes_pro"><p><a href="%s" target=_blank><img src="%s" width="180" height="180" alt="%s" /></a></p><p><a href="%s" target=_blank class="f3n">%s</a></p><p><a class="f2 f_h">￥%s</a></p></div> ';
        $list_count = 10;
        $max_title_length = 15;
        
        $style = $this->request->get['style'];
        //if($style == 'clothes') ... default for clothes or unknown;
        if($style == 'foods')
        {
            $image_width = 180;
            $image_height = 180;
            $formated = '<dl><dd><a href="%s" target=_blank><img src="%s" width="180" height="180" alt="%s" /></a></dd><dd class="fpro_intr_pric_bg"></dd><dd class="fpro_intr_pric">';
			$formated = $formated . '<div class="fpro_intr z"><a href="%s" target=_blank>%s</a></div><div class="fpro_pric tc f_b z">￥<font class="f1 f_b">%s</font></div></dd></dl>';						
            $list_count = 8;
            $max_title_length = 8;
        }
        
        if($style == 'house')
        {
            $image_width = 180;
            $image_height = 135;
            $formated = '<dl><dd><a href="%s"><img src="%s" width="180" height="135" alt="%s" /></a></dd>';
			$formated = $formated . '<dd class="txt"><a href="%s">%s</a></dd><dd class="txt"><a class="f_h">价格 ￥%s</a></dd></dl>';						
            $list_count = 10;
            $max_title_length = 15;
        }
        
        $category_id = (int)$this->request->get['category_id'];
        $products = $this->model_catalog_product->get_products_by_category($category_id, $list_count);
        if($products == null) echo ' ';
        
        foreach($products as $product)
        {
            $id = $product['product_id'];
            $title = $product['name'];
            $price = sprintf ("%01.2f", $product['price']);
            $alt = $product['name'];
            $path = $this->model_tool_image->resize($product['image'], $image_width, $image_height);
            if($path == null) $path = $this->model_tool_image->resize('no_image.jpg', $image_width, $image_height);
            $url = 'index.php?route=product/product&product_id=' . $id;
            
            echo sprintf($formated, $url, $path, $alt, $url, $title, $price);
            echo "\r\n";
        }
    }
	*/
    
	
}
?>