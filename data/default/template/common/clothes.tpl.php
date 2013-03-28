<?php echo $header;?>

<script type="text/javascript" src="catalog/view/javascript/initial_css_jquery.js"></script>

<script type="text/javascript">
$(function(){$('#promotion').cnckSuperMarquee({distance: 760,duration: 20,time: 6,direction: 'left',navId:'#promotion_nv'});});
$(function(){$('#brand_c').cnckSuperMarquee({distance: 810,duration: 50,time: 8,direction: 'left',btnGo:{left:'#brand_z',right:'#brand_y'}});});
MyCYAutoTabCon=setInterval("cnckMyAutoTabCon('#ranking_list_ta','#ranking_list_co')",3000);
</script>


<!--content begin-->
<div id="con" class="wp cl">
	<div id="con_z" class="z">
		<!--classify_promotion_brand 960*510-->
		<div class="classify_promotion_brand h">
		    <!--左侧分类列表begin-->
			<?php echo $left;?>
            <!--左侧分类列表end-->
			
			<div class="promotion_box z h">
				<div id="promotion" class="promotion h">
				<ul>
					<li class="z"><img src="catalog/view/theme/default/image/nousefulpic/ad1.gif" width="760" height="420" alt="promotion" /></li>
					<li class="z"><img src="catalog/view/theme/default/image/nousefulpic/ad2.gif" width="760" height="420" alt="promotion" /></li>
				</ul>				
				</div>
				<div id="promotion_nv" class="cl"><ul></ul></div>
			</div>
			
			<div class="brand_box cl h">
				<div id="brand_z" class="brand_z z"></div>
				<div id="brand_c" class="brand_c z h">
					<?php echo $brand;?>
				</div>
				<div id="brand_y" class="brand_y z"></div>
			</div>
		</div>
        
		
		<!--ranking_ad_list-->
		<div class="ranking_ad_list cl h">
			<div class="ranking_ad z">
				<div class="ranking_ad_box cl h"><a href="javascript:void(0);"><img src="catalog/view/theme/default/image/nousefulpic/ads1.gif" width="198" height="173" alt="ranking_ad" /></a></div>
				<div class="ranking_ad_box cl h"><a href="javascript:void(0);"><img src="catalog/view/theme/default/image/nousefulpic/ads2.gif" width="198" height="173" alt="ranking_ad" /></a></div>
			</div>
			<div class="ranking_list z">
				<ul id="ranking_list_ta" class="cl">
					<li class="f1 f_b">热销商品</li>
					<li class="f1 f_b">最潮新品</li>
					<li class="f1 f_b">人气商品</li>
				</ul>
				<ul id="ranking_list_co" class="cl h">
					<li class="dn">
					    <?php foreach((array)$hot_products as $hot) {?>
						<dl>
							<dd class="ddimg"><a href="index.php?route=product/product&product_id=<?php echo $hot['product_id'];?>"><img src="<?php echo $hot['image'];?>"  title="<?php echo $hot['name'];?>" /></a></dd>
						    <dt class="f_dh tc"><a href="index.php?route=product/product&product_id=<?php echo $hot['product_id'];?>"><span><?php echo $hot['shortname'];?></span></a></dt>
							<dd class="dds tc"><span class="f2 f_h">¥<?php echo $hot['price'];?></span></dd>
						</dl>
						<?php } ?>
					</li>
					<li class="dn">
					    <?php foreach((array)$new_products as $new) {?>
						<dl>
							<dd class="ddimg"><a href="index.php?route=product/product&product_id=<?php echo $new['product_id'];?>"><img src="<?php echo $new['image'];?>"  title="<?php echo $new['name'];?>" /></a></dd>
						    <dt class="f_dh tc"><a href="index.php?route=product/product&product_id=<?php echo $new['product_id'];?>"><span><?php echo $new['shortname'];?></span></a></dt>
							<dd class="dds  tc"><span class="f2 f_h">¥<?php echo $new['price'];?></span></dd>
						</dl>
						<?php } ?>
					</li>
					<li class="dn">
					    <?php foreach((array)$view_products as $view) {?>
						<dl>
							<dd class="ddimg"><a href="index.php?route=product/product&product_id=<?php echo $view['product_id'];?>"><img src="<?php echo $view['image'];?>"  title="<?php echo $view['name'];?>" /></a></dd>
						    <dt class="f_dh tc"><a href="index.php?route=product/product&product_id=<?php echo $view['product_id'];?>"><span><?php echo $view['shortname'];?></span></a></dt>
							<dd class="dds  tc"><span class="f2 f_h">¥<?php echo $view['price'];?></span></dd>
						</dl>
						<?php } ?>
					</li>
				</ul>
			</div>
		</div>
		<!--ranking_ad_list over-->
		
		<!--clothes 960*x-->
		<div class="clothes cl h">
		    <!--女装 -->
			<dl class="dress cl">
				<dt></dt>
				<!-- <dd class="clothes_ad cl h">
				   <a style="float:left;" href="#"><img src="catalog/view/theme/default/image/nousefulpic/clothes001_474x180.jpg" width="474" height="180" alt="clothes_ad" /></a>
				   <a style="float:left;" href="#"><img src="catalog/view/theme/default/image/nousefulpic/clothes002_474x180.jpg" width="474" height="180" alt="clothes_ad" /></a>
				</dd> -->
				<dd class="clothes_pro_box cl h">
				    <?php if(!empty($female_clothes)) { ?>
						<?php foreach((array)$female_clothes as $c) {?>
							<div class="clothes_pro"><p><a href="index.php?route=product/product&product_id=<?php echo $c['product_id'];?>"><img src="<?php echo $c['image'];?>" width="180" height="180" title="<?php echo $c['name'];?>" /></a></p><p><a href="index.php?route=product/product&product_id=<?php echo $c['product_id'];?>" class="f3n"><?php echo $c['shortname'];?></a></p><p class="f2 f_h">¥<?php echo $c['price'];?></p></div>
						<?php } ?>
					<?php } ?>
				</dd>
			</dl>
			
			<!--男装 -->
			<dl class="clothing cl">
				<dt></dt>
				<!-- <dd class="clothes_ad cl h"><a href="#">
				    <a style="float:left;" href="#"><img src="catalog/view/theme/default/image/nousefulpic/clothes003_474x180.jpg" width="474" height="180" alt="clothes_ad" /></a>
					<a style="float:left;" href="#"><img src="catalog/view/theme/default/image/nousefulpic/clothes004_474x180.jpg" width="474" height="180" alt="clothes_ad" /></a>
				</dd> -->
				<dd class="clothes_pro_box cl h" id="list_clothes_b">
					<?php if(!empty($male_clothes)) { ?>
						<?php foreach((array)$male_clothes as $c) {?>
							<div class="clothes_pro"><p><a href="index.php?route=product/product&product_id=<?php echo $c['product_id'];?>"><img src="<?php echo $c['image'];?>" width="180" height="180" title="<?php echo $c['name'];?>" /></a></p><p><a href="index.php?route=product/product&product_id=<?php echo $c['product_id'];?>" class="f3n"><?php echo $c['shortname'];?></a></p><p class="f2 f_h">¥<?php echo $c['price'];?></p></div>
						<?php } ?>
					<?php } ?>
			</dl>
			
			<!--运动 -->
			<dl class="sportswear cl">
				<dt></dt>
				<!-- <dd class="clothes_ad cl h">
				    <a style="float:left" href="#"><img src="catalog/view/theme/default/image/nousefulpic/clothes005_474x180.jpg" width="474" height="180" alt="clothes_ad" /></a>
					<a style="float:left" href="#"><img src="catalog/view/theme/default/image/nousefulpic/clothes006_474x180.jpg" width="474" height="180" alt="clothes_ad" /></a>
				</dd> -->
				<dd class="clothes_pro_box cl h" id="list_clothes_c">
					<?php if(!empty($sports_clothes)) { ?>
						<?php foreach((array)$sports_clothes as $c) {?>
							<div class="clothes_pro"><p><a href="index.php?route=product/product&product_id=<?php echo $c['product_id'];?>"><img src="<?php echo $c['image'];?>" width="180" height="180" title="<?php echo $c['name'];?>" /></a></p><p><a href="index.php?route=product/product&product_id=<?php echo $c['product_id'];?>" class="f3n"><?php echo $c['shortname'];?></a></p><p class="f2 f_h">¥<?php echo $c['price'];?></p></div>
						<?php } ?>
					<?php } ?>
                </dd>
			</dl>
		</div>
		<!--clothes over-->
		<!--clothes_bot_ad 960*60-->
		<div class="clothes_bot_ad cl h"><a href="#"><img src="catalog/view/theme/default/image/nousefulpic/clothes001_958x58.gif" width="958" height="58" alt="clothes_bot_ad" /></a></div>
		<!--clothes_bot_ad over-->
	</div>
	
	
	<div id="con_y" class="z">

		<!--notice_recommend 240*510-->
		<script><!--
		$(function(){$('#recommend').cnckSuperMarquee({distance: 238,duration: 20,time: 6,direction: 'left',navId:'#recommend_nv'});});
		//--></script>
		<!--div class="notice_recommend"-->
			<dl class="notice h">
				<dt>穿悦公告</dt>
				<dd class="tip"><a href="#">热烈祝贺穿悦商城上线试运行</a></dd>
				<dd class="tip"><a href="#"><p style="word-break: break-all; word-wrap:break-word;">为庆祝穿悦商城正式上线，前五十名入住商家赠送首页轮播广告一周</p></a></dd>
				<dd class="tip"><a href="#">穿悦商城，合肥人自己的网上商城</a></dd>
				<dd class="tip"><a href="#">庆新春迎新年，穿悦商城惊喜连连</a></dd>
				
			</dl>
            
           
		
		<!--style_tag 240*360-->
			<dl class="style_tag h">
				<dt><font class="f2 f_q">风格标签</font></dt>
				<dd>
					<div><a href="#">正能量</a></div>
					<div><a href="#">非主流</a></div>
					<div><a href="#">复古</a></div>
					<div><a href="#">萝莉</a></div>
					<div><a href="#">清新</a></div>
					<div><a href="#">自由</a></div>
					<div><a href="#" class="f_h">白领</a></div>
					<div><a href="#">学生</a></div>
					<div><a href="#">高富帅</a></div>
					<div><a href="#">白富美</a></div>
					<div><a href="#">卖萌</a></div>
					<div><a href="#">宝宝</a></div>
					<div><a href="#">宅生活</a></div>
					<div><a href="#" class="f_h">蜗居</a></div>
					
				</dd>
			</dl>
		<!--style_tag over-->
		<!--con_y_ads 240*x-->
		<!--右边图片-->
			<dl><img src="catalog/view/theme/default/image/nousefulpic/clothes001_240x420.gif" width="240" height="420" alt="" /></dl>
			<dl><img src="catalog/view/theme/default/image/nousefulpic/clothes001_240x420.gif" width="240" height="420" alt="" /></dl>
			<dl><img src="catalog/view/theme/default/image/nousefulpic/clothes001_240x420.gif" width="240" height="420" alt="" /></dl>
			<dl><img src="catalog/view/theme/default/image/nousefulpic/clothes001_240x420.gif" width="240" height="420" alt="" /></dl>
			
		<!--con_y_ads over-->
	</div>
</div>
<div class="cl_div"></div>
<!--content over-->
<script type="text/javascript">
    $(".clothes_pro").hover(function(){
	    $(this).css({'border':'1px solid black'});
	},function(){
	    $(this).css({'border':'1px solid #DBDBDB'});
	});

    gotoTop();//返回顶部
	
</script>

<?php echo $footer;?>