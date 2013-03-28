<?php
/**
*  商家商品信息
*/
class ModelMerchantsProduct extends Model {
	/**
	*  获取商品列表
	*  intStart   :起始记录
	*  intCount   ：多少条记录
	*  data       ：搜索条件
	*/
	public function getList($data){
	    $res=array();
	    $status =isset($data['status'])?$this->db->escape($data['status']):'';
		$name=isset($data['name'])?$this->db->escape($data['name']):'';
		$model=isset($data['model'])?$this->db->escape($data['model']):'';
		$price1=isset($data['price1'])?$this->db->escape($data['price1']):'';
		$price2=isset($data['price2'])?$this->db->escape($data['price2']):'';
		$store_id=$this->cookie->OCAuthCode($this->request->cookie['storeid'],'DECODE');
		if(empty($store_id)){
			$this->showMessage("您还没有开店，或登录已超时，请重新登录！");
		}
		
		$where="where 1 ";
		if(!empty($status)) $where .=" and status={$status}";
		if(!empty($name)) $where.=" And name like '%{$name}%'";
		if(!empty($model)) $where.=" And model='{$model}'";
		if(!empty($price1)) $where.=" And price>={$price1}";
		if(!empty($price2)) $where.=" And price<={$price2}";
		if(!empty($store_id)) $where .= " And  store_id={$store_id}";
		
		if ($data['start'] < 0) {
			$data['start'] = 0;
		}
		
		if ($data['limit'] < 1) {
			$data['limit'] = 1;
		}
		
		$sql="select * from view_product ".$where." order by product_id desc LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];

		$query=$this->db->query($sql);
		
		
		$res=$query->rows;
	   		
		return $res;
	}

	/**
	*  获取商品总条数
	*  data : 搜索条件
	*/
	public function getTotalProducts($data){
		$status=isset($data['status'])?$this->db->escape($data['status']):'';
		$name=isset($data['name'])?$this->db->escape($data['name']):'';
		$model=isset($data['model'])?$this->db->escape($data['model']):'';
		$price1=isset($data['price1'])?$this->db->escape($data['price1']):'';
		$price2=isset($data['price2'])?$this->db->escape($data['price2']):'';
		$store_id=$this->cookie->OCAuthCode($this->request->cookie['storeid'],'DECODE');
		if(empty($store_id)){
			$this->showMessage("您还没有开店，或登录已超时，请重新登录！");
		}

		$where='where 1 ';
		if(!empty($status)) $where.=" and status={$status}";
		if(!empty($name)) $where.=" And name like '%{$name}%'";
		if(!empty($model)) $where.=" And model='{$model}'";
		if(!empty($price1)) $where.=" And price>={$price1}";
		if(!empty($price2)) $where.=" And price<={$price2}";
		if(!empty($store_id)) $where .=" and store_id={$store_id}";
		
		$sql="select count(product_id) as total from view_product ".$where;
		$query=$this->db->query($sql);
		return $query->row["total"];
	}
	
	/**
	*  因为删除了产品表中的category_id字段，所以每次都要重新查询产品最小类
	*  intProductId : 产品ID
	*/
	public function getCategoryId($intProductId){
		$strSql="select Max(category_id) as category_id from product_to_category where product_id={$intProductId}";
		$query=$this->db->query($strSql);
		return $query->row["category_id"];
	}
	
	/**
	* 设置商品状态信息
	*/
	public function setProductStatus($field,$value,$intId) {
		$store_id=$this->cookie->OCAuthCode($this->request->cookie['storeid'],'DECODE');
		if(empty($store_id)){
			$this->showMessage("您还没有开店，或登录已超时，请重新登录！");
		}
		$query=$this->db->query("update " . DB_PREFIX . "product SET {$field}={$value} where store_id={$store_id} and product_id in({$intId})");
		if($query===true){
			return "ok";
		}
		return "no";
	}
	
	/**
	* 设置商品主图片信息
	*/
	public function setProductImage($img_id,$pro_id) {
		$store_id=$this->cookie->OCAuthCode($this->request->cookie['storeid'],'DECODE');
		if(empty($store_id)){
			$this->showMessage("您还没有开店，或登录已超时，请重新登录！");
		}
		$image=$this->db->query("select image from " . DB_PREFIX . "product_image where product_image_id={$img_id} and product_id={$pro_id}");
		if($image->num_rows==0) return "no";
		$query=$this->db->query("update " . DB_PREFIX . "product SET image='". $image->row["image"] ."' where store_id={$store_id} and product_id ={$pro_id}");
		if($query===true){
			return "ok";
		}
		return "no";
	}
	
	/**
	* 删除商品图片信息
	*/
	public function delProductImage($img_id,$pro_id) {
		$store_id=$this->cookie->OCAuthCode($this->request->cookie['storeid'],'DECODE');
		if(empty($store_id)){
			$this->showMessage("您还没有开店，或登录已超时，请重新登录！");
		}
		$product=$this->db->query("select product_id from " . DB_PREFIX . "product where store_id={$store_id} and product_id ={$pro_id}");
		if($product->num_rows==0) return "no";
		$query=$this->db->query("delete from " . DB_PREFIX . "product_image where product_image_id={$img_id} and product_id={$pro_id}");
		if($query===true){
			return "ok";
		}
		return "no";
	}
}
?>