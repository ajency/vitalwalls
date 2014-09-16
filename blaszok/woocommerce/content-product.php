<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop;
global $shop_style;
global $mpcth_options;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] )
	$classes[] = 'first';
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
	$classes[] = 'last';

// Check for second image
$product_gallery = $product->get_gallery_attachment_ids();

$disable_hover_slide = get_field('mpc_disable_hover_slide');
$custom_hover_image = get_field('mpc_custom_hover_image');
$display_second_image = '';
if (!$disable_hover_slide && (! empty($product_gallery) || $custom_hover_image))
	$display_second_image = ' mpcth-double-image';

if (! empty($mpcth_options['mpcth_disable_product_hover']) && $mpcth_options['mpcth_disable_product_hover'])
	$display_second_image = '';

$quickview_text = __('Quickview', 'mpcth');
$quickview_icon = 'eye';

global $jckqv;
if (isset($jckqv)) {
	$quickview_settings = $jckqv->settings->__getSettings();
	$quickview_text = $quickview_settings['trigger_styling_text'];
	$quickview_icon = $quickview_settings['trigger_styling_icon'];
}

?>
<article id="post-<?php the_ID(); ?>" <?php post_class('mpcth-waypoint ' . implode($classes, ' ') . $display_second_image); ?> >
	<div class="mpcth-product-wrap">
		<?php do_action('woocommerce_before_shop_loop_item_title'); ?>
		<header class="mpcth-post-header">
			<a class="mpcth-post-thumbnail" href="<?php the_permalink(); ?>">
				<?php do_action('mpcth_before_shop_loop_item_title'); ?>
			</a>
			<div class="mpcth-product-panel">
				<?php if (shortcode_exists('yith_wcwl_add_to_wishlist')) echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>
				<?php if (class_exists('jckqv')) { ?>
					<div class="mpcth-quick-view">
						<div class="mpcth-tooltip-wrap">
							<a href="<?php the_permalink(); ?>" class="mpcth-tooltip-text" data-jckqvpid="<?php the_ID(); ?>"><i class="fa fa-fw fa-<?php echo $quickview_icon; ?>"></i></a>
							<div class="mpcth-tooltip-message mpcth-color-main-background mpcth-color-main-border"><?php echo $quickview_text; ?></div>
						</div>
					</div>
				<?php } ?>
			</div>
		</header>
		<section class="mpcth-post-content<?php echo $product->get_price_html() == '' ? ' mpcth-empty-price' : ''; ?>">
		<?php if (isset($shop_style)) { ?>
			<?php if ($shop_style == 'slim') { ?>
				<div class="mpcth-post-content-wrap">
					<?php woocommerce_template_loop_price(); ?>
					<h6 class="mpcth-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
					<?php mpcth_wc_product_categories(); ?>
					<div class="mpcth-cart-wrap">
						<?php woocommerce_template_loop_add_to_cart(); ?>
						<?php if (shortcode_exists('yith_wcwl_add_to_wishlist')) echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>
						<?php if (class_exists('jckqv')) { ?>
							<a href="<?php the_permalink(); ?>" class="mpcth-quick-view" data-jckqvpid="<?php the_ID(); ?>"><i class="fa fa-fw fa-<?php echo $quickview_icon; ?>"></i><span><?php echo $quickview_text; ?></span></a>
						<?php } ?>
					</div>
				</div>
			<?php } elseif ($shop_style == 'center') { ?>
				<div class="mpcth-post-content-wrap">
					<?php woocommerce_template_loop_price(); ?>
					<h6 class="mpcth-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
					<?php mpcth_wc_product_categories(); ?>
					<div class="mpcth-price-wrap">
						<?php woocommerce_template_loop_price(); ?>
					</div>
					<div class="mpcth-cart-wrap">
						<?php woocommerce_template_loop_add_to_cart(); ?>
						<?php if (shortcode_exists('yith_wcwl_add_to_wishlist')) echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>
						<?php if (class_exists('jckqv')) { ?>
							<a href="<?php the_permalink(); ?>" class="mpcth-quick-view" data-jckqvpid="<?php the_ID(); ?>"><i class="fa fa-fw fa-<?php echo $quickview_icon; ?>"></i><span><?php echo $quickview_text; ?></span></a>
						<?php } ?>
					</div>
				</div>
			<?php } else { ?>
				<div class="mpcth-cart-wrap">
					<?php woocommerce_template_loop_price(); ?>
					<?php woocommerce_template_loop_add_to_cart(); ?>
				</div>
				<h6 class="mpcth-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
				<?php mpcth_wc_product_categories(); ?>
			<?php } ?>
		<?php } else { ?>
			<div class="mpcth-cart-wrap">
				<?php woocommerce_template_loop_price(); ?>
				<?php woocommerce_template_loop_add_to_cart(); ?>
			</div>
			<h6 class="mpcth-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
			<?php mpcth_wc_product_categories(); ?>
		<?php } ?>
		</section>
	</div>
</article>