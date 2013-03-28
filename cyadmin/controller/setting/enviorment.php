<?php
class ControllerSettingEnviorment extends Controller {
	private $error = array();

	public function index() {
	    $this->load->model('setting/enviorment');
		
	    $this->load->language('setting/enviorment');
	    
		$this->getList();
	}
	
	private function getList(){
	    $this->data['heading_title']=$this->language->get('heading_title');
		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
		$this->data['button_refresh'] = $this->language->get('button_refresh');
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_edit']=$this->language->get('text_edit');
		
		$this->data['column_group'] = $this->language->get('column_group');
		$this->data['column_key']   = $this->language->get('column_key');
		$this->data['column_value']  =$this->language->get('column_value');
		$this->data['column_serialized']  =$this->language->get('column_serialized');
		
		$this->data['token']=$this->session->data['token'];
		
		$this->data['insert'] = $this->url->link('setting/enviorment/insert', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['delete'] = $this->url->link('setting/enviorment/delete', 'token=' . $this->session->data['token'], 'SSL');	
		$this->data['refresh'] = $this->url->link('setting/enviorment', 'token=' . $this->session->data['token'].'&refresh=1', 'SSL');
		
		$url='';
		
		if(isset($this->request->get['page'])){
		    $page=$this->request->get['page'];
		}elseif(isset($this->request->cookie['page'])){
			$page=isset($this->request->get['page']);
		}else{
		     $page=1;
		}
		
		$this->cookie->OCSetCookie("page",$page,24*3600);
		
		
		
		$group='';
		$env_group=$this->memcached->get('env_group');
		if(isset($env_group)){
		    $group=$env_group;
		}

		if(isset($this->request->get['group'])){
		    $group=$this->request->get['group'];
		    $this->memcached->set('env_group',$group);
		}
		
		if(isset($this->request->get['refresh']) && $this->request->get['refresh']==1){
		    $this->memcached->set('env_group','');
		}
	
		$limit=20;
		$data=array(
		        'start'=>($page - 1)*$limit,
				'limit' => $limit,
				'group' => $group
			);
		
		if(!empty($group)) $url = "&group={$group}";
		
		$total = $this->model_setting_enviorment->getTotalEnviorment($data);
	    
		$results = $this->model_setting_enviorment->getEnviorments($data);
        
		
    	foreach ($results as $result) {
		    $result['selected']= isset($this->request->post['selected']) && in_array($result['setting_id'], $this->request->post['selected']);
		    $result['value'] = OcCutstr($result['value'],29);
			$result['action'] = $this->url->link('setting/enviorment/update', 'token=' . $this->session->data['token'] . '&setting_id=' . $result['setting_id'], 'SSL');
			$this->data['enviorments'][]=$result;
		
		}
		
		
		$pagination = new Pagination('results','links');
		$pagination->total = $total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('setting/enviorment', 'token=' . $this->session->data['token'] .'&page={page}'.$url, 'SSL');
		
		$this->data['pagination'] = $pagination->render();
		
		
		$this->template = 'setting/enviorment_list.html';
		
		
		$this->response->setOutput($this->render());
	
	}
	
	//插入
	public function insert() {
	
    	$this->load->language('setting/enviorment');

    	$this->data['heading_title']=$this->language->get('heading_title'); 
		
		$this->load->model('setting/enviorment');
		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
		
			$this->model_setting_enviorment->addEnviorment($this->request->post);
	 
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->link('setting/enviorment', 'token=' . $this->session->data['token'], 'SSL'));
    	}
	
    	$this->getForm();
  	}
    
	//修改
  	public function update() {
    	$this->load->language('setting/enviorment');

    
		$this->load->model('setting/enviorment');
	    
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
		    
			$this->model_setting_enviorment->editEnviorment($this->request->post);
			
			
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			if(isset($this->request->cookie['page'])){
				$page=$this->request->cookie['page'];
			}else{
				$page=1;
			}
			
			$group='';
			$env_group=$this->memcached->get('env_group');
			if(isset($env_group)){
				$group=$env_group;
			}
		
			$this->redirect($this->url->link('setting/enviorment', 'token=' . $this->session->data['token'] ."&page={$page}&group={$group}", 'SSL'));
		}
       
    	$this->getForm();
  	}
    
	//删除
  	public function delete() {
    	$this->load->language('setting/enviorment');
		$this->load->model('setting/enviorment');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $id) {
			    
			    if(empty($id)) continue;
				$this->model_setting_enviorment->deleteEnviorment($id);

			}

			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->link('setting/enviorment', 'token=' . $this->session->data['token'], 'SSL'));
		}

    	$this->getList();
  	}
	
	
	public function getForm() { 
		$this->load->language('setting/enviorment');
		$this->data['heading_title']=$this->language->get('heading_title'); 
		$this->data['column_group'] = $this->language->get('column_group');
		$this->data['column_key'] = $this->language->get('column_key');
		$this->data['column_value'] = $this->language->get('column_value');
		$this->data['column_serialized'] = $this->language->get('column_serialized');
	
				
		$this->load->model('setting/enviorment');
		
	    
		$setting_id=isset($this->request->get['setting_id'])?$this->request->get['setting_id']:0;

		$v = $this->model_setting_enviorment->getEnviorment($setting_id);
        
		$this->data['enviorment'] =array();
    	
		if(!empty($v)){
			// var_dump(unserialize($v['value']));
			$this->data['enviorment'] = $v;
		}	
		
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['error_group']=isset($this->error['group'])?$this->error['group']:'';
		$this->data['error_key']=isset($this->error['key'])?$this->error['key']:'';
		$this->data['error_value']=isset($this->error['value'])?$this->error['value']:'';
		
 		/* if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		} */
		

  		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
		if (!isset($this->request->get['setting_id'])) {
			$this->data['action'] = $this->url->link('setting/enviorment/insert', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$this->data['action'] = $this->url->link('setting/enviorment/update', 'token=' . $this->session->data['token'] . '&setting_id=' . $this->request->get['setting_id'], 'SSL');
		} 
		
		if(isset($this->request->cookie['page'])){
		    $page=$this->request->cookie['page'];
		}else{
		    $page=1;
		}
		
		$group='';
		$env_group=$this->memcached->get('env_group');
		if(isset($env_group)){
		    $group=$env_group;
		}
		
		$this->data['cancel'] = $this->url->link('setting/enviorment', 'token=' . $this->session->data['token']."&page={$page}&group={$group}", 'SSL');
		
		$this->data['token'] = $this->session->data['token'];
		
	

		$this->template = 'setting/enviorment_form.html';
	
		$this->response->setOutput($this->render());
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'setting/enviorment')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
        
		if(empty($this->request->post['group'])){
		    $this->error['group']='须填入组名！';
		}
		
		if(empty($this->request->post['key'])){
		    $this->error['key']='须填入键名！';
		}
		
		if(empty($this->request->post['val'])){
		    $this->error['value']='须填入键值！';
		}
		
		/* if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		} */
			
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'setting/enviorment')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['selected'] as $setting_id) {
			if (!$setting_id) {
			    
				$this->error['warning'] = $this->language->get('error_default');
			}

			
		}
		
		if (!$this->error) {
			return true; 
		} else {
			return false;
		}
	}
}

?>