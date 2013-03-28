// JavaScript Document CNCIKE.COM
$(document).ready(function(){
       
		var preta;
		var preco;
		$(".classify_z li").hover(function(){
			preta=$(this).parent().children("li");
			preco=$(".classify_y").children("li");
			var index=$.inArray(this,preta);
			if(preco.eq(index)[0]){
				for (var classify_z_l_i=0;classify_z_l_i<6;classify_z_l_i++){
					if(classify_z_l_i==index){
						preta.removeClass("classify_z_lc"+(classify_z_l_i+1)).eq(classify_z_l_i).addClass("classify_z_lo"+(classify_z_l_i+1));
						
					}else{
						preta.removeClass("classify_z_lo"+(classify_z_l_i+1)).eq(classify_z_l_i).addClass("classify_z_lc"+(classify_z_l_i+1));
					}	
				}				
				preco.addClass("dn").eq(index).removeClass("dn");
			}
		});
		
		var rnkta;
		var rnkco;
		$("#ranking_list_ta li").hover(function(){
			rnkta=$(this).parent().children("li");
			rnkco=$("#ranking_list_co").children("li");
			var index=$.inArray(this,rnkta);
			if(rnkco.eq(index)[0]){				
				rnkta.removeClass("lio").eq(index).addClass("lio");
				rnkco.addClass("dn").eq(index).removeClass("dn");
			}
		});	
		var rnkfta;
		var rnkfco;
		$("#rankingf_list_ta li").hover(function(){
			rnkfta=$(this).parent().children("li");
			rnkfco=$("#rankingf_list_co").children("li");
			var index=$.inArray(this,rnkfta);
			if(rnkfco.eq(index)[0]){				
				rnkfta.removeClass("lio").eq(index).addClass("lio");
				rnkfco.addClass("dn").eq(index).removeClass("dn");
			}
		});	
		var trnkta;
		$(".top_ranking dd").hover(function(){
			trnkta=$(this).parent().children("dd");
			var index=$.inArray(this,trnkta);	
			trnkta.removeClass("ddo").eq(index).addClass("ddo");
			trnkta.children("div .ddo_img").addClass("dn").eq(index).removeClass("dn");
			trnkta.children("div .ddo_txt").children(".hot").addClass("dn").eq(index).removeClass("dn");
		});	
		var rnklta;
		var rnklco;
		$("#rankingl_list_ta li").hover(function(){
			rnklta=$(this).parent().children("li");
			rnklco=$("#rankingl_list_co").children("li");
			var index=$.inArray(this,rnklta);
			if(rnklco.eq(index)[0]){				
				rnklta.removeClass("lio").eq(index).addClass("lio");
				rnklco.addClass("dn").eq(index).removeClass("dn");
			}
		});	
		var rnkwta;
		var rnkwco;
		$("#rankingw_list_ta li").hover(function(){
			rnkwta=$(this).parent().children("li");
			rnkwco=$("#rankingw_list_co").children("li");
			var index=$.inArray(this,rnkwta);
			if(rnkwco.eq(index)[0]){				
				rnkwta.removeClass("lio").eq(index).addClass("lio");
				rnkwco.addClass("dn").eq(index).removeClass("dn");
			}
		});	
		
		
		$(".flist_brand_more_btn1").live("click",function(){
			$(".flist_brand_more_btn1").html("收起");
			$(this).removeClass("flist_brand_more_btn1").addClass("flist_brand_more_btn2");		
			$(".flist_brand").removeClass("flist_brandbox");
		});
		$(".flist_brand_more_btn2").live("click",function(){
			$(".flist_brand_more_btn2").html("更多");
			$(this).removeClass("flist_brand_more_btn2").addClass("flist_brand_more_btn1");					
			$(".flist_brand").addClass("flist_brandbox");
		});
		
		$(".clist_week_ranking_con dl dd").hover(function(){
		    $(this).children(".clist_week_ranking_con_z").find(".clist_week_imgs").removeClass("clist_week_imgs").addClass("clist_week_img");
			$(this).children(".clist_week_ranking_con_z").find(".clist_week_ranking_con_ts").removeClass("clist_week_ranking_con_ts").addClass("clist_week_ranking_con_t");
			$(this).children(".clist_week_ranking_con_z").removeClass("clist_week_ranking_con_z").removeClass("z").addClass("clist_week_ranking_con_cz").addClass("clist_week_img");
			$(this).children(".clist_week_ranking_con_y").removeClass("clist_week_ranking_con_y").removeClass("z").addClass("clist_week_ranking_con_cy");
			
		},function(){
			var clista=$(this).parent().children("dd");
			clista.children(".clist_week_ranking_con_cz").find(".clist_week_img").removeClass("clist_week_img").addClass("clist_week_imgs");
			clista.children(".clist_week_ranking_con_cz").find(".clist_week_ranking_con_t").removeClass("clist_week_ranking_con_t").addClass("clist_week_ranking_con_ts");
			clista.children(".clist_week_ranking_con_cz").removeClass("clist_week_ranking_con_cz").removeClass("clist_week_img").addClass("clist_week_ranking_con_z").addClass("z");
			clista.children(".clist_week_ranking_con_cy").removeClass("clist_week_ranking_con_cy").addClass("clist_week_ranking_con_y").addClass("z");
		});	
		

		
		/*
		var dt2ta;
		$(".dt_foods ul li").click(function(){
			dt2ta=$(this).parent().children("li");
			var index=$.inArray(this,dt2ta);	
			dt2ta.removeClass("fist_tab").eq(index).addClass("fist_tab");
		});	
		var dt3ta;
		$(".dt_house ul li").click(function(){
			dt3ta=$(this).parent().children("li");
			var index=$.inArray(this,dt3ta);	
			dt3ta.removeClass("fist_tab").eq(index).addClass("fist_tab");
		});	
		var dt4ta;
		$(".dt_travel ul li").click(function(){
			dt4ta=$(this).parent().children("li");
			var index=$.inArray(this,dt4ta);	
			dt4ta.removeClass("fist_tab").eq(index).addClass("fist_tab");
		});	
		var dt5ta;
		$(".dt5 ul li").click(function(){
			dt5ta=$(this).parent().children("li");
			dt5co=$(".pro_info_tab").children("dd");
			var index=$.inArray(this,dt5ta);	
			dt5ta.removeClass("fist_tab").eq(index).addClass("fist_tab");
			dt5co.addClass("dn").eq(index).removeClass("dn");
		});	
		*/
		
		var cshta;
		/*
		$(".clothes_focus_img ul li").click(function(){
			cshta=$(this).parent().children("li");
			var cshco=$(".clothes_show").children("img");
			var index=$.inArray(this,cshta);	
			cshco.addClass("dn").eq(index).removeClass("dn");
		});
		*/
		
		
		
		var cscta;
		$(".clothes_nature_color img").click(function(){
			cscta=$(this).parent().children("img");
			var index=$.inArray(this,cscta);	
			cscta.removeClass("select_img").eq(index).addClass("select_img");
		});
		
		var csmta;
		$(".clothes_nature_measu .xx").click(function(){
			csmta=$(this).parent().children(".xx");
			csmtb=$(".clothes_nature_measu").children(".measuo")
			var index=$.inArray(this,csmta);	
			csmta.eq(index).removeClass("measu").addClass("measuo");
			csmtb.removeClass("measuo").addClass("measu");
		});
		
		
		
});
//cnckMyCYAutoTabCon//穿悦排行Tab自动跳转///////////
//(
var li_i;
function cnckMyAutoTabCon(Tab,Con){
	var atcta;
	var atcco;	
	atcta=$(Tab).children("li");
	atcco=$(Con).children("li");
	index=atcta.size();
	((!li_i && typeof(li_i)!="undefined" && li_i!=0)||isNaN(li_i))?li_i=1:(li_i<index?li_i++:li_i=1)
	atcta.removeClass("lio").eq(li_i-1).addClass("lio");
	atcco.addClass("dn").eq(li_i-1).removeClass("dn");
}
//)(jQuery);
///////////////////
(function($){

	$.fn.cnckSuperMarquee = function(options){
		var opts = $.extend({},$.fn.cnckSuperMarquee.defaults, options);
		
		return this.each(function(){
			var $marquee = $(this);//滚动元素容器
			var _scrollObj = $marquee.get(0);//滚动元素容器DOM
			var scrollW = $marquee.width();//滚动元素容器的宽度
			var scrollH = $marquee.height();//滚动元素容器的高度
			var $element = $marquee.children(); //滚动元素
			var $kids = $element.children();//滚动子元素
			var scrollSize=0;//滚动元素尺寸
			var _type = (opts.direction == 'left' || opts.direction == 'right') ? 1:0;//滚动类型，1左右，0上下
			var scrollId, rollId, isMove, marqueeId;
			var t,b,c,d,e; //滚动动画的参数,t:当前时间，b:开始的位置，c:改变的位置，d:持续的时间，e:结束的位置
			var _size, _len; //子元素的尺寸与个数
			var $nav,$navBtns;
			var arrPos = []; 
			var numView = 0; //当前所看子元素
			var numRoll=0; //轮换的次数
			var numMoved = 0;//已经移动的距离

			//防止滚动子元素比滚动元素宽而取不到实际滚动子元素宽度
			$element.css(_type?'width':'height',10000);
			//获取滚动元素的尺寸
			var navHtml = '<ul>';
			if (opts.isEqual) {
				_size = $kids[_type?'outerWidth':'outerHeight']();
				_len = $kids.length;
				scrollSize = _size * _len;
				for(var i=0;i<_len;i++){
					arrPos.push(i*_size);
					navHtml += '<li>'+ (i+1) +'</li>';
				}
			}else{
				$kids.each(function(i){
					arrPos.push(scrollSize);
					scrollSize += $(this)[_type?'outerWidth':'outerHeight']();
					navHtml += '<li>'+ (i+1) +'</li>';
				});
			}
			navHtml += '</ul>';
			
			//滚动元素总尺寸小于容器尺寸，不滚动
			if (scrollSize<(_type?scrollW:scrollH)) return; 
			//克隆滚动子元素将其插入到滚动元素后，并设定滚动元素宽度
			$element.append($kids.clone()).css(_type?'width':'height',scrollSize*2);
			
			//轮换导航
			if (opts.navId) {
				$nav = $(opts.navId).append(navHtml).hover( stop, start );
				$navBtns = $('li', $nav);
				$navBtns.each(function(i){
					$(this).bind(opts.eventNav,function(){
						if(isMove) return;
						if(numView==i) return;
						rollFunc(arrPos[i]);
						$navBtns.eq(numView).removeClass('navOn');
						numView = i;
						$(this).addClass('navOn');
					});
				});
				$navBtns.eq(numView).addClass('navOn');
			}
			
			//设定初始位置
			if (opts.direction == 'right' || opts.direction == 'down') {
				_scrollObj[_type?'scrollLeft':'scrollTop'] = scrollSize;
			}else{
				_scrollObj[_type?'scrollLeft':'scrollTop'] = 0;
			}
			
			if(opts.isMarquee){
				//滚动开始
				//marqueeId = setInterval(scrollFunc, opts.scrollDelay);
				marqueeId = setTimeout(scrollFunc, opts.scrollDelay);
				//鼠标划过停止滚动
				$marquee.hover(
					function(){
						clearInterval(marqueeId);
					},
					function(){
						//marqueeId = setInterval(scrollFunc, opts.scrollDelay);
						clearInterval(marqueeId);
						marqueeId = setTimeout(scrollFunc, opts.scrollDelay);
					}
				);
				
				//控制加速运动
				if(opts.controlBtn){
					$.each(opts.controlBtn, function(i,val){
						$(val).bind(opts.eventA,function(){
							opts.direction = i;
							opts.oldAmount = opts.scrollAmount;
							opts.scrollAmount = opts.newAmount;
						}).bind(opts.eventB,function(){
							opts.scrollAmount = opts.oldAmount;
						});
					});
				}
			}else{
				if(opts.isAuto){
					//轮换开始
					start();
					
					//鼠标划过停止轮换
					$marquee.hover( stop, start );
				}
			
				//控制前后走
				if(opts.btnGo){
					$.each(opts.btnGo, function(i,val){
						$(val).bind(opts.eventGo,function(){
							if(isMove == true) return;
							opts.direction = i;
							rollFunc();
							if (opts.isAuto) {
								stop();
								start();
							}
						});
					});
				}
			}
			
			function scrollFunc(){
				var _dir = (opts.direction == 'left' || opts.direction == 'right') ? 'scrollLeft':'scrollTop';
				
				if(opts.isMarquee){
					if (opts.loop > 0) {
						numMoved+=opts.scrollAmount;
						if(numMoved>scrollSize*opts.loop){
							_scrollObj[_dir] = 0;
							return clearInterval(marqueeId);
						} 
					}
					var newPos = _scrollObj[_dir]+(opts.direction == 'left' || opts.direction == 'up'?1:-1)*opts.scrollAmount;
				}else{
					if(opts.duration){
						if(t++<d){
							isMove = true;
							var newPos = Math.ceil(easeOutQuad(t,b,c,d));
							if(t==d){
								newPos = e;
							}
						}else{
							newPos = e;
							clearInterval(scrollId);
							isMove = false;
							return;
						}
					}else{
						var newPos = e;
						clearInterval(scrollId);
					}
				}
				
				if(opts.direction == 'left' || opts.direction == 'up'){
					if(newPos>=scrollSize){
						newPos-=scrollSize;
					}
				}else{
					if(newPos<=0){
						newPos+=scrollSize;
					}
				}
				_scrollObj[_dir] = newPos;
				
				if(opts.isMarquee){
					marqueeId = setTimeout(scrollFunc, opts.scrollDelay);
				}else if(t<d){
					if(scrollId) clearTimeout(scrollId);
					scrollId = setTimeout(scrollFunc, opts.scrollDelay);
				}else{
					isMove = false;
				}
				
			};
			
			function rollFunc(pPos){
				isMove = true;
				var _dir = (opts.direction == 'left' || opts.direction == 'right') ? 'scrollLeft':'scrollTop';
				var _neg = opts.direction == 'left' || opts.direction == 'up'?1:-1;

				numRoll = numRoll +_neg;
				//得到当前所看元素序号并改变导航CSS
				if(pPos == undefined&&opts.navId){
					$navBtns.eq(numView).removeClass('navOn');
					numView +=_neg;
					if(numView>=_len){
						numView = 0;
					}else if(numView<0){
						numView = _len-1;
					}
					$navBtns.eq(numView).addClass('navOn');
					numRoll = numView;
				}

				var _temp = numRoll<0?scrollSize:0;
				t=0;
				b=_scrollObj[_dir];
				//c=(pPos != undefined)?pPos:_neg*opts.distance;
				e=(pPos != undefined)?pPos:_temp+(opts.distance*numRoll)%scrollSize;
				if(_neg==1){
					if(e>b){
						c = e-b;
					}else{
						c = e+scrollSize -b;
					}
				}else{
					if(e>b){
						c =e-scrollSize-b;
					}else{
						c = e-b;
					}
				}
				d=opts.duration;
				
				//scrollId = setInterval(scrollFunc, opts.scrollDelay);
				if(scrollId) clearTimeout(scrollId);
				scrollId = setTimeout(scrollFunc, opts.scrollDelay);
			}
			
			function start(){
				rollId = setInterval(function(){
					rollFunc();
				}, opts.time*1000);
			}
			function stop(){
				clearInterval(rollId);
			}
			
			function easeOutQuad(t,b,c,d){
				return -c *(t/=d)*(t-2) + b;
			}
			
			function easeOutQuint(t,b,c,d){
				return c*((t=t/d-1)*t*t*t*t + 1) + b;
			}

		});
	};
	$.fn.cnckSuperMarquee.defaults = {
		isMarquee:false,//是否为Marquee
		isEqual:true,//所有滚动的元素长宽是否相等,true,false
		loop: 0,//循环滚动次数，0时无限
		newAmount:3,//加速滚动的步长
		eventA:'mousedown',//鼠标事件，加速
		eventB:'mouseup',//鼠标事件，原速
		isAuto:true,//是否自动轮换
		time:5,//停顿时间，单位为秒
		duration:50,//缓动效果，单次移动时间，越小速度越快，为0时无缓动效果
		eventGo:'click', //鼠标事件，向前向后走
		direction: 'left',//滚动方向，'left','right','up','down'
		scrollAmount:1,//步长
		scrollDelay:10,//时长
		eventNav:'click'//导航事件
	};
	
	$.fn.cnckSuperMarquee.setDefaults = function(settings) {
		$.extend( $.fn.cnckSuperMarquee.defaults, settings );
	};
	
})(jQuery);