<?php echo $header;?>
<script type="text/javascript" src="catalog/view/javascript/jquery.masonry.min.js"></script>
<!--content begin-->

<div id="con">
<div id="main">

<div class=" it_box item">
	<div class="it_tag cl h">
		<dl>
			<dt>热门标签</dt>
			<dd>
				<div><a href="#">自驾游</a></div>
				<div><a href="#">当季游</a></div>
				<div><a href="#">电影之旅</a></div>
			</dd>
			<dd class="cl_div"></dd>
		</dl>
		<dl>
			<dt><a href="#">玩乐</a></dt>
			<dd>
				<div><a href="#">户外</a></div>
				<div><a href="#">夜生活</a></div>
				<div><a href="#">桌游</a></div>
				<div><a href="#">游乐游艺</a></div>
				<div><a href="#">瑜伽</a></div>
				<div><a href="#">健身</a></div>
				<div><a href="#">骑行</a></div>
				<div><a href="#">徒步</a></div>
			</dd>
			<dd class="cl_div"></dd>
		</dl>
		<dl>
			<dt>主题游</dt>
			<dd>
				<div><a href="#">当季游</a></div>
				<div><a href="#">电影之旅</a></div>
			</dd>
			<dd class="cl_div"></dd>
		</dl>
		<dl>
			<dt>北京旅游</dt>
			<dd>
				<div><a href="#">当季游</a></div>
				<div><a href="#">电影之旅</a></div>
			</dd>
			<dd class="cl_div"></dd>
		</dl>
	</div>
	<div class="it_api cl h">
		<ul class="tc">
			<li class="f2n">生活应用</li>
			<li>
				<div class="z"><img src="catalog/view/theme/default/image/ico/api1.jpg" width="72" height="72" alt="api" /><p><a href="#">舌尖上没事</a></p></div>
				<div class="z"><img src="catalog/view/theme/default/image/ico/api2.jpg" width="72" height="72" alt="api" /><p><a href="#">育期宝典</a></p></div>
				<div class="z"><img src="catalog/view/theme/default/image/ico/api3.jpg" width="72" height="72" alt="api" /><p><a href="#">飞机票预订</a></p></div>
			</li>
			<li><div class="y"><a href="#">更多>></a></div></li>
		</ul>		
	</div>
</div>



</div>
</div>

<script type="text/javascript" >
    
	var loadLazy={
	    num:0,
		maxnum:5,
		loadMore:function(){
		    $.ajax({
				url : 'index.php?route=product/joy/getImageSrc&start='+loadLazy.num,
				dataType : 'json',
				success : function(show){
					if(typeof show == 'object'){	
						l = show.length;
						var i=0;
						var oProduct, row, iHeight, iTempHeight, item;
						for(i; i<l; i++){
							oProduct = show[i];
			
							// 找出当前高度最小的列, 新内容添加到该列
							iHeight = -1;
							$('#main').each(function(){
								iTempHeight = Number( $(this).height() );
								if(iHeight == -1 || iHeight > iTempHeight)
								{
									iHeight = iTempHeight;
									row = $(this);
								}
							});
							item = $('<div class="item"><div class="itimg"><a href="index.php?route=product/joy/joyDetail&id='+oProduct.id+'"><img src="'+oProduct.imageUrl+'"/></a></div><div class="itintr cl">'+oProduct.present+'</div><div class="itshare cl"><div class="itsharebg"><a >'+oProduct.favoriate+'</a></div> <div><a>评论</a>（'+oProduct.comment+'）</div> <div><a>分享</a>（'+oProduct.share+'）</div></div><div class="itmember cl"><a href="#"><img src="catalog/view/theme/default/image/nousefulpic/members1.gif" width="30" height="30" alt="itmember" />赛车手</a></div></div>').hide();
							
							row.append(item);
							item.fadeIn();
						}
					}
				}		
			});
		}
	
	
	
	};
	
	loadLazy.loadMore();
	$(document).ready(function () {
		$(window).bind("scroll",function(){
			var top = $(document).scrollTop();
			var wh = $(window).height();
			var dh = $(document).height();

		    /*判断窗体高度与竖向滚动位移大小相加 是否 超过内容页高度*/
			if ((wh + top) >= dh && (loadLazy.num < loadLazy.maxnum)) {
			    ++loadLazy.num;
				loadLazy.loadMore();
				
			}
		});
	});
	
	
	
	gotoTop();//返回顶部
</script>

<div class="cl_div"></div>
<?php echo $footer;?> 