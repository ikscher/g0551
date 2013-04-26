<?php 
	/**
	* 买家退换货的商品
	*/
class ControllerMerchantsReturn extends Controller { 
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
	//申请退货的商品
	*/
	public function index() {
		$this->check_customer();

		$this->load->model('merchants/return');
		
		//退换货状态处理
		$state=isset($this->request->request['s'])?intval($this->request->request['s']):7;
	
		
		$statusid=ORDER_REFUND;//	

		//当前页
		$page=isset($this->request->get['page'])?intval($this->request->get['page']):1;
		
		
		$data=array();
		$limit=10;
		$data=array( 
					'start'=>($page-1)*$limit,
					'limit'=>$limit,
					'statusid'=>$statusid);
						
		//总记录数
		$total = $this->model_merchants_return->getTotalReturn($data);
	
		
		//获取分页列表
		$this->data["returnList"]=array();
		$result = $this->model_merchants_return->getReturns($data);
		foreach ($result as $item) {
			$item["date_added"]=date("Y-m-d H:i:s",$item["date_added"]);
			$this->data["returnList"][]=$item;
		}

		$pagination = new Pagination('results','links');
		$pagination->total = $total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('merchants/return', "page={page}&s={$state}", 'SSL');
		$this->data["page"]=$pagination->render();

		
		$this->children = array(
			'merchants/left',
			'merchants/footer',
			'merchants/header'		
		);
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/merchants/merchants_return.html')) {
			$this->template = $this->config->get('config_template') . '/template/merchants/merchants_return.html';
		} else {
			$this->template = 'default/template/merchants/merchants_return.html';
		}
		
		$this->response->setOutput($this->render());
  	}
	
	/**
	//退换商品详情
	*/
	public function detail() {
		$this->check_customer();
		
		$this->children = array(
			'merchants/left',
			'merchants/footer',
			'merchants/header'		
		);
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/merchants/return_detail.html')) {
			$this->template = $this->config->get('config_template') . '/template/merchants/return_detail.html';
		} else {
			$this->template = 'default/template/merchants/return_detail.html';
		}
		
		$intReturn=isset($this->request->get['id'])?intval($this->request->get['id']):0;
		if($intReturn==0 || !is_numeric($intReturn)) $this->showMessage("对不起，退换货不存在！");
		
		$this->load->model('merchants/return');
		$returninfo=$this->model_merchants_return->getReturnInfo($intReturn);
		if(count($returninfo)==0) $this->showMessage("对不起，退换货不存在或您无权查看！");
		$this->data["return"]=$returninfo;
		$this->data["return"]["date_added"]=date("Y-m-d H:i:s",$returninfo["date_added"]);
		$this->data["return"]["order_date"]=date("Y-m-d H:i:s",$returninfo["order_date"]);
		$this->response->setOutput($this->render());
	}
	
	/**
	* 设置退换信息状态
	*/
	public function setstate() {
		$this->check_customer();
	
		$state=isset($this->request->request['state'])?intval($this->request->request['state']):1;
		if(!is_numeric($state))$state=1;
		$state=intval($state);
		switch($state){
			case 1:
			case 2:
			case 3:
				$state=intval($state);
				break;
			default:
				$state=1;
		}
	
		$intOrder=isset($this->request->post['id'])?intval($this->request->post['id']):0;
		if($intOrder==0 || !is_numeric($intOrder)) $this->showMessage("对不起，退换信息不存在！");

		$this->load->model('merchants/return');
		$result=$this->model_merchants_return->setReturnState($intOrder,$state);
		if($result!="ok"){
			exit("对不起已发货状态设置失败！");
		}
		exit("ok");
	}
}
?>