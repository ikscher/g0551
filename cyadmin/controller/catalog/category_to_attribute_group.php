<?php 
class ControllerCatalogCategoryToAttributeGroup extends Controller { 
    /*属性组*/
	private $error = array();

  	public function index() {
		$this->load->language('catalog/category_to_attribute_group');
	
    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/category_to_attribute_group');
		
    	$this->getList();
  	}
     
    /**新增属性组**/	 
  	public function insert() {
		$this->load->language('catalog/category_to_attribute_group');
	
    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/category_to_attribute_group');
		$this->load->model('catalog/category');
           
		
		$category_id=isset($this->request->post['category_id'])?$this->request->post['category_id']:'';
		$attribute_group_id=isset($this->request->post['attribute_group_id'])?$this->request->post['attribute_group_id']:0;
	    
		
		$json=array();
		//更新类category表 的attribute_group字段 
		if(!empty($category_id)){
		    $categoryList=$this->model_catalog_category->getLowestLevelID($category_id);
			
			
			foreach($categoryList as $v){
			    $result_=array();
				$res2=array();
		        $res2=$this->model_catalog_category->getCategory($v);
			    $attribute_group=isset($res2['attribute_group'])?$res2['attribute_group']:'';
			
			    $data=array(
				         'category_id'=>$v,
						 'attribute_group_id'=>$attribute_group_id
				     );
					 
			    if(empty($attribute_group)){
	
					$this->model_catalog_category->updateCategory($data);
			    }else{
			        $x=explode(',',$attribute_group);
					if(!in_array($attribute_group_id,$x)){
						$this->model_catalog_category->updateCategoryAttributeGroup($data);
					}
				}
				
				
				//增加到分类属性组对照表中
				$result_=$this->model_catalog_category_to_attribute_group->getAttributeGroup($attribute_group_id,$v);
			
				if(empty($result_['category_id']) && empty($result_['attribute_group_id'])){
					$this->model_catalog_category_to_attribute_group->addAttributeGroup($data);
				}
				
			} 

		} 
		
		
		exit('ok');
			
  	}
    
	/**更新**/
  	/* public function update() {
		$this->load->language('catalog/category_to_attribute_group');
	
    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/category_to_attribute_group');

		$data=array();
		$data['attribute_group_id']=$this->request->post['attribute_group_id'];
		$data['atypename']=$this->request->post['atypename'];
		$data['attribute_group_description']=$this->request->post['attribute_group_description'];
		$data['attribute_group_text0']=$this->request->post['attribute_group_text0'];
		$data['attribute_group_text1']=$this->request->post['attribute_group_text1'];
		$data['category_id']=$this->request->post['category_id'];
		$data['attribute_cid0']=$this->request->post['attribute_cid0'];
		$data['attribute_cid1']=$this->request->post['attribute_cid1'];
		$data['attribute_cid2']=$this->request->post['attribute_cid2'];
		$data['attribute_cid3']=$this->request->post['attribute_cid3'];
		
        
		$this->model_catalog_category_to_attribute_group->editAttributeGroup($data);
		
		$this->response->setOutput('ok');
			
	    
  	} */

  	public function delete() {
		$this->load->language('catalog/category_to_attribute_group');
	
    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/category_to_attribute_group');
		$this->load->model('catalog/category');
		
		
		
    	if (isset($this->request->post['selected']) && $this->validateDelete()) {
		   
			foreach ($this->request->post['selected'] as $id) {
			    //更新category表attribute_group字段值
				$x=$this->model_catalog_category_to_attribute_group->getAttributeGroupById($id);
				$category_id=$x['category_id'];
				$attribute_group_id=$x['attribute_group_id'];
				
				$result=$this->model_catalog_category->getCategory($category_id);
				$attribute_group=isset($result['attribute_group'])?$result['attribute_group']:'';
				if(!empty($attribute_group)) $attribute_group=explode(',',$attribute_group);
				foreach($attribute_group as $k=>$v){
					if($v==$attribute_group_id) unset($attribute_group[$k]);
				}
				$attribute_group=implode(',',$attribute_group);
				
				$data=array(
						  'attribute_group_id' => $attribute_group,
						  'category_id'        => $category_id
						 );
				$this->model_catalog_category->updateCategory($data);
		
		
				$this->model_catalog_category_to_attribute_group->deleteAttributeGroup($id);
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
			
			$this->redirect($this->url->link('catalog/category_to_attribute_group', 'token=' . $this->session->data['token'] . $url, 'SSL'));
   		}
	
    	$this->getList();
  	}
	
	public function deleteone(){
	    $id=$this->request->post['id'];
		$category_id=$this->request->post['category_id'];
		$attribute_group_id=$this->request->post['attribute_group_id'];
		
		if (empty($id)) return ;
		
	    $this->load->model('catalog/category_to_attribute_group');
		$this->load->model('catalog/category');
		
		//更新category表attribute_group字段值
		$result=$this->model_catalog_category->getCategory($category_id);
		$attribute_group=isset($result['attribute_group'])?$result['attribute_group']:'';
		if(!empty($attribute_group)) $attribute_group=explode(',',$attribute_group);
		foreach($attribute_group as $k=>$v){
		    if($v==$attribute_group_id) unset($attribute_group[$k]);
		}
		$attribute_group=implode(',',$attribute_group);
		
		$data=array(
		          'attribute_group_id' => $attribute_group,
				  'category_id'        => $category_id
				 );
		$this->model_catalog_category->updateCategory($data);
		
		//删除
		$query=$this->model_catalog_category_to_attribute_group->deleteAttributeGroup($id);
		
		if($query){
		   $this->response->setOutput('yes');
		}else{
		   $this->response->setOutput('no');
		}
	}
    
  	private function getList() {
	    $this->load->model('catalog/category');
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'agd.name';
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
		
		if(isset($this->request->get['category_id'])){
		    $category_id=$this->request->get['category_id'];
		}else{
		    $category_id='';
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
							
	    $this->data['token'] = $this->session->data['token'];
		$this->data['insert'] = $this->url->link('catalog/category_to_attribute_group/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('catalog/category_to_attribute_group/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $this->data['refresh'] = $this->url->link('catalog/category_to_attribute_group', 'token=' . $this->session->data['token'] , 'SSL');			

		$this->data['attribute_groups'] = array();

		$data = array(
		    'filter_name'=>$attribute_group_name,
			'category_id' => $category_id,
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);
		

		$attribute_group_total = $this->model_catalog_category_to_attribute_group->getTotalAttributeGroups($data);
	
		$results = $this->model_catalog_category_to_attribute_group->getAttributeGroups($data);
       
    	foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('catalog/category_to_attribute_group/update', 'token=' . $this->session->data['token'] . '&attribute_group_id=' . $result['attribute_group_id'] . $url, 'SSL')
			);
						
			$this->data['attribute_groups'][] = array(
				'attribute_group_id' => $result['attribute_group_id'],
				'category_id'        => $result['category_id'],
				'id'                 => $result['id'],
				'name'               => $result['name'],
				'is_pa'              => $result['is_pa'],
				'type'               => $result['type'],
				'ctype'              => $this->model_catalog_category->getCurrentCategory($result['category_id'],'name'),
				'selected'           => isset($this->request->post['selected']) && in_array($result['id'], $this->request->post['selected']),
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
		$this->data['column_id'] = $this->language->get('column_id');
		
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
		
		$this->data['sort_id'] = $this->url->link('catalog/category_to_attribute_group', 'token=' . $this->session->data['token'] . '&sort=c2ag.attribute_group_id' . $url, 'SSL');
		$this->data['sort_name'] = $this->url->link('catalog/category_to_attribute_group', 'token=' . $this->session->data['token'] . '&sort=agd.name' . $url, 'SSL');
		$this->data['sort_sort_order'] = $this->url->link('catalog/category_to_attribute_group', 'token=' . $this->session->data['token'] . '&sort=ag.sort_order' . $url, 'SSL');
		
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
		$pagination->url = $this->url->link('catalog/category_to_attribute_group', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		

        $this->data['token']=$this->session->data['token'];
		$this->template = 'catalog/category_to_attribute_group_list.html';
	
				
		$this->response->setOutput($this->render());
  	}
    
	
	/* public function getCategoryType($type){
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
	} */
	
	
	/**表单内容**/
  	public function getForm() {
	    $this->load->language('catalog/category_to_attribute_group');
     	$this->data['heading_title'] = $this->language->get('heading_title');

    	$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_type'] = $this->language->get('entry_type');
	   
       
    	$this->data['button_save'] = $this->language->get('button_save');
    	$this->data['button_cancel'] = $this->language->get('button_cancel');
	    $this->data['token']= $this->session->data['token'];
		
	    $this->load->model('catalog/attribute_group');
		$this->load->model('catalog/category');
		
		$this->data['attribute_group_name']='';
		$this->data['firstDir']=$this->model_catalog_category->getChildCategory(0);
		
		
		$this->data['firstid']=$this->data['secondid']=$this->data['thirdid']=$this->data['forthid']='';
		
		$data['start']=0;
		$data['limit']=99999;
		$attributeGroups=array();
		$attributeGroups=$this->model_catalog_attribute_group->getAttributeGroups($data);
		
		$this->data['attributeGroups']=$attributeGroups;
		/*
		
		$attribute_group_info=array();
		$attribute_group_id=isset($this->request->get['attribute_group_id'])?$this->request->get['attribute_group_id']:'';
		$category_id = isset($this->request->get['category_id'])?$this->request->get['category_id']:'';
		
		$this->data['attribute_group_id']=$attribute_group_id;
		$this->data['category_id']=$category_id;
		
		
		$this->data['secondDir']=$this->data['thirdDir']=$this->data['forthDir']=array();
		
		if($attribute_group_id && $category_id){
		    $attribute_group_info=$this->model_catalog_category_to_attribute_group->getAttributeGroup($attribute_group_id,$category_id);
		
		
			$firstid=$secondid=$thirdid='';
			if(!empty($attribute_group_info)){
				$this->data['attribute_group_name']=$attribute_group_info['name'];
				$result=$this->model_catalog_category->getCurrentCategory($category_id,'id');
				$category=explode('|',$result);
			}
		    
		    if(!empty($category[0])) $firstid=$category[0];
			if(!empty($category[1])) $secondid=$category[1];
			if(!empty($category[2])) $thirdid=$category[2];
			if(!empty($category[3])) $forthid=$category[3]; 
			$firstid=isset($this->request->get['attribute_cid0'])?$this->request->get['attribute_cid0']:'';
			$secondid=isset($this->request->get['attribute_cid1'])?$this->request->get['attribute_cid1']:'';
			$thirdid=isset($this->request->get['attribute_cid2'])?$this->request->get['attribute_cid2']:'';
			$forthid=isset($this->request->get['attribute_cid3'])?$this->request->get['attribute_cid3']:'';
			
			
			
			
			if(!empty($firstid)){
				$this->data['secondDir']=$this->model_catalog_category->getChildCategory($firstid);
			}
		
			
			if(!empty($secondid)){
				$this->data['thirdDir']=$this->model_catalog_category->getChildCategory($secondid);
			}
			
			if(!empty($thirdid)){
				$this->data['forthDir']=$this->model_catalog_category->getChildCategory($thirdid);
			}
			
			
			$this->data['firstid']=$firstid;
			$this->data['secondid']=$secondid;
			$this->data['thirdid']=$thirdid;
			$this->data['forthid']=$forthid;
			
		}	
		*/
	
		$this->template = 'catalog/category_to_attribute_group_form.html';
	
		$this->response->setOutput($this->render());	
  	}
  	
	private function validateForm() {
    	if (!$this->user->hasPermission('modify', 'catalog/category_to_attribute_group')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}
	
		
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}

  	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/category_to_attribute_group')) {
      		$this->error['warning'] = $this->language->get('error_permission');
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
	     $this->load->model('catalog/category_to_attribute_group');
		 $agid=$this->request->post['agid'];
		 $data=$this->model_catalog_category_to_attribute_group->getAttributeGroupDescriptions($agid);
		 
		 $data['type']=$gfunc->getCategoryType($data['type']);
		
		 $gfunc=null;
		 
	     $this->response->setOutput(json_encode($data));
	}
	
	/**设置价格属性是否有效**/
	public function setPriceAttributeValid(){
	    $id=$this->request->post['id'];
		$is_pa=$this->request->post['is_pa'];
		if(empty($id)) exit('no');
		$this->load->model('catalog/category_to_attribute_group');
		if($this->model_catalog_category_to_attribute_group->setPriceAttributeValid($id,$is_pa)){
		    exit('yes');
		}else{
		    exit('no');
		}
	}
    
}
?>