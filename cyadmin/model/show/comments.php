<?php
/**秀的评论**/
class ModelShowComments extends Model {
    /*
	*******所有内容******
	*/
	public function getComments($data=array()){
	    $where=' where 1';
	    if(!empty($data['comment_id'])){
		    $where.=" and comment_id={$data['comment_id']}";
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
		
		if(!empty($data['comment'])){
		    $where.=" and comment like '%".$data['comment']."%'";
		}
		
		if(!empty($data['isShow'])){
		    $where.=" and isShow={$data['isShow']}";
		}
		
		
	    $sql="select comment_id,`comment`,`userid`,`username`,`createtime`,`isShow`,`content_id` from `". DB_PREFIX ."comments` ";
		
		$sql .=$where;
		$query = $this->db->query($sql);
		
		return $query->rows;
	}
	
	/**
	*单一内容
	*/
	public function getComment($id){
	    $result=array();
        $sql="select comment_id,`userid`,`username`,`content_id`,`createtime`,`isShow`,`comment` from `". DB_PREFIX ."comments` where comment_id = '$id' ";
		$query = $this->db->query($sql);
	    $result=$query->row;
		return $result;
	}
	
	/**
	*编辑内容
	*/
	public function editComment($id,$data){

		$comment=isset($data['comment'])?$this->db->escape($data['comment']):'';
		$createtime=strtotime($data['createtime']);
		$isShow=$data['isShow'];
		
		
		$sql="update  `". DB_PREFIX ."comments` set `comment`='{$comment}',`createtime`='{$createtime}',`isShow`='{$isShow}' where comment_id = '{$id}' ";
		
		$this->db->query($sql);
	}
	
	/**
	*删除内容
	*/
	public function deleteComment($id){
	    $sql="delete from ".DB_PREFIX."comments where comment_id='{$id}'";
		$this->db->query($sql);
	
	}
	
	
}
?>