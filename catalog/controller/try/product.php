<?php 
class ControllerTryProduct extends Controller { 
	public function index() {

		
		$customer_id=$this->customer->isLogged();
        if(!empty($customer_id)){
		    $this->data['customer_id']=$customer_id;
			$this->data['mobile']=$this->customer->getMobile();
		}else{
		    $this->data['customer_id']=0;
		} 
		
		$this->data['referer']=$this->request->server['REQUEST_URI'];
        
		$product_id=!empty($this->request->get['product_id'])?$this->request->get['product_id']:'';
        if(empty($product_id)) return ;
		
		$this->load->model('catalog/product');
		$this->load->model('try/try');
		$this->load->model('tool/image');
		$this->load->model('store/store');
		
		$product=$this->model_catalog_product->getProduct($product_id);
		$this->data['store']  =$this->model_store_store->getStore($product['store_id']);
		
		$this->data['product_id']=$product_id;
		$this->data['store_id']=$product['store_id'];
		
		
		//初始化显示产品信息
		$productInfo=array();
		$attributes_price=array();
		$attributes=$this->model_catalog_product->getProductAttributes($product_id,false);
		
		foreach ($attributes as $key => $value) {
			if($value['gtype']==2){
				$attributes_price[]=$value;
			}
		}
		
		$images=array();
		$productImages=$this->model_catalog_product->getProductImages($product_id);
		foreach($productImages as $v){
		    $v['small_image']=$this->model_tool_image->resize($v['image'],59,59);
			$v['large_image']=$this->model_tool_image->resize($v['image'],460,460);
			$images[]=$v;
		}
		
		$_product=array();
		$_product=$this->model_catalog_product->getProduct($product_id);

		$_product['special']['date_start']=strtotime($_product['special']['date_start']);
		$_product['special']['date_end']  =strtotime($_product['special']['date_end']);
	
	    $productInfo['product']=$_product;
		$productInfo['images']=$images;
		$productInfo['attribute']=$attributes_price;
		$this->data['productInfo']=$productInfo;
		
		
		
		//单店铺所有的相关试用产品
		$products=array();
		$results=$this->model_try_try->getProducts($product['store_id']);
		
		$this->data['products']=array();
		
		foreach($results as $k=>$v){
		    $v['image']=$this->model_tool_image->resize($v['image'],108,108);
			$v['shortname']=OcCutstr($v['name'],26);
			
			$images=array();
			$productImages=$this->model_catalog_product->getProductImages($v['product_id']);
			foreach($productImages as $v_){
				$v_['small_image']=$this->model_tool_image->resize($v_['image'],59,59);
				$v_['large_image']=$this->model_tool_image->resize($v_['image'],460,460);
				$images[]=$v_;
			}
			
			$v['special']['date_start']= $v['date_start'];
		    $v['special']['date_end']  = $v['date_end'];
			$v['special']['price']     = $v['special_price'];
			$v['description']= html_entity_decode($v['description'], ENT_QUOTES, 'UTF-8');
			
			$productInfo['attribute']=$attributes_price;
			
			$attributes_=$this->model_catalog_product->getProductAttributes($v['product_id'],false);
		    
			$attributes__=array();
			foreach ($attributes_ as $key_ => $value_) {
				if($value_['gtype']==2){
					$attributes__[]=$value_;
				}
			}
		
			$products['images']=$images;
			$products['productInfo']=$v;
			$products['attribute'] = $attributes__;
			$this->data['products'][]=$products;
		}
       
		//var_dump($this->data['products']);
		
		if ($this->customer->isLogged()){
			if(isset($this->request->cookie['oc_customer'])){
				$customer=$this->cookie->OCAuthCode($this->request->cookie['customer'],'DECODE');
				$customer=unserialize($customer);
				
				$this->data['username']=$customer['email'];
			}
		}else{
		    $this->data['username']='';
		}
		
		
		$this->children = array(
		    'try/header',
			'try/footer'
		);
	
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/try/product.html')) {
			$this->template = $this->config->get('config_template') . '/template/try/product.html';
		} else {
			$this->template = 'default/template/try/product.html';
		}
		
				
		$this->response->setOutput($this->render());
 
	
    }
	
	//change product by click
	public function selectProduct(){
	    $json=array();
	    $product_id=$this->request->post['product_id'];
		
		$this->load->model('catalog/product');
		$this->load->model('tool/image');
		//$this->load->model('store/store');
		
		
		//价格属性
		$attributes=$attributes_price=array();
		$attributes=$this->model_catalog_product->getProductAttributes($product_id,false);
		
		foreach ($attributes as $key => $value) {
			if($value['gtype']==2){
				$attributes_price[]=$value;
			}
		}
		
		$images=array();
		$productImages=$this->model_catalog_product->getProductImages($product_id);
		foreach($productImages as $v){
		    $v['small_image']=$this->model_tool_image->resize($v['image'],59,59);
			$v['large_image']=$this->model_tool_image->resize($v['image'],460,460);
			$images[]=$v;
		}
		
		$product=array();
		$product=$this->model_catalog_product->getProduct($product_id);
		
		
		$product['special']['date_start']=strtotime($product['special']['date_start']);
		$product['special']['date_end']  =strtotime($product['special']['date_end']);
		//$product['store']=$this->model_store_store->getStore($product['store_id']);
	
		
		
		$json[$product_id]['product']=$product;
		$json[$product_id]['images']=$images;
		$json[$product_id]['attribute']=$attributes_price;
		
		$this->response->setOutput(json_encode($json));
	
	}
	
	public function ConfirmSelectProduct(){
	    $json=array();
		$time=time();
	    $product_id_list=isset($this->request->post['product_id_list'])?$this->request->post['product_id_list']:'';
		$store_id  = isset($this->request->post['store_id'])?$this->request->post['store_id']:'';
		$customer_id= $this->customer->getId();
		
		
		//if(empty($customer_id)) return ;
		$this->load->model('try/try');
		$try_order_id= $this->model_try_try->getTryOrderid();
		//$this->cookie->OCSetCookie("try_order_id",$this->cookie->OCAuthCode($try_order_id,'ENCODE'),24*3600);
        $this->session->data['try_order_id']=$try_order_id;
		
		if(!empty($customer_id)){//会员
		    $mobile = $this->customer->getMobile();
			
			foreach($product_id_list as $k=>$v){
			    $x=explode('|',$k);
				$product_id=$x[0];
				$attribute_ids=$x[1];
				
				//$numRows=$this->model_try_try->getTryProduct($product_id,$attribute_ids,$customer_id);
				//if($numRows>0){
				//	$json['exists'][$k]=$v;
				//}else{
					$json['noexists'][$k]=$this->model_try_try->addTryProduct($try_order_id,$customer_id,$product_id,$attribute_ids,$store_id,$mobile,$time,$v);
				//}
				
			} 
		}else{//游客
		    $mobile=$this->request->post['mobile'];
			//$this->cookie->OCSetCookie("try_anonymous_mobile",$this->cookie->OCAuthCode($mobile,'ENCODE'),24*3600);
			$this->session->data['try_annoymous_mobile']=$mobile;
		    foreach($product_id_list as $k=>$v){
			    $x=explode('|',$k);
				$product_id=$x[0];
				$attribute_ids=$x[1];
				
				//$numRows=$this->model_try_try->getTryProduct($product_id,$attribute_ids,$mobile,false);
				//if($numRows>0){
				//	$json['exists'][$k]=$v;
				//}else{
					$json['noexists'][$k]=$this->model_try_try->addTryProduct($try_order_id,$customer_id,$product_id,$attribute_ids,$store_id,$mobile,$time,$v);
				//}
				
			} 
		}
		
		$this->response->setOutput(json_encode($json));
	}
	
	public function isTry(){
	    //if(empty($raw_post_data))  $raw_post_data = file_get_contents("php://input");
		//$storeid=$this->cookie->OCAuthCode($this->request->cookie['storeid'],'DECODE');
		$storeid=$this->customer->getStoreId();
		
	    $this->load->model('try/try');
		
		$product_id=$this->request->post['product_id'];
		$attribute_ids=$this->request->post['attribute_ids'];
		$store_id  =$this->request->post['store_id'];
		
		$customer_id=$this->customer->getId();
		
		$numRows=0;
		
		if(!empty($storeid) && $storeid==$store_id) {
		    $numRows=-1;
		}else{
		    if(!empty($customer_id)){
		        $numRows=$this->model_try_try->getTryProduct($product_id,$attribute_ids,$customer_id);
			}else{
			    //$mobile=$this->cookie->OCAuthCode($this->request->cookie['oc_try_anonymous_mobile'],'DECODE');
				$mobile=$this->session->data['try_annoymous_mobile'];
			    $numRows=$this->model_try_try->getTryProduct($product_id,$attribute_ids,$mobile,false);
			}
		}
		
		$this->response->setOutput($numRows);
	
	}

}
?>