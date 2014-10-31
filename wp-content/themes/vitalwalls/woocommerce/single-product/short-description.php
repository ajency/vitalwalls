<?php
/**
 * Single product short description
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     99.99
 */

global $post, $product, $pmc_data , $wpdb;


?>

	<div class="titleSP">
		<h2><?php the_title(); ?></h2>
		<p>	
			<?php if ( $product->is_type( array( 'simple', 'variable' ) ) && get_option('woocommerce_enable_sku') == 'yes' && $product->get_sku() ) : ?>
			<span itemprop="productID" class="sku"><?php _e('SKU:', 'woocommerce'); ?> <?php echo $product->get_sku(); ?></span>
			<?php endif; ?>
		</p>
		<div class="author-link">
			View Other Products by <?php echo the_author_posts_link(); ?>
		</div>
	</div>

	<?php do_action( 'vital_single_sharer' ); ?>

	<?php if($post->post_excerpt) { ?>
	<div class="descriptionSP short">
		<?php echo apply_filters( 'woocommerce_short_description', $post->post_excerpt ); ?>
	</div>
	<?php } ?>
	<div class="cart-wraper-SP">
	<div class="recentCart"><?php // woocommerce_template_loop_add_to_cart(  $product ); ?></div>
