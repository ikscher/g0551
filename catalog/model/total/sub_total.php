<?php
class ModelTotalSubTotal extends Model {
    /**
	* $flag ��־ ���� ֱ�ӹ����� ���ﳵ 
	& store ����ֵ�����ʽͳ�ƽ��
	*/
	public function getTotal(&$total_data, &$total,$flag=false,$store=false) {
	    $sort_order=$this->config->get('sub_total_sort_order');
	    if($store==false){ //���й��ﳵ�Ĳ�Ʒ��ͳ����һ��
			$this->load->language('total/sub_total');
			
			$sub_total = $this->cart->getSubTotal($flag);
			
			if (isset($this->session->data['vouchers']) && $this->session->data['vouchers']) {
				foreach ($this->session->data['vouchers'] as $voucher) {
					$sub_total += $voucher['amount'];
				}
			} 
			
			$total_data[] = array( 
				'code'       => 'sub_total',
				'title'      => $this->language->get('text_sub_total'),
				'text'       => number_format($sub_total,2,'.',','),
				'value'      => $sub_total,
				'sort_order' => isset($sort_order)?$sort_order:0
			);
			
			$total += $sub_total;
		}elseif ($store==true){ //�ֵ���ͳ�ƹ��ﳵ��Ʒ�Ľ��
		    $this->load->language('total/sub_total');
			
			$sub_total=array();
			
			$sub_total = $this->cart->getStoreSubTotal($flag);
	
			foreach($sub_total as $k=>$v){
				if (isset($this->session->data['vouchers']) && $this->session->data['vouchers']) {
					foreach ($this->session->data['vouchers'] as $voucher) {
						
						$v += $voucher['amount'];
					}
					
		            $sub_total[$k]=$v;
				} 
			}
			
			foreach($sub_total as $k=>$v){
				$total_data[$k][] = array( 
					'code'       => 'sub_total',
					'title'      => $this->language->get('text_sub_total'),
					'text'       => number_format($v,2,'.',','),
					'value'      => $v,
					'sort_order' => isset($sort_order)?$sort_order:0
				);
				
				if(!isset($total[$k])) $total[$k]=0;
				$total[$k] += $v;
				//$total[$k]=0.01; //test by user
			}
		    
		}
	}
}
?>