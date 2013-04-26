<link rel="stylesheet" type="text/css" href="view/stylesheet/main.css">
<link rel="stylesheet" type="text/css" href="view/stylesheet/general.css?v=20130318">
<script type="text/javascript" src="view/javascript/jquery/jquery-1.7.1.min.js"></script><!--这里只能用1.7.1的版本,否则自带的图片处理有问题-->
<script type="text/javascript" src="view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
<link type="text/css" href="view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />

    <h1><img src="view/image/customer.png" alt="" /> <?php echo $heading_title;?>
        <span class="action-span">
		<!-- <a href="<?php echo $insert;?>" class="insert"><?php echo $button_insert;?></a> -->
		<a href="javascript:void(0);" class="delete"><?php echo $button_delete;?></a>
		<a href="<?php echo $refresh;?>"  class="save"><?php echo $button_refresh;?></a>
	    </span>
    </h1>
	
	
      
              <?php echo $column_name;?><input type="text" name="filter_name" value="<?php echo $filter_name;?>" />
              <?php echo $column_email;?><input type="text" name="filter_email" value="<?php echo $filter_email;?>" />
             <?php echo $column_customer_group;?> <select name="filter_customer_group_id">
                  <option value="*"></option>
                  <?php foreach((array)$customer_groups as $customer_group) {?>
                  <?php if($customer_group['customer_group_id'] == $filter_customer_group_id) { ?>
                  <option value="<?php echo $customer_group['customer_group_id'];?>" selected="selected"><?php echo $customer_group['name'];?></option>
                   <?php } else { ?>
                  <option value="<?php echo $customer_group['customer_group_id'];?>"><?php echo $customer_group['name'];?></option>
                  <?php } ?>
                 <?php } ?>
                </select>
              <?php echo $column_status;?><select name="filter_status">
                  <option value="*"></option>
                  <?php if($filter_status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled;?></option>
                   <?php } else { ?>
                  <option value="1"><?php echo $text_enabled;?></option>
                  <?php } ?>
                  <?php if(!is_null($filter_status) && !$filter_status) { ?>
                  <option value="0" selected="selected"><?php echo $text_disabled;?></option>
                   <?php } else { ?>
                  <option value="0"><?php echo $text_disabled;?></option>
                <?php } ?>
                </select>
             
              <?php echo $column_ip;?><input type="text" name="filter_ip" value="<?php echo $filter_ip;?>" /></td>
              <?php echo $column_date_added;?><input type="text" name="filter_date_added" value="<?php echo $filter_date_added;?>" size="12" id="date" />
              
              <a href="javascript:void(0);"  onclick="filter();"><?php echo $button_filter;?></a>
   
    	
    <div class="list-div" id="listDiv">
      <form action="<?php echo $delete;?>" method="post" enctype="multipart/form-data" id="form" >
        <table class="list">
          <thead>
            <tr>
              <td width="1" class="center"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
              <td class="center"><?php if($sort == 'name') { ?>
                <a href="<?php echo $sort_name;?>" class="{strtolower(<?php echo $order;?>)}"><?php echo $column_name;?></a>
                 <?php } else { ?>
                <a href="<?php echo $sort_name;?>"><?php echo $column_name;?></a>
                <?php } ?></td>
              <td class="center"><?php if($sort == 'c.email') { ?>
                <a href="<?php echo $sort_email;?>" class="{strtolower(<?php echo $order;?>)}"><?php echo $column_email;?></a>
                 <?php } else { ?>
                <a href="<?php echo $sort_email;?>"><?php echo $column_email;?></a>
               <?php } ?></td>
			   <td>店铺ID</td>
			   <td>店铺名称</td>
              <td class="left"><?php if($sort == 'customer_group') { ?>
                <a href="<?php echo $sort_customer_group;?>" class="{strtolower(<?php echo $order;?>)}"><?php echo $column_customer_group;?></a>
                 <?php } else { ?>
                <a href="<?php echo $sort_customer_group;?>"><?php echo $column_customer_group;?></a>
               <?php } ?></td>
              <td class="center"><?php if($sort == 'c.status') { ?>
                <a href="<?php echo $sort_status;?>" class="{strtolower(<?php echo $order;?>)}"><?php echo $column_status;?></a>
                 <?php } else { ?>
                <a href="<?php echo $sort_status;?>"><?php echo $column_status;?></a>
               <?php } ?></td>
             <!--  <td class="left"><?php if($sort == 'c.approved') { ?>
                <a href="<?php echo $sort_approved;?>" class="{strtolower(<?php echo $order;?>)}"><?php echo $column_approved;?></a>
                 <?php } else { ?>
                <a href="<?php echo $sort_approved;?>"><?php echo $column_approved;?></a>
                <?php } ?></td> -->
              <td class="center"><?php if($sort == 'c.ip') { ?>
                <a href="<?php echo $sort_ip;?>" class="{strtolower(<?php echo $order;?>)}"><?php echo $column_ip;?></a>
                 <?php } else { ?>
                <a href="<?php echo $sort_ip;?>"><?php echo $column_ip;?></a>
                <?php } ?></td>
              <td class="center"><?php if($sort == 'c.date_added') { ?>
                <a href="<?php echo $sort_date_added;?>" class="{strtolower(<?php echo $order;?>)}"><?php echo $column_date_added;?></a>
                 <?php } else { ?>
                <a href="<?php echo $sort_date_added;?>"><?php echo $column_date_added;?></a>
                <?php } ?></td>
              <td class="center"><?php echo $column_login;?></td>
              <td class="center"><?php echo $column_action;?></td>
            </tr>
          </thead>
          <tbody>
            
            <?php if($customers) { ?>
            <?php foreach((array)$customers as $customer) {?>
            <tr>
              <td class="center"><?php if($customer['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $customer['customer_id'];?>" checked="checked" />
                 <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $customer['customer_id'];?>" />
               <?php } ?></td>
              <td class="left"><?php echo $customer['username'];?></td>
              <td class="left"><?php echo $customer['email'];?></td>
			  <td class="left"><?php echo $customer['store_id'];?></td>
			  <td class="left"><?php echo $customer['storename'];?></td>
              <td class="left"><?php echo $customer['customer_group'];?></td>
              <td class="left"><?php echo $customer['status'];?></td>
              <!-- <td class="left"><?php echo $customer['approved'];?></td> -->
              <td class="left"><?php echo $customer['ip'];?></td>
              <td class="left"><?php echo $customer['date_added'];?></td>
              <td></td>
              <td class="right"><?php foreach((array)$customer['action'] as $action) {?>
                 <a href="<?php echo $action['href'];?>"><?php echo $action['text'];?></a> 
                <?php } ?></td>
            </tr>
            <?php } ?>
             <?php } else { ?>
            <tr>
              <td class="center" colspan="9"><?php echo $text_no_results;?></td>
            </tr>
           <?php } ?>
          </tbody>
        </table>
      </form>
      <div class="pagination"><?php echo $pagination;?></div>
    </div>

<script type="text/javascript"><!--
function filter() {
	url = 'index.php?route=sale/customer&token=<?php echo $token;?>';
	
	var filter_name = $('input[name=\'filter_name\']').attr('value');
	
	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}
	
	var filter_email = $('input[name=\'filter_email\']').attr('value');
	
	if (filter_email) {
		url += '&filter_email=' + encodeURIComponent(filter_email);
	}

	
	var filter_customer_group_id = $('select[name=\'filter_customer_group_id\']').attr('value');
	
	if (filter_customer_group_id != '*') {
		url += '&filter_customer_group_id=' + encodeURIComponent(filter_customer_group_id);
	}	
	
	var filter_status = $('select[name=\'filter_status\']').attr('value');
	
	if (filter_status != '*') {
		url += '&filter_status=' + encodeURIComponent(filter_status); 
	}	
	
	//var filter_approved = $('select[name=\'filter_approved\']').attr('value');
	
	//if (filter_approved != '*') {
	//	url += '&filter_approved=' + encodeURIComponent(filter_approved);
	//}	
	
	var filter_ip = $('input[name=\'filter_ip\']').attr('value');
	
	if (filter_ip) {
		url += '&filter_ip=' + encodeURIComponent(filter_ip);
	}
		
	var filter_date_added = $('input[name=\'filter_date_added\']').attr('value');
	
	if (filter_date_added) {
		url += '&filter_date_added=' + encodeURIComponent(filter_date_added);
	}
	
	location= url;
}



//--></script>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#date').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script>
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
    
	return true;
};

$(".delete").click(function(){
    if (checkForm()){
		if(confirm("您确认删除吗?")){
			$('form').submit();
		}
    }		
});
</script>