<?php echo $header;?>
 
<link href="catalog/view/theme/default/stylesheet/shopping_car.css" type="text/css" rel="stylesheet" />
<div class="mainContent clear">
	<!-- <div class="buyPhoto"><img src="images/ad/xhy_012.jpg" width="980" height="210" /></div> -->
	<div class="buyPhoto"><img src="catalog/view/theme/default/image/order/shopping_steps.jpg" width="980" height="50" /></div>
	<div class="buyTitle"><img src="catalog/view/theme/default/image/order/consignee.jpg" width="224" height="30" /></div>
	<div class="sendAddress">
	    <?php foreach((array)$addresses as $address) {?>
		<dl <?php if($address['status']==1) { ?>class="present"<?php } ?> id="<?php echo $address['address_id'];?>">
			
			<dt><input  name="addressopt" type="radio" <?php if($address['status']==1) { ?>checked="checked"<?php } ?> /></dt>
			<dd>
				<?php echo $address['address'];?> <?php echo $address['username'];?><span class="mobile"><?php echo $address['mobile'];?></span> <?php if($address['status']==1) { ?>默认地址<?php } ?>
			</dd>
			
		</dl>
		<?php } ?>
		
		<div class="new">
		  <a><img src="catalog/view/theme/default/image/order/new_address.jpg" width="89" height="25" border="0" /></a>
		</div>
	</div>
	
	<div class="sendInfo" >
		<div class="title">收货信息</div>
		<dl>
			<dt>收 货 人：</dt>
			<dd><input  type="text" name="username" size="20" />
			</dd>
		</dl>
		<!-- <dl class="clearfix">
			<dt>地　　区：</dt>
			<dd>
			<select name="">
				<option>--请选择省--</option>
			</select>
			<select name="">
				<option>--请选择地区--</option>
			</select>
			<select name="">
				<option>--请选择城市--</option>
			</select>
			<span class="star">*</span>
			</dd>
		</dl> -->
		<dl>
			<dt>收货地址：</dt>
			<dd><input name="address" type="text" /> <span class="star">*</span></dd>
		</dl>
		<dl>
			<dt>邮　　编：</dt>
			<dd><input type="text" name="postcode" size="20" />
			</dd>
		</dl>
		<dl>
			<dt>手机号码：</dt>
			<dd><input type="text" name="mobile" size="20" /> <span class="star">*</span></dd>
		</dl>
		<dl>
			<dt>固定电话：</dt>
			<dd><input type="text" name="telephone" size="20" />
			</dd>
		</dl>
		<div class="opaddr">
			<a class="save"><img src="catalog/view/theme/default/image/order/saveAddress.gif" /></a>&nbsp;&nbsp;
			<a class="cancel"><img src="catalog/view/theme/default/image/order/cancel.gif" /></a>
		</div>
	</div>
	
	
	<!-- <div class="buyTitle"><img src="images/payment_title2.jpg" width="237" height="30" /></div>
	<div class="paymentContent">
		<dl class="clearfix">
			<dt>
				<span>支付方式：</span>
			</dt>
			<dd class="current">
				<input type="radio" /> 支付宝(支付宝特约商家)
				<div class="container">
				  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="100" style="vertical-align:top;"><img src="images/zhifubao.jpg" width="86" height="30" /></td>
                      <td>支付宝是国内最大的独立第三方支付平台<br />
                        由于24小时未付款的订单将会被系统自动取消，为了避免您的损失请您尽快完成在线或联系客服进行支付，感谢您的支付和配合。</td>
                    </tr>
                  </table>
				</div>
			</dd>
			<dd><input type="radio" /> 网银支付(支持15家国内银行网上支付，需开通网上银行功能)</dd>
		</dl>
	</div> -->
	
    <?php if($shipping_required) { ?>
		<div class="buyTitle"><img src="catalog/view/theme/default/image/order/shipping_method.jpg" width="280" height="30" /></div>
		<div class="paymentContent">
			<dl class="clearfix">
				<dt>
					<span>配送方式：</span>(各大城市隔天送达，合肥市区：10元；其它地区：20元)
				</dt>
				
				<dd><input type="radio" name="shippingmethod" id="shippingmethod1" value="1,快递公司"  <?php if($shippingMethod==1) { ?>checked="checked"<?php } ?> /><span>快递公司</span></dd>
				<dd><input type="radio" name="shippingmethod" id="shippingmethod2" value="2,EMS邮政专递" <?php if($shippingMethod==2) { ?>checked="checked"<?php } ?> /><span>EMS邮政专递</span></dd>
				<dd><input type="radio" name="shippingmethod" id="shippingmethod3" value="3,货到付款" <?php if($shippingMethod==3) { ?>checked="checked"<?php } ?> /><span>货到付款</span></dd>
				<dd><input type="radio" name="shippingmethod" id="shippingmethod4" value="4,上门自提" <?php if($shippingMethod==4) { ?>checked="checked"<?php } ?> /><span>上门自提</span></dd>
			</dl>
		</div>
	<?php } ?>
	<div class="buyTitle"><img src="catalog/view/theme/default/image/order/shopping_list.jpg" width="218" height="30" /></div>
	<div class="buyContent bottonLine">
		<table class="clearfix">
			<thead>
			  <tr>
				<td class="photo">商品图片</td>
				<td class="productName">商品名称</td>
				<td class="count">数量</td>
				<td class="price">单价</td>
				<td class="total">小计</td>
				<!-- <span class="operator">操作</span> -->
			  </tr>
			</thead>
			<tbody>
			<?php foreach((array)$products as $product) {?>
			<tr>
				<td class="photo"><a href="<?php echo $product['href'];?>" title="<?php echo $product['name'];?>"><img src="<?php echo $product['thumb'];?>" width="50" height="60" /></a></td>
				<td class="productName"><a href="<?php echo $product['href'];?>" title="<?php echo $product['name'];?>"><?php echo $product['name'];?></a> <?php if(!$product['stock']) { ?>
				  <span class="stock">***</span>
				  <?php } ?>
				  <div>
					<?php foreach((array)$product['option'] as $option) {?>
					<small><!-- <?php echo $option['attribute_group_name'];?>: --> <?php echo $option['value'];?></small>
					<?php } ?>
					<?php foreach((array)$product['attribute'] as $attribute) {?>
					<small><?php echo $attribute['name'];?></small> 
					<?php } ?>
					
				  </div>
				  <?php if($product['reward']) { ?>
				  <small><?php echo $product['reward'];?></small>
				  <?php } ?></td>
				<td class="count"><?php echo $product['quantity'];?></td>
				<td class="price"><?php echo $product['price'];?></td>
				<td class="total"><?php echo $product['total'];?></td>
				<!-- <span class="operator"><a href="#">删除商品</a></span> -->
			</tr>
			<?php } ?>
			 <?php foreach((array)$vouchers as $voucher) {?>
			  <tr>
			    <td></td>
				<td class="name"><?php echo $voucher['description'];?></td>
				<td class="model"></td>
				<td class="quantity">1</td>
				<td class="price"><?php echo $voucher['amount'];?></td>
				<td class="total"><?php echo $voucher['amount'];?></td>
			  </tr>
			  <?php } ?>
			</tbody>
		</table>
	</div>
	<div class="paybutton">
		<div class="moneyinfo">
			<?php foreach((array)$totals as $total) {?>
			  <dl class="clearfix">
				<dt><?php echo $total['title'];?>:</dt>
				<dd><?php echo $total['text'];?></dd>
			  </dl>
			<?php } ?>
		</div>
		
		<div>
		    <?php if(empty($dbuy)) { ?><a href="<?php echo $cart;?>"><img src="catalog/view/theme/default/image/order/returnCart.jpg" width="161" height="33" /></a><?php } ?>
		    <a class="submit"> <img src="catalog/view/theme/default/image/order/submitOrder.jpg" width="160" height="33" /></a>
		</div>
	</div>
</div>
<input type="hidden" name="dbuy" <?php if(isset($dbuy)) { ?> value="<?php echo $dbuy;?>"<?php } else { ?> value="" <?php } ?> />
<!--begin提交订单支付数据到alipay-->
<div style="display:none">
    <form id="alipay" name="alipay" action="index.php?route=payment/alipay" method="post">
	    <input type="hidden" name="WIDseller_email" value="" />
		<input type="hidden" name="WIDout_trade_no" value="" />
		<input type="hidden" name="WIDsubject" value="" />
		<input type="hidden" name="WIDtotal_fee" value="" />
		<input type="hidden" name="WIDbody" value="" />
		<input type="hidden" name="WIDshow_url" value="" />
		<input type="hidden" name="WIDexter_invoke_ip" value="" />
	</form>
</div>
<!--end提交订单支付数据到alipay-->
<script type="text/javascript">
   //提交订单
   $(".paybutton .submit").click(function(){
        <?php if($shipping_required) { ?>
			var flag=false;
			$(".paymentContent dl dd input").each(function(i,w){
				if($(this).attr("checked")=='checked'){
				   flag=true;
				   return false;//退出循环
				}
			});
			
			if(flag==false) {
				alert('请选择配送方式！');
				return false;
			}
			
			var flag2=false;
			$(".sendAddress dl dt input").each(function(i,w){
				if($(this).attr("checked")=='checked'){
				   flag2=true;
				   return false;
				}
			});
			
			if(flag2==false) {
				alert('请选择收货地址！');
				return false;
			}
		<?php } ?>
		

        $.ajax({
	        type:'POST',
	        url:'index.php?route=checkout/confirm_order',
			dataType:'json',
			data:$('.paymentContent input[name=\'shippingmethod\']:checked ,input[name=\'dbuy\'],input[type=\'hidden\']'),
			success:function(json){
                
			    if (json['redirect']){
				    location.href=json['redirect'];
					return false;
				}else if (typeof json['redirect']=='undefined'){
				    $('input[name=WIDseller_email]').val(json['WIDseller_email']);
					$('input[name=WIDout_trade_no]').val(json['WIDout_trade_no']);
					$('input[name=WIDsubject]').val(json['WIDsubject']);
					$('input[name=WIDtotal_fee]').val(json['WIDtotal_fee']);
					$('input[name=WIDbody]').val(json['WIDbody']);
					$('input[name=WIDshow_url]').val(json['WIDshow_url']);
					$('input[name=WIDexter_invoke_ip]').val(json['WIDexter_invoke_ip']);
					
					$("#alipay").submit();
				}
			}
		});
   
   });

   //MOUSE 
   $(".sendAddress dl").each(function(){
      $(this).mouseenter(function(){
	     if($(this).prop('class')=='present'){
	        //$(this).css({'background-color':'#FFFAE5'});
		 }else{
		    $(this).css({'background-color':'#FFFAE5'});
		 }
	  }).mouseleave(function(){
	     if($(this).prop('class')=='present'){
	       //$(this).css({'background-color':'#FFE5CC','border-color':'FFE5CC'});
		 }else{
		   $(this).css({'background-color':''});
		 }
	  });
   });
   
   //货运方式
   $(".paymentContent dl dd").each(function(){
        $(this).mouseenter(function(){
	        if($(this).prop('class')!='shipping'){
		       $(this).addClass('shipping');
		    }
	    }).mouseleave(function(){
	       if($(this).prop('class')=='shipping'){
		      $(this).removeClass('shipping');
		   }
	    }).click(function(){
	        $(this).children('input[type=radio]').prop("checked","checked");
		    $.ajax({
			    url:'index.php?route=checkout/checkout/shippingMethod',
				type:'post',
				dataType:'json',
				data:$('input[name=\'shippingmethod\']:checked'),
				beforeSend: function() {
					$('.moneyinfo').html('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
				},
				complete: function() {
					$('.wait').remove();
				},	
				success:function(json){ 
				    //alert(json['cost']);
			        var dbuy='<?php echo $dbuy;?>';
				    $.ajax({
						url: 'index.php?route=checkout/checkout/refreshTotal',
						data:'dbuy='+dbuy,
						dataType: 'html',
						success: function(html) {
							$('.moneyinfo').html(html);
						}
					});
				}
				
			
			});	
	    });
   
   });
   
   
   
   //点击单选按钮,设置默认收货地址
   $(".sendAddress>dl").live('click',function(){
      var self=$(this);
   
	  if(!confirm('您要设置此项为默认收货地址吗?')) return false;
	  var dataid=$.trim($(this).prop('id'));
	  
	  $.post('index.php?route=account/address/setDefault',{dataid:dataid},function(data){
	     if(data==1){
		   //alert("设置成功！");
		  
		   $(".sendAddress dl").removeClass('present');
		   self.css({'background-color':''});
           self.addClass('present');
	       self.children('dt').children('input[type=radio]').prop('checked','checked');
		 }else{
		   alert("设置失败!");
		 }
	  })
   });
   
   
   //新增地址
   $(".sendInfo").css('display','none');
   $(".new").click(function(){
      if($(".sendInfo").css('display')=='none'){
	    //$(".sendInfo").css('display','block');
		$(".sendInfo").fadeIn('slow');
	  }
   });
   
   
   //地址取消
    $(".sendInfo a.cancel").click(function(){
        if($(".sendInfo").css('display')=='block'){
	     //$(".sendInfo").css('display','none');
		 $(".sendInfo").fadeOut('slow');
	    }
    });
   
   
    $("input[name=mobile]").blur(function(){
        var   mobile=$.trim($("input[name=mobile]").val());
		var   self=$(this);
		$.ajax({
			  url:'index.php?route=account/register/ajaxMobile&mobile='+mobile,
			  dataType:'json',
			  success:function(json){	
				    if(json.mobile>=1){
					    //alert("手机号已经存在！");
						if(!self.parent().children('span').hasClass('ggg')){
					        self.parent().append('<span class="ggg">手机号已经存在！</span>');
						}
					    return false;
				    }else{
				        self.parent().children('span').remove('.ggg');
				    }
			   }
		});
    });
   
   
				 
   
   //保存地址
   $(".sendInfo a.save").click(function(){
        var count=$(".sendAddress dl").size();
		if  (count>=6){
		    alert('不能超过6条地址记录！');
			return false;
		}
		
        var arr=[];
	    var username=$.trim($(".sendInfo input[name=username]").val());

	    if(!(/^[\u4E00-\u9FA5]{2,5}$/.test(username))) {
	       arr.push("输入的用户名不少于2个汉字!");
	    }
	   
	    var mobile=$.trim($(".sendInfo input[name=mobile]").val());

	    if(!(/^1[3|4|5|8][0-9]\d{4,8}$/.test(mobile))){
		   arr.push("输入的手机号格式不正确！");
	    }
		
		var ggg=$("input[name=mobile]").siblings('.ggg').html();
		if(ggg){
		   arr.push("手机号已经存在！");
		}
	   
	    if(telephone){
			var telephone=$.trim($(".sendInfo input[name=telephone]").val());
			if(!(/(^0\d{2,3}-?)?\d{7,8}$/.test(telephone))) {
			   arr.push("输入的电话不正确!");
			}
	    }
		
	    var address=$.trim($(".sendInfo input[name=address]").val());
	    if(!(/^[\w\u4E00-\u9FA5]{5,}$/.test(address))) {
	       arr.push("输入的地址不正确!");
	    }
	   
	    if(postcode){
			var postcode=$(".sendInfo input[name=postcode]").val();
			if(!(/^[1-9][0-9]{5,5}$/.test(postcode))) {
			   arr.push("输入的邮编不正确!");
			}
	    }
		
	    if (arr.length>0){
	      var s;
		  s=arr.join("\n");
		  alert(s);
	      return false;
	   
	    }
	   
	    $.post('index.php?route=account/address/insert',{username:username,mobile:mobile,telephone:telephone,address:address,postcode:postcode},function(data){
		    if (data){
			    alert("新增成功!");
			    var dl=$("<dl id='"+data+"'><dt><input  name='addressopt' type='radio'  /></dt><dd>"+address+' '+username+"<span class='mobile'> "+mobile+"</span></dd> </dl>");
				$(".sendAddress").append(dl);
			    $(".sendInfo input").val('');
			    $(".sendInfo").fadeOut('slow');
		     
		    }else{
		        alert("新增失败！");
		    }
	    });
    });
</script>
<?php echo $footer;?>