<!-- <?php echo $header;?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach((array)$breadcrumbs as $breadcrumb) {?>
    <?php echo $breadcrumb['separator'];?><a href="<?php echo $breadcrumb['href'];?>"><?php echo $breadcrumb['text'];?></a>
    <?php } ?>
  </div>
  <?php if($error_warning) { ?>
  <div class="warning"><?php echo $error_warning;?></div>
  <?php } ?>
  <?php if($success) { ?>
  <div class="success"><?php echo $success;?></div>
  <?php } ?>
  <div class="box">
    <div class="heading"> -->
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

    <h1><img src="view/image/review.png" alt="" /> <?php echo $heading_title;?>
        <span class="action-span">
		    <a href="javascript:;" onclick="parent.addTab('新增评论','<?php echo $insert;?>')" class="button"><?php echo $button_insert;?></a>
			<a href="javascript:;" onclick="$('form').submit();" class="button"><?php echo $button_delete;?></a>
			<a href="<?php echo $refresh;?>" class="button"><?php echo $button_refresh;?></a>
	    </span>
    </h1>
    <div class="list-div" id="listDiv">
      <form action="<?php echo $delete;?>" method="post" enctype="multipart/form-data" id="form" onsubmit="return checkForm();">
        <table class="list">
          <thead>
            <tr>
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
 
			  <td><?php if($sort == 'pd.name') { ?>
                <a href="<?php echo $sort_product;?>" class="{strtolower(<?php echo $order;?>)}"><?php echo $column_product;?></a>
                 <?php } else { ?>
                <a href="<?php echo $sort_product;?>"><?php echo $column_product;?></a>
                <?php } ?></td>
              <td><?php if($sort == 'r.author') { ?>
                <a href="<?php echo $sort_author;?>" class="{strtolower(<?php echo $order;?>)}"><?php echo $column_author;?></a>
                 <?php } else { ?>
                <a href="<?php echo $sort_author;?>"><?php echo $column_author;?></a>
                <?php } ?></td>
              <td><?php if($sort == 'r.rating') { ?>
                <a href="<?php echo $sort_rating;?>" class="{strtolower(<?php echo $order;?>)}"><?php echo $column_rating;?></a>
                 <?php } else { ?>
                <a href="<?php echo $sort_rating;?>"><?php echo $column_rating;?></a>
                <?php } ?></td>
              <td><?php if($sort == 'r.status') { ?>
                <a href="<?php echo $sort_status;?>" class="{strtolower(<?php echo $order;?>)}"><?php echo $column_status;?></a>
                 <?php } else { ?>
                <a href="<?php echo $sort_status;?>"><?php echo $column_status;?></a>
                <?php } ?></td>
              <td><?php if($sort == 'r.date_added') { ?>
                <a href="<?php echo $sort_date_added;?>" class="{strtolower(<?php echo $order;?>)}"><?php echo $column_date_added;?></a>
                 <?php } else { ?>
                <a href="<?php echo $sort_date_added;?>"><?php echo $column_date_added;?></a>
                <?php } ?></td>
              <td><?php echo $column_action;?></td>
            </tr>
          </thead>
          <tbody>
            <?php if($reviews) { ?>
				<?php foreach((array)$reviews as $review) {?>
				<tr>
				  <td style="text-align: center;"><?php if($review['selected']) { ?>
					<input type="checkbox" name="selected[]" value="<?php echo $review['review_id'];?>" checked="checked" />
					 <?php } else { ?>
					<input type="checkbox" name="selected[]" value="<?php echo $review['review_id'];?>" />
					<?php } ?></td>
		
				  <td><?php echo $review['name'];?></td>
				  <td><?php echo $review['author'];?></td>
				  <td><?php echo $review['rating'];?></td>
				  <td><?php echo $review['status'];?></td>
				  <td><?php echo date('Y-m-d',$review['date_added'])?></td>
				  <td><?php foreach((array)$review['action'] as $action) {?>
					 <a href="javascript:;"  onclick="parent.addTab('编辑评论','<?php echo $action['href'];?>')"><?php echo $action['text'];?></a> 
					<?php } ?></td>
				</tr>
				<?php } ?>
             <?php } else { ?>
				<tr>
				  <td class="center" colspan="7"><?php echo $text_no_results;?></td>
				</tr>
           <?php } ?>
          </tbody>
        </table>
      </form>
      <?php echo $pagination;?>
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