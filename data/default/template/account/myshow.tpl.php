<?php echo $header;?>
<!--个人中心body_begin-->
<div class="mainContent clear">
 	<!--左侧begin-->
	<?php echo $left;?>
 	<!--左侧end-->
    <!--右侧begin-->
	<div class="right">
         <!--my subscription-->
        	<div class="account_box">
			    <div class="ac_bgs clearfix">
                    <div class="ac_t_l">我的秀</div>
                    <div class="ac_t_r">
                        <div class="ac_t_l_s"><img src="catalog/view/theme/default/image/member/pic_account_title_011.gif" /></div>
                        <div class="account_contianer">
                        	<h4 class="line">秀主题 <span ><?php if(isset($success)) { ?><?php echo $success;?><?php } ?></span><input type="button" name="issue" class="p_btn_s r" value="发布" /><input type="button" name="cancel" class="p_btn_s r" value="返回" /></h4>
                            <div class="line_bot">
								<div class="content">
								<!--个人设置-->
								<div class="listForm" style="margin-bottom:10px;padding:5px;">
									<form action="<?php echo $refresh;?>" method="post" >
										<?php echo $column_content_id;?><input type="text" name="content_id" value="<?php echo $content_id;?>" size="10" />
										<?php echo $column_starttime;?><input type="text" name="starttime" value="<?php echo $starttime;?>"  size="12"/>
										<?php echo $column_endtime;?><input type="text" name="endtime" value="<?php echo $endtime;?>" size="12" />
										<?php echo $column_title;?><input type="text" name="title" value="<?php echo $title;?>" />
										<?php echo $column_isShow;?>
											<select name="isShow">
												<option  value=""  <?php if($isShow=='') { ?>selected="selected"<?php } ?>>--全部--</option>
												<option  value="1" <?php if($isShow==1) { ?>selected="selected"<?php } ?>>显示</option>
												<option  value="2" <?php if($isShow==2) { ?>selected="selected"<?php } ?>>删除</option>
												<option  value="3" <?php if($isShow==3) { ?>selected="selected"<?php } ?>>不显示</option>
											</select>	
										<input type="reset"  name="rst" value="重置" style="cursor:pointer" />
										<input type="submit" name="sbt" value="提交" style="cursor:pointer" />
									</form>
								</div>

								<div class="listShow">
								  <form action="<?php echo $delete;?>" method="post" enctype="multipart/form-data" id="form">
									<table  border="1" align="center" cellpadding="0" cellspacing="0" >
									  <thead>
										<tr>
										  <td class="center" width="5%" ><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
										  <td class="center" width="5%"><?php echo $column_content_id;?></td>
										  <td class="center" width="5%"><?php echo $column_imageUrl;?></td>
										  <td class="center"><?php echo $column_favoriate;?></td>
										  <td class="center"><?php echo $column_share;?></td>
										  <td class="center" width="12%"><?php echo $column_createtime;?></td>
										  <td class="center" width="38%"><?php echo $column_title;?></td>
										  <td class="center"><?php echo $column_isShow;?></td>
										  <td class="center" width="9%"><?php echo $column_action;?></td>
										</tr>
									  </thead>
									  <tbody>
										<?php if(isset($contents)) { ?>
										<?php foreach((array)$contents as $content) {?>
											<tr>
											  <td style="text-align: center;"><?php if($content['selected']) { ?>
												<input type="checkbox" name="selected[]" value="<?php echo $content['content_id'];?>" checked="checked" />
												<?php } else { ?>
												<input type="checkbox" name="selected[]" value="<?php echo $content['content_id'];?>" />
												<?php } ?>
											 </td>
											  <td class="center"><?php echo $content['content_id'];?></td>
											  <td class="center"><img src="<?php echo $content['imageUrl'];?>" /></td>
											  <td class="center"><?php echo $content['favoriate'];?></td>
											  <td class="center"><?php echo $content['share'];?></td>
											  <td class="center"><?php echo $content['createtime'];?></td>
											  <td class="center"><a href="index.php?route=product/joy/joyDetail&id=<?php echo $content['content_id'];?>" target="_blank"> <?php echo $content['title'];?></a></td>
											  <td  class="center"><?php if($content['isShow']==1) { ?>显示<?php } elseif ($content['isShow']==2) { ?>删除<?php } else { ?>不显示<?php } ?></td>
											  <td class="center"><?php foreach((array)$content['action'] as $action) {?>
												<a  class="<?php echo $action['class'];?>" href="<?php echo $action['href'];?>"><?php echo $action['text'];?></a>
												<?php } ?></td>
											</tr>
										<?php } ?>
										 
										<?php } else { ?>
										<tr>
										  <td class="center" colspan="9"><?php echo $text_no_results;?></td>
										</tr>
									   <?php } ?>
									  </tbody>
									  <tfoot><tr><td class="center"><input type="submit"  class="delete" value="<?php echo $text_delete;?>" /></td><td colspan="8" class="center"><?php echo $pagination;?></td></tr></tfoot>
									</table>
								  </form>
								  
								</div>
								<!--个人设置结束-->
								</div>
							</div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end-->
		 
    </div>
</div>
<?php echo $footer;?>

<script type="text/javascript">
$(function(){
	$(".listShow tbody tr").mouseover(function(){
		$(this).addClass("over");
	}).mouseout(function(){
		$(this).removeClass("over");	
	})

});

function checkForm(){
    var sum=0;
    $("input[name^='select']").each(function(i,n){
		if($(this).prop("checked")==true){
		   sum++;
		}
  
    });
  
    if(sum<1) {
       alert("请选择要删除的项！");
	   return false;
    }
	
	return true;

};


 $("td .delete").click(function(){
    if(checkForm()){
	    if(confirm('你确认删除吗？')){
			$('#form').submit();
		}
	}
 });

 $("td a.deleteid").click(function(){
    if(!confirm("您确认删除吗？")){
	    return false;
	}
 });
 
 $(":reset").click(function(){
　　var resetArr = $(this).parents("form").find(":text");
    var len=resetArr.length;
　　for(var i=0;i<len ; i++){
　　　　resetArr.eq(i).val("");
　　}
　　return false;　　//一定要return false，阻止reset按钮功能，不然值又会变成aa
});

$("input[name=cancel]").click(function(){
   location='<?php echo $back;?>';
});

$("input[name=issue]").click(function(){
   location='<?php echo $insert;?>';
});
</script>



<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script> 
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" /> 
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-timepicker-addon.js"></script> 
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/i18n/jquery.ui.datepicker-zh-CN.js"></script> 
<script type="text/javascript"><!--
$("input[name=starttime],input[name=endtime]").datepicker({
    dateFormat: 'yy-mm-dd',
	numberOfMonths: 2 //显示两个月
});
//--></script> 