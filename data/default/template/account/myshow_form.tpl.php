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
                        	<h4 class="line">编辑秀主题 &nbsp;&nbsp;&nbsp;&nbsp;<span ><?php if(isset($success)) { ?><?php echo $success;?><?php } ?></span><input type="button" name="cancel" value="返回" class="p_btn_s r" /></h4>
                            <div class="line_bot">
								<div class="content">
      
								  <form action="<?php echo $action;?>" method="post" enctype="multipart/form-data" id="form">

									<!--基本信息-->
									  <table class="form" width="100%">
										<tr>
										  <td width="10%"><span class="required">*</span><?php echo $column_title;?></td>
										  <td><input type="text" name="title" value="<?php if(isset($content['title'])) { ?><?php echo $content['title'];?><?php } ?>" size="60"/>
											
											
											</td>
										</tr>
										<tr>
										  <td width="10%"><?php echo $column_present;?></td>
										  <td ><textarea cols="100"  rows="5" name="present"  ><?php if(isset($content['present'])) { ?><?php echo $content['present'];?><?php } ?></textarea>
							
										  </td>
										</tr>
										<tr>
										  <td width="10%"><span class="required">*</span><?php echo $column_content;?></td>
										  <td ><textarea name="content" id="content" cols="100"  rows="5"><?php if(isset($content['content'])) { ?><?php echo $content['content'];?><?php } ?></textarea>
										 
										  </td>
										</tr>
									  
										<tr>
											<td width="10%"><?php echo $column_imageUrl;?></td>
											<td>
												<div>
													<img src="<?php if(isset($content['imageUrl'])) { ?><?php echo $content['imageUrl'];?><?php } ?>" alt="" class="thumb" id="thumb"/><br />
													<input type="hidden" name="image" value="<?php if(!empty($content['imageUrl'])) { ?><?php echo $content['imageUrl'];?><?php } else { ?><?php echo $no_image;?><?php } ?>" class="image" />
													<a href="javascript:void(0);" class="uploadImg"><?php echo $text_browse;?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a  href="javascript:void(0);" class="clearImg"><?php echo $text_clear;?></a>
												</div>
											</td>
										</tr>
										
										<?php if(empty($createtime)) { ?>
										<tr>
										  <td ><?php echo $column_favoriate;?></td>
										  <td><input type="text" name="favoriate" value="<?php if(isset($content['favoriate'])) { ?><?php echo $content['favoriate'];?><?php } ?>" readonly /></td>
										</tr>
										
										
								
										<tr>
										  <td><?php echo $column_share;?></td>
										  <td><input type="text" name="share" value="<?php if(isset($content['share'])) { ?><?php echo $content['share'];?><?php } ?>"  readonly /></td>
										</tr>
										<?php } ?>
										
										
										<tr>
										  <td><span class="required">*</span> <?php echo $column_createtime;?></td>
										  <td><input type="text" name="createtime" value="<?php if(isset($content['createtime'])) { ?><?php echo $content['createtime'];?><?php } else { ?><?php echo $createtime;?><?php } ?>" size="12" class="date" /></td>
										</tr>
										
									   
										<tr>
											<td><?php echo $column_isShow;?></td>
											<td><select name="isShow">
												<option value="1" <?php if(isset($content['isShow']) && $content['isShow']==1) { ?>  selected="selected"<?php } ?>><?php echo $text_show;?></option>
												<option value="2" <?php if(isset($content['isShow']) && $content['isShow']==2) { ?>  selected="selected"<?php } ?>><?php echo $text_delete;?></option>
												<option value="3" <?php if(isset($content['isShow']) && $content['isShow']==3) { ?>  selected="selected"<?php } ?>><?php echo $text_hidden;?></option>
											</select></td>
										</tr>
										
										<tr>
											<td align="right">&nbsp;</td>
											<td colspan="2"><input class="p_btn_s"   onclick="location.href='<?php echo $cancel;?>'" type="button" value="取消" />
											<input class="p_btn_s" id="sbt" type="submit" value="保存"></td>
										 </tr>
										
									  </table>

								  </form>
								  
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




<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script> 
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" /> 
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-timepicker-addon.js"></script> 
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/i18n/jquery.ui.datepicker-zh-CN.js"></script> 
<script type="text/javascript"><!--
$(".date").datepicker({
    dateFormat: 'yy-mm-dd',
});
//--></script> 


<script charset="utf-8" src="catalog/view/javascript/editor/kindeditor.js"></script>
<script charset="utf-8" src="catalog/view/javascript/editor/lang/zh_CN.js"></script>

<script type="text/javascript">
KindEditor.ready(function(K) {
		editor = K.create('#content',{items:['source','fontsize','|','forecolor','hilitecolor','bold','italic','underline','removeformat','|','justifyleft','justifycenter','justifyright','|','emoticons','image','multiimage','table','link','unlink','|','preview','fullscreen'],resizeType:1});
		K('.uploadImg').click(function() {
			editor.loadPlugin('image', function() {
				editor.plugin.imageDialog({
					imageSizeLimit:"512KB",
					showRemote : false,
					clickFn : function(url, title, width, height, border, align) {
						K('.image').val(url);
					    K('.thumb').attr('src',url);
						editor.hideDialog();
					}
				});
			});
		});
	});
	
$('.clearImg').click(function(){
    $('.thumb').attr('src','<?php echo $no_image;?>');
	$('.image').val('');
});

$("#sbt").click(function(){
    $('td').children('span').remove();
    var title=$('input[name=title]').val();
	
	if(!title && $('input[name=title]').next('span').length<=0) {
	    $('input[name=title]').after('<span style="color:red;margin-left:3px;"> * 错误的标题（不能为空）</span>');
		return false;
	}
	
	if(!editor.text()){
	    alert("内容不能为空！"); return false;
	}
	
	var createtime=$("input[name=createtime]").val();
	if(!createtime && $('input[name=createtime]').next('span').length<=0) {
	    $('input[name=createtime]').after('<span style="color:red;margin-left:3px;"> * 请填写发布日期</span>');
		return false;
	}
	

});

$('input[name=cancel]').click(function(){
    location='<?php echo $cancel;?>';
});
</script>