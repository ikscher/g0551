<?php 
/*获取店铺的有效支付方式*/
class ModelPaymentPaymentMethod extends Model {
  	public function getMethod($store_id) {
	    $results=array();
		$sql="select e.code,e.name as title,s2p.sort_order from ".DB_PREFIX."store_to_payment s2p inner join ".DB_PREFIX."extension e on s2p.payment_code=e.code where s2p.status=1 and s2p.store_id='{$store_id}'";
		$query=$this->db->query($sql);
		
		$results=$query->rows;
		
		return $results;
		
  	}
}
?>