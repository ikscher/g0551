<?php 
/**我的试用**/
class ControllerAccountMyTry extends Controller {  
	private $error = array();
 
	public function index() {
		$this->load->language('account/mytry');
      
		
		$this->load->model('account/mytry');
        $this->load->model('catalog/product');
		 
		$this->getList();
	}

	
	
    
	//批量删除
	public function delete() {
		$this->load->language('account/mytry');

		$this->load->model('account/mytry');
		
		if (isset($this->request->post['selected'])) {

			foreach ($this->request->post['selected'] as $content_id) {
				$this->model_account_mytry->deleteContent($content_id);
			}

			$this->redirect($this->url->link('account/mytry','','SSL'));
		}

		$this->getList();
	}
	
	//单条删除
	public function deleteid() {
		$this->load->language('account/mytry');

		$this->load->model('account/mytry');
		
		if (isset($this->request->get['try_id'])) {
			
			$this->model_account_mytry->deleteContent($this->request->get['try_id']);
			

			$this->redirect($this->url->link('account/mytry','','SSL'));
		}

		$this->getList();
	}
	
	
	/**
	*   所有分类
	*
	*/
	private function getList() {
   	  
	    $this->data['refresh'] = $this->url->link('account/mytry','','SSL');
		$this->data['delete'] = $this->url->link('account/mytry/delete','','SSL');
		$this->data['back'] = $this->url->link('account/account','','SSL');

		
		$url='';
		
		
		if(isset($this->request->request['try_id'])){
		    $try_id=$this->request->request['try_id'];
			$url="&try_id={$try_id}";
		}else{
		    $try_id='';
		}
		
		if(isset($this->request->request['starttime']) && isset($this->request->request['endtime'])){
		    $starttime=$this->request->request['starttime'];
			$endtime=$this->request->request['endtime'];
			$url="&starttime={$starttime}&endtime={$endtime}";
		}else{
		    $starttime='';
		    $endtime='';
		}
		
		if(isset($this->request->request['product_id']) && $this->request->request['product_id']!='' ){
		    $product_id=$this->request->request['product_id'];
			$url="&product_id={$product_id}";
		}else{
		    $product_id='';
		}
		
		if(isset($this->request->request['store_id']) && $this->request->request['store_id']!='' ){
		    $store_id=$this->request->request['store_id'];
			$url="&store_id={$store_id}";
		}else{
		    $store_id='';
		}

		
		if(isset($this->request->request['is_try']) && $this->request->request['is_try']!=''){
		    $is_try=$this->request->request['is_try'];
			$url.="&is_try={$is_try}";
		}else{
		    $is_try='';
		} 
		
		
		$data=array(
		    'content_id'=>$try_id,
			'starttime'=>$starttime,
			'endtime'=>$endtime,
			'product_id' =>$product_id,
			'store_id'  => $store_id,
			'is_try'=>$is_try);
			
	    $this->data['try_id']=$try_id;
		$this->data['starttime']=$starttime;
		$this->data['endtime']=$endtime;
		$this->data['product_id']=$product_id;
		$this->data['store_id']=$store_id;
		$this->data['is_try']=$is_try;
		$this->data['text_delete']=$this->language->get('text_delete');
		
		$results = $this->model_account_mytry->getContents($data);
		
		
		
		if (isset($this->request->get['page'])) {
		    $page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		$offset=15;
		$total=count($results);
		
		$slicedata=array_slice($results,($page-1)*$offset,$offset);
     
		foreach ($slicedata as $result) {
			$action = array();
			
			
			
			$action[] = array(
				'text' => $this->language->get('text_delete'),
				'class'=>'deleteid',
				'href' => $this->url->link('account/mytry/deleteid',  'try_id=' . $result['try_id'], 'SSL')
			);
			
			
			$this->data['contents'][] = array(
				'try_id' => $result['try_id'],
				'product_id' => $result['product_id'],
				'product'=>$this->model_catalog_product->getProduct($result['product_id']),
				//'title'        => strip_tags(htmlspecialchars_decode($result['title'])),
				'attribute'   => $result['attribute'],
				'customer_id'     =>$result['customer_id'],
				'trytime'   => date('Y-m-d H:i:s',$result['trytime']),
				'store_id'    =>$result['store_id'],
				'attribute'   =>$result['attribute'],
				'is_try'    =>$result['is_try'],
				'selected'    => isset($this->request->post['selected']) && in_array($result['try_id'], $this->request->post['selected']),
				'action'      => $action
			);
		}
		

		$slicedata=null;
		
		$this->data['column_mytry'] = $this->language->get('column_mytry');
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['column_try_id'] = $this->language->get('column_try_id');
		$this->data['column_product_id'] = $this->language->get('column_product_id');
		$this->data['column_store_id'] = $this->language->get('column_store_id');
		$this->data['column_try_time'] = $this->language->get('column_try_time');
		$this->data['column_starttime'] = $this->language->get('column_starttime');
		$this->data['column_is_try'] = $this->language->get('column_is_try');
		$this->data['column_attribute'] = $this->language->get('column_attribute');
		$this->data['column_endtime'] = $this->language->get('column_endtime');
		$this->data['column_action'] = $this->language->get('column_action');
		$this->data['column_product_name']=$this->language->get('column_product_name');
		$this->data['column_no_try']=$this->language->get('column_no_try');
		$this->data['column_try']=$this->language->get('column_try');

		$this->data['button_delete'] = $this->language->get('button_delete');
		$this->data['button_refresh'] = $this->language->get('button_refresh');
 
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			 unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		} 
		
		
		$pagination = new Pagination('results','links');
		$pagination->total = $total;
		$pagination->page = $page;
		$pagination->limit = $offset;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('account/mytry','page={page}'.$url, 'SSL');
		
		$this->data['pagination'] = $pagination->render();
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/mytry.html')) {
			$this->template = $this->config->get('config_template') . '/template/account/mytry.html';
		} else {
			$this->template = 'default/template/account/mytry.html';
		}
		
		$this->children = array(
			'account/left',
			'account/footer',
			'account/header'	
		);
				
		$this->response->setOutput($this->render());
	}
	
	


}
	
?>