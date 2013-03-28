<?php 
class ControllerShowComments extends Controller {
	
   	private $error = array();
 
	public function index() {
		$this->load->language('show/comments');
      
		//$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('show/comments');
		 
		$this->getList();
	}
	
	
	public function update() {
		$this->load->language('show/comments');

		//$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('show/comments');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_show_comments->editComment($this->request->get['comment_id'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->link('show/comments', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('show/comments');

		//$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('show/comments');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $comment_id) {
			   
				$this->model_show_comments->deleteComment($comment_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('show/comments', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->getList();
	}
	
	
	/**
	*   所有分类
	*
	*/
	private function getList() {
   	  					
		$this->data['token']=$this->session->data['token'];
		$this->data['delete'] = $this->url->link('show/comments/delete', 'token=' . $this->session->data['token'], 'SSL');
	    $this->data['refresh'] = $this->url->link('show/comments', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['comments'] = array();
		
		$url='';
		
		
		if(isset($this->request->request['comment_id'])){
		    $comment_id=$this->request->request['comment_id'];
			$url="&comment_id={$comment_id}";
		}else{
		    $comment_id='';
		}
		
		if(isset($this->request->request['starttime']) && isset($this->request->request['endtime'])){
		    $starttime=$this->request->request['starttime'];
			$endtime=$this->request->request['endtime'];
			$url="&starttime={$starttime}&endtime={$endtime}";
		}else{
		    $starttime='';
		    $endtime='';
		}
		
		if(isset($this->request->request['comment']) && $this->request->request['comment']!='' ){
		    $comment=$this->request->request['comment'];
			$url="&comment={$comment}";
		}else{
		    $comment='';
		}
		
		if(isset($this->request->request['isShow']) && $this->request->request['isShow']!=''){
		    $isShow=$this->request->request['isShow'];
			$url.="&isShow={$isShow}";
		}else{
		    $isShow='';
		} 
		
		
		$data=array(
		    'content_id'=>$comment_id,
			'starttime'=>$starttime,
			'endtime'=>$endtime,
			'comment' =>$comment,
			'isShow'=>$isShow);
	    
		$results = $this->model_show_comments->getComments($data);
		
		$this->data['comment_id']=$comment_id;
		$this->data['starttime']=$starttime;
		$this->data['endtime']=$endtime;
		$this->data['comment']=$comment;
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
				'href' => $this->url->link('show/comments/update', 'token=' . $this->session->data['token'] . '&comment_id=' . $result['comment_id'], 'SSL')
			);
			
			
			
			$this->data['comments'][] = array(
				'comment_id' => $result['comment_id'],
				'comment'        => strip_tags(htmlspecialchars_decode($result['comment'])),
				'userid'     =>$result['userid'],
				'username'   =>$result['username'],
				'createtime'   => date('Y-m-d',$result['createtime']),
				'content_id'   =>$result['content_id'],
				'isShow'    =>$result['isShow'],
				'selected'    => isset($this->request->post['selected']) && in_array($result['comment_id'], $this->request->post['selected']),
				'action'      => $action
			);
		}
		$slicedata=null;
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['column_comment_id'] = $this->language->get('column_comment_id');
		$this->data['column_content_id'] = $this->language->get('column_content_id');
		$this->data['column_starttime'] = $this->language->get('column_starttime');
		$this->data['column_endtime'] = $this->language->get('column_endtime');
		$this->data['column_createtime'] = $this->language->get('column_createtime');
		$this->data['column_isShow'] = $this->language->get('column_isShow');
		$this->data['column_comment'] = $this->language->get('column_comment');
		$this->data['column_userid'] = $this->language->get('column_userid');
		$this->data['column_username'] = $this->language->get('column_username');
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
		$pagination->url = $this->url->link('show/comments', 'token=' . $this->session->data['token'] .'&page={page}'.$url, 'SSL');
		
		$this->data['pagination'] = $pagination->render();
		
		$this->template = 'show/comments_list.html';
		
				
		$this->response->setOutput($this->render());
	}
	
	
		/**
	*  表单
	*
	*/
	private function getForm() {
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_show'] = $this->language->get('text_show');
		$this->data['text_hidden'] = $this->language->get('text_hidden');
		$this->data['text_delete'] = $this->language->get('text_delete');
		$this->data['column_comment_id'] = $this->language->get('column_comment_id');
		$this->data['column_starttime'] = $this->language->get('column_starttime');
		$this->data['column_endtime'] = $this->language->get('column_endtime');
		$this->data['column_createtime'] = $this->language->get('column_createtime');
		$this->data['column_isShow'] = $this->language->get('column_isShow');
		$this->data['column_comment'] = $this->language->get('column_comment');
		$this->data['column_action'] = $this->language->get('column_action');
	
		

		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

	
		
		if (isset($this->error['content'])) {
			$this->data['error_content'] = $this->error['content'];
		} else {
			$this->data['error_content'] = '';
		}
		
		if (!isset($this->request->get['comment_id'])) {
			$this->data['action'] = $this->url->link('show/comments/insert', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$this->data['action'] = $this->url->link('show/comments/update', 'token=' . $this->session->data['token'] . '&comment_id=' . $this->request->get['comment_id'], 'SSL');
			$this->data['comment_id']=$this->request->get['comment_id'];
		}
		
		$this->data['cancel'] = $this->url->link('show/comments', 'token=' . $this->session->data['token'], 'SSL');
		
        $this->data['token'] = $this->session->data['token'];
		
		if (isset($this->request->get['comment_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$comment_info = $this->model_show_comments->getComment($this->request->get['comment_id']);
    	}
	
		
		
		if (!empty($comment_info)) {
	        foreach($comment_info as $k=>$v){
				if($k=='createtime') $v=date('Y-m-d',$v);
			    $this->data['comment'][$k]=$v;
			}
		}
       
		$this->template = 'show/comment_form.html';
			
		$this->response->setOutput($this->render());
	}
	
	
	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'show/comments')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		
		
		if($this->request->post['comment']) {
			if ((utf8_strlen($this->request->post['comment']) < 1) || (utf8_strlen($this->request->post['comment']) >1000)) {
				$this->error['comment'] = $this->language->get('error_comment');
			}
		}
					
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'show/comments')) {
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