<link rel="stylesheet" type="text/css" href="view/stylesheet/general.css">
<link rel="stylesheet" type="text/css" href="view/stylesheet/main.css">
<script type="text/javascript" src="view/javascript/jquery/jquery-1.7.1.min.js"></script><!--这里只能用1.7.1的版本,否则自带的图片处理有问题-->
<script type="text/javascript" src="view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
<link type="text/css" href="view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />

    <h1><img src="view/image/order.png" alt="" /> <?php echo $heading_title;?>
        <span class="action-span"><a href="javascript:;" onclick="$('#form').submit();" class="button"><?php echo $button_save;?></a></span>
		<span class="action-span"><a href="<?php echo $cancel;?>"><?php echo $button_cancel;?></a></span>
    </h1>
    <div class="list-div" id="listDiv">
      <form action="<?php echo $action;?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $entry_name;?></td>
            <td>
              <input type="text" name="order_status[name]" value="<?php if(isset($order_status['name'])) { ?> <?php echo $order_status['name'];?> <?php } ?>" />
              <br />
              <?php if(isset($error_name)) { ?> 
              <span class="error"><?php echo $error_name?></span><br />
              <?php } ?>
              </td>
          </tr>
        </table>
      </form>
    </div>