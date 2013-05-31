<?php 
class ControllerTryProduct extends Controller { 
	public function index() {
		/* if (!$this->customer->isLogged()) {
	  		//$this->session->data['redirect'] = $this->url->link('try/try', '', 'SSL');
	  
	  		$this->redirect($this->url->link('account/login', '', 'SSL'));
    	}  */
	
		//$this->language->load('try/try');

		// $this->document->setTitle($this->language->get('heading_title'));
        
		$this->data['referer']='?route=try/product';
        
      	$this->data['login']="?route=account/login";
		
		
    	$this->data['heading_title'] = $this->language->get('heading_title');

    	
		$this->data['home'] =$this->url->link('common/home','','SSL');
		$this->data['logout'] =$this->url->link('account/logout','','SSL');

	    	
		$this->data['telphone']=$this->language->get('telphone');
		$this->data['address']=$this->language->get('address');
		$this->data['icp']=$this->language->get('icp');
		$this->data['bottom']=$this->language->get('bottom');
        
		$this->load->model('catalog/category');
        $this->data['clothes'] = $this->url->link('product/category','category_id='.ModelCatalogCategory::$CATEGORY_CLOTHES,'SSL');
		$this->data['foods']   = $this->url->link('product/category','category_id='.ModelCatalogCategory::$CATEGORY_FOODS,'SSL');
		$this->data['house']   = $this->url->link('product/category','category_id='.ModelCatalogCategory::$CATEGORY_HOUSE,'SSL');
		$this->data['travel']   = $this->url->link('product/category','category_id='.ModelCatalogCategory::$CATEGORY_TRAVEL,'SSL');
		$this->data['joy']    =  $this->url->link('common/home/joy','','SSL');
       
		
		$product_id=!empty($this->request->get['product_id'])?$this->request->get['product_id']:'';
        if(empty($product_id)) return ;
		
		$this->load->model('catalog/product');
		$this->load->model('try/try');
		$this->load->model('tool/image');
		$this->load->model('store/store');
		
		$product=$this->model_catalog_product->getProduct($product_id);
		//$this->data['store']  =$this->model_store_store->getStore($product['store_id']);
		
		$this->data['product_id']=$product_id;
		$this->data['store_id']=$product['store_id'];
		
		$products=array();
		//单店铺所有的相关试用产品
		$results=$this->model_try_try->getProducts($product['store_id']);
		
		foreach($results as $k=>$v){
		    $v['image']=$this->model_tool_image->resize($v['image'],108,108);
			$v['shortname']=OcCutstr($product['name'],13);
			
			$products[]=$v;
		}
       
		$this->data['products']=$products;
		
		
		if ($this->customer->isLogged()){
			if(isset($this->request->cookie['oc_customer'])){
				$customer=$this->cookie->OCAuthCode($this->request->cookie['customer'],'DECODE');
				$customer=unserialize($customer);
				
				$this->data['username']=$customer['email'];
			}
		}else{
		    $this->data['username']='';
		}
		
		
	
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/try/product.html')) {
			$this->template = $this->config->get('config_template') . '/template/try/product.html';
		} else {
			$this->template = 'default/template/try/product.html';
		}
		
				
		$this->response->setOutput($this->render());
 
	
    }
	
	public function selectProduct(){
	    $json=array();
	    $product_id=$this->request->post['product_id'];
		
		$this->load->model('catalog/product');
		$this->load->model('tool/image');
		
		
		//价格属性
		$attributes=$attributes_price=array();
		$attributes=$this->model_catalog_product->getProductAttributes($product_id,false);
		
		foreach ($attributes as $key => $value) {
			if($value['gtype']==2){
				$attributes_price[]=$value;
			}
		}
		
		$images=array();
		$productImages=$this->model_catalog_product->getProductImages($product_id);
		foreach($productImages as $v){
		    $v['small_image']=$this->model_tool_image->resize($v['image'],59,59);
			$v['large_image']=$this->model_tool_image->resize($v['image'],460,460);
			$images[]=$v;
		}
		
		$product=array();
		$product=$this->model_catalog_product->getProduct($product_id);
		
		
		$product['special']['date_start']=strtotime($product['special']['date_start']);
		$product['special']['date_end']  =strtotime($product['special']['date_end']);
	
		
		
		$json[$product_id]['product']=$product;
		$json[$product_id]['images']=$images;
		$json[$product_id]['attribute']=$attributes_price;
		
		$this->response->setOutput(json_encode($json));
	
	}

}
?>