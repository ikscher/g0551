<link rel="stylesheet" type="text/css" href="view/stylesheet/general.css">
<link rel="stylesheet" type="text/css" href="view/stylesheet/main.css">
<script type="text/javascript" src="view/javascript/jquery/jquery-1.7.1.min.js"></script>


<?php if($error_warning) { ?>
<div class="warning"><?php echo $error_warning;?></div>
<?php } ?>
   
    <h1 ><?php echo $heading_title;?>
		<span class="action-span">
		    <a href="javascript:void(0)" onclick="$('#form').submit();" ><span><?php echo $button_save;?></span></a>
			<a href="<?php echo $cancel;?>" ><span><?php echo $button_cancel;?></span></a>
    </h1>
   <div class="list-div" id="listDiv">
    <form action="<?php echo $action;?>" method="post" enctype="multipart/form-data" id="form">
      <table class="form">
	    <tr>
			<td><span class="required">*</span> <?php echo $entry_store;?><br>(请选择店铺)</td>
		    <td>
			    <select name="store">
				    <?php foreach((array)$stores as $store) {?>
						<option value="<?php echo $store['store_id'];?>" <?php if($store_id==$store['store_id']) { ?>selected="selected"<?php } ?>><?php echo $store['name'];?></option>
					<?php } ?>
				</select>
			</td>
		</tr>
		<tr>
			<td><span class="required">*</span> <?php echo $entry_code;?></td>
			<td>
				<select name="payment_code">
					<?php foreach((array)$payment_bank as $key=>$pb) {?>
						<option value="<?php echo $key;?>" <?php if($key==$payment_code) { ?>selected="selected"<?php } ?>><?php echo $pb;?></option>
					<?php }?>
				</select>
			</td>
		</tr>
		<?php if($payment_code=='alipay') { ?>
			
		    
			<tr class="alipay">
			<td><span class="required">*</span> <?php echo $entry_trade_type;?><br>(请根据对应的接口填入正确的参数)</td>
			  <td>
				<?php if($alipay_trade_type=='trade_create_by_buyer') { ?>
					<label for="trade_create_by_buyer">双接口</label>：<input type="radio" name="alipay_trade_type" id="trade_create_by_buyer" value="trade_create_by_buyer"  checked="true"/>&nbsp;&nbsp;
					<label for="create_direct_pay_by_user">直接到帐：<input type="radio" name="alipay_trade_type" id="create_direct_pay_by_user" value="create_direct_pay_by_user"/>&nbsp;&nbsp;
					<label for="create_partner_trade_by_buyer">担保接口：<input type="radio" name="alipay_trade_type" id="create_partner_trade_by_buyer" value="create_partner_trade_by_buyer"/>&nbsp;&nbsp;
				<?php } elseif ($alipay_trade_type=='create_direct_pay_by_user') { ?>
					<label for="trade_create_by_buyer">双接口：<input type="radio" name="alipay_trade_type"  id="trade_create_by_buyer" value="trade_create_by_buyer"/>&nbsp;&nbsp;
					<label for="create_direct_pay_by_user">直接到帐：<input type="radio" name="alipay_trade_type"  id="create_direct_pay_by_user" value="create_direct_pay_by_user"  checked="true"/>&nbsp;&nbsp;
					<label for="create_partner_trade_by_buyer">担保接口：<input type="radio" name="alipay_trade_type"  id="create_partner_trade_by_buyer" value="create_partner_trade_by_buyer"/>&nbsp;&nbsp;
				<?php } else { ?>
					<label for="trade_create_by_buyer">双接口</label>：<input type="radio" name="alipay_trade_type" id="trade_create_by_buyer" value="trade_create_by_buyer"/>&nbsp;&nbsp;
					<label for="create_direct_pay_by_user">直接到帐：<input type="radio" name="alipay_trade_type" id="create_direct_pay_by_user"  value="create_direct_pay_by_user"/>&nbsp;&nbsp;
					<label for="create_partner_trade_by_buyer">担保接口：<input type="radio" name="alipay_trade_type"  id="create_partner_trade_by_buyer" value="create_partner_trade_by_buyer"  checked="true"/>&nbsp;&nbsp;
				<?php } ?>
			</td>
			</tr>
			<tr class="alipay">
			  <td><span class="required">*</span> <?php echo $entry_partner;?></td>
			  <td><input type="text" name="alipay_partner" value="<?php echo $alipay_partner;?>" size="50" />
		  <?php if($error_partner) { ?>
				<span class="error"><?php echo $error_partner;?></span>
				<?php } ?></td>
			</tr>

			<tr class="alipay">
			  <td><span class="required">*</span> <?php echo $entry_security_code;?></td>
			  <td><input type="text" name="alipay_security_code" value="<?php echo $alipay_security_code;?>" size="50" />
		  <?php if($error_secrity_code) { ?><span class="error"><?php echo $error_secrity_code;?></span><?php } ?></td>
			</tr>
		   <tr class="alipay">
			  <td><span class="required">*</span> <?php echo $entry_seller_email;?></td>
			  <td><input type="text" name="alipay_seller_email" value="<?php echo $alipay_seller_email;?>" size="50" />
				<?php if($error_email) { ?> <span class="error"><?php echo $error_email;?></span><?php } ?></td>
			</tr>
		 
			<!--
				<tr>
					  <td><span class="required">*</span> <?php echo $entry_anti_phishing;?></td>
					  <td>
					   <?php if(($alipay_anti_phishing==1)) { ?>
							Yes:&nbsp;<input type="radio" name="alipay_anti_phishing" value="1" checked="true"/>&nbsp;&nbsp;
							No:&nbsp;<input type="radio" name="alipay_anti_phishing" value="0"/>&nbsp;&nbsp;
						<?php } else { ?>
							Yes:&nbsp;<input type="radio" name="alipay_anti_phishing" value="1"/>&nbsp;&nbsp;
							No:&nbsp;<input type="radio" name="alipay_anti_phishing" value="0" checked="true"/>&nbsp;&nbsp;
						<?php } ?>
					</td>
				</tr>
			-->
		<?php } elseif ($payment_code=='cod' || $payment_code=='bank' || $payment_code=='post') { ?>
		    
			<tr class="other">
			    <td style="text-align:right;padding-right:10px;width:40%"><span class="required">*</span> <?php echo $entry_description;?></td>
				<td><textarea name="description" style="width:373px;height:96px" ><?php echo $description;?></textarea></td>
			</tr>
            
		<?php } ?>
		
        <tr>
          <td><?php echo $entry_order_status;?></td>
          <td><select name="alipay_order_status_id">
              <?php foreach((array)$order_statuses as $order_status) {?>
                 <?php if($order_status['order_status_id'] == $alipay_order_status_id) { ?>
                    <option value="<?php echo $order_status['order_status_id'];?>" selected="selected"><?php echo $order_status['name'];?></option>
                 <?php } else { ?>
                    <option value="<?php echo $order_status['order_status_id'];?>"><?php echo $order_status['name'];?></option>
                  <?php } ?>
              <?php } ?>
            </select></td>
        </tr>
        <tr>
          <td><?php echo $entry_status;?></td>
          <td><select name="alipay_status">
              <?php if($alipay_status) { ?>
              <option value="1" selected="selected"><?php echo $text_enabled;?></option>
              <option value="0"><?php echo $text_disabled;?></option>
              <?php } else { ?>
              <option value="1"><?php echo $text_enabled;?></option>
              <option value="0" selected="selected"><?php echo $text_disabled;?></option>
              <?php } ?>
            </select></td>
        </tr>
        <tr>
          <td><?php echo $entry_sort_order;?></td>
          <td><input type="text" name="alipay_sort_order" value="<?php echo $alipay_sort_order;?>" size="10" /></td>
        </tr>
		 <tr>
          <td>&nbsp;</td>
          <td>使用注意已经存在CNY的人民币汇率设置。Code为CNY</td>
        </tr>
      </table>
    </form>
  </div>
    <script type="text/javascript">
        $('select[name=payment_code]').change(function(){
	        $("tr.alipay").css({'display':'none'});
			if($('tr.other').length<=0){
				var html='<tr class="other"><td><span class="required">*</span>描述：</td><td><textarea name="description" style="width:373px;height:96px" ></textarea></td></tr>';
				$('tr.alipay:last').after(html);
			}
			$("tr.alipay").remove();
	    });
    </script>
