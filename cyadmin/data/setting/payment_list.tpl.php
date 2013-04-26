
<link rel="stylesheet" type="text/css" href="view/stylesheet/main.css">
<script type="text/javascript" src="view/javascript/jquery/jquery-1.8.0.min.js"></script>
<link rel="stylesheet" type="text/css" href="view/stylesheet/general.css">


<!-- <?php if($error_warning) { ?>
<div class="warning"><?php echo $error_warning;?></div>
<?php } ?>
<?php if($success) { ?>
<div class="success"><?php echo $success;?></div>
<?php } ?> -->

<h1>
  <?php echo $heading_title;?>
  <span class="action-span"><a href="<?php echo $insert;?>" ><?php echo $button_insert;?></a><a href="javascript:;" onclick="$('#form').submit();"   ><?php echo $button_delete;?></a><a href="<?php echo $refresh;?>"><?php echo $button_refresh;?></a></span>
</h1>



<div class="list-div" id="listDiv">
  <form action="<?php echo $delete;?>" method="post" enctype="multipart/form-data" id="form" onSubmit="return checkForm();">
	<table class="list">
	  <thead>
		<tr>
		  <td width="3%"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
		  <td width="15%"class="center"><?php echo $entry_store;?></td>
		  <td width="5%"class="center"><?php echo $entry_code;?></td>
		  <td class="center"><?php echo $entry_trade_type;?></td>
		  <td class="center"><?php echo $entry_partner;?></td>
		  <td width="10%" class="center"><?php echo $entry_security_code;?></td>
		  <td width="10%" class="center"><?php echo $entry_seller_email;?></td>
		  <td width="2%" class="center"><?php echo $entry_status;?></td>
		  <td class="center"><?php echo $entry_description;?></td>
		  <td  width="3%" class="center"><?php echo $entry_action;?></td>
		</tr>
	  </thead>
	  <tbody>
		<?php if($storePayments) { ?>
		<?php foreach((array)$storePayments as $payment) {?>
		<tr>
		  <td><?php if($payment['selected']) { ?>
			<input type="checkbox" name="selected[]" value="<?php echo $payment['id'];?>" checked="checked" />
			<?php } else { ?>
			<input type="checkbox" name="selected[]" value="<?php echo $payment['id'];?>" />
			<?php } ?>
		 </td>
		  <td><?php echo $payment['storename'];?></td>
		  <td><?php echo $payment['payment_code'];?></td>
		  <td><?php echo $payment['trade_type'];?></td>
		  <td><?php echo $payment['partner'];?></td>
		  <td><?php echo $payment['security_code'];?></td>
		  <td><?php echo $payment['seller_email'];?></td>
		  <td><?php if($payment['status'])  echo '在用';  else  echo '禁用'?></td>
		  <td><?php echo $payment['description'];?></td>
		  <td><?php foreach((array)$payment['action'] as $action) {?>
			 <a href="<?php echo $action['href'];?>"><?php echo $action['text'];?></a> 
			<?php } ?></td>
		</tr>
		<?php } ?>
		 
		<?php } else { ?>
		<tr>
		  <td style="text-align:center" colspan="10"><?php echo $text_no_results;?></td>
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


</script>