<?php 
/**店铺支付平台的列表**/
class ModelSettingPayment extends Model {
    public function getStorePayments($data=array()){
	    $results=array();
		
		$sql="SELECT s.name,s2p.* FROM ".DB_PREFIX. "store_to_payment  s2p  inner join ".DB_PREFIX."store s  on s2p.store_id=s.store_id inner join ".DB_PREFIX."extension e on s2p.payment_code=e.code ";
		
		if(!empty($data['status'])){
		    $sql.=" where  s2p.status='".$data['status']."'";
		}
		
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}					

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	
		
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}	
		
		$query = $this->db->query($sql);

		$results = $query->rows;
	
		
	 
		return $results;
	
	}
	
	public function getTotalStorePayments($data){
	    $sql="SELECT count(s2p.id) as total FROM ".DB_PREFIX. "store_to_payment  s2p  inner join ".DB_PREFIX."store s  on s2p.store_id=s.store_id inner join ".DB_PREFIX."extension e on s2p.payment_code=e.code ";
		
		if(!empty($data['status'])){
		    $sql.=" where  s2p.status='".$data['status']."'";
		}
		
		$query = $this->db->query($sql);
		
		return $query->row['total'];

	}
	
	
	public function getStorePayment($id){
	    $result=array();
		
		$sql="SELECT s.name,s2p.* FROM ".DB_PREFIX. "store_to_payment  s2p  inner join ".DB_PREFIX."store s  on s2p.store_id=s.store_id inner join ".DB_PREFIX."extension e on s2p.payment_code=e.code where s2p.id='{$id}' ";
		
		$query=$this->db->query($sql);
		
		$result=$query->row;
		
		return $result;
	
	}
	
	
	public function addStorePayment($data) {
        $store_id=$this->db->escape($data['store']);
		$payment_code=$this->db->escape($data['payment_code']);
		$trade_type=$this->db->escape(isset($data['alipay_trade_type'])?$data['alipay_trade_type']:'');
		$partner=$this->db->escape(isset($data['alipay_partner'])?$data['alipay_partner']:'');
		$security_code=$this->db->escape(isset($data['alipay_security_code'])?$data['alipay_security_code']:'');
		$seller_email=$this->db->escape(isset($data['alipay_seller_email'])?$data['alipay_seller_email']:'');
		$order_status_id=$this->db->escape(isset($data['alipay_order_status_id'])?$data['alipay_order_status_id']:'');
		$status=$this->db->escape($data['alipay_status']);
		$sort_order=$this->db->escape($data['alipay_sort_order']);
		$description=$this->db->escape(isset($data['description'])?$data['description']:'');
		$sql="insert into ".DB_PREFIX."store_to_payment set store_id='{$store_id}',payment_code='{$payment_code}',trade_type='{$trade_type}',partner='{$partner}',security_code='{$security_code}',seller_email='{$seller_email}',description='{$description}',order_status_id='{$order_status_id}',sort_order='{$sort_order}',status='{$status}'";
		$this->db->query($sql);
	}
	
	public function editStorePayment($id,$data) {
		$store_id=$this->db->escape($data['store']);
		$payment_code=$this->db->escape($data['payment_code']);
		$trade_type=$this->db->escape(isset($data['alipay_trade_type'])?$data['alipay_trade_type']:'');
		$partner=$this->db->escape(isset($data['alipay_partner'])?$data['alipay_partner']:'');
		$security_code=$this->db->escape(isset($data['alipay_security_code'])?$data['alipay_security_code']:'');
		$seller_email=$this->db->escape(isset($data['alipay_seller_email'])?$data['alipay_seller_email']:'');
		$order_status_id=$this->db->escape(isset($data['alipay_order_status_id'])?$data['alipay_order_status_id']:'');
		$status=$this->db->escape($data['alipay_status']);
		$sort_order=$this->db->escape($data['alipay_sort_order']);
		$description=$this->db->escape(isset($data['description'])?$data['description']:'');
		$sql="update ".DB_PREFIX."store_to_payment set store_id='{$store_id}',payment_code='{$payment_code}',trade_type='{$trade_type}',partner='{$partner}',security_code='{$security_code}',seller_email='{$seller_email}',description='{$description}',order_status_id='{$order_status_id}',sort_order='{$sort_order}',status='{$status}' where id='{$id}'";
		$this->db->query($sql);
	}
	
	public function deleteStorePayment($id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "store_to_payment where id='{$id}'");
	}
}
?>