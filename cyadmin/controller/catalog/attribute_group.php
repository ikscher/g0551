<?php 
class ControllerCatalogAttributeGroup extends Controller { 
    /*属性组*/
	private $error = array();
   
  	public function index() {
		$this->load->language('catalog/attribute_group');
	
    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/attribute_group');
		
		
    	$this->getList();
  	}
     
    /**新增属性组**/	 
  	public function insert() {
		$this->load->language('catalog/attribute_group');
	
    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/attribute_group');

		$this->model_catalog_attribute_group->addAttributeGroup($this->request->post);
		  	
		$this->response->setOutput('ok');
			
  	}
    
	/**更新**/
  	public function update() {
		$this->load->language('catalog/attribute_group');
	
    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/attribute_group');

		$data=array();
		
		$data['sort_order']=$this->request->post['sort_order'];
		$data['attribute_group_name']=$this->request->post['attribute_group_name'];
		$data['isShow']=$this->request->post['isShow'];
		$data['option_id']=$this->request->post['option_id'];
		$data['original_option_id']=$this->request->post['original_option_id'];
		$data['group_type']=$this->request->post['group_type'];
        
		$this->model_catalog_attribute_group->editAttributeGroup($this->request->post['attribute_group_id'], $data);
		
		$this->response->setOutput('ok');
			
	    
  	}

  	public function delete() {
		$this->load->language('catalog/attribute_group');
	
    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/attribute_group');
		
		
    	if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $attribute_group_id) {
				$this->model_catalog_attribute_group->deleteAttributeGroup($attribute_group_id);
			}
			      		
			$this->session->data['success'] = $this->language->get('text_success');

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
			
			$this->redirect($this->url->link('catalog/attribute_group', 'token=' . $this->session->data['token'] . $url, 'SSL'));
   		}
	
    	$this->getList();
  	}
    
  	private function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name';
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
		
		if(isset($this->request->get['attribute_group_name'])){
		    $attribute_group_name=$this->request->get['attribute_group_name'];
		}else{
		    $attribute_group_name='';
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

  		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

	
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
							
		$this->data['insert'] = $this->url->link('catalog/attribute_group/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('catalog/attribute_group/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $this->data['refresh'] = $this->url->link('catalog/attribute_group', 'token=' . $this->session->data['token'] , 'SSL');			

		$this->data['attribute_groups'] = array();

		$data = array(
		    'filter_name'=>$attribute_group_name,
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);
		
		$this->data['entry_general']=$this->language->get('entry_general');
		$this->data['entry_price']=$this->language->get('entry_price');
		
		$attribute_group_total = $this->model_catalog_attribute_group->getTotalAttributeGroups($data);
	
		$results = $this->model_catalog_attribute_group->getAttributeGroups($data);
         
    	foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('catalog/attribute_group/update', 'token=' . $this->session->data['token'] . '&attribute_group_id=' . $result['attribute_group_id'] . $url, 'SSL')
			);
						
			$this->data['attribute_groups'][] = array(
				'attribute_group_id' => $result['attribute_group_id'],
				'name'               => $result['name'],
				'type'                => $result['type']==1?$this->language->get('entry_general'):$this->language->get('entry_price'),
				'isShow'             => $result['isShow'],
				'sort_order'         => $result['sort_order'],
				'selected'           => isset($this->request->post['selected']) && in_array($result['attribute_group_id'], $this->request->post['selected']),
				'action'             => $action
			);
		}	
		$results=null;
	
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_sort_order'] = $this->language->get('column_sort_order');
		$this->data['column_action'] = $this->language->get('column_action');		
		$this->data['column_type'] = $this->language->get('column_type');
		$this->data['column_show'] = $this->language->get('column_show');
		
		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
		$this->data['button_refresh'] = $this->language->get('button_refresh');
 
 		
		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$this->data['token']=$this->session->data['token'] ;
		
		$this->data['sort_id'] = $this->url->link('catalog/attribute_group', 'token=' . $this->session->data['token'] . '&sort=ag.attribute_group_id' . $url, 'SSL');
		$this->data['sort_name'] = $this->url->link('catalog/attribute_group', 'token=' . $this->session->data['token'] . '&sort=agd.name' . $url, 'SSL');
		$this->data['sort_sort_order'] = $this->url->link('catalog/attribute_group', 'token=' . $this->session->data['token'] . '&sort=ag.sort_order' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination('results','links');
		$pagination->total = $attribute_group_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('catalog/attribute_group', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		

        $this->data['token']=$this->session->data['token'];
		$this->template = 'catalog/attribute_group_list.html';
	
				
		$this->response->setOutput($this->render());
  	}
    
	
	public function getCategoryType($type){
	    $this->load->model('catalog/category');
		$xyz='';
		switch($type){
		    case  ModelCatalogCategory::$CATEGORY_JOY:
			    $xyz="爽";
				break;
			case  ModelCatalogCategory::$CATEGORY_CLOTHES:
			    $xyz="衣";
				break;
			case  ModelCatalogCategory::$CATEGORY_FOODS:
			    $xyz="食";
				break;
			case  ModelCatalogCategory::$CATEGORY_HOUSE:
			    $xyz="住";
				break;
			case  ModelCatalogCategory::$CATEGORY_TRAVEL:
			    $xyz="行";
				break;
			default:
			    $xyz="";
		}
		
		
		return $xyz;
	}
	/**表单内容**/
  	public function getForm() {
	    $this->load->language('catalog/attribute_group');
     	$this->data['heading_title'] = $this->language->get('heading_title');

    	$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_type'] = $this->language->get('entry_type');
		$this->data['entry_group_type'] = $this->language->get('entry_group_type');
		$this->data['entry_option'] = $this->language->get('entry_option');
		$this->data['entry_show'] = $this->language->get('entry_show');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
        $this->data['entry_general'] = $this->language->get('entry_general');
		$this->data['entry_price'] = $this->language->get('entry_price');
		
    	$this->data['button_save'] = $this->language->get('button_save');
    	$this->data['button_cancel'] = $this->language->get('button_cancel');
	    $this->data['token']= $this->session->data['token'];
		
		$this->load->model('catalog/attribute_group');
		$this->load->model('catalog/option');
		
		$this->data['flag']=isset($this->request->get['flag'])?$this->request->get['flag']:'';
		//取所有的选项
		$this->data['options']=array();
		$this->data['options']=$this->model_catalog_option->getOptions();
		
		$attribute_group_info=array();
		if (isset($this->request->get['attribute_group_id'])) {
			$attribute_group_info = $this->model_catalog_attribute_group->getAttributeGroup($this->request->get['attribute_group_id']);

		    $agd=$this->model_catalog_attribute_group->getAttributeGroupDescriptions($this->request->get['attribute_group_id']);
			$this->data['attribute_group_name'] =$agd['name'] ;
			$this->data['attribute_group_description']=$agd['description'];
			$this->data['attribute_group_text0']=$agd['text0'];
			$this->data['attribute_group_text1']=$agd['text1'];
			$this->data['attribute_group_id']=$this->request->get['attribute_group_id'];
	    }
 
		
		if (!empty($attribute_group_info)) {
			$this->data['type'] = $attribute_group_info['type'];
			$this->data['cid0']=$attribute_group_info['cid0'];
			$this->data['cid1']=$attribute_group_info['cid1'];
			$this->data['cid2']=$attribute_group_info['cid2'];
			$this->data['cid3']=$attribute_group_info['cid3'];
			$this->data['sort_order'] = $attribute_group_info['sort_order'];
			$this->data['isShow']=$attribute_group_info['isShow'];
			$this->data['option_id']=$attribute_group_info['option_id'];
			//$this->data['option_name']=$this->model_catalog_option->getOption($attribute_group_info['option_id']);
		} else {
			$this->data['type'] = '1';
			$this->data['cid0']='';
			$this->data['cid1']='';
			$this->data['cid2']='';
			$this->data['cid3']='';
			$this->data['sort_order'] = '';
			$this->data['isShow']='1';
			$this->data['option_id']='4';//select下拉框选项
			//$this->data['option_name']='';
		}

		
		$this->load->model('catalog/category');
       
		if(!empty($attribute_group_info)){
		    $category_id=$attribute_group_info['cid0'];
		}
		
		$this->data['firstDir']=$this->model_catalog_category->getChildCategory(0);
		
		if(!empty($category_id)){
		    $this->data['secondDir']=$this->model_catalog_category->getChildCategory($category_id);
		}
		
		if(!empty($attribute_group_info['cid1'])){
		    $this->data['thirdDir']=$this->model_catalog_category->getChildCategory($attribute_group_info['cid1']);
		}
		
		if(!empty($attribute_group_info['cid2'])){
		    $this->data['forthDir']=$this->model_catalog_category->getChildCategory($attribute_group_info['cid2']);
		}
	    
		
		
	
		$this->template = 'catalog/attribute_group_form.html';
		/* $this->children = array(
			'common/header',
			'common/footer'
		); */
				
		$this->response->setOutput($this->render());	
  	}
  	
	private function validateForm() {
    	if (!$this->user->hasPermission('modify', 'catalog/attribute_group')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}
	
    	$attribute_group_name=$this->request->post['attribute_group_name'];
		if ((utf8_strlen($attribute_group_name) < 1) || (utf8_strlen($attribute_group_name) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
    	
		
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}

  	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/attribute_group')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}

		
		$this->load->model('catalog/attribute');

		foreach ($this->request->post['selected'] as $attribute_group_id) {
			$attribute_total = $this->model_catalog_attribute->getTotalAttributesByAttributeGroupId($attribute_group_id);
            
			if ($attribute_total) {
				$this->error['warning'] = sprintf($this->language->get('error_attribute'), $attribute_total);
			}
	  	}
		
		if (!$this->error) { 
	  		return true;
		} else {
	  		return false;
		}
  	}
	
	/** 分类选框*/
	public function getAjaxCategory(){
	    //$level=$this->request->get['level'];
		$id=$this->request->get['id'];
		
		$this->load->model('catalog/category');
		
		$category_data=array();
		if(!empty($id)){
		    $category_data=$this->model_catalog_category->getChildCategory($id);
		}
		
		$this->response->setOutput(json_encode($category_data));
	
	}
	
	/**属性组**/
	public function getAjaxGroup(){
	     $data=array();
		 $this->load->library('func');
		 $gfunc=new func();
	     $this->load->model('catalog/attribute_group');
		 $agid=$this->request->post['agid'];
		 $data=$this->model_catalog_attribute_group->getAttributeGroupDescriptions($agid);
		 
		 $data['type']=$gfunc->getCategoryType($data['type']);
		
		 $gfunc=null;
		 
	     $this->response->setOutput(json_encode($data));
	}
    
}
?>