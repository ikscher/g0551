<link rel="stylesheet" type="text/css" href="view/stylesheet/main.css">
<link rel="stylesheet" type="text/css" href="view/stylesheet/general.css">

<script type="text/javascript" src="view/javascript/jquery/jquery-1.7.1.min.js"></script>

    <h1><img src="view/image/user-group.png" alt="" /> <?php echo $heading_title;?>
        <span class="action-span">
		   <a href="<?php echo $refresh;?>" class="button"><?php echo $button_refresh;?></a>
		   <a href="javascript:;" onclick="$('form').submit();" class="button"><?php echo $button_delete;?></a>
		</span>
    </h1>



	<div class="list-div" id="listDiv">
		<div id="main-content">
		 <form method="post" action="?route=merchants/try">		
			
			    <div class="condition">
                    <label>会员ID：</label><input type="text" name="customer_id" class="input-small"    maxlength="30" value="<?php echo $info['customer_id'];?>"/>
 
                    <label>产品ID：</label><input type="text"   class="input-small"   name="product_id" value="<?php echo $info['product_id'];?>" />

                    <label>试用时间：</label><input type="text" class="date input-small"   name="trytime" value="<?php echo $info['trytime'];?>" />
                    
                    
                        <label>是否试用：</label>
                        <select  name="is_try" height="100" style="width:100px;" >
						<option value=null <?php if($info['is_try']===null) { ?>selected="selected"<?php } ?>>全部</option>
				        <option value="0" <?php if($info['is_try']===0) { ?>selected="selected"<?php } ?>>未试用</option>
						<option value="1" <?php if($info['is_try']===1) { ?>selected="selected"<?php } ?>>已试用</option>
					
				        </select>
					
                    
                    <input  class="button" type="submit" onclick="changePage(0)" value="&nbsp;搜索&nbsp;"></button>
                       
                                   
                </div>
				
		   
		 </form>
		</div>


		<div>
		<table class="list">
			<thead>
				<tr>
				    <th width="5%"><input type="checkbox" name="tryall"  /></th>
					<th width="10%" >图片</th>
					<th width="10%">试用产品ID</th>
					<th  width="35%">产品名称</th>
					<th width="20%">属性</th>
				  	<th width="10%">试用时间</th>
					<th width="10%">是否试用</th>
					
				</tr>
			</thead>
         <tbody>
         <?php foreach((array)$tryList as $k=>$t) {?>
		  
		  <tr>
			<td height="28" colspan="7" bgcolor="#f3f3f3">
				<span>【试用会员】<?php if(!empty($t['customer']['email'])) { ?><a data-id="<?php echo $t['customer']['customer_id'];?>">Email：<?php echo $t['customer']['email'];?></a> <?php if(!empty($t['customer']['username'])) { ?>，用户名：<?php echo $t['customer']['username'];?><?php } ?> <?php if(!empty($t['customer']['mobile'])) { ?>，手机：<?php echo $t['customer']['mobile'];?><?php } ?><?php } else { ?>手机：<?php echo $k;?><?php } ?></span>
			</td>
		  </tr>
		  
		  <?php foreach((array)$t['products'] as $p) {?>
		  <tr>
		    <td bgcolor="#FFFFFF"><input type="checkbox" name="try_id[]" value="<?php echo $p['try_id'];?>" <?php if($p['is_try']==1) { ?>checked="checked"<?php } ?>/></td>
			<td bgcolor="#FFFFFF"><img src="<?php echo $p['product']['image'];?>" /></td>
			<td bgcolor="#FFFFFF"><?php echo $p['product']['product_id'];?></td>
			<td bgcolor="#FFFFFF"><a href="<?php echo $p['product']['url'];?>" target="_blank" class="txt_color"><?php echo $p['product']['name'];?><?php if(!empty($p['attribute'])) { ?>(<?php echo $p['attribute'];?>)<?php } ?></a>	</td>
			<td bgcolor="#FFFFFF"></td>
			<td bgcolor="#FFFFFF"><?php echo $p['trytime'];?></td>
			<td bgcolor="#FFFFFF" class="operation"><?php echo $p['is_try_cn'];?><?php if($p['is_try']) { ?><p><button class="btn btn-mini">取消</button></p><?php } ?></td>
			
		  </tr>
		  <?php }?>
	
        <?php } ?>
		   </tbody>
		</table>
		</div>
 	   
      <!--begin  页脚批量操作和列表翻页 begin-->
	    <p>
	    <div class="page">
		<span style="float:left;margin-top:-5px;"><input name="try" class="button" type="button" value="试用"></input></span>
		<table>
    		<tr>
    			<td><?php echo $page;?></td>
    		</tr>		
		</table>
		</div>
		</p>
 	<!--页脚翻页end-->
    </div>
 	<!--右侧end-->

<script type="text/javascript" src="view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script> 
<link rel="stylesheet" type="text/css" href="view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" /> 
<script type="text/javascript" src="view/javascript/jquery/ui/jquery-ui-timepicker-addon.js"></script> 
<script type="text/javascript" src="view/javascript/jquery/ui/i18n/jquery.ui.datepicker-zh-CN.js"></script> 
<script type="text/javascript"><!--
$(".date").datepicker({
    dateFormat: 'yy-mm-dd',
	beforeShow: function() {
        setTimeout(function(){
            $('.ui-datepicker').css('z-index', 9999);
        }, 0);
    }
});
//--></script> 

<script type="text/javascript">

$(function(){
	$(".list tr").mouseover(function(){
		$(this).addClass("over");
	}).mouseout(function(){
		$(this).removeClass("over");	
	})

});


$(document).ready(function(){
	$("#order_state>li").removeClass("current");
	$("#order_state>li[rel='<?php echo $info['state'];?>']").addClass("current");
	$("#state_list>option[value='<?php echo $info['state'];?>']").attr("selected","selected");
});

$('input[name=tryall]').click(function(){
    
    if($(this).prop('checked')==true){
        $('input[name^=try_id]').attr('checked',true);
	}else{
	    $('input[name^=try_id]').attr('checked',false);
    }
});

$('button[name=try]').click(function(){
    if(confirm("您确认已经试用过吗？")){
        $.ajax({
		    url:'?route=merchants/try/confirm',
			type:'post',
			dataType:'json',
			data:$('input[name^=try_id]:checked'),
			success:function(json){
			    $('input[name^=try_id]:checked').each(function(i,w){
				    $(w).parent('td').siblings('td.operation').html('已试用<p><button class="btn btn-mini">取消</button></p>');
				});
				
			}
		});
    }
});
$('td.operation  ').on('click','p button',function(){
    var _gfv=$(this).parents('tr').children('td').eq(0).children('input');
    var try_id=_gfv.val();
	
    $.ajax({
		url:'?route=merchants/try/confirm',
		type:'post',
		dataType:'json',
		data:{try_id:try_id,is_try:0},
		success:function(json){
		    
		    alert('取消成功！');
			_gfv.removeAttr('checked');
			_gfv.parent('td').siblings('td.operation').html('未试用');
		}
	});

});
<!--测试看下-->
</script>