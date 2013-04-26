<?php
    /**店铺列表**/
	class ControllerStoreList extends Controller {
        public function index(){
		    $this->load->model('store/list');
			$this->load->model('tool/image');
			if (isset($this->request->get['page'])) {
				$page = $this->request->get['page'];
			} else {
				$page = 1;
			}
			
			$filter_name=isset($this->request->get['filter_name'])?$this->request->get['filter_name']:'';
			
			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];
			} else {
				$limit = $this->config->get('config_store_limit');
			}
			
			$url='';

			$search='';
			if (isset($this->request->get['search'])){
			    $search=urldecode($this->request->get['search']);
				$url.="&search=".urlencode($search);
			}
            
			//排序
			$this->data['sort']='';
			if(isset($this->request->get['sort'])){
			    $this->data['sort']=$this->request->get['sort'];
			    $url.="&sort=".urlencode($this->request->get['sort']);
			}
			
			$this->data['order']='';
			if(isset($this->request->get['order']) && !empty($this->request->get['sort'])){
			    $this->data['order']=$this->request->get['order'];
				$url.="&order=".urlencode($this->request->get['order']);
			}elseif(!empty($this->request->get['sort'])){
			    $this->data['order']='desc';
				$url.="&order=desc";
			}
			
			$data=array(
			       'start'=>($page-1)*$limit,
				   'limit'=>$limit,
				   'filter_name'=>html_entity_decode($filter_name, ENT_QUOTES, 'UTF-8'),
				   'search'=>$search,
				   'sort'  =>isset($this->request->get['sort'])?$this->request->get['sort']:'',
				   'order' =>isset($this->request->get['order'])?$this->request->get['order']:''
				);
			
			$results=$this->model_store_list->getStoreList($data);
		    
			$this->data['list']=array();
			foreach($results as $k=>$v){
				if ($v['logo']) {
					$v['logo'] = $this->model_tool_image->resize($v['logo'], 70, 70);
				} else {
					$v['logo'] = $this->model_tool_image->resize('no_image.jpg', 70, 70);
			    }
				
				$productsTotal=$this->model_store_list->getStoreProductsTotal($v['store_id']);
				$orderPaidTotal=$this->model_store_list->getStoreOrderPaidTotals($v['store_id']);
				
				$this->data['list'][] = array(
								'store_id' => $v['store_id'],
								'introduce'=>utf8_substr(strip_tags(html_entity_decode($v['introduce'], ENT_QUOTES, 'UTF-8')), 0,20) . '...',
								'name' => $v['name'],
								'address' => $v['address'],
								'owner' =>$v['owner'],
								'productsTotal'=>$productsTotal['total'],
								'orderPaidTotal'=>$orderPaidTotal['total'],
								'logo' => $v['logo'],
								'href' => $this->url->link('store/store', '&store_id=' . $v['store_id']),
							);
			}
			$results=null;
			
			$total=$this->model_store_list->getStoreTotal($data);
		
              
			$pagination = new Pagination('result','link');
			$pagination->total = $total['total'];
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->text = $this->language->get('text_pagination');
			$pagination->url = $this->url->link('store/list', $url. "&page={page}");
		
		    
			
			$this->data['pagination'] = $pagination->render();
		    $this->data['search']=$search;
			$this->data['total']=$total['total'];
			
		    if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/store/list.html')) {
				$this->template = $this->config->get('config_template') . '/template/store/list.html';
			} else {
				$this->template = 'default/template/store/list.html';
			}
			
			
			$this->children = array(
				'common/footer',
				'common/header'
			);      
			$this->response->setOutput($this->render());
		
		}
	}
?>