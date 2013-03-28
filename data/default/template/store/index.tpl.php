<?php echo $header;?>
<link href="catalog/view/theme/default/stylesheet/jquery.treeview.css" rel="stylesheet" />
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery.treeview.js"></script>

<script type="text/javascript">
		$(function() {
			$("#tree").treeview({
				collapsed: true,
				animated: "medium",
				control:".sidetreecontrol",
				persist: "location"
			});
		})
		
	</script>
	
<!--店铺开始 -->
<div class="store">
<!--穿悦LOGO和搜索 -->
<div class="store_top90">
	<div class="topl"><a href="index.php?route=common/home" ><img src="catalog/view/theme/default/image/store/store_logo.jpg"/></a></div>
	<div class="topr">
	<form id="form___&&*as203" name="frmStore" method="post" action="index.php?route=store/store&store_id=<?php echo $store_id;?>">
	<ul>
		<li class="searcht">宝贝</li>
		<li class="searchb"><input name="keyword1" type="text" <?php if(!empty($keyword1)) { ?>value="<?php echo $keyword1;?>"<?php } else { ?>value="搜索关键词"<?php } ?> size="50" class="formbor" onFocus="this.value=''"/></li>
		<li class="searchr"><input type="submit" name="Submit" value="搜 索" class="formbtn"/></li>
		
		<!-- <li class="searchr2"><a href="#">高级搜索</a><br><a href="#">使用帮助</a></li> -->
	</ul></form>
	</div>
</div>
<!--穿悦LOGO和搜索end -->
<div class="store_baaner">
</div>
<!--菜单menu begin -->
<div class="store_menured">
	<ul>
		<li class="menuon"><a href="<?php echo $action;?>"  hidefocus="true">店铺首页</a></li>
		<li><a href="#" onclick=""  hidefocus="true">店铺介绍</a></li>
	</ul>
</div>
<!--菜单menu end -->
<!--主体body begin --><div class="store_body">
<!--左边 begin -->
<div class="redleft">
	<div class="rednavbg">搜索店内的宝贝</div>
	<div class="lsearch">
	    <form id="formStore"   action="<?php echo $action;?>" method="post" >
		<ul>
			<li>关键字：<input name="keyword2" type="text" <?php if(!empty($keyword2)) { ?>value="<?php echo $keyword2;?>"<?php } ?> size="20" maxLength="20" class="searchbor"/></li>
			<li>价&nbsp;&nbsp;格：<input name="priceLower" type="text" <?php if(!empty($priceLower)) { ?>value="<?php echo $priceLower;?>"<?php } ?> size="7" maxLength="7" class="searchbor"/> 到 <input name="priceUp" type="text" <?php if(!empty($priceUp)) { ?>value="<?php echo $priceUp;?>"<?php } ?> size="8" maxLength="8" class="searchbor"/></li>
			<li><input type="button" name="clear" value="清 空" class="searchbtn" /><input type="submit" name="submit" value="搜 索" class="searchbtn"/></li>
		</ul>
		</form>
	</div>
	<div class="rednavbg1">产品分类</div>
	<?php if(!empty($storeCategories)) { ?><div class="sidetreecontrol"><a href="?#">收缩</a> | <a href="?#">展开</a></div><?php } ?>
	<div class="lclass">
		<ul class="treeview" id="tree">
		    
				<?php foreach((array)$storeCategories as $a) {?>
				    <li><a href="index.php?route=store/store&store_id=<?php echo $store_id;?>&category_id=<?php echo $a['cid'];?>" class="cid" data-value="<?php echo $a['cid'];?>"><?php echo $a['cname'];?></a>
						<ul>
						<?php if(isset($a['sub'])) { ?>
						<?php foreach((array)$a['sub'] as $b) {?>
							<li><a href="index.php?route=store/store&store_id=<?php echo $store_id;?>&category_id=<?php echo $b['cid'];?>" class="cid" data-value="<?php echo $b['cid'];?>"><?php echo $b['cname'];?></a>
							    <?php if(isset($b['sub'])) { ?>
							    <ul>
							    <?php foreach((array)$b['sub'] as $c) {?>
								    <li><a href="index.php?route=store/store&store_id=<?php echo $store_id;?>&category_id=<?php echo $c['cid'];?>" class="cid" data-value="<?php echo $c['cid'];?>"><?php echo $c['cname'];?></a>
									    <?php if(isset($c['sub'])) { ?>
 									    <ul> 
										     
										     <?php foreach((array)$c['sub'] as $k=>$d) {?>
											    <li><a href="index.php?route=store/store&store_id=<?php echo $store_id;?>&category_id=<?php echo $d['cid'];?>" class="cid" data-value="<?php echo $d['cid'];?>"><?php echo $d['cname'];?></a></li>	
											 <?php }?>
											 
										</ul>
										<?php } ?>
									
									</li>
								
								<?php } ?>
								</ul>
								<?php } ?>
							</li>
						<?php } ?>
						<?php } ?>
						</ul>
					</li>
				<?php } ?>
			
		</ul>
	</div>
	<div class="rednavbg1">销量排行榜</div>
	<div class="lranking">
		<ul>
		    <?php if(!empty($productSaleTop)) { ?>
				<?php foreach((array)$productSaleTop as $v) {?>
					<li><span class="picbor"><a href="<?php echo $v['href'];?>"><img src="<?php echo $v['image'];?>" title="<?php echo $v['name'];?>"/></a></span>
						<span class="title"><a href="<?php echo $v['href'];?>"><?php echo $v['shortname'];?></a><br><b class="price">¥<?php echo $v['price'];?></b></span>
					</li>
				<?php } ?>
			<?php } ?>
		</ul>
	</div>
</div>
<!--左边 end -->

<!--右边 begin -->
<div class="redright">
	<div class="rednavbg">店铺所有新品</div>
	<div class="rproducts">
		<ul>
		    <?php if(!empty($store_products)) { ?>
				<?php foreach((array)$store_products as $product) {?>
					<li>
						<div class="display">
							<ul>
							<li class="bor236"><a href="<?php echo $product['href'];?>"><img src="<?php echo $product['image'];?>" title="<?php echo $product['name'];?>" /></a></li>
							<li ><a href="<?php echo $product['href'];?>"><?php echo $product['shortname'];?></a></li>
							<li class="price">¥<?php echo $product['price'];?></li>
							<li >已销售：<span class="sales"><?php echo $product['hots'];?></span>件</li>
							</ul>
						</div>
					</li>
				<?php } ?>
			<?php } else { ?>
			    <p style="text-align:center">没有数据</p>
			<?php } ?>
		</ul>
	</div>
	
	<div class="store_introduce" style="display:none">
	    <p><span>店铺名称：</span><?php echo $store_info['name'];?></p>
		<!-- <p>店主    ：<?php echo $store_info['owner'];?></p> -->
		<p><span>电 话：</span><?php echo $store_info['tel'];?></p>
		<!-- <p>手机    ：<?php echo $store_info['mobile'];?></p> -->
		<p><span>地 址：</span><?php echo $store_info['address'];?></p>
		<p><span>简 介：</span><?php echo $store_info['introduce'];?></p>
	</div>
</div>
<!--右边 end -->

<div class="pagination"><?php echo $pagination;?></div>
<!--主体body end -->
</div>
<!--店铺end -->
</div>
<script type="text/javascript">
    $(".store_menured ul li").mouseenter(function(){
	    $(this).parent().children('li').removeClass('menuon');
        $(this).addClass('menuon');
    });
	
	//店铺首页
	$(".store_menured ul li:eq(0)").click(function(){
	    $(".redright .rednavbg").html('店铺所有产品');
		$(".store_introduce").css({'display':'none'});
		$(".rproducts").css({'display':'block'});
		$(".pagination").css({'display':'block'});
	});
	
	//店铺介绍
	$(".store_menured ul li:eq(1)").click(function(){
	    $(".redright .rednavbg").html('店铺介绍');
		$(".store_introduce").css({'display':'block'});
		$(".rproducts").css({'display':'none'});
		$(".pagination").css({'display':'none'});
	});
	
	//$("input[name^=price]").keyup(function(){
	//    $(this).val($(this).val().replace(/\D/gi,""));
	//});
	
	$("input[name^=price]").keydown(function(e){
	    var s="48,49,50,51,52,53,54,55,56,57,96,97,98,99,100,101,102,103,104,105,110,190";
		var k=e.keyCode;
		if(s.indexOf(k)==-1){
		    return false;
		}
	});
	
	$("input[name=clear]").click(function(){
	    $('#formStore input[type=text]').val('');
	});
    
	
	//$(".cid").click(function(){
	//    var cid=$(this).attr('data-value');
	//	var query='index.php'+location.search;
	//	query=query.replace(/page=\d*/g,'');
	//	if(query.search(/category_id=\d*/g)==-1){
	//	    window.location.href=query+"&category_id="+cid;
	//	}else{
	//	    query=query.replace(/(category_id=)\d*/g,'$1'+cid);
	//		window.location.href=query;
	//	}
	//});
	
	$('.bor236').hover(function(){
	    $(this).css({'border':'1px solid #000'});
	},function(){
	    $(this).css({'border':'1px solid #CCC'});
	});
</script>
<?php echo $footer;?>