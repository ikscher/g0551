<?php echo $header;?>
 	<!--左侧begin-->
	<?php echo $left;?>
 	<!--左侧end-->
    <!--右侧begin-->
	<div class="right"><div class="account_box1">
		<div class="item-list">
			<div class="item-list-hd">
			<ul class="item-list-tabs item-list-tabs-flexible clearfix" >
				<li><a href="index.php?route=merchants/sell" hidefocus="true">出售中的宝贝</a></li>
				<li class="current"><a href="index.php?route=merchants/warehouse" hidefocus="true">等待上架的宝贝</a></li>
			</ul>
			</div>
			<div class="item-list-bd">
				<form name="" action="<?php echo $search_url;?>" method="post">
                <table>
					<tr>
						<td width="60" id="alignright">宝贝名称：</td>
						<td width="160" id="alignleft"><input name="name" type="text" size="20" class="input_txt" id="name" value="<?php if(isset($name)) { ?><?php echo $name;?><?php } ?>"/></td>
						<td width="60" id="alignright">宝贝编号：</td>
						<td width="160" id="alignleft"><input name="model" type="text" size="20" class="input_txt" id="model" value="<?php if(isset($model)) { ?><?php echo $model;?><?php } ?>"/></td>
						<td width="60" id="alignright">宝贝价格：</td>
					  <td width="150" id="alignleft"><input name="price1" type="text" class="input_txt" id="price1" size="7" maxlength="10" value="<?php if(isset($price1)) { ?><?php echo $price1;?><?php } ?>"/>
到
  <input name="price2" type="text" class="input_txt" id="price2" size="7" maxlength="10" value="<?php if(isset($price2)) { ?><?php echo $price2;?><?php } ?>"/></td>
				      <td id="alignleft"><button onclick="searchItems()" class="search-btn" type="submit">搜索</button></td>
				  </tr>
				</table>
                </form>
				<table align="center">
				<thead>
					<tr>
					  <th class="th_topbor" width="18"></th>
						<th class="th_topbor" width="60">宝贝图片</th>
						<th class="th_topbor" width="200">宝贝名称</th>
					  <th class="th_topbor" width="100">价格</th>
						<th class="th_topbor" width="100">库存</th>
					  <th class="th_topbor" width="60">上架</th>
						<th class="th_topbor" width="150">创建时间</th>
						<th width="60" class="th_topbor" >操作</th>
			          <th class="th_topbor" >&nbsp;</th>
				  </tr>
				</thead>
				</table> 
		  </div>  
			<table width="100%">
				<tr bgcolor="#f3f3f3" id="alignleft">
					<td width="60"><input type="checkbox" name="checkbox" value="" onclick="SelectAll('info_id',this)" /> 全选</td>
					<td width="200"><button class="trigger-btn" type="button" onclick="SetSelectProduct('index.php?route=merchants/sell/del','删除','宝贝','info_id')">删 除</button>
									<button class="trigger-btn" type="button" onclick="SetSelectProduct('index.php?route=merchants/sell/up','上架','宝贝','info_id')">上 架</button><td>
					<td></td>
			</table>
            <div class="sell">
                <?php foreach((array)$list as $info) {?>
                <table border="0" align="center" cellpadding="0" cellspacing="0" >
                  <tr>
                    <td colspan="7" class="td_top" id="alignleft"><label>
                      <input type="checkbox" name="info_id" value="<?php echo $info['product_id'];?>" />
                    宝贝编号 <?php echo $info['model'];?> </label></td>
                  </tr>
                  <tr>
                    <td height="72" colspan="7"><table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="60"><a href=""><img src="<?php echo $info['image'];?>" width="52" height="52" class="item-pic"/></a></td>
                        <td width="220"><?php echo $info['name'];?></td>
                        <td width="100" class="price-now">￥<span class="bf60"><?php echo $info['price'];?></span></td>
                        <td width="100"><?php echo $info['quantity'];?>(<?php echo $info['sku'];?>)</td>
                        <td width="60"><button class="trigger-btn" type="button" onclick="SetProduct('index.php?route=merchants/sell/up','上架','宝贝',<?php echo $info['product_id'];?>)">上 架</button></td>
                        <td width="150" align="center"><?php echo $info['date_added'];?></td>
                        <td width="60" align="center"><a href="<?php echo $info['edit_url'];?>">
                        <button class="trigger-btn" type="button">编辑宝贝</button></a><!--<a href="<?php echo $info['edit_url'];?>">编辑宝贝</a><br/><button class="trigger-btn" type="button">预览宝贝</button>--></td>
                      </tr>
                    </table></td>
                  </tr>
                </table>
                <?php } ?>
            </div>
            
      <!--begin  页脚批量操作和列表翻页 begin-->
	    <div class="pageRight">
		<table>
    		<tr>
    			<td><?php echo $page;?></td>
    		</tr>		
		</table>
		</div>
 	<!--页脚翻页end-->
		</div>
    </div></div>
 	<!--右侧end-->
</div>
<?php echo $footer;?>
<script type="text/javascript" src="catalog/view/javascript/merchants.js"></script>