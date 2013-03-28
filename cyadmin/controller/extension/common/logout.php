<?php       
class ControllerCommonLogout extends Controller {   
	public function index() { 
    	$this->user->logout();
 
 		unset($this->session->data['token']);
		
		if(isset($this->request->cookie['adminuserid'])) $this->cookie->OCSetCookie("adminuserid","",-24*3600);
		if(isset($this->request->cookie['adminusername'])) $this->cookie->OCSetCookie("adminusername","",-24*3600);
		
		session_destroy();

		$this->redirect($this->url->link('common/login', '', 'SSL'));
  	}
}  
?>