<link rel="stylesheet" type="text/css" href="view/stylesheet/general.css">
<link rel="stylesheet" type="text/css" href="view/stylesheet/main.css">
<script type="text/javascript" src="view/javascript/jquery/jquery-1.7.1.min.js"></script><!--这里只能用1.7.1的版本,否则自带的图片处理有问题-->
<script type="text/javascript" src="view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
<link type="text/css" href="view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
<style type="text/css">
tr.over td {
	background:#cfeefe;
} 
</style>

 
    
    <h1><img src="view/image/product.png" alt="" /> <?php echo $heading_title;?>
        <span class="action-span">
	      <a href="<?php echo $insert;?>" ><?php echo $button_insert;?></a>
		 <!--  <a href="javascript:;" onclick="$('#form').prop('action', '<?php echo $copy;?>'); $('#form').submit();" ><?php echo $button_copy;?></a> -->
		  <a href="javascript:;" onclick="$('form').submit();" ><?php echo $button_delete;?></a>
		  <a href="<?php echo $refresh;?>"  ><?php echo $button_refresh;?></a>
	    </span>
    </h1>
    
	<div class="list-div" style="margin-bottom:10px;padding:3px;" >
	    <?php echo $column_id;?><input type="text" name="filter_id" value="<?php echo $filter_id;?>" size='10' />
	    <?php echo $column_name;?><input type="text" name="filter_name" value="<?php echo $filter_name;?>" size='30' />
	    <?php echo $column_model;?><input type="text" name="filter_model" value="<?php echo $filter_model;?>" size='12' />
	    <?php echo $column_price;?><input type="text" name="filter_price" value="<?php echo $filter_price;?>" size="8"/>
	    <?php echo $column_category;?><select name="filter_category_id" >
                  <option value="0">--无--</option>
                  <?php foreach((array)$categories as $category) {?>
                  <?php if($category['category_id'] == $filter_category_id) { ?>
                  <option value="<?php echo $category['category_id'];?>" selected="selected" ><?php echo $category['name'];?></option>
                  <?php } else { ?>
                  <option value="<?php echo $category['category_id'];?>"><?php echo $category['name'];?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
				<?php echo $column_sub_category;?><input type="checkbox" name="filter_sub_category" <?php if(!empty($filter_sub_category)) { ?>checked="checked" value="1" <?php } else { ?> value="0" <?php } ?>  />
	    <?php echo $column_status;?><select name="filter_status">
		  <option value="*"></option>
		  <?php if($filter_status) { ?>
		  <option value="1" selected="selected"><?php echo $text_enabled;?></option>
		   <?php } else { ?>
		  <option value="1"><?php echo $text_enabled;?></option>
		   <?php } ?>
		  <?php if(!is_null($filter_status) && !$filter_status) { ?>
		  <option value="0" selected="selected"><?php echo $text_disabled;?></option>
		   <?php } else { ?>
		  <option value="0"><?php echo $text_disabled;?></option>
		  <?php } ?>
		</select>
	    <input type="button" name="filter"   value="<?php echo $button_filter;?>" />
           
	
	</div>
	
    <div class="list-div" id="listDiv">
      <form action="<?php echo $delete;?>" method="post" enctype="multipart/form-data" id="form" onsubmit="return checkForm();">
        <table class="list">
          <thead>
            <tr>
              <td><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
              <td width="5%"><?php echo $column_image;?></td>
			  <td width="5%"><?php if($sort == 'p.product_id') { ?>
                <a href="javascript:void(0);" class="columnID" >ID</a> <!-- class="{strtolower(<?php echo $order;?>)}" -->
				<?php } else { ?>
                <a href="javascript:void(0);" class="columnID">ID</a>
                <?php } ?></td>
				
              <td><?php if($sort == 'pd.name') { ?>
                <a href="javascript:void(0);" class="columnName" ><?php echo $column_name;?></a> <!-- class="{strtolower(<?php echo $order;?>)}" -->
				<?php } else { ?>
                <a href="javascript:void(0);" class="columnName"><?php echo $column_name;?></a>
                <?php } ?></td>
              <td><?php if($sort == 'p.model') { ?>
                <a href="javascript:void(0);" class="columnModel"><?php echo $column_model;?></a>
                 <?php } else { ?>
                <a href="javascript:void(0);" class="columnModel"><?php echo $column_model;?></a>
                <?php } ?></td>
              <td><?php if($sort == 'p.price') { ?>
                <a href="javascript:void(0);" class="columnPrice"><?php echo $column_price;?></a>
                 <?php } else { ?>
                <a href="javascript:void(0);" class="columnPrice"><?php echo $column_price;?></a>
                <?php } ?></td>
              <td><?php if($sort == 'p.quantity') { ?>
                <a href="javascript:void(0);" class="columnQuantity"><?php echo $column_quantity;?></a>
                 <?php } else { ?>
                <a href="javascript:void(0);" class="columnQuantity"><?php echo $column_quantity;?></a>
               <?php } ?></td>
              <td><?php if($sort == 'p.status') { ?>
                <a href="javascript:void(0);" class="columnStatus"><?php echo $column_status;?></a>
                 <?php } else { ?>
                <a href="javascript:void(0);" class="columnStatus"><?php echo $column_status;?></a>
                <?php } ?></td>
              <td><?php echo $column_action;?></td>
            </tr>
          </thead>
          <tbody>
            
            <?php if($products) { ?>
				<?php foreach((array)$products as $product) {?>
				<tr>
				  <td style="text-align: center;"><?php if($product['selected']) { ?>
					<input type="checkbox" name="selected[]" value="<?php echo $product['product_id'];?>" checked="checked" />
					 <?php } else { ?>
					<input type="checkbox" name="selected[]" value="<?php echo $product['product_id'];?>" />
					<?php } ?></td>
				  <td><img src="<?php echo $product['image'];?>" alt="<?php echo $product['name'];?>" style="padding: 1px; border: 1px solid #DDDDDD;" /></td>
				  <td><a href="<?php echo $product['href'];?>" target="_blank"><?php echo $product['product_id'];?></a></td>
				  <td class='pname'><a href="<?php echo $product['href'];?>" target="_blank"><?php echo $product['name'];?></a></td>
				  <td><?php echo $product['model'];?></td>
				  <td><?php if($product['special']) { ?>
					<span style="text-decoration: line-through;"><?php echo $product['price'];?></span><br/>
					<span style="color: #b00;"><?php echo $product['special'];?></span>
					 <?php } else { ?>
					<?php echo $product['price'];?>
					<?php } ?></td>
				  <td><?php if($product['quantity'] <= 0) { ?>
					<span style="color: #FF0000;"><?php echo $product['quantity'];?></span>
					<?php } elseif ($product['quantity'] <= 5) { ?>
					<span style="color: #FFA500;"><?php echo $product['quantity'];?></span>
					 <?php } else { ?>
					<span style="color: #008000;"><?php echo $product['quantity'];?></span>
					<?php } ?></td>
				  <td><?php echo $product['status'];?></td>
				  <td><?php foreach((array)$product['action'] as $action) {?>
					<!-- <a href="javascript:;" onclick="parent.addTab('<?php echo $action['text'];?>商品','<?php echo $action['href'];?>')"><?php echo $action['text'];?></a> -->
					<a href="<?php echo $action['href'];?>"><?php echo $action['text'];?></a>
					<?php } ?></td>
				</tr>
				  <?php } ?>
             <?php } else { ?>
				<tr>
				  <td colspan="8"><?php echo $text_no_results;?></td>
				</tr>
            <?php } ?>
          </tbody>
        </table>
      </form>
      <?php echo $pagination;?>
    </div>


<script type="text/javascript">


$('input[name^=\'filter_\']').keydown(function(e) {  
	if (e.keyCode == 13) {
		$("input[name=filter]").trigger('click');
	}
});

$("input[name=filter]").bind('click',function(){

	url = 'index.php?route=catalog/product&token=<?php echo $token;?>';
	
	var filter_id = $('input[name=\'filter_id\']').attr('value');
	
	if (filter_id) {
		url += '&filter_id=' + encodeURIComponent(filter_id);
	}
	
	var filter_name = $('input[name=\'filter_name\']').attr('value');
	
	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}
	
	var filter_model = $('input[name=\'filter_model\']').attr('value');
	
	if (filter_model) {
		url += '&filter_model=' + encodeURIComponent(filter_model);
	}
	
	var filter_price = $('input[name=\'filter_price\']').attr('value');
	
	if (filter_price) {
		url += '&filter_price=' + encodeURIComponent(filter_price);
	}
	
	var filter_category_id = $('select[name=\'filter_category_id\']').attr('value');
	
	if (filter_category_id) {
		url += '&filter_category_id=' + encodeURIComponent(filter_category_id);
	}
	
	var filter_status = $('select[name=\'filter_status\']').attr('value');
	
	if (filter_status != '*') {
		url += '&filter_status=' + encodeURIComponent(filter_status);
	}	

	location = url;
});
</script> 

<script type="text/javascript"><!--
$('input[name=\'filter_name\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token;?>&filter_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.product_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('input[name=\'filter_name\']').val(ui.item.label);
						
		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});

$('input[name=\'filter_model\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token;?>&filter_model=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.model,
						value: item.product_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('input[name=\'filter_model\']').val(ui.item.label);
						
		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});
//--></script> 
<script type="text/javascript"><!--
$(function(){
	$(".list tr").mouseover(function(){
		$(this).addClass("over");
	}).mouseout(function(){
		$(this).removeClass("over");	
	})
	
	//链接到前台产品页面
	$(".pname").children('a').mouseenter(function(){
		var s=$(this).prop('href');
		var s_=s.replace(/admin\//,'')
		$(this).prop('href',s_);
    });
});


function checkForm(){
    var sum=0;
    $("input[name^='select']").each(function(i,n){
		if($(this).prop("checked")==true){
		   sum++;
		}
  
    });
  
    if(sum<1) {
       alert("请选择要删除的项！");
	   return false;
    }

};

$('.list-div input[type=\'text\']').keydown(function(e) {
	if (e.keyCode == 13) {
		$('.list-div a').trigger('click');
	}
});

//点击排序
$(".columnID").click(function(){
    var url='index.php'+location.search;
    if(url.length>0){
	    if(url.search(/sort=[\w\.]*/i)==-1){
		    url=url+'&sort=p.product_id';
		}else{
		    url=url.replace(/sort=[\w\.]*/i,'sort=p.product_id');
		}
		
	    if(url.search(/order=\w*/i)==-1){
		    url=url+'&order=asc';
		}else if (url.search(/order=desc/i)>0){
		    url=url.replace(/order=desc/i,'order=ASC');
		}else if (url.search(/order=asc/i)>0){
		    url=url.replace(/order=asc/i,'order=DESC');
		}
	    
	}
    
	location=url;
	
});

$(".columnName").click(function(){
    var url='index.php'+location.search;
    if(url.length>0){
	    if(url.search(/sort=[\w\.]*/i)==-1){
		    url=url+'&sort=pd.name';
		}else{
		    url=url.replace(/sort=[\w\.]*/i,'sort=pd.name');
		}
		
	    if(url.search(/order=\w*/i)==-1){
		    url=url+'&order=asc';
		}else if (url.search(/order=desc/i)>0){
		    url=url.replace(/order=desc/i,'order=ASC');
		}else if (url.search(/order=asc/i)>0){
		    url=url.replace(/order=asc/i,'order=DESC');
		}
	    
	}
    
	location=url;
	
});

$(".columnModel").click(function(){
    var url='index.php'+location.search;
    if(url.length>0){
	    if(url.search(/sort=[\w\.]*/i)==-1){
		    url=url+'&sort=p.model';
		}else{
		    url=url.replace(/sort=[\w\.]*/i,'sort=p.model');
		}
		
	    if(url.search(/order=\w*/i)==-1){
		    url=url+'&order=asc';
		}else if (url.search(/order=desc/i)>0){
		    url=url.replace(/order=desc/i,'order=ASC');
		}else if (url.search(/order=asc/i)>0){
		    url=url.replace(/order=asc/i,'order=DESC');
		}
	    
	}
	location=url;
	
});

$(".columnPrice").click(function(){
    var url='index.php'+location.search;
    if(url.length>0){
	    if(url.search(/sort=[\w\.]*/i)==-1){
		    url=url+'&sort=p.price';
		}else{
		    url=url.replace(/sort=[\w\.]*/i,'sort=p.price');
		}
		
	    if(url.search(/order=\w*/i)==-1){
		    url=url+'&order=asc';
		}else if (url.search(/order=desc/i)>0){
		    url=url.replace(/order=desc/i,'order=ASC');
		}else if (url.search(/order=asc/i)>0){
		    url=url.replace(/order=asc/i,'order=DESC');
		}
	    
	}
	location=url;
	
});


$(".columnQuantity").click(function(){
    var url='index.php'+location.search;
    if(url.length>0){
	    if(url.search(/sort=[\w\.]*/i)==-1){
		    url=url+'&sort=p.quantity';
		}else{
		    url=url.replace(/sort=[\w\.]*/i,'sort=p.quantity');
		}
		
	    if(url.search(/order=\w*/i)==-1){
		    url=url+'&order=asc';
		}else if (url.search(/order=desc/i)>0){
		    url=url.replace(/order=desc/i,'order=ASC');
		}else if (url.search(/order=asc/i)>0){
		    url=url.replace(/order=asc/i,'order=DESC');
		}
	    
	}
	location=url;
	
});


$(".columnStatus").click(function(){
    var url='index.php'+location.search;
    if(url.length>0){
	    if(url.search(/sort=[\w\.]*/i)==-1){
		    url=url+'&sort=p.status';
		}else{
		    url=url.replace(/sort=[\w\.]*/i,'sort=p.status');
		}
		
	    if(url.search(/order=\w*/i)==-1){
		    url=url+'&order=asc';
		}else if (url.search(/order=desc/i)>0){
		    url=url.replace(/order=desc/i,'order=ASC');
		}else if (url.search(/order=asc/i)>0){
		    url=url.replace(/order=asc/i,'order=DESC');
		}
	    
	}
	location=url;
	
});

//--></script>
