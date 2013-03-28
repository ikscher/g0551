var menudown=0;
//var Dir="/";
$(document).ready(function(){
	$(".menulist").mouseenter(function(e){
		//$(this).addClass("curr");
		menudown=1;
		$(this).children('ul').slideDown("fast");	
		$(this).children('span').css({'background':'url(./catalog/view/theme/default/image/3c4.png) no-repeat right center','padding-right':'10px','color':'#666'});
	}).mouseleave(function(e){
		//$(this).removeClass("curr");
		setTimeout("menudown=0",300);
		//menudown=0;
		$(this).children('ul').fadeOut("slow");	
		$(this).children('span').css({'background':'url(./catalog/view/theme/default/image/3c3.png) no-repeat right center','padding-right':'10px','color':'#666'});
	});
	
	/* $(".menulist>span").click(function(){
		menudown=1;
		$(".menulist>ul").slideToggle("fast");	
		setTimeout("menudown=0",300);
	}) */
	
	/* $(".searchtype>span").mouseover(function(){
		menudown=1;
		$(".searchtype>ul").slideToggle("fast");	
		setTimeout("menudown=0",300);
	}) */
	
	/* $(".searchtype a").click(function(){
		$("#SearchPageId").val($(this).attr("rel"));
		$("#currentSearchPage").html($(this).html());
	}) */
	
	/* $(document).click(function(){
		if(menudown==0){
			$(".menulist>ul").slideUp("fast");	
			//$(".searchtype>ul").slideUp("fast");	
		}				   
	}); */
});
