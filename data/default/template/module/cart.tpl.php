<?php if($products || $vouchers) { ?>
<div class="mini-cart-info">
  <table>
	<?php foreach((array)$products as $product) {?>
	<tr class="count">
	  <td class="image"><?php if($product['thumb']) { ?>
		<a href="<?php echo $product['href'];?>"><img src="<?php echo $product['thumb'];?>" alt="<?php echo $product['name'];?>" title="<?php echo $product['name'];?>" /></a>
		<?php } ?></td>
	  <td class="name"><a href="<?php echo $product['href'];?>" title="<?php echo $product['allname'];?>"><?php echo $product['name'];?></a>
		<div>
		  <?php foreach((array)$product['option'] as $option) {?>
		  - <small><?php echo $option['attribute_group_name'];?> <?php echo $option['value'];?></small><br />
		  <?php } ?>
		</div></td>
	  <td class="quantity">x&nbsp;<?php echo $product['quantity'];?></td>
	  <td class="total"><?php echo $product['total'];?></td>
	  <td class="remove"><img src="catalog/view/theme/default/image/remove-small.png" alt="<?php echo $button_remove;?>" title="<?php echo $button_remove;?>" data-id="<?php echo $product['key'];?>" /></td>
	   <!-- onclick="(getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') ? location = 'index.php?route=checkout/cart&remove=<?php echo $product['key'];?>' : $('.car-content').load('index.php?route=module/cart&remove=<?php echo $product['key'];?>' + ' .car-content > *');" /> -->
	</tr>
	<?php } ?>
	<?php foreach((array)$vouchers as $voucher) {?>
	<tr class="count">
	  <td class="image"></td>
	  <td class="name"><?php echo $voucher['description'];?></td>
	  <td class="quantity">x&nbsp;1</td>
	  <td class="total"><?php echo $voucher['amount'];?></td>
	  <td class="remove"><img src="catalog/view/theme/default/image/remove-small.png" alt="<?php echo $button_remove;?>" title="<?php echo $button_remove;?>" onclick="(getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') ? location = 'index.php?route=checkout/cart&remove=<?php echo $voucher['key'];?>' : $('.car-content').load('index.php?route=module/cart&remove=<?php echo $voucher['key'];?>' + ' .car-content > *');" /></td>
	</tr>
	<?php } ?>
  </table>
</div>
<div class="mini-cart-total">
  <table>
	<?php foreach((array)$totals as $total) {?>
	<tr>
	  <td class="right"><b><?php echo $total['title'];?>:</b></td>
	  <td class="right"><?php echo $total['text'];?></td>
	</tr>
	<?php } ?>
  </table>
</div>
<div class="checkout"><a href="<?php echo $cart;?>"><?php echo $text_cart;?></a> | <a href="<?php echo $checkout;?>"><?php echo $text_checkout;?></a></div>
 <?php } else { ?>
<div class="empty"><?php echo $text_empty;?></div>
<?php } ?>
<script type="text/javascript" >
    $('.remove img').click(function(){
	    var self=$(this);
	    $(this).parent().parent().remove();
		var product_id=$(this).attr('data-id');
		if(getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
		    location.href = 'index.php?route=checkout/cart&remove='+product_id;
		}else{
		    $.get('index.php?route=module/cart&remove='+product_id,function(){
			    var quantity=$.trim(self.parent().parent().find('.quantity').text()).match(/\d+/g);
				var total=$.trim($('#cart-total a').text()).match(/\d+/g);
				total=total - quantity;
				if (total<0) return false;
				$('#cart-total a').html($('#cart-total a').text().replace(/\d+/g,total));
				
				//´©ÔÃ´©ÔÃ³µ
				$(".tmMCBotLink .tmMCNum").html($('#cart-total a').text().replace(/\d+/g,total));
				$(".tmMCHdLeft span.tmMCNum").html($('#cart-total a').text().replace(/\d+/g,total));
			});
		}
	});
	
	
	
</script>

