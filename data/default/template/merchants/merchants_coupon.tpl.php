<?php echo $header;?>
    <!--左侧begin-->
    <?php echo $left;?>
 	<!--左侧end-->
    <!--右侧begin-->
	<div class="right"><div class="account_box1">
		<div class="item-list">
			<div class="item-list-hd">
			<ul class="item-list-tabs item-list-tabs-flexible clearfix" >
				<li  class="current" ><a href="#" onclick="" hidefocus="true">优惠券管理</a></li>
				<li ><a href="#" onclick="" hidefocus="true">优惠券添加</a></li>
			</ul>
			</div>
			<div class="item-list-bd">
				<table id="J_ListTable">
				<thead>
					<tr>
						<th align="right"><a href="#" class="fa" onclick="SetSelectProduct('index.php?route=merchants/coupon/del','删除','优惠券','info_id')">删除所选优惠券</a></th>
					</tr>
				</thead>
				</table> 
			</div>  
			<table width="100%">
              <tr bgcolor="#EDF5FF">
					<td width="50"><input type="checkbox" name="checkbox" value="checkbox" onclick="SelectAll('info_id',this)" /></td>
					<td><b>优惠券名称</b></td>
				  <td width="60"><b>类型</b></td>
					<td width="60"><b>折扣</b></td>
					<td width="60"><b>限额</b></td>
				  <td width="80"><b>生效时间</b></td>
					<td width="80"><b>失效时间</b></td>
					<td width="60"><b>状态</b></td>
					<td><strong>使用会员</strong></td>
					<td width="60"><b>操作</b></td>
				</tr>
                <?php foreach((array)$couponList as $coupon) {?>
				<tr >
					<td><input type="checkbox" name="info_id" value="<?php echo $coupon['coupon_id'];?>" /></td>
					<td><?php echo $coupon['name'];?></td>
					<td><?php echo $coupon['type'];?></td>
					<td><?php echo $coupon['discount'];?></td>
					<td><?php echo $coupon['total'];?></td>
					<td><?php echo $coupon['date_start'];?></td>
					<td><?php echo $coupon['date_end'];?></td>
					<td><?php echo $coupon['status'];?></td>
					<td><?php echo $coupon['customer_name'];?></td>
					<td><a href="index.php?route=merchants/coupon/add&id=<?php echo $coupon['coupon_id'];?>" class="fa">编辑</a></td>
                </tr>
                <?php } ?>
			</table> 
          	</div>
    	</div>
        <table width="100%" border="0">
          <tr>
            <td align="right"><?php echo $page;?></td>
          </tr>
        </table>
    </div>
 	<!--右侧end-->
</div>
<?php echo $footer;?>
<script type="text/javascript" src="catalog/view/javascript/merchants.js"></script>