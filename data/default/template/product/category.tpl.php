<?php echo $header;?>
<!--衣食住行列表页面-->
<div id="list_box" class="wp cl">
	<div class="z h">		         
		<dl>    
  		    <?php if(isset($list_channel_title)) { ?>
			  <dt class="<?php echo $list_channel_title;?>_list_channel_title"></dt>
			<?php } ?>
			
			<dd class="clist_channel_content">
				<ul>
				<li>
                    <?php foreach((array)$categoryList as $category) {?>
					    <p class="f2"><a <?php if($category['category_id']==$category_id) { ?>class="selected"<?php } ?> href="index.php?route=product/category&category_id=<?php echo $category['category_id'];?>"><?php echo $category['name'];?></a></p>
						<?php foreach((array)$category['third_category_list'] as $v) {?>
                             <span class="list_pro"><a   <?php if($v['category_id']==$category_id) { ?>class="selected"<?php } ?> href="index.php?route=product/category&category_id=<?php echo $v['category_id'];?>"><?php echo $v['name'];?></a></span>
						<?php } ?>
                    <?php } ?>					
				</li>
				</ul>
			</dd>
		</dl>
		
		<dl>
			<dt class="clist_week_ranking f2 f_b tc">一周销售排行</dt>
			<dd class="clist_week_ranking_con h">
			    <?php foreach((array)$hot_products as $k=>$hot) {?>
				<dl>
					<dd class="cl h">
						<div class="clist_week_ranking_con_z z h"><span class="clist_week_imgs h"><a href="index.php?route=product/product&product_id=<?php echo $hot['product_id'];?>"><img src="<?php echo $hot['image'];?>"  title="<?php echo $hot['name'];?>"/></a></span><span class="clist_week_ranking_con_ts f_b"><?php echo $k+1;?></span></div>
						<div class="clist_week_ranking_con_y z"><span><a href="index.php?route=product/product&product_id=<?php echo $hot['product_id'];?>"><?php echo $hot['shortname'];?></a></span><span class="f3 f_dh">¥<?php echo $hot['price'];?></span></div>
					    <div class="cl_div"></div>
					</dd>
				</dl>
				<?php }?>
			</dd>
		</dl>
		
		<dl>
			<dt class="clist_week_ranking f2 f_b tc">为你挑选</dt>
			<dd class="clist_week_ranking_conf">
				<ul>
				    <?php foreach((array)$foryou_products as $foryou) {?>
					<dd class="cl h">
						<div class="clist_week_ranking_con_zw clist_week_imgs z h"><a href="index.php?route=product/product&product_id=<?php echo $foryou['product_id'];?>"><img src="<?php echo $foryou['image'];?>" title="<?php echo $foryou['name'];?>" /></a></div>
						<div class="clist_week_ranking_con_y z"><span><a href="index.php?route=product/product&product_id=<?php echo $foryou['product_id'];?>"><?php echo $foryou['shortname'];?></a></span><span class="f3 f_dh">¥<?php echo $foryou['price'];?></span></div>
					<div class="cl_div"></div>
					</dd>
					<?php } ?>
				</ul>
			</dd>
		</dl>
      
	</div>
	
    
	<div id="list_y" class="z h">
        <!--属性搜索条件列表begin-->    
		<dl><a ><img name="" src="catalog/view/theme/default/image/clad1.gif" width="1000" height="100" alt="" /></a></dl>
		<dl class="clist_content_classify">
			<?php if(!empty($searchCondition)) { ?>
				<?php foreach((array)$searchCondition as $k=>$s) {?>
					<?php if(count($s)>=1) { ?>
						<dd class="cl">
							<div class="clist_calssify_z z f2"><?php echo $k;?>：</div>
							<div class="clist_calssify_y z h">
								<ul>
								<?php foreach((array)$s as $key=>$v) {?>
								    <?php $aname=explode('|',$v);?>
									<?php if(preg_match('/catalog\/view\/theme\/default\/image\/ico/',$aname[2])) { ?><!--颜色-->
										<li class="<?php if(in_array($key,$attid)) { ?>selected<?php } else { ?>color<?php } ?> h "><a href="javascript:void(0);" data-id="<?php echo $key;?>" data-type="<?php echo $aname[0];?>" title="<?php echo $aname[1];?>"  ><img src="<?php echo $aname[2];?>"  /></a></li>
									<?php } else { ?>
										<li><a <?php if(in_array($key,$attid)) { ?>class="selected"<?php } ?> href="javascript:void(0);" data-id="<?php echo $key;?>" data-type="<?php echo $aname[0];?>"><?php echo $aname[1];?></a></li>
									<?php } ?>
								<?php }?>
								</ul>
							</div>
							<div class="cl_div"></div>
							
						</dd>
					<?php } ?>
				<?php }?>
			<?php } ?>
		</dl>
        <!--属性搜索条件列表end-->   
        
        <div class="clist_calssify_explore"></div>
		
        <!--产品列表开始-->
		<dl class="clist_pro">
			<dt class="dt_<?php if(isset($list_channel_title)) { ?><?php echo $list_channel_title;?><?php } ?>">
				<ul>
				    <li  data-id="default" <?php if($sort=='default') { ?> class="selected"<?php } ?> >默认<?php if($sort=='default' && $order=='desc') { ?><img src="catalog/view/theme/default/image/down.png" /><?php } elseif ($sort=='default' && $order=='asc' ) { ?><img  src="catalog/view/theme/default/image/up.png"><?php } ?></li>
				    <li  data-id="viewed"  <?php if($sort=='viewed') { ?> class="selected"<?php } ?>>人气<?php if($sort=='viewed' && $order=='desc') { ?><img src="catalog/view/theme/default/image/down.png"><?php } elseif ($sort=='viewed' && $order=='asc' ) { ?><img src="catalog/view/theme/default/image/up.png"><?php } ?></li>
					<!-- <li <?php if($sort=='salenum') { ?> class="selected"<?php } ?>>销量 <?php if($order=='asc') { ?>↓<?php } elseif ($order=='desc' ) { ?>↑<?php } ?></li> -->
					<li  data-id="price"   <?php if($sort=='price') { ?> class="selected"<?php } ?>>价格<?php if($sort=='price' && $order=='desc') { ?><img src="catalog/view/theme/default/image/down.png"><?php } elseif ($sort=='price' && $order=='asc' ) { ?><img src="catalog/view/theme/default/image/up.png"><?php } ?></li>
					<!-- <li>价格 ↓ </li> -->
					<!-- <li>好评 ↓ </li> -->
					<li  data-id="latest"  <?php if($sort=='latest') { ?> class="selected"<?php } ?>>最新<?php if($sort=='latest' && $order=='desc') { ?><img src="catalog/view/theme/default/image/down.png"><?php } elseif ($sort=='latest' && $order=='asc' ) { ?><img src="catalog/view/theme/default/image/up.png"><?php } ?></li>
					<!-- <li>促销商品</li>	 -->
					<!-- <a href="index.php?route=product/category&category_id=<?php echo $category_id;?>&sort=sort_order&order=asc" ><li <?php if($sort == 'sort_order') echo 'class="fist_tab"';?> >默认 ↓ </li></a>
					<a href="index.php?route=product/category&category_id=<?php echo $category_id;?>&sort=price&order=asc" ><li <?php if($sort == 'price' && $order == 'asc') echo 'class="fist_tab"';?> >价格 ↑ </li></a>
					<a href="index.php?route=product/category&category_id=<?php echo $category_id;?>&sort=price&order=desc" ><li <?php if($sort == 'price' && $order == 'desc') echo 'class="fist_tab"';?> >价格 ↓ </li></a>
					<a href="index.php?route=product/category&category_id=<?php echo $category_id;?>&sort=points&order=asc" ><li <?php if($sort == 'points') echo 'class="fist_tab"';?> >销量 ↓ </li></a> -->
					<!--
					<li>好评 ↓ </li>
					<li>最新 ↓ </li>
					<li>促销商品</li>
					-->	
				</ul>
			</dt>
			<dd class="clist_pro_box h z" >				
                <ul>
                <?php foreach((array)$products as $product) {?>
                    <li><p><a href="index.php?route=product/product&product_id=<?php echo $product['product_id'];?>" target="_blank" title="<?php echo $product['name'];?>"><img src="<?php echo $product['image'];?>" width="180" height="180" alt="clothes_pro" /></a></p><p><a href="#" class="f3n"><?php echo $product['shortname'];?></a></p><p><a href="index.php?route=product/product&product_id=<?php echo $product['product_id'];?>" target="_blank" class="f2 f_h">¥<?php echo $product['price'];?></a></p></li>
                <?php } ?>
                </ul>
			</dd>
			<div class="pagination"><?php echo $pagination;?></div>
			
		</dl>
		<!--产品列表结束-->
		
	</div>
</div>

<!--一周热销产品begin-->
<div id="list_box_hot" class="wp cl">
	<div class="list_box_hot">
		<dl>
			<dt><img  src="catalog/view/theme/default/image/hot_list.gif" width="104" height="28" /></dt>
			<dd>
				<ul>
				    <?php foreach((array)$recommend_products as $recommend) {?>
				        <li><p><a href="index.php?route=product/product&product_id=<?php echo $recommend['product_id'];?>"><img src="<?php echo $recommend['image'];?>" width="180" height="180" title="<?php echo $recommend['name'];?>" /></a></p><p><a href="index.php?route=product/product&product_id=<?php echo $recommend['product_id'];?>" class="f3n"><?php echo $recommend['shortname'];?></a></p><p><span class="f2 f_h">¥<?php echo $recommend['price'];?></span></p></li>
				    <?php } ?>
				</ul>
			</dd>
		</dl>
	</div>
</div>
<!--一周热销产品end-->

<script type="text/javascript">
    $(".clist_calssify_explore").click(function(){
        
        if($(".clist_content_classify").css('display')=='none'){//收缩
	        $(".clist_content_classify").slideDown('slow');
			$(this).css({'background':'url(catalog/view/theme/default/image/toggle_bg.gif) no-repeat 0 -80px'});
        }else{ //展开
		    $(".clist_content_classify").slideUp('slow');
			//$(".clist_content_classify").before('<div id="splitline" style="width:998px;border:1px solid #DBDBDB;"></div>');
			//$(this).css({'border-top':'1px solid #DBDBDB'});
			$(this).css({'background':'url(catalog/view/theme/default/image/toggle_bg.gif) no-repeat 0 0'});
		}
    });
   
    $(".clist_pro dt ul li").hover(function(){
        //$(this).css({'border-left':'1px solid #DA2061','border-top':'1px solid #DA2061','border-right':'1px solid #DA2061'});
		
    },function(){
        //$(this).css({'border-left':'1px solid #CFCFCF','border-top':'1px solid #CFCFCF','border-right':'1px solid #CFCFCF'});

    });
	
	$(".clist_pro dd.clist_pro_box ul li").hover(function(){
        $(this).css({'border':'1px solid #DA2061'});
    },function(){
        $(this).css({'border':'1px solid #dbdbdb'});
    });
	
	
	//排序
	var orderClass={
	        init:function(){
			    var query=location.search;
				if(query.search(/sort=\w*/i)==-1 && query.search(/order=\w*/i)==-1){
					$(".clist_pro dt ul li:eq(0) ").addClass('selected');
					$(".clist_pro dt ul li:eq(0)  ").append("<img src='catalog/view/theme/default/image/down.png' />");
				}
			}
    };
	
	$(document).ready(function(){
	    orderClass.init();
	});
	
   
    $(".clist_content_classify ul li a").click(function(){
        var attribute_id=$(this).attr('data-id');
		var attribute_type=$(this).attr('data-type');
		//var attribute_type=attribute_type%10;
		var url='';
	   
		var query=location.search;
        var pairs=query.split('&');
		var pattern=new RegExp('(a_id'+attribute_type+'=)','gi');
		if(query.search(pattern)==-1){
            var url='index.php'+query+'&a_id'+attribute_type+'='+attribute_id;
		}else{
		    for(var i=0;i<pairs.length;i++){
			    var pos=pairs[i].indexOf('=');
			    if(pos==-1) continue;
				var name=pairs[i].substring(0,pos);
				var value=pairs[i].substring(pos+1);
				if(name=='a_id'+attribute_type){
		            if(value==attribute_id){ //点击重复的条件，取消条件 
					    var pn=new RegExp('&'+name+'='+value,'i');
						var q=query.replace(pn,'');
						var url='index.php'+q;
					}else{   //点击同组其他条件选项
						var pn=new RegExp(name+'='+value,'i');
						var q=query.replace(pn,name+'='+attribute_id);
						var url='index.php'+q;
					}
					break;
				}
			}
		}
		
		url=url.replace(/page=\d*/gi,'page=1'); //指向第一页
		window.location.href=url;
    });
    
	
	
			
	//点击标签排序
	$(".clist_pro dt ul li").click(function(){
		var url;
		/* dt1ta=$(this).parent().children("li");
		var index=$.inArray(this,dt1ta);	
		dt1ta.removeClass("fist_tab").eq(index).addClass("fist_tab"); */

		var query=location.search;
		//query=query.substr(1);url重写后需要的
		query="index.php"+query;
		if($(this).prop('class')=='selected'){
			
			var sort=$(this).attr('data-id');
			if(query.search(/sort=\w*/i)!=-1){
				query=query.replace(/sort=\w*/i,'sort='+sort);
			}else{
				query=query+'&sort='+sort;
			}
			
			if($(this).has('img').length>0 && $(this).children('img').attr('src').search(/down/i)!=-1){//降序点击
				if(query.search(/order=\w*/i)!=-1){
					url=query.replace(/order=\w*/i,'order=asc');
				}else{
					url=query+'&order=asc';
				}
				
				$(this).children('img').remove();
				$(this).append("<img src='catalog/view/theme/default/image/up.png' />");
			}else {  //($(this).children('a').has('img').length>0 && $(this).children('a').children('img').attr('src').search(/up/i)!=-1)升序点击
				if(query.search(/order=\w*/i)!=-1){
					url=query.replace(/order=\w*/i,'order=desc');
				}else{
					url=query+'&order=desc';
				}
				
		
				$(".clist_pro dt ul li").children('img').remove();
				$(this).append("<img src='catalog/view/theme/default/image/down.png' />");
			}
			
			
		}else{
			$(".clist_pro dt ul li").removeClass('selected');
			$(this).addClass('selected');
			
			$(".clist_pro dt ul li").children('img').remove();
			
			
			var sort=$(this).attr('data-id');
			
			if(query.search(/sort=\w*/i)!=-1){
				query=query.replace(/sort=\w*/i,'sort='+sort);
			}else{
				query=query+'&sort='+sort;
			}
			if(query.search(/order=\w*/i)!=-1){
				url=query.replace(/order=\w*/i,'order=desc');
			}else{
				url=query+'&order=desc';
			}
			//url='index.php?route=store/list'+'&sort='+sort+'&order=desc';
			$(this).append("<img src='catalog/view/theme/default/image/down.png' />");
		}
		location.href=url;
		
		
	});	
	
	
	$(".clist_calssify_more_btn1").live("click",function(){
		$(".clist_calssify_more_btn1").html("收起");
		$(this).removeClass("clist_calssify_more_btn1").addClass("clist_calssify_more_btn2");		
		$(".other_classify").show(100);
	});
	$(".clist_calssify_more_btn2").live("click",function(){
		$(".clist_calssify_more_btn2").html("展开");
		$(this).removeClass("clist_calssify_more_btn2").addClass("clist_calssify_more_btn1");		
		$(".other_classify").hide(100);
	});
</script>
<?php echo $footer;?>