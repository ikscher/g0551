<?php 
	
class ControllerMerchantsTry extends Controller { 
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
		
		$this->load->model('merchants/try');
		$this->load->model('account/customer');
		$this->load->model('catalog/product');
		$this->load->model('tool/image');
		
		//是否试用
		$is_try=isset($this->request->post['is_try'])?$this->request->post['is_try']:null;
		if(is_numeric($is_try)) $is_try=intval($is_try);
		
		$customer_id=isset($this->request->post['customer_id'])?$this->request->post['customer_id']:"";
		$product_id=isset($this->request->post['product_id'])?$this->request->post['product_id']:"";
		$trytime=isset($this->request->post['trytime'])?$this->request->post['trytime']:"";
		
		//当前页
		$page=isset($this->request->get['page'])?intval($this->request->get['page']):1;
		
		//每页显示多少条记录
		$limit=10;
		//总记录数
		
		
		$data=array(
			"customer_id"=>$customer_id,
			"is_try"=>$is_try,
			"product_id"=>$product_id,
			"trytime"=>$trytime,
			'start'=>($page-1)*$limit,
			'limit'=>$limit
		);
		
		$this->data["info"]=$data;
		//获取分页列表
		$this->data["tryList"]=array();
		
		
		$total = $this->model_merchants_try->getTotalTry($data);

		$results = $this->model_merchants_try->getTryList($data);
		
		//var_dump($results);
		
		$items=array();
		foreach ($results as $v) {
			$v['product'] = $this->model_catalog_product->getProduct($v['product_id']);
			$v['trytime']=date('Y-m-d H:i:s',$v['trytime']);
			$v['is_try_cn']=($v['is_try']==0)?'未试用':'已试用';
			$v['product']['image']=$this->model_tool_image->resize($v['product']['image'],50,50);
			//$items[$v['customer_id']]['customer']=$this->model_account_customer->getCustomer($v['customer_id']);
			
			//$items[$v['customer_id']]['products'][]=$v;
			
			if(!empty($v['customer_id'])){//注册会员
			    $items[$v['customer_id']]['customer']=$this->model_merchants_try->getCustomer($v['customer_id']);
			
			    $items[$v['customer_id']]['products'][]=$v;
			}else{ //未注册会员
			    $items[$v['mobile']]['products'][]=$v;
			
			}
		}
		
		$this->data['tryList']=$items;

		$pagination = new Pagination('results','links');
		$pagination->total = $total;
		$pagination->page = $page;

		$pagination->limit = $limit;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('merchants/try', "page={page}&is_try={$is_try}&product_id={$product_id}&customer_id={$customer_id}&trytime={$trytime}", 'SSL');
		$this->data["page"]=$pagination->render();
		
		
		$this->children = array(
			'merchants/left',
			'merchants/footer',
			'merchants/header'		
		);
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/merchants/merchants_try.html')) {
			$this->template = $this->config->get('config_template') . '/template/merchants/merchants_try.html';
		} else {
			$this->template = 'default/template/merchants/merchants_try.html';
		}
		
		$this->response->setOutput($this->render());
  	}
	
	public function confirm(){
	    $try_id_list=array();
		$json=array('m'=>'c');
		
	    $this->load->model('merchants/try');
		$try_id_list=$this->request->post['try_id'];
		
		$is_try=isset($this->request->post['is_try'])?$this->request->post['is_try']:1;
		
		if(is_array($try_id_list)){
			foreach($try_id_list as $v){
				$this->model_merchants_try->confirm($v,$is_try);
			}  
		}else{
		    $this->model_merchants_try->confirm($try_id_list,$is_try);
		}
		$this->response->setOutput(json_encode($json));
		
	}
	
	
	
}
?>