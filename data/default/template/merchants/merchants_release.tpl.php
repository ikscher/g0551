<?php echo $header;?>
 	<!--左侧begin-->
	<?php echo $left;?>
 	<!--左侧end-->
	
    <!--右侧begin-->
	<div class="right">
		<div class="blue_bor">
			<div class="blue_topbg">
				<ul>
					<li class="bl">填写宝贝基本信息</li>
					<li class="br"><span class="red">*</span> 表示该项必填</li>
				</ul>
			</div>
			<div class="blue_r">	
                <form id="formfb" name="formfb" method="post" action="index.php?route=merchants/release/insert" onsubmit="return checkProduct(this)">
                	<input name="category_id" id="category_id" type="hidden" value="<?php echo $category_id;?>" />
                	<?php if($product_id>0) { ?><input name="product_id" id="product_id" type="hidden" value="<?php echo $product_id;?>" /><?php } ?>
                    <input name="product_image" id="product_image" type="hidden" value="" />
				    <table width="760" border="0" align="center" cellpadding="0" cellspacing="0" class="mainTbl">
					    <!--
						<tr>
						    <td  width="90" align="right" ><label>宝贝属性：</label></td>
						    <td>
								<div class="attribute"></div>
							</td>
						</tr>
					    -->
						
						
						
						<tr>
						    <td width="90" align="right"><label>宝贝标题：</label></td>
						    <td><label>
							<input name="name" type="text" class="input_txt" onfocus="textCounter(this,'leavings',50);" onblur="textCounter(this,'leavings',50);" onkeyup="textCounter(this,'leavings',50);" size="94" maxlength="60" id="name" value="<?php echo $info['name'];?>" /> 
							<span >还能输入<em id="leavings">50</em>字</span></label></td>
						</tr>
						<tr>
						    <td width="90" align="right"><label>宝贝价格：</label></td>
						    <td><label>
							<input name="price" type="text" class="input_txt" size="20" maxlength="10" id="price" value="<?php echo $info['price'];?>" />
						  元</label>  <input type="checkbox" name="isSpecial" id="special" value="1" <?php if(!empty($info['special'])) { ?>checked="checked"<?php } ?> /><label for="special">是否优惠</label></td>
						</tr>
						
						<?php if(!empty($info['special'])) { ?>
						     <tr><td width="90" align="right"><label>优惠价格：</label></td><td><input name="special_price" type="text" class="input_txt" size="20" maxlength="10" id="special_price"  value="<?php echo $info['special']['price'];?>" /><label> 元  开始：</label><input type="textbox" name="date_start"  class="input_txt" value="<?php echo $info['special']['date_start'];?>" /><label> 结束：</label><input type="textbox" name="date_end" class="input_txt" value="<?php echo $info['special']['date_end'];?>" /></td></tr>
						<?php } ?>
						
						<tr>
						  <td width="90" align="right"><label>宝贝数量：</label></td>
						  <td><label>
							<input name="quantity" type="text" class="input_txt" size="20" maxlength="8" id="quantity" value="<?php echo $info['quantity'];?>" />
						  </label></td>
						</tr>
						<tr> 
						  <td align="right"><label>库存单位：</label></td>
						  <td><label><input name="sku" type="text" class="input_txt" size="20" maxlength="10" id="sku"  value="<?php echo $info['sku'];?>" /> 
						  如：件、瓶、盒、套……</label></td>
					  </tr>
						<tr>
						  <td align="right"><label>要求配送：</label></td>
						  <td><label><input name="shipping" type="radio" id="radio"  value="1"  <?php if($info['shipping']==1) { ?>checked="checked" <?php } ?> />
						    需要　
                            <input type="radio" name="shipping" id="radio2" <?php if($info['shipping']==2) { ?>checked="checked" value="2" <?php } ?> />
					        不需要</label></td>
					  </tr>
						<tr>
						  <td align="right"><label>当前状态：</label></td>
						  <td><label><input name="status" type="radio" id="radio"  value="1"  <?php if($info['status']==1) { ?>checked="checked" <?php } ?>/>
						    上架　
                            <input type="radio" name="status" id="radio2" <?php if($info['status']==3) { ?>checked="checked" value="3" <?php } ?>/>
					        下架</label></td>
					  </tr>
						<tr>
						  <td width="90" align="right"><label>宝贝编号：</label></td>
						  <td><label>
							<input name="model" type="text" class="input_txt" size="30" maxlength="50" value="<?php echo $info['model'];?>" />
						  请输入宝贝编码，方便将来管理查找</label></td>
						</tr>
						<tr>
						    <td width="90" align="right"><label>宝贝图片：</label></td>
						    <td>
								<!-- imageUpload -->
								<div id="itemPic">
								<div class="pic-manager2">
                                    <ul id="imageList">
                                    <?php foreach((array)$image as $img) {?><li id="img_item<?php echo $img['id'];?>"><img src="<?php echo $img['image'];?>" width="80" height="80"/><div><a href="javascript:setProductImage(<?php echo $img['id'];?>);">设主图</a>　<a href="javascript:delProductImage(<?php echo $img['id'];?>);">删除</a></div></li><?php } ?>
                                    </ul>
                                    <ul id="J_imageView"></ul>
                                    <div style="clear:both;"><span class="upload" id="J_selectImage"><a href="javascript:void(0);"></a></span></div>
                                    <div class="pm-msg">
                                        <div class="msg"><p class="attention" style="width:559px">图片至少上传1张，图片大小不能超过512K，第1张图片默认作为宝贝主图。</p></div>
                                    </div>
								</div>
								</div>							</td>
					    </tr>
						<tr>
						    <td width="90" align="right"><label>宝贝描述：</label></td>
						    <td><div id="editor_body" style="width:660px;"><textarea name="description" style="width:650px;height:280px;" id="description"><?php echo $info['description'];?></textarea></div>	  </td>
						</tr>
						<tr>
							<td height="25" colspan="2" style="padding:0px; margin:0px;"></td>
					    </tr>
		      </table>
                    <div class="submit">
						<div class="float-submitbar">
							<button type="submit" name="" class="J_Submit btn btn-main-primary btn-submit" value="发布" >
							<span class="btn-txt">发布商品</span>  </button>
						</div>
				    </div>
			    </form>
			</div>
		</div>
    
    </div>
 	<!--右侧end-->
	
	<!--属性的选项begin-->
	<?php $option_row = 0?>
	<?php $option_value_row = 0?>
	<?php foreach((array)$product_options as $product_option) {?>
	<div id="product_option_<?php echo $product_option['attribute_group_id'];?>"  style="display:none" > 
	<!-- <tr >
		<td  width="90" align="right" ></td>
		<td> -->
				 <input type="hidden" name="product_option[<?php echo $option_row;?>][product_option_id]" value="<?php echo $product_option['product_option_id'];?>" />
				 <input type="hidden" name="product_option[<?php echo $option_row;?>][name]" value="<?php echo $product_option['name'];?>" />
				 <input type="hidden" name="product_option[<?php echo $option_row;?>][attribute_group_id]" value="<?php echo $product_option['attribute_group_id'];?>" />
				 <input type="hidden" name="product_option[<?php echo $option_row;?>][option_id]" value="<?php echo $product_option['option_id'];?>" />
				 <input type="hidden" name="product_option[<?php echo $option_row;?>][type]" value="<?php echo $product_option['type'];?>" />
				
				<?php if($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') { ?>
				<table id="option-value<?php echo $option_row;?>" class="list">
				  <thead>
					<tr>
					  <td>选项数值</td>
					  <td>商品数量</td>
					  <td>扣减库存</td>
					  <td>销售价格</td>
					  <td>积分</td>
					  <td>重量</td>
					  <td>必填项</td>
					  <td></td>
					</tr>
				  </thead>
				 
				  <?php foreach((array)$product_option['product_option_value'] as $product_option_value) {?>
				  <tbody id="option-value-row<?php echo $option_value_row;?>">
					<tr>
					  
					  <td><select name="product_option[<?php echo $option_row;?>][product_option_value][<?php echo $option_value_row;?>][option_value_id]">
						  <?php if(isset($option_values[$product_option['attribute_group_id']])) { ?>
						  <?php foreach((array)$option_values[$product_option['attribute_group_id']] as $option_value) {?>
						  <?php if($option_value['option_value_id'] == $product_option_value['option_value_id']) { ?>
						  <option value="<?php echo $option_value['option_value_id'];?>,<?php echo $option_value['attribute_id'];?>" selected="selected"><?php echo $option_value['name'];?></option>
						   <?php } else { ?>
						  <option value="<?php echo $option_value['option_value_id'];?>,<?php echo $option_value['attribute_id'];?>"><?php echo $option_value['name'];?></option>
						  <?php } ?>
						  <?php } ?>
						  <?php } ?>
						</select>
						<input type="hidden" name="product_option[<?php echo $option_row;?>][product_option_value][<?php echo $option_value_row;?>][attribute_id]" value="<?php echo $product_option_value['attribute_id'];?>" />
						<input type="hidden" name="product_option[<?php echo $option_row;?>][product_option_value][<?php echo $option_value_row;?>][product_option_value_id]" value="<?php echo $product_option_value['product_option_value_id'];?>" />
					  </td>
					  <td><input type="text" name="product_option[<?php echo $option_row;?>][product_option_value][<?php echo $option_value_row;?>][quantity]" value="<?php echo $product_option_value['quantity'];?>" size="3" /></td>
					  <td><select name="product_option[<?php echo $option_row;?>][product_option_value][<?php echo $option_value_row;?>][subtract]">
						  <?php if($product_option_value['subtract']) { ?>
						  <option value="1" selected="selected">是</option>
						  <option value="0">否</option>
						   <?php } else { ?>
						  <option value="1">是</option>
						  <option value="0" selected="selected">否</option>
						  <?php } ?>
						</select></td>
					  <td><select name="product_option[<?php echo $option_row;?>][product_option_value][<?php echo $option_value_row;?>][price_prefix]">
						  <?php if($product_option_value['price_prefix'] == '+') { ?>
						  <option value="+" selected="selected">+</option>
						   <?php } else { ?>
						  <option value="+">+</option>
						 <?php } ?>
						  <?php if($product_option_value['price_prefix'] == '-') { ?>
						  <option value="-" selected="selected">-</option>
						   <?php } else { ?>
						  <option value="-">-</option>
						  <?php } ?>
						</select>
						<input type="text" name="product_option[<?php echo $option_row;?>][product_option_value][<?php echo $option_value_row;?>][price]" value="<?php echo $product_option_value['price'];?>" size="5" />
						</td>
					  <td><select name="product_option[<?php echo $option_row;?>][product_option_value][<?php echo $option_value_row;?>][points_prefix]">
						  <?php if($product_option_value['points_prefix'] == '+') { ?>
						  <option value="+" selected="selected">+</option>
						   <?php } else { ?>
						  <option value="+">+</option>
						  <?php } ?>
						  <?php if($product_option_value['points_prefix'] == '-') { ?>
						  <option value="-" selected="selected">-</option>
						   <?php } else { ?>
						  <option value="-">-</option>
						  <?php } ?>
						</select>
						<input type="text" name="product_option[<?php echo $option_row;?>][product_option_value][<?php echo $option_value_row;?>][points]" value="<?php echo $product_option_value['points'];?>" size="5" /></td>
					  <td><select name="product_option[<?php echo $option_row;?>][product_option_value][<?php echo $option_value_row;?>][weight_prefix]">
						  <?php if($product_option_value['weight_prefix'] == '+') { ?>
						  <option value="+" selected="selected">+</option>
						   <?php } else { ?>
						  <option value="+">+</option>
						  <?php } ?>
						  <?php if($product_option_value['weight_prefix'] == '-') { ?>
						  <option value="-" selected="selected">-</option>
						   <?php } else { ?>
						  <option value="-">-</option>
						  <?php } ?>
						</select>
						<input type="text" name="product_option[<?php echo $option_row;?>][product_option_value][<?php echo $option_value_row;?>][weight]" value="<?php echo $product_option_value['weight'];?>" size="5" /></td>
					  <td><a href="javascript:void(0);"  class="deleteOptionRow">删除</a></td>
					</tr>
				  </tbody>
				  <?php $option_value_row++?>
				  <?php } ?>
				</table>	
                 <select id="option-values<?php echo $product_option['attribute_group_id'];?>" style="display: none;">
				  <?php if(isset($option_values[$product_option['attribute_group_id']])) { ?>
				  <?php foreach((array)$option_values[$product_option['attribute_group_id']] as $option_value) {?>
				  <option value="<?php echo $option_value['option_value_id'];?>,<?php echo $option_value['attribute_id'];?>" ><?php echo $option_value['name'];?></option>
				  <?php } ?>
				 <?php } ?>
				</select>				
			 <?php } ?>		  
		<!--   </td>
	</tr> -->
	</div>
	<?php $option_row++?>
	<?php } ?>
	<!--属性的选项end-->
	
	
	
<?php echo $footer;?>
<script charset="utf-8" src="catalog/view/javascript/editor/kindeditor.js"></script>
<script charset="utf-8" src="catalog/view/javascript/editor/lang/zh_CN.js"></script>
<script type="text/javascript" src="catalog/view/javascript/merchants.js?v=20130320"></script>
<script type="text/javascript"><!--
$(document).ready(function(){
	productEditor();
	window.json=<?php echo $attributeGroups;?>;
    console.log(json);
	if(json.length>0){
		for(var i=0;i<json.length;i++){
		    
		    var strAttr=[];
			strAttr.push('<tr id="tr_'+json[i].attribute_group_id+'">');
			strAttr.push('<td  width="90" align="right" ><label>'+json[i].attribute_group_name+'：</label></td>');
			
			strAttr.push('<td><div class="attribute">');
			strAttr.push('<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="pushAttribute">');
			strAttr.push('<tr><td  align="left"  id="attribute_group_id'+json[i].attribute_group_id+'">');

			var valList=json[i].attribute;
			if(valList.length>0){
				//根据不同的显示方式，生成不同的表单控件
				
				if(json[i].option_id==4){
					//下拉列表
					strAttr.push('<select name="attribute[]" id="attr_'+ json[i].attribute_group_id +'">');
					strAttr.push('<option value="" selected="selected">请选择'+ json[i].attribute_group_name +'</option>');
					for(var j=0;j<valList.length;j++){
						strAttr.push('<option value="');
						strAttr.push(valList[j].attribute_id);
			            
						
						if(json[i].product_option_value && json[i].product_option_value.length==1){//只有一个属性，单选项
							if(valList[j].attribute_id==json[i].product_option_value[0].attribute_id){
								strAttr.push('" selected="selected');
							}
						}
						
						strAttr.push('">');
						strAttr.push(valList[j].name);
						strAttr.push('</option>');
					}
					strAttr.push('</select>');
				}else if (json[i].option_id==2){
					//复选框
					for(var j=0;j<valList.length;j++){
						strAttr.push('<input name="attribute[]" id="attr_');
						strAttr.push(valList[j].attribute_id);
						strAttr.push('" type="checkbox" value="');
						strAttr.push(valList[j].attribute_id);
				        
						if(json[i].product_option_value){
							for(var k=0;k<json[i].product_option_value.length;k++){
								if(valList[j].attribute_id==json[i].product_option_value[k].attribute_id){
									strAttr.push('" checked="checked');
								}
							}
						}
						
						strAttr.push('" /> ');
						strAttr.push("<label for='attr_"+valList[j].attribute_id+"'>");
						strAttr.push(valList[j].name);
						strAttr.push("</label>");
						strAttr.push('　');
					}
				}else if (json[i].option_id==1){
					//单选框
					
					for(var j=0;j<valList.length;j++){
						strAttr.push('<input name="attribute[]" id="attr_');
						strAttr.push(valList[j].attribute_id);
						strAttr.push('" type="radio" value="');
						strAttr.push(valList[j].attribute_id);
						
						if(json[i].product_option_value){
							for(var k=0;k<json[i].product_option_value.length;k++){
								if(valList[j].attribute_id==json[i].product_option_value[k].attribute_id){
									strAttr.push('" checked="checked');
								}
							}
						}
						strAttr.push('" /> ');
						strAttr.push("<label for='attr_"+valList[j].attribute_id+"'>");
						strAttr.push(valList[j].name);
						strAttr.push("</label>");
						strAttr.push('　');
					}
				}
			}
			strAttr.push('</td></tr>');
			strAttr.push('</table></div></td></tr>');
	
			$(".mainTbl").prepend(strAttr.join(""));
			
			//初始化，加载属性组的选项
			if($('#product_option_'+json[i].attribute_group_id+" .list tbody td select[name$='option_value_id]'] option:selected").length){
				var y='<tr  data-role="optionAddtional" class="optionsAdd_'+json[i].attribute_group_id+'"><td  width="90" align="right" ></td><td>'+$('#product_option_'+json[i].attribute_group_id).html()+  '</td></tr>';
				$('#tr_'+json[i].attribute_group_id).after(y);
			}
			
		}
		i=null;
		j=null;
		y=null;
	}
});


//针对checkbox and radio选框单击事件（1）
$("input[name^=attribute]").live('click',function(){
    var option_value=$(this).val();
	if(!option_value) return false;
	
    var attribute_group_id=$(this).parent().attr('id').replace(/attribute_group_id/g,'');
	
	var that=$(this);
	//判断属性组类型：一般属性还是价格属性
	$.getJSON('index.php?route=merchants/release/getAttributeGroupType',{attribute_group_id:attribute_group_id},function(json){
	    if(json['type']==1){
		    return false;
		}else if (json['type']==2){
		    
		    var attribute_id=that.val();
	 
			//没有对应的属性值
			//var so_len=$("#tr"+attribute_group_id+" select[id=option-values"+attribute_group_id + "] option").size();
			//if (so_len<=0) return false;
			
			//显示对应属性组的选项
			//$('.mainTbl tbody tr[data-role="optionAddtional"]').hide();
			//$('.mainTbl tbody tr.optionsAdd_'+attribute_group_id).show();
			
			if (($('#tr_'+attribute_group_id).next('.optionsAdd_'+attribute_group_id)).length<=0){//属性组的显示
				var x='<tr data-role="optionAddtional" class="optionsAdd_'+attribute_group_id+'"><td  width="90" align="right" ></td><td>'+$('#product_option_'+attribute_group_id).html()+  '</td></tr>';
				$('#tr_'+attribute_group_id).after(x);
			}
			
			var optionRowNum=$('.optionsAdd_'+attribute_group_id + ' td input[name$="attribute_group_id]"]').attr('name');
			var option_row=optionRowNum.replace(/\D/g,'');

			//属性组选项列表有对应的属性，点击属性不重复增加 属性选项
			var attributeIds=',';
			$(".optionsAdd_"+attribute_group_id+" td select[name$='option_value_id]']>option:selected").map(function(i,w){
				var optionStr=$(w).val();
				var optionArr=optionStr.split(',');
				attributeIds=attributeIds.concat(optionArr[1]+',');
				
			});
			if(attributeIds.indexOf(','+attribute_id+',')<0){
				addOptionValue(attribute_group_id,attribute_id,option_row);
			}else{
				//$('#option-value-row3').remove();
				$(".optionsAdd_"+attribute_group_id + " table.list tbody").map(function(i,w){
					var tbody=$(w);
					var android=tbody.find('select[name^="product_option"] option:selected').val();
					var iphone=android.split(',');
					if (attribute_id==iphone[1]){
						$(this).remove();
						return false;
					}
				});
			}
		}
	});
	
	
});

//针对select 下拉选框 单击事件（2）
$("select[name^=attribute]").live('change',function(){
    var option_value=$(this).val();
	if(!option_value) return false;
	
    var attribute_group_id=$(this).parent().attr('id').replace(/attribute_group_id/g,'');
	var attribute_id=$(this).val();
	
	//判断属性组类型：一般属性还是价格属性
	$.getJSON('index.php?route=merchants/release/getAttributeGroupType',{attribute_group_id:attribute_group_id},function(json){
		if(json['type']==1){
		    return false;
		}else if(json['type']==2){
		    
			//没有对应的属性值
			//var so_len=$("#product_option_"+attribute_group_id+" select[id=option-values"+attribute_group_id + "] option").size();
			//if (so_len<=0) return false;
			
			//显示对应属性组的选项
			//$('.mainTbl tbody tr[data-role="optionAddtional"]').hide();
			//$('.mainTbl tbody tr.optionsAdd_'+attribute_group_id).show();

			if (($('#tr_'+attribute_group_id).next('.optionsAdd_'+attribute_group_id)).length<=0){//属性组的显示
				var x='<tr data-role="optionAddtional" class="optionsAdd_'+attribute_group_id+'"><td  width="90" align="right" ></td><td>'+$('#product_option_'+attribute_group_id).html()+  '</td></tr>';
				$('#tr_'+attribute_group_id).after(x);
			}
			
			var optionRowNum=$('.optionsAdd_'+attribute_group_id + ' td input[name$="attribute_group_id]"]').attr('name');
			var option_row=optionRowNum.replace(/\D/g,'');
			
			//属性组选项列表有对应的属性，点击属性不重复增加 属性选项
			var attributeIds=',';
			$(".optionsAdd_"+attribute_group_id+" td select[name$='option_value_id]']>option:selected").map(function(i,w){
				var optionStr=$(w).val();
				var optionArr=optionStr.split(',');
				attributeIds=attributeIds.concat(optionArr[1]+',');
				
			});
			if(attributeIds.indexOf(','+attribute_id+',')<0){
				addOptionValue(attribute_group_id,attribute_id,option_row);
			}
	
		}
	});
 
	
});
//--></script>

<script type="text/javascript"><!--	
var option_value_row = <?php echo $option_value_row;?>;
function addOptionValue(attribute_group_id,attribute_id,option_row) {	
	html  = '<tbody id="option-value-row' + option_value_row + '">';
	html += '  <tr>';
	html += '    <td><select name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][option_value_id]">';
	html += $('#option-values' + attribute_group_id).html();
	html += '    </select><input type="hidden" name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][attribute_id]" value="" /><input type="hidden" name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][product_option_value_id]" value="" /></td>';
	html += '    <td><input type="text" name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][quantity]" value="" size="3" /></td>'; 
	html += '    <td><select name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][subtract]">';
	html += '      <option value="1">是</option>';
	html += '      <option value="0">否</option>';
	html += '    </select></td>';
	html += '    <td><select name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][price_prefix]">';
	html += '      <option value="+">+</option>';
	html += '      <option value="-">-</option>';
	html += '    </select>';
	html += '    <input type="text" name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][price]" value="" size="5" /></td>';
	html += '    <td><select name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][points_prefix]">';
	html += '      <option value="+">+</option>';
	html += '      <option value="-">-</option>';
	html += '    </select>';
	html += '    <input type="text" name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][points]" value="" size="5" /></td>';	
	html += '    <td><select name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][weight_prefix]">';
	html += '      <option value="+">+</option>';
	html += '      <option value="-">-</option>';
	html += '    </select>';
	html += '    <input type="text" name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][weight]" value="" size="5" /></td>';
	html += '    <td><a href="javascript:void(0);" class="deleteOptionRow">删除</a></td>';
	html += '  </tr>';
	html += '</tbody>';
    //console.log(html);
	$('tr.optionsAdd_'+attribute_group_id+' .list' ).append(html);

	//$('select[name="product_option[2][product_option_value][4][option_value_id]"] option[value$=",41"]').attr('selected','selected');
	$('select[name="product_option['+option_row +'][product_option_value]['+option_value_row +'][option_value_id]"] option[value$=",'+attribute_id+'"]').attr('selected','selected');
	option_value_row++;
}

$(".deleteOptionRow").live('click',function(){
    //onclick="$('#option-value-row<?php echo $option_value_row;?>').remove();"
    $(this).parent().parent().parent().remove();
	var compositeID=$(this).parent().parent().children().first().children('select').val();
	if(compositeID){
		var y=compositeID.split(',');
		var attid=y[1];
		$("#attr_"+attid).removeAttr("checked");
	}
});

$("#special").click(function(){
    var x='<tr><td width="90" align="right"><label>优惠价格：</label></td><td><input name="special_price" type="text" class="input_txt" size="20" maxlength="10" id="special_price" value="" /> <label>元  开始：</label><input type="textbox" name="date_start"  class="input_txt"/><label> 结束：</label><input type="textbox" name="date_end" class="input_txt" /></td></tr>';
 
	if($(this).prop('checked')==true){
	    if($("#special_price").length<=0){
		    $(this).parent().parent().after(x);
	   }
	}else{
	    if($("#special_price").length>0){
	       $("#special_price").parent().parent().remove();
		}
	}
});
//--></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script> 
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" /> 
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-timepicker-addon.js"></script> 
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/i18n/jquery.ui.datepicker-zh-CN.js"></script> 
<script type="text/javascript"><!--
$("input[name^=date]").live("click", function(){
    $(this).datepicker({
    	dateFormat: 'yy-mm-dd',
		numberOfMonths: 2 //显示两个月
	});
});
//--></script> 
