<?php
/** "News" block 
 * 
 * Optional to use horizontal lines/images
**/
class AQ_Title_Border_Block extends AQ_Block {
	
	//set and create block
	function __construct() {
		$block_options = array(
			'name' => 'Title with border',
			'size' => 'span3'
		);
		
		//create the block
		parent::__construct('aq_title_border_block', $block_options);
	}
	
	function form($instance) {
		
		$defaults = array(
			'title' => '',
			'show_border' => ''
		);
		

		
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		
		
		?>
		<p class="description note">
			<?php _e('Use this block to create title with border.', 'framework') ?>
		</p>
		<p class="description ">
			<label for="<?php echo $this->get_field_id('title') ?>">
				Title
				<?php echo aq_field_input('title', $block_id, $title, $size = 'full') ?>
			</label>
		</p>
		<p class="description">
			<label for="<?php echo $this->get_field_id('show_border') ?>">
			<?php echo aq_field_checkbox('show_border', $block_id, $show_border); ?> &nbsp; Show border
			</label>
		</p>
	
	
		<?php
		
	}
	
	function block($instance) {
			$defaults = array(
			'title' => '',
			'show_border' => ''
		);
		

		
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		if($show_border)
			$text = '<div class="border-block"><div class="titlebordrtext"><h2 class="titleborderh2">'. $title .'</h2></div>	
							<div class="titleborderOut"><div class="titleborder"></div></div></div>';
		else
			$text = '<h2>'.$title.'</h2>';
		echo wpautop(do_shortcode(htmlspecialchars_decode($text)));
	
}}