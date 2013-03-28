<?php
class ModelCatalogCategory extends Model {
    /*数据库category_id必须按照衣，食，住，行，爽 顺序排序 */
    static $CATEGORY_ROOT = 0;

    static $CATEGORY_CLOTHES = 148; //衣
    static $CATEGORY_FOODS = 219; //食
    static $CATEGORY_HOUSE = 279; //住
    static $CATEGORY_TRAVEL = 324; //行
	static $CATEGORY_JOY = 332; //爽
	
	
    
	public function getCategory($category_id) {
		$query = $this->db->query("SELECT c.category_id,c.parent_id,c.top,c.sort_order,c.column,cd.name,cd.description,c.attribute_group FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE c.category_id = '" . (int)$category_id . "' AND c.status = '1'"); // . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') 
		
		return $query->row;
	}
	
	
	public function getSubCategories($parent_id = 0) {
	    $sql="SELECT c.category_id,c.image,c.parent_id,c.top,c.column,c.sort_order,c.status,c.date_added,c.date_modified,cd.name,cd.description,cd.meta_description,cd.meta_keyword  FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id)  WHERE c.parent_id = '" . (int)$parent_id . "'  AND c.status = '1' ORDER BY c.category_id , c.sort_order";
	
		$query = $this->db->query($sql);

		return $query->rows;
	}
    

    /**
	 * $flag=true依据父ID循环取出所有子孙项 默认
	 * $flag=false 依据父ID取出 子项
	*/	
	public function getCategoriesByParentId($category_id,$flag=true) {
		$category_data = array();

		$category_query = $this->db->query("SELECT c.category_id,c.parent_id,c.top,c.sort_order,c.column,cd.name,cd.description FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE c.parent_id = '" . (int)$category_id . "'");
        
		if($flag==true){
			foreach ($category_query->rows as $category) {
				$category_data[] = $category['category_id'];

				$children = $this->getCategoriesByParentId($category['category_id']);

				if ($children) {
					$category_data = array_merge($children, $category_data);
				}			
			}
        }else{
		    $category_data=$category_query->rows;
		}
		return $category_data;
	}
			
	
					
	public function getTotalCategoriesByCategoryId($parent_id = 0) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND c.status = '1'");
		
		return $query->row['total'];
	}
    
	
	    
    /**取产品所有分类**/
    public function getAllCategories()
    {
        $sql = 'SELECT c.category_id as id, c.parent_id as pid,cd.name as title from category c ';

        $sql = $sql . ' LEFT JOIN category_description  cd on c.category_id = cd.category_id';

        $sql = $sql . ' ORDER BY c.sort_order';
        
        $query = $this->db->query($sql);
        
        return $query->rows; 
    }
	
	
		/**
	*   循环输出所有 类别，父类，子类等等，穷举
	*
	*/
	public function getCategories($pid = 0) {
		//$category_data = $this->cache->get('category.front.'  . (int)$pid);
        
		//if (empty($category_data)) {
			$category_data = array();
		
			
            $sql="SELECT c.category_id,c.status,c.sort_order,c.parent_id,c.image,c.column,c.top FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE c.parent_id = '" . (int)$pid  . "' ORDER BY c.category_id,c.sort_order";
	
			$query = $this->db->query($sql);
 
			foreach ($query->rows as $result) {
			    $this->category_name="";
				$category_data[] = array(
					'category_id' => $result['category_id'],
					'parent_id'   => $result['parent_id'],
					'name'        => $this->getPath($result['category_id']),
					'status'  	  => $result['status'],
					'sort_order'  => $result['sort_order']
				);

				$category_data = array_merge($category_data, $this->getCategories($result['category_id']));
			}
			
			

			//$this->cache->set('category.front.'  . (int)$pid, $category_data);
		//}
        
		return $category_data;
	}
    
	/**
	*   父类>>子类>>子孙类 ...一直循环嵌套
	*/
	public function getPath($category_id) {
	    
		$query = $this->db->query("SELECT cd.name, c.parent_id FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE c.category_id = '" . (int)$category_id .  "' ORDER BY c.sort_order, cd.name ASC");
        
		if (!$query->num_rows) return '';
		
		if ($query->row['parent_id']) {
		    if ($this->category_name) {
		        $this->category_name = $query->row['name'] .'|'. $this->category_name ; // 一级父类>>二级父类>>三级父类 等形式
			}else{
			    $this->category_name =$query->row['name'];
			}
			return $this->getPath($query->row['parent_id']);
		} else {
		    if($this->category_name){
		        $this->category_name =$query->row['name'] .  '|'. $this->category_name; 
			}else{
			    $this->category_name =$query->row['name'];
			}
			return $this->category_name;
		}
	}
	
	
	
	//对应的风格，品牌，颜色等等
    public function getAttributeByType($attribute_group_id){
	    $result=array();
		if(!empty($attribute_group_id)){
			$sql="select a.attribute_group_id,agd.name as n1 ,ad.name as n2,ag.type,a.attribute_id,ad.url from  attribute_group ag left join  attribute_group_description  agd on ag.attribute_group_id=agd.attribute_group_id left join attribute a on ag.attribute_group_id=a.attribute_group_id left join attribute_description ad  on a.attribute_id=ad.attribute_id where ag.attribute_group_id in({$attribute_group_id}) and ag.isShow=1 order by a.sort_order asc";
			$query=$this->db->query($sql);
			foreach($query->rows as $value){
				$result[$value['n1']][$value['attribute_id']]=$value['attribute_group_id'].'|'.$value['n2'].'|'.$value['url'];
			
			}
		} 

        return $result; 
	   
    }	
	
	/**取所有的属性组*/
	public function getAttributeGroupIn($groups){
		$sql="SELECT  ag.type,agd.name,ag.attribute_group_id FROM " . DB_PREFIX. "attribute_group ag inner join ".DB_PREFIX."attribute_group_description agd on ag.attribute_group_id=agd.attribute_group_id and ag.attribute_group_id in({$groups})";
		$query = $this->db->query($sql);
		return $query->rows;
	}
    
    

}
?>