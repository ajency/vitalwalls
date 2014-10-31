<?php
/** "News" block 
 * 
 * Optional to use horizontal lines/images
**/
class AQ_Quote_Title_Block extends AQ_Block {
	
	//set and create block
	function __construct() {
		$block_options = array(
			'name' => 'Quote full width',
			'size' => 'span12',
			'resizable' => 0
		);
		
		//create the block
		parent::__construct('aq_quote_title_block', $block_options);
	}
	
	function form($instance) {
		
		//get all registered sidebars
		global $wp_registered_sidebars;

		
		$defaults = array(
			'title' => '',
			'title_small' => ''
		);	

		
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		
		
		?>
		<p class="description note">
			<?php _e('Use this block to quote with widget under slider area.', 'framework') ?>
		</p>
		<p class="description">
			<label for="<?php echo $this->get_field_id('title') ?>">
				Title
				<?php echo aq_field_input('title', $block_id, $title, $size = 'full') ?>
			</label>
		</p>
		<p class="description">
			<label for="<?php echo $this->get_field_id('title_small') ?>">
				Small title
				<?php echo aq_field_input('title_small', $block_id, $title_small, $size = 'full') ?>
			</label>
		</p>		
		

	
		<?php
		
	}
	
	function block($instance) {
		extract($instance);
		?>
		<div class="infotextwrap">
			<div class="infotext">
				<div class="infotext-title">
					<h2><?php echo do_shortcode(htmlspecialchars_decode($title)) ?></h2>
					<div class="infotext-title-small"><?php echo wpautop(do_shortcode(htmlspecialchars_decode($title_small))) ?></div>
				</div>
			</div>
		</div>
		<?php
	
}}