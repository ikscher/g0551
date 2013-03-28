<?php 
	/**
	* 商家等待发货的订单
	*/
class ControllerMerchantsOrder extends Controller { 
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
		$this->load->model('account/order');
		
		$statusid=ORDER_WAITING;//
		
		
		$this->load->language('merchants/left');
		$this->data['waitingorder']=$this->language->get('waitingorder');
		$this->data['dealingorder']=$this->language->get('dealingorder');
		$this->data['createorder']=$this->language->get('createorder');
		$this->data['dealedorder']=$this->language->get('dealedorder');
		
		//当前页
		$page=isset($this->request->get['page'])?intval($this->request->get['page']):1;
		
		
		$data=array();
		$limit=10;
		$data=array( 
					'start'=>($page-1)*$limit,
					'limit'=>$limit,
					'statusid'=>$statusid);
						
		
		$product_total = $this->model_merchants_order->getTotalOrder($data);
		
		
		//获取分页列表
		$this->data["orderList"]=array();
		$result = $this->model_merchants_order->getOrderList($data);
		foreach ($result as $item) {
			$item["product_list"]=array();
			$item["date_added"]=date("Y-m-d H:i:s",$item["date_added"]);
			$product=$this->model_merchants_order->getOrderProduct($item["order_id"]);
			foreach ($product as $p) {
				if ($p['image']) {
					$p['image'] = $this->model_tool_image->resize($p['image'], 50, 50);                    
				} else {
					$p['image'] = false;
				}    
				
				$item["product_list"][]=$p;
			}
			$item['shipping']= $this->model_account_order->getOrderTotals($item['order_id'],'shipping');
			$this->data["orderList"][]=$item;
		}
		$result=null;

		$pagination = new Pagination('results','links');
		$pagination->total = $product_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('merchants/order', "page={page}", 'SSL');
		$this->data["page"]=$pagination->render();
		
		$this->children = array(
			'merchants/left',
			'merchants/footer',
			'merchants/header'		
		);
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/merchants/merchants_order.html')) {
			$this->template = $this->config->get('config_template') . '/template/merchants/merchants_order.html';
		} else {
			$this->template = 'default/template/merchants/merchants_order.html';
		}
		
		$this->response->setOutput($this->render());
  	}
	
	/**
	//订单详情
	*/
	public function detail() {
		$this->check_customer();
		
		
		
		$intOrder=isset($this->request->get['id'])?intval($this->request->get['id']):0;
		if($intOrder==0 || !is_numeric($intOrder)) $this->showMessage("对不起，订单不存在！");
		
		$this->load->model('merchants/order');
		$this->load->model('account/order');
		$this->load->model('tool/image');
		
		$orderinfo=$this->model_merchants_order->getOrderOnce($intOrder);
		if(count($orderinfo)==0) $this->showMessage("对不起，订单不存在或您无权查看！");
		$product=$this->model_merchants_order->getOrderProduct($orderinfo["order_id"]);
		
		foreach ($product as $p) {
			if ($p['image']) {
				$p['image'] = $this->model_tool_image->resize($p['image'], 50, 50);                    
			} else {
				$p['image'] = false;
			}   
			
			$product_list[]=$p;
		}
		
		$this->data["order"]=$orderinfo;
		$this->data["order"]["date_added"]=date("Y-m-d H:i:s",$orderinfo["date_added"]);
		$this->data["order"]["product_list"]=$product_list;
		$this->data['order']['shipping']=$this->model_account_order->getOrderTotals($orderinfo['order_id'],'shipping');
		
		$this->children = array(
			'merchants/left',
			'merchants/footer',
			'merchants/header'		
		);
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/merchants/order_detail.html')) {
			$this->template = $this->config->get('config_template') . '/template/merchants/order_detail.html';
		} else {
			$this->template = 'default/template/merchants/order_detail.html';
		}
		
		$this->response->setOutput($this->render());
	}
	
	/**
	* 开始配货所选订单(设为发货中状态)
	*/
	public function detachGoods() {
		$this->check_customer();
	
		$order_id=isset($this->request->post['order_id'])?intval($this->request->post['order_id']):0;
		
		if($order_id==0 || !is_numeric($order_id)) $this->showMessage("对不起，订单不存在！");

		$this->load->model('merchants/order');
		$result=$this->model_merchants_order->setOrderState($order_id,ORDER_DETACHING,ORDER_WAITING);
		if($result){
			exit('ok');
		}else{
			exit('no');
		}
	}
	
	
	/**
	* 已发货所选订单(设为已发货状态)
	*/
	public function wrapGoods() {
		$this->check_customer();
	
		$order_id=isset($this->request->post['order_id'])?intval($this->request->post['order_id']):0;
		if($order_id==0 || !is_numeric($order_id)) $this->showMessage("对不起，订单不存在！");

		$this->load->model('merchants/order');
		$result=$this->model_merchants_order->setOrderState($order_id,ORDER_OVER,ORDER_DETACHING);
		if($result){
			exit('ok');
		}else{
			exit('no');
		}
	}
	
}
?>