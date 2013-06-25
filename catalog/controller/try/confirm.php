<?php 
class ControllerTryConfirm extends Controller { 

/***confirm your try****/
	public function index(){
	
	 
	    $time=time();
		$try_id=isset($this->request->get['try_id'])?$this->request->get['try_id']:'';
		
		if(empty($try_id)) return;
		
		
		$this->data['mobile']=$this->customer->getMobile();
		
		$try_id=urldecode($try_id);
		
		$this->load->model('try/try');
		$this->load->model('tool/image');
		
		$products=$this->model_try_try->getSelectedTryProduct($try_id);
		
		$products_=array();

		
		foreach($products as $p){
		    if($time>=$p['date_start'] && $time<=$p['date_end'] && $p['special_price']>=0){ 
			    $p['price']=$p['special_price'];
			}
			
			$p['image']=$this->model_tool_image->resize($p['image'],50,60);
		    $p['attribute']=!empty($p['attribute'])?$p['attribute']:' 无';
			$products_[]=$p;
			
		}
		// var_dump($products_);
	    
		$this->data['products']=$products_;
		
	    
	    $this->children = array(
		    'try/header',
			'try/footer'
		);
		
		
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/try/confirm.html')) {
			$this->template = $this->config->get('config_template') . '/template/try/confirm.html';
		} else {
			$this->template = 'default/template/try/confirm.html';
		}
		
		
				
		$this->response->setOutput($this->render());
	
	}
	
	public function deleteTryProduct(){
	    $try_id=$this->request->post['try_id'];
		
		if(empty($try_id)) return;
		$this->load->model('try/try');
		
		if($this->model_try_try->deleteTryProduct($try_id)){
		    echo 1;exit;
		}else{
		    echo 0;exit;
		}
	
	}
	
	public function validateCaptcha(){
	 
	    $captcha=$this->request->post['captcha'];
		if($this->session->data['captcha'] ==$captcha){
		    echo 'yes';exit;
		}else{
		    echo 'no';exit;
		}
	
	}
	
	public function validateMessage(){
	    $message=$this->memcached->get('try_your_product');
		
		$captcha_=$this->request->post['captcha_'];
		
		if(empty($captcha_) || empty($message)) echo 'no';exit;
		
		if($captcha_==$message){
		    $this->memcached->set('try_your_product',null);
		    echo 'yes';exit;
		}else{
		    echo 'no';exit;
		}
	
	}
	
	
	public function sendMessage(){
	    $rand=rand(100000,999999);
		
	    $this->memcached->set('try_your_product',$rand);
		
	    $mobile=$this->request->post['mobile'];
		$time=time();
		
		$sql="insert into ".DB_PREFIX."try_tmp_message set mobile='{$mobile}',sendtime='{$time}'";
		
		$this->db->query($sql);
	
	}
	
	public function test(){
	    echo $this->memcached->get('try_your_product');
	
	}
}
	
?>