<?php echo $header;?>
<div id="show_main">
	<div class="blank10"></div>
	<div class="bg980">
	<!--左边-->
		<div class="great_l">
			<!---------->
			<div class="share-user">
				<p class="share-avatar"><a><img src="catalog/view/theme/default/image/s_detail/50-1.jpg" /></a></p>
				<p><a class="f16b"><?php echo $msg['present'];?></a></p>
				<p><span class="when"><?php echo $msg['createtime'];?></span><span>来自穿悦网</span></p>
			</div>
			<div class="share-cont">
				<div class="share-txt">
					<h4 class="share-title"><?php if(isset($msg['title'])) { ?>【<?php echo $msg['title'];?>】<?php } ?></h4><p><?php if(isset($msg['content'])) { ?><?php echo $msg['content'];?><?php } ?></p>
				</div>
			<!---------->
				<!-- <div class="share-pic-cont">						
					<div class="share-pic"><a href="<?php echo $msg['href'];?>"><img class="share-img" src="<?php if(isset($msg['image'])) { ?><?php echo $msg['image'];?><?php } ?>"></a>
					</div>					
				</div> -->
			<!---------->
			</div>
			
			<div class="tools cls">
				<span>分享<b class="c-count">(5)</b></span>
				<span><a class="digg like-btn" ><em><strong><?php echo $msg['favoriate'];?></strong></em></a></span>
			</div>
			<div class="comment">
				<div class="comment-post" style="zoom:1">
					<div class="txt"><textarea id="remark"></textarea></div>
					<div class="submit cls">
						<a href="javascript:void(0);" class="comment-btn btns btn-default-20" ><span>评论</span></a>
					</div>
					<ul>
						<?php foreach((array)$comments as $comment) {?>
							<li>
								<div class="comment-hf">
									<div class="comment-hf-l">
										<ul>
											<li><img src="catalog/view/theme/default/image/s_detail/30-1.jpg "></li>
											<li><span class="c588"><?php if(!empty($comment['userid'])) { ?><?php echo $comment['username'];?><?php } else { ?>游客<?php } ?>：</span><?php echo $comment['comment'];?><br><?php echo date('Y-m-d H:i:s',$comment['createtime'])?></li>
										</ul>
									</div>
								</div>
							</li>
						<?php } ?>
					</ul>
				</div>
			</div>	
			<!---------->
		<!--{start: 超多人喜欢 -->
		<div class="post-liked-hd">
			<h2>你可能喜欢</h2>
		</div>
		<div class="post-liked-bd">
			<ul class="cls">
				<li>
					<div class="share-liked-bd cls"><a><img src="catalog/view/theme/default/image/s_detail/11.jpg" width="208" height="208"/></a></div>
					<div class="share-liked-bt"><a><img src="catalog/view/theme/default/image/s_detail/30-1.jpg" />夜之谜猫</a></div>
				</li>
				<li>
					<div class="share-liked-bd cls"><a><img src="catalog/view/theme/default/image/s_detail/11.jpg" width="208" height="208"/></a></div>
					<div class="share-liked-bt"><a><img src="catalog/view/theme/default/image/s_detail/30-1.jpg" />夜之谜猫</a></div>
				</li>
				<li>
					<div class="share-liked-bd cls"><a><img src="catalog/view/theme/default/image/s_detail/11.jpg" width="208" height="208"/></a></div>
					<div class="share-liked-bt"><a><img src="catalog/view/theme/default/image/s_detail/30-1.jpg" />夜之谜猫</a></div>
				</li>
				<li>
					<div class="share-liked-bd cls"><a><img src="catalog/view/theme/default/image/s_detail/11.jpg" width="208" height="208"/></a></div>
					<div class="share-liked-bt"><a><img src="catalog/view/theme/default/image/s_detail/30-1.jpg" />夜之谜猫</a></div>
				</li>
				<li>
					<div class="share-liked-bd cls"><a><img src="catalog/view/theme/default/image/s_detail/11.jpg" width="208" height="208"/></a></div>
					<div class="share-liked-bt"><a><img src="catalog/view/theme/default/image/s_detail/30-1.jpg" />夜之谜猫</a></div>
				</li>
				<li>
					<div class="share-liked-bd cls"><a><img src="catalog/view/theme/default/image/s_detail/11.jpg" width="208" height="208"/></a></div>
					<div class="share-liked-bt"><a><img src="catalog/view/theme/default/image/s_detail/30-1.jpg" />夜之谜猫</a></div>
				</li>
			</ul>
		</div>
		<!--}end: 超多人喜欢 -->
		</div>
	<!--左边end-->
	<!--右边-->
		<div class="great_r">
			
			<div class="side-con cls">
				<div class="post-wrap">
					<div class="title cls">
						<h3><a>春之韵</a>的分享</h3><a class="right-a">更多</a>
					</div>
					<div class="cls">
						<ul class="pic-list post-pic cls">
								<li>
									<div class="pic-wrap"><a><img src="catalog/view/theme/default/image/s_detail/t01.jpg"></a></div>
									<div class="con-wrap cls"><p>小王子被巫婆施了咒语吗？<a>查看全部</a></p></div>
								</li>
								<li>
									<div class="pic-wrap"><a><img src="catalog/view/theme/default/image/s_detail/t01.jpg"></a></div>
									<div class="con-wrap cls"><p>小王子被巫婆施了咒语吗？<a>查看全部</a></p></div>
								</li>
								<li>
									<div class="pic-wrap"><a><img src="catalog/view/theme/default/image/s_detail/t01.jpg"></a></div>
									<div class="con-wrap cls"><p>小王子被巫婆施了咒语吗？<a>查看全部</a></p></div>
								</li>
						</ul>
					</div>
					<div class="toggle-btn cls">
						<a class="btn-l"></a>
						<span class="digital">1 / 7</span>
						<a class="btn-r"></a>
					</div>
				</div>
			</div>
			<div class="adpic-220-136">
			<a href=""><img src="catalog/view/theme/default/image/s_detail/ad1.jpg"/></a><br></br>
			<a href=""><img src="catalog/view/theme/default/image/s_detail/ad2.jpg"/></a><br></br>
			<a href=""><img src="catalog/view/theme/default/image/s_detail/ad3.jpg"/></a><br></br>
			<a href=""><img src="catalog/view/theme/default/image/s_detail/ad4.jpg"/></a><br></br>
			</div>	
		</div>
	<!--右边end-->
	</div>

	<!--content_end-->

		

</div>
<!-- <script type="text/javascript" src="http://s.shareto.com.cn/js/shareto_button.js" charset="utf-8"></script> -->

<script type="text/javascript">
	function addFavoriate(){
		$.post("index.php?route=product/joy/addFavoriate",{id:<?php echo $msg['content_id'];?>},function(str){
		    alert('献爱成功！');
		});
	}
	
	function addComment(){
		var comment = $.trim($("#remark").val());
		var content_id=<?php echo $msg['content_id'];?>;
        var username;
		<?php if(!empty($userid)) { ?>
		    username='<?php echo $username;?>'+'：';
		<?php } else { ?>
		    username='游客：'
		<?php } ?>
		
		if(!comment){
		    alert('请输入评论内容！');
			return false;
		}
		
		$.post("index.php?route=product/joy/addComment",{id:content_id,comment:comment},function(str){
		    if(str==1){
				alert('评论成功！');
				$("#remark").val('');
				
				var remark=$("<li><div class='comment-hf'><div class='comment-hf-l'><ul><li><img src='catalog/view/theme/default/image/s_detail/30-1.jpg '></li><li><span class='c588'>"+username+"</span>"+comment+"<br>"+CurrentTime()+"</li></ul></div></div></li>");
			    $(".comment-post ul li:eq(0)").prepend(remark);
			}else{
			    alert('评论失败！');
			}
		});
	}
	
	$(".comment .submit a").click(function(){
	    addComment();
	});
	
	
	
	//若要显示:当前日期加时间(如:2009-06-12 12:00:00)
	function CurrentTime(){ 
		var now = new Date();
	   
		var year = now.getFullYear();       //年
		var month = now.getMonth() + 1;     //月
		var day = now.getDate();            //日
	   
		var hh = now.getHours();            //时
		var mm = now.getMinutes();          //分
		var ss = now.getSeconds();          //秒
	   
		var clock = year + "-";
	   
		if(month < 10)
			clock += "0";
	   
		clock += month + "-";
	   
		if(day < 10)
			clock += "0";
		   
		clock += day + " ";
	   
		if(hh < 10) clock += "0";
		clock += hh + ":";
		
		if (mm < 10) clock += '0'; 
		clock += mm + ":"; 
		
		if(ss<10)  clock += '0';
		clock +=ss;
		
		return(clock); 
	} 
</script>

<?php echo $footer;?> 
