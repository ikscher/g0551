<link rel="stylesheet" type="text/css" href="view/stylesheet/general.css">
<link rel="stylesheet" type="text/css" href="view/stylesheet/main.css">
<script type="text/javascript" src="view/javascript/jquery/jquery-1.7.1.min.js"></script><!--这里只能用1.7.1的版本,否则自带的图片处理有问题-->
<!-- <script type="text/javascript" src="view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
<link type="text/css" href="view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" /> -->
<style type="text/css">
tr.over td {
	background:#cfeefe;
} 
</style>

    <h1>
	    <img src="view/image/payment.png" alt="" /> <?php echo $heading_title;?>
	    <span class="action-span"><a href="<?php echo $refresh;?>" ><?php echo $button_refresh;?></a></span>
	</h1>
    
    <div class="list-div" id="listDiv">
      <table class="list">
        <thead>
          <tr>
            <td class="left"><?php echo $column_name;?></td>
            <td></td>
            <td class="left"><?php echo $column_status;?></td>
            <td class="right"><?php echo $column_sort_order;?></td>
            <td class="right"><?php echo $column_action;?></td>
          </tr>
        </thead>
        <tbody>
          <?php if($extensions) { ?>
          <?php foreach((array)$extensions as $extension) {?>
          <tr>
            <td class="left"><?php echo $extension['name'];?></td>
            <td class="center"><?php echo $extension['link'];?></td>
            <td class="left"><?php echo $extension['status'];?></td>
            <td class="right"><?php echo $extension['sort_order'];?></td>
            <td class="right"><?php foreach((array)$extension['action'] as $action) {?>
              [ <a href="<?php echo $action['href'];?>"><?php echo $action['text'];?></a> ]
              <?php } ?></td>
          </tr>
           <?php } ?>
           <?php } else { ?>
          <tr>
            <td class="center" colspan="6"><?php echo $text_no_results;?></td>
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