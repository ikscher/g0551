<?php
class ControllerProductJoy extends Controller {
	/**
	*  爽页面图片信息
	*
	**/

	public function getImageSrc(){
        $start=isset($this->request->get['start'])?$this->request->get['start']:0;
		$this->load->model('catalog/joy');
		$this->load->model('tool/image');
		$this->data['show'] = array();
		
		$data=array(
		        'start'=>$start,
				'limit'=>20);
		$images = $this->model_catalog_joy->getImage($data);
		
		foreach($images as $image){
			$id = $image['content_id'];
			$present = $image['present'];
			$imageUrl = $this->model_tool_image->resize($image['imageUrl'],229,114);
			$favoriate = $image['favoriate'];
			$share = $image['share'];

			$comment = $this->model_catalog_joy->getTotalComments($image['content_id']);
			
		
			$this->data['show'][] = array(
			'id' => $id,
			'imageUrl'	=> $imageUrl,
			'present' => $present,
			'comment' => $comment,
			'favoriate' => $favoriate,
			'share' => $share
			);
			
		}

		echo json_encode($this->data['show']);

    }


    /**
	*  爽页面产品信息
	*/

	public function joyDetail(){
		$this->load->model('catalog/joy');
		$this->load->model('account/customer');
		$this->load->model('tool/image');
        
		if(!empty($this->request->get['id'])){
			$id = $this->request->get['id'];
			
			//$message = $this->model_catalog_joy->getMessageByShow($id);
			
			$content = $this->model_catalog_joy->getContent($id);
			
	
			if(empty($content)) return ;
			
			$poster=$this->model_account_customer->getCustomer($content['customer_id']);
			
			$customer=$this->model_account_customer->getCustomer($this->customer->getId());
		    
			$this->data['customer']=$customer;
			//var_dump($customer);
			//$content['content']=preg_replace("/\/cy\//",'',$content['content']);
		    //$content['content']=preg_replace("/(img\s*src=)['\\\"]([^'\\\"]+\.[jpg|png|jpeg|bmp])['\\\"]?/",'\\1'.HTTP_SERVER.'\\2',$content['content']);

			/* if(preg_match("/(src)\s*=\\\"([a-zA-Z0-9\/_]*)/",$content['content'])){
			   echo 'ok';
			}else{
			   echo 'no';
			} */
			
			
			$this->data['msg'] =array();
			$this->data['msg'] = array(
				'content_id' => $content['content_id'],
				'imageUrl' => $content['imageUrl'],
				'favoriate' => $content['favoriate'],
				'share' => $content['share'],
				'content'=>html_entity_decode($content['content'], ENT_QUOTES, 'UTF-8'),
				'title'=>$content['title'],
				'present'=>$content['present'],
				'createtime'=>date('Y-m-d',$content['createtime']),
				'poster' => $poster
				//'href' => $this->url->link('product/product','&product_id=' . $message['product_id'])

			);
            
			$comments=array();
			$cc = $this->model_catalog_joy->getComments($id);
		
			foreach($cc as $k=>$v){
			    $v['comment']=strip_tags(htmlspecialchars_decode($v['comment']));
				$y=$this->model_account_customer->getCustomer($v['userid']);
				$v['avatar']=$this->model_tool_image->resize($y['avatar'],'50','50');
				$comments[]=$v;
			}
			
			$this->data['comments'] = $comments;
          
			$this->data['userid']=$this->customer->getId();
			$this->data['username']=$this->customer->getUserName();
			$this->data['nickname']=$this->customer->getNickName();
			$this->data['email']=$this->customer->getEmail();
			
			$this->document->setTitle($this->config->get('config_title'));
			$this->document->setDescription($this->config->get('config_meta_description'));
			$this->data['heading_title'] = $this->config->get('config_title');
			
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/joyproduct.html')) {
				$this->template = $this->config->get('config_template') . '/template/product/joyproduct.html';
			} else {
				$this->template = 'default/template/product/joyproduct.html';
			}

			 $this->children = array(
				'common/footer',
				'common/header'
			); 
		
			$this->response->setOutput($this->render());
		
		}
	}

	/**
	*  喜欢按钮
	**/
	public function addFavoriate(){

		$this->load->model('catalog/joy');

		$id = $this->request->post['id'];	
		if(!empty($id)) $query=$this->model_catalog_joy->addFavoriate($id);
		
		if($query){
		    echo 1;
		}else{
		    echo 0;
		}
		
	}
    
	//评论
	public function addComment(){
		$this->load->model('catalog/joy');

		$id = $this->request->post['id'];
		
		$comment = $this->db->escape($this->request->post['comment']);

		if($this->model_catalog_joy->addComment($id,$comment)){
		    echo 1;
		}else{
		    echo 0;
		}
	}

}

?>