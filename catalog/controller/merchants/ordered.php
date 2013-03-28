<?php 
	/**
	* 商家已发货订单
	*/
class ControllerMerchantsOrdered extends Controller { 
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
		
		
		
		$this->load->model('merchants/order');
		$this->load->model('tool/image');
		$this->load->model('account/order');
		
		$this->load->language('merchants/left');
		$this->data['waitingorder']=$this->language->get('waitingorder');
		$this->data['dealingorder']=$this->language->get('dealingorder');
		$this->data['createorder']=$this->language->get('createorder');
		$this->data['dealedorder']=$this->language->get('dealedorder');
		
		$statusid=ORDER_OVER.','.ORDER_SUCCESS.','.ORDER_CLOSE;//
		
		//当前页
		$page=isset($this->request->get['page'])?intval($this->request->get['page']):1;
		
		$data=array();
		$limit=10;
		$data=array( 
					'start'=>($page-1)*$limit,
					'limit'=>$limit,
					'statusid'=>$statusid);
		
		//总记录数
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
			$item['order_status']=$this->model_account_order->getOrderStatus($item['order_status_id']);
			$this->data["orderList"][]=$item;
		}

		$pagination = new Pagination('results','links');
		$pagination->total = $product_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('merchants/ordered', "page={page}", 'SSL');
		$this->data["page"]=$pagination->render();
		
		
		$this->children = array(
			'merchants/left',
			'merchants/footer',
			'merchants/header'		
		);
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/merchants/merchants_ordered.html')) {
			$this->template = $this->config->get('config_template') . '/template/merchants/merchants_ordered.html';
		} else {
			$this->template = 'default/template/merchants/merchants_ordered.html';
		}
		
		$this->response->setOutput($this->render());
  	}
}
?>