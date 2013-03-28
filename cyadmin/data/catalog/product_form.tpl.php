<link rel="stylesheet" type="text/css" href="view/stylesheet/general.css">
<link rel="stylesheet" type="text/css" href="view/stylesheet/main.css">

<script type="text/javascript" src="view/javascript/jquery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
<link type="text/css" href="view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
<script type="text/javascript" src="view/javascript/jquery/tabs.js"></script> 

<style>
.ui-autocomplete {
    max-height: 200px;
    overflow-y: auto;
    <!-- /* prevent horizontal scrollbar */ -->
    overflow-x: hidden;
   <!--  /* add padding to account for vertical scrollbar */ -->
    padding-right: 20px;
}
<!-- /* IE 6 doesn't support max-height
 * we use height instead, but this forces the menu to always be this tall
 */ -->
 html .ui-autocomplete {
    height: 200px;
}


</style>

	
	
    <h1><img src="view/image/product.png" alt="" /> <?php echo $heading_title;?>
        <span class="action-span">
	      <a href="javascript:;"  onclick="$('#form').submit();" ><?php echo $button_save;?></a>
	      <a href="<?php echo $refresh;?>"><?php echo $button_refresh;?></a>
		  <a href="<?php echo $cancel;?>"><?php echo $button_cancel;?></a>
	    </span>
    </h1>
   <?php if($error_warning) { ?>
      <div class="warning"><?php echo $error_warning;?></div>
   <?php } ?>
   <?php if($success) { ?>
      <div class="success"><?php echo $success;?></div>
   <?php } ?> 
    <div class="list-div" id="listDiv">
      <div id="tabs" class="htabs">
	       <a href="#tab-general"><?php echo $tab_general;?></a>
		   <a href="#tab-data"><?php echo $tab_data;?></a>
		   <a href="#tab-links"><?php echo $tab_links;?></a>
		   <!-- <a href="#tab-attribute"><?php echo $tab_attribute;?></a> -->
		   <a href="#tab-option"><?php echo $tab_attribute;?><?php echo $tab_option;?></a>
		   <a href="#tab-discount"><?php echo $tab_discount;?></a>
		   <a href="#tab-special"><?php echo $tab_special;?></a>
		   <a href="#tab-image"><?php echo $tab_image;?></a>
		   <a href="#tab-reward"><?php echo $tab_reward;?></a>
		   <!-- <a href="#tab-design"><?php echo $tab_design;?></a> -->
	  </div>
      <form action="<?php echo $action;?>" method="post" enctype="multipart/form-data" id="form">
	     
		<!--编辑项目-->
        <div id="tab-general">
            <table class="form">
			
              <tr>
                <td><span class="required">*</span> <?php echo $entry_name;?></td>
                <td><input type="text" name="product_description[name]" size="100" value="<?php if(isset($product_description['name'])) { ?><?php echo $product_description['name'];?><?php } ?>" />
                  <!-- <?php if(isset($error_name)) { ?>
                  <span class="error"><?php echo $error_name?></span>
                  <?php } ?></td> -->
              </tr>
              <tr>
                <td><?php echo $entry_meta_description;?></td>
                <td><textarea name="product_description[meta_description]" cols="40" rows="5"><?php if(isset($product_description['meta_description'])) { ?> <?php echo $product_description['meta_description'];?> <?php } ?></textarea></td>
              </tr>
              <tr>
                <td><?php echo $entry_meta_keyword;?></td>
                <td><textarea name="product_description[meta_keyword]" cols="40" rows="5"><?php if(isset($product_description['meta_keyword'])) { ?> <?php echo $product_description['meta_keyword'];?> <?php } ?></textarea></td>
              </tr>
              <tr>
                <td><?php echo $entry_description;?></td>
                <td><textarea name="product_description[description]" cols="140" rows="10"  id="descriptions"><?php if(isset($product_description['description'])) { ?> <?php echo $product_description['description'];?> <?php } ?></textarea></td>
              </tr>
              <tr>
                <td><?php echo $entry_tag;?></td>
                <td><input type="text" name="product_description[tag]" value="<?php if(isset($product_description['tag'])) { ?> <?php echo $product_description['tag'];?> <?php } ?>" size="80" /></td>
              </tr>
            </table>
         </div>
      
        <!--基本信息-->
        <div id="tab-data">
          <table class="form">
            <tr>
              <td><span class="required">*</span> <?php echo $entry_model;?></td>
              <td><input type="text" name="model" value="<?php echo $model;?>" />
                <?php if($error_model) { ?>
                <span class="error"><?php echo $error_model;?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><?php echo $entry_sku;?></td>
              <td><input type="text" name="sku" value="<?php echo $sku;?>" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_upc;?></td>
              <td><input type="text" name="upc" value="<?php echo $upc;?>" /></td>
            </tr>
           
            <tr>
              <td><?php echo $entry_location;?></td>
              <td><input type="text" name="location" value="<?php echo $location;?>" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_price;?></td>
              <td><input type="text" name="price" value="<?php echo $price;?>" /></td>
            </tr>
			
			
    
            <tr>
              <td><?php echo $entry_quantity;?></td>
              <td><input type="text" name="quantity" value="<?php echo $quantity;?>"  /></td>
            </tr>
            <tr>
              <td><?php echo $entry_minimum;?></td>
              <td><input type="text" name="minimum" value="<?php echo $minimum;?>" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_subtract;?></td>
              <td><select name="subtract">
                  <?php if($subtract) { ?>
                  <option value="1" selected="selected"><?php echo $text_yes;?></option>
                  <option value="0"><?php echo $text_no;?></option>
                   <?php } else { ?>
                  <option value="1"><?php echo $text_yes;?></option>
                  <option value="0" selected="selected"><?php echo $text_no;?></option>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_stock_status;?></td>
              <td><select name="stock_status_id">
                  <?php foreach((array)$stock_statuses as $stock_status) {?>
                  <?php if($stock_status['stock_status_id'] == $stock_status_id) { ?>
                  <option value="<?php echo $stock_status['stock_status_id'];?>" selected="selected"><?php echo $stock_status['name'];?></option>
                   <?php } else { ?>
                  <option value="<?php echo $stock_status['stock_status_id'];?>"><?php echo $stock_status['name'];?></option>
                 <?php } ?>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_shipping;?></td>
              <td><?php if($shipping) { ?>
                <input type="radio" name="shipping" value="1" checked="checked" />
                <?php echo $text_yes;?>
                <input type="radio" name="shipping" value="0" />
                <?php echo $text_no;?>
                 <?php } else { ?>
                <input type="radio" name="shipping" value="1" />
                <?php echo $text_yes;?>
                <input type="radio" name="shipping" value="0" checked="checked" />
                <?php echo $text_no;?>
                <?php } ?></td>
            </tr>
            <tr>
              <td><?php echo $entry_keyword;?></td>
              <td><input type="text" name="keyword" value="<?php echo $keyword;?>" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_image;?></td>
              <td><div class="image"><img src="<?php echo $thumb;?>" alt="" id="thumb" /><br />
                  <input type="hidden" name="image" value="<?php echo $image;?>" id="image" />
                  <a href="javascript:;" onclick="image_upload('image', 'thumb');"><?php echo $text_browse;?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a  href="javascript:;" onclick="$('#thumb').attr('src', '<?php echo $no_image;?>'); $('#image').attr('value', '');"><?php echo $text_clear;?></a></div></td>
            </tr>
            <tr>
              <td><?php echo $entry_date_available;?></td>
              <td><input type="text" name="date_available" value="<?php echo $date_available;?>" size="12" class="date" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_dimension;?></td>
              <td><input type="text" name="length" value="<?php echo $length;?>" size="10" />
                <input type="text" name="width" value="<?php echo $width;?>" size="10" />
                <input type="text" name="height" value="<?php echo $height;?>" size="10" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_length;?></td>
              <td><select name="length_class_id">
                  <?php foreach((array)$length_classes as $length_class) {?>
                  <?php if($length_class['length_class_id'] == $length_class_id) { ?>
                  <option value="<?php echo $length_class['length_class_id'];?>" selected="selected"><?php echo $length_class['title'];?></option>
                   <?php } else { ?>
                  <option value="<?php echo $length_class['length_class_id'];?>"><?php echo $length_class['title'];?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_weight;?></td>
              <td><input type="text" name="weight" value="<?php echo $weight;?>" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_weight_class;?></td>
              <td><select name="weight_class_id">
                  <?php foreach((array)$weight_classes as $weight_class) {?>
                  <?php if($weight_class['weight_class_id'] == $weight_class_id) { ?>
                  <option value="<?php echo $weight_class['weight_class_id'];?>" selected="selected"><?php echo $weight_class['title'];?></option>
                   <?php } else { ?>
                  <option value="<?php echo $weight_class['weight_class_id'];?>"><?php echo $weight_class['title'];?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_status;?></td>
              <td><select name="status">
                  <?php if($status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled;?></option>
                  <option value="0"><?php echo $text_disabled;?></option>
                   <?php } else { ?>
                  <option value="1"><?php echo $text_enabled;?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled;?></option>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_sort_order;?></td>
              <td><input type="text" name="sort_order" value="<?php echo $sort_order;?>" size="2" /></td>
            </tr>
          </table>
        </div>
		
		<!--关联-->
        <div id="tab-links">
          <table class="form">
            <tr>
              <td><?php echo $entry_manufacturer;?></td>
              <td><select name="manufacturer_id">
                  <option value="0" selected="selected"><?php echo $text_none;?></option>
                  <?php foreach((array)$manufacturers as $manufacturer) {?>
                  <?php if($manufacturer['manufacturer_id'] == $manufacturer_id) { ?>
                  <option value="<?php echo $manufacturer['manufacturer_id'];?>" selected="selected"><?php echo $manufacturer['name'];?></option>
                   <?php } else { ?>
                  <option value="<?php echo $manufacturer['manufacturer_id'];?>"><?php echo $manufacturer['name'];?></option>
                 <?php } ?>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_category;?></td>
              <!-- <td><div class="scrollbox">
                  <?php foreach((array)$categories as $category) {?>
				  <div>
				    <label>
                    <?php if(in_array($category['category_id'], $product_category)) { ?>
                    <input type="checkbox" name="product_category[]" value="<?php echo $category['category_id'];?>" checked="checked" />
                    <?php echo $category['name'];?></label>
                     <?php } else { ?>
                    <label><input type="checkbox"  name="product_category[]" value="<?php echo $category['category_id'];?>" />
                    <?php echo $category['name'];?>
                    <?php } ?>
					</label>
                  </div>
                  <?php } ?>
                </div>
				</td> -->
				<td>
				    <?php foreach((array)$category_dir as $k=>$dir) {?>
				    <select name="product_category[]" class="<?php if($k==0) { ?>one<?php } elseif ($k==1) { ?>two<?php } elseif ($k==2) { ?>three<?php } elseif ($k==3) { ?>four<?php } ?>d">
					<option value=''>--请选择--</option>
						<?php foreach((array)$dir as $v) {?>
								<option value="<?php echo $v['id'];?>" <?php if(in_array($v['id'],$product_category)) { ?>selected="selected"<?php } ?>><?php echo $v['id'];?>：<?php echo $v['name'];?></option>
						<?php }?>
					</select>
                    <?php } ?>
					
				</td>
            </tr>
            <tr>
              <td><?php echo $entry_store;?></td>
              <td><div class="scrollbox">
                  
                 <!--  <div>
                    <?php if(in_array(0, $product_store)) { ?>
                    <input type="radio" name="product_store[]" value="0" checked="checked" />
                    <?php echo $text_default;?>
                     <?php } else { ?>
                    <input type="radio" name="product_store[]" value="0" />
                    <?php echo $text_default;?>
                    <?php } ?>
                  </div> -->
				  
                  <?php foreach((array)$stores as $store) {?>
                  <div>
				    
                    <?php if(in_array($store['store_id'], $product_store)) { ?>
                    <label><input type="radio"  name="product_store" value="<?php echo $store['store_id'];?>" checked="checked" />
                    <?php echo $store['name'];?></label>
                     <?php } else { ?>
                    <label><input type="radio"  name="product_store" value="<?php echo $store['store_id'];?>" />
                    <?php echo $store['name'];?></label>
                    <?php } ?>
					
                  </div>
                  <?php } ?>
                </div></td>
            </tr>
            <tr>
              <td><?php echo $entry_download;?></td>
              <td><div class="scrollbox">
                  <?php $class = 'odd'?>
                  <?php foreach((array)$downloads as $download) {?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even')?>
                  <div class="<?php echo $class;?>">
                    <?php if(in_array($download['download_id'], $product_download)) { ?>
                    <input type="checkbox" name="product_download[]" value="<?php echo $download['download_id'];?>" checked="checked" />
                    <?php echo $download['name'];?>
                     <?php } else { ?>
                    <input type="checkbox" name="product_download[]" value="<?php echo $download['download_id'];?>" />
                    <?php echo $download['name'];?>
                    <?php } ?>
                  </div>
                 <?php } ?>
                </div></td>
            </tr>
            <tr>
              <td><?php echo $entry_related;?></td>
              <td><input type="text" name="related" value="" /></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><div id="product-related" class="scrollbox">
                  <?php $class = 'odd'?>
                  <?php foreach((array)$product_related as $product_related) {?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even')?>
                  <div id="product-related<?php echo $product_related['product_id'];?>" class="<?php echo $class;?>"> <?php echo $product_related['name'];?><img src="view/image/delete.png" />
                    <input type="hidden" name="product_related[]" value="<?php echo $product_related['product_id'];?>" />
                  </div>
                 <?php } ?>
                </div></td>
            </tr>
          </table>
        </div>
		
		<!--属性-->
        <!-- <div id="tab-attribute">
          <table id="attribute" class="list">
            <thead>
              <tr>
                <td><?php echo $entry_attribute;?></td>
                <td><?php echo $entry_text;?></td>
                <td></td>
              </tr>
            </thead>
            <?php $attribute_row = 0?>
            <?php foreach((array)$product_attributes as $product_attribute) {?>
            <tbody id="attribute-row<?php echo $attribute_row;?>">
              <tr>
                <td><?php echo $product_attribute['attribute_group']['name'];?>：
				    <input type="text" name="product_attribute[<?php echo $attribute_row;?>][name]" value="<?php echo $product_attribute['name'];?>" />
                    <input type="hidden" name="product_attribute[<?php echo $attribute_row;?>][attribute_id]" value="<?php echo $product_attribute['attribute_id'];?>" />
				</td>
				
                <td>
                     <textarea name="product_attribute[<?php echo $attribute_row;?>][text]" cols="40" rows="5"><?php if(isset($product_attribute['text'])) { ?> <?php echo $product_attribute['text'];?><?php } ?></textarea>
                </td>
                <td><a href="javascript:;" onclick="$('#attribute-row<?php echo $attribute_row;?>').remove();" ><?php echo $button_remove;?></a></td>
              </tr>
            </tbody>
            <?php $attribute_row++?>
            <?php } ?>
            <tfoot>
              <tr>
                <td colspan="2"></td>
                <td><a  href="javascript:;" onclick="addAttribute();" ><?php echo $button_add_attribute;?></a></td>
              </tr>
            </tfoot>
          </table>
        </div> -->
		
		
		<!--选项设置-->
        <div id="tab-option">
          <div id="vtab-option" class="vtabs">
		    <select name="atrributeGroups">
				<?php if($attributeGroups) { ?>
				<?php foreach((array)$attributeGroups as $ag) {?>
				    <option value="<?php echo $ag['attribute_group_id'];?>" ><?php echo $ag['name'];?></option>
				<?php } ?>
				<?php } ?>
			</select>
            <?php $option_row = 0?>
            <?php foreach((array)$product_options as $product_option) {?>
            <a href="#tab-option-<?php echo $option_row;?>" id="option-<?php echo $option_row;?>"><?php if(isset($product_option['attribute_group_name'])) { ?><?php echo $product_option['attribute_group_name'];?><?php } ?>(<?php echo $product_option['name'];?>)&nbsp;<img src="view/image/delete.png" alt=""  onclick="$('#vtabs a:first').trigger('click'); $('#option-<?php echo $option_row;?>').remove(); $('#tab-option-<?php echo $option_row;?>').remove(); return false;" /></a>
            <?php $option_row++?>
            <?php } ?>
            <!-- <span id="option-add">
            <input name="option" value="" style="width: 130px;" />
            &nbsp;<img src="view/image/add.png" alt="<?php echo $button_add_option;?>" title="<?php echo $button_add_option;?>" /></span> -->
			<input type="button" name="addOptions" value="添加属性选项" />
			</div>
          <?php $option_row = 0?>
          <?php $option_value_row = 0?>
          <?php foreach((array)$product_options as $product_option) {?>
          <div id="tab-option-<?php echo $option_row;?>" class="vtabs-content">
            <input type="hidden" name="product_option[<?php echo $option_row;?>][product_option_id]" value="<?php echo $product_option['product_option_id'];?>" />
            <input type="hidden" name="product_option[<?php echo $option_row;?>][name]" value="<?php echo $product_option['name'];?>" />
			<input type="hidden" name="product_option[<?php echo $option_row;?>][attribute_group_id]" value="<?php echo $product_option['attribute_group_id'];?>" />
            <input type="hidden" name="product_option[<?php echo $option_row;?>][option_id]" value="<?php echo $product_option['option_id'];?>" />
            <input type="hidden" name="product_option[<?php echo $option_row;?>][type]" value="<?php echo $product_option['type'];?>" />
            <table class="form">
              <tr>
                <td><?php echo $entry_required;?></td>
                <td><select name="product_option[<?php echo $option_row;?>][required]">
                    <?php if($product_option['required']) { ?>
                    <option value="1" selected="selected"><?php echo $text_yes;?></option>
                    <option value="0"><?php echo $text_no;?></option>
                     <?php } else { ?>
                    <option value="1"><?php echo $text_yes;?></option>
                    <option value="0" selected="selected"><?php echo $text_no;?></option>
                     <?php } ?>
                  </select></td>
              </tr>
			
			 
              <?php if($product_option['type'] == 'text') { ?>
              <tr>
                <td><?php echo $entry_option_value;?></td>
                <td><input type="text" name="product_option[<?php echo $option_row;?>][option_value]" value="<?php echo $product_option['option_value'];?>" /></td>
              </tr>
              <?php } ?>
              <?php if($product_option['type'] == 'textarea') { ?>
              <tr>
                <td><?php echo $entry_option_value;?></td>
                <td><textarea name="product_option[<?php echo $option_row;?>][option_value]" cols="40" rows="5"><?php echo $product_option['option_value'];?></textarea></td>
              </tr>
              <?php } ?>
              <?php if($product_option['type'] == 'file') { ?>
              <tr style="display: none;">
                <td><?php echo $entry_option_value;?></td>
                <td><input type="text" name="product_option[<?php echo $option_row;?>][option_value]" value="<?php echo $product_option['option_value'];?>" /></td>
              </tr>
              <?php } ?>
              <?php if($product_option['type'] == 'date') { ?>
              <tr>
                <td><?php echo $entry_option_value;?></td>
                <td><input type="text" name="product_option[<?php echo $option_row;?>][option_value]" value="<?php echo $product_option['option_value'];?>" class="date" /></td>
              </tr>
              <?php } ?>
              <?php if($product_option['type'] == 'datetime') { ?>
              <tr>
                <td><?php echo $entry_option_value;?></td>
                <td><input type="text" name="product_option[<?php echo $option_row;?>][option_value]" value="<?php echo $product_option['option_value'];?>" class="datetime" /></td>
              </tr>
              <?php } ?>
              <?php if($product_option['type'] == 'time') { ?>
              <tr>
                <td><?php echo $entry_option_value;?></td>
                <td><input type="text" name="product_option[<?php echo $option_row;?>][option_value]" value="<?php echo $product_option['option_value'];?>" class="time" /></td>
              </tr>
             <?php } ?>
            </table>
            <?php if($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') { ?>
            <table id="option-value<?php echo $option_row;?>" class="list">
              <thead>
                <tr>
				  <!-- <td><?php echo $entry_attribute_group;?></td> -->
                  <td><?php echo $entry_option_value;?></td>
                  <td><?php echo $entry_quantity;?></td>
                  <td><?php echo $entry_subtract;?></td>
                  <td><?php echo $entry_price;?></td>
                  <td><?php echo $entry_option_points;?></td>
                  <td><?php echo $entry_weight;?></td>
                  <td></td>
                </tr>
              </thead>
              <?php foreach((array)$product_option['product_option_value'] as $product_option_value) {?>
              <tbody id="option-value-row<?php echo $option_value_row;?>">
                <tr>
				  
                  <td><select name="product_option[<?php echo $option_row;?>][product_option_value][<?php echo $option_value_row;?>][option_value_id]">
                      <?php if(isset($option_values[$product_option['option_id']])) { ?>
                      <?php foreach((array)$option_values[$product_option['option_id']] as $option_value) {?>
                      <?php if($option_value['option_value_id'] == $product_option_value['option_value_id']) { ?>
                      <option value="<?php echo $option_value['option_value_id'];?>,<?php echo $option_value['attribute_id'];?>" selected="selected"><?php echo $option_value['name'];?></option>
                       <?php } else { ?>
                      <option value="<?php echo $option_value['option_value_id'];?>,<?php echo $option_value['attribute_id'];?>"><?php echo $option_value['name'];?></option>
                      <?php } ?>
                      <?php } ?>
                      <?php } ?>
                    </select>
					<input type="hidden" name="product_option[<?php echo $option_row;?>][product_option_value][<?php echo $option_value_row;?>][attribute_id]" value="<?php echo $product_option_value['attribute_id'];?>" />
                    <input type="hidden" name="product_option[<?php echo $option_row;?>][product_option_value][<?php echo $option_value_row;?>][product_option_value_id]" value="<?php echo $product_option_value['product_option_value_id'];?>" />
				  </td>
                  <td><input type="text" name="product_option[<?php echo $option_row;?>][product_option_value][<?php echo $option_value_row;?>][quantity]" value="<?php echo $product_option_value['quantity'];?>" size="3" /></td>
                  <td><select name="product_option[<?php echo $option_row;?>][product_option_value][<?php echo $option_value_row;?>][subtract]">
                      <?php if($product_option_value['subtract']) { ?>
                      <option value="1" selected="selected"><?php echo $text_yes;?></option>
                      <option value="0"><?php echo $text_no;?></option>
                       <?php } else { ?>
                      <option value="1"><?php echo $text_yes;?></option>
                      <option value="0" selected="selected"><?php echo $text_no;?></option>
                      <?php } ?>
                    </select></td>
                  <td><select name="product_option[<?php echo $option_row;?>][product_option_value][<?php echo $option_value_row;?>][price_prefix]">
                      <?php if($product_option_value['price_prefix'] == '+') { ?>
                      <option value="+" selected="selected">+</option>
                       <?php } else { ?>
                      <option value="+">+</option>
                     <?php } ?>
                      <?php if($product_option_value['price_prefix'] == '-') { ?>
                      <option value="-" selected="selected">-</option>
                       <?php } else { ?>
                      <option value="-">-</option>
                      <?php } ?>
                    </select>
                    <input type="text" name="product_option[<?php echo $option_row;?>][product_option_value][<?php echo $option_value_row;?>][price]" value="<?php echo $product_option_value['price'];?>" size="5" /></td>
                  <td><select name="product_option[<?php echo $option_row;?>][product_option_value][<?php echo $option_value_row;?>][points_prefix]">
                      <?php if($product_option_value['points_prefix'] == '+') { ?>
                      <option value="+" selected="selected">+</option>
                       <?php } else { ?>
                      <option value="+">+</option>
                      <?php } ?>
                      <?php if($product_option_value['points_prefix'] == '-') { ?>
                      <option value="-" selected="selected">-</option>
                       <?php } else { ?>
                      <option value="-">-</option>
                      <?php } ?>
                    </select>
                    <input type="text" name="product_option[<?php echo $option_row;?>][product_option_value][<?php echo $option_value_row;?>][points]" value="<?php echo $product_option_value['points'];?>" size="5" /></td>
                  <td><select name="product_option[<?php echo $option_row;?>][product_option_value][<?php echo $option_value_row;?>][weight_prefix]">
                      <?php if($product_option_value['weight_prefix'] == '+') { ?>
                      <option value="+" selected="selected">+</option>
                       <?php } else { ?>
                      <option value="+">+</option>
                      <?php } ?>
                      <?php if($product_option_value['weight_prefix'] == '-') { ?>
                      <option value="-" selected="selected">-</option>
                       <?php } else { ?>
                      <option value="-">-</option>
                      <?php } ?>
                    </select>
                    <input type="text" name="product_option[<?php echo $option_row;?>][product_option_value][<?php echo $option_value_row;?>][weight]" value="<?php echo $product_option_value['weight'];?>" size="5" /></td>
                  <td><a href="javascript:;" onclick="$('#option-value-row<?php echo $option_value_row;?>').remove();" class="button"><?php echo $button_remove;?></a></td>
                </tr>
              </tbody>
              <?php $option_value_row++?>
              <?php } ?>
              <tfoot>
                <tr>
                  <td colspan="6"></td>
                  <td><a href="javacript:;" onclick="addOptionValue('<?php echo $option_row;?>');" class="button"><?php echo $button_add_option_value;?></a></td>
                </tr>
              </tfoot>
            </table>
            <select id="option-values<?php echo $option_row;?>" style="display: none;">
              <?php if(isset($option_values[$product_option['option_id']])) { ?>
              <?php foreach((array)$option_values[$product_option['option_id']] as $option_value) {?>
              <option value="<?php echo $option_value['option_value_id'];?>,<?php echo $option_value['attribute_id'];?>"><?php echo $option_value['name'];?></option>
              <?php } ?>
             <?php } ?>
            </select>
           <?php } ?>
          </div>
          <?php $option_row++?>
          <?php } ?>
        </div>
		
		
		
        <div id="tab-discount">
          <table id="discount" class="list">
            <thead>
              <tr>
                <td><?php echo $entry_customer_group;?></td>
                <td><?php echo $entry_quantity;?></td>
                <td><?php echo $entry_priority;?></td>
                <td><?php echo $entry_price;?></td>
                <td><?php echo $entry_date_start;?></td>
                <td><?php echo $entry_date_end;?></td>
                <td></td>
              </tr>
            </thead>
            <?php $discount_row = 0?>
            <?php foreach((array)$product_discounts as $product_discount) {?>
            <tbody id="discount-row<?php echo $discount_row;?>">
              <tr>
                <td><select name="product_discount[<?php echo $discount_row;?>][customer_group_id]">
                    <?php foreach((array)$customer_groups as $customer_group) {?>
                    <?php if($customer_group['customer_group_id'] == $product_discount['customer_group_id']) { ?>
                    <option value="<?php echo $customer_group['customer_group_id'];?>" selected="selected"><?php echo $customer_group['name'];?></option>
                     <?php } else { ?>
                    <option value="<?php echo $customer_group['customer_group_id'];?>"><?php echo $customer_group['name'];?></option>
                    <?php } ?>
                    <?php } ?>
                  </select></td>
                <td><input type="text" name="product_discount[<?php echo $discount_row;?>][quantity]" value="<?php echo $product_discount['quantity'];?>" size="5" /></td>
                <td><input type="text" name="product_discount[<?php echo $discount_row;?>][priority]" value="<?php echo $product_discount['priority'];?>" size="5" /></td>
                <td><input type="text" name="product_discount[<?php echo $discount_row;?>][price]" value="<?php echo $product_discount['price'];?>" /></td>
                <td><input type="text" name="product_discount[<?php echo $discount_row;?>][date_start]" value="<?php echo $product_discount['date_start'];?>" class="date" /></td>
                <td><input type="text" name="product_discount[<?php echo $discount_row;?>][date_end]" value="<?php echo $product_discount['date_end'];?>" class="date" /></td>
                <td><a href="javascript:;" onclick="$('#discount-row<?php echo $discount_row;?>').remove();"><?php echo $button_remove;?></a></td>
              </tr>
            </tbody>
            <?php $discount_row++?>
            <?php } ?>
            <tfoot>
              <tr>
                <td colspan="6"></td>
                <td><a href="javascirpt:;" onclick="addDiscount();" ><?php echo $button_add_discount;?></a></td>
              </tr>
            </tfoot>
          </table>
        </div>
        <div id="tab-special">
          <table id="special" class="list">
            <thead>
              <tr>
                <td><?php echo $entry_customer_group;?></td>
                <td><?php echo $entry_priority;?></td>
                <td><?php echo $entry_price;?></td>
                <td><?php echo $entry_date_start;?></td>
                <td><?php echo $entry_date_end;?></td>
                <td></td>
              </tr>
            </thead>
            <?php $special_row = 0?>
            <?php foreach((array)$product_specials as $product_special) {?>
            <tbody id="special-row<?php echo $special_row;?>">
              <tr>
                <td><select name="product_special[<?php echo $special_row;?>][customer_group_id]">
                    <?php foreach((array)$customer_groups as $customer_group) {?>
                    <?php if($customer_group['customer_group_id'] == $product_special['customer_group_id']) { ?>
                    <option value="<?php echo $customer_group['customer_group_id'];?>" selected="selected"><?php echo $customer_group['name'];?></option>
                     <?php } else { ?>
                    <option value="<?php echo $customer_group['customer_group_id'];?>"><?php echo $customer_group['name'];?></option>
                    <?php } ?>
                   <?php } ?>
                  </select></td>
                <td><input type="text" name="product_special[<?php echo $special_row;?>][priority]" value="<?php echo $product_special['priority'];?>" size="2" /></td>
                <td><input type="text" name="product_special[<?php echo $special_row;?>][price]" value="<?php echo $product_special['price'];?>" /></td>
                <td><input type="text" name="product_special[<?php echo $special_row;?>][date_start]" value="<?php echo $product_special['date_start'];?>" class="date" /></td>
                <td><input type="text" name="product_special[<?php echo $special_row;?>][date_end]" value="<?php echo $product_special['date_end'];?>" class="date" /></td>
                <td><a onclick="$('#special-row<?php echo $special_row;?>').remove();" class="button"><?php echo $button_remove;?></a></td>
              </tr>
            </tbody>
            <?php $special_row++?>
            <?php } ?>
            <tfoot>
              <tr>
                <td colspan="5"></td>
                <td><a href="javascript:;" onclick="addSpecial();" ><?php echo $button_add_special;?></a></td>
              </tr>
            </tfoot>
          </table>
        </div>
        <div id="tab-image">
          <table id="images" class="list">
            <thead>
              <tr>
                <td><?php echo $entry_image;?></td>
                <td><?php echo $entry_sort_order;?></td>
                <td></td>
              </tr>
            </thead>
            <?php $image_row = 0?>
            <?php foreach((array)$product_images as $product_image) {?>
            <tbody id="image-row<?php echo $image_row;?>">
              <tr>
                <td><div class="image"><img src="<?php echo $product_image['thumb'];?>" alt="" id="thumb<?php echo $image_row;?>" />
                    <input type="hidden" name="product_image[<?php echo $image_row;?>][image]" value="<?php echo $product_image['image'];?>" id="image<?php echo $image_row;?>" />
					<input type="hidden" name="product_image[<?php echo $image_row;?>][product_image_id]" value="<?php echo $product_image['product_image_id'];?>"  />
                    <br />
                    <a href="javascript:;" onclick="image_upload('image<?php echo $image_row;?>', 'thumb<?php echo $image_row;?>');"><?php echo $text_browse;?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="javascript:;" onclick="$('#thumb<?php echo $image_row;?>').attr('src', '<?php echo $no_image;?>'); $('#image<?php echo $image_row;?>').attr('value', '');"><?php echo $text_clear;?></a></div></td>
                <td><input type="text" name="product_image[<?php echo $image_row;?>][sort_order]" value="<?php echo $product_image['sort_order'];?>" size="2" /></td>
                <td><a href="javascript:;" onclick="$('#image-row<?php echo $image_row;?>').remove();" class="button"><?php echo $button_remove;?></a></td>
              </tr>
            </tbody>
            <?php $image_row++?>
            <?php } ?>
            <tfoot>
              <tr>
                <td colspan="2"></td>
                <td><a href="javascript:;" onclick="addImage();" class="button"><?php echo $button_add_image;?></a></td>
              </tr>
            </tfoot>
          </table>
        </div>
        <div id="tab-reward">
          <table class="form">
            <tr>
              <td><?php echo $entry_points;?></td>
              <td><input type="text" name="points" value="<?php echo $points;?>" /></td>
            </tr>
          </table>
          <table class="list">
            <thead>
              <tr>
                <td><?php echo $entry_customer_group;?></td>
                <td><?php echo $entry_reward;?></td>
              </tr>
            </thead>
            <?php foreach((array)$customer_groups as $customer_group) {?>
            <tbody>
              <tr>
                <td><?php echo $customer_group['name'];?></td>
                <td><input type="text" name="product_reward[<?php echo $customer_group['customer_group_id'];?>][points]" value="<?php isset($product_reward[$customer_group['customer_group_id']]) ? $product_reward[$customer_group['customer_group_id']]['points'] : ''?>" /></td>
              </tr>
            </tbody>
            <?php } ?>
          </table>
        </div>
		
		
        <!-- <div id="tab-design">
          <table class="list">
            <thead>
              <tr>
                <td><?php echo $entry_store;?></td>
                <td><?php echo $entry_layout;?></td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><?php echo $text_default;?></td>
                <td><select name="product_layout[0][layout_id]">
                    <option value=""></option>
                    <?php foreach((array)$layouts as $layout) {?>
                    <?php if(isset($product_layout[0]) && $product_layout[0] == $layout['layout_id']) { ?>
                    <option value="<?php echo $layout['layout_id'];?>" selected="selected"><?php echo $layout['name'];?></option>
                     <?php } else { ?>
                    <option value="<?php echo $layout['layout_id'];?>"><?php echo $layout['name'];?></option>
                    <?php } ?>
                    <?php } ?>
                  </select></td>
              </tr>
            </tbody>
            <?php foreach((array)$stores as $store) {?>
            <tbody>
              <tr>
                <td><?php echo $store['name'];?></td>
                <td><select name="product_layout[<?php echo $store['store_id'];?>][layout_id]">
                    <option value=""></option>
                    <?php foreach((array)$layouts as $layout) {?>
                    <?php if(isset($product_layout[$store['store_id']]) && $product_layout[$store['store_id']] == $layout['layout_id']) { ?>
                    <option value="<?php echo $layout['layout_id'];?>" selected="selected"><?php echo $layout['name'];?></option>
                     <?php } else { ?>
                    <option value="<?php echo $layout['layout_id'];?>"><?php echo $layout['name'];?></option>
                    <?php } ?>
                    <?php } ?>
                  </select></td>
              </tr>
            </tbody>
            <?php } ?>
          </table>
        </div> -->
		
		
      </form>
</div>
<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script> 
<script type="text/javascript"><!--

CKEDITOR.replace('descriptions', {
	filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token;?>',
	filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token;?>',
	filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token;?>',
	filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token;?>',
	filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token;?>',
	filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token;?>'
});

//--></script> 
<script type="text/javascript"><!--
$('input[name=\'related\']').autocomplete({
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
		$('#product-related' + ui.item.value).remove();
		
		$('#product-related').append('<div id="product-related' + ui.item.value + '">' + ui.item.label + '<img  src="view/image/delete.png" /><input type="hidden" name="product_related[]" value="' + ui.item.value + '" /></div>');

		$('#product-related div:odd').attr('class', 'odd');
		$('#product-related div:even').attr('class', 'even');
				
		return false;
	},
	focus: function(event, ui) {
      return false;
   }
});

$('#product-related div img').live('click', function() {
	$(this).parent().remove();
	
	$('#product-related div:odd').attr('class', 'odd');
	$('#product-related div:even').attr('class', 'even');	
});
//--></script> 
<script type="text/javascript"><!--
var attribute_row = <?php echo $attribute_row;?>;

function addAttribute() {
    if(attribute_row==10){
	   alert('最多只能设置10个属性！');
	   return false;
	}
	html  = '<tbody id="attribute-row' + attribute_row + '">';
    html += '  <tr>';
	html += '    <td><input type="text" name="product_attribute[' + attribute_row + '][name]" value="" /><input type="hidden" name="product_attribute[' + attribute_row + '][attribute_id]" value="" /></td>';
	html += '    <td>';
	
	html += '<textarea name="product_attribute[' + attribute_row + '][text]" cols="40" rows="5"></textarea><br />';
   
	html += '    </td>';
	html += '    <td><a  href="javascript:;" onclick="$(\'#attribute-row' + attribute_row + '\').remove();" class="button"><?php echo $button_remove;?></a></td>';
    html += '  </tr>';	
    html += '</tbody>';
	
	$('#attribute tfoot').before(html);
	
	attributeautocomplete(attribute_row);
	
	attribute_row++;
}

$.widget('custom.catcomplete', $.ui.autocomplete, {
	_renderMenu: function(ul, items) {
		var self = this, currentCategory = '';
		
		$.each(items, function(index, item) {
			if (item.category != currentCategory) {
				ul.append('<li class="ui-autocomplete-category">' + item.category + '</li>');
				
				currentCategory = item.category;
			}
			
			self._renderItem(ul, item);
		});
	}
});


function attributeautocomplete(attribute_row) {
	$('input[name=\'product_attribute[' + attribute_row + '][name]\']').catcomplete({
		delay: 0,
		source: function(request, response) {
			$.ajax({
				url: 'index.php?route=catalog/attribute/autocomplete&token=<?php echo $token;?>&filter_name=' + encodeURIComponent(request.term)+'&productId=<?php echo $productId;?>', //encodeURIComponent(
				dataType: 'json',
				success: function(json) {			
					response($.map(json, function(item) {
					    if(item.name.length>0){
							return {
								category: item.attribute_group,
								label: item.name,
								value: item.attribute_id
							}
						}
					}));
				}
			});
		}, 
		select: function(event, ui) {
			$('input[name=\'product_attribute[' + attribute_row + '][name]\']').attr('value', ui.item.label);
			$('input[name=\'product_attribute[' + attribute_row + '][attribute_id]\']').attr('value', ui.item.value);
			
			return false;
		},
		focus: function(event, ui) {
      		return false;
   		}
	});
}

$('#attribute tbody').each(function(index, element) {
	attributeautocomplete(index);
});


//--></script> 
<script type="text/javascript"><!--	
var option_row = <?php echo $option_row;?>;

$("input[name=addOptions]").click(function(){

	
	var attribute_group_id=$('select[name=atrributeGroups]').val();
	$.ajax({
		url: 'index.php?route=catalog/option/autocomplete&token=<?php echo $token;?>&attribute_group_id='+attribute_group_id,
		dataType: 'json',
		success: function(json) {
		   
			$.map(json, function(item) {
				//alert(item.option_id);
				/*
				return {
					category: item.category,
					label: item.name,
					value: item.option_id,
					type: item.type,
					option_value: item.option_value,
					attribute_group_id:item.attribute_group_id
				}*/
				
				html  = '<div id="tab-option-' + option_row + '" class="vtabs-content">';
				html += '	<input type="hidden" name="product_option[' + option_row + '][product_option_id]" value="" />';
				html += '	<input type="hidden" name="product_option[' + option_row + '][name]" value="' + item.label + '" />';
				html += '	<input type="hidden" name="product_option[' + option_row + '][attribute_group_id]" value="'+item.attribute_group_id+'" />'; 
				html += '	<input type="hidden" name="product_option[' + option_row + '][option_id]" value="' + item.option_id + '" />';
				html += '	<input type="hidden" name="product_option[' + option_row + '][type]" value="' + item.type + '" />';
				html += '	<table class="form">';
				html += '	  <tr>';
				html += '		<td><?php echo $entry_required;?></td>';
				html += '       <td><select name="product_option[' + option_row + '][required]">';
				html += '	      <option value="1"><?php echo $text_yes;?></option>';
				html += '	      <option value="0"><?php echo $text_no;?></option>';
				html += '	    </select></td>';
				html += '     </tr>';
				
				if (item.type == 'text') {
					html += '     <tr>';
					html += '       <td><?php echo $entry_option_value;?></td>';
					html += '       <td><input type="text" name="product_option[' + option_row + '][option_value]" value="" /></td>';
					html += '     </tr>';
				}
				
				if (item.type == 'textarea') {
					html += '     <tr>';
					html += '       <td><?php echo $entry_option_value;?></td>';
					html += '       <td><textarea name="product_option[' + option_row + '][option_value]" cols="40" rows="5"></textarea></td>';
					html += '     </tr>';						
				}
				 
				if (item.type == 'file') {
					html += '     <tr style="display: none;">';
					html += '       <td><?php echo $entry_option_value;?></td>';
					html += '       <td><input type="text" name="product_option[' + option_row + '][option_value]" value="" /></td>';
					html += '     </tr>';			
				}
								
				if (item.type == 'date') {
					html += '     <tr>';
					html += '       <td><?php echo $entry_option_value;?></td>';
					html += '       <td><input type="text" name="product_option[' + option_row + '][option_value]" value="" class="date" /></td>';
					html += '     </tr>';			
				}
				
				if (item.type == 'datetime') {
					html += '     <tr>';
					html += '       <td><?php echo $entry_option_value;?></td>';
					html += '       <td><input type="text" name="product_option[' + option_row + '][option_value]" value="" class="datetime" /></td>';
					html += '     </tr>';			
				}
				
				if (item.type == 'time') {
					html += '     <tr>';
					html += '       <td><?php echo $entry_option_value;?></td>';
					html += '       <td><input type="text" name="product_option[' + option_row + '][option_value]" value="" class="time" /></td>';
					html += '     </tr>';			
				}
				
				html += '  </table>';
					
				if (item.type == 'select' || item.type == 'radio' || item.type == 'checkbox' || item.type == 'image') {
					html += '  <table id="option-value' + option_row + '" class="list">';
					html += '  	 <thead>'; 
					html += '      <tr>';
					html += '        <td><?php echo $entry_option_value;?></td>';
					html += '        <td><?php echo $entry_quantity;?></td>';
					html += '        <td><?php echo $entry_subtract;?></td>';
					html += '        <td><?php echo $entry_price;?></td>';
					html += '        <td><?php echo $entry_option_points;?></td>';
					html += '        <td><?php echo $entry_weight;?></td>';
					html += '        <td></td>';
					html += '      </tr>';
					html += '  	 </thead>';
					html += '    <tfoot>';
					html += '      <tr>';
					html += '        <td colspan="6"></td>';
					html += '        <td><a href="javascript:;" onclick="addOptionValue(' + option_row + ');" class="button"><?php echo $button_add_option_value;?></a></td>';
					html += '      </tr>';
					html += '    </tfoot>';
					html += '  </table>';
					html += '  <select id="option-values' + option_row + '" style="display: none;">';
					
					for (i = 0; i < item.option_value.length; i++) {
						html += '  <option value="' + item.option_value[i]['option_value_id'] + ','+item.option_value[i]['attribute_id']+'">' + item.option_value[i]['name'] + '</option>';
					}

					html += '  </select>';			
					html += '</div>';	
				}
				
				$('#tab-option').append(html);
				
				$('#option-add').before('<a href="#tab-option-' + option_row + '" id="option-' + option_row + '">' + item.label + '&nbsp;<img src="view/image/delete.png" alt="" onclick="$(\'#vtab-option a:first\').trigger(\'click\'); $(\'#option-' + option_row + '\').remove(); $(\'#tab-option-' + option_row + '\').remove(); return false;" /></a>');
				
				$('#vtab-option a').tabs();
				
				$('#option-' + option_row).trigger('click');		
				
				$('.date').datepicker({dateFormat: 'yy-mm-dd'});
				$('.datetime').datetimepicker({
					dateFormat: 'yy-mm-dd',
					timeFormat: 'h:m'
				});	
					
				$('.time').timepicker({timeFormat: 'h:m'});	
						
				option_row++;
				
				return false;
			});
		}
	});
	
	/*
	select: function(event, ui) {
		
	},
	focus: function(event, ui) {
      return false;
   }*/
});

/*
$('input[name=\'option\']').catcomplete({
	delay: 0,
	source: function(request, response) {
	    var attribute_group_id=$('select[name=atrributeGroups]').val();
		$.ajax({
			url: 'index.php?route=catalog/option/autocomplete&token=<?php echo $token;?>&attribute_group_id='+attribute_group_id+'&filter_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
				    
					return {
						category: item.category,
						label: item.name,
						value: item.option_id,
						type: item.type,
						option_value: item.option_value,
						attribute_group_id:item.attribute_group_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		html  = '<div id="tab-option-' + option_row + '" class="vtabs-content">';
		html += '	<input type="hidden" name="product_option[' + option_row + '][product_option_id]" value="" />';
		html += '	<input type="hidden" name="product_option[' + option_row + '][name]" value="' + ui.item.label + '" />';
		html += '	<input type="hidden" name="product_option[' + option_row + '][attribute_group_id]" value="'+ui.item.attribute_group_id+'" />'; 
		html += '	<input type="hidden" name="product_option[' + option_row + '][option_id]" value="' + ui.item.value + '" />';
		html += '	<input type="hidden" name="product_option[' + option_row + '][type]" value="' + ui.item.type + '" />';
		html += '	<table class="form">';
		html += '	  <tr>';
		html += '		<td><?php echo $entry_required;?></td>';
		html += '       <td><select name="product_option[' + option_row + '][required]">';
		html += '	      <option value="1"><?php echo $text_yes;?></option>';
		html += '	      <option value="0"><?php echo $text_no;?></option>';
		html += '	    </select></td>';
		html += '     </tr>';
		
		if (ui.item.type == 'text') {
			html += '     <tr>';
			html += '       <td><?php echo $entry_option_value;?></td>';
			html += '       <td><input type="text" name="product_option[' + option_row + '][option_value]" value="" /></td>';
			html += '     </tr>';
		}
		
		if (ui.item.type == 'textarea') {
			html += '     <tr>';
			html += '       <td><?php echo $entry_option_value;?></td>';
			html += '       <td><textarea name="product_option[' + option_row + '][option_value]" cols="40" rows="5"></textarea></td>';
			html += '     </tr>';						
		}
		 
		if (ui.item.type == 'file') {
			html += '     <tr style="display: none;">';
			html += '       <td><?php echo $entry_option_value;?></td>';
			html += '       <td><input type="text" name="product_option[' + option_row + '][option_value]" value="" /></td>';
			html += '     </tr>';			
		}
						
		if (ui.item.type == 'date') {
			html += '     <tr>';
			html += '       <td><?php echo $entry_option_value;?></td>';
			html += '       <td><input type="text" name="product_option[' + option_row + '][option_value]" value="" class="date" /></td>';
			html += '     </tr>';			
		}
		
		if (ui.item.type == 'datetime') {
			html += '     <tr>';
			html += '       <td><?php echo $entry_option_value;?></td>';
			html += '       <td><input type="text" name="product_option[' + option_row + '][option_value]" value="" class="datetime" /></td>';
			html += '     </tr>';			
		}
		
		if (ui.item.type == 'time') {
			html += '     <tr>';
			html += '       <td><?php echo $entry_option_value;?></td>';
			html += '       <td><input type="text" name="product_option[' + option_row + '][option_value]" value="" class="time" /></td>';
			html += '     </tr>';			
		}
		
		html += '  </table>';
			
		if (ui.item.type == 'select' || ui.item.type == 'radio' || ui.item.type == 'checkbox' || ui.item.type == 'image') {
			html += '  <table id="option-value' + option_row + '" class="list">';
			html += '  	 <thead>'; 
			html += '      <tr>';
			html += '        <td><?php echo $entry_option_value;?></td>';
			html += '        <td><?php echo $entry_quantity;?></td>';
			html += '        <td><?php echo $entry_subtract;?></td>';
			html += '        <td><?php echo $entry_price;?></td>';
			html += '        <td><?php echo $entry_option_points;?></td>';
			html += '        <td><?php echo $entry_weight;?></td>';
			html += '        <td></td>';
			html += '      </tr>';
			html += '  	 </thead>';
			html += '    <tfoot>';
			html += '      <tr>';
			html += '        <td colspan="6"></td>';
			html += '        <td><a href="javascript:;" onclick="addOptionValue(' + option_row + ');" class="button"><?php echo $button_add_option_value;?></a></td>';
			html += '      </tr>';
			html += '    </tfoot>';
			html += '  </table>';
            html += '  <select id="option-values' + option_row + '" style="display: none;">';
			
            for (i = 0; i < ui.item.option_value.length; i++) {
				html += '  <option value="' + ui.item.option_value[i]['option_value_id'] + '">' + ui.item.option_value[i]['name'] + '</option>';
            }

            html += '  </select>';			
			html += '</div>';	
		}
		
		$('#tab-option').append(html);
		
		$('#option-add').before('<a href="#tab-option-' + option_row + '" id="option-' + option_row + '">' + ui.item.label + '&nbsp;<img src="view/image/delete.png" alt="" onclick="$(\'#vtab-option a:first\').trigger(\'click\'); $(\'#option-' + option_row + '\').remove(); $(\'#tab-option-' + option_row + '\').remove(); return false;" /></a>');
		
		$('#vtab-option a').tabs();
		
		$('#option-' + option_row).trigger('click');		
		
		$('.date').datepicker({dateFormat: 'yy-mm-dd'});
		$('.datetime').datetimepicker({
			dateFormat: 'yy-mm-dd',
			timeFormat: 'h:m'
		});	
			
		$('.time').timepicker({timeFormat: 'h:m'});	
				
		option_row++;
		
		return false;
	},
	focus: function(event, ui) {
      return false;
   }
});
*/
//--></script> 
<script type="text/javascript"><!--		
var option_value_row = <?php echo $option_value_row;?>;

function addOptionValue(option_row) {	
	html  = '<tbody id="option-value-row' + option_value_row + '">';
	html += '  <tr>';
	html += '    <td><select name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][option_value_id]">';
	html += $('#option-values' + option_row).html();
	html += '    </select><input type="hidden" name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][attribute_id]" value="" /><input type="hidden" name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][product_option_value_id]" value="" /></td>';
	html += '    <td><input type="text" name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][quantity]" value="" size="3" /></td>'; 
	html += '    <td><select name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][subtract]">';
	html += '      <option value="1"><?php echo $text_yes;?></option>';
	html += '      <option value="0"><?php echo $text_no;?></option>';
	html += '    </select></td>';
	html += '    <td><select name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][price_prefix]">';
	html += '      <option value="+">+</option>';
	html += '      <option value="-">-</option>';
	html += '    </select>';
	html += '    <input type="text" name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][price]" value="" size="5" /></td>';
	html += '    <td><select name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][points_prefix]">';
	html += '      <option value="+">+</option>';
	html += '      <option value="-">-</option>';
	html += '    </select>';
	html += '    <input type="text" name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][points]" value="" size="5" /></td>';	
	html += '    <td><select name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][weight_prefix]">';
	html += '      <option value="+">+</option>';
	html += '      <option value="-">-</option>';
	html += '    </select>';
	html += '    <input type="text" name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][weight]" value="" size="5" /></td>';
	html += '    <td><a href="javascript:;" onclick="$(\'#option-value-row' + option_value_row + '\').remove();" class="button"><?php echo $button_remove;?></a></td>';
	html += '  </tr>';
	html += '</tbody>';
	
	$('#option-value' + option_row + ' tfoot').before(html);

	option_value_row++;
}
/*
$("select[name$='[option_value_id]']").live('change',function(){
    $(this).next().val('34');
});
*/
//--></script> 
<script type="text/javascript"><!--
var discount_row = <?php echo $discount_row;?>;

function addDiscount() {
	html  = '<tbody id="discount-row' + discount_row + '">';
	html += '  <tr>'; 
    html += '    <td><select name="product_discount[' + discount_row + '][customer_group_id]">';
    <?php foreach((array)$customer_groups as $customer_group) {?>
    html += '      <option value="<?php echo $customer_group['customer_group_id'];?>"><?php echo $customer_group['name'];?></option>';
    <?php } ?>
    html += '    </select></td>';		
    html += '    <td><input type="text" name="product_discount[' + discount_row + '][quantity]" value="" size="5" /></td>';
    html += '    <td><input type="text" name="product_discount[' + discount_row + '][priority]" value="" size="5" /></td>';
	html += '    <td><input type="text" name="product_discount[' + discount_row + '][price]" value="" /></td>';
    html += '    <td><input type="text" name="product_discount[' + discount_row + '][date_start]" value="" class="date" /></td>';
	html += '    <td><input type="text" name="product_discount[' + discount_row + '][date_end]" value="" class="date" /></td>';
	html += '    <td><a href="javascript:;" onclick="$(\'#discount-row' + discount_row + '\').remove();" class="button"><?php echo $button_remove;?></a></td>';
	html += '  </tr>';	
    html += '</tbody>';
	
	$('#discount tfoot').before(html);
		
	$('#discount-row' + discount_row + ' .date').datepicker({dateFormat: 'yy-mm-dd'});
	
	discount_row++;
}
//--></script> 
<script type="text/javascript"><!--
var special_row = <?php echo $special_row;?>;

function addSpecial() {
	html  = '<tbody id="special-row' + special_row + '">';
	html += '  <tr>'; 
    html += '    <td><select name="product_special[' + special_row + '][customer_group_id]">';
    <?php foreach((array)$customer_groups as $customer_group) {?>
    html += '      <option value="<?php echo $customer_group['customer_group_id'];?>"><?php echo $customer_group['name'];?></option>';
    <?php } ?>
    html += '    </select></td>';		
    html += '    <td><input type="text" name="product_special[' + special_row + '][priority]" value="" size="5" /></td>';
	html += '    <td><input type="text" name="product_special[' + special_row + '][price]" value="" /></td>';
    html += '    <td><input type="text" name="product_special[' + special_row + '][date_start]" value="" class="date" /></td>';
	html += '    <td><input type="text" name="product_special[' + special_row + '][date_end]" value="" class="date" /></td>';
	html += '    <td><a href="javascript:;" onclick="$(\'#special-row' + special_row + '\').remove();" class="button"><?php echo $button_remove;?></a></td>';
	html += '  </tr>';
    html += '</tbody>';
	
	$('#special tfoot').before(html);
 
	$('#special-row' + special_row + ' .date').datepicker({dateFormat: 'yy-mm-dd'});
	
	special_row++;
}
//--></script> 
<script type="text/javascript"><!--
function image_upload(field, thumb) {
	$('#dialog').remove();
	
	$('#listDiv').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token;?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
	
	$('#dialog').dialog({
		title: '<?php echo $text_image_manager;?>',
		close: function (event, ui) {
			if ($('#' + field).attr('value')) {
				$.ajax({
					url: 'index.php?route=common/filemanager/image&token=<?php echo $token;?>&image=' + encodeURIComponent($('#' + field).attr('value')),
					dataType: 'text',
					success: function(text) {
						$('#' + thumb).replaceWith('<img src="' + text + '" alt="" id="' + thumb + '" />');
					}
				});
			}
		},	
		bgiframe: false,
		width: 800,
		height: 400,
		resizable: false,
		modal: false
	});
};
//--></script> 
<script type="text/javascript"><!--
var image_row = <?php echo $image_row;?>;

function addImage() {
    html  = '<tbody id="image-row' + image_row + '">';
	html += '  <tr>';
	html += '    <td><div class="image"><img src="<?php echo $no_image;?>" alt="" id="thumb' + image_row + '" /><input type="hidden" name="product_image[' + image_row + '][image]" value="" id="image' + image_row + '" /><br /><a href="javascript:;" onclick="image_upload(\'image' + image_row + '\', \'thumb' + image_row + '\');"><?php echo $text_browse;?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="javascript:;" onclick="$(\'#thumb' + image_row + '\').attr(\'src\', \'<?php echo $no_image;?>\'); $(\'#image' + image_row + '\').attr(\'value\', \'\');"><?php echo $text_clear;?></a></div></td>';
	html += '    <td><input type="text" name="product_image[' + image_row + '][sort_order]" value="" size="2" /></td>';
	html += '    <td><a href="javascript:;" onclick="$(\'#image-row' + image_row  + '\').remove();" class="button"><?php echo $button_remove;?></a></td>';
	html += '  </tr>';
	html += '</tbody>';
	
	$('#images tfoot').before(html);
	
	image_row++;
}
//--></script> 
<script type="text/javascript" src="view/javascript/jquery/ui/jquery-ui-timepicker-addon.js"></script> 
<script type="text/javascript"><!--
$('.date').datepicker({dateFormat: 'yy-mm-dd'});
$('.datetime').datetimepicker({
	dateFormat: 'yy-mm-dd',
	timeFormat: 'h:m'
});
$('.time').timepicker({timeFormat: 'h:m'});
//--></script> 
<script type="text/javascript"><!--
$('#tabs a').tabpages(); 
//$('#languages a').tabpages(); 
$('#vtab-option a').tabpages();
//--></script> 

<script type="text/javascript">
  
  var sel={ 
            getOne:function(){
				var id=$('.oned').find("option:selected").val();
				$.ajax({
				    url:'index.php?route=catalog/attribute_group/getAjaxCategory&token=<?php echo $token;?>&id='+id,
				    dataType:'json',
					success:function(json){
						$('.twod').css({'display':'none'});
						$('.threed').html('');
						$('.threed').css({'display':'none'});
						$('.fourd').html('');
						$('.fourd').css({'display':'none'});
					    var l=json.length;
						
						var x="<option value=''>--请选择--</option>";
						if (l>0){
						    $('.twod').css({'display':'inline'});
						    for(var i=0;i<l;i++){
							    x=x+"<option value="+json[i]['id']+">"+json[i]['id']+"："+json[i]['name']+"</option>";
							}
						}else{
						    x='';
						}
					     
						$('.twod').html(x);
					  
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
					    $('.threed').html('');
						$('.threed').css({'display':'none'});
						$('.fourd').html('');
						$('.fourd').css({'display':'none'});
					    var l=json.length;
						var x="<option value=''>--请选择--</option>";
						if (l>0){
						    $('.threed').css({'display':'inline'});
						    for(var i=0;i<l;i++){
							    x=x+"<option value="+json[i]['id']+">"+json[i]['id']+"："+json[i]['name']+"</option>";
							}
						}else{
						    x='';
						}
					
					    $('.threed').html(x);
						
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
					    $('.fourd').html('');
						$('.fourd').css({'display':'none'});
					    var l=json.length;
						var x="<option value=''>--请选择--</option>";
						if (l>0){
						    $('.fourd').css({'display':'inline'});
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
