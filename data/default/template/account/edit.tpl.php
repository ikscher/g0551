<?php echo $header;?>
 <!--个人中心body_begin-->
<div class="mainContent clear">
 	<!--左侧begin-->
	<?php echo $left;?>
 	<!--左侧end-->
    <!--右侧begin-->
	<div class="right">
        	
			  <!--编辑帐户-->
        	<div class="account_box">
            	<div class="ac_bgs clearfix">
                    <div class="ac_t_l">编辑帐户</div>
                    <div class="ac_t_r">
                        <div class="ac_t_l_s"><img src="catalog/view/theme/default/image/member/pic_account_title_03.gif" /></div>
                        <div class="account_contianer">
                        	<h4 class="line">我的详细信息&nbsp;&nbsp;&nbsp;&nbsp;<span ><?php if(isset($success)) { ?><?php echo $success;?><?php } ?></span></h4>
                            <div class="line_bot">
							<div class="content">
                        	<!--个人设置-->
							
							<form action="<?php echo $action;?>" method="post" >
							<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
							  <tr>
								<td align="right">用&nbsp;户&nbsp;名：</td>
								<td><input type="text" name="username" class="small" value="<?php echo $username;?>" />　<span class="pinkfont">*</span></td>
							  </tr>
							  <tr>
								<td align="right">昵&nbsp;&nbsp;&nbsp;&nbsp;称：</td>
								<td><input type="text" name="nickname" class="small" value="<?php echo $nickname;?>" />　<span class="pinkfont">*</span></td>
							  </tr>
							  <tr>
								<td align="right">手&nbsp;机&nbsp;号：</td>
								<td><input type="text" name="mobile" class="small" value="<?php echo $mobile;?>" />　<span class="pinkfont">*</span></td>
							  </tr>
							  <tr>
								<td align="right">固定电话：</td>
								<td><input type="text" name="telephone" class="small" value="<?php echo $telephone;?>"  />　<span class="pinkfont">*</span></td>
							  </tr>
							  <tr>
								<td align="right">邮箱地址：</td>
								<td><input type="text" name="email" class="small"  value="<?php echo $email;?>"/>　<span class="pinkfont">*</span></td>
							  </tr>
							  <!-- <tr>
								<td align="right">收货地址：</td>
								<td><input type="text" name="address" class="small" value="<?php echo $address;?>" /></td>
							  </tr> -->
							  
							<!--   <tr>
								<td align="right">邮政编码：</td>
								<td><input type="text" name="postcode" class="small" value="<?php echo $postcode;?>"  /></td>
							  </tr> -->
							  
							  
							
							  <tr>
								<td align="right">&nbsp;</td>
								<td colspan="2"><input class="p_btn_s"   onclick="location.href='<?php echo $back;?>'" type="button" value="返回" />
								<input class="p_btn_s" id="sbt" type="submit" value="保存修改"></td>
							  </tr>
							</table>
							</form>
                            <!--个人设置结束-->
							</div>
							</div>
                        </div>
                    </div>
                </div>
            </div>
            <!--编辑帐户end-->
			
			
			
			
 	
</div>

 <!--个人中心body_end-->

<script type="text/javascript">
   var modify={
            
             check:function(){
			    var arr=[];
				
				var username=$.trim($("input[name=username]").val());
			    
				if (!(/[^<>$]{2,}/.test(username))) {
				   arr.push("输入的用户名有错误！");	
				   //alert('ddd');
				} 
				
			    var nickname=$.trim($("input[name=nickname]").val());
			    
				if (!(/[^<>$]{2,}/.test(nickname))) {
				   arr.push("输入的昵称有错误！");	
				   //alert('ddd');
				} 
				
					
				var mobile=$.trim($("input[name=mobile]").val());
				if(!(/^1[3|4|5|8][0-9]\d{4,8}$/.test(mobile))){
				   arr.push("输入的手机号格式不正确！");
				}
				
				var telephone=$.trim($("input[name=telephone]").val());
				if(!(/^\d{3,4}-\d{7,8}$/.test(telephone))){
				   arr.push("输入的电话号码格式不正确！");
				}
				
				
				var email=$.trim($("input[name=email]").val());
				if(!(/[_a-zA-Z\d\-\.]+@[_a-zA-Z\d\-]+(\.[_a-zA-Z\d\-]+)+$/.test(email))){ 
				   arr.push("输入的邮箱地址格式不正确！");
				}
				
				
				//var address=$.trim($("input[name=address]").val());
				//if (!(/[^<>$]{6,}/.test(address))) {
				//   arr.push("输入的地址格式不对或不正确！");	
				//} 
				
				//var postcode=$.trim($("input[name=postcode]").val());
				//if (!(/[^<>$]{6,}/.test(postcode))) {
				//   arr.push("输入的邮编不正确！");	
				//} 
				
				
				 if(arr.length>0){
				    var s;
					s=arr.join("\n");
					alert(s);
					return false;
				 }
				 
				
			 }
   
   };
   
   $("#sbt").click(modify.check);
   
 
</script>

<?php echo $footer;?>





 


