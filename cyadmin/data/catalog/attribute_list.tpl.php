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
	  <a href="javascript:;"  title="<?php echo $delete;?>" class="button"><?php echo $button_delete;?></a>
	  <a href="<?php echo $refresh;?>" class="button"><?php echo $button_refresh;?></a>
	</span>
</h1>

<div class="list-div" id="listDiv">
  <form action="<?php echo $delete;?>" method="post" enctype="multipart/form-data" id="form" >
	<table class="list">
	  <thead>
		<tr>
		  <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
		  <td>ID</td>
		  <td class="left"><?php if($sort == 'ad.name') { ?>
			<a href="<?php echo $sort_name;?>" class="{strtolower(<?php echo $order;?>)}"><?php echo $column_name;?></a>
			 <?php } else { ?>
			<a href="<?php echo $sort_name;?>"><?php echo $column_name;?></a>
			<?php } ?></td>
		  <td class="left"><?php if($sort == 'attribute_group') { ?>
			<a href="<?php echo $sort_attribute_group;?>" class="{strtolower(<?php echo $order;?>)}"><?php echo $column_attribute_group;?></a>
			 <?php } else { ?>
			<a href="<?php echo $sort_attribute_group;?>"><?php echo $column_attribute_group;?></a>
			<?php } ?></td>
		  <td><a href="<?php echo $sort_attribute_group_id;?>"><?php echo $column_attribute_group_id;?></a></td>
		  <!-- <td ><a href="<?php echo $sort_type;?>"><?php echo $column_type;?></a></td>
		  <td style="width:10%">子类别1</td><td style="width:10%">子类别2</td><td style="width:10%">子类别3</td> -->
		  <td class="right"><?php if($sort == 'a.sort_order') { ?>
			<a href="<?php echo $sort_sort_order;?>" class="{strtolower(<?php echo $order;?>)}"><?php echo $column_sort_order;?></a>
			 <?php } else { ?>
			<a href="<?php echo $sort_sort_order;?>"><?php echo $column_sort_order;?></a>
			<?php } ?></td>
		  <td><?php echo $column_show;?></td>
		  <td class="right"><?php echo $column_action;?></td>
		</tr>
	  </thead>
	  <tbody>
		<?php if($attributes) { ?>
		<?php foreach((array)$attributes as $attribute) {?>
		<tr>
		  <td style="text-align: center;"><?php if($attribute['selected']) { ?>
			<input type="checkbox" name="selected[]" value="<?php echo $attribute['attribute_id'];?>" checked="checked" />
			 <?php } else { ?>
			<input type="checkbox" name="selected[]" value="<?php echo $attribute['attribute_id'];?>" />
			<?php } ?></td>
		  <td><?php echo $attribute['attribute_id'];?></td>
		  <td class="left"><?php echo $attribute['name'];?></td>
		  <td class="attribute_group" ><?php echo $attribute['attribute_group'];?></td>
		  <td class="attribute_group_id" data-type="<?php echo $attribute['attribute_group_id'];?>"><?php echo $attribute['attribute_group_id'];?></td>
		 <!--  <td class="attribute_type" data-type="<?php echo $attribute['type'];?>"><?php echo $attribute['typename'];?></td>
		  <td><?php echo $attribute['description'];?></td>
		  <td><?php echo $attribute['text0'];?></td>
		  <td><?php echo $attribute['text1'];?></td> -->
		  <td class="right"><?php echo $attribute['sort_order'];?></td>
		  <td><?php if($attribute['isShow']==1) { ?>yes<?php } else { ?>no<?php } ?></td>
		
			<td class='operation'><a href="javascript:void(0);"  id="<?php echo $attribute['attribute_id'];?>" >编辑</a></td>
		</tr>
		<?php } ?>
		 <?php } else { ?>
		<tr>
		  <td class="center" colspan="10" ><?php echo $text_no_results;?></td>
		</tr>
		<?php } ?>
	  </tbody>
	</table>
  </form>
  <?php echo $pagination;?>
</div>


<div id="dialog-form-e" title="编辑属性"></div>
<div id="dialog-form-i" title="新增属性"></div>

<script type="text/javascript">
$(function(){
	$(".list tr").mouseover(function(){
		$(this).addClass("over");
	}).mouseout(function(){
		$(this).removeClass("over");	
	})

});

var cf={
        checkForm:function(){
			var sum=0;
			$("input[name^='select']").each(function(i,n){
				if($(this).prop("checked")==true){
				   sum++;
				}
		  
			});
		  
			if(sum<1) {
			   alert("请选择要删除的项！");
			   return false;
			}else{
			   return true;
			}

        },
		submitForm:function(){
		    if(cf.checkForm()){
			    $('form').submit();
			}
		
		}

	};


$('.action-span a:eq(1)').click(function(){	
	cf.submitForm();
});


$(".attribute_group").css({'cursor':'pointer','color':'red'});
$(".attribute_group").click(function(){
  var pathname=location.pathname;
  var query=location.search;
  var url=pathname+query;
  var url=url+'&attribute_group='+encodeURIComponent($.trim($(this).html()));

  url=url.replace(/&page=\d*/i,'');
  location.href=url;
 
});


$(".attribute_type").css({'cursor':'pointer','color':'red'});
$(".attribute_type").click(function(){
  var pathname=location.pathname;
  var query=location.search;
  var url=pathname+query;
  var url=url+'&attribute_type='+$.trim($(this).attr('data-type'));
  url=url.replace(/&page=\d*/i,'');
  url=url.replace(/&attribute_group=[\w%]*/i,'');
  location.href=url;
 
});


$(".attribute_group_id").css({'cursor':'pointer','color':'red'});
$(".attribute_group_id").click(function(){
  var pathname=location.pathname;
  var query=location.search;
  var url=pathname+query;
  var url=url+'&attribute_group_id='+$.trim($(this).attr('data-type'));
  url=url.replace(/&page=\d*/i,'');
  url=url.replace(/&attribute_group=[\w%]*/i,'');
  url=url.replace(/&attribute_type=[\w%]*/i,'');
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
			    var attribute_id=$('input[name=attribute_id]').val();
				var attribute_group_id=$('select[name=attribute_group_id]').find("option:selected").val();
				var sort_order=$('input[name=sort_order]').val();
				var attribute_name=$('input[name=attribute_name]').val();
			
				$.post("index.php?route=catalog/attribute/update&token=<?php echo $token;?>",{attribute_id:attribute_id,attribute_name:attribute_name,sort_order:sort_order,attribute_group_id:attribute_group_id},function(str){
				    if (str=='ok'){
					    location.href="index.php?route=catalog/attribute&token=<?php echo $token;?>&attribute_group_id="+attribute_group_id;
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
    var attribute_id=$(this).attr('id');

	$.ajax({
	        url:'index.php?route=catalog/attribute/getForm&token=<?php echo $token;?>',
			dataType:'html',
			type:'get',
			data:{attribute_id:attribute_id},
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
			    if(!($.trim($('input[name=attribute_name]').val()))) {
				    alert('属性名称不能为空！');
					return false;
				}

				var attribute_group_id=$('select[name=attribute_group_id]').find("option:selected").val();
				var sort_order=$('input[name=sort_order]').val();
				var attribute_name=$('input[name=attribute_name]').val();
				
				$.post("index.php?route=catalog/attribute/insert&token=<?php echo $token;?>",{attribute_group_id:attribute_group_id,sort_order:sort_order,attribute_name:attribute_name},function(str){
				    if (str=='ok'){
					    window.location.href="index.php?route=catalog/attribute&token=<?php echo $token;?>";
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
    $.get('index.php?route=catalog/attribute/getForm&token=<?php echo $token;?>',function(str){
        $("#dialog-form-i").html(str);
    },'html');
	$("#dialog-form-e").html('');
    $("#dialog-form-i").dialog( "open" );
});

</script>