<?php echo $header;?>
 	<!--左侧begin-->
	<?php echo $left;?>
 	<!--左侧end-->
    <!--右侧begin-->
	<div class="right"><div class="account_box1">
		<div class="item_list">
			<div class="tabs">
				<ul class="tabs_list">
					<li class="current"><h1><a href="">店铺设置</a></h1></li>
				</ul>
			</div>
<form action="index.php?route=merchants/merchants/insert" method="post" id="" onsubmit="return checkStore(this)">
<input name="map_x" type="hidden" value="" />
<input name="map_y" type="hidden" value="" />
<input name="logo_url" id="logo_url" type="hidden" value="<?php echo $info['logo'];?>" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="right"><em>*</em>店铺名称：</td>
    <td><input name="name" type="text" class="text4" id="name" maxlength="100" value="<?php if(isset($info['name'])) { ?><?php echo $info['name'];?><?php } ?>"/></td>
  </tr>
  <tr>
    <td align="right">店铺标志：</td>
    <td><img src="<?php echo $logo_url;?>" class="shop-pic"/>
	<p><span class="upload-btn" id="upload_logo">上传图标</span><span class="info-tip img-erro"><i></i>文件格式GIF、JPG、JPEG、PNG文件大小80K以内，建议尺寸80PX*80PX</span></p>	</td>
  </tr>
  <tr>
    <td align="right"><em>*</em>联系地址：</td>
    <td><select name="province" id="province" onchange="changCity(this.value)">
			<option value="">请选择省份</option>
		</select>
        <select name="city" id="city">
			<option value="">请选择城市</option>
		</select>
        <input name="address" type="text" class="text1" id="address" maxlength="100" value="<?php if(isset($info['address'])) { ?><?php echo $info['address'];?><?php } ?>"/></td>
  </tr>
  <tr>
    <td align="right"><em>*</em>联系电话：</td>
    <td><input name="tel" type="text" class="text1" id="tel" maxlength="50" value="<?php if(isset($info['tel'])) { ?><?php echo $info['tel'];?><?php } ?>"/> （例如：0551-64374866）</td>
  </tr>
  <tr>
    <td align="right"><em>*</em>联系手机：</td>
    <td><input name="mobile" type="text" class="text4" id="mobile" maxlength="60" value="<?php if(isset($info['mobile'])) { ?><?php echo $info['mobile'];?><?php } ?>"/></td>
  </tr>
  <tr>
    <td align="right">店铺传真：</td>
    <td><input name="fax" type="text" class="text4" id="fax" maxlength="60" value="<?php if(isset($info['fax'])) { ?><?php echo $info['fax'];?><?php } ?>"/></td>
  </tr>
  <tr>
    <td align="right"><em>*</em>店主姓名：</td>
    <td><input name="owner" type="text" class="text1" id="owner" maxlength="20" value="<?php if(isset($info['owner'])) { ?><?php echo $info['owner'];?><?php } ?>"/>	</td>
  </tr>
  <tr>
    <td align="right"><em>*</em>店铺介绍：</td>
    <td><div class="sh-edit" style="width:570px;_margin-left:60px;_margin-top:-18px;">
        <textarea class="edit" style="width:550px;height:200px" name="introduce" id="introduce"><?php if(isset($info['introduce'])) { ?><?php echo $info['introduce'];?><?php } ?></textarea>
        </div>	</td>
  </tr>
  <tr>
    <td align="right"><em>*</em>店铺位置：</td>
    <td><div class="map" id="container"></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" class="form-save" value="保存"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
		</div>
	
    </div></div>
    <!--右侧end-->
<?php echo $footer;?>
<script charset="utf-8" src="catalog/view/javascript/editor/kindeditor.js"></script>
<script charset="utf-8" src="catalog/view/javascript/editor/lang/zh_CN.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.4" charset="utf-8"></script>
<script id="map" type="text/javascript" src="catalog/view/javascript/baidu_map.js?v=1.0" data-pos="x=<?php echo $info['map_x'];?>&y=<?php echo $info['map_y'];?>" title="<?php echo $info['name'];?>"></script>
<script type="text/javascript" src="catalog/view/javascript/merchants.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	showProvince(<?php echo $info['province'];?>);
	setEditor();
	<!-- initMap(<?php echo $info['map_x'];?>,<?php echo $info['map_y'];?>); -->
	changCity(<?php echo $info['province'];?>,<?php echo $info['city'];?>);
});
</script>
