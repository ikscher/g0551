
<!--左侧begin-->
<div class="left">
	<div class="leftClass">
		<dl>
			<dt><?php echo $store_management;?></dt>
			<dd class="current"><a  href="<?php echo $merchants;?>"><?php echo $store_setup;?></a></dd>
			<dd><a  href="<?php echo $store;?>"><?php echo $store_list;?></a></dd>
		</dl>
		<dl>
			<dt><?php echo $trade_management;?></dt>
			<dd><a href="<?php echo $sold;?>"><?php echo $soldproduct;?></a></dd>
			<dd><a href="index.php?route=merchants/return">退换货管理</a></dd>
			<!--<dd><a href="<?php echo $remark;?>"><?php echo $remark_management;?></a></dd>-->
		</dl>
		<dl>
			<dt><?php echo $product_management;?></dt>
			<dd><a href="<?php echo $release;?>"><?php echo $releaseproduct;?></a></dd>
			<dd><a href="<?php echo $sell;?>"><?php echo $sellingproduct;?></a></dd>
			<dd><a href="<?php echo $warehouse;?>"><?php echo $baseproduct;?></a></dd>
		</dl>
		<dl>
			<dt><?php echo $order_management;?></dt>
			<dd><a href="<?php echo $order_;?>"><?php echo $createorder;?></a></dd>
			<dd><a href="<?php echo $order;?>"><?php echo $waitingorder;?></a></dd>
			<dd><a href="<?php echo $ordering;?>"><?php echo $dealingorder;?></a></dd>
			<dd><a href="<?php echo $ordered;?>"><?php echo $dealedorder;?></a></dd>
		</dl>
		<dl>
			<dt><?php echo $discount_management;?></dt>
			<dd><a href="<?php echo $coupon_add;?>"><?php echo $coupon_adds;?></a></dd>
			<dd><a href="<?php echo $coupon;?>"><?php echo $coupons;?></a></dd>
		</dl>
	</div>
</div>
<!--左侧end-->



<script type="text/javascript">

<?php if(empty($hasShop)) { ?>
	$(".leftClass dd a").click(function(){
	   alert('您的店铺正在审核状态中...');
	   return false;

	});
<?php } ?>

$("dd ").hover(function(){
   $(this).addClass('current');
},function(){
  
   $(this).removeClass('current');
});

</script>