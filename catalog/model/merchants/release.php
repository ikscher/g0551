<?php

/**
*  发布商品
*/
class ModelMerchantsRelease extends Model {
	/**
	*  获取子分类信息
	*  category_id   :分类ID
	*8  encode	:是否对中文进行URL编码
	*/
	public function getClass($category_id,$encode=true){
	   $category_id   =$this->db->escape($category_id);
	   $res=array();
	   $query=$this->db->query("select a.category_id as classId,b.name as className from " . DB_PREFIX . "category as a,category_description as b where a.category_id=b.category_id and a.parent_id={$category_id}");
       if($query->num_rows>0){
			$class_list=$query->rows;
			foreach($class_list as $item){
				if($encode){
					$item["className"]=urlencode(trim($item["className"]));
				}
				$res[]=$item;
			}
	   }
	   return $res;
	}
	
	
	
	
	/**
	*  获取子分类属性信息
	*  category_id   :分类ID
	*  $attribute_group 如果不为空，就排除在这个数组里面的 ATTRIBUTE_GROUP_ID值
	*/
	public function getAttributesByCid($category_id,$attribute_group=array()){
	   $category_id   = $this->db->escape($category_id);
	   $res=array();
	   //获取分类下的属性组ID
	   $query=$this->db->query("select attribute_group from " . DB_PREFIX . "category where category_id={$category_id}");
       if($query->num_rows>0){
			$attribute_group_id=$query->row["attribute_group"];
			//echo $attribute_group_id;
			if(!empty($attribute_group_id)){
				//获取属性组列表
				$query_=$this->db->query("select ag.attribute_group_id,ag.option_id,ag.`type` as gtype, agd.name as attribute_group_name,o.`type`,c2ag.is_pa from " . DB_PREFIX . "attribute_group  ag inner join " . DB_PREFIX . "attribute_group_description  agd on ag.attribute_group_id=agd.attribute_group_id  inner join `".DB_PREFIX."option` o on ag.option_id=o.option_id   inner join ".DB_PREFIX."category_to_attribute_group c2ag on ag.attribute_group_id=c2ag.attribute_group_id where  ag.isShow=1 and c2ag.category_id='{$category_id}' and ag.attribute_group_id in({$attribute_group_id}) order by ag.sort_order asc,ag.attribute_group_id asc");
				if($query_->num_rows>0){
				
					$group_list=$query_->rows;
					foreach($group_list as $item){
					    if(in_array($item['attribute_group_id'],$attribute_group)) continue;
						$attr_array=array();
						//获取属性组下的所有属性值  开始
						$query__=$this->db->query("select a.attribute_id, ad.name as attrName from " . DB_PREFIX . "attribute  a  left join " . DB_PREFIX . "attribute_description  ad  on  a.attribute_id=ad.attribute_id   where a.isShow=1 and a.attribute_group_id=". $item["attribute_group_id"] ." order by a.sort_order asc,a.attribute_id asc");
						if($query__->num_rows>0){
							$attr_list=$query__->rows;
							foreach($attr_list as $attr_item){
								$attr_item["name"]=trim($attr_item["attrName"]);
								$attr_array[]=$attr_item;
							}
						}
						//获取属性组下的所有属性值  结束
						
						$item['required']=1;
						$item['name']=$item['type'];
						$item['product_option_id']='';
						$item["attribute_group_name"]=trim($item["attribute_group_name"]);
						$item["attribute"]=$attr_array;
						$item['product_option_value']=array();
						
						if($item['is_pa'] && $item['gtype']==2){//设置了价格属性
							$item['gtype']=$item['gtype'];
						}else{ //其他全部定位一般属性
						    $item['gtype']=1;
						}
						$res[]=$item;
					}
					
				}
			}
		
	   }
	   return $res;
	}
	
	
	/**
	* 获取当前商品属性值
	* $intId :商品ID
	*/
	public function getAttrValue($id) {
		$value="";
		if($id>0){
		    $query=$this->db->query("select attribute_id from " . DB_PREFIX . "product_attribute where product_id={$id}");
		    if($query->num_rows>0){
			   $value=$query->row["attribute_id"];
		    }
		}
		return $value;
	}
	
	
	/**
	* 获取当前商品图片列表
	* $intId :商品ID
	*/
	public function getImages($intId) {
		$image=array();
		if($intId>0){
		   $query=$this->db->query("select product_image_id as id,image from " . DB_PREFIX . "product_image where product_id={$intId} order by sort_order asc,product_image_id asc");
		   if($query->num_rows>0){
			   foreach($query->rows as $item){
				$image[]=$item;
			   }
		   }
		}
		return $image;
	}
	
	/**
	* 保存商品信息
	* $data :post数据
	* $intId :要修改商品ID，0表示添加新商品
	*/
	public function saveInfo($data,$intId) {
		$category_id   =$this->db->escape($data['category_id']);
		$product_image    =$this->db->escape($data['product_image']);
		$attribute  =$data['attribute'];
		$name    =$this->db->escape($data['name']);
		$price   =$this->db->escape($data['price']);
		$special_price = $this->db->escape($data['special_price']);
		$date_start = $this->db->escape($data['date_start']);
		$date_end   = $this->db->escape($data['date_end']);
		$quantity   =$this->db->escape($data['quantity']);
	    $sku   =$this->db->escape($data['sku']);
	    $shipping   =$this->db->escape($data['shipping']);
		$status     =$this->db->escape($data['status']);
		$model     =$this->db->escape($data['model']);
		$description     =$this->db->escape($data['description']);
		$store_id=$this->db->escape($data['store_id']);
	
		if(empty($store_id)){
			exit("您还没有开店，或登录已超时，请重新登录！");
		}
		$date_added=time();
		$date_available=time()+7776000;//发布的商品90天内有效
	
	    //获取有效属性值数组
		$attrList=array();
		
	
		
		//获取宝贝图片数组
		$imageList=array();
		if(trim($product_image)!=""){
			$imageList=explode(",",str_replace("/image/","",$product_image));
		}
		
		
		//获取宝贝分类数组
		$categoryList=array();
		$categoryList[]=$category_id;
		$parent_id=$category_id;
		while($parent_id>0){
			$list=$this->db->query("select parent_id from " . DB_PREFIX . "category where category_id={$parent_id}");
			if($list->num_rows==0){
				break;
			}
			$parent_id=$list->row["parent_id"];
			if($parent_id>0)$categoryList[]=$parent_id;
		}
		$categoryList=array_reverse($categoryList);
		
		//保存商品及相关信息
		if($intId==0){ //插入
		    $sql="INSERT INTO " . DB_PREFIX . "product SET store_id = '{$store_id}',model='{$model}', price = '{$price}',quantity = '{$quantity}', sku = '{$sku}',image='". $imageList[0] ."', shipping = '{$shipping}',  status = '{$status}', date_added = '{$date_added}',date_available='{$date_available}'";
			
			$query=$this->db->query($sql);
			$product_id=$this->db->getLastId();
			
			//写入商品描述信息
			$this->db->query("INSERT INTO " . DB_PREFIX . "product_description SET product_id='{$product_id}',name='{$name}',description='{$description}'");
			
			//写入商品产品对照表
			$this->db->query("insert into ".DB_PREFIX."product_to_store set product_id='{$product_id}',store_id='{$store_id}'");
			
			//写入宝贝分类信息
			foreach($categoryList as $category_id){
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id='{$product_id}',category_id='{$category_id}'");
				$this->db->query("REPLACE INTO " . DB_PREFIX . "category_to_store SET category_id = '" . (int)$category_id . "', store_id = '" . (int)$store_id . "'");
			} 
			
			//写入优惠价格表
			if (!empty($special_price)) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$this->customer->getCustomerGroupId() . "', price = '" . (float)$special_price. "', date_start = '{$date_start}', date_end = '{$date_end}'");
			}
			
			//====编辑属性begin===
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "'");
			
			$comma='|';
			$separtor='';
			$sql='';
			$option_attribute_id='';
			$product_attribute_id='';
			$optioin_attribute_=array();
			//====编辑属性end===
		  
			if (!empty($data['product_option'])) {
				foreach ($data['product_option'] as $product_option_value) {
					
					
							$quantity=!empty($product_option_value['quantity'])?(int)$product_option_value['quantity']:1;
							$attribute_id1=$product_option_value['attribute1'];
							$attribute_id2=isset($product_option_value['attribute2'])?$product_option_value['attribute2']:'';
							if(!empty($attribute_id2)){
							    $compositeId='|'.$attribute_id1.'|'.$attribute_id2.'|';
							}else{
							    $compositeId='|'.$attribute_id1.'|';
							}
							$sql="INSERT INTO " . DB_PREFIX . "product_option_ulity SET  composite_id='{$compositeId}' ,product_id = '" . (int)$product_id. "', quantity = '{$quantity}', subtract = '" . (int)$product_option_value['subtract'] . "', price = '" . (float)$product_option_value['price'] . "'";
							
							$this->db->query($sql);
						    
							array_push($attribute,$attribute_id1);
							if(!empty($attribute_id2)){ array_push($attribute,$attribute_id2);}
							
							array_push($optioin_attribute_,$attribute_id1);
							if(!empty($attribute_id2)){ array_push($optioin_attribute_,$attribute_id2);}
							
					
					
				}
				
				
				//=============编辑属性开始===================
				$sql=" product_id = '" . (int)$product_id . "'";
				
				$attrList=array_unique($attribute);
				foreach($attrList as $v){
				    if(empty($v)) continue;
				    $product_attribute_id .=$comma;
					$product_attribute_id .="{$v}";
				
				}
				//判断属性值是否全部为空的
				$s=preg_replace('/|/','',$product_attribute_id);
				$product_attribute_id .=$comma;
				
				$mmm=array_unique($optioin_attribute_);
				foreach($mmm as $v){
				    if(empty($v)) continue;
				    $option_attribute_id .=$comma;
					$option_attribute_id .="{$v}";
				
				}
				
				if(!empty($s)) $sql.=", `attribute_id`='{$product_attribute_id}',`option_attribute_id`='{$option_attribute_id}'";

				$this->db->query("insert into ".DB_PREFIX."product_attribute set ".$sql  );
				
									
				//=============编辑属性结束=================
			}
			
		}else{  //编辑
		
			$product_id=$intId;
			$date_modified=time();
			$optioin_attribute_=array();
			//判断是商品是否属于本店
			$sql="select product_id from " . DB_PREFIX . "product_to_store where product_id='{$product_id}' and store_id='{$store_id}'";
			$result=$this->db->query($sql);
			if($result->num_rows==0){
				return "nostore";
			}
			
			$query=$this->db->query("Update " . DB_PREFIX . "product SET model='{$model}', price = '{$price}',quantity = '{$quantity}', sku = '{$sku}', shipping = '{$shipping}',  status = '{$status}', date_modified = '{$date_modified}' Where product_id='{$product_id}'");
			
			//修改商品描述信息
			$this->db->query("Update " . DB_PREFIX . "product_description SET name='{$name}',description='{$description}' Where product_id='{$product_id}'");
			
			
			//写入优惠价格表
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "'");
		
			if (!empty($special_price)) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$this->customer->getCustomerGroupId() . "', price = '" . (float)$special_price . "', date_start = '{$date_start}', date_end = '{$date_end}'");
			}
			
			//====编辑属性begin===
			//$this->load->model('catalog/attribute');
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "'");
			$comma='|';
			$separtor='';
			$sql='';
			$product_attribute_id='';
			$option_attribute_id='';

			$this->db->query("DELETE FROM " . DB_PREFIX . "product_option_ulity WHERE product_id = '" . (int)$product_id . "'");
			
			
			if (!empty($data['product_option'])) {
				
				foreach ($data['product_option'] as $product_option_value) {
					
					
							$quantity=!empty($product_option_value['quantity'])?(int)$product_option_value['quantity']:1;
							$attribute_id1=$product_option_value['attribute1'];
							$attribute_id2=isset($product_option_value['attribute2'])?$product_option_value['attribute2']:'';
							if(!empty($attribute_id2)){
								$compositeId='|'.$attribute_id1.'|'.$attribute_id2.'|';
							}else{
							    $compositeId='|'.$attribute_id1.'|';
							}
							$sql="INSERT INTO " . DB_PREFIX . "product_option_ulity SET  composite_id='{$compositeId}' ,product_id = '" . (int)$product_id. "', quantity = '{$quantity}', subtract = '" . (int)$product_option_value['subtract'] . "', price = '" . (float)$product_option_value['price'] . "'";
							
							$this->db->query($sql);
						    
							array_push($attribute,$attribute_id1);
							if(!empty($attribute_id2)){ array_push($attribute,$attribute_id2);}
							
							array_push($optioin_attribute_,$attribute_id1);
							if(!empty($attribute_id2)){ array_push($optioin_attribute_,$attribute_id2);}
							
					
					
				}
				
				
				//=============编辑属性开始===================
				$sql=" product_id = '" . (int)$product_id . "'";
				
				$attrList=array_unique($attribute);
				foreach($attrList as $v){
				    if(empty($v)) continue;
				    $product_attribute_id .=$comma;
					$product_attribute_id .="{$v}";
				
				}
				//判断属性值是否全部为空的
				$s=preg_replace('/|/','',$product_attribute_id);
				$product_attribute_id .=$comma;
				
				$mmm=array_unique($optioin_attribute_);
				foreach($mmm as $v){
				    if(empty($v)) continue;
				    $option_attribute_id .=$comma;
					$option_attribute_id .="{$v}";
				
				}
				
				if(!empty($s)) $sql.=", `attribute_id`='{$product_attribute_id}',`option_attribute_id`='{$option_attribute_id}'";

				$this->db->query("insert into ".DB_PREFIX."product_attribute set ".$sql  );
				
									
				//=============编辑属性结束=================
			} 
				
				
			
		}
		
		
	
		
		//保存宝贝属性信息
		/* if(count($attrList)>0){
			$result=$this->db->query("select product_id from " . DB_PREFIX . "product_attribute where product_id={$product_id}");
			if($result->num_rows==0){
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET product_id={$product_id},attribute_id='|". implode("|",$attrList) ."|'");
			}else{
				$this->db->query("Update " . DB_PREFIX . "product_attribute SET attribute_id='|". implode("|",$attrList) ."|' where product_id={$product_id}");
			}
		} */
		
		//保存宝贝图片信息
		if(count($imageList)>0){
			foreach($imageList as $item){
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id='{$product_id}',image='{$item}',date_added={$date_added}");
			}
		}
		
		if($query===true){
		   return $product_id;
		}
		return "no";
	}
	
	/**
	*  获取商品详细信息
	*  intProduct   :商品ID
	*/
	/* public function getInfo($intProduct){
	   $intProduct   =$this->db->escape($intProduct);
	   $res=array("product_id"=>"0","category_id"=>"","price"=>"","quantity"=>"","sku"=>"","shipping"=>"1","status"=>"1","model"=>"","name"=>"","description"=>"",);
	   $query=$this->db->query("select a.*,b.name,b.description from " . DB_PREFIX . "product as a,product_description as b where a.product_id=b.product_id And a.product_id={$intProduct}");
       if($query->num_rows>0){
	   	   $res=$query->row;
	   }
	   return $res;
	} */
	
	/**
	*  获取属性组的类型1：一般属性，2：价格属性
	*/
	public function getAttributeGroupType($attribute_group_id){
	    $data=array();
		$sql="select type from ".DB_PREFIX."attribute_group where attribute_group_id='{$attribute_group_id}'";
	    $query=$this->db->query($sql);
		$data=$query->row;
		return $data['type'];
	}
	
	
}
?>