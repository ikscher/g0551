<?php 
class ControllerCatalogProduct extends Controller {
	private $error = array(); 
     
  	public function index() {
		$this->load->language('catalog/product');
    	
		$this->document->setTitle($this->language->get('heading_title')); 
		
		$this->load->model('catalog/product');
		
		$this->getList();
  	}
  
  	public function insert() {
    	$this->load->language('catalog/product');

    	$this->document->setTitle($this->language->get('heading_title')); 
		
		$this->data['refresh'] = $this->url->link('catalog/product/insert', 'token=' . $this->session->data['token'] , 'SSL');
        $this->data['cancel'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token']  , 'SSL');
		
		
		$this->load->model('catalog/product');
		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
		    
			$this->model_catalog_product->addProduct($this->request->post);
	  		
			$this->session->data['success'] = $this->language->get('text_success');
	  
			$url = '';
			
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}
		
			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . $this->request->get['filter_price'];
			}
			
			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
			}
			
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}
					
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->redirect($this->url->link('catalog/product/insert', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    	}
	
    	$this->getForm();
  	}
    
	/**
	*   修改产品
	*/
  	public function update() {
    	$this->load->language('catalog/product');

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/product');
	    
		$this->data['refresh']=$this->url->link('catalog/product/update', 'token=' . $this->session->data['token'] . '&product_id=' . $this->request->get['product_id'] , 'SSL');
		$this->data['cancel'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token']  , 'SSL');
		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_product->editProduct($this->request->get['product_id'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';
			
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}
		
			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . $this->request->get['filter_price'];
			}
			
			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
			}	
		
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}
					
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&product_id=' . $this->request->get['product_id'], 'SSL'));
		}

    	$this->getForm();
  	}

  	public function delete() {
    	$this->load->language('catalog/product');

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/product');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $product_id) {
				$this->model_catalog_product->deleteProduct($product_id);
	  		}

			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';
			
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}
		
			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . $this->request->get['filter_price'];
			}
			
			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
			}	
		
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}
					
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

    	$this->getList();
  	}

  	public function copy() {
    	$this->load->language('catalog/product');

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/product');
		
		if (isset($this->request->post['selected']) && $this->validateCopy()) {
			foreach ($this->request->post['selected'] as $product_id) {
				$this->model_catalog_product->copyProduct($product_id);
	  		}

			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';
			
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}
		  
			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . $this->request->get['filter_price'];
			}
			
			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
			}	
		
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}
					
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

    	$this->getList();
  	}
	
	/**
	*    商品列表
	*/
  	private function getList() {		
	    $filter_id=isset($this->request->get['filter_id'])?$this->request->get['filter_id']:null;

        $filter_name=isset($this->request->get['filter_name'])?$this->request->get['filter_name']:null	;

		$filter_model=isset($this->request->get['filter_model'])?$this->request->get['filter_model']:null	;

		$filter_price=isset($this->request->get['filter_price'])?$this->request->get['filter_price']:null	;

        $filter_category_id=isset($this->request->get['filter_category_id'])?$this->request->get['filter_category_id']:null;

		$filter_sub_category = isset($this->request->get['filter_sub_category'])?$this->request->get['filter_sub_category']:'';
       
        $filter_status=isset($this->request->get['filter_status'])?$this->request->get['filter_status']:null;

        $sort=isset($this->request->get['sort'])?$this->request->get['sort']:'pd.name';

		$order=isset($this->request->get['order'])?$this->request->get['order']:'ASC';

		$page=isset($this->request->get['page'])?$this->request->get['page']:1;
			
		$url = '';
		if(isset($filter_id)) $url .= '&filter_id=' . urlencode(html_entity_decode($filter_id, ENT_QUOTES, 'UTF-8'));
		if(isset($filter_name)) $url .= '&filter_name=' . urlencode(html_entity_decode($filter_name, ENT_QUOTES, 'UTF-8'));
	    if(isset($filter_model)) $url .= '&filter_model=' . urlencode(html_entity_decode($filter_model, ENT_QUOTES, 'UTF-8'));
	    if(isset($filter_price)) $url .= '&filter_price=' . $filter_price;
		if(isset($filter_category_id)) $url .= '&filter_category_id=' . $filter_category_id;
		if(isset($filter_sub_category)) $url .= '&filter_sub_category=' . $filter_sub_category;
        if(isset($filter_status)) $url .= '&filter_status=' . $filter_status;
		if(isset($order)) $url .= '&order=' . $order;
	    if(isset($page)) $url .= '&page=' . $page;
		if(isset($sort)) $url .= '&sort=' . $sort;
	
		$urlnopage=preg_replace("/&page=(\w)*/","",$url);
		

  		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$server = HTTP_CATALOG;
		} else {
			$server = HTTP_CATALOG;
		}
		
		$this->data['insert'] = $this->url->link('catalog/product/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['copy'] = $this->url->link('catalog/product/copy', 'token=' . $this->session->data['token'] . $url, 'SSL');	
		$this->data['delete'] = $this->url->link('catalog/product/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['refresh']=$this->url->link('catalog/product', 'token=' . $this->session->data['token'] , 'SSL');
    	
		$this->data['products'] = array();

		$data = array(
		    'filter_id'       => $filter_id,
			'filter_name'	  => $filter_name, 
			'filter_model'	  => $filter_model,
			'filter_price'	  => $filter_price,
			'filter_category_id' => $filter_category_id,
			'filter_sub_category' => $filter_sub_category,
			'filter_status'   => $filter_status,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'           => $this->config->get('config_admin_limit')
		);

		$this->load->model('tool/image');
		
		$product_total = $this->model_catalog_product->getTotalProducts($data);

			
		$results = $this->model_catalog_product->getProducts($data);
	
		foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('catalog/product/update', 'token=' . $this->session->data['token'] . '&product_id=' . $result['product_id'] , 'SSL')
			);
			
			if ($result['image'] && file_exists(DIR_IMAGE . $result['image'])) {
				$image = $this->model_tool_image->resize($result['image'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.jpg', 40, 40);
			}
	
			$special = false;
			
			$product_specials = $this->model_catalog_product->getProductSpecials($result['product_id']);
			
			$time1=strtotime(date('Y-m-d'));
			$time2=strtotime("+1 day",$time1);
			foreach ($product_specials  as $product_special) {
				if (($product_special['date_start'] == 0 || ($product_special['date_start'] < $time2)) && ($product_special['date_end'] == 0 || $product_special['date_end'] > $time2)) {
					$special = $product_special['price'];
			
					break;
				}					
			}
	
      		$this->data['products'][] = array(
				'product_id' => $result['product_id'],
				'name'       => $result['name'],
				'model'      => $result['model'],
				'price'      => $result['price'],
				'special'    => $special,
				'image'      => $image,
				'quantity'   => $result['quantity'],
				'status'     => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'selected'   => isset($this->request->post['selected']) && in_array($result['product_id'], $this->request->post['selected']),
				'action'     => $action,
				'href'       => $server.'index.php?route=product/product&product_id='.$result['product_id']
			);
    	}
		
		
		//分类
		$this->load->model('catalog/category');
		$categories = $this->model_catalog_category->getCategories(0);//从根目录开始
		$this->data['categories'] = $categories;
		
	
		$this->data['heading_title'] = $this->language->get('heading_title');		
		$this->data['text_enabled'] = $this->language->get('text_enabled');		
		$this->data['text_disabled'] = $this->language->get('text_disabled');		
		$this->data['text_no_results'] = $this->language->get('text_no_results');		
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');		
		$this->data['column_image'] = $this->language->get('column_image');
        $this->data['column_id'] = $this->language->get('column_id');				
		$this->data['column_name'] = $this->language->get('column_name');		
		$this->data['column_model'] = $this->language->get('column_model');		
		$this->data['column_price'] = $this->language->get('column_price');		
		$this->data['column_category'] = $this->language->get('column_category');		
		$this->data['column_sub_category'] = $this->language->get('column_sub_category');
		$this->data['column_quantity'] = $this->language->get('column_quantity');
		$this->data['column_status'] = $this->language->get('column_status');		
		$this->data['column_action'] = $this->language->get('column_action');		
		$this->data['button_copy'] = $this->language->get('button_copy');		
		$this->data['button_insert'] = $this->language->get('button_insert');		
		$this->data['button_delete'] = $this->language->get('button_delete');	
        $this->data['button_refresh'] = $this->language->get('button_refresh');			
		$this->data['button_filter'] = $this->language->get('button_filter');
 		$this->data['token'] = $this->session->data['token'];
		
	
		
					
		/* $this->data['sort_name'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['sort_model'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['sort_price'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['sort_quantity'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['sort_status'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['sort_order'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, 'SSL'); */
		
	    
		$pagination = new Pagination('results','links');
		$pagination->total = $product_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $urlnopage . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();
		
        $this->data['filter_id'] = $filter_id;
		$this->data['filter_name'] = $filter_name;
		$this->data['filter_model'] = $filter_model;
		$this->data['filter_price'] = $filter_price;
		$this->data['filter_category_id'] = $filter_category_id;
		$this->data['filter_sub_category']= $filter_sub_category;
		$this->data['filter_status'] = $filter_status;
		
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'catalog/product_list.html';
		/* $this->children = array(
			'common/header',
			'common/footer'
		); */
		
		$this->response->setOutput($this->render());
  	}
    
	/**
	*  表单
	*/
  	private function getForm() {
	
	    $this->load->language('catalog/product');
	    	
	    $this->data['error_warning'] =isset($this->error['warning'])?$this->error['warning']:'';
 

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
			 unset($this->session->data['success']);
		} else {
			 $this->data['success'] = '';
		}
		
    	$this->data['heading_title'] = $this->language->get('heading_title');
 
    	$this->data['text_enabled'] = $this->language->get('text_enabled');
    	$this->data['text_disabled'] = $this->language->get('text_disabled');
    	$this->data['text_none'] = $this->language->get('text_none');
    	$this->data['text_yes'] = $this->language->get('text_yes');
    	$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_select_all'] = $this->language->get('text_select_all');
		$this->data['text_unselect_all'] = $this->language->get('text_unselect_all');
		$this->data['text_plus'] = $this->language->get('text_plus');
		$this->data['text_minus'] = $this->language->get('text_minus');
		$this->data['text_default'] = $this->language->get('text_default');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		$this->data['text_browse'] = $this->language->get('text_browse');
		$this->data['text_clear'] = $this->language->get('text_clear');
		$this->data['text_option'] = $this->language->get('text_option');
		$this->data['text_option_value'] = $this->language->get('text_option_value');
		$this->data['text_select'] = $this->language->get('text_select');
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_percent'] = $this->language->get('text_percent');
		$this->data['text_amount'] = $this->language->get('text_amount');

		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$this->data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
		$this->data['entry_description'] = $this->language->get('entry_description');
		$this->data['entry_store'] = $this->language->get('entry_store');
		$this->data['entry_keyword'] = $this->language->get('entry_keyword');
    	$this->data['entry_model'] = $this->language->get('entry_model');
		$this->data['entry_sku'] = $this->language->get('entry_sku');
		$this->data['entry_upc'] = $this->language->get('entry_upc');
		$this->data['entry_ean'] = $this->language->get('entry_ean');
		$this->data['entry_jan'] = $this->language->get('entry_jan');
		$this->data['entry_isbn'] = $this->language->get('entry_isbn');
		$this->data['entry_mpn'] = $this->language->get('entry_mpn');
		$this->data['entry_location'] = $this->language->get('entry_location');
		$this->data['entry_minimum'] = $this->language->get('entry_minimum');
		$this->data['entry_manufacturer'] = $this->language->get('entry_manufacturer');
    	$this->data['entry_shipping'] = $this->language->get('entry_shipping');
    	$this->data['entry_date_available'] = $this->language->get('entry_date_available');
    	$this->data['entry_quantity'] = $this->language->get('entry_quantity');
		$this->data['entry_stock_status'] = $this->language->get('entry_stock_status');
    	$this->data['entry_price'] = $this->language->get('entry_price');
		$this->data['entry_tax_class'] = $this->language->get('entry_tax_class');
		$this->data['entry_points'] = $this->language->get('entry_points');
		$this->data['entry_option_points'] = $this->language->get('entry_option_points');
		$this->data['entry_subtract'] = $this->language->get('entry_subtract');
    	$this->data['entry_weight_class'] = $this->language->get('entry_weight_class');
    	$this->data['entry_weight'] = $this->language->get('entry_weight');
		$this->data['entry_dimension'] = $this->language->get('entry_dimension');
		$this->data['entry_length'] = $this->language->get('entry_length');
    	$this->data['entry_image'] = $this->language->get('entry_image');
    	$this->data['entry_download'] = $this->language->get('entry_download');
	    $this->data['entry_attribute_group'] = $this->language->get('entry_attribute_group');
    	$this->data['entry_category'] = $this->language->get('entry_category');
		$this->data['entry_related'] = $this->language->get('entry_related');
		$this->data['entry_attribute'] = $this->language->get('entry_attribute');
		$this->data['entry_text'] = $this->language->get('entry_text');
		$this->data['entry_option'] = $this->language->get('entry_option');
		$this->data['entry_option_value'] = $this->language->get('entry_option_value');
		$this->data['entry_required'] = $this->language->get('entry_required');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_customer_group'] = $this->language->get('entry_member_group');
		$this->data['entry_date_start'] = $this->language->get('entry_date_start');
		$this->data['entry_date_end'] = $this->language->get('entry_date_end');
		$this->data['entry_priority'] = $this->language->get('entry_priority');
		$this->data['entry_tag'] = $this->language->get('entry_tag');
		$this->data['entry_customer_group'] = $this->language->get('entry_member_group');
		$this->data['entry_reward'] = $this->language->get('entry_reward');
		$this->data['entry_layout'] = $this->language->get('entry_layout');
				
    	$this->data['button_save'] = $this->language->get('button_save');
    	$this->data['button_refresh'] = $this->language->get('button_refresh');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_attribute'] = $this->language->get('button_add_attribute');
		$this->data['button_add_option'] = $this->language->get('button_add_option');
		$this->data['button_add_option_value'] = $this->language->get('button_add_option_value');
		$this->data['button_add_discount'] = $this->language->get('button_add_discount');
		$this->data['button_add_special'] = $this->language->get('button_add_special');
		$this->data['button_add_image'] = $this->language->get('button_add_image');
		$this->data['button_remove'] = $this->language->get('button_remove');
		
    	$this->data['tab_general'] = $this->language->get('tab_general');
    	$this->data['tab_data'] = $this->language->get('tab_data');
		$this->data['tab_attribute'] = $this->language->get('tab_attribute');
		$this->data['tab_option'] = $this->language->get('tab_option');		
		$this->data['tab_discount'] = $this->language->get('tab_discount');
		$this->data['tab_special'] = $this->language->get('tab_special');
    	$this->data['tab_image'] = $this->language->get('tab_image');		
		$this->data['tab_links'] = $this->language->get('tab_links');
		$this->data['tab_reward'] = $this->language->get('tab_reward');
		$this->data['tab_design'] = $this->language->get('tab_design');
		 
		$this->data['error_warning']=isset($this->error['warning'])?$this->error['warning']:'';
		$this->data['error_name'] = isset($this->error['name'])?$this->error['name']:array();
        $this->data['error_meta_description'] = isset($this->error['meta_description'])?$this->error['meta_description']:array();
 		$this->data['error_description'] = isset($this->error['description'])?$this->error['description']:array();	
        $this->data['error_model'] = isset($this->error['model'])?$this->error['model']:'';
	    $this->data['error_date_available'] = isset($this->error['date_available'])?$this->error['date_available']:'';
  
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}
		
		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}	
		
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
								
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

  	
									
		if (!isset($this->request->get['product_id'])) {
			$this->data['action'] = $this->url->link('catalog/product/insert', 'token=' . $this->session->data['token'] , 'SSL');
			$this->data['productId']='';
		} else {
			$this->data['action'] = $this->url->link('catalog/product/update', 'token=' . $this->session->data['token'] . '&product_id=' . $this->request->get['product_id'] , 'SSL');
			$this->data['productId']=$this->request->get['product_id'];
		}
		
		
		if (isset($this->request->get['product_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$product_info = $this->model_catalog_product->getProduct($this->request->get['product_id']);
    	}

		$this->data['token'] = $this->session->data['token'];
		
	    $product_description=array();
		if (isset($this->request->post['product_description'])) {
			$product_description = $this->request->post['product_description'];
		} elseif (isset($this->request->get['product_id'])) {
		    
			$product_description = $this->model_catalog_product->getProductDescriptions($this->request->get['product_id']);
		} else {
			$product_description = array();
		}
		
		if(!empty($product_description)){
			if(preg_match('/(jpg|bmp|gif|png)/',$product_description['description'])){

				 $product_description['description']=preg_replace("/(src)\s*=\s*([a-zA-Z0-9\/_]*)/",'${1}='.HTTP_CATALOG.'${2}',$product_description['description']);
				 $product_description['description']=preg_replace("/\\\"/", '',$product_description['description']);
		        
			}
			$product_description['description']=htmlspecialchars_decode($product_description['description']);
		}
		//print_r($product_description);
		$this->data['product_description']=$product_description;
		$this->data['model'] = isset($this->request->post['model'])?$this->request->post['model']:(!empty($product_info)?$product_info['model']:'');
		
        $this->data['sku'] = isset($this->request->post['sku'])?$this->request->post['sku']:(!empty($product_info)?$product_info['sku']:'');
	
		$this->data['upc'] = isset($this->request->post['upc'])?$this->request->post['upc']:(!empty($product_info)?$product_info['upc']:'');
						
		$this->data['location'] = isset($this->request->post['location'])?$this->request->post['location']:(!empty($product_info)?$product_info['location']:'');		
	

		$this->load->model('setting/store');
		
		$this->data['stores'] = $this->model_setting_store->getStores();
	
		if (isset($this->request->post['product_store'])) {
			$this->data['product_store'] = $this->request->post['product_store'];
		} elseif (isset($this->request->get['product_id'])) {
			$this->data['product_store'] = $this->model_catalog_product->getProductStores($this->request->get['product_id']);
		} else {
			$this->data['product_store'] = array(0);
		}	
		
		$this->data['keyword'] = isset($this->request->post['keyword'])? $this->request->post['keyword']:(!empty($product_info)?$product_info['keyword']:'');
	
		$this->data['image'] = isset($this->request->post['image'])?$this->request->post['image']:(!empty($product_info)?$product_info['image']:'');
	
		
		$this->load->model('tool/image');
		
		if (isset($this->request->post['image']) && file_exists(DIR_IMAGE . $this->request->post['image'])) {
			$this->data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($product_info) && $product_info['image'] && file_exists(DIR_IMAGE . $product_info['image'])) {
			$this->data['thumb'] = $this->model_tool_image->resize($product_info['image'], 100, 100);
		} else {
			$this->data['thumb'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
	
		$this->load->model('catalog/manufacturer');
		
    	$this->data['manufacturers'] = $this->model_catalog_manufacturer->getManufacturers();
        
		$this->data['manufacturer_id'] = isset($this->request->post['manufacturer_id'])?$this->request->post['manufacturer_id']:(!empty($product_info)?$product_info['manufacturer_id']:'');
    
		$this->data['shipping'] = isset($this->request->post['shipping'])?$this->request->post['shipping']:(!empty($product_info)?$product_info['shipping']:1);
   
		$this->data['price'] = isset($this->request->post['price'])?$this->request->post['price']:(!empty($product_info)?$product_info['price']:'');
    
	
		
        $this->data['date_available'] = isset($this->request->post['date_available'])? $this->request->post['date_available']:(!empty($product_info)?date('Y-m-d',$product_info['date_available']):date('Y-m-d',time()-86400));    	

		$this->data['quantity'] = isset($this->request->post['quantity'])?$this->request->post['quantity']:(!empty($product_info)?$product_info['quantity']:1);									

		$this->data['minimum'] = isset($this->request->post['minimum'])?$this->request->post['minimum']:(!empty($product_info)?$product_info['minimum']:1);

		$this->data['subtract'] = isset($this->request->post['subtract'])?$this->request->post['subtract']:(!empty($product_info)?$product_info['subtract']:1);
        $this->data['sort_order'] = isset($this->request->post['sort_order'])?$this->request->post['sort_order']:(!empty($product_info)?$product_info['sort_order']:1);
		

		$this->load->model('localisation/stock_status');
		
		$this->data['stock_statuses'] = $this->model_localisation_stock_status->getStockStatuses();
	
    	
		$this->data['stock_status_id'] = isset($this->request->post['stock_status_id'])?$this->request->post['stock_status_id']:(!empty($product_info)?$product_info['stock_status_id']:$this->config->get('config_stock_status_id'));

		$this->data['status'] = isset($this->request->post['status'])?$this->request->post['status']:(!empty($product_info)?$product_info['status']:1);		
    
        $this->data['weight'] = isset($this->request->post['weight'])? $this->request->post['weight']:(!empty($product_info)?$product_info['weight']:'');
    
		
		$this->load->model('localisation/weight_class');
		
		$this->data['weight_classes'] = $this->model_localisation_weight_class->getWeightClasses();
    	
		$this->data['weight_class_id'] = isset($this->request->post['weight_class_id'])?$this->request->post['weight_class_id']:(!empty($product_info)? $product_info['weight_class_id']:$this->config->get('config_weight_class_id'));

		$this->data['length'] = isset($this->request->post['length'])?$this->request->post['length']:(!empty($product_info)?$product_info['length']:'');
	
		$this->data['width'] = isset($this->request->post['width'])?$this->request->post['width']:(!empty($product_info)?$product_info['width']:'');
	
		$this->data['height'] = isset($this->request->post['height'])?$this->request->post['height']:(!empty($product_info)?$product_info['height']:'');
	

		$this->load->model('localisation/length_class');
		
		$this->data['length_classes'] = $this->model_localisation_length_class->getLengthClasses();
    	
		$this->data['length_class_id'] = isset($this->request->post['length_class_id'])?$this->request->post['length_class_id']:(!empty($product_info)?$product_info['length_class_id']:$this->config->get('config_length_class_id'));
	
        
		if (isset($this->request->post['product_attribute'])) {
			$this->data['product_attributes'] = $this->request->post['product_attribute'];
		} elseif (isset($this->request->get['product_id'])) {
			$this->data['product_attributes'] = $this->model_catalog_product->getProductAttributes($this->request->get['product_id']);
		} else {
			$this->data['product_attributes'] = array();
		}
		
		
		//选项标签页 ：产品所在的属性组  model(getAttribute) option(getOptionValues) 需优化
		if(isset($this->request->get['product_id'])){
		    $this->load->model('catalog/product');
			$this->load->model('catalog/category');
			$this->load->model('catalog/attribute_group');
			$categoryId=$this->model_catalog_product->getProductCategories($this->request->get['product_id']);//产品属于的分类（包括子类和父类）
            
			$attribute_group='';
			if(!empty($categoryId)){
			    $results=array();
				$groups=array();
			    foreach($categoryId as $v){
			        $result=$this->model_catalog_category->getCategory($v);
					$result=array_filter($result,"filter");
					
					if(!empty($result['attribute_group'])) $groups[]=$result['attribute_group'];
			    }
			}

			if(!empty($groups)){
				$group=array_unique($groups);
				$attribute_group=implode(',',$group);
			}
			
			$attributeGroups=array();
			if(!empty($attribute_group)) $attributeGroups=$this->model_catalog_attribute_group->getAttributeGroupIn($attribute_group);
			$this->data['attributeGroups']=$attributeGroups;
		}
		
		
		
		$this->load->model('catalog/option');
		
		if (isset($this->request->post['product_option'])) {
			$product_options = $this->request->post['product_option'];
		} elseif (isset($this->request->get['product_id'])) {
			$product_options = $this->model_catalog_product->getProductOptions($this->request->get['product_id']);					
		} else {
			$product_options = array();
		}			
		
	
		$this->data['product_options'] = array();
	    
		foreach ($product_options as $product_option) {
			if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
				$product_option_value_data = array();
				
				if(!empty($product_option['product_option_value'])){
					foreach ($product_option['product_option_value'] as $product_option_value) {
						$product_option_value_data[] = array(
							'product_option_value_id' => $product_option_value['product_option_value_id'],
							'option_value_id'         => $product_option_value['option_value_id'],
							'attribute_id'            => $product_option_value['attribute_id'],
							'quantity'                => $product_option_value['quantity'],
							'name'                    => $product_option_value['name'],
							'subtract'                => $product_option_value['subtract'],
							'price'                   => $product_option_value['price'],
							'price_prefix'            => $product_option_value['price_prefix'],
							'points'                  => $product_option_value['points'],
							'points_prefix'           => $product_option_value['points_prefix'],						
							'weight'                  => $product_option_value['weight'],
							'weight_prefix'           => $product_option_value['weight_prefix']	
						);						
					}
				}
				
				$this->data['product_options'][] = array(
					'product_option_id'    => $product_option['product_option_id'],
					'product_option_value' => $product_option_value_data,
					'option_id'            => $product_option['option_id'],
					'name'                 => $product_option['name'],
					'attribute_group_id'   => isset($product_option['attribute_group_id'])?$product_option['attribute_group_id']:'',
					'attribute_group_name' => isset($product_option['attribute_group_name'])?$product_option['attribute_group_name']:'',
					'type'                 => $product_option['type'],
					'required'             => $product_option['required']
				);				
			} else {
				$this->data['product_options'][] = array(
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
     
		$this->data['option_values'] = array();
		
		foreach ($product_options as $product_option) {
			if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
				if (!isset($this->data['option_values'][$product_option['option_id']])) {
		
					$this->data['option_values'][$product_option['option_id']] = $this->model_catalog_option->getOptionValues($product_option['option_id']);
				}
			}
		} 
		
		
		$this->load->model('sale/customer_group');
		
		$this->data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();
		
		if (isset($this->request->post['product_discount'])) {
			$this->data['product_discounts'] = $this->request->post['product_discount'];
		} elseif (isset($this->request->get['product_id'])) {
			$this->data['product_discounts'] = $this->model_catalog_product->getProductDiscounts($this->request->get['product_id']);
		} else {
			$this->data['product_discounts'] = array();
		}

		if (isset($this->request->post['product_special'])) {
			$this->data['product_specials'] = $this->request->post['product_special'];
		} elseif (isset($this->request->get['product_id'])) {
			$this->data['product_specials'] = $this->model_catalog_product->getProductSpecials($this->request->get['product_id']);
		} else {
			$this->data['product_specials'] = array();
		}
		
		if (isset($this->request->post['product_image'])) {
			$product_images = $this->request->post['product_image'];
		} elseif (isset($this->request->get['product_id'])) {
			$product_images = $this->model_catalog_product->getProductImages($this->request->get['product_id']);
		} else {
			$product_images = array();
		}
		
		$this->data['product_images'] = array();
		
		foreach ($product_images as $product_image) {
			if ($product_image['image'] && file_exists(DIR_IMAGE . $product_image['image'])) {
				$image = $product_image['image'];
			} else {
				$image = 'no_image.jpg';
			}
			
			$this->data['product_images'][] = array(
			    'product_image_id' =>$product_image['product_image_id'],
				'image'      => $image,
				'date_added' => date('Y-m-d',$product_image['date_added']),
				'thumb'      => $this->model_tool_image->resize($image, 100, 100),
				'sort_order' => $product_image['sort_order']
			);
		}

		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);

		$this->load->model('catalog/download');
		
		$this->data['downloads'] = $this->model_catalog_download->getDownloads();
		
		if (isset($this->request->post['product_download'])) {
			$this->data['product_download'] = $this->request->post['product_download'];
		} elseif (isset($this->request->get['product_id'])) {
			$this->data['product_download'] = $this->model_catalog_product->getProductDownloads($this->request->get['product_id']);
		} else {
			$this->data['product_download'] = array();
		}		
		
		$this->load->model('catalog/category');
		
        //$pid=array('pid'=>0);		
		//$this->data['categories'] = $this->model_catalog_category->getCategories($pid);
		
		
		
		
		if (isset($this->request->post['product_category'])) {
			$this->data['product_category'] = $this->request->post['product_category'];
		} elseif (isset($this->request->get['product_id'])) {
			$this->data['product_category'] = $this->model_catalog_product->getProductCategories($this->request->get['product_id']);
		} else {
			$this->data['product_category'] = array();
		}	
        
		//分类按照层级排序 top
		$this->data['category_dir']=array();
		if(!empty($this->data['product_category'])){
			$category_dir=array();
			foreach($this->data['product_category'] as $category_id){
			    if(empty($category_id)) continue;
				$category_result=$this->model_catalog_category->getCategory($category_id);
				$category_dir[$category_result['top']]=$category_id;
			}	
			
			foreach($category_dir as $k=>$v){
				$x=$this->model_catalog_category->getChildCategory($v);
				$this->data['category_dir'][]=$x;
			}
			
		    $len=sizeof($this->data['category_dir']);
			if($len<4){
			    for(;$len<4;$len++){
			       $this->data['category_dir'][$len]=array();
				}
			}
			
			if(!empty($this->data['category_dir'])) array_pop($this->data['category_dir']);
			array_unshift($this->data['category_dir'],$this->model_catalog_category->getChildCategory(0));
			
			/* $this->data['firstDir']=$this->model_catalog_category->getChildCategory(0);
			$this->data['secondDir']=$this->model_catalog_category->getChildCategory($category_dir[1]);
			$this->data['thirdDir']=$this->model_catalog_category->getChildCategory($category_dir[2]);
			$this->data['forthDir']=$this->model_catalog_category->getChildCategory($category_dir[3]); */
		}else{
		    $this->data['category_dir'][0]=$this->model_catalog_category->getChildCategory(0);
			$this->data['category_dir'][1]=array();
			$this->data['category_dir'][2]=array();
			$this->data['category_dir'][3]=array();
		}
	    		
		
		if (isset($this->request->post['product_related'])) {
			$products = $this->request->post['product_related'];
		} elseif (isset($this->request->get['product_id'])) {		
			$products = $this->model_catalog_product->getProductRelated($this->request->get['product_id']);
		} else {
			$products = array();
		}
	
		$this->data['product_related'] = array();
		
		foreach ($products as $product_id) {
			$related_info = $this->model_catalog_product->getProduct($product_id);
			
			if ($related_info) {
				$this->data['product_related'][] = array(
					'product_id' => $related_info['product_id'],
					'name'       => $related_info['name']
				);
			}
		}

    	if (isset($this->request->post['points'])) {
      		$this->data['points'] = $this->request->post['points'];
    	} elseif (!empty($product_info)) {
			$this->data['points'] = $product_info['points'];
		} else {
      		$this->data['points'] = '';
    	}
						
		if (isset($this->request->post['product_reward'])) {
			$this->data['product_reward'] = $this->request->post['product_reward'];
		} elseif (isset($this->request->get['product_id'])) {
			$this->data['product_reward'] = $this->model_catalog_product->getProductRewards($this->request->get['product_id']);
		} else {
			$this->data['product_reward'] = array();
		}
		
		/* if (isset($this->request->post['product_layout'])) {
			$this->data['product_layout'] = $this->request->post['product_layout'];
		} elseif (isset($this->request->get['product_id'])) {
			$this->data['product_layout'] = $this->model_catalog_product->getProductLayouts($this->request->get['product_id']);
		} else {
			$this->data['product_layout'] = array();
		}

		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts(); */
										
		$this->template = 'catalog/product_form.html';
		/* $this->children = array(
			'common/header',
			'common/footer'
		); */
				
		$this->response->setOutput($this->render());
  	} 
	
  	private function validateForm() { 
    	if (!$this->user->hasPermission('modify', 'catalog/product')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}
        
		$value=$this->request->post['product_description'] ;
    	if ($value){
			if ((utf8_strlen($value['name']) < 1) || (utf8_strlen($value['name']) > 255)) {
				$this->error['name'] = $this->language->get('error_name');
			}
    	}
		
    	if ((utf8_strlen($this->request->post['model']) < 1) || (utf8_strlen($this->request->post['model']) > 64)) {
      		$this->error['model'] = $this->language->get('error_model');
    	}
		
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
					
    	if (!$this->error) {
			return true;
    	} else {
      		return false;
    	}
  	}
	
  	private function validateDelete() {
    	if (!$this->user->hasPermission('modify', 'catalog/product')) {
      		$this->error['warning'] = $this->language->get('error_permission');  
    	}
		
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}
  	
  	private function validateCopy() {
    	if (!$this->user->hasPermission('modify', 'catalog/product')) {
      		$this->error['warning'] = $this->language->get('error_permission');  
    	}
		
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}
		
	public function autocomplete() {
		$json = array();
		
		if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_model']) || isset($this->request->get['filter_category_id'])) {
			$this->load->model('catalog/product');
			
			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}
			
			if (isset($this->request->get['filter_model'])) {
				$filter_model = $this->request->get['filter_model'];
			} else {
				$filter_model = '';
			}
						
			if (isset($this->request->get['filter_category_id'])) {
				$filter_category_id = $this->request->get['filter_category_id'];
			} else {
				$filter_category_id = '';
			}
			
			if (isset($this->request->get['filter_sub_category'])) {
				$filter_sub_category = $this->request->get['filter_sub_category'];
			} else {
				$filter_sub_category = '';
			}
			
			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];	
			} else {
				$limit = 20;	
			}			
						
			$data = array(
				'filter_name'         => $filter_name,
				'filter_model'        => $filter_model,
				'filter_category_id'  => $filter_category_id,
				'filter_sub_category' => $filter_sub_category,
				'start'               => 0,
				'limit'               => $limit
			);
			
			$results = $this->model_catalog_product->getProducts($data);
			
			foreach ($results as $result) {
				$option_data = array();
				
				$product_options = $this->model_catalog_product->getProductOptions($result['product_id']);	
				
				foreach ($product_options as $product_option) {
					if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
						$option_value_data = array();
					
						foreach ($product_option['product_option_value'] as $product_option_value) {
							$option_value_data[] = array(
								'product_option_value_id' => $product_option_value['product_option_value_id'],
								'option_value_id'         => $product_option_value['option_value_id'],
								'name'                    => $product_option_value['name'],
								'price'                   => (float)$product_option_value['price'] ? $this->currency->format($product_option_value['price'], $this->config->get('config_currency')) : false,
								'price_prefix'            => $product_option_value['price_prefix']
							);	
						}
					
						$option_data[] = array(
							'product_option_id' => $product_option['product_option_id'],
							'option_id'         => $product_option['option_id'],
							'name'              => $product_option['name'],
							'type'              => $product_option['type'],
							'option_value'      => $option_value_data,
							'required'          => $product_option['required']
						);	
					} else {
						$option_data[] = array(
							'product_option_id' => $product_option['product_option_id'],
							'option_id'         => $product_option['option_id'],
							'name'              => $product_option['name'],
							'type'              => $product_option['type'],
							'option_value'      => $product_option['option_value'],
							'required'          => $product_option['required']
						);				
					}
				}
					
				$json[] = array(
					'product_id' => $result['product_id'],
					'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),	
					'model'      => $result['model'],
					'option'     => $option_data,
					'price'      => $result['price']
				);	
			}
		}

		$this->response->setOutput(json_encode($json));
	}
}
?>