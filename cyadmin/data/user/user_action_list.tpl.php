<link rel="stylesheet" type="text/css" href="view/stylesheet/general.css">
<link rel="stylesheet" type="text/css" href="view/stylesheet/main.css">
<script type="text/javascript" src="view/javascript/jquery/jquery-1.7.1.min.js"></script>
<!-- <script type="text/javascript" src="view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
<link type="text/css" href="view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" /> -->
<style type="text/css">
tr.over td {
	background:#cfeefe;
} 
</style>
    <h1><img src="view/image/user-group.png" alt="" /> <?php echo $heading_title;?>
        <span class="action-span">
		   <a href="<?php echo $refresh;?>" class="button"><?php echo $button_refresh;?></a>
		   <a href="<?php echo $insert;?>" class="button"><?php echo $button_insert;?></a>
		   <a href="javascript:;" onclick="$('form').submit();" class="button"><?php echo $button_delete;?></a>
		</span>
    </h1>
	
     <div class="list-div" id="listDiv">
      <form action="<?php echo $delete;?>" method="post" enctype="multipart/form-data" id="form" onsubmit="return checkForm();">
        <table class="list">
          <thead>
            <tr>
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
              <td class="left"><?php if($sort == 'navcode') { ?>
                <a href="<?php echo $sort_navcode;?>" class="{strtolower(<?php echo $order;?>)}"><?php echo $column_navcode;?></a>
                 <?php } else { ?>
                <a href="<?php echo $sort_navcode;?>"><?php echo $column_navcode;?></a>
                <?php } ?></td>
			  <td class="left"><?php if($sort == 'navdesc') { ?>
                <a href="<?php echo $sort_navdesc;?>" class="{strtolower(<?php echo $order;?>)}"><?php echo $column_navdesc;?></a>
                 <?php } else { ?>
                <a href="<?php echo $sort_navdesc;?>"><?php echo $column_navdesc;?></a>
                <?php } ?></td>
			  <td class="left"><?php if($sort == 'actioncode') { ?>
                <a href="<?php echo $sort_actioncode;?>" class="{strtolower(<?php echo $order;?>)}"><?php echo $column_actioncode;?></a>
                 <?php } else { ?>
                <a href="<?php echo $sort_actioncode;?>"><?php echo $column_actioncode;?></a>
                <?php } ?></td>
			  <td class="left"><?php if($sort == 'actiondesc') { ?>
                <a href="<?php echo $sort_actiondesc;?>" class="{strtolower(<?php echo $order;?>)}"><?php echo $column_actiondesc;?></a>
                 <?php } else { ?>
                <a href="<?php echo $sort_actiondesc;?>"><?php echo $column_actiondesc;?></a>
                <?php } ?></td>
              <td class="right"><?php echo $column_action;?></td>
            </tr>
          </thead>
          <tbody>
            <?php if($user_actions) { ?>
            <?php foreach((array)$user_actions as $user_action) {?>
            <tr>
              <td style="text-align: center;"><?php if($user_action['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $user_action['id'];?>" checked="checked" />
                 <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $user_action['id'];?>" />
                <?php } ?></td>
			  <td class="navcode"><?php echo $user_action['navcode'];?></td>
              <td class="navdesc"><?php echo $user_action['navdesc'];?></td>
			  <td><?php echo $user_action['actioncode'];?></td>
			  <td class="left"><?php echo $user_action['actiondesc'];?></td>
              <td class="right"><?php foreach((array)$user_action['action'] as $action) {?>
                <a href="<?php echo $action['href'];?>"><?php echo $action['text'];?></a>
                <?php } ?></td>
            </tr>
            <?php } ?>
             <?php } else { ?>
            <tr>
              <td class="center" colspan="6"><?php echo $text_no_results;?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </form>
      <div class="pagination"><?php echo $pagination;?></div>
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



$(".navdesc").css({'cursor':'pointer','color':'red'});
$(".navdesc").click(function(){
  var x=$.trim($(this).html());

  var url='index.php?route=user/user_action&token=<?php echo $token;?>&navdesc='+encodeURIComponent(x);
  location.href=url;
 
});
</script>