<?php echo $header;?>
<link href="catalog/view/theme/default/stylesheet/notfound.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
      var time=3000;
      function redirect(){
	    self.location.href= document.referrer;
	  }
	  
	  setTimeout('redirect()', time);
	  
</script>
<div class="notfound"> 
		<ul>
			<li>非常抱歉，您请求的页面不存在！</li>
			
			<li><a href="javascript:history.back();"><img src="catalog/view/theme/default/image/goon.gif" /></a></li>
			
		</ul>
		
</div>
<?php echo $footer;?>