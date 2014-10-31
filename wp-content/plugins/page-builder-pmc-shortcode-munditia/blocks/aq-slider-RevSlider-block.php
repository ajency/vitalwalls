<?php

class AQ_Slider_Block_revolutionSlider extends AQ_Block {
	
	//set and create block
	function __construct() {
		$block_options = array(
			'name' => 'Revolution Slider',
			'size' => 'span12'
		);
		
		//create the block
		parent::__construct('aq_slider_block_revolutionslider', $block_options);
	}
	
	function form($instance) {
		
		$defaults = array(
			'revSliderAlias' => '',
		);
		

		
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);

		if(!is_plugin_active( 'revslider/revslider.php')) {
			echo __('Sorry, this block requires the Revolution Slider plugin to be installed & activated. Please install/activate the plugin before using this block. You can find plugin in theme folder /plugins/munditia.zip', 'framework');
			return false;
		}		
		
		?>
		<p class="description note">
			<?php _e('Use this block to include Revolution Sliders .', 'framework') ?>
		</p>
		<p class="description">
			<label for="<?php echo $this->get_field_id('revSliderAlias') ?>">
				Enter Revolution Sliders alias
				<?php echo aq_field_input('revSliderAlias', $block_id, $revSliderAlias, $size = 'full') ?>
			</label>
		</p>
	
	
		<?php
		
	}
	
	function block($instance) {
		extract($instance);
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		if(is_plugin_active( 'revslider/revslider.php')){			
			putRevSlider($revSliderAlias);
		}
	
	}

	function update($new_instance, $old_instance) {
		$new_instance = aq_recursive_sanitize($new_instance);
		return $new_instance;
	}

}