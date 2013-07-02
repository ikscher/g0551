<?php
class ModelTryTry extends Model {
	
	
	public function getProducts($store_id=0) {
	    $time=time();
	
	
		/* $special=array();
		$sql="SELECT date_start,date_end,price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id='".(int)$product_id . "' AND  ps.date_start <'$time' AND  ps.date_end >'$time' ORDER BY ps.priority ASC, ps.price ASC LIMIT 1";//."' and  ps.customer_group_id = '" . (int)$customer_group_id 只有登录的情况下出现的bug
		$query_=$this->db->query($sql);
		if($query_->num_rows>0){
			$query_->row['date_start']=date('Y-m-d H:i:s',($query_->row['date_start']));
			$query_->row['date_end']  =date('Y-m-d H:i:s',($query_->row['date_end']));
			$special=$query_->row;
		} */
		
		//(SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id  AND pd2.quantity ='1' and  pd2.date_start <'$time' AND  pd2.date_end >'$time'  ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount,
        $sql="SELECT  p.*,ps.price as special_price ,ps.date_start,ps.date_end,pd.meta_keyword,pd.description,pd.meta_description, pd.name AS name, p.image, m.name AS manufacturer, (SELECT points FROM " . DB_PREFIX . "product_reward pr WHERE pr.product_id = p.product_id ) AS reward, (SELECT ss.name FROM " . DB_PREFIX . "stock_status ss WHERE ss.stock_status_id = p.stock_status_id ) AS stock_status,  (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, (SELECT COUNT(*) AS total FROM " . DB_PREFIX . "review r2 WHERE r2.product_id = p.product_id AND r2.status = '1' GROUP BY r2.product_id) AS reviews, p.sort_order FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) LEFT JOIN " . DB_PREFIX . "product_special ps on p.product_id=ps.product_id where  p.date_available>={$time} AND p.status = '1'  AND ps.date_start <='$time' AND  ps.date_end >='$time'  ";		
	    
		if(!empty($store_id)){
		    $sql.=" AND p2s.store_id={$store_id}";
		}else{
			$sql.=" limit 36";
		}
		
		$query = $this->db->query($sql);
		
		
		if ($query->num_rows) {
		       $results=$query->rows;

			   
		        return $results;
			
		} else {
			return false;
		}
	}
	
	
	/**依据产品取对应的类*/
	public function getProductLevelCategory($product_id) {
		$product_category_data = array();
		
		$sql="SELECT c.category_id,cd.name FROM " . DB_PREFIX . "product_to_category p2c left join ".DB_PREFIX."category c on p2c.category_id=c.category_id left join ".DB_PREFIX."category_description cd on p2c.category_id=cd.category_id  WHERE product_id = '" . (int)$product_id . "' order by c.top desc limit 1";
		$query = $this->db->query($sql);
		
		
		$product_category_data = $query->row;
		

		return $product_category_data;
	}
	
	//是否试用过产品
	public function getTryProduct($product_id,$attribute_ids,$customer_id,$flag=true){
	    if($flag){
			$sql="select try_id from ".DB_PREFIX."try where product_id={$product_id} and attribute_ids='{$attribute_ids}' and customer_id={$customer_id}";
		}else{
            $sql="select try_id from ".DB_PREFIX."try where product_id={$product_id} and attribute_ids='{$attribute_ids}' and mobile={$customer_id}";
        }		
		$query=$this->db->query($sql);
		
		return $query->num_rows;
	
	}
	
	//选中的试用产品
	public function getSelectedTryProduct($try_id){
	    
	    $sql="select t.try_id,t.product_id,p.image,pd.name,t.attribute,p.price,ps.price as special_price ,ps.date_start,ps.date_end from ".DB_PREFIX."try t left join ".DB_PREFIX."product p on t.product_id=p.product_id left join ".DB_PREFIX."product_description pd on t.product_id=pd.product_id left join ".DB_PREFIX."product_special ps on t.product_id=ps.product_id where t.try_id in({$try_id})";
	   $query=$this->db->query($sql);
		
		return $query->rows;
	}
	
	//试用产品
	public function addTryProduct($try_order_id,$customer_id,$product_id,$attribute_ids,$store_id,$mobile,$time,$attribute){
	    $sql="insert into ".DB_PREFIX."try (`try_order_id`,`customer_id`,`product_id`,`attribute_ids`,`store_id`,`mobile`,`trytime`,`attribute`) values('{$try_order_id}','{$customer_id}','{$product_id}','{$attribute_ids}','{$store_id}','{$mobile}','{$time}','{$attribute}')";
	    //return $this->db->query($sql);
	    if($this->db->query($sql)){
		    return $this->db->getLastId();
		} 
	}
	
	//删除试用的产品
	public function deleteTryProduct($try_id){
	    $sql="delete from ".DB_PREFIX."try where try_id={$try_id}";
		return $this->db->query($sql);
		 
	}
	
	
	/*取订单号*/
	public function getTryOrderid(){
	    $Orderid='';
		$randNum=rand(1000,9999);
	    $Orderid=date('ymdHis').$randNum;
		
		
		$Orderid='T'.date('ymdHis').$randNum;
		
		
		return $Orderid;
	
	}
	
	/**添加短信发送记录**/
	public function addMessage($mobile,$message,$time,$rand=''){
	    $sql="insert into ".DB_PREFIX."try_tmp_message set mobile='{$mobile}',message='{$message}',sendtime='{$time}',captcha='{$rand}'";
		
		return $this->db->query($sql);
    }
	
	/**验证**/
	public function validateCaptcha($tryid){
	    $result=array();
	    $sql="select captcha from ".DB_PREFIX."try_tmp_message where id='{$tryid}' limit 1";
		
		$query=$this->db->query($sql);
		
		$result=$query->row;
		
		return $result;
	
	}
	
	/**所有待发的信息**/
    public function cacheMessages(){
	    $results=array();
	    $sql="select mobile,sendtime,captcha,message from ".DB_PREFIX."try_tmp_message ";
		$query=$this->db->query($sql);
		
		$results=$query->rows;
		
		return $results;
	}
}
?>