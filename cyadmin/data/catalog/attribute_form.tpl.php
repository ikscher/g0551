<form action="<?php echo $action;?>" method="post" enctype="multipart/form-data" id="form">
	<table class="form">
	  <tr>
		<td><span class="required">*</span> <?php echo $entry_name;?></td>
		<td>
		  <input type="text" name="attribute_name" value="<?php if(isset($attribute_name)) { ?> <?php echo $attribute_name;?><?php } ?>" />
		  <br />
		  <?php if(isset($error_name)) { ?>
		  <span class="error"><?php echo $error_name;?></span><br />
		  <?php } ?>
		  </td>
	  </tr>

	  <tr>
		<td><?php echo $entry_attribute_group;?></td>
		<td><select name="attribute_group_id">
			<?php foreach((array)$attribute_groups as $attribute_group) {?>
			<?php if($attribute_group['attribute_group_id'] == $attribute_group_id) { ?>
			<option value="<?php echo $attribute_group['attribute_group_id'];?>" <?php if($attribute_group_id==$attribute_group['attribute_group_id']) { ?>selected="selected"<?php } ?>><?php echo $attribute_group['attribute_group_id'];?>：<?php echo $attribute_group['name'];?></option>
			 <?php } else { ?>
			<option value="<?php echo $attribute_group['attribute_group_id'];?>"><?php echo $attribute_group['attribute_group_id'];?>：<?php echo $attribute_group['name'];?></option>
		   <?php } ?>
			<?php } ?>
		  </select></td>
	  </tr>
	  
	  <!-- <tr>
		<td><?php echo $entry_type;?></td>
		<td>
		    <input type="text" name="atype" readonly="true" value="<?php echo $attribute_group_type;?>" />
		    
		</td>
	  </tr>
	  <tr>
	    <td></td>
		<td>
		    <input type="text" name="description"  readonly="true" value="<?php echo $attribute_group_description;?>" />
		   
		</td>
	  </tr>
	  
	  <tr>
	    <td></td>
		<td>
			<input type="text" name="text0"  readonly="true" value="<?php echo $attribute_group_text0;?>" />
	    </td>
	  </tr>
	  
	  <tr>
	    <td></td>
		<td>
		    <input type="text" name="text1"  readonly="true" value="<?php echo $attribute_group_text1;?>" />
		</td>
	  </tr> -->
	  
	  <tr> 
		<td><?php echo $entry_sort_order;?></td>
		<td><input type="text" name="sort_order" value="<?php echo $sort_order;?>" size="10" /></td>
	  </tr>
	  <input type='hidden' name='attribute_id' value="<?php echo $attribute_id;?>" />
	</table>
  </form>
  
<script type="text/javascript">
   var sel={ 
            getGroupDesc:function(){
				var id=$('select[name=attribute_group_id]').find("option:selected").val();
				$.ajax({
				    type:'POST',
				    url:'index.php?route=catalog/attribute_group/getAjaxGroup&token=<?php echo $token;?>',
					data:'agid='+id,
				    dataType:'json',
					success:function(json){
					    //$('input[name=atype]').val(json['type']);
						//$('input[name=description]').val(json['description']);
						//$('input[name=text0]').val(json['text0']);
						//$('input[name=text1]').val(json['text1']);
						
					   
					},
					error:function(){
					    alert('数据返回错误！');
					}
				});
			    
            }
        };
	$('select[name=attribute_group_id]').bind('change',sel.getGroupDesc);
</script>