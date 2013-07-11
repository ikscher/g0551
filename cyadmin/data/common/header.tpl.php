<!DOCTYPE HTML>
<html dir="<?php echo $direction;?>" lang="<?php echo $lang;?>">
<head>
<meta charset="UTF-8" />
<title><?php echo $title;?></title>
<base href="<?php echo $base;?>" />
<?php if($description) { ?>
<meta name="description" content="<?php echo $description;?>" />
<?php } ?>
<?php if($keywords) { ?>
<meta name="keywords" content="<?php echo $keywords;?>" />
<?php } ?>

<?php if($icon) { ?>
<link href="<?php echo $icon;?>" rel="icon" />
<?php } ?>
<!-- <?php foreach((array)$links as $link) {?>
<link href="<?php echo $link['href'];?>" rel="<?php echo $link['rel'];?>" />
<?php } ?> -->
<!-- <link rel="stylesheet" type="text/css" href="view/stylesheet/stylesheet.css" />  -->
<!-- <?php foreach((array)$styles as $style) {?>
<link rel="<?php echo $style['rel'];?>" type="text/css" href="<?php echo $style['href'];?>" media="<?php echo $style['media'];?>" />
<?php } ?> -->


<!-- <link rel="stylesheet" type="text/css" href="../themes/icon.css"> -->
<script type="text/javascript" src="view/javascript/jquery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="view/javascript/jquery/jquery.easyui.min.js"></script>
<script type="text/javascript" src="view/javascript/jquery/outlook.js"></script>
<link rel="stylesheet" type="text/css" href="view/stylesheet/easyui.css">
<!-- <script type="text/javascript" src="view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
<link type="text/css" href="view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" /> -->
<!-- <script type="text/javascript" src="view/javascript/jquery/tabs.js"></script> -->
<!-- <script type="text/javascript" src="view/javascript/jquery/superfish/js/superfish.js"></script> -->

<!-- <?php foreach((array)$scripts as $script) {?>
<script type="text/javascript" src="<?php echo $script;?>"></script>
<?php } ?> -->

<script type="text/javascript">
//-----------------------------------------
// Confirm Actions (delete, uninstall)
//-----------------------------------------
$(document).ready(function(){
    // Confirm Delete
    $('#form').submit(function(){
        if ($(this).attr('action').indexOf('delete',1) != -1) {
            if (!confirm('<?php echo $text_confirm;?>')) {
                return false;
            }
        }
    });
    	
    // Confirm Uninstall
    $('a').click(function(){
        if ($(this).attr('href') != null && $(this).attr('href').indexOf('uninstall', 1) != -1) {
            if (!confirm('<?php echo $text_confirm;?>')) {
                return false;
            }
        }
    });
});
</script>
</head>
<body class="easyui-layout">

    <!-- <?php if($logged) { ?> -->
	   <div data-options="region:'north',border:false" style="padding-top:5px;overflow: hidden; height: 30px;background: url(view/image/header.png) #7f99be repeat-x center 50%;line-height: 20px;color: #fff; font-family: Verdana, 微软雅黑,黑体">
	   <span style="position:absolute;top:<?php if($GLOBALS['ccid']) { ?>-6px<?php } else { ?>2px<?php } ?>;left:190px;">
		
		</span> 
		<span style="float:right; padding-right:20px;" class="head"> 
			<!-- <?php if((!empty($chang_user) && !empty($_GET['change_uid'])) || !empty($GLOBALS['_MooCookie']['change_identity'])) { ?>  -->
				<span style="font-weight:bold;color:red;font-size:14px;"> 您当前登录的用户名是：<?php echo $username;?>, ID是:<?php echo $userid;?>。 <!-- <a href="index.php?action=login&h=logout_change_identify">返回我的身份</a>  -->
					<span onclick="parent.location.href='index.php'" style="cursor:pointer;font-size:14px;color:#fff;" id="change_identify"></span> 
				</span> 
			<!-- <?php } ?> -->
		
		
		当前登录管理员：<?php echo $username;?> ID：<?php echo $userid;?>   身份： <a href="index.php?route=common/logout" id="loginOut">安全退出</a> <a href="<?php echo $home;?>"> 商城首页</a></span> <span style="padding-left:10px; font-size: 16px; font-family:微软雅黑,黑体"> <img src="view/image/top_logo.png" width="20" height="20" align="absmiddle" /> 安徽穿悦电子网络商城后台管理系统 </span> 

		
		</div>
	<!-- <?php } else { ?>
       <div class="div1"></div>
	<?php } ?> -->
	
    <!-- <?php if($logged) { ?> -->
    <div class="div3"><img src="view/image/lock.png" alt="" style="position: relative; top: 3px;" />&nbsp;<?php echo $logged;?></div>
    <!-- <?php } ?> -->
  </div>
  <!-- <?php if($logged) { ?> -->
  
  <div data-options="region:'west',split:true" title="导航菜单" style="width:200px;padding1:1px;overflow:hidden;">
		<div class="easyui-accordion" data-options="fit:true,border:false">
			<div title="<?php echo $text_catalog;?>" style="padding:10px;overflow:auto;">
				  <p><a data-role="<?php echo $category;?>"><?php echo $text_category;?></a></p>
				  <p><a data-role="<?php echo $product;?>"><?php echo $text_product;?></a></p>
				  <!-- <p><a class="parent"><?php echo $text_attribute;?></a> -->
					
				  <p><a data-role="<?php echo $attribute;?>"><?php echo $text_attribute;?></a></p>
				  <p><a data-role="<?php echo $attribute_group;?>"><?php echo $text_attribute_group;?></a></p>
				  <p><a data-role="<?php echo $category_to_attribute_group;?>"><?php echo $text_category_to_attribute_group;?></a></p>
				
				 
				  <p><a data-role="<?php echo $option;?>"><?php echo $text_option;?></a></p>
				  <p><a data-role="<?php echo $manufacturer;?>"><?php echo $text_manufacturer;?></a></p>
				  <p><a data-role="<?php echo $download;?>"><?php echo $text_download;?></a></p>
				  <p><a data-role="<?php echo $review;?>"><?php echo $text_review;?></a></p>
				  <p><a data-role="<?php echo $information;?>"><?php echo $text_information;?></a></p>
			</div>
			
			<div title="<?php echo $text_extension;?>" data-options="selected:true" style="padding:10px;">
				  <p><a data-role="<?php echo $module;?>"><?php echo $text_module;?></a></p>
				  <p><a data-role="<?php echo $shipping;?>"><?php echo $text_shipping;?></a></p>
				  <p><a data-role="<?php echo $payment;?>"><?php echo $text_payment;?></a></p>
				  <p><a data-role="<?php echo $total;?>"><?php echo $text_total;?></a></p>
				  <p><a data-role="<?php echo $feed;?>"><?php echo $text_feed;?></a></p>
			</div>
			
			<div title="<?php echo $text_sale;?>" style="padding:10px">
				  <p><a data-role="<?php echo $order;?>"><?php echo $text_order;?></a></p>
				  <p><a data-role="<?php echo $return;?>"><?php echo $text_return;?></a></p>
				 <!--  <p><a class="parent"><?php echo $text_customer;?></a>
					<ul> -->
					  <p><a data-role="<?php echo $customer;?>"><?php echo $text_customer;?></a></p>
					  <p><a data-role="<?php echo $customer_group;?>"><?php echo $text_customer_group;?></a></p>
					  <p><a data-role="<?php echo $customer_blacklist;?>"><?php echo $text_customer_blacklist;?></a></p>
				<!-- 	</ul>
				  </p> -->
				  <p><a data-role="<?php echo $affiliate;?>"><?php echo $text_affiliate;?></a></p>
				  <p><a data-role="<?php echo $coupon;?>"><?php echo $text_coupon;?></a></p>
				 <!--  <p><a class="parent"><?php echo $text_voucher;?></a>
					<ul> -->
					  <p><a data-role="<?php echo $voucher;?>"><?php echo $text_voucher;?></a></p>
					  <p><a data-role="<?php echo $voucher_theme;?>"><?php echo $text_voucher_theme;?></a></p>
					<!-- </ul>
				  </p> -->
				  <p><a data-role="<?php echo $contact;?>"><?php echo $text_contact;?></a></p>
			</div>
			
			<div title="<?php echo $text_system;?>" style="padding:10px">
			          <p><a data-role="<?php echo $setting;?>"><?php echo $text_setting;?></a></p>
					  <p><a data-role="<?php echo $storePayment;?>"><?php echo $text_store_payment;?></a></p>
					  <!-- <p><a class="parent"><?php echo $text_design;?></a>
						<ul> -->
						<!--   <p><a data-role="<?php echo $layout;?>"><?php echo $text_layout;?></a></p>
						  <p><a data-role="<?php echo $banner;?>"><?php echo $text_banner;?></a></p> -->
					<!-- 	</ul>
					  </p> -->
					 <!--  <p><a class="parent"><?php echo $text_users;?></a>
						<ul> -->
						  <p><a data-role="<?php echo $user;?>"><?php echo $text_user;?></a></p>
						  <p><a data-role="<?php echo $user_group;?>"><?php echo $text_user_group;?></a></p>
						  <p><a data-role="<?php echo $user_action;?>"><?php echo $text_user_action;?></a></p>
					<!-- 	</ul>
					  </p> -->
					 <!--  <p><a class="parent"><?php echo $text_localisation;?></a>
						<ul> -->
						 <!--  <p><a data-role="<?php echo $language;?>"><?php echo $text_language;?></a></p>
						  <p><a data-role="<?php echo $currency;?>"><?php echo $text_currency;?></a></p> -->
						  <p><a data-role="<?php echo $stock_status;?>"><?php echo $text_stock_status;?></a></p>
						  <p><a data-role="<?php echo $order_status;?>"><?php echo $text_order_status;?></a></p>
						  <!-- <p><a class="parent"><?php echo $text_return;?></a>
							<ul> -->
							  <p><a data-role="<?php echo $return_status;?>"><?php echo $text_return_status;?></a></p>
							  <p><a data-role="<?php echo $return_action;?>"><?php echo $text_return_action;?></a></p>
							  <p><a data-role="<?php echo $return_reason;?>"><?php echo $text_return_reason;?></a></p>
							<!-- </ul>
						  </p> -->
						 <!--  <p><a data-role="<?php echo $country;?>"><?php echo $text_country;?></a></p>
						  <p><a data-role="<?php echo $zone;?>"><?php echo $text_zone;?></a></p>
						  <p><a data-role="<?php echo $geo_zone;?>"><?php echo $text_geo_zone;?></a></p> -->
						 <!--  <p><a class="parent"><?php echo $text_tax;?></a>
							<ul> -->
							  <!-- <p><a data-role="<?php echo $tax_class;?>"><?php echo $text_tax_class;?></a></p>
							  <p><a data-role="<?php echo $tax_rate;?>"><?php echo $text_tax_rate;?></a></p> -->
						<!-- 	</ul>
						  </p> -->
						  <p><a data-role="<?php echo $length_class;?>"><?php echo $text_length_class;?></a></p>
						  <p><a data-role="<?php echo $weight_class;?>"><?php echo $text_weight_class;?></a></p>
						<!-- </ul>
					  </p> -->
					  <p><a data-role="<?php echo $error_log;?>"><?php echo $text_error_log;?></a></p>
					  <p><a data-role="<?php echo $update;?>"><?php echo $text_update;?></a></p>
					  <p><a data-role="<?php echo $enviorment;?>"><?php echo $text_enviorment;?></a></p>
					  <!-- <p><a data-role="<?php echo $backup;?>"><?php echo $text_backup;?></a></p> -->
			</div>
			
			<div title="<?php echo $text_reports;?>" style="padding:10px">
			         <!-- <p><a class="parent"><?php echo $text_sale;?></a>
						<ul> -->
						  <p><a data-role="<?php echo $report_sale_order;?>"><?php echo $text_report_sale_order;?></a></p>
						  <p><a data-role="<?php echo $report_sale_tax;?>"><?php echo $text_report_sale_tax;?></a></p>
						  <p><a data-role="<?php echo $report_sale_shipping;?>"><?php echo $text_report_sale_shipping;?></a></p>
						  <p><a data-role="<?php echo $report_sale_return;?>"><?php echo $text_report_sale_return;?></a></p>
						  <p><a data-role="<?php echo $report_sale_coupon;?>"><?php echo $text_report_sale_coupon;?></a></p>
						<!-- </ul>
					  </p> -->
					 <!--  <p><a class="parent"><?php echo $text_product;?></a>
						<ul> -->
						  <p><a data-role="<?php echo $report_product_viewed;?>"><?php echo $text_report_product_viewed;?></a></p>
						  <p><a data-role="<?php echo $report_product_purchased;?>"><?php echo $text_report_product_purchased;?></a></p>
						<!-- </ul>
					  </p> -->
					<!--   <p><a class="parent"><?php echo $text_customer;?></a>
						<ul> -->
						  <p><a data-role="<?php echo $report_customer_onpne;?>"><?php echo $text_report_customer_online;?></a></p>
						  <p><a data-role="<?php echo $report_customer_order;?>"><?php echo $text_report_customer_order;?></a></p>
						  <p><a data-role="<?php echo $report_customer_reward;?>"><?php echo $text_report_customer_reward;?></a></p>
						  <p><a data-role="<?php echo $report_customer_credit;?>"><?php echo $text_report_customer_credit;?></a></p>
						<!-- </ul>
					  </p> -->
					 <!--  <p><a class="parent"><?php echo $text_affiliate;?></a>
						<ul> -->
						  <p><a data-role="<?php echo $report_affiliate_commission;?>"><?php echo $text_report_affiliate_commission;?></a></p>
						<!-- </ul>
					  </p> -->
			</div>
			
			<div title="<?php echo $text_show;?>" style="padding:10px;">
			    <p><a data-role="<?php echo $show_contents;?>"><?php echo $text_show_contents;?></a></p>
				<p><a data-role="<?php echo $show_comments;?>"><?php echo $text_show_comments;?></a></p>
			</div>
			
			<div title="<?php echo $text_try;?>" style="padding:10px;">
			    <p><a data-role="<?php echo $try;?>"><?php echo $text_all_try;?></a></p>
			</div>
			
			
			
			<div title="<?php echo $text_help;?>"  style="padding:10px">
			        <p><a onClick="window.open('http://www.opencart.com');"><?php echo $text_opencart;?></a></p>
					  <p><a onClick="window.open('http://www.opencart.com/index.php?route=documentation/introduction');"><?php echo $text_documentation;?></a></p>
					  <p><a onClick="window.open('http://forum.opencart.com');"><?php echo $text_support;?></a></p>
			</div>
		</div>
	</div>
	
	<!-- content -->
	<div data-options="region:'center'">  <!-- title="Main Title" style="overflow:hidden;" -->
	    <div id="tt" class="easyui-tabs" data-options="tools:'#tab-tools',fit:true" >
		
			<!-- <div title="Tab1" style="padding:20px;overflow:hidden;"> 
				<div style="margin-top:20px;">
					<h3>jQuery EasyUI framework help you build your web page easily.</h3>
					<ul>
						<li>easyui is a collection of user-interface plugin based on jQuery.</li> 
						<li>using easyui you don't write many javascript code, instead you defines user-interface by writing some HTML markup.</li> 
						<li>easyui is very easy but powerful.</li> 
					</ul>
				</div>
			</div>
			<div title="Tab2" data-options="closable:true" style="padding:20px;">This is Tab2 width close button.</div> -->

<!--以下footer部分-->			
<!-- 		
        </div>
	</div>
  
  
 
 <?php } ?>

</body>
</html> -->