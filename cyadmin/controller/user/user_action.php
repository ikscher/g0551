<?php
/**权限管理**/
class ControllerUserUserAction extends Controller {
	private $error = array();
 
	public function index() {
		$this->load->language('user/user_action');
 
		$this->document->setTitle($this->language->get('heading_title'));
 		
		$this->load->model('user/user_action');

		$this->getList();
	}

	public function insert() {
		$this->load->language('user/user_action');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('user/user_action');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_user_user_action->addUserAction($this->request->post);
			
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
						
			$this->redirect($this->url->link('user/user_action', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function update() {
		$this->load->language('user/user_action');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('user/user_action');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_user_user_action->editUserAction($this->request->get['id'], $this->request->post);
			
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
						
			$this->redirect($this->url->link('user/user_action', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() { 
		$this->load->language('user/user_action');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('user/user_action');
		
		if (isset($this->request->post['selected'])) {
      		foreach ($this->request->post['selected'] as $id) {
				$this->model_user_user_action->deleteUserAction($id);	
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
						
			$this->redirect($this->url->link('user/user_action', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	private function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'navdesc';
		}
		
		if (isset($this->request->get['navdesc'])) {
			$navdesc = $this->request->get['navdesc'];
		} else {
			$navdesc = '';
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
		
		
	    
		$this->data['token'] = $this->session->data['token'];
		$this->data['refresh'] = $this->url->link('user/user_action', 'token=' . $this->session->data['token'] . $url, 'SSL');					
		$this->data['insert'] = $this->url->link('user/user_action/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('user/user_action/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');	
	
		$this->data['user_actions'] = array();
        
		$limit=$this->config->get('config_admin_limit');
		$limit=isset($limit)?$limit:20;
		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'navdesc' => $navdesc,
			'start' => ($page - 1) * $limit,
			'limit' => $limit
		);
		
		$user_action_total = $this->model_user_user_action->getTotalUserActions($data);
		
		$results = $this->model_user_user_action->getUserActions($data);
      
		foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('user/user_action/update', 'token=' . $this->session->data['token'] . '&id=' . $result['id'] . $url, 'SSL')
			);		
		
			$this->data['user_actions'][] = array(
				'id' => $result['id'],
				'navcode' => $result['navcode'],
				'navdesc'          => $result['navdesc'],
				'actioncode'  => $result['actioncode'],
				'actiondesc'  => $result['actiondesc'],
				'selected'      => isset($this->request->post['selected']) && in_array($result['id'], $this->request->post['selected']),
				'action'        => $action
			);
		}	
	
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_navcode'] = $this->language->get('column_navcode');
		$this->data['column_actioncode'] = $this->language->get('column_actioncode');
		$this->data['column_actiondesc'] = $this->language->get('column_actiondesc');
		$this->data['column_navdesc'] = $this->language->get('column_navdesc');
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
		
		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
        
		$this->data['sort_navcode'] = $this->url->link('user/user_action', 'token=' . $this->session->data['token'] . '&sort=navcode' . $url, 'SSL');
		$this->data['sort_actioncode'] = $this->url->link('user/user_action', 'token=' . $this->session->data['token'] . '&sort=actioncode' . $url, 'SSL');
		$this->data['sort_navdesc'] = $this->url->link('user/user_action', 'token=' . $this->session->data['token'] . '&sort=navdesc' . $url, 'SSL');
		$this->data['sort_actiondesc'] = $this->url->link('user/user_action', 'token=' . $this->session->data['token'] . '&sort=actiondesc' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
				
		$pagination = new Pagination('results','links');
		$pagination->total = $user_action_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('user/user_action', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
		
		$this->data['pagination'] = $pagination->render();				

		$this->data['sort'] = $sort; 
		$this->data['order'] = $order;

		$this->template = 'user/user_action_list.html';
	
				
		$this->response->setOutput($this->render());
 	}

	private function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		//$this->data['text_select_all'] = $this->language->get('text_select_all');
		//$this->data['text_unselect_all'] = $this->language->get('text_unselect_all');
				
		$this->data['column_navcode'] = $this->language->get('column_navcode');
		$this->data['column_navdesc'] = $this->language->get('column_navdesc');
		$this->data['column_actioncode'] = $this->language->get('column_actioncode');
		$this->data['column_actiondesc'] = $this->language->get('column_actiondesc');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
 		if (isset($this->error['navdesc'])) {
			$this->data['error_navdesc'] = $this->error['navdesc'];
		} else {
			$this->data['error_navdesc'] = '';
		}
		
		if (isset($this->error['navcode'])) {
			$this->data['error_navcode'] = $this->error['navcode'];
		} else {
			$this->data['error_navcode'] = '';
		}
		
		if (isset($this->error['actiondesc'])) {
			$this->data['error_actiondesc'] = $this->error['actiondesc'];
		} else {
			$this->data['error_actiondesc'] = '';
		}
		
		if (isset($this->error['actioncode'])) {
			$this->data['error_actioncode'] = $this->error['actioncode'];
		} else {
			$this->data['error_actioncode'] = '';
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
		
  	
		if (!isset($this->request->get['id'])) {
			$this->data['action'] = $this->url->link('user/user_action/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('user/user_action/update', 'token=' . $this->session->data['token'] . '&id=' . $this->request->get['id'] . $url, 'SSL');
		}
		  
    	$this->data['cancel'] = $this->url->link('user/user_action', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['id']) && $this->request->server['REQUEST_METHOD'] != 'POST') {
			$user_action_info = $this->model_user_user_action->getUserAction($this->request->get['id']);
		}

		if (isset($this->request->post['navcode'])) {
			$this->data['navcode'] = $this->request->post['navcode'];
		} elseif (!empty($user_action_info)) {
			$this->data['navcode'] = $user_action_info['navcode'];
		} else {
			$this->data['navcode'] = '';
		}
		
		if (isset($this->request->post['navdesc'])) {
			$this->data['navdesc'] = $this->request->post['navdesc'];
		} elseif (!empty($user_action_info)) {
			$this->data['navdesc'] = $user_action_info['navdesc'];
		} else {
			$this->data['navdesc'] = '';
		}
		
		if (isset($this->request->post['actioncode'])) {
			$this->data['actioncode'] = $this->request->post['actioncode'];
		} elseif (!empty($user_action_info)) {
			$this->data['actioncode'] = $user_action_info['actioncode'];
		} else {
			$this->data['actioncode'] = '';
		}
		
		if (isset($this->request->post['actiondesc'])) {
			$this->data['actiondesc'] = $this->request->post['actiondesc'];
		} elseif (!empty($user_action_info)) {
			$this->data['actiondesc'] = $user_action_info['actiondesc'];
		} else {
			$this->data['actiondesc'] = '';
		}
		
		
		
	
		$this->template = 'user/user_action_form.html';
	
				
		$this->response->setOutput($this->render());
	}
    
	
	private function validateForm() {
		/* if (!$this->user->hasPermission('modify', 'user/user_permission')) {
			$this->error['warning'] = $this->language->get('error_permission');
		} */

		if ((utf8_strlen($this->request->post['navdesc']) < 1) || (utf8_strlen($this->request->post['navdesc']) > 30)) {
			$this->error['navdesc'] = $this->language->get('error_navdesc');
		}
		
		if ((utf8_strlen($this->request->post['navcode']) < 1) || (utf8_strlen($this->request->post['navcode']) > 30)) {
			$this->error['navcode'] = $this->language->get('error_navcode');
		}
		
		if ((utf8_strlen($this->request->post['actiondesc']) < 1) || (utf8_strlen($this->request->post['actiondesc']) > 30)) {
			$this->error['actiondesc'] = $this->language->get('error_actiondesc');
		}
		
		if ((utf8_strlen($this->request->post['actioncode']) < 1) || (utf8_strlen($this->request->post['actioncode']) > 30)) {
			$this->error['actioncode'] = $this->language->get('error_actioncode');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
    
	/*
	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'user/user_permission')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		$this->load->model('user/user');
      	
		foreach ($this->request->post['selected'] as $id) {
			$user_total = $this->model_user_user->getTotalUsersByGroupId($user_group_id);

			if ($user_total) {
				$this->error['warning'] = sprintf($this->language->get('error_user'), $user_total);
			}
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
	*/
}
?>