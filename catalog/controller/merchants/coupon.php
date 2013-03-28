<?php 
	/**
	* 优惠券设置
	*/
class ControllerMerchantsCoupon extends Controller { 
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
		
		$this->children = array(
			'merchants/left',
			'merchants/footer',
			'merchants/header'		
		);
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/merchants/merchants_coupon.html')) {
			$this->template = $this->config->get('config_template') . '/template/merchants/merchants_coupon.html';
		} else {
			$this->template = 'default/template/merchants/merchants_coupon.html';
		}
		
		$this->load->model('merchants/coupon');
		
		$data=array("where"=>"");
		
		//当前页
		$page=isset($this->request->get['page'])?intval($this->request->get['page']):1;
		if(!is_numeric($page))$page=1;
		//每页显示多少条记录
		$page_size=10;
		//总记录数
		$product_total = $this->model_merchants_coupon->getTotalCoupon($data);
		//总页数
		$page_count = ceil($product_total / $page_size);
		//页码有效值处理
		if($page>$page_count)$page=$page_count;
		if($page<1)$page=1;
		
		//获取分页列表
		$this->data["couponList"]=array();
		$result = $this->model_merchants_coupon->getCouponList(($page - 1) * $page_size, $page_size, $data);
		foreach ($result as $item) {
			if($item['type']=="P"){
				$item['type']="百分比";
			}else{
				$item['type']="固定金额";
			}
			if($item['status']==1){
				$item['status']="未使用";
			}else{
				$item['status']="已使用";
			}
			$item["date_start"]=date("Y-m-d",$item["date_start"]);
			$item["date_end"]=date("Y-m-d",$item["date_end"]);
			if($item["customer_id"]>0){
				$item["customer_name"]=$this->model_merchants_coupon->getCustomerInfo($item["customer_id"]);
			}else{
				$item["customer_name"]="-";
			}
			$this->data["couponList"][]=$item;
		}

		$pagination = new Pagination('results','links');
		$pagination->total = $product_total;
		$pagination->page = $page;
		$pagination->num_links = 5;
		$pagination->limit = $page_size;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('merchants/coupon', "page={page}", 'SSL');
		$this->data["page"]=$pagination->render();
				
		$this->response->setOutput($this->render());
  	}
	
	public function add() {
		$this->check_customer();
		
		$this->children = array(
			'merchants/left',
			'merchants/footer',
			'merchants/header'		
		);
		
		$coupon_id=isset($this->request->get["id"])?$this->request->get["id"]:0;
		if($coupon_id=="") $coupon_id=0;
		if(!is_numeric($coupon_id)) $this->showMessage("对不起，优惠券编号不正确！");
		
		$this->load->model('merchants/coupon');
		$info=$this->model_merchants_coupon->getCouponInfo($coupon_id);
		if($info['coupon_id']>0){
			$info['date_start']=date("Y-m-d",$info['date_start']);
			$info['date_end']=date("Y-m-d",$info['date_end']);
		}
		$this->data["info"]=$info;

		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/merchants/merchants_coupon_add.html')) {
			$this->template = $this->config->get('config_template') . '/template/merchants/merchants_coupon_add.html';
		} else {
			$this->template = 'default/template/merchants/merchants_coupon_add.html';
		}
		
		$this->response->setOutput($this->render());
	}
	
	public function insert() {
		$this->check_customer();
		
		//服务器端验证
		$coupon_id   =isset($this->request->post["coupon_id"])?$this->request->post["coupon_id"]:0;
		if($coupon_id==""||!is_numeric($coupon_id)) $coupon_Id=0;
		$name   =isset($this->request->post["coupon_name"])?$this->request->post["coupon_name"]:"";
		$code    =isset($this->request->post["coupon_code"])?$this->request->post["coupon_code"]:"";
		$type  =isset($this->request->post["coupon_type"])?$this->request->post["coupon_type"]:"P";
		$discount    =isset($this->request->post["coupon_discount"])?$this->request->post["coupon_discount"]:"";
		$total   =isset($this->request->post["coupon_total"])?$this->request->post["coupon_total"]:"";
		$date_start   =isset($this->request->post["date_start"])?$this->request->post["date_start"]:"";
	    $date_end   =isset($this->request->post["date_end"])?$this->request->post["date_end"]:"";
		
		if($name=="")$this->showMessage("对不起，请输入优惠券编号！");
		if($code=="")$this->showMessage("对不起，请输入优惠券密码！");
		if($discount=="")$this->showMessage("对不起，请输入优惠折扣！");
		if($total=="")$this->showMessage("对不起，请输入订单限额！");
		if($date_start=="")$this->showMessage("对不起，请输入开始日期！");
		if($date_end=="")$this->showMessage("对不起，请输入结束日期！");
		
		$data=array(
			"coupon_id"=>$coupon_id,
			"name"=>$name,
			"code"=>$code,
			"type"=>$type,
			"discount"=>$discount,
			"total"=>$total,
			"date_start"=>strtotime($date_start),
			"date_end"=>strtotime($date_end),
			"date_added"=>strtotime("now")
		);

		$this->document->setTitle('优惠券设置');
		
		$this->load->model('merchants/coupon');
		
		//新增优惠券时判断优惠券是否存在
		if($coupon_id==0){
			$total = $this->model_merchants_coupon->getTotalCoupon(array("where"=>" And name='{$name}'"));
			if($total>0){
				$this->showMessage("对不起，优惠券编号已存在！");
			}
		}else{
			$total = $this->model_merchants_coupon->getTotalCoupon(array("where"=>" And name='{$name}' And coupon_id!={$coupon_id}"));
			if($total>0){
				$this->showMessage("对不起，优惠券编号已存在！");
			}
		}
		
		$result=$this->model_merchants_coupon->saveInfo($data);
		
		if($result=="no"){
			$this->showMessage("对不起，优惠券信息保失败！");
		}else{
			$this->showMessage("优惠券信息保存成功！",$this->url->link('merchants/coupon/add&id='.$coupon_id, '', 'SSL'));
		}

	}
	
	//删除店铺优惠券信息
	public function del() {
		$this->check_customer();
		
		$intId=isset($this->request->post['id'])?$this->request->post['id']:"";
		if($intId=="")exit("对不起，操作不正确!");

		$this->load->model('merchants/coupon');
		$result=$this->model_merchants_coupon->delCoupon($intId);
		if($result!="ok"){
			exit("对不起，优惠券删除失败！");
		}
		exit("ok");
  	}
	
}
?>