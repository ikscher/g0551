<?php 
class ControllerShowContents extends Controller {
	
  	private $error = array();
 
	public function index() {
		$this->load->language('show/contents');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('show/contents');
		 
		$this->getList();
	}

	public function insert() {
		$this->load->language('show/contents');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('show/contents');
		
		$this->data['refresh']=$this->url->link('show/contents/insert', 'token=' . $this->session->data['token'], 'SSL');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_show_contents->addContent($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->data['refresh']); 
		}

		$this->getForm();
	}

	public function update() {
		$this->load->language('show/contents');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('show/contents');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_show_contents->editContent($this->request->get['content_id'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->link('show/contents', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('show/contents');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('show/contents');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $content_id) {
				$this->model_show_contents->deleteContent($content_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('show/contents', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->getList();
	}
	
	/**
	*   所有分类
	*
	*/
	private function getList() {
   	    $this->load->model('tool/image');
									
		$this->data['insert'] = $this->url->link('show/contents/insert', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['delete'] = $this->url->link('show/contents/delete', 'token=' . $this->session->data['token'], 'SSL');
	    $this->data['refresh'] = $this->url->link('show/contents', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['contents'] = array();
		
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
	    
		$results = $this->model_show_contents->getContents($data);
		
		$this->data['content_id']=$content_id;
		$this->data['starttime']=$starttime;
		$this->data['endtime']=$endtime;
		$this->data['title']=$title;
		$this->data['isShow']=$isShow;
		
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
				'href' => $this->url->link('show/contents/update', 'token=' . $this->session->data['token'] . '&content_id=' . $result['content_id'], 'SSL')
			);
			
			if ($result['imageUrl'] && file_exists(DIR_IMAGE . $result['imageUrl'])) {
				$image = $this->model_tool_image->resize($result['imageUrl'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.jpg', 40, 40);
			}		
			
			$this->data['contents'][] = array(
				'content_id' => $result['content_id'],
				'imageUrl'   => $image,
				'favoriate'        => $result['favoriate'],
				'share'         => $result['share'],
				'title'       => $result['title'],
				'content'  => strip_tags(htmlspecialchars_decode($result['content'])),
				'present'      => $result['present'],
				'createtime'   => date('Y-m-d',$result['createtime']),
				'isShow'    =>$result['isShow'],
				'selected'    => isset($this->request->post['selected']) && in_array($result['content_id'], $this->request->post['selected']),
				'action'      => $action
			);
		}
		$slicedata=null;
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['text_no_results'] = $this->language->get('text_no_results');
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
		
		
		$pagination = new Pagination('results','links');
		$pagination->total = $total;
		$pagination->page = $page;
		$pagination->limit = $offset;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('show/contents', 'token=' . $this->session->data['token'] .'&page={page}'.$url, 'SSL');
		
		$this->data['pagination'] = $pagination->render();
		
		$this->template = 'show/contents_list.html';
		
				
		$this->response->setOutput($this->render());
	}
    
	/**
	*  表单
	*
	*/
	private function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');

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
			$this->data['action'] = $this->url->link('show/contents/insert', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$this->data['action'] = $this->url->link('show/contents/update', 'token=' . $this->session->data['token'] . '&content_id=' . $this->request->get['content_id'], 'SSL');
			$this->data['content_id']=$this->request->get['content_id'];
		}
		
		$this->data['cancel'] = $this->url->link('show/contents', 'token=' . $this->session->data['token'], 'SSL');
		
        $this->data['token'] = $this->session->data['token'];
		
		if (isset($this->request->get['content_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$content_info = $this->model_show_contents->getContent($this->request->get['content_id']);
    	}
	    
		$this->data['content']['createtime']=date('Y-m-d');
		$this->load->model('tool/image');
		//显示属性
		if (!empty($content_info)) {
	        foreach($content_info as $k=>$v){
			    if($k=='imageUrl'){
                    if(!empty($v)){
					    $v=$this->model_tool_image->resize($v, 100, 100);
				    }else{
					    $v=$this->model_tool_image->resize('no_image.jpg', 100, 100);
					}
				}
				if($k=='createtime') {
				    if(!empty($v)){
						$v=date('Y-m-d',$v);
					}else{
					    $v=date('Y-m-d');
					}
				}
			    $this->data['content'][$k]=$v;
			}
		}
		
		
        
		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
						
		$this->template = 'show/content_form.html';
			
		$this->response->setOutput($this->render());
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'show/contents')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if($this->request->post['title']) {
			if ((utf8_strlen($this->request->post['title']) < 1) || (utf8_strlen($this->request->post['title']) > 255)) {
				$this->error['title'] = $this->language->get('error_title');
			}
		}
		
		
		if($this->request->post['present']) {
			if ((utf8_strlen($this->request->post['present']) < 1) || (utf8_strlen($this->request->post['present']) > 255)) {
				$this->error['present'] = $this->language->get('error_present');
			}
		}
		
		
		if($this->request->post['content']) {
			if ((utf8_strlen($this->request->post['content']) < 1) || (utf8_strlen($this->request->post['content']) >1000)) {
				$this->error['content'] = $this->language->get('error_content');
			}
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
		if (!$this->user->hasPermission('modify', 'show/contents')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
 
		if (!$this->error) {
			return true; 
		} else {
			return false;
		}
	}
	
}	
?>