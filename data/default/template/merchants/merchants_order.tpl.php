<?php echo $header;?>
 	<!--左侧begin-->
	<?php echo $left;?>
 	<!--左侧end-->
    <!--右侧begin-->
	<div class="right">
	<div class="item-list">
	<div class="item-list-hd">
   	<ul class="item-list-tabs item-list-tabs-flexible clearfix" data-spm="9">
		<li ><a href="index.php?route=merchants/order_create" hidefocus="true"><?php echo $createorder;?></a></li>
		<li class="current"><a href="index.php?route=merchants/order" ><?php echo $waitingorder;?></a></li>
		<li><a href="index.php?route=merchants/ordering"  hidefocus="true"><?php echo $dealingorder;?></a></li>
		<li><a href="index.php?route=merchants/ordered"  hidefocus="true"><?php echo $dealedorder;?></a></li>
	</ul>	
    </div>
		 		
	<form  action="" method="post">
		<input type='hidden' value=''>
		<div class="item-list-bd">
			<table id="J_ListTable">
			<thead>
				<tr>
					<th> </th>
					<th width="250">宝贝</th>
					<th width="100">单价(元)</th>
					<th width="40">数量</th>
				  <th width="100">收货人</th>
					<th width="80">交易状态</th>
					<th width="100">实收款(元)</th>
					<th >评价</th>
				</tr>
			</thead>
			<!--<tbody class="act">
				<tr>
					<td colspan="9">
						<div class="operations">
							<input type="checkbox" class="all-selector" /><label>全选</label>
						 		   <a href="">批量发货</a>
	    						   <a href="">批量备忘</a>
	    						   <a href="">批量免运费</a>
						    <span style="display:inline">
								<label class="show-hidden-orders" ><input type="checkbox"onclick="switch_closeorder(this)" />不显示已关闭的订单</label>
						    </span>
							<ul class="page-nav inline-block page-nav-simply">
							<li class="prev-page"><a href="#" class="disabled" onclick="javascript:void(0)">上一页</a></li>
							<li class="next-page"><a href="#" class="disabled" onclick="javascript:void(0)">下一页</a></li>
							</ul>
						</div>
					</td>
				</tr>
			</tbody>-->
		</table> 
		</div>   
		</form>
	</div>
 	<!--订单列表-->
		<div class="tab_bor">
        <?php foreach((array)$orderList as $order) {?>
		<table width="790" height="100" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#e6e6e6" >
		  <tr>
			<td height="28" colspan="5" bgcolor="#f3f3f3">
				<span class="order_num">订单编号：<?php echo $order['orderid'];?></span>
				<span class="order_num">成交时间：<?php echo $order['date_added'];?></span>
                <span class="deal_time">买家：<?php echo $order['email'];?></span>
			</td>
		  </tr>
		  <tr>
			<td bgcolor="#FFFFFF" width="450">
            <?php foreach((array)$order['product_list'] as $product) {?>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="nostyle">
			  <tr>
				<td width="60" align="center"><a href="index.php?route=product/product&product_id=<?php echo $product['product_id'];?>" target="_blank" ><img src="<?php echo $product['image'];?>" width="50" height="50" /></a></td>
				<td width="250">
				<div class="props">
				<a href="index.php?route=product/product&product_id=<?php echo $product['product_id'];?>" target="_blank" class="txt_color"><?php echo $product['name'];?></a> <?php if($product['attribute']) { ?><br><span><?php echo $product['attribute'];?></span><?php } ?>
                </div>
				</td>
				<td width="100" align="center" class="price"><?php echo $product['price'];?></td>
				<td width="40"  align="center"  class="num"><?php echo $product['quantity'];?></td>
			  </tr>
			</table>
            <?php } ?>            </td>
			<td bgcolor="#FFFFFF" width="100" align="center">
				<?php echo $order['username'];?><br>
				<span><?php echo $order['mobile'];?></span>
			</td>
			<td bgcolor="#FFFFFF" width="80" align="center">
			  <a href="javascript:void(0);" onclick="setOrderStatus('detachGoods','确定所选宝贝已开始配货吗？',<?php echo $order['order_id'];?>);">开始配货</a><br>
			  <a href="index.php?route=merchants/order/detail&id=<?php echo $order['order_id'];?>" target="_blank" class="txt_color">详情</a>			</td>
			<td bgcolor="#FFFFFF" width="100" align="center">
				<span class="price"><?php echo $order['total'];?></span><p class="post-type"><?php if(!empty($order['shipping'])) { ?>(含<?php echo $order['shipping']['title'];?>:<?php echo $order['shipping']['text'];?>)<?php } ?></p>
				<!--(含<span class="post-type"> 快递 </span>:<span class="J_PostFee">12.00</span>)-->				    						    			
			</td>
			<td bgcolor="#FFFFFF">&nbsp;</td>
		  </tr>
		</table>
        <?php } ?>
	  </div>
 	<!--订单列表end-->
      <!--begin  页脚批量操作和列表翻页 begin-->
	    <div class="page">
		<table>
    		<tr>
    			<td><?php echo $page;?></td>
    		</tr>		
		</table>
		</div>
 	<!--页脚翻页end-->
    </div>
 	<!--右侧end-->
</div>

<?php echo $footer;?>
<script type="text/javascript" src="catalog/view/javascript/merchants.js"></script>