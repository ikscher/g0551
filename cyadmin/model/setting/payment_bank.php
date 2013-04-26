<?php 

class ModelSettingPaymentBank extends Model {
    public function getPaymentBanks(){
	    $results=array();
		$payment_bank=array();
		
	    $sql="select code from ".DB_PREFIX."extension where type='payment'";
		
		$query=$this->db->query($sql);
		
		$results=$query->rows;
		
		foreach($results as $v){
		    
			if($v['code']=='tenpay') $payment_bank['tenpay']='财付通';
		    if($v['code']=='post') $payment_bank['post']='邮局汇款';
			if($v['code']=='cod') $payment_bank['cod']='货到付款';
			if($v['code']=='alipay') $payment_bank['alipay']='支付宝';
		}
		
		/* $payment_bank=array('alipay'=>'支付宝',
							 'tenpay'=>'财付通',
							 'post'=>'邮局汇款',
							 'bank'=>'银行汇款',
							 'cod' =>'货到付款'); */
							 
		return $payment_bank;
	}
}
?>