<?php 

class ControllerTryTry extends Controller { 
	public function index() {
		
		$this->data['heading_title'] = $this->language->get('heading_title');

	 
		$this->load->model('catalog/category');
        $this->data['clothes'] = $this->url->link('product/category','category_id='.ModelCatalogCategory::$CATEGORY_CLOTHES,'SSL');
		$this->data['foods']   = $this->url->link('product/category','category_id='.ModelCatalogCategory::$CATEGORY_FOODS,'SSL');
		$this->data['house']   = $this->url->link('product/category','category_id='.ModelCatalogCategory::$CATEGORY_HOUSE,'SSL');
		$this->data['travel']   = $this->url->link('product/category','category_id='.ModelCatalogCategory::$CATEGORY_TRAVEL,'SSL');
		$this->data['joy']    =  $this->url->link('common/home/joy','','SSL');
        
		$this->load->model('tool/image');
		$this->load->model('try/try');
		
		$url="";
		if(isset($this->request->get['s'])){
		    $search= urldecode($this->request->get['s']);
			$url .= "&s={$search}";
		}else{
		    $search='';
		}
		$this->data['searchp']=$search;
		
		$data=array(
		        'search'=>$search
		);
		
		
		$products=$this->model_try_try->getProducts($data);
		
	    
		$products_=array();
		
		
		if (isset($this->request->get['page'])) {
		    $page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		$offset=15;
		$total=count($products);
		
		if(!empty($products)) $slicedata=array_slice($products,($page-1)*$offset,$offset);
     
	    
		
		
		if(!empty($slicedata)){
			foreach($slicedata as $p){
				//$p['category']=$this->model_try_try->getProductLevelCategory($p['product_id']);
				
				if(!empty($p['image'])) {
				    
				    $p['image']=$this->model_tool_image->generate($p['image'],300,210,'scale');
					//$p['image']=$this->model_tool_image->resize($p['image'],300,210,'yes');
					
				}
				$p['shortname']=OcCutstr($p['name'],30);
				$p['discount']=!empty($p['special_price'])?number_format($p['price']/$p['special_price'],2):1;
				$products_[]=$p;
			}
			
			
			$this->data['products']=$products_;
        }
		
		
		
		$pagination = new Pagination('results','links');
		$pagination->total = $total;
		$pagination->page = $page;
		$pagination->limit = $offset;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('try/try','page={page}'.$url, 'SSL');
		
		$this->data['pagination'] = $pagination->render();
		
		
		
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
	
	/*测试生成图片的*/
	public function generateImage_(){


		$image = new lib_image_imagick();

		$image->open('image\data\2013\05\31\153147_12963.jpg');
		$image->resize_to(200, 200, 'scale_fill');
		$image->add_text('1024i.com', 10, 20);
		//$image->add_watermark('images/watermark.png', 10, 50);
		$image->save_to('image\data\2013\05\31\1_.jpg');
	}	 

}
?>