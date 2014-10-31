<?php
/*
 * This our new world, Inshallah 29 aug, 2013
 */
global $nmpersonalizedproduct;

if (isset ( $_REQUEST ['productmeta_id'] ) && $_REQUEST ['do_meta'] == 'edit') {
	
	$single_productmeta = $nmpersonalizedproduct -> get_product_meta( intval ( $_REQUEST ['productmeta_id'] ) );
	// $nmpersonalizedproduct -> pa($single_productmeta);
	
	$productmeta_name 		= $single_productmeta -> productmeta_name;
	$aviary_api_key 		= $single_productmeta -> aviary_api_key;
	$productmeta_style 		= $single_productmeta -> productmeta_style;
	$product_meta 			= json_decode ( $single_productmeta->the_meta, true );
	
	// $nmpersonalizedproduct->pa ( $product_meta );
}

$url_cancel = $this -> nm_plugin_fix_request_uri(array('action'=>'','productmeta_id'=>''));
echo '<p><a class="button" href="'.$url_cancel.'">'.__('&laquo; Existing Product Meta', 'nm-personalizedproduct').'</a></p>';
?>

<input type="hidden" name="productmeta_id"
	value="<?php echo $_REQUEST['productmeta_id']?>">
<div id="nmpersonalizedproduct-form-generator">
	<ul>
		<li><a href="#formbox-1"><?php _e('Product Meta Basic Settings', 'nm-personalizedproduct')?></a></li>
		<li><a href="#formbox-2"><?php _e('Product Meta Fields', 'nm-personalizedproduct')?></a></li>
		<li style="float: right"><button class="button-primary button"
				onclick="save_form_meta(<?php echo $productmeta_id?>)"><?php _e('Save settings', 'nm-personalizedproduct')?></button>
			<span id="nm-saving-form" style="display:none"><img alt="saving..." src="<?php echo $nmpersonalizedproduct->plugin_meta['url']?>/images/loading.gif"></span></li>
	</ul>

	<div id="formbox-1">

		<table id="form-main-settings" border="0" bordercolor=""
			style="background-color: #F8F8F8; padding: 10px" width="100%"
			cellpadding="0" cellspacing="0">
			<tr>
				<td class="headings"><?php _e('Meta group name', 'nm-personalizedproduct')?></td>
				<td><input type="text" name="productmeta_name"
					value="<?php echo $productmeta_name?>" /> <br />
					<p class="s-font"><?php _e('For your reference', 'nm-personalizedproduct')?></p></td>
			</tr>
			
			<!-- Photo editing with Aviary -->
			<tr>
				<td class="headings"><?php _e('Aviary API Key (Photo Editing)', 'nm-personalizedproduct')?>
				<a class="button" href="http://aviary.com/web" target="_blank"><?php _e('Learn about Aviary', 'nm-personalizedproduct')?></a></td>
				<td>
				
				<?php if ($nmpersonalizedproduct -> is_aviary_installed()) {?>
				<input type="text" name="aviary_api_key"
					value="<?php echo $aviary_api_key?>" /> <br />
					<p class="s-font"><?php _e('Enter Aviary API Key.', 'nm-personalizedproduct')?>
					<br><?php _e('You need to get your API key from Aviary to use this. It is free as long as you need paid features', 'nm-personalizedproduct')?></p>
				<?php }else{?>
					<p class="s-font">
						<a href="http://www.najeebmedia.com/photo-editing-add-on-for-n-media-website-contact-form/" class="button-primary" target="_blank"><?php _e('Buy this Add-on', 'nm-personalizedproduct')?></a>
						<a href="http://webcontact.wordpresspoets.com/demo-of-photo-editing/" class="button-primary" target="_blank"><?php _e('See Demo', 'nm-personalizedproduct')?></a>
					</p>
					
					<?php }?>
						
					</td>
			</tr>
			
			<tr>
				<td class="headings"><?php _e('Form styling/css', 'nm-personalizedproduct')?></td>
				<td><textarea rows="7" cols="25" name="productmeta_style"><?php echo stripslashes($productmeta_style)?></textarea> <br />
					<p class="s-font"><?php _e('Form styling/css.', 'nm-personalizedproduct')?></p></td>
			</tr> 
		</table>

	</div>
	<!--------------------- END formbox-1 ---------------------------------------->

	<div id="formbox-2">
		<div id="form-meta-bttons">
			<p>
		<?php _e('select input type below and drag it on right side. Then set more options', 'nm-personalizedproduct')?>
		</p>

			<ul id="nm-input-types">
		<?php
		foreach ( $nmpersonalizedproduct -> inputs as $type => $meta ) {
			
			echo '<li class="input-type-item" data-inputtype="' . $type . '">';
			echo '<div><h3><span class="top-heading-text">' . $meta -> title . '</span>';
			echo '<span class="top-heading-icons ui-icon ui-icon-arrow-4"></span>';
			echo '<span class="top-heading-icons ui-icon-placehorder"></span>';
			echo '<span style="clear:both;display:block"></span>';
			echo '</h3>';
			
			// this function Defined below
			echo render_input_settings ( $meta -> settings );
			
			echo '</div></li>';
			// echo '<div><p>'.$data['desc'].'</p></div>';
		}
		?>
		</ul>
		</div>


		<div id="form-meta-setting" class="postbox-container">

			<div id="postcustom" class="postbox">
				<h3>
					<span style="float: left"><?php _e('Drage form fields here', 'nm-personalizedproduct')?></span>
					<span style="float: right"><span style="float: right"
						title="<?php _e('Collapse all', 'nm-personalizedproduct')?>"
						class="ui-icon ui-icon-circle-triangle-n"></span><span
						title="<?php _e('Expand all', 'nm-personalizedproduct')?>"
						class="ui-icon ui-icon-circle-triangle-s"></span></span> <span
						class="clearfix"></span>
				</h3>
				<div class="inside" style="background-color: #fff;">
					<ul id="meta-input-holder">
					<?php render_existing_form_meta($product_meta, $nmpersonalizedproduct -> inputs)?>
					</ul>
				</div>
			</div>
		</div>

		<div class="clearfix"></div>
	</div>
</div>

<!-- ui dialogs -->
<div id="remove-meta-confirm"
	title="<?php _e('Are you sure?', 'nm-personalizedproduct')?>">
	<p>
		<span class="ui-icon ui-icon-alert"
			style="float: left; margin: 0 7px 20px 0;"></span>
  <?php _e('Are you sure to remove this input field?', 'nm-personalizedproduct')?></p>
</div>

<?php
function render_input_settings($settings, $values = '') {
	
	$setting_html = '<table>';
	foreach ( $settings as $meta_type => $data ) {
		
		// nm_personalizedproduct_pa($data);
		
		if ($data ['type'] == 'html-conditions')
			$colspan = 'colspan="2"';
		 
		$setting_html .= '<tr>';
		$setting_html .= '<td class="table-column-title">' . $data ['title'] . '</td>';
		
		if ($values)
			$setting_html .= '<td '.$colspan.' class="table-column-input" data-type="' . $data ['type'] . '" data-name="' . $meta_type . '">' . render_input_types ( $data ['type'], $meta_type, $values [$meta_type], $data ['options'] ) . '</td>';
		else
			$setting_html .= '<td '.$colspan.' class="table-column-input" data-type="' . $data ['type'] . '" data-name="' . $meta_type . '">' . render_input_types ( $data ['type'], $meta_type, null, $data ['options'] ) . '</td>';
		
		//removing the desc column for type: html-conditions
		if ($data ['type'] != 'html-conditions') {
			$setting_html .= '<td class="table-column-desc">' . $data ['desc'] . '</td>';;
		}
		
		$setting_html .= '</tr>';
	}
	
	$setting_html .= '</table>';
	
	return $setting_html;
}

/*
 * this function is rendring input field for settings
 */
function render_input_types($type, $name, $value = '', $options = '') {
	global $nmpersonalizedproduct;
	$html_input = '';
	
	// var_dump($value);
	if(!is_array($value))
		$value = stripslashes($value);
	
	switch ($type) {
		
		case 'text' :
			$html_input .= '<input type="text" name="' . $name . '" value="' . esc_html( $value ). '">';
			break;
		
		case 'textarea' :
			$html_input .= '<textarea name="' . $name . '">' . esc_html( $value ) . '</textarea>';
			break;
		
		case 'select' :
			$html_input .= '<select name="' . $name . '">';
			foreach ( $options as $key => $val ) {
				$selected = ($key == $value) ? 'selected="selected"' : '';
				$html_input .= '<option value="' . $key . '" ' . $selected . '>' . esc_html( $val ) . '</option>';
			}
			$html_input .= '</select>';
			break;
		
		case 'paired' :
			
			if($value){
				foreach ($value as $option){
					$html_input .= '<div class="data-options" style="border: dashed 1px;">';
					$html_input .= '<input type="text" name="options[option]" value="'.$option['option'].'" placeholder="'.__('option','nm-personalizedproduct').'">';
					$html_input .= '<input type="text" name="options[price]" value="'.$option['price'].'" placeholder="'.__('price (if any)','nm-personalizedproduct').'">';
					$html_input	.= '<img class="add_option" src="'.$nmpersonalizedproduct->plugin_meta['url'].'/images/plus.png" title="add rule" alt="add rule" style="cursor:pointer; margin:0 3px;">';
					$html_input	.= '<img class="remove_option" src="'.$nmpersonalizedproduct->plugin_meta['url'].'/images/minus.png" title="remove rule" alt="remove rule" style="cursor:pointer; margin:0 3px;">';
					$html_input .= '</div>';
				}
			}else{
				$html_input .= '<div class="data-options" style="border: dashed 1px;">';
				$html_input .= '<input type="text" name="options[option]" placeholder="'.__('option','nm-personalizedproduct').'">';
				$html_input .= '<input type="text" name="options[price]" placeholder="'.__('price (if any)','nm-personalizedproduct').'">';
				$html_input	.= '<img class="add_option" src="'.$nmpersonalizedproduct->plugin_meta['url'].'/images/plus.png" title="add rule" alt="add rule" style="cursor:pointer; margin:0 3px;">';
				$html_input	.= '<img class="remove_option" src="'.$nmpersonalizedproduct->plugin_meta['url'].'/images/minus.png" title="remove rule" alt="remove rule" style="cursor:pointer; margin:0 3px;">';
				$html_input .= '</div>';
			}
			
			break;
			
		case 'checkbox' :
			
			if ($options) {
				foreach ( $options as $key => $val ) {
					
					parse_str ( $value, $saved_data );
					if ($saved_data ['editing_tools']) {
						if (in_array($key, $saved_data['editing_tools'])) {
							$checked = 'checked="checked"';
						}else{
							$checked = '';
						}
					}
					// $html_input .= '<option value="' . $key . '" ' . $selected . '>' . $val . '</option>';
					$html_input .= '<input type="checkbox" value="' . $key . '" name="' . $name . '[]" ' . $checked . '> ' . $val . '<br>';
				}
			} else {
				if ($value)
					$checked = 'checked = "checked"';
				$html_input .= '<input type="checkbox" name="' . $name . '" ' . $checked . '>';
			}
			break;
			
		case 'html-conditions' :
			
			// nm_personalizedproduct_pa($value);
			$rule_i = 1;
			if($value){
				
	
					$visibility_show = ($value['visibility'] == 'Show') ? 'selected="selected"' : '';
					$visibility_hide = ($value['visibility'] == 'Hide') ? 'selected="selected"' : '';
					
					$html_input	 = '<select name="condition_visibility">';
					$html_input .= '<option '.$visibility_show.'>'.__('Show','nm-personalizedproduct').'</option>';
					$html_input .= '<option '.$visibility_hide.'>'.__('Hide', 'nm-personalizedproduct').'</option>';
					$html_input	.= '</select> ';
					
					
					$html_input .= __('only if', 'nm-personalizedproduct');
					
					$bound_all = ($value['bound'] == 'All') ? 'selected="selected"' : '';
					$bound_any = ($value['bound'] == 'Any') ? 'selected="selected"' : '';
					
					$html_input	.= '<select name="condition_bound">';
					$html_input 	.= '<option '.$bound_all.'>'.__('All','nm-personalizedproduct').'</option>';
					$html_input .= '<option '.$bound_any.'>'.__('Any', 'nm-personalizedproduct').'</option>';
					$html_input	.= '</select> ';
						
					$html_input .= __(' of the following matches', 'nm-personalizedproduct');
					
					
				foreach ($value['rules'] as $condition){
					
					
					// conditional elements
					$html_input .= '<div class="webcontact-rules" id="rule-box-'.$rule_i.'">';
					$html_input .= '<br><strong>'.__('Rule # ', 'nm-personalizedproduct') . $rule_i++ .'</strong><br>';
					$html_input .= '<select name="condition_elements" data-existingvalue="'.$condition['elements'].'" onblur="load_conditional_values(this)"></select>';
					
					// is
					
					$operator_is 		= ($condition['operators'] == 'is') ? 'selected="selected"' : '';
					$operator_not 		= ($condition['operators'] == 'not') ? 'selected="selected"' : '';
					$operator_greater 	= ($condition['operators'] == 'greater then') ? 'selected="selected"' : '';
					$operator_less 		= ($condition['operators'] == 'less then') ? 'selected="selected"' : '';
					
					$html_input .= '<select name="condition_operators">';
					$html_input	.= '<option '.$operator_is.'>'.__('is','nm-personalizedproduct').'</option>';
					$html_input .= '<option '.$operator_not.'>'.__('not', 'nm-personalizedproduct').'</option>';
					$html_input .= '<option '.$operator_greater.'>'.__('greater then', 'nm-personalizedproduct').'</option>';
					$html_input .= '<option '.$operator_less.'>'.__('less then', 'nm-personalizedproduct').'</option>';
					$html_input	.= '</select> ';
					
					// conditional elements values
					$html_input .= '<select name="condition_element_values" data-existingvalue="'.$condition['element_values'].'"></select>';
					$html_input	.= '<img class="add_rule" src="'.$nmpersonalizedproduct->plugin_meta['url'].'/images/plus.png" title="add rule" alt="add rule" style="cursor:pointer; margin:0 3px;">';
					$html_input	.= '<img class="remove_rule" src="'.$nmpersonalizedproduct->plugin_meta['url'].'/images/minus.png" title="remove rule" alt="remove rule" style="cursor:pointer; margin:0 3px;">';
					$html_input .= '</div>';
					
				}
			}else{

					
				$html_input	 = '<select name="condition_visibility">';
				$html_input .= '<option>'.__('Show','nm-personalizedproduct').'</option>';
				$html_input .= '<option>'.__('Hide', 'nm-personalizedproduct').'</option>';
				$html_input	.= '</select> ';
					
				$html_input	.= '<select name="condition_bound">';
				$html_input .= '<option>'.__('All','nm-personalizedproduct').'</option>';
				$html_input .= '<option>'.__('Any', 'nm-personalizedproduct').'</option>';
				$html_input	.= '</select> ';
					
				$html_input .= __(' of the following matches', 'nm-personalizedproduct');
				// conditional elements
				
				$html_input .= '<div class="webcontact-rules" id="rule-box-'.$rule_i.'">';
				$html_input .= '<br><strong>'.__('Rule # ', 'nm-personalizedproduct') . $rule_i++ .'</strong><br>';
				$html_input .= '<select name="condition_elements" data-existingvalue="'.$condition['elements'].'" onblur="load_conditional_values(this)"></select>';
					
				// is
					
				$html_input .= '<select name="condition_operators">';
				$html_input	.= '<option>'.__('is','nm-personalizedproduct').'</option>';
				$html_input .= '<option>'.__('not', 'nm-personalizedproduct').'</option>';
				$html_input .= '<option>'.__('greater then', 'nm-personalizedproduct').'</option>';
				$html_input .= '<option>'.__('less then', 'nm-personalizedproduct').'</option>';
				$html_input	.= '</select> ';
					
				// conditional elements values
				$html_input .= '<select name="condition_element_values" data-existingvalue="'.$condition['element_values'].'"></select>';
				$html_input	.= '<img class="add_rule" src="'.$nmpersonalizedproduct->plugin_meta['url'].'/images/plus.png" title="add rule" alt="add rule" style="cursor:pointer; margin:0 3px;">';
				$html_input	.= '<img class="remove_rule" src="'.$nmpersonalizedproduct->plugin_meta['url'].'/images/minus.png" title="remove rule" alt="remove rule" style="cursor:pointer; margin:0 3px;">';
				$html_input .= '</div>';
			}

			break;
			
			case 'pre-images' :
			
				
				//$html_input	.= '<textarea name="pre_upload_images">'.$pre_uploaded_images.'</textarea>';
				$html_input	.= '<div class="pre-upload-box">';
				$html_input	.= '<input name="pre_upload_image_button" type="button" value="'.__('Select/Upload Image', 'nm-personalizedproduct').'" />';
				// nm_personalizedproduct_pa($value);
				if ($value) {
					foreach ($value as $pre_uploaded_image){
				
						$html_input .='<table>';
						$html_input .= '<tr>';
						$html_input .= '<td><img width="75" src="'.$pre_uploaded_image['link'].'">';
						$html_input .= '<input type="hidden" name="pre-upload-link" value="'.$pre_uploaded_image['link'].'"></td>';
						$html_input .= '<td><input style="width:100px" type="text" value="'.stripslashes($pre_uploaded_image['title']).'" name="pre-upload-title"><br>';
						$html_input .= '<input style="width:100px" type="text" value="'.stripslashes($pre_uploaded_image['price']).'" name="pre-upload-price"><br>';
						$html_input .= '<input style="width:100px; color:red" name="pre-upload-delete" type="button" class="button" value="Delete"><br>';
						$html_input .= '</td></tr>';
						$html_input .= '</table><br>';
				
					}
					//$pre_uploaded_images = $value;
				}
				
				$html_input .= '</div>';
			
			break;
	}
	
	return $html_input;
}


/*
 * this function is rendering the existing form meta
 */
function render_existing_form_meta($product_meta, $types) {
	if ($product_meta) {
		foreach ( $product_meta as $key => $meta ) {
			
			$type = $meta ['type'];
			
			// nm_personalizedproduct_pa($meta);
			
			echo '<li data-inputtype="' . $type . '"><div class="postbox">';
			echo '<h3><span class="top-heading-text">' . $meta ['title'] . ' (' . $type . ')</span>';
			echo '<span class="top-heading-icons ui-icon ui-icon-carat-2-n-s"></span>';
			echo '<span class="top-heading-icons ui-icon ui-icon-trash"></span>';
			echo '<span style="clear:both;display:block"></span></h3>';
			
			echo render_input_settings ( $types[$type] -> settings, $meta );
			
			echo '</div></li>';
		}
	}
}

?>