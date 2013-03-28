<?php 
class ControllerAccountWishList extends Controller {
	public function index() {
    	if (!$this->customer->isLogged()) {
	  		$this->session->data['redirect'] = $this->url->link('account/wishlist', '', 'SSL');
           
	  		$this->redirect($this->url->link('account/login', '', 'SSL')); 
			 $this->data['username']='';
    	} else{

            if(isset($this->request->cookie['oc_customer'])){
				$customer=$this->cookie->OCAuthCode($this->request->cookie['oc_customer'],'DECODE');
				$customer=unserialize($customer);
				$this->data['username']=$customer['email'];
			}else{
			    $this->redirect($this->url->link('account/login', '', 'SSL')); 
			    $this->data['username']='';
			
			}

        }		
	
		
		$this->load->model('catalog/product');
		
		$this->load->model('tool/image');
		
		if (!isset($this->session->data['wishlist'])) {
			$this->session->data['wishlist'] = array();
		}

		if (isset($this->request->get['remove'])) { //链接单个产品删除
		   
			while(list($key,$value)=each($this->session->data['wishlist'])){
			 
			   if(strpos($value,strval($this->request->get['remove']))!==false){
				   unset($this->session->data['wishlist'][$key]);
			   }
		
			   //$this->session->data['success'] = $this->language->get('text_remove');
			   
			}
			$this->redirect($this->url->link('account/wishlist'));
			
		}
	
	   
		if (!empty($this->request->post['pid']) && $this->request->server['REQUEST_METHOD'] == 'POST') { //删除
		    //var_dump($this->request->post['pid']);
		    //var_dump(array_map("ControllerAccountWishList::splitArr",$this->session->data['wishlist']));
			
			foreach($this->request->post['pid'] as $v){
			    $key = array_search($v, array_map("ControllerAccountWishList::splitArr",$this->session->data['wishlist']));
				if ($key !== false) {
					unset($this->session->data['wishlist'][$key]);
				} 
		    }
			//$this->session->data['success'] = $this->language->get('text_remove');
		    $this->request->post['pid']=array();
			//$this->redirect($this->url->link('account/wishlist'));
		}
						
		$this->document->setTitle($this->language->get('heading_title'));	
      	
						
		
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
			
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
							
		$this->data['products'] = array();
		
		if (isset($this->request->get['page'])) {
		    $page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		$offset=6;
		$total=count($this->session->data['wishlist']);
		
		$result=array_slice($this->session->data['wishlist'],($page-1)*$offset,$offset);
	    
		foreach ($result as $key => $data) {
		    $arr=explode("|",$data);
			$product_id=$arr[0];
			$time=$arr[1];
			
			$product_info = $this->model_catalog_product->getProduct($product_id);
			
			if ($product_info) { 
				if ($product_info['image']) {
					$image = $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_wishlist_width'), $this->config->get('config_image_wishlist_height'));
				} else {
					$image = false;
				}

				if ($product_info['quantity'] <= 0) {
					$stock = $product_info['stock_status'];
				} elseif ($this->config->get('config_stock_display')) {
					$stock = $product_info['quantity'];
				} else {
					$stock = $this->language->get('text_instock');
				}
							
				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = number_format($product_info['price'],2,'.',',');
				} else {
					$price = false;
				}
				
				if ((float)$product_info['special']) {
					$special = number_format($product_info['special']['price'], 2,'.',',');
				} else {
					$special = false;
				}
																			
				$this->data['products'][] = array(
					'product_id' => $product_info['product_id'],
					'thumb'      => $image,
					'name'       => $product_info['name'],
					'model'      => $product_info['model'],
					'viewed'     => $product_info['viewed'],
					'stock'      => $stock,
					'price'      => $price,	
                    'time'       => date('Y-m-d H:i:s',$time),					
					'special'    => $special,
					'href'       => $this->url->link('product/product', 'product_id=' . $product_info['product_id']),
					'remove'     => $this->url->link('account/wishlist', 'remove=' . $product_info['product_id'])
				);
			} else {
				//unset($this->session->data['wishlist'][$key]);
				unset($result);
			}
		}	
        
		
	
		
		$pagination = new Pagination('results','links');
		$pagination->total = $total;
		$pagination->page = $page;
		$pagination->limit = $offset;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('account/wishlist', 'page={page}', 'SSL');
		
		$this->data['pagination'] = $pagination->render();

		
		$this->data['wishlist'] = $this->url->link('account/wishlist', '', 'SSL');
		$this->data['home'] = $this->url->link('common/home', '', 'SSL');
		$this->data['logout'] = $this->url->link('common/logout', '', 'SSL');
		$this->data['back'] = $this->url->link('account/account','','SSL');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/wishlist.html')) {
			$this->template = $this->config->get('config_template') . '/template/account/wishlist.html';
		} else {
			$this->template = 'default/template/account/wishlist.html';
		}
		
		$this->children = array(
			'account/left',
			'account/footer',
			'account/header'	
		);
							
		$this->response->setOutput($this->render());		
	}
	
	public function add() {
	    $time=time();
		$this->language->load('account/wishlist');
		
		$json = array();

		if (!isset($this->session->data['wishlist'])) {
			$this->session->data['wishlist'] = array();
		}
				
		if (isset($this->request->post['product_id'])) {
			$product_id = $this->request->post['product_id'];
		} else {
			$product_id = 0;
			
		}
		
		$this->load->model('catalog/product');
		
		$product_info = $this->model_catalog_product->getProduct($product_id);
		
		if ($product_info) {
			/* if (!in_array($this->request->post['product_id'], $this->session->data['wishlist'])) {	
				$this->session->data['wishlist'][] = $this->request->post['product_id'].'|'.$time;
				
			} */
			
			$key = array_search($this->request->post['product_id'], array_map("ControllerAccountWishList::splitArr",$this->session->data['wishlist']));
			if ($key === false) {
				$this->session->data['wishlist'][] = $this->request->post['product_id'].'|'.$time;
			} 
		    
			 
			if ($this->customer->isLogged()) {			
				$json['success'] = sprintf($this->language->get('text_success'), $this->url->link('product/product', 'product_id=' . $this->request->post['product_id']), $product_info['name'], $this->url->link('account/wishlist'));				
			} else {
				$json['success'] = sprintf($this->language->get('text_login'), $this->url->link('account/login', '', 'SSL'), $this->url->link('account/register', '', 'SSL'), $this->url->link('product/product', 'product_id=' . $this->request->post['product_id']), $product_info['name'], $this->url->link('account/wishlist'));				
			}
			
			$json['total'] = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
		}	
		
		$this->response->setOutput(json_encode($json));
	}
    
	/**
	*  收藏列表的 形式：pid|time 组成的数组
	*  功能：过滤掉时间，只留下产品ID
	*/
    public static function splitArr($str){
	   $res='';
       if(!is_string($str)) return false;
	   
	   $x=explode("|",$str);
	   $res=$x[0];

	   return $res;
 
    }	
}
?>