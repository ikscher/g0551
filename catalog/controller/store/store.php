<?php
    /**店铺**/
	class ControllerStoreStore extends Controller {
	
		public function index(){
		
			$this->load->model('store/store');
			$this->load->model('tool/image');
            
			
		
			if (isset($this->request->get['page'])) {
				$page = $this->request->get['page'];
			} else {
				$page = 1;
			}
					
			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];
			} else {
				$limit = $this->config->get('config_store_limit');
			}
			
			$url = '';
			
			$category_id=isset($this->request->request['category_id'])?$this->request->request['category_id']:'';
			$keyword1=isset($this->request->request['keyword1'])?$this->request->request['keyword1']:'';
			$keyword2=isset($this->request->request['keyword2'])?$this->request->request['keyword2']:'';
			$priceLower=isset($this->request->request['priceLower'])?$this->request->request['priceLower']:0;
			$priceUp=isset($this->request->request['priceUp'])?$this->request->request['priceUp']:0;
			
			$this->data['keyword2']=$keyword2;
			$this->data['keyword1']=$keyword1;
			$this->data['priceLower']=$priceLower;
			$this->data['priceUp']=$priceUp;
			if(!empty($keyword))$url.="&keyword={$keyword}";
			if(!empty($priceLower)) $url.="&priceLower={$priceLower}";
			if(!empty($priceUp)) $url.="&priceUp={$priceUp}";
			if(!empty($category_id)) $url.="&category_id={$category_id}";
            
			
			if(!empty($this->request->get['store_id'])){
				$store_id = $this->request->get['store_id'];
                
				$store_info=$this->model_store_store->getStore($store_id);
				
				if (!empty($store_info['logo'])) {
					$store_info['logo']= $this->model_tool_image->resize($store_info['logo'], 130, 64);
				} else {
					$store_info['logo'] = 'catalog/view/theme/default/image/store/store_banner_logo.jpg';
				}	
				
				$store_info['createtime']=date('Y-m-d',$store_info['createtime']);
				
				switch ($store_info['grade']){
				    case 1:
						$store_info['grade']='catalog/view/theme/default/image/store/m.png';
						break;
				    
				    case 2:
						$store_info['grade']='catalog/view/theme/default/image/store/v.png';
						break;
				    case 3:
						$store_info['grade']='catalog/view/theme/default/image/store/v+.png';
						break;
				    default:
						$store_info['grade']='catalog/view/theme/default/image/store/m.png';
						break;
				}
				
				if(!empty($store_info['introduce'])) $store_info['introduce']=strip_tags(htmlspecialchars_decode($store_info['introduce']));
            
			    $this->data['store_info']=$store_info;
				
				$data = array(
				'store_id' => $store_id,
				'start'    => ($page - 1) * $limit,
				'keyword1'  => isset($keyword1)?$keyword1:'',
				'keyword2'  => isset($keyword2)?$keyword2:'',
				'priceLower'=>isset($priceLower)?$priceLower:0,
				'priceUp'  =>isset($priceUp)?$priceUp:0,
				'category_id'=>isset($category_id)?$category_id:'',
				'limit'    => $limit);

				
                $this->data['store_products']=array();
				$results = $this->model_store_store->getStoreProduct($data);
                
				if(!empty($results)){
					foreach($results as $result){
						
						if ($result['image']) {
							$image = $this->model_tool_image->resize($result['image'], 233, 233);
						} else {
							$image = false;
						}		

						$product_id = $result['product_id'];
						$name = trim($result['name']);
						$price = $result['price'];
						$store_id = $result['store_id'];
						$hots=!empty($result['hots'])?$result['hots']:0;
						$this->data['store_products'][] = array(
							'product_id' => $product_id,
							'shortname'=>utf8_substr(strip_tags(html_entity_decode($name, ENT_QUOTES, 'UTF-8')), 0,17) . '...',
							'name' => $name,
							'price' => $price,
							'image' => $image,
							'href' => $this->url->link('product/product', $url. '&product_id=' . $result['product_id']),
							'store_id' => $store_id,
							'hots'   =>$hots

						);
					
					}
				}
                $results=null;
				
				$total = $this->model_store_store->getStoreProductTotal($data);
              
				$pagination = new Pagination('results','links');
				$pagination->total = $total['total'];
				$pagination->page = $page;
				$pagination->limit = $limit;
				$pagination->text = $this->language->get('text_pagination');
				$pagination->url = $this->url->link('store/store', $url. "&store_id={$store_id}&page={page}");
				
				$this->data['pagination'] = $pagination->render();


				//$this->document->setTitle($this->config->get('config_title'));
				//$this->document->setDescription($this->config->get('config_meta_description'));
				//$this->data['heading_title'] = $this->config->get('config_title'); 
				
				$this->data['action']=$this->url->link('store/store',"&store_id={$store_id}");
				$this->data['store_id']=$store_id;
				
				//销量排行
				$this->data['productSaleTop']=array();
				$results=$this->model_store_store->getSaleTopByStore($store_id);
				if(!empty($results)){
					foreach($results as $result){
						if ($result['image']) {
							$image = $this->model_tool_image->resize($result['image'], 77, 74);
						} else {
							$image = $this->model_tool_image->resize('no_image.jpg', 77, 74);
						}
						
						$this->data['productSaleTop'][] = array(
						    'product_id' => $result['product_id'],
							'shortname'=>utf8_substr(strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')), 0,20) . '...',
							'name' => $result['name'],
							'price' => $result['price'],
							'image' => $image,
							'href' => $this->url->link('product/product', $url. '&product_id=' . $result['product_id']),
						);
                        						
				    }
				}
				$results=null;
				
				//店铺产品分类
				$firstDir=array();
				$secondDir=array();
				$thirdDir=array();
				$forthDir=array();
				$storeCategories=array();
				$this->data['storeCategories']=array();
				$storeCategories=$this->model_store_store->getStoreCategories($store_id);
				foreach($storeCategories as $v){
				    switch($v['top']){
					    case 1: //一级目录
					        $firstDir[]=$v;
							break;
						case 2: //二级目录
						    $secondDir[]=$v;
						    break;
						case 3: //三级目录
						    $thirdDir[]=$v;
						    break;
						case 4: //四级目录
						    $forthDir[]=$v;
						    break;
					}   
				}
				
				
			    $gg=$vv=$hh=array();
				foreach($thirdDir as $t){
					foreach($forthDir as $f){
				
						if($f['pid']==$t['cid']){
							$t['sub'][]=$f;
							
						}
					}
                    $gg[]=$t;
				}
					
				foreach($secondDir as $s){
				    foreach($gg as $t){
						if($s['cid']==$t['pid']){	 
							$s['sub'][]=$t;
							
						}
					}
					$vv[]=$s;
				}
				
				foreach($firstDir as $f){
					foreach($vv as $t){
						if($f['cid']==$t['pid']){	 
							$f['sub'][]=$t;
							
						}
					}
					$hh[]=$f;
				}
		        
				$this->data['storeCategories']=$hh;
			
				
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/store/index.html')) {
					$this->template = $this->config->get('config_template') . '/template/store/index.html';
				} else {
					$this->template = 'default/template/store/index.html';
				}
                
				$this->children = array(
					'merchants/footer',
					'store/header'
				);   
            }else{ //店铺不存在
	
			    if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.html')) {
					$this->template = $this->config->get('config_template') . '/template/error/not_found.html';
				} else {
					$this->template = 'default/template/error/not_found.html';
				}
				
				$this->children = array(
					'common/footer',
					'common/header'
				);
			}
			
			$this->response->setOutput($this->render());
		}


        /*
		public function pcategory(){
		
			$this->load->model('store/store');
			$this->load->model('tool/image');

			if (isset($this->request->get['page'])) {
				$page = $this->request->get['page'];
			} else {
				$page = 1;
			}
					
			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];
			} else {
				$limit = $this->config->get('config_catalog_limit');
			}

			if(isset($this->request->get['store_id'])){
				$store_id = $this->request->get['store_id'];

			}
			else
				$store_id = 0;

			if(isset($this->request->get['category_id'])){
				$category_id = $this->request->get['category_id']; 
			}

			$this->get_store_product();

			$url = '';

			$data = array(
				'store_id' => $store_id,
				'start'    => ($page - 1) * $limit,
				'limit'    => $limit,
				'store_id' => $store_id,
				'category_id' => $category_id
			);


			$pro_category = $this->model_store_store->getProductByCategory($data);

			foreach($pro_category as $result){
				
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
				} else {
					$image = false;
				}		

				$product_id = $result['product_id'];
				$name = $result['name'];
				$price = $result['price'];
				$store_id = $result['store_id'];

				$this->data['store_pro'][] = array(
					
					'product_id' => $product_id,
					'name' => utf8_substr(strip_tags(html_entity_decode($name, ENT_QUOTES, 'UTF-8')), 0,27) . '..',
					'price' => $price,
					'image' => $image,
					'href' => $this->url->link('product/product', $url. '&product_id=' . $result['product_id']),
					'store_id' => $store_id

				);
			
			}
			

			$total = $this->model_store_store->getStoreProductTotalByCategory($data);

			$pagination = new Pagination('results','links');
			$pagination->total = $total['total'];
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->text = $this->language->get('text_pagination');
			$pagination->url = $this->url->link('store/store/pcategory', $url. '&page={page}' . '&category_id='.$category_id);
			
			$this->data['pagination'] = $pagination->render();



			$this->document->setTitle($this->config->get('config_title'));
			$this->document->setDescription($this->config->get('config_meta_description'));

			$this->data['heading_title'] = $this->config->get('config_title');
			
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/store/index.html')) {
				$this->template = $this->config->get('config_template') . '/template/store/index.html';
			} else {
				$this->template = 'default/template/store/index.html';
			}
			
			
			$this->children = array(
				'store/footer',
				'store/header'
			);      
			$this->response->setOutput($this->render());
		
		}
		*/

    
	
	}
?>