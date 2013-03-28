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
            <td><span class="required">*</span> <?php echo $entry_username;?></td>
            <td><input type="text" name="username" value="<?php echo $username;?>" />
              <?php if($error_username) { ?>
              <span class="error"><?php echo $error_username;?></span>
              <?php } ?></td>
          </tr>
         <!--  <tr>
            <td><span class="required">*</span> <?php echo $entry_firstname;?></td>
            <td><input type="text" name="firstname" value="<?php echo $firstname;?>" />
              <?php if($error_firstname) { ?>
              <span class="error"><?php echo $error_firstname;?></span>
             <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_lastname;?></td>
            <td><input type="text" name="lastname" value="<?php echo $lastname;?>" />
              <?php if($error_lastname) { ?>
              <span class="error"><?php echo $error_lastname;?></span>
              <?php } ?></td>
          </tr> -->
          <tr>
            <td><?php echo $entry_email;?></td>
            <td><input type="text" name="email" value="<?php echo $email;?>" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_user_group;?></td>
            <td><select name="user_group_id">
                <?php foreach((array)$user_groups as $user_group) {?>
                <?php if($user_group['user_group_id'] == $user_group_id) { ?>
                <option value="<?php echo $user_group['user_group_id'];?>" selected="selected"><?php echo $user_group['name'];?></option>
                 <?php } else { ?>
                <option value="<?php echo $user_group['user_group_id'];?>"><?php echo $user_group['name'];?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_password;?></td>
            <td><input type="password" name="password" value="<?php echo $password;?>"  />
              <?php if($error_password) { ?>
              <span class="error"><?php echo $error_password;?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_confirm;?></td>
            <td><input type="password" name="confirm" value="<?php echo $confirm;?>" />
              <?php if($error_confirm) { ?>
              <span class="error"><?php echo $error_confirm;?></span>
             <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_status;?></td>
            <td><select name="status">
                <?php if($status) { ?>
                <option value="0"><?php echo $text_disabled;?></option>
                <option value="1" selected="selected"><?php echo $text_enabled;?></option>
                 <?php } else { ?>
                <option value="0" selected="selected"><?php echo $text_disabled;?></option>
                <option value="1"><?php echo $text_enabled;?></option>
               <?php } ?>
              </select></td>
          </tr>
        </table>
      </form>
    </div>