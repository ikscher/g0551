<?php echo $header;?>
 <!--个人中心body_begin-->
<div class="mainContent clear">
 	<!--左侧begin-->
	<?php echo $left;?>
 	<!--左侧end-->
    <!--右侧begin-->
	<div class="right">
        	<div class="account_box" style="margin-bottom:10px;">
            	<div class="ac_bgs clearfix">
                    <div class="ac_t_l">账户信息</div>
                    <div class="ac_t_r">
                        <div class="ac_t_l_s"><img src="catalog/view/theme/default/image/member/pic_account_title_01.gif" /></div>
                        <div class="account_contianer">
                            <p class="line">尊敬的会员，欢迎您来到 <span class="c_purple">穿悦商城</span></p>
                            <div class="line_bot">
                           <!--  <p class="ac_t_s clearfix"><b>账户余额：</b>
							<span class="c_purple">￥2300.00</span>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							为了您的账户财产安全，请及时绑定您的手机 <a class="c_purple" href="">马上绑定>></a>
							</p> -->
							</div>
                            <p class="order_attention"><b>提醒：</b>
                                <span>待付款（<a class="c_purple" href="index.php?route=account/order&statusid=1"><?php echo $total_1;?></a>）</span>
                               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							    <span>待确认收货（<a class="c_purple" href="index.php?route=account/order&statusid=4"><?php echo $total_4;?></a>）</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        	
		<!-- <div class="memberAd"><img src="images/ad/member_ad.jpg" width="790" height="110" /></div> -->
          
        	<div class="account_box">
            	<div class="ac_bgs clearfix">
                    <div class="ac_t_l">猜你喜欢</div>
                    <div class="ac_t_r">
                        <div class="ac_t_l_s"><img src="catalog/view/theme/default/image/member/pic_account_title_02.gif" /></div>
                        <div class="account_contianer">
                        	
                            <ul class="product_list clearfix">
							    <?php foreach((array)$guessYouLike as $g) {?>
									<li>
										<a class="product_img" href="index.php?route=product/product&product_id=<?php echo $g['product_id'];?>"><img src="<?php echo $g['image'];?>" class="productImg" title="<?php echo $g['name'];?>"></a>
										<div class="product_n"><a href="index.php?route=product/product&product_id=<?php echo $g['product_id'];?>" ><?php echo $g['shortname'];?></a><p><?php echo $g['price'];?>元</p></div>
									</li>
								<?php } ?>     				
							</ul>
                            
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
</div>
 <!--个人中心body_end-->
<?php echo $footer;?>
