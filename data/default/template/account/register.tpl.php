<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="catalog/view/theme/default/stylesheet/login.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="catalog/view/javascript/jquery-1.8.0.min.js" ></script>
<?php if($icon) { ?>
<link href="<?php echo $icon;?>" rel="icon" />
<?php } ?>
<title>穿悦网注册</title>
</head>
<body class="reg_bg">
<div class="baseWidth mgc">
	<!--logo -->
	<div id="header" class="mgc">
    	<a href="<?php echo $home;?>" title="返回穿悦网首页" class="logo jL_sprite clearfont"></a>
        <div class="channer jL_sprite clearfont"></div>
    </div>
	<!--logo end -->
	<!--主体 -->
    <div id="content">
    	<div class="nav_bar">
		    <ul class="tabs_list">
				<li class="current"><span data-role="buyer">买家<span></li>
				<li><span data-role="seller">卖家</span></li>
			</ul>
		   <span class="fr">已注册？<a href="<?php echo $login;?>" title="登录">登录</a></span>
        </div>
    	<div class="content_bg">
        	<div class="CB_top jL_sprite clearfont"></div>
            <div class="CB_content"><div class="CB_OA_click"></div></div>
            <div class="CB_bottom jL_sprite clearfont"></div>
        </div>
        	<form class="reg_form" id="user_reg_form" action="<?php echo $action;?>" method="post">
                <div class="form_content">
                	<ul class="input_ul">
		                <li>
						    <dl class="IU_title">店铺名称：</dl>
                            <dl class="IU_input"><input type="text" class="IUI_box_L" name="store" value="请输入您的店铺名称" onfocus="if(this.value=='请输入您的店铺名称'){this.value='';}" onblur="if(this.value==''){this.value='请输入您的店铺名称';}">
                            </dl>
						</li>
						
						<li>
						    <dl class="IU_title">店主姓名：</dl>
                            <dl class="IU_input"><input type="text" class="IUI_box_L" name="yourname" value="请输入您的姓名" onfocus="if(this.value=='请输入您的姓名'){this.value='';}" onblur="if(this.value==''){this.value='请输入您的姓名';}">
                            </dl>
						</li>
						
						<li>
						    <dl class="IU_title">联系电话：</dl>
                            <dl class="IU_input"><input type="text" class="IUI_box_L" name="telphone" value="请输入您的联系电话" onfocus="if(this.value=='请输入您的联系电话'){this.value='';}" onblur="if(this.value==''){this.value='请输入您的联系电话';}">
                            </dl>
						</li>
						
                    	<li>
                            <dl class="IU_title">邮箱：</dl>
                            <dl class="IU_input"><input type="text" class="IUI_box_L" name="email" value="请输入您的邮箱" onfocus="if(this.value=='请输入您的邮箱'){this.value='';}" onblur="if(this.value==''){this.value='请输入您的邮箱';}">
                            </dl>
                        </li>
						
						<li>
                            <dl class="IU_title">手机号：</dl>
                            <dl class="IU_input"><input type="text" class="IUI_box_L" name="mobile" value="请输入手机号" onfocus="if(this.value=='请输入手机号'){this.value='';}" onblur="if(this.value==''){this.value='请输入手机号';}">
                            </dl>
                        </li>
						
						
                        <li>
                        	<dl class="IU_title">性别：</dl>
                            <dl class="IU_input IU_sex">
                            	  <label id="sex_m_lab" class="IUS_click jL_sprite" >先生</label>
                            	  <label id="sex_l_lab" class="IUS_noclick jL_sprite" >女士</label>
                                   <input  type="hidden" id="gender" name="gender" value="1"/> 
								   
                            </dl>
                        </li>
                        <li>
                        	<dl class="IU_title">密码：</dl>
                            <dl class="IU_input">
                                <input class="IUI_box_L pswt"  type="password" value=""  name="password" >
                                <!-- <input type="password" class="IUI_box_L IUIB_L_Hover pswh" name="password" style="display:none"> -->
                            </dl>
                        </li>
                        <li>
                        	<dl class="IU_title">确认密码：</dl>
                            <dl class="IU_input">
                                <input class="IUI_box_L pswt" type="password" value=""  name="confirm" >
                                <!-- <input type="password" class="IUI_box_L IUIB_L_Hover pswh"  name="confirm" style="display:none"> -->
                            </dl>
                        </li>
                        <li class="IU_input_code">
                        	<dl class="IU_title">验证码：</dl>
                            <dl class="IU_input"><input type="text" class="IUI_box_S"  id="captcha" name="captcha" value="">
                            </dl>
                           
                            <dl class="IU_changCode">
				
							    <img id="code"  style="cursor:pointer" src="index.php?route=account/register/captcha" border="0" onclick="javascript:this.src='index.php?route=account/register/captcha&update=' + Math.random();" />
                            </dl>
                            <dl class="IU_rtip jL_sprite"></dl>
                        </li>
						
						
						
                        <li class="IU_input_submit">
                        	<dl class="IU_title"><img src="catalog/view/theme/default/image/login/reg_loading.gif" width="20" height="20" class="user_loading" style="display: none;"></dl>
                            <dl class="IU_input"><input type="submit" id="sbt" class="IU_submit jL_sprite" value="" /><span class="IU_submit_shadow jL_sprite"></span></dl>
                        </li>
				
                      	<li class="IU_terms_li">
                       		<dl class="IU_title"></dl>
                            <dl class="IU_input">
                            	<label  class="IU_terms IU_terms_Hover jL_sprite clearfont fl"><input type="checkbox" name="terms" value="1" checked="checked" /></label>
                                <em class="IU_terms_text fl" id="terms"  >我已阅读并接受<a href="http://www.g0551.com" target="_blank">穿悦商城</a>服务条款。</em>
                                <!-- <input id="saveagree" type="hidden" name="agree" value="1" class="IU_terms_value"/> -->
                                <div class="IUI_tip">
                                    <span class="IUIT_icon fl clearfont"></span>
                                    <span class="fl IUIT_content">接受服务条款才能注册</span>
                                    <em class="IUIT_arrow clearfont"></em>
                                </div>
                            </dl>
                        </li>
                    </ul>
                </div>
				<input type='hidden'  name='isMerchants' value='0' />
            </form>
        
    </div>
    <div id="footer">
    	<p class="ft_text"><?php echo $bottom;?> <?php echo $icp;?></p>
    </div>
</div>
</body>
<script type="text/javascript">

   $(document).ready(function(){
	   $("#sex_m_lab").click(function(){  //男生
		   if ($(this).attr("class")=="IUS_noclick jL_sprite") {
			  $(this).removeClass("IUS_noclick jL_sprite");
			  $(this).addClass("IUS_click jL_sprite");
			  
			 if($("#sex_l_lab").attr("class")=="IUS_click jL_sprite") {
				  $("#sex_l_lab").removeClass("IUS_click jL_sprite");
				  $("#sex_l_lab").addClass("IUS_noclick jL_sprite");

			   }
			  $("#gender").val('1');
		   }
	   });
	   
	   $("#sex_l_lab").click(function(){ //女士
		   if ($(this).attr("class")=="IUS_noclick jL_sprite") {
			  $(this).removeClass("IUS_noclick jL_sprite");
			  $(this).addClass("IUS_click jL_sprite");
			  
			   if($("#sex_m_lab").attr("class")=="IUS_click jL_sprite") {
				  $("#sex_m_lab").removeClass("IUS_click jL_sprite");
				  $("#sex_m_lab").addClass("IUS_noclick jL_sprite");

			   }
			   
			   $("#gender").val("2");
		   }
	   });
   
   
	   $("#terms").click(function(){
		 if(!($("input[name=terms]").prop("checked"))){
		     $("input[name=terms]").attr("checked",true);
			 $("input[name=terms]").val(1); //选中值1
			 //console.log(1);
		 
		 }else if ($("input[name=terms]").prop("checked")) {
		     $("input[name=terms]").attr("checked",false);
			 $("input[name=terms]").val(0);
			 //console.log(0);
		 }
	   
	   });
	   
	    $("ul.input_ul li:lt(3)").css({'display':'none'});
	    $(".tabs_list li").click(function(){
	        $(this).parent().children('li').removeClass('current');
			$(this).addClass('current');
			
			if($(this).children('span').attr('data-role')=='buyer'){
			    $("ul.input_ul li:lt(3)").css({'display':'none'});
				$("ul.input_ul li").css({'height':'36px'});
				$("ul.input_ul li dl").css({'height':'36px'});
				$('input[name=isMerchants]').val(0);//会员注册
			}else if ($(this).children('span').attr('data-role')=='seller'){
			    $("ul.input_ul li:lt(3)").css({'display':'block'});
				$("ul.input_ul li").css({'height':'25px'});
				$("ul.input_ul li dl").css({'height':'25px'});
				$('input[name=isMerchants]').val(1);//店铺注册
			}
		
		});
	   
	
   });
   
   var register={  
                finished:true,
                output:[],

                check:function(){
				    var   arr=[];
				   
				    var   store=$.trim($("input[name=store]").val());
				    var   name=$.trim($("input[name=yourname]").val());
					var   telphone=$.trim($("input[name=telphone]").val());
				    var   email=$.trim($("input[name=email]").val());
				    var   mobile=$.trim($("input[name=mobile]").val());
				    var   password=$.trim($("input[name=password]").val());
				    var   confirm=$.trim($("input[name=confirm]").val());
					var   isMerchants=$.trim($("input[name=isMerchants]").val());
			        
					if($("ul.input_ul li:eq(0)").css('display')=='block'){
					    if(store=='请输入您的店铺名称') { store='';}
					    //if(!(/^[\u4E00-\u9FA5\w]{5,30}$/.test(store))) {
						if(!store){
						   arr.push("输入您的店铺名称!");
						}
					}
					
					if($("ul.input_ul li:eq(1)").css('display')=='block'){
					    if(name=='请输入您的姓名') { name='';}
						if(!(/^[\u4E00-\u9FA5\w]{2,5}$/.test(name))) {
						   arr.push("输入的姓名 2至5 个汉字!");
						}
					}
					
					if($("ul.input_ul li:eq(2)").css('display')=='block'){
						if(!(/(^0\d{2,3}-?\d{7,8}$|^\d{7,8}$)/.test(telphone))) {
						   arr.push("输入的电话号码格式不正确!格式为：0551-12345678或12345678");
						}
					}
					
				    if(!(/[_a-zA-Z\d\-\.]+@[_a-zA-Z\d\-]+(\.[_a-zA-Z\d\-]+)+$/.test(email))){ 
					    arr.push("输入的邮箱格式不正确！");
					}else{
					    register.emailfunc(arr);
					}
					
					
					if((isMerchants==0 && !isNaN(mobile)) || isMerchants==1){
						if(!(/^1[3|4|5|8][0-9]\d{4,8}$/.test(mobile))){
							arr.push("输入的手机号格式不正确！");
						}else{
							register.mobilefunc(arr);
						}
					}
					
					if(!password || !(/[\w|!@\#\$%^&\*\(\)+\|]{6,12}/.test(password))){  
					    arr.push("密码格式不正确,至少6位！");
					   
					   //return false;
					}
					
					if(password!=confirm){
					    arr.push("两次输入的密码不相同！");
					   //return false;
					}
				     
					register.validate(arr);
					
					
					if(!$("input[name=terms]").prop("checked")){
					    arr.push("接受服务条款才能注册!");
					}
					
					
					//register.output=arr.concat(arrinfo);	
					register.output=arr;
                    
					if (register.output.length>0){
					    var s;
						s=register.output.join("\n");
					    alert(s);
						return false;
				    }
					
				

                },	
				
				validate:function(x){
					var seccode = $.trim($('#captcha').val());
					seccode=seccode.toUpperCase();
					$.ajax({
						   url:'index.php?route=account/register/ajaxCaptcha&update='+Math.random(),
						   dataType:'json',
						   async:false,
						   success: function(json){	
                       	   
						   //alert(seccode);
							if(json.yzm== seccode){
								
							}else{
							  x.push("验证码不正确！");
							}
						 }
					});	
				},


		      //查看邮箱是否存在
			  // $("input[name=email]").blur(function(){
			  emailfunc:function(y){
			      
				  var   email=$.trim($("input[name=email]").val());
				  $.ajax({
				          url:'index.php?route=account/register/ajaxEmail&email='+email,
						  dataType:'json',
						  async:false,
						  success:function(json){	
						      //alert(json.email);
							  if(json.email>=1){
								//alert("邮箱已经存在！");
								//if (y.indexOf("邮箱已经存在！")<0){
								   y.push("邮箱已经存在！");
								//}
								return false;
							  }
						   }
						   
			      });
				},
				
				//查看手机号是否存在
				//$("input[name=mobile]").blur(function(){
				mobilefunc:function(z){
				  var   mobile=$.trim($("input[name=mobile]").val());
				  $.ajax({
				          url:'index.php?route=account/register/ajaxMobile&mobile='+mobile,
						  dataType:'json',
						  async:false,
						  success:function(json){	
							  if(json.mobile>=1){
								//alert("手机号已经存在！");
								if(z.indexOf("手机号已经存在！")<0){
								   z.push("手机号已经存在！");
								}
								return false;
							  }
						   }
			        });
				}			
							
			
			};
			
			$("#sbt").click(register.check);
			$(".input_ul").delegate("input[class^=IUI_box_]","focus",function(){
			  $(this).css('border','1px #F60 solid');
			});
			
			$(".input_ul").delegate("input[class^=IUI_box_]","blur",function(){
				  $(this).css('border','1px solid #DAD8DA');
			});
			  
</script>
</html>