<?php
class ModelCatalogJoy extends Model {
	/**
	*  爽页面 model
	*  AUTHOR: WD
	*
	**/

	/* joy */
	public function getImage($data=array()){
	    $result=array();
		
		$limit=$data['limit'];
		
	    if(!empty($data['start'])){
		    $start=$data['start']*$limit;
		}else{
		    $start=0;
		}

		
	    $query = $this->db->query("select a.content_id,a.`present`,a.imageUrl,a.favoriate,a.`share`,c.nickname,c.avatar from `". DB_PREFIX ."contents` a left join ".DB_PREFIX."customer c on a.customer_id=c.customer_id limit {$start},{$limit}");
		$result=$query->rows;
		
		return $result;
		 	 
	}

	public function getTotalComments($id){
		
		$query = $this->db->query("select count(comment_id) as total from `". DB_PREFIX ."comments` where content_id = {$id}");

		 return $query->row['total'];
	
	}

    /* joyProduct */
	/* public function getMessageByShow($id){
	
		$query = $this->db->query("select content_id,imageUrl,`favoriate`,`share` from `". DB_PREFIX ."contents` where content_id = '$id' ");

		return $query->row;
	} */

	public function getContent($id){
	
		 $query = $this->db->query("select content_id,imageUrl,`favoriate`,`share`,`title`,`content`,`present`,`createtime`,`customer_id` from `". DB_PREFIX ."contents` where content_id = '$id' ");
		
		 return $query->row;
	}

	public function getComments($id){
	
		$query = $this->db->query("select `comment`,`createtime`,`userid`,`username` from ". DB_PREFIX ."comments where content_id = {$id} order by comment_id desc");
		
		return $query->rows;
	}

	public function addFavoriate($id){
	
		$query = $this->db->query("update `". DB_PREFIX ."contents` set `favoriate` = `favoriate`+1 where content_id = {$id}");

	
	}

	public function addComment($id,$comment){
	    $time=time();
		
		$userid=$this->customer->getId();
		if(empty($userid)){
		    $userid=0;
		}
		
		$username=$this->customer->getUserName();
		if(empty($username)){
		    $username='';
		}
		
		$sql="insert into `". DB_PREFIX ."comments`(comment,createtime,content_id,userid,username) values ('{$comment}','{$time}','{$id}','{$userid}','{$username}') ";//注意：{$comment}要加引号，否则数据只能插入整型数
        
		$query = $this->db->query($sql);
		
		return $query;
	
	}

}
?>