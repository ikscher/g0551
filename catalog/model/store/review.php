<?php
Class ModelStoreReview extends Model 
{
    static $TIME_RECENT_DAY30 = 30;   //最近30天
    static $TIME_RECENT_DAY90 = 90;   //最近90天
    static $TIME_RECENT_DAY180 = 180; //最近180天
    static $TIME_LATER_DAY30 = -180;  //180天前
        
    static $RATING_GOOD = 1;    //好评
    static $RATING_NORMAL = 0;  //中评
    static $RATING_BAD = -1;    //差评
    
    static $SECOND_IN_DAY = 86400; //一天中的秒数
    
    
    /**
     * getReviewCount：返回评论数
     * 
     * $store_id：商店号
     * 
     * 返回评论二维数组[时间段][评论等级]
     * */
    public function getReviewCount($store_id){

        $review_count = array();

		$review_count[ModelStoreReview::$TIME_RECENT_DAY30] = $this->getReviewCountByTime($store_id, ModelStoreReview::$TIME_RECENT_DAY30);
        $review_count[ModelStoreReview::$TIME_RECENT_DAY90] = $this->getReviewCountByTime($store_id, ModelStoreReview::$TIME_RECENT_DAY90);
        $review_count[ModelStoreReview::$TIME_RECENT_DAY180] = $this->getReviewCountByTime($store_id, ModelStoreReview::$TIME_RECENT_DAY180);
        $review_count[ModelStoreReview::$TIME_LATER_DAY30] = $this->getReviewCountByTime($store_id, ModelStoreReview::$TIME_LATER_DAY30);
      
        return $review_count;
    }
     
    /**
     * getReviewCountByTime：返回指定时间段的评论数
     * 
     * $store_id：商店号
     * $time：时间段，ModelStoreReview::$TIME_
     * 
     * 返回评论二维数组[时间段][评论等级]
     * */
    private function getReviewCountByTime($store_id, $time)
    {
        $review_count = array();
        $review_count[ModelStoreReview::$RATING_GOOD] = 0;
        $review_count[ModelStoreReview::$RATING_NORMAL] = 0;
        $review_count[ModelStoreReview::$RATING_BAD] = 0;
        
        $sql = 'SELECT count(*) as count, rating from review where product_id in (SELECT product_id from product where store_id = ' . $store_id . ')'; 

        if($time > 0)
        {
            $sql = $sql . ' and date_added >= UNIX_TIMESTAMP() - ' . ($time * ModelStoreReview::$SECOND_IN_DAY);
        }
        else
        {
            $sql = $sql . ' and date_added < UNIX_TIMESTAMP() + ' . ($time * ModelStoreReview::$SECOND_IN_DAY);
        }

        $sql = $sql . ' GROUP BY rating';
        
        $items = $this->db->query($sql)->rows;
        foreach($items as $item)
        {
            $review_count[$item['rating']] = $item['count'];
        }
        
        return $review_count;
    }
     

    /**
     * getReviews：返回符合条件的评论
     * 
     * $store_id：商店号
     * $time：时间段，ModelStoreReview::$TIME_
     * rating: 评论等级，ModelStoreReview::$RATING_
     * 
     * 返回：review数组
     * */
    private function getReviews($store_id, $time, $rating)
    {
        $sql = 'SELECT * from review where product_id in (SELECT product_id from product where store_id = ' . $store_id . ')'; 

        if($time > 0)
        {
            $sql = $sql . ' and date_added >= UNIX_TIMESTAMP() - ' . ($time * ModelStoreReview::$SECOND_IN_DAY);
        }
        else
        {
            $sql = $sql . ' and date_added < UNIX_TIMESTAMP() + ' . ($time * ModelStoreReview::$SECOND_IN_DAY);
        }

        $sql = $sql . ' and rating = ' . $rating;
        
        $sql = $sql . ' order by date_added desc';
        
        return $this->db->query($sql);
    }
}
?>