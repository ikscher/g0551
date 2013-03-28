<link rel="stylesheet" type="text/css" href="view/stylesheet/general.css">
<link rel="stylesheet" type="text/css" href="view/stylesheet/main.css">
<script type="text/javascript" src="view/javascript/jquery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
<link type="text/css" href="view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />


<style type="text/css">
tr.over td {
	background:#cfeefe;
} 
</style>

<?php if($error_warning) { ?>
<div class="warning"><?php echo $error_warning;?></div>
<?php } ?>
<?php if($success) { ?>
<div class="success"><?php echo $success;?></div>
<?php } ?> 

<h1><img src="view/image/order.png" alt="" /> <?php echo $heading_title;?>
	<span class="action-span">
	  <a href="javascript:;"  class="button"><?php echo $button_insert;?></a>
	  <a href="javascript:;"  class="button"><?php echo $button_delete;?></a>
	  <a href="<?php echo $refresh;?>" class="button"><?php echo $button_refresh;?></a>
	</span>
</h1>
 <div class="list-div" id="listDiv">
  <form action="<?php echo $delete;?>" method="post" enctype="multipart/form-data" id="form" >
	<table class="list">
	  <thead>
		<tr>
		  <td style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
		  <td><?php if($sort=='ag.attribute_group_id') { ?><a href="<?php echo $sort_id;?>">ID</a><?php } else { ?><a href="<?php echo $sort_id;?>">ID</a><?php } ?></td>
		  <td class="left"><?php if($sort == 'agd.name') { ?>
			<a href="<?php echo $sort_name;?>" class="{strtolower(<?php echo $order;?>)}"><?php echo $column_name;?></a>
			 <?php } else { ?>
			<a href="<?php echo $sort_name;?>"><?php echo $column_name;?></a>
			<?php } ?></td>
		  <td class="right"><?php if($sort == 'ag.sort_order') { ?>
			<a href="<?php echo $sort_sort_order;?>" class="{strtolower(<?php echo $order;?>)}"><?php echo $column_sort_order;?></a>
			 <?php } else { ?>
			<a href="<?php echo $sort_sort_order;?>"><?php echo $column_sort_order;?></a>
			<?php } ?>
			</td>
		
		  <td><?php echo $column_show;?></td>
		  <td></td>
		  <td class="right"><?php echo $column_action;?></td>
		</tr>
	  </thead>
	  <tbody>
		<?php if($attribute_groups) { ?>
		<?php foreach((array)$attribute_groups as $attribute_group) {?>
		<tr>
		  <td style="text-align: center;"><?php if($attribute_group['selected']) { ?>
			<input type="checkbox" name="selected[]" value="<?php echo $attribute_group['attribute_group_id'];?>" checked="checked" />
			 <?php } else { ?>
			<input type="checkbox" name="selected[]" value="<?php echo $attribute_group['attribute_group_id'];?>" />
		   <?php } ?></td>
		  <td><?php echo $attribute_group['attribute_group_id'];?></td>
		  <td class="attribute_group_name"><?php echo $attribute_group['name'];?></td>
		  <td class="right"><?php echo $attribute_group['sort_order'];?></td>
		 
		
		  <td><?php if($attribute_group['isShow']==1) { ?>yes<?php } else { ?>no<?php } ?></td>
		  <td><?php echo $attribute_group['type'];?></td>
		  <td class='operation'><a href="javascript:void(0);"  id="<?php echo $attribute_group['attribute_group_id'];?>" >编辑</a></td>
		</tr>
		<?php } ?>
		 <?php } else { ?>
		<tr>
		  <td class="center" colspan="7"><?php echo $text_no_results;?></td>
		</tr>
		<?php } ?>
	  </tbody>
	</table>
  </form>
  <?php echo $pagination;?>
</div>


<div id="dialog-form-e" title="编辑属性组"></div>
<div id="dialog-form-i" title="新增属性组"></div>


<script type="text/javascript">
$(function(){
	$(".list tr").mouseover(function(){
		$(this).addClass("over");
	}).mouseout(function(){
		$(this).removeClass("over");	
	})

});

var cf={ 
        sum:0,
        checkForm:function(){
			//var sum=0;
			$("input[name^='select']").each(function(i,n){
				if($(this).prop("checked")==true){
				   cf.sum++;
				}
		  
			});
		  
			if(cf.sum<1) {
			   alert("请选择要删除的项！");
			   return false;
			}else{
			   return true;
			}

		},
		submitForm:function(){
		    if(cf.checkForm()){
			    if(confirm('确认删除吗?')){
					$('form').submit();
				}
			} 
		
		}
	};
    

$('.action-span a:eq(1)').click(function(){	
	cf.submitForm();
});

$(".attribute_group_name").css({'cursor':'pointer','color':'red'});
$(".attribute_group_name").click(function(){
  var url='index.php?route=catalog/attribute_group&token=<?php echo $token;?>&attribute_group_name='+encodeURIComponent($.trim($(this).html()));
  location.href=url;
 
});



//编辑
$(function() {
	// a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
	//$( "#dialog:ui-dialog" ).dialog( "destroy" );
	
	$("#dialog-form-e" ).dialog({
		bgiframe:true, //兼容IE6
		autoOpen: false,
		height: 400,
		width: 300,
		modal: true,
		position:['top','left'],
		buttons: {
			"确定": function() {

				var attribute_group_name =$.trim($("input[name=attribute_group_name]").val());	
				
				var isShow=$('select[name=isShow]').val();
				var option_id=$('select[name=option_id]').val();
				var original_option_id=$('input[name=original_option_id]').val();
				var group_type=$('select[name=group_type]').val();
				

				
			    if(!group_type) group_type=1;
				if(group_type==1){
				     group_type_text='<?php echo $entry_general;?>';
				}else{
				     group_type_text='<?php echo $entry_price;?>';
				}
				
				
				var isShowText=$('select[name=isShow]').find("option:selected").text();
				var option_name=$('select[name=option_id]').find("option:selected").text();
				
				
				var sort_order=$.trim($("input[name=sort_order]").val());
				var attribute_group_id=$("input[name=attribute_group_id]").val();
				
                
				$.post("index.php?route=catalog/attribute_group/update&token=<?php echo $token;?>",{attribute_group_id:attribute_group_id,group_type:group_type,attribute_group_name:attribute_group_name,sort_order:sort_order,isShow:isShow,option_id:option_id,original_option_id:original_option_id},function(str){
				    if (str=='ok'){
					    $('.operation > a[id='+attribute_group_id+']').parent().parent().children('td').eq(2).text(attribute_group_name);
						$('.operation > a[id='+attribute_group_id+']').parent().parent().children('td').eq(3).text(sort_order);
						$('.operation > a[id='+attribute_group_id+']').parent().parent().children('td').eq(4).text(isShowText);
						$('.operation > a[id='+attribute_group_id+']').parent().parent().children('td').eq(5).text(group_type_text);
				        alert('更新成功！');
					}else{
					    alert("更新失败！");
					}

				});
				
				$( this ).dialog( "close" );

			},
			"取消": function() {
				$( this ).dialog( "close" );
			}
		}
	});
});

//编辑
$('.operation a').click(function(){
    var attribute_group_id=$(this).attr('id');
    //$.get('index.php?route=catalog/attribute_group/getForm&token=<?php echo $token;?>',{attribute_group_id:attribute_group_id},function(str){
    //    $("#dialog-form").html(str);
    //},'html');
	$.ajax({
	        url:'index.php?route=catalog/attribute_group/getForm&token=<?php echo $token;?>',
			dataType:'html',
			type:'get',
			data:{attribute_group_id:attribute_group_id},
			success:function(str){
			    $("#dialog-form-e").html(str);
			},
			beforeSend:function(){
			   $("#dialog-form-e").html('正在载入...'); 
			}
    });
	$("#dialog-form-i").html('');
    $("#dialog-form-e").dialog( "open" );
});


//新增
$(function() {
	$("#dialog-form-i" ).dialog({
		bgiframe:true, //兼容IE6
		autoOpen: false,
		height: 400,
		width: 300,
		modal: true,
		position:['top','left'],
		buttons: {
		     "确定": function() {
			    
			    var attribute_group_name =$.trim($("input[name=attribute_group_name]").val());
							
				if(!attribute_group_name){
				    alert('属性组名称不能为空！');
					return false;
				}
				
				//var atype = $.trim($(".oned").val());
				//if(!atype){
				//    alert('首选类不能为空！');
				//	return false;
				//}
				//var attribute_cid0=$.trim($(".oned").val());
				
				var sort_order=$.trim($("input[name=sort_order]").val());
				var attribute_group_id=$("input[type=hidden]").val();
				var option_id=$('select[name=option_id]').val();//默认值
				
				$.post("index.php?route=catalog/attribute_group/insert&token=<?php echo $token;?>",{attribute_group_id:attribute_group_id,attribute_group_name:attribute_group_name,sort_order:sort_order,option_id:option_id},function(str){
				    if (str=='ok'){
					    window.location.href="index.php?route=catalog/attribute_group&token=<?php echo $token;?>";
				    }else{
					    alert("插入失败！");
					}

				});
				$( this ).dialog( "close" );
			 },	
			 "取消": function(){
			    
				$( this ).dialog( "close" );
			 }
		
		}
	});
});
    
//新增
$('.action-span a:eq(0)').click(function(){
    $.get('index.php?route=catalog/attribute_group/getForm&token=<?php echo $token;?>',function(str){
        $("#dialog-form-i").html(str);
    },'html');
	$("#dialog-form-e").html('');
    $("#dialog-form-i").dialog( "open" );
});

</script>