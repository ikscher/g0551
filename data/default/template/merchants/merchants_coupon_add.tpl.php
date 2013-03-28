<?php echo $header;?>
    <!--左侧begin-->
    <?php echo $left;?>
 	<!--左侧end-->
    <!--右侧begin-->
	<div class="right">
    <div class="blue_bor">
      <form action="index.php?route=merchants/coupon/insert" method="post" onsubmit="return CheckCoupon(this);">
        <input name="coupon_id" type="hidden" value="<?php echo $info['coupon_id'];?>" />
        <div class="blue_topbg">
            <ul>
                <li class="bl">优惠券设置</li>
            </ul>
        </div>
	  <div class="container">
		<table align="center" class="bianji">
		  <tr class="bianji">
			<td width="180" align="left"><strong class="red">*</strong> 优惠券编号：</td>
			<td width="570"><input name="coupon_name" type="text" id="coupon_name" size="30" maxlength="30" value="<?php echo $info['name'];?>" />　<span>编号不能相同，每张优惠券只能使用1次</span></td>
		  </tr>
		  <tr>
			<td align="left"><strong class="red">*</strong> 优惠券密码：</td>
			<td><input name="coupon_code" type="text" id="coupon_code" size="30" maxlength="30" value="<?php echo $info['code'];?>" />　<span>正确输入密码后才能使用优惠券</span></td>
		  </tr>
		  <tr>
			<td align="left"><strong class="red">*</strong> 优惠类型：</td>
			<td>
            <select name="coupon_type" id="coupon_type">
			  <option value="P"<?php if($info['type']=='P') { ?> selected<?php } ?>>百分比</option>
			  <option value="F"<?php if($info['type']=='F') { ?> selected<?php } ?>>固定金额</option>
			</select>
            　<span>百分比或固定数额</span>            </td>
		  </tr>
		  <tr>
			<td align="left"><strong class="red">*</strong> 折扣：</td>
			<td><input name="coupon_discount" type="text" id="coupon_discount" size="30" maxlength="10" value="<?php echo $info['discount'];?>" /></td>
		  </tr>
		  <tr>
			<td align="left"><strong class="red">*</strong> 订单限额：</td>
			<td><input name="coupon_total" type="text" id="coupon_total" size="30" maxlength="10" value="<?php echo $info['total'];?>" />　<span>订单金额必须大于本数值，优惠券才能使用</span></td>
	      </tr>
		  <tr>
			<td align="left"><strong class="red">*</strong> 开始日期：</td>
			<td><input name="date_start" type="text" id="date_start" size="30" maxlength="10" value="<?php echo $info['date_start'];?>"/>　<span>优惠券生效日期</span></td>
		  </tr>
		  <tr>
			<td align="left"><strong class="red">*</strong> 结束日期：</td>
			<td>
			  <input name="date_end" type="text" id="date_end" size="30" maxlength="10" value="<?php echo $info['date_end'];?>"/>　<span>优惠券失效日期</span></td>
		  </tr>
		</table>
	  </div>
        <div class="blue_topbg">
            <ul>
                <li class="br"><input name="" type="submit" value="保存" /> <input name="" type="button" value="返回" onclick="history.back();" /></li>
            </ul>
        </div>
	</form>
    </div>
    </div>
 	<!--右侧end-->
</div>
<?php echo $footer;?>
<script type="text/javascript" src="catalog/view/javascript/merchants.js"></script>