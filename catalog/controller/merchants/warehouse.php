<?php 
	/**
	* 商家已下架的商品
	*/
class ControllerMerchantsWarehouse extends Controller { 
	//身份验证
	private function check_customer(){
		if (!$this->customer->isLogged()) {
	  		$this->session->data['redirect'] = $this->url->link('merchants/merchants', '', 'SSL');
	  		$this->redirect($this->url->link('account/login', '', 'SSL')); 
    	} 

		$store_id=$this->cookie->OCAuthCode($this->request->cookie['storeid'],'DECODE');
		if(empty($store_id)){
			$this->showMessage("您还没有开店，或登录已超时，请重新登录！");
		}
	}
	
	public function index() {
		$this->check_customer();
		
		$this->load->model('tool/image');
		
		$name=isset($this->request->request['name'])?$this->request->request['name']:"";
		$model=isset($this->request->request['model'])?$this->request->request['model']:"";
		$price1=isset($this->request->request['price1'])?$this->request->request['price1']:"";
		$price2=isset($this->request->request['price2'])?$this->request->request['price2']:"";
       
		
		$this->load->model('merchants/product');
		//$data=array("name"=>$name,"model"=>$model,"price1"=>$price1,"price2"=>$price2,"where"=>" And status=0");
		//$this->data["data"]=$data;
		$this->data['name']=$name;
		$this->data['model']=$model;
		$this->data['price1']=$price1;
		$this->data['price2']=$price2;
		//搜索地址
		$this->data["search_url"]=$this->url->link('merchants/warehouse', '', 'SSL');
		
		//当前页
		$page=isset($this->request->get['page'])?intval($this->request->get['page']):1;
	    
        $time=time();
		$data=array();
		$limit=10;
		$data=array( 
					'start'=>($page-1)*$limit,
					'limit'=>$limit,
					'status'=>3,//下架
					'date_available'=>$time,
					'name'=>$this->data['name'],
					'model'=>$this->data['model'],
					'price1'=>$this->data['price1'],
					'price2'=>$this->data['price2']);
		
		
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
			$result["edit_url"]=$this->url->link('merchants/release/detail&status=3&cid='. $result["category_id"] .'&product_id='.$result["product_id"], '', 'SSL');
			$this->data["list"][]=$result;
		}
		
		$pagination = new Pagination('results','links');
		$pagination->total = $product_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('merchants/warehouse', "page={page}&name={$name}&model={$model}&price1={$price1}&price2={$price2}", 'SSL');
		$this->data["page"]=$pagination->render();
		
		$this->children = array(
			'merchants/left',
			'merchants/footer',
			'merchants/header'		
		);
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/merchants/merchants_warehouse.html')) {
			$this->template = $this->config->get('config_template') . '/template/merchants/merchants_warehouse.html';
		} else {
			$this->template = 'default/template/merchants/merchants_warehouse.html';
		}
		
		$this->response->setOutput($this->render());
  	}
}
?>