<?php 
	/**
	* 商品评价管理
	*/
    class ControllerMerchantsRemark extends Controller 
    {         
    
    
        /**
         * index: 返回店铺的评价统计交叉表
         * 
         * request->get[]
         * store_id: 店铺号
         * 
         * return
         * render
         * */
        public function index()
        {		
            $store_id = 0;
			if(isset($this->request->get['store_id'])){
				$store_id = $this->request->get['store_id'];
			} 
            $this->data['store_id'] = $store_id;           
            
			//$this->load->model('store/review');
			//$this->data['review_count'] = $this->model_store_review->getReviewCount($store_id);            

		
    		$this->children = array(
    			'merchants/left',
    			'merchants/footer',
    			'merchants/header'		
    		);
    		
    		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/merchants/merchants_remark.html')) 
            {
    			$this->template = $this->config->get('config_template') . '/template/merchants/merchants_remark.html';
    		} else {
    			$this->template = 'default/template/merchants/merchants_remark.html';
    		}		
    				
    		$this->response->setOutput($this->render());
      	}
        
        
        /**
         * get_store_reviews: 返回店铺的指定时间段和评论级别的具体评价
         * 
         * request->get[]
         * store_id: 店铺号
         * time: 时间区域，ModelStoreReview::$TIME_
         * rating: 评论等级，ModelStoreReview::$RATING_
         * 
         * return
         * ajax,
         * */
		 
		/*
        public function get_store_reviews()
        {            
            $this->load->model('store/review');
            
            $store_id = 0;
			if(isset($this->request->get['store_id'])){
				$store_id = $this->request->get['store_id'];
			}
            
            $rating = ModelStoreReview::$RATING_NORMAL;
            if(isset($this->request->get['rating'])){
				$rating = $this->request->get['rating'];
			}
            
            $time = ModelStoreReview::$TIME_RECENT_DAY30;
            if(isset($this->request->get['time'])){
				$time = $this->request->get['time'];
			}
            
			$reviews = $this->model_store_review->getReviews($store_id, $time, $rating);  
            
            $formated = '<TR><TD>%s</TD></TR>';
            foreach($reviews as $review)
            {
                $id = $review['product_id'];
                $title = $review['name'];
                
                echo sprintf($formated, $title);
                echo "\r\n";
            }
        }*/
                
    }
?>