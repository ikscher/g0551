<?php 
	/**
	* 商家正在销售的商品
	*/
class ControllerMerchantsSell extends Controller { 
	//身份验证
	private function check_customer(){
		if (!$this->customer->isLogged()) {
	  		$this->session->data['redirect'] = $this->url->link('merchants/merchants', '', 'SSL');
	  		$this->redirect($this->url->link('account/login', '', 'SSL')); 
    	} 

		/* $store_id=$this->cookie->OCAuthCode($this->request->cookie['storeid'],'DECODE');
		if(empty($store_id)){
			$this->showMessage("您还没有开店，或登录已超时，请重新登录！");
		} */
	}
	
	public function index() {
		$this->check_customer();
		$this->load->model('tool/image');
		
		
		$name=isset($this->request->request['name'])?$this->request->request['name']:"";
		$model=isset($this->request->request['model'])?$this->request->request['model']:"";
		$price1=isset($this->request->request['price1'])?$this->request->request['price1']:"";
		$price2=isset($this->request->request['price2'])?$this->request->request['price2']:"";
		if($price1!=""&&!is_numeric($price1))exit("对不起，商品价格只能输入数值!");
		if($price2!=""&&!is_numeric($price2))exit("对不起，商品价格只能输入数值!");

		$this->load->model('merchants/product');
		//$data=array("name"=>$name,"model"=>$model,"price1"=>$price1,"price2"=>$price2,"where"=>" And status=1");
		//$this->data["data"]=$data;
		$this->data['name']=$name;
		$this->data['model']=$model;
		$this->data['price1']=$price1;
		$this->data['price2']=$price2;
		
		//搜索地址
		$this->data["search_url"]=$this->url->link('merchants/sell', '', 'SSL');
		
		//当前页
		$page=isset($this->request->get['page'])?intval($this->request->get['page']):1;
		
	    $time=time();
		$data=array();
		$limit=10;
		$data=array( 
					'start'=>($page-1)*$limit,
					'limit'=>$limit,
					'status'=>1,//上架
					'date_available'=>$time,
					'price1'=>$price1,
					'price2'=>$price2,
					'name'=>$name,
					'model'=>$model);
		//总记录数
		$product_total = $this->model_merchants_product->getTotalProducts($data);
		
		
		//获取分页列表
		$this->data["list"]=array();
		$results = $this->model_merchants_product->getList($data);
		
		foreach ($results as $result) {
			$result["category_id"]=$this->model_merchants_product->getCategoryId($result["product_id"]);
			$result["date_added"]=date("Y-m-d H:i:s",$result["date_added"]);
			
			
			if ($result['image']) {
				$result['image'] = $this->model_tool_image->resize($result['image'], 50, 50);                    
			} else {
				$result['image'] = false;
			}  
			$result["edit_url"]=$this->url->link('merchants/release/detail&cid='. $result["category_id"] .'&product_id='.$result["product_id"], '', 'SSL');
			$this->data["list"][]=$result;
		}
		
	
		
		$pagination = new Pagination('results','links');
		$pagination->total = $product_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('merchants/sell', "page={page}&name={$name}&model={$model}&price1={$price1}&price2={$price2}", 'SSL');
		$this->data["page"]=$pagination->render();
	
		
		$this->children = array(
			'merchants/left',
			'merchants/footer',
			'merchants/header'		
		);
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/merchants/merchants_sell.html')) {
			$this->template = $this->config->get('config_template') . '/template/merchants/merchants_sell.html';
		} else {
			$this->template = 'default/template/merchants/merchants_sell.html';
		}
		
		$this->response->setOutput($this->render());
  	}
	
	//删除店铺商品信息
	public function del() {
		$this->check_customer();
		
		$intId=isset($this->request->post['product_id'])?$this->request->post['product_id']:"";
		if($intId=="")exit("对不起，操作不正确!");

		$this->load->model('merchants/product');
		$result=$this->model_merchants_product->setProductStatus('status',2,$intId);
		if($result!="ok"){
			exit("对不起，宝贝删除失败！");
		}
		exit("ok");
  	}
	
	//上架店铺商品信息
	public function up() {
		$this->check_customer();
		
		$intId=isset($this->request->post['product_id'])?$this->request->post['product_id']:"";
		if($intId=="")exit("对不起，操作不正确!");

		$this->load->model('merchants/product');
		$result=$this->model_merchants_product->setProductStatus('status',1,$intId);
		if($result!="ok"){
			exit("对不起，宝贝上架失败！");
		}
		exit("ok");
  	}
	
	//下架店铺商品信息
	public function down() {
		$this->check_customer();
		
		$intId=isset($this->request->post['product_id'])?$this->request->post['product_id']:"";
		if($intId=="")exit("对不起，操作不正确!");

		$this->load->model('merchants/product');
		$result=$this->model_merchants_product->setProductStatus('status',3,$intId);
		if($result!="ok"){
			exit("对不起，宝贝下架失败！");
		}
		exit("ok");
  	}
	
	
	//设置商品主图片信息
	public function setimg() {
		$this->check_customer();
		
		$intImgId=isset($this->request->post['img_id'])?$this->request->post['img_id']:"";
		$intProductId=isset($this->request->post['pro_id'])?$this->request->post['pro_id']:"";
		if($intImgId==""||$intProductId=="")exit("对不起，操作不正确!");

		$this->load->model('merchants/product');
		$result=$this->model_merchants_product->setProductImage($intImgId,$intProductId);
		if($result!="ok"){
			exit("对不起，宝贝主图设置失败！");
		}
		exit("ok");
  	}
	
	
	//删除商品图片信息
	public function delimg() {
		$this->check_customer();
		
		$intImgId=isset($this->request->post['img_id'])?$this->request->post['img_id']:"";
		$intProductId=isset($this->request->post['pro_id'])?$this->request->post['pro_id']:"";
		if($intImgId==""||$intProductId=="")exit("对不起，操作不正确!");

		$this->load->model('merchants/product');
		$result=$this->model_merchants_product->delProductImage($intImgId,$intProductId);
		if($result!="ok"){
			exit("对不起，宝贝图片删除失败！");
		}
		exit("ok");
  	}
}
?>