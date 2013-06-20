<?php 
class ControllerAccountOrder extends Controller {
	private $error = array();
		
		
	public function index() {
    	if (!$this->customer->isLogged()) {
      		$this->session->data['redirect'] = $this->url->link('account/order', '', 'SSL');

	  		$this->redirect($this->url->link('account/login', '', 'SSL'));
    	}
		
		$this->language->load('account/order');
		
		
		$this->load->model('account/order');
		$this->load->model('catalog/product');
		$this->load->model('tool/image');
		
		//返单
		if (isset($this->request->get['order_id'])) {
			$order_info = $this->model_account_order->getOrder($this->request->get['order_id']);
			
			if ($order_info) {
				$order_products = $this->model_account_order->getOrderProducts($this->request->get['order_id']);
						
				foreach ($order_products as $order_product) {
					$option_data = array();
							
					$order_options = $this->model_account_order->getOrderOptions($this->request->get['order_id'], $order_product['order_product_id']);
							
					foreach ($order_options as $order_option) {
						if ($order_option['type'] == 'select' || $order_option['type'] == 'radio') {
							$option_data[$order_option['product_option_id']] = $order_option['product_option_value_id'];
						} elseif ($order_option['type'] == 'checkbox') {
							$option_data[$order_option['product_option_id']][] = $order_option['product_option_value_id'];
						} elseif ($order_option['type'] == 'text' || $order_option['type'] == 'textarea' || $order_option['type'] == 'date' || $order_option['type'] == 'datetime' || $order_option['type'] == 'time') {
							$option_data[$order_option['product_option_id']] = $order_option['value'];	
						} elseif ($order_option['type'] == 'file') {
							$option_data[$order_option['product_option_id']] = $this->encryption->encrypt($order_option['value']);
						}
					}
							
					$this->session->data['success'] = sprintf($this->language->get('text_success'), $this->request->get['order_id']);
							
					$this->cart->add($order_product['product_id'], $order_product['quantity'], $option_data);
				}
									
				$this->redirect($this->url->link('checkout/cart'));
			}
		}
		
		

    	$this->document->setTitle($this->language->get('heading_title'));

      	
		
		$url = '';
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
	
		$this->data['orderquery']=$this->url->link('account/order', $url, 'SSL');

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_order_id'] = $this->language->get('text_order_id');
		$this->data['text_status'] = $this->language->get('text_status');
		$this->data['text_date_added'] = $this->language->get('text_date_added');
		$this->data['text_customer'] = $this->language->get('text_customer');
		$this->data['text_products'] = $this->language->get('text_products');
		$this->data['text_total'] = $this->language->get('text_total');
		$this->data['text_empty'] = $this->language->get('text_empty');

		$this->data['button_view'] = $this->language->get('button_view');
		$this->data['button_reorder'] = $this->language->get('button_reorder');
		$this->data['button_continue'] = $this->language->get('button_continue');
		
		/* $orderStatusArr=array(
		                      2=>'卖家已发货',
							  3=> '卖家正在发货',
							  4=>'卖家发货完成',
							  5=>'交易成功'); */
							  
		$this->data['orders'] = array();
		if(!empty($this->request->post['orderno']) && is_numeric($this->request->post['orderno'])){ //按订单号查询
		    $result = $this->model_account_order->getOrder($this->request->post['orderno']);
			if(!empty($result)){
				$product_total = $this->model_account_order->getTotalOrderProductsByOrderId($result['order_id']);
				$voucher_total = $this->model_account_order->getTotalOrderVouchersByOrderId($result['order_id']);
				$this->data['orders'][] = array(
					'order_id'   => $result['order_id'],
					'store_id'   => $result['store_id'],
					'store_name' => $result['store_name'],
					'shipping'=> $this->model_account_order->getOrderTotals($result['order_id'],'shipping'),
					'products'   => $this->model_account_order->getOrderProducts($result['order_id']),
					'name'       => $result['username'],
					'status'     => $this->model_account_order->getOrderStatus($result['order_status_id']),
					'date_added' => date('Y-m-d H:i:s', $result['date_added']),
					'payment_method' =>$result['payment_method'],
					'products_total'   => ($product_total + $voucher_total),
					'total'      => number_format($result['total'],2,'.',','),
					'href'       => $this->url->link('account/order/info', 'order_id=' . $result['order_id'], 'SSL'),
					'reorder'    => $this->url->link('account/order', 'order_id=' . $result['order_id'], 'SSL')
				);
			}
			$this->data['pagination'] ='';
		}else{
		    
			if (isset($this->request->get['page'])) {
				$page = $this->request->get['page'];
			} else {
				$page = 1;
			}
			
			if (!empty($this->request->get['statusid'])) {
				$statusid = $this->request->get['statusid'];
			} else {
				$statusid = '';
			}
			
			
			$data=array();
			$limit=10;
			$data=array( 
			            'start'=>($page-1)*$limit,
						'limit'=>$limit,
						'statusid'=>$statusid);
			
			$order_total = $this->model_account_order->getTotalOrders($data);
			
			$results=array();
			
			$results = $this->model_account_order->getOrders($data);
			
			$products=array();
			foreach ($results as $result) {
				$product_total = $this->model_account_order->getTotalOrderProductsByOrderId($result['order_id']);
				$voucher_total = $this->model_account_order->getTotalOrderVouchersByOrderId($result['order_id']);
				
				$ops=$this->model_account_order->getOrderProducts($result['order_id']);
				
				foreach($ops as $k=>$v){
				    $p=$this->model_catalog_product->getProduct($v['product_id']);
					if ($p['image']) {
						$v['image'] = $this->model_tool_image->resize($p['image'], 50, 50);                    
					} else {
						$v['image'] = false;
					}       
					
					
					if(!empty($v['attribute'])){
					    $sql="select attribute_id,name from ".DB_PREFIX."attribute_description where attribute_id in ({$v['attribute']})";
						$v['attribute']=null;//$v['attribute']是属性ID，置空值，用来以下存储属性名
					    $query_=$this->db->query($sql);
						$attribute_data=$query_->rows;
						
						foreach($attribute_data as $ga){
							$v['attribute'] .= $ga['name'];
						}
						
					}
		
					$products[]=$v;
					
				}
				
				
				
				$this->data['orders'][] = array(
					'order_id'   => $result['order_id'],
					'store_id'   => $result['store_id'],
					'store_name' => $result['store_name'],
					'products'   => $products,
					'shipping'=> $this->model_account_order->getOrderTotals($result['order_id'],'shipping'),
					'name'       => $result['username'],
					'order_status_id' => $result['order_status_id'],
					//'status'      =>$orderStatusArr[$result['order_status_id']],
					'status'     => $this->model_account_order->getOrderStatus($result['order_status_id']),
					'date_added' => date('Y-m-d H:i:s', $result['date_added']),
					'payment_method' =>$result['payment_method'],
					'products_total'   => ($product_total + $voucher_total),
					'total'      => number_format($result['total'],2,'.',','),
					'href'       => $this->url->link('account/order/info', 'order_id=' . $result['order_id'], 'SSL'),
					'reorder'    => $this->url->link('account/order', 'order_id=' . $result['order_id'], 'SSL')
				);
			}
              // var_dump($this->data['orders']);
			
			$pagination = new Pagination('results','links');
			$pagination->total = $order_total;
			$pagination->page = $page;
			$pagination->limit = 10;
			$pagination->text = $this->language->get('text_pagination');
			$pagination->url = $this->url->link('account/order', 'page={page}', 'SSL');
			
			$this->data['pagination'] = $pagination->render();
        }
		
		$this->data['orderstatus']=array();
		$this->data['orderstatus']=$this->model_account_order->getOrderStatus();
		$this->data['statusid']=isset($statusid)?$statusid:'';
		
		$this->data['back'] = $this->url->link('account/account', '', 'SSL');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/order_list.html')) {
			$this->template = $this->config->get('config_template') . '/template/account/order_list.html';
		} else {
			$this->template = 'default/template/account/order_list.html';
		}
		
		$this->children = array(
			'account/footer',
			'account/left',
			'account/header'	
		);
						
		$this->response->setOutput($this->render());				
	}
	
	
	/**
	*  查看订单信息
	*/
	public function info() { 
		$this->language->load('account/order');
		
		if (isset($this->request->get['order_id'])) {
			$order_id = $this->request->get['order_id'];
			$this->data['order_id']= $this->request->get['order_id'];
		} else {
			$order_id = 0;
		}	

		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/order/info', 'order_id=' . $order_id, 'SSL');
			
			$this->redirect($this->url->link('account/login', '', 'SSL'));
    	}
						
		$this->load->model('account/order');
			
		$order_info = $this->model_account_order->getOrder($order_id);
		
		if ($order_info) {
			$this->document->setTitle($this->language->get('text_order'));
			
			
			$url = '';
			
			
      		$this->data['heading_title'] = $this->language->get('text_order');
			
			$this->data['text_order_detail'] = $this->language->get('text_order_detail');
			$this->data['text_invoice_no'] = $this->language->get('text_invoice_no');
    		$this->data['text_order_id'] = $this->language->get('text_order_id');
			$this->data['text_date_added'] = $this->language->get('text_date_added');
      		$this->data['text_shipping_method'] = $this->language->get('text_shipping_method');
			$this->data['text_shipping_address'] = $this->language->get('text_shipping_address');
      		$this->data['text_payment_method'] = $this->language->get('text_payment_method');
      		$this->data['text_payment_address'] = $this->language->get('text_payment_address');
      		$this->data['text_history'] = $this->language->get('text_history');
			$this->data['text_comment'] = $this->language->get('text_comment');

      		$this->data['column_name'] = $this->language->get('column_name');
      		$this->data['column_model'] = $this->language->get('column_model');
      		$this->data['column_quantity'] = $this->language->get('column_quantity');
      		$this->data['column_price'] = $this->language->get('column_price');
      		$this->data['column_total'] = $this->language->get('column_total');
			$this->data['column_action'] = $this->language->get('column_action');
			$this->data['column_date_added'] = $this->language->get('column_date_added');
      		$this->data['column_status'] = $this->language->get('column_status');
      		$this->data['column_comment'] = $this->language->get('column_comment');
			
			$this->data['button_return'] = $this->language->get('button_return');
      		$this->data['button_continue'] = $this->language->get('button_continue');
		
			/* if ($order_info['invoice_no']) {
				$this->data['invoice_no'] = $order_info['invoice_prefix'] . $order_info['invoice_no'];
			} else {
				$this->data['invoice_no'] = '';
			} */
			
			$this->data['order_id'] = $this->request->get['order_id'];
			$this->data['date_added'] = date('Y-m-d H:i:s', $order_info['date_added']);
			//$this->data['orderid'] = $order_info['orderid'];
			
		   /* if (isset($order_info['payment_address_format'])) {
      			$format = $order_info['payment_address_format'];
    		} else {
				$format = '{username}' . "\n" . '{company}' . "\n" . '{address}'  . "\n" . '{city} {postcode}';
			}
		
    		$find = array(
	  			'{username}',
	  			'{company}',
      			'{address}',
				'{postcode}'

			);
	
			$replace = array(
	  			'username' => $order_info['payment_username'],
	  			'company'   => $order_info['payment_company'],
      			'address' => $order_info['payment_address'],
				'postcode'  => $order_info['payment_postcode']

			);
			
			$this->data['payment_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

      		$this->data['payment_method'] = $order_info['payment_method']; */
			
			if (isset($order_info['shipping_address_format'])) {
      			$format = $order_info['shipping_address_format'];
    		} else {
				$format = '{username}' . "\n" . '{mobile}'  . "\n" . '{address}' . "\n" . '{postcode}' ;
			}
		
    		$find = array(
	  			'{username}',
	  			'{mobile}',
      			'{address}',
				'{postcode}'
			);
	
			$replace = array(
	  			'username' => $order_info['shipping_username'],
	  			'mobile'   => $order_info['shipping_mobile'],
				'address'  => $order_info['shipping_address'],
      			'postcode' => $order_info['shipping_postcode']

			);
            
			$this->data['shipping_username']=$order_info['shipping_username'];
			$this->data['shipping_telphone']=$order_info['telphone'];
			$this->data['shipping_mobile']=$order_info['mobile'];
			$this->data['shipping_postcode']=$order_info['shipping_postcode'];
			$this->data['order_status']=$this->model_account_order->getOrderStatus($order_info['order_status_id']);
			$this->data['date_added']=date('Y-m-d H:i:s',$order_info['date_added']);
			// $this->data['invoice_no']=$order_info['invoice_no'];
			$this->data['shpping_method']=$order_info['shipping_method'];
			$this->data['shipping_comment']=$order_info['comment'];
			
			$this->data['shipping_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

			$this->data['shipping_method'] = $order_info['shipping_method'];
			
			$this->data['order_products'] = array();
			
			$order_products = $this->model_account_order->getOrderProducts($this->request->get['order_id']);

      		foreach ($order_products as $product) {
				$option_data = array();
				
				/*
				$options = $this->model_account_order->getOrderOptions($this->request->get['order_id'], $product['order_product_id']);

         		foreach ($options as $option) {
          			if ($option['type'] != 'file') {
						$value = $option['value'];
					} else {
						$value = utf8_substr($option['value'], 0, utf8_strrpos($option['value'], '.'));
					}
					
					$option_data[] = array(
						'name'  => $option['type'],
						'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
					);					
        		} */
				if(!empty($product['attribute'])){
					$sql="select attribute_id,name from ".DB_PREFIX."attribute_description where attribute_id in ({$product['attribute']})";
					$product['attribute']=null;//$v['attribute']是属性ID，置空值，用来以下存储属性名
					$query_=$this->db->query($sql);
					$attribute_data=$query_->rows;
					
					foreach($attribute_data as $ga){
						$product['attribute'] .= $ga['name'];
					}
					
				}
				

        		$this->data['order_products'][] = array(
				    'product_id'=>$product['product_id'],
          			'name'     => $product['name'],
          			'model'    => $product['model'],
					'href'     =>'index.php?route=product/product&product_id='.$product['product_id'],
          			'attribute'   => $product['attribute'],
          			'quantity' => $product['quantity'],
          			'price'    => number_format($product['price'] ,2,'.',','),
					'total'    => number_format($product['total'] ,2,'.',','),
					'return'   => $this->url->link('account/return/insert', 'order_id=' . $order_info['order_id'] . '&product_id=' . $product['product_id'], 'SSL')
        		);
      		}

			// Voucher
			$this->data['vouchers'] = array();
			
			$vouchers = $this->model_account_order->getOrderVouchers($this->request->get['order_id']);
			
			foreach ($vouchers as $voucher) {
				$this->data['vouchers'][] = array(
					'description' => $voucher['description'],
					'amount'      => number_format($voucher['amount'],2,'.',',')
				);
			}
			
      		$this->data['totals'] = $this->model_account_order->getOrderTotals($this->request->get['order_id']);
			
			
			
			$this->data['comment'] = nl2br($order_info['comment']);
			
			$this->data['histories'] = array();

			$results = $this->model_account_order->getOrderHistories($this->request->get['order_id']);

      		foreach ($results as $result) {
        		$this->data['histories'][] = array(
          			'date_added' => date('Y-m-d H:i:s', $result['date_added']),
          			'status'     => $result['status'],
          			'comment'    => nl2br($result['comment'])
        		);
      		}

      		$this->data['continue'] = $this->url->link('account/order', '', 'SSL');
		
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/order_info.html')) {
				$this->template = $this->config->get('config_template') . '/template/account/order_info.html';
			} else {
				$this->template = 'default/template/account/order_info.html';
			}
			
			$this->children = array(
				'account/left',
				'account/footer',
				'account/header'	
			);
								
			$this->response->setOutput($this->render());		
    	} else {
			$this->document->setTitle($this->language->get('text_order'));
			
      		$this->data['heading_title'] = $this->language->get('text_order');

      		$this->data['text_error'] = $this->language->get('text_error');

      		$this->data['button_continue'] = $this->language->get('button_continue');
			
			
												
      		$this->data['continue'] = $this->url->link('account/order', '', 'SSL');
			 			
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.html')) {
				$this->template = $this->config->get('config_template') . '/template/error/not_found.html';
			} else {
				$this->template = 'default/template/error/not_found.html';
			}
			
			$this->children = array(
				'common/footer',
				'common/header'	
			);
								
			$this->response->setOutput($this->render());				
    	}
  	}
	
	//订单付款
	public function pay(){
	    $this->load->model('account/order');
		if (!empty($this->request->post['order_id'])) {
			$order_info = $this->model_account_order->getOrder($this->request->post['orderid']);
			
			if ($order_info) {
				$order_products = $this->model_account_order->getOrderProducts($this->request->post['order_id']);
						
				foreach ($order_products as $order_product) {
					$option_data = array();
							
					$order_options = $this->model_account_order->getOrderOptions($this->request->post['order_id'], $order_product['order_product_id']);
							
					foreach ($order_options as $order_option) {
						if ($order_option['type'] == 'select' || $order_option['type'] == 'radio') {
							$option_data[$order_option['product_option_id']] = $order_option['product_option_value_id'];
						} elseif ($order_option['type'] == 'checkbox') {
							$option_data[$order_option['product_option_id']][] = $order_option['product_option_value_id'];
						} elseif ($order_option['type'] == 'text' || $order_option['type'] == 'textarea' || $order_option['type'] == 'date' || $order_option['type'] == 'datetime' || $order_option['type'] == 'time') {
							$option_data[$order_option['product_option_id']] = $order_option['value'];	
						} elseif ($order_option['type'] == 'file') {
							$option_data[$order_option['product_option_id']] = $this->encryption->encrypt($order_option['value']);
						}
					}
							
					
					//$this->cart->add($order_product['product_id'], $order_product['quantity'], $option_data);
				}
				$json['WIDseller_email']='124@132.com';
				$json['WIDout_trade_no']='';
				$json['WIDsubject']='';
				$json['WIDtotal_fee']='';
				$json['WIDbody']='';
				$json['WIDshow_url']='';
				$json['WIDexter_invoke_ip']='';
			
				$this->response->setOutput(json_encode($json));
			}
		}
		
	}
	
	
	/**
	* 确认收货
	*/
	public function Accept() {
	
		$order_id=isset($this->request->post['id'])?intval($this->request->post['id']):0;
		if($order_id==0 || !is_numeric($order_id)) $this->showMessage("对不起，订单不存在！");

		$this->load->model('merchants/order');
		$result=$this->model_merchants_order->setOrderState($order_id,5,4);
		if($result!="ok"){
			exit("对不起,操作失败！");
		}
		exit("ok");
	}
	
	/**取消订单**/
	public function cancel(){
	    $order_id=$this->db->escape($this->request->post['order_id']);
	    if(empty($order_id)) exit;
		
		$sql="update `".DB_PREFIX."order`  set order_status_id=6 where order_id='{$order_id}'";
		$this->db->query($sql);
	
	}
	
	/**
	* 删除订单确认 是否有关联的退货订单
	*/
	public function ConfirmDel(){
	    $order_id=$this->db->escape($this->request->post['order_id']);
	    if(empty($order_id)) exit;
	    $sql="select count(return_id) as total from `".DB_PREFIX."return` where order_id='{$order_id}'";
		
		$query=$this->db->query($sql);
		
		if($query->num_rows>0){
		    return true;
		}else{
		    return false;
		}
		
	}
	
	/**
	* 删除订单
	*/
	public function delete(){
	    if ($this->confirmDel) exit('no');
	
	    $order_id=$this->db->escape($this->request->post['order_id']);
	    if(empty($order_id)) exit;
		
		$sql="delete from `".DB_PREFIX."order` where order_id='{$order_id}'";
		$this->db->query($sql);
		
		$sql="delete from `".DB_PREFIX."order_total` where order_id='{$order_id}'";
		$this->db->query($sql);
		
		$sql="delete from `".DB_PREFIX."order_voucher` where order_id='{$order_id}'";
		$this->db->query($sql);
		
		$sql="delete from `".DB_PREFIX."order_product` where order_id='{$order_id}'";
		$this->db->query($sql);
		
		$sql="delete from `".DB_PREFIX."order_history` where order_id='{$order_id}'";
		$this->db->query($sql);
		
		$sql="delete from `".DB_PREFIX."order_fraud` where order_id='{$order_id}'";
		$this->db->query($sql);
		exit('yes');
	
	}
	
}
?>