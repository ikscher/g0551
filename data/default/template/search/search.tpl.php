<?php echo $header;?>
<link rel="stylesheet" href='catalog/view/theme/default/stylesheet/search.css' type="text/css" />

<!-- <div class="search_ad"><img src="images/search_ad.jpg" /></div> -->
<div class="search_menu">
  <table width="100%" height="35">
    <tr>
      <!-- <td width="2" valign="top"><img src="images/searchTitleLeft.jpg" width="2" height="35" /></td> -->
      <td align="left" valign="top">
	  <!-- <ul class="clearfix">
		  <li class="current"><a href="#">所有商品</a></li>
		  <li><a href="#">服装专区</a></li>
		  <li><a href="#">食品专区</a></li>
		  <li><a href="#">家居专区</a></li>
	  </ul> -->
	  </td>
      <td align="right" valign="top">搜索结果约为<?php echo $total;?>条，用时<?php echo $spend;?>秒</td>
      <!-- <td width="20" align="right"><img src="images/searchTitleRight.jpg" width="2" height="35" /></td> -->
    </tr>
  </table>
</div>

<div class="searchContent">
	<!-- <div class="keyleft">关键字：<span class="fd71257">礼物</span> 搜索</div> -->
	<div class="keyright">
		<ul>
		    <li class="bor"><input type="text" class="s_input" name="filter_name" placeholder="搜索关键词"  <?php if(!empty($filter_name)) { ?> value="<?php echo $filter_name;?>" <?php } else { ?>  onclick="this.value='';" <?php } ?> size="50"  /><input type="button"value="搜 索" class="s_but"/>
			</li>
		</ul>
	</div> 
	<div class="searchSort clear">
	    <span class="display"><b><?php echo $text_display;?></b> <?php echo $text_list;?> <b>|</b> <a onclick="display('grid');"><?php echo $text_grid;?></a></span>
		<span class="limit">显示：
			  <select name="limit">
				<?php foreach((array)$limits as $limits) {?>
					<?php if($limits['value'] == $limit) { ?>
					    <option value="<?php echo $limits['href'];?>" selected="selected"><?php echo $limits['text'];?></option>
					<?php } else { ?>
					<option value="<?php echo $limits['href'];?>"><?php echo $limits['text'];?></option>
					<?php } ?>
				<?php } ?>
			  </select>
		</span>	
		<span class="sort">排序方式：
		  <select onchange="location = this.value;">
			<?php foreach((array)$sorts as $sorts) {?>
				<?php if($sorts['value'] == $sort . '-' . $order) { ?>
				   <option value="{<?php echo $sorts['href'];?>;}" selected="selected"><?php echo $sorts['text'];?></option>
				<?php } else { ?>
				   <option value="<?php echo $sorts['href'];?>"><?php echo $sorts['text'];?></option>
				<?php } ?>
			<?php } ?>
		  </select>
		</span>
	</div>
	
	<div class="product-grid">
	    <?php if(!empty($products)) { ?>
		    <?php foreach((array)$products as $p) {?>
			<div>
				<dl>
					<dt class="image"><a href="<?php echo $p['href'];?>"><img src="<?php echo $p['thumb'];?>" width="182" height="182" title="<?php echo $p['name'];?>" /></a></dt>
					<dd class="name"><a href="<?php echo $p['href'];?>"><?php echo $p['shortname'];?></a></dd>
					<dd class="salenum">销售数量：<?php echo $p['hots'];?></dd>
					<dd class="price"><?php echo $p['price'];?>元</dd>
					<!-- <dd class="cart"><a data-id="<?php echo $p['product_id'];?>"><?php echo $button_cart;?></a></dd> -->
			        <dd class="wishlist"><a  data-id="<?php echo $p['product_id'];?>"><?php echo $button_wishlist;?></a></dd>
					<!-- <dd class="compare"><a data-id="<?php echo $p['product_id'];?>"><?php echo $button_compare;?></a></dd> -->
				</dl>
			</div>
			<?php } ?>
	    <?php } else { ?>
		    <p class="noresult">没有数据</p>
		<?php } ?>
	</div>
	<?php if(!empty($pagination)) { ?><div class="pagination"><?php echo $pagination;?></div><?php } ?>
	
	<div class="likeProduct clearfix">
		<h2>店铺热卖产品</h2>
		<?php foreach((array)$hotProduct as $h) {?>
			<dl>
				<dt><a href="<?php echo $h['href'];?>"><img src="<?php echo $h['thumb'];?>" width="182" height="182" title="<?php echo $h['name'];?>" /></a></dt>
				<dd><a href="<?php echo $h['href'];?>"><?php echo $h['shortname'];?></a></dd>
				<dd class="price">商品价格：<?php echo $h['price'];?>元</dd>
			</dl>
		<?php } ?>
	
	</div>
	
</div>
<script type="text/javascript">
$('.bor input[name=\'filter_name\']').keydown(function(e) {
	if (e.keyCode == 13) {
		$('.s_but').trigger('click');
	}
});

$('.s_but').bind('click', function() {
	url = 'index.php?route=search/search';
	
	var filter_name = $('.bor input[name=\'filter_name\']').attr('value');

	if(filter_name.indexOf('搜索')>=0){
	   return false;
	}
	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}
	/*var filter_category_id = $('#content select[name=\'filter_category_id\']').attr('value');
	
	if (filter_category_id > 0) {
		url += '&filter_category_id=' + encodeURIComponent(filter_category_id);
	}
	
	var filter_sub_category = $('#content input[name=\'filter_sub_category\']:checked').attr('value');
	
	if (filter_sub_category) {
		url += '&filter_sub_category=true';
	}
		
	var filter_description = $('#content input[name=\'filter_description\']:checked').attr('value');
	
	if (filter_description) {
		url += '&filter_description=true';
	}*/
	location = url;
});

function display(view) {
	if (view == 'list') {
		$('.product-grid').attr('class', 'product-list');
		
		$('.product-list > div').each(function(index, element) {
			
			var html='<dl>';

			var image = $(element).find('.image').html();

			image=image.replace(/width=['"]?\d['"]?/,"width='80'").replace(/height=['"]?\d['"]?/,"height='80'");
			if (image != null) { 
				html += '<dt class="image">' + image + '</dt>';
			}
			
			html += '  <dd class="wishlist">' + $(element).find('.wishlist').html() + '</dd>';
			//html += '  <dd class="cart">' + $(element).find('.cart').html() + '</dd>';
			
			//html += '  <dd class="compare">' + $(element).find('.compare').html() + '</dd>';
			
			html += '<dd class="name">' + $(element).find('.name').html() + '</dd>';
			
			var salenum = $(element).find('.salenum').html();
			
			if (salenum != null) {
				html += '<dd class="salenum">' + salenum + '</dd>';
			}
			
			var price = $(element).find('.price').html();
			
			if (price != null) {
				html += '<dd class="price">' + price  + '</dd>';
			}
						
		    html+='</dl>';
			//html += '  <dd class="description">' + $(element).find('.description').html() + '</dd>';
			
				

						
			$(element).html(html);
		});		
		
		$('.display').html('<b><?php echo $text_display;?></b> <?php echo $text_list;?> <b>|</b> <a onclick="display(\'grid\');"><?php echo $text_grid;?></a>');
		
		$.cookie('display', 'list'); 
	} else {
		$('.product-list').attr('class', 'product-grid');
		
		$('.product-grid > div').each(function(index, element) {
			html = '<dl>';
			
			var image = $(element).find('.image').html();
            image=image.replace(/width=['"]?\d['"]?/,"width='182'").replace(/height=['"]?\d['"]?/,"height='182'");
			if (image != null) {
				html += '<dt class="image">' + image + '</dt>';
			}
			
			var name=$(element).find('.name').html();
			html += '<dd class="name">' + name + '</dd>';
			
			var salenum = $(element).find('.salenum').html();
			
			if (salenum != null) {
				html += '<dd class="salenum">' + salenum + '</dd>';
			}
			
			//html += '<dd class="description">' + $(element).find('.description').html() + '</dd>';
			
			var price = $(element).find('.price').html();
			
			if (price != null) {
				html += '<dd class="price">' + price  + '</dd>';
			}	
					
			
						
			//html += '<dd class="cart">' + $(element).find('.cart').html() + '</dd>';
			html += '<dd class="wishlist">' + $(element).find('.wishlist').html() + '</dd>';
			//html += '<dd class="compare">' + $(element).find('.compare').html() + '</dd>';
			
			html+='</dl>';
			$(element).html(html);
		});	
					
		$('.display').html('<b><?php echo $text_display;?></b> <a onclick="display(\'list\');"><?php echo $text_list;?></a> <b>|</b> <?php echo $text_grid;?>');
		
		$.cookie('display', 'grid');
	}
}

var view = $.cookie('display');

if (view) {
	display(view);
} else {
	display('list');
}


$(".product-grid div dl").live('mouseenter',function(){
    $(this).css({'border':'1px solid #000000'});
}).live('mouseleave',function(){
    $(this).css({'border':'1px solid #ffffff'});
});


$(".product-list div").live('mouseenter',function(){
    $(this).css({'background-color':'#4adddc'});
}).live('mouseleave',function(){
    $(this).css({'background-color':'#ffffff'});
});

$("select[name=limit]").change(function(){
   var url=$(this).val();
   window.location.href=url;
});



//添加到购物车
$(".cart a").live('click',function(){
    var product_id=$(this).attr('data-id');
    <?php if(empty($customer_id)) { ?>
	    var referer='<?php echo $referer;?>';
	    location.href="index.php?route=account/login&referer="+encodeURIComponent(referer);
	<?php } else { ?>
        addToCart(product_id); 
	<?php } ?>
});


//添加到收藏夹
$(".wishlist a").live('click',function(){
    var product_id=$(this).attr('data-id');
    <?php if(empty($customer_id)) { ?>
	    var referer='<?php echo $referer;?>';
	    location.href="index.php?route=account/login&referer="+encodeURIComponent(referer);
	<?php } else { ?>
	    addToWishList(product_id);
    <?php } ?>
});


</script> 
<?php echo $footer;?>