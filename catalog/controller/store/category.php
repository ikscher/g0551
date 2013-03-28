<?php
class ControllerStoreCategory extends Controller {

	public function index(){

			$this->load->model('store/index');
			$this->load->model('tool/image');

			if(isset($this->request->get['store_id'])){
				$store_id = $this->request->get['store_id'];
			} else $store_id = 0;

			if(isset($this->request->get['parent_id'])){
				$parent_id = $this->request->get['parent_id'];
			} else $parent_id = 0;


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

			if(isset($this->request->get['category_id'])){

			$category_id = $this->request->get['category_id']; 
	
            $category = $this->model_store_index->getCategory($category_id);

            if(isset($category)){

			 $categories = $this->model_store_index->getCategories($store_id,$parent_id);
			 $this->data['categories'] = $categories;
			 $this->data['child_categories'] = $this->model_store_index->getCategories($store_id,$category_id);

			 $index = 0;
                foreach($categories as $item){
                    if($item['category_id'] === $category_id) 
                    {
                        $this->data['category'] = $item;
                        break;
                    }           
                    $index++;
                }

			  } 
			} else {
				$category_id = 0;            
				$this->data['categories'] = $this->model_store_index->getCategories($store_id,0);
			  }

			$this->data['category_id'] = $category_id;

			$url = '';

			$data = array(
				'store_id' => $store_id,
				'start'    => ($page - 1) * $limit,
				'limit'    => $limit,
				'store_id' => $store_id,
				'category_id' => $category_id
			);


			$pro_category = $this->model_store_index->getProductByCategory($data);

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
					'name' => utf8_substr(strip_tags(html_entity_decode($name, ENT_QUOTES, 'UTF-8')), 0,25) . '..',
					'price' => $price,
					'image' => $image,
					'href' => $this->url->link('product/product', $url. '&product_id=' . $result['product_id']),
					'store_id' => $store_id

				);
			
			}
			

			$total = $this->model_store_index->getStoreProductTotalByCategory($data);

				$pagination = new Pagination('results','links');
				$pagination->total = $total['total'];
				$pagination->page = $page;
				$pagination->limit = $limit;
				$pagination->text = $this->language->get('text_pagination');
				$pagination->url = $this->url->link('store/category', $url. '&page={page}' . '&store_id='.$store_id . '&parent_id='.$parent_id .'&category_id='.$category_id);
				
				$this->data['pagination'] = $pagination->render();



			$this->document->setTitle($this->config->get('config_title'));
			$this->document->setDescription($this->config->get('config_meta_description'));

			$this->data['heading_title'] = $this->config->get('config_title');
			
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/store/store_category.html')) {
				$this->template = $this->config->get('config_template') . '/template/store/store_category.html';
			} else {
				$this->template = 'default/template/store/store_category.html';
			}

			$this->children = array(
				'store/footer',
				'store/header'
			);      
			$this->response->setOutput($this->render());
	}
}
?>