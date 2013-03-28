<?php 
class ControllerCatalogAttribute extends Controller { 
	private $error = array();
   
  	public function index() {
		$this->load->language('catalog/attribute');
	
    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/attribute');
		
    	$this->getList();
  	}
              
  	public function insert() {
		$this->load->language('catalog/attribute');
	
    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/attribute');
		
		$this->model_catalog_attribute->addAttribute($this->request->post);
		$this->response->setOutput('ok');
			
  	}

  	public function update() {
		$this->load->language('catalog/attribute');
	
    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/attribute');
		$this->model_catalog_attribute->editAttribute($this->request->post); 
		$this->response->setOutput('ok');
			
  	}

  	public function delete() {
		$this->load->language('catalog/attribute');
	
    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/attribute');
		
    	if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $attribute_id) {
			    
				$this->model_catalog_attribute->deleteAttribute($attribute_id);
			}
			      		
			$this->session->data['success'] = $this->language->get('text_success');

			/* $url = '';
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->redirect($this->url->link('catalog/attribute', 'token=' . $this->session->data['token'] . $url, 'SSL')); */
   		}
	
    	$this->getList();
  	}
    
  	private function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'ad.name';
		}
		
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		if (isset($this->request->get['attribute_group'])){
		    $attribute_group=$this->request->get['attribute_group'];
		}else{
		    $attribute_group='';
		}
		
		if (isset($this->request->get['attribute_group_id'])){
		    $attribute_group_id=$this->request->get['attribute_group_id'];
		}else{
		    $attribute_group_id='';
		}
		
		if (isset($this->request->get['attribute_type'])){
		    $attribute_type=$this->request->get['attribute_type'];
		}else{
		    $attribute_type='';
		}
				
		$url = '';
			
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		if (isset($this->request->get['attribute_group'])){
		    $url .='&attribute_group='.$this->request->get['attribute_group'];
		}
		
		if (isset($this->request->get['attribute_group_id'])){
		    $url .='&attribute_group_id='.$this->request->get['attribute_group_id'];
		}
		
		if (isset($this->request->get['attribute_type'])){
		    $url .='&attribute_type='.$this->request->get['attribute_type'];
		}
	    
		$this->data['insert'] = $this->url->link('catalog/attribute/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('catalog/attribute/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');	
        $this->data['refresh'] = $this->url->link('catalog/attribute', 'token=' . $this->session->data['token'] , 'SSL');
		
		$this->data['attributes'] = array();

		$data = array(
		    'filter_attribute_group_id' =>$attribute_group_id,
		    'filter_name'=>$attribute_group,
			'filter_type'=>$attribute_type,
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);
		
		$this->load->library('func');
		$gfunc=new func();
		
		$attribute_total = $this->model_catalog_attribute->getTotalAttributes($data);
	
		$results = $this->model_catalog_attribute->getAttributes($data);
    	foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('catalog/attribute/update', 'token=' . $this->session->data['token'] . '&attribute_id=' . $result['attribute_id'] . $url, 'SSL')
			);
						
			$this->data['attributes'][] = array(
				'attribute_id'       => $result['attribute_id'],
				'name'               => $result['name'],
				'attribute_group_id' => $result['attribute_group_id'],
				'typename'           => $gfunc->getCategoryType($result['type']),
				'type'               => $result['type'],
				'isShow'             => $result['isShow'],
				'attribute_group'    => $result['attribute_group'],
				'sort_order'         => $result['sort_order'],
				'description'        => $result['description'],
				'text0'               => $result['text0'],
				'text1'               => $result['text1'],
				'selected'           => isset($this->request->post['selected']) && in_array($result['attribute_id'], $this->request->post['selected']),
				'action'             => $action
			);
		}	
		$results=null;
		$gfunc=null;
	
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_attribute_group'] = $this->language->get('column_attribute_group');
		$this->data['column_sort_order'] = $this->language->get('column_sort_order');
		$this->data['column_action'] = $this->language->get('column_action');
		$this->data['column_type'] = $this->language->get('column_type');
		$this->data['column_show'] = $this->language->get('column_show');
		$this->data['column_attribute_group_id'] = $this->language->get('column_attribute_group_id');		
		
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
		
 		//链接
		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$this->data['sort_name'] = $this->url->link('catalog/attribute', 'token=' . $this->session->data['token'] . '&sort=ad.name' . $url, 'SSL');
		$this->data['sort_attribute_group'] = $this->url->link('catalog/attribute', 'token=' . $this->session->data['token'] . '&sort=attribute_group' . $url, 'SSL');
		$this->data['sort_sort_order'] = $this->url->link('catalog/attribute', 'token=' . $this->session->data['token'] . '&sort=a.sort_order' . $url, 'SSL');
		$this->data['sort_attribute_group_id'] = $this->url->link('catalog/attribute', 'token=' . $this->session->data['token'] . '&sort=a.attribute_group_id' . $url, 'SSL');
        $this->data['sort_type'] = $this->url->link('catalog/attribute', 'token=' . $this->session->data['token'] . '&sort=ag.type' . $url, 'SSL');
		
		$this->data['url'] = $this->url->link('catalog/attribute', 'token=' . $this->session->data['token'] , 'SSL');
		
        //翻页
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		if (isset($this->request->get['attribute_group'])){
		    $url .= '&attribute_group=' . $this->request->get['attribute_group'];
		}
		
		if (isset($this->request->get['attribute_type'])){
		    $url .= '&attribute_type=' . $this->request->get['attribute_type'];
		}
     
		$pagination = new Pagination('results','links');
		$pagination->total = $attribute_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('catalog/attribute', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		$this->data['token'] =$this->session->data['token'];

		$this->template = 'catalog/attribute_list.html';
		/* $this->children = array(
			'common/header',
			'common/footer'
		); */
				
		$this->response->setOutput($this->render());
  	}
  
  	public function getForm() {
	    $this->load->language('catalog/attribute');
		$this->load->model('catalog/attribute');
		$this->load->model('catalog/attribute_group');
		
     	$this->data['heading_title'] = $this->language->get('heading_title');

    	$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_type'] = $this->language->get('entry_type');
		$this->data['entry_attribute_group'] = $this->language->get('entry_attribute_group');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
    
		if (isset($this->request->get['attribute_id'])) {
			$attribute_info = $this->model_catalog_attribute->getAttribute($this->request->get['attribute_id']);
			$this->data['attribute_id']=$this->request->get['attribute_id'];
		}
				
		
		if (isset($this->request->get['attribute_id'])) {
			$this->data['attribute_name'] = $this->model_catalog_attribute->getAttributeDescriptions($this->request->get['attribute_id']);
		} else {
			$this->data['attribute_name'] = '';
		}

		if (!empty($attribute_info)) {
			$this->data['attribute_group_id'] = $attribute_info['attribute_group_id'];
			$this->data['sort_order'] = $attribute_info['sort_order'];
		} else {
			$this->data['attribute_group_id'] = '';
			$this->data['attribute_id'] = '';
			$this->data['attribute_group_type']='';
			$this->data['attribute_group_description']='';
			$this->data['attribute_group_text0']='';
			$this->data['attribute_group_text1']='';
			$this->data['sort_order'] = '';
		}
	
		
		$this->load->library('func');
		$gfunc=new func();
		
		$attribute_group=array();
		$attribute_group=$this->model_catalog_attribute_group->getAttributeGroups();	

		$this->data['attribute_groups'] = $attribute_group;

		
		
		if(!empty($attribute_info['attribute_group_id'])){
		    $attribute_group_info = $this->model_catalog_attribute_group->getAttributeGroup($attribute_info['attribute_group_id']);
			$agd=$this->model_catalog_attribute_group->getAttributeGroupDescriptions($attribute_info['attribute_group_id']);
			$this->data['attribute_group_type']=$gfunc->getCategoryType($agd['type']);
			// $this->data['attribute_group_name'] =$agd['name'] ;
			$this->data['attribute_group_description']=$agd['description'];
			$this->data['attribute_group_text0']=$agd['text0'];
			$this->data['attribute_group_text1']=$agd['text1'];

	    }
        $gfunc=null;
		
		$this->data['token'] =$this->session->data['token'];
		
		$this->template = 'catalog/attribute_form.html';
				
		$this->response->setOutput($this->render());	
  	}
  	
	private function validateForm() {
    	if (!$this->user->hasPermission('modify', 'catalog/attribute')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}
	
    	$attribute_description=$this->request->post['attribute_description'];
		if ((utf8_strlen($attribute_description) < 1) || (utf8_strlen($attribute_description) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
    	
		
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}

  	private function validateDelete() {
	    $this->error['warning']='';
		if (!$this->user->hasPermission('modify', 'catalog/attribute')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}
		
		$this->load->model('catalog/product');
		
		$x='产品ID：';
		$comma='';
		//$k=0;
		foreach ($this->request->post['selected'] as $attribute_id) {
		    //if($k>100) break;
		    $product_total=array();
			$product_total = $this->model_catalog_product->getTotalProductsByAttributeId($attribute_id);
	
			if (count($product_total)>0) {

			    foreach($product_total as $v){
				    $x .=$comma;
				    $x .= $v['product_id'];
					$comma='；';
				}
				
			}
			//$k++;
	  	}
		if(!empty($x)){
		    $this->error['warning'] = sprintf($this->language->get('error_product'),$x);
		}
		
		if (!preg_match('/ID/i',$this->error['warning'])) { 
	  		return true;
		} else {
	  		return false;
		}
  	}
	
	
	/**
	**debug** //http://test.cy0551.com/cy/cyadmin/index.php?route=catalog/attribute/autocomplete&token=8ba017ef47fe08c86a1940059b423c29&productId=520
	*/
	public function autocomplete() {
	    $json = array();
		$filter_name=isset($this->request->get['filter_name'])?$this->request->get['filter_name']:'';
		$productId=isset($this->request->get['productId'])?$this->request->get['productId']:'';
		//if (isset($this->request->get['filter_name'])) {
			$this->load->model('catalog/attribute');
			
			$data = array(
			    'productId'   => trim($productId),
				'filter_name' => trim($filter_name),
				'start'       => 0,
				'limit'       => 100
			);
			
			$json = array();
			
			$results = $this->model_catalog_attribute->getAttributes($data);
	        
			foreach ($results as $result) {
				$json[] = array(
					'attribute_id'    => $result['attribute_id'], 
					'name'            => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
					'attribute_group' => $result['attribute_group']
				);		
			}		
		//}

		$sort_order = array();
	  
		/* foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json); */

		$this->response->setOutput(json_encode($json));
	}		
    
   
}
?>