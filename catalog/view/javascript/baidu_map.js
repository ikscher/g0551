$(document).ready(function(){	
	//developer.baidu.com/map
	var Args = document.getElementById('map').getAttribute('data-pos');
	var map=Args.match(/\d+(\.)?(\d*)/g);

	var map_x=map[0];
	var map_y=map[1];
	//var title=document.getElementById('map').getAttribute('title');
	var baidumap={
			map : new BMap.Map("container"),
			point : new BMap.Point(map_x,map_y),
			/*
			infowindow :  new BMap.InfoWindow(title, {
			    width:150,
				height:50
				//title:'hello'
			}),  // 创建信息窗口对象  
			*/
			addMarker:function(point, index){   // 创建图标对象  
			    this.map.centerAndZoom(point, 15);
				var myIcon = new BMap.Icon("catalog/view/theme/default/image/marker.png", new BMap.Size(20, 32), {  
				// 指定定位位置。 
				// 当标注显示在地图上时其所指向的地理位置距离图标左上      
				// 角各偏移10像素和25像素。您可以看到在本例中该位置即是      
				// 图标中央下端的尖角位置。     
					offset: new BMap.Size(10, 32)  
				// 设置图片偏移。     
				// 当您需要从一幅较大的图片中截取某部分作为标注图标时您     
				// 需要指定大图的偏移位置此做法与css sprites技术类似。      
					//imageOffset: new BMap.Size(0, 0 - index * 25) 
				// 设置图片偏移  
				});      
				// 创建标注对象并添加到地图    
				var marker = new BMap.Marker(point, {icon: myIcon});  
				this.map.addOverlay(marker); 
				marker.enableDragging(); 
				marker.addEventListener("dragend", function(e){  
  			    	//alert("当前位置" + e.point.lng + ", " + e.point.lat); 
					$("input[name=map_x]").val(e.point.lng);
					$("input[name=map_y]").val(e.point.lat);
				});
			}
	};
    
	baidumap.addMarker(baidumap.point, 1); 
	
	 
    baidumap.map.addControl(new BMap.NavigationControl());
	baidumap.map.addControl(new BMap.ScaleControl());
	baidumap.map.addControl(new BMap.OverviewMapControl());
	baidumap.map.enableScrollWheelZoom();     //启用滚轮放大缩小，默认禁用。
	//map.addControl(new BMap.MapTypeControl());

	baidumap.map.openInfoWindow(baidumap.infowindow, baidumap.map.getCenter());      // 打开信息窗口 
    
	//右键添加标注
    var contextMenu = new BMap.ContextMenu(); 	
	var txtMenuItem = [
	   {
	    text:'放大',
	    callback:function(){baidumap.map.zoomIn()}
	   },
	   {
	    text:'缩小',
	    callback:function(){baidumap.map.zoomOut()}
	   },
	   {
	    text:'在此添加标注',
	    callback:function(p){
		    baidumap.map.clearOverlays();
		    var myIcon = new BMap.Icon("catalog/view/theme/default/image/marker.png", new BMap.Size(20, 32), {  
					offset: new BMap.Size(10, 32)  
				});      
		    var marker = new BMap.Marker(p, {icon: myIcon}), px = baidumap.map.pointToPixel(p);
			//alert(p.lat+' '+p.lng);
		    baidumap.map.addOverlay(marker);
		    marker.enableDragging(); 
			var p=marker.getPosition();
			//alert("当前位置 :" + p.lng + ", " + p.lat); 
			$("input[name=map_x]").val(p.lng);
			$("input[name=map_y]").val(p.lat);
		
			
	    }
	   }
	 ];
	 
	for(var i=0; i < txtMenuItem.length; i++){
	    contextMenu.addItem(new BMap.MenuItem(txtMenuItem[i].text,txtMenuItem[i].callback,100));
	    if(i==1 || i==3) {
	        contextMenu.addSeparator();
	    }
	}
	baidumap.map.addContextMenu(contextMenu);
	
	/*
	var local = new BMap.LocalSearch("合肥", {
        renderOptions:{map: baidumap.map, autoViewport:true}
	});
	local.searchInBounds("商铺", baidumap.map.getBounds()); 
	*/

});
