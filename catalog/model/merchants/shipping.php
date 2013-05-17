<?php 
/**配送方式管理**/
class ModelMerchantsShipping extends Model {

    public function getStoreShippings($data=array()){
	    $results=array();
	
		$sql="select * from ".DB_PREFIX."shipping where store_id={$data['store_id']}";
		
		if(!empty($data['status'])){
		    $sql.=" And  enabled='".$data['status']."'";
		}
		
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}					

			if ($data['limit'] < 1) {
				$data['limit'] = 5;
			}	
		
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}	
		
		$query = $this->db->query($sql);

		$results = $query->rows;
	
		
	 
		return $results;
	
	}
	
	public function getTotalStoreShippings($data){
	    
	    $sql="SELECT count(shipping_id) as total from ".DB_PREFIX."shipping where store_id={$data['store_id']}";
		
		if(!empty($data['status'])){
		    $sql.=" And  enabled='".$data['status']."'";
		}
		
		$query = $this->db->query($sql);
		
		return $query->row['total'];

	}
	
	
	public function getStoreShipping($shipping_id){
	    $result=array();
		
		$sql="SELECT * from ".DB_PREFIX."shipping where shipping_id='{$shipping_id}'";
		
		$query=$this->db->query($sql);
		
		$result=$query->row;
		
		return $result;
	
	}
	
	
	public function addStoreShipping($data) {
        $store_id=$this->cookie->OCAuthCode($this->request->cookie['storeid'],'DECODE');
		$payment_code=$this->db->escape($data['payment_code']);
		$trade_type=$this->db->escape(isset($data['trade_type'])?$data['trade_type']:'');
		$partner=$this->db->escape(isset($data['partner'])?$data['partner']:'');
		$security_code=$this->db->escape(isset($data['security_code'])?$data['security_code']:'');
		$seller_email=$this->db->escape(isset($data['seller_email'])?$data['seller_email']:'');
		$order_status_id=$this->db->escape($data['order_status_id']);
		$status=$this->db->escape($data['status']);
		$sort_order=$this->db->escape($data['sort_order']);
		$description=$this->db->escape(isset($data['description'])?$data['description']:'');
		$sql="insert into ".DB_PREFIX."store_to_payment set store_id='{$store_id}',payment_code='{$payment_code}',trade_type='{$trade_type}',partner='{$partner}',security_code='{$security_code}',seller_email='{$seller_email}',order_status_id='{$order_status_id}',sort_order='{$sort_order}',status='{$status}',description='{$description}'";
		return $this->db->query($sql);
	}
	
	public function editStorePayment($id,$data) {
		$trade_type=$this->db->escape(isset($data['trade_type'])?$data['trade_type']:'');
		$partner=$this->db->escape(isset($data['partner'])?$data['partner']:'');
		$security_code=$this->db->escape(isset($data['security_code'])?$data['security_code']:'');
		$seller_email=$this->db->escape(isset($data['seller_email'])?$data['seller_email']:'');
		$order_status_id=$this->db->escape(isset($data['order_status_id'])?$data['order_status_id']:'');
		$status=$this->db->escape($data['status']);
		$sort_order=$this->db->escape($data['sort_order']);
		$description=$this->db->escape(isset($data['description'])?$data['description']:'');
		$sql="update ".DB_PREFIX."store_to_payment set trade_type='{$trade_type}',partner='{$partner}',security_code='{$security_code}',seller_email='{$seller_email}',description='{$description}',order_status_id='{$order_status_id}',sort_order='{$sort_order}',status='{$status}' where id='{$id}'";
		return $this->db->query($sql);
	}
	

	

}
?>