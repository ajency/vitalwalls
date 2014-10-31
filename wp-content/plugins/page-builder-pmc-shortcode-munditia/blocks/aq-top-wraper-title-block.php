<?php
/** "News" block 
 * 
 * Optional to use horizontal lines/images
**/
class AQ_Top_Wrapper_Title_Block extends AQ_Block {
	
	//set and create block
	function __construct() {
		$block_options = array(
			'name' => 'Breadcrumb',
			'size' => 'span12',
			'resizable' => 0
		);
		
		//create the block
		parent::__construct('aq_top_wrapper_title_block', $block_options);
	}
	
	function form($instance) {
		
		$defaults = array();
			
		$instance = wp_parse_args($instance, $defaults);	
		extract($instance);	
		if( function_exists( 'pmc_breadcrumb' ) ){
			?>
			<p class="description note">
				<?php _e('Use this block to create top Wrapper with breadcrumb.', 'framework') ?>
			</p>
		<?php
		}else {
			echo '<p class="description note">For this block you need to use PremiumCoding themes!</p>';
		}			
	}
	
	function block($instance) {
		$defaults = array(
				'big_title' => '',
				'small_title' => '',
				'icon' => 'icon-file'
			);
			
		$instance = wp_parse_args($instance, $defaults);	
		extract($instance);
		if( function_exists( 'pmc_breadcrumb' ) ){
			$text = '<div class = "outerpagewrap">
					<div class="pagewrap">
						<div class="pagecontent">
							<div class="pagecontentContent">
								<div>'. pmc_breadcrumb() .' </div>
							</div>
						</div>

					</div>
				</div>';
			echo wpautop(do_shortcode(htmlspecialchars_decode($text)));
		}
	
}}