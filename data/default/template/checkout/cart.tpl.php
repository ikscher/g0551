<?php echo $header;?>
<link href="catalog/view/theme/default/stylesheet/shopping_car.css" type="text/css" rel="stylesheet" />
<div class="mainContent clear">
	<!-- <div class="buyPhoto"><img src="images/ad/xhy_012.jpg" width="980" height="210" /></div> -->
	<div class="buyPhoto"><img src="catalog/view/theme/default/image/order/shopping_steps.jpg" width="980" height="50" /></div>
	<?php if($success) { ?>
	<div class="success" ><?php echo $success;?><img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div> 
	<?php } ?>
	<?php if($error_warning) { ?>
	<div class="warning"><?php echo $error_warning;?><img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>
	<?php } ?>
	<div class="buyTitle"><img src="catalog/view/theme/default/image/order/order_buy_pay1.jpg" width="193" height="30" /></div>
	<div class="buyContent">
	    <form id="cart" method="POST" action="<?php echo $action;?>" enctype="multipart/form-data" >
		<table class="clearfix">
			<thead>
			  <tr>
				<td class="photo">商品图片</td>
				<td class="productName">商品名称</td>
				<td class="quantity">数量</td>
				<td class="price">单价</td>
				<td class="total">总价</td>
				<td class="operator">操作</td>
			  </tr>
			</thead>
			<tbody>
			<?php foreach((array)$products as $product) {?>
			
			<tr>
				<td ><?php if($product['thumb']) { ?> <a href="<?php echo $product['href'];?>"><img src="<?php echo $product['thumb'];?>"  width="50" height="60"  alt="<?php echo $product['name'];?>" title="<?php echo $product['name'];?>" /></a><?php } ?></td>
				<td ><a href="<?php echo $product['href'];?>"><?php echo $product['name'];?>></a>
				  <?php if(!$product['stock']) { ?>
				  <span class="stock">***</span>
				  <?php } ?>
				  <div>
					<?php foreach((array)$product['option'] as $option) {?>
					<small><!-- <?php echo $option['attribute_group_name'];?>:  --><?php echo $option['value'];?></small> 
					<?php } ?>
					<?php foreach((array)$product['attribute'] as $attribute) {?>
					<small><?php echo $attribute['name'];?></small> 
					<?php } ?>
				  </div>
				  <?php if($product['reward']) { ?>
				  <small><?php echo $product['reward'];?></small>
				  <?php } ?>
				</td>
				<td ><span class="subadd"> - </span><input type="text" name="quantity[<?php echo $product['key'];?>]" value="<?php echo $product['quantity'];?>" size="1" /><span class="subadd">+</span></td>
				<td ><?php echo $product['price'];?></td>
				<td ><?php echo $product['total'];?></td>
			    <input type="submit" name="sbt" id="sbt" style="display:none" />
				<td ><a class="deleteProduct" href="<?php echo $product['remove'];?>">删除</a></td>
			</tr>
			<?php } ?>
		    </tbody>
	    </table>
		</form>
	    <div class="containue"></div> 
	</div>
	
	<h1><b>您希望使用下列的哪个功能</b></h1>
	<div class="coupon_bor">
		<ul>
			<li>选择使用折扣券， 或奖励积分<!-- ，或预估配送成本 --></li>
			<li><label for="use_coupon"><input type="radio" name="next" value="coupon" id="use_coupon" />使用折扣券</label></li>
			<li><label for="use_voucher"><input type="radio" name="next" value="voucher" id="use_voucher" />使用礼品券</label></li>
		</ul>	
			 
	</div>
	

	
	 <div class="cart-module">
		<div id="coupon" class="content" style="display: <?php if($next == 'coupon') { ?>'block'<?php } else { ?>'none'<?php } ?>;">
		  <form action="<?php echo $action;?>" method="post" enctype="multipart/form-data">
			请输入您的折扣券：&nbsp;
			<input type="text" name="coupon" value="<?php echo $coupon;?>" />
			<input type="hidden" name="next" value="coupon" />
			&nbsp;
			<input type="submit" value="使用折扣券" class="button" />
		  </form>
		</div>
		<div id="voucher" class="content" style="display:<?php if($next == 'voucher') { ?>'block'<?php } else { ?>'none'<?php } ?>;">
		  <form action="<?php echo $action;?>" method="post" enctype="multipart/form-data">
			请输入您的礼品券：&nbsp;
			<input type="text" name="voucher" value="<?php echo $voucher;?>" />
			<input type="hidden" name="next" value="voucher" />
			&nbsp;
			<input type="submit" value="使用礼品券" class="button" />
		  </form>
		</div>
    </div>
	
	
	
	<div class="paybutton">
	    <div>
			<ul class="clearfix">
			    <?php foreach((array)$totals as $total) {?>
				<li><?php echo $total['title'];?>：<?php echo $total['text'];?></li>
				<?php } ?>
			</ul>
		</div>
     
      
		<div class="shoppingAndcheckout" >
		    <a href="<?php echo $continue;?>"><img src="catalog/view/theme/default/image/order/continue.jpg" border="0" /></a>&nbsp;&nbsp;&nbsp;
		    <a href="<?php echo $checkout;?>"><img src="catalog/view/theme/default/image/order/checkout.jpg" /></a>
		</div>
	</div>
</div>


<!-- <?php if($attention) { ?>
<div class="attention"><?php echo $attention;?><img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>
<?php } ?>
<?php if($success) { ?>
<div class="success"><?php echo $success;?><img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>
<?php } ?>
<?php if($error_warning) { ?>
<div class="warning"><?php echo $error_warning;?><img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>
<?php } ?> -->



<script type="text/javascript"><!--
$('input[name=\'next\']').bind('change', function() {
	$('.cart-module > div').hide();
	
	$('#' + this.value).show();
});

$(".subadd").each(function(index){
	$(this).mouseenter(function(){
	  $(this).css({'border-width':'1px','border-style':'solid','border-color':'#111'});
	  $(this).css("cursor","pointer");
	  
	}).mouseleave(function(){
	  $(this).css({'border-width':'1px','border-style':'solid','border-color':'#fcd'});
	});
});


$(".subadd").each(function(index){
  
   $(this).click(function(){
	   var operator=$.trim($(this).html());
	   var v=parseInt($(this).siblings('input').val());
	   if(operator=='-'){
	       if (v>1) $(this).siblings('input').val(v-1);
	   }else if(operator='+'){
		   $(this).siblings('input').val(v+1);
	   }
	   setTimeout(function(){$("#sbt").click()},1000);
	  
	   
	});
});

$(".deleteProduct").click(function(){
  if(!confirm("确认要删除这个产品吗?")){
     return false;
  }
  return true;
});
//--></script>
<?php if($shipping_status) { ?>
<script type="text/javascript"><!--
/*
$('#button-quote').live('click', function() {
	$.ajax({
		url: 'index.php?route=checkout/cart/quote',
		type: 'post',
		data: 'country_id=' + $('select[name=\'country_id\']').val() + '&zone_id=' + $('select[name=\'zone_id\']').val() + '&postcode=' + encodeURIComponent($('input[name=\'postcode\']').val()),
		dataType: 'json',		
		beforeSend: function() {
			$('#button-quote').attr('disabled', true);
			$('#button-quote').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
		},
		complete: function() {
			$('#button-quote').attr('disabled', false);
			$('.wait').remove();
		},		
		success: function(json) {
			$('.success, .warning, .attention, .error').remove();			
						
			if (json['error']) {
				if (json['error']['warning']) {
					$('#notification').html('<div class="warning" style="display: none;">' + json['error']['warning'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
					
					$('.warning').fadeIn('slow');
					
					$('html, body').animate({ scrollTop: 0 }, 'slow'); 
				}	
							
				if (json['error']['country']) {
					$('select[name=\'country_id\']').after('<span class="error">' + json['error']['country'] + '</span>');
				}	
				
				if (json['error']['zone']) {
					$('select[name=\'zone_id\']').after('<span class="error">' + json['error']['zone'] + '</span>');
				}
				
				if (json['error']['postcode']) {
					$('input[name=\'postcode\']').after('<span class="error">' + json['error']['postcode'] + '</span>');
				}					
			}
			
			if (json['shipping_method']) {
				html  = '<h2><?php echo $text_shipping_method;?></h2>';
				html += '<form action="<?php echo $action;?>" method="post" enctype="multipart/form-data">';
				html += '  <table class="radio">';
				
				for (i in json['shipping_method']) {
					html += '<tr>';
					html += '  <td colspan="3"><b>' + json['shipping_method'][i]['title'] + '</b></td>';
					html += '</tr>';
				
					if (!json['shipping_method'][i]['error']) {
						for (j in json['shipping_method'][i]['quote']) {
							html += '<tr class="highlight">';
							
							if (json['shipping_method'][i]['quote'][j]['code'] == '<?php echo $shipping_method;?>') {
								html += '<td><input type="radio" name="shipping_method" value="' + json['shipping_method'][i]['quote'][j]['code'] + '" id="' + json['shipping_method'][i]['quote'][j]['code'] + '" checked="checked" /></td>';
							} else {
								html += '<td><input type="radio" name="shipping_method" value="' + json['shipping_method'][i]['quote'][j]['code'] + '" id="' + json['shipping_method'][i]['quote'][j]['code'] + '" /></td>';
							}
								
							html += '  <td><label for="' + json['shipping_method'][i]['quote'][j]['code'] + '">' + json['shipping_method'][i]['quote'][j]['title'] + '</label></td>';
							html += '  <td style="text-align: right;"><label for="' + json['shipping_method'][i]['quote'][j]['code'] + '">' + json['shipping_method'][i]['quote'][j]['text'] + '</label></td>';
							html += '</tr>';
						}		
					} else {
						html += '<tr>';
						html += '  <td colspan="3"><div class="error">' + json['shipping_method'][i]['error'] + '</div></td>';
						html += '</tr>';						
					}
				}
				
				html += '  </table>';
				html += '  <br />';
				html += '  <input type="hidden" name="next" value="shipping" />';
				
				<?php if($shipping_method) { ?>
				html += '  <input type="submit" value="<?php echo $button_shipping;?>" id="button-shipping" class="button" />';	
				 <?php } else { ?>
				html += '  <input type="submit" value="<?php echo $button_shipping;?>" id="button-shipping" class="button" disabled="disabled" />';	
				<?php } ?>
							
				html += '</form>';
				
				$.colorbox({
					overlayClose: true,
					opacity: 0.5,
					width: '600px',
					height: '400px',
					href: false,
					html: html
				});
				
				$('input[name=\'shipping_method\']').bind('change', function() {
					$('#button-shipping').attr('disabled', false);
				});
			}
		}
	});
});
*/
//--></script> 

<script type="text/javascript"><!--
/*
$('select[name=\'country_id\']').bind('change', function() {
	$.ajax({
		url: 'index.php?route=checkout/cart/country&country_id=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			$('select[name=\'country_id\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
		},
		complete: function() {
			$('.wait').remove();
		},			
		success: function(json) {
			if (json['postcode_required'] == '1') {
				$('#postcode-required').show();
			} else {
				$('#postcode-required').hide();
			}
			
			html = '<option value=""><?php echo $text_select;?></option>';
			
			if (json['zone'] != '') {
				for (i = 0; i < json['zone'].length; i++) {
        			html += '<option value="' + json['zone'][i]['zone_id'] + '"';
	    			
					if (json['zone'][i]['zone_id'] == '<?php echo $zone_id;?>') {
	      				html += ' selected="selected"';
	    			}
	
	    			html += '>' + json['zone'][i]['name'] + '</option>';
				}
			} else {
				html += '<option value="0" selected="selected"><?php echo $text_none;?></option>';
			}
			
			$('select[name=\'zone_id\']').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('select[name=\'country_id\']').trigger('change');
//--> */</script>
<?php } ?>
<?php echo $footer;?>