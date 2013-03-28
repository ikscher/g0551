<link rel="stylesheet" type="text/css" href="view/stylesheet/general.css">
<link rel="stylesheet" type="text/css" href="view/stylesheet/main.css">
<script type="text/javascript" src="view/javascript/jquery/jquery-1.7.1.min.js"></script>

<style type="text/css">
tr.over td {
	background:#cfeefe;
} 
</style>
    <h1><img src="view/image/setting.png" alt="" /> <?php echo $heading_title;?>
        <span class="action-span">
		    <a href="<?php echo $insert;?>" class="button"><?php echo $button_insert;?></a>
			<a href="javascript:void(0);"  class="button"><?php echo $button_delete;?></a>
			<a href="<?php echo $refresh;?>" class="button"><?php echo $button_refresh;?></a>
			
		</span>
    </h1>
    <div class="list-div" id="listDiv">
      <form action="<?php echo $delete;?>" method="post" enctype="multipart/form-data" id="form" onsubmit="return checkForm();">
        <table class="list">
          <thead>
            <tr>
              <td  style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
              <td style="text-align:center">ID</td>
			  <td style="text-align:center"><?php echo $column_group;?></td>
			  <td style="text-align:center"><?php echo $column_key;?></td>
              <td style="text-align:center"><?php echo $column_value;?></td>
              <td style="text-align:center"><?php echo $column_serialized;?></td>
			  <td></td>
		
            </tr>
          </thead>
		  <?php if(!empty($enviorments)) { ?>
          <tbody>
            
				<?php foreach((array)$enviorments as $e) {?>
				<tr>
				  <td style="text-align: center;"><?php if($e['selected']) { ?>
					<input type="checkbox" name="selected[]" value="<?php echo $e['setting_id'];?>" checked="checked" />
					 <?php } else { ?>
					<input type="checkbox" name="selected[]" value="<?php echo $e['setting_id'];?>" />
					<?php } ?></td>
				  <td class="left"><?php echo $e['setting_id'];?></td>
				  <td class="group"><?php if(isset($e['group'])) { ?><?php echo $e['group'];?><?php } ?></td>
				  <td class="left"><?php if(isset($e['key'])) { ?><?php echo $e['key'];?><?php } ?></td>
				  <td class="left"><?php if(isset($e['value'])) { ?><?php echo $e['value'];?><?php } ?></td>
				  <td class="left"><?php if(isset($e['serialized'])) { ?><?php echo $e['serialized'];?><?php } ?></td>
				  <td class="left"><a href="<?php echo $e['action'];?>" ><?php echo $text_edit;?></a></td>
				</tr>
				<?php } ?>
				
           
          </tbody>
		  <tfoot>
				 <tr class="pagination"><td colspan="7"><?php echo $pagination;?></td></tr>
				</tfoot>
		 <?php } else { ?>
		       <tr><td style="text-align:center" colspan="7"><?php echo $text_no_results;?></td></tr>
			 <?php } ?>
        </table>
      </form>
	 
    </div>
<script type="text/javascript">
$(function(){
	$(".list tr").mouseover(function(){
		$(this).addClass("over");
	}).mouseout(function(){
		$(this).removeClass("over");	
	})

});

$(".action-span a:eq(1)").click(function(){
    if(checkForm()){
		if(confirm('您确认删除吗?')){
		   $('form').submit();
		}
	}
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
	
	return true;

};

$(".group").css({"cursor":"pointer","color":"red"});
$(".group").click(function(){
   var group=$(this).text();
   location.href="index.php?route=setting/enviorment&token=<?php echo $token;?>&group="+encodeURIComponent(group);
});
</script>