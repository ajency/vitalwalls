<?php
/** "News" block 
 * 
 * Optional to use horizontal lines/images
**/
class AQ_End_Content_Block extends AQ_Block {
	
	//set and create block
	function __construct() {
		$block_options = array(
			'name' => 'End Content',
			'size' => 'span12',
			'resizable' => 0
		);
		
		//create the block
		parent::__construct('aq_end_content_block', $block_options);
	}
	
	function form($instance) {
		
		

		

		extract($instance);
		
		
		?>
		<p class="description note">
			<?php _e('Use this block to create main content block after top Wrappers.', 'framework') ?>
		</p>

	
		<?php
		
	}
	
	function block($instance) {
		extract($instance);
		$text = '		</div></div>
					</div>';
		echo $text;
	
}}