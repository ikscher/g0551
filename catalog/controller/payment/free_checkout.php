<?php
class ControllerPaymentFreeCheckout extends Controller {
	protected function index() {
    	$this->data['button_confirm'] = $this->language->get('button_confirm');

		$this->data['continue'] = $this->url->link('checkout/success');//成功返回界面

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/free_checkout.html')) {
            $this->template = $this->config->get('config_template') . '/template/payment/free_checkout.html';
		} else {
            $this->template = 'default/template/payment/free_checkout.html';
        }
		
		$this->render();		 
	}
	
	public function confirm() { //免费 发送，不需要通过银行 支付接口的 ，直接修改订单状态后 返回
		$this->load->model('checkout/order');
		
		$this->model_checkout_order->confirm($this->session->data['order_id'], $this->config->get('free_checkout_order_status_id'));
	}
}
?>