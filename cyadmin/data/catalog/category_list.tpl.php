<link rel="stylesheet" type="text/css" href="view/stylesheet/general.css">
<link rel="stylesheet" type="text/css" href="view/stylesheet/main.css">
<script type="text/javascript" src="view/javascript/jquery/jquery-1.8.0.min.js"></script>
<style type="text/css">
tr.over td {
	background:#cfeefe;
} 
</style>

<?php if($error_warning) { ?>
<div class="warning"><?php echo $error_warning;?></div>
<?php } ?>
<?php if($success) { ?>
<div class="success"><?php echo $success;?></div>
<?php } ?>

<h1>
  <img src="view/image/category.png" alt="" /> <?php echo $heading_title;?>
  <span class="action-span"><a href="<?php echo $insert;?>" ><?php echo $button_insert;?></a><a href="javascript:;" onclick="$('#form').submit();"   ><?php echo $button_delete;?></a><a href="<?php echo $refresh;?>"><?php echo $button_refresh;?></a></span>
</h1>

<div class="list-div" style="margin-bottom:10px;padding:5px;">
    <form action="<?php echo $refresh;?>" method="post" >
		<?php echo $column_categoryid;?><input type="text" name="categoryid" value="<?php echo $categoryid;?>" />
		<?php echo $column_name;?><input type="text" name="categoryname" value="<?php echo $categoryname;?>" />
		<?php echo $column_parentid;?><input type="text" name="parentid" value="<?php echo $parentid;?>" />
		<?php echo $column_status;?>
		    <select name="status">
			    <option  value=""  <?php if($status==='') { ?>selected="selected"<?php } ?>>--全部--</option>
				<option  value="0" <?php if($status===0) { ?>selected="selected"<?php } ?>>停用</option>
				<option  value="1" <?php if($status==1) { ?>selected="selected"<?php } ?>>启用</option>
			</select>	
	    <input type="submit" name="sbt" value="提交" style="cursor:pointer" />
	</form>
</div>

<div class="list-div" id="listDiv">
  <form action="<?php echo $delete;?>" method="post" enctype="multipart/form-data" id="form" onSubmit="return checkForm();">
	<table class="list">
	  <thead>
		<tr>
		  <td><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
		  <td><?php echo $column_categoryid;?></td>
		  <td><?php echo $column_name;?></td>
		  <td><?php echo $column_parentid;?></td>
		  <td><?php echo $column_sort_order;?></td>
		  <td><?php echo $column_status;?></td>
		  <td><?php echo $column_action;?></td>
		</tr>
	  </thead>
	  <tbody>
		<?php if($categories) { ?>
		<?php foreach((array)$categories as $category) {?>
		<tr>
		  <td style="text-align: center;"><?php if($category['selected']) { ?>
			<input type="checkbox" name="selected[]" value="<?php echo $category['category_id'];?>" checked="checked" />
			<?php } else { ?>
			<input type="checkbox" name="selected[]" value="<?php echo $category['category_id'];?>" />
			<?php } ?>
		 </td>
		  <td><?php echo $category['category_id'];?></td>
		  <td><?php echo $category['name'];?></td>
		  <td><?php echo $category['parent_id'];?></td>
		  <td><?php echo $category['sort_order'];?></td>
		  <td><?php if($category['status'])  echo '启用';  else  echo '停用'?></td>
		  <td><?php foreach((array)$category['action'] as $action) {?>
			[ <a href="<?php echo $action['href'];?>"><?php echo $action['text'];?></a> ]
			<?php } ?></td>
		</tr>
		<?php } ?>
		 
		<?php } else { ?>
		<tr>
		  <td style="text-align:center" colspan="7"><?php echo $text_no_results;?></td>
		</tr>
	   <?php } ?>
	  </tbody>
	</table>
  </form>
  <?php echo $pagination;?>
</div>
	
  
</div>
<script type="text/javascript">
$(function(){
	$(".list tr").mouseover(function(){
		$(this).addClass("over");
	}).mouseout(function(){
		$(this).removeClass("over");	
	})

});

function checkForm(){
    var sum=0;
    $("input[name^='select']").each(function(i,n){
		if($(this).prop("checked")==true){
		   sum++;
		}
  
    });
  
    if(sum<1) {
       alert("请选择要删除的项！");
	   return false;
    }

};

$("input[name='categoryid']").click(function(){
    $("input[name='parentid']").val('');
	$("input[name='categoryname']").val('');
});
$("input[name='parentid']").click(function(){
    $("input[name='categoryid']").val('');
	$("input[name='categoryname']").val('');
});
$("input[name='categoryname']").click(function(){
    $("input[name='parentid']").val('');
	$("input[name='categoryid']").val('');
});
</script>