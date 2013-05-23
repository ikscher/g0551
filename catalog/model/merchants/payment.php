<?php 
/**店铺支付平台的列表**/
class ModelMerchantsPayment extends Model {
    /**
	*返回可用的支付方式*
	*/
    public function getEnabledPayments(){
	    $payments=array();
		$results=array();
		
		//$store_id=$this->customer->getStoreId();
		$store_id=$this->cookie->OCAuthCode(isset($this->request->cookie['storeid'])?$this->request->cookie['storeid']:'','DECODE');
        
		if(empty($store_id)) return;
		
	    //$sql="select s2p.store_id,s2p.status,s2p.id,(select `code` from ".DB_PREFIX."extension e where e.`code`=s2p.payment_code) as `code`,(select `name` from ".DB_PREFIX."extension e where e.`code`=s2p.payment_code) as `name` from ".DB_PREFIX."store_to_payment s2p where  s2p.store_id={$store_id} and s2p.status=1";
		//$sql="SELECT s.name,s2p.* FROM ".DB_PREFIX. "store_to_payment  s2p  left join ".DB_PREFIX."store s  on s2p.store_id=s.store_id left join ".DB_PREFIX."extension e on s2p.payment_code=e.code";
		$sql="select e.*,s2p.status,s2p.store_id,s2p.id from ".DB_PREFIX."extension e left join  ".DB_PREFIX."store_to_payment s2p on e.code=s2p.payment_code  where e.type='payment' ";

		$query=$this->db->query($sql);
		$results=$query->rows;
		
		foreach($results as $v){
		    if($v['code']=='alipay') {
		        $v['code']='alipay';
				$v['name']='支付宝';
				$v['description']='支付宝网站(www.alipay.com) 是国内先进的网上支付平台，穿悦商城联合支付宝推出优惠套餐：无预付/年费，单笔费率1.5%，无流量限制。<a href="https://www.alipay.com/himalayas/product_info.htm?type=from_agent_contract&id=C4335319945672464113" target="_blank" style="color:red; font-weight:bold;">立即在线申请</a>';
			}
			
			if($v['code']=='tenpay'){
			    $v['code']='tenpay';
				$v['name']='财付通即时到账';
				$v['description']='财付通（www.tenpay.com） - 本即时到账接口无需预付费，任何订单金额均即时到达您的账户，只收单笔 1% 手续费。';
			}
			
			if($v['code']=='cod'){
			    $v['code']='cod';
				$v['name']='货到付款';
				$v['description']='开通城市: 请在配送方式里设置“可货到付款地区”开通，手续费:**';
			}
			
			if($v['code']=='bank'){
			    $v['code']='bank';
				$v['name']='银行汇款';
				$v['description']='银行';
			}
			
			if($v['code']=='post'){
			    $v['code']='post';
				$v['name']='邮政汇款';
				$v['description']='收款人信息: 姓名 ***; 地址:***; 邮编 ***';
			}
			
			/*  if($v['store_id']!=$store_id){
			    $v['store_id']='';
				$v['status']='';
			} */
			
			$payments[]=$v;
		}
		return $payments;
	
	}

    public function getStorePayments($data=array()){
	    $results=array();
		
		$store_id=$this->customer->getStoreId();
		$sql="SELECT s.name,s2p.* FROM ".DB_PREFIX. "store_to_payment  s2p  inner join ".DB_PREFIX."store s  on s2p.store_id=s.store_id inner join ".DB_PREFIX."extension e on s2p.payment_code=e.code where s2p.store_id='{$store_id}'";
		
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
	    $store_id=$this->customer->getStoreId();
		
	    $sql="SELECT count(s2p.id) as total FROM ".DB_PREFIX. "store_to_payment  s2p  inner join ".DB_PREFIX."store s  on s2p.store_id=s.store_id inner join ".DB_PREFIX."extension e on s2p.payment_code=e.code where s2p.store_id='{$store_id}'";
		
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
	
	public function deleteStorePayment($id) {
		return $this->db->query("DELETE FROM " . DB_PREFIX . "store_to_payment where id='{$id}'");
		    
	}
	
	
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
			if($v['code']=='bank') $payment_bank['bank']='银行汇款';
		}
		
	
		return $payment_bank;
	}
	
	
	public function getOrderStatuses($data = array()) {
      	if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "order_status where order_status_id<=7";
			
			$sql .= " ORDER BY name";	
			
			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
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
			
			return $query->rows;
		} else {
			$order_status_data = $this->cache->get('order_status');
		
			if (!$order_status_data) {
				$query = $this->db->query("SELECT order_status_id, name FROM " . DB_PREFIX . "order_status where order_status_id<=7 ORDER BY name");
	
				$order_status_data = $query->rows;
			
				$this->cache->set('order_status' , $order_status_data);
			}	
	
			return $order_status_data;				
		}
	}
	
}
?>