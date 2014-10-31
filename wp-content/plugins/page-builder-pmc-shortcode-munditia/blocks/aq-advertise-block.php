<?php
/** "News" block 
 * 
 * Optional to use horizontal lines/images
**/
class AQ_Advertise_Block extends AQ_Block {
	
	//set and create block
	function __construct() {
		$block_options = array(
			'name' => 'Advertise',
			'size' => 'span12',
			'resizable' => 0
		);
		
		//create the block
		parent::__construct('aq_advertise_block', $block_options);
	}
	
	function form($instance) {
		
		$defaults = array(
			'title' => ''
		);
		

		
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		
		if( function_exists( 'pmc_advertiseBlock' ) ){
		?>
		<p class="description note">
			<?php _e('Use this block to create news feed.', 'framework') ?>
		</p>
		<p class="description">
			<label for="<?php echo $this->get_field_id('title') ?>">
				Title (optional)
				<?php echo aq_field_input('title', $block_id, $title, $size = 'full') ?>
			</label>
		</p>

	
		<?php
		}
		else {
			echo '<p class="description note">For this block you need to use PremiumCoding themes!</p>';
		}		
	}
	
	function block($instance) {
		extract($instance);
		if( function_exists( 'pmc_advertiseBlock' ) ){
			pmc_advertiseBlock($title);
		}
}
}