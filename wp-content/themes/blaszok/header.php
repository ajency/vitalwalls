<?php
/**
 * The Header base for MPC Themes
 *
 * Displays all of the <head> section and everything up till <div id="mpcth_main">
 *
 * @package WordPress
 * @subpackage MPC Themes
 * @since 1.0
 */

global $post;
global $page_id;
global $paged;
global $mpcth_options;
global $sidebar_position;
global $content_width;

if (isset($post))
	$page_id = $post->ID;
else
	$page_id = 0;

if(function_exists('is_woocommerce') && (is_shop() || is_product_category() || is_product_tag()))
	$page_id = get_option('woocommerce_shop_page_id');

$paged = (get_query_var('paged')) ? get_query_var('paged') : ((get_query_var('page')) ? get_query_var('page') : 1);

$sidebar_position = mpcth_get_sidebar_position();

if ($sidebar_position == 'none')
	$content_width = 1200;
else
	$content_width = 900;

$style = '';
if ($mpcth_options['mpcth_boxed_type'] != 'fullwidth' && $mpcth_options['mpcth_background_type'] != 'none') {
	$bg_type = $mpcth_options['mpcth_background_type'];

	$style = 'style="';
	if ($bg_type == 'color') {
		$style .= 'background-color:' . $mpcth_options['mpcth_bg_color'];
	} elseif ($bg_type == 'custom_background') {
		if (! empty($mpcth_options['mpcth_bg_image'])) {
			$style .= 'background-image:url(' . $mpcth_options['mpcth_bg_image'] . ');' . ($mpcth_options['mpcth_enable_bg_image_repeat'] ? 'background-repeat:repeat;' : 'background-repeat:no-repeat;background-position:center;background-size:100%;background-size:cover;background-attachment:fixed;');

			$bg_image = '<img class="mpcth-page-background" src="' . $mpcth_options['mpcth_bg_image'] . '" />';
		}
	} elseif ($bg_type == 'pattern_background') {
		$style .= 'background-image:url(' . MPC_THEME_URI . '/panel/images/patterns/' . $mpcth_options['mpcth_bg_pattern'] . '.png); background-repeat:repeat;';
	}
	$style .= '"';

	if ($bg_type != 'color')
		$bg_cover = '<div class="mpcth-background-cover' . ($bg_type == 'custom_background' ? ' mpcth-image' : '') . '" ' . $style . '></div>';
}

$disable_responsive = isset($mpcth_options['mpcth_disable_responsive']) && $mpcth_options['mpcth_disable_responsive'];

$disable_product_cart = isset($mpcth_options['mpcth_disable_product_cart']) && $mpcth_options['mpcth_disable_product_cart'];
$disable_product_price = $disable_product_cart && isset($mpcth_options['mpcth_disable_product_price']) && $mpcth_options['mpcth_disable_product_price'];

$masonry_shop = false;
$load_more_shop = false;
if (function_exists('is_woocommerce') && (is_shop() || is_product_category() || is_product_tag())) {
	if (! empty($_GET['masonry'])) {
		if ($_GET['masonry'] == 1) {
			$masonry_shop = true;
			$load_more_shop = false;
		} elseif ($_GET['masonry'] == 2) {
			$masonry_shop = true;
			$load_more_shop = true;
		}
	} else {
		$masonry_shop = function_exists('is_woocommerce') && (is_shop() || is_product_category() || is_product_tag()) && isset($mpcth_options['mpcth_enable_masonry_shop']) && $mpcth_options['mpcth_enable_masonry_shop'];
		$load_more_shop = $masonry_shop && isset($mpcth_options['mpcth_enable_shop_load_more']) && $mpcth_options['mpcth_enable_shop_load_more'];
	}
}

$disable_mobile_slider_nav = isset($mpcth_options['mpcth_disable_mobile_slider_nav']) && $mpcth_options['mpcth_disable_mobile_slider_nav'];

?>

<!DOCTYPE html>
<!--[if IE 8]> <html class="ie<?php echo ! $disable_responsive ? ' mpcth-responsive' : ''; ?>" <?php language_attributes(); ?>><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> <?php echo ! $disable_responsive ? 'class="mpcth-responsive"' : ''; ?>> <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title><?php wp_title(' | ', true, 'right'); ?></title>

	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php if ($mpcth_options['mpcth_enable_fav_icon']) { ?>
		<link rel="icon" type="image/png" href="<?php echo $mpcth_options['mpcth_fav_icon']; ?>">
	<?php } ?>

	<!--[if lt IE 9]>
		<script src="<?php echo MPC_THEME_URI ?>/js/html5.js"></script>
	<![endif]-->

	<?php
		if (is_singular() && get_option('thread_comments'))
			wp_enqueue_script('comment-reply');

		wp_head();
	?>
</head>
<!-- mpcth-responsive -->
<body <?php body_class('mpcth-sidebar-' . mpcth_get_sidebar_position()); ?> <?php echo ! isset($bg_cover) ? $style : ''; ?>>
	<?php if (isset($bg_image)) echo $bg_image; ?>
	<?php if (isset($bg_cover)) echo $bg_cover; ?>

	<div id="mpcth_page_wrap" class="<?php
		echo ($mpcth_options['mpcth_boxed_type'] != 'fullwidth') ? 'mpcth-boxed ' : '';
		echo ($mpcth_options['mpcth_boxed_type'] == 'floating_boxed') ? 'mpcth-floating-boxed ' : '';
		echo ($mpcth_options['mpcth_theme_skin'] == 'skin_dark') ? 'mpcth-skin-dark ' : '';
		echo ($disable_product_cart) ? 'mpcth-disable-add-to-cart ' : '';
		echo ($disable_product_price) ? 'mpcth-disable-price ' : '';
		echo ($masonry_shop) ? 'mpcth-masonry-shop ' : '';
		echo ($load_more_shop) ? 'mpcth-load-more-shop ' : '';
		echo (is_rtl()) ? 'mpcth-rtl ' : '';
		echo ($disable_mobile_slider_nav) ? 'mpcth-no-mobile-slider-nav ' : '';
	?>">

		<a id="mpcth_toggle_mobile_menu" class="mpcth-color-main-color-hover" href="#"><i class="fa fa-bars"></i><i class="fa fa-times"></i></a>
		<div id="mpcth_mobile_nav_wrap">
			<nav id="mpcth_nav_mobile" role="navigation">
				<?php
					if (has_nav_menu('mpcth_mobile_menu')) {
						wp_nav_menu(array(
							'theme_location' => 'mpcth_mobile_menu',
							'container' => '',
							'menu_id' => 'mpcth_mobile_menu',
							'menu_class' => 'mpcth-mobile-menu',
							'link_before' => '<span class="mpcth-color-main-border">',
							'link_after' => '</span>',
						));
					} elseif (has_nav_menu('mpcth_menu')) {
						wp_nav_menu(array(
							'theme_location' => 'mpcth_menu',
							'container' => '',
							'menu_id' => 'mpcth_mobile_menu',
							'menu_class' => 'mpcth-mobile-menu',
							'link_before' => '<span class="mpcth-color-main-border">',
							'link_after' => '</span>',
						));
					} else {
						wp_nav_menu(array(
							'container' => '',
							'menu_id' => 'mpcth_mobile_menu',
							'menu_class' => 'mpcth-mobile-menu',
							'link_before' => '<span class="mpcth-color-main-border">',
							'link_after' => '</span>',
						));
					}
				?>
			</nav><!-- end #mpcth_nav_mobile -->
		</div>

		<div id="mpcth_page_header_wrap_spacer"></div>
		<?php
			$enable_sticky_header = true;
			if (isset($mpcth_options['mpcth_enable_sticky_header']))
				$enable_sticky_header = $mpcth_options['mpcth_enable_sticky_header'];
		?>
		<header id="mpcth_page_header_wrap" class="<?php echo $enable_sticky_header ? 'mpcth-sticky-header-enabled' : ''; ?>">
			<div id="mpcth_page_header_container">
				<?php
				if ($mpcth_options['mpcth_enable_secondary_header'] && $mpcth_options['mpcth_header_secondary_position'] == 'top') {
					mpcth_display_secondary_header();
				}
				?>
				<?php
				$header_order = 'l_m_s';
				if ($mpcth_options['mpcth_header_main_layout'])
					$header_order = $mpcth_options['mpcth_header_main_layout'];

				$header_order_items = explode('_', $header_order);
				?>
				<div id="mpcth_page_header_content" class="mpcth-header-order-<?php echo $header_order; ?>">
					<?php
					foreach ($header_order_items as $item) {
						if ($item == 'l' || $item == 'tl') { ?>
							<div id="mpcth_logo_wrap">
								<a id="mpcth_logo" href="<?php echo get_home_url(); ?>">
									<?php if (! $mpcth_options['mpcth_enable_text_logo'] && $mpcth_options['mpcth_logo'] != '') { ?>
										<img src="<?php echo $mpcth_options['mpcth_logo']; ?>" class="mpcth-standard-logo" alt="Logo">
										<?php if ($mpcth_options['mpcth_logo_2x'] != '') { ?>
											<img src="<?php echo $mpcth_options['mpcth_logo_2x']; ?>" class="mpcth-retina-logo" alt="Logo">
										<?php } else { ?>
											<img src="<?php echo $mpcth_options['mpcth_logo']; ?>" class="mpcth-retina-logo" alt="Logo">
										<?php } ?>
									<?php } else { ?>
										<h1><?php echo $mpcth_options['mpcth_text_logo'] != '' ? $mpcth_options['mpcth_text_logo'] : get_bloginfo('name', 'display'); ?></h1>
									<?php } ?>
								</a>
								<?php if($mpcth_options['mpcth_text_logo_description']) { ?>
									<small><?php echo get_bloginfo('description'); ?></small>
								<?php } ?>
							</div><!-- end #mpcth_logo_wrap -->
						<?php }
						if ($item == 'm' || $item == 'rm' || $item == 'cm') { ?>
							<?php
							if ($header_order == 'tl_m_s')
								echo '<div id="mpcth_center_header_wrap">';
							?>
							<nav id="mpcth_nav" role="navigation">
								<?php
									if(isset($mpcth_options['mpcth_enable_mega_menu']) && $mpcth_options['mpcth_enable_mega_menu']) {
										echo '<ul id="mpcth_mega_menu">';
											dynamic_sidebar('mpcth_main_menu');
										echo '</ul>';
									} else {
										if(has_nav_menu('mpcth_menu')) {
											wp_nav_menu(array(
												'theme_location' => 'mpcth_menu',
												'container' => '',
												'menu_id' => 'mpcth_menu',
												'menu_class' => 'mpcth-menu'
											));
										} else {
											wp_nav_menu(array(
												'container' => '',
												'menu_id' => 'mpcth_menu',
												'menu_class' => 'mpcth-menu'
											));
										}
									}
								?>
							</nav><!-- end #mpcth_nav -->
						<?php }
						if ($item == 's' || $item == 'cs') { ?>
							<div id="mpcth_controls_wrap">
								<div id="mpcth_controls_container">
									<?php
										$header_search = true;
										if (isset($mpcth_options['mpcth_enable_header_search']) && ! $mpcth_options['mpcth_enable_header_search'])
											$header_search = false;
									?>
									<?php if ($header_search) { ?>
										<a id="mpcth_search" href="#"><i class="fa fa-fw fa-search"></i></a>
									<?php } ?>
									<?php
										$disable_header_cart = isset($mpcth_options['mpcth_disable_header_cart']) && $mpcth_options['mpcth_disable_header_cart'];
									?>
									<?php if (function_exists('is_woocommerce') && ! $disable_header_cart) { ?>
										<a id="mpcth_cart" href="<?php echo WC()->cart->get_cart_url(); ?>" class="<?php echo sizeof(WC()->cart->get_cart()) > 0 ? 'active' : ''; ?>">
											<span class="mpcth-mini-cart-icon-info">
												<?php if (sizeof( WC()->cart->get_cart()) > 0) { ?>
													<?php echo __('Subtotal', 'mpcth'); ?>: <?php echo WC()->cart->get_cart_subtotal(); ?> (<?php echo WC()->cart->cart_contents_count; ?>)
												<?php } ?>
											</span>
											<i class="fa fa-fw fa-shopping-cart"></i>
										</a>
										<div id="mpcth_mini_cart">
											<?php mpcth_wc_print_mini_cart(); ?>
										</div>
									<?php } ?>
								</div>
							</div><!-- end #mpcth_controls_wrap -->
							<?php
							if ($header_order == 'tl_m_s')
								echo '</div><!-- end #mpcth_center_header_wrap -->';
							?>
						<?php }
					}
					?>
				</div><!-- end #mpcth_page_header_content -->
				<?php
				if ($mpcth_options['mpcth_enable_secondary_header'] && $mpcth_options['mpcth_header_secondary_position'] == 'bottom') {
					mpcth_display_secondary_header();
				}
				?>
			</div><!-- end #mpcth_page_header_container -->
			<div id="mpcth_smart_search_wrap">
				<form role="search" method="get" id="searchform" action="<?php echo home_url(); ?>">
					<?php if (isset($mpcth_options['mpcth_enable_smart_search']) && $mpcth_options['mpcth_enable_smart_search'] && function_exists('is_woocommerce')) {
							$currency_position = get_option('woocommerce_currency_pos');
							$add_space = $currency_position == 'right_space' || $currency_position == 'left_space' ? ' ' : '';
						?>
						<input type="hidden" name="post_type" value="product">
						<input type="hidden" name="" id="mpcth_currency_symbol" value="<?php echo ($currency_position == 'right_space' ? ' ' : '') . get_woocommerce_currency_symbol() . ($currency_position == 'left_space' ? ' ' : ''); ?>" data-position="<?php echo $currency_position; ?>">
						<?php
							echo '<ul id="mpcth_smart_search">';
								dynamic_sidebar('mpcth_smart_search');
							echo '</ul>';
						?>
						<div class="mpcth-smart-search-divider"><?php _e('-&nbsp;&nbsp;&nbsp;OR&nbsp;&nbsp;&nbsp;-', 'mpcth'); ?></div>
						<input type="text" value="" name="s" id="s" placeholder="<?php _e('Search for products', 'mpcth'); ?>">
					<?php } else { ?>
						<input type="text" value="" name="s" id="s" placeholder="<?php _e('Search...', 'mpcth'); ?>">
					<?php } ?>
					<div class="mpcth-smart-search-submit-wrap">
						<p>
							<input type="submit" id="searchsubmit" value="<?php _e('Find my items', 'mpcth'); ?>">
							<i class="fa fa-search"></i>
						</p>
					</div>
				</form>
			</div>
		</header><!-- end #mpcth_page_header_wrap -->