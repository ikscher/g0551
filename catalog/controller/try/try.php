<?php 
class ControllerTryTry extends Controller { 
	public function index() {
		/* if (!$this->customer->isLogged()) {
	  		//$this->session->data['redirect'] = $this->url->link('try/try', '', 'SSL');
	  
	  		$this->redirect($this->url->link('account/login', '', 'SSL'));
    	}  */
	
		//$this->language->load('try/try');

		// $this->document->setTitle($this->language->get('heading_title'));
        
		$this->data['referer']='index.php?route=try/try';
        
      	$this->data['login']="index.php?route=account/login";
		
		
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
        
		$this->load->model('tool/image');
		$this->load->model('try/try');
		$products=$this->model_try_try->getProducts();
		 
		$products_=array();
		foreach($products as $p){
			$p['category']=$this->model_try_try->getProductLevelCategory($p['product_id']);
			if(!empty($p['image'])) {
			    $p['image']=$this->model_tool_image->resize($p['image'],250,154);
			}
			$p['shortname']=OcCutstr($p['name'],10);
			$p['discount']=!empty($p['special_price'])?number_format($p['price']/$p['special_price'],2):1;
			$products_[]=$p;
		}
		
		
		$this->data['products']=$products_;
       
		
		if ($this->customer->isLogged()){
			if(isset($this->request->cookie['oc_customer'])){
				$customer=$this->cookie->OCAuthCode($this->request->cookie['customer'],'DECODE');
				$customer=unserialize($customer);
				
				$this->data['username']=$customer['email'];
			}
		}else{
		    $this->data['username']='';
		}
		
		
		
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/try/index.html')) {
			$this->template = $this->config->get('config_template') . '/template/try/index.html';
		} else {
			$this->template = 'default/template/try/index.html';
		}
		
				
		$this->response->setOutput($this->render());
  	}
}
?>