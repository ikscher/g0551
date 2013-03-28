<table id="J_CommonBottomBar" style="right: 25px;">
	<tbody>
		<tr>
			<td order="0"></td>
			<!-- <td order="20">
				<div id="J_BrandBar" order="20" class="tm_cmbar_clearfix tm_cmbar">
					<div class="BrandFlyer"></div>
					<a href="http://brand.tmall.com/myBrandsIndex.htm" target=" target=" _blank""="">我关注的品牌</a>
				</div>
			</td> -->
			<td order="50">
				<div class="tmMC tm_cmbar_clearfix tm_cmbar" id="J_TMiniCart">
					<div class="<?php if($countProducts>0 ) { ?>tmMCHandler HdlOpen HdlShort<?php } else { ?>tmMCHandler <?php if(empty($userid)) { ?>unlogin<?php } ?> <?php } ?>" >
						<div class="tmMCTopBorder" <?php if($countProducts>0) { ?>style="display:block;"<?php } else { ?>style="display:none;"<?php } ?>></div>
							<div class="tmMCBody" style=" display:none;">
								<div class="tmMCLoading" >正在加载…</div>
								<div class="tmMCCon">
							    <!--
						        <?php if($countProducts>0) { ?>
									购物车数据加载
									<?php if($products || $vouchers) { ?>
									<div class="tmMCGroup">
										<div class="tmMCGroupTitle"><label title="尚纳东川专卖店" class="tmMCGroupName">尚纳东川专卖店</label></div> 
										<div class="tmMCItemWp">
											<?php foreach((array)$products as $product) {?>
												<div class="tmMCItem" >
													<a target="_blank" href="<?php echo $product['href'];?>" title="<?php echo $product['allname'];?>" class="tmMCItemImg"><img src="<?php echo $product['thumb'];?>" alt="<?php echo $product['name'];?>" width="50" height="50"></a>
													<div class="tmMCItemskuWp">
														<span class="tmMCItemSku" title="<?php echo $product['allname'];?>"><?php echo $product['allname'];?></span>
														<span class="tmMCItemSku" title="S">S</span>
													</div>
													<span class="tmMCItemPrice"><?php echo $product['price'];?></span>
													<a class="tmMCItemDel"></a>
												</div>
											<?php } ?>
										</div>
									</div>
									<div class="tmMCBtnArea">
										<a class="tmMCViewFull" target="_blank" href="http://cart.tmall.com/cart/myCart.htm?from=viewbutton"></a>
									</div>
									<?php } ?>
									购物车数据加载
								<?php } ?>
								-->
								</div>
							</div>
						
						
						<span class="tmMCBotLink"><span class="tmMCNum" ><?php if($countProducts>0) { ?>购物车 <?php echo $countProducts;?><?php } else { ?>0<?php } ?>件</span></span>
						<div class="tmMCHdLeft" >
							<a class="tmMCBotLink" title="查看购物车" href="index.php?route=checkout/cart" target="_blank">
							<span class="tmMCNum" ><?php if($countProducts>0) { ?>购物车 <?php echo $countProducts;?><?php } else { ?>0<?php } ?>件</span>
							</a>
							<span class="tmMCEx"></span>
						</div>
					</div>
					<!-- <form method="POST" id="tmMCOrderForm">
						<input id="tmMCCartIds" type="hidden" name="cartId">
						<input id="tmMCDelCartIds" type="hidden" name="delCartIds">
						<input type="hidden" name="needMerge">
					</form> -->
				</div>
			</td>
		</tr>
	</tbody>
</table>

