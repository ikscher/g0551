<?php echo $header;?>
<!--个人中心body_begin-->
<div class="mainContent clear">
 	<!--左侧begin-->
	<?php echo $left;?>
 	<!--左侧end-->
    <!--右侧begin-->
	<div class="right">
         <!--my subscription-->
        	<div class="account_box">
			    <div class="ac_bgs clearfix">
                    <div class="ac_t_l">我的订阅</div>
                    <div class="ac_t_r">
                        <div class="ac_t_l_s"><img src="catalog/view/theme/default/image/member/pic_account_title_011.gif" /></div>
                        <div class="account_contianer">
                        	<h4 class="line">订阅本站最新动态 &nbsp;&nbsp;&nbsp;&nbsp;<span ><?php if(isset($success)) { ?><?php echo $success;?><?php } ?></span></h4>
                            <div class="line_bot">
								<div class="content">
								<!--个人设置-->
								<form action="<?php echo $action;?>" method="post" enctype="multipart/form-data">
									 <table class="form" width="650">
										<tr>
										  <td align="right"><?php echo $entry_newsletter;?></td>
										  <td><?php if($newsletter) { ?><label for="sbcp1"><input type="radio" id="sbcp1" name="newsletter" value="1" checked="checked" />
											是&nbsp;</label>
											<label for="sbcp2"><input type="radio" id="sbcp2" name="newsletter" value="0"  />
											否            </label></td>
											 <?php } else { ?>
											 <label for="sbcp1"><input type="radio" id="sbcp1" name="newsletter" value="1" />
											是&nbsp;</label>
											<label for="sbcp2"><input type="radio" id="sbcp2" name="newsletter" value="0" checked="checked" />
											否            </label></td>
											<?php } ?>
										</tr>
										<tr>
										  <td align="right"><!-- <a href="<?php echo $back;?>" class="button"><img src="catalog/view/theme/default/image/cancel.gif" /></a> --></td>
										  
										  <td><input class="p_btn_s" type="submit" value="我要订阅" /></td>
										</tr>
									  </table>
								  </form>
								<!--个人设置结束-->
								</div>
							</div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end-->
		 
    </div>
</div>
<?php echo $footer;?>




<!-- <?php echo $header;?><?php echo $column_left;?><?php echo $column_right;?>
<div id="content"><?php echo $content_top;?>
  <div class="breadcrumb">
    <?php foreach((array)$breadcrumbs as $breadcrumb) {?>
    <?php echo $breadcrumb['separator'];?><a href="<?php echo $breadcrumb['href'];?>"><?php echo $breadcrumb['text'];?></a>
    <?php } ?>
  </div>
  <h1><?php echo $heading_title;?></h1>
  <form action="<?php echo $action;?>" method="post" enctype="multipart/form-data">
    <div class="content">
      <table class="form">
        <tr>
          <td><?php echo $entry_newsletter;?></td>
          <td><?php if($newsletter) { ?>
            <input type="radio" name="newsletter" value="1" checked="checked" />
            <?php echo $text_yes;?>&nbsp;
            <input type="radio" name="newsletter" value="0" />
            <?php echo $text_no;?>
             <?php } else { ?>
            <input type="radio" name="newsletter" value="1" />
            <?php echo $text_yes;?>&nbsp;
            <input type="radio" name="newsletter" value="0" checked="checked" />
            <?php echo $text_no;?>
            <?php } ?></td>
        </tr>
      </table>
    </div>
    <div class="buttons">
      <div class="left"><a href="<?php echo $back;?>" class="button"><?php echo $button_back;?></a></div>
      <div class="right"><input type="submit" value="<?php echo $button_continue;?>" class="button" /></div>
    </div>
  </form>
  <?php echo $content_bottom;?></div>
<?php echo $footer;?> -->