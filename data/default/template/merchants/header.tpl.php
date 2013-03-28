<!DOCTYPE HTML>
<html>
<head>
<title><?php echo $title;?></title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<?php if($icon) { ?>
<link href="<?php echo $icon;?>" rel="icon" />
<?php } ?>
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery-1.7.1.min.js"></script>
<!-- <script type="text/javascript" src="catalog/view/javascript/common.js"></script> -->

<link href="catalog/view/theme/default/stylesheet/member.css" rel="stylesheet" type="text/css" />
<link href="catalog/view/theme/default/stylesheet/merchants.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="catalog/view/javascript/menudropdown.js"></script>
</head>

<body>
<div class="wrapper">
 	<div class="toolbar">
	    <ul>
		     <li><a href="javascript:void(0);" class="favorites" onClick="AddFavorite('','<?php echo $home;?>')"><?php echo $favoriate;?></a></li>
		     <li><?php echo $welcome;?><?php echo $username;?>！</li>
		     <li><a href="<?php echo $logout;?>" class="exit"><?php echo $quit;?></a></li>
			 
		</ul>
		
        <ul class="z">	
             <li><a href="<?php echo $home;?>" >商城首页</a></li>		
			 <li>
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
			 
			 
			 <li>
				<div class="menulist" id="myaccount">
					<span><a href="<?php echo $merchants;?>">卖家中心</a></span>
						<ul>
							<li><a href="<?php echo $sold;?>">已卖出的商品</a></li>
							<li><a href="<?php echo $sell;?>">出售中的商品</a></li>
							<li><a href="<?php echo $release;?>">发布商品</a></li>
							<li><a href="<?php echo $remark;?>">评价管理</a></li>
						</ul>
				</div>
			 </li>
			 
			 <li><a href="#" >帮助中心</a></li>
	
			 <li class="tell"><img src="catalog/view/theme/default/image/member/tel.gif" width="15" height="19"/></li>
			 <li class="tel"><?php echo $telephone;?></li>
        </ul>
	    <a class="logo" href="<?php echo $home;?>" title="<?php echo $homepage;?>" ><img src="catalog/view/theme/default/image/member/logo.gif"  /></a>
	</div>

    
<!--logo菜单-->
	<div class="logomenu">
	   
		<ul>
			<li class="logomenu1"><a href="<?php echo $clothes;?>"></a></li>
			<li class="logomenu2"><a href="<?php echo $foods;?>"></a></li>
			<li class="logomenu3"><a href="<?php echo $house;?>"></a></li>
			<li class="logomenu4"><a href="<?php echo $travel;?>"></a></li>
			<li class="logomenu5"><a href="<?php echo $joy;?>"></a></li>
		</ul>
	</div>
</div>
<!--用户nav-->
<div class="navbg">
	<div class="navmenu"><img src="catalog/view/theme/default/image/member/navmenu_merchants.jpg"/></div>
</div>

<div class="mainContent clear"> 