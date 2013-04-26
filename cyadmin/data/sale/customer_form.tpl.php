<link rel="stylesheet" type="text/css" href="view/stylesheet/general.css">
<link rel="stylesheet" type="text/css" href="view/stylesheet/main.css">
<script type="text/javascript" src="view/javascript/jquery/jquery-1.7.1.min.js"></script><!--这里只能用1.7.1的版本,否则自带的图片处理有问题-->
<script type="text/javascript" src="view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="view/javascript/jquery/tabs.js"></script>
<link type="text/css" href="view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />

    <h1><img src="view/image/customer.png" alt="" /> <?php echo $heading_title;?>
        <span class="action-span">
		    <a href="javascript:;" onclick="$('#form').submit();" class="button"><?php echo $button_save;?></a>
		   <a href="<?php echo $cancel;?>" class="button"><?php echo $button_cancel;?></a> 
		</span>
    </h1>
    <div class="list-div" id="listDiv">
      
      <form action="<?php echo $action;?>" method="post" enctype="multipart/form-data" id="form">
        <div id="tab-general">
          <div id="vtabs" class="vtabs"><a href="#tab-customer"><?php echo $tab_general;?></a>
            <?php $address_row = 1?>
            <?php foreach((array)$addresses as $address) {?>
            <a href="#tab-address-<?php echo $address_row;?>" id="address-<?php echo $address_row;?>"><?php echo $tab_address . ' ' . $address_row?>&nbsp;<img src="view/image/delete.png" alt="" onclick="$('#vtabs a:first').trigger('click'); $('#address-<?php echo $address_row;?>').remove(); $('#tab-address-<?php echo $address_row;?>').remove(); return false;" /></a>
            <?php $address_row++?>
            <?php } ?>
            <span id="address-add"><?php echo $button_add_address;?>&nbsp;<img src="view/image/add.png" alt="" onclick="addAddress();" /></span></div>
          <div id="tab-customer" class="vtabs-content">
            <table class="form">
              <tr>
                <td><span class="required">*</span> <?php echo $entry_username;?></td>
                <td><input type="text" name="username" value="<?php echo $username;?>" />
                  <?php if($error_username) { ?>
                  <span class="error"><?php echo $error_username;?></span>
                  <?php } ?></td>
              </tr>
          
              <tr>
                <td><span class="required">*</span> <?php echo $entry_email;?></td>
                <td><input type="text" name="email" value="<?php echo $email;?>" />
                  <?php if($error_email) { ?>
                  <span class="error"><?php echo $error_email;?></span>
                  <?php } ?></td>
              </tr>
              <tr>
                <td><span class="required">*</span> <?php echo $entry_telphone;?></td>
                <td><input type="text" name="telphone" value="<?php echo $telphone;?>" />
                  <?php if($error_telphone) { ?>
                  <span class="error"><?php echo $error_telphone;?></span>
                  <?php } ?></td>
              </tr>
              <tr>
                <td><?php echo $entry_mobile;?></td>
                <td><input type="text" name="mobile" value="<?php echo $mobile;?>" /></td>
              </tr>
              <tr>
                <td><?php echo $entry_password;?></td>
                <td><input type="password" name="password" value="<?php echo $password;?>"  />
                  <br />
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
                <td><?php echo $entry_newsletter;?></td>
                <td><select name="newsletter">
                    <?php if($newsletter) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled;?></option>
                    <option value="0"><?php echo $text_disabled;?></option>
                     <?php } else { ?>
                    <option value="1"><?php echo $text_enabled;?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled;?></option>
                    <?php } ?>
                  </select></td>
              </tr>
              <tr>
                <td><?php echo $entry_customer_group;?></td>
                <td><select name="customer_group_id">
                    <?php foreach((array)$customer_groups as $customer_group) {?>
                    <?php if($customer_group['customer_group_id'] == $customer_group_id) { ?>
                    <option value="<?php echo $customer_group['customer_group_id'];?>" selected="selected"><?php echo $customer_group['name'];?></option>
                     <?php } else { ?>
                    <option value="<?php echo $customer_group['customer_group_id'];?>"><?php echo $customer_group['name'];?></option>
                    <?php } ?>
                    <?php } ?>
                  </select></td>
              </tr>
              <tr>
                <td><?php echo $entry_status;?></td>
                <td><select name="status">
                    <?php if($status) { ?>
                    <option value="1" selected="selected"><?php echo $text_open;?></option>
                    <option value="0"><?php echo $text_lock;?></option>
                     <?php } else { ?>
                    <option value="1"><?php echo $text_open;?></option>
                    <option value="0" selected="selected"><?php echo $text_lock;?></option>
                   <?php } ?>
                  </select></td>
              </tr>
            </table>
          </div>
		  
		  
         <?php $address_row = 1?>
          <?php foreach((array)$addresses as $address) {?>
          <div id="tab-address-<?php echo $address_row;?>" class="vtabs-content">
            <input type="hidden" name="address[<?php echo $address_row;?>][address_id]" value="<?php echo $address['address_id'];?>" />
            <table class="form">
              <tr>
                <td><span class="required">*</span> <?php echo $entry_username;?></td>
                <td><input type="text" name="address[<?php echo $address_row;?>][username]" value="<?php echo $address['username'];?>" />
                  <?php if(isset($error_address_username[$address_row])) { ?>
                  <span class="error"><?php echo $error_address_username[$address_row]?></span>
                  <?php } ?></td>
              </tr>
             
              
              <tr>
                <td><span class="required">*</span> <?php echo $entry_address;?></td>
                <td><input type="text" name="address[<?php echo $address_row;?>][address]" value="<?php echo $address['address'];?>" />
                  <?php if(isset($error_address_address[$address_row])) { ?>
                  <span class="error"><?php echo $error_address_address[$address_row]?></span>
                  <?php } ?></td>
              </tr>
			  
			   <tr>
                <td><span class="required">*</span> <?php echo $entry_telphone;?></td>
                <td><input type="text" name="address[<?php echo $address_row;?>][telphone]" value="<?php echo $address['telphone'];?>" />
                  <?php if(isset($error_address_telphone[$address_row])) { ?>
                  <span class="error"><?php echo $error_address_telphone[$address_row]?></span>
                  <?php } ?></td>
              </tr>
			  
			   <tr>
                <td><span class="required">*</span> <?php echo $entry_mobile;?></td>
                <td><input type="text" name="address[<?php echo $address_row;?>][mobile]" value="<?php echo $address['mobile'];?>" />
                  <?php if(isset($error_address_mobile[$address_row])) { ?>
                  <span class="error"><?php echo $error_address_mobile[$address_row]?></span>
                  <?php } ?></td>
              </tr>
             
            
              <tr>
                <td><span id="postcode-required<?php echo $address_row;?>" class="required">*</span> <?php echo $entry_postcode;?></td>
                <td><input type="text" name="address[<?php echo $address_row;?>][postcode]" value="<?php echo $address['postcode'];?>" /></td>
              </tr>
             
              <tr>
                <td><?php echo $entry_default;?></td>
                <td><?php if($address['address_id'] == $address_id || !$addresses) { ?>
                  <input type="radio" name="address[<?php echo $address_row;?>][default]" value="1" checked="checked" /></td>
                 <?php } else { ?>
                <input type="radio" name="address[<?php echo $address_row;?>][default]" value="0" />
                  </td>
                <?php } ?>
              </tr>
            </table>
          </div>
          <?php $address_row++?>
         <?php } ?>
        </div>
		
       
       
      </form>
    </div>
  </div>
</div>


<script type="text/javascript"><!--
var address_row = <?php echo $address_row;?>;

function addAddress() {	
	html  = '<div id="tab-address-' + address_row + '" class="vtabs-content" style="display: none;">';
	html += '  <input type="hidden" name="address[' + address_row + '][address_id]" value="" />';
	html += '  <table class="form">'; 
	html += '    <tr>';
    html += '	   <td><span class="required">*</span> <?php echo $entry_username;?></td>';
    html += '	   <td><input type="text" name="address[' + address_row + '][username]" value="" /></td>';
    html += '    </tr>';

    html += '    <tr>';
    html += '      <td><?php echo $entry_telphone;?></td>';
    html += '      <td><input type="text" name="address[' + address_row + '][telphone]" value="" /></td>';
    html += '    </tr>';	

			
    html += '    <tr>';
    html += '      <td><span class="required">*</span> <?php echo $entry_address;?></td>';
    html += '      <td><input type="text" name="address[' + address_row + '][address]" value="" /></td>';
    html += '    </tr>';
   
    html += '    <tr>';
    html += '      <td><span class="required">*</span> <?php echo $entry_mobile;?></td>';
    html += '      <td><input type="text" name="address[' + address_row + '][mobile]" value="" /></td>';
    html += '    </tr>';
    html += '    <tr>';
    html += '      <td><span id="postcode-required' + address_row + '" class="required">*</span> <?php echo $entry_postcode;?></td>';
    html += '      <td><input type="text" name="address[' + address_row + '][postcode]" value="" /></td>';
    html += '    </tr>';

  
	html += '    <tr>';
    html += '      <td><?php echo $entry_default;?></td>';
    html += '      <td><input type="radio" name="address[' + address_row + '][default]" value="1" checked="checked"/></td>';
    html += '    </tr>';
    html += '  </table>';
    html += '</div>';
	
	$('#tab-general').append(html);
	
	//$('select[name=\'address[' + address_row + '][country_id]\']').trigger('change');	
	
	$('#address-add').before('<a href="#tab-address-' + address_row + '" id="address-' + address_row + '"><?php echo $tab_address;?> ' + address_row + '&nbsp;<img src="view/image/delete.png" alt="" onclick="$(\'#vtabs a:first\').trigger(\'click\'); $(\'#address-' + address_row + '\').remove(); $(\'#tab-address-' + address_row + '\').remove(); return false;" /></a>');
		 
	$('.vtabs a').tabpages();
	
	$('#address-' + address_row).trigger('click');
	
	address_row++;
}
//--></script> 

<script type="text/javascript"><!--

/*
function addBlacklist(ip) {
	$.ajax({
		url: 'index.php?route=sale/customer/addblacklist&token=<?php echo $token;?>',
		type: 'post',
		dataType: 'json',
		data: 'ip=' + encodeURIComponent(ip),
		beforeSend: function() {
			$('.success, .warning').remove();
			
			$('.box').before('<div class="attention"><img src="view/image/loading.gif" alt="" /> Please wait!</div>');			
		},
		complete: function() {
			$('.attention').remove();
		},			
		success: function(json) {
			if (json['error']) {
				 $('.box').before('<div class="warning" style="display: none;">' + json['error'] + '</div>');
				
				$('.warning').fadeIn('slow');
			}
						
			if (json['success']) {
                $('.box').before('<div class="success" style="display: none;">' + json['success'] + '</div>');
				
				$('.success').fadeIn('slow');
				
				$('#' + ip.replace(/\./g, '-')).replaceWith('<a id="' + ip.replace(/\./g, '-') + '" onclick="removeBlacklist(\'' + ip + '\');"><?php echo $text_remove_blacklist;?></a>');
			}
		}
	});	
}

function removeBlacklist(ip) {
	$.ajax({
		url: 'index.php?route=sale/customer/removeblacklist&token=<?php echo $token;?>',
		type: 'post',
		dataType: 'json',
		data: 'ip=' + encodeURIComponent(ip),
		beforeSend: function() {
			$('.success, .warning').remove();
			
			$('.box').before('<div class="attention"><img src="view/image/loading.gif" alt="" /> Please wait!</div>');				
		},
		complete: function() {
			$('.attention').remove();
		},			
		success: function(json) {
			if (json['error']) {
				 $('.box').before('<div class="warning" style="display: none;">' + json['error'] + '</div>');
				
				$('.warning').fadeIn('slow');
			}
			
			if (json['success']) {
				 $('.box').before('<div class="success" style="display: none;">' + json['success'] + '</div>');
				
				$('.success').fadeIn('slow');
				
				$('#' + ip.replace(/\./g, '-')).replaceWith('<a id="' + ip.replace(/\./g, '-') + '" onclick="addBlacklist(\'' + ip + '\');"><?php echo $text_add_blacklist;?></a>');
			}
		}
	});	
};
*/
//--></script> 
<script type="text/javascript"><!--
$('.htabs a').tabpages();
$('.vtabs a').tabpages();
//--></script> 