<?php
class ModelCatalogProduct extends Model {
	public function updateViewed($product_id) {
	    if(!empty($product_id)){
			$this->db->query("UPDATE " . DB_PREFIX . "product SET viewed = (viewed + 1) WHERE product_id = '" . (int)$product_id . "'");
	    }
	}
	
	public function getProduct($product_id,$status=1) {
	    $time=time();
	
		/* if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		} */	
		
		$special=array();
		$sql="SELECT date_start,date_end,price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id='".(int)$product_id . "' AND  ps.date_start <'$time' AND  ps.date_end >'$time' ORDER BY ps.priority ASC, ps.price ASC LIMIT 1";//."' and  ps.customer_group_id = '" . (int)$customer_group_id 只有登录的情况下出现的bug
		$query_=$this->db->query($sql);
		if($query_->num_rows>0){
			$query_->row['date_start']=date('Y-m-d',($query_->row['date_start']));
			$query_->row['date_end']  =date('Y-m-d',($query_->row['date_end']));
			$special=$query_->row;
		}
		
		
		//(SELECT wcd.unit FROM " . DB_PREFIX . "weight_class_description wcd WHERE p.weight_class_id = wcd.weight_class_id ) AS weight_class,
        $sql="SELECT  p.*,pd.meta_keyword,pd.description,pd.meta_description, pd.name AS name, p.image, m.name AS manufacturer, (SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id  AND pd2.quantity ='1' and  pd2.date_start <'$time' AND  pd2.date_end >'$time'  ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount,  (SELECT points FROM " . DB_PREFIX . "product_reward pr WHERE pr.product_id = p.product_id ) AS reward, (SELECT ss.name FROM " . DB_PREFIX . "stock_status ss WHERE ss.stock_status_id = p.stock_status_id ) AS stock_status,  (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, (SELECT COUNT(*) AS total FROM " . DB_PREFIX . "review r2 WHERE r2.product_id = p.product_id AND r2.status = '1' GROUP BY r2.product_id) AS reviews, p.sort_order FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) WHERE p.product_id = '" . (int)$product_id  . "'";		
	    
		if($status==1){
		    $sql .= " AND p.date_available>={$time} AND p.status = '1' ";
	    }else{
		    $sql .=" AND p.status='{$status}'";
		}
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows) {
			return array(
				'product_id'       => $query->row['product_id'],
                'store_id'         => $query->row['store_id'],
				'name'             => $query->row['name'], 
				'description'      => html_entity_decode($query->row['description'], ENT_QUOTES, 'UTF-8'),
				'meta_description' => $query->row['meta_description'],
				'meta_keyword'     => $query->row['meta_keyword'],
				'tag'              => $query->row['tag'],
				'model'            => $query->row['model'],
				'sku'              => $query->row['sku'],
				'upc'              => $query->row['upc'],
				'location'         => $query->row['location'],
				'quantity'         => $query->row['quantity'],
				'stock_status'     => $query->row['stock_status'],
				'image'            => $query->row['image'],
				'manufacturer_id'  => $query->row['manufacturer_id'],
				'manufacturer'     => $query->row['manufacturer'],
				'price'            => ($query->row['discount'] ? $query->row['discount'] : $query->row['price']),
				'special'          => $special,
				'reward'           => $query->row['reward'],
				'points'           => $query->row['points'],
				'date_available'   => $query->row['date_available'],
				'weight'           => $query->row['weight'],
				'weight_class_id'  => $query->row['weight_class_id'],
				'length'           => $query->row['length'],
				'width'            => $query->row['width'],
				'height'           => $query->row['height'],
				'shipping'         => $query->row['shipping'],
				'subtract'         => $query->row['subtract'],
				'rating'           => round($query->row['rating']),
				'reviews'          => $query->row['reviews'],
				'minimum'          => $query->row['minimum'],
				'sort_order'       => $query->row['sort_order'],
				'status'           => $query->row['status'],
				'date_added'       => $query->row['date_added'],
				'date_modified'    => $query->row['date_modified'],
				'viewed'           => $query->row['viewed']
			);
		} else {
			return false;
		}
	}
    
    public function getStore($store_id)
    {
        $query = $this->db->query("SELECT * from store where store_id = " . $store_id);

		return $query->row;
    }

	public function getProducts($data = array()) {
	    $time=time();
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}	
		
		$cache = md5(http_build_query($data));
		
		$product_data = $this->cache->get('product' . (int)$this->config->get('config_store_id') . '.' . (int)$customer_group_id . '.' . $cache);
		
		if (!$product_data) {
			$sql = "SELECT p.product_id, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)"; // LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id)
						
			if (!empty($data['filter_category_id'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id)";			
			}
			
			$sql .= " WHERE  p.status = '1' "; //AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'
			
			if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
				$sql .= " AND (";
				
				if (!empty($data['filter_name'])) {					
					if (!empty($data['filter_description'])) {
						$sql .= "LCASE(pd.name) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%' OR MATCH(pd.description) AGAINST('" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "')";
					} else {
						$sql .= "LCASE(pd.name) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
					}
				}
				
				if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
					$sql .= " OR ";
				}
				
				if (!empty($data['filter_tag'])) {
					$sql .= "MATCH(pd.tag) AGAINST('" . $this->db->escape(utf8_strtolower($data['filter_tag'])) . "')";
				}
			
				$sql .= ")";
				
				if (!empty($data['filter_name'])) {
					$sql .= " OR LCASE(p.model) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				}
				
				if (!empty($data['filter_name'])) {
					$sql .= " OR LCASE(p.sku) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				}	
				
				if (!empty($data['filter_name'])) {
					$sql .= " OR LCASE(p.upc) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				}		

				/*if (!empty($data['filter_name'])) {
					$sql .= " OR LCASE(p.ean) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				}

				if (!empty($data['filter_name'])) {
					$sql .= " OR LCASE(p.jan) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				}
				
				if (!empty($data['filter_name'])) {
					$sql .= " OR LCASE(p.isbn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				}		
				
				if (!empty($data['filter_name'])) {
					$sql .= " OR LCASE(p.mpn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				}	*/				
			}
			
			if (!empty($data['filter_category_id'])) {
				if (!empty($data['filter_sub_category'])) {
					$implode_data = array();
					
					$implode_data[] = (int)$data['filter_category_id'];
					
					$this->load->model('catalog/category');
					
					$categories = $this->model_catalog_category->getCategoriesByParentId($data['filter_category_id']);
										
					foreach ($categories as $category_id) {
						$implode_data[] = (int)$category_id;
					}
								
					$sql .= " AND p2c.category_id IN (" . implode(', ', $implode_data) . ")";			
				} else {
					$sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
				}
			}		
					
			if (!empty($data['filter_manufacturer_id'])) {
				$sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer_id'] . "'";
			}
			
			$sql .= " GROUP BY p.product_id";
			
			$sort_data = array(
				'pd.name',
				'p.model',
				'p.quantity',
				'p.price',
				'rating',
				'p.sort_order',
				'p.date_added'
			);	
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
					$sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
				} else {
					$sql .= " ORDER BY " . $data['sort'];
				}
			} else {
				$sql .= " ORDER BY p.sort_order";	
			}
			
			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC, LCASE(pd.name) DESC";
			} else {
				$sql .= " ASC, LCASE(pd.name) ASC";
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
			
			$product_data = array();
					
			$query = $this->db->query($sql);
		
			foreach ($query->rows as $result) {
				$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
			}
			
			$this->cache->set('product'  . (int)$this->config->get('config_store_id') . '.' . (int)$customer_group_id . '.' . $cache, $product_data);
		}
		
		return $product_data;
	}
	
	public function getProductSpecials($data = array()) {
	    $time=time();
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}	
				
		$sql = "SELECT DISTINCT ps.product_id, (SELECT AVG(rating) FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = ps.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating FROM " . DB_PREFIX . "product_special ps LEFT JOIN " . DB_PREFIX . "product p ON (ps.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= {$time}  AND ps.customer_group_id = '" . (int)$customer_group_id . "' AND ps.date_start < {$time} AND ps.date_end >{$time} GROUP BY ps.product_id";

		$sort_data = array(
			'pd.name',
			'p.model',
			'ps.price',
			'rating',
			'p.sort_order'
		);
		
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
				$sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
			} else {
				$sql .= " ORDER BY " . $data['sort'];
			}
		} else {
			$sql .= " ORDER BY p.sort_order";	
		}
		
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC, LCASE(pd.name) DESC";
		} else {
			$sql .= " ASC, LCASE(pd.name) ASC";
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

		$product_data = array();
		
		$query = $this->db->query($sql);
		
		foreach ($query->rows as $result) { 		
			$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
		}
		
		return $product_data;
	}
		
	public function getLatestProducts($limit) {
	    $time=time();
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}	
				
		$product_data = $this->cache->get('product.latest' . $customer_group_id . '.' . (int)$limit);

		if (!$product_data) { 
			$query = $this->db->query("SELECT p.product_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= {$time}  ORDER BY p.date_added DESC LIMIT " . (int)$limit);
		 	 
			foreach ($query->rows as $result) {
				$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
			}
			
			$this->cache->set('product.latest'  . $customer_group_id . '.' . (int)$limit, $product_data);
		}
		
		return $product_data;
	}
	
	public function getPopularProducts($limit) {
	    $time=time();
		$product_data = array();
		
		$query = $this->db->query("SELECT p.product_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= {$time}  ORDER BY p.viewed, p.date_added DESC LIMIT " . (int)$limit);
		
		foreach ($query->rows as $result) { 		
			$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
		}
					 	 		
		return $product_data;
	}

	public function getBestSellerProducts($limit) {
	    $time=time();
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}	
				
		$product_data = $this->cache->get('product.bestseller' . (int)$this->config->get('config_store_id'). '.' . $customer_group_id . '.' . (int)$limit);

		if (!$product_data) { 
			$product_data = array();
			
			$query = $this->db->query("SELECT op.product_id, COUNT(*) AS total FROM " . DB_PREFIX . "order_product op LEFT JOIN `" . DB_PREFIX . "order` o ON (op.order_id = o.order_id) LEFT JOIN `" . DB_PREFIX . "product` p ON (op.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE o.order_status_id > '0' AND p.status = '1' AND p.date_available <= '$time'  GROUP BY op.product_id ORDER BY total DESC LIMIT " . (int)$limit);
			
			foreach ($query->rows as $result) { 		
				$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
			}
			
			$this->cache->set('product.bestseller' . $customer_group_id . '.' . (int)$limit, $product_data);
		}
		
		return $product_data;
	}
	
	/**
	*  依据产品ID 获取产品 属性，及属性组
	*  $product_id :产品ID
	*  $exclude  attribute_id排除出现在option_attribute_id后的attribute_id，默认不排除
	*/
	public function getProductAttributes($product_id,$exclude=false) {
	    $product_attribute_group_data = array();
		$attribute=array();
		$option_attribute=array();
		
		$attribute_id='';
		$comma='';
		
	    // $product_attribute_group_query = $this->db->query("SELECT ag.attribute_group_id, agd.name FROM " . DB_PREFIX . "product_attribute pa LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_group ag ON (a.attribute_group_id = ag.attribute_group_id) LEFT JOIN " . DB_PREFIX . "attribute_group_description agd ON (ag.attribute_group_id = agd.attribute_group_id) WHERE pa.product_id = '" . (int)$product_id  . "' GROUP BY ag.attribute_group_id ORDER BY ag.sort_order, agd.name");
		$query = $this->db->query("select attribute_id,option_attribute_id FROM ".DB_PREFIX."product_attribute where product_id='{$product_id}'");
		
		if($query->num_rows<=0) return $product_attribute_group_data;//没有属性
	    
		$category_id=$this->getProductCategories($product_id);
        $category_id=implode(',',$category_id);
		
		
		
		if($exclude=='option'){ //只选择option的属性
			if(!empty($query->row['option_attribute_id'])){
				$attribute=explode('|',$query->row['option_attribute_id']);
			}
		}else{
		    if(!empty($query->row['attribute_id'])){
				$attribute=explode('|',$query->row['attribute_id']);
			}
			
			//排除开始
			if(!empty($query->row['option_attribute_id']) && $exclude===true){
				$option_attribute=explode('|',$query->row['option_attribute_id']);
				
				foreach($attribute as $v){
					array_shift($attribute);
					if(empty($v)) continue;
					if(!in_array($v, $option_attribute)){
						array_push($attribute,$v);
					}
				}
			}
			//排除结束
		}
		
		
		$query=null;
	
		
		foreach($attribute as $v){
		    if(empty($v)) continue;
			$attribute_id .= $comma;
			$attribute_id .= $v;
			$comma=',';
		}
	
		if(!empty($attribute_id)){
			$sql="select a.attribute_id,a.attribute_group_id,ad.name,ad.url from `".DB_PREFIX."attribute` a  left join ".DB_PREFIX."attribute_description ad on a.attribute_id=ad.attribute_id where a.attribute_id in({$attribute_id})";
			$query=$this->db->query($sql);
		
		
			$attributes_=array();
			if($query->num_rows>0){
				$results=$query->rows;
				foreach($results as $v){
					$attributes_[$v['attribute_group_id']][] = array(
						'attribute_id' => $v['attribute_id'],
						'name'         => $v['name'],
						'url'         => $v['url']		 	
					);
				}
				
				foreach($attributes_ as $attribute_group_id=>$product_attribute_group){
					$product_attribute_data = array();
					
					foreach ($product_attribute_group as $product_attribute) {
						$product_attribute_data[] = array(
							'attribute_id' => $product_attribute['attribute_id'],
							'name'         => $product_attribute['name'],
							'url'         => $product_attribute['url']		 	
						);
					}
				    
					$sql="select agd.name,ag.option_id,ag.type,c2ag.is_pa from ".DB_PREFIX."attribute_group ag left join ".DB_PREFIX."attribute_group_description agd  on ag.attribute_group_id=agd.attribute_group_id  left join ".DB_PREFIX."category_to_attribute_group c2ag on ag.attribute_group_id=c2ag.attribute_group_id where  ag.attribute_group_id={$attribute_group_id} and c2ag.category_id in({$category_id})";
					$query_=$this->db->query($sql);
					
					if($query_->num_rows>0){
						$attribute_group_name=$query_->row['name'];
						$option_id=$query_->row['option_id'];
						$gtype=$query_->row['type'];
						if($query_->row['is_pa'] && $gtype==2){
							$gtype=2;
						}else{
							$gtype=1;
						}
						
						$product_attribute_group_data[] = array(
								'attribute_group_id' => $attribute_group_id,
									'attribute_group_name'               => $attribute_group_name,
									'product_option_value'          => $product_attribute_data, //即产品的属性列表
									'option_id'       => (int)$option_id,
									'attribute'  => $this->getAttributes($attribute_group_id),
									'gtype'   => $gtype,
									'type'  => $this->getOptionTypeByGID($attribute_group_id)
								);	
					}
				}
			}
			$query_=null;
			$results=null;
			$query=null;
		}

		return $product_attribute_group_data;
	}
    
    /**
    * 原先获取选项的函数，废弃
	*/	
	public function getProductOptions_old($product_id) {
		$product_option_data = array();
		
        $sql="SELECT po.product_option_id,o.option_id,od.name ,o.`type`,po.option_value,po.required,agd.name as attribute_group_name,agd.attribute_group_id FROM " . DB_PREFIX . "product_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) left join ".DB_PREFIX."attribute_group_description agd on po.attribute_group_id=agd.attribute_group_id  left join ".DB_PREFIX."attribute_group ag on po.attribute_group_id=ag.attribute_group_id WHERE  ag.type=2 and po.product_id = '" . (int)$product_id  . "' ORDER BY o.sort_order";
		$product_option_query = $this->db->query($sql);
		
		foreach ($product_option_query->rows as $product_option) {
			if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
				$product_option_value_data = array();
			
				$product_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_id = '" . (int)$product_id . "' AND pov.product_option_id = '" . (int)$product_option['product_option_id']  . "' ORDER BY ov.sort_order");
				
				foreach ($product_option_value_query->rows as $product_option_value) {
					$product_option_value_data[] = array(
						'product_option_value_id' => $product_option_value['product_option_value_id'],
						'option_value_id'         => $product_option_value['option_value_id'],
						'attribute_id'            => $product_option_value['attribute_id'],
						'name'                    => $product_option_value['name'],
						'image'                   => $product_option_value['image'],
						'quantity'                => $product_option_value['quantity'],
						'subtract'                => $product_option_value['subtract'],
						'price'                   => $product_option_value['price'],
						'price_prefix'            => $product_option_value['price_prefix'],
						'sell_price'              => $product_option_value['sell_price'],
						'weight'                  => $product_option_value['weight'],
						'weight_prefix'           => $product_option_value['weight_prefix'],
						'points'                  => $product_option_value['points'],
						'points_prefix'           => $product_option_value['points_prefix'],		
					);
				}
									
				$product_option_data[] = array(
					'product_option_id' => $product_option['product_option_id'],
					'option_id'         => $product_option['option_id'],
					'attribute_group_id'=> $product_option['attribute_group_id'],
					'name'              => $product_option['name'],
					'attribute_group_name' => isset($product_option['attribute_group_name'])?$product_option['attribute_group_name']:'',
					'type'              => $product_option['type'],
					'gtype'            => $this->getAttributeGroupType($product_option['attribute_group_id']),
					'product_option_value'      => $product_option_value_data,
					'required'          => $product_option['required']
				);
			} else {
				$product_option_data[] = array(
					'product_option_id' => $product_option['product_option_id'],
					'option_id'         => $product_option['option_id'],
					'name'              => $product_option['name'],
					'type'              => $product_option['type'],
					'product_option_value'      => $product_option['option_value'],
					'required'          => $product_option['required']
				);				
			}
      	}
		
		return $product_option_data;
	}
	
	public function getProductOptions($product_id) {
	    $product_option_data = array();
		
	    $sql="select product_id,composite_id,price,quantity,subtract from ".DB_PREFIX."product_option_ulity where product_id='{$product_id}'";
		$query=$this->db->query($sql);
		
		$product_option_data=$query->rows;
		
		return $product_option_data;
	  
	}
	
	public function getProductDiscounts($product_id) {
	    $time=time();
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}	
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$customer_group_id . "' AND quantity > 1 AND  date_start<{$time} AND date_end >{$time} ORDER BY quantity ASC, priority ASC, price ASC");

		return $query->rows;		
	}
		
	public function getProductImages($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "' ORDER BY sort_order ASC");

		return $query->rows;
	}
	
	public function getProductRelated($product_id) {
	    $time=time();
		$product_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_related pr LEFT JOIN " . DB_PREFIX . "product p ON (pr.related_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pr.product_id = '" . (int)$product_id . "' AND p.status = '1' AND p.date_available <= '$time' ");
		
		foreach ($query->rows as $result) { 
			$product_data[$result['related_id']] = $this->getProduct($result['related_id']);
		}
		
		return $product_data;
	}
		
	public function getProductLayoutId($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_layout WHERE product_id = '" . (int)$product_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");
		
		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return  $this->config->get('config_layout_product');
		}
	}
	
	public function getCategories($product_id) {
		$query = $this->db->query("SELECT c.category_id,c.image,c.parent_id,c.top,c.status,c.date_added,c.date_modified,c.attribute_group FROM " . DB_PREFIX . "product_to_category p2c left join ".DB_PREFIX."category c on p2c.category_id=c.category_id WHERE product_id = '" . (int)$product_id . "' order by c.top asc");
		
		return $query->rows;
	}	
		
	public function getTotalProducts($data = array()) {
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}	
				
		$cache = md5(http_build_query($data));
		
		$product_data = $this->cache->get('product.total' . (int)$this->config->get('config_store_id') . '.' . (int)$customer_group_id . '.' . $cache);
		
		if (!$product_data) {
		    $time=time();
			$sql = "SELECT COUNT(DISTINCT p.product_id) AS total FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id)";
	
			if (!empty($data['filter_category_id'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id)";			
			}
						
			$sql .= " WHERE  p.status = '1' AND p.date_available <='$time' ";
			
			if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
				$sql .= " AND (";
				
				if (!empty($data['filter_name'])) {					
					if (!empty($data['filter_description'])) {
						$sql .= "LCASE(pd.name) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%' OR MATCH(pd.description) AGAINST('" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "')";
					} else {
						$sql .= "LCASE(pd.name) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
					}
				}
				
				if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
					$sql .= " OR ";
				}
				
				if (!empty($data['filter_tag'])) {
					$sql .= "MATCH(pd.tag) AGAINST('" . $this->db->escape(utf8_strtolower($data['filter_tag'])) . "')";
				}
			
				$sql .= ")";
				
				if (!empty($data['filter_name'])) {
					$sql .= " OR LCASE(p.model) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				}
				
				if (!empty($data['filter_name'])) {
					$sql .= " OR LCASE(p.sku) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				}	
				
				if (!empty($data['filter_name'])) {
					$sql .= " OR LCASE(p.upc) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				}		

				/*if (!empty($data['filter_name'])) {
					$sql .= " OR LCASE(p.ean) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				}

				if (!empty($data['filter_name'])) {
					$sql .= " OR LCASE(p.jan) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				}
				
				if (!empty($data['filter_name'])) {
					$sql .= " OR LCASE(p.isbn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				}		
				
				if (!empty($data['filter_name'])) {
					$sql .= " OR LCASE(p.mpn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				}		*/		
			}
						
			if (!empty($data['filter_category_id'])) {
				if (!empty($data['filter_sub_category'])) {
					$implode_data = array();
					
					$implode_data[] = (int)$data['filter_category_id'];
					
					$this->load->model('catalog/category');
					
					$categories = $this->model_catalog_category->getCategoriesByParentId($data['filter_category_id']);
										
					foreach ($categories as $category_id) {
						$implode_data[] = (int)$category_id;
					}
								
					$sql .= " AND p2c.category_id IN (" . implode(', ', $implode_data) . ")";			
				} else {
					$sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
				}
			}		
			
			if (!empty($data['filter_manufacturer_id'])) {
				$sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer_id'] . "'";
			}
			
			$query = $this->db->query($sql);
			
			$product_data = $query->row['total']; 
			
			$this->cache->set('product.total'  . (int)$this->config->get('config_store_id') . '.' . (int)$customer_group_id . '.' . $cache, $product_data);
		}
		
		return $product_data;
	}
			
	public function getTotalProductSpecials() {
		$time=time();
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}		
		
		$query = $this->db->query("SELECT COUNT(DISTINCT ps.product_id) AS total FROM " . DB_PREFIX . "product_special ps LEFT JOIN " . DB_PREFIX . "product p ON (ps.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available >= {$time}  AND ps.customer_group_id = '" . (int)$customer_group_id . "' AND  ps.date_start >{$time} AND ps.date_end <{$time}");
		
		if (isset($query->row['total'])) {
			return $query->row['total'];
		} else {
			return 0;	
		}
	}
    
	/**
	*根据产品分类取对应的产品
	*/
	public function getProductByCategoryId($category_id,$limit,$order=''){
	    if(!empty($order)){
		    $time=time();
	        $sql="select distinct(p.product_id) from ".DB_PREFIX."product p inner join ".DB_PREFIX."product_to_category p2c on p.product_id=p2c.product_id WHERE p.status=1 and date_available>{$time} ";
		
			$implode_data = array();
			
			//第一种写法
			/* $implode_data[] = "p2c.category_id = '" . (int)$category_id . "'";
			
			$this->load->model('catalog/category');
			
			$pid=array('pid'=>$category_id);
			$categories = $this->model_catalog_category->getCategories($pid);
			
			foreach ($categories as $category) {
				$implode_data[] = "p2c.category_id = '" . (int)$category['category_id'] . "'";
			}
			
			$sql .= " AND (" . implode(' OR ', $implode_data) . ")"; */
			//第二种写法
			$this->load->model('catalog/category');
			
			$categories = $this->model_catalog_category->getCategories($category_id);
		
			foreach ($categories as $category) {
				$implode_data[] = (int)$category['category_id'] ;
			}
			if(sizeof($implode_data)==0){
			     $sql.=" and p2c.category_id='".(int)$category_id."'";
			}elseif(sizeof($implode_data)>0){
			     $implode_data[]=(int)$category_id;
			     $sql.="and p2c.category_id in(".implode(',',$implode_data).")";
			}

			$sql .="  order by {$order} desc limit {$limit}";
			
			
		}else{
		    $sql="select distinct(p.product_id) from ".DB_PREFIX."product p inner join ".DB_PREFIX."product_to_category p2c on p.product_id=p2c.product_id where p2c.category_id={$category_id} order by date_added desc limit {$limit}";
		}
		
		$product_data = array();
				
		$query = $this->db->query($sql);
	    
		if(!empty($query)){
			foreach ($query->rows as $result) {
			    if($result['product_id']) $product_data[$result['product_id']] = $this->getProduct($result['product_id']);
			}
		}
		
		return $product_data;
	}
	
	
	
	/**
	*一周销售排行 按照销售数量
	*/
	public function getProductByWeek($category_id,$recommend=false){
	    $startTime=strtotime("-7 day");
		$endTime=strtotime("-1 day");
		
		
		$sql="select p.product_id ,sum(op.quantity) as total from ".DB_PREFIX."product p left join ".DB_PREFIX."product_to_category p2c on p.product_id=p2c.product_id left join ".DB_PREFIX."order_product op on p.product_id=op.product_id left join `".DB_PREFIX."order` o on op.order_id=o.order_id   where p2c.category_id={$category_id} and o.date_added>{$startTime} and o.date_added<{$endTime} and o.order_status_id=5 group by p.product_id order by total desc limit 11";
		$product_data = array();
				
		$query = $this->db->query($sql);
	
		foreach ($query->rows as $key=>$result) {
		    if($recommend===true){ 
			    if($key>=5){  //取后面6条记录
				    $product_data[$result['product_id']] = $this->getProduct($result['product_id']);
				}
			}elseif($recommend===false){  
			    if($key<=4){  //取前面5条记录
			        $product_data[$result['product_id']] = $this->getProduct($result['product_id']);
				}
			}
		}
		
		
		
		return $product_data;
	}
	
	/**为你挑选 按照产品分类的 最新上架，人气指数 */
	public function getProductForYou($category_id){
	    $sql="select p.product_id from ".DB_PREFIX."product p left join ".DB_PREFIX."product_to_category p2c on p.product_id=p2c.product_id  where p2c.category_id={$category_id} group by p.product_id order by p.date_added desc ,p.viewed desc limit 5";
        $product_data = array();
				
		$query = $this->db->query($sql);
	
		foreach ($query->rows as $result) {
			$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
		}
		
		
		return $product_data;
	}
	
    /**
    * 根据分类及搜索条件取对应的产品
    */
    public function getProductsByCategory($data=array()){
	    $time=time();
	    $sql="select p.product_id from ".DB_PREFIX."product p left join ".DB_PREFIX."product_description pd on p.product_id=pd.product_id left join ".DB_PREFIX."product_to_category p2c on p.product_id=p2c.product_id left join ".DB_PREFIX."product_attribute pa on p.product_id=pa.product_id where p.date_available>{$time} and p.status=1 ";
        
		//包含子类
		$implode_data=array();
		$this->load->model('catalog/category');
		$pid=array('pid'=>$data['category_id']);
		$categories = $this->model_catalog_category->getCategories($pid);
		foreach ($categories as $category) {
			$implode_data[] = (int)$category['category_id'] ;
		}
		if(sizeof($implode_data)==0){
			 $sql.=" and p2c.category_id='".(int)$data['category_id']."'";
		}elseif(sizeof($implode_data)>0){
			 $implode_data[]=(int)$category_id;
			 $sql.="and p2c.category_id in(".implode(',',$implode_data).")";
		}
		//单一ID
		//if(!empty($data['category_id'])){
		//    $sql.=" and p2c.category_id={$data['category_id']}";
		//}
	
		$url_arr=$data['url_arr'];

		$str='';
		if(!empty($url_arr) && count($url_arr)>=1){
		    foreach($url_arr as $k=>$v){
			    $lr=explode('=',$v);
				if (!empty($lr[1]))  $str .=" and instr(attribute_id,'|".$lr[1]."|')";
			}
		}
		$sql.=$str;
	
		/*
		if(!empty($data['a_id1']))  $sql.=" and pa.a_id1={$data['a_id1']}";
		if(!empty($data['a_id2']))  $sql.=" and pa.a_id2={$data['a_id2']}";
		if(!empty($data['a_id3']))  $sql.=" and pa.a_id3={$data['a_id3']}";
		if(!empty($data['a_id4']))  $sql.=" and pa.a_id4={$data['a_id4']}";
		if(!empty($data['a_id5']))  $sql.=" and pa.a_id5={$data['a_id5']}";
		if(!empty($data['a_id6']))  $sql.=" and pa.a_id6={$data['a_id6']}";
		if(!empty($data['a_id7']))  $sql.=" and pa.a_id7={$data['a_id7']}";
		if(!empty($data['a_id8']))  $sql.=" and pa.a_id8={$data['a_id8']}";
		if(!empty($data['a_id9']))  $sql.=" and pa.a_id9={$data['a_id9']}";
		if(!empty($data['a_id0']))  $sql.=" and pa.a_id0={$data['a_id0']}";
		*/
		
        $sql.=" group by p.product_id";
		
		$sort_data = array(
			'pd.name',
			'p.model',
			'p.quantity',
			'p.price',
			'p.viewed',
			'p.sort_order',
			'p.date_added'
		);
		
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		}
		
		if (isset($data['order']) && ($data['order'] == 'desc')) {
			$sql .= " desc";
		} else {
			$sql .= " asc";
		}
	
		
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}				

			if ($data['limit'] < 1) {
				$data['limit'] = 30;
			}	
		
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
		
		
		
		$product_data = array();
				
		$query = $this->db->query($sql);
	
		foreach ($query->rows as $result) {
			$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
		}
		
		
		return $product_data;

    }
	
	/**
    * 根据分类及搜索条件取对应的产品总数
	* 因为 一个产品属于父类，子类，子孙。。。，所以要用groupby 过滤多行
    */
    public function getTotalProductsByCategory($data){
	    $time=time();
	    $sql="select distinct(p.product_id) from ".DB_PREFIX."product p inner join ".DB_PREFIX."product_description pd on p.product_id=pd.product_id left join ".DB_PREFIX."product_to_category p2c on p.product_id=p2c.product_id left join ".DB_PREFIX."product_attribute pa on p.product_id=pa.product_id  where p.date_available>{$time} and p.status=1 ";
        
		//包含子类
		$implode_data=array();
		$this->load->model('catalog/category');
		$pid=array('pid'=>$data['category_id']);
		$categories = $this->model_catalog_category->getCategories($pid);
		foreach ($categories as $category) {
			$implode_data[] = (int)$category['category_id'] ;
		}
		if(sizeof($implode_data)==0){
			 $sql.=" and p2c.category_id='".(int)$data['category_id']."'";
		}elseif(sizeof($implode_data)>0){
			 $implode_data[]=(int)$category_id;
			 $sql.="and p2c.category_id in(".implode(',',$implode_data).")";
		}
		//单一类别ID
		//if(!empty($data['category_id'])){
		//    $sql.=" and p2c.category_id={$data['category_id']}";
		//}
		
		$url_arr=$data['url_arr'];
		
		$str='';
		if(!empty($url_arr) && count($url_arr)>=1){
		    foreach($url_arr as $k=>$v){
			    $lr=explode('=',$v);
				if (!empty($lr[1]))  $str .=" and instr(attribute_id,'|".$lr[1]."|')";
			}
		}
		$sql.=$str;
		/*
		if(!empty($data['a_id1']))  $sql.=" and pa.a_id1={$data['a_id1']}";
		if(!empty($data['a_id2']))  $sql.=" and pa.a_id2={$data['a_id2']}";
		if(!empty($data['a_id3']))  $sql.=" and pa.a_id3={$data['a_id3']}";
		if(!empty($data['a_id4']))  $sql.=" and pa.a_id4={$data['a_id4']}";
		if(!empty($data['a_id5']))  $sql.=" and pa.a_id5={$data['a_id5']}";
		if(!empty($data['a_id6']))  $sql.=" and pa.a_id6={$data['a_id6']}";
		if(!empty($data['a_id7']))  $sql.=" and pa.a_id7={$data['a_id7']}";
		if(!empty($data['a_id8']))  $sql.=" and pa.a_id8={$data['a_id8']}";
		if(!empty($data['a_id9']))  $sql.=" and pa.a_id9={$data['a_id9']}";
		if(!empty($data['a_id0']))  $sql.=" and pa.a_id0={$data['a_id0']}";
		*/
		
        //$sql.=" group by p.product_id";
		
	    $query = $this->db->query($sql);
		
		
		return $query->num_rows;
	
	}
	
	/**
	* 依据产品的ID显示对应的顶级父类
	*/
	public function getTopCidByPid($pid){
	    $cid='';
	    $sql="select c.category_id  as category_id from ".DB_PREFIX."product p left join ".DB_PREFIX."product_to_category p2c on p.product_id=p2c.product_id left join ".DB_PREFIX."category c on p2c.category_id=c.category_id where p.product_id='{$pid}' and c.parent_id=0";
	    $query=$this->db->query($sql);
		$result=$query->row;
		if($result){
		    $cid=$result['category_id'];
		}
		return $cid;
	}
	
	/**
	*依据product_option_id从product_option表取对应的attribute_group_id对应的name
	*/
	public function getAttributeGroupNameByPO($product_option_id){
	    $data=array();
	    $sql="select agd.name from ".DB_PREFIX."product_option po left join ".DB_PREFIX."attribute_group_description agd on agd.attribute_group_id=po.attribute_group_id where po.product_option_id='{$product_option_id}'";
	    $query=$this->db->query($sql);
		$data=$query->row;
		
		return $data['name'];
	}
	
	/**依据产品ID取对应的类*/
	public function getProductCategories($product_id) {
		$product_category_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");
		
		foreach ($query->rows as $result) {
			$product_category_data[] = $result['category_id'];
		}

		return $product_category_data;
	}
	
	//取某个属性组下的所有属性
	public function getAttributes($attribute_group_id){
	    $data=array();
	    if(!empty($attribute_group_id)){
	        $sql="select a.attribute_id,ad.name from ".DB_PREFIX."attribute a left join ".DB_PREFIX."attribute_description ad on a.attribute_id=ad.attribute_id where a.attribute_group_id in ({$attribute_group_id})";
		    $query=$this->db->query($sql);
	        $data=$query->rows;
	    }
		
		return $data;
	}
	
	//
    public function getOptionTypeByGID($attribute_group_id){
        $type='';
	    $sql="select o.type from `".DB_PREFIX."attribute_group` ag left join `".DB_PREFIX."option` o on ag.option_id=o.option_id where ag.attribute_group_id='{$attribute_group_id}'";
		$query=$this->db->query($sql);
		$type=$query->row['type'];
		return $type;
	}
	
	//对应catalog/option model下的 函数
	public function getOptionValues($option_id,$attribute_group_id='') {
		$option_value_data = array();

		$sql="SELECT * FROM " . DB_PREFIX . "option_value ov LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE ov.option_id = '" . (int)$option_id  . "'";
	
		if (!empty($attribute_group_id)){
		    $sql.=" AND ovd.attribute_group_id ='{$attribute_group_id}'";
		}
		
		$sql.=" ORDER BY ov.sort_order ASC";
		
		$option_value_query = $this->db->query($sql);
				
		foreach ($option_value_query->rows as $option_value) {
			$option_value_data[] = array(
				'option_value_id' => $option_value['option_value_id'],
				'attribute_group_id' => $option_value['attribute_group_id'],
				'attribute_id'    => $option_value['attribute_id'],
				'name'            => $option_value['name'],
				'image'           => $option_value['image'],
				'sort_order'      => $option_value['sort_order']
			);
		}
		
		return $option_value_data;
	}
	
	/**
	* 依据产品ID获取 对应选项属性 所在的属性组
	* $option true:默认取option_attribute_id所在的属性组，false:所有attribute_id所在的属性组
	*/
	public function getGroupIDByAttributeID($product_id,$option=true){
	    $attribute_id='';
		$option_attribute_group=array();
		$comma='';
		$attribute=array();
		
	    $sql="select attribute_id,option_attribute_id from ".DB_PREFIX."product_attribute where product_id='{$product_id}'";
		$query=$this->db->query($sql);
	    if($query->num_rows>0){
		    if($option==true){
				$attribute=$query->row['option_attribute_id'];
			}else{
			    $attribute=$query->row['attribute_id'];
			}
			
	
		    if(!empty($attribute)){
				$attribute=explode('|',$attribute);
			
				foreach($attribute as $v){
					if(empty($v)) continue;
					$attribute_id .= $comma;
					$attribute_id .= $v;
					$comma=',';
				}
			}
			// echo $attribute_id;
			
			if(!empty($attribute_id)){
			    if($option==true){
			        $sql="select ag.attribute_group_id from ".DB_PREFIX."attribute a  left join ".DB_PREFIX."attribute_group ag on a.attribute_group_id=ag.attribute_group_id where  ag.type=2 and attribute_id in({$attribute_id}) group by a.attribute_group_id";
				}else{
				    $sql="select attribute_group_id from ".DB_PREFIX."attribute  where   attribute_id in({$attribute_id}) group by attribute_group_id";
				}
				$query_=$this->db->query($sql);
				if($query_->num_rows>0){
				    foreach($query_->rows as $v){
						$option_attribute_group[]=$v['attribute_group_id'];
					}
				}
			}
		
		}
		$query=null;
		
		return $option_attribute_group;
	}
	
	
	/**
	*根据产品PID获取 一般属性（排除选项属性）
	*/
	public function getGeneralAttributesByPid($product_id){
	    $data=array();
	    $attribute_id=array();
		$option_attribute_id=array();
	    $sql="select attribute_id,option_attribute_id from ".DB_PREFIX."product_attribute where product_id='{$product_id}'";
		$query=$this->db->query($sql);
		if($query->num_rows>0){
		    $str1=$query->row['attribute_id'];
		    $str2=$query->row['option_attribute_id'];
	    }
		
		$attribute_id=explode('|',$str1);
		$option_attribute_id=explode('|',$str2);
		
		foreach($attribute_id as $v){
		    if(empty($v)) continue;
		    if(!in_array($v,$option_attribute_id)){
			     array_push($data,$v);
			}
		}
		
		return $data;
	}
	
	public function getAttributeGroupType($attribute_group_id){
	
	    $sql="select type from ".DB_PREFIX."attribute_group  where attribute_group_id='{$attribute_group_id}'";
		$query=$this->db->query($sql);
		
		return $query->row['type'];
	}
	
	/* public function getOptionType($option_id){
	    $data=array();
	    $sql="select * from `".DB_PREFIX."option` where option_id='{$option_id}'";
		$query=$this->db->query($sql);
		
	    $data=$query->row;
		
		return $data;
	} */
	
    public function getAttributeNameById($attribute_id){
	    $data='';
	    $sql="select name from ".DB_PREFIX."attribute_description where attribute_id='{$attribute_id}'";
		$query=$this->db->query($sql);
		$data=$query->row['name'];
		
		return $data;
    }
	
	
	public function getProductPriceByAttribute($product_id,$attribute1,$attribute2){
	    $data='';
	
	    $sql="select price from ".DB_PREFIX."product_option_ulity where product_id='{$product_id}' and (composite_id='{$attribute1}' or composite_id='{$attribute2}')";
		$query=$this->db->query($sql);
		$data=$query->row;
		
		return isset($data['price'])?$data['price']:0;
		
	}
}
?>