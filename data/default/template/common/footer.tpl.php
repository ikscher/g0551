<link rel="stylesheet" href="catalog/view/theme/default/stylesheet/footer.css" type="text/css" />
<div id="footer" class="box cl">
	<div class="cl_div"></div>
	<!-- <div class="policy wp cl">
		<ul>
			<li><a href="javascript:void(0);"><em class="policyem1"></em></a><a href="javascript:void(0);"><b class="f1">正品保证</b></a><br /><a href="javascript:void(0);">中华保险</a></li>
			<li><em class="policyem2"></em><b class="f1">开箱验货</b><br />先验货再签收</li>
			<li><em class="policyem3"></em><b class="f1">7天保障</b><br />无理由退货</li>
			<li><em class="policyem4"></em><b class="f1">货到付款</b><br />全国范围</li>
			<li><em class="policyem5"></em><b class="f1">免运费</b><br />购满288元</li>
			<li><em class="policyem6"></em><b class="f1">积分抵现金</b><br />100分=￥1元</li>
		</ul>
	</div> -->
	<div class="support wp cl">
		<ul class="support_ser z"><li></li></ul>
		<ul class="support_lis z">
			<li class="lis_l"><dl>
				<dt><em class="supportem1"></em><a href="javascript:void(0);" class="f_j f2"><?php echo $text_manual;?></a></dt>
				<dd><a href="<?php echo $register;?>"><?php echo $text_register;?></a></dd>
				<dd><a href="<?php echo $shoppingProcess;?>"><?php echo $text_shoppingProcess;?></a></dd>
			</dl></li>
			<li class="lis_l"><dl>
				<dt><em class="supportem2"></em><a href="javascript:void(0);" class="f_j f2"><?php echo $text_shoppingMethod;?></a></dt>
				<dd><a href="<?php echo $diy;?>"><?php echo $text_diy;?></a></dd>
				<dd><a href="<?php echo $transport;?>"><?php echo $text_transport;?></a></dd>
				<dd><a href="<?php echo $arrivedIntime;?>"><?php echo $text_arrivedIntime;?></a></dd>
			</dl></li>
			<li class="lis_l"><dl>
				<dt><em class="supportem3"></em><a href="javascript:void(0);" class="f_j f2"><?php echo $text_payMethod;?></a></dt>
				<dd><a href="<?php echo $payment;?>"><?php echo $text_payment;?></a></dd>
				<dd><a href="<?php echo $onlinePay;?>"><?php echo $text_onlinePay;?></a></dd>
				<dd><a href="<?php echo $installments;?>"><?php echo $text_installments;?></a></dd>
			</dl></li>
			<li class="lis_l"><dl>
				<dt><em class="supportem4"></em><a href="javascript:void(0);" class="f_j f2"><?php echo $text_support;?></a></dt>
				<dd><a href="<?php echo $exchange;?>"><?php echo $text_exchange;?></a></dd>
				<dd><a href="<?php echo $warrant;?>"><?php echo $text_warrant;?></a></dd>
			</dl></li>
			<li class="lis_l"><dl>
				<dt><em class="supportem5"></em><a href="javascript:void(0);" class="f_j f2"><?php echo $text_help;?></a></dt>
				<dd><a href="<?php echo $forgotten;?>"><?php echo $text_forgotten;?></a></dd>
				<dd><a href="<?php echo $faq;?>"><?php echo $text_faq;?></a></dd>
				<dd><a href="<?php echo $feedback;?>"><?php echo $text_feedback;?></a></dd>
				<dd><a href="<?php echo $contact;?>"><?php echo $text_contact;?></a></dd>
			</dl></li>
			<li><dl>
				<dt><em class="supportem6"></em><a href="javascript:void(0);" class="f_j f2"><?php echo $text_aboutus;?></a></dt>
				<dd><a href="<?php echo $company;?>"><?php echo $text_company;?></a></dd>
			</dl></li>
		</ul>
	</div>
	<div class="bottom wp cl tc">
		<?php echo $bottom;?><p><?php echo $address;?> <?php echo $telephone;?> <?php echo $icp;?></p>
	</div>
	
	<div class="cart-bottom">
	    <?php echo $cart_bottom;?>
	</div>
</div>

</body>
<script type="text/javascript">
    <?php if(empty($userid)) { ?>
		$(".tmMCHandler").hover(function(){
			$(this).addClass('unlogin_hover');
			$(".tmMCNum").css({'display':'none'});
		},function(){
			$(this).removeClass('unlogin_hover');
			$(".tmMCNum").css({'display':'inline-block'});
		}).click(function(){
			window.location.href='index.php?route=account/login';
		});
	<?php } ?>
	
	$("#J_BrandBar").hover(function(){
	    $(this).css({'background-color':'#D9D1D1'});
	},function(){
	    $(this).css({'background-color':'#EEE'});
	});
	
	$(".tmMCBotLink .tmMCNum").hover(function(){
		$(this).css({'color':'white'});
	},function(){
		$(this).css({'color':'black'});
	});
		
	/*弹出伸缩*/
	<?php if($countProducts>0) { ?>
        $("#J_TMiniCart").css({'width':'283px'});
        
		/*
		$(".tmMCHdLeft").toggle(function(){
			$(".tmMCBody").css({'display': 'block', 'top': '-283px',' -webkit-transition':'none'});
			$(".tmMCLoading").css({'display': 'none', 'margin-top': '5px'});
			$(".tmMCCon").css({'height': '269px', 'overflow-y': 'scroll'});
			$('.tmMCHandler').removeClass('HdlShort');
		},function(){
			$('.tmMCHandler').addClass('HdlShort');
			$(".tmMCBody").css({'display': 'none', 'top': '-4px', '-webkit-transition': 'none'});
		});
		*/
	<?php } ?>
</script>
</html>