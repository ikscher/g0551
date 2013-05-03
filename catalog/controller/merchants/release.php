<?php 
	/**
	* 商家发布商品
	*/
class ControllerMerchantsRelease extends Controller { 
	//身份验证
	private function check_customer(){
		if (!$this->customer->isLogged()) {
	  		$this->session->data['redirect'] = $this->url->link('merchants/merchants', '', 'SSL');
	  		$this->redirect($this->url->link('account/login', '', 'SSL')); 
    	} 
        
		/* $store_id=$this->cookie->OCAuthCode($this->request->cookie['storeid'],'DECODE');
		if(empty($store_id)){
			$this->showMessage("您还没有开店，或登录已超时，请重新登录！");
		} */
	}
	
	//商品分类设置
	public function index() {
		$this->check_customer();
		
		$store_id=$this->cookie->OCAuthCode($this->request->cookie['storeid'],'DECODE');
		
		
		$this->load->model('payment/payment_method');
		$this->load->model('merchants/release');
		
		$this->data['payment_method']=json_encode($this->model_payment_payment_method->getMethod($store_id));
		
		$result=$this->model_merchants_release->getClass(0,false);
		$this->data["classList"]=$result;
		
		
		$this->children = array(
			'merchants/left',
			'merchants/footer',
			'merchants/header'		
		);
		
		
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/merchants/merchants_class.html')) {
			$this->template = $this->config->get('config_template') . '/template/merchants/merchants_class.html';
		} else {
			$this->template = 'default/template/merchants/merchants_class.html';
		}
		
		$this->response->setOutput($this->render());
  	}


	//获取子分类
	public function getClass() {
    	$this->check_customer();
		
		if(!isset($this->request->get["id"])||!is_numeric($this->request->get["id"])){
			exit();
		}
		$this->load->model('merchants/release');
		$result=$this->model_merchants_release->getClass($this->request->get["id"]);
		
		$this->response->setOutput(urldecode(json_encode($result)));
  	}
	
	
	//商品详情填写
	public function detail() {
    	$this->check_customer();
		
		$this->load->model('catalog/product');
		$this->load->model('merchants/release');
		$this->load->model('tool/image');
		
		if(!isset($this->request->get["cid"])||!is_numeric($this->request->get["cid"])){
			exit();
		}
		
		$status=isset($this->request->get["status"])?$this->request->get["status"]:'1';
		
		if(isset($this->request->get["product_id"]) && is_numeric($this->request->get["product_id"]) && $this->request->get["product_id"]>0){
			$product_id=$this->request->get["product_id"];
		}else{
			$product_id=0;
		}
		
		$product_options=array();
		$attributeGroups=array();
		$groups=array();
		// $results=array();
		
		
		
		//选项标签页 ：产品所在的属性组  model(getAttribute) option(getOptionValues) 
		
		if(!empty($product_id)){
			/* $results=$this->model_catalog_product->getProductOptions_old($product_id);

			$attributes=array();
			if(!empty($results)){
				foreach($results as $v){
					if(!empty($v['attribute_group_id']))  $attributes=$this->model_catalog_product->getAttributes($v['attribute_group_id']);
					$v['attribute']=$attributes;
					$attributeGroups[]=$v;//(1)获取选项属性组
				}
			} */
	        // var_dump($attributeGroups);
			$attributeGroups_other=$this->model_catalog_product->getProductAttributes($product_id,false);//
			 
			
			//属性ID为空 ，并且是一般属性 ,此种情况出现在产品的编辑状态下（有属性组，但没有选择属性）
			// attribute_id: |45|33|27|47| 产品的属性，option_attribute_id:|45|33|27|，产品的隐藏属性49没有显示
			$category=array();
			$category=$this->model_catalog_product->getCategories($product_id);
			$category_id=array_pop($category);
			$option_attribute_group=$this->model_catalog_product->getGroupIDByAttributeID($product_id,false);
			
			$attributeGroups_other2=$this->model_merchants_release->getAttributesByCid($category_id['category_id'],$option_attribute_group);//(2)
            
			$attributeGroups=array_merge($attributeGroups_other,$attributeGroups_other2);
			
			 
			/* $attributeGroups_other= array(
			        'product_option_id'    => '',
					'product_option_value' => array(array('attribute_id'=>44)),
					'option_id'            => 4,
					'name'                 => 'select',
					'attribute_group_id'   => 6,
					'attribute_group_name' => '尺寸',
					'type'                 => 'select',
					'required'             => '1',
					'attribute'            =>array(array('attribute_id'=>44,'name'=>'大'),array('attribute_id'=>45,'name'=>'中'),array('attribute_id'=>46,'name'=>'小'))
			); */
			
			//从other里面删除product_option出现的attribute_group_id
            /* foreach($attributeGroups_other as $key=>$ago){
			    $agoid=$ago['attribute_group_id'];
			    foreach($attributeGroups as $ag){
				    if($agoid==$ag['attribute_group_id']){
					    unset($attributeGroups_other[$key]);
					}
				   
				}
			}  */
			
			//$attributeGroups=array_merge($attributeGroups,$attributeGroups_other);//获取到产品的所有属性组 
			
			$sort_order=array();
			foreach ($attributeGroups as $key => $value) {
				$sort_order[$key] = $value['gtype'];
			}
			
			array_multisort($sort_order, SORT_DESC, $attributeGroups);
			  // var_dump($attributeGroups);
			
			foreach($attributeGroups as $k=>$v){
				if($v['gtype']==1) continue;
				$groups[$k]['attribute_group_name']=$v['attribute_group_name'];
				$groups[$k]['attribute_group_id']=$v['attribute_group_id'];
			}
			$this->data['groups']=$groups;
			//获取选项属性组
			/* $product_options2=array();
			$option_attribute_group2=$this->model_catalog_product->getGroupIDByAttributeID($product_id,true);
			
			$option_attribute_group2=$this->model_merchants_release->getAttributesByCid($category_id['category_id'],$option_attribute_group2);//(2)
		    foreach($option_attribute_group2 as $ago2){
			    if($ago2['gtype']==2){
				    $product_options2[]=$ago2;
				}
			} */
		  	
			$this->data['product_options']=array();
			$product_options = $this->model_catalog_product->getProductOptions($product_id);	
			foreach($product_options as $v){
			    $composite_id=$v['composite_id'];
				$composite_id=explode('|',$composite_id);
				foreach($composite_id as $id){
				    if(empty($id)) continue;
				    $attribute_name=$this->model_catalog_product->getAttributeNameById($id);
					$v['attribute'][$id]=$attribute_name;
				}
				$v['attribute_id']=implode('_',$composite_id);
				$this->data['product_options'][]=$v;
			}
               // var_dump($this->data['product_options']);
            //$product_options = array_merge($product_options,$product_options2);	
		
		}else{
		    $category_id=$this->request->get["cid"];
			if(!empty($category_id)){
				$attributeGroups=$this->model_merchants_release->getAttributesByCid($category_id);
				
				foreach($attributeGroups as $k=>$v){
				if($v['gtype']==1) continue;
					$groups[$k]['attribute_group_name']=$v['attribute_group_name'];
					$groups[$k]['attribute_group_id']=$v['attribute_group_id'];
				}
				$this->data['groups']=$groups;
				
				$sort_order=array();
				foreach ($attributeGroups as $key => $value) {
					$sort_order[$key] = $value['gtype'];
				}
				
				array_multisort($sort_order, SORT_DESC, $attributeGroups);
			}

		}
		
		
		$info=$this->model_catalog_product->getProduct($product_id,$status);
		

		
		$this->data["info"]=$info;
		$this->data["product_id"]=$product_id;
		$this->data["category_id"]=$this->request->get["cid"];
		$this->data['attributeGroups']=json_encode($attributeGroups);
			
		
		/*
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
					'type'              => $product_option['type'],
					'product_option_value'      => $product_option['product_option_value'],
					'required'          => $product_option['required']
				);				
			}
		}
	    
		//选项列表
		$this->data['option_values'] = array();

		foreach ($product_options as $product_option) {
			if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
				if (!isset($this->data['option_values'][$product_option['attribute_group_id']])) {
		
					$this->data['option_values'][$product_option['attribute_group_id']] = $this->model_catalog_product->getOptionValues($product_option['option_id'],$product_option['attribute_group_id']);
				}
			}
		} 
		*/
		
		
		//获取商品图片列表
		$image=$this->model_merchants_release->getImages($product_id);
		
		$item=array();
		foreach ($image as $p) {
			if ($p['image']) {
				$p['image'] = $this->model_tool_image->resize($p['image'], 50, 50);                    
			} else {
				$p['image'] = false;
			} 
			$item[]=$p;
			
		}
	
	
		$this->data["image"]=$item;
        
		$this->children = array(
			'merchants/left',
			'merchants/footer',
			'merchants/header'		
		);
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/merchants/merchants_release.html')) {
			$this->template = $this->config->get('config_template') . '/template/merchants/merchants_release.html';
		} else {
			$this->template = 'default/template/merchants/merchants_release.html';
		}
		
		$this->response->setOutput($this->render());
  	}
	
	//添加商品信息
	public function insert() {
		$this->check_customer();
		
		$date_start=strtotime(date('Y-m-d'));
		$date_end  =strtotime(date('Y-m-d',strtotime("+1 day")));
		//商品服务器端验证
		$product_id=isset($this->request->post["product_id"])?$this->request->post["product_id"]:0;
		$category_id   =isset($this->request->post["category_id"])?$this->request->post["category_id"]:"";
		$product_image    =isset($this->request->post["product_image"])?$this->request->post["product_image"]:"";
		$attribute  =isset($this->request->post["attribute"])?$this->request->post["attribute"]:"";
	
		$name    =isset($this->request->post["name"])?$this->request->post["name"]:"";
		$price   =isset($this->request->post["price"])?$this->request->post["price"]:"";
		$special_price = isset($this->request->post["special_price"])?$this->request->post["special_price"]:"";
		$date_start = isset($this->request->post['date_start'])?strtotime($this->request->post['date_start']):$date_start;
		$date_end = isset($this->request->post['date_end'])?strtotime($this->request->post['date_end']):$date_end;
		
		$quantity   =isset($this->request->post["quantity"])?$this->request->post["quantity"]:"";
	    $sku   =isset($this->request->post["sku"])?$this->request->post["sku"]:"件";
	    $shipping   =isset($this->request->post["shipping"])?$this->request->post["shipping"]:1;
		$status     =isset($this->request->post["status"])?$this->request->post["status"]:1;
		$model     =isset($this->request->post["model"])?$this->request->post["model"]:"";
		$description     =isset($this->request->post["description"])?$this->request->post["description"]:"";
		$product_option = isset($this->request->post['product_option'])?$this->request->post['product_option']:'';
		
		 // var_dump($product_option);exit;
		if($category_id=="" || !is_numeric($category_id))$this->showMessage("对不起，参数不正确！");
		if($name=="")$this->showMessage("对不起，请输入宝贝名称！");
		if($price=="" || !is_numeric($price))$this->showMessage("对不起，宝贝价格必须输入一个数值！");
		if($quantity=="" || !is_numeric($quantity))$this->showMessage("对不起，宝贝数量必须输入一个数值！");
		if($status=="")$this->showMessage("对不起，宝贝状态必须选择！");
		if($model=="")$this->showMessage("对不起，宝贝编号必须输入！");
		if($description=="")$this->showMessage("对不起，宝贝描述必须输入！");
		if($product_id=="" || !is_numeric($product_id) || $product_id<0)$product_id=0;
		
		
		if(isset($this->request->cookie['customer']))  {
		    $customer=unserialize($this->cookie->OCAuthCode($this->request->cookie['customer'],'DECODE'));
			if($customer['store_id']) {
			    $store_id=$customer['store_id'];
			}else{
			    $store_id=$this->customer->getStoreId();
			}
		}
		
		$data=array(
			"product_id"=>$product_id,
			"category_id"=>$category_id,
			"product_image"=>$product_image,
			"attribute"=>$attribute,
			"name"=>$name,
			"price"=>$price,
			"special_price"=>$special_price,
			"date_start" =>$date_start,
			"date_end" =>$date_end,
			"quantity"=>$quantity,
			"sku"=>$sku,
			"shipping"=>$shipping,
			"status"=>$status,
			"model"=>$model,
			"description"=>$description,
			"store_id"=>$store_id,
			"product_option"=>$product_option
		);
		$this->load->model('merchants/release');
		$result=$this->model_merchants_release->saveInfo($data,$product_id);
		
		$url="index.php?route=merchants/release/detail&cid={$category_id}&product_id={$product_id}&status={$status}";
		if($result=="no"){
			$this->showMessage("对不起，宝贝信息保存失败！",$url);
		}elseif($result=="nostore"){
			$this->showMessage("对不起，您无权编辑此宝贝！",$url);
		}else{
			$this->showMessage("宝贝信息保存成功！",$url);
		}
  	}
	
	//判断是否属性组的类型1：一般属性，2：价格属性
	public function getAttributeGroupType(){
	    $attribute_group_id=$this->request->get['attribute_group_id'];
	    if(empty($attribute_group_id)) exit(0);
		$json=array();
	    $this->load->model('merchants/release');
		$type=$this->model_merchants_release->getAttributeGroupType($attribute_group_id);
		$json=array('type'=>$type);
		$this->response->setOutput(json_encode($json));
	}
}
?>