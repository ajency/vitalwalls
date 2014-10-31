<?php
/** "News" block 
 * 
 * Optional to use horizontal lines/images
**/
class AQ_Product_Block_Feed extends AQ_Block {
	
	//set and create block
	function __construct() {
		$block_options = array(
			'name' => 'Recent product',
			'size' => 'span12',
			'resizable' => 0,
			'categories_product' => array()	
		);
		
		//create the block
		parent::__construct('aq_product_block_feed', $block_options);
	}
	
	function form($instance) {
		
		$defaults = array(
			'title' => '',
			'number_post' => '',
			'rowsB' => '',
			'categories_product' => '',
			'port_text' => '',
			'product_ajax' => 'false'
		);
		
		$ajax_options = array(
			'true' => 'True',
			'false' => 'False',
		);
		

		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		
		$port_categories = ($temp = get_terms('product_cat')) ? $temp : array();
		$categories_options = array();
		foreach($port_categories as $cat) {
			$categories_options[$cat->term_id] = $cat->name;
		}		
		if( function_exists( 'pmc_productBlock' ) ){	
		?>
		<p class="description note">
			<?php _e('Use this block to create news feed.', 'framework') ?>
		</p>
		<p class="description ">
			<label for="<?php echo $this->get_field_id('title') ?>">
				Title (optional)
				<?php echo aq_field_input('title', $block_id, $title, $size = 'full') ?>
			</label>
		</p>
		<p class="description half">
			<label for="<?php echo $this->get_field_id('categories_product') ?>">
			Product Categories<br/>
			<?php echo aq_field_multiselect('categories_product', $block_id, $categories_options, $categories_product); ?>
			</label>
		</p>		
		<p class="description half last">
			<label for="<?php echo $this->get_field_id('number_post') ?>">
				Number of product to show (optional)- if you leave empty theme admin settings will be used
				<?php echo aq_field_input('number_post', $block_id, $number_post, $size = 'full') ?>
			</label>
		</p>	
		<p class="description half">
			<label for="<?php echo $this->get_field_id('rowsB') ?>">
				If you have more then 4 product you can define how many portfolio you wish to display in one slide - if you leave empty theme admin settings will be used
				<?php echo aq_field_input('rowsB', $block_id, $rowsB, $size = 'full') ?>
			</label>
		</p>		
		<p class="description half last">
			<label for="<?php echo $this->get_field_id('product_ajax') ?>">
				Use ajax<br/>
				<?php echo aq_field_select('product_ajax', $block_id, $ajax_options, $product_ajax); ?>
			</label>
		</p>		

		<?php
		}
		else {
			echo '<p class="description note">For this block you need to use PremiumCoding themes!</p>';
		}		
	}
	
	function block($instance) {
		$defaults = array(
			'port_text' => ''
		);

		$instance = wp_parse_args($instance, $defaults);	
		extract($instance);

		$port_categories = ($temp = get_terms('product_cat')) ? $temp : array();
		$i = 0;		
		foreach($port_categories as $cat) {
			$categories_temp[$i] = $cat->term_id;
			$i++;
		}			
		if(!empty($categories_product)){
			$categories_product = $categories_product;
		}
		else{
			$categories_product = $categories_temp;
		}	
		
		wp_enqueue_script('pmc_any');
		wp_enqueue_script('pmc_any_fx');
		wp_enqueue_script('pmc_any_video');
		if( function_exists( 'pmc_productBlock' ) ){			
			pmc_productBlock($title,$number_post,$rowsB,$categories_product,$port_text,'recent',$product_ajax);
		}
	
	}
	
	function update($new_instance, $old_instance) {
		$new_instance = aq_recursive_sanitize($new_instance);
		return $new_instance;
	}

}