<link rel="stylesheet" type="text/css" href="view/stylesheet/general.css">
<link rel="stylesheet" type="text/css" href="view/stylesheet/main.css">

<script type="text/javascript" src="view/javascript/jquery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
<link type="text/css" href="view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />

    <h1><img src="view/image/product.png" alt="" /> <?php echo $heading_title;?>
        <span class="action-span">
	      <a href="javascript:;"  onclick="$('#form').submit();" ><?php echo $button_save;?></a>
	      <a href="<?php echo $cancel;?>"><?php echo $button_cancel;?></a>
	    </span>
    </h1>
   <!-- <?php if($error_warning) { ?>
      <div class="warning"><?php echo $error_warning;?></div>
   <?php } ?>
   <?php if($success) { ?>
      <div class="success"><?php echo $success;?></div>
   <?php } ?>  -->
    <div class="list-div" id="listDiv">
      
      <form action="<?php echo $action;?>" method="post" enctype="multipart/form-data" id="form">

        <!--基本信息-->
          <table class="form">
            <tr>
              <td width="5%"><span class="required">*</span> <?php echo $column_title;?></td>
              <td><input type="text" name="title" value="<?php if(isset($content['title'])) { ?><?php echo $content['title'];?><?php } ?>" size="100"/>
                <?php if($error_title) { ?>
                <span class="error"><?php echo $error_title;?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td width="5%"><?php echo $column_present;?></td>
              <td ><textarea cols="100"  rows="5" name="present"  ><?php if(isset($content['present'])) { ?><?php echo $content['present'];?><?php } ?></textarea>
			  <?php if($error_present) { ?>
                <span class="error"><?php echo $error_present;?></span>
                <?php } ?>
			  </td>
            </tr>
            <tr>
              <td width="5%"><?php echo $column_content;?></td>
              <td><textarea name="content" id="content" ><?php if(isset($content['content'])) { ?><?php echo $content['content'];?><?php } ?></textarea>
			  <?php if($error_content) { ?>
                <span class="error"><?php echo $error_content;?></span>
                <?php } ?>
			  </td>
            </tr>
          
            <tr>
                <td width="5%"><?php echo $column_imageUrl;?></td>
                <td>
			        <div class="image">
					    <img src="<?php if(isset($content['imageUrl'])) { ?><?php echo $content['imageUrl'];?><?php } ?>" alt="" id="thumb" /><br />
                        <input type="hidden" name="image" value="<?php if(isset($content['imageUrl'])) { ?><?php echo $content['imageUrl'];?><?php } ?>" id="image" />
                        <a href="javascript:;" onclick="image_upload('image', 'thumb');"><?php echo $text_browse;?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a  href="javascript:;" onclick="$('#thumb').attr('src', '<?php echo $no_image;?>'); $('#image').attr('value', '');"><?php echo $text_clear;?></a>
					</div>
				</td>
            </tr>
            <tr>
              <td ><?php echo $column_favoriate;?></td>
              <td><input type="text" name="favoriate" value="<?php if(isset($content['favoriate'])) { ?><?php echo $content['favoriate'];?><?php } ?>" /></td>
            </tr>
			
			
    
            <tr>
              <td><?php echo $column_share;?></td>
              <td><input type="text" name="share" value="<?php if(isset($content['share'])) { ?><?php echo $content['share'];?><?php } ?>"  /></td>
            </tr>
            
            
            
            <tr>
              <td><?php echo $column_createtime;?></td>
              <td><input type="text" name="createtime" value="<?php if(isset($content['createtime'])) { ?><?php echo $content['createtime'];?><?php } ?>" size="12" class="date" /></td>
            </tr>
            
           
            <tr>
                <td><?php echo $column_isShow;?></td>
                <td><select name="isShow">
					<option value="1" <?php if(isset($content['isShow']) && $content['isShow']==1) { ?>  selected="selected"<?php } ?>><?php echo $text_show;?></option>
					<option value="2" <?php if(isset($content['isShow']) && $content['isShow']==2) { ?>  selected="selected"<?php } ?>><?php echo $text_delete;?></option>
					<option value="3" <?php if(isset($content['isShow']) && $content['isShow']==3) { ?>  selected="selected"<?php } ?>><?php echo $text_hidden;?></option>
                </select></td>
            </tr>
            
          </table>

      </form>
</div>
<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script> 
<script type="text/javascript"><!--

CKEDITOR.replace('content', {
	filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token;?>',
	filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token;?>',
	filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token;?>',
	filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token;?>',
	filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token;?>',
	filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token;?>'
});

//--></script> 

<script type="text/javascript" src="view/javascript/jquery/ui/jquery-ui-timepicker-addon.js"></script> 
<script type="text/javascript"><!--
$('.date').datepicker({dateFormat: 'yy-mm-dd'});
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
					url: 'index.php?route=common/filemanager/image&token=<?php echo $token;?>&image=' + encodeURIComponent($('#' + field).attr('value')),
					dataType: 'text',
					success: function(text) {
						$('#' + thumb).replaceWith('<img src="' + text + '" alt="" id="' + thumb + '" />');
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
//--></script> 
