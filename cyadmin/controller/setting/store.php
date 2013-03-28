<?php
class ControllerSettingStore extends Controller {
	private $error = array(); 

	public function index() {
		$this->load->language('setting/store');

		$this->document->setTitle($this->language->get('heading_title'));
		 
		$this->load->model('setting/store');

		$this->getList();
	}
	      
  	public function insert() {
    	$this->load->language('setting/store');

    	$this->document->setTitle($this->language->get('heading_title')); 
		
		$this->load->model('setting/store');
		
		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
		    
			$store_id = $this->model_setting_store->addStore($this->request->post);
            
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->link('setting/store', 'token=' . $this->session->data['token'], 'SSL'));
    	}
	  
    	$this->getForm();
  	}

  	public function update() {
    	$this->load->language('setting/store');

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/store');
	
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_setting_store->editStore($this->request->get['store_id'], $this->request->post);
			
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->link('setting/store', 'token=' . $this->session->data['token'] . '&store_id=' . $this->request->get['store_id'], 'SSL'));
		}
       
    	$this->getForm();
  	}

  	public function delete() {
    	$this->load->language('setting/store');

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/store');
		
		$this->load->model('setting/setting');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $store_id) {
				$this->model_setting_store->deleteStore($store_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->link('setting/store', 'token=' . $this->session->data['token'], 'SSL'));
		}

    	$this->getList();
  	}
	
	private function getList() {

		$page=isset($this->request->get['page'])?$this->request->get['page']:1;
		

  		$this->load->model('tool/image');
							
		$this->data['insert'] = $this->url->link('setting/store/insert', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['delete'] = $this->url->link('setting/store/delete', 'token=' . $this->session->data['token'], 'SSL');	
		$this->data['refresh'] = $this->url->link('setting/store', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['stores'] = array();
		
		$action = array();
					
		$action[] = array(
			'text' => $this->language->get('text_edit'),
			'href' => $this->url->link('setting/setting', 'token=' . $this->session->data['token'], 'SSL')
		);
					
		/* $this->data['stores'][] = array(
			'store_id' => 0,
			'name'     => $this->config->get('config_name') . $this->language->get('text_default'),
			'url'      => HTTP_CATALOG,
			'selected' => isset($this->request->post['selected']) && in_array(0, $this->request->post['selected']),
			'action'   => $action
		); */
		
		$limit=15;
		
		$data=array(
		        'start' => ($page - 1)*$limit,
				'limit' => $limit
			    );
					
		$store_total = $this->model_setting_store->getTotalStores();
	    
		$results = $this->model_setting_store->getStores($data);
       
    	foreach ($results as $result) {
		    $action = array();
						
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('setting/store/update', 'token=' . $this->session->data['token'] . '&store_id=' . $result['store_id'], 'SSL')
			);
			
		    if ($result['logo']) {
				$result['logo'] = $this->model_tool_image->resize($result['logo'], 50, 50);                    
			} else {
				$result['logo'] = false;
			}  
			$result['introduce']=strip_tags(htmlspecialchars_decode($result['introduce']));
			$result['createtime']=date('Y-m-d H:i:s',$result['createtime']);
			$result['selected']= isset($this->request->post['selected']) && in_array($result['store_id'], $this->request->post['selected']);
			$result['action']=$action;
			if(isset($result['hasShop']) && $result['hasShop']==1){
				$result['status']='开通';
			}else{
			    $result['status']='封锁';
			}
			
		    $this->data['stores'][] = $result;
			
		}	
		
		
		$pagination = new Pagination('results','links');
		$pagination->total = $store_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('setting/store', 'token=' . $this->session->data['token'] .'&page={page}', 'SSL');
		
		$this->data['pagination'] = $pagination->render();
		
	
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_url'] = $this->language->get('column_url');
		$this->data['column_action'] = $this->language->get('column_action');		
		
		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
		$this->data['button_refresh'] = $this->language->get('button_refresh');
 
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$this->template = 'setting/store_list.html';
		
		$this->response->setOutput($this->render());
	}
	 
	public function getForm() { 
		$this->data['heading_title'] = $this->language->get('heading_title');
		 
		$this->data['text_select'] = $this->language->get('text_select');
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_items'] = $this->language->get('text_items');
		$this->data['text_tax'] = $this->language->get('text_tax');
		$this->data['text_account'] = $this->language->get('text_account');
		$this->data['text_checkout'] = $this->language->get('text_checkout');
		$this->data['text_stock'] = $this->language->get('text_stock');				
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
 		$this->data['text_browse'] = $this->language->get('text_browse');
		$this->data['text_clear'] = $this->language->get('text_clear');			
		$this->data['text_shipping'] = $this->language->get('text_shipping');	
		$this->data['text_payment'] = $this->language->get('text_payment');	
				
		$this->load->model('setting/store');
		$this->load->model('tool/image');
		
	    
		$store_id=isset($this->request->get['store_id'])?$this->request->get['store_id']:0;
	    
		
		$v = $this->model_setting_store->getStore($store_id);
        
		$this->data['store'] =array();
		$this->data['no_image']=$this->model_tool_image->resize('no_image.jpg', 100, 100);		
		
		if(!empty($v)){
			
			if ($v['logo']) {
				$v['imageUrl'] = $this->model_tool_image->resize($v['logo'], 100, 100);                    
			} else {
				$v['imageUrl'] = $this->data['no_image'];
			}  
		
			$v['introduce']=trim(strip_tags(htmlspecialchars_decode($v['introduce'])));
			$v['createtime']=date('Y-m-d H:i:s',$v['createtime']);
			 
			
			$this->data['store'] = $v;
		}else{
		    $this->request->post['imageUrl'] = $this->data['no_image'];
		    //$this->request->post['createtime']=date('Y-m-d H:i:s');
		    $this->data['store']=$this->request->post;
		
		}
		
		
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
        $this->data['token'] = $this->session->data['token'];
		
		
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if(isset($this->error['storename'])){
		    $this->data['error_storename']=$this->error['storename'];
		}else{
		    $this->data['error_storename']='';
		}
		
		if(isset($this->error['telphone'])){
		    $this->data['error_telphone']=$this->error['telphone'];
		}else{
		    $this->data['error_telphone']='';
		}
		
		if(isset($this->error['mobile'])){
		    $this->data['error_mobile']=$this->error['mobile'];
		}else{
		    $this->data['error_mobile']='';
		}
		
		if(isset($this->error['address'])){
		    $this->data['error_address']=$this->error['address'];
		}else{
		    $this->data['error_address']='';
		}
		
		if(isset($this->error['introduce'])){
		    $this->data['error_introduce']=$this->error['introduce'];
		}else{
		    $this->data['error_introduce']='';
		}
		
	
		
	
  		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
		if (!isset($this->request->get['store_id'])) {
			$this->data['action'] = $this->url->link('setting/store/insert', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$this->data['action'] = $this->url->link('setting/store/update', 'token=' . $this->session->data['token'] . '&store_id=' . $this->request->get['store_id'], 'SSL');
		} 
				
		$this->data['cancel'] = $this->url->link('setting/store', 'token=' . $this->session->data['token'], 'SSL');
        
		
						

		$this->template = 'setting/store_form.html';
	
		$this->response->setOutput($this->render());
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'setting/store')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if(empty($this->request->post['name'])){
		    $this->error['storename']='须填入店铺名称！';
		}
		
		if(empty($this->request->post['telphone'])){
		    $this->error['telphone']='须填入店铺联系电话！';
		}
		
		if(empty($this->request->post['mobile'])){
		    $this->error['mobile']='须填入店主手机！';
		}
		
		if(empty($this->request->post['address'])){
		    $this->error['address']='须填入店铺地址！';
		}
		
		if(empty($this->request->post['introduce'])){
		    $this->error['introduce']='须填入店铺简介！';
		}
		
		
		
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
					
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'setting/store')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		$this->load->model('sale/order');
		
		foreach ($this->request->post['selected'] as $store_id) {
			if (!$store_id) {
				$this->error['warning'] = $this->language->get('error_default');
			}
			
			$store_total = $this->model_sale_order->getTotalOrdersByStoreId($store_id);
	
			if ($store_total) {
				$this->error['warning'] = sprintf($this->language->get('error_store'), $store_total);
			}	
		}
		
		if (!$this->error) {
			return true; 
		} else {
			return false;
		}
	}
	
	/* public function template() {
		$template = basename($this->request->get['template']);
		
		if (file_exists(DIR_IMAGE . 'templates/' . $template . '.png')) {
			$image = HTTPS_IMAGE . 'templates/' . $template . '.png';
		} else {
			$image = HTTPS_IMAGE . 'no_image.jpg';
		}
		
		$this->response->setOutput('<img src="' . $image . '" alt="" title="" style="border: 1px solid #EEEEEE;" />');
	}	 */	
	
}
?>