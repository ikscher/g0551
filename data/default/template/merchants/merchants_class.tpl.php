<?php echo $header;?>
 	<!--左侧begin-->
	<?php echo $left;?>
 	<!--左侧end-->
	
    <!--右侧begin-->
	<div class="right">
		<div class="blue_bor">
			<div class="blue_topbg">
				<ul>
					<li class="bl">选择宝贝所属分类</li>
					<li class="br"><span class="red">*</span> 表示该项必填</li>
				</ul>
			</div>
			<div class="blue_r">	
				    <input name="id" id="class_id" type="hidden" value="" />
                    <div class="product_class">
                        <div id="loading_info">分类加载中……</div>
                        <?php if($classList) { ?>
                        <ul class="class_list">
                            <?php foreach((array)$classList as $item) {?>
                            <li data-rel="<?php echo $item["classId"];?>"><?php echo $item["className"];?></li>
                            <?php } ?>
                        </ul>
                        <div class="clear_float"></div>
                        <?php } else { ?>
                        暂无商品分类
                        <?php } ?>
                    </div>
                    <div class="submit">
						<div class="float-submitbar">
							<button type="button" name="" class="J_Submit btn btn-main-primary btn-submit" value="发布" onclick="checkClass()">
							<span class="btn-txt">发布商品</span>  </button>
						</div>
				    </div>
			</div>
		</div>
    
    </div>
 	<!--右侧end-->
<?php echo $footer;?>
<script type="text/javascript" src="catalog/view/javascript/merchants.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	selectClass();
});
</script>