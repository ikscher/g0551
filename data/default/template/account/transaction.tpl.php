<?php echo $header;?>
<!--个人中心body_begin-->
<div class="mainContent clear">
 	<!--左侧begin-->
	<?php echo $left;?>
 	<!--左侧end-->
    <!--右侧begin-->
	<div class="right">
	    <div class="account_box">
		     <div class="ac_bgs clearfix">
                    <div class="ac_t_l"><?php echo $heading_title;?></div>
                    <div class="ac_t_r">
                        <div class="ac_t_l_s"><img src="catalog/view/theme/default/image/member/pic_account_title_010.gif" /></div>
							<div class="account_contianer">
								<h4 class="line"><?php echo $heading_title;?></h4>
								<div class="line_bot list">
									
									    <table width="720" border="0" align="center" cellpadding="0" cellspacing="0" >
											<thead>
											  <tr>
												<td width="20%" align="center" bgcolor="#F5EDE2" class="itemTitle"><?php echo $column_date_added;?></td>
												<td width="20%" align="center" bgcolor="#F5EDE2" class="itemTitle"><?php echo $column_description;?></td>
												<td width="20%" align="center" bgcolor="#F5EDE2" class="itemTitle"><?php echo $column_amount;?></td>
											  </tr>
											</thead>
											<tbody>
											  <?php if($transactions) { ?>
												  <?php foreach((array)$transactions as $transaction) {?>
												  <tr>
													<td align="center" bgcolor="#FFFFFF"><?php echo $transaction['date_added'];?></td>
													<td align="center" bgcolor="#FFFFFF"><?php echo $transaction['description'];?></td>
													<td align="center" bgcolor="#FFFFFF"><?php echo $transaction['amount'];?></td>
												  </tr>
												  <?php } ?>
												  <tr class="pagination"><td colspan="3" align="right"><?php echo $pagination;?></td></tr>
											  <?php } else { ?>
												  <tr>
													<td colspan="3" align="center" bgcolor="#FFFFFF"><?php echo $text_empty;?></td>
												  </tr>
											  <?php } ?>
											</tbody>
									    </table>
									    <div class="pagination"><?php echo $pagination;?></div>
									    <div class="buttons">
										    <a href="<?php echo $continue;?>"  class="button"><img src="catalog/view/theme/default/image/goon.gif" /></a>
									    </div>
							    </div>
							</div>
					    </div>
			    </div>
		</div>
	</div>
	
</div>
<?php echo $footer;?>