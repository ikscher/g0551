<?php foreach((array)$totals as $total) {?>
  <dl class="clearfix">
	<dt><?php echo $total['title'];?>:</dt>
	<dd><?php echo $total['text'];?></dd>
  </dl>
<?php } ?>