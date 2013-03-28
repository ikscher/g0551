<?php 
/**搜索控制页面**/
class ControllerSearchSearch extends Controller { 	
	public function index() {
        $start=$this->microtime_float();	
    	$this->language->load('search/search');
		$this->load->model('catalog/category');
		$this->load->model('search/search');
		$this->load->model('tool/image'); 
		
	
		$filter_name=isset($this->request->get['filter_name'])?$this->request->get['filter_name']:'新';
		$sort=isset($this->request->get['sort'])?$this->request->get['sort']:'p.sort_order';
	    $order=isset($this->request->get['order'])?$this->request->get['order']:'ASC';
  		$page=isset($this->request->get['page'])?$this->request->get['page']:1;
	    $limit=isset($this->request->get['limit'])?$this->request->get['limit']:15; //$limit = $this->config->get('config_catalog_limit');
	
		if (!empty($filter_name)) {
			$this->document->setTitle($this->language->get('heading_title') .  ' - ' . $filter_name);
		} else {
			$this->document->setTitle($this->language->get('heading_title'));
		}

		
		$url = '';
		if (!empty($filter_name)) 	$url .= '&filter_name=' . urlencode(html_entity_decode($filter_name, ENT_QUOTES, 'UTF-8'));		
		if (!empty($this->request->get['limit'])) 	$url .= '&limit=' . $this->request->get['limit'];
					
		$this->data['sorts'] = array();
		
		$this->data['sorts'][] = array(
			'text'  => $this->language->get('text_default'),
			'value' => 'p.sort_order-ASC',
			'href'  => $this->url->link('search/search', 'sort=p.sort_order&order=ASC' . $url)
		);
		
		$this->data['sorts'][] = array(
			'text'  => $this->language->get('text_name_asc'),
			'value' => 'pd.name-ASC',
			'href'  => $this->url->link('search/search', 'sort=pd.name&order=ASC' . $url)
		); 

		$this->data['sorts'][] = array(
			'text'  => $this->language->get('text_name_desc'),
			'value' => 'pd.name-DESC',
			'href'  => $this->url->link('search/search', 'sort=pd.name&order=DESC' . $url)
		);

		$this->data['sorts'][] = array(
			'text'  => $this->language->get('text_price_asc'),
			'value' => 'p.price-ASC',
			'href'  => $this->url->link('search/search', 'sort=p.price&order=ASC' . $url)
		); 

		$this->data['sorts'][] = array(
			'text'  => $this->language->get('text_price_desc'),
			'value' => 'p.price-DESC',
			'href'  => $this->url->link('search/search', 'sort=p.price&order=DESC' . $url)
		); 
		
		if ($this->config->get('config_review_status')) {
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_rating_desc'),
				'value' => 'rating-DESC',
				'href'  => $this->url->link('search/search', 'sort=rating&order=DESC' . $url)
			); 
			
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_rating_asc'),
				'value' => 'rating-ASC',
				'href'  => $this->url->link('search/search', 'sort=rating&order=ASC' . $url)
			);
		}
		
		$this->data['sorts'][] = array(
			'text'  => $this->language->get('text_model_asc'),
			'value' => 'p.model-ASC',
			'href'  => $this->url->link('search/search', 'sort=p.model&order=ASC' . $url)
		); 

		$this->data['sorts'][] = array(
			'text'  => $this->language->get('text_model_desc'),
			'value' => 'p.model-DESC',
			'href'  => $this->url->link('search/search', 'sort=p.model&order=DESC' . $url)
		);

		$url = '';
		
		if (isset($filter_name)) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($filter_name, ENT_QUOTES, 'UTF-8'));
		}
		
		
					
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}	

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		$this->data['limits'] = array();
		
		/* $this->data['limits'][] = array(
			'text'  => $this->config->get('config_catalog_limit'),
			'value' => $this->config->get('config_catalog_limit'),
			'href'  => $this->url->link('search/search', $url . '&limit=' . $this->config->get('config_catalog_limit'))
		); */
		
		$this->data['limits'][] = array(
			'text'  => 15,
			'value' => 15,
			'href'  => $this->url->link('search/search', $url . '&limit=15')
		);
					
		$this->data['limits'][] = array(
			'text'  => 25,
			'value' => 25,
			'href'  => $this->url->link('search/search', $url . '&limit=25')
		);
		
		$this->data['limits'][] = array(
			'text'  => 50,
			'value' => 50,
			'href'  => $this->url->link('search/search', $url . '&limit=50')
		);

		$this->data['limits'][] = array(
			'text'  => 75,
			'value' => 75,
			'href'  => $this->url->link('search/search', $url . '&limit=75')
		);
		
		$this->data['limits'][] = array(
			'text'  => 100,
			'value' => 100,
			'href'  => $this->url->link('search/search', $url . '&limit=100')
		);
				
		
		$this->data['products'] = array();
		$this->data['pagination']=array();
		
		if (!empty($filter_name)) {
			$data = array(
				'filter_name'         => $filter_name, 
				//'filter_tag'          => $filter_tag, 
				//'filter_description'  => $filter_description,
				//'filter_category_id'  => $filter_category_id, 
				//'filter_sub_category' => $filter_sub_category, 
				'sort'                => $sort,
				'order'               => $order,
				'start'               => ($page - 1) * $limit,
				'limit'               => $limit
			);
					
			$product_total = $this->model_search_search->getTotalProducts($data);
							
			$results = $this->model_search_search->getProducts($data);
					
			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], 182, 182);
				} else {
					$image = false;
				}
				
				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price =number_format($result['price'],2,'.',',');
				} else {
					$price = false;
				}
				
				if ((float)$result['special']) {
					$special = number_format($result['special'],2,'.',',');
				} else {
					$special = false;
				}	
				
				
				if ($this->config->get('config_review_status')) {
					$rating = (int)$result['rating'];
				} else {
					$rating = false;
				}
			
				$this->data['products'][] = array(
					'product_id'  => $result['product_id'],
					'thumb'       => $image,
					'shortname'   => utf8_substr($result['name'], 0, 10) . '...',
					'name'        => $result['name'],
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..',
					'price'       => $price,
					'hots'        => $result['hots'],
					'special'     => $special,
					'rating'      => $result['rating'],
					'reviews'     => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
					'href'        => $this->url->link('product/product',  '&product_id=' . $result['product_id'])
				);
			}
					
			$url = '';

			if (isset($filter_name)) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($filter_name, ENT_QUOTES, 'UTF-8'));
			}
			
			
										
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}	

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
			
					
			$pagination = new Pagination('results','links');
			$pagination->total = $product_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->text = $this->language->get('text_pagination');
			$pagination->url = $this->url->link('search/search', $url . '&page={page}');
			
			$this->data['pagination'] = $pagination->render();
		}	
		$results=null;
		
		
		//店铺热卖产品
		$this->data['hotProduct']=array();
		$results=$this->model_search_search->getHotSaleProduct();
		foreach ($results as $result) {
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], 182, 182);
			} else {
				$image = false;
			}
			
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$price =number_format($result['price'],2,'.',',');
			} else {
				$price = false;
			}
			
			$this->data['hotProduct'][]=array(
			    'product_id'  => $result['product_id'],
				'thumb'       => $image,
				'shortname'   => utf8_substr($result['name'], 0, 13) . '...',
				'name'        => $result['name'],
				'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..',
				'price'       => $price,
				'hots'        => $result['hots'],
				//'special'     => $special,
				'rating'      => $result['rating'],
				'reviews'     => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
				'href'        => $this->url->link('product/product', $url . '&product_id=' . $result['product_id'])
			
			);
		}	
		$results=null;
		
		$this->data['referer']   ="index.php?route=search/search&filter_name={$filter_name}";
		$this->data['customer_id']=$this->customer->isLogged();
		$this->data['button_search'] = $this->language->get('button_search');
		$this->data['button_cart'] = $this->language->get('button_cart');
		$this->data['button_wishlist'] = $this->language->get('button_wishlist');
		$this->data['button_compare'] = $this->language->get('button_compare');
		$this->data['text_display'] = $this->language->get('text_display');
		$this->data['text_list'] = $this->language->get('text_list');
		$this->data['text_grid'] = $this->language->get('text_grid');	
		$this->data['filter_name'] = $filter_name;
		$this->data['limit']=$limit;
		$this->data['total']=isset($product_total)?$product_total:0;
		$end=$this->microtime_float();
		$this->data['spend']=$end-$start;
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/search/search.html')) {
			$this->template = $this->config->get('config_template') . '/template/search/search.html';
		} else {
			$this->template = 'default/template/search/search.html';
		}
		
		$this->children = array(
			'common/footer',
			'common/header'
		);
				
		$this->response->setOutput($this->render());
  	}
	
	function microtime_float(){
		list($usec, $sec) = explode(" ", microtime());
		return ((float)$usec + (float)$sec);
	}
}
?>