<?php 
 /**分类产品*/
class ControllerProductCategory extends Controller { 

	public function index() 
    { 		 
	    $this->data['list_channel_title']='';
		$flag=true; //标志位
		$url='';
		
		$this->load->model('catalog/product');	
		$this->load->model('catalog/category');	
		$this->load->model('tool/image'); 
		

		if (!empty($this->request->get['category_id'])){
			$category_id = $this->request->get['category_id'];   	
		}else{
		    return ;
		}
		

		$this->data['category_id']=$category_id;
		$this->data['categoryList']=array();
		$this->data['searchCondition']=array();
		$this->data['top']=0;
		$result=array();
		/**衣类别下的所有子类*/
		$clothes_cid=$this->model_catalog_category->getCategories(ModelCatalogCategory::$CATEGORY_CLOTHES);
		if($flag==true){
			foreach($clothes_cid as $v){
				if($category_id==$v['category_id'] || $category_id==ModelCatalogCategory::$CATEGORY_CLOTHES){
				    $this->data['list_channel_title']='clothes';
				    $flag=false;
				    $this->data['categoryList']=$this->getCategoryList(ModelCatalogCategory::$CATEGORY_CLOTHES);//左侧显示类列表
					//搜索条件列表.
					$result=$this->model_catalog_category->getCategory($category_id);
					if(!empty($result)){
					    $this->data['top']=$result['top'];
						if($result['top']>=3){
							$attribute_group=$result['attribute_group'];
							$this->data['searchCondition']=$this->model_catalog_category->getAttributeByType($attribute_group);
						}
					}
				    break;
				 
				}
			}
			
		}
		$result=null;
        $clothes_cid=null;

	
		/*食衣类别下的所有子类*/
		$foods_cid=$this->model_catalog_category->getCategories(ModelCatalogCategory::$CATEGORY_FOODS);
		if($flag==true){
			foreach($foods_cid as $v){
				if($category_id==$v['category_id'] || $category_id==ModelCatalogCategory::$CATEGORY_FOODS){
				    $this->data['list_channel_title']='foods';
					$flag=false;
					$this->data['categoryList']=$this->getCategoryList(ModelCatalogCategory::$CATEGORY_FOODS);
					//搜索条件列表
		            $result=$this->model_catalog_category->getCategory($category_id);
					if(!empty($result)){
					    $this->data['top']=$result['top'];
						if($result['top']>=3){
							$attribute_group=$result['attribute_group'];
							$this->data['searchCondition']=$this->model_catalog_category->getAttributeByType($attribute_group);
						}
					}
				    break;
				}
			}
		}
		$result=null;
		$foods_cid=null;
		
		/**住类别下的所有子类*/
		$house_cid=$this->model_catalog_category->getCategories(ModelCatalogCategory::$CATEGORY_HOUSE);
		if($flag==true){
			foreach($house_cid as $v){
				if($category_id==$v['category_id'] || $category_id==ModelCatalogCategory::$CATEGORY_HOUSE){
				    $this->data['list_channel_title']='house';
					$flag=false;
					$this->data['categoryList']=$this->getCategoryList(ModelCatalogCategory::$CATEGORY_HOUSE);
					//搜索条件列表
		            $result=$this->model_catalog_category->getCategory($category_id);
					if(!empty($result)){
					    $this->data['top']=$result['top'];
						
						if($result['top']>=3){
							$attribute_group=$result['attribute_group'];
							$this->data['searchCondition']=$this->model_catalog_category->getAttributeByType($attribute_group);
						}
					}
				    break;
				}
			}
		}
		$result=null;
		$house_cid=null;
		
		/**行类别下的所有子类*/
		$travel_cid=$this->model_catalog_category->getCategories(ModelCatalogCategory::$CATEGORY_TRAVEL);
		if($flag==true){
			foreach($travel_cid as $v){
			   if($category_id==$v['category_id'] || $category_id==ModelCatalogCategory::$CATEGORY_TRAVEL){
				    $this->data['list_channel_title']='travel';
					$flag=false;
					$this->data['categoryList']=$this->getCategoryList(ModelCatalogCategory::$CATEGORY_TRAVEL);
					//搜索条件列表
		            $result=$this->model_catalog_category->getCategory($category_id);
					if(!empty($result)){
					    $this->data['top']=$result['top'];
						if($result['top']>=3){
							$attribute_group=$result['attribute_group'];
							$this->data['searchCondition']=$this->model_catalog_category->getAttributeByType($attribute_group);
						}
					}
				  	break;
				}
			}
		}
		$result=null;
		$travel_cid=null;
		
		// var_dump($this->data['categoryList']);
		
        $this->data['category_id'] = $category_id; 
		
		$url .="&category_id={$category_id}";
		
		
		//一周热销产品
		$hot_products = array();
		$hot_results=$this->model_catalog_product->getProductByWeek($category_id);
		foreach ($hot_results as $v) {
            if ($v['image']) {
				$v['image'] = $this->model_tool_image->resize($v['image'], 180, 180);                    
			} else {
				$v['image'] = false;
			}       
            $v['shortname'] = isset($v['name'])?OcCutstr($v['name'], 15):'';  
			
			$hot_products[]=$v;
		}
		$this->data['hot_products']=$hot_products;
		$hot_results=null;
		
		//为你挑选
		$foryou_products = array();
		$foryou_results=$this->model_catalog_product->getProductForYou($category_id);
		foreach ($foryou_results as $v) {
		    if(empty($v)) continue;
            if ($v['image']) {
				$v['image'] = $this->model_tool_image->resize($v['image'], 180, 180);                    
			} else {
				$v['image'] = false;
			}       
            $v['shortname'] = isset($v['name'])?OcCutstr($v['name'], 15):'';  
			
			$foryou_products[]=$v;
		}
		$this->data['foryou_products']=$foryou_products;
		$foryou_results=null;
		
		//一周热销推荐
		$recommend_products = array();
		$recommend_results=$this->model_catalog_product->getProductByWeek($category_id,true);
		foreach ($recommend_results as $v) {
		    if(empty($v)) continue;
            if ($v['image']) {
				$v['image'] = $this->model_tool_image->resize($v['image'], 180, 180);                    
			} else {
				$v['image'] = false;
			}       
            $v['shortname'] = isset($v['name'])?OcCutstr($v['name'], 15):'';  
			
			$recommend_products[]=$v;
		}
		$this->data['recommend_products']=$recommend_products;
		$recommend_results=null;
		
		
		
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
		
		$query_arr=$url_arr=array();
		$this->data['attid']=array();
		
		$query_string=$this->request->server['QUERY_STRING'];
		$query_string=preg_replace('/&amp;/i','&',$query_string);
		$query_arr=explode('&',$query_string);
	    $url_arr=preg_grep('/a_id\d+=\d*/i',$query_arr);
		
		if(!empty($url_arr) && count($url_arr)>=1){
		    foreach($url_arr as $k=>$v){
			    $lr=explode('=',$v);
				$this->data['attid'][]=$lr[1];
				$url.="&".$v;
			}
		}
		// $url=preg_replace('/&amp;/i','&',$url);
		
		/*
		if (isset($this->request->get['a_id1'])){
		    $a_id1=$this->request->get['a_id1'];
			$this->data['attid'][]=$a_id1;
			$url.="&a_id1={$a_id1}";
		}
		if (isset($this->request->get['a_id2'])){
		    $a_id2=$this->request->get['a_id2'];
			$this->data['attid'][]=$a_id2;
			$url.="&a_id2={$a_id2}";
		}
		if (isset($this->request->get['a_id3'])){
		    $a_id3=$this->request->get['a_id3'];
			$this->data['attid'][]=$a_id3;
			$url.="&a_id3={$a_id3}";
		}
		if (isset($this->request->get['a_id4'])){
		    $a_id4=$this->request->get['a_id4'];
			$this->data['attid'][]=$a_id4;
			$url.="&a_id4={$a_id4}";
		}
		if (isset($this->request->get['a_id5'])){
		    $a_id5=$this->request->get['a_id5'];
			$this->data['attid'][]=$a_id5;
			$url.="&a_id5={$a_id5}";
		}
		if (isset($this->request->get['a_id6'])){
		    $a_id6=$this->request->get['a_id6'];
			$this->data['attid'][]=$a_id6;
			$url.="&a_id6={$a_id6}";
		}
		if (isset($this->request->get['a_id7'])){
		    $a_id7=$this->request->get['a_id7'];
			$this->data['attid'][]=$a_id7;
			$url.="&a_id7={$a_id7}";
		}
		if (isset($this->request->get['a_id8'])){
		    $a_id8=$this->request->get['a_id8'];
			$this->data['attid'][]=$a_id8;
			$url.="&a_id8={$a_id8}";
		}
		if (isset($this->request->get['a_id9'])){
		    $a_id9=$this->request->get['a_id9'];
			$this->data['attid'][]=$a_id9;
			$url.="&a_id9={$a_id9}";
		}
		if (isset($this->request->get['a_id0'])){
		    $a_id0=$this->request->get['a_id0'];
			$this->data['attid'][]=$a_id0;
			$url.="&a_id0={$a_id0}";
		}
        */
           
        //排序sort=default&order=asc
		$sortby=$orderby='';
		$sort=isset($this->request->get['sort'])?$this->request->get['sort']:null;
		if (isset($sort)) {
			switch($sort){
			    case 'viewed':
				    $sortby='p.viewed';
				    break;
				case 'price':
				    $sortby='p.price';
				    break;
				case 'latest':
				    $sortby='p.date_added';
				    break;
				case 'default':
				    $sortby='p.sort_order';
				    break;
				default:
				    $sortby = 'p.sort_order';
			}   
		} else {
			$sortby = 'p.sort_order';
		}
	
        $order=isset($this->request->get['order'])?$this->request->get['order']:'';
		if (isset($order)) {
			$orderby = $order;
		} else {
			$orderby = 'desc';
		}
		
		if(!empty($sort)) $url.="&sort={$sort}";
		if(!empty($order)) $url.="&order={$order}";

		/* if (isset($this->request->get['sort'])) $url .= '&sort=' . $this->request->get['sort'];
		if (isset($this->request->get['order'])) $url .= '&order=' . $this->request->get['order'];
		if (isset($this->request->get['page'])) $url .= '&page=' . $this->request->get['page'];
	    if (isset($this->request->get['limit'])) $url .= '&limit=' . $this->request->get['limit']; */
		
		$data = array(
		    'category_id'=>$category_id,
			/*
		    'a_id1' => isset($this->request->get['a_id1'])?$this->request->get['a_id1']:'',
			'a_id2' => isset($this->request->get['a_id2'])?$this->request->get['a_id2']:'',
			'a_id3' => isset($this->request->get['a_id3'])?$this->request->get['a_id3']:'',
			'a_id4' => isset($this->request->get['a_id4'])?$this->request->get['a_id4']:'',
			'a_id5' => isset($this->request->get['a_id5'])?$this->request->get['a_id5']:'',
			'a_id6' => isset($this->request->get['a_id6'])?$this->request->get['a_id6']:'',
			'a_id7' => isset($this->request->get['a_id7'])?$this->request->get['a_id7']:'',
			'a_id8' => isset($this->request->get['a_id8'])?$this->request->get['a_id8']:'',
			'a_id9' => isset($this->request->get['a_id9'])?$this->request->get['a_id9']:'',
			'a_id0' => isset($this->request->get['a_id0'])?$this->request->get['a_id0']:'',
			*/
			'url_arr'=>$url_arr,
			'sort'  => $sortby,
			'order' => $orderby,
			'start' => ($page - 1) * $limit,
			'limit' => $limit
		);
        
		
        $products = array();			
		$items = $this->model_catalog_product->getProductsByCategory($data);
		foreach ($items as $item) {
		    if(empty($item)) continue;
            if ($item['image']) {
				$item['image'] = $this->model_tool_image->resize($item['image'], 180, 180);                    
			} else {
				$item['image'] = false;
			}       
            $item['shortname'] = OcCutstr($item['name'], 15);  
			
			$products[]=$item;
		}

		// var_dump($products);

        $this->data['sort'] = $sort;
		$this->data['order'] = $order;
        $this->data['products'] = $products; 
		
		$product_total=$this->model_catalog_product->getTotalProductsByCategory($data);
	
	
		$pagination = new Pagination('results','links');
		$pagination->total = $product_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('product/category', $url . '&page={page}');
			
		$this->data['pagination'] = $pagination->render();
        		
		
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/category.html')) {
			$this->template = $this->config->get('config_template') . '/template/product/category.html';
		} else {
			$this->template = 'default/template/product/category.html';
		}

		$this->children = array(
			'common/footer',
			'common/header'
		);		
	
	    $this->response->setOutput($this->render());
  	}
	
	/**
	*  $id 代表 是 衣食住行的大类 categroy_id
	*/
	public function getCategoryList($id=0){
	    $categories = $this->model_catalog_category->getCategories($id);
		
		$list_category=array();
		foreach($categories as $key=>$category){ 
		    $categroyname=$category['name'];
		    $categroyname_detail=explode("|",$categroyname);
		    if(sizeof($categroyname_detail)==2){
		        
				if($id==$category['parent_id']){
					$list_category[$category['category_id']]=array(
									'pid'=>$id,
									'category_id'=>$category['category_id'],
									'name'=>$categroyname_detail[1],
									'third_category_list'=>$this->model_catalog_category->getCategoriesByParentId($category['category_id'],false),
									); //二级目录
				}
		    }
		  
		}
		
		return $list_category;
	}
 
}
?>