<?php
/** "News" block 
 * 
 * Optional to use horizontal lines/images
**/
class AQ_Top_Wrapper_Portfolio_Block extends AQ_Block {
	
	//set and create block
	function __construct() {
		$block_options = array(
			'name' => 'Breadcrumb/Portfolio',
			'size' => 'span12',
			'resizable' => 0,
			'port_categories_breadcrumb' => array()
		);
		
		//create the block
		parent::__construct('aq_top_wrapper_portfolio_block', $block_options);
	}
	
	function form($instance) {
		
		$defaults = array(
			'filter' => 1,	

		);
			
		$instance = wp_parse_args($instance, $defaults);	
		extract($instance);
		
		$categories_port = ($temp = get_terms('portfoliocategory')) ? $temp : array();
		$categories_options = array();
		foreach($categories_port as $cat) {
			$categories_options[$cat->term_id] = $cat->name;
		}				
		if( function_exists( 'pmc_getcatname' ) ){	
			?>
			<p class="description note">
				<?php _e('Use this block to create top Wrapper with breadcrumb and portfolio categories.', 'framework') ?>
			</p>


			<p class="description half last">
				<label for="<?php echo $this->get_field_id('port_categories_breadcrumb') ?>">
					Portfolio Categories<br/>
				<?php echo aq_field_multiselect('port_categories_breadcrumb', $block_id, $categories_options, $port_categories_breadcrumb); ?>
				</label>
			</p>
			<p class="description half">
				<label for="<?php echo $this->get_field_id('filter') ?>">
					<?php echo aq_field_checkbox('filter', $block_id, $filter); ?>
					Show filter?
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
		if( function_exists( 'pmc_getcatname' ) ){
		
			if(!isset($port_categories_breadcrumb)){
				$port_categories_breadcrumb = ($temp = get_terms('portfoliocategory','fields=ids')) ? $temp : array();
					
			}
			?>
			<div class = "outerpagewrap">
					<div class="pagewrap">
						<div class="pagecontent">
							<div class="pagecontentContent">
								<div><?php echo pmc_breadcrumb() ?></div>
							</div>
							<div class="breadcrumb-info">
					
							<?php if($filter && count($port_categories_breadcrumb) > 0){ ?>				
						
								<div id="remove" class="portfolioremove">
									<h2>
									<a class="catlink" href="#filter=*" >Show All <span> / </span></a>
									<?php
									foreach ($port_categories_breadcrumb as $category) {

									$find =     array("&", "/", " ","amp;","&#38;");
									$replace  = array("", "", "", "","");
									$entrycategory = str_replace($find , $replace, pmc_getcatname($category,'portfoliocategory'));
										echo '<a class="catlink" href="#filter=.'.$entrycategory .'" >'.pmc_getcatname($category,'portfoliocategory').' <span class="aftersortingword"> / </span></a>';
									}
									?>
									</h2>
								</div>
							
							<?php } ?>
							</div>
						</div>

					</div>
				</div>

			<?php
		}
	}
		function update($new_instance, $old_instance) {
			return $new_instance;
		}
}