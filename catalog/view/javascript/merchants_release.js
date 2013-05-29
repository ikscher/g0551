
$(document).ready(function(){

	
	//window.json={$attributeGroups};
	//window.json=document.getElementById('release').getAttribute('data-attr');
	//console.log(json);
   
	if(json.length>0){ 
	    var i=0,maxLen=json.length;
		for(;i<maxLen;i++){
		    var gtype=json[i].gtype;
		    var strAttr=[];
			strAttr.push('<tr id="tr_'+json[i].attribute_group_id+'">');
			
			if(gtype==2){//价格属性
			    strAttr.push('<td  width="90" class="gtype" align="right" ><label>'+json[i].attribute_group_name+'：</label></td>');
			}else{
			    strAttr.push('<td  width="90" align="right" ><label>'+json[i].attribute_group_name+'：</label></td>');
			}
			
			strAttr.push('<td><div class="attribute">');
			strAttr.push('<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="pushAttribute">');
			
			if(gtype==2){
			    strAttr.push('<tr><td  align="left"  class="composite" id="attribute_group_id'+json[i].attribute_group_id+'">');
            }else{
			    strAttr.push('<tr><td  align="left"  id="attribute_group_id'+json[i].attribute_group_id+'">');
			}
			var valList=json[i].attribute;
			if(valList.length>0){
				//根据不同的显示方式，生成不同的表单控件
				
				if(json[i].option_id==4){
					//下拉列表
					strAttr.push('<select name="attribute[]" id="attr_'+ json[i].attribute_group_id +'">');
					strAttr.push('<option value="" selected="selected">请选择'+ json[i].attribute_group_name +'</option>');
					var j=0,max=valList.length;
					for(;j<max;j++){
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
					var j=0,max=valList.length;
					for(;j<max;j++){
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
					
					var j=0,max=valList.length;
					for(;j<max;j++){
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
			
			//加载 （显示）属性组的选项
			
			//if($('#product_option_'+json[i].attribute_group_id+" .list tbody td select[name$='option_value_id]'] option:selected").length){
			//	var y='<tr  data-role="optionAddtional" class="optionsAdd"><td  width="90" align="right" ></td><td>'+$('#product_option_'+json[i].attribute_group_id).html()+  '</td></tr>';
			//	$('.sxtpy_attribute_Jxjx_0909').before(y);
			//}
			
			
			
		}
		
		if($('#product_option .list tbody tr').length){
			var y='<tr  data-role="optionAddtional" class="optionsAdd"><td  width="90" align="right" ></td><td>'+$('#product_option').html()+  '</td></tr>';
			$('.sxtpy_attribute_Jxjx_0909').before(y);
		}
			
		i=null;
		j=null;
		y=null;
	}
	
	
	f_set_num();
	
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
		}else if (json['type']==2 ){
		    
		    var attribute_id=that.val();
            
			var counter=0;//计数器
			var gtype_len=$('.gtype').length;
			var flag;
			$("td.gtype").each(function(i,w){
			    flag=false;
			    $(this).siblings("td").children('.attribute').children('table').children('tbody').children('tr').children('td').children('input').each(function(j,x){
				    if($(x).attr('checked')=='checked'){
					    flag=true;
						return false;
					}
					
				});
				if(flag==true) counter++;
			});
			//console.log(counter);
			//console.log(gtype_len);
			var attribute_={};
			
			if(counter==gtype_len){
			    $('td.composite').each(function(i,w){
				    var attribute=[];
				    var gid=$(w).attr('id').replace(/[a-z_]*/,'');
				    $(w).children('input').each(function(k,y){
				        if($(y).attr('checked')=='checked'){
						    var x=$(y).val();
							var l=$(y).next('label').text();
						    attribute[x]=l;
						    
						}
				    });
					
					attribute_[gid]=attribute;
				});
				//console.log(attribute_);
				
				
				var attribute__=[];
                for(var name in attribute_){
				    if(attribute_[name]!==undefined && attribute_[name]!==null){
					    attribute__.push(attribute_[name]);//attribute__[name]=(attribute_[name]);
					}
				}
				
				//console.log(attribute__.length);
			
				
				
				if($('.optionsAdd').length<=0){
					var x='<tr data-role="optionAddtional" class="optionsAdd"><td  width="90" align="right" ></td><td>'+$('#product_option').html()+  '</td></tr>';
					$('.sxtpy_attribute_Jxjx_0909').before(x);
				}
				
				
				
				if(that.attr('checked')=='checked'){
				    if(attribute__.length==2){ //两个属性决定的价格
						for(var c in attribute__[1]){
							for (var d in attribute__[0]){							
								//console.log($('.optionsAdd  table.list tbody tr.attribute_'+c+'_'+d+'_').length);
								if($('.optionsAdd  table.list tbody tr.attribute_'+c+'_'+d+'_').length<=0){
									addOptionValue(c,attribute__[1][c],d,attribute__[0][d]);
								}
							}
						}
                    }else if(attribute__.length==1){ //一个属性决定的价格
                        
						for (var d in attribute__[0]){							
							//console.log($('.optionsAdd  table.list tbody tr.attribute_'+c+'_'+d+'_').length);
							if($('.optionsAdd  table.list tbody tr.attribute_'+d+'_').length<=0){
								addOptionValue(d,attribute__[0][d]);
							}
						}
						
                    }					
			    }else{
				    $(".optionsAdd  table.list tbody tr td.attribute_"+attribute_id).parent().remove();
					/*
					if($('.list tbody tr[data-role^=_'+attribute_id+'_]').length>0){
						$('.list tbody tr[data-role^=_'+attribute_id+'_]').remove();
					}else{
						var x=$(".list tbody tr td.attribute_"+attribute_id).parent().attr('data-role');
						
						var y=x.split('_');
		
						var z=y[1];
						
						
						var len=$('.list tbody tr[data-role^=_'+z+'_]').length;
						len=len-1;
						if (len>=1){
							$('.list tbody tr td.attribute_'+z).attr('rowSpan',len);
							
							$(".list tbody tr td.attribute_"+attribute_id).prev().each(function(i,w){
								if($(this).attr('rowSpan')){
								   var s=$(this).text();
								   $('<td class="attribute_'+z+'" rowSpan="'+len+'">'+s+'</td>').prependTo($(this).parent().next());
								}
							});
						}
						
						$(".list tbody tr td.attribute_"+attribute_id).parent().remove();

					}
					*/
					
				}
				
	
			}else if(counter!=gtype_len){
			    $(".optionsAdd").remove();
            }
			f_set_num();
		}
	});
	
	
});

$(".optionsAdd input[name$='[quantity]']").live('blur',function(){  
	var sum=0;
	$(".optionsAdd input[name$='[quantity]']").each(function(i,w){
	    var x=parseInt($(w).val());
	    if(isNaN(x)) return true;
		sum +=x;
	});
	if(sum>0) $('input[name=quantity]').val(sum);
});



//var option_value_row = {$option_value_row};
var option_value_row=document.getElementById('release').getAttribute('data-row');

function addOptionValue(attribute_id1,attribute_name1,attribute_id2,attribute_name2) {	
    var html='';
	//html  = '<tbody id="option-value-row">'; 
	if(attribute_id2 && attribute_name2){
		html += '  <tr class="attribute_'+attribute_id1+'_'+attribute_id2+'_" data-role="_'+attribute_id1+'_'+attribute_id2+'_" >';
		html += '    <td class="attribute_'+attribute_id1+ '">'+attribute_name1+'</td>';
		html += '   <input type="hidden" name="product_option[' + option_value_row + '][attribute1]" value="'+attribute_id1+'" />';
		html += '    <td class="attribute_'+attribute_id2+ '" >'+attribute_name2+'</td>';
		html += '   <input type="hidden" name="product_option[' + option_value_row + '][attribute2]" value="'+attribute_id2+'" />';
	}else{
	    html += '  <tr class="attribute_'+attribute_id1+'_" data-role="_'+attribute_id1+'_" >';
		html += '    <td class="attribute_'+attribute_id1+ '">'+attribute_name1+'</td>';
		html += '   <input type="hidden" name="product_option[' + option_value_row + '][attribute1]" value="'+attribute_id1+'" />';
		<!-- html += '    <td class="attribute_'+attribute_id2+ '" >'+attribute_name2+'</td>'; -->
		<!-- html += '   <input type="hidden" name="product_option[' + option_value_row + '][attribute2]" value="'+attribute_id2+'" />'; -->
	}
	
	html += '    <td><input type="text" name="product_option[' + option_value_row + '][quantity]" value="" size="10" /></td>'; 
	html += '    <td><select name="product_option[' + option_value_row + '][subtract]">';
	html += '      <option value="1">是</option>';
	html += '      <option value="0">否</option>';
	html += '    </select></td>';
	html += '    <td><input type="text" name="product_option[' + option_value_row + '][price]" value="" size="12" /></td>';
	html += '    <td><a href="javascript:void(0);" class="deleteOptionRow">删除</a></td>';
	html += '  </tr>';
	//<!-- html += '</tbody>'; 
    //console.log(html);
	
	
	
	
	var compositeID,flag=false;
    $('.optionsAdd  table.list tbody tr').each(function(i,w){
	    compositeID=$(w).attr('data-role');
		if(compositeID.indexOf(attribute_id1)>=0){
		   flag=true;
		   $(this).before(html);
		   return false;
			
		}
	});
  
	if (flag===false) $('tr.optionsAdd  table.list tbody' ).append(html);
	
	
	option_value_row++;
	/*
	var len=$('.list tbody tr[data-role^=_'+attribute_id1+'_]').length;
	
	if(len>=2) {
	    $('.list tbody tr td.attribute_'+attribute_id1).each(function(i,w){
		    if(i==0){
		        $(this). attr('rowSpan',len);
			}else{
			    $(this).remove();
			}
		});
	}
		
	*/
	
}

$(".deleteOptionRow").live('click',function(){
    
	var compositeID=$(this).parent().parent().attr('data-role');
	//console.log(compositeID);
	var x=compositeID.split('_');

	
	$(this).parent().parent().remove();
	
	
	for(var m in x){
	    if(!x[m]) continue;
	    if($('.optionsAdd  table.list tbody tr td.attribute_'+x[m]).length <=0){
	       $("#attr_"+x[m]).removeAttr("checked");
		}
	}
	
	if($(".optionsAdd  table.list tbody tr").length==0) $(".optionsAdd").remove();
	
	//console.log($(".optionsAdd input[name$='[quantity]']").length);
	f_set_num();
		
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

$("input[name=try]").click(function(){
    if( $(this).prop('checked')==true){
	    $(this).val(1);
	}else{
	    $(this).val(0);
	}
});



$("input[name^=date]").live("click", function(){
    $(this).datetimepicker({
    	dateFormat: 'yy-mm-dd',
		timeFormat: 'hh:mm:ss',
		numberOfMonths: 2 //显示两个月
	});
});

function f_set_num(){
	if($(".optionsAdd input[name$='[quantity]']").length>0){
		$('input[name=quantity]').attr('readonly',true);
		$('input[name=quantity]').css({'background':'#ECE9D8'});
	}else{
		$('input[name=quantity]').removeAttr('readonly');
		$('input[name=quantity]').css({'background':'#FFFFFF'});
	}
	
	var sum=0;
	$(".optionsAdd input[name$='[quantity]']").each(function(i,w){
	    var x=parseInt($(w).val());
	    if(isNaN(x)) return true;
		sum +=x;
	});
    
	if (sum>0) $('input[name=quantity]').val(sum);
}

//链接ETAO
$('.etao').click(function(){
	var now = new Date();

	var year = now.getFullYear();       //年
	var month = now.getMonth() + 1;     //月
	var day = now.getDate();            //日

   
	var today = year + "";
   
	if(month < 10)
		today += "0";
   
	today += month + "";
   
	if(day < 10)
		today += "0";
	   
	today += day ;
	
    var productName=$('input[name=name]').val();
	productName=productName.replace(/\s*/g,'');
    if(!productName) return false;
	productName=productName.substr(0,20);
	//productName=encodeURIComponent(productName);
	var href='http://s.etao.com/search?q='+productName+'&initiative_id=setao_'+today+'&style=grid';
	window.open(href,'','height=600,width=800,scrollbars=yes,status =yes');
});
