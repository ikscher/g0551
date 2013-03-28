<link rel="stylesheet" type="text/css" href="view/stylesheet/general.css">
<link rel="stylesheet" type="text/css" href="view/stylesheet/main.css">
<script type="text/javascript" src="view/javascript/jquery/jquery-1.7.1.min.js"></script>

    <h1><img src="view/image/user.png" alt="" /> <?php echo $heading_title;?>
        <span class="action-span">
		    <a href='javascript:void(0)' onclick="$('#form').submit();" class="button"><?php echo $button_save;?></a>
			<a href='javascript:void(0)' onclick="location = '<?php echo $cancel;?>';" class="button"><?php echo $button_cancel;?></a> 
		</span>
    </h1>
	
    <div class="list-div" id="listDiv">
      <form action="<?php echo $action;?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $column_navcode;?></td>
            <td><input type="text" name="navcode" value="<?php echo $navcode;?>" />
              <?php if($error_navcode) { ?>
              <span class="error"><?php echo $error_navcode;?></span>
              <?php } ?></td> 
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $column_navdesc;?></td>
            <td><input type="text" name="navdesc" value="<?php echo $navdesc;?>" />
             <?php if($error_navdesc) { ?>
              <span class="error"><?php echo $error_navdesc;?></span>
             <?php } ?></td> 
          </tr>
         
          <tr>
            <td><?php echo $column_actioncode;?></td>
            <td><input type="text" name="actioncode" value="<?php echo $actioncode;?>" />
			<?php if($error_actioncode) { ?>
              <span class="error"><?php echo $error_actioncode;?></span>
             <?php } ?>
			</td>
          </tr>
          
          <tr>
            <td><?php echo $column_actiondesc;?></td>
            <td><input type="text" name="actiondesc" value="<?php echo $actiondesc;?>"  />
			<?php if($error_actiondesc) { ?>
              <span class="error"><?php echo $error_actiondesc;?></span>
             <?php } ?>
			</td>
          </tr>
          
          
        </table>
      </form>
    </div>