<link rel="stylesheet" type="text/css" href="view/stylesheet/general.css">
<link rel="stylesheet" type="text/css" href="view/stylesheet/main.css">
<script type="text/javascript" src="view/javascript/jquery/jquery-1.7.1.min.js"></script><!--这里只能用1.7.1的版本,否则自带的图片处理有问题-->
<script type="text/javascript" src="view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
<link type="text/css" href="view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
<style type="text/css">
tr.over td {
	background:#cfeefe;
} 
</style>
    <h1><img src="view/image/customer.png" alt="" /> <?php echo $heading_title;?>
        <span class="action-span">
		    <a href="javascript:;"  onclick="parent.addTab('新增优惠券','<?php echo $insert;?>')" class="button"><?php echo $button_insert;?></a>
			<a href="javascript:;"  onclick="$('#form').submit();" class="button"><?php echo $button_delete;?></a>
		</span>
    </h1>
    <div class="list-div" id="listDiv">
      <form action="<?php echo $delete;?>" method="post" enctype="multipart/form-data" id="form" onSubmit="return checkForm();">
        <table class="list">
          <thead>
            <tr>
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
              <td class="left"><?php if($sort == 'cd.name') { ?>
                <a href="<?php echo $sort_name;?>" class="{strtolower(<?php echo $order;?>)}"><?php echo $column_name;?></a>
                 <?php } else { ?>
                <a href="<?php echo $sort_name;?>"><?php echo $column_name;?></a>
                <?php } ?></td>
              <td class="left"><?php if($sort == 'c.code') { ?>
                <a href="<?php echo $sort_code;?>" class="{strtolower(<?php echo $order;?>)}"><?php echo $column_code;?></a>
                 <?php } else { ?>
                <a href="<?php echo $sort_code;?>"><?php echo $column_code;?></a>
                <?php } ?></td>
              <td class="right"><?php if($sort == 'c.discount') { ?>
                <a href="<?php echo $sort_discount;?>" class="{strtolower(<?php echo $order;?>)}"><?php echo $column_discount;?></a>
                 <?php } else { ?>
                <a href="<?php echo $sort_discount;?>"><?php echo $column_discount;?></a>
                <?php } ?></td>
              <td class="left"><?php if($sort == 'c.date_start') { ?>
                <a href="<?php echo $sort_date_start;?>" class="{strtolower(<?php echo $order;?>)}"><?php echo $column_date_start;?></a>
                 <?php } else { ?>
                <a href="<?php echo $sort_date_start;?>"><?php echo $column_date_start;?></a>
                <?php } ?></td>
              <td class="left"><?php if($sort == 'c.date_end') { ?>
                <a href="<?php echo $sort_date_end;?>" class="{strtolower(<?php echo $order;?>)}"><?php echo $column_date_end;?></a>
                 <?php } else { ?>
                <a href="<?php echo $sort_date_end;?>"><?php echo $column_date_end;?></a>
               <?php } ?></td>
              <td class="left"><?php if($sort == 'c.status') { ?>
                <a href="<?php echo $sort_status;?>" class="{strtolower(<?php echo $order;?>)}"><?php echo $column_status;?></a>
                 <?php } else { ?>
                <a href="<?php echo $sort_status;?>"><?php echo $column_status;?></a>
                <?php } ?></td>
              <td class="right"><?php echo $column_action;?></td>
            </tr>
          </thead>
          <tbody>
            <?php if($coupons) { ?>
            <?php foreach((array)$coupons as $coupon) {?>
            <tr>
              <td style="text-align: center;"><?php if($coupon['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $coupon['coupon_id'];?>" checked="checked" />
                 <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $coupon['coupon_id'];?>" />
                <?php } ?></td>
              <td class="left"><?php echo $coupon['name'];?></td>
              <td class="left"><?php echo $coupon['code'];?></td>
              <td class="right"><?php echo $coupon['discount'];?></td>
              <td class="left"><?php echo $coupon['date_start'];?></td>
              <td class="left"><?php echo $coupon['date_end'];?></td>
              <td class="left"><?php echo $coupon['status'];?></td>
              <td class="right"><?php foreach((array)$coupon['action'] as $action) {?>
                [ <a href="<?php echo $action['href'];?>"><?php echo $action['text'];?></a> ]
                <?php } ?></td>
            </tr>
            <?php } ?>
             <?php } else { ?>
            <tr>
              <td class="center" colspan="8"><?php echo $text_no_results;?></td>
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