
<link rel="stylesheet" type="text/css" href="view/stylesheet/main.css">
<link rel="stylesheet" type="text/css" href="view/stylesheet/general.css">
<script type="text/javascript" src="view/javascript/jquery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
<link type="text/css" href="view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />



<?php if($error_warning) { ?>
<div class="warning"><?php echo $error_warning;?></div>
<?php } ?>
<?php if($success) { ?>
<div class="success"><?php echo $success;?></div>
<?php } ?> 

<h1><img src="view/image/order.png" alt="" /> <?php echo $heading_title;?>
	<span class="action-span">
	  <a href="javascript:;"  class="button"><?php echo $button_insert;?></a>
	  <a class="delete" href="javascript:void(0)"  class="button"><?php echo $button_delete;?></a>
	  <a href="<?php echo $refresh;?>" class="button"><?php echo $button_refresh;?></a>
	</span>
</h1>
 <div class="list-div" id="listDiv">
  <form action="<?php echo $delete;?>" method="post" enctype="multipart/form-data" id="form" >
	<table class="list">
	  <thead>
		<tr>
		  <td style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
		  <td><?php if($sort=='c2ag.attribute_group_id') { ?><a href="<?php echo $sort_id;?>"><?php echo $column_id;?></a><?php } else { ?><a href="<?php echo $sort_id;?>"><?php echo $column_id;?></a><?php } ?></td>
		  <td class="left"><?php if($sort == 'agd.name') { ?>
			<a href="<?php echo $sort_name;?>" class="{strtolower(<?php echo $order;?>)}"><?php echo $column_name;?></a>
			 <?php } else { ?>
			<a href="<?php echo $sort_name;?>"><?php echo $column_name;?></a>
			<?php } ?></td>
		
		
		  <td style="text-align:center"><?php echo $column_type;?></td>
		  <td>价格属性</td>
		  <td class="right"><?php echo $column_action;?></td>
		</tr>
	  </thead>
	  <tbody>
		<?php if($attribute_groups) { ?>
		<?php foreach((array)$attribute_groups as $attribute_group) {?>
		<tr>
		  <td style="text-align: center;"><?php if($attribute_group['selected']) { ?>
			<input type="checkbox" name="selected[]" value="<?php echo $attribute_group['id'];?>" checked="checked" />
			 <?php } else { ?>
			<input type="checkbox" name="selected[]" value="<?php echo $attribute_group['id'];?>" />
		   <?php } ?></td>
		  <td><?php echo $attribute_group['attribute_group_id'];?></td>
		  <td class="attribute_group_name"><?php echo $attribute_group['name'];?></td>
		 
		  <td class="attribute_group_type" data-type="<?php echo $attribute_group['category_id'];?>"><?php echo $attribute_group['ctype'];?></td>
          <td data-id="<?php echo $attribute_group['id'];?>"><?php if($attribute_group['type']==2) { ?><input type="checkbox" class="priceAttr" name="priceAttr" value="<?php echo $attribute_group['is_pa'];?>" <?php if($attribute_group['is_pa']) { ?>checked="checked"<?php } ?> /><?php } ?></td>
		  <td class='operation'><a href="javascript:void(0);"  data-id="<?php echo $attribute_group['id'];?>" >删除</a></td>
		</tr>
		<?php } ?>
		 <?php } else { ?>
		<tr>
		  <td style="text-align:center" colspan="7"><?php echo $text_no_results;?></td>
		</tr>
		<?php } ?>
	  </tbody>
	</table>
  </form>
  <?php echo $pagination;?>
</div>


<!-- <div id="dialog-form-e" title="编辑分类-属性组参照表"></div> -->
<div id="dialog-form-i" title="新增分类-属性组"></div>


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
    

$('.delete').click(function(){	
	cf.submitForm();
});

$(".attribute_group_name").css({'cursor':'pointer','color':'red'});
$(".attribute_group_type").css({'cursor':'pointer','color':'red'});


$(".attribute_group_name").click(function(){

  var url='index.php?route=catalog/category_to_attribute_group&token=<?php echo $token;?>&attribute_group_name='+encodeURIComponent($.trim($(this).html()));
  location.href=url;
 
});

$(".attribute_group_type").click(function(){
  var url='index.php?route=catalog/category_to_attribute_group&token=<?php echo $token;?>&category_id='+$.trim($(this).attr('data-type'));

  location.href=url;
 
});


//价格属性ajax
$(".priceAttr").click(function(){
    var id=$(this).parent().attr('data-id');
	var is_pa;
	
	if($(this).val()==0) {
	    $(this).val(1);
	    is_pa=1;
	}else{
	    $(this).val(0);
	    is_pa=0;
	}
	console.log(id+','+is_pa);
	$.post('index.php?route=catalog/category_to_attribute_group/setPriceAttributeValid&token=<?php echo $token;?>',{id:id,is_pa:is_pa},function(str){
	    if(str=='yes'){
		   alert('设置成功！');
		}else{
		   alert('设置失败！');
		}
	});
});
/*
//编辑
$(function() {
	// a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
	//$( "#dialog:ui-dialog" ).dialog( "destroy" );
	
	$("#dialog-form-e" ).dialog({
		bgiframe:true, //兼容IE6
		autoOpen: false,
		height: 300,
		width: 300,
		modal: true,
		position:['top','left'],
		buttons: {
			"确定": function() {

				var category_id =$.trim($("input[name=category_id]").val());	
				var attribute_cid0=$('.oned').val();
				var attribute_cid1=$('.twod').val();
				var attribute_cid2=$('.threed').val();
				var attribute_cid3=$('.fourd').val();
				
				
				var atypename='';
				if(attribute_cid0){
				    atypename=$('.oned').find("option:selected").text().replace(/\d+[\：\:]/i,'');
				}
				
				var attribute_group_description='';
				if(attribute_cid1){
				    attribute_group_description=$.trim($('.twod').find("option:selected").text().replace(/\d+[\：\:]/i,''));
				}
				
				var attribute_group_text0='';
				if(attribute_cid2){
				    attribute_group_text0=$.trim($('.threed').find("option:selected").text().replace(/\d+[\：\:]/i,''));
				}
				
				var attribute_group_text1='';
				if(attribute_cid3){
				    attribute_group_text1=$.trim($('.fourd').find("option:selected").text().replace(/\d+[\：\:]/i,''));
				}
				
			    
				var attribute_group_id=$("input[name=attribute_group_id]").val();
				
                
				$.post("index.php?route=catalog/category_to_attribute_group/update&token=<?php echo $token;?>",{attribute_group_id:attribute_group_id,category_id:category_id,attribute_cid0:attribute_cid0,attribute_cid1:attribute_cid1,attribute_cid2:attribute_cid2,attribute_cid3:attribute_cid3,atypename:atypename,attribute_group_description:attribute_group_description,attribute_group_text0:attribute_group_text0,attribute_group_text1:attribute_group_text1},function(str){
				    if (str=='ok'){
						$('.operation > a[id='+attribute_group_id+']').parent().parent().children('td').eq(3).text(atypename+'>>'+attribute_group_description+'>>'+attribute_group_text0+'>>'+attribute_group_text1);
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
	var category_id=$(this).parent().prev().attr('data-type');
	
	$.ajax({
	        url:'index.php?route=catalog/category_to_attribute_group/getForm&token=<?php echo $token;?>',
			dataType:'html',
			type:'get',
			data:{attribute_group_id:attribute_group_id,category_id:category_id},
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
*/

$('.operation a').click(function(){
    var id=$(this).attr('data-id');
	var category_id=$(this).parent().prev().prev().attr('data-type');
	var attribute_group_id=$.trim($(this).parent().prev().prev().prev().prev().text());
   
	var that=$(this);
	if(confirm('确认删除吗?')){
		$.ajax({
				url:'index.php?route=catalog/category_to_attribute_group/deleteone&token=<?php echo $token;?>',
				dataType:'text',
				type:'post',
				data:{id:id,attribute_group_id:attribute_group_id,category_id:category_id},
				success:function(str){
				    //console.log(str);
					if(str=='yes'){
						//that.parent().parent().remove();
						location.href="index.php?route=catalog/category_to_attribute_group&token=<?php echo $token;?>";
					}
				}
		});
	}
});

//新增
$(function() {
	$("#dialog-form-i" ).dialog({
		bgiframe:true, //兼容IE6
		autoOpen: false,
		height: 300,
		width: 300,
		modal: true,
		position:['top','left'],
		buttons: {
		     "确定": function() {
			    
			    var attribute_group_id =$.trim($("select[name='attribute_group']").val());
							
				if(!attribute_group_id){
				    alert('属性组名称不能为空！');
					return false;
				}
				
				var atype = $.trim($(".oned").val());
				if(!atype){
				    alert('首选类不能为空！');
					return false;
				}
				
				var category_id;
				var attribute_cid0=$.trim($(".oned").val());
				var atypename='';
				if(attribute_cid0){
				    atypename=$('.oned').find("option:selected").text().replace(/\d+[\：\:]/i,'');
					category_id=attribute_cid0;
				}
				
				var attribute_cid1=$.trim($(".twod").val());
				var attribute_group_description='';
				if(attribute_cid1){
				    attribute_group_description=$.trim($('.twod').find("option:selected").text().replace(/\d+[\：\:]/i,''));
					category_id=attribute_cid1;
				}
				
				var attribute_cid2=$.trim($(".threed").val());
				var attribute_group_text0='';
				if(attribute_cid2){
				    attribute_group_text0=$.trim($('.threed').find("option:selected").text().replace(/\d+[\：\:]/i,''));
					category_id=attribute_cid2;
				}
				var attribute_cid3=$.trim($(".fourd").val());
				var attribute_group_text1='';
				if(attribute_cid3){
				    attribute_group_text1=$.trim($('.fourd').find("option:selected").text().replace(/\d+[\：\:]/i,''));
					category_id=attribute_cid3;
				}
	            
				$.ajax({
				     url:"index.php?route=catalog/category_to_attribute_group/insert&token=<?php echo $token;?>",
					 type:'post',
					 data:{attribute_group_id:attribute_group_id,category_id:category_id,attribute_cid0:attribute_cid0,attribute_cid1:attribute_cid1,attribute_cid2:attribute_cid2,attribute_cid3:attribute_cid3},
					 async:true,
					 beforeSend:function(){
					    $("#dialog-form-i").append('<div style="margin-top:20px;margin-left:40px;">正在处理,请稍后...</div>');
					 },
					 dataType:'html',
					 success:function(str){
					    //console.log(str);
					    
					    if (str=='ok'){
						    window.location.href="index.php?route=catalog/category_to_attribute_group&token=<?php echo $token;?>";
						}else{
						    alert("插入失败(可能已经存在分配的项)！");
						}
						$( this ).dialog( "close" );
					    
					 }
				});
					 
				
				//$.post("index.php?route=catalog/category_to_attribute_group/insert&token=<?php echo $token;?>",{attribute_group_id:attribute_group_id,category_id:category_id,attribute_cid0:attribute_cid0,attribute_cid1:attribute_cid1,attribute_cid2:attribute_cid2,attribute_cid3:attribute_cid3},function(str){ 
					//if (str=='ok'){
					//    window.location.href="index.php?route=catalog/category_to_attribute_group&token=<?php echo $token;?>";
				    //}else{
					//    alert("插入失败(可能已经存在分配的项)！");
					//}
				//});
				//$( this ).dialog( "close" );
			 },	
			 "取消": function(){
			    
				$( this ).dialog( "close" );
			 }
		
		}
	});
});
    
//新增
$('.action-span a:eq(0)').click(function(){
    $.get('index.php?route=catalog/category_to_attribute_group/getForm&token=<?php echo $token;?>',function(str){
        $("#dialog-form-i").html(str);
    },'html');
	$("#dialog-form-e").html('');
    $("#dialog-form-i").dialog( "open" );
});

</script>