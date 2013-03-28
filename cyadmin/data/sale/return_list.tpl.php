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
    <h1><img src="view/image/order.png" alt="" /> <?php echo $heading_title;?>
        <span class="action-span">
		     <a href="javascript:;" onclick="parent.addTab('新增退单','<?php echo $insert;?>')" class="button"><?php echo $button_insert;?></a>
			 <a href="javascript:;" onclick="$('form').submit();" class="button"><?php echo $button_delete;?></a></span>
    </h1>
   
    <div class="list-div" id="listDiv">
      <form action="<?php echo $delete;?>" method="post" enctype="multipart/form-data" id="form" onsubmit="return checkForm();">
        <table class="list">
          <thead>
            <tr>
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
              <td class="right"><?php if($sort == 'r.return_id') { ?>
                <a href="<?php echo $sort_return_id;?>" class="{strtolower(<?php echo $order;?>)}"><?php echo $column_return_id;?></a>
                 <?php } else { ?>
                <a href="<?php echo $sort_return_id;?>"><?php echo $column_return_id;?></a>
                <?php } ?></td>
              <td class="right"><?php if($sort == 'r.order_id') { ?>
                <a href="<?php echo $sort_order_id;?>" class="{strtolower(<?php echo $order;?>)}"><?php echo $column_order_id;?></a>
                 <?php } else { ?>
                <a href="<?php echo $sort_order_id;?>"><?php echo $column_order_id;?></a>
                <?php } ?></td>
              <td><?php if($sort == 'customer') { ?>
                <a href="<?php echo $sort_customer;?>" class="{strtolower(<?php echo $order;?>)}"><?php echo $column_customer;?></a>
                 <?php } else { ?>
                <a href="<?php echo $sort_customer;?>"><?php echo $column_customer;?></a>
               <?php } ?></td>
              <td><?php if($sort == 'r.product') { ?>
                <a href="<?php echo $sort_product;?>" class="{strtolower(<?php echo $order;?>)}"><?php echo $column_product;?></a>
                 <?php } else { ?>
                <a href="<?php echo $sort_product;?>"><?php echo $column_product;?></a>
                <?php } ?></td>
              <td><?php if($sort == 'r.model') { ?>
                <a href="<?php echo $sort_model;?>" class="{strtolower(<?php echo $order;?>)}"><?php echo $column_model;?></a>
                 <?php } else { ?>
                <a href="<?php echo $sort_model;?>"><?php echo $column_model;?></a>
                <?php } ?></td>                
              <td><?php if($sort == 'status') { ?>
                <a href="<?php echo $sort_status;?>" class="{strtolower(<?php echo $order;?>)}"><?php echo $column_status;?></a>
                 <?php } else { ?>
                <a href="<?php echo $sort_status;?>"><?php echo $column_status;?></a>
                <?php } ?></td>
              <td><?php if($sort == 'r.date_added') { ?>
                <a href="<?php echo $sort_date_added;?>" class="{strtolower(<?php echo $order;?>)}"><?php echo $column_date_added;?></a>
                 <?php } else { ?>
                <a href="<?php echo $sort_date_added;?>"><?php echo $column_date_added;?></a>
                <?php } ?></td>
              <td><?php if($sort == 'r.date_modified') { ?>
                <a href="<?php echo $sort_date_modified;?>" class="{strtolower(<?php echo $order;?>)}"><?php echo $column_date_modified;?></a>
                 <?php } else { ?>
                <a href="<?php echo $sort_date_modified;?>"><?php echo $column_date_modified;?></a>
                <?php } ?></td>
              <td class="right"><?php echo $column_action;?></td>
            </tr>
          </thead>
          <tbody>
            <tr class="filter">
              <td></td>
              <td><input type="text" name="filter_return_id" value="<?php echo $filter_return_id;?>" size="4" style="text-align: right;" /></td>
              <td><input type="text" name="filter_order_id" value="<?php echo $filter_order_id;?>" size="4" style="text-align: right;" /></td>
              <td><input type="text" name="filter_customer" value="<?php echo $filter_customer;?>" /></td>
              <td><input type="text" name="filter_product" value="<?php echo $filter_product;?>" /></td>
              <td><input type="text" name="filter_model" value="<?php echo $filter_model;?>" /></td>
              <td><select name="filter_return_status_id">
                  <option value="*"></option>
                  <?php foreach((array)$return_statuses as $return_status) {?>
                  <?php if($return_status['return_status_id'] == $filter_return_status_id) { ?>
                  <option value="<?php echo $return_status['return_status_id'];?>" selected="selected"><?php echo $return_status['name'];?></option>
                   <?php } else { ?>
                  <option value="<?php echo $return_status['return_status_id'];?>"><?php echo $return_status['name'];?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
              <td><input type="text" name="filter_date_added" value="<?php echo $filter_date_added;?>" size="12" class="date" /></td>
              <td><input type="text" name="filter_date_modified" value="<?php echo $filter_date_modified;?>" size="12" class="date" /></td>
              <td><a onclick="filter();" class="button"><?php echo $button_filter;?></a></td>
            </tr>
            <?php if($returns) { ?>
            <?php foreach((array)$returns as $return) {?>
            <tr>
              <td style="text-align: center;"><?php if($return['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $return['return_id'];?>" checked="checked" />
                 <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $return['return_id'];?>" />
                <?php } ?></td>
              <td class="right"><?php echo $return['return_id'];?></td>
              <td class="right"><?php echo $return['order_id'];?></td>
              <td><?php echo $return['customer'];?></td>
              <td><?php echo $return['product'];?></td>
              <td><?php echo $return['model'];?></td>
              <td><?php echo $return['status'];?></td>
              <td><?php echo $return['date_added'];?></td>
              <td><?php echo $return['date_modified'];?></td>
              <td class="right"><?php foreach((array)$return['action'] as $action) {?>
                 <a href="javascript:;" onclick="parent.addTab('<?php echo $action['text'];?>退单','<?php echo $action['href'];?>')"><?php echo $action['text'];?></a>
                <?php } ?></td>
            </tr>
            <?php } ?>
             <?php } else { ?>
            <tr>
              <td class="center" colspan="10"><?php echo $text_no_results;?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </form>
      <?php echo $pagination;?>
    </div>

<script type="text/javascript"><!--
function filter() {
	url = 'index.php?route=sale/return&token=<?php echo $token;?>';
	
	var filter_return_id = $('input[name=\'filter_return_id\']').attr('value');
	
	if (filter_return_id) {
		url += '&filter_return_id=' + encodeURIComponent(filter_return_id);
	}
	
	var filter_order_id = $('input[name=\'filter_order_id\']').attr('value');
	
	if (filter_order_id) {
		url += '&filter_order_id=' + encodeURIComponent(filter_order_id);
	}	
		
	var filter_customer = $('input[name=\'filter_customer\']').attr('value');
	
	if (filter_customer) {
		url += '&filter_customer=' + encodeURIComponent(filter_customer);
	}
	
	var filter_product = $('input[name=\'filter_product\']').attr('value');
	
	if (filter_product) {
		url += '&filter_product=' + encodeURIComponent(filter_product);
	}

	var filter_model = $('input[name=\'filter_model\']').attr('value');
	
	if (filter_model) {
		url += '&filter_model=' + encodeURIComponent(filter_model);
	}
		
	var filter_return_status_id = $('select[name=\'filter_return_status_id\']').attr('value');
	
	if (filter_return_status_id != '*') {
		url += '&filter_return_status_id=' + encodeURIComponent(filter_return_status_id);
	}	
	
	var filter_date_added = $('input[name=\'filter_date_added\']').attr('value');
	
	if (filter_date_added) {
		url += '&filter_date_added=' + encodeURIComponent(filter_date_added);
	}

	var filter_date_modified = $('input[name=\'filter_date_modified\']').attr('value');
	
	if (filter_date_modified) {
		url += '&filter_date_modified=' + encodeURIComponent(filter_date_modified);
	}
			
	location = url;
}
//--></script> 
<script type="text/javascript"><!--
$.widget('custom.catcomplete', $.ui.autocomplete, {
	_renderMenu: function(ul, items) {
		var self = this, currentCategory = '';
		
		$.each(items, function(index, item) {
			if (item.category != currentCategory) {
				ul.append('<li class="ui-autocomplete-category">' + item.category + '</li>');
				
				currentCategory = item.category;
			}
			
			self._renderItem(ul, item);
		});
	}
});

$('input[name=\'filter_customer\']').catcomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=sale/customer/autocomplete&token=<?php echo $token;?>&filter_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						category: item.customer_group,
						label: item.name,
						value: item.customer_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('input[name=\'filter_customer\']').val(ui.item.label);
						
		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});
//--></script> 
<script type="text/javascript"><!--
$(document).ready(function() {
	$('.date').datepicker({dateFormat: 'yy-mm-dd'});
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

};
</script>