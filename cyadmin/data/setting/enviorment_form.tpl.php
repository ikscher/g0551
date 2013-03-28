<link rel="stylesheet" type="text/css" href="view/stylesheet/general.css">
<link rel="stylesheet" type="text/css" href="view/stylesheet/main.css">
<script type="text/javascript" src="view/javascript/jquery/jquery-1.7.1.min.js"></script>

<!-- <?php if(isset($error_warning)) { ?><?php echo $error_warning;?><?php } ?> -->
    <h1><img src="view/image/setting.png" alt="" /> <?php echo $heading_title;?>
        <span class="action-span">
		    <a href="javascript:;" onclick="$('#form').submit();" class="button"><?php echo $button_save;?></a>
			<a href="<?php echo $cancel;?>" class="button"><?php echo $button_cancel;?></a> 
		</span>
    </h1>
	
    <div class="list-div" id="listDiv">
      <!-- <div id="tabs" class="htabs"><a href="#tab-general"><?php echo $tab_general;?></a><a href="#tab-store"><?php echo $tab_store;?></a><a href="#tab-local"><?php echo $tab_local;?></a><a href="#tab-option"><?php echo $tab_option;?></a><a href="#tab-image"><?php echo $tab_image;?></a><a href="#tab-server"><?php echo $tab_server;?></a></div> -->
      <form action="<?php echo $action;?>" method="post" enctype="multipart/form-data" id="form">
        <div id="tab-general">
            <table class="form">
		    
				<tr>
				  <td><span class="required">*</span> ID</td>
				  <td><input type="text" name="setting_id" value="<?php if(isset($enviorment['setting_id'])) { ?><?php echo $enviorment['setting_id'];?><?php } ?>" readonly size="15" />
				</tr>
				<tr>
				  <td><span class="required">*</span> <?php echo $column_group;?></td>
				  <td><input type="text" name="group" value="<?php if(isset($enviorment['group'])) { ?><?php echo $enviorment['group'];?><?php } ?>" size="50" /><?php if($error_group) { ?>
					<span class="error"><?php echo $error_group;?>
					 <?php } ?></td>
				</tr>
				<tr>
				  <td><?php echo $column_key;?></td>
				  <td><input type="text" name="key" value="<?php if(isset($enviorment['key'])) { ?><?php echo $enviorment['key'];?><?php } ?>" size="40" /><?php if($error_key) { ?>
					<span class="error"><?php echo $error_key;?></span>
					 <?php } ?></td>
				</tr>
				
				
				<tr>
				  <td><span class="required">*</span> <?php echo $column_value;?></td>
				  <td><textarea name="val" rows="5" cols="40"> <?php if(isset($enviorment['value'])) { ?><?php echo $enviorment['value'];?><?php } ?></textarea><?php if($error_value) { ?>
					<span class="error"><?php echo $error_value;?></span>
					 <?php } ?></span>
					  </td>
					
				</tr>
				
				
				<tr>
				  <td><span class="required">*</span> <?php echo $column_serialized;?></td>
				  <td>
				        <select name="serial">
							<option <?php if(isset($enviorment['serialized']) && $enviorment['serialized']==0) { ?>selected="selected"<?php } ?> value="0">否</option>
							<option <?php if(isset($enviorment['serialized']) &&  $enviorment['serialized']==1) { ?>selected="selected"<?php } ?> value="1">是</option>
					    </select>
				</tr>
				
			
            </table>
        </div>
       
       
        
       
      </form>
    </div>
