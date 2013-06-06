/* function getCookie(b) {
    var a = document.cookie.match(new RegExp("(^| )" + b + "=([^;]*)(;|$)"));
    if (a != null) {
        return unescape(a[2]);
    }
    return null;
}
function getlogCookie(name) {
	var start = document.cookie.indexOf( name + "=" );
	var len = start + name.length + 1;
	if ( ( !start ) && ( name != document.cookie.substring( 0, name.length ) ) ) {
		return null;
	}
	if ( start == -1 ) return null;
	var end = document.cookie.indexOf( ';', len );
	if ( end == -1 ) end = document.cookie.length;
	return decodeURIComponent( document.cookie.substring( len, end ) );
}
function setCookie( name, value, expires, path, domain, secure ){
	var today = new Date();
	today.setTime( today.getTime() );
	if ( expires ) {
		expires = expires * 1000 * 60 * 60 * 24;
	}
	var expires_date = new Date( today.getTime() + (expires) );
	document.cookie = name+'='+escape( value ) +
	( ( expires ) ? ';expires='+expires_date.toGMTString() : '' ) + //expires.toGMTString()
	( ( path ) ? ';path=' + path : ';path=/' ) +
	( ( domain ) ? ';domain=' + domain : '' ) +
	( ( secure ) ? ';secure' : '' );
} */

/* 
function getLogin(){
	var login="__TRANSIENT";
	var LongTimeValuesCookies=getlogCookie("LongTimeValuesCookies");
	if(LongTimeValuesCookies!=null && LongTimeValuesCookies!=""){
		var arrStr = LongTimeValuesCookies.split("#");
		for(var i=0;i<arrStr.length;i++){
			var co = arrStr[i].split("$");
			if(co[0]=="__LOGIN__VIEWINFO__"){
				if("invalid"!=co[1]){
					login=co[1];
					break;
				}
			}
			if(co[0]=="__LOGIN")
			{
				login=co[1];
				break;
			}
		}
	}
	return login; 
}
function getuserId(){
	var userId="__TRANSIENT";
	var LongTimeValuesCookies=getlogCookie("LongTimeValuesCookies");
	if(LongTimeValuesCookies!=null && LongTimeValuesCookies!=""){
		var arrStr = LongTimeValuesCookies.split("#");
		for(var i=0;i<arrStr.length;i++){
			var co = arrStr[i].split("$");
			if(co[0]=="__user_id_login_2009"){
				if("invalid"!=co[1]){
					userId=co[1];
					break;
				}
			}
		}
	}
	return userId; 
}
function loadUser(obj){
	var islogin=getLogin();
	var str = "";
	if(islogin != null && islogin != "__TRANSIENT" && islogin != ""){
		str = "小蜜蜂欢迎您，<b>" + islogin + "</b>！<a href=\"javascript:logout();\" >退出登录</a>";
	}else{
		str = "欢迎来乐蜂，请&nbsp;<a href=\"javascript:loginreg('login');\">登录</a>&nbsp;<a href=\"javascript:loginreg('reg');\">注册</a>";
	}
	$("#"+obj).html(str);
} */



/* function bbslogout(){
    var IframeObj = document.createElement("iframe");
    IframeObj.style.display = "none";
    document.body.appendChild(IframeObj);
    IframeObj.contentWindow.location.href ='http://space.lefeng.com/sso.do?act=shoplogout';
}
function logout(){
	var today = new Date();
	today.setTime( today.getTime() );
	var expires = 1000 * 60;
    var expires_date = new Date( today.getTime() - (expires) );
    document.cookie = 'LongTimeValuesCookies=;expires='+expires_date.toGMTString()+';path=/'+
		';domain=lefeng.com;secure';	
	$("#Cheadlogin").html("欢迎来到乐蜂，请&nbsp;<a href=\"javascript:loginreg('login');\">登录</a>&nbsp;<a href=\"javascript:loginreg('reg');\">注册</a>");
    bbslogout();
	$('.Chead-tip').remove();
    setTimeout("jump('http://www.lefeng.com/index.html')", 10000);
}
function loginreg(str){
	var returnback=encodeURIComponent(window.location.href);
	if("login"==str){
		var nowhref=window.location.href;
		if(nowhref.indexOf("login.jsp")!=-1){
			window.location.href='https://passport.lefeng.com/login.jsp';
		}else{
			window.location.href='https://passport.lefeng.com/login.jsp?returnback='+returnback;
		}
	}
	if("reg"==str){
		window.location.href='https://passport.lefeng.com/register.jsp?returnback='+returnback
	}
} 


//shopping show
var cartCount = 0;
var cartItems = new Array();//cartItems['id'] = num||amount||name||pid||id(if null then 0)||imgurl
function fillCart(){
	cartCount = getlogCookie("__cart_count__");
    cartCount = cartCount == null ? 0 : cartCount;
	$("#cartbuy").html(cartCount);
}
*/




//表示当前高亮的节点
var highlightindex = -1;
var timeOutId;
var Chinavalue = '';

jQuery(document).ready(function() {
	//Changeword();
	
    var wordInput = jQuery("#search");
    var wordInputOffset = wordInput.offset();
    //自动补全框最开始应该隐藏起来
    if(wordInputOffset!=null && wordInputOffset!="undefind"){
    	jQuery("#auto").hide().css("border","1px #666 solid").css("position","absolute")
        .width(287).css("background","#fff").css("padding","5px 0px").css("z-index","9999");
    }
    jQuery(document).click(function(event){ 
        jQuery("#auto").hide();
    });//单击空白区域隐藏
    //给文本框添加键盘按下并弹起的事件
    wordInput.keyup(function(event){
        //处理文本框中的键盘事件
        var myEvent = event || window.event;
        var keyCode = myEvent.keyCode;
        //alert("keyCode "+keyCode);
        //如果输入的是字母，应该将文本框中最新的信息发送给服务器
        //如果输入的是退格键或删除键，也应该将文本框中的最新信息发送给服务器
        //var china = /^[\u4e00-\u9fa5]+jQuery/i;
        //var isChina = false; 
        //if (china.test(keyCode))isChina=true;
        //isChina || keyCode >= 65 && keyCode <= 90 || 
        // alert(keyCode);
        if (keyCode >= 65 && keyCode <= 90 || keyCode == 8 || keyCode == 16 || keyCode == 46|| keyCode== 32 || keyCode >=48 && keyCode <= 57) {
            //1.首先获取文本框中的内容
            var autoNode = jQuery("#auto");
            var wordText = jQuery("#search").val();
            if(wordText != ""){
                if(keyCode == 8&&wordText==""){
                    return;
                }
                //如果是汉字的话进行编码后再发啦
                wordText = encodeURIComponent(wordText);
                //2.将文本框中的内容发送给服务器段
                clearTimeout(timeOutId);
                //延时处理
                timeOutId = setTimeout(function(){
                    // alert("wordText :"+wordText);
                    var url = "http://sproxy.lefeng.com/proxy/keyword?callback=?";
                    jQuery.getJSON(url,{q:wordText,r:10},function(data){
                    	if(data!=null && data.length>0){
                    		//alert(data);
		                    //将dom对象data转换成JQuery的对象
		                    //var jqueryObj = jQuery(data);
		                    //找到所有的word节点
		                    // var wordNodes = jqueryObj.find("word");
		                    //遍历所有的word节点，取出单词内容，然后将单词内容添加到弹出框中
		                    //需要清空原来的内容
		                    autoNode.html("");
		                    var i=0;
                			jQuery.each(data,function(idx,item){
		                        //获取单词内容
		                        //var wordNode = jQuery(this);
		                        //新建div节点，将单词内容加入到新建的节点中
		                        //将新建的节点加入到弹出框的节点中
		                        //jQuery("<div>").html(wordNode.text()).appendTo(autoNode);
		                        //style='width:100%;float:left;overflow:hidden;'
		                        //style='width:100%;float:left;overflow:hidden;'
		                        var newDivNode = jQuery("<div style='width:275px;padding: 0 6px;float:left;overflow:hidden;line-height:28px;color:#000;cursor:pointer;'>").attr("id",i);
		                        //style='text-align:right;color:#008000;'style='float:left;'
		                        //style='list-style:none;'
		                        //style='flautooat:right;text-align:right;color:#f00;'
		                        var namev = item.name;
								var numv = item.num;
		                        //var textword = wordNode.text();
		                        //var textArray=textword.split("#");
		                        newDivNode.html("<ul style='list-style:none;'><li style='float:left;'>"+namev+" </li><li style='float:right;text-align:right;color:#999'>约<span style='color:#f00;'>"+numv+"</span>件商品</li></ul>").appendTo(autoNode);
		                        //鼠标滑入则高亮显示节点
		                        newDivNode.mouseover(function (){
		                            if(highlightindex!=-1){
		                           		jQuery("#auto").children("div").eq(highlightindex).css("background-color","white"); 
		                            }
		                            highlightindex = jQuery(this).attr("id");
		                            jQuery(this).css("background-color","#ffe899");
		                        });
		                        //鼠标划出则取消高亮节点
		                        newDivNode.mouseout(function (){
		                            jQuery(this).css("background-color","white");
		                        });
			                    //增加click事件，进行补全处理
			                    newDivNode.click(function(){
				                    //取出高亮节点的内容
				                    var Text = reverse(jQuery(this).text());
				                    jQuery("#auto").hide();
				                    highlightindex = -1;
				                    //赋值到输入框中
				                    //var tx = Text.split(" ");
				                    //alert(tx);
				                    jQuery("#search").val(Text);
									jQuery("#search-submit").trigger('click'); //执行搜索
			                   	});
               					i++;
                			});//遍历结束
		                    //如果服务器段有数据返回，则显示弹出框
		                    if (data.length > 0) {
		                        autoNode.show();
		                        //alert(autoNode.html());
		                    } else {
		                        autoNode.hide();
		                        //弹出框隐藏的同时，高亮节点索引值也制成-1
		                        highlightindex = -1;
		                    }
                		}// if(data!=null && data.length>0)	
                   	});
				},60);
            }else{
                autoNode.hide();
                highlightindex = -1;
        	}
        } else if (keyCode == 38 || keyCode == 40) {
            //如果输入的是向上38向下40按键
            if (keyCode == 38) {
                //向上
                var autoNodes = jQuery("#auto").children("div")
                if (highlightindex != -1) {
                    //如果原来存在高亮节点，则将背景色改称白色
                    autoNodes.eq(highlightindex).css("background-color","white");
                    highlightindex--;
                } else {
                    highlightindex = autoNodes.length - 1;    
                }
                if (highlightindex == -1) {
                    //如果修改索引值以后index变成-1，则将索引值指向最后一个元素
                    highlightindex = autoNodes.length - 1;
                }
                //让现在高亮的内容变成红色
                autoNodes.eq(highlightindex).css("background-color","#ffe899");
            }
            if (keyCode == 40) {
                //向下
                var autoNodes = jQuery("#auto").children("div")
                if (highlightindex != -1) {
                    //如果原来存在高亮节点，则将背景色改称白色
                    autoNodes.eq(highlightindex).css("background-color","white");
                }
                highlightindex++;
                if (highlightindex == autoNodes.length) {
                    //如果修改索引值以后index变成-1，则将索引值指向最后一个元素
                    highlightindex = 0;
                }
                //让现在高亮的内容变成红色
                autoNodes.eq(highlightindex).css("background-color","#ffe899");
            }
            var comText = reverse(jQuery("#auto").children("div").eq(highlightindex).text());
            //var txKey = comText.split(" ");
            jQuery("#search").val(comText);
        } else if (keyCode == 13) {
            //如果输入的是回车
            //下拉框有高亮内容
            if (highlightindex != -1) {
                //取出高亮节点的文本内容
                var comText = reverse(jQuery("#auto").hide().children("div").eq(highlightindex).text());
                highlightindex = -1;
                //文本框中的内容变成高亮节点的内容
                //var txKey = comText.split(" ");
                jQuery("#search").val(comText);
            } else {
                //下拉框没有高亮内容
                //alert("文本框中的[" + jQuery("#word").val() + "]被提交了");
                jQuery("#auto").hide();
				//jQuery("#search").get(0).blur();
            }
        }else if(keyCode == 9){
        	//tab键取消显示的提示框
        	//alert("tab");
        	jQuery("#auto").hide();
        }else if(keyCode == 27){
        	//esc键.隐藏提示框，且将输入框置为空
        	jQuery("#search").val();
        	jQuery("#auto").hide();
        }else if(keyCode == 37){
        }else if(keyCode == 39){
        }else{
        	jQuery("#auto").hide();
        }  
    });
})


/* 
var initShopping = function(){

	if ($('#Chead-shopping dl').length > 6){
		$('#Chead-shopping').find('dl').hide();
		$('#Chead-shopping dl:lt(6)').show();
		$('#Chead-shopping div.shopping-page b').show().eq(0).css({'opacity':'0.6'});
		ShoppingPageClick();
	}else{
		$('#Chead-shopping').find('dl').show();
		$('#Chead-shopping div.shopping-page b').hide();
	}

}

function ShoppingPageClick(){
	$('#Chead-shopping div.shopping-page b').each(function(i){
		if(i == 0){
			$(this).css('background-position','-30px -90px');
			$(this).click(function(){
				if($(this).css('opacity') != '1'){return false;}
				$('#Chead-shopping dl:visible:first').prev().show();
				$('#Chead-shopping dl:visible:last').hide();
				shoppingPage();
			});
		}else{
			$(this).click(function(){
				if($(this).css('opacity') != '1'){return false;}
				$('#Chead-shopping dl:visible:first').hide();
				$('#Chead-shopping dl:visible:last').next().show();
				shoppingPage();
			});
		}
	});
} */





//loadUser('Cheadlogin');  //登录

$(window).load(function(){


//fillCart();
//延续以前的JS end



/* function loadOrderCoupon(){
	var islogin=getLogin();
	if(islogin != null && islogin != "__TRANSIENT" && islogin != ""){
		var uid = getuserId();
		var url = "http://notice.lefeng.com/fetch.do?callback=?";
		var ordercoupon = getCookie("ordercoupon");
		if(ordercoupon != null && ordercoupon == uid){
			return false;
		}
		$.getJSON(url,{cmd:"get",key:uid},function(data){
			var result = data.result;
			if(result != "0" && result != "0|0"){
				var order = result.split("|")[0];
				var coupon = result.split("|")[1];
				var content = "<b id=\"Chead-tip-close\" class=\"Chead-tip-close\"></b><b class=\"Chead-tip-arrow\"></b>";
				content += "<p>您有";
				if(order != "0"){
					content += "<a href=\"http://order.lefeng.com/user_orders.jsp?statusType=1000\">" + order + "个订单</a>未支付";
				}
				if(coupon != "0"){
					if(order != "0"){
						content += ",";
					}
					content += "<a href=\"http://order.lefeng.com/myvouchers.jsp?voucherStatus=1\">" + coupon + "张代金券</a>未使用";
				}
				content += "</p>";
				$(".Chead-main > div").last().after("<div class=\"Chead-tip\">"+content+"</div>");
				// coupon notice
				$('#Chead-tip-close').click(function(){
						$(this).parent().hide();
						setCookie("ordercoupon",uid, false,"/","lefeng.com",false);
						//document.cookie="ordercoupon=" + uid + ";domain=lefeng.com";
					}
				);
			}
		});
	}
}

loadOrderCoupon(); */




//super star animate
/* var SuperStar = function(o){
	this.dom = $('#superstar img');
	this.rightNumber = 50;
	this.animateTime = 200;
	this.bigHeight = 90;
	$.extend(this,o);
	this.smailHeight = this.dom.css('height');
	this.hoverNumber = 0
	this.imgDom = [];
	this.init();
}
SuperStar.prototype = {
	constructor:SuperStar,
	init:function(){
		var _self = this;
		_self.dom.each(function(i){
			_self.imgDom.push($(this));
			//$(this).css({'right':i * 10 - 30 + 'px'}); // 7人时位置算法
			if(i==5){ $(this).css({'right':'10px'}); }
			else{
			$(this).css({'right':'5px'}); //4人位置
			};
			_self.imgDom[i].sLeft = $(this)[0].offsetLeft;
			$(this).hover(function(){
				_self.animateBig(_self.imgDom[i]);
				_self.hoverNumber++;
			},function(){
				_self.animateSmail(_self.imgDom[i]);
			});
		});
		_self.imgDom[0].trigger('mouseenter');
	},
	reset:function(t){
		if(t != this.imgDom[0] && this.hoverNumber == 1){
			this.imgDom[0].trigger('mouseleave');
			$('#superstar b').hide();
		}
	},
	animateBig:function(t){
		if (t.check) {return false;}
		t.check = true;
		t.stop();
		this.reset(t);
		t.animate({
			'height':this.bigHeight
		},this.animateTime);
		this.nameShow(t.parent().index(),t);
	},
	animateSmail:function(t){
		var _self = this;
		t.animate({
			'height':this.smailHeight
		},this.animateTime,function(){
			t.check = false;
		});
		$('#superstar b').hide();
	},
	nameShow:function(i,t){
		var position = {};
		if(this.dom.length - i > i){
			position.left = t.sLeft + 150;
			//position.target = position.left - 80 - i * 6;   //7人时距离算法
			position.target = position.left - 100;
		}else{
			position.left = t.sLeft - 200;
			//position.target = position.left + 100 + (this.dom.length - i) * 10; //7人时距离算法
			position.target = position.left + 100;
		}
		if(i==5){
			$('#superstar b').eq(i).css('left',position.left+50).show().animate({
			'left':position.target+50
		},this.animateTime);}
		else
		{
		$('#superstar b').eq(i).css('left',position.left).show().animate({
			'left':position.target
		},this.animateTime);
		}
	}

} */










});
		
//priority

//浮层距离计算
var floatListPosition = function(t){
	var _default = [0,-22,-130,-190,-96,-50]
		,_top = t.offset().top + _default[t.index() - 1]
		,_height = t.find('dd').outerHeight(true)
		,_sTop = $(window).scrollTop()
		,_wHeight = $(window).height()
		,boxtop;
	if(_top > _sTop && _top + _height < _sTop + _wHeight){boxtop = _default[t.index() - 1];}
	else if(_top < _sTop){boxtop = Math.min(_default[t.index() - 1] + (_sTop - _top) + 10,0);}
	else if(_top + _height > _sTop + _wHeight){boxtop = Math.max((t.index() - 1) * -91 + 40,Math.max(_default[t.index() - 1] - (_top + _height - _sTop - _wHeight) - 10,-(_height - 91)));}
	return boxtop;
}

//导航经过
var _floatListHover
$('#float-list dl').hover(
	function(){
		var _self = this;
		clearTimeout(_floatListHover);
		_floatListHover = setTimeout(function(){
			$(_self).css('background-color','#f6f6f6').find('dd').css('top',floatListPosition($(_self))).show();
			$(_self).find('dt strong').css('background-position','144px -123px');
			$(_self).find('img').attr('load') && $(_self).find('img').attr('src',$(_self).find('img').attr('load')).removeAttr('load');
			var _h = $(_self).find('dd').outerHeight(true);
			_h > $(_self).find('.float-list-info').outerHeight(true) && $(_self).find('.float-list-info').css({'height':_h - 30});
		},300);
	},
	function(){
		clearTimeout(_floatListHover);
		$(this).css('background-color','#fff').find('dd').hide();
		$(this).find('dt strong').removeAttr('style');
	}
);

/////////////
/* if(getuserId() == '7ab68f2908345e2018004458108854bb'){
    logout();
} */



//轮播器
	
var Slide = function(o){
	this.dom = {img:'#slider .sliderbox',btn:'#slider b',cls:'on',e:'mouseenter',t:7000};
	this.timeout;
	this.index = 0;
	$.extend(this.dom,o);
	this.init();
	this.automatic();
}

Slide.prototype = {
	constructor:Slide,
	init:function(){
		var _self = this,_nowshow = $(_self.dom.img+':first');
		_nowshow.s = true;
		_nowshow.css('z-index',11);
		//$('#slideBg').css('background-color',_nowshow.attr('c'));
		$(_self.dom.btn).bind(_self.dom.e,function(){
			if($(this).hasClass(_self.dom.cls)){return false;}
			$(this).siblings().removeClass(_self.dom.cls);
			var i = $(this).addClass(_self.dom.cls).index();
			_self.index = i;
			var _showImg = $(_self.dom.img).eq(_self.index);
			_self.imgShow(_showImg);
			_nowshow.css('z-index',11);
			_showImg.css('z-index',10).show();
			_nowshow.fadeOut(300,function(){
				$(this).css('z-index',1);
			});
			//$('#slideBg').css('background-color',_showImg.attr('c'));
			_nowshow = _showImg;
		});
		$(_self.dom.img).parent().hover(function(){clearTimeout(_self.timeout)},function(){_self.automatic()});

		/*setTimeout(function(){
			$(_self.dom.img).each(function(){
				_self.imgShow($(this));
			});
		},12000);*/
	},
	imgShow:function(showImg){
			showImg.find('img').attr('load') && showImg.find('img').attr('src',showImg.find('img').attr('load')).removeAttr('load');
		showImg.find('img').removeAttr('style');
	},
	automatic:function(){
		var _self = this;
		if(_self.index >= $(_self.dom.btn).length - 1){_self.index = -1;}
		clearTimeout(_self.timeout);
		_self.timeout = setTimeout(function(){
			$(_self.dom.btn).eq(_self.index + 1).trigger(_self.dom.e);
			_self.automatic();
		},_self.dom.t);
	}
}

new Slide();

//公告
var _announcementTabSwitch;
var announcementTab = function(i){
	var _firstDD = $('#announcement dd:first');
	if(!_announcementTabSwitch){
		if (!i){
			$('#announcement').hover(function(){_announcementTabSwitch = !_announcementTabSwitch});
			_firstDD.addClass('on');
			i = 1;
		}else{
			$('#announcement dd.on').animate({
				'height':'0px',
				'top':'21px'
			},100,function(){
				if(i == $('#announcement dd').length){i = 0};
				$('#announcement dd').removeClass('on').eq(i++).addClass('on').animate({
				'height':'12px',
				'top':'10px'
				},100);
			});
		}
	}
	setTimeout(function(){announcementTab(i)},5000);
}
announcementTab();

//搜索
var obj={
		searchType:'',
		query:'',
		z:'',
		url:''
	};

obj.searchType='item';
$("ul.ks-switchable-nav li a").click(function(){
	if($(this).parent().attr('data-searchtype')=='item'){
		obj.searchType='item';
	}else if ($(this).parent().attr('data-searchtype')=='shop'){
		obj.searchType='shop';
	}
});
	
$('#search_box input[name=\'search\']').keydown(function(e) {
	if (e.keyCode == 13) {
		$('.search_btn').trigger('click');
	}
});
$('#search_btn').bind('click', function() {
	if (obj.searchType=='item'){
		obj.url = '?route=search/search';
	}else if(obj.searchType=='shop'){
		obj.url = '?route=store/list';
	}
	
	var filter_name = $('#search_box input[name=\'search\']').attr('value');
	if (filter_name) {
		obj.url += '&filter_name=' + encodeURIComponent(filter_name);
	}
	
	window.location.href = obj.url;
});



$('ul.ks-switchable-nav li').click(function(){
	$(this).parent().children('li').removeClass('selected');
	$(this).addClass('selected');
});


$(".Fright dd").hover(function(){
	$(this).css({'border':'1px solid #f4bd00'});
},function(){
	$(this).css({'border':'1px solid #fff'});
});




//gotoTop();//返回顶部