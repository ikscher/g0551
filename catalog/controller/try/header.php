<?php 
class ControllerTryHeader extends Controller { 
	public function index() {
        
		//$this->data['referer']='index.php?route=try/try';
        
      	$this->data['login']="?route=account/login";
		
    	$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['home'] =$this->url->link('common/home','','SSL');
		$this->data['logout'] =$this->url->link('account/logout','','SSL');
        
		   
		$this->data['referer']='?route=try/try';
        

		/*
	    $this->load->model('catalog/category');
        $this->data['clothes'] = $this->url->link('product/category','category_id='.ModelCatalogCategory::$CATEGORY_CLOTHES,'SSL');
		$this->data['foods']   = $this->url->link('product/category','category_id='.ModelCatalogCategory::$CATEGORY_FOODS,'SSL');
		$this->data['house']   = $this->url->link('product/category','category_id='.ModelCatalogCategory::$CATEGORY_HOUSE,'SSL');
		$this->data['travel']   = $this->url->link('product/category','category_id='.ModelCatalogCategory::$CATEGORY_TRAVEL,'SSL');
		$this->data['joy']    =  $this->url->link('common/home/joy','','SSL');
        */
		
      
		
		if ($this->customer->isLogged()){
			if(isset($this->request->cookie['oc_customer'])){
				$customer=$this->cookie->OCAuthCode($this->request->cookie['customer'],'DECODE');
				$customer=unserialize($customer);
				
				$this->data['username']=$customer['email'];
			}
		}else{
		    $this->data['username']='';
		}
		
		
	
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/try/header.html')) {
			$this->template = $this->config->get('config_template') . '/template/try/header.html';
		} else {
			$this->template = 'default/template/try/header.html';
		}
		
		
				
		$this->response->setOutput($this->render());
 
	
    }
	


}
?>