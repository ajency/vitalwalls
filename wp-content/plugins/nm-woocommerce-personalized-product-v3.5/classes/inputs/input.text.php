<?php
/*
 * Followig class handling text input control and their
* dependencies. Do not make changes in code
* Create on: 9 November, 2013
*/

class NM_Text extends NM_Inputs_wooproduct{
	
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
		
		$this -> title 		= __ ( 'Text Input', 'nm-personalizedproduct' );
		$this -> desc		= __ ( 'regular text input', 'nm-personalizedproduct' );
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
				
						'max_length' => array (
								'type' => 'text',
								'title' => __ ( 'Max. Length', $nmpersonalizedproduct->plugin_meta ['shortname'] ),
								'desc' => __ ( 'Max. characters allowed, leave blank for default', $nmpersonalizedproduct->plugin_meta ['shortname'] )
						),
						
						/* 'min_length' => array (
								'type' => 'text',
								'title' => __ ( 'Min. Length', $nmpersonalizedproduct->plugin_meta ['shortname'] ),
								'desc' => __ ( 'Min. characters allowed, leave blank for default', $nmpersonalizedproduct->plugin_meta ['shortname'] )
						), */
						
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
	 * @params: args
	*/
	function render_input($args, $content=""){
		
		$_html = '<input type="text" ';
		
		foreach ($args as $attr => $value){
			
			$_html .= $attr.'="'.stripslashes( $value ).'"';
		}
		
		if($content)
			$_html .= 'value="' . stripslashes($content	) . '"';
		
		$_html .= ' />';
		
		echo $_html;
	}
}