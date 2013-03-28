<link rel="stylesheet" type="text/css" href="view/stylesheet/general.css">
<link rel="stylesheet" type="text/css" href="view/stylesheet/main.css">
<script type="text/javascript" src="view/javascript/jquery/jquery-1.7.1.min.js"></script><!--这里只能用1.7.1的版本,否则自带的图片处理有问题-->
<script type="text/javascript" src="view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
<link type="text/css" href="view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
<script type="text/javascript" src="view/javascript/jquery/tabs.js"></script>

    <h1><img src="view/image/customer.png" alt="" /> <?php echo $heading_title;?>
        <span class="action-span">
		     <a href="javascript:;" onclick="$('#form').submit();" class="button"><?php echo $button_save;?></a>
			 <a href = "<?php echo $cancel;?>" class="button"><?php echo $button_cancel;?></a>
		</span>
    </h1>
    <div class="list-div" id="listDiv">
      <form action="<?php echo $action;?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $entry_name;?></td>
            <td>
              <input type="text" name="customer_group_description[name]" value="<?php if(isset($customer_group_description['name'])) { ?><?php echo $customer_group_description['name'];?><?php } ?>" />
              
              <?php if(isset($error_name)) { ?>
              <span class="error"><?php echo $error_name;?></span><br />
              <?php } ?>
             </td>
          </tr>
         
          <tr>
            <td><?php echo $entry_description;?></td>
            <td><textarea name="customer_group_description[description]" cols="40" rows="5"><?php if(isset($customer_group_description['description'])) { ?> <?php echo $customer_group_description['description'];?><?php } ?></textarea>
              
          </tr>
         
          <tr>
            <td><?php echo $entry_approval;?></td>
            <td><?php if($approval) { ?>
              <input type="radio" name="approval" value="1" checked="checked" />
              <?php echo $text_yes;?>
              <input type="radio" name="approval" value="0" />
              <?php echo $text_no;?>
               <?php } else { ?>
              <input type="radio" name="approval" value="1" />
              <?php echo $text_yes;?>
              <input type="radio" name="approval" value="0" checked="checked" />
              <?php echo $text_no;?>
              <?php } ?></td>
          </tr>
         
         
          
          <tr>
            <td><?php echo $entry_sort_order;?></td>
            <td><input type="text" name="sort_order" value="<?php echo $sort_order;?>" size="10" /></td>
          </tr>
        </table>
      </form>
    </div>
