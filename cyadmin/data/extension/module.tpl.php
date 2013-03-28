
<link rel="stylesheet" type="text/css" href="view/stylesheet/general.css">
<link rel="stylesheet" type="text/css" href="view/stylesheet/main.css">
<script type="text/javascript" src="view/javascript/jquery/jquery-1.7.1.min.js"></script>
<style type="text/css">
tr.over td {
	background:#cfeefe;
} 
</style>
    <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title;?></h1>

    <div class="list-div" id="listDiv">
      <table class="list">
        <thead>
          <tr>
            <td class="left"><?php echo $column_name;?></td>
            <td class="right"><?php echo $column_action;?></td>
          </tr>
        </thead>
        <tbody>
          <?php if($extensions) { ?>
          <?php foreach((array)$extensions as $extension) {?>
          <tr>
            <td class="left"><?php echo $extension['name'];?></td>
            <td class="right"><?php foreach((array)$extension['action'] as $action) {?>
               <a href="javascript:;" onclick="parent.addTab('编辑模块','<?php echo $action['href'];?>')"><?php echo $action['text'];?></a>&nbsp;
              <?php } ?></td>
          </tr>
           <?php } ?>
           <?php } else { ?>
          <tr>
            <td class="center" colspan="8"><?php echo $text_no_results;?></td>
          </tr>
         <?php } ?>
        </tbody>
      </table>
    </div>
<script type="text/javascript">
$(function(){
	$(".list tr").mouseover(function(){
		$(this).addClass("over");
	}).mouseout(function(){
		$(this).removeClass("over");	
	})

});
</script>