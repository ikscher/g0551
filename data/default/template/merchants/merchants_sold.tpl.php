<?php echo $header;?>
    <!--左侧begin-->
    <?php echo $left;?>
 	<!--左侧end-->
	
    <!--右侧begin-->
	<div class="right">
		<div id="main-content">
		 <form method="post" action="index.php?route=merchants/sold">		
			<div id="trade-search-box" data-spm="10">
			<div class="bd" id="J_SearchBox">
			<table>
				<tbody>
                <tr>
                    <td class="single-col">
                    <label>订单编号：<input name="i" type="text" id="i" size="11" maxlength="30" value="<?php echo $info['orderid'];?>"/>
                    </label></td>
                    <td class="single-col">
                    <label>买家邮箱：<input type="text" size="15" id="J_BuyNick" name="e" value="<?php echo $info['email'];?>" />
                    </label>                    </td>                    
                    <td class="single-col">
                    <label>买家手机：<input type="text" size="15" id="m" name="m" value="<?php echo $info['mobile'];?>"/>
                    </label>                    </td>
                </tr>
                <tr>
                  <td class="single-col">
                  <label>收件姓名：<input name="cn" type="text" id="i" value="<?php echo $info['cname'];?>" size="11" maxlength="30"/>
                  </label></td>
                  <td class="single-col">
                  <label>收件手机：<input type="text" size="15" id="J_BuyNick2" name="cm" value="<?php echo $info['cmobile'];?>" />
                  </label>
                  </td>
                  <td class="single-col">
                  <label>收件电话：<input type="ct" size="15" id="ct" name="ct" value="<?php echo $info['ctelephone'];?>"/>
                  </label>
                  </td>
                </tr>
                <tr>
                    <td class="single-col">
                    <label>成交时间：<input type="text" size="11" id="bizOrderDateBegin" name="t" value="<?php echo $info['order_time'];?>" />
                    </label></td>
                    <td class="single-col">
                        <label>订单状态：
                        <select id="state_list" name="s" value="" >
				        <option value="">全部</option>
						<option value="1">等待买家付款</option>
						<option value="2">买家已付款</option>
						<option value="3">正在配货</option>
						<option value="4">已发货</option>
						<option value="5">交易成功</option>
						<option value="6">交易关闭</option>
				        </select></label></td>
					<td class="single-col">
                    <span class="skin-gray">
                        <button id="J_SearchOrders" class="small-btn J_MakePoint" type="submit" onclick="changePage(0)">&nbsp;搜索订单&nbsp;</button>
                        <!--<button id="J_BatchExportBtn" class="small-long-btn" type="button">&nbsp;批量导出&nbsp;</button>-->
                    </span>                    </td>
                </tr>
                </tbody>
			</table>
			<div class="msg" id=""></div>			
				<div id="" class="batch-export skin-gray" style="display: none">
                <ul>
					<li>为了保证您的查询性能，两次导出的时间间隔请保持在5分钟以上。</li>      	
	                <li>我们将为您保留30天内导出的数据，便于您随时导出。</li>
	            </ul>
	            <div class="actions"> 		
                	<a class="long-btn generate-sheets" onclick="applyExport()">生成报表</a> 
                	<a class="long-btn view-sheets"href='' target="_blank">查看已生成报表</a> 
                </div>    					
			 		<a id="J_BatchExportPanelCloseBtn" class="close-btn" href="#" title="关闭">关闭</a>
				</div>
			</div>			
		 </div>	
		 </form>
		</div>
	<div class="item-list">
	<div class="item-list-hd">
   	<ul class="item-list-tabs item-list-tabs-flexible clearfix" data-spm="9" id="order_state">
		<li class="current" rel=""><a href="index.php?route=merchants/sold">查看全部订单</a></li>
		<li rel="1"><a href="index.php?route=merchants/sold&s=1">等待买家付款的订单</a></li>
		<li rel="2"><a href="index.php?route=merchants/sold&s=2">等待发货的订单</a></li>
   		<li rel="3"><a href="index.php?route=merchants/sold&s=3">发送中的订单</a></li>
		<li rel="4"><a href="index.php?route=merchants/sold&s=4">已发货的订单</a></li>
		<li rel="5"><a href="index.php?route=merchants/sold&s=5">交易成功的订单</a></li>
		<li rel="6"><a href="index.php?route=merchants/sold&s=6">已关闭的订单</a></li>
	</ul>	
    </div>
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
					<th>评价</th>
				</tr>
			</thead>
		</table> 
		</div>   
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
				<td width="60" align="center"><img src="<?php echo $product['image'];?>" width="50" height="50" /></td>
				<td width="250">
				<div class="props">
				<a href="index.php?route=product/product&product_id=<?php echo $product['product_id'];?>" target="_blank" class="txt_color"><?php echo $product['name'];?></a> (<?php echo $product['model'];?>)<?php if($product['attribute']) { ?><br><span><?php echo $product['attribute'];?></span><?php } ?>
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
			  <?php echo $order['order_state'];?><br>
			  <a href="index.php?route=merchants/order/detail&id=<?php echo $order['order_id'];?>" target="_blank" class="txt_color">详情</a>			</td>
			<td bgcolor="#FFFFFF" width="100" align="center">
				<?php if($state==1) { ?>
                <input type="text" size="8" id="price_<?php echo $order['order_id'];?>" value="<?php echo $order['total'];?>" style="text-align:center;height:16px;line-height:16px;" /><br/>
                <a href="javascript:;" onclick="return setOrderPrice(<?php echo $order['order_id'];?>);" class="txt_color">修改价格</a>
                <?php } else { ?>
              	<strong class="price"><?php echo $order['total'];?></strong><br>
                (含快递)
                <?php } ?>
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

<?php echo $footer;?>
<script type="text/javascript" src="catalog/view/javascript/merchants.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#order_state>li").removeClass("current");
	$("#order_state>li[rel='<?php echo $info['state'];?>']").addClass("current");
	$("#state_list>option[value='<?php echo $info['state'];?>']").attr("selected","selected");
});
</script>