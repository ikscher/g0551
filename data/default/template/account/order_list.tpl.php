<?php echo $header;?>
<!-- <style type="text/css">
tr.over td {
	background:#cfeefe;
} 
</style> -->
<!--个人中心body_begin-->
<div class="mainContent clear">
  <!--左侧begin-->
	<?php echo $left;?>
 	<!--左侧end-->
    <!--右侧begin-->
	<div class="right">
        
		<!--我的订单-->
        	<div class="account_box">
            	<div class="ac_bgs clearfix">
                    <div class="ac_t_l">已买到的宝贝</div>
                    <div class="ac_t_r">
                        <div class="ac_t_l_s"><img src="catalog/view/theme/default/image/member/pic_account_title_07.gif" /></div>
                        <div class="account_contianer">
                        	<h4 class="line">已买到的宝贝<input type="button" class="p_btn_s r" name="cancel" value="返回" /></h4>
                            <div class="line_bot">
							<div class="list">
								<!--个人设置-->
								<form action="<?php echo $orderquery;?>" method="post" >
								<table width="720" border="0" align="center" cellpadding="0" cellspacing="0" class="nostyle">
								  <tr>
									<td width="70">订单序号：</td>
									<td width="180"><input name="orderno" type="text" size="22" class="searchInput" /></td>
									<td><input type="submit" class="p_btn_s"   value="查询" /></td>
								  </tr>
								</table>
								</form>
								<!-- <table width="720" border="0" cellspacing="0" cellpadding="0">
								  <tr>
									<td width="15" height="24"></td>
									<td width="116" class="item" >待处理的订单：0</td>
									<td width="116" class="item" >成交订单：0</td>
									<td width="116" class="item" >订单总数：0</td>
									<td>&nbsp;</td>
								  </tr>
								</table> -->
								<table width="100%" border="0" align="center" cellspacing="1" class="ordercontent">
								  
								  <thead>
								    <tr>
									    <th  bgcolor="#F5EDE2" class="itemTitle"></th>
										<th width="35%" align="center" bgcolor="#F5EDE2" class="itemTitle">宝贝</th>
										<th width="10%" align="center" bgcolor="#F5EDE2" class="itemTitle">单价(元)</th>
										<th width="10%" align="center" bgcolor="#F5EDE2" class="itemTitle">数量</th>
										<th width="13%" align="center" bgcolor="#F5EDE2" class="itemTitle">实付款(元)</th>
										<th width="15%" align="center" bgcolor="#F5EDE2" class="itemTitle">
											<select name="orderstatus">
												<option value="" <?php if(empty($statusid)) { ?>selected=\"selected\"<?php } ?>>订单状态</option>
												<?php if(!empty($orderstatus)) { ?>
													<?php foreach((array)$orderstatus as $v) {?>
														<option value="<?php echo $v['order_status_id'];?>" <?php if($statusid==$v['order_status_id']) { ?>selected=\"selected\"<?php } ?>><?php echo $v['name'];?></option>
													<?php } ?>
												<?php } ?>
											</select>	
										</th>
										<th align="center" bgcolor="#F5EDE2" class="itemTitle">操作</th>
									</tr>
								  </thead>
								  
								  <?php if($orders) { ?>
								        
			                           <?php foreach((array)$orders as $order) {?>
									    <tbody data-id="<?php echo $order['order_id'];?>">
										<tr class="sep-row"></tr>
									        <tr class="order-hd">
										        <td colspan="7">
												<span class="no">订单编号：<?php echo $order['orderid'];?></span>
												<span class="deal-time">成交时间：<?php echo $order['date_added'];?></span>
												<span class="seller">店铺：<a target="_blank" href="index.php?route=store/store&store_id=<?php echo $order['store_id'];?>"><?php if(isset($order['store_name'])) { ?><?php echo $order['store_name'];?><?php } else { ?><?php echo $order['store_id'];?><?php } ?></a></span></td>
										    </tr>
											<?php if(!empty($order['products'])) { ?>
											<?php $cn=count($order['products']);?>
											<?php foreach((array)$order['products'] as $k=>$product) {?>
												<tr class="order-bd">
													<td class="baobei" colspan="2">
													    <a target="_blank" hidefouce="true" title="查看宝贝详情" href="index.php?route=product/product&product_id=<?php echo $product['product_id'];?>" class="pic"><img src="<?php echo $product['image'];?>" alt="查看宝贝详情" /></a>
													    <div class="desc">
														    <a class="baibei-name" target="_blank" href="index.php?route=product/product&product_id=<?php echo $product['product_id'];?>"><?php echo $product['name'];?></a>
														    <div class="spec"><?php echo $product['attribute'];?></div>
														</div>
													</td>
													<td class="price"><?php echo $product['price'];?></td>
													<td class="quantity"><?php echo $product['quantity'];?></td>
													<?php if($k==0) { ?>
													<td class="amount" rowspan="<?php echo $cn;?>"><?php echo $order['total'];?><?php if(!empty($order['shipping'])) { ?><p class="post-type">(含<?php echo $order['shipping']['title'];?>:<?php echo $order['shipping']['text'];?>)</p><?php } ?></td>
													<td class="trade_status" rowspan="<?php echo $cn;?>"><?php if($order['order_status_id']==4) { ?><a href="javascript:void(0);" onclick="setOrderStatus('accept','确定收货吗，您的款项将打给对方？',<?php echo $order['order_id'];?>);">确认收货<?php } else { ?><?php echo $order['status']['name'];?><?php } ?></a><p><a href="<?php echo $order['href'];?>">订单详情</a></p></td>
													
													<td rowspan="<?php echo $cn;?>" class="operate"><?php if($order['status']['order_status_id']==1) { ?><input type="button" class="p_btn_s" id="payOrder" value="付款" /><p><a  class="cancelOrder" data-id="<?php echo $order['order_id'];?>"  data-reorder="<?php echo $order['reorder'];?>" href="javascript:void(0);">取消订单</a></p><?php } elseif ($order['status']['order_status_id']==5 || $order['status']['order_status_id']==6) { ?><a class="deleteOrder" data-id="<?php echo $order['order_id'];?>" href="javascript:void(0);">删除</a> <?php } ?></td>
												    <?php } ?>
												</tr>
												
											<?php }?>
											<?php } ?>
										</tbody>
								        <?php } ?>
									   
									    <tfoot>
											<tr class="pagination"><td colspan="7" align="right"><?php echo $pagination;?></td></tr>
										</tfoot>
								   <?php } else { ?>
								       <tbody>
											<tr class="content"><td colspan="7" align='center'><?php echo $text_empty;?></td></tr>
					                    </tbody>
								   <?php } ?>
								  
								</table>
                            <!--个人设置结束-->
							</div>
							</div>
                        </div>
                    </div>
                </div>
            </div>
            <!--我的订单end-->
			
			
		  <!-- <h1><?php echo $heading_title;?></h1>
		  <?php if($orders) { ?>
			  <?php foreach((array)$orders as $order) {?>
			  <div class="order-list">
				<div class="order-id"><b><?php echo $text_order_id;?></b> #<?php echo $order['order_id'];?></div>
				<div class="order-status"><b><?php echo $text_status;?></b> <?php echo $order['status'];?></div>
				<div class="order-content">
				  <div><b><?php echo $text_date_added;?></b> <?php echo $order['date_added'];?><br />
					<b><?php echo $text_products;?></b> <?php echo $order['products'];?></div>
				  <div><b><?php echo $text_customer;?></b> <?php echo $order['name'];?><br />
					<b><?php echo $text_total;?></b> <?php echo $order['total'];?></div>
				  <div class="order-info"><a href="<?php echo $order['href'];?>"><img src="catalog/view/theme/default/image/info.png" alt="<?php echo $button_view;?>" title="<?php echo $button_view;?>" /></a>&nbsp;&nbsp;<a href="<?php echo $order['reorder'];?>"><img src="catalog/view/theme/default/image/reorder.png" alt="<?php echo $button_reorder;?>" title="<?php echo $button_reorder;?>" /></a></div>
				</div>
			  </div>
			  <?php } ?>
			  <div class="pagination"><?php echo $pagination;?></div>
		   <?php } else { ?>
			   <div class="content"><?php echo $text_empty;?></div>
		  <?php } ?>
		  <div class="buttons">
			<div class="right"><a href="<?php echo $continue;?>" class="button"><?php echo $button_continue;?></a></div>
		  </div> -->
  </div>

  
<!--begin提交订单支付数据到alipay-->
<div style="display:none">
    <form id="alipay" name="alipay" action="index.php?route=payment/alipay" method="post">
	    <input type="hidden" name="WIDseller_email" value="" />
		<input type="hidden" name="WIDout_trade_no" value="" />
		<input type="hidden" name="WIDsubject" value="" />
		<input type="hidden" name="WIDtotal_fee" value="" />
		<input type="hidden" name="WIDbody" value="" />
		<input type="hidden" name="WIDshow_url" value="" />
		<input type="hidden" name="WIDexter_invoke_ip" value="" />
	</form>
</div>
<!--end提交订单支付数据到alipay-->

<script  type="text/javascript">
    /*
    $(function(){
		$(".ordercontent tbody tr.order-bd").mouseover(function(){
			$(this).addClass("over");
		}).mouseout(function(){
			$(this).removeClass("over");	
		});

	});*/
    
	
	//付款
	$("#payOrder").click(function(){
	    var orderid=$.trim($(this).parent().parent().children('td:eq(0)').text());
		$.post('index.php?route=account/order/pay',{orderid:orderid},function(json){
		    //alert(json.WIDseller_email);
			$("#alipay").submit();
		},'json');
	});
	
	
	//取消订单
	$(".cancelOrder").click(function(){
	    if(confirm("您确认取消订单吗？")){
		    var order_id=$.trim($(this).attr('data-id'));
	        //window.location.href=url;
			$.post('index.php?route=account/order/cancel',{order_id:order_id},function(){
			    location.href='index.php?route=account/order';
			});
	    }
	});
	
	
	//删除订单
	$(".deleteOrder").click(function(){
	    if(confirm("您确认删除订单吗？")){
		    var order_id=$.trim($(this).attr('data-id'));
			$.post('index.php?route=account/order/delete',{order_id:order_id},function(str){
			    if(str=='yes'){
					location.href='index.php?route=account/order';
				}else{
				    alert('删除失败！');
				}
			});
	    }
	
	});
	
	$("select[name='orderstatus']").change(function(){
        var statusid=$(this).val();
		if(isNaN(parseInt(statusid))) {
		    window.location.href='index.php?route=account/order';
	    }else{
		    window.location.href='index.php?route=account/order&statusid='+statusid;
		}
	});
	
	
	//设置订单状态
	function setOrderStatus(action,strMsg,intId){
		if(confirm(strMsg)){
			$.post("index.php?route=account/order/"+action,{id:intId},function(str){
				if(str=="ok"){
					location.reload();
				}else{
					alert(str);
				}
			});
		}
	}
	
	$("input[name=cancel]").click(function(){
	    location='<?php echo $back;?>';
	});
	
</script>
<?php echo $footer;?>