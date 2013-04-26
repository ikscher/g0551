<?php
class ModelCatalogCategory extends Model {
    private $category_name='';
	private $current_category_name='';
	private $categoryList=array();
	private $current_category_id='';
	static $CATEGORY_ROOT = 0;

    static $CATEGORY_CLOTHES = 148; //衣
    static $CATEGORY_FOODS = 219; //食
    static $CATEGORY_HOUSE = 279; //住
    static $CATEGORY_TRAVEL = 324; //行
	static $CATEGORY_JOY = 332; //爽
	
	public function addCategory($data) {
		$time=time();
		$composite=explode(",",$data['parent_id']);
		$parent_id=$composite[0];
		$top=$composite[1];
		$top=$top+1;
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "category SET parent_id = '" . (int)$parent_id . "', `top` = '" . $top . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_modified ={$time}, date_added ={$time}");

		$category_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "category SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE category_id = '" . (int)$category_id . "'");
		}
        
		$value=$data['category_description'];
		if(!empty($value)) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "category_description SET category_id = '" . (int)$category_id  . "', name = '" . $this->db->escape(trim($value['name'])) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}

		/* if (isset($data['category_store'])) {
			foreach ($data['category_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_to_store SET category_id = '" . (int)$category_id . "', store_id = '" . (int)$store_id . "'");
			}
		} */

		/* if (isset($data['category_layout'])) {
			foreach ($data['category_layout'] as $store_id => $layout) {
				if ($layout['layout_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "category_to_layout SET category_id = '" . (int)$category_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
				}
			}
		} */

		/* if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'category_id=" . (int)$category_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		} */

		$this->cache->delete('category');
	}

	/**
	*  修改 指定类别
	*  category_id :  指定类
	*  data        :   要修改的数据
	*/
	public function editCategory($category_id, $data) {
	    $time=time();
		$composite=explode(",",$data['parent_id']);
		$parent_id=$composite[0];
		$top=$composite[1];
		$top=$top+1;
		$attribute_group=implode(',',$data['attribute_group']);
		$this->db->query("UPDATE " . DB_PREFIX . "category SET parent_id = '" . (int)$parent_id  . "', `top` = '" . $top  . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_modified ={$time},attribute_group='{$attribute_group}' WHERE category_id = '" . (int)$category_id . "'");//. "', attribute_group_id = '" . $data['attribute_group_id']

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "category SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE category_id = '" . (int)$category_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int)$category_id . "'");

		
		if(!empty($data['category_description'])){
			$this->db->query("INSERT INTO " . DB_PREFIX . "category_description SET category_id = '" . (int)$category_id . "', name = '" . $this->db->escape(trim($data['category_description']['name'])) . "', meta_keyword = '" . $this->db->escape(trim($data['category_description']['meta_keyword'])) . "', meta_description = '" . $this->db->escape(trim($data['category_description']['meta_description'])) . "', description = '" . $this->db->escape(trim($data['category_description']['description'])) . "'");
		}

		//$this->db->query("DELETE FROM " . DB_PREFIX . "category_to_store WHERE category_id = '" . (int)$category_id . "'");
        
		
		
		/* if (isset($data['category_store'])) {
			foreach ($data['category_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_to_store SET category_id = '" . (int)$category_id . "', store_id = '" . (int)$store_id . "'");
			}
		} */

		/* $this->db->query("DELETE FROM " . DB_PREFIX . "category_to_layout WHERE category_id = '" . (int)$category_id . "'");

		if (isset($data['category_layout'])) {
			foreach ($data['category_layout'] as $store_id => $layout) {
				if ($layout['layout_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "category_to_layout SET category_id = '" . (int)$category_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
				}
			}
		} */

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'category_id=" . (int)$category_id. "'");

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'category_id=" . (int)$category_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('category');
	}

	public function deleteCategory($category_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "category WHERE category_id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_to_store WHERE category_id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "category_to_layout WHERE category_id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'category_id=" . (int)$category_id . "'");

		$query = $this->db->query("SELECT category_id FROM " . DB_PREFIX . "category WHERE parent_id = '" . (int)$category_id . "'");

		foreach ($query->rows as $result) {
			$this->deleteCategory($result['category_id']);
		}

		$this->cache->delete('category');
	}
	
	
	public function getCategory($category_id) {
	    $result=array();
		$sql="SELECT category_id,image,parent_id,`top`,`column`,sort_order,`status`,date_added,date_modified,attribute_group FROM " . DB_PREFIX . "category WHERE status=1 and category_id = '" . (int)$category_id . "'";

		$query = $this->db->query($sql);
        $result=$query->row;
		//return array_filter($result,"ModelCatalogCategory::filter");
		return $result;
	}
    
	/**取当前类的子类*/
	public function getChildCategory($category_id){
	    $data=array();
	    $query = $this->db->query("SELECT  c.category_id as id ,cd.name FROM " . DB_PREFIX . "category c inner join ".DB_PREFIX."category_description cd on c.category_id=cd.category_id and c.parent_id = '" . (int)$category_id . "'");
        $data=$query->rows;
		
		return $data;
	
	}
	/**
	*   循环输出所有 类别，父类，子类等等，穷举
	*   由父类 ID 循环输出 名下所有 子类
	*/
	public function getCategories($data) {
	    $pid=$data['pid'];
		$categoryid=isset($data['categoryid'])?$data['categoryid']:'';
		$categoryname=isset($data['categoryname'])?$data['categoryname']:'';
		$status=isset($data['status'])?$data['status']:'';
		
		
		if(is_numeric($pid)) $category_data = $this->cache->get('category.'  . (int)$pid);
       
	    
		if (empty($category_data)) {

			$category_data = array();

            $sql_="SELECT c.category_id,c.status,c.sort_order,c.parent_id,c.top,c.image FROM " . DB_PREFIX . "category c inner JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) ";
			$sql=$sql_ ." WHERE c.parent_id = '" . (int)$pid  . "'";
	
			if($categoryid>0)   $sql = $sql_ . " where c.category_id='".(int)$categoryid."'";
			if(isset($categoryname) and $categoryname!=='') $sql = $sql_ . " where cd.name like '%".$categoryname."%'";
			if(isset($status) && $status!=='' )       $sql = $sql . " and c.status={$status}";
			
			$sql.=" ORDER BY c.parent_id,c.category_id,c.sort_order, cd.name ASC";
		
		   
			$query = $this->db->query($sql);
 
			foreach ($query->rows as $result) {
			    $this->category_name="";
				$category_data[] = array(
					'category_id' => $result['category_id'],
					'parent_id'   => $result['parent_id'],
					'top'         => $result['top'],
					'image'       => $result['image'],
					'name'        => $this->getPath($result['category_id']),
					'status'  	  => $result['status'],
					'sort_order'  => $result['sort_order']
				);
                
				
				$cid=array('pid'=>$result['category_id']);
				$category_data = array_merge($category_data, $this->getCategories($cid));
				
			}
			

			$this->cache->set('category.'  . (int)$pid, $category_data);
		}
        
		return $category_data;
	}
    
	/**
	*   父类>>子类>>子孙类 ...一直循环嵌套
	*/
	public function getPath($category_id) {
	    
		$sql="SELECT cd.name, c.parent_id FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE c.category_id = '" . (int)$category_id .  "' ORDER BY c.sort_order, cd.name ASC";
		
		$query = $this->db->query($sql);
        
		if (!$query->num_rows) return '';
		
		if ($query->row['parent_id']) {
		    if ($this->category_name) {
		        $this->category_name = $query->row['name'] .'>>'. $this->category_name ; // 一级父类>>二级父类>>三级父类 等形式
			}else{
			    $this->category_name =$query->row['name'];
			}
			return $this->getPath($query->row['parent_id']);
		} else {
		    if($this->category_name){
		        $this->category_name =$query->row['name'] .  '>>'. $this->category_name; 
			}else{
			    $this->category_name =$query->row['name'];
			}
			return $this->category_name;
		}
	}
	
	/** 
	*  根据当前类ID取属于当前类下 所有最底级的ID
	*/
	public function getLowestLevelID($category_id){
	    $data=array();
	    $sql="SELECT category_id, parent_id FROM " . DB_PREFIX . "category  WHERE parent_id = '" . (int)$category_id .  "'";
		
		$query = $this->db->query($sql);
        
		if (!$query->num_rows) {
		    array_push($this->categoryList,$category_id);
		}
		
		$data=$query->rows;
		
		foreach($data as $v){
			$this->getLowestLevelID($v['category_id']);
	    }
		
		return $this->categoryList;
	}
	
	/**
	*  根据当前的类ID获取 类的绝对路径 衣>>女装>>内衣...
	*/
	public function getCurrentPath($category_id,$type){
	    
	    $sql="SELECT cd.name,c.category_id, c.parent_id FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE c.category_id = '" . (int)$category_id .  "' ORDER BY c.sort_order, cd.name ASC";
		
		$query=$this->db->query($sql);
		if (!$query->num_rows) return '';
		    
		if($query->row['parent_id']){
		    if ($this->current_category_name) {
				$this->current_category_name=$query->row['name'].'>>'.$this->current_category_name;
				$this->current_category_id=$query->row['category_id'].'|'.$this->current_category_id;
			}else{
			    $this->current_category_name =$query->row['name'];
				$this->current_category_id=$query->row['category_id'];
			}
		    return $this->getCurrentPath($query->row['parent_id'],$type);
		}else{
		    $this->current_category_name=$query->row['name'].'>>'.$this->current_category_name;
			$this->current_category_id=$query->row['category_id'].'|'.$this->current_category_id;
			if($type=='id'){
			    return  $this->current_category_id;
			}else{
			    return  $this->current_category_name;
			}
		}
	  
	}
	
	public function getCurrentCategory($category_id,$type){
	    $this->current_category_name='';
		$this->current_category_id='';
		return $this->getCurrentPath($category_id,$type);
	}
    
	/**
	*   指定 类的描述
	*
	*/
	public function getCategoryDescriptions($category_id) {
		$category_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int)$category_id . "'");
        
		/* foreach ($query->rows as $result) {
			$category_description_data[] = array(
				'name'             => $result['name'],
				'meta_keyword'     => $result['meta_keyword'],
				'meta_description' => $result['meta_description'],
				'description'      => $result['description']
			);
		} */
		$result=$query->row;
		
		$category_description_data = array(
			'name'             => $result['name'],
			'meta_keyword'     => $result['meta_keyword'],
			'meta_description' => $result['meta_description'],
			'description'      => $result['description']
		);
    
		return $category_description_data;
	}

	public function getCategoryStores($category_id) {
		$category_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_to_store WHERE category_id = '" . (int)$category_id . "'");

		foreach ($query->rows as $result) {
			$category_store_data[] = $result['store_id'];
		}

		return $category_store_data;
	}

	public function getCategoryLayouts($category_id) {
		$category_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_to_layout WHERE category_id = '" . (int)$category_id . "'");

		foreach ($query->rows as $result) {
			$category_layout_data[$result['store_id']] = $result['layout_id'];
		}

		return $category_layout_data;
	}

	public function getTotalCategories() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category");

		return $query->row['total'];
	}

	public function getTotalCategoriesByImageId($image_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category WHERE image_id = '" . (int)$image_id . "'");

		return $query->row['total'];
	}

	public function getTotalCategoriesByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}
	
	
	/**根据categoryid取对应所属组**/
	public function getAttributeByCategory($categoryid){
	    $group_data=array();
	    $sql="select category_id,attribute_group from ".DB_PREFIX."category where status=1 and parent_id=".(int)$categoryid;
		$query=$this->db->query($sql);
		foreach($query->rows as $key=>$value){
		    if(!empty($value['attribute_group'])){
				$group_data[]=array(
					'category_id'=>$value['category_id'],
					'attribute_group'=>$value['attribute_group']
				);
			}
			$group_data=array_merge($group_data,$this->getAttributeByCategory($value['category_id']));
		
		}
	    $query=null;
		
		return $group_data;
	    
	}
	
	public function getAttributeGroupsByCategory($categoryid){
	    $group_data=$this->getAttributeByCategory($categoryid);
	    //$sql="select category_id,attribute_group from ".DB_PREFIX."category where status=1 and category_id=".(int)$categoryid;
		$sql="SELECT category_id,image,parent_id,`top`,`column`,sort_order,`status`,date_added,date_modified,attribute_group, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'category_id=" . (int)$categoryid . "') AS keyword FROM " . DB_PREFIX . "category WHERE status=1 and category_id = '" . (int)$categoryid . "'";

		$query=$this->db->query($sql);
		array_push($group_data,$query->row);
		
		$NC=array();
		$str='';
		$comma='';
		foreach($group_data as $value){
		    if(!empty($value)){
				$str .=$comma;
				$str .=$value['attribute_group'];
				$comma=',';
			}
		}
		if(!empty($str)) $NC=explode(',',$str);
		$NC=array_unique($NC);
		return $NC;
	}
	
	/**
	* 更新类的属性组
	* $cagegory_id :类ID
	* $attribute_group : 属性组
	*/
	public function updateCategory($data=array()){
	    $category_id=$data['category_id'];
		$attribute_group_id=$data['attribute_group_id'];
	    $sql="update ".DB_PREFIX."category set attribute_group='{$attribute_group_id}' where category_id='{$category_id}'";
		
		$this->db->query($sql);
	
	}
	
	public function updateCategoryAttributeGroup($data=array()){
	    $category_id=$data['category_id'];
		$attribute_group_id=$data['attribute_group_id'];
	    $sql="update ".DB_PREFIX."category set attribute_group=CONCAT(attribute_group,',','{$attribute_group_id}') where category_id={$category_id}";
	    $this->db->query($sql);
	
	}
	
	//根据属性组表求对应的属性组  
	/*
	public function getGroupsByCategory($categoryid,$top=''){
	    $group_data=array();
		$categoryid=(int)$categoryid;
		if($categoryid>0 && $top>=0){
			$sql="select attribute_group_id from ".DB_PREFIX."attribute_group where  cid{$top}='{$categoryid}' ";
			$query=$this->db->query($sql);
			$group_data=$query->rows;
			
			$NC=array();
			$str='';
			$comma='';
			foreach($group_data as $value){
				if(!empty($value)){
					$str .=$comma;
					$str .=$value['attribute_group_id'];
					$comma=',';
				}
			}
			if(!empty($str)) $NC=explode(',',$str);
			$NC=array_unique($NC);
		}
		return $NC;
	    
	}
	*/
}
?>