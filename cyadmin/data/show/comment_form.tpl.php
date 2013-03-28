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

          <table class="form">
    
            <tr>
              <td><?php echo $column_comment;?></td>
              <td><textarea name="comment" id="comment" cols="150" rows="10" ><?php if(isset($comment['comment'])) { ?><?php echo $comment['comment'];?><?php } ?></textarea>
			  <?php if($error_content) { ?>
                <span class="error"><?php echo $error_content;?></span>
                <?php } ?>
			  </td>
            </tr>
          
            
            
            <tr>
              <td><?php echo $column_createtime;?></td>
              <td><input type="text" name="createtime" value="<?php if(isset($comment['createtime'])) { ?><?php echo $comment['createtime'];?><?php } ?>" size="12" class="date" /></td>
            </tr>
            
           
            <tr>
                <td><?php echo $column_isShow;?></td>
                <td><select name="isShow">
					<option value="1" <?php if(isset($comment['isShow']) && $comment['isShow']=='1') { ?>  selected="selected"<?php } ?>><?php echo $text_show;?></option>
					<option value="2" <?php if(isset($comment['isShow']) && $comment['isShow']=='2') { ?>  selected="selected"<?php } ?>><?php echo $text_delete;?></option>
					<option value="3" <?php if(isset($comment['isShow']) && $comment['isShow']=='3') { ?>  selected="selected"<?php } ?>><?php echo $text_hidden;?></option>
                </select></td>
            </tr>
            
          </table>

      </form>
</div>
<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script> 
<script type="text/javascript"><!--

CKEDITOR.replace('comment', {
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