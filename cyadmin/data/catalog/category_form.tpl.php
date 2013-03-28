<link rel="stylesheet" type="text/css" href="view/stylesheet/general.css">
<link rel="stylesheet" type="text/css" href="view/stylesheet/main.css">
<script type="text/javascript" src="view/javascript/jquery/jquery-1.7.1.min.js"></script><!--这里只能用1.7.1的版本,否则自带的图片处理有问题-->
<script type="text/javascript" src="view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
<link type="text/css" href="view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />


    <?php if($error_warning) { ?>
	<div class="warning"><?php echo $error_warning;?></div>
	<?php } ?>

  <div class="box">
    <div class="heading">
    <h1><img src="view/image/category.png" alt="" /> <?php echo $heading_title;?>
	  <span class="action-span"><a href="<?php echo $cancel;?>" ><?php echo $button_cancel;?></a></span>
      <span class="action-span"><a href="javascript:;" onclick="$('#form').submit();" ><?php echo $button_save;?></a></span>
    </h1>
    <div class="list-div" id="listDiv">
   
      <form action="<?php echo $action;?>" method="post" enctype="multipart/form-data" id="form">
            <table class="form">
              <tr>
                <td><span class="required">*</span> <?php echo $entry_name;?></td>
				
                <td><input type="text" name="category_description[name]" size="100" value="<?php if(isset($category_description['name'])) { ?><?php echo $category_description['name'];?><?php } ?>" /><?php if(!empty($category_id)) { ?>ID：<?php echo $category_id;?><?php } ?>
                <p><?php if(isset($error_name)) { ?>
                  <span class="error"><?php echo $error_name;?></span>
                <?php } ?></p>
				</td>
              </tr>
              <tr>
                <td><?php echo $entry_meta_description;?></td>
                <td><textarea name="category_description[meta_description]" cols="40" rows="3"><?php if(isset($category_description['meta_description'])) { ?> <?php echo $category_description['meta_description'];?> <?php } ?></textarea></td>
              </tr>
              <tr>
                <td><?php echo $entry_meta_keyword;?></td>
                <td><textarea name="category_description[meta_keyword]" cols="40" rows="3"><?php if(isset($category_description['meta_keyword'])) { ?> <?php echo $category_description['meta_keyword'];?> <?php } ?></textarea></td>
              </tr>
              <tr>
                <td><?php echo $entry_description;?></td>
                <td><textarea name="category_description[description]" id="description"><?php if(isset($category_description['description'] )) { ?>  <?php echo $category_description['description'];?> <?php } ?></textarea></td>
              </tr>
          
            <tr>
              <td><?php echo $entry_parent;?></td>
              <td><select name="parent_id" >
                  <option value="0"><?php echo $text_none;?></option>
                  <?php foreach((array)$categories as $category) {?>
                  <?php if($category['category_id'] == $parent_id) { ?>
                  <option value="<?php echo $category['category_id'];?>,<?php echo $category['top'];?>" selected="selected" ><?php echo $category['name'];?></option>
                  <?php } else { ?>
                  <option value="<?php echo $category['category_id'];?>,<?php echo $category['top'];?>"><?php echo $category['name'];?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
				<!-- <a href="index.php?route=catalog/category/update&token=<?php echo $token;?>&category_id=<?php echo $category_id;?>" ><?php echo $button_refresh;?></a></td> -->
            </tr>
           <!--  <tr>
              <td><?php echo $entry_attributes;?></td>
              <td class='attributes'>
			        <?php if(isset($attribute_groups)) { ?>
						<?php foreach((array)$attribute_groups as $key=>$attribute_group) {?>
							
							<?php foreach((array)$attribute_group as $k=>$v) {?>
								<label class="agp" for="agp<?php echo $k;?>"><input type="checkbox" name="attribute_group[]" id="agp<?php echo $k;?>" value="<?php echo $k;?>"  <?php if(in_array($k,$AttributeGroups)) { ?>checked="checked"<?php } ?>/><?php echo $v;?></label>
							<?php }?>
							 <br/>
						<?php }?>
					<?php } ?>
			     </td>
            </tr> -->
			

			
              <td><?php echo $entry_image;?></td>
              <td valign="top"><div class="image"><img src="<?php echo $thumb;?>" alt="" id="thumb" />
                <input type="hidden" name="image" value="<?php echo $image;?>" id="image" />
                <br /><a  href="javascript:;" onclick="image_upload('image', 'thumb');"><?php echo $text_browse;?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a  href="javascript:;" onclick="$('#thumb').attr('src', '<?php echo $no_image;?>'); $('#image').attr('value', '');"><?php echo $text_clear;?></a></div></td>
            </tr>
            <!-- <tr>
              <td><?php echo $entry_top;?></td>
              <td><?php if($top) { ?>
                <input type="checkbox" name="top" value="1" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="top" value="1" />
                <?php } ?></td>
            </tr> -->
            <!-- <tr>
              <td><?php echo $entry_column;?></td>
              <td><input type="text" name="column" value="<?php echo $column;?>" size="1" /></td>
            </tr>
            <tr> -->
              <td><?php echo $entry_sort_order;?></td>
              <td><input type="text" name="sort_order" value="<?php echo $sort_order;?>" size="10" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_status;?></td>
              <td><select name="status">
                  <?php if($status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled;?></option>
                  <option value="0"><?php echo $text_disabled;?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled;?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled;?></option>
                  <?php } ?>
                </select></td>
            </tr>
          </table>
        
		
		
      </form>
    </div>

<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script> 
<script type="text/javascript"><!--

CKEDITOR.replace('description', {
	filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token;?>',
	filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token;?>',
	filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token;?>',
	filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token;?>',
	filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token;?>',
	filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token;?>'
});

//--></script> 
<script type="text/javascript"><!--
function image_upload(field, thumb) {
	$('#dialog').remove();
	
	$('#listDiv').append('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token;?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
	
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


    
/*
var sel={
        change:function(){
		    var id=$('select[name=parent_id]').val();
			var id_array=id.split(',');
			var category_id=id_array[0];
			var top=id_array[1];

			var attribute_group='';
			var str='';
			$.get('index.php?route=catalog/category/getAjaxGroupsByCategory&token=<?php echo $token;?>',{category_id:category_id,top:top},function(json){
			    for(var x in json){
				    for(var y in json[x]){
					    attribute_group=json[x][y];
						str +="<label class='agp' for='agp"+y+"'><input type='checkbox' name='attribute_group[]' id='agp"+y+"' value='"+y+ "' />"+attribute_group+"</label>";
					   
					}
				}
				$('.form tr td.attributes').html(str);
			},'json');
			
			
		},
		intilize:function(){
		    $.get('index.php?route=catalog/category/getAjaxGroupsByCategory&token=<?php echo $token;?>&category_id=<?php echo $category_id;?>',function(json){
				var str='';
				for(var x in json){
					for(var y in json[x]){
						attribute_group=json[x][y];
						str +="<label class='agp' for='agp"+y+"'><input type='checkbox' name='attribute_group[]' id='agp"+y+"' value='"+y+ "' />"+attribute_group+"</label>";
					   
					}
				}
				$('.form tr td.attributes').html(str);
			},'json');
        }
    
	};

	$('select[name=parent_id]').bind('change',sel.change);


$('input[name^=attribute_group]').css('cursor','pointer');
$('.agp').css('cursor','pointer');

*/

//--></script> 
