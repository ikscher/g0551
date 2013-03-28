<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="catalog/view/theme/default/stylesheet/login.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="catalog/view/javascript/jquery-1.8.0.min.js" ></script>
<?php if($icon) { ?>
<link href="<?php echo $icon;?>" rel="icon" />
<?php } ?>
<title>穿悦网站登录</title>
</head>
<body class="login_bg">
<div class="baseWidth mgc">
	<!--logo -->
	<div id="header" class="mgc">
		<a href="<?php echo $home;?>" title="返回穿悦网首页" class="logo jL_sprite clearfont"></a>
		<div class="channel jL_sprite clearfont"></div>
	</div>
	<!--logo end -->
	<!--主体 -->
    <div id="content">
    	<div class="nav_bar">
        	<span class="fr">还没有注册？<a href="<?php echo $register;?>" title="免费注册">免费注册</a></span>
        </div>
    	<div class="content_bg">
        	<div class="CB_top jL_sprite clearfont"></div>
            <div class="CB_content"><div id="unionClick"></div></div>
            <div class="CB_bottom jL_sprite clearfont"></div>
        </div>
        	<form class="login_form" id="user_login_form" action="<?php echo $login;?>" method="post" >
            	<div class="form_content">
                	<ul class="input_ul">
                    	<li>
                        	<dl class="IU_title">用户名：</dl>
                        	<dl class="IU_input"><input type="text" class="IUI_box_L" name="username" value="手机号/邮箱" onclick="if(this.value=='手机号/邮箱'){this.value='';}" ></dl>
                        </li>
                        <li>
                        	<dl class="IU_title">密码：</dl>
                            <dl class="IU_input"><input type="password" class="IUI_box_L pswt" name="password" value="请输入密码"  ></dl>
                        </li>
                        <li>
                       		<dl class="IU_title"></dl>
                            <dl class="IU_input">
                            	<label   class="IU_terms IU_terms_Hover jL_sprite clearfont fl"><input  type="checkbox" name="remember" value="1" /></label>
                                <em class="IU_terms_text fl">记住登录账号</em>
                            </dl>
                        </li>
                        <li>
                        	<dl class="IU_title"><img src="catalog/view/theme/default/image/login/reg_loading.gif" width="20" height="20" class="user_loading" style="display: none;"></dl>
                            <dl class="IU_input IU_wrong"><input type="submit" id="sbt" class="IU_submit jL_sprite" value="" /><span class="IU_submit_shadow jL_sprite clearfont"></span></dl>
                            <dl class="IU_forgot"><a href="">忘记密码？</a></dl>
                        </li>
						
						
					    <li style="margin-top:20px;margin-left:20px;"><dl></dl><dl class="IU_title"></dl></li>
                    </ul>
            	</div>
				  <input type="hidden" name="referer" value="<?php echo $referer;?>" />
				 <?php if($redirect) { ?>
				  <input type="hidden" name="redirect" value="<?php echo $redirect;?>" />
				  <?php } ?>
            </form>        
    </div>
	<!--主体end -->
    <div id="footer">
    	<p class="ft_text"><?php echo $bottom;?> <?php echo $icp;?></p>
    </div>
</div>
</body>
<script type="text/javascript">
$("input[name=password]").val('');
var login={ 
		    check:function(){
			   var username=$.trim($(".IUI_box_L").val());
		       var   password=$.trim($("input[name=password]").val());
		
		       if(!(/^1[3|4|5|8][0-9]\d{4,8}$/.test(username)) && !(/[_a-zA-Z\d\-\.]+@[_a-zA-Z\d\-]+(\.[_a-zA-Z\d\-]+)+$/.test(username))){ 
			       //alert("输入的用户名格式不正确！");
				   $(".form_content ul li:eq(4)>dl:eq(0)").html("输入的用户名格式不正确！");
				   return false;
				}
				
				if(!password){  
				   $(".form_content ul li:eq(4)>dl:eq(0)").html("密码不能为空！");
				   return false;
				}
				
	
				$.ajax({
			        type:'POST',
				    url:'index.php?route=account/login/ajaxlogin',
					dataType:'json',
					async:false,
					data:'username='+username+'&password='+password,
				    success:function(json){
				     if(json.key=='ok'){
					   alert("错误的用户名和密码！");
				       $(".form_content ul li:eq(4)>dl:eq(0)").html("错误的用户名和密码！");
				       return false;
				     } 
				    }
				});
			}
			
			<!-- addStyle:function(){
			     
			//} -->
			
	};
	
	$("#sbt").click(login.check);
	$(".input_ul").delegate("input[class^=IUI_box_L]","focus",function(){
	      $(this).css('border','1px #F60 solid');
	});
	
	$(".input_ul").delegate("input[class^=IUI_box_L]","blur",function(){
	      $(this).css('border','1px solid #DAD8DA');
	});
</script>
</html>