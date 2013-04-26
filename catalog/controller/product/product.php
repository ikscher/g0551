<?php  

class ControllerProductProduct extends Controller {
	private $error = array(); 
	
	public function index() 
    {   
	    $this->load->model('tool/image');
        $this->load->model('catalog/product');
		$this->load->language('product/product');
        
		$this->data['customer_id']=$this->customer->isLogged();
		
		
		$this->document->setTitle($this->config->get('config_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));

		$this->data['heading_title'] = $this->config->get('config_title');
		
		
        
        $product_id = isset($this->request->get['product_id'])?(int)$this->request->get['product_id']:0;
		
		
		//更新人气数
		$this->load->library('func');
		$gfunc=new Func();
		$ip=$gfunc->GetIp();
		$key=$ip.'.'.$product_id;
		$pv=$this->memcached->get($key);
		if(empty($pv)){
			$this->model_catalog_product->updateViewed($product_id);
			$this->memcached->set($key,'1',0,86400*30);
		}
		$gfunc=null;
		
		
        $product = $this->model_catalog_product->getProduct($product_id);
	  
	  
		//促销有效期天数
	    if(isset($product['special']['date_end'])) $this->data['interval']=getDateDiff(time(),strtotime($product['special']['date_end']));
		
		//猜你喜欢的(也即会有浏览过的产品，保存为cookie的形式,保存期限30天)
		$guessYouLike=array();
		if(isset($this->request->cookie['guessYouLike'])){
		    $guessYouLike=unserialize($this->cookie->OCAuthCode($this->request->cookie['guessYouLike'],'DECODE'));
		}
		
		if(!empty($guessYouLike)){
			if(array_search($product_id,$guessYouLike)===false){  
				array_push($guessYouLike,$product_id);
			}
		}
		
        $this->cookie->OCSetCookie("guessYouLike",$this->cookie->OCAuthCode(serialize($guessYouLike),'ENCODE'),30*24*3600);
      
		if (!empty($product)){ //指定商品存在
		    
			$this->data['referer']   ="index.php?route=product/product&product_id={$product_id}";
			$this->data['product'] = $product;
			
			
			$store= $this->model_catalog_product->getStore($product['store_id']);
            if($store['map_x']>0){			
		        $this->data['map_x']=$store['map_x'];
			}else{
			    $this->data['map_x']=117.29;
			}
			if($store['map_y']>0){			
		        $this->data['map_y']=$store['map_y'];
			}else{
			    $this->data['map_y']=31.87;
			}
			$this->data['store']=$store;
			
			
			$this->data['images'] = array();
		
			$ext_images = $this->model_catalog_product->getProductImages($product_id);
			
			
			foreach($ext_images as $result){   
			    $popup=HTTP_SERVER.$result['image'];//原图
				// var_dump(getimagesize($popup));
			    $this->data['images'][] = array(
				   'popup' => $this->model_tool_image->resize($result['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height')),
					//'popup' => $popup,
					'image' => $this->model_tool_image->resize($result['image'], $this->config->get('config_image_additional_width'), $this->config->get('config_image_additional_height')),
					'thumb' => $this->model_tool_image->resize($result['image'], $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height'))
				);
			}

            $this->data['popup']=isset($this->data['images'][0]['popup'])?$this->data['images'][0]['popup']:null;	
			$this->data['addtional']=isset($this->data['images'][0]['image'])?$this->data['images'][0]['image']:null;	
				
		    
			$this->data['text_select'] = $this->language->get('text_select');
			$this->data['text_option'] = $this->language->get('text_option');
			$this->data['options'] = array();
            
			/*
			$product_options_info=$this->model_catalog_product->getProductOptions($this->request->get['product_id']);
			
			foreach ($product_options_info as $option) {
				if ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'checkbox' || $option['type'] == 'image') {
					$option_value_data = array();

					foreach ($option['product_option_value'] as $option_value) {
						if (!$option_value['subtract'] || ($option_value['quantity'] > 0)) {
							if ((($this->config->get('config_member_price') && $this->member->isLogged()) || !$this->config->get('config_member_price')) && (float)$option_value['price']) {
								$price = number_format($option_value['price'], 2,'.','');
							} else {
								$price = false;
							}

							$option_value_data[] = array(
								'product_option_value_id' => $option_value['product_option_value_id'],
								'option_value_id'         => $option_value['option_value_id'],
								'name'                    => $option_value['name'],
								'image'                   => $this->model_tool_image->resize($option_value['image'], 50, 50),
								'price'                   => $price,
								'price_prefix'            => $option_value['price_prefix']
							);
						}
					}

					$this->data['options'][] = array(
						'product_option_id' => $option['product_option_id'],
						'option_id'         => $option['option_id'],
						'name'              => $option['name'],
						'attribute_group_name' => $option['attribute_group_name'],
						'type'              => $option['type'],
						'option_value'      => $option_value_data,
						'required'          => $option['required']
					);
				} elseif ($option['type'] == 'text' || $option['type'] == 'textarea' || $option['type'] == 'file' || $option['type'] == 'date' || $option['type'] == 'datetime' || $option['type'] == 'time') {
					$this->data['options'][] = array(
						'product_option_id' => $option['product_option_id'],
						'option_id'         => $option['option_id'],
						'name'              => $option['name'],
						'attribute_group_name' => $option['attribute_group_name'],
						'type'              => $option['type'],
						'option_value'      => $option['option_value'],
						'required'          => $option['required']
					);
				}
			}
			*/
			
			//一般属性,价格属性
			$attributes=$attributes_general=$attributes_price=array();
			$attributes=$this->model_catalog_product->getProductAttributes($product_id,false);
			
			$sort_order=array();
			foreach ($attributes as $key => $value) {
				if($value['gtype']==1){
				    $attributes_general[]=$value;
				}elseif($value['gtype']==2){
				    $attributes_price[]=$value;
				}
			}
			
			$this->data['attributes_general']=$attributes_general;
			$this->data['attributes_price']=$attributes_price;
			
			
			
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/product.html')) {
				$this->template = $this->config->get('config_template') . '/template/product/product.html';
			} else {
				$this->template = 'default/template/product/product.html';
			}
        }else{ //商品不存在
		    if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.html')) {
				$this->template = $this->config->get('config_template') . '/template/error/not_found.html';
			} else {
				$this->template = 'default/template/error/not_found.html';
			}
		
		}
        // common/header/index&category=clothes
		$this->children = array(
			'common/footer',
			'common/header'
		);		
	
	    $this->response->setOutput($this->render());
  	}
	
	public function review() {
    	$this->language->load('product/product');
		
		$this->load->model('catalog/review');

		$this->data['text_on'] = $this->language->get('text_on');
		$this->data['text_no_reviews'] = $this->language->get('text_no_reviews');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}  
		
		$this->data['reviews'] = array();
		
		$review_total = $this->model_catalog_review->getTotalReviewsByProductId($this->request->get['product_id']);
			
		$results = $this->model_catalog_review->getReviewsByProductId($this->request->get['product_id'], ($page - 1) * 5, 5);
      		
		foreach ($results as $result) {
        	$this->data['reviews'][] = array(
        		'author'     => $result['author'],
				'text'       => $result['text'],
				'rating'     => (int)$result['rating'],
        		'reviews'    => sprintf($this->language->get('text_reviews'), (int)$review_total),
        		'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added']))
        	);
      	}			
			
		$pagination = new Pagination('results','links');
		$pagination->total = $review_total;
		$pagination->page = $page;
		$pagination->limit = 5; 
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('product/product/review', 'product_id=' . $this->request->get['product_id'] . '&page={page}');
			
		$this->data['pagination'] = $pagination->render();
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/review.html')) {
			$this->template = $this->config->get('config_template') . '/template/product/review.html';
		} else {
			$this->template = 'default/template/product/review.html';
		}
		
		$this->response->setOutput($this->render());
	}
	
	public function write() {
		$this->language->load('product/product');
		
		$this->load->model('catalog/review');
		
		$json = array();
		
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 25)) {
				$json['error'] = $this->language->get('error_name');
			}
			
			if ((utf8_strlen($this->request->post['text']) < 25) || (utf8_strlen($this->request->post['text']) > 1000)) {
				$json['error'] = $this->language->get('error_text');
			}
	
			if (empty($this->request->post['rating'])) {
				$json['error'] = $this->language->get('error_rating');
			}
	
			if (empty($this->session->data['captcha']) || ($this->session->data['captcha'] != $this->request->post['captcha'])) {
				$json['error'] = $this->language->get('error_captcha');
			}
				
			if (!isset($json['error'])) {
				$this->model_catalog_review->addReview($this->request->get['product_id'], $this->request->post);
				
				$json['success'] = $this->language->get('text_success');
			}
		}
		
		$this->response->setOutput(json_encode($json));
	}
	
	public function captcha() {
		$this->load->library('captcha');
		
		$captcha = new Captcha();
		
		$this->session->data['captcha'] = $captcha->getCode();
		
		$captcha->showImage();
	}
	
	public function upload() {
		$this->language->load('product/product');
		
		$json = array();
		
		if (!empty($this->request->files['file']['name'])) {
			$filename = basename(preg_replace('/[^a-zA-Z0-9\.\-\s+]/', '', html_entity_decode($this->request->files['file']['name'], ENT_QUOTES, 'UTF-8')));
			
			if ((utf8_strlen($filename) < 3) || (utf8_strlen($filename) > 64)) {
        		$json['error'] = $this->language->get('error_filename');
	  		}	  	
			
			$allowed = array();
			
			$filetypes = explode(',', $this->config->get('config_upload_allowed'));
			
			foreach ($filetypes as $filetype) {
				$allowed[] = trim($filetype);
			}
			
			if (!in_array(substr(strrchr($filename, '.'), 1), $allowed)) {
				$json['error'] = $this->language->get('error_filetype');
       		}	
						
			if ($this->request->files['file']['error'] != UPLOAD_ERR_OK) {
				$json['error'] = $this->language->get('error_upload_' . $this->request->files['file']['error']);
			}
		} else {
			$json['error'] = $this->language->get('error_upload');
		}
		
		if (!$json) {
			if (is_uploaded_file($this->request->files['file']['tmp_name']) && file_exists($this->request->files['file']['tmp_name'])) {
				$file = basename($filename) . '.' . md5(mt_rand());
				
				// Hide the uploaded file name so people can not link to it directly.
				$json['file'] = $this->encryption->encrypt($file);
				
				move_uploaded_file($this->request->files['file']['tmp_name'], DIR_DOWNLOAD . $file);
			}
						
			$json['success'] = $this->language->get('text_upload');
		}	
		
		$this->response->setOutput(json_encode($json));		
	}
	
	public function getProductPriceByAttribute(){
	    $this->load->model('catalog/product');
		$product_id=$this->request->post['product_id'];
		$attribute1=$this->request->post['attribute1'];
		$attribute2=$this->request->post['attribute2'];
		
		$price=0;
		$price=$this->model_catalog_product->getProductPriceByAttribute($product_id,$attribute1,$attribute2);
		
		$this->response->setOutput($price);
	}
}
?>