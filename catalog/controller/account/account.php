<?php 
class ControllerAccountAccount extends Controller { 
	public function index() {
		if (!$this->customer->isLogged()) {
	  		$this->session->data['redirect'] = $this->url->link('account/account', '', 'SSL');
	  
	  		$this->redirect($this->url->link('account/login', '', 'SSL'));
    	} 
	
		$this->language->load('account/account');

		$this->document->setTitle($this->language->get('heading_title'));

      
      	
		
		if (isset($this->session->data['success'])) {
    		$this->data['success'] = $this->session->data['success'];
			
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
    	$this->data['heading_title'] = $this->language->get('heading_title');

    	$this->data['text_my_account'] = $this->language->get('text_my_account');
		$this->data['text_my_orders'] = $this->language->get('text_my_orders');
		$this->data['text_my_newsletter'] = $this->language->get('text_my_newsletter');
    	$this->data['text_edit'] = $this->language->get('text_edit');
    	$this->data['text_password'] = $this->language->get('text_password');
    	$this->data['text_address'] = $this->language->get('text_address');
		$this->data['text_wishlist'] = $this->language->get('text_wishlist');
    	$this->data['text_order'] = $this->language->get('text_order');
    	$this->data['text_download'] = $this->language->get('text_download');
		$this->data['text_reward'] = $this->language->get('text_reward');
		$this->data['text_return'] = $this->language->get('text_return');
		$this->data['text_transaction'] = $this->language->get('text_transaction');
		$this->data['text_newsletter'] = $this->language->get('text_newsletter');
        
		$this->data['home'] =$this->url->link('common/home','','SSL');
    
		$this->data['logout'] =$this->url->link('account/logout','','SSL');
		
		if ($this->config->get('reward_status')) {
			$this->data['reward'] = $this->url->link('account/reward', '', 'SSL');
		} else {
			$this->data['reward'] = '';
		}
		
		$this->load->model('account/order');
		$this->data['total_1']=$this->data['total_4']=0;
		$results=array();
		//
		$results=$this->model_account_order->getOrderNumByStatus($this->customer->getId(),1);
	    $this->data['total_1']=$results['total'];
		$results=null;
		
    	//
		$results=$this->model_account_order->getOrderNumByStatus($this->customer->getId(),4);
		$this->data['total_4']=$results['total'];
		
		
		//猜您喜欢的
		$guessYouLike=array();
		$this->data['guessYouLike']=array();
		if(isset($this->request->cookie['guessYouLike'])){
		    $guessYouLike=unserialize($this->cookie->OCAuthCode($this->request->cookie['guessYouLike'],'DECODE'));
		}
	    
		
		
		if(!empty($guessYouLike)){
		    $guessYouLike=array_unique($guessYouLike);
			$guessYouLike=array_slice($guessYouLike,0,8);
			$xxx=array();
		
		    $this->load->model('catalog/product');
			$this->load->model('tool/image');
			foreach($guessYouLike as $v){
				$p=$this->model_catalog_product->getProduct($v);
				
				if ($p['image']) {
					$p['image'] = $this->model_tool_image->resize($p['image'], 170, 182);                    
				} else {
					$p['image'] = false;
				}       	
				$p['shortname']=utf8_substr($v['name'],0,13).'..';
				
				$p['price']=isset($v['price'])?$v['price']:'';
				
				$this->data['guessYouLike'][]=$p;
			}
		}

       
		//穿悦穿悦穿悦
		if ($this->customer->isLogged()){
		    // $customer=isset($this->session->data['customer'])?$this->session->data['customer']:'';
			if(isset($this->request->cookie['oc_customer'])){
				$customer=$this->cookie->OCAuthCode($this->request->cookie['customer'],'DECODE');
				$customer=unserialize($customer);
				
				$this->data['username']=$customer['email'];
			}
		}else{
		    $this->data['username']='';
		}
		
		
		$this->children = array(
			'account/left',
			'account/footer',
			'account/header'		
		);
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/account.html')) {
			$this->template = $this->config->get('config_template') . '/template/account/account.html';
		} else {
			$this->template = 'default/template/account/account.html';
		}
		
				
		$this->response->setOutput($this->render());
  	}
}
?>