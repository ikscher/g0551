<?php echo $header;?>
<link href="catalog/view/theme/default/stylesheet/product.css?v=20130321" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="catalog/view/theme/default/stylesheet/jquery.jqzoom.css" type="text/css">
<!--clothes_show-->
<div id="product_show" class="wps cl">
	
	<div class="notification"> </div>
	<div class="product_show_focus_nature">
		<div class="product_focus h z">
			<dl>
			<dt id="product_focus_up" class="product_focus_up"></dt>
			<dd id="product_focus_img" class="product_focus_img">
				<ul id="thumblist" >
                    <?php foreach((array)$images as $image) {?>
                        <li class="colorbox"  rel="colorbox" data-image="<?php echo $image['popup'];?>"><a  href='javascript:void(0);' rel="{gallery: 'gal1', smallimage: '<?php echo $image['image'];?>',largeimage: '<?php echo $image['popup'];?>'}"><img src="<?php echo $image['thumb'];?>" /></a></li>
                    <?php } ?>
				</ul>
			</dd>
			<dt id="product_focus_down" class="product_focus_down"></dt>
			</dl>
		</div>
		
		<div class="product_show z">
            <a href="<?php echo $popup;?>" class="jqzoom" rel='gal1'  title="" ><img  src="<?php echo $addtional;?>" title="" /></a>
			<div class="zoom-icon" id="J_ZoomIcon"></div>
		</div>
		
		<div class="product_info h z">
		<dl>
		    
			<dt class="f1 f_q"><?php echo $product['name'];?> </dt>
			
			  
			<dd><?php if(isset($product['special']['price'])) { ?>原价：<span class="f0 price_old"><?php echo $product['price'];?></span>元  <span class="space"></span>  商城价：<span class="f0 f_h"><?php echo $product['special']['price'];?></span>元<span class="interval"><?php if(isset($interval)) { ?>限时<?php echo $interval;?>天<?php } ?></span> <?php } else { ?><span class="f0 f_h"><?php echo $product['price'];?></span>元<?php } ?></dd>
			
        
            <dd class="product_info_o">
				<ul>
          
                    <li class="product_info_num h">
						<font class="z">购买数量：</font>
                        
						<input type="hidden" name="product_id" value="<?php echo $product['product_id'];?>"  />
                        <input class="z" type="text" id="goodsnum" name="quantity" value="1" maxlength="4" />
                       
						<div class="jiajianbtn z h">
							<p><input class="jia cl" type="button" /></p>
                            <p><input class="jian cl" type="button" /></p>
						</div>
						<font class="z h"> 件 (库存<?php echo $product['quantity'];?>件)</font>
					</li>
					<li class="l2 cl h"></li>
					<li class="cl">
					 <?php if($attributes) { ?>
					    <div class="attributes">
					        <?php foreach((array)$attributes as $attribute) {?>
								<?php if($attribute['type'] == 'select') { ?>
								<div id="attribute-<?php echo $attribute['attribute_group_id'];?>" class="attribute">
								  <span class="required">*</span>
								  <b><?php echo $attribute['attribute_group_name'];?>:</b>
								  <select name="attribute[<?php echo $attribute['attribute_group_id'];?>]">
									<option value=""><?php echo $text_select;?></option>
									<?php foreach((array)$attribute['product_option_value'] as $option_value) {?>
									<option value="<?php echo $option_value['attribute_id'];?>"><?php echo $option_value['name'];?></option>
									<?php } ?>
								  </select>
								</div>
								 <?php } ?>
								 
								<?php if($attribute['type'] == 'radio') { ?>
								<div id="attribute-<?php echo $attribute['attribute_group_id'];?>" class="attribute">
								  <span class="required">*</span>
								  <b><?php echo $attribute['attribute_group_name'];?>:</b>
								  <?php foreach((array)$attribute['product_option_value'] as $option_value) {?>
								  <input type="radio" name="attribute[<?php echo $attribute['attribute_group_id'];?>]" value="<?php echo $option_value['attribute_id'];?>" id="option-value-<?php echo $option_value['attribute_id'];?>" />
								  <label for="option-value-<?php echo $option_value['attribute_id'];?>"><?php echo $option_value['name'];?></label>
								 <?php } ?>
								</div>
								<?php } ?>
								
								<?php if($attribute['type'] == 'checkbox') { ?>
								<div id="attribute-<?php echo $attribute['attribute_group_id'];?>" class="attribute">
								  <span class="required">*</span>
								  <b><?php echo $attribute['attribute_group_name'];?>:</b>
								  <?php foreach((array)$attribute['product_option_value'] as $option_value) {?>
								  <input type="checkbox" name="attribute[<?php echo $attribute['attribute_group_id'];?>][]" value="<?php echo $option_value['attribute_id'];?>" id="option-value-<?php echo $option_value['attribute_id'];?>" />
								  <label for="option-value-<?php echo $option_value['attribute_id'];?>"><?php echo $option_value['name'];?></label>
								  <?php } ?>
								</div>
								
								<?php } ?>
							<?php } ?>
					    </div>
					 <?php } ?>
					 
					 
					 
					 <?php if($options) { ?>
						  <div class="options">
							
							<?php foreach((array)$options as $option) {?>
								<?php if($option['type'] == 'select') { ?>
								<div id="option-<?php echo $option['product_option_id'];?>" class="option">
								  <?php if($option['required']) { ?>
								  <span class="required">*</span>
								   <?php } ?>
								  <b><?php echo $option['attribute_group_name'];?>:</b>
								  <select name="option[<?php echo $option['product_option_id'];?>]">
									<option value=""><?php echo $text_select;?></option>
									<?php foreach((array)$option['option_value'] as $option_value) {?>
									<option value="<?php echo $option_value['product_option_value_id'];?>"><?php echo $option_value['name'];?>
									<?php if($option_value['price']) { ?>
									(<?php echo $option_value['price_prefix'];?><?php echo $option_value['price'];?>)
									<?php } ?>
									</option>
									<?php } ?>
								  </select>
								</div>
								
								 <?php } ?>
								 
								<?php if($option['type'] == 'radio') { ?>
								<div id="option-<?php echo $option['product_option_id'];?>" class="option">
								  <?php if($option['required']) { ?>
								  <span class="required">*</span>
								   <?php } ?>
								  <b><?php echo $option['attribute_group_name'];?>:</b>
								  <?php foreach((array)$option['option_value'] as $option_value) {?>
								  <input type="radio" name="option[<?php echo $option['product_option_id'];?>]" value="<?php echo $option_value['product_option_value_id'];?>" id="option-value-<?php echo $option_value['product_option_value_id'];?>" />
								  <label for="option-value-<?php echo $option_value['product_option_value_id'];?>"><?php echo $option_value['name'];?>
									<?php if($option_value['price']) { ?>
									(<?php echo $option_value['price_prefix'];?><?php echo $option_value['price'];?>)
									 <?php } ?>
								  </label>
								 
								 <?php } ?>
								</div>
								<?php } ?>
								
								<?php if($option['type'] == 'checkbox') { ?>
								<div id="option-<?php echo $option['product_option_id'];?>" class="option">
								  <?php if($option['required']) { ?>
								  <span class="required">*</span>
								   <?php } ?>
								  <b><?php echo $option['attribute_group_name'];?>:</b>
								  <?php foreach((array)$option['option_value'] as $option_value) {?>
								  <input type="checkbox" name="option[<?php echo $option['product_option_id'];?>][]" value="<?php echo $option_value['product_option_value_id'];?>" id="option-value-<?php echo $option_value['product_option_value_id'];?>" />
								  <label for="option-value-<?php echo $option_value['product_option_value_id'];?>"><?php echo $option_value['name'];?>
									<?php if($option_value['price']) { ?>
									(<?php echo $option_value['price_prefix'];?><?php echo $option_value['price'];?>)
									 <?php } ?>
								  </label>
								  <?php } ?>
								</div>
								
								<?php } ?>
								
								<?php if($option['type'] == 'image') { ?>
								<div id="option-<?php echo $option['product_option_id'];?>" class="option">
								  <?php if($option['required']) { ?>
								  <span class="required">*</span>
								   <?php } ?>
								  <b><?php echo $option['attribute_group_name'];?>:</b>
									<table class="option-image">
									  <?php foreach((array)$option['option_value'] as $option_value) {?>
									  <tr>
										<td style="width: 1px;"><input type="radio" name="option[<?php echo $option['product_option_id'];?>]" value="<?php echo $option_value['product_option_value_id'];?>" id="option-value-<?php echo $option_value['product_option_value_id'];?>" /></td>
										<td><label for="option-value-<?php echo $option_value['product_option_value_id'];?>"><img src="<?php echo $option_value['image'];?>" alt="<?php echo $option_value['name'];?>  (<?php $option_value['price']?> ? ' ' . <?php echo $option_value['price_prefix'];?> . <?php echo $option_value['price'];?> : '')}" /></label></td>
										<td><label for="option-value-<?php echo $option_value['product_option_value_id'];?>"><?php echo $option_value['name'];?>
											<?php if($option_value['price']) { ?>
											(<?php echo $option_value['price_prefix'];?><?php echo $option_value['price'];?>)
											<?php } ?>
										  </label></td>
									  </tr>
									  <?php } ?>
									</table>
								</div>
								<?php } ?>
								
								<?php if($option['type'] == 'text') { ?>
								<div id="option-<?php echo $option['product_option_id'];?>" class="option">
								  <?php if($option['required']) { ?>
								  <span class="required">*</span>
								   <?php } ?>
								  <b><?php echo $option['attribute_group_name'];?>:</b>
								  <input type="text" name="option[<?php echo $option['product_option_id'];?>]" value="<?php echo $option['option_value'];?>" />
								</div>
								<?php } ?>
								 
								<?php if($option['type'] == 'textarea') { ?>
								<div id="option-<?php echo $option['product_option_id'];?>" class="option">
								  <?php if($option['required']) { ?>
								  <span class="required">*</span>
								   <?php } ?>
								  <b><?php echo $option['attribute_group_name'];?>:</b>
								  <textarea name="option[<?php echo $option['product_option_id'];?>]" cols="40" rows="5"><?php echo $option['option_value'];?></textarea>
								</div>
								<?php } ?>
								<?php if($option['type'] == 'file') { ?>
								<div id="option-<?php echo $option['product_option_id'];?>" class="option">
								  <?php if($option['required']) { ?>
								  <span class="required">*</span>
								   <?php } ?>
								  <b><?php echo $option['attribute_group_name'];?>:</b>
								  <a id="button-option-<?php echo $option['product_option_id'];?>" class="button"><?php echo $button_upload;?></a>
								  <input type="hidden" name="option[<?php echo $option['product_option_id'];?>]" value="" />
								</div>
								<?php } ?>
								<?php if($option['type'] == 'date') { ?>
								<div id="option-<?php echo $option['product_option_id'];?>" class="option">
								  <?php if($option['required']) { ?>
								  <span class="required">*</span>
								   <?php } ?>
								  <b><?php echo $option['attribute_group_name'];?>:</b>
								  <input type="text" name="option[<?php echo $option['product_option_id'];?>]" value="<?php echo $option['option_value'];?>" class="date" />
								</div>
								<?php } ?>
								<?php if($option['type'] == 'datetime') { ?>
								<div id="option-<?php echo $option['product_option_id'];?>" class="option">
								  <?php if($option['required']) { ?>
								  <span class="required">*</span>
								   <?php } ?>
								  <b><?php echo $option['attribute_group_name'];?>:</b>
								  <input type="text" name="option[<?php echo $option['product_option_id'];?>]" value="<?php echo $option['option_value'];?>" class="datetime" />
								</div>
								<?php } ?>
								<?php if($option['type'] == 'time') { ?>
								<div id="option-<?php echo $option['product_option_id'];?>" class="option">
								  <?php if($option['required']) { ?>
								  <span class="required">*</span>
								   <?php } ?>
								  <b><?php echo $option['attribute_group_name'];?>:</b>
								  <input type="text" name="option[<?php echo $option['product_option_id'];?>]" value="<?php echo $option['option_value'];?>" class="time" />
								</div>
								<?php } ?>
							<?php } ?>
						  </div>
						   <?php } ?>
					
					
					
					<li class="product_info_buy y">
                        <a class="goodsbuy" ></a>
                        <a class="goodscar" ></a>	
                    </li>
				</ul>
				
			</dd>
   
		</dl>
		
		</div>
	</div>
	
	<div class="clothes_recommend cl h">
	<dl>
		<!-- <dt class="f2 f_q z">推荐给朋友：<a class="f3n" href="#">我要推荐</a></dt> -->
		<!-- JiaThis Button BEGIN -->
		
		<!-- JiaThis Button END -->
		<dd>
		    <!-- JiaThis Button BEGIN -->
			<div class="jiathis_style_24x24">
			    <span class="z">分享到：</span>
				<a class="jiathis_button_qzone"></a>
				<a class="jiathis_button_tsina"></a>
				<a class="jiathis_button_tqq"></a>
				<a class="jiathis_button_renren"></a>
				<a class="jiathis_button_kaixin001"></a>
				<a href="http://www.jiathis.com/share" class="jiathis jiathis_txt jtico jtico_jiathis" target="_blank"></a>
			</div>
        <!-- JiaThis Button END -->
		</dd>
		<!--
        <dd><font class="discuss z"></font><a class="z" href="#">查看评论</a></dd>
        -->
		<dd><font class="favrate z"></font><a class="favoriate">收藏此产品</a></dd>
		<dd><a class="seller_gotoshop" href="index.php?route=store/store&store_id=<?php echo $store['store_id'];?>"></a></dd>
	</dl>
	</div>
	
	
	<!--产品信息begin-->
	<div class="pro_info cl">
		<dl class="pro_info_tab">
			<dt class="dt5"><ul>
				<li class="fist_tab">产品详情</li>
				<li>商品评价</li>
				<li>售后服务</li>
			</ul></dt>
			<dd class="">
				{<?php echo $product['description'];?> }
			</dd>
			<dd class="dn">
				<div class="wps cl">
					暂无商品评价！<br/>
					只有购买过该商品的用户才能进行评价。				
					<div class="cl_div"></div>
				</div>			
			</dd>
			<dd class="dn">
				<div class="wps cl">
					<ul class="pro_info_con">
						<li>售后服务：</li>
						<li>配送时限：</li>
						<li>配送费用：</li>
						<li>支付方式：</li>
					</ul>				
					<div class="cl_div"></div>
				</div>			
			</dd>
			
		</dl>
		
		<div class="cl_div"></div>
	</div>
	<!--产品信息end-->
	
	<!--商家信息begin-->
	<!--
	<div class="seller_info cl">
		<dl>
			<dt class="clothes_show_dt ti2 f2 f_q">商家信息</dt>
			<dd>
				<div class="seller_info_z z" id="container"  ></div>
				<div class="seller_info_y z">
					<dl>
						<dt class="f1 f_q"><?php echo $store['name'];?></dt>
						<dd class="cl">
							<div class="seller_z_ser z"><img name="" src="catalog/view/theme/default/image/ico/s1.gif" width="56" height="56" alt="" /></div>
							<div class="seller_z_ser_con z"><p class="f2 f_q">正品承诺</p><p>穿悦网所有商品均通过正餐的渠道采购，并有中华联保保险公司承保。</p></div>
						</dd>
						<dd class="cl">
							<div class="seller_z_ser z"><img name="" src="catalog/view/theme/default/image/ico/s2.gif" width="56" height="56" alt="" /></div>
							<div class="seller_z_ser_con z"><p class="f2 f_q">服务质量保证</p><p>穿悦网售后服务保障您的权益，请拨打售后保障服务电话： 4008-800-1999</p></div>
						</dd>
						<dd class="cl">
							<div class="seller_z_ser z"><img name="" src="catalog/view/theme/default/image/ico/s3.gif" width="56" height="56" alt="" /></div>
							<div class="seller_z_ser_con z"><p class="f2 f_q">七天无条件退货</p><p>穿悦网承诺1000元以下产品，7天内无条件退货。</p></div>
						</dd>
						<dd class="cl"><p>店铺地址：<?php echo $store['address'];?></p><p>联系电话：<?php echo $store['tel'];?></p></dd>
					</dl>
					<dl ><a class="seller_gotoshop" href="index.php?route=store/store&store_id=<?php echo $store['store_id'];?>"></a></dl>
				</div>
			</dd>
			<dd class="cl_div"></dd>
		</dl>

	</div>
	-->
	<!--商家信息end-->
	
	<div class="state">
		<dl class="state_con">
			<dt class="f_q f2"><font class="state_con_title z"></font>免责声明</dt>
			<dd>
			    <p>穿悦商城所展示的宝贝供求信息由买卖双方自行提供，其真实性、准确性和合法性由信息发布人负责。我们的工作人员会对不符合的信息给予删除！</p>
				<p>穿悦网友情提醒：为保障您的利益，请网上成交，贵重宝贝，请使用安全账号交易。</p>
				<p>交易过程中请勿随意接收卖家发送的可疑文件，请勿点击不明来源的链接，付款前请务必详细核对支付信息。</p>
				<p>推荐安全软件：搜狗浏览器 手机密令 360网盾 QQ电脑管家 安全软件中心</p>
				<p>解释权归穿悦商城所有</p>
			</dd>
		</dl>
	</div>
</div>
<!-- <script type="text/javascript" src="http://api.map.baidu.com/api?v=1.4" charset="utf-8"></script> -->

<script type="text/javascript"><!--

$(document).ready(function() {
	$('.jqzoom').jqzoom({
            zoomType: 'standard',
            lens:true,
            preloadImages: false,
            alwaysOn:false,
			zoomWidth: 440,  
            zoomHeight: 420
			//xOffset:360
        });
	
});

//-->
</script>

<script type="text/javascript"><!--
/*
$(document).ready(function(){
    var map = new BMap.Map("container");//在百度地图容器中创建一个地图
	var point = new BMap.Point(<?php echo $map_x;?>,<?php echo $map_y;?>);//定义一个中心点坐标
	map.centerAndZoom(point,13);//设定地图的中心点和坐标并将地图显示在地图容器中
	marker = new BMap.Marker(point);  // 创建标注
	map.addOverlay(marker);              // 将标注添加到地图中
	map.enableScrollWheelZoom();     //启用滚轮放大缩小，默认禁用。
});
*/

//加载图片弹出框
$(".product_focus_img ul li ").colorbox({
	    href:function(){
	         var href=$(this).attr('data-image');
			 return href;
		},
		overlayClose: true,
		opacity: 0.5,
		rel: 'group1',
		transition: "none"
		
});

//增加减少购买数量
$(".jia").click(function(){
    var num=parseInt($("#goodsnum").attr("value"));
	if(num<10000) $("#goodsnum").val(num+1);	
});
$(".jian").click(function(){
	$("#goodsnum").val((parseInt($("#goodsnum").attr("value"))-1)<1?1:(parseInt($("#goodsnum").attr("value"))-1));	
});

		
//添加到收藏夹
$(".favoriate").click(function(){
    <?php if(empty($customer_id)) { ?>
	    var referer='<?php echo $referer;?>';
	    location.href="index.php?route=account/login&referer="+encodeURIComponent(referer);
	<?php } else { ?>
	    addToWishList('<?php echo $product['product_id'];?>');
    <?php } ?>
});

//直接购买
$(".goodsbuy").click(function(){
    <?php if(empty($customer_id)) { ?>
	    var referer='<?php echo $referer;?>';
	    location.href="index.php?route=account/login&referer="+encodeURIComponent(referer);
	<?php } else { ?>
	    
        dBuy('<?php echo $product['product_id'];?>');
	<?php } ?>
});

//添加到购物车
$(".goodscar").click(function(){
    <?php if(empty($customer_id)) { ?>
	    var referer='<?php echo $referer;?>';
	    location.href="index.php?route=account/login&referer="+encodeURIComponent(referer);
	<?php } else { ?>
	
        addToCart('<?php echo $product['product_id'];?>'); 
		
	<?php } ?>
});

$(document).ready(function() {
	$(".goodscar").click(function () {  
		$("#formCartAdd").submit();
	});
});


$("ul#thumblist li:eq(0) a").addClass('zoomThumbActive');
/*
$(".product_focus_img ul li").mouseenter(function(){
	cshta=$(this).parent().children("li");
	var cshco=$(".product_show").children("a").children(".zoomPad").children("img");//zoomPad是加载jqzoom后产生的div的类名
	var index=$.inArray(this,cshta);
	cshco.addClass("dn").eq(index).removeClass("dn");
	$(this).css({'border':'1px solid #000000'});
}).mouseleave(function(){
	$(this).css({'border':'1px solid #CDCDCD'});
});
*/

var imgUD={
		i:0,
		j:0,
		imgDown:function(){
			
			var cn_li=0;
			$(".product_focus_img ul li").each(function(index){
				cn_li ++;
			});
			
			if(cn_li>4 && cn_li>imgUD.i+4){  
                for(var k=0;k<cn_li-4;k++){			
					$(".product_focus_img ul li").eq(imgUD.i).slideUp('slow');
					imgUD.i++;
				}
			}
			
			
		},

		imgUp:function(){
			var cn_li=0;
			$(".product_focus_img ul li").each(function(index){
				cn_li ++;
			});
			
			if(cn_li>4 && imgUD.i>0){    
			    for(var k=0;k<cn_li - 4;k++){
					imgUD.i--;
					$(".product_focus_img ul li").eq(imgUD.i).slideDown('slow');
				}
				
			}
			
			
		}
}

$('.product_focus_down').bind('mouseenter',imgUD.imgDown);
$('.product_focus_up').bind('mouseenter',imgUD.imgUp);
//-->
</script>

<script type="text/javascript" src="http://v3.jiathis.com/code/jia.js?uid=1354786494444563" charset="utf-8"></script>

<script src="catalog/view/javascript/jquery/jquery.jqzoom-core.js" type="text/javascript"></script>


<?php echo $footer;?>