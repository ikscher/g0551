<?php
/*
 支付宝双接口，担保接口
*/

require_once("alipay_function.php");
require_once("alipay_notify.php");
require_once("alipay_service.php");
class ControllerPaymentAlipay extends Controller {
	public function index() {

		$this->load->model('checkout/order');
       
		$order_id = isset($this->session->data['order_id'])?$this->session->data['order_id']:'';
   
		if(!empty($order_id)){
			$store_payment_info = $this->model_checkout_order->getStoreInfoByOrderid($order_id);
		
			$seller_email   = $store_payment_info['seller_email'];
			$security_code  = $store_payment_info['security_code'];
			$trade_type     = $store_payment_info['trade_type'];
			$partner        = $store_payment_info['partner'];
			$owner          = $store_payment_info['owner'];
			$order_status_id= $store_payment_info['order_status_id'];
			$total = number_format($store_payment_info['total'],2,'.','');
			
            $this->session->data['trade_type']=$trade_type;
			$this->session->data['security_code']=$security_code;
			$this->session->data['partner']=$partner;
			$this->session->data['seller_email']=$seller_email;
			$this->session->data['order_status_id']=$order_status_id;

			$_input_charset = "utf-8";
			$sign_type      = "MD5";
			$transport      = "http";
			$notify_url     = HTTP_SERVER . 'index.php?route=payment/alipay/callback';
			$return_url		=HTTP_SERVER . 'index.php?route=checkout/success';
			$show_url       = "";
            
			$this->load->model('account/customer');
			$customer_id=$this->customer->getId();
			$customer_info=$this->model_account_customer->getCustomer($customer_id);
			$receive_name=$customer_info['username'];
			$receive_address=$customer_info['address'];
			$receive_zip=$customer_info['postcode'];
			$receive_mobile=$customer_info['mobile'];
			$receive_phone=$customer_info['telphone'];
		
			$parameter = array(
				"service"        => $trade_type,
				"partner"        => $partner,
				"return_url"     => $return_url,
				"notify_url"     => $notify_url,
				"_input_charset" => $_input_charset,
				"subject"        => $partner.' Order：' . $order_id ,
				"body"           => 'Owner： ' . $owner,
				"out_trade_no"   => $order_id,
				"price"          => $total,
				"payment_type"   => "1",
				"quantity"       => "1",
				"logistics_fee"      =>'0.00',
				"logistics_payment"  =>'BUYER_PAY',
				"logistics_type"     =>'EXPRESS',
				"receive_name"       =>$receive_name,
				"receive_address"    =>$receive_address,
				"receive_zip"        =>$receive_zip,
				"receive_phone"      =>$receive_phone,
				"receive_mobile" =>$receive_mobile,
				"show_url"       => $show_url,
				"seller_email"   => $seller_email
			);

			$alipay = new alipay_service($parameter,$security_code,$sign_type);
			$action=$alipay->build_url();

			//$this->data['payment_action'] = $action;
			//$this->id = 'payment';
        }
		//$action='https://mapi.alipay.com/gateway.do?_input_charset=utf-8&body=%E8%A1%A3%E6%9C%8D&logistics_fee=0.00&logistics_payment=BUYER_PAY&logistics_type=EXPRESS¬ify_url=http%3A%2F%2Fwww.xxx.com%2Fcreate_direct_pay_by_user-PHP-UTF-8%2Fnotify_url.php&out_trade_no=1304231437232596&partner=2088801239967847&payment_type=1&price=0.01&quantity=1&receive_address=%E5%AE%89%E5%BE%BD%E7%9C%81+%E5%90%88%E8%82%A5%E5%B8%82+%E7%91%B6%E6%B5%B7%E5%8C%BA+%E7%91%B6%E6%B5%B7%E5%8C%BA%E6%96%B0%E6%B5%B7%E5%A4%A7%E9%81%93%E4%B8%8E%E5%BD%93%E6%B6%82%E5%8C%97%E8%B7%AF%E4%BA%A4%E5%8F%89%E5%8F%A3&receive_mobile=18905655866&receive_name=%E5%94%90%E5%86%9B&receive_phone=0551-64374866&receive_zip=230011&return_url=http%3A%2F%2Fwww.xxx.com%2Fcreate_direct_pay_by_user-PHP-UTF-8%2Freturn_url.php&seller_email=newcross2012%40126.com&service=trade_create_by_buyer&subject=%E6%B5%8B%E8%AF%95%E8%AE%A2%E5%8D%95&sign=49e9455011180ed4958f2304b3937189&sign_type=MD5&';
		$this->response->setOutput(json_encode(array('action'=>$action)));
		/* if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/alipay.html')) {
			$this->template = $this->config->get('config_template') . '/template/payment/alipay.html';
		} else {
			$this->template = 'default/template/payment/alipay.html';
		}

		$this->render(); */
	}

	public function callback() {
		//trade_create_by_buyer 双接口 ,create_direct_pay_by_user 直接到帐，create_partner_trade_by_buyer 担保接口
		$trade_type = $this->session->data['trade_type'];

		log_result("Alipay :: exciting callback function.");
		$oder_success = FALSE;
		$this->load->library('encryption');

		$seller_email = $this->session->data['seller_email']; // 商家邮箱
		$partner = $this->session->data['partner']; //合作伙伴ID
		$security_code = $this->session->data['security_code']; //安全检验码

		$_input_charset = "utf-8";
		//$_input_charset = "GBK";
		$sign_type = "MD5";
		$transport = 'http';

		$alipay = new alipay_notify($partner,$security_code,$sign_type,$_input_charset,$transport);
		$verify_result = $alipay->notify_verify();

		// Order status for Opencart
		/* DEFINE('ORDER_CREATED',1);
		define('ORDER_WAITING',2);
		define('ORDER_DETACHING',3);
		DEFINE('ORDER_OVER',4);
		DEFINE('ORDER_SUCCESS',5);
		DEFINE('ORDER_CLOSE',6);
		DEFINE('ORDER_REFUND',7);
		DEFINE('ORDER_ERROR',9); */

		log_result("Alipay :: trade_type ".$trade_type." :: verify_result  = ".$verify_result);
		if($verify_result) {
			$order_id   = $this->request->post['out_trade_no'];   //$_POST['out_trade_no'];
			$trade_status=$this->request->post['trade_status'];
			$this->load->model('checkout/order');
			$order_info = $this->model_checkout_order->getOrder($order_id);
			log_result("Alipay order_id :: ".$order_id);

			if ($order_info) {
				$order_status_id = $order_info["order_status_id"];
				log_result("Alipay order_id :: ".$order_id." order_status_id = ".$order_status_id." , trade_status :: ".$trade_status);
				log_result("Alipay order_id :: Complete status = ".ORDER_OVER);
				// 确定订单没有重复支付
				if ($order_status_id != ORDER_OVER) {
					$amount = $order_info['total'];
					
					$total  =  $this->request->post['total_fee'];    //$_POST['total_fee'];
					// 确定支付和订单额度一致
					log_result("Alipay total :: ".$this->request->post['total_fee'].",amount :: ".$amount);
					if($total < $amount){
						log_result("Alipay order_id :: ".$order_id." total < amount, order_status_id = ".$order_status_id);
						$this->model_checkout_order->confirm($order_id, ORDER_CLOSE);
						echo "success";
					}else{
						// 根据接口类型动态使用支付方法
						if($trade_type=='trade_create_by_buyer'){
							$this->func_trade_create_by_buyer($order_id,$order_status_id,$order_status,$trade_status);
							echo "success";
						}else if($trade_type=='create_direct_pay_by_user'){
							$this->func_create_direct_pay_by_user($order_id,$order_status_id,$order_status,$trade_status);
							echo "success";
						}else if($trade_type=='create_partner_trade_by_buyer'){
							$this->func_create_partner_trade_by_buyer($order_id,$order_status_id,$order_status,$trade_status);
							echo "success";
						}
					 }
					}else {
						echo "fail";
					}
			}else{
				log_result("Alipay No Order Found.");
				echo "fail";
			}
		}
	}
		// 双接口
	private function func_trade_create_by_buyer($order_id,$order_status_id,$order_status,$trade_status){
			if($trade_status == 'WAIT_BUYER_PAY') {
				log_result("Alipay order_id :: ".$order_id." WAIT_BUYER_PAY, order_status_id = ".$order_status_id);
				if (ORDER_CREATED> $order_status_id){
					$this->model_checkout_order->confirm($order_id, ORDER_CREATED);
					log_result("Alipay order_id :: ".$order_id." Update Successfully.");
				}
			}
			else if($trade_status == 'WAIT_SELLER_SEND_GOODS') {
				log_result("Alipay order_id :: ".$order_id." trade_status == WAIT_SELLER_SEND_GOODS, update order_status_id from ".$order_status_id." to ".$this->session->data['order_status_id']);
				if($this->session->data['order_status_id']> $order_status_id){
					$this->model_checkout_order->confirm($order_id, $this->session->data['order_status_id']);
					log_result("Alipay order_id :: ".$order_id." Update Successfully.");
				}
			}
			else if($trade_status == 'WAIT_BUYER_CONFIRM_GOODS') {
				log_result("Alipay order_id :: ".$order_id." trade_status == WAIT_BUYER_CONFIRM_GOODS,update order_status_id from ".$order_status_id." to ".ORDER_SUCCESS);
				if ( ORDER_SUCCESS> $order_status_id){
					$this->model_checkout_order->confirm($order_id, ORDER_SUCCESS);
					log_result("Alipay order_id :: ".$order_id." Update Successfully.");
				}
			}
			else if($trade_status == 'TRADE_FINISHED' ||$trade_status == 'TRADE_SUCCESS') {
				log_result("Alipay order_id :: ".$order_id." trade_status == TRADE_FINISHED / TRADE_SUCCESS, update order_status_id from ".$order_status_id." to ".ORDER_SUCCESS);
				if (ORDER_SUCCESS > $order_status_id){
					$this->model_checkout_order->confirm($order_id,ORDER_SUCCESS);
					log_result("Alipay order_id :: ".$order_id." Update Successfully.");
				}
			}
	}
	// 直接到帐
	private function func_create_direct_pay_by_user($order_id,$order_status_id,$order_status,$trade_status){
			if($trade_status == 'TRADE_FINISHED' ||$trade_status == 'TRADE_SUCCESS') {
				log_result("Alipay order_id :: ".$order_id." trade_status ==TRADE_FINISHED / TRADE_SUCCESS,  update order_status_id from ".$order_status_id." to ".$this->session->data['order_status_id']);
				if($this->session->data['order_status_id']> $order_status_id){
					$this->model_checkout_order->confirm($order_id, $this->session->data['order_status_id']);
					log_result("Alipay order_id :: ".$order_id." update order_status_id to ".$this->session->data['order_status_id']);
				}
			}
	}
	// 双接口
	private function func_create_partner_trade_by_buyer($order_id,$order_status_id,$order_status,$trade_status){
			if($trade_status == 'WAIT_BUYER_PAY') {
				log_result("Alipay order_id :: ".$order_id."  trade_status ==  WAIT_BUYER_PAY,  update order_status_id from ".$order_status_id." to ".ORDER_CREATED);
				if (ORDER_CREATED> $order_status_id){
					$this->model_checkout_order->confirm($order_id, ORDER_CREATED);
					log_result("Alipay order_id :: ".$order_id." Update Successfully.");
				}
			}
			else if($trade_status == 'WAIT_SELLER_SEND_GOODS') {
				log_result("Alipay order_id :: ".$order_id." trade_status == WAIT_SELLER_SEND_GOODS, update order_status_id from ".$order_status_id." to ".$this->session->data['order_status_id']);
				if($this->session->data['order_status_id']){
					$this->model_checkout_order->confirm($order_id, $this->session->data['order_status_id']);
					log_result("Alipay order_id :: ".$order_id." Update Successfully.");
				}
			}
			else if($trade_status == 'WAIT_BUYER_CONFIRM_GOODS') {
				log_result("Alipay order_id :: ".$order_id." trade_status == WAIT_BUYER_CONFIRM_GOODS, update order_status_id from ".$order_status_id." to ".ORDER_SUCCESS);
				if ( ORDER_SUCCESS> $order_status_id){
					$this->model_checkout_order->confirm($order_id, ORDER_SUCCESS);
					log_result("Alipay order_id :: ".$order_id." Update Successfully.");
				}
			}
			else if($trade_status == 'TRADE_FINISHED' ) {
				log_result("Alipay order_id :: ".$order_id." trade_status == TRADE_FINISHED ,update order_status_id from ".$order_status_id." to ".ORDER_SUCCESS);
				if (ORDER_SUCCESS> $order_status_id){
					$this->model_checkout_order->confirm($order_id,ORDER_SUCCESS);
					log_result("Alipay order_id :: ".$order_id." Update Successfully.");
				}
			}
	}
}

?>