<?php echo $header;?>
 <!--���ô���body_begin-->
<div class="mainContent clear">
 	<!--����begin-->
	<?php echo $left;?>
 	<!--����end-->
    <!--����begin-->
	<div class="right">

		  <!-- <div class="breadcrumb">
			<?php foreach((array)$breadcrumbs as $breadcrumb) {?>
			<?php echo $breadcrumb['separator'];?><a href="<?php echo $breadcrumb['href'];?>"><?php echo $breadcrumb['text'];?></a>
			<?php } ?>
		  </div> -->
		  <h1><?php echo $heading_title;?></h1>
		  <?php echo $text_message;?>
		  <div class="buttons">
			<div class="right"><a href="<?php echo $continue;?>" class="button"><?php echo $button_continue;?></a></div>
		  </div>
    </div>
</div>
<?php echo $footer;?>