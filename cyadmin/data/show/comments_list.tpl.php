<link rel="stylesheet" type="text/css" href="view/stylesheet/main.css">
<link rel="stylesheet" type="text/css" href="view/stylesheet/general.css">

<script type="text/javascript" src="view/javascript/jquery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
<link type="text/css" href="view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />



<?php if($error_warning) { ?>
<div class="warning"><?php echo $error_warning;?></div>
<?php } ?>
<?php if($success) { ?>
<div class="success"><?php echo $success;?></div>
<?php } ?>

<h1>
  <img src="view/image/category.png" alt="" /> <?php echo $heading_title;?>
   
    <span class="action-span">
       
	   <a href="javascript:void(0);"  ><?php echo $button_delete;?></a>
	   <a href="<?php echo $refresh;?>"><?php echo $button_refresh;?></a>
	   
    </span>
</h1>

<div class="list-div" style="margin-bottom:10px;padding:5px;">
    <form enctype="multipart/form-data" method="post"  action="<?php echo $import;?>" >  
        <input type="file"  name="import"  />
		<input  type="submit" value="<?php echo $button_import;?>" /> 
    </form>
    <form action="<?php echo $refresh;?>" method="post" >
		<?php echo $column_comment_id;?><input type="text" name="comment_id" value="<?php echo $comment_id;?>" />
		<?php echo $column_starttime;?><input type="text" name="starttime" value="<?php echo $starttime;?>" class="date"/>
		<?php echo $column_endtime;?><input type="text" name="endtime" value="<?php echo $endtime;?>" class="date" />
		<?php echo $column_comment;?><input type="text" name="comment" value="<?php echo $comment;?>" />
		<?php echo $column_isShow;?>
		    <select name="isShow">
			    <option  value=""  <?php if($isShow=='') { ?>selected="selected"<?php } ?>>--全部--</option>
				<option  value="1" <?php if($isShow==1) { ?>selected="selected"<?php } ?>>显示</option>
				<option  value="2" <?php if($isShow==2) { ?>selected="selected"<?php } ?>>删除</option>
				<option  value="3" <?php if($isShow==3) { ?>selected="selected"<?php } ?>>不显示</option>
			</select>	
		<input type="reset"  name="rst" value="重置" style="cursor:pointer" />
	    <input type="submit" name="sbt" value="提交" style="cursor:pointer" />
	</form>
</div>

<div class="list-div" id="listDiv">
  <form action="<?php echo $delete;?>" method="post" enctype="multipart/form-data" id="form">
	<table class="list">
	  <thead>
		<tr>
		  <td><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
		  <td><?php echo $column_comment_id;?></td>
		  <td width="45%"><?php echo $column_comment;?></td>
		  <td width="6%"><?php echo $column_createtime;?></td>
		  <td width="15%"><?php echo $column_userid;?></td>
		  <td width="10%"><?php echo $column_username;?></td>
		  <td width="3%"><?php echo $column_content_id;?></td>
		  <td><?php echo $column_isShow;?></td>
		  <td><?php echo $column_action;?></td>
		</tr>
	  </thead>
	  <tbody>
		<?php if($comments) { ?>
		<?php foreach((array)$comments as $comment) {?>
		<tr>
		  <td style="text-align: center;"><?php if($comment['selected']) { ?>
			<input type="checkbox" name="selected[]" value="<?php echo $comment['comment_id'];?>" checked="checked" />
			<?php } else { ?>
			<input type="checkbox" name="selected[]" value="<?php echo $comment['comment_id'];?>" />
			<?php } ?>
		 </td>
		  <td><?php echo $comment['comment_id'];?></td>
		  <td><?php echo $comment['comment'];?></td>
		  <td><?php echo $comment['createtime'];?></td>
		  <td><?php echo $comment['userid'];?></td>
		  <td><?php echo $comment['username'];?></td>
		  <td><a href="javascript:void(0)" onclick='parent.addTab("","index.php?route=show/contents&content_id=<?php echo $comment['content_id'];?>&token=<?php echo $token;?>")' ><?php echo $comment['content_id'];?></a></td>
		  <td><?php if($comment['isShow']==1) { ?>显示<?php } elseif ($comment['isShow']==2) { ?>删除<?php } else { ?>不显示<?php } ?></td>
		  <td><?php foreach((array)$comment['action'] as $action) {?>
			[ <a href="<?php echo $action['href'];?>"><?php echo $action['text'];?></a> ]
			<?php } ?></td>
		</tr>
		<?php } ?>
		 
		<?php } else { ?>
		<tr>
		  <td style="text-align:center" colspan="11"><?php echo $text_no_results;?></td>
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
	
	return true

};


</script>

<script type="text/javascript"><!--
$('.date').datepicker({dateFormat: 'yy-mm-dd'});
//--></script> 

<script type="text/javascript"><!--
 $("span.action-span a:eq(0)").click(function(){
    if(checkForm()){
	    if(confirm('你确认删除吗？')){
			$('#form').submit();
		}
	}
 });


//--></script>