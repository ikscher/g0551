<!DOCTYPE HTML>
<html>
<head>
<title>穿悦商城店铺</title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<?php if($icon) { ?>
<link href="<?php echo $icon;?>" rel="icon" />
<?php } ?>
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery-1.7.1.min.js"></script>
<link href="catalog/view/theme/default/stylesheet/member.css" rel="stylesheet" type="text/css" />
<link href="catalog/view/theme/default/stylesheet/store.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="catalog/view/javascript/menudropdown.js"></script>
</head>

<body>
<div class="wrapper">
    
 	<div class="toolbar">
	    <?php if(!empty($username)) { ?>
	    <ul>
		     <li><a href="javascript:void(0);" class="favorites" onclick="AddFavorite('','<?php echo $home;?>')"><?php echo $favoriate;?></a></li>
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
			 <li class="tel">服务热线：0551-4374866</li>
        </ul>
		<?php } else { ?>
		<ul>
		     <li><a href="javascript:void(0);" class="favorites" onclick="AddFavorite('','<?php echo $home;?>')"><?php echo $favoriate;?></a></li>
		     <li><?php echo $welcome;?>游客！</li>
			 <li><a class="exit" href="index.php?route=account/login">登录</li>

			 
		</ul>
		<ul class="z">	
             <li><a href="<?php echo $home;?>" >商城首页</a></li>		
			 
			 <li><a href="#" >帮助中心</a></li>
	
			 <li class="tell"><img src="catalog/view/theme/default/image/member/tel.gif" width="15" height="19"/></li>
			 <li class="tel">服务热线：0551-4374866</li>
        </ul>
	    <?php } ?>
	</div>
	