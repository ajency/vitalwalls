<?php
/*
 * rendering product meta on product page
 */
global $nmpersonalizedproduct;

$single_form = $nmpersonalizedproduct->get_product_meta ( $nmpersonalizedproduct->productmeta_id );
// $nmpersonalizedproduct -> pa($single_form);

$nmpersonalizedproduct->allow_file_upload = $single_form->allow_file_upload;

$existing_meta = json_decode ( $single_form->the_meta, true );

// productmeta_pa($existing_meta);

if ($existing_meta) {
	?>

<style>
<?php 

//pasting the custom css if used in form settings	
echo stripslashes(strip_tags($single_form->form_style));
?>
</style>

<?php
	
	echo '<div id="nm-productmeta-box-' . $nmpersonalizedproduct->productmeta_id . '" class="nm-productmeta-box">';
	echo '<input type="hidden" name="woo_option_price">';
	
	$row_size = 0;
	
	$started_section = '';
	
	foreach ( $existing_meta as $key => $meta ) {
		
		$type = $meta ['type'];
		
		$name = strtolower ( preg_replace ( "![^a-z0-9]+!i", "_", $meta ['data_name'] ) );
		
		// conditioned elements
		$visibility = '';
		$conditions_data = '';
		if ($meta['logic'] == 'on') {
		
			if($meta['conditions']['visibility'] == 'Show')
				$visibility = 'display: none';
		
			$conditions_data	= 'data-rules="'.esc_attr( json_encode($meta['conditions'] )).'"';
		}
		
		if (($row_size + intval ( $meta ['width'] )) > 100 || $type == 'section') {
			
			echo '<div style="clear:both; margin: 0;"></div>';
			
			if ($type == 'section') {
				$row_size = 100;
			} else {
				
				$row_size = intval ( $meta ['width'] );
			}
		} else {
			
			$row_size += intval ( $meta ['width'] );
		}
		
		$show_asterisk = ($meta ['required']) ? '<span class="show_required"> *</span>' : '';
		$show_description = ($meta ['description']) ? '<span class="show_description"> ' . stripslashes ( $meta ['description'] ) . '</span>' : '';
		
		$the_width = intval ( $meta ['width'] ) - 1 . '%';
		$the_margin = '1%';
		
		$field_label = $meta ['title'] . $show_asterisk . $show_description;
		
		switch ($type) {
			case 'text':
					
					$args = array(	'name'			=> $name,
									'id'			=> $name,
									'data-type'		=> $type,
									'data-req'		=> $meta['required'],
									'data-message'	=> $meta['error_message'],
									'maxlength'	=> $meta['max_length'],
									'minlength'	=> $meta['min_length']);
					echo '<p id="box-'.$name.'" style="width: '. $the_width.'; margin-right: '. $the_margin.';'.$visibility.'" '.$conditions_data.'>';
					echo '<label for="'.$name.'">'. $field_label.' </label> <br />';
					
					$nmpersonalizedproduct -> inputs[$type]	-> render_input($args);					
					
					//for validtion message
					echo '<span class="errors"></span>';
					echo '</p>';
					break;
					
				case 'masked':
						
					$args = array(	'name'			=> $name,
					'id'			=> $name,
					'data-type'		=> $type,
					'data-req'		=> $meta['required'],
					'data-mask'		=> $meta['mask'],
					'data-ismask'	=> "no",
					'data-message'	=> $meta['error_message']);
					echo '<p id="box-'.$name.'" style="width: '. $the_width.'; margin-right: '. $the_margin.';'.$visibility.'" '.$conditions_data.'>';
					echo '<label for="'.$name.'">'. $field_label.' </label> <br />';
						
					$nmpersonalizedproduct -> inputs[$type]	-> render_input($args);
						
					//for validtion message
					echo '<span class="errors"></span>';
					echo '</p>';
					break;
				
				case 'hidden':

					$args = array(	'name'			=> $name,
									'id'			=> $name,
									'data-type'		=> $type,
								);
					
					$nmpersonalizedproduct -> inputs[$type]	-> render_input($args);	
					break;
					
			
				case 'date':
					
					$args = array(	'name'			=> $name,
									'id'			=> $name,
									'data-type'		=> $type,
									'data-req'		=> $meta['required'],
									'data-message'	=> $meta['error_message'],
									'data-format'	=> $meta['date_formats']);
			
					echo '<p id="box-'.$name.'" style="width: '. $the_width.'; margin-right: '. $the_margin.';'.$visibility.'" '.$conditions_data.'>';
					echo '<label for="'.$name.'">'. $field_label.' </label> <br />';
			
					$nmpersonalizedproduct -> inputs[$type]	-> render_input($args);
					//for validtion message
					echo '<span class="errors"></span>';
					echo '</p>';
					break;
					
				case 'color':
						
					$args = array(	'name'			=> $name,
					'id'			=> $name,
					'data-type'		=> $type,
					'data-req'		=> $meta['required'],
					'data-message'	=> $meta['error_message'],
					'default-color'	=> $meta['default_color'],
					'show-onload'	=> $meta['show_onload'],
					'show-palletes'	=> $meta['show_palletes']);
						
					echo '<p id="box-'.$name.'" style="width: '. $the_width.'; margin-right: '. $the_margin.';'.$visibility.'" '.$conditions_data.'>';
					echo '<label for="'.$name.'">'. $field_label.' </label> <br />';
						
					$nmpersonalizedproduct -> inputs[$type]	-> render_input($args);
					//for validtion message
					echo '<span class="errors"></span>';
					echo '</p>';
					break;
		
				case 'email':
					
					$args = array(	'name'			=> $name,
									'id'			=> $name,
									'data-type'		=> $type,
									'data-req'		=> $meta['required'],
									'data-message'	=> $meta['error_message'],
									'data-sendemail'=> $meta['send_email']);

					echo '<p id="box-'.$name.'" style="width: '. $the_width.'; margin-right: '. $the_margin.';'.$visibility.'" '.$conditions_data.'>';
					echo '<label for="'.$name.'">'. $field_label.' </label> <br />';
					
					$nmpersonalizedproduct -> inputs[$type]	-> render_input($args);
					//for validtion message
					echo '<span class="errors"></span>';
					echo '</p>';
					break;
					
				
				case 'textarea':
				
					$args = array(	'name'			=> $name,
							'id'			=> $name,
							'data-type'		=> $type,
							'data-req'		=> $meta['required'],
							'data-message'	=> $meta['error_message'],
							'maxlength'	=> $meta['max_length'],
							'minlength'	=> $meta['min_length']);
					
					echo '<p id="box-'.$name.'" style="width: '. $the_width.'; margin-right: '. $the_margin.';'.$visibility.'" '.$conditions_data.'>';
					echo '<label for="'.$name.'">'. $field_label.' </label> <br />';
					
					$nmpersonalizedproduct -> inputs[$type]	-> render_input($args);				
					//for validtion message
					echo '<span class="errors"></span>';
					echo '</p>';
					break;
					
					
				case 'select':
				
					$default_selected = $meta['selected'];
					
					$args = array(	'name'			=> $name,
									'id'			=> $name,
									'data-type'		=> $type,
									'data-req'		=> $meta['required'],
									'data-message'	=> $meta['error_message']);
				
					echo '<p id="box-'.$name.'" style="width: '. $the_width.'; margin-right: '. $the_margin.';'.$visibility.'" '.$conditions_data.'>';
					echo '<label for="'.$name.'">'. $field_label.' </label> <br />';
					
					$nmpersonalizedproduct -> inputs[$type]	-> render_input($args, $meta['options'], $default_selected);
				
					//for validtion message
					echo '<span class="errors"></span>';
					echo '</p>';
					break;
						
				case 'radio':
					
					$default_selected = $meta['selected'];
					
					$args = array(	'name'			=> $name,
									'data-type'		=> $type,
									'data-req'		=> $meta['required'],
									'data-message'	=> $meta['error_message']);
				
					echo '<p id="box-'.$name.'" style="width: '. $the_width.'; margin-right: '. $the_margin.';'.$visibility.'" '.$conditions_data.'>';
					echo '<label for="'.$name.'">'. $field_label.' </label> <br />';
					
					$nmpersonalizedproduct -> inputs[$type]	-> render_input($args, $meta['options'], $default_selected);
					//for validtion message
					echo '<span class="errors"></span>';
					echo '</p>';
					break;
		
				case 'checkbox':
			
					$defaul_checked = explode("\n", $meta['checked']);
		
					$args = array(	'name'			=> $name,
							'id'			=> $name,
							'data-type'		=> $type,
							'data-req'		=> $meta['required'],
							'data-message'	=> $meta['error_message']);
					
					echo '<p id="box-'.$name.'" style="width: '. $the_width.'; margin-right: '. $the_margin.';'.$visibility.'" '.$conditions_data.'>';
					echo '<label for="'.$name.'">'. $field_label.' </label> <br />';
					
					$nmpersonalizedproduct -> inputs[$type]	-> render_input($args, $meta['options'], $defaul_checked);
					//for validtion message
					echo '<span class="errors"></span>';
					echo '</p>';
					break;
					
				case 'file':
				
					$label_select = ($meta['button_label_select'] == '' ? __('Select files', 'nm-personalizedproduct') : $meta['button_label_select']);
					$files_allowed = ($meta['files_allowed'] == '' ? 1 : $meta['files_allowed']);
					$file_types = ($meta['file_types'] == '' ? 'jpg,png,gif' : $meta['file_types']);
					$file_size = ($meta['file_size'] == '' ? '10mb' : $meta['file_size']);
					$chunk_size = ($meta['chunk_size'] == '' ? '5mb' : $meta['chunk_size']);
					
					$args = array(	'name'			=> $name,
									'id'			=> $name,
									'data-type'		=> $type,
									'data-req'		=> $meta['required'],
									'data-message'	=> $meta['error_message'],
									'button-label-select'	=> $label_select,
									'files-allowed'			=> $files_allowed,
									'file-types'			=> $file_types,
									'file-size'				=> $file_size,
									'chunk-size'			=> $chunk_size,
									'button-class'			=> $meta['button_class'],
									'photo-editing'			=> $meta['photo_editing'],
									'editing-tools'			=> $meta['editing_tools'],
									'aviary-api-key'		=> $single_form -> aviary_api_key,
									'popup-width'	=> $meta['popup_width'],
									'popup-height'	=> $meta['popup_height']);
					
					echo '<div id="box-'.$name.'" class="fileupload-box" style="float:left; width: '. $the_width.'; margin-right: '. $the_margin.';'.$visibility.'" '.$conditions_data.'>';
					echo '<label for="'.$name.'">'. $field_label.'</label>';
					echo '<div id="nm-uploader-area-'. $name.'" class="nm-uploader-area">';
					
					$nmpersonalizedproduct -> inputs[$type]	-> render_input($args);
				
					echo '<span class="errors"></span>';
				
					echo '</div>';		//.nm-uploader-area
					echo '</div>';
				
					// adding thickbox support
					add_thickbox();
					break;
					
					
					case 'image':
					
						$args = array(	'name'			=> $name,
								'id'			=> $name,
								'data-type'		=> $type,
								'data-req'		=> $meta['required'],
								'data-message'	=> $meta['error_message'],
								'popup-width'	=> $meta['popup_width'],
								'popup-height'	=> $meta['popup_height'],
								'multiple-allowed' => $meta['multiple_allowed']);
					
						echo '<div id="pre-uploaded-images-'.$name.'" style="width: '. $the_width.'; margin-right: '. $the_margin.';'.$visibility.'" '.$conditions_data.'>';
						echo '<label for="'.$name.'">'. $field_label.' </label> <br />';
							
						$nmpersonalizedproduct -> inputs[$type]	-> render_input($args, $meta['images']);
					
						//for validtion message
						echo '<span class="errors"></span>';
						echo '</div>';
					break;
					
					
					case 'instagram':
							
						$args = array(	'name'			=> $name,
						'id'			=> $name,
						'data-type'		=> $type,
						'data-req'		=> $meta['required'],
						'data-message'	=> $meta['error_message'],
						'button-class'			=> $meta['button_class'],
						'button-label-import'	=> $meta['button_label_import'],
						'client-id'		=> $meta['client_id'],
						'client-secret'	=> $meta['client_secret'],
						);
							
						echo '<div id="instagram-photos-'.$name.'" style="width: '. $the_width.'; margin-right: '. $the_margin.';'.$visibility.'" '.$conditions_data.'>';
						echo '<label for="'.$name.'">'. $field_label.' </label> <br />';
							
						$nmpersonalizedproduct -> inputs[$type]	-> render_input($args);
							
						//for validtion message
						echo '<span class="errors"></span>';
						echo '</div>';
						break;
					
					
					case 'section':
						
						if($started_section)		//if section already started then close it first
							echo '</section>';
						
						$section_title 		= strtolower(preg_replace("![^a-z0-9]+!i", "_", $meta['title'])); 
						$started_section 	= 'webcontact-section-'.$section_title;
						
						$args = array(	'id'			=> $started_section,
								'data-type'		=> $type,
								'title'			=> $meta['title'],
								'description'			=> $meta['description'],
								);
						
						$nmpersonalizedproduct -> inputs[$type]	-> render_input($args);
						
					break;
		}
	}
	
	echo '<div style="clear: both"></div>';
	
	echo '</div>'; // ends nm-productmeta-box
}