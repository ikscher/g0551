<?php
    class ControllerTryComplete extends Controller { 
	    public function index() {
	        
			$this->children = array(
				'try/header',
				'try/footer'
			);
			
			$this->data['try_order_id']='';
			
			if(isset($this->request->cookie['oc_try_order_id'])){
			    $try_order_id=$this->cookie->OCAuthCode($this->request->cookie['oc_try_order_id'],'DECODE');
			}else{
			    $try_order_id='';
			}
			if(!empty($try_order_id)) $this->data['try_order_id']=$try_order_id;
			
			
			$this->load->model('try/try');
			
			$mobile='15375274448';
			$time=time();
			
			if($this->customer->getId()){
			    $mobile_=$this->customer->getMobile();
				$message='会员已下订单：'.$try_order_id."，手机号：".$mobile_;
			}else{
			    //$mobile_=$this->cookie->OCAuthCode($this->request->cookie['oc_try_anonymous_mobile'],'DECODE');
				$mobile_=$this->session->data['try_annoymous_mobile'];
			    $message='游客已下订单：'.$try_order_id."，手机号：".$mobile_;
			}
			
			
			$this->model_try_try->addMessage($mobile,$message,$time);
			
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/try/complete.html')) {
				$this->template = $this->config->get('config_template') . '/template/try/complete.html';
			} else {
				$this->template = 'default/template/try/complete.html';
			}
			
			
					
			$this->response->setOutput($this->render());
		   
			}
	   
	}
?>