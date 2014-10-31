<?php
/** "News" block 
 * 
 * Optional to use horizontal lines/images
**/
class AQ_Start_Content_Block extends AQ_Block {
	
	//set and create block
	function __construct() {
		$block_options = array(
			'name' => 'Start Content',
			'size' => 'span12',
			'resizable' => 0
		);
		
		//create the block
		parent::__construct('aq_start_content_block', $block_options);
	}
	
	function form($instance) {
		
		$defaults = array(
			'color' => '#fff'
		);
		
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		
		
		?>
		<p class="description note">
			<?php _e('Use this block to create main content block after top Wrappers.', 'framework') ?>
		</p>
		<div class="description ">
			<label for="<?php echo $this->get_field_id('color') ?>">
				Background color<br/>
				<?php echo aq_field_color_picker('color', $block_id, $color, $defaults['color']) ?>
			</label>
			
		</div>
	
		<?php
		
	}
	
	function block($instance) {
		$defaults = array(
			'color' => '#fff'
		);
		
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		$text = '<div class="mainwrap" style="background:'.$color.'">
					<div class="main clearfix">
						<div class="content fullwidth">';
		echo wpautop(do_shortcode(htmlspecialchars_decode($text)));
	
}}