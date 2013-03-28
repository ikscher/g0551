<link rel="stylesheet" type="text/css" href="view/stylesheet/general.css">
<link rel="stylesheet" type="text/css" href="view/stylesheet/main.css">
<script type="text/javascript" src="view/javascript/jquery/jquery-1.7.1.min.js"></script>

<style type="text/css">
    .list-div{padding:10px;}
	.list-div p input[type='radio'],.list-div p label{cursor:pointer;}
</style>
<h1><img src="view/image/log.png" alt="" /> <?php echo $heading_title;?>
	<span class="action-span"><a href="javascript:void(0);" class="updateOption" class="button"><?php echo $button_update;?></a></span>
	<span class="action-span"><a href="<?php echo $refresh;?>" class="button"><?php echo $button_refresh;?></a></span>
</h1>

<div class="list-div" id="listDiv">
   <p><input type="radio" id="updateOption" name="update" value="option" /><label for="updateOption">更新属性选项</label></p>
   
   <p><input type="radio" id="updateStoreCategory" name="update" value="storeCategory" /><label for="updateStoreCategory">更新店铺分类</label></p>
</div>

<script type="text/javascript">
    var flag=true;
	$(".updateOption").click(function(){  
	    if (flag==false) return false;
	    var checkedVal=$('input[name=update]:checked').val();
		if (!checkedVal || typeof checkedVal=='undefined'){
		    alert("请选择要更新的项目！");
			return false;
		}
		
		if (checkedVal=='option'){
			if(confirm('您确认要更新属性选项吗，这样会重置所有的选项属性?')){
				$.post('index.php?route=setting/update/option&token=<?php echo $token;?>',function(str){
					if(str=='ok'){
						$('#listDiv').html('successful!');
					}else{
						$('#listDiv').html('failed!');
					}
				});
			}
		}
		
		if (checkedVal=='storeCategory'){
			if(confirm('您确认要更新店铺分类吗，这样会重置所有的店铺分类信息?')){
			    $.ajax({
				        url:'index.php?route=setting/update/storeCategory&token=<?php echo $token;?>',
						beforeSend:function(){
						    $('#listDiv').html('正在处理中...');
							this.flag==false;
						},
						type:'post',
						dataType:'html',
						success:function(str){
						   if(str=='ok'){
								$('#listDiv').html('successful!');
							}else{
								$('#listDiv').html('failed!');
							}
							this.flag==true
						}
				    });
				/*
				$.post('index.php?route=setting/update/storeCategory&token=<?php echo $token;?>',function(str){
					if(str=='ok'){
						$('#listDiv').html('successful!');
					}else{
						$('#listDiv').html('failed!');
					}
				});*/
			}
		}
		
		
	});
</script>