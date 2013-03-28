<?php echo $header;?>

<link href="catalog/view/theme/default/stylesheet/store.css" type="text/css" rel="stylesheet" />
<!--内容-->

<div class="mainSearch">
<!-- <div class="ad"><a href=""><img width="980" height="100" alt="" src="images/ad/banner.jpg" /></a></div> -->
<div class="search_list">
    
    <input type="text" name="searchStore"  class="text" maxlength="100" value="<?php if(isset($search)) { ?><?php echo $search;?><?php } ?>" /><input type="button" value="搜&nbsp;索" class="button" />
	
	<?php if(!empty($search)) { ?><p>搜索与"<span><?php echo $search;?></span>"相关的店铺数<span><?php echo $total;?></span>个</p><?php } ?>
	
</div>

<div class="condition">
	<div class="you_search">
		<dl class="subhide fore"><dt>品牌：</dt>
		<dd>
			<div class="brand"><a href="">梦芭莎-女装(381)</a></div>
			<div class="brand"><a href="">蒙蒂埃莫-高端商务男装(132)</a></div>
			<div class="brand"><a href="">若缇诗-欧式女装(99)</a></div>
			<div class="brand"><a href="">宝耶-童装(85)</a></div>
			<div class="brand"><a href="">Ing2Ing-时尚潮牌(73)</a></div>
			<div class="brand"><a href="">樱桃派-少女文胸(58)</a></div>
			<div class="brand"><a href="">零一佰-时尚运动(51)</a></div>
			<div class="brand"><a href="">梦芭莎·维多利亚-高端内衣(49)</a></div>
		</dd></dl>
		<dl class="subhide"><dt><a href="">风格</a>：</dt>
		<dd>
			<div><a href="">淑女风(135)</a></div>
			<div><a href="">学院风(56)</a></div>
			<div><a href="">欧美(30)</a></div>
			<div><a href="">复古(15)</a></div>
			<div><a href="">英伦(8)</a></div>
			<div><a href="">甜美(1)</a></div>
			<div><a href="">性感(1)</a></div>
		</dd></dl>
		<dl class="subhide"><dt><a href="">好店推荐</a>：</dt>
		<dd>
			<div><a href="">服务态度好(56)</a></div>
			<div><a href="">发货速度快(54)</a></div>
			<div><a href="">回头客多(30)</a></div>
			<div><a href="">黄钻买家爱买(11)</a></div>
		</dd></dl>
	</div>
</div>

<div class="separtor">

    <div class="c_topdiv">
		<div data-id="name"><a <?php if($sort=='name') { ?>class="link_on"<?php } ?> href="javascript:void(0);"><span>默认</span><?php if($order=='desc' && $sort=='name') { ?><img src='catalog/view/theme/default/image/down.png' /><?php } elseif ($order=='asc' && $sort=='name') { ?><img src='catalog/view/theme/default/image/up.png' /><?php } ?></a></div>
		<div data-id="quantity"><a <?php if($sort=='quantity') { ?>class="link_on"<?php } ?> href="javascript:void(0);"><span>宝贝数</span><?php if($order=='desc' && $sort=='quantity') { ?><img src='catalog/view/theme/default/image/down.png' /><?php } elseif ($order=='asc' && $sort=='quantity') { ?><img src='catalog/view/theme/default/image/up.png' /><?php } ?></a></div>
		<div data-id='soldnum'><a <?php if($sort=='soldnum') { ?>class="link_on"<?php } ?> href="javascript:void(0);"><span>成交数</span><?php if($order=='desc' && $sort=='soldnum') { ?><img src='catalog/view/theme/default/image/down.png' /><?php } elseif ($order=='asc' && $sort=='soldnum') { ?><img src='catalog/view/theme/default/image/up.png' /><?php } ?></a></div>
		<div data-id='createTime'><a <?php if($sort=='createTime') { ?>class="link_on"<?php } ?> href="javascript:void(0);"><span>开店时间</span><?php if($order=='desc' && $sort=='createTime') { ?><img src='catalog/view/theme/default/image/down.png' /><?php } elseif ($order=='asc' && $sort=='createTime') { ?><img src='catalog/view/theme/default/image/up.png' /><?php } ?></a></div>
    </div>

<!-- <div class="page_list"><span class='paginationSimplifyInfo'>1/25</span><a class='paginationNext' href=''>下一页</a></div> -->
</div>


<div class="plist_group">
    <?php if(!empty($list)) { ?>
		<?php foreach((array)$list as $l) {?>
			<dl>
				<dt><img src="<?php echo $l['logo'];?>" /></dt>
				<dd>
					<ul>
						<li><a href="<?php echo $l['href'];?>" class="title"><?php echo $l['name'];?></a></li>
						<li>店铺介绍：<a href="<?php echo $l['href'];?>"><?php echo $l['introduce'];?></a></li>
						<li>掌柜：<a href="<?php echo $l['href'];?>"><?php echo $l['owner'];?></a></li>
					</ul>
				</dd>
				<dd class="deal">
					<ul>
						<li>共<?php echo $l['productsTotal'];?>件宝贝</li>
						<li>成交<span class="digital"><?php echo $l['orderPaidTotal'];?></span>笔</li>
					</ul>
				</dd>
				<dd><?php echo $l['address'];?></dd>
			</dl>
		<?php } ?>
	<?php } ?>
</div>

<!-- <div class="page"> -->
	<div class="pagination">
				<?php echo $pagination;?>
				<!-- <select id='pageIndex' onchange='pageJump()'>
				<option selected value=''>第1页</option>
				<option value=''>第2页</option>
				<option value=''>第3页</option>
				<option value=''>第4页</option>
				<option value=''>第5页</option>
				<option value=''>第6页</option>
				<option value=''>第7页</option>
				<option value=''>第8页</option>
				<option value=''>第9页</option>
				<option value=''>第10页</option>
				</select>
			<script language='javascript' type='text/javascript'> function pageJump() { location.href = document.getElementById('pageIndex').value; } </script> -->
	</div>
</div>
<script type="text/javascript">
    $(".button").click(function(){
	    var url=location.href;
		var v;
		v=$.trim($('input[name=searchStore]').val());

		if(url.search(/search=[\w%]*/i)>=0){
		    url=url.replace(/search=[\w%]*/i,'search='+encodeURIComponent(v));
		}else{
		    url=url+'&search='+encodeURIComponent(v);
		}

		location.href=encodeURI(url);
	});
	
	//排序
	var orderClass={
	        init:function(){
			    var query=location.search;
				if(query.search(/sort=\w*/i)==-1 && query.search(/order=\w*/i)==-1){
					$(".c_topdiv div:eq(0) ").children('a').addClass('link_on');
					$(".c_topdiv div:eq(0) ").children('a').append("<img src='catalog/view/theme/default/image/down.png' />");
				}
			}
    };
	
	$(document).ready(function(){
	    orderClass.init();
	});
	
	$(".c_topdiv div ").click(function(){
		var url;
		var query=location.search;
		//query=query.substr(1);url重写后需要的
		query="index.php"+query;
	    if($(this).children('a').prop('class')=='link_on'){
			
		    var sort=$(this).attr('data-id');
			if(query.search(/sort=\w*/i)!=-1){
		        query=query.replace(/sort=\w*/i,'sort='+sort);
			}else{
			    query=query+'&sort='+sort;
			}
			
			if($(this).children('a').has('img').length>0 && $(this).children('a').children('img').attr('src').search(/down/i)!=-1){//降序点击
			    if(query.search(/order=\w*/i)!=-1){
					url=query.replace(/order=\w*/i,'order=asc');
				}else{
					url=query+'&order=asc';
				}
				
				$(this).children('a').children('img').remove();
		    	$(this).children('a').append("<img src='catalog/view/theme/default/image/up.png' />");
			}else {  //($(this).children('a').has('img').length>0 && $(this).children('a').children('img').attr('src').search(/up/i)!=-1)升序点击
			    if(query.search(/order=\w*/i)!=-1){
					url=query.replace(/order=\w*/i,'order=desc');
				}else{
					url=query+'&order=desc';
				}
				
		
				$(".c_topdiv div ").children('a').children('img').remove();
			    $(this).children('a').append("<img src='catalog/view/theme/default/image/down.png' />");
			}
			
			
	    }else{
		    $(".c_topdiv div ").children('a').removeClass('link_on');
			$(this).children('a').addClass('link_on');
			
			$(".c_topdiv div ").children('a').children('img').remove();
			
			
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
			$(this).children('a').append("<img src='catalog/view/theme/default/image/down.png' />");
		}
		location.href=url;
	});
</script>
<?php echo $footer;?>