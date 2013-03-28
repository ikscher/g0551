<link rel="stylesheet" type="text/css" href="view/stylesheet/general.css">
<link rel="stylesheet" type="text/css" href="view/stylesheet/main.css">
<script type="text/javascript" src="view/javascript/jquery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="view/javascript/jquery/tabs.js"></script> 

<!--这里只能用1.7.1的版本,否则自带的图片处理有问题-->
<!-- <script type="text/javascript" src="view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
<link type="text/css" href="view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
 -->
    <h1><img src="view/image/user-group.png" alt="" /> <?php echo $heading_title;?>
        <span class="action-span">
		    <a href="<?php echo $cancel;?>" class="button"><?php echo $button_cancel;?></a>
			<a href="javascript:;" onclick="$('#form').submit();" class="button"><?php echo $button_save;?></a>
		</span>
    </h1>
	
    <div class="list-div" id="listDiv">
	    <div id="tabs" class="htabs">
	       <a href="#tab-access"><?php echo $tab_access;?></a>
		   <a href="#tab-modify"><?php echo $tab_modify;?></a>
		</div>
		
        <form action="<?php echo $action;?>" method="post" enctype="multipart/form-data" id="form">
	        
			<div id="tab-access">
				<table class="form">
				    <tr>
						<td width="18%"><span class="required">*</span> <?php echo $entry_name;?></td>
						<td><input type="text" name="name" value="<?php echo $name;?>" />
						  <?php if($error_name) { ?>
						  <span class="error"><?php echo $error_name;?></span>
						  <?php } ?></td>
				    </tr>
				
				    <tr>
						<td><?php echo $entry_access;?></td>
						<td>
							<!-- <div class="scrollbox"> -->
							<?php foreach((array)$allActions as $a) {?>
								<div  style="width:220px;float:left;">
								  <?php if(in_array($a, $access)) { ?>
								  <label for="<?php echo $a;?>_access"><input type="checkbox" id="<?php echo $a;?>_access" name="permission[access][]" value="<?php echo $a;?>" checked="checked" />
								  <?php echo $a;?>
								   <?php } else { ?>
								  <label for="<?php echo $a;?>_access"><input type="checkbox"  id="<?php echo $a;?>_access" name="permission[access][]" value="<?php echo $a;?>" />
								  <?php echo $a;?>
								 <?php } ?>
								</div>
							<?php } ?>
						</td>
							 <!-- </div> -->
					</tr>
					<tr>
					    <td colspan="2" style="text-align:center" ><input type="checkbox" name="checkAccess" value="checked" class="checkAccess" onclick="javascript:access();" /><?php echo $text_select_all;?></td>
					</tr>
				</table>
			</div>
			
			<div id="tab-modify">
			    <table class="form">
				  <tr>
					<td width="18%"><?php echo $entry_modify;?></td>
					<td>
					    <!-- <div class="scrollbox"> -->
						<?php foreach((array)$allActions as $a) {?>
							<div style="width:220px;float:left;">
							  <?php if(in_array($a, $modify)) { ?>
							  <label for="<?php echo $a;?>_modify"><input type="checkbox" name="permission[modify][]" id="<?php echo $a;?>_modify" value="<?php echo $a;?>" checked="checked" />
							  <?php echo $a;?>
							   <?php } else { ?>
							  <label for="<?php echo $a;?>_modify"><input type="checkbox" name="permission[modify][]" id="<?php echo $a;?>_modify" value="<?php echo $a;?>" />
							  <?php echo $a;?>
							 <?php } ?>
							</div>
					    <?php } ?>
					    <!-- </div> -->
					</td>
				 </tr>
				 <tr>
				    <td colspan="2" style="text-align:center"><input type="checkbox" name="checkModify" value="checked" class="checkModify" onclick="javascript:modify();"  /><?php echo $text_select_all;?></td>
				 
				 </tr>
			    </table>
			</div>
        </form>
    </div>
	
<script type="text/javascript"><!--
$('#tabs a').tabpages(); 

function access(){
	var check = $(".checkAccess").prop('checked');
	
	if(check){
		$("#tab-access :checkbox").prop('checked','checked');
	}else{
		$("#tab-access :checkbox").prop('checked','');
	}
}

function modify(){
	var check = $(".checkModify").prop('checked');
	if(check){
		$("#tab-modify :checkbox").prop('checked','checked');
	}else{
		$("#tab-modify :checkbox").prop('checked','');
	}

}

//--></script> 