<?php echo $header;?>
 <!--个人中心body_begin-->
<div class="mainContent clear">
 	<!--左侧begin-->
	<?php echo $left;?>
 	<!--左侧end-->
    <!--右侧begin-->
	<div class="right">
            <!--地址薄-->
        	<div class="account_box">
            	<div class="ac_bgs clearfix">
                    <div class="ac_t_l">我的地址薄</div>
                    <div class="ac_t_r">
                        <div class="ac_t_l_s"><img src="catalog/view/theme/default/image/member/pic_account_title_05.gif" /></div>
                        <div class="account_contianer">
                        	<!--已保存的地址信息-->
                        	<h4 class="line">已保存的地址信息  <input type="button" name="cancel" value="返回" class="p_btn_s r" /></h4>
                            <div class="ac_order_n">
							<div class="addresslist">
							<table width="730" border="0" align="center" cellpadding="0" cellspacing="0">
							  <thead>
							  <tr height="22">
							    <td width="6%" align="center" bgcolor="#F3EBE0" class="itemTitle">收货地址</td>
								<td width="13%" align="center" bgcolor="#F3EBE0" class="itemTitle">姓名</td>
								<td width="15%" align="center" bgcolor="#F3EBE0" class="itemTitle">移动电话</td>
								<td align="center" bgcolor="#F3EBE0" class="itemTitle">地址</td>
								<td width="13%" align="center" bgcolor="#F3EBE0" class="itemTitle">操作</td>
							  </tr>
							  </thead>
							  
							  <tbody class="info">
							  <?php if($addresses) { ?>
							     <?php foreach((array)$addresses as $key=>$value) {?>
								  <tr height="30" data-flag="">
								    <td align="center" bgcolor="#FFFFFF"><input type="radio" name="dataid" value="<?php echo $value['address_id'];?>" <?php if($value['status']==1) { ?>checked="checked"<?php } ?> /></td>
									<td align="center" bgcolor="#FFFFFF"><?php echo $value['username'];?></td>
									<td align="center" bgcolor="#FFFFFF"><?php echo $value['mobile'];?></td>
									<td align="center" bgcolor="#FFFFFF"><?php echo $value['address'];?> </td>
									<td align="center" bgcolor="#FFFFFF" class="operation"><a href="javascript:;" class="edit">编辑</a>　<a href="javascript:;" class="delete">删除</a>　</td>
								  </tr>
								  <?php }?>
							  <?php } ?>
							  </tbody>
							</table>
                            </div>
                            </div>
							
							
                            <!--新增地址信息-->
						    <div id="insertAddress" >
								<h4 class="line">新增地址信息</h4>
								<div class="line_bot">
								<div class="content">
								  <table width="730" border="0" align="center" cellpadding="0" cellspacing="0">
									<tr>
									  <td width="100" align="right">收货人：</td>
									  <td><input type="text" name="username" class="small" />&nbsp;&nbsp;<span class="pinkfont">*</span></td>
									</tr>				
									<!-- <tr>
									  <td align="right">地区：</td>
									  <td><select name="select7">
										  <option>请选择</option>
										  <option>1980</option>
										</select>
										  <select name="select7">
											<option>请选择</option>
											<option>1980</option>
										  </select>
										  <select name="select7">
											<option>请选择</option>
											<option>1980</option>
										  </select>									　
										<span class="pinkfont">*</span></td>
									</tr> -->
									<tr>
									  <td align="right">公司：</td>
									  <td><input name="company" type="text" class="small"  value="" />&nbsp;&nbsp;<span class="pinkfont">*</span></td>
									</tr>
									
									<tr>
									  <td align="right">详细地址：</td>
									  <td><input name="address" type="text" class="small"  />&nbsp;&nbsp;<span class="pinkfont">*</span></td>
									</tr>
									<tr>
									  <td align="right">邮政编码：</td>
									  <td><input type="text" name="postcode" class="small" />&nbsp;&nbsp;<span class="pinkfont">*</span></td>
									</tr>
									<tr>
									  <td align="right">移动电话：</td>
									  <td><input type="text" name="mobile" class="small" />&nbsp;&nbsp;<span class="pinkfont">*</span></td>
									</tr>
									<tr>
									  <td align="right">固定电话：</td>
									  <td><input type="text" name="telephone" class="small" />&nbsp;&nbsp;<span class="pinkfont">*</span></td>
									</tr>
									<tr>
									  <td align="right">&nbsp;</td>
									  <td ><button class="p_btn_s" class="insert">新&nbsp;增</button></td>
									</tr>
								  </table>
								</div>
								</div>
							</div>
							
							<!--编辑地址信息-->
							<div id="editAddress"  >
								<h4 class="line">编辑地址信息</h4>
								<div class="line_bot">
								<div class="content">
								  
								  <table width="730" border="0" align="center" cellpadding="0" cellspacing="0">
									<tr>
									  <td width="100" align="right">收货人：</td>
									  <td><input type="text" name="username" class="small" value="" />&nbsp;&nbsp;<span class="pinkfont">*</span></td>
									</tr>				
									<!-- <tr>
									  <td align="right">地区：</td>
									  <td><select name="select7">
										  <option>请选择</option>
										  <option>1980</option>
										</select>
										  <select name="select7">
											<option>请选择</option>
											<option>1980</option>
										  </select>
										  <select name="select7">
											<option>请选择</option>
											<option>1980</option>
										  </select>									　
										<span class="pinkfont">*</span></td>
									</tr> -->
									<tr>
									  <td align="right">公司：</td>
									  <td><input name="company" type="text" class="small"  value="" />&nbsp;&nbsp;<span class="pinkfont">*</span></td>
									</tr>
									
									<tr>
									  <td align="right">详细地址：</td>
									  <td><input name="address" type="text" class="small"  value="" />&nbsp;&nbsp;<span class="pinkfont">*</span></td>
									</tr>
									<tr>
									  <td align="right">邮政编码：</td>
									  <td><input type="text" name="postcode" class="small" value="" /></td>
									  
									</tr>
									<tr>
									  <td align="right">移动电话：</td>
									  <td><input type="text" name="mobile" class="small" value="" />&nbsp;&nbsp;<span class="pinkfont">*</span></td>
									</tr>
									<tr>
									  <td align="right">固定电话：</td>
									  <td><input type="text" name="telephone" class="small" value="" />&nbsp;&nbsp;<span class="pinkfont">*</span></td>
									</tr>
									<tr>
									  <td align="right">&nbsp;</td>
									  <td><button class="p_btn_s" >保&nbsp;存</button></td>
									</tr>
									<input type="hidden" name="address_id" value="" />
								  </table>
								</div>
								</div>
							</div>
							
							
                        </div>
                    </div>
                </div>
            </div>
            <!--地址薄end-->
        </div>
 	<!--右侧end-->
</div>
 <!--个人中心body_end-->
 
 <script type="text/javascript">
    $("input[name=dataid]").live('click',function(){
	    var dataid=$.trim($(this).val());
	    $.post('index.php?route=account/address/setDefault',{dataid:dataid},function(data){
	        if(data==1){
		       alert("设置成功！");
		    }else{
		       alert("设置失败!");
		    }
	    })
	});
    
	$(document).ready(function(){
	  $("#editAddress").css("display","none");
	 
	});
	
	//编辑地址
	$(".edit").live('click',function(){
        $("#editAddress").fadeIn("slow");
	    $("#editAddress").css("display","block");
	    $("#insertAddress").css("display","none");
	 
	    var dataid=$(this).parent().siblings().eq(0).children().val();
		
		//指定 修改 记录定位标志
		$(".info tr ").attr('data-flag','');
		$(this).parent().parent().attr('data-flag','1');
		
	    $.post('index.php?route=account/address/getAddress',{dataid:dataid},function(data){
		    if(data){
				$("#editAddress input[name=username]").val(data.username);
				$("#editAddress input[name=company]").val(data.company);
				$("#editAddress input[name=telephone]").val(data.telephone);
				$("#editAddress input[name=mobile]").val(data.mobile);
				$("#editAddress input[name=address]").val(data.address);
				$("#editAddress input[name=postcode]").val(data.postcode);
				$("#editAddress input[name=address_id]").val(data.address_id);
			 
			}else{
			    alert("编辑错误！");
			}
	   
	    },"json");
	   
	});
	
	//保存地址
	$("#editAddress .p_btn_s").click(function(){
	  
	    var username=$.trim($("#editAddress input[name=username]").val());
	    var mobile=$.trim($("#editAddress input[name=mobile]").val());
	    var company=$.trim($("#editAddress input[name=company]").val());
	    var telephone=$.trim($("#editAddress input[name=telephone]").val());
	    var address=$.trim($("#editAddress input[name=address]").val());
	    var postcode=$.trim($("#editAddress input[name=postcode]").val());
	    var address_id=$.trim($("#editAddress input[name=address_id]").val());
		
		
		var arr=[];
	    if(!(/^[\w\d\u4E00-\u9FA5]{2,5}$/.test(username))) {
	       arr.push("输入的用户名2至5个字符!");
	    }
	    if(!(/^1[3|4|5|8][0-9]\d{4,8}$/.test(mobile))){
		   arr.push("输入的手机号格式不正确！");
	    }
	    if(!(/[a-z0-9\u4E00-\u9FA5]{5,}$/.test(company))) {
	       arr.push("输入的公司名称格式不正确,不少于5个字符!");
	    }
		
		if(telephone){
			if(!(/(^0\d{2,3}-?)?\d{7,8}$/.test(telephone))) {
			   arr.push("输入的电话不正确!");
		 	}
	    }
		
	    if(!(/[a-z0-9\u4E00-\u9FA5]{5,}$/.test(address))) {
	       arr.push("输入的地址不正确!");
	    }
	   
	    if(!(/^[1-9][0-9]{5,5}$/.test(postcode))) {
	       arr.push("输入的邮编不正确!");
	    }
	   
	    if (arr.length>0){
	        var s;
		    s=arr.join("\n");
		    alert(s);
	        return false;
	   
	    }
	   
	    $.post('index.php?route=account/address/update',{username:username,mobile:mobile,telephone:telephone,company:company,address:address,postcode:postcode,address_id:address_id},function(data){
		    if (data==1){
			    $(".info tr").each(function(){
				    if($(this).attr('data-flag')=='1'){
					    $(this).children('td').eq(1).text(username);
						$(this).children('td').eq(2).text(mobile);
						$(this).children('td').eq(3).text(address);
					}
				});
		        alert("更新成功!");
		    }else{
		        alert("更新失败！");
		    }
	    });
	
	});
	
	
	//删除地址
	$(".delete").live('click',function(){
	    var self=$(this);
	    if(confirm("您确认删除这条记录么？")){
			var dataid=$(this).parent().siblings().eq(0).children().val();
			$.post('index.php?route=account/address/delete',{dataid:dataid},function(data){
			   if(data==1){
				 self.parent().parent().remove();
			   }else if (data==2){
				 alert("必须要有一个收货地址！");
			   }else{
				 alert("删除失败！");
			   }
			});
	    }
	});

	//新增地址
	$("#insertAddress .p_btn_s").click(function(){
		var count=$('tbody.info tr').size();
		if  (count>=6){
		    alert('不能超过6条地址记录！');
			return false;
		}
		
	    var arr=[];
	    var username=$.trim($("#insertAddress input[name=username]").val());

	    if(!(/^[\u4E00-\u9FA5]{2,5}$/.test(username))) {
	       arr.push("输入的用户名不少于2个汉字!");
	    }
	   
	    var mobile=$.trim($("#insertAddress input[name=mobile]").val());

	    if(!(/^1[3|4|5|8][0-9]\d{4,8}$/.test(mobile))){
		   arr.push("输入的手机号格式不正确！");
	    }
	   
	    var company=$.trim($("#insertAddress input[name=company]").val());
	    if(!(/^[\u4E00-\u9FA5]{5,}$/.test(company))) {
	       arr.push("输入的公司名称不正确!");
	    }
	   
	    var telephone=$.trim($("#insertAddress input[name=telephone]").val());
		if(telephone){
			if(!(/(^0\d{2,3}-?)?\d{7,8}$/.test(telephone))) {
			   arr.push("输入的电话不正确!");
			}
	    }
		
	    var address=$.trim($("#insertAddress input[name=address]").val());
	    if(!(/^[\w\u4E00-\u9FA5]{5,}$/.test(address))) {
	       arr.push("输入的地址不正确!");
	    }
	   
	    var postcode=$("#insertAddress input[name=postcode]").val();
	    if(!(/^[1-9][0-9]{5,5}$/.test(postcode))) {
	       arr.push("输入的邮编不正确!");
	    }
	   
	    if (arr.length>0){
	        var s;
		    s=arr.join("\n");
		    alert(s);
	        return false;
	   
	    }
	    
	    $.post('index.php?route=account/address/insert',{username:username,mobile:mobile,telephone:telephone,company:company,address:address,postcode:postcode},function(data){
		    if (data){
				 //var address_id=json.address_id;
				 //var customer_id=json.customer_id;
				 var x=$("<tr height='30'><td align='center' bgcolor='#FFFFFF'><input type='radio' name='dataid' value='"+data +"'/></td><td align='center' bgcolor='#FFFFFF'>"+username+"</td><td align='center' bgcolor='#FFFFFF'>"+mobile+"</td><td align='center' bgcolor='#FFFFFF'>"+address+"<td align='center' bgcolor='#FFFFFF' class='operation'><a href='javascript:;' class='edit'>编辑</a>　<a href='javascript:;' class='delete'>删除</a>　</td></tr>");
				 //x.appendTo(".info");
				 $(".info").append(x);
				 alert("新增成功!");
				 $(".small").val('');
		    }else{
				alert("新增失败！");
		    }
	    });
	
	});
	
	
	$("input[name=cancel]").click(function(){
	    location='<?php echo $back;?>';
	});
	
 </script>
 
<?php echo $footer;?>
