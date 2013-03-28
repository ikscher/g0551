<?php
class ControllerCommonLeft extends Controller {
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
	public function getCategoryList($id=0){
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
}
?>