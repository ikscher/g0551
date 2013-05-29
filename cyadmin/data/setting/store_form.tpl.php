<link rel="stylesheet" type="text/css" href="view/stylesheet/general.css">
<link rel="stylesheet" type="text/css" href="view/stylesheet/main.css">
<script type="text/javascript" src="view/javascript/jquery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
<link type="text/css" href="view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />

    <h1><img src="view/image/setting.png" alt="" /> 商城设置
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
				  <td><span class="required">*</span> 店铺名称</td>
				  <td><input type="text" name="name" value="<?php if(isset($store['name'])) { ?><?php echo $store['name'];?><?php } ?>" size="80" /><a  class="simulate_login" href="javascript:void(0);">模拟登录</a><?php if($error_storename) { ?>
					<span class="error"><?php echo $error_storename;?></span>
					 <?php } ?></td></td>
				</tr>
				<tr>
				  <td>简称</td>
				  <td><input type="text" name="shortname" value="<?php if(isset($store['shortname'])) { ?><?php echo $store['shortname'];?><?php } ?>" size="50" /></td>
				</tr>
				<tr>
				  <td>店主</td>
				  <td><input type="text" name="owner" value="<?php if(isset($store['owner'])) { ?><?php echo $store['owner'];?><?php } ?>" size="40" /></td>
				</tr>
				
				<tr>
				  <td>logo</td>
				  <td>
				     <div class="image">
					    <img src="<?php if(isset($store['imageUrl'])) { ?><?php echo $store['imageUrl'];?><?php } ?>" alt="" id="thumb" /><br />
                        <input type="hidden" name="logo" value="<?php if(isset($store['logo'])) { ?><?php echo $store['logo'];?><?php } ?>" id="logo" />
                        <a href="javascript:;" onclick="image_upload('logo', 'thumb');"><?php echo $text_browse;?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a  href="javascript:;" onclick="$('#thumb').attr('src', '<?php echo $no_image;?>'); $('#logo').attr('value', '');"><?php echo $text_clear;?></a>
					</div></td>
				</tr>
				
				<tr>
				  <td><span class="required">*</span> 电话</td>
				  <td><input type="text" name="telphone" value="<?php if(isset($store['tel'])) { ?><?php echo $store['tel'];?><?php } ?>" size="40" /><?php if($error_telphone) { ?>
					<span class="error"><?php echo $error_telphone;?></span>
					 <?php } ?></td>
				</tr>
				<tr>
				  <td><span class="required">*</span> 手机</td>
				  <td><input type="text" name="mobile" value="<?php if(isset($store['mobile'])) { ?><?php echo $store['mobile'];?><?php } ?>" size="40" /><?php if($error_mobile) { ?>
					<span class="error"><?php echo $error_mobile;?></span>
					 <?php } ?></td>
				</tr>
				
				<tr>
				  <td><span class="required">*</span> email</td>
				  <td><input type="text" name="email" value="<?php if(isset($store['email'])) { ?><?php echo $store['email'];?><?php } ?>" size="40" disabled /></td>
				</tr>
				
				<tr><td>传真</td>
				  <td><input type="text" name="fax" value="<?php if(isset($store['fax'])) { ?><?php echo $store['fax'];?><?php } ?>" /></td>
				</tr>
				<tr>
				  <td><span class="required">*</span> 地址</td>
				  <td><input name="address" type="text" value="<?php if(isset($store['address'])) { ?><?php echo $store['address'];?><?php } ?>" />
					<?php if($error_address) { ?>
					<span class="error"><?php echo $error_address;?></span>
					 <?php } ?></td>
				</tr>
				<tr>
				  <td><span class="required">*</span> 简介</td>
				  <td><textarea name="introduce" rows="5" cols="40"> <?php if(isset($store['introduce'])) { ?><?php echo $store['introduce'];?><?php } ?></textarea><?php if($error_introduce) { ?>
					<span class="error"><?php echo $error_introduce;?></span>
					 <?php } ?></td>
					
				</tr>
				<tr>
				  <td><span class="required">*</span> 开店时间</td>
				  <td><input type="text" name="createtime" value="<?php if(isset($store['createtime'])) { ?><?php echo $store['createtime'];?><?php } ?>"  size="20" disabled/></td>
				</tr>
				
				<tr>
				  <td>宝贝数量</td>
				  <td><input type="text" name="quantity" value="<?php if(isset($store['quantity'])) { ?><?php echo $store['quantity'];?><?php } ?>" /></td>
				</tr>
				
				<tr>
				  <td>售出数量</td>
				  <td><input type="text" name="soldnum" value="<?php if(isset($store['soldnum'])) { ?><?php echo $store['soldnum'];?><?php } ?>" /></td>
				</tr>
				
				<tr>
				  <td><span class="required">*</span> 是否在用</td>
				  <td>
				        <select name="status">
					        <option <?php if(isset($store['status']) && $store['status']==1) { ?>selected="selected"<?php } ?> value="1">在用</option>
							<option <?php if(isset($store['status']) && $store['status']==0) { ?>selected="selected"<?php } ?> value="0">停用</option>
					    </select>
				</tr>
				
				<tr>
				  <td><span class="required">*</span> 审核</td>
				  <td>
				        <select name="hasShop">
							<option <?php if(isset($store['hasShop']) && $store['hasShop']==0) { ?>selected="selected"<?php } ?> value="0">封锁</option>
							<option <?php if(isset($store['hasShop']) && $store['hasShop']==1) { ?>selected="selected"<?php } ?> value="1">开通</option>
					    </select>
				</tr>
				
			
            </table>
        </div>
       
       
        
       
      </form>
    </div>

<script type="text/javascript" src="view/javascript/jquery/ui/jquery-ui-timepicker-addon.js"></script> 
<script type="text/javascript"><!--
$('.date').datetimepicker({dateFormat: 'yy-mm-dd'});
$('.datetime').datetimepicker({
	dateFormat: 'yy-mm-dd',
	timeFormat: 'h:m'
});
//--></script> 

<script type="text/javascript"><!--
function image_upload(field, thumb) {
	$('#dialog').remove();
	
	$('#listDiv').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token;?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
	
	$('#dialog').dialog({
		title: '<?php echo $text_image_manager;?>',
		close: function (event, ui) {
			if ($('#' + field).attr('value')) {
				$.ajax({
					url: 'index.php?route=common/filemanager/image&token=<?php echo $token;?>&image=' + encodeURIComponent($('#' + field).val()),
					dataType: 'text',
					success: function(data) {
						$('#' + thumb).replaceWith('<img src="' + data + '" alt="" id="' + thumb + '" />');
					}
				});
			}
		},	
		bgiframe: false,
		width: 800,
		height: 400,
		resizable: false,
		modal: false
	});
};

$('.simulate_login').click(function(){
   alert('fff');
});
//--></script> 
