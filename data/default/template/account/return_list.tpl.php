<?php echo $header;?>
<!--个人中心body_begin-->
<div class="mainContent clear">
 	<!--左侧begin-->
	<?php echo $left;?>
 	<!--左侧end-->
    <!--右侧begin-->
	<div class="right">
         <!--商品退换-->
        	<div class="account_box">
            	<div class="ac_bgs clearfix">
                    <div class="ac_t_l">商品退换</div>
                    <div class="ac_t_r">
                        <div class="ac_t_l_s"><img src="catalog/view/theme/default/image/member/pic_account_title_09.gif" /></div>
                        <div class="account_contianer">
                        	<h4 class="line">退换货申请</h4>
                            <div class="line_bot">
								<div class="list">
								
								<!-- <form action="<?php echo $orderquery;?>" method="post" >
								<table width="720" border="0" align="center" cellpadding="0" cellspacing="0"class="nostyle">
								  <tr>
									<td width="70">订单编号：</td>
									<td width="180"><input name="orderno" type="text" size="22" class="searchInput" /></td>
									<td><input type="submit" class="p_btn_i float_l" style="margin-left:5px;"   value="查&nbsp;询" /></td>
								  </tr>
								</table>
								</form> -->
								
								<table width="720" border="0" align="center" cellspacing="1" class="ordercontent">
								  
								  <thead>
									<td width="20%" align="center" bgcolor="#F5EDE2" class="itemTitle">退换号</td>
									<td width="20%" align="center" bgcolor="#F5EDE2" class="itemTitle">状态</td>
									<td width="15%" align="center" bgcolor="#F5EDE2" class="itemTitle">新增日期</td>
									<td width="20%" align="center" bgcolor="#F5EDE2" class="itemTitle">订单号</td>
									<td align="center" bgcolor="#F5EDE2" class="itemTitle">操作</td>
								  </thead>
								  <tbody>
								  <?php if($returns) { ?>
	                                    <?php foreach((array)$returns as $return) {?>
										  <tr bgcolor="#F6F6F6">
											<td align="center" bgcolor="#FFFFFF"><?php echo $return['return_id'];?></td>
											<td align="center" bgcolor="#FFFFFF">￥<?php echo $return['status'];?></td>
											<td align="center" bgcolor="#FFFFFF"><?php echo $return['date_added'];?></td>
											<td align="center" bgcolor="#FFFFFF"><?php echo $return['order_id'];?></td>
											<td align="center" bgcolor="#FFFFFF"><a href="<?php echo $return['href'];?>"><img src="catalog/view/theme/default/image/info.png" alt="<?php echo $button_view;?>" title="<?php echo $button_view;?>" /></a></td>
										  </tr>
								       <?php } ?>
										 <tr class="pagination"><td colspan="5" align="right"><?php echo $pagination;?></td></tr>
								   <?php } else { ?>
									   <tr class="content"><td colspan="5" align='center'><?php echo $text_empty;?></td></tr>
					
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
    </div>
</div>
<!--
<div id="content">
  <div class="breadcrumb">
    <?php foreach((array)$breadcrumbs as $breadcrumb) {?>
    <?php echo $breadcrumb['separator'];?><a href="<?php echo $breadcrumb['href'];?>"><?php echo $breadcrumb['text'];?></a>
    <?php } ?>
  </div>
  <h1><?php echo $heading_title;?></h1>
  <?php if($returns) { ?>
	  <?php foreach((array)$returns as $return) {?>
	  <div class="return-list">
		<div class="return-id"><b><?php echo $text_return_id;?></b> #<?php echo $return['return_id'];?></div>
		<div class="return-status"><b><?php echo $text_status;?></b> <?php echo $return['status'];?></div>
		<div class="return-content">
		  <div><b><?php echo $text_date_added;?></b> <?php echo $return['date_added'];?><br />
			<b><?php echo $text_order_id;?></b> <?php echo $return['order_id'];?></div>
		  <div><b><?php echo $text_customer;?></b> <?php echo $return['name'];?></div>
		  <div class="return-info"><a href="<?php echo $return['href'];?>"><img src="catalog/view/theme/default/image/info.png" alt="<?php echo $button_view;?>" title="<?php echo $button_view;?>" /></a></div>
		</div>
	  </div>
	  <?php } ?>
	  <div class="pagination"><?php echo $pagination;?></div>
   <?php } else { ?>
      <div class="content"><?php echo $text_empty;?></div>
  <?php } ?>
  <div class="buttons">
    <div class="right"><a href="<?php echo $continue;?>" class="button"><?php echo $button_continue;?></a></div>
  </div>
  </div>
-->
<?php echo $footer;?>