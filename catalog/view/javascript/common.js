$(document).ready(function() {
	/* Search */
	$('.button-search').bind('click', function() {
		url = $('base').attr('href') + 'index.php?route=product/search';
				 
		var filter_name = $('input[name=\'filter_name\']').attr('value');
		
		if (filter_name) {
			url += '&filter_name=' + encodeURIComponent(filter_name);
		}
		
		location = url;
	});
	
	$('#header input[name=\'filter_name\']').bind('keydown', function(e) {
		if (e.keyCode == 13) {
			url = $('base').attr('href') + 'index.php?route=product/search';
			 
			var filter_name = $('input[name=\'filter_name\']').attr('value');
			
			if (filter_name) {
				url += '&filter_name=' + encodeURIComponent(filter_name);
			}
			
			location = url;
		}
	});
	
	/* Ajax Cart */
	$('#cart').mouseenter(function() {
		//$('#cart').addClass('active');
		$('.car-content').css('display','block');
		
		//$('#cart').load('index.php?route=module/cart .car_content > *');

		$.ajax({
		        url:'index.php?route=module/cart ',
		        dataType:'html',
				success:function(data){
				   //alert(data);
				   $(".car-content").html(data);
				}
			  });
				
	}).mouseleave(function(){	
		$('.car-content').css('display','none');
	    //$(this).removeClass('active');
		
	});
	
	/* Mega Menu */
	$('#menu ul > li > a + div').each(function(index, element) {
		// IE6 & IE7 Fixes
		if ($.browser.msie && ($.browser.version == 7 || $.browser.version == 6)) {
			var category = $(element).find('a');
			var columns = $(element).find('ul').length;
			
			$(element).css('width', (columns * 143) + 'px');
			$(element).find('ul').css('float', 'left');
		}		
		
		var menu = $('#menu').offset();
		var dropdown = $(this).parent().offset();
		
		i = (dropdown.left + $(this).outerWidth()) - (menu.left + $('#menu').outerWidth());
		
		if (i > 0) {
			$(this).css('margin-left', '-' + (i + 5) + 'px');
		}
	});

	// IE6 & IE7 Fixes
	if ($.browser.msie) {
		if ($.browser.version <= 6) {
			$('#column-left + #column-right + #content, #column-left + #content').css('margin-left', '195px');
			
			$('#column-right + #content').css('margin-right', '195px');
		
			$('.box-category ul li a.active + ul').css('display', 'block');	
		}
		
		if ($.browser.version <= 7) {
			$('#menu > ul > li').bind('mouseover', function() {
				$(this).addClass('active');
			});
				
			$('#menu > ul > li').bind('mouseout', function() {
				$(this).removeClass('active');
			});	
		}
	}
	
	$('.success img, .warning img, .attention img, .information img').live('click', function() {
		$(this).parent().fadeOut('slow', function() {
			$(this).remove();
		});
	});	
});

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

/*加入购物车*/
function addToCart(product_id, quantity) {
	quantity = typeof(quantity) != 'undefined' ? quantity : 1;
	$.ajax({
		url: 'index.php?route=checkout/cart/add',
		type: 'post',
		data: $('.product_info input[type=\'text\'], .product_info input[type=\'hidden\'], .product_info input[type=\'radio\']:checked, .product_info input[type=\'checkbox\']:checked, .product_info select, .product_info textarea'),
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, .information, .error').remove();
			//console.log(json['attribute']);
			
			if (json['error']) {
				if(json['error']['product']){
					alert('自己不能购买自己的产品！');
					return false;
				}
			}
			
			if (json['error']) {
				if (json['error']['option']) {
					for (j in json['error']['option']) {
						$('#option-' + j).append('<span class="error">' + json['error']['option'][j] + '</span>');
					}
					
				}
				
				if(json['error']['attribute']){
				    for (j in json['error']['attribute']) {
						//$('#attribute-' + j).append('<span class="error">' + json['error']['attribute'][j] + '</span>');
						$('.attributes').append('<span class="error">' + json['error']['attribute'][j] + '</span>');
					}
				}
				
				
				return false;
			} 
			
			if (json['redirect']) {
				location = json['redirect'];
			}
			
			if (json['success']) {
			  
				$('.notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
				
				$('.success').fadeIn('slow');
				
				//顶部导航
				var str=$.trim($('#cart-total a').html()).replace(/\d+/,json['total']);
                $('#cart-total a').html(str);
				
				//底部购物车
				$(".tmMCBotLink .tmMCNum").html(str);
				$(".tmMCHdLeft span.tmMCNum").html(str);
				
				
				$(".tmMCHandler").addClass('HdlOpen').addClass('HdlShort');
				$("#J_TMiniCart").css({'width':'283px'});
				$(".tmMCTopBorder").css({'display':'block'});
				
				//动画移动到底部购物车
				$(".goodscar").before("<span  class=\"square\" style=\"position:absolute; left:300px;top:300px;background-color:#fff; width:50px;height:50px; border:1px solid black;z-index:1000;\"><img src='"+json['cartimage']+"'</span>");
			
				$(".square").animate({top:$("#J_CommonBottomBar").offset().top, left: $("#J_CommonBottomBar").offset().left+100, width: 50, height:50},'slow',function(){$(this).remove();}).fadeOut('slow');
				
			}	
		}
	});
}



//直接购买
function dBuy(product_id, quantity) {
	quantity = typeof(quantity) != 'undefined' ? quantity : 1;
    
	$.ajax({
		url: 'index.php?route=checkout/dbuy/index',
		type: 'post',
		data: $('.product_info input[type=\'text\'], .product_info input[type=\'hidden\'], .product_info input[type=\'radio\']:checked, .product_info input[type=\'checkbox\']:checked, .product_info select, .product_info textarea'),
		dataType: 'json',
		success: function(json) {
		    console.log(json);
		    $('.success, .warning, .attention, .information, .error').remove();
			
			if (json['error']) {
				if(json['error']['product']){
					alert('自己不能购买自己的产品！');
					return false;
				}
        
				if(json['error']['attribute']){
				    for (i in json['error']['attribute']) {
						/* $('#attribute-' + i ).append('<span class="error">' + json['error']['attribute'][i] + '</span>'); */
						$('.attributes').append('<span class="error">' + json['error']['attribute'][i] + '</span>');
					}
				}
				
				return false;
			} 
			
			if (json['redirect']) {
				location.href = json['redirect'];
			}
			
			if (json['success']) {
			    location.href='index.php?route=checkout/checkout';
			}
		}
	});
}


//加入收藏列表
function addToWishList(product_id) {
	$.ajax({
		url: 'index.php?route=account/wishlist/add',
		type: 'post',
		data: 'product_id=' + product_id,
		dataType: 'json',
		success: function(json) {
		    
			//$('.success, .warning, .attention, .information').remove();
						
			if (json['success']) {
				//$('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
				
				//$('.success').fadeIn('slow');
				
				//$('#wishlist-total').html(json['total']);
				
				//$('html, body').animate({ scrollTop: 0 }, 'slow');
				alert('收藏成功!');
			}	
		}
	});
}

function addToCompare(product_id) { 
	$.ajax({
		url: 'index.php?route=product/compare/add',
		type: 'post',
		data: 'product_id=' + product_id,
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, .information').remove();
						
			if (json['success']) {
				$('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
				
				$('.success').fadeIn('slow');
				
				$('#compare-total').html(json['total']);
				
				$('html, body').animate({ scrollTop: 0 }, 'slow'); 
			}	
		}
	});
}



/*移动到导航*/

$(document).ready(function(){
  $(".logomenu1").hover(function(){
     $(this).css({'background-position':'0px -392px'});
  },function(){
     $(this).css({'background-position':'0px 0px'});
  });
  
  $(".logomenu2").hover(function(){
     $(this).css({'background-position':'-100px -392px'});
  },function(){
     $(this).css({'background-position':'-100px 0px'});
  });
  
  $(".logomenu3").hover(function(){
     $(this).css({'background-position':'-200px -392px'});
  },function(){
     $(this).css({'background-position':'-200px 0px'});
  });
  
  $(".logomenu4").hover(function(){
     $(this).css({'background-position':'-300px -392px'});
  },function(){
     $(this).css({'background-position':'-300px 0px'});
  });
  
  $(".logomenu5").hover(function(){
     $(this).css({'background-position':'-400px -392px'});
  },function(){
     $(this).css({'background-position':'-400px 0px'});
  });

});



//收藏本站
function AddFavorite(title, url) {
    try {
        window.external.addFavorite(url, title);
    }
    catch (e) {
        try {
            window.sidebar.addPanel(title, url, "");
        }
        catch (e) {
            alert("抱歉，您所使用的浏览器无法完成此操作。\n\n加入收藏失败，请使用Ctrl+D进行添加");
        }
    }
}


//返回顶部
function gotoTop(min_height){
	//预定义返回顶部的html代码，它的css样式默认为不显示
	var gotoTop_html = '<div id="gotoTop">返回顶部</div>';
	//将返回顶部的html代码插入页面上id为page的元素的末尾 
	$("#con").append(gotoTop_html);
	$("#gotoTop").click(function(){//定义返回顶部点击向上滚动的动画
	    $('html,body').animate({scrollTop:0},700);
	}).hover(function(){//为返回顶部增加鼠标进入的反馈效果，用添加删除css类实现
	   $(this).addClass("hover");
	},function(){$(this).removeClass("hover");
	});
	//获取页面的最小高度，无传入值则默认为600像素
	min_height ? min_height = min_height : min_height = 600;
	//为窗口的scroll事件绑定处理函数
	$(window).scroll(function(){
		//获取窗口的滚动条的垂直位置
		var s = $(window).scrollTop();
		//当窗口的滚动条的垂直位置大于页面的最小高度时，让返回顶部元素渐现，否则渐隐
		if( s > min_height){
			$("#gotoTop").fadeIn(100);
		}else{
			$("#gotoTop").fadeOut(200);
		};
	});
};


