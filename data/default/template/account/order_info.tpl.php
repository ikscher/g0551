
<?php echo $header;?>
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
                    <div class="ac_t_l">订单明细</div>
                    <div class="ac_t_r">
                        <div class="ac_t_l_s"><img src="catalog/view/theme/default/image/member/pic_account_title_012.gif" /></div>
                        <div class="account_contianer">
                        	<div class="line">订单明细  &nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo $continue;?>">返回</a></div> 
                            <div class="line_bot">
								<div class="txt">
									<!--个人设置-->
									<h4>订单详情</h4>
									<table width="96%" class="table">
										<tr>
											<td class="h" width="100">状态</td>
											<td class="t"><?php echo $order_status['name'];?></td>
											<td class="h" width="80"></td>
											<td class="t"></td>
										</tr>
										<tr>
											<td class="h">收货人</td>
											<td class="t"><?php echo $shipping_username;?></td>
											<td class="h">邮政编码</td>
											<td class="t"><?php echo $shipping_postcode;?></td>
										</tr>
										<tr>
											<td class="h">移动电话</td>
											<td class="t"><?php echo $shipping_mobile;?></td>
											<td class="h">联系电话</td>
											<td class="t"><?php echo $shipping_telephone;?></td>
										</tr>
										<tr>
											<!-- <td class="h">公司</td>
											<td class="t"><?php echo $shipping_company;?></td> -->
											<td class="h" >收货人地址</td>
											<td class="t" colspan='3'><?php echo $shipping_address;?></td>
										</tr>
									</table>           
									<br />
									<br />
									<h4>配送详情&nbsp;&nbsp;<!-- <a style="color:#AB0036; font-weight:normal;" target="_blank" href="">随时随地查物流</a> --></h4>
									<table width="96%" class="table">
										<tr>
											<td class="h" >订单号</td>
											<td class="t" ><?php echo $orderid;?></td>
											<td class="h" >下单日期</td>
											<td class="t"><?php echo $date_added;?></td>
										</tr>
										<!-- <tr>
											<td class="h" style="width:100px;">发票编号</td>
											<td class="t"><?php if($invoice_no) { ?><?php echo $invoice_no;?><?php } ?></td>
											<td class="h" style="width:100px;">发票明细</td>
											<td class="t"><a href="">查看</a></td>
										</tr> -->
										<tr>
											<td class="h">配送方式</td>
											<td class="t"><?php echo $shipping_method;?></td>
											<td class="h">备注</td>
											<td class="t"><?php echo $shipping_comment;?></td>
										</tr>
										<tr>
											<td class="h" >订单处理日期/时间</td>
											<td class="t"></td>
											<td class="h">处理内容</td>
											<td class="t"></td>
										</tr>
										<?php if($histories) { ?>
											<?php foreach((array)$histories as $history) {?>
												<tr>
													<td colspan="3"><?php echo $history['date_added'];?></td>
													<td style=" text-align:left;"><?php echo $history['status'];?>，<?php echo $history['comment'];?></td>
												</tr>
										    <?php } ?>
										<?php } ?>
										
									</table>
									<br />
									<br />
									<h4>订单金额</h4>
									<table width="96%" class="table">
									   
										<tr>
									    <?php foreach((array)$totals as $total) {?>
											<td class="h"><?php echo $total['title'];?></td>
											<td class="t"><?php echo $total['value'];?></td>
										<?php } ?>
										</tr>
										
										<!-- <tr>
											<td colspan="4" class="h" style="text-align: center;">支付明细</td>
										</tr>
										<tr>
											<td colspan="4">
												<table width="96%" border="0" class="table_nob">                                
													<tr>
														<td>支付宝(在线)</td>
														<td>￥119.00</td>
														<td>支付成功</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
										   <td colspan="4" bgcolor="#FFFFFF" height="28">注：因网络延迟，有可能造成“支付状态”更新不及时，若您已在银行支付成功，请耐心等待，我们会尽快处理您的订单。</td>
										</tr> -->
									</table>
									<br />
									<br />
									<h4>商品明细</h4>
									<div class="clear"></div>
									<table width="96%" class="table">
									
									<thead> <class="h">
										<td width="10%">商品号</td>
										<td width="45">商品名称</td>

										<td width="10%">单价(元)</td>
										<td width="10%">数量</td>
										<td width="10%">小计</td>
										<?php if($order_status['order_status_id']==1) { ?><td width="10%">操作</td><?php } ?>
									</thead>
									<tbody>
									<?php foreach((array)$products as $product) {?>
										<tr>
											<td><a href="<?php echo $product['href'];?>"><?php echo $product['product_id'];?></a></td>
											<td style="text-align: left; padding-left: 10px;height:60px;"><a href="<?php echo $product['href'];?>"><?php echo $product['name'];?> </a></td>
											<td><?php echo $product['price'];?></td>
											<td><?php echo $product['quantity'];?></td>
											<td><?php echo $product['total'];?></td>
											<?php if($order_status['order_status_id']==1) { ?><td><a href="<?php echo $product['return'];?>" title="退换商品" ><img src="catalog/view/theme/default/image/return.png" /></a></td><?php } ?>
											
										</tr>
									<?php } ?>
									</tbody>
									</table>
								<!--个人设置结束-->
								</div>
							</div>
                        </div>
                    </div>
                </div>
            </div>
            <!--我的订单end-->
     </div>
 	<!--右侧end-->
</div>
 <!--个人中心body_end-->
	
	
	
<!--	
<div id="content">
  <div class="breadcrumb">
    <?php foreach((array)$breadcrumbs as $breadcrumb) {?>
    <?php echo $breadcrumb['separator'];?><a href="<?php echo $breadcrumb['href'];?>"><?php echo $breadcrumb['text'];?></a>
    <?php } ?>
  </div>
  <h1><?php echo $heading_title;?></h1>
  <table class="list">
    <thead>
      <tr>
        <td class="left" colspan="2"><?php echo $text_order_detail;?></td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="left" style="width: 50%;"><?php if($invoice_no) { ?>
          <b><?php echo $text_invoice_no;?></b> <?php echo $invoice_no;?><br />
          <?php } ?>
          <b><?php echo $text_order_id;?></b> #<?php echo $order_id;?><br />
          <b><?php echo $text_date_added;?></b> <?php echo $date_added;?></td>
        <td class="left" style="width: 50%;"><?php if($payment_method) { ?>
          <b><?php echo $text_payment_method;?></b> <?php echo $payment_method;?><br />
          <?php } ?>
          <?php if($shipping_method) { ?>
          <b><?php echo $text_shipping_method;?></b> <?php echo $shipping_method;?>
          <?php } ?></td>
      </tr>
    </tbody>
  </table>
  <table class="list">
    <thead>
      <tr>
        <td class="left"><?php echo $text_payment_address;?></td>
        <?php if($shipping_address) { ?>
        <td class="left"><?php echo $text_shipping_address;?></td>
        <?php } ?>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="left"><?php echo $payment_address;?></td>
        <?php if($shipping_address) { ?>
        <td class="left"><?php echo $shipping_address;?></td>
        <?php } ?>
      </tr>
    </tbody>
  </table>
  <table class="list">
    <thead>
      <tr>
        <td class="left"><?php echo $column_name;?></td>
        <td class="left"><?php echo $column_model;?></td>
        <td class="right"><?php echo $column_quantity;?></td>
        <td class="right"><?php echo $column_price;?></td>
        <td class="right"><?php echo $column_total;?></td>
        <?php if($products) { ?>
        <td style="width: 1px;"></td>
        <?php } ?>
      </tr>
    </thead>
    <tbody>
      <?php foreach((array)$products as $product) {?>
      <tr>
        <td class="left"><?php echo $product['name'];?>
          <?php foreach((array)$product['option'] as $option) {?>
          <br />
          &nbsp;<small> - <?php echo $option['name'];?>: <?php echo $option['value'];?></small>
          <?php } ?></td>
        <td class="left"><?php echo $product['model'];?></td>
        <td class="right"><?php echo $product['quantity'];?></td>
        <td class="right"><?php echo $product['price'];?></td>
        <td class="right"><?php echo $product['total'];?></td>
        <td class="right"><a href="<?php echo $product['return'];?>"><img src="catalog/view/theme/default/image/return.png" alt="<?php echo $button_return;?>" title="<?php echo $button_return;?>" /></a></td>
      </tr>
      <?php } ?>
      <?php foreach((array)$vouchers as $voucher) {?>
      <tr>
        <td class="left"><?php echo $voucher['description'];?></td>
        <td class="left"></td>
        <td class="right">1</td>
        <td class="right"><?php echo $voucher['amount'];?></td>
        <td class="right"><?php echo $voucher['amount'];?></td>
        <?php if($products) { ?>
        <td></td>
        <?php } ?>
      </tr>
     <?php } ?>
    </tbody>
    <tfoot>
      <?php foreach((array)$totals as $total) {?>
      <tr>
        <td colspan="3"></td>
        <td class="right"><b><?php echo $total['title'];?>:</b></td>
        <td class="right"><?php echo $total['text'];?></td>
        <?php if($products) { ?>
        <td></td>
        <?php } ?>
      </tr>
      <?php } ?>
    </tfoot>
  </table>
  <?php if($comment) { ?>
  <table class="list">
    <thead>
      <tr>
        <td class="left"><?php echo $text_comment;?></td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="left"><?php echo $comment;?></td>
      </tr>
    </tbody>
  </table>
  <?php } ?>
  <?php if($histories) { ?>
  <h2><?php echo $text_history;?></h2>
  <table class="list">
    <thead>
      <tr>
        <td class="left"><?php echo $column_date_added;?></td>
        <td class="left"><?php echo $column_status;?></td>
        <td class="left"><?php echo $column_comment;?></td>
      </tr>
    </thead>
    <tbody>
      <?php foreach((array)$histories as $history) {?>
      <tr>
        <td class="left"><?php echo $history['date_added'];?></td>
        <td class="left"><?php echo $history['status'];?></td>
        <td class="left"><?php echo $history['comment'];?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
  <?php } ?>
  <div class="buttons">
    <div class="right"><a href="<?php echo $continue;?>" class="button"><?php echo $button_continue;?></a></div>
  </div>
  </div> -->
<?php echo $footer;?> 