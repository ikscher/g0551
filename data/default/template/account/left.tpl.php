<div class="left">
	<div class="leftClass">
		<dl>
			<dt>我的帐户</dt>
			<!-- <dd><a href="#">我的帐户</a></dd> -->
			<dd><a href="<?php echo $edit;?>">编辑帐户</a></dd>
			<dd><a href="<?php echo $password;?>">修改密码</a></dd>
			<dd><a href="<?php echo $address;?>">收货地址</a></dd>
			<dd><a href="<?php echo $wishlist;?>">收藏列表</a></dd>
		</dl>
		<dl>
			<dt>我的订单</dt>
			<dd><a href="<?php echo $order;?>">已买到的宝贝</a></dd>
			<dd><a href="<?php echo $download;?>">下载商品</a></dd>
			<dd><a href="<?php echo $return;?>">商品退换</a></dd>
			<dd><a href="<?php echo $transaction;?>">购买过的店铺</a></dd>
		</dl>
		<dl>
			<dt>我的秀</dt>
			<dd><a href="<?php echo $myshow;?>">发布秀主题</a></dd>
		</dl>
	</div>
</div>

<script type="text/javascript">

$("dd ").hover(function(){
   $(this).addClass('current');
},function(){
  
   $(this).removeClass('current');
});

</script>