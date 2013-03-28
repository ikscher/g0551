<?php 
/**我的秀**/
class ControllerAccountMyshow extends Controller {  
	private $error = array();
 
	public function index() {
		$this->load->language('account/myshow');
      
		//$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('account/myshow');

		 
		$this->getList();
	}
	
	public function insert() {
		$this->load->language('account/myshow');

		$this->load->model('account/myshow');
		
		//$this->data['refresh']=$this->url->link('account/myshow/insert', '', 'SSL');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			$this->model_account_myshow->addContent($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->link('account/myshow', '', 'SSL'));
		}

		$this->getForm();
	}
	
	public function update() {
		$this->load->language('account/myshow');

		
		$this->load->model('account/myshow');

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			$this->model_account_myshow->editContent($this->request->get['content_id'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->link('account/myshow', '', 'SSL'));
		}

		$this->getForm();
	}
    
	//批量删除
	public function delete() {
		$this->load->language('account/myshow');

		$this->load->model('account/myshow');
		
		if (isset($this->request->post['selected'])) {

			foreach ($this->request->post['selected'] as $content_id) {
				$this->model_account_myshow->deleteContent($content_id);
			}

			$this->redirect($this->url->link('account/myshow','','SSL'));
		}

		$this->getList();
	}
	
	//单条删除
	public function deleteid() {
		$this->load->language('account/myshow');

		$this->load->model('account/myshow');
		
		if (isset($this->request->get['content_id'])) {
			
			$this->model_account_myshow->deleteContent($this->request->get['content_id']);
			

			$this->redirect($this->url->link('account/myshow','','SSL'));
		}

		$this->getList();
	}
	
	
	/**
	*   所有分类
	*
	*/
	private function getList() {
   	  	$this->load->model('tool/image');	
        $this->data['insert'] = $this->url->link('account/myshow/insert', '', 'SSL');		
		$this->data['delete'] = $this->url->link('account/myshow/delete','','SSL');
	    $this->data['refresh'] = $this->url->link('account/myshow','','SSL');
		$this->data['back'] = $this->url->link('account/account','','SSL');

		
		$url='';
		
		
		if(isset($this->request->request['content_id'])){
		    $content_id=$this->request->request['content_id'];
			$url="&content_id={$content_id}";
		}else{
		    $content_id='';
		}
		
		if(isset($this->request->request['starttime']) && isset($this->request->request['endtime'])){
		    $starttime=$this->request->request['starttime'];
			$endtime=$this->request->request['endtime'];
			$url="&starttime={$starttime}&endtime={$endtime}";
		}else{
		    $starttime='';
		    $endtime='';
		}
		
		if(isset($this->request->request['title']) && $this->request->request['title']!='' ){
		    $title=$this->request->request['title'];
			$url="&title={$title}";
		}else{
		    $title='';
		}
		
		if(isset($this->request->request['isShow']) && $this->request->request['isShow']!=''){
		    $isShow=$this->request->request['isShow'];
			$url.="&isShow={$isShow}";
		}else{
		    $isShow='';
		} 
		
		
		$data=array(
		    'content_id'=>$content_id,
			'starttime'=>$starttime,
			'endtime'=>$endtime,
			'title' =>$title,
			'isShow'=>$isShow);
	    
		$results = $this->model_account_myshow->getContents($data);
		
		$this->data['content_id']=$content_id;
		$this->data['starttime']=$starttime;
		$this->data['endtime']=$endtime;
		$this->data['title']=$title;
		$this->data['isShow']=$isShow;
		$this->data['text_delete']=$this->language->get('text_delete');
		
		if (isset($this->request->get['page'])) {
		    $page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		$offset=15;
		$total=count($results);
		
		$slicedata=array_slice($results,($page-1)*$offset,$offset);
     
		foreach ($slicedata as $result) {
			$action = array();
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'class'=>'edit',
				'href' => $this->url->link('account/myshow/update',  'content_id=' . $result['content_id'], 'SSL')
			);
			
			$action[] = array(
				'text' => $this->language->get('text_delete'),
				'class'=>'deleteid',
				'href' => $this->url->link('account/myshow/deleteid',  'content_id=' . $result['content_id'], 'SSL')
			);
			
			if(!empty($result['imageUrl'])){
			    $imageUrl=$this->model_tool_image->resize($result['imageUrl'],50,50);
			}else{
			    $imageUrl=$this->model_tool_image->resize('no_image.jpg',50,50);
			}
			
			$this->data['contents'][] = array(
				'content_id' => $result['content_id'],
				'title'        => strip_tags(htmlspecialchars_decode($result['title'])),
				'customer_id'     =>$result['customer_id'],
				'createtime'   => date('Y-m-d H:i:s',$result['createtime']),
				'imageUrl'    =>$imageUrl,
				'favoriate'   =>$result['favoriate'],
				'share'     => $result['share'],
				'isShow'    =>$result['isShow'],
				'selected'    => isset($this->request->post['selected']) && in_array($result['content_id'], $this->request->post['selected']),
				'action'      => $action
			);
		}
		

		$slicedata=null;
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['column_imageUrl'] = $this->language->get('column_imageUrl');
		$this->data['column_content_id'] = $this->language->get('column_content_id');
		$this->data['column_starttime'] = $this->language->get('column_starttime');
		$this->data['column_endtime'] = $this->language->get('column_endtime');
		$this->data['column_createtime'] = $this->language->get('column_createtime');
		$this->data['column_isShow'] = $this->language->get('column_isShow');
		$this->data['column_title'] = $this->language->get('column_title');
		$this->data['column_favoriate'] = $this->language->get('column_favoriate');
		$this->data['column_share'] = $this->language->get('column_share');
		$this->data['column_action'] = $this->language->get('column_action');
		$this->data['text_show_contents']=$this->language->get('text_show_contents');

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
		
		
		$pagination = new Pagination('results','links');
		$pagination->total = $total;
		$pagination->page = $page;
		$pagination->limit = $offset;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('account/myshow','page={page}'.$url, 'SSL');
		
		$this->data['pagination'] = $pagination->render();
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/myshow.html')) {
			$this->template = $this->config->get('config_template') . '/template/account/myshow.html';
		} else {
			$this->template = 'default/template/account/myshow.html';
		}
		
		$this->children = array(
			'account/left',
			'account/footer',
			'account/header'	
		);
				
		$this->response->setOutput($this->render());
	}
	
	
		/**
	*  表单
	*
	*/
	private function getForm() {
		$this->load->model('tool/image');
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_show'] = $this->language->get('text_show');
		$this->data['text_hidden'] = $this->language->get('text_hidden');
		$this->data['text_delete'] = $this->language->get('text_delete');
		$this->data['column_content_id'] = $this->language->get('column_content_id');
		$this->data['column_starttime'] = $this->language->get('column_starttime');
		$this->data['column_endtime'] = $this->language->get('column_endtime');
		$this->data['column_createtime'] = $this->language->get('column_createtime');
		$this->data['column_title'] = $this->language->get('column_title');
		$this->data['column_imageUrl'] = $this->language->get('column_imageUrl');
		$this->data['column_isShow'] = $this->language->get('column_isShow');
		$this->data['column_content'] = $this->language->get('column_content');
		$this->data['column_favoriate'] = $this->language->get('column_favoriate');
		$this->data['column_share'] = $this->language->get('column_share');
		$this->data['column_present'] = $this->language->get('column_present');
		$this->data['column_action'] = $this->language->get('column_action');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		$this->data['text_browse'] = $this->language->get('text_browse');
		$this->data['text_clear'] = $this->language->get('text_clear');
		

		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
        
		if (isset($this->error['title'])) {
			$this->data['error_title'] = $this->error['title'];
		} else {
			$this->data['error_title'] = '';
		}
	    
		if (isset($this->error['present'])) {
			$this->data['error_present'] = $this->error['present'];
		} else {
			$this->data['error_present'] = '';
		}
		
		if (isset($this->error['content'])) {
			$this->data['error_content'] = $this->error['content'];
		} else {
			$this->data['error_content'] = '';
		}
		
		if (!isset($this->request->get['content_id'])) {
			$this->data['action'] = $this->url->link('account/myshow/insert','','SSL');
		} else {
			$this->data['action'] = $this->url->link('account/myshow/update',  'content_id=' . $this->request->get['content_id'], 'SSL');
			$this->data['content_id']=$this->request->get['content_id'];
		}
		
		$this->data['cancel'] = $this->url->link('account/myshow','','SSL');
		
		
		if (isset($this->request->get['content_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$content = $this->model_account_myshow->getContent($this->request->get['content_id']);
    	}
	
		
		if (!empty($content)) {
			$content['createtime']=date('Y-m-d',$content['createtime']);
			if(!empty($content['imageUrl'])){
			    $content['imageUrl']=$this->model_tool_image->resize($content['imageUrl'],80,80);
			}else{
			    $content['imageUrl'] = $this->model_tool_image->resize('no_image.jpg', 80, 80);
			}
			$this->data['content']=$content;
			
		}else{
		    $this->data['createtime']=date('Y-m-d');
		}
	
		
		$this->data['no_image']=$this->model_tool_image->resize('no_image.jpg', 80, 80);
       
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/myshow_form.html')) {
			$this->template = $this->config->get('config_template') . '/template/account/myshow_form.html';
		} else {
			$this->template = 'default/template/account/myshow_form.html';
		}
		
		$this->children = array(
			'account/left',
			'account/footer',
			'account/header'	
		);
			
		$this->response->setOutput($this->render());
	}
	
	


}
	
?>