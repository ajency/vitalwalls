<?php
/**
 * The template for displaying product category thumbnails within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product_cat.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Increase loop count
$woocommerce_loop['loop']++;
?>
<article class="product-category product<?php
    if ( ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] == 0 || $woocommerce_loop['columns'] == 1 )
        echo ' first';
	if ( $woocommerce_loop['loop'] % $woocommerce_loop['columns'] == 0 )
		echo ' last';
	?>">
	<div class="mpcth-product-wrap">
		<header class="mpcth-post-header">
			<a class="mpcth-post-thumbnail" href="<?php echo get_term_link($category->slug, 'product_cat'); ?>">
				<?php do_action('woocommerce_before_subcategory_title', $category); ?>
			</a>
		</header>
		<section class="mpcth-post-content">
			<?php do_action('woocommerce_before_subcategory', $category); ?>

			<a href="<?php echo get_term_link($category->slug, 'product_cat'); ?>">
				<?php do_action('woocommerce_after_subcategory_title', $category); ?>
			</a>

			<h6 class="mpcth-post-title"><a href="<?php the_permalink(); ?>"><?php echo $category->name; ?></a></h6>
			<div class="mpcth-post-categories">
				<span class="count">
					<?php if ($category->count > 0) printf(_n('1 Item','%s Items', $category->count, 'mpcth'), $category->count); ?>
				</span>
			</div>

			<?php do_action('woocommerce_after_subcategory', $category); ?>
		</section>
	</div>
</article>