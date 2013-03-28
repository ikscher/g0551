<?php
//更新环境变量setting表的配置
class ModelSettingEnviorment extends Model {
    public function addEnviorment($data){
	    $group=$this->db->escape($data['group']);
		$key  =$this->db->escape($data['key']);
		$value=$this->db->escape($data['val']);
		$serial=$this->db->escape($data['serial']);
		
		if($serial==1) $value=serialize($value);
		
		$sql="insert into ".DB_PREFIX."setting SET `group`='{$group}',`key`='{$key}',`value`='{$value}',`serialized`='{$serial}'";
		

		$this->db->query($sql);
	
	}
	
	public function editEnviorment($data){

	    $id=$data['setting_id'];
	    $group=trim($this->db->escape($data['group']));
		$key  =trim($this->db->escape($data['key']));
		$value=trim($this->db->escape($data['val']));
		$serial=trim($this->db->escape($data['serial']));
		if($serial==1) $value=serialize($value);

		$sql="update ".DB_PREFIX."setting SET `group`='{$group}',`key`='{$key}',`value`='{$value}',`serialized`='{$serial}' where setting_id='{$id}'";
	

		$this->db->query($sql);
	
	}
	
    public function getEnviorments($data=array()){
	    $results=array();
	    $sql="select * from ".DB_PREFIX."setting ";
		
		if ($data['group']){
		    $sql .= " where `group`='{$data['group']}'";
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
		
		$query=$this->db->query($sql);
		$results=$query->rows;
		
		return $results;
	
	}
	
	public function getTotalEnviorment($data=array()){
	    $sql="select setting_id from ".DB_PREFIX."setting ";
		
		if(!empty($data['group'])){
		    $sql .= " where  `group`='{$data['group']}'";
		}
		
		$query=$this->db->query($sql);
		
		return $query->num_rows;
	
	
	}
	
	public function getEnviorment($id){
	    $sql="select * from ".DB_PREFIX."setting where setting_id='{$id}'";
		$query=$this->db->query($sql);
	    
		return $query->row;
	}
	
	public function deleteEnviorment($id){
	    $sql="delete from ".DB_PREFIX."setting where setting_id='{$id}'";
		$this->db->query($sql);
	
	}
	

}
?>