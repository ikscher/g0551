<?php echo $header;?>
<script type="text/javascript" src="catalog/view/javascript/initial_css_jquery.js"></script>

<script type="text/javascript"><!--
    $(function(){$('#promotion').cnckSuperMarquee({distance: 760,duration: 30,time: 6,direction: 'left',navId:'#promotion_nv'});});
	$(function(){$('#brand_c').cnckSuperMarquee({distance: 810,duration: 50,time: 8,direction: 'left',btnGo:{left:'#brand_z',right:'#brand_y'}});});
	$(function(){$('#promotion_snacks').cnckSuperMarquee({distance: 226,duration: 20,time: 4,direction: 'left',navId:'#promotion_snacks_nv'});});
	$(function(){$('#promotion_drink').cnckSuperMarquee({distance: 226,duration: 20,time: 4,direction: 'left',navId:'#promotion_drink_nv'});});
	$(function(){$('#promotion_greengrocer').cnckSuperMarquee({distance: 226,duration: 20,time: 4,direction: 'left',navId:'#promotion_greengrocer_nv'});});
	MyCYAutoTabCon=setInterval("cnckMyAutoTabCon('#rankingf_list_ta','#rankingf_list_co')",3000);
//-->
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
					<li class="z"><img src="catalog/view/theme/default/image/nousefulpic/ad3.gif" width="760" height="420" alt="promotion" /></li>
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
		
		<!--rankinfg_ad_list over-->
		
		<!--foods 960*x-->
		<div class="foods cl h">
			<dl class="snacks cl">
				<dt><div class="ftitle"></div></dt>
				<dd class="foods_pro_box cl h">
					<div class="foods_pro_box_z z h">
						<div id="promotion_snacks" class="h">
						<ul>
							<li><img src="catalog/view/theme/default/image/nousefulpic/foods001_226x362.gif" width="226" height="362" alt="promotion_snacks" /></li>
							<li><img src="catalog/view/theme/default/image/nousefulpic/foods002_226x362.gif" width="226" height="362" alt="promotion_snacks" /></li>
							<li><img src="catalog/view/theme/default/image/nousefulpic/foods003_226x362.gif" width="226" height="362" alt="promotion_snacks" /></li>
						</ul>
						</div>
						<div id="promotion_snacks_nv"><ul></ul></div>
					</div>
					<!--特产零食begin-->
					<div class="foods_pro_box_y z h">
					    <?php foreach((array)$snacks_foods as $s) {?>
						<dl>
							<dd><a href="index.php?route=product/product&product_id=<?php echo $s['product_id'];?>"><img src="<?php echo $s['image'];?>" width="180" height="180" title="<?php echo $s['name'];?>" /></a></dd>
							<dd class="fpro_intr_pric_bg"></dd>
							<dd class="fpro_intr_pric">
								<div class="fpro_intr z"><a href="index.php?route=product/product&product_id=<?php echo $s['product_id'];?>"><?php echo $s['shortname'];?></a></div>
								<div class="fpro_pric tc f_b z">¥<font class="f1 f_b"><?php echo $s['price'];?></font></div>
							</dd>							
						</dl>
						<?php } ?>
					</div>
					<!--特产零食begin-->
					
				</dd>
				<!-- <dd class="foods_ad cl h"><a href="#"><img src="catalog/view/theme/default/image/nousefulpic/foods001_960x90.gif" width="960" height="90" alt="foods_ad" /></a></dd> -->
			</dl>
			<dl class="drink cl">
				<dt><div class="ftitle"></div></dt>
				<dd class="foods_pro_box cl h">
					<div class="foods_pro_box_z z h">
						<div id="promotion_drink" class="h">
						<ul>							
							<li><img src="catalog/view/theme/default/image/nousefulpic/foods001_226x362.gif" width="226" height="362" alt="promotion_drink" /></li>
							<li><img src="catalog/view/theme/default/image/nousefulpic/foods002_226x362.gif" width="226" height="362" alt="promotion_drink" /></li>
							<li><img src="catalog/view/theme/default/image/nousefulpic/foods003_226x362.gif" width="226" height="362" alt="promotion_drink" /></li>
						</ul>
						</div>
						<div id="promotion_drink_nv"><ul></ul></div>
					</div>
					<!--茶叶饮料begin-->
					<div class="foods_pro_box_y z h" id="list_foods_b">
					    <?php foreach((array)$drinks_foods as $d) {?>
						<dl>
							<dd><a href="index.php?route=product/product&product_id=<?php echo $d['product_id'];?>"><img src="<?php echo $d['image'];?>" width="180" height="180" title="<?php echo $d['name'];?>" /></a></dd>
							<dd class="fpro_intr_pric_bg"></dd>
							<dd class="fpro_intr_pric">
								<div class="fpro_intr z"><a href="index.php?route=product/product&product_id=<?php echo $d['product_id'];?>"><?php echo $d['shortname'];?></a></div>
								<div class="fpro_pric tc f_b z">¥<font class="f1 f_b"><?php echo $d['price'];?></font></div>
							</dd>							
						</dl>
						<?php } ?>
					</div>
					<!--茶叶饮料end-->
				</dd>
				<!-- <dd class="foods_ad cl h"><a href="#"><img src="catalog/view/theme/default/image/nousefulpic/foods002_960x90.gif" width="960" height="90" alt="foods_ad" /></a></dd> -->
			</dl>
			<dl class="greengrocer cl">
				<dt><div class="ftitle"></div></dt>
				<dd class="foods_pro_box cl h">
					<div class="foods_pro_box_z z h">
						<div id="promotion_greengrocer" class="h">
						<ul>
							<li><img src="catalog/view/theme/default/image/nousefulpic/foods001_226x362.gif" width="226" height="362" alt="promotion_greengrocer" /></li>
							<li><img src="catalog/view/theme/default/image/nousefulpic/foods001_226x362.gif" width="226" height="362" alt="promotion_greengrocer" /></li>
							<li><img src="catalog/view/theme/default/image/nousefulpic/foods003_226x362.gif" width="226" height="362" alt="promotion_greengrocer" /></li>							
						</ul>
						</div>
						<div id="promotion_greengrocer_nv"><ul></ul></div>
					</div>
					<!--绿色蔬果begin-->
					<div class="foods_pro_box_y z h" id="list_foods_c">
					    <?php foreach((array)$fruit_foods as $f) {?>
						<dl>
							<dd><a href="index.php?route=product/product&product_id=<?php echo $f['product_id'];?>"><img src="<?php echo $f['image'];?>" width="180" height="180" title="<?php echo $f['name'];?>" /></a></dd>
							<dd class="fpro_intr_pric_bg"></dd>
							<dd class="fpro_intr_pric">
								<div class="fpro_intr z"><a href="index.php?route=product/product&product_id=<?php echo $f['product_id'];?>"><?php echo $f['shortname'];?></a></div>
								<div class="fpro_pric tc f_b z">¥<font class="f1 f_b"><?php echo $f['price'];?></font></div>
							</dd>							
						</dl>
						<?php } ?>
					</div>
					<!--绿色蔬果end-->
				</dd>
				<!-- <dd class="foods_ad cl h"><a href="#"><img src="catalog/view/theme/default/image/nousefulpic/foods003_960x90.gif" width="960" height="90" alt="foods_ad" /></a></dd> -->
			</dl>
		</div>
		<!--clothes over-->
	</div>
	
	
	
	<div id="con_y" class="z">

		<!--fhotsearch_fpromotion 240*510-->
        <!--
			<dl class="fhotsearch h">
				<dt><font class="f2 f_q z">热搜商品</font><a href="#" class="y">更多>></a></dt>
				<dd class="intr"><a href="#">传统月饼融入了流行的口感，实在是月到中秋越想吃！</a></dd>
				<dd class="pic"><a href="#"><img src="catalog/view/theme/default/image/nousefulpic/fadh1.gif" width="236" height="150" alt="fhotsearch" /></a></dd>
				<dd class="buy"><div class="buy_pric f_b tc z">￥<font class="f1 f_b">5元起</font></div><div class="y"><a href="#" class="buy_buynow"></a></div></dd>
			</dl>
			<dl class="fpromotion h">
				<dt><font class="f2 f_q">促销活动</font></dt>
				<dd><div class="fpromotion_ddz z h"><img src="catalog/view/theme/default/image/nousefulpic/fadp1.gif" width="74" height="74" alt="fpromotion" /></div>
				<div class="fpromotion_ddy z h"><p><a class="f2" href="#">养生堂</a></p><p><a href="#">内服美容，祛斑美白</a></p><p><a class="f3 f_h" href="#">全场特惠双重礼！</a></p></div></dd>
				<dd><div class="fpromotion_ddz z h"><img src="catalog/view/theme/default/image/nousefulpic/fadp1.gif" width="74" height="74" alt="fpromotion" /></div>
				<div class="fpromotion_ddy z h"><p><a class="f2" href="#">养生堂</a></p><p><a href="#">内服美容，祛斑美白</a></p><p><a class="f3 f_h" href="#">全场特惠双重礼！</a></p></div></dd>
			</dl>
        -->
		<!--/div-->
		<!--fhotsearch_fpromotion over-->
		
		<!--flagship_brand 240*310-->
			<dl class="flagship_brand h">
				<dt><font class="f2 f_q z">品牌旗舰店</font></dt>
				<dd>
					<!-- <div><a href="#"><img src="catalog/view/theme/default/image/nousefulpic/foods001_98x38.gif" width="98" height="38" alt="flagship_brand" /></a></div>
					<div><a href="#"><img src="catalog/view/theme/default/image/nousefulpic/foods002_98x38.gif" width="98" height="38" alt="flagship_brand" /></a></div>
					<div><a href="#"><img src="catalog/view/theme/default/image/nousefulpic/foods001_98x38.gif" width="98" height="38" alt="flagship_brand" /></a></div>
					<div><a href="#"><img src="catalog/view/theme/default/image/nousefulpic/foods002_98x38.gif" width="98" height="38" alt="flagship_brand" /></a></div>
					<div><a href="#"><img src="catalog/view/theme/default/image/nousefulpic/foods001_98x38.gif" width="98" height="38" alt="flagship_brand" /></a></div>
					<div><a href="#"><img src="catalog/view/theme/default/image/nousefulpic/foods002_98x38.gif" width="98" height="38" alt="flagship_brand" /></a></div>
					<div><a href="#"><img src="catalog/view/theme/default/image/nousefulpic/foods001_98x38.gif" width="98" height="38" alt="flagship_brand" /></a></div>
					<div><a href="#"><img src="catalog/view/theme/default/image/nousefulpic/foods002_98x38.gif" width="98" height="38" alt="flagship_brand" /></a></div>
					<div><a href="#"><img src="catalog/view/theme/default/image/nousefulpic/foods001_98x38.gif" width="98" height="38" alt="flagship_brand" /></a></div>
					<div><a href="#"><img src="catalog/view/theme/default/image/nousefulpic/foods002_98x38.gif" width="98" height="38" alt="flagship_brand" /></a></div> -->
				</dd>
			</dl>
		<!--flagship_brand over-->
		<!--top_ranking 240*400-->
			<dl class="top_ranking h">
				<dt><font class="f2 f_b">零食特产热销榜</font></dt>
				<!-- <dd>
					<div class="codeNum tc f_b z">1</div>
					<div class="ddo_img z h dn"><img src="catalog/view/theme/default/image/nousefulpic/fprot1.gif" width="60" height="60" alt="top_ranking" /></div>
					<div class="ddo_txt z"><p><a href="#">万人推荐 新疆薄皮核桃</a></p><p class="hot">热销<font class="f3 f_j">3666</font>件</p></div>
				</dd>
				<dd>
					<div class="codeNum tc f_b z">2</div>
					<div class="ddo_img z h dn"><img src="catalog/view/theme/default/image/nousefulpic/fprot1.gif" width="60" height="60" alt="top_ranking" /></div>
					<div class="ddo_txt z"><p><a href="#">万人推荐 新疆薄皮核桃</a></p><p class="hot dn">热销<font class="f3 f_j">3666</font>件</p></div>
				</dd>
				<dd>
					<div class="codeNum tc f_b z">3</div>
					<div class="ddo_img z h dn"><img src="catalog/view/theme/default/image/nousefulpic/fprot1.gif" width="60" height="60" alt="top_ranking" /></div>
					<div class="ddo_txt z"><p><a href="#">万人推荐 新疆薄皮核桃</a></p><p class="hot dn">热销<font class="f3 f_j">3666</font>件</p></div>
				</dd>
				<dd>
					<div class="codeNum tc f_b z">4</div>
					<div class="ddo_img z h dn"><img src="catalog/view/theme/default/image/nousefulpic/fprot1.gif" width="60" height="60" alt="top_ranking" /></div>
					<div class="ddo_txt z"><p><a href="#">万人推荐 新疆薄皮核桃</a></p><p class="hot dn">热销<font class="f3 f_j">3666</font>件</p></div>
				</dd>
				<dd>
					<div class="codeNum tc f_b z">5</div>
					<div class="ddo_img z h dn"><img src="catalog/view/theme/default/image/nousefulpic/fprot1.gif" width="60" height="60" alt="top_ranking" /></div>
					<div class="ddo_txt z"><p><a href="#">万人推荐 新疆薄皮核桃</a></p><p class="hot dn">热销<font class="f3 f_j">3666</font>件</p></div>
				</dd>
				<dd>
					<div class="codeNum tc f_b z">6</div>
					<div class="ddo_img z h dn"><img src="catalog/view/theme/default/image/nousefulpic/fprot1.gif" width="60" height="60" alt="top_ranking" /></div>
					<div class="ddo_txt z"><p><a href="#">万人推荐 新疆薄皮核桃</a></p><p class="hot dn">热销<font class="f3 f_j">3666</font>件</p></div>
				</dd>
				<dd>
					<div class="codeNum tc f_b z">7</div>
					<div class="ddo_img z h dn"><img src="catalog/view/theme/default/image/nousefulpic/fprot1.gif" width="60" height="60" alt="top_ranking" /></div>
					<div class="ddo_txt z"><p><a href="#">万人推荐 新疆薄皮核桃</a></p><p class="hot dn">热销<font class="f3 f_j">3666</font>件</p></div>
				</dd>
				<dd>
					<div class="codeNum tc f_b z">8</div>
					<div class="ddo_img z h dn"><img src="catalog/view/theme/default/image/nousefulpic/fprot1.gif" width="60" height="60" alt="top_ranking" /></div>
					<div class="ddo_txt z"><p><a href="#">万人推荐 新疆薄皮核桃</a></p><p class="hot dn">热销<font class="f3 f_j">3666</font>件</p></div>
				</dd> -->
			</dl>
		<!--top_ranking over-->
		<!--fads-------------->
			<dl><a href="#"><img src="catalog/view/theme/default/image/nousefulpic/foods001_240x90.gif" width="240" height="90" alt="fads" /></a></dl>
		<!--fads-------------->
		<!--top_ranking 240*400-->
			<dl class="top_ranking h">
				<dt><font class="f2 f_b">各地名茶热销榜</font></dt>
				<!-- <dd>
					<div class="codeNum tc f_b z">1</div>
					<div class="ddo_img z h dn"><img src="catalog/view/theme/default/image/nousefulpic/fprot1.gif" width="60" height="60" alt="top_ranking" /></div>
					<div class="ddo_txt z"><p><a href="#">万人推荐 新疆薄皮核桃</a></p><p class="hot">热销<font class="f3 f_j">3666</font>件</p></div>
				</dd>
				<dd>
					<div class="codeNum tc f_b z">2</div>
					<div class="ddo_img z h dn"><img src="catalog/view/theme/default/image/nousefulpic/fprot1.gif" width="60" height="60" alt="top_ranking" /></div>
					<div class="ddo_txt z"><p><a href="#">万人推荐 新疆薄皮核桃</a></p><p class="hot dn">热销<font class="f3 f_j">3666</font>件</p></div>
				</dd>
				<dd>
					<div class="codeNum tc f_b z">3</div>
					<div class="ddo_img z h dn"><img src="catalog/view/theme/default/image/nousefulpic/fprot1.gif" width="60" height="60" alt="top_ranking" /></div>
					<div class="ddo_txt z"><p><a href="#">万人推荐 新疆薄皮核桃</a></p><p class="hot dn">热销<font class="f3 f_j">3666</font>件</p></div>
				</dd>
				<dd>
					<div class="codeNum tc f_b z">4</div>
					<div class="ddo_img z h dn"><img src="catalog/view/theme/default/image/nousefulpic/fprot1.gif" width="60" height="60" alt="top_ranking" /></div>
					<div class="ddo_txt z"><p><a href="#">万人推荐 新疆薄皮核桃</a></p><p class="hot dn">热销<font class="f3 f_j">3666</font>件</p></div>
				</dd>
				<dd>
					<div class="codeNum tc f_b z">5</div>
					<div class="ddo_img z h dn"><img src="catalog/view/theme/default/image/nousefulpic/fprot1.gif" width="60" height="60" alt="top_ranking" /></div>
					<div class="ddo_txt z"><p><a href="#">万人推荐 新疆薄皮核桃</a></p><p class="hot dn">热销<font class="f3 f_j">3666</font>件</p></div>
				</dd>
				<dd>
					<div class="codeNum tc f_b z">6</div>
					<div class="ddo_img z h dn"><img src="catalog/view/theme/default/image/nousefulpic/fprot1.gif" width="60" height="60" alt="top_ranking" /></div>
					<div class="ddo_txt z"><p><a href="#">万人推荐 新疆薄皮核桃</a></p><p class="hot dn">热销<font class="f3 f_j">3666</font>件</p></div>
				</dd>
				<dd>
					<div class="codeNum tc f_b z">7</div>
					<div class="ddo_img z h dn"><img src="catalog/view/theme/default/image/nousefulpic/fprot1.gif" width="60" height="60" alt="top_ranking" /></div>
					<div class="ddo_txt z"><p><a href="#">万人推荐 新疆薄皮核桃</a></p><p class="hot dn">热销<font class="f3 f_j">3666</font>件</p></div>
				</dd>
				<dd>
					<div class="codeNum tc f_b z">8</div>
					<div class="ddo_img z h dn"><img src="catalog/view/theme/default/image/nousefulpic/fprot1.gif" width="60" height="60" alt="top_ranking" /></div>
					<div class="ddo_txt z"><p><a href="#">万人推荐 新疆薄皮核桃</a></p><p class="hot dn">热销<font class="f3 f_j">3666</font>件</p></div>
				</dd> -->
			</dl>
		<!--top_ranking over-->
		<!--fads-------------->
			<dl><a href="#"><img src="catalog/view/theme/default/image/nousefulpic/foods002_240x90.gif" width="240" height="90" alt="fads" /></a></dl>
		<!--fads-------------->
		<!--top_ranking 240*400-->
			<dl class="top_ranking h">
				<dt><font class="f2 f_b">绿色蔬果热销榜</font></dt>
				<!-- <dd>
					<div class="codeNum tc f_b z">1</div>
					<div class="ddo_img z h dn"><img src="catalog/view/theme/default/image/nousefulpic/fprot1.gif" width="60" height="60" alt="top_ranking" /></div>
					<div class="ddo_txt z"><p><a href="#">万人推荐 新疆薄皮核桃</a></p><p class="hot">热销<font class="f3 f_j">3666</font>件</p></div>
				</dd>
				<dd>
					<div class="codeNum tc f_b z">2</div>
					<div class="ddo_img z h dn"><img src="catalog/view/theme/default/image/nousefulpic/fprot1.gif" width="60" height="60" alt="top_ranking" /></div>
					<div class="ddo_txt z"><p><a href="#">万人推荐 新疆薄皮核桃</a></p><p class="hot dn">热销<font class="f3 f_j">3666</font>件</p></div>
				</dd>
				<dd>
					<div class="codeNum tc f_b z">3</div>
					<div class="ddo_img z h dn"><img src="catalog/view/theme/default/image/nousefulpic/fprot1.gif" width="60" height="60" alt="top_ranking" /></div>
					<div class="ddo_txt z"><p><a href="#">万人推荐 新疆薄皮核桃</a></p><p class="hot dn">热销<font class="f3 f_j">3666</font>件</p></div>
				</dd>
				<dd>
					<div class="codeNum tc f_b z">4</div>
					<div class="ddo_img z h dn"><img src="catalog/view/theme/default/image/nousefulpic/fprot1.gif" width="60" height="60" alt="top_ranking" /></div>
					<div class="ddo_txt z"><p><a href="#">万人推荐 新疆薄皮核桃</a></p><p class="hot dn">热销<font class="f3 f_j">3666</font>件</p></div>
				</dd>
				<dd>
					<div class="codeNum tc f_b z">5</div>
					<div class="ddo_img z h dn"><img src="catalog/view/theme/default/image/nousefulpic/fprot1.gif" width="60" height="60" alt="top_ranking" /></div>
					<div class="ddo_txt z"><p><a href="#">万人推荐 新疆薄皮核桃</a></p><p class="hot dn">热销<font class="f3 f_j">3666</font>件</p></div>
				</dd>
				<dd>
					<div class="codeNum tc f_b z">6</div>
					<div class="ddo_img z h dn"><img src="catalog/view/theme/default/image/nousefulpic/fprot1.gif" width="60" height="60" alt="top_ranking" /></div>
					<div class="ddo_txt z"><p><a href="#">万人推荐 新疆薄皮核桃</a></p><p class="hot dn">热销<font class="f3 f_j">3666</font>件</p></div>
				</dd>
				<dd>
					<div class="codeNum tc f_b z">7</div>
					<div class="ddo_img z h dn"><img src="catalog/view/theme/default/image/nousefulpic/fprot1.gif" width="60" height="60" alt="top_ranking" /></div>
					<div class="ddo_txt z"><p><a href="#">万人推荐 新疆薄皮核桃</a></p><p class="hot dn">热销<font class="f3 f_j">3666</font>件</p></div>
				</dd>
				<dd>
					<div class="codeNum tc f_b z">8</div>
					<div class="ddo_img z h dn"><img src="catalog/view/theme/default/image/nousefulpic/fprot1.gif" width="60" height="60" alt="top_ranking" /></div>
					<div class="ddo_txt z"><p><a href="#">万人推荐 新疆薄皮核桃</a></p><p class="hot dn">热销<font class="f3 f_j">3666</font>件</p></div>
				</dd> -->
			</dl>
		<!--top_ranking over-->
		<!--fads-------------->
			<!-- <dl><a href="#"><img src="catalog/view/theme/default/image/nousefulpic/foods002_240x90.gif" width="240" height="90" alt="fads" /></a></dl> -->
		<!--fads-------------->
	</div>
</div>
<div class="cl_div"></div>
<!--content over-->
<script type="text/javascript">
    gotoTop();//返回顶部
</script>
<?php echo $footer;?>