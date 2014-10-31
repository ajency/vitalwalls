<?php
/*
 * Followig class handling pre-uploaded image control and their
* dependencies. Do not make changes in code
* Create on: 9 November, 2013
*/

class NM_Image extends NM_Inputs_wooproduct{
	
	/*
	 * input control settings
	 */
	var $title, $desc, $settings;
	
	/*
	 * this var is pouplated with current plugin meta
	*/
	var $plugin_meta;
	
	function __construct(){
		
		$this -> plugin_meta = get_plugin_meta_productmeta();
		
		$this -> title 		= __ ( 'Images', 'nm-personalizedproduct' );
		$this -> desc		= __ ( 'Images selection', 'nm-personalizedproduct' );
		$this -> settings	= self::get_settings();
		
	}
	
	
	
	
	private function get_settings(){
		
		return array (
		'title' => array (
				'type' => 'text',
				'title' => __ ( 'Title', 'nm-personalizedproduct' ),
				'desc' => __ ( 'It will be shown as field label', 'nm-personalizedproduct' ) 
		),
		'data_name' => array (
				'type' => 'text',
				'title' => __ ( 'Data name', 'nm-personalizedproduct' ),
				'desc' => __ ( 'REQUIRED: The identification name of this field, that you can insert into body email configuration. Note:Use only lowercase characters and underscores.', 'nm-personalizedproduct' ) 
		),
		'description' => array (
				'type' => 'text',
				'title' => __ ( 'Description', 'nm-personalizedproduct' ),
				'desc' => __ ( 'Small description, it will be diplay near name title.', 'nm-personalizedproduct' ) 
		),
		'error_message' => array (
				'type' => 'text',
				'title' => __ ( 'Error message', 'nm-personalizedproduct' ),
				'desc' => __ ( 'Insert the error message for validation.', 'nm-personalizedproduct' ) 
		),
				
		'class' => array (
				'type' => 'text',
				'title' => __ ( 'Class', 'nm-personalizedproduct' ),
				'desc' => __ ( 'Insert an additional class(es) (separateb by comma) for more personalization.', 'nm-personalizedproduct' )
		),
		
		'width' => array (
				'type' => 'text',
				'title' => __ ( 'Width', 'nm-personalizedproduct' ),
				'desc' => __ ( 'Type field width in % e.g: 50%', 'nm-personalizedproduct' )
		),
		
		'required' => array (
				'type' => 'checkbox',
				'title' => __ ( 'Required', 'nm-personalizedproduct' ),
				'desc' => __ ( 'Select this if it must be required.', 'nm-personalizedproduct' ) 
		),
				
		'images' => array (
				'type' => 'pre-images',
				'title' => __ ( 'Select images', 'nm-personalizedproduct' ),
				'desc' => __ ( 'Select images from media library', 'nm-personalizedproduct' )
		),
				
		'multiple_allowed' => array (
				'type' => 'checkbox',
				'title' => __ ( 'Multiple selection?', 'nm-personalizedproduct' ),
				'desc' => __ ( 'Allow users to select more then one images?.', 'nm-personalizedproduct' )
		),
				
		'popup_width' => array (
				'type' => 'text',
				'title' => __ ( 'Popup width', 'nm-personalizedproduct' ),
				'desc' => __ ( 'Popup window width in px e.g: 750', 'nm-personalizedproduct' )
		),
		
		'popup_height' => array (
				'type' => 'text',
				'title' => __ ( 'Popup height', 'nm-personalizedproduct' ),
				'desc' => __ ( 'Popup window height in px e.g: 550', 'nm-personalizedproduct' )
		),
		
		
		'logic' => array (
				'type' => 'checkbox',
				'title' => __ ( 'Enable conditional logic', 'nm-personalizedproduct' ),
				'desc' => __ ( 'Tick it to turn conditional logic to work below', 'nm-personalizedproduct' )
		),
		'conditions' => array (
				'type' => 'html-conditions',
				'title' => __ ( 'Conditions', 'nm-personalizedproduct' ),
				'desc' => __ ( 'Tick it to turn conditional logic to work below', 'nm-personalizedproduct' )
		),
		);
	}
	
	
	/*
	 * @params: $options
	*/
	function render_input($args, $images=""){
		
		// nm_personalizedproduct_pa($images);
		
		$_html = '<div class="pre_upload_image_box">';
			
		$img_index = 0;
		$popup_width	= $args['popup-width'] == '' ? 600 : $args['popup-width'];
		$popup_height	= $args['popup-height'] == '' ? 450 : $args['popup-height'];
		
		if ($images) {
			
			foreach ($images as $image){
					
				$_html .= '<div class="pre_upload_image">';
				$_html .= '<img width="75" src="'.$image['link'].'" />';
					
				// for bigger view
				$_html	.= '<div style="display:none" id="pre_uploaded_image_' . $img_index . '"><img src="' . $image['link'] . '" /></div>';
					
				$_html	.= '<div class="input_image">';
				if ($args['multiple-allowed'] == 'on') {
					$_html	.= '<input type="checkbox" data-price="'.$image['price'].'" data-title="'.stripslashes( $image['title'] ).'" name="'.$args['name'].'[]" value="'.$image['link'].'" />';
				}else{
					$_html	.= '<input type="radio" data-price="'.$image['price'].'" data-title="'.stripslashes( $image['title'] ).'" name="'.$args['name'].'" value="'.$image['link'].'" />';
				}
					
				// image big view
				$price = '';
				if(function_exists(woocommerce_price))
					$price = woocommerce_price( $image['price'] );
				else
					$price = $image['price'];
					
				$_html	.= '<a href="#TB_inline?width='.$popup_width.'&height='.$popup_height.'&inlineId=pre_uploaded_image_' . $img_index . '" class="thickbox" title="' . $args['name'] . '"><img width="15" src="' . $this -> plugin_meta['url'] . '/images/zoom.png" /></a>';
				$_html	.= '<div class="p_u_i_name">'.stripslashes( $image['title'] ) . ' ' . $price . '</div>';
				$_html	.= '</div>';	//input_image
					
					
				$_html .= '</div>';
					
				$img_index++;
			}
		}
		
		$_html .= '<div style="clear:both"></div>';		//container_buttons
			
		$_html .= '</div>';		//container_buttons
		
		echo $_html;
		
		$this -> get_input_js($args);
	}
	
	
	/*
	 * following function is rendering JS needed for input
	*/
	function get_input_js($args){
		?>
			
					<script type="text/javascript">	
					<!--
					jQuery(function($){
	
						// pre upload image click selection
						$(".pre_upload_image").click(function(){

							if($(this).find('input:checkbox').attr("checked") === 'checked'){
								$(this).find('input:checkbox').attr("checked", false);
							}else{
								$(this).find('input:radio, input:checkbox').attr("checked", "checked");
							}
s
						});
					});
					
					//--></script>
					<?php
			}
}