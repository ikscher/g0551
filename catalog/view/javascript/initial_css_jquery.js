// JavaScript Document
$(document).ready(function(){
	
	//----------------clothes-----------------//
	$("#ranking_list_ta li:first").addClass("lio");
	$("#ranking_list_co li:first").removeClass("dn");
	//----------------foods-----------------//
	$("#rankingf_list_ta li:first").addClass("lio");
	$("#rankingf_list_co li:first").removeClass("dn");
	//
	$(".top_ranking").find("dd:first").addClass("ddo");
	$(".top_ranking").find("dd:first .ddo_img").removeClass("dn");
	//----------------live-----------------//
	$("#rankingl_list_ta li:first").addClass("lio");
	$("#rankingl_list_co li:first").removeClass("dn");	
	//------------------walk-------------------//
	$("#rankingw_list_co li:first").removeClass("dn");
	$("#rankingw_list_co li").find("dl:first").css("border","0px");	
	//------------------clist-------------------//
	$(".clist_channel_content ul li:last").css("border","0px");
	$(".clist_week_ranking_con").find(".clist_week_ranking_con_z:first").find(".clist_week_imgs").removeClass("clist_week_imgs").addClass("clist_week_img");
	$(".clist_week_ranking_con").find(".clist_week_ranking_con_z:first").find(".clist_week_ranking_con_ts").removeClass("clist_week_ranking_con_ts").addClass("clist_week_ranking_con_t");
	$(".clist_week_ranking_con").find(".clist_week_ranking_con_z:first").removeClass("clist_week_ranking_con_z").removeClass("z").addClass("clist_week_ranking_con_cz").addClass("clist_week_img");
	$(".clist_week_ranking_con").find(".clist_week_ranking_con_y:first").removeClass("clist_week_ranking_con_y").removeClass("z").addClass("clist_week_ranking_con_cy");
	
	$(".dt1 ul li:first").addClass("fist_tab");
	$(".dt2 ul li:first").addClass("fist_tab");
	$(".dt3 ul li:first").addClass("fist_tab");
	$(".dt4 ul li:first").addClass("fist_tab");
	$(".dt5 ul li:first").addClass("fist_tab");
	
	$(".pro_info_tab dd:first").removeClass("dn");
	$(".clothes_show img:first").removeClass("dn");
	
	
});