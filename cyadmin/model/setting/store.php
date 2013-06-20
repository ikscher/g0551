<?php
/**店铺**/
class ModelSettingStore extends Model {
	/* public function addStore($data) {
	    $storename=$this->db->escape($data['storename']);
		$shortname=$this->db->escape($data['shortname']);
		$owner=$this->db->escape($data['owner']);
		$telphone=$this->db->escape($data['telphone']);
		$mobile=$this->db->escape($data['mobile']);
		$fax=$this->db->escape($data['fax']);
		$address=$this->db->escape($data['address']);
		$introduce=trim($this->db->escape($data['introduce']));
		$createtime=strtotime($this->db->escape($data['createtime']));
		$quantity=$this->db->escape($data['quantity']);
		$soldnum=$this->db->escape($data['soldnum']);
		$status=$this->db->escape($data['status']);
		$hasShop=$this->db->escape($data['hasShop']);
		$logo=$this->db->escape($data['logo']);
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "store SET name = '{$storename}', `logo`='{$logo}',shortname='{$shortname}',owner='{$owner}',telphone='{$telphone}',mobile='{$mobile}',fax='{$fax}',address='{$address}',introduce='{$introduce}',createtime='{$createtime}',quantity='{$quantity}',soldnum='{$soldnum}',status='{$status}',
		
		
	} */
	
	public function editStore($store_id, $data) {
	    $storename=$this->db->escape($data['name']);
		$shortname=$this->db->escape($data['shortname']);
		$owner=$this->db->escape($data['owner']);
		$password=$this->db->escape($data['password']);
		if(!empty($password)) $password=md5($password);
		$telphone=$this->db->escape($data['telphone']);
		$mobile=$this->db->escape($data['mobile']);
		$fax=$this->db->escape($data['fax']);
		$address=$this->db->escape($data['address']);
		$introduce=trim($this->db->escape($data['introduce']));

		$quantity=$this->db->escape($data['quantity']);
		$soldnum=$this->db->escape($data['soldnum']);
		$status=$this->db->escape($data['status']);
		$hasShop=$this->db->escape($data['hasShop']);
		$logo=$this->db->escape($data['logo']);
		
	    $sql="UPDATE `" .DB_PREFIX. "store` SET name = '{$storename}',`logo`='{$logo}', `status`='{$status}',`shortname` = '{$shortname}', `owner` = '{$owner}',`tel`='{$telphone}' ,mobile='{$mobile}',fax='{$fax}',address='{$address}',introduce='{$introduce}',quantity='{$quantity}',soldnum='{$soldnum}',status='{$status}' WHERE store_id = '" . (int)$store_id . "'";
	   
		$this->db->query($sql);
		
		if(!empty($password)){
		    $sql="update `".DB_PREFIX."customer` set hasShop='{$hasShop}',password='{$password}' where store_id='{$store_id}'";
		}else{
		    $sql="update `".DB_PREFIX."customer` set hasShop='{$hasShop}' where store_id='{$store_id}'";
		}
		$this->db->query($sql);
						
		$this->cache->delete('store');
	}
	
	public function deleteStore($store_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "store WHERE store_id = '" . (int)$store_id . "'");
			
		$this->cache->delete('store');
	}	
	
	public function getStore($store_id) {
	    $sql="SELECT s.*,c.hasShop,c.email FROM ".DB_PREFIX. "store  s inner join ".DB_PREFIX."customer  c  on s.store_id=c.store_id  where s.store_id = '" . (int)$store_id . "'";
		$query = $this->db->query($sql);
		
		return $query->row;
	}
	
	public function getStores($data = array()) {
		
	    $store_data=array();
		
		$sql="SELECT s.*,c.hasShop FROM ".DB_PREFIX. "store  s inner join ".DB_PREFIX."customer  c  on s.store_id=c.store_id";
		
		if(isset($data['status'])){
		    $sql.=" where  s.status='".$data['status']."'";
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

		$store_data = $query->rows;
	
		
	 
		return $store_data;
	}

	public function getTotalStores() {
      	$query = $this->db->query("SELECT COUNT(store_id) AS total FROM " . DB_PREFIX . "store");
		
		return $query->row['total'];
	}	
	

	
	
	public function getTotalStoresByOrderStatusId($order_status_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "setting WHERE `key` = 'config_order_status_id' AND `value` = '" . (int)$order_status_id . "'");
		
		return $query->row['total'];		
	}	
}
?>