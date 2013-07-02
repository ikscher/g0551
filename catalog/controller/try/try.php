<?php 
class ControllerTryTry extends Controller { 
	public function index() {
		/* if (!$this->customer->isLogged()) {
	  		//$this->session->data['redirect'] = $this->url->link('try/try', '', 'SSL');
	  
	  		$this->redirect($this->url->link('account/login', '', 'SSL'));
    	}  */
	
		//$this->language->load('try/try');

		// $this->document->setTitle($this->language->get('heading_title'));
        
		$this->data['referer']='index.php?route=try/try';
        
      	$this->data['login']="index.php?route=account/login";
		
		
    	$this->data['heading_title'] = $this->language->get('heading_title');

    	
		$this->data['home'] =$this->url->link('common/home','','SSL');
		$this->data['logout'] =$this->url->link('account/logout','','SSL');

	 
		$this->load->model('catalog/category');
        $this->data['clothes'] = $this->url->link('product/category','category_id='.ModelCatalogCategory::$CATEGORY_CLOTHES,'SSL');
		$this->data['foods']   = $this->url->link('product/category','category_id='.ModelCatalogCategory::$CATEGORY_FOODS,'SSL');
		$this->data['house']   = $this->url->link('product/category','category_id='.ModelCatalogCategory::$CATEGORY_HOUSE,'SSL');
		$this->data['travel']   = $this->url->link('product/category','category_id='.ModelCatalogCategory::$CATEGORY_TRAVEL,'SSL');
		$this->data['joy']    =  $this->url->link('common/home/joy','','SSL');
        
		$this->load->model('tool/image');
		$this->load->model('try/try');
		$products=$this->model_try_try->getProducts();
		 
		$products_=array();
		foreach($products as $p){
			$p['category']=$this->model_try_try->getProductLevelCategory($p['product_id']);
			if(!empty($p['image'])) {
			    $p['image']=$this->model_tool_image->resize($p['image'],250,250);
			}
			$p['shortname']=OcCutstr($p['name'],10);
			$p['discount']=!empty($p['special_price'])?number_format($p['price']/$p['special_price'],2):1;
			$products_[]=$p;
		}
		
		
		$this->data['products']=$products_;
        
		if ($this->customer->isLogged()){
			if(isset($this->request->cookie['oc_customer'])){
				$customer=$this->cookie->OCAuthCode($this->request->cookie['customer'],'DECODE');
				$customer=unserialize($customer);
				
				$this->data['username']=$customer['email'];
			}
		}else{
		    $this->data['username']='';
		}
		
		
		
		$this->children = array(
		    'try/header',
			'try/footer'
		);
		
		
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/try/index.html')) {
			$this->template = $this->config->get('config_template') . '/template/try/index.html';
		} else {
			$this->template = 'default/template/try/index.html';
		}
		
		
				
		$this->response->setOutput($this->render());
 
	
    }
	
	
	
	
	public function sendMail(){
	    $this->load->library('class.phpmailer'); //载入PHPMailer类 
        
		$mail = new PHPMailer(); //实例化 
		$mail->IsSMTP(); // 启用SMTP 
		//$mail->Host = "smtp.exmail.qq.com"; //SMTP服务器 以163邮箱为例子 
		$mail->Host="127.0.0.1";
		$mail->Port = 25;  //邮件发送端口 
		$mail->SMTPAuth   = true;  //启用SMTP认证 
		 
		$mail->CharSet  = "UTF-8"; //字符集 
		$mail->Encoding = "base64"; //编码方式 
		 
		$mail->Username = "ikscher@g0551.com";  //你的邮箱 
		$mail->Password = "cy4374866";  //你的密码 
		$mail->Subject = "你好"; //邮件标题 
		 
		$mail->From = "ikscher@g0551.com";  //发件人地址（也就是你的邮箱） 
		$mail->FromName = "月光光";  //发件人姓名 
		 
		$address = "45397312@qq.com";//收件人email 
		$mail->AddAddress($address, "亲");//添加收件人（地址，昵称） 
		 
		//$mail->AddAttachment('xx.xls','我的附件.xls'); // 添加附件,并指定名称 
		$mail->IsHTML(true); //支持html格式内容 
		//$mail->AddEmbeddedImage("logo.jpg", "my-attach", "logo.jpg"); //设置邮件中的图片 
		$mail->Body = '你好, <b>朋友</b>! <br/>这是一封来自<a href="http://www.helloweba.com"  
		target="_blank">helloweba.com</a>的邮件！<br/> 
		<img alt="helloweba" src="cid:my-attach">'; //邮件主体内容 
		 
		//发送 
		if(!$mail->Send()) { 
		  echo "Mailer Error: " . $mail->ErrorInfo; 
		} else { 
		  echo "Message sent!"; 
		} 
	}
    
	
    public function sendMessage(){

		$time=time();
		
		
        $this->redirect($this->url->link('try/try/sending',"time={$time}",'SSL'));
    }	
	
	public function sending(){
	    $results=array();
		
	    $json=array();
		
		//$rand=$this->memcached->get('try_your_product');
		

		/* $sql="select mobile,sendtime,captcha from ".DB_PREFIX."try_tmp_message ";
		$query=$this->db->query($sql);
		
		$results=$query->rows; */
		
		$this->load->model('try/try');
		$results=$this->model_try_try->cacheMessages();
		
		if(empty($results)) return;
		
		foreach($results as $v){
		    $time=$v['sendtime'];
			$time=strval($time);
			$mobile=$v['mobile'];
			$message=$v['message'];
			$json[]=array('tel'=>$mobile,'message'=>$message,'time'=>$time);
		
		}
	
		$this->response->setOutput(json_encode($json));
	
	}

}
?>