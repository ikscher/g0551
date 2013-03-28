<?php
//更新数据信息
class ModelSettingUpdate extends Model {
    //更新属性选项
	/**
	*  修改attribute_group 数据后，同步更新option_value_description,option_value 对应的字段值
	*/
    public function updateOption(){
	    //$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "option_value` ");
		//$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "option_value_description` ");
		
		$sql="select ag.attribute_group_id as gid ,a.attribute_id as aid,ad.name,ag.option_id from ".DB_PREFIX."attribute_group ag left join ".DB_PREFIX."attribute a on ag.attribute_group_id=a.attribute_group_id left join ".DB_PREFIX."attribute_description ad on a.attribute_id=ad.attribute_id where ag.isShow=1 order by a.attribute_id asc";
		$query=$this->db->query($sql);
		$result=$query->rows;
		
		if(!empty($result)){
		    $this->db->query('BEGIN');
			foreach($result as $v){
			    $option_id=isset($v['option_id'])?$v['option_id']:2;
				$gid=$v['gid'];
				$aid=$v['aid'];
				$name=$v['name'];
				
				$sql="select option_value_id from ".DB_PREFIX."option_value_description where `option_id`='{$option_id}' and attribute_group_id='{$gid}' and attribute_id='{$aid}'";
				$query=$this->db->query($sql);
				
				
				if($query->num_rows<=0){
					$sql="insert into ".DB_PREFIX."option_value_description(`option_id`,`name`,`attribute_group_id`,`attribute_id`) values('{$option_id}','{$name}','{$gid}','{$aid}')";
					$updateOVD=$this->db->query($sql);
					
					$option_value_id=$this->db->getLastId();
					
					$sql="insert into ".DB_PREFIX."option_value(`option_value_id`,`option_id`,`image`,`sort_order`)  values('{$option_value_id}','{$option_id}','no_image.jpg','0')";//option-id=2->默认复选框checkbox
					$updateOV=$this->db->query($sql);
					
					if(!$updateOV || !$updateOVD){
					   $this->db->query('ROLLBACK');
					}
				
				}else{
				    $sql="update ".DB_PREFIX."option_value_description SET name='{$name}' where `option_id`='{$option_id}' and attribute_group_id='{$gid}' and attribute_id='{$aid}'";
				    if(!$this->db->query($sql)){
					    $this->db->query('ROLLBACK');
					}
				}
				
				
				
				
				
			}
			$this->db->query('COMMIT');
	    }
	
	}
	
	public function updateStoreCategory(){
	    $sql="delete from ".DB_PREFIX."category_to_store ";
		$this->db->query($sql);
	   
	   $sql="select p2s.product_id,p2s.store_id,p2c.category_id from ".DB_PREFIX."product_to_store p2s left join ".DB_PREFIX."product_to_category p2c on p2s.product_id=p2c.product_id left join ".DB_PREFIX."product p on p2s.product_id=p.product_id where p.status=1 group by p2s.store_id,p2c.category_id ";
		$query=$this->db->query($sql);
		
		$result=$query->rows;
		
		if($query->num_rows>0){
		    foreach($result as $v){
			    if(empty($v)) continue;
			    $store_id=$v['store_id'];
				$category_id=$v['category_id'];
				
				//$sql="select category_id from ".DB_PREFIX."category_to_store where store_id={$store_id} and category_id={$category_id}";
				//$query_=$this->db->query($sql);
				//if($query_->num_rows<=0){
				    $sql="insert into ".DB_PREFIX."category_to_store  set `category_id`='{$category_id}',`store_id`='{$store_id}'";
					$this->db->query($sql);
				//}
			
			}
		
		}
	    
	
	}


}
?>