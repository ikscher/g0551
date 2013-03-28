<?php
class ModelCatalogProduct extends Model {
	public function addProduct($data) {
	    $time=time();
		$this->db->query("INSERT INTO " . DB_PREFIX . "product SET model = '" . $this->db->escape($data['model']) . "', sku = '" . $this->db->escape($data['sku']) . "', upc = '" . $this->db->escape($data['upc']) . "',   location = '" . $this->db->escape($data['location']) . "', quantity = '" . (int)$data['quantity'] . "', minimum = '" . (int)$data['minimum'] . "', subtract = '" . (int)$data['subtract'] . "', stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . strtotime($this->db->escape($data['date_available'])) . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', points = '" . (int)$data['points'] . "', weight = '" . (float)$data['weight'] . "', weight_class_id = '" . (int)$data['weight_class_id'] . "', length = '" . (float)$data['length'] . "', width = '" . (float)$data['width'] . "', height = '" . (float)$data['height'] . "', length_class_id = '" . (int)$data['length_class_id'] . "', status = '" . (int)$data['status']  . "', sort_order = '" . (int)$data['sort_order'] . "', date_added ={$time}");
		
		$product_id = $this->db->getLastId();
		
		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "product SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE product_id = '" . (int)$product_id . "'");
		}
		
		$value=$data['product_description'];
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "product_description SET product_id = '" . (int)$product_id  . "', name = '" . $this->db->escape($value['name']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "', tag = '" . $this->db->escape($value['tag']) . "'");
		
		
		if (isset($data['product_store'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_store SET product_id = '" . (int)$product_id . "', store_id = '" . (int)$data['product_store'] . "'");
		} 

		/* if (isset($data['product_attribute'])) {
			foreach ($data['product_attribute'] as $product_attribute) {
				if ($product_attribute['attribute_id']) {
					$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "' AND attribute_id = '" . (int)$product_attribute['attribute_id'] . "'");
					
					
					$product_attribute_description=$product_attribute['product_attribute_description'];
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET product_id = '" . (int)$product_id . "', attribute_id = '" . (int)$product_attribute['attribute_id']  . "', text = '" .  $this->db->escape($product_attribute_description['text']) . "'");
					
				}
			}
		} */
		
		//====编辑属性begin===
		$this->load->model('catalog/attribute');
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "'");
		
		$comma='|';
		$separtor='';
		$sql='';
		// $product_attribute_description='';
		$product_attribute_id='';
		
		/* if (!empty($data['product_attribute'])) {
			foreach ($data['product_attribute'] as $key=>$product_attribute) {
				if (!empty($product_attribute['attribute_id'])) {
				    $attribute_id=trim($product_attribute['attribute_id']);
					$product_attribute_id .=$comma;
					$product_attribute_id .="{$attribute_id}";
					
					$product_attribute_description .=$separtor;
					$product_attribute_description .=trim($product_attribute['text']);
					$separtor='&&';
						
					
				}
				
			}
			$sql.=" product_id = '" . (int)$product_id . "'";
			
            $s=preg_replace('/|/','',$product_attribute_id);
			if(!empty($s)) $sql.=", `attribute_id`='{$product_attribute_id}".$comma."'";
			
			$s=preg_replace('/&&/','',$product_attribute_description);
			if(!empty($s)) $sql.=" ,`text`='{$product_attribute_description}'";
			
		    
			$this->db->query("insert into ".DB_PREFIX."product_attribute set ".$sql  );
		} */
        //====编辑属性end===
	
		if (isset($data['product_option'])) {
			foreach ($data['product_option'] as $product_option) {
				if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', required = '" . (int)$product_option['required'] . "'");
				
					$product_option_id = $this->db->getLastId();
				
					if (isset($product_option['product_option_value'])) {
						foreach ($product_option['product_option_value'] as $product_option_value) {
							$this->db->query("INSERT INTO " . DB_PREFIX . "product_option_value SET product_option_id = '" . (int)$product_option_id . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', option_value_id = '" . (int)$product_option_value['option_value_id'] . "', quantity = '" . (int)$product_option_value['quantity'] . "', subtract = '" . (int)$product_option_value['subtract'] . "', price = '" . (float)$product_option_value['price'] . "', price_prefix = '" . $this->db->escape($product_option_value['price_prefix']) . "', points = '" . (int)$product_option_value['points'] . "', points_prefix = '" . $this->db->escape($product_option_value['points_prefix']) . "', weight = '" . (float)$product_option_value['weight'] . "', weight_prefix = '" . $this->db->escape($product_option_value['weight_prefix']) . "'");
						    //=================获取属性ID开始=================
							if (!empty($product_option_value['attribute_id'])) {
								$attribute_id=trim($product_option_value['attribute_id']);
								$product_attribute_id .=$comma;
								$product_attribute_id .="{$attribute_id}";
								
								//$product_attribute_description .=$separtor;
								//$product_attribute_description .=trim($product_option_value['text']);
								//$separtor='&&';
										
							}
							//=================获取属性ID结束==================
						} 
					}
				} else { 
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', option_value = '" . $this->db->escape($product_option['option_value']) . "', required = '" . (int)$product_option['required'] . "'");
				}
			}
			
			//=============编辑属性开始===================
			$sql.=" product_id = '" . (int)$product_id . "'";
							
			$s=preg_replace('/|/','',$product_attribute_id);
			if(!empty($s)) $sql.=", `attribute_id`='{$product_attribute_id}".$comma."'";

			//$s=preg_replace('/&&/','',$product_attribute_description);
			//if(!empty($s)) $sql.=" ,`text`='{$product_attribute_description}'";
			
			
			$this->db->query("insert into ".DB_PREFIX."product_attribute set ".$sql  );
			
								
			//=============编辑属性结束=================
		}
		
		if (isset($data['product_discount'])) {
			foreach ($data['product_disEDcount'] as $product_discount) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_discount SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$product_discount['customer_group_id'] . "', quantity = '" . (int)$product_discount['quantity'] . "', priority = '" . (int)$product_discount['priority'] . "', price = '" . (float)$product_discount['price'] . "', date_start = '" . strtotime($this->db->escape($product_discount['date_start'])) . "', date_end = '" . strtotime($this->db->escape($product_discount['date_end'])) . "'");
			}
		}

		if (isset($data['product_special'])) {
			foreach ($data['product_special'] as $product_special) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$product_special['customer_group_id'] . "', priority = '" . (int)$product_special['priority'] . "', price = '" . (float)$product_special['price'] . "', date_start = '" . strtotime($this->db->escape($product_special['date_start'])) . "', date_end = '" . strtotime($this->db->escape($product_special['date_end'])) . "'");
			}
		}
		
		if (isset($data['product_image'])) {
			foreach ($data['product_image'] as $product_image) {
			    $sql="INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int)$product_id . "', image = '" . $this->db->escape(html_entity_decode($product_image['image'], ENT_QUOTES, 'UTF-8')) . "', sort_order = '" . (int)$product_image['sort_order'] . "'";
				$this->db->query($sql);
			}
		}
		
		if (isset($data['product_download'])) {
			foreach ($data['product_download'] as $download_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_download SET product_id = '" . (int)$product_id . "', download_id = '" . (int)$download_id . "'");
			}
		}
		
		if (isset($data['product_category'])) {
			foreach ($data['product_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$category_id . "'");
				$this->db->query("REPLACE INTO " . DB_PREFIX . "category_to_store SET category_id = '" . (int)$category_id . "', store_id = '" . (int)$data['product_store'] . "'");
			}
		}
		
		if (isset($data['product_related'])) {
			foreach ($data['product_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id = '" . (int)$product_id . "', related_id = '" . (int)$related_id . "'");
			}
		}

		if (isset($data['product_reward'])) {
			foreach ($data['product_reward'] as $customer_group_id => $product_reward) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_reward SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$customer_group_id . "', points = '" . (int)$product_reward['points'] . "'");
			}
		}

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product_id=" . (int)$product_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
						
		$this->cache->delete('product');
	}
	
	
	/**
	* 保存
	*/
	public function editProduct($product_id, $data) {
   
	    $time=time();
		$this->db->query("UPDATE " . DB_PREFIX . "product SET model = '" . $this->db->escape($data['model']) . "', sku = '" . $this->db->escape($data['sku']) . "', upc = '" . $this->db->escape($data['upc'])  . "', location = '" . $this->db->escape($data['location']) . "', quantity = '" . (int)$data['quantity'] . "', minimum = '" . (int)$data['minimum'] . "', subtract = '" . (int)$data['subtract'] . "', stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . strtotime($this->db->escape($data['date_available'])) . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', points = '" . (int)$data['points'] . "', weight = '" . (float)$data['weight'] . "', weight_class_id = '" . (int)$data['weight_class_id'] . "', length = '" . (float)$data['length'] . "', width = '" . (float)$data['width'] . "', height = '" . (float)$data['height'] . "', length_class_id = '" . (int)$data['length_class_id'] . "', status = '" . (int)$data['status']  . "', sort_order = '" . (int)$data['sort_order'] . "', date_modified ={$time} WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "product SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE product_id = '" . (int)$product_id . "'");
		}
		
		//$this->db->query("DELETE FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$product_id . "'");
		
		
		$value=$data['product_description'];
		if(!empty($value)) {
			$this->db->query("update " . DB_PREFIX . "product_description SET  name = '" . $this->db->escape($value['name']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "', tag = '" . $this->db->escape($value['tag']) . "' where product_id = '" . (int)$product_id  . "'");
		} 

		//$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_store WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_store'])) {
		  
			$store_id=$data['product_store'];
			$this->db->query("update " . DB_PREFIX . "product_to_store SET  store_id = '" . (int)$store_id . "' where product_id = '" . (int)$product_id . "'");

		}
	
		
        
		//====编辑属性begin===
		$this->load->model('catalog/attribute');
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "'");
		$comma='|';
		$separtor='';
		$sql='';
		$product_attribute_id='';
		/* 
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "'");
		
		$comma='|';
		$separtor='';
		$sql='';
		$product_attribute_description='';
		$product_attribute_id='';
		

		if (!empty($data['product_attribute'])) {
			foreach ($data['product_attribute'] as $key=>$product_attribute) {
				if (!empty($product_attribute['attribute_id'])) {
				    $attribute_id=trim($product_attribute['attribute_id']);
					$product_attribute_id .=$comma;
					$product_attribute_id .="{$attribute_id}";
					
					$product_attribute_description .=$separtor;
					$product_attribute_description .=trim($product_attribute['text']);
					$separtor='&&';
						
					
				}
				
			}
	
			$sql.=" product_id = '" . (int)$product_id . "'";
			
            $s=preg_replace('/|/','',$product_attribute_id);
			if(!empty($s)) $sql.=", `attribute_id`='{$product_attribute_id}".$comma."'";

			
			$s=preg_replace('/&&/','',$product_attribute_description);
			if(!empty($s)) $sql.=" ,`text`='{$product_attribute_description}'";
			
		    
			$this->db->query("insert into ".DB_PREFIX."product_attribute set ".$sql  );
		}
		*/
        //====编辑属性end===
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_option_value WHERE product_id = '" . (int)$product_id . "'");
		
		if (isset($data['product_option'])) {
			foreach ($data['product_option'] as $product_option) {
				if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_option_id = '" . (int)$product_option['product_option_id'] . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', attribute_group_id = '" . (int)$product_option['attribute_group_id'] . "', required = '" . (int)$product_option['required'] . "'");
				
					$product_option_id = $this->db->getLastId();
				    
					if (isset($product_option['product_option_value'])) {
						foreach ($product_option['product_option_value'] as $product_option_value) {
						    $option_value_attribute_id=array();
							$option_value_attribute_id=explode(',',$product_option_value['option_value_id']);
						
							$option_value_id = $option_value_attribute_id[0];
							$attribute_id    = $option_value_attribute_id[1];
							$this->db->query("INSERT INTO " . DB_PREFIX . "product_option_value SET product_option_value_id = '" . (int)$product_option_value['product_option_value_id'] . "', product_option_id = '" . (int)$product_option_id . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', option_value_id = '" . (int)$option_value_id . "', quantity = '" . (int)$product_option_value['quantity'] . "', subtract = '" . (int)$product_option_value['subtract'] . "', price = '" . (float)$product_option_value['price'] . "', price_prefix = '" . $this->db->escape($product_option_value['price_prefix']) . "', points = '" . (int)$product_option_value['points'] . "', points_prefix = '" . $this->db->escape($product_option_value['points_prefix']) . "', weight = '" . (float)$product_option_value['weight'] . "', weight_prefix = '" . $this->db->escape($product_option_value['weight_prefix']) . "'");
						    
							//=================编辑属性开始=================
							//if (!empty($product_option_value['attribute_id'])) {
							if(!empty($attribute_id)){
								//$attribute_id=trim($product_option_value['attribute_id']);
								$product_attribute_id .=$comma;
								$product_attribute_id .="{$attribute_id}";
								
								//$product_attribute_description .=$separtor;
								//$product_attribute_description .=trim($product_option_value['text']);
								//$separtor='&&';
										
							}
							//=================编辑属性结束==================
						}
						
					}
				} else { 
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_option_id = '" . (int)$product_option['product_option_id'] . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', option_value = '" . $this->db->escape($product_option['option_value']) . "', required = '" . (int)$product_option['required'] . "'");
				}					
			}
			
			//=============编辑属性开始===================
			$sql.=" product_id = '" . (int)$product_id . "'";
					
			$s=preg_replace('/|/','',$product_attribute_id);
			if(!empty($s)) $sql.=", `attribute_id`='{$product_attribute_id}".$comma."'";

			//$s=preg_replace('/&&/','',$product_attribute_description);
			//if(!empty($s)) $sql.=" ,`text`='{$product_attribute_description}'";
			
			
			$this->db->query("insert into ".DB_PREFIX."product_attribute set ".$sql  );
			
								
			//=============编辑属性结束=================
		} 
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "'");
 
		if (isset($data['product_discount'])) {
			foreach ($data['product_discount'] as $product_discount) {
			    $date_start=strtotime($this->db->escape($product_discount['date_start']));
				$date_end=strtotime($this->db->escape($product_discount['date_end']));
				
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_discount SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$product_discount['customer_group_id'] . "', quantity = '" . (int)$product_discount['quantity'] . "', priority = '" . (int)$product_discount['priority'] . "', price = '" . (float)$product_discount['price'] . "', date_start = '{$date_start}', date_end = '{$date_end}'");
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "'");
		
		if (isset($data['product_special'])) {
			foreach ($data['product_special'] as $product_special) {
			    $date_start=strtotime($this->db->escape($product_special['date_start']));
				$date_end=strtotime($this->db->escape($product_special['date_end']));
				
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$product_special['customer_group_id'] . "', priority = '" . (int)$product_special['priority'] . "', price = '" . (float)$product_special['price'] . "', date_start = '{$date_start}', date_end = '{$date_end}'");
			}
		}
		
		//$this->db->query("DELETE FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "'");
		$pimage=array();
		foreach($data['product_image'] as $v2){ //表单返回的图片
		   $pimage[]=$v2['product_image_id'];
		}
		$product_images=$this->getProductImages((int)$product_id); //原有的图片
		foreach($product_images as $v){
		    $strimageid=$v['product_image_id'];
			if(!in_array($strimageid,$pimage)){
		        $this->db->query("delete from " . DB_PREFIX . "product_image where product_image_id='".(int)$strimageid."'");
			}
		}
        	
		if (isset($data['product_image'])) {
			foreach ($data['product_image'] as $product_image) {
			    if(!empty($product_image['product_image_id'])){
				    $this->db->query("update " . DB_PREFIX . "product_image set  image = '" . $this->db->escape(html_entity_decode($product_image['image'], ENT_QUOTES, 'UTF-8')) . "', sort_order = '" . (int)$product_image['sort_order'] . "',date_modified='{$time}' where  product_image_id = '" . (int)$product_image['product_image_id'] . "'");	
				}else{
				    $this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int)$product_id . "', image = '" . $this->db->escape(html_entity_decode($product_image['image'], ENT_QUOTES, 'UTF-8')) . "', sort_order = '" . (int)$product_image['sort_order'] . "',flag=2,date_added='{$time}'");
			    }
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_download WHERE product_id = '" . (int)$product_id . "'");
		
		if (isset($data['product_download'])) {
			foreach ($data['product_download'] as $download_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_download SET product_id = '" . (int)$product_id . "', download_id = '" . (int)$download_id . "'");
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");
		
		if (isset($data['product_category'])) {
			foreach ($data['product_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$category_id . "'");
			    $this->db->query("REPLACE INTO " . DB_PREFIX . "category_to_store SET category_id = '" . (int)$category_id . "', store_id = '" . (int)$data['product_store'] . "'");
			}		
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE related_id = '" . (int)$product_id . "'");
        
		//$data['product_related'][]=$data['related'];
		if (isset($data['product_related'])) {
			foreach ($data['product_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$related_id . "' AND related_id = '" . (int)$product_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id = '" . (int)$related_id . "', related_id = '" . (int)$product_id . "'");
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_reward WHERE product_id = '" . (int)$product_id . "'");

		if (isset($data['product_reward'])) {
			foreach ($data['product_reward'] as $customer_group_id => $value) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_reward SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$customer_group_id . "', points = '" . (int)$value['points'] . "'");
			}
		}

	
						
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_id. "'");
		
		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product_id=" . (int)$product_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
						
		$this->cache->delete('product');
	}
	
	public function copyProduct($product_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int)$product_id . "'");
		
		if ($query->num_rows) {
			$data = array();
			
			$data = $query->row;
			
			$data['sku'] = '';
			$data['upc'] = '';
			$data['viewed'] = '0';
			$data['keyword'] = '';
			$data['status'] = '0';
						
			$data = array_merge($data, array('product_attribute' => $this->getProductAttributes($product_id)));
			$data = array_merge($data, array('product_description' => $this->getProductDescriptions($product_id)));			
			$data = array_merge($data, array('product_discount' => $this->getProductDiscounts($product_id)));
			$data = array_merge($data, array('product_image' => $this->getProductImages($product_id)));		
			$data = array_merge($data, array('product_option' => $this->getProductOptions($product_id)));
			$data = array_merge($data, array('product_related' => $this->getProductRelated($product_id)));
			$data = array_merge($data, array('product_reward' => $this->getProductRewards($product_id)));
			$data = array_merge($data, array('product_special' => $this->getProductSpecials($product_id)));
			$data = array_merge($data, array('product_category' => $this->getProductCategories($product_id)));
			$data = array_merge($data, array('product_download' => $this->getProductDownloads($product_id)));
			$data = array_merge($data, array('product_layout' => $this->getProductLayouts($product_id)));
			$data = array_merge($data, array('product_store' => $this->getProductStores($product_id)));
			
			$this->addProduct($data);
		}
	}
	
	public function deleteProduct($product_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_option_value WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE related_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_reward WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_download WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_layout WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_store WHERE product_id = '" . (int)$product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "review WHERE product_id = '" . (int)$product_id . "'");
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_id. "'");
		
		$this->cache->delete('product');
	}
	
	public function getProduct($product_id) {
		 $query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_id . "') AS keyword FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int)$product_id . "'");
				
		return $query->row;
	}
	
	public function getProducts($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)";
			
			if (!empty($data['filter_category_id'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id)";			
			}
					
		    $sql .= " WHERE 1"; 
			
			if (!empty($data['filter_id'])) {
				$sql .= " AND LCASE(p.product_id) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_id'])) . "%'";
			}
			
			
			
			if (!empty($data['filter_name'])) {
				$sql .= " AND LCASE(pd.name) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
			}

			if (!empty($data['filter_model'])) {
				$sql .= " AND LCASE(p.model) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_model'])) . "%'";
			}
			
			if (!empty($data['filter_price'])) {
				$sql .= " AND p.price LIKE '" . $this->db->escape($data['filter_price']) . "%'";
			}
			
			/* if (isset($data['filter_quantity']) && !is_null($data['filter_quantity']) && $data['filter_quantity']!='') {
				$sql .= " AND p.quantity = '" . $this->db->escape($data['filter_quantity']) . "'";
			} */
			
			if (isset($data['filter_status']) && !is_null($data['filter_status']) && $data['filter_status']!='') {
				$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
			}
			    
					
			if (!empty($data['filter_category_id'])) {
				if (!empty($data['filter_sub_category'])) {
					$implode_data = array();
					
					$implode_data[] = "category_id = '" . (int)$data['filter_category_id'] . "'";
					
					$this->load->model('catalog/category');
					
					$pid=array('pid'=>$data['filter_category_id']);
					$categories = $this->model_catalog_category->getCategories($pid);
					
					foreach ($categories as $category) {
						$implode_data[] = "p2c.category_id = '" . (int)$category['category_id'] . "'";
					}
					
					$sql .= " AND (" . implode(' OR ', $implode_data) . ")";			
				} else {
					$sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
				}
			}
			
			$sql .= " GROUP BY p.product_id";
						
			$sort_data = array(
			    'p.product_id',
				'pd.name',
				'p.model',
				'p.price',
				'p.quantity',
				'p.status',
				'p.sort_order'
			);	
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY pd.name";	
			}
			
			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
			}elseif (isset($data['order']) && ($data['order'] == 'ASC')) {
			    $sql .= " ASC";
			}else {
				$sql .= " ASC";
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
		
			return $query->rows;
		} else {
			$product_data = $this->cache->get('product.'  . (int)$this->config->get('config_store_id'));
		
			if (!$product_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)  ORDER BY pd.name ASC");
	
				$product_data = $query->rows;
			
				$this->cache->set('product.'  . (int)$this->config->get('config_store_id'), $product_data);
			}	
	
			return $product_data;
		}
	}
	
	public function getProductsByCategoryId($category_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) WHERE  p2c.category_id = '" . (int)$category_id . "' ORDER BY pd.name ASC");
								  
		return $query->rows;
	} 
	
	/**
	*  产品描述
	*/
	public function getProductDescriptions($product_id) {
		$result = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$product_id . "'");
		
		$result=$query->row;

		return $result;
	}

	public function getProductAttributes($product_id) {
		$product_attribute_data = array();
		$this->load->model('catalog/attribute');
		
		$product_attribute_query = $this->db->query("SELECT pa.attribute_id,pa.text FROM " . DB_PREFIX . "product_attribute pa  WHERE pa.product_id = '" . (int)$product_id . "'");
        $product_attribute=$product_attribute_query->row;
		if(empty($product_attribute)) return;
	    
		$attribute_id=array();
		$attribute_id=explode('|',$product_attribute['attribute_id']);
		
		//删除数组最前和最后一个空值
		array_pop($attribute_id);
		array_shift($attribute_id);
		
		/*
		if(!empty($product_attribute['a_id1'])) $a_id1=$this->model_catalog_attribute->getAttributeDescriptions($product_attribute['a_id1']);
		if(!empty($product_attribute['a_id2'])) $a_id2=$this->model_catalog_attribute->getAttributeDescriptions($product_attribute['a_id2']);
		if(!empty($product_attribute['a_id3'])) $a_id3=$this->model_catalog_attribute->getAttributeDescriptions($product_attribute['a_id3']);
		if(!empty($product_attribute['a_id4'])) $a_id4=$this->model_catalog_attribute->getAttributeDescriptions($product_attribute['a_id4']);
		if(!empty($product_attribute['a_id5'])) $a_id5=$this->model_catalog_attribute->getAttributeDescriptions($product_attribute['a_id5']);
		if(!empty($product_attribute['a_id6'])) $a_id6=$this->model_catalog_attribute->getAttributeDescriptions($product_attribute['a_id6']);
		if(!empty($product_attribute['a_id7'])) $a_id7=$this->model_catalog_attribute->getAttributeDescriptions($product_attribute['a_id7']);
		if(!empty($product_attribute['a_id8'])) $a_id8=$this->model_catalog_attribute->getAttributeDescriptions($product_attribute['a_id8']);
		if(!empty($product_attribute['a_id9'])) $a_id9=$this->model_catalog_attribute->getAttributeDescriptions($product_attribute['a_id9']);
		if(!empty($product_attribute['a_id0'])) $a_id0=$this->model_catalog_attribute->getAttributeDescriptions($product_attribute['a_id0']);
        */
		
		//描述字段属性用 &&  分隔 text字段
		$text=array();
		if(!empty($product_attribute['text'])) $text=explode('&&',$product_attribute['text']);
		
		if(!empty($attribute_id)){
		    foreach($attribute_id as $k=>$v){
				$product_attribute_data[] = array(
					'attribute_id'   => $v,
					'attribute_group'=>$this->model_catalog_attribute->getAttribute($v),
					'name'           => $this->model_catalog_attribute->getAttributeDescriptions($v),
					'text'           => isset($text[$k])?$text[$k]:''
				);
			}
		}
		
		/*
		if(!empty($product_attribute['a_id1'])){
			$product_attribute_data[] = array(
				'attribute_id' => $product_attribute['a_id1'],
				'attribute_group'=>$this->model_catalog_attribute->getAttribute($product_attribute['a_id1']),
				'name'         => $a_id1,
				'text'         => isset($text[0])?$text[0]:''
			);
		}

		if(!empty($product_attribute['a_id2'])){
			$product_attribute_data[] = array(
				'attribute_id' => $product_attribute['a_id2'],
				'attribute_group'=>$this->model_catalog_attribute->getAttribute($product_attribute['a_id2']),
				'name'         => $a_id2,
				'text'         => isset($text[1])?$text[1]:''
			);
		}
		
		if(!empty($product_attribute['a_id3'])){
			$product_attribute_data[] = array(
				'attribute_id' => $product_attribute['a_id3'],
				'attribute_group'=>$this->model_catalog_attribute->getAttribute($product_attribute['a_id3']),
				'name'         => $a_id3,
				'text'         => isset($text[2])?$text[2]:''
			);
		}
		
		if(!empty($product_attribute['a_id4'])){
			$product_attribute_data[] = array(
				'attribute_id' => $product_attribute['a_id4'],
				'attribute_group'=>$this->model_catalog_attribute->getAttribute($product_attribute['a_id4']),
				'name'         => $a_id4,
				'text'         => isset($text[3])?$text[3]:''
			);
		}
		
		if(!empty($product_attribute['a_id5'])){
			$product_attribute_data[] = array(
				'attribute_id' => $product_attribute['a_id5'],
				'attribute_group'=>$this->model_catalog_attribute->getAttribute($product_attribute['a_id5']),
				'name'         => $a_id5,
				'text'         => isset($text[4])?$text[4]:''
			);
		}
		
		if(!empty($product_attribute['a_id6'])){
			$product_attribute_data[] = array(
				'attribute_id' => $product_attribute['a_id6'],
				'attribute_group'=>$this->model_catalog_attribute->getAttribute($product_attribute['a_id6']),
				'name'         => $a_id6,
				'text'         => isset($text[5])?$text[5]:''
			);
		}
		
		if(!empty($product_attribute['a_id7'])){
			$product_attribute_data[] = array(
				'attribute_id' => $product_attribute['a_id7'],
				'attribute_group'=>$this->model_catalog_attribute->getAttribute($product_attribute['a_id7']),
				'name'         => $a_id7,
				'text'         => isset($text[6])?$text[6]:''
			);
		}
		
		if(!empty($product_attribute['a_id8'])){
			$product_attribute_data[] = array(
				'attribute_id' => $product_attribute['a_id8'],
				'attribute_group'=>$this->model_catalog_attribute->getAttribute($product_attribute['a_id8']),
				'name'         => $a_id8,
				'text'         => isset($text[7])?$text[7]:''
			);
		}
		
		if(!empty($product_attribute['a_id9'])){
			$product_attribute_data[] = array(
				'attribute_id' => $product_attribute['a_id9'],
				'attribute_group'=>$this->model_catalog_attribute->getAttribute($product_attribute['a_id9']),
				'name'         => $a_id9,
				'text'         => isset($text[8])?$text[8]:''
			);
		}
		
		if(!empty($product_attribute['a_id0'])){
			$product_attribute_data[] = array(
				'attribute_id' => $product_attribute['a_id0'],
				'attribute_group'=>$this->model_catalog_attribute->getAttribute($product_attribute['a_id0']),
				'name'         => $a_id0,
				'text'         => isset($text[9])?$text[9]:''
			);
		}
		*/
		
		return $product_attribute_data;
	}
	
	public function getProductOptions($product_id) {
		$product_option_data = array();
		
		//"SELECT * FROM " . DB_PREFIX . "product_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.product_id = '" . (int)$product_id . "' ORDER BY o.sort_order"
		$sql="SELECT po.product_option_id,o.option_id,od.name ,o.`type`,po.option_value,po.required,agd.attribute_group_id,agd.name as attribute_group_name FROM " . DB_PREFIX . "product_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) left join ".DB_PREFIX."attribute_group_description agd on po.attribute_group_id=agd.attribute_group_id WHERE po.product_id = '" . (int)$product_id  . "' ORDER BY o.sort_order";
		$product_option_query = $this->db->query($sql);
		
		foreach ($product_option_query->rows as $product_option) {
			if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
				$product_option_value_data = array();	
				
				$product_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_id = '" . (int)$product_option['product_option_id']  . "' ORDER BY ov.sort_order");
				foreach ($product_option_value_query->rows as $product_option_value) {
					$product_option_value_data[] = array(
						'product_option_value_id' => $product_option_value['product_option_value_id'],
						'option_value_id'         => $product_option_value['option_value_id'],
						'attribute_id'            => $product_option_value['attribute_id'],
						'name'                    => $product_option_value['name'],//属性名称
						'image'                   => $product_option_value['image'],
						'quantity'                => $product_option_value['quantity'],
						'subtract'                => $product_option_value['subtract'],
						'price'                   => $product_option_value['price'],
						'price_prefix'            => $product_option_value['price_prefix'],
						'points'                  => $product_option_value['points'],
						'points_prefix'           => $product_option_value['points_prefix'],						
						'weight'                  => $product_option_value['weight'],
						'weight_prefix'           => $product_option_value['weight_prefix']					
					);
				}
				
				$product_option_data[] = array(
					'product_option_id'    => $product_option['product_option_id'],
					'option_id'            => $product_option['option_id'],
					'name'                 => $product_option['name'],//选项名称如select ,checkbox,radio
					'attribute_group_id'   => $product_option['attribute_group_id'],
					'attribute_group_name' => isset($product_option['attribute_group_name'])?$product_option['attribute_group_name']:'',
					'type'                 => $product_option['type'],
					'product_option_value' => $product_option_value_data,
					'required'             => $product_option['required']
				);				
			} else {
				$product_option_data[] = array(
					'product_option_id' => $product_option['product_option_id'],
					'option_id'         => $product_option['option_id'],
					'name'              => $product_option['name'],
					//'attribute_group_name' => isset($product_option['attribute_group_name'])?$product_option['attribute_group_name']:'',
					'type'              => $product_option['type'],
					'option_value'      => $product_option['option_value'],
					'required'          => $product_option['required']
				);				
			}
		}	
		
		return $product_option_data;
	}
	
	public function getProductImages($product_id) {
		$query = $this->db->query("SELECT product_image_id,image,sort_order,date_added,flag FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "'");
		
		return $query->rows;
	}
	
	public function getProductDiscounts($product_id) {
	    $data=array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "' ORDER BY quantity, priority, price");
		if($query->num_rows<0)  return;

		foreach($query->rows as $v){
		    $v['date_start']=date('Y-m-d',$v['date_start']);
			$v['date_end']  =date('Y-m-d',$v['date_end']);
			
			$data[]=$v;
		}
		return $data;
	}
	
	public function getProductSpecials($product_id) {
	    $data=array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "' ORDER BY priority, price");
		if($query->num_rows<0)  return;
		
		foreach($query->rows as $v){
		    $v['date_start']=date('Y-m-d',$v['date_start']);
			$v['date_end']  =date('Y-m-d',$v['date_end']);
			
			$data[]=$v;
		}
		return $data;
	}
	
	public function getProductRewards($product_id) {
		$product_reward_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_reward WHERE product_id = '" . (int)$product_id . "'");
		
		foreach ($query->rows as $result) {
			$product_reward_data[$result['customer_group_id']] = array('points' => $result['points']);
		}
		
		return $product_reward_data;
	}
		
	public function getProductDownloads($product_id) {
		$product_download_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_download WHERE product_id = '" . (int)$product_id . "'");
		
		foreach ($query->rows as $result) {
			$product_download_data[] = $result['download_id'];
		}
		
		return $product_download_data;
	}

	public function getProductStores($product_id) {
		$product_store_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_store WHERE product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $result) {
			$product_store_data[] = $result['store_id'];
		}
		
		return $product_store_data;
	}

	public function getProductLayouts($product_id) {
		$product_layout_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_layout WHERE product_id = '" . (int)$product_id . "'");
		
		foreach ($query->rows as $result) {
			$product_layout_data[$result['store_id']] = $result['layout_id'];
		}
		
		return $product_layout_data;
	}
	
    /**依据产品取对应的类*/
	public function getProductCategories($product_id) {
		$product_category_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");
		
		foreach ($query->rows as $result) {
			$product_category_data[] = $result['category_id'];
		}

		return $product_category_data;
	}

	public function getProductRelated($product_id) {
		$product_related_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "'");
		
		foreach ($query->rows as $result) {
			$product_related_data[] = $result['related_id'];
		}
		
		return $product_related_data;
	}
	
	/**
	* 指定条件下产品 的列表
	*/
	public function getTotalProducts($data = array()) {
		$sql = "SELECT COUNT(DISTINCT p.product_id) AS total FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)";

		if (!empty($data['filter_category_id'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id)";			
		}
		 
		$sql .= " WHERE 1";
		
        if (!empty($data['filter_id'])) {
			$sql .= " AND LCASE(p.product_id) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_id'])) . "%'";
		}		
					
		if (!empty($data['filter_name'])) {
			$sql .= " AND LCASE(pd.name) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
		}

		if (!empty($data['filter_model'])) {
			$sql .= " AND LCASE(p.model) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_model'])) . "%'";
		}
		
		if (!empty($data['filter_price'])) {
			$sql .= " AND p.price LIKE '" . $this->db->escape($data['filter_price']) . "%'";
		}
		
		if (isset($data['filter_quantity']) && !is_null($data['filter_quantity']) && $data['filter_quantity']!='') {
			$sql .= " AND p.quantity = '" . $this->db->escape($data['filter_quantity']) . "'";
		}
		
		if (isset($data['filter_status']) && !is_null($data['filter_status']) && $data['filter_status']!='') {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}
      
		if (!empty($data['filter_category_id'])) { //类下包括的所有子类
			if (!empty($data['filter_sub_category'])) {
				$implode_data = array();
				
				$implode_data[] = "p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
				
				$this->load->model('catalog/category');
				
				$pid=array('pid'=>$data['filter_category_id']);
				$categories = $this->model_catalog_category->getCategories($pid);
				
				if(!empty($categories)){
					foreach ($categories as $category) {
						$implode_data[] = "p2c.category_id = '" . (int)$category['category_id'] . "'";
					}
				}
				
				$sql .= " AND (" . implode(' OR ', $implode_data) . ")";			
			} else {
				$sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
			}
		}
	    
		$query = $this->db->query($sql);
		
		return $query->row['total'];
	}	
	
	public function getTotalProductsByTaxClassId($tax_class_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE tax_class_id = '" . (int)$tax_class_id . "'");

		return $query->row['total'];
	}
		
	public function getTotalProductsByStockStatusId($stock_status_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE stock_status_id = '" . (int)$stock_status_id . "'");

		return $query->row['total'];
	}
	
	public function getTotalProductsByWeightClassId($weight_class_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE weight_class_id = '" . (int)$weight_class_id . "'");

		return $query->row['total'];
	}
	
	public function getTotalProductsByLengthClassId($length_class_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE length_class_id = '" . (int)$length_class_id . "'");

		return $query->row['total'];
	}

	public function getTotalProductsByDownloadId($download_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_to_download WHERE download_id = '" . (int)$download_id . "'");
		
		return $query->row['total'];
	}
	
	public function getTotalProductsByManufacturerId($manufacturer_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");

		return $query->row['total'];
	}
	
	public function getTotalProductsByAttributeId($attribute_id) {
	    //find_in_set只支持逗号分隔的字符（only used in the string of split by comma)
	    $sql="SELECT product_id FROM " . DB_PREFIX . "product_attribute WHERE find_in_set('{$attribute_id}',replace(attribute_id,'|',','))";
		
		$query = $this->db->query($sql);

		return $query->rows;
	}	
	
	public function getTotalProductsByOptionId($option_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_option WHERE option_id = '" . (int)$option_id . "'");

		return $query->row['total'];
	}	
	
	public function getTotalProductsByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}
}
?>