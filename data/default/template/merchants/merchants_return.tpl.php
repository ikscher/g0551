<?php echo $header;?>
 	<!--左侧begin-->
	<?php echo $left;?>
 	<!--左侧end-->
    <!--右侧begin-->
	<div class="right">
	<div class="item-list">
	<div class="item-list-hd">
   	<ul class="item-list-tabs item-list-tabs-flexible clearfix" id="return_state">
		<li class="current" rel="1"><a href="index.php?route=merchants/return">买家申请退换</a></li>
		<li rel="2"><a href="index.php?route=merchants/return&s=2">等待买家发货</a></li>
		<li rel="3"><a href="index.php?route=merchants/return&s=3">商品退换成功</a></li>
	</ul>	
    </div>
		 		
	<form  action="" method="post">
		<input type='hidden' value=''>
		<div class="item-list-bd">
			<table id="J_ListTable">
			<thead>
				<tr>
					<th width="10"></th>
                    <th width="380">产品名称</th>
					<th width="100">编号</th>
				  <th width="80">数量</th>
					<th width="60">买家姓名</th>
					<th width="100">买家电话</th>
					<th width="60">详情</th>
				</tr>
			</thead>
		</table> 
	  </div>   
		</form>
	</div>
 	<!--订单列表-->
		<div class="tab_bor">
        <?php foreach((array)$returnList as $return) {?>
		<table height="60" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#e6e6e6" >
		  <tr>
			<td height="28" colspan="7" bgcolor="#f3f3f3">
				<span class="order_num">订单编号：<?php echo $return['orderid'];?></span>
				<span class="order_num">退换时间：<?php echo $return['date_added'];?></span>
                <span class="deal_time">退货编号：<?php echo $return['return_id'];?></span>			</td>
		  </tr>
		  <tr>
			<td width="10" align="center" bgcolor="#FFFFFF"></td>
	        <td width="380" bgcolor="#FFFFFF"><?php echo $return['product'];?></td>
	        <td width="100" align="center" bgcolor="#FFFFFF"><?php echo $return['model'];?></td>
	        <td width="80" align="center" bgcolor="#FFFFFF"><?php echo $return['quantity'];?></td>
	        <td bgcolor="#FFFFFF" width="60" align="center"><?php echo $return['username'];?></td>
			<td bgcolor="#FFFFFF" width="100" align="center"><?php echo $return['telephone'];?></td>
	        <td bgcolor="#FFFFFF" width="60" align="center"><a href="index.php?route=merchants/return/detail&id=<?php echo $return['return_id'];?>">详情</a></td>
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
<script type="text/javascript">
$(document).ready(function(){
	$("#return_state>li").removeClass("current");
	$("#return_state>li[rel='<?php echo $info;?>']").addClass("current");
});
</script>