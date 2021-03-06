<!DOCTYPE html>
<html>
<head>
<title><?php echo $title;?></title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<base href="<?php echo $base;?>" />

<meta name="keywords" content="穿悦商城,购物商城,合肥购物商城,合肥B2C,网上买,网上卖,电子商务,网店,网购,合肥网店,店铺" />
<meta name="description" content="穿悦商城 - 合肥最大、最安全的网上交易平台，提供各类服饰、美容、家居、数码、食品、汽车配件，同时提供担保交易(先收货后付款)、先行赔付、假一赔三、七天无理由退换货、数码免费维修等安全交易保障服务，让你全面安心享受网上购物乐趣！">
<?php if($icon) { ?>
<link href="<?php echo $icon;?>" rel="icon" />
<?php } ?>

<script type="text/javascript" src="catalog/view/javascript/jquery/jquery-1.7.1.min.js"></script>
<!-- <script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script> 
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" /> --> 
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/external/jquery.cookie.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/colorbox/jquery.colorbox.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/colorbox/colorbox.css" media="screen" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/common.css" media="screen" />
<script type="text/javascript" src="catalog/view/javascript/common_jquery.js"></script>
<script type="text/javascript" src="catalog/view/javascript/common.js"></script>
<script type="text/javascript" src="catalog/view/javascript/menudropdown.js"></script>


</head>
<body>
<div id="head_top" class="box cl">
	<div class="wp cl h">
		<ul class="z">
			<li class="z collect"><a href="javascript:void(0);" onclick="AddFavorite('<?php echo $title;?>','<?php echo $home;?>')">收藏本站</a></li>
			<li class="z">您好，<?php if(!empty($username)) { ?><?php echo $username;?>欢迎来到穿悦商城！<a href="<?php echo $text_logout;?>" class="f_h">退出</a><?php } else { ?>欢迎来到穿悦商城！<a href="<?php echo $text_login;?>" class="f_h">登录</a>，<a href="<?php echo $text_register;?>" class="f_h">快速注册</a><?php } ?></li>
		</ul>
		<ul class="y" id="menu">
		    <?php if(!empty($username)) { ?>
	
		    <li class="z ">
			<div class="menulist" id="myaccount">
				<span><a href="<?php echo $account;?>">我的穿悦</a></span>
					<ul>
						<li><a href="<?php echo $order;?>">我的订单</a></li>
						<li><a href="<?php echo $transaction;?>">我的交易</a></li>
						<li><a href="<?php echo $wishlist;?>">收藏列表</a></li>
						<li><a href="<?php echo $return;?>">商品退换</a></li>
					</ul>
			</div>
		    </li>
			
			<?php if(!empty($store_id)) { ?>
			<li class="z ">
			<div class="menulist" id="merchants">
				<span><a href="<?php echo $merchants;?>">卖家中心</a></span>
					<ul>
						<li><a href="<?php echo $sold;?>">已卖出的商品</a></li>
						<li><a href="<?php echo $sell;?>">出售中的商品</a></li>
						<li><a href="<?php echo $release;?>">发布商品</a></li>
						<li><a href="<?php echo $remark;?>">评价管理</a></li>
					</ul>
			</div>
		    </li>
			<?php } ?>
		    
			<li class="z" >
			  <div class="menulist" id="cart">
				<span id="cart-total"><a href="<?php echo $shoppingcart;?>" >购物车<?php echo $countProducts;?>件</a></span>
                <div class="car-content" style="display: none;"></div>
				
			  </div>
			</li>
			
			<?php } ?>
			<li class="z hotline f2 f_c"><?php echo $telephone;?></li>
		</ul>
	</div>
</div>

<div id="head_index" class="wp cl h">
	<a href="<?php echo $home;?>" ><div class="logo z"></div></a>
	<div class="index z">
		<ul class="nav">
			<li><a href="<?php echo $clothes;?>"></a></li>
			<li><a href="<?php echo $foods;?>"></a></li>
			<li><a href="<?php echo $house;?>"></a></li>
			<li><a href="<?php echo $travel;?>"></a></li>
			<li><a href="<?php echo $joy;?>"></a></li>
		</ul>
	</div>
	<div class="search y">
	    <div class="search-triggers">
		    <ul class="ks-switchable-nav">
			    <li data-searchtype="item" data-defaultpage="index.php?route=search/search" class="selected"><a href="javascript:void(0);">宝贝</a><!--[if lt IE 9]><s class="search-fix search-fix-triggerlt"></s><s class="search-fix search-fix-triggerrt"></s><![endif]--></li>
			    <li data-searchtype="shop" data-action="index.php?route=store/list"><a href="javascript:void(0);">店铺</a><!--[if lt IE 9]><s class="search-fix search-fix-triggerlt"></s><s class="search-fix search-fix-triggerrt"></s><![endif]--></li>
			</ul>
		</div>
		<div class="search_box h" id="search_box">
			<input id="search" name="search" class="search_input z h" accesskey="s" autofocus="true" autocomplete="off" x-webkit-speech="" x-webkit-grammar="builtin:translate" />
			<button id="search_btn" class="search_btn"></button>
		</div>
		<div class="search_hot f3n">
            热门搜索：
            <a href="">山核桃</a> 
            <a href="">鱿鱼 </a>
            <a href="">铁观音 </a>
            <a href="">罐头 </a>
            <a href="">卵磷脂 </a>
            <a href="">鹿茸 </a>
            <a href="">阿胶 </a>
            <a href="">雪蛤 </a>
            <a href="">婴幼保健</a>
        </div>
	</div>
</div>

<div id="head_nav" class="head_nav_<?php echo $list_channel_title;?> box cl h">
	<div class="wp cl h" >
		<ul>
			<?php foreach((array)$subCategoryList as $scl) {?>
			   <li><a href="index.php?route=product/category&category_id=<?php echo $scl['category_id'];?>"><?php echo $scl['name'];?></a></li>
			<?php } ?>
		</ul>
	</div>
</div>

<script type="text/javascript">
    //搜索**/
    var obj={
	        searchType:'',
			query:'',
			z:'',
			url:''
		};
	
	obj.searchType='item';
	$("ul.ks-switchable-nav li a").click(function(){
		if($(this).parent().attr('data-searchtype')=='item'){
			obj.searchType='item';
		}else if ($(this).parent().attr('data-searchtype')=='shop'){
		    obj.searchType='shop';
		}
	});
	    
    $('#search_box input[name=\'search\']').keydown(function(e) {
		if (e.keyCode == 13) {
			$('.search_btn').trigger('click');
		}
	});
	$('#search_btn').bind('click', function() {
	    if (obj.searchType=='item'){
		    obj.url = 'index.php?route=search/search';
		}else if(obj.searchType=='shop'){
		    obj.url = 'index.php?route=store/list';
		}
		
		var filter_name = $('#search_box input[name=\'search\']').attr('value');
		if (filter_name) {
			obj.url += '&filter_name=' + encodeURIComponent(filter_name);
		}
		window.location.href = obj.url;
	});

   //页面标签切换
	obj.query=window.location.search+"&<?php echo $list_channel_title;?>";
	$("ul.nav li").each(function(i,w){
		var x=i+1;
		if(obj.query.search(/clothes/i)>=0) obj.z=1;
		if(obj.query.search(/foods/i)>=0) obj.z=2;
		if(obj.query.search(/house/i)>=0 ) obj.z=3;
		if(obj.query.search(/travel/i)>=0 ) obj.z=4;
		if(obj.query.search(/joy/i)>=0 ) obj.z=5;
		
		if(x==obj.z){
	       $(w).addClass("indexo"+obj.z);
		}else{
	       $(w).addClass("indexc"+x);
	    }
		
		/*
		var self=$(this);
	    self.click(function(){
		   self.removeClass("indexc"+x);
	       self.addClass("indexo"+x);
	      
		});
	    */
	});
	
	$('ul.ks-switchable-nav li').click(function(){
	    $(this).parent().children('li').removeClass('selected');
		$(this).addClass('selected');
	});

</script>