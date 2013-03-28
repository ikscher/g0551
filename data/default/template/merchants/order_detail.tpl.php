<?php echo $header;?>
 	<!--左侧begin-->
	<?php echo $left;?>
 	<!--左侧end-->
    <!--右侧begin-->
	<div class="right">
	<div class="order_details"><ul><li>订单详情</li></ul></div>
    
	<div class="order_details_box">
		<div class="order_information">
			<ul>
			<li><span>收货地址：</span> <?php echo $order['username'];?> ，<?php echo $order['mobile'];?> ，<?php echo $order['telephone'];?> ，<?php echo $order['address'];?> ，<?php echo $order['postcode'];?> </li>
			<li><span>买家留言：</span> <?php echo $order['comment'];?></li>
			</ul>
			<ul>
			<li><span>卖家信息</span></li>
			<li>
				<table>
				<tr>
					<td align="right">姓名：</td>
					<td align="left"><?php echo $order['user_username'];?></td>
					<td align="right">昵称：</td>
					<td align="left"><?php echo $order['nickname'];?></td>
					<td align="right">手机：</td>
					<td align="left"><?php echo $order['user_mobile'];?></td>
					<td align="right">电话：</td>
					<td align="left"><?php echo $order['user_telephone'];?></td>
				    <td align="right">邮箱：</td>
				    <td align="left"><?php echo $order['email'];?></td>
				</tr>
				</table>
			</li>
			</ul>
			<ul>
			<li><span>订单信息</span></li>
			<li>
				<table>
				<tr>
					<td align="right">订单编号：</td>
					<td width="160"><?php echo $order['orderid'];?></td>
					<td align="right">成交时间：</td>
					<td width="150"><?php echo $order['date_added'];?> </td>
					<td align="right">支付宝交易号：</td>
				  <td width="170"> </td>
				</tr>
				<tr>
					<td align="right">发货时间：</td>
					<td></td>
					<td align="right">付款时间：</td>
					<td></td>
					<td align="right">确认时间：</td>
					<td></td>
				</tr>
				</table>
			</li>
			</ul>
		</div>
		<!--table_begin-->
		<div class="table_details">
			<table>
				<tr>
				<td align="center" bgcolor="#E8F2FF">宝贝</td>
				<td align="center" bgcolor="#E8F2FF">宝贝属性</td>
				<td width="90" align="center" bgcolor="#E8F2FF">编号</td>
				<td align="center" bgcolor="#E8F2FF">单价(元)</td>
				<td align="center" bgcolor="#E8F2FF">数量</td>
				<td align="center" bgcolor="#E8F2FF">优惠</td>
				</tr>
                <?php foreach((array)$order['product_list'] as $product) {?>
				<tr>
				<td width="280">
					<div class="small_pic">
						<ul>
						<li><a href="index.php?route=product/product&product_id=<?php echo $product['product_id'];?>" target="_blank"><img src="<?php echo $product['image'];?>" /></a></li>
						<li><a href="index.php?route=product/product&product_id=<?php echo $product['product_id'];?>" target="_blank"><?php echo $product['name'];?> </a></li>
						</ul>
					</div>
				</td>
				<td align="center"><?php echo $product['attribute'];?></td>
				<td align="center"><?php echo $product['model'];?></td>
				<td align="center"><?php echo $product['price'];?></td>
				<td align="center"><?php echo $product['quantity'];?></td>
				<td align="center">-</td>
				</tr>
                <?php } ?>
			</table>
            <div class="order_money">实付款：<em><?php echo $order['total'];?></em> 元<?php if(!empty($order['shipping'])) { ?><p>(含<?php echo $order['shipping']['title'];?>:<?php echo $order['shipping']['text'];?>)</p><?php } ?></div>
		</div>
		<!--table_end-->
    </div>
    
    </div>
 	<!--右侧end-->
<?php echo $footer;?>
<script type="text/javascript" src="catalog/view/javascript/merchants.js"></script>