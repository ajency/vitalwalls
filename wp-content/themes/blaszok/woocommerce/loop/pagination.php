<?php
/**
 * Pagination - Show numbered pagination for catalog pages.
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $wp_query;

if ( $wp_query->max_num_pages <= 1 )
	return;
?>
<nav class="woocommerce-pagination">
	<a href="#" id="mpcth_shop_load_more"><?php _e('Load more', 'mpcth'); ?><span class="mpcth-load-more-icon"></span></a>
	<?php
		echo paginate_links( apply_filters( 'woocommerce_pagination_args', array(
			'base' 			=> str_replace( 999999999, '%#%', get_pagenum_link( 999999999 ) ),
			'format' 		=> '',
			'current' 		=> max( 1, get_query_var('paged') ),
			'total' 		=> $wp_query->max_num_pages,
			'prev_text' 	=> '<i class="fa fa-angle-left"></i>',
			'next_text' 	=> '<i class="fa fa-angle-right"></i>',
			'type'			=> 'list',
			'end_size'		=> 3,
			'mid_size'		=> 3
		) ) );
	?>
	<div id="mpcth_shop_load_more_wrapper" data-max-pages="<?php echo $wp_query->max_num_pages; ?>"></div>
</nav>