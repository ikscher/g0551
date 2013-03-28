<div class="classify z h">
	<ul class="classify_z z">
		<li class="classify_z_lc1">所有商品</li>
		<li class="classify_z_l<?php if($list_channel_title=='148') { ?>o<?php } else { ?>c<?php } ?>2"><font class="fonts">服饰</font></li>
		<li class="classify_z_l<?php if($list_channel_title=='219') { ?>o<?php } else { ?>c<?php } ?>3"><font class="fonts">食品</font></li>
		<li class="classify_z_l<?php if($list_channel_title=='279') { ?>o<?php } else { ?>c<?php } ?>4"><font class="fonts">家居</font></li>
		<li class="classify_z_l<?php if($list_channel_title=='324') { ?>o<?php } else { ?>c<?php } ?>5"><font class="fonts">旅游</font></li>
		<li class="classify_z_l<?php if($list_channel_title=='332') { ?>o<?php } else { ?>c<?php } ?>6"><font class="fonts">娱乐</font></li>
	</ul>
	<ul class="classify_y z">
		<li class="classify_y_lo1 dn">                        
		<?php foreach((array)$list_category as $key1=>$list) {?>
            <?php foreach((array)$list as $key2=>$list2) {?>
			    <dl class="all">
				   <dt class="f_dh"><a href="index.php?route=product/category&category_id=<?php echo $list2['category_id'];?>"><?php echo $list2['name']?></a></dt>
				   <dd class="f_dh">
				   <?php foreach((array)$list2['third_category_list'] as $list3) {?>
					   <a href="index.php?route=product/category&category_id=<?php echo $list3['category_id'];?>"><?php echo $list3['name'];?></a>
				   <?php }?>
				   </dd>
				</dl>
            <?php } ?>
		<?php }?>
		</li> 
		
		<?php $k=2;?>
		<?php foreach((array)$list_category as $key1=>$list) {?>

		<li class="classify_y_lo<?php echo $k;?> <?php if($key1==$list_channel_title) { ?><?php } else { ?>dn<?php } ?>"  >
		    <?php foreach((array)$list as $key2=>$list2) {?>
			<dl>
			   <dt class="f_b"><a href="index.php?route=product/category&category_id=<?php echo $list2['category_id'];?>" class="f_b"><?php echo $list2['name']?></a></dt>
			   <dd class="f_b">
			   <?php foreach((array)$list2['third_category_list'] as $list3) {?>
			       <a href="index.php?route=product/category&category_id=<?php echo $list3['category_id'];?>" class="f_b"><?php echo $list3['name'];?></a>
			   <?php }?>
			   </dd>
			</dl>	
		    <?php } ?>
 
		</li>
		<?php $k++;?>
		<?php }?>
		<!--
		<li class="classify_y_lo6 dn">
			<dl><dt class="f_b">品牌招商正在进行</dt></dl>
			
			<dl><dt class="f_b">品牌展示</dt><dd class="f_b"></dd></dl>
			<dl><dt class="f_b">品牌展示</dt></dl>
			<dl><dt class="f_b">品牌展示</dt></dl>
			<dl><dt class="f_b">品牌展示</dt></dl>
			<dl><dt class="f_b">品牌展示</dt></dl>
			<dl><dt class="f_b">品牌展示</dt></dl>
			<dl><dt class="f_b">品牌展示</dt></dl>
			
		</li>-->
	</ul>
</div>