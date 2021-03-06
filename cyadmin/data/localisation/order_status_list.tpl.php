<link rel="stylesheet" type="text/css" href="view/stylesheet/general.css">
<link rel="stylesheet" type="text/css" href="view/stylesheet/main.css">
<script type="text/javascript" src="view/javascript/jquery/jquery-1.7.1.min.js"></script>
<style type="text/css">
tr.over td {
	background:#cfeefe;
} 
</style>

    <h1><img src="view/image/order.png" alt="" /> <?php echo $heading_title;?>
        <span class="action-span">
	      <a href="<?php echo $refresh;?>" class="button"><?php echo $button_refresh;?></a>
		  <a href="<?php echo $insert;?>" class="button"><?php echo $button_insert;?></a>
		  <a href="javascript:;" onclick="$('form').submit();" class="button"><?php echo $button_delete;?></a>
		</span>
    </h1>
    <div class="list-div" id="listDiv">
      <form action="<?php echo $delete;?>" method="post" enctype="multipart/form-data" id="form" onSubmit="return checkForm();">
        <table class="list">
          <thead>
            <tr>
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
              <td class="left"><?php if($sort == 'name') { ?>
                <a href="<?php echo $sort_name;?>" class="{strtolower(<?php echo $order;?>)}"><?php echo $column_name;?></a>
                 <?php } else { ?>
                <a href="<?php echo $sort_name;?>"><?php echo $column_name;?></a>
                <?php } ?></td>
              <td class="right"><?php echo $column_action;?></td>
            </tr>
          </thead>
          <tbody>
            <?php if($order_statuses) { ?>
            <?php foreach((array)$order_statuses as $order_status) {?>
            <tr>
              <td style="text-align: center;"><?php if($order_status['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $order_status['order_status_id'];?>" checked="checked" />
                 <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $order_status['order_status_id'];?>" />
                <?php } ?></td>
              <td class="left"><?php echo $order_status['name'];?></td>
              <td class="right"><?php foreach((array)$order_status['action'] as $action) {?>
                 <a href="<?php echo $action['href'];?>"><?php echo $action['text'];?></a>
                <?php } ?></td>
            </tr>
             <?php } ?>
             <?php } else { ?>
            <tr>
              <td class="center" colspan="3"><?php echo $text_no_results;?></td>
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
</script>