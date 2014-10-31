<?php
/*
 * Followig class handling select input control and their
* dependencies. Do not make changes in code
* Create on: 9 November, 2013
*/

class NM_Select extends NM_Inputs_wooproduct{
	
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
		
		$this -> title 		= __ ( 'Select-box Input', 'nm-personalizedproduct' );
		$this -> desc		= __ ( 'regular select-box input', 'nm-personalizedproduct' );
		$this -> settings	= self::get_settings();
		
	}
	
	
	
	
	private function get_settings(){
		
		return array (
						'title' => array (
								'type' => 'text',
								'title' => __ ( 'Title', $nmpersonalizedproduct->plugin_meta ['shortname'] ),
								'desc' => __ ( 'It will be shown as field label', $nmpersonalizedproduct->plugin_meta ['shortname'] ) 
						),
						'data_name' => array (
								'type' => 'text',
								'title' => __ ( 'Data name', $nmpersonalizedproduct->plugin_meta ['shortname'] ),
								'desc' => __ ( 'REQUIRED: The identification name of this field, that you can insert into body email configuration. Note:Use only lowercase characters and underscores.', $nmpersonalizedproduct->plugin_meta ['shortname'] ) 
						),
						'description' => array (
								'type' => 'text',
								'title' => __ ( 'Description', $nmpersonalizedproduct->plugin_meta ['shortname'] ),
								'desc' => __ ( 'Small description, it will be diplay near name title.', $nmpersonalizedproduct->plugin_meta ['shortname'] ) 
						),
						'error_message' => array (
								'type' => 'text',
								'title' => __ ( 'Error message', $nmpersonalizedproduct->plugin_meta ['shortname'] ),
								'desc' => __ ( 'Insert the error message for validation.', $nmpersonalizedproduct->plugin_meta ['shortname'] ) 
						),
						
						'options' => array (
								'type' => 'paired',
								'title' => __ ( 'Add options', $nmpersonalizedproduct->plugin_meta ['shortname'] ),
								'desc' => __ ( 'Type option with price (optionally)', $nmpersonalizedproduct->plugin_meta ['shortname'] )
						),
						
						'selected' => array (
								'type' => 'text',
								'title' => __ ( 'Selected option', $nmpersonalizedproduct->plugin_meta ['shortname'] ),
								'desc' => __ ( 'Type option name (given above) if you want already selected.', $nmpersonalizedproduct->plugin_meta ['shortname'] ) 
						),
						
						'required' => array (
								'type' => 'checkbox',
								'title' => __ ( 'Required', $nmpersonalizedproduct->plugin_meta ['shortname'] ),
								'desc' => __ ( 'Select this if it must be required.', $nmpersonalizedproduct->plugin_meta ['shortname'] ) 
						),
						
						'class' => array (
								'type' => 'text',
								'title' => __ ( 'Class', $nmpersonalizedproduct->plugin_meta ['shortname'] ),
								'desc' => __ ( 'Insert an additional class(es) (separateb by comma) for more personalization.', $nmpersonalizedproduct->plugin_meta ['shortname'] ) 
						),
						'width' => array (
								'type' => 'text',
								'title' => __ ( 'Width', $nmpersonalizedproduct->plugin_meta ['shortname'] ),
								'desc' => __ ( 'Type field width in % e.g: 50%', $nmpersonalizedproduct->plugin_meta ['shortname'] ) 
						),
						'logic' => array (
								'type' => 'checkbox',
								'title' => __ ( 'Enable conditional logic', $nmpersonalizedproduct->plugin_meta ['shortname'] ),
								'desc' => __ ( 'Tick it to turn conditional logic to work below', $nmpersonalizedproduct->plugin_meta ['shortname'] )
						),
						'conditions' => array (
								'type' => 'html-conditions',
								'title' => __ ( 'Conditions', $nmpersonalizedproduct->plugin_meta ['shortname'] ),
								'desc' => __ ( 'Tick it to turn conditional logic to work below', $nmpersonalizedproduct->plugin_meta ['shortname'] )
						),
				);
	}
	
	
	/*
	 * @params: $options
	*/
	function render_input($args, $options="", $default=""){
		
		//nm_personalizedproduct_pa($options);
		$_html = '<select ';
		
		foreach ($args as $attr => $value){
			
			$_html .= $attr.'="'.stripslashes( $value ).'"';
		}
		
		$_html .= '>';
		
		$_html .= '<option value="">'.__('Select option', $this -> plugin_meta['shortname']).'</option>';
		
		foreach($options as $opt)
		{
				
			$selected = ($opt['option'] == $default) ? 'selected="selected"' : '';
			
			if($opt['price']){
				$output	= stripslashes(trim($opt['option'])) .' - ' . woocommerce_price($opt['price']);
			}else{
				$output	= stripslashes(trim($opt['option']));
			}
				
			$_html .= '<option data-price="'.$opt['price'].'" value="'.$opt['option'].'" '. $selected.'>';
			$_html .= $output;
			$_html .= '</option>';
		}
		
		$_html .= '</select>';
		
		echo $_html;
	}
}