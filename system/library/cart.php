<?php
class Cart {
	private $config;
	private $db;
	private $data = array();

	
  	public function __construct($registry) {
		$this->config = $registry->get('config');
		$this->customer = $registry->get('customer');
		$this->session = $registry->get('session');
		$this->request = $registry->get('request');
		$this->cookie = $registry->get('cookie');
		$this->db = $registry->get('db');
		$this->tax = $registry->get('tax');
		$this->weight = $registry->get('weight');

		if (!isset($this->session->data['cart']) || !is_array($this->session->data['cart'])) {
      		$this->session->data['cart'] = array();
    	}
	}
	

    /**
    *    获取产品信息
	*    $flag  :  (1)false 加入购物车 默认方式 session
	*              (2)true  直接购买            cookie
    */	
  	public function getProducts($flag=false) {
	    $time=time();
		$profilo=array();
        $this->data=array();
		//if (!$this->data) { //缓存数据，重新取数据
		    
			if($flag===true){
			    if(isset($this->request->cookie['dbuyproduct'])){
				    $dbuyproduct=$this->request->cookie['dbuyproduct'];
					$profilo = unserialize(base64_decode($dbuyproduct));
				
					array_walk_recursive($profilo,'formatSerializeRev');
				}
                
			}else{
		        $profilo=isset($this->session->data['cart'])?$this->session->data['cart']:'';
				
            } 
		
			if(empty($profilo)) return array();
			
			foreach ($profilo as $key => $quantity) {
				$product = explode('|', $key);
				$product_id = $product[0];
				$stock = true;
	
				// Options
				/* if (isset($product[1])) {
					$options = unserialize(base64_decode($product[1]));
				} else {
					$options = array();
				}  */
				
				//attributes
				if(isset($product[1])){
				    $attributes = unserialize(base64_decode($product[1]));
				}else{
				    $attributes = array();
				}
				
				
				$price=isset($product[2])?round(floatval($product[2]),2):0;
				
				
				//date_available 有效期应该是大于当前的时间
				$product_query = $this->db->query("SELECT p.*,pd.name,pd.description,p2s.store_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) left join ".DB_PREFIX."product_to_store p2s on p.product_id=p2s.product_id  WHERE p.product_id = '" . (int)$product_id  . "' AND p.date_available >= {$time} AND p.status = '1'");
				
				if ($product_query->num_rows) {
					$option_price = 0;
					$option_points = 0;
					$option_weight = 0;
	
					$option_data = array();
	                
					$item='|';
					foreach($attributes as $k=>$v){
						$item .= $v[0];
						$item .='|';
					}
					
					$sql="select * from ".DB_PREFIX."product_option_ulity where product_id='{$product_id}' and composite_id='{$item}'";
					
					$option_query=$this->db->query($sql);
					
					$option_data=$option_query->row;
					/*
					foreach ($options as $product_option_id => $option_value) {
						$option_query = $this->db->query("SELECT po.product_option_id, po.option_id, od.name, o.type,agd.name as attribute_group_name FROM " . DB_PREFIX . "product_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) left join ".DB_PREFIX."attribute_group_description agd on po.attribute_group_id=agd.attribute_group_id WHERE po.product_option_id = '" . (int)$product_option_id . "' AND po.product_id = '" . (int)$product_id  . "'");
						
						if ($option_query->num_rows) {
							if ($option_query->row['type'] == 'select' || $option_query->row['type'] == 'radio' || $option_query->row['type'] == 'image') {
								$option_value_query = $this->db->query("SELECT pov.option_value_id, ovd.name,ovd.attribute_id, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$option_value . "' AND pov.product_option_id = '" . (int)$product_option_id  . "'");
								
								if ($option_value_query->num_rows) {
									if ($option_value_query->row['price_prefix'] == '+') {
										$option_price += $option_value_query->row['price'];
									} elseif ($option_value_query->row['price_prefix'] == '-') {
										$option_price -= $option_value_query->row['price'];
									}
	
									if ($option_value_query->row['points_prefix'] == '+') {
										$option_points += $option_value_query->row['points'];
									} elseif ($option_value_query->row['points_prefix'] == '-') {
										$option_points -= $option_value_query->row['points'];
									}
																
									if ($option_value_query->row['weight_prefix'] == '+') {
										$option_weight += $option_value_query->row['weight'];
									} elseif ($option_value_query->row['weight_prefix'] == '-') {
										$option_weight -= $option_value_query->row['weight'];
									}
									
									if ($option_value_query->row['subtract'] && (!$option_value_query->row['quantity'] || ($option_value_query->row['quantity'] < $quantity))) {
										$stock = false;
									}
									
									$option_data[] = array(
										'product_option_id'       => $product_option_id,
										'product_option_value_id' => $option_value,
										'option_id'               => $option_query->row['option_id'],
										'option_value_id'         => $option_value_query->row['option_value_id'],
										'name'                    => $option_query->row['name'],
										'attribute_id'            => $option_value_query->row['attribute_id'],
										'attribute_group_name'    => $option_query->row['attribute_group_name'],
										'option_value'            => $option_value_query->row['name'],
										'type'                    => $option_query->row['type'],
										'quantity'                => $option_value_query->row['quantity'],
										'subtract'                => $option_value_query->row['subtract'],
										'price'                   => $option_value_query->row['price'],
										'price_prefix'            => $option_value_query->row['price_prefix'],
										'points'                  => $option_value_query->row['points'],
										'points_prefix'           => $option_value_query->row['points_prefix'],									
										'weight'                  => $option_value_query->row['weight'],
										'weight_prefix'           => $option_value_query->row['weight_prefix']
									);								
								}
							} elseif ($option_query->row['type'] == 'checkbox' && is_array($option_value)) {
								foreach ($option_value as $product_option_value_id) {
									$option_value_query = $this->db->query("SELECT pov.option_value_id, ovd.name,ovd.attribute_id, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$product_option_value_id . "' AND pov.product_option_id = '" . (int)$product_option_id  . "'");
									
									if ($option_value_query->num_rows) {
										if ($option_value_query->row['price_prefix'] == '+') {
											$option_price += $option_value_query->row['price'];
										} elseif ($option_value_query->row['price_prefix'] == '-') {
											$option_price -= $option_value_query->row['price'];
										}
	
										if ($option_value_query->row['points_prefix'] == '+') {
											$option_points += $option_value_query->row['points'];
										} elseif ($option_value_query->row['points_prefix'] == '-') {
											$option_points -= $option_value_query->row['points'];
										}
																	
										if ($option_value_query->row['weight_prefix'] == '+') {
											$option_weight += $option_value_query->row['weight'];
										} elseif ($option_value_query->row['weight_prefix'] == '-') {
											$option_weight -= $option_value_query->row['weight'];
										}
										
										if ($option_value_query->row['subtract'] && (!$option_value_query->row['quantity'] || ($option_value_query->row['quantity'] < $quantity))) {
											$stock = false;
										}
										
										$option_data[] = array(
											'product_option_id'       => $product_option_id,
											'product_option_value_id' => $product_option_value_id,
											'option_id'               => $option_query->row['option_id'],
											'option_value_id'         => $option_value_query->row['option_value_id'],
											'name'                    => $option_query->row['name'],
											'attribute_id'            => $option_value_query->row['attribute_id'],
											'attribute_group_name'    => $option_query->row['attribute_group_name'],
											'option_value'            => $option_value_query->row['name'],
											'type'                    => $option_query->row['type'],
											'quantity'                => $option_value_query->row['quantity'],
											'subtract'                => $option_value_query->row['subtract'],
											'price'                   => $option_value_query->row['price'],
											'price_prefix'            => $option_value_query->row['price_prefix'],
											'points'                  => $option_value_query->row['points'],
											'points_prefix'           => $option_value_query->row['points_prefix'],
											'weight'                  => $option_value_query->row['weight'],
											'weight_prefix'           => $option_value_query->row['weight_prefix']
										);								
									}
								}						
							} elseif ($option_query->row['type'] == 'text' || $option_query->row['type'] == 'textarea' || $option_query->row['type'] == 'file' || $option_query->row['type'] == 'date' || $option_query->row['type'] == 'datetime' || $option_query->row['type'] == 'time') {
								$option_data[] = array(
									'product_option_id'       => $product_option_id,
									'product_option_value_id' => '',
									'option_id'               => $option_query->row['option_id'],
									'option_value_id'         => '',
									'name'                    => $option_query->row['name'],
									'attribute_id'            => '',
									'attribute_group_name'    => $option_query->row['attribute_group_name'],
									'option_value'            => $option_value,
									'type'                    => $option_query->row['type'],
									'quantity'                => '',
									'subtract'                => '',
									'price'                   => '',
									'price_prefix'            => '',
									'points'                  => '',
									'points_prefix'           => '',								
									'weight'                  => '',
									'weight_prefix'           => ''
								);						
							}
						}
					} */
				
					if ($this->customer->isLogged()) {
						$customer_group_id = $this->customer->getCustomerGroupId();
					} else {
						$customer_group_id = $this->config->get('config_customer_group_id');
					}
					
					//$price = $product_query->row['price'];
					
					// Product Discounts 按照打折价格算，要求 实际购买的数量 大于 打折最低购买的数量
					$discount_quantity = 0;
					
					/* foreach ($this->session->data['cart'] as $key_2 => $quantity_2) {
						$product_2 = explode(':', $key_2);
						
						if ($product_2[0] == $product_id) {
							$discount_quantity += $quantity_2;
						}
					}
					$discount_quantity+=$quantity;
					
					$product_discount_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$customer_group_id . "' AND quantity <= '" . (int)$discount_quantity . "' AND  date_start <= {$time} AND  date_end >= {$time} ORDER BY quantity DESC, priority ASC, price ASC LIMIT 1");
					
					if ($product_discount_query->num_rows) {
						$price = $product_discount_query->row['price'];
					} */
					
					// Product Specials
					/* $product_special_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$customer_group_id . "' AND date_start <= {$time} AND date_end >={$time} ORDER BY priority ASC, price ASC LIMIT 1");
				
					if ($product_special_query->num_rows) {
						$price = $product_special_query->row['price'];
					} */						
			
					// Reward Points
					$product_reward_query = $this->db->query("SELECT points FROM " . DB_PREFIX . "product_reward WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$customer_group_id . "'");
					
					if ($product_reward_query->num_rows) {	
						$reward = $product_reward_query->row['points'];
					} else {
						$reward = 0;
					}
					
					// Downloads		
					$download_data = array();     		
					
					$download_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_download p2d LEFT JOIN " . DB_PREFIX . "download d ON (p2d.download_id = d.download_id) LEFT JOIN " . DB_PREFIX . "download_description dd ON (d.download_id = dd.download_id) WHERE p2d.product_id = '" . (int)$product_id . "'");
				
					foreach ($download_query->rows as $download) {
						$download_data[] = array(
							'download_id' => $download['download_id'],
							'name'        => $download['name'],
							'filename'    => $download['filename'],
							'mask'        => $download['mask'],
							'remaining'   => $download['remaining']
						);
					}
					
					// Stock
					if (!$product_query->row['quantity'] || ($product_query->row['quantity'] < $quantity)) {
						$stock = false;
					}
					
					//attributes
					$attribute_data=array();
					$comma='';
					$attribute_ids='';
					foreach($attributes as $a){
					    foreach($a as $b){
							$attribute_ids .= $comma;
							$attribute_ids .=$b;
							$comma=',';
						} 
					}  
					
					if(!empty($attribute_ids)){
					    $sql="select attribute_id,name from ".DB_PREFIX."attribute_description where attribute_id in ({$attribute_ids})";
					    $query_=$this->db->query($sql);
						$attribute_data=$query_->rows;
					}
					
					$this->data[$key] = array(
						'key'             => $key,
						'product_id'      => $product_query->row['product_id'],
						'store_id'        => $product_query->row['store_id'],
						'name'            => $product_query->row['name'],
						'model'           => $product_query->row['model'],
						'shipping'        => $product_query->row['shipping'],
						'image'           => $product_query->row['image'],
						'option'          => $option_data,
						'attribute'       => $attribute_data,
						//'download'        => $download_data,
						'quantity'        => $quantity,
						'minimum'         => $product_query->row['minimum'],
						'subtract'        => $product_query->row['subtract'],
						'stock'           => $stock,
						'price'           => $price ,
						'total'           => $price  * $quantity,
						'reward'          => $reward * $quantity,
						'points'          => ($product_query->row['points'] ? $product_query->row['points'] * $quantity : 0),
						'tax_class_id'    => $product_query->row['tax_class_id'],
						'weight'          => $product_query->row['weight'] * $quantity,
						'weight_class_id' => $product_query->row['weight_class_id'],
						'length'          => $product_query->row['length'],
						'width'           => $product_query->row['width'],
						'height'          => $product_query->row['height'],
						'length_class_id' => $product_query->row['length_class_id']					
					);
				} else {
					$this->remove($key);
				}
			}

		// }
		
		return $this->data;
  	}
	
    /*session保存购物车产品*/	
  	public function add($product_id, $qty = 1, $attribute = array(),$price=0) {
    	
      	$key = (int)$product_id . '|' . base64_encode(serialize($attribute)).'|'.$price;
    	
    	
		if ((int)$qty && ((int)$qty > 0)) {
    		if (!isset($this->session->data['cart'][$key])) {
      			$this->session->data['cart'][$key] = (int)$qty;
    		} else {
      			$this->session->data['cart'][$key] += (int)$qty;
    		}
		}
		
		$this->data = array();
  	}

  	public function update($key, $qty) {
    	if ((int)$qty && ((int)$qty > 0)) {
      		$this->session->data['cart'][$key] = (int)$qty;
    	} else {
	  		$this->remove($key);
		}
		
		$this->data = array();
  	}

  	public function remove($key) {
		if (isset($this->session->data['cart'][$key])) {
     		unset($this->session->data['cart'][$key]);
  		}
		
		if (isset($this->request->cookie['dbuyproduct'])){
		   $this->cookie->OCSetCookie('dbuyproduct','',-24*3600);
		}
		
		$this->data = array();
	}
	
  	public function clear() {
		$this->session->data['cart'] = array();
		if (isset($this->request->cookie['dbuyproduct'])){
		   $this->cookie->OCSetCookie('dbuyproduct','',-24*3600);
		}
		unset($this->session->data['cart']);
		$this->data = array();
  	}
	
  	public function getWeight() {
		$weight = 0;
	
    	foreach ($this->getProducts() as $product) {
			if ($product['shipping']) {
      			$weight += $this->weight->convert($product['weight'], $product['weight_class_id'], $this->config->get('config_weight_class_id'));
			}
		}
	
		return $weight;
	}
	
  	public function getSubTotal($flag=false) {
		$total = 0;

		foreach ($this->getProducts($flag) as $product) {
			$total += $product['total'];
		}
        
		return $total;
  	}
	
	//根据店铺分别统计总金额
	public function getStoreSubTotal($flag=false){
		$total = array();

		foreach ($this->getProducts($flag) as $product) {
		    $k=$product['store_id'];
			if(!isset($total[$k])) $total[$k]=0;
			$total[$k] += $product['total'];
		}
        
		return $total;
	
	}
	
	/**
	*  税率，删除
	*/
	public function getTaxes() {
		$tax_data = array();
		
		foreach ($this->getProducts() as $product) {
			if ($product['tax_class_id']) {
				$tax_rates = $this->tax->getRates($product['price'], $product['tax_class_id']);
				
				foreach ($tax_rates as $tax_rate) {
					if (!isset($tax_data[$tax_rate['tax_rate_id']])) {
						$tax_data[$tax_rate['tax_rate_id']] = ($tax_rate['amount'] * $product['quantity']);
					} else {
						$tax_data[$tax_rate['tax_rate_id']] += ($tax_rate['amount'] * $product['quantity']);
					}
				}
			}
		}
		
		return $tax_data;
  	}
    
  	public function getTotal() {
		$total = 0;
		
		foreach ($this->getProducts() as $product) {
		    $total += $product['price'] * $product['quantity'];
			//$total += $this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity'];
		}

		return $total;
  	}
	  	
  	public function countProducts() {
		$product_total = 0;
			
		$products = $this->getProducts();
		if(empty($products)) { return;}
		foreach ($products as $product) {

			$product_total += $product['quantity'];
		}		
		return $product_total;
	}
	  
  	public function hasProducts($flag=false) {
	    if($flag===true){
		    $x=unserialize(base64_decode($this->request->cookie['dbuyproduct']));
			return count($x);
		}else{
    	    return count($this->session->data['cart']);
		}
  	}
  
  	public function hasStock($flag=false) {
		$stock = true;
		
		foreach ($this->getProducts($flag) as $product) {
			if (!$product['stock']) {
	    		$stock = false;
			}
		}
		
    	return $stock;
  	}
    
	/**
	* 判断 产品 是否 要求托运
	*/
  	public function hasShipping($flag=false) {
		$shipping = false;
		foreach ($this->getProducts($flag) as $product) {
		    
	  		if ($product['shipping']) {
	    		$shipping = true;
				
				break;
	  		}		
		}
		
		return $shipping;
	}
	
  	public function hasDownload() {
		$download = false;
		
		foreach ($this->getProducts() as $product) {
	  		if ($product['download']) {
	    		$download = true;
				
				break;
	  		}		
		}
		
		return $download;
	}	
}
?>