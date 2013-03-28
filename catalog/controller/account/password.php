<?php
class ControllerAccountPassword extends Controller {
	private $error = array();
	     
  	public function index() {	
    	if (!$this->customer->isLogged()) {
      		$this->session->data['redirect'] = $this->url->link('account/password', '', 'SSL');

      		$this->redirect($this->url->link('account/login', '', 'SSL'));
			$this->data['username']='';
			$this->data['uid']=0;
			
    	}else{
		    if(isset($this->request->cookie['oc_customer'])){
				$customer=$this->cookie->OCAuthCode($this->request->cookie['oc_customer'],'DECODE');
				$customer=unserialize($customer);
				
				$this->data['username']=$customer['email'];
				$this->data['uid']=$customer['customer_id'];
			}else{
			    $this->redirect($this->url->link('account/login', '', 'SSL'));
			}
			
		}

	
    	if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			$this->load->model('account/customer');
			
			$this->model_account_customer->editPassword($this->request->post['newpassword']);
            
			$this->load->language('account/password');
      		$this->data['success'] = $this->language->get('text_success');
	  
	  		//$this->redirect($this->url->link('account/account', '', 'SSL'));
    	}

      	$this->data['home'] = $this->url->link('common/home', '', 'SSL');
		$this->data['logout']=$this->url->link('account/logout','','SSL');
        $this->data['action']=$this->url->link('account/password','','SSL');
    	$this->data['back'] = $this->url->link('account/account', '', 'SSL');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/password.html')) {
			$this->template = $this->config->get('config_template') . '/template/account/password.html';
		} else {
			$this->template = 'default/template/account/password.html';
		}
		
		$this->children = array(
			'account/left',
			'account/footer',
			'account/header'	
		);
						
		$this->response->setOutput($this->render());			
  	}
  
  	private function validate() {
    	if ((utf8_strlen($this->request->post['password']) < 4) || (utf8_strlen($this->request->post['password']) > 20)) {
      		$this->error['password'] = $this->language->get('error_password');
    	}

    	if ($this->request->post['confirm'] != $this->request->post['password']) {
      		$this->error['confirm'] = $this->language->get('error_confirm');
    	}  
	
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}
	
	/** 
	*  验证密码是否正确
	*/
	
	public function ajaxCheckPwd(){
	   $uid=trim($this->request->post['uid']);
	   $password=md5(trim($this->request->post['oldpassword']));
	   $this->load->model("account/customer");
	   $result=$this->model_account_customer->getCustomer($uid);
	   

	   if (!empty($result)){
	       if ($result['password']==$password){
		      echo 1;exit;
		    }
	   }

	   echo 0;exit;
	
	}
}
?>
