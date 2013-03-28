<link rel="stylesheet" type="text/css" href="view/stylesheet/general.css">
<link rel="stylesheet" type="text/css" href="view/stylesheet/main.css">
<script type="text/javascript" src="view/javascript/jquery/jquery-1.7.1.min.js"></script><!--这里只能用1.7.1的版本,否则自带的图片处理有问题-->

<style type="text/css">
tr.over td {
	background:#cfeefe;
} 
</style>
    <h1><img src="view/image/setting.png" alt="" /> <?php echo $heading_title;?>
        <span class="action-span">
		    <!-- <a href="<?php echo $insert;?>" class="button"><?php echo $button_insert;?></a> -->
			<a href="javascript:;" onclick="$('form').submit();" class="button"><?php echo $button_delete;?></a>
			<a href="<?php echo $refresh;?>" class="button"><?php echo $button_refresh;?></a>
			
		</span>
    </h1>
    <div class="list-div" id="listDiv">
      <form action="<?php echo $delete;?>" method="post" enctype="multipart/form-data" id="form" onsubmit="return checkForm();">
        <table class="list">
          <thead>
            <tr>
              <td  style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
              <td style="text-align:center">logo</td>
			  <td style="text-align:center">ID</td>
			  <td style="text-align:center">网店名称</td>
              <td style="text-align:center">店主</td>
              <td style="text-align:center">电话</td>
			  <td style="text-align:center">手机</td>
			  <td style="text-align:center">地址</td>
			  <td style="text-align:center" width="30%">介绍</td>
			  <td style="text-align:center">开店时间</td>
			  <td style="text-align:center">状态</td>
			  <td style="text-align:center">操作</td>
            </tr>
          </thead>
          <tbody>
            <?php if($stores) { ?>
				<?php foreach((array)$stores as $store) {?>
				<tr>
				  <td style="text-align: center;"><?php if($store['selected']) { ?>
					<input type="checkbox" name="selected[]" value="<?php echo $store['store_id'];?>" checked="checked" />
					 <?php } else { ?>
					<input type="checkbox" name="selected[]" value="<?php echo $store['store_id'];?>" />
					<?php } ?></td>
				  <td class="left"><img src="<?php echo $store['logo'];?>" /></td>
				  <td class="left"><?php if(isset($store['store_id'])) { ?><?php echo $store['store_id'];?><?php } ?></td>
				  <td class="left"><?php if(isset($store['name'])) { ?><?php echo $store['name'];?><?php } ?></td>
				  <td class="left"><?php if(isset($store['owner'])) { ?><?php echo $store['owner'];?><?php } ?></td>
				  <td class="left"><?php if(isset($store['tel'])) { ?><?php echo $store['tel'];?><?php } ?></td>
				  <td class="left"><?php if(isset($store['mobile'])) { ?><?php echo $store['mobile'];?><?php } ?></td>
				  <td class="left"><?php if(isset($store['address'])) { ?><?php echo $store['address'];?><?php } ?></td>
				  <td class="left"><?php if(isset($store['introduce'])) { ?><?php echo $store['introduce'];?><?php } ?></td>
				  <td class="left"><?php if(isset($store['createtime'])) { ?><?php echo $store['createtime'];?><?php } ?></td>
				  <td class="left"><?php if(isset($store['status'])) { ?><?php echo $store['status'];?><?php } ?></td>
				  <td class="right"><?php foreach((array)$store['action'] as $action) {?>
					<a href="<?php echo $action['href'];?>"><?php echo $action['text'];?></a>
					<?php } ?></td>
				</tr>
				<?php } ?>
            <?php } else { ?>
				<tr>
				  <td class="center" colspan="12"><?php echo $text_no_results;?></td>
				</tr>
            <?php } ?>
          </tbody>
        </table>
      </form>
	  <div class="pagination"><?php echo $pagination;?></div>
    </div>
<script type="text/javascript">
$(function(){
	$(".list tr").mouseover(function(){
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

};
</script>