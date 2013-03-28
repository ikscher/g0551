<link rel="stylesheet" type="text/css" href="view/stylesheet/general.css">
<link rel="stylesheet" type="text/css" href="view/stylesheet/main.css">
<script type="text/javascript" src="view/javascript/jquery/jquery-1.7.1.min.js"></script><!--这里只能用1.7.1的版本,否则自带的图片处理有问题-->

<style type="text/css">
tr.over td {
	background:#cfeefe;
} 
.center{
   text-align:center;
} 
</style>

    <h1><img src="view/image/customer.png" alt="" /> <?php echo $heading_title;?>
        <span class="action-span">
		   
		   <a href="<?php echo $insert;?>" class="insert"><?php echo $button_insert;?></a>
		   <a href="javascript:;" class="delete"><?php echo $button_delete;?></a>
		   <a href="<?php echo $refresh;?>" class="refresh"><?php echo $button_refresh;?></a>
		</span>
    </h1>
    <div class="list-div" id="listDiv">
      <form action="<?php echo $delete;?>" method="post" enctype="multipart/form-data" id="form">
        <table class="list">
          <thead>
            <tr>
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
              <td class="center">ID</td>
			  <td class="center"><?php if($sort == 'cgd.name') { ?>
                <a href="<?php echo $sort_name;?>" class="{strtolower(<?php echo $order;?>)}"><?php echo $column_name;?></a>
                 <?php } else { ?>
                <a href="<?php echo $sort_name;?>"><?php echo $column_name;?></a>
                <?php } ?></td>
              <td class="center"><?php if($sort == 'cg.sort_order') { ?>
                <a href="<?php echo $sort_sort_order;?>" class="{strtolower(<?php echo $order;?>)}"><?php echo $column_sort_order;?></a>
                 <?php } else { ?>
                <a href="<?php echo $sort_sort_order;?>"><?php echo $column_sort_order;?></a>
                <?php } ?></td>           
              <td class="center"><?php echo $column_description;?></td>				
              <td class="center"><?php echo $column_action;?></td>
            </tr>
          </thead>
          <tbody>
            <?php if($customer_groups) { ?>
				<?php foreach((array)$customer_groups as $customer_group) {?>
				<tr>
				  <td style="text-align: center;"><?php if($customer_group['selected']) { ?>
					<input type="checkbox" name="selected[]" value="<?php echo $customer_group['customer_group_id'];?>" checked="checked" />
					 <?php } else { ?>
					<input type="checkbox" name="selected[]" value="<?php echo $customer_group['customer_group_id'];?>" />
					<?php } ?></td>
				  <td><?php echo $customer_group['customer_group_id'];?></td>
				  <td class="left"><?php echo $customer_group['name'];?></td>
				  <td class="right"><?php echo $customer_group['sort_order'];?></td>
				  <td><?php echo $customer_group['description'];?></td>
				  <td class="right"><?php foreach((array)$customer_group['action'] as $action) {?>
					 <a href="<?php echo $action['href'];?>"><?php echo $action['text'];?></a>
					<?php } ?></td>
				</tr>
				<?php } ?>
            <?php } else { ?>
				<tr>
				  <td class="center" colspan="4"><?php echo $text_no_results;?></td>
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


$('.delete').click(function(){
    if(checkForm()){
	   if(confirm('您确认删除吗?')){
			$('#form').submit();
		}
	}
});

function checkForm(){
    var sum=0;
	var customer_group_id=[];
    $("input[name^='select']").each(function(i,n){
		if($(this).prop("checked")==true){
		   customer_group_id.push($(this).val());
		   sum++;
		}
  
    });
    
    if(sum<1) {
       alert("请选择要删除的项！");
	   return false;
    }

	var flag;
	$.ajax({
	    url:'index.php?route=sale/customer_group/validateDelete&token=<?php echo $token;?>',
		dataType:'json',
		type:'post',
		data:({'s[]':customer_group_id}),
		async:false,
		success:function(json){
			if(json.length>0){
			   alert(json); 
			   flag=true;
			}
		}
	});
	if(flag==true){
	   return false;
	}
	return true;

};
</script>