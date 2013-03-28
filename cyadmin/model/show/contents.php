<?php
/**秀的主题**/
class ModelShowContents extends Model {
    /*
	*******所有内容******
	*/
	public function getContents($data=array()){
	    $where=' where 1';
	    if(!empty($data['content_id'])){
		    $where.=" and content_id={$data['content_id']}";
		}
		
		$starttime=isset($data['starttime'])?strtotime($data['starttime']):0;
		$endtime=isset($data['endtime'])?strtotime($data['endtime']):0;
		if(!empty($starttime) && !empty($endtime)){
		    $where.=" and createtime>={$starttime}  and createtime<={$endtime}";
		}elseif(!empty($starttime) && empty($endtime)){
		    $where.=" and createtime>{$starttime}";
		}elseif(empty($starttime) && !empty($endtime)){
		    $where.=" and createtime<{$endtime}";
		}
		
		if(!empty($data['title'])){
		    $where.=" and title like '%".$data['title']."%'";
		}
		
		if(!empty($data['isShow'])){
		    $where.=" and isShow={$data['isShow']}";
		}
		
		
	    $sql="select content_id,imageUrl,`favoriate`,`share`,`title`,`content`,`present`,`createtime`,`isShow` from `". DB_PREFIX ."contents` ";
		
		$sql .=$where;
		$query = $this->db->query($sql);
		
		return $query->rows;
	}
	
	/**
	*单一内容
	*/
	public function getContent($id){
	    $result=array();
        $sql="select content_id,imageUrl,`favoriate`,`share`,`title`,`content`,`present`,`createtime`,`isShow` from `". DB_PREFIX ."contents` where content_id = '$id' ";
		$query = $this->db->query($sql);
	    $result=$query->row;
		return $result;
	}
	
	/**
	*编辑内容
	*/
	public function editContent($id,$data){
        $imageUrl='';
		$favoriate=isset($data['favoriate'])?$data['favoriate']:0;
		$share=isset($data['share'])?$data['share']:0;
		$title=isset($data['title'])?$this->db->escape($data['title']):'';
		$present=isset($data['present'])?$this->db->escape($data['present']):'';
		$content=isset($data['content'])?$this->db->escape($data['content']):'';
		$createtime=strtotime($data['createtime']);
		$isShow=$data['isShow'];
		
		$image = isset($data['image'])?$this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')):'';
		
		if(strpos($image,'cache')!==false){//已生产缓存文件，不更新数据库
			$image=str_replace(HTTP_IMAGE,'',$image);
			$image=str_replace('cache/','',$image);
			$imageUrl="";
		}else{
		    $imageUrl="`imageUrl`='{$image}',";
		}
		
		$sql="update  `". DB_PREFIX ."contents`  set {$imageUrl} `favoriate`='{$favoriate}',`share`='{$share}',`title`='{$title}',`content`='{$content}',`present`='{$present}',`createtime`='{$createtime}',`isShow`='{$isShow}' where content_id = '{$id}' ";
		
		$this->db->query($sql);
	}
	
	/**
	*删除内容
	*/
	public function deleteContent($id){
	    $sql="delete from ".DB_PREFIX."contents where content_id='{$id}'";
		$this->db->query($sql);
	
	}
	
	/*
	**添加内容
	*/
	public function addContent($data){
	    $favoriate=isset($data['favoriate'])?$data['favoriate']:0;
		$share=isset($data['share'])?$data['share']:0;
		$title=isset($data['title'])?$this->db->escape($data['title']):'';
		$present=isset($data['present'])?$this->db->escape($data['present']):'';
		$content=isset($data['content'])?$this->db->escape($data['content']):'';
		$createtime=strtotime($data['createtime']);
		$isShow=$data['isShow'];
		
		$image = isset($data['image'])?$this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')):'';
		
		$sql="insert  into `". DB_PREFIX ."contents`(`favoriate`,`share`,`title`,`content`,`present`,`createtime`,`isShow`,`imageUrl`) values('{$favoriate}','{$share}','{$title}','{$content}','{$present}','{$createtime}','{$isShow}','{$image}')";
		
		$this->db->query($sql);
		
	
	}
	
}
?>