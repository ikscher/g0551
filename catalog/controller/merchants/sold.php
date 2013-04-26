<?php 
	/**
	* 商家已卖出的商品
	*/
class ControllerMerchantsSold extends Controller { 
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
	
	/**
	//等待发货的订单
	*/
	public function index() {
		$this->check_customer();
		
		$this->load->model('merchants/order');
		$this->load->model('tool/image');
		
		
		//订单状态处理
		$state=isset($this->request->request['s'])?intval($this->request->request['s']):0;
		if(!is_numeric($state))$state=0;
		$state=intval($state);
		
		$statusid='4,5,6';//
		
		$order_id=isset($this->request->request['i'])?$this->request->request['i']:"";
		$email=isset($this->request->request['e'])?$this->request->request['e']:"";
		$mobile=isset($this->request->request['m'])?$this->request->request['m']:"";
		$cname=isset($this->request->request['cn'])?$this->request->request['cn']:"";
		$cmobile=isset($this->request->request['cm'])?$this->request->request['cm']:"";
		$ctelphone=isset($this->request->request['ct'])?$this->request->request['ct']:"";
		$order_time=isset($this->request->request['t'])?$this->request->request['t']:"";
		
		$state_list=array(ORDER_CREATED=>"买家未付款",ORDER_PAID=>"买家已付款",ORDER_DETACHING=>"正在配货",ORDER_OVER=>"已发货",ORDER_SUCCESS=>"交易成功",ORDER_CLOSE=>"交易已关闭");
		
		
		
		
		
		//当前页
		$page=isset($this->request->get['page'])?intval($this->request->get['page']):1;
		
		//每页显示多少条记录
		$limit=10;
		//总记录数
		
		
		$data=array(
			"state"=>$state,
			"order_id"=>$order_id,
			"email"=>$email,
			"mobile"=>$mobile,
			"cname"=>$cname,
			"cmobile"=>$cmobile,
			"ctelphone"=>$ctelphone,
			"order_time"=>$order_time,
			'start'=>($page-1)*$limit,
			'limit'=>$limit,
			'statusid'=>$statusid
		);
		$this->data["state"]=$state;
		$this->data["info"]=$data;
		//获取分页列表
		$this->data["orderList"]=array();
		
		
		$product_total = $this->model_merchants_order->getTotalOrder($data);

		$result = $this->model_merchants_order->getOrderList($data);
		foreach ($result as $item) {
			$item["product_list"]=array();
			$item["date_added"]=date("Y-m-d H:i:s",$item["date_added"]);
			$item["order_state"]=$state_list[$item["order_status_id"]];
			$product=$this->model_merchants_order->getOrderProduct($item["order_id"]);
			foreach ($product as $p) {
				if ($p['image']) {
					$p['image'] = $this->model_tool_image->resize($p['image'], 50, 50);                    
				} else {
					$p['image'] = false;
				}  
				$item["product_list"][]=$p;
			}
			$this->data["orderList"][]=$item;
		}

		$pagination = new Pagination('results','links');
		$pagination->total = $product_total;
		$pagination->page = $page;

		$pagination->limit = $limit;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('merchants/sold', "page={page}&s={$state}&e={$email}&m={$mobile}&cn={$cname}&ct={$ctelphone}&cm={$cmobile}&t={$order_time}", 'SSL');
		$this->data["page"]=$pagination->render();
		
		
		$this->children = array(
			'merchants/left',
			'merchants/footer',
			'merchants/header'		
		);
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/merchants/merchants_sold.html')) {
			$this->template = $this->config->get('config_template') . '/template/merchants/merchants_sold.html';
		} else {
			$this->template = 'default/template/merchants/merchants_sold.html';
		}
		
		$this->response->setOutput($this->render());
  	}
}
?>