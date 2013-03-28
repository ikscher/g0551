<?php
class ModelTotalStoreSubTotal extends Model {
	public function getTotal(&$total_data, &$total,$flag=false) {
		$this->load->language('total/sub_total');
		
		$store_sub_total = $this->cart->getStoreSubTotal($flag);
		
		if (isset($this->session->data['vouchers']) && $this->session->data['vouchers']) {
			foreach ($this->session->data['vouchers'] as $voucher) {
				$store_sub_total += $voucher['amount'];
			}
		} 
		
		$total_data[] = array( 
			'code'       => 'sub_total',
			'title'      => $this->language->get('text_sub_total'),
			'text'       => number_format($store_sub_total,2,'.',','),
			'value'      => $store_sub_total,
			'sort_order' => $this->config->get('sub_total_sort_order')
		);
		
		$total += $store_sub_total;
	}
}
?>