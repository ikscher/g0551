<!--修改begin-->
<!-- <form action="<?php echo $action;?>" method="post" enctype="multipart/form-data" id="form"> -->
    <table class="form" style="cellspacing:10">
	  <tr>
		<td><span class="required">*</span> <?php echo $entry_name;?></td>
		<td>
		  <input type="text" name="attribute_group_name" value="<?php if(isset($attribute_group_name)) { ?><?php echo $attribute_group_name;?><?php } ?>" />
		  <?php if(isset($error_name)) { ?>
		  <span class="error"><?php echo $error_name;?></span><br />
		  <?php } ?>
		  </td>
	  </tr>
	  
	  <!--
	  <tr>
		<td><?php echo $entry_type;?></td>
		<td>
		    <select name="attribute_cid0" class="oned">
				<option value=''>--请选择--</option>
				<?php if(!empty($firstDir)) { ?>
			        <?php foreach((array)$firstDir as $v) {?>
		                <option value="<?php echo $v['id'];?>" <?php if($cid0==$v['id']) { ?>selected="selected"<?php } ?>><?php echo $v['id'];?>：<?php echo $v['name'];?></option>
					<?php } ?>
				<?php } ?>
			</select>	
		</td>
	  </tr>
	  <tr>
	    <td></td>
		<td>
		    <select name="attribute_cid1" class="twod">
			    <option value=''>--请选择--</option>
			    <?php if(!empty($secondDir)) { ?>
			        <?php foreach((array)$secondDir as $v) {?>
		                <option value="<?php echo $v['id'];?>" <?php if($cid1==$v['id']) { ?>selected="selected"<?php } ?>><?php echo $v['id'];?>：<?php echo $v['name'];?></option>
					<?php } ?>
				<?php } ?>
		    </select>
		</td>
	  </tr>
	  
	  <tr>
	    <td></td>
		<td>
			<select name="attribute_cid2" class="threed">
			    <option value=''>--请选择--</option>
			    <?php if(!empty($thirdDir)) { ?>
			        <?php foreach((array)$thirdDir as $t) {?>
		                <option value="<?php echo $t['id'];?>" <?php if($cid2==$t['id']) { ?>selected="selected"<?php } ?>><?php echo $t['id'];?>：<?php echo $t['name'];?></option>
					<?php } ?>
				<?php } ?>
		    </select>
	    </td>
	  </tr>
	  
	  <tr>
	    <td></td>
		<td>
		    <select name="attribute_cid3" class="fourd">
			    <option value=''>--请选择--</option>
			    <?php if(!empty($forthDir)) { ?>
			        <?php foreach((array)$forthDir as $f) {?>
		                <option value="<?php echo $f['id'];?>" <?php if($cid3==$f['id']) { ?>selected="selected"<?php } ?>><?php echo $f['id'];?>：<?php echo $f['name'];?></option>
					<?php } ?>
				<?php } ?>
		    </select>
		</td>
	  </tr>
	  -->
	  
	  
	   <tr>
		<td><?php echo $entry_option;?></td>
		<td><select name='option_id'>
		    <option value=''>--请选择--</option>
			<?php foreach((array)$options as $option) {?>
			    <?php if($option['type']=='select' || $option['type']=='checkbox' || $option['type']=='radio') { ?>
					<option value="<?php echo $option['option_id'];?>" <?php if($option_id==$option['option_id']) { ?>selected="selected"<?php } ?>><?php echo $option['type'];?></option>
				<?php } ?>
			<?php } ?>
			
		    </select></td>
	  </tr>
	  <tr><td colspan='2' style="color:red;text-align:right;font-size:13px;"><?php echo $entry_option;?>只选择radio,checkbox,select</td></tr>
	  
	   <tr>
		<td><?php echo $entry_show;?></td>
		<td><select name='isShow'>
		      <option value=''>--请选择--</option>
			  <option value='1' <?php if($isShow=='1') { ?>selected="selected"<?php } ?>>yes</option>
			  <option value='0' <?php if($isShow==='0') { ?>selected="selected"<?php } ?>>no</option>
		    </select></td>
	  </tr>
	  
	  <tr>
		<td><?php echo $entry_group_type;?></td>
		<td><select name='group_type'>
		      <option value=''>--请选择--</option>
			  <option value='1' <?php if($type==1) { ?>selected="selected"<?php } ?>><?php echo $entry_general;?></option>
			  <option value='2' <?php if($type==2) { ?>selected="selected"<?php } ?>><?php echo $entry_price;?></option>
		    </select></td>
	  </tr>
	  
	  <tr>
		<td><?php echo $entry_sort_order;?></td>
		<td><input type="text" name="sort_order" value="<?php echo $sort_order;?>" size="5" /></td>
	  </tr>
	  
	  <input type='hidden' name='original_option_id' value="<?php echo $option_id;?>" />
	  <input type='hidden' name='attribute_group_id' value="<?php echo $attribute_group_id;?>" />
	</table>
<!-- </form> -->
<!--修改end-->
 
<script type="text/javascript">
  
  var sel={ 
            getOne:function(){
				var id=$('.oned').find("option:selected").val();
				$.ajax({
				    url:'index.php?route=catalog/attribute_group/getAjaxCategory&token=<?php echo $token;?>&id='+id,
				    dataType:'json',
					success:function(json){
					    var l=json.length;
						var x="<option value=''>--请选择--</option>";
						if (l>0){
						    for(var i=0;i<l;i++){
							    x=x+"<option value="+json[i]['id']+">"+json[i]['id']+"："+json[i]['name']+"</option>";
							}
						}else{
						    x='';
						}
					
					    $('.twod').html(x);
						$('.threed').html('');
						$('.fourd').html('');
					},
					error:function(){
					    alert('数据返回错误！');
					}
				});
			    
			},
			getTwo:function(){
			    //var url=sel.getUrl();
				var id=$('.twod').val();
				$.ajax({
				    url:'index.php?route=catalog/attribute_group/getAjaxCategory&token=<?php echo $token;?>&id='+id,
				    dataType:'json',
					success:function(json){
					    var l=json.length;
						var x="<option value=''>--请选择--</option>";
						if (l>0){
						    for(var i=0;i<l;i++){
							    x=x+"<option value="+json[i]['id']+">"+json[i]['id']+"："+json[i]['name']+"</option>";
							}
						}else{
						    x='';
						}
					
					    $('.threed').html(x);
						$('.fourd').html('');
					},
					error:function(){
					    alert('数据返回错误！');
					}
				});
			    
			},
			
			getThree:function(){
			    //var url=sel.getUrl();
				var id=$('.threed').val();
				$.ajax({
				    url:'index.php?route=catalog/attribute_group/getAjaxCategory&token=<?php echo $token;?>&id='+id,
				    dataType:'json',
					success:function(json){
					    var l=json.length;
						var x="<option value=''>--请选择--</option>";
						if (l>0){
						    for(var i=0;i<l;i++){
							    x=x+"<option value="+json[i]['id']+">"+json[i]['id']+"："+json[i]['name']+"</option>";
							}
						}else{
						    x='';
						}
					
					    $('.fourd').html(x);
					},
					error:function(){
					    alert('数据返回错误！');
					}
				});
			    
			},
			
			getUrl:function(){
			    var pathname=location.pathname;
				var query=location.search;
				var url=pathname+query;
				return url;
			}
	};
	
	$('.oned').bind('change',sel.getOne);
	$('.twod').bind('change',sel.getTwo);
	$('.threed').bind('change',sel.getThree);

	
</script>