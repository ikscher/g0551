<?php
class ControllerCommonLeft extends Controller {
    private $category_list=array();
     /**
    * 商品分类分组输出
    * $pid 商品类别parent_id
    */
	public function index() {
	    $this->load->model('catalog/category');
	    $uri=$this->request->server['REQUEST_URI'];
		
		$this->data['list_channel_title']=ModelCatalogCategory::$CATEGORY_CLOTHES;
        if(preg_match('/clothes/i',$uri)){
		    $this->data['list_channel_title']=ModelCatalogCategory::$CATEGORY_CLOTHES;
		}
		
		if(preg_match('/foods/i',$uri)){
		    $this->data['list_channel_title']=ModelCatalogCategory::$CATEGORY_FOODS;
		}
		
		if(preg_match('/house/i',$uri)){
		    $this->data['list_channel_title']=ModelCatalogCategory::$CATEGORY_HOUSE;
		}
		
		if(preg_match('/travel/i',$uri)){
		    $this->data['list_channel_title']=ModelCatalogCategory::$CATEGORY_TRAVEL;
		}
		
		if(preg_match('/joy/i',$uri)){
		    $this->data['list_channel_title']=ModelCatalogCategory::$CATEGORY_JOY;
		}
		
		$list_category=array();
		$list_category=$this->getCategoryList();
		$this->data['list_category']=$list_category;
       
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/left.html')) {
			$this->template = $this->config->get('config_template') . '/template/common/left.html';
		} else {
			$this->template = 'default/template/common/left.html';
		}

		$this->render();
	}
	
	
	/**
	*取类的列表
	*/
	public function getCategoryList_old($id=0){
	    $this->load->model('catalog/category');
	    $categories = $this->model_catalog_category->getCategories(0);

		$categroyname_detail=array();
		foreach($categories as $key=>$category){ 
		    if($category['parent_id']==0) {
    		   $list_category_root[] = $category['name']; //根目录 衣食住行爽
			   $pid[]=$category['category_id'];
			}
		}
		
		$list_category=array();
		foreach($categories as $key=>$category){ 
		    $categroyname=$category['name'];
		    $categroyname_detail=explode("|",$categroyname);
		    if(sizeof($categroyname_detail)==2){
		        foreach($pid as $v){
				    if($v==$category['parent_id']){
				        $list_category[$v][$category['category_id']]=array(
						                'pid'=>$v,
										'category_id'=>$category['category_id'],
						                'name'=>$categroyname_detail[1],
										'third_category_list'=>$this->model_catalog_category->getCategoriesByParentId($category['category_id'],false),
										); //二级目录
				        // $pid1[]=$category['category_id'].','.$v; //二级目录ID.根ID
						
						
				    }
				 
				}
		  
		    }
		  
		}
		
		return $list_category;

	}
	
	
	/**
	*取类的列表
	*/
	public function getCategoryList($category_id=0,$flag=false){
	    $this->load->model('catalog/category');
		$category_data = array();

		$category_query = $this->db->query("SELECT c.category_id,c.parent_id,c.top,c.sort_order,c.column,cd.name,cd.description FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE c.parent_id = '" . (int)$category_id . "'");
        
		
		foreach ($category_query->rows as $category) {
		    
			//$category_data=$category_query->rows;
           
			$child=$this->model_catalog_category->getCategoriesByParentId($category['category_id'],false) ;
			 
			$category['list']=$child;
			
			
			foreach($child as $k=>$category_){
			    $category['list'][$k]['list']=$this->model_catalog_category->getCategoriesByParentId($category_['category_id'],false) ;
				  
				if($flag==true){
					$child_=$this->model_catalog_category->getCategoriesByParentId($category_['category_id'],false) ;
					foreach($child_ as $k_=>$category__){
						$category['list'][$k]['list'][$k_]['list']=$this->model_catalog_category->getCategoriesByParentId($category__['category_id'],false) ;
					  
					  
					}
			    }
			       
			}  
			
			$this->category_list[]=$category;
			
			
			//array_push($this->category_list,$category_data);
/*
			if ($children) {
				$this->category_list[$category['category_id']]['child']=  $children;
			}else{
               	$this->category_list = $category_data;
            }	  */		
		}
        
		return  $this->category_list;

	}
}
?>