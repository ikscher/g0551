

//省份
var provice = new Array("10106000,安徽","10102000,北京","10103000,上海","10101000,广东","10104000,天津","10105000,重庆","10107000,福建","10108000,甘肃","10109000,广西","10110000,贵州","10111000,海南","10112000,河北","10113000,河南","10114000,黑龙江","10115000,湖北","10116000,湖南","10117000,吉林","10118000,江苏","10119000,江西","10120000,辽宁","10121000,内蒙古","10122000,宁夏","10123000,青海","10124000,山东","10125000,山西","10126000,陕西","10127000,四川","10128000,西藏","10129000,新疆","10130000,云南","10131000,浙江","10132000,澳门","10133000,香港","10134000,台湾");

//市
var city = new Array("10102001,北京","10103001,上海","10104001,天津","10105001,重庆","10132001,澳门","10133001,香港","10101201,深圳","10101002,广州","10101003,佛山","10101004,湛江","10101005,珠海","10101006,肇庆","10101007,东莞","10101008,惠州","10101011,中山","10101012,茂名","10101013,汕头","10101014,梅州","10101015,韶关","10101016,江门","10101018,清远","10101020,潮州","10101022,阳江","10101023,河源","10101026,揭阳","10101028,汕尾","10101068,云浮","10106001,合肥","10106002,淮南","10106003,蚌埠","10106004,宿州","10106005,阜阳","10106006,六安","10106007,巢湖","10106008,滁州","10106009,芜湖","10106011,安庆","10106012,黄山","10106013,铜陵","10106027,贵池","10106042,淮北","10106030,桐城","10106038,明光","10106075,马鞍山","10106078,天长","10106079,池州","10106080,宣城","10106099,亳州","10107001,福州","10107002,厦门","10107010,莆田","10107003,泉州","10107013,宁德","10107004,南平","10107007,漳州","10107008,龙岩","10107009,三明","10108001,兰州","10108002,张掖","10108003,武威","10108004,酒泉","10108006,金昌","10108022,临夏","10108007,天水","10108008,定西","10108012,甘南","10108009,平凉","10108023,嘉峪关","10108064,庆阳","10108078,白银","10108084,陇南","10109001,南宁","10109002,柳州","10109003,钦州","10109004,百色","10109005,玉林","10109006,防城港","10109007,桂林","10109008,梧州","10109083,崇左","10109009,河池","10109010,北海","10109014,贵港","10109018,来宾","10109089,贺州","10110001,贵阳","10110002,六盘水","10110004,凯里","10110005,都匀","10110006,安顺","10110007,遵义","10110021,毕节","10110026,兴义","10110055,铜仁","10110082,黔西南","10110083,黔东南","10110084,黔南","10111001,海口","10111002,三亚","10111006,文昌","10111007,琼海","10111020,儋州","10111021,五指山","10112001,石家庄","10112002,衡水","10112003,邢台","10112004,邯郸","10112005,沧州","10112006,唐山","10112007,廊坊","10112008,秦皇岛","10112009,承德","10112010,保定","10112011,张家口","10113001,郑州","10113002,新乡","10113003,安阳","10113004,许昌","10113005,驻马店","10113006,漯河","10113007,信阳","10113008,周口","10113009,洛阳","10113099,济源","10113010,平顶山","10113011,三门峡","10113012,南阳","10113013,开封","10113014,商丘","10113015,鹤壁","10113016,濮阳","10113017,焦作","10114001,哈尔滨","10114002,绥化","10114053,黑河","10114003,佳木斯","10114004,牡丹江","10114005,齐齐哈尔","10114007,大庆","10114067,七台河","10114008,大兴安岭","10114009,鸡西","10114042,伊春","10114020,鹤岗","10114024,双鸭山","10115001,武汉","10115002,黄石","10115004,鄂州","10115005,襄樊","10115006,咸宁","10115007,十堰","10115008,宜昌","10115009,恩施","10115010,荆州","10115011,黄冈","10115012,荆门","10115013,孝感","10115016,神农架林区","10115034,天门","10115062,随州","10115066,仙桃","10116001,长沙","10116002,株洲","10116003,益阳","10116004,岳阳","10116005,常德","10116007,娄底","10116008,怀化","10116009,衡阳","10116010,邵阳","10116011,郴州","10116013,张家界","10116014,湘潭","10116075,永州","10116097,湘西","10117001,长春","10117002,吉林","10117003,延吉","10117004,通化","10117006,四平","10117007,白城","10117008,松原","10117028,辽源","10117049,延边","10118001,南京","10118002,苏州","10118003,无锡","10118004,徐州","10118005,常州","10118006,镇江","10118051,泰州","10118007,连云港","10118008,淮安","10118009,盐城","10118010,扬州","10118011,南通","10118017,常熟","10118063,宿迁","10119001,南昌","10119002,九江","10119003,景德镇","10119004,上饶","10119005,鹰潭","10119006,宜春","10119007,萍乡","10119008,赣州","10119009,吉安","10119010,抚州","10119040,新余","10119042,井岗山","10120001,沈阳","10120002,铁岭","10120003,抚顺","10120004,鞍山","10120005,营口","10120006,大连","10120007,本溪","10120008,丹东","10120009,锦州","10120010,朝阳","10120011,阜新","10120012,盘锦","10120013,辽阳","10120014,葫芦岛","10121001,呼和浩特","10121002,集宁","10121003,包头","10121004,临河","10121005,乌海","10121007,海拉尔","10121008,赤峰","10121009,锡林浩特","10121011,通辽","10121024,乌兰浩特","10121089,锡林郭勒盟","10121090,阿拉善盟","10121091,兴安","10121092,鄂尔多斯","10121093,呼伦贝尔","10121094,巴彦淖尔","10121095,乌兰察布","10122001,银川","10122002,石嘴山","10122003,固原","10122010,吴忠","10122011,中卫","10123001,西宁","10123002,果洛","10123003,玉树","10123004,格尔木","10123005,海西","10123045,海东","10123046,海北","10123047,黄南","10123048,海南藏族自治州","10124001,青岛","10124002,威海","10124003,济南","10124004,淄博","10124005,聊城","10124006,德州","10124007,东营","10124008,潍坊","10124009,烟台","10124011,泰安","10124012,菏泽","10124013,临沂","10124014,枣庄","10124015,济宁","10124016,日照","10124068,莱芜","10124018,滨州","10125001,太原","10125003,忻州","10125005,大同","10125006,临汾","10125008,运城","10125009,阳泉","10125010,长治","10125011,晋城","10125107,晋中","10125108,吕梁","10126001,西安","10126002,渭南","10126003,延安","10126005,榆林","10126006,宝鸡","10126007,安康","10126008,汉中","10126010,铜川","10126011,咸阳","10127001,成都","10127125,巴中","10127002,乐山","10127003,凉山","10127005,绵阳","10127007,阿坝","10127008,雅安","10127009,甘孜","10127010,广元","10127117,遂宁","10127011,南充","10127013,内江","10127014,自贡","10127015,宜宾","10127016,泸州","10127017,攀枝花","10127018,德阳","10127056,眉山","10127070,广安","10127137,达州","10128001,拉萨","10128002,那曲","10128003,昌都","10128004,山南","10128005,日喀则","10128006,阿里","10128007,林芝","10129001,乌鲁木齐","10129002,石河子","10129003,乌苏","10129004,克拉玛依","10129006,阿勒泰","10129007,巴音郭楞","10129008,哈密","10129009,吐鲁番","10129010,阿克苏","10129011,喀什","10129012,和田","10129013,图木舒克","10129014,五家渠","10129081,奎屯","10129086,塔城","10129088,克孜勒苏","10129089,博尔塔拉","10129017,昌吉","10129090,伊犁","10130001,昆明","10130002,曲靖","10130003,昭通","10130005,文山","10130007,大理","10130008,楚雄","10130098,红河","10130009,临沧","10130010,保山","10130011,玉溪","10130030,丽江","10130052,普洱","10130127,西双版纳","10130128,德宏","10130129,怒江","10130130,迪庆","10131001,杭州","10131002,温州","10131003,宁波","10131004,绍兴","10131005,湖州","10131006,嘉兴","10131009,金华","10131010,丽水","10131011,衢州","10131012,台州","10131013,义乌","10131014,温岭","10131015,舟山");

//县,区
var zone = new Array("1010200101,东城区","1010200102,西城区","1010200103,崇文区","1010200104,宣武区","1010200105,朝阳区","1010200106,丰台区","1010200107,石景山区","1010200108,海淀区","1010200109,门头沟区","1010200110,房山区","1010200111,通州区","1010200112,顺义区","1010200113,昌平区","1010200114,大兴区","1010200115,怀柔区","1010200116,平谷区","1010200117,密云区","1010200118,延庆区","1010200119,其他区",
                   "1010100801,惠城区","1010100802,惠阳区","1010100803,惠东县","1010100804,博罗县","1010100805,龙门县","1010100806,其他区",
				    "1010600101,瑶海区","1010600102,庐阳区","1010600103,蜀山区","1010600104,包河区","1010600105,新站区","1010600106,经开区","1010600107,政务区","1010600108,滨湖区","1010600109,长丰县","1010600110,肥东县","1010600111,肥西县","1010600112,高新区","1010600113,巢湖市","1010600114,居巢区","1010600115,庐江县");
              
function selectProvince(){
	var obj_pro=document.getElementById("province");
	var strVal="";
	for(var i=0;i<provice.length;i++){
		strVal=provice[i].split(",");
		obj_pro.options.add(new Option(strVal[1],strVal[0]));
			if(arguments.length==1){
				if(arguments[0]==strVal[0]){obj_pro.options[obj_pro.length-1].selected=true;}
			}
	}
}

function selectCity(){
	var obj_city=document.getElementById("city");
	var temp_val=arguments[0].toString().substr(0,6);
	
	var strVal="";
	
	obj_city.length=1;//clear options
	for(var i=0;i<city.length;i++){
		strVal=city[i].split(",");
		if(strVal[0].substr(0,6)==temp_val){
			obj_city.options.add(new Option(strVal[1],strVal[0]));
			if(arguments.length==2){
				if(arguments[1]==strVal[0]){obj_city.options[obj_city.length-1].selected=true;}
			}
		}
	}
}

function selectZone(){
    var obj_zone=document.getElementById("zone");
	var temp_val=arguments[0].toString();
	var strVal="";
	
	obj_zone.length=1;
	for(var i=0;i<zone.length;i++){
		strVal=zone[i].split(",");
		if(strVal[0].substr(0,8)==temp_val){
			obj_zone.options.add(new Option(strVal[1],strVal[0]));
			if(arguments.length==2){
				if(arguments[1]==strVal[0]){obj_zone.options[obj_zone.length-1].selected=true;}
			}
		}
	}

}

//分割JS数组
/*
Array.prototype.parseValuesFromArray= function (array) {
        if (array && array.length && array.length > 0) {
            for (var x = 0, xlen = array.length; x < xlen; x++) {
                var value = array[x].split(':');
                if (value.length > 1) {
                    if (value.length > 2) {
                        for (var j = 2, jlen = value.length; j < jlen; j++) {
                            value[1] = value[1] + ":" + value[j];
                        }
                    }
                    this[decodeURI(value[0])] = decodeURI(value[1]);
                }
            }
            return true;
        } else { return false; }
    }
*/

String.prototype.Trim=function(){
	return this.replace(/(^\s*)|(\s*$)/g,"");	
}


function checkStore(obj){

	if(obj.name.value.Trim()==""){alert("请输入店铺名称！");obj.name.focus();return false;}
	if(obj.province.value.Trim()==""){alert("请输选择省份！");obj.province.focus();return false;}
	if(obj.city.value.Trim()==""){alert("请选择城市！");obj.city.focus();return false;}
	if(obj.address.value.Trim()==""){alert("请输联系地址！");obj.address.focus();return false;}
	if(obj.zone.value.Trim()==""){alert("请输入电话区号！");	obj.zone.focus();return false;}
	if(obj.tel.value.Trim()==""){alert("请输入联系电话！");	obj.tel.focus();return false;}
	if(obj.mobile.value.Trim()==""){alert("请输入联系手机！");	obj.mobile.focus();return false;}
	if(obj.owner.value.Trim()==""){alert("请输店主姓名！");obj.owner.focus();return false;}
}

var editor;


function setEditor(){
	
}

function selectClass(){
	$(".class_list>li").live("click",function(){
		$("#loading_info").show();
		$("#class_id").val("")
		$(this).siblings().removeClass("current");
		$(this).addClass("current")
		var intId=$(this).attr("data-rel");
		var objParent=$(this).parent();
		objParent.nextAll(".class_list").remove();
		$.getJSON("?route=merchants/release/getClass&id="+ intId.toString(),function(json){
			$("#loading_info").hide();
			if(json.length>0){
				var list_con="<ul class=\"class_list\">";
				for(var i=0;i<json.length;i++){
					list_con+="<li data-rel=\""+ json[i].classId +"\">"+ json[i].className +"</li>";
				}
				list_con+="</ul>";
				objParent.after(list_con);
			}else{
				$("#class_id").val(intId);
			}
		});
	});
}




var productImage=Array();
function productEditor(){
	KindEditor.ready(function(K) {
		editor = K.create('#description',{items:['source','fontsize','fontname','|','forecolor','hilitecolor','bold','italic','underline','removeformat','|','justifyleft','justifycenter','justifyright','|','emoticons','image','multiimage','table','link','unlink','|','preview','fullscreen'],resizeType:1});
		K('#J_selectImage').click(function() {
			if(productImage.length>=20){
				alert("对不起，最多只能上传20张宝贝图片！");
				return false;
			}
			editor.loadPlugin('multiimage', function() {
				editor.plugin.multiImageDialog({
					imageSizeLimit:"512KB",
					imageUploadLimit:20,
					insertBtnName:"保存图片",
					clickFn : function(urlList) {
						//var div = K('#J_imageView');
						var div=K('#imageList');
						K.each(urlList, function(i, data) {
							productImage.push(data.url);
							div.append('<li><img width="80" height="80" src="' + data.url + '"></li>');
						});
						editor.hideDialog();
					}
				});
			});
		});
	});
}

function checkProduct(obj){
	if(obj.name.value.Trim()==""){alert("请输入宝贝名称！");obj.name.focus();return false;}
	if(obj.price.value.Trim()==""){alert("请输入宝贝价格！");obj.price.focus();return false;}
	if(isNaN(obj.price.value.Trim())){alert("宝贝价格只能输入数值！");obj.price.focus();return false;}
	if ($("#special_price").length>0){
	    if(isNaN(obj.special_price.value.Trim())){alert("优惠价格只能输入数值！");obj.special_price.focus();return false;}
	    if(!(/\d{4}-\d{1,2}-\d{1,2}/.test(obj.date_start.value.Trim()))) {alert("请输入有效的日期");obj.date_start.focus();return false;}
	    if(!(/\d{4}-\d{1,2}-\d{1,2}/.test(obj.date_end.value.Trim()))) {alert("请输入有效的日期");obj.date_end.focus();return false;}
    }
	if(obj.quantity.value.Trim()==""){alert("请输入宝贝数量！");obj.quantity.focus();return false;}
	if(isNaN(obj.quantity.value.Trim())){alert("宝贝数量只能输入数值！");obj.quantity.focus();return false;}
	if(obj.sku.value.Trim()==""){alert("请输入库存单位！");obj.sku.focus();return false;}
	if(obj.model.value.Trim()==""){alert("请输入宝贝编号！");obj.model.focus();return false;}
	editor.sync();
	if(obj.description.value.Trim()==""){alert("请输入宝贝描述！");editor.focus();return false;}
	if(obj.product_id==null){if(productImage.length==0){alert("至少需要上传1张宝贝图片！");return false;};}
	$("#product_image").val(productImage.join(","));
}

//选择全部信息
function SelectAll(strName,obj){
	var oitem=document.getElementsByName(strName);
	if(oitem.length==1){
		oitem.checked=obj.checked;
	}
	for(var i=0;i<oitem.length;i++){
		oitem[i].checked=obj.checked;
	}
}

//设置商品信息
function SetProduct(strUrl,strMsg,strMenu,intId){
	if(intId==null){
		alert("对不起，请先选择要"+ strMsg +"的"+ strMenu +"！");
		return false;
	}
	if(confirm("确定"+ strMsg +"所选"+ strMenu +"吗？")){
		$.post(strUrl,{"product_id":intId.toString()},function(html){
			if(html.toString()=="ok"){
				alert(strMenu.toString()+strMsg.toString()+"成功！");
				location.reload();
			}else{
				alert(html);
			}
		});
	}
}

//设置多个商品信息
function SetSelectProduct(strUrl,strMsg,strMenu,strName){
	var tmp=new Array();
	var obj=document.getElementsByName(strName);
	var intSelCount=0;
	for(var i=0;i<obj.length;i++){
		if(obj[i].checked){
			intSelCount+=1;
			tmp.push(obj[i].value.toString());
		}
	}
	if(intSelCount==0){
		alert("请先选择要"+ strMsg +"的"+ strMenu +"！");
		return false;
	}
	if(confirm("已选择"+ intSelCount +"个"+ strMenu +"，确定"+ strMsg +"所选"+ strMenu +"吗？")){
		$.post(strUrl,{"product_id":tmp.join(",")},function(html){
			if(html.toString()=="ok"){
				alert(strMsg.toString()+strMenu.toString()+"成功！");
				location.reload();
			}else{
				alert(html);
			}
		});
	}
}

//设置商品主图
function setProductImage(intId){
	if(confirm("确定设置当前图片为宝贝主图吗？")){
		$.post("?route=merchants/sell/setimg",{"img_id":intId,"pro_id":$("#product_id").val()},function(html){
			if(html.toString()=="ok"){
				$("#imageList li").removeClass("current");
				$("#img_item"+intId.toString()).addClass("current");
			}else{
				alert(html);
			}
		});
	}
}

//删除商品图片
function delProductImage(intId){
	if(confirm("确定删除所选宝贝主图吗？")){
		$.post("?route=merchants/sell/delimg",{"img_id":intId,"pro_id":$("#product_id").val()},function(html){
			if(html.toString()=="ok"){
				$("#img_item"+intId.toString()).remove();
			}else{
				alert(html);
			}
		});
	}
}

//设置订单状态
function setOrderStatus(action,strMsg,order_id){
	if(confirm(strMsg)){
		$.post("?route=merchants/order/"+action,{order_id:order_id},function(str){
			if(str=="ok"){
				location.reload();
			}else{
				alert('对不起,配货失败！');
			}
		});
	}
}

//验证优惠券状态
function CheckCoupon(obj){
	if(obj.coupon_name.value.Trim()==""){alert("请输入优惠券编号！");obj.coupon_name.focus();return false;}
	if(obj.coupon_code.value.Trim()==""){alert("请输入优惠券密码！");obj.coupon_code.focus();return false;}
	if(obj.coupon_code.value.Trim().length<6){alert("优惠券密码不能少于6位！");obj.coupon_code.focus();return false;}
	if(obj.coupon_discount.value.Trim()==""){alert("请输入优惠折扣！");obj.coupon_discount.focus();return false;}
	if(isNaN(obj.coupon_discount.value.Trim())){alert("优惠折扣只能输入数值！");obj.coupon_discount.focus();return false;}
	if(obj.coupon_total.value.Trim()==""){alert("请输入订单限额！");obj.coupon_total.focus();return false;}
	if(isNaN(obj.coupon_total.value.Trim())){alert("订单限额只能输入数值！");obj.coupon_total.focus();return false;}
	if(obj.coupon_discount.value.Trim()>obj.coupon_total.value.Trim()){alert("不对吧，折扣大于订单限额啦！");obj.coupon_total.focus();return false;}
	if(obj.date_start.value.Trim()==""){alert("请输入开始日期！");obj.date_start.focus();return false;}
	var startDate=/\d{4}-\d{1,2}-\d{1,2}/;
	if(!startDate.test(obj.date_start.value.Trim())){alert("开始日期格式不正确！");obj.date_start.focus();return false;}
	if(obj.date_end.value.Trim()==""){alert("请输入结束日期！");obj.date_end.focus();return false;}
	var endDate=/\d{4}-\d{1,2}-\d{1,2}/;
	if(!endDate.test(obj.date_end.value.Trim())){alert("结束日期格式不正确！");obj.date_end.focus();return false;}
}

//设置退换货状态
function setReturn(intId,intState){
	$.post("?route=merchants/return/setstate",{"id":intId.toString(),"state":intState.toString()},function(html){
		if(html.toString()=="ok"){
			alert("退换状态设置成功！");
			location.reload();
		}else{
			alert(html);
		}
	});
}

var modifyOrderTotal={
         total:$('.modifyOrderTotal').parent().prev().children('.total').html(),
		 mot:function(){
		    if($('input[name=total]').length<=0){
				modifyOrderTotal.total=$('.modifyOrderTotal').parent().prev().children('.total').html();
				$('.modifyOrderTotal').parent().prev().children('.total').html('<input type="text" name="total" class="input-small" value="'+modifyOrderTotal.total+'"/><br><a href="javascrip:void(0)" class="ok">确定</a><a href="javascript:void(0)" class="cancel">取消</a>');
			
			}
		 },
		 cancel:function(){
		    $('.modifyOrderTotal').parent().prev().children('.total').html(modifyOrderTotal.total);
		 },
		 ok:function(){
		    
		 }


};

//修改金额
var total;
$(".modifyOrderTotal").click(function(){
    if($(this).parent().prev().children('.total').children('input[name=total]').length<=0){
		total=$(this).parent().prev().children('.total').html();
		$(this).parent().prev().children('.total').html('<input type="text" name="total" class="input-mini" value="'+total+'"/><br><a  style="cursor:pointer" class="ok">确定</a><a href="javascript:void(0)" class="cancel">取消</a>');
	
	}
});

$('td').on('click','.cancel',function(){
	$(this).parent().html(total);
	
});

$('input[name=total]').live('keypress',function(e){
    var keyunicode=e.charCode || e.keyCode;
	if(keyunicode===13){
		$(this).siblings('.ok').click(); // trigger the dynamically created 'anchor' stuff
	}
});


$('td').on('click','.ok',function(){
    var order_id=$(this).parent().attr('data-id');
	var xt=$(this).siblings('input[name=total]').val();
	
	xt=parseFloat(xt).toFixed(2);
	
	
	if(isNaN(parseFloat(xt))) { 
	    alert("请输入正确的金额！");
		$(this).siblings('input[name=total]').val(total)
		return false;
	}
    var that=$(this).parent();
	$.ajax({
	    url:'?route=merchants/order_create/setOrderTotal',
		data:{order_id:order_id,total:xt},
		//data:'order_id='+order_id+'&total='+xt,
		type:'post',
        dataType: "json",
		error: function(jqXHR, exception) {
            if (jqXHR.status === 0) {
                alert('Not connect.\n Verify Network.');
            } else if (jqXHR.status == 404) {
                alert('Requested page not found. [404]');
            } else if (jqXHR.status == 500) {
                alert('Internal Server Error [500].');
            } else if (exception === 'parsererror') {
                alert('Requested JSON parse failed.');
            } else if (exception === 'timeout') {
                alert('Time out error.');
            } else if (exception === 'abort') {
                alert('Ajax request aborted.');
            } else {
                alert('Uncaught Error.\n' + jqXHR.responseText);
            }
        },
		success: function(data, textStatus, jqXHR) {
		   //console.log(textStatus);
		     if(data.odt==1){
			     alert('修改成功！');
				 that.html(xt);
			 }else{
			     alert('修改失败!');
			}
		}
	});

});

total=null;	


function textCounter(field,leavingsfieldId,maxlimit) {
	var l=field.value.length;
	if (l > maxlimit) // if too long...trim it!
	{   
		$('input[name=title]').val(field.value.substring(0,maxlimit));
		return false;
	} else { 
	    var x= Math.floor((maxlimit - l)/2);
		x=x>0?x:0;
		$('#'+leavingsfieldId).html(x);
	}
}


function getURLVar(urlVarName) {
	var urlHalves = String(document.location).toLowerCase().split('?');
	var urlVarValue = '';
	
	if (urlHalves[1]) {
		var urlVars = urlHalves[1].split('&');

		for (var i = 0; i <= (urlVars.length); i++) {
			if (urlVars[i]) {
				var urlVarPair = urlVars[i].split('=');
				
				if (urlVarPair[0] && urlVarPair[0] == urlVarName.toLowerCase()) {
					urlVarValue = urlVarPair[1];
				}
			}
		}
	}
	
	return urlVarValue;
} 