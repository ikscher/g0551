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
	    //$total=0;
		//$shipping_fee_arr=array();
		
	    $sql="SELECT count(shipping_id) as total from ".DB_PREFIX."shipping where store_id={$data['store_id']}";
		
		if(!empty($data['status'])){
		    $sql.=" And  enabled='".$data['status']."'";
		}
		
		$query = $this->db->query($sql);
		
		return $query->row['total'];
		/* $results=$query->rows;

		foreach($results as $r){
		    $shipping_fee_arr=unserialize($r['shipping_fee']); 
			$total +=count($shipping_fee_arr);
		
		}
		
		return $total; */

	}
	
	
	public function getStoreShipping($shipping_id){
	    $result_=array();
		
		$sql="SELECT * from ".DB_PREFIX."shipping where shipping_id='{$shipping_id}'";
		
		$query=$this->db->query($sql);
		
		$result_=$query->row;
		$s__=unserialize($result_['shipping_fee']);
		//foreach($shipping_fee_arr as $s__){
		    $result_['express_start']=isset($s__['express']['express_start'])?$s__['express']['express_start']:'';
			$result_['ems_start']=isset($s__['ems']['ems_start'])?$s__['ems']['ems_start']:'';
			$result_['post_start']=isset($s__['post']['post_start'])?$s__['post']['post_start']:'';
				
			$result_['express_postage']=isset($s__['express']['express_postage'])?$s__['express']['express_postage']:'';
			$result_['ems_postage']=isset($s__['ems']['ems_postage'])?$s__['ems']['ems_postage']:'';
			$result_['post_postage']=isset($s__['post']['post_postage'])?$s__['post']['post_postage']:'';
			
			
			$result_['express_plus']=isset($s__['express']['express_plus'])?$s__['express']['express_plus']:'';
			$result_['ems_plus']=isset($s__['ems']['ems_plus'])?$s__['ems']['ems_plus']:'';
			$result_['post_plus']=isset($s__['post']['post_plus'])?$s__['post']['post_plus']:'';
			
			
			$result_['express_postageplus']=isset($s__['express']['express_postageplus'])?$s__['express']['express_postageplus']:'';
			$result_['ems_postageplus']=isset($s__['ems']['ems_postageplus'])?$s__['ems']['ems_postageplus']:'';
			$result_['post_postageplus']=isset($s__['post']['post_postageplus'])?$s__['post']['post_postageplus']:'';
			
		//}
		
		return $result_;
	
	}
	
	public function deleteShipping($shipping_id){
	    return $this->db->query("delete from ".DB_PREFIX."shipping where shipping_id={$shipping_id}");
	}
	
	
	public function addStoreShipping($data) {
        $store_id=$this->cookie->OCAuthCode($this->request->cookie['storeid'],'DECODE');
		$shipping_desc=$this->db->escape($data['t_x']);
		$province=$this->db->escape(isset($data['ya_prov'])?$data['ya_prov']:'');
		$city=$this->db->escape(isset($data['ya_city'])?$data['ya_city']:'');
		$zone=$this->db->escape(isset($data['ya_town'])?$data['ya_town']:'');
		$consignDate=$this->db->escape(isset($data['consignDate'])?$data['consignDate']:'');
		$bearFreight=$this->db->escape(isset($data['bearFreight'])?$data['bearFreight']:'');
		$calc_rule=$this->db->escape(isset($data['valuation'])?$data['valuation']:'');
		$delivery_type=$this->db->escape(isset($data['tplType'])?$data['tplType']:'');
		
		$shipping_fee_arr=array();
		$express_arr=array();
		$ems_arr=array();
		$post_arr=array();
		
		$express_start=$this->db->escape(isset($data['express_start'])?$data['express_start']:'');
		$express_postage=$this->db->escape(isset($data['express_postage'])?$data['express_postage']:'');
		$express_plus=$this->db->escape(isset($data['express_plus'])?$data['express_plus']:'');
		$express_postageplus=$this->db->escape(isset($data['express_postageplus'])?$data['express_postageplus']:'');
		$express_arr=array(
					 'express_start'      => $express_start,
					 'express_postage'    => $express_postage,
					 'express_plus'       => $express_plus,
					 'express_postageplus'=> $express_postageplus);
		
		$ems_start=$this->db->escape(isset($data['ems_start'])?$data['ems_start']:'');
		$ems_postage=$this->db->escape(isset($data['ems_postage'])?$data['ems_postage']:'');
		$ems_plus=$this->db->escape(isset($data['ems_plus'])?$data['ems_plus']:'');
		$ems_postageplus=$this->db->escape(isset($data['ems_postageplus'])?$data['ems_postageplus']:'');
		$ems_arr   = array(
		                 'ems_start'      => $ems_start,
						 'ems_postage'    => $ems_postage,
						 'ems_plus'       => $ems_plus,
						 'ems_postageplus'=> $ems_postageplus);
		
		$post_start=$this->db->escape(isset($data['post_start'])?$data['post_start']:'');
		$post_postage=$this->db->escape(isset($data['post_postage'])?$data['post_postage']:'');
		$post_plus=$this->db->escape(isset($data['post_plus'])?$data['post_plus']:'');
		$post_postageplus=$this->db->escape(isset($data['post_postageplus'])?$data['post_postageplus']:'');
		$post_arr   = array(
		                 'post_start'      => $post_start,
						 'post_postage'    => $post_postage,
						 'post_plus'       => $post_plus,
						 'post_postageplus'=> $post_postageplus);
						 
		if(!empty($express_start) && !empty($express_postage)) $shipping_fee_arr['express']= $express_arr;
		if(!empty($ems_start) && !empty($ems_postage)) $shipping_fee_arr['ems']    = $ems_arr;
		if(!empty($post_start) && !empty($post_postage)) $shipping_fee_arr['post']   = $post_arr;
						 
		$shipping_fee=serialize($shipping_fee_arr);
		
		//$description=$this->db->escape(isset($data['description'])?$data['description']:'');
		$sql="insert into ".DB_PREFIX."shipping set store_id='{$store_id}',delivery_type='{$delivery_type}',calc_rule='{$calc_rule}',shipping_desc='{$shipping_desc}',shipping_fee='{$shipping_fee}',province='{$province}',city='{$city}',zone='{$zone}',consignDate='{$consignDate}',is_freight='{$bearFreight}'";
		return $this->db->query($sql);
	}
	
	public function editStoreShipping($id,$data) {
		//$store_id=$this->cookie->OCAuthCode($this->request->cookie['storeid'],'DECODE');
		$shipping_desc=$this->db->escape($data['t_x']);
		$province=$this->db->escape(isset($data['ya_prov'])?$data['ya_prov']:'');
		$city=$this->db->escape(isset($data['ya_city'])?$data['ya_city']:'');
		$zone=$this->db->escape(isset($data['ya_town'])?$data['ya_town']:'');
		$consignDate=$this->db->escape(isset($data['consignDate'])?$data['consignDate']:'');
		$bearFreight=$this->db->escape(isset($data['bearFreight'])?$data['bearFreight']:'');
		//$calc_rule=$this->db->escape(isset($data['valuation'])?$data['valuation']:'');
		$delivery_type=$this->db->escape(isset($data['tplType'])?$data['tplType']:'');
		
		$shipping_fee_arr=array();
		$express_arr=array();
		$ems_arr=array();
		$post_arr=array();
		
		$express_start=$this->db->escape(isset($data['express_start'])?$data['express_start']:'');
		$express_postage=$this->db->escape(isset($data['express_postage'])?$data['express_postage']:'');
		$express_plus=$this->db->escape(isset($data['express_plus'])?$data['express_plus']:'');
		$express_postageplus=$this->db->escape(isset($data['express_postageplus'])?$data['express_postageplus']:'');
		$express_arr=array(
					 'express_start'      => $express_start,
					 'express_postage'    => $express_postage,
					 'express_plus'       => $express_plus,
					 'express_postageplus'=> $express_postageplus);
		
		$ems_start=$this->db->escape(isset($data['ems_start'])?$data['ems_start']:'');
		$ems_postage=$this->db->escape(isset($data['ems_postage'])?$data['ems_postage']:'');
		$ems_plus=$this->db->escape(isset($data['ems_plus'])?$data['ems_plus']:'');
		$ems_postageplus=$this->db->escape(isset($data['ems_postageplus'])?$data['ems_postageplus']:'');
		$ems_arr   = array(
		                 'ems_start'      => $ems_start,
						 'ems_postage'    => $ems_postage,
						 'ems_plus'       => $ems_plus,
						 'ems_postageplus'=> $ems_postageplus);
		
		$post_start=$this->db->escape(isset($data['post_start'])?$data['post_start']:'');
		$post_postage=$this->db->escape(isset($data['post_postage'])?$data['post_postage']:'');
		$post_plus=$this->db->escape(isset($data['post_plus'])?$data['post_plus']:'');
		$post_postageplus=$this->db->escape(isset($data['post_postageplus'])?$data['post_postageplus']:'');
		$post_arr   = array(
		                 'post_start'      => $post_start,
						 'post_postage'    => $post_postage,
						 'post_plus'       => $post_plus,
						 'post_postageplus'=> $post_postageplus);
						 
		if(!empty($express_start) && !empty($express_postage)) $shipping_fee_arr['express']= $express_arr;
		if(!empty($ems_start) && !empty($ems_postage)) $shipping_fee_arr['ems']    = $ems_arr;
		if(!empty($post_start) && !empty($post_postage)) $shipping_fee_arr['post']   = $post_arr;
						 
		$shipping_fee=serialize($shipping_fee_arr);
		
		$sql="update ".DB_PREFIX."shipping set delivery_type='{$delivery_type}',shipping_desc='{$shipping_desc}',shipping_fee='{$shipping_fee}',province='{$province}',city='{$city}',zone='{$zone}',consignDate='{$consignDate}',is_freight='{$bearFreight}'";
		return $this->db->query($sql);
	}
	

	

}
?>