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
                
                    <div class="ac_t_l">修改密码</div>
                    <div class="ac_t_r">
                        <div class="ac_t_l_s"><img src="catalog/view/theme/default/image/member/pic_account_title_04.gif" /></div>
                        <div class="account_contianer">
                        	<h4 class="line">您的帐户密码&nbsp;&nbsp;&nbsp;&nbsp;<span ><?php if(isset($success)) { ?><?php echo $success;?><?php } ?></span></h4>
                            <div class="line_bot">
							<div class="content">
                        	<!--个人设置-->
							<form action="<?php echo $action;?>" method="POST" >
							<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
							  <tr>
								<td width="100" align="right">原始密码：</td>
								<td><input type="password" name="oldpassword" class="small" value="" />　<span id="oldrequired" class="pinkfont">*</span></td>
							  </tr>
							  <tr>
								<td align="right">新密码：</td>
								<td><input type="password" name="newpassword" class="small" value="" />　<span id="newrequired" class="pinkfont">*</span></td>
							  </tr>
							  <tr>
								<td align="right">确认新密码：</td>
								<td><input type="password" name="confirmpassword" class="small"  />　<span  id="confirmrequired" class="pinkfont">*</span></td>
							  </tr>
							  <tr>
								<td align="right">&nbsp;</td>
								
								<td colspan="2"><input class="p_btn_s"  onclick="location.href='<?php echo $back;?>'" type="button" value="返回" />
								<input  class="p_btn_s" id="sbt" type="submit" value="保存密码"></td>
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
             joo:[],
             isclick:false,
             check:function(){
			    modify.joo=[];
		        modify.isclick=true;
				var newpassword=$.trim($("input[name=newpassword]").val());
				var confirmpassword=$.trim($("input[name=confirmpassword]").val());
				
				if (!(/\w{6,}/.test(newpassword))){
				    modify.joo.push("输入的密码格式不正确，最少6位！");
					$('#newrequired').html('输入的密码格式不正确，最少6位！');
					//return false;
				}else{
				    $('#newrequired').html('*');
				}
				if(newpassword!=confirmpassword){
				  modify.joo.push("输入的两次密码不一致！");
				  $('#confirmrequired').html('输入的两次密码不一致！');
				  //return false;
				}else{
				  $('#confirmrequired').html('*');
				}
				
				modify.validate();
					
				
			    if(modify.joo.length>0 && modify.isclick==true){
				   var s;
				   s=modify.joo.join("\n");
				   //alert(s);
				   return false;
				
				
				}
			    
				
			
			 },
			 validate:function(){
			    
			    var uid=<?php echo $uid;?>;
				var oldpassword=$.trim($("input[name=oldpassword]").val());
			    
			    $.post("index.php?route=account/password/ajaxCheckPwd",{uid:uid,oldpassword:oldpassword},function(data){

					   if(data==0){
						  //alert("输入的原密码不正确！");
						  modify.joo.push("输入的原密码不正确！");
						  $('#oldrequired').html('输入的原密码不正确！');
						  return false;
					   }else if(data==1){
		
                          $('#oldrequired').html('*');
                       }					   
                  				   
				});

			 
			},
			clearNotation:function(){
			    if($.trim($("#oldrequired").html())){
				    $("#oldrequired").html('*');
				}
			    
				if($.trim($("#newrequired").html())){
				    $("#newrequired").html('*');
				}
				
				if($.trim($("#confirmrequired").html())){
				    $("#confirmrequired").html('*');
				}
			}
			  
   
   };
   
   $("#sbt").click(modify.check);
   $('input[name=oldpassword]').bind('keydown',modify.clearNotation);
   $('input[name=newrequired]').bind('keydown',modify.clearNotation);
   $('input[name=confirmrequired]').bind('keydown',modify.clearNotation);
		 
</script>



<?php echo $footer;?>



 


