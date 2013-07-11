<?php 
	
class ControllerTryTry extends Controller { 

	public function index() {
	   
	    $this->load->language('try/try');
		$this->load->model('try/try');
		$this->load->model('catalog/product');
		$this->load->model('tool/image');
		
		$this->data['heading_title']=$this->language->get('heading_title');
	    $this->data['button_delete'] = $this->language->get('button_delete');	
        $this->data['button_refresh'] = $this->language->get('button_refresh');			
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['refresh'] = $this->url->link('try/try','token=' . $this->session->data['token'],'SSL');
		
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
		
		
		
		$total = $this->model_try_try->getTotalTry($data);

		$results = $this->model_try_try->getTryList($data);
		
		//var_dump($results);
		
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$server = HTTP_CATALOG;
		} else {
			$server = HTTP_CATALOG;
		}
		
		$items=array();
		foreach ($results as $v) {
			$v['product'] = $this->model_catalog_product->getProduct($v['product_id']);
            $v['product']['url']= $server ."index.php?route=try/product&product_id={$v['product_id']}";
			$v['trytime']=date('Y-m-d H:i:s',$v['trytime']);
			$v['is_try_cn']=($v['is_try']==0)?'未试用':'已试用';
			$v['product']['image']=$this->model_tool_image->resize($v['product']['image'],50,50);
			
			if(!empty($v['customer_id'])){//注册会员
			    $items[$v['customer_id']]['customer']=$this->model_try_try->getCustomer($v['customer_id']);
			
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
		$pagination->url = $this->url->link('try/try', 'token=' . $this->session->data['token']."&page={page}&is_try={$is_try}&product_id={$product_id}&customer_id={$customer_id}&trytime={$trytime}", 'SSL');
		$this->data["page"]=$pagination->render();
		
		
		$this->template = 'try/try.html';
		
	
		$this->response->setOutput($this->render());
  	}
}

?>