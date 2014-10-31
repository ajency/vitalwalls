<?php

define('MPC_OPTIONS_NAME', 'mpcth_options_theme_customizer');
define('MPC_THEME_PATH', get_template_directory());
define('MPC_THEME_URI', get_template_directory_uri());
define('MPC_THEME_ENABLED', true);

global $page_id;
global $mpcth_options;

$mpcth_options = get_option(MPC_OPTIONS_NAME);

/* ---------------------------------------------------------------- */
/* Theme setup
/* ---------------------------------------------------------------- */
add_action('after_setup_theme', 'mpcth_theme_setup');
function mpcth_theme_setup(){
	if (function_exists('add_theme_support')) {
		add_theme_support('post-thumbnails');
		add_theme_support('automatic-feed-links');
		add_theme_support('post-formats', array('gallery', 'video', 'audio', 'link', 'aside', 'quote', 'status', 'chat'));
		add_theme_support('woocommerce');

		add_image_size('mpcth-horizontal-columns-1', 1200, 900, true);
		add_image_size('mpcth-horizontal-columns-2', 600, 450, true);
		add_image_size('mpcth-horizontal-columns-3', 400, 300, true);
		add_image_size('mpcth-horizontal-columns-4', 300, 225, true);

		add_image_size('mpcth-vertical-columns-1', 1200, 1600, true);
		add_image_size('mpcth-vertical-columns-2', 600, 800, true);
		add_image_size('mpcth-vertical-columns-3', 400, 533, true);
		add_image_size('mpcth-vertical-columns-4', 300, 400, true);

		add_editor_style();
	}
	/* Enabling translations */
	load_theme_textdomain('mpcth', MPC_THEME_PATH . '/languages');
	load_child_theme_textdomain( 'mpcth', get_stylesheet_directory() . '/languages' );
}

/* ---------------------------------------------------------------- */
/* Location Files
/* ---------------------------------------------------------------- */
$locale = get_locale();
$locale_file = MPC_THEME_URI . "/languages/$locale.php";
if (is_readable($locale_file) )
	require_once($locale_file);

/* ---------------------------------------------------------------- */
/* WP Title
/* ---------------------------------------------------------------- */
add_filter('wp_title', 'mpcth_wp_title', 10, 2);
function mpcth_wp_title($title, $sep) {
	global $paged;

	if (is_feed())
		return $title;

	// Add the blog name.
	$title .= get_bloginfo('name');

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo('description', 'display');
	if ($site_description && (is_home() || is_front_page()) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ($paged > 1)
		$title = "$title $sep " . __('Page ', 'mpcth') . $paged;

	return $title;
}

/* ---------------------------------------------------------------- */
/* Enqueue theme scripts and styles
/* ---------------------------------------------------------------- */
add_action('wp_enqueue_scripts', 'mpcth_enqueue_scripts');
function mpcth_enqueue_scripts() {
	global $mpcth_options;
	$protocol = is_ssl() ? 'https' : 'http';

	if (isset($mpcth_options['mpcth_content_font']) && is_array($mpcth_options['mpcth_content_font'])) {
		if ($mpcth_options['mpcth_content_font']['type'] == 'google') {
			$content_family = str_replace(' ', '+', $mpcth_options['mpcth_content_font']['family']);
			$content_style = $mpcth_options['mpcth_content_font']['style'] != 'regular' ? ':' . $mpcth_options['mpcth_content_font']['style'] : '';
			wp_enqueue_style('mpc-content-font', "$protocol://fonts.googleapis.com/css?family={$content_family}{$content_style}");
		}
	}
	if (isset($mpcth_options['mpcth_heading_font']) && is_array($mpcth_options['mpcth_heading_font'])) {
		if ($mpcth_options['mpcth_heading_font']['type'] == 'google') {
			$heading_family = str_replace(' ', '+', $mpcth_options['mpcth_heading_font']['family']);
			$heading_style = $mpcth_options['mpcth_heading_font']['style'] != 'regular' ? ':' . $mpcth_options['mpcth_heading_font']['style'] : '';
			wp_enqueue_style('mpc-heading-font', "$protocol://fonts.googleapis.com/css?family={$heading_family}{$heading_style}");
		} else {
			wp_enqueue_style('mpc-heading-font', "$protocol://fonts.googleapis.com/css?family=Lato:700");
		}
	}

	$main_color = isset($mpcth_options['mpcth_color_main']) ? $mpcth_options['mpcth_color_main'] : '#B163A3';
	$base_font_size = isset($mpcth_options['mpcth_base_font_size']) ? $mpcth_options['mpcth_base_font_size'] : '12px';
	$custom_styles = "
	body {font-size: $base_font_size;}
	#mpcth_page_wrap #mpcth_sidebar a:hover,#mpcth_page_wrap #mpcth_footer a:hover,a {color: $main_color;}
	#mpcth_page_wrap .mpcth-color-main-color,#mpcth_page_wrap .mpcth-color-main-color-hover:hover {color: $main_color;}
	#mpcth_page_wrap .mpcth-color-main-background,#mpcth_page_wrap .mpcth-color-main-background-hover:hover {background-color: $main_color;}
	#mpcth_page_wrap .mpcth-color-main-border,#mpcth_page_wrap .mpcth-color-main-border-hover:hover {border-color: $main_color !important;}
	#jckqv .woocommerce-product-rating .star-rating span:before,#mpcth_page_wrap .woocommerce .mpcth-post-header .mpcth-quick-view .fa:hover,.woocommerce-page #mpcth_page_wrap .mpcth-post-header .mpcth-quick-view .fa:hover,#mpcth_back_to_top:hover,.woocommerce #mpcth_page_wrap .mpcth-shop-style-slim .products .product .mpcth-post-content .fa,.woocommerce #mpcth_page_wrap .mpcth-shop-style-slim .products .product .mpcth-post-content a:hover,.woocommerce #mpcth_page_wrap .mpcth-shop-style-center .products .product .mpcth-post-content .fa,.woocommerce #mpcth_page_wrap .mpcth-shop-style-center .products .product .mpcth-post-content a:hover,.woocommerce #mpcth_page_wrap .mpcth-shop-style-slim .products .product .mpcth-post-content .add_to_cart_button i,.page-template-template-blog-php #mpcth_content .mpcth-post .mpcth-post-title > a:hover,.archive #mpcth_page_wrap #mpcth_content .mpcth-post .mpcth-post-title > a:hover,#mpcth_page_wrap .mpcth-mobile-menu .page_item > a:hover,#mpcth_page_wrap .mpcth-mobile-menu .menu-item > a:hover,#mpcth_page_wrap .mpcth-mobile-menu .page_item.current-menu-item > a,#mpcth_page_wrap .mpcth-mobile-menu .menu-item.current-menu-item > a,.woocommerce-page.single-product #mpcth_page_wrap #mpcth_content > .product .summary .stock.out-of-stock,.woocommerce-wishlist #mpcth_page_wrap #mpcth_content .yith-wcwl-share li a:hover,#mpcth_page_wrap .wpcf7 .contact-form-input label,#mpcth_page_wrap .wpcf7 .contact-form-message label,#mpcth_page_wrap .woocommerce.widget.widget_layered_nav .chosen a,#mpcth_page_wrap #mpcth_page_header_secondary_content #mpcth_newsletter input[type=submit]:hover,#mpcth_page_wrap #mpcth_smart_search_wrap .mpcthSelect,.woocommerce-page.single-product #mpcth_page_wrap #mpcth_content > .product .star-rating span,#mpcth_page_wrap .widget_product_categories .product-categories .cat-item.current-cat > a,#mpcth_page_wrap .products .product .mpcth-post-content .product_type_variable:hover,#mpcth_page_wrap .products .product .mpcth-post-content .add_to_cart_button:hover,.woocommerce-page.single-product #mpcth_page_wrap #mpcth_content > .product .woocommerce-tabs #review_form_wrapper .stars a:hover,#mpcth_page_wrap #mpcth_comments #mpcth_comments_wrap .mpcth-comment-header a:hover,#mpcth_page_wrap .widget .product_list_widget li .star-rating > span,#mpcth_page_wrap .widget .product_list_widget li a,#mpcth_page_wrap #mpcth_main .nivoSlider .nivo-directionNav a,#mpcth_page_wrap #mpcth_main .rev_slider_wrapper .tparrows.default,#mpcth_page_wrap #mpcth_main .flexslider .flex-direction-nav a,#mpcth_page_wrap #mpcth_main .widget a:hover,#mpcth_page_wrap #mpcth_main .widget.widget_text a,#mpcth_page_wrap .widget.mpc-w-twitter-widget a,#mpcth_page_wrap .mpc-sc-tooltip-wrap .mpc-sc-tooltip-text,#mpcth_page_wrap #mpcth_smart_search_wrap select,#mpcth_page_wrap #mpcth_smart_search_wrap input,#mpcth_page_wrap #mpcth_page_header_secondary_content a:hover,#mpcth_page_wrap #mpcth_main .vc_text_separator > div,.woocommerce-page.single-product #mpcth_page_wrap #mpcth_content > .product .woocommerce-tabs .tabs li.active a,.woocommerce-page.single-product #mpcth_page_wrap #mpcth_content > .product .woocommerce-tabs .tabs li:hover a,.woocommerce-page #mpcth_page_wrap .woocommerce-breadcrumb a,#mpcth_page_wrap #mpcth_main #mpcth_content_wrap .wpb_accordion_header.ui-state-active a,#mpcth_page_wrap #mpcth_main #mpcth_content_wrap .wpb_accordion_header:hover a,#mpcth_page_wrap #mpcth_main #mpcth_content_wrap .wpb_toggle.wpb_toggle_title_active .mpcth-title-wrap,#mpcth_page_wrap #mpcth_main #mpcth_content_wrap .wpb_toggle:hover .mpcth-title-wrap,#mpcth_page_wrap #mpcth_main #mpcth_content_wrap .wpb_toggle.wpb_toggle_title_active .mpcth-toggle-mark,#mpcth_page_wrap #mpcth_main #mpcth_content_wrap .wpb_toggle:hover .mpcth-toggle-mark,#mpcth_page_wrap #mpcth_main #mpcth_content_wrap .wpb_tabs .wpb_tabs_nav > li.ui-state-active > a,#mpcth_page_wrap #mpcth_main #mpcth_content_wrap .wpb_tabs .wpb_tabs_nav > li.ui-state-hover > a,#mpcth_page_wrap #mpcth_main #mpcth_content_wrap .wpb_tour .wpb_tabs_nav > li.ui-state-active > a > span,#mpcth_page_wrap #mpcth_main #mpcth_content_wrap .wpb_tour .wpb_tabs_nav > li.ui-state-hover > a > span,#mpcth_page_wrap .mpcth-menu .page_item:hover > a,#mpcth_page_wrap .mpcth-menu .menu-item:hover > a,#mpcth_page_wrap .mpcth-menu .page_item.current-menu-item > a,#mpcth_page_wrap .mpcth-menu .menu-item.current-menu-item > a,#mpcth_page_wrap #mpcth_mega_menu .widget ul .menu-item > a:hover,#mpcth_page_wrap #mpcth_mega_menu .widget .sub-container > .sub-menu li > a:hover,#mpcth_page_wrap #mpcth_mega_menu .widget ul .menu-item.current-page-ancestor > a,#mpcth_page_wrap #mpcth_mega_menu .widget ul .menu-item.current-menu-item > a,#mpcth_page_wrap #mpcth_nav .current-page-ancestor > a,#mpcth_page_wrap #mpcth_nav .current-menu-ancestor > a,#mpcth_page_wrap #mpcth_nav .current_page_ancestor > a,#mpcth_page_wrap .widget_nav_menu .page_item.current-menu-item > a,#mpcth_page_wrap .widget_nav_menu .menu-item.current-menu-item > a,#mpcth_page_wrap .widget_nav_menu .current-page-ancestor > a,#mpcth_page_wrap .widget_nav_menu .current-menu-ancestor > a,#mpcth_page_wrap .widget_nav_menu .current_page_ancestor > a,#mpcth_page_wrap .mpcth-socials-list li a:hover,#mpcth_page_wrap #mpcth_content .product .mpcth-post-content .price ins .amount,.woocommerce-page #mpcth_page_wrap #mpcth_content .products .product .mpcth-post-categories a:hover,.page-template-template-portfolio-php #mpcth_page_wrap #mpcth_content .mpcth-post .mpcth-post-content .mpcth-post-categories a:hover,.page-template-template-portfolio-php #mpcth_page_wrap #mpcth_portfolio_sorts li.active,.page-template-template-portfolio-php #mpcth_page_wrap #mpcth_portfolio_filters li.active {color: $main_color;}
	#jckqv #jckqv_summary .onsale,#jckqv #jckqv_summary .yith-wcwl-add-to-wishlist a:hover,#jckqv #jckqv_summary .single_add_to_cart_button,#jckqv #jckqv_summary h1:after,#jckqv #jckqv_summary .product_meta:after,.woocommerce-wishlist #mpcth_page_wrap #mpcth_content a.button,#mpcth_page_wrap #mpcth_mini_cart .button:hover,#mpcth_page_wrap #mpcth_mini_cart .button.alt,.woocommerce-page.single-product #mpcth_page_wrap #mpcth_content > .product .summary .yith-wcwl-add-to-wishlist a:hover,.page-template-template-blog-php #mpcth_content .mpcth-post .mpcth-post-footer .mpcth-read-more:hover,.archive #mpcth_page_wrap #mpcth_content .mpcth-post .mpcth-post-footer .mpcth-read-more:hover,.blog #mpcth_page_wrap #mpcth_content .mpcth-post .mpcth-post-footer .mpcth-read-more:hover,.woocommerce-page.single-product #mpcth_page_wrap .cart .quantity .plus-wrap:hover,.woocommerce-page.single-product #mpcth_page_wrap .cart .quantity .minus-wrap:hover,.woocommerce-cart #mpcth_page_wrap .cart .quantity .plus-wrap:hover,.woocommerce-cart #mpcth_page_wrap .cart .quantity .minus-wrap:hover,#mpcth_page_wrap #mpcth_main #mpcth_content_wrap .vc_separator.mpcth-separator .vc_sep_holder_l .vc_sep_line:before,#mpcth_page_wrap #mpcth_smart_search_wrap #searchsubmit,#mpcth_page_wrap .s2_form_widget form input[type=submit]:hover,#mpcth_page_wrap .mpcth-menu-label-hot,#mpcth_page_wrap .bra-photostream-widget ul li:hover a,.woocommerce-page.single-product #mpcth_page_wrap .cart .single_add_to_cart_button:hover,.woocommerce-cart #mpcth_page_wrap .cart .single_add_to_cart_button:hover,#mpcth_page_wrap .wpcf7 .form-submit .wpcf7-submit:hover,#mpcth_page_wrap #review_form_wrapper #submit:hover,#mpcth_page_wrap .widget #searchform #searchsubmit:hover,#mpcth_page_wrap .widget #searchform #searchsubmit.alt,.woocommerce-page.single-product #mpcth_page_wrap #mpcth_content > .product .product_meta:after,.woocommerce-page.single-product #mpcth_page_wrap #mpcth_content > .product .product_share:after,#mpcth_page_wrap .woocommerce #review_form_wrapper #submit:hover,#mpcth_page_wrap .woocommerce button.button:hover,#mpcth_page_wrap .woocommerce input.button:hover,#mpcth_page_wrap .woocommerce a.button:hover,.woocommerce #mpcth_page_wrap #review_form_wrapper #submit:hover,.woocommerce #mpcth_page_wrap button.button:hover,.woocommerce #mpcth_page_wrap input.button:hover,.woocommerce #mpcth_page_wrap a.button:hover,#mpcth_page_wrap .woocommerce #review_form_wrapper #submit.alt,#mpcth_page_wrap .woocommerce button.button.alt,#mpcth_page_wrap .woocommerce input.button.alt,#mpcth_page_wrap .woocommerce a.button.alt,.woocommerce #mpcth_page_wrap #review_form_wrapper #submit.alt,.woocommerce #mpcth_page_wrap button.button.alt,.woocommerce #mpcth_page_wrap input.button.alt,.woocommerce #mpcth_page_wrap a.button.alt,#mpcth_page_wrap #mpcth_main .wpb_separator:before,#mpcth_page_wrap #mpcth_main .vc_text_separator:before,#mpcth_page_wrap .woocommerce.widget.widget_layered_nav_filters .chosen a,#mpcth_page_wrap #mpcth_page_header_content #mpcth_controls_wrap #mpcth_controls_container > a:hover,#mpcth_page_wrap #mpcth_page_header_content #mpcth_controls_wrap #mpcth_controls_container > a.active,#mpcth_page_wrap .woocommerce.widget.widget_price_filter .ui-slider-handle,#mpcth_page_wrap .woocommerce.widget.widget_price_filter .ui-slider-range,#mpcth_page_wrap .woocommerce.widget.widget_price_filter .button:hover,#mpcth_page_wrap #mpcth_comments #respond #mpcth_comment_form .form-submit input:hover,.blog #mpcth_page_wrap #mpcth_content .post .mpcth-post-thumbnail .mpcth-lightbox,.page-template-template-blog-php #mpcth_page_wrap #mpcth_content .post .mpcth-post-thumbnail .mpcth-lightbox,#mpcth_page_wrap #mpcth_main .vc-carousel .vc-carousel-indicators li,#mpcth_page_wrap #mpcth_main .wpb_posts_slider .nivo-controlNav a,#mpcth_page_wrap #mpcth_main .flexslider .flex-control-nav li a,#mpcth_page_wrap #mpcth_main .rev_slider_wrapper .tp-bullets.simplebullets.round .bullet {background-color: $main_color;}
	#mpcth_back_to_top:hover,#mpcth_page_wrap .mpc-sc-tooltip-wrap .mpc-sc-tooltip-text,#mpcth_page_wrap .mpcth-deco-header span,.woocommerce-page.single-product #mpcth_page_wrap #mpcth_content > .product .woocommerce-tabs #review_form_wrapper #reply-title,.woocommerce-page.single-product #mpcth_page_wrap #mpcth_content > .product .woocommerce-tabs .tabs li.active a,.woocommerce-page.single-product #mpcth_page_wrap #mpcth_content > .product .woocommerce-tabs .tabs li:hover a,#mpcth_page_wrap #mpcth_main #mpcth_content_wrap .wpb_accordion_header.ui-state-active a,#mpcth_page_wrap #mpcth_main #mpcth_content_wrap .wpb_accordion_header:hover a,#mpcth_page_wrap #mpcth_main #mpcth_content_wrap .wpb_toggle.wpb_toggle_title_active .mpcth-title-wrap,#mpcth_page_wrap #mpcth_main #mpcth_content_wrap .wpb_toggle:hover .mpcth-title-wrap,#mpcth_page_wrap #mpcth_main #mpcth_content_wrap .wpb_toggle.wpb_toggle_title_active .mpcth-toggle-mark,#mpcth_page_wrap #mpcth_main #mpcth_content_wrap .wpb_toggle:hover .mpcth-toggle-mark,#mpcth_page_wrap #mpcth_main #mpcth_content_wrap .wpb_tabs .wpb_tabs_nav > li.ui-state-active > a,#mpcth_page_wrap #mpcth_main #mpcth_content_wrap .wpb_tabs .wpb_tabs_nav > li.ui-state-hover > a,#mpcth_page_wrap #mpcth_main #mpcth_content_wrap .wpb_tour .wpb_tabs_nav > li.ui-state-active > a > span,#mpcth_page_wrap #mpcth_main #mpcth_content_wrap .wpb_tour .wpb_tabs_nav > li.ui-state-hover > a > span,#mpcth_page_wrap #mpcth_comments #reply-title,#mpcth_page_wrap #mpcth_main .vc-carousel .vc-carousel-indicators li.vc-active,#mpcth_page_wrap #mpcth_main .wpb_posts_slider .nivo-controlNav a.active,#mpcth_page_wrap #mpcth_main .flexslider .flex-control-nav li a.flex-active,#mpcth_page_wrap #mpcth_main .rev_slider_wrapper .tp-bullets.simplebullets.round .bullet.selected,#mpcth_page_wrap .page_item.menu-item-has-children:after,#mpcth_page_wrap .menu-item.menu-item-has-children:after,#mpcth_page_wrap .page_item.menu-item-has-children:after,#mpcth_page_wrap .menu-item.menu-item-has-children:after {border-color: $main_color;}
	#mpcth_page_wrap #mpcth_main .wpb_call_to_action.cta_align_bottom .wpb_button_a:after {border-bottom-color: $main_color;}
	#mpcth_page_wrap .mpcth-list-item:before,#mpcth_page_wrap ul li:before, #mpcth_page_wrap #mpcth_main ul li:before,ol li:before,#mpcth_page_wrap #mpcth_page_header_secondary_content #mpcth_newsletter .mpcth-newsletter-toggle:before,#mpcth_page_wrap #mpcth_page_header_secondary_content #mpcth_newsletter form:before,#mpcth_page_wrap #mpcth_page_header_secondary_content #mpcth_newsletter .mpcth-newsletter-subscribe:before,#mpcth_page_wrap #mpcth_main .wpb_call_to_action.cta_align_left .wpb_button_a:after {border-left-color: $main_color;}
	#mpcth_page_wrap #mpcth_main .wpb_call_to_action.cta_align_right .wpb_button_a:after {border-right-color: $main_color;}
	#jckqv #jckqv_summary .mpcth-sale-wrap:before, #mpcth_page_wrap .woocommerce .mpcth-sale-wrap:before, .woocommerce-page #mpcth_page_wrap .mpcth-sale-wrap:before {border-bottom-color: " . mpcth_adjust_brightness($main_color, -25) . ";}
	#mpcth_page_wrap .woocommerce .mpcth-sale-wrap:after, .woocommerce-page #mpcth_page_wrap .mpcth-sale-wrap:after {border-left-color: " . mpcth_adjust_brightness($main_color, -25) . ";}
	#jckqv #jckqv_summary .mpcth-sale-wrap:after, #mpcth_page_wrap .mpcth-thumbs-sale-swap #jckWooThumbs_img_wrap + .mpcth-sale-wrap:after {border-right-color: " . mpcth_adjust_brightness($main_color, -25) . ";}
	#mpcth_page_wrap #mpcth_smart_search_wrap #s::-webkit-input-placeholder,#mpcth_page_wrap #mpcth_smart_search_wrap #s::-webkit-input-placeholder {color: $main_color;}
	#mpcth_page_wrap #mpcth_smart_search_wrap #s:-moz-placeholder,#mpcth_page_wrap #mpcth_smart_search_wrap #s:-moz-placeholder {color: $main_color;}
	#mpcth_page_wrap #mpcth_smart_search_wrap #s::-moz-placeholder,#mpcth_page_wrap #mpcth_smart_search_wrap #s::-moz-placeholder {color: $main_color;}
	#mpcth_page_wrap #mpcth_smart_search_wrap #s:-ms-input-placeholder,#mpcth_page_wrap #mpcth_smart_search_wrap #s:-ms-input-placeholder {color: $main_color;}";

	if (isset($content_family)) {
		$custom_styles .= "body {";
			$custom_styles .= "font-family: " . str_replace('+', ' ', $content_family) . ";";
			if (!empty($mpcth_options['mpcth_content_font']['font-style'])) {
				$custom_styles .= "font-style: {$mpcth_options['mpcth_content_font']['font-style']};";
			}
			if (!empty($mpcth_options['mpcth_content_font']['font-weight']) && $mpcth_options['mpcth_content_font']['font-weight'] != 'regular') {
				$custom_styles .= "font-weight: {$mpcth_options['mpcth_content_font']['font-weight']};";
			}
		$custom_styles .= "}";
	}
	if (isset($heading_family)) {
		$custom_styles .= "h1, h2, h3, h4, h5, h6,";
		$custom_styles .= "#jckqv h1, #jckqv h2, #jckqv h3, #jckqv h4, #jckqv h5, #jckqv h6 {";
			$custom_styles .= "font-family: " . str_replace('+', ' ', $heading_family) . ";";
			if (!empty($mpcth_options['mpcth_heading_font']['font-style'])) {
				$custom_styles .= "font-style: {$mpcth_options['mpcth_heading_font']['font-style']};";
			}
			if (!empty($mpcth_options['mpcth_heading_font']['font-weight']) && $mpcth_options['mpcth_heading_font']['font-weight'] != 'regular') {
				$custom_styles .= "font-weight: {$mpcth_options['mpcth_heading_font']['font-weight']};";
			}
		$custom_styles .= "}";
	}

	$menu_id = get_nav_menu_locations();
	if(isset($menu_id['mpcth_menu'])) {
		$menu_items = wp_get_nav_menu_items($menu_id['mpcth_menu']);

		if (! empty($menu_items))
			foreach ($menu_items as $item) {
				if ($item->menu_item_parent === '0') {
					$custom_styles .= "#mpcth_page_wrap #mpcth_mega_menu .menu-item-$item->ID > .sub-container > .sub-menu {";

					if (isset($mpcth_options['mpcth_menu_bg_image_' . $item->object_id]) && $mpcth_options['mpcth_menu_bg_image_' . $item->object_id] != '') {
						$custom_styles .= "background-image: url('" . $mpcth_options['mpcth_menu_bg_image_' . $item->object_id] . "');";
						$custom_styles .= "background-repeat: no-repeat;";
					}
					if (isset($mpcth_options['mpcth_menu_bg_align_' . $item->object_id]) && $mpcth_options['mpcth_menu_bg_align_' . $item->object_id] != '') {
						$custom_styles .= "background-position: " . $mpcth_options['mpcth_menu_bg_align_' . $item->object_id] . ";";
					} else {
						$custom_styles .= "background-position: bottom center;";
					}
					if (isset($mpcth_options['mpcth_menu_bg_padding_' . $item->object_id]) && $mpcth_options['mpcth_menu_bg_padding_' . $item->object_id] != '')
						$custom_styles .= "padding: 1.5em " . $mpcth_options['mpcth_menu_bg_padding_' . $item->object_id] . ";";

					$custom_styles .= "}";
				}
			}
	}

	if (isset($mpcth_options['mpcth_custom_css'])) {
		$custom_styles .= html_entity_decode(stripslashes(stripslashes($mpcth_options['mpcth_custom_css'])));
	}

	wp_enqueue_style('mpc-styles', get_stylesheet_directory_uri() . '/style.css');
	wp_add_inline_style('mpc-styles', $custom_styles);

	if ($mpcth_options['mpcth_theme_skin'] != 'default')
		wp_enqueue_style('mpc-skins-styles', get_template_directory_uri() . '/css/' . $mpcth_options['mpcth_theme_skin'] . '.css');

	wp_enqueue_style('font-awesome', MPC_THEME_URI . '/fonts/font-awesome.css');
	wp_enqueue_style('mpc-theme-plugins-css', MPC_THEME_URI . '/css/plugins.min.css');

	wp_enqueue_script('mpc-theme-plugins-js', MPC_THEME_URI . '/js/plugins.min.js', array('jquery'), '1.0', true);
	wp_enqueue_script('mpc-theme-main-js', MPC_THEME_URI . '/js/main.min.js', array('jquery', 'mpc-theme-plugins-js'), '1.0', true);

	$comment_form_labels = array(
		'field_name' => __('NAME', 'mpcth'),
		'field_email' => __('EMAIL', 'mpcth'),
		'field_url' => __('WEBSITE', 'mpcth'),
		'field_comment' => __('MESSAGE', 'mpcth')
	);
	wp_localize_script('mpc-theme-main-js', 'mpc_cf', $comment_form_labels);
}

/* ---------------------------------------------------------------- */
/* Add theme options panel
/* ---------------------------------------------------------------- */
if (!function_exists('mpcth_optionsframework_init')) {
	require_once(MPC_THEME_PATH . '/panel/options-framework.php');
	require_once(MPC_THEME_PATH . '/panel/admin-visual-options.php');
}

/* ---------------------------------------------------------------- */
/* Add ACF fallback
/* ---------------------------------------------------------------- */
if (! is_admin() && ! function_exists('get_field')) {
	function get_field($name) {
		return false;
	}
}

/* ---------------------------------------------------------------- */
/* Register main sidebar
/* ---------------------------------------------------------------- */
if(function_exists('register_sidebar')) {
	register_sidebar(array(
		'id' => 'mpcth_sidebar',
		'name' => __('Main Sidebar', 'mpcth'),
		'description' => __('This is a standard sidebar.', 'mpcth'),
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h5 class="widget-title sidebar-widget-title"><span class="mpcth-color-main-border">',
		'after_title' => '</span></h5>'
	));
}

/* ---------------------------------------------------------------- */
/* Register main menu area
/* ---------------------------------------------------------------- */
if(function_exists('register_sidebar')) {
	register_sidebar(array(
		'id' => 'mpcth_main_menu',
		'name' => __('Main Menu', 'mpcth'),
		'description' => __('This is a mega menu.', 'mpcth'),
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h5 class="widget-title sidebar-widget-title"><span class="mpcth-color-main-border">',
		'after_title' => '</span></h5>'
	));
}

/* ---------------------------------------------------------------- */
/* Register smart search area
/* ---------------------------------------------------------------- */
if(function_exists('register_sidebar')) {
	register_sidebar(array(
		'id' => 'mpcth_smart_search',
		'name' => __('Smart Search', 'mpcth'),
		'description' => __('This is a smart search.', 'mpcth'),
		'before_widget' => '<li id="%1$s" class="mpcth-smart-search-field %2$s">',
		'after_widget' => '</li>',
		'before_title' => '',
		'after_title' => ''
	));
}

/* ---------------------------------------------------------------- */
/* Register main footer
/* ---------------------------------------------------------------- */
if(function_exists('register_sidebar')) {
	register_sidebar(array(
		'id' => 'mpcth_footer',
		'name'=> __('Main Footer', 'mpcth'),
		'description' => __('This is a standard footer.', 'mpcth'),
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h5 class="widget-title footer-widget-title"><span class="mpcth-color-main-border">',
		'after_title' => '</span></h5>'
	));
}

/* ---------------------------------------------------------------- */
/* Register additional footer
/* ---------------------------------------------------------------- */
if(function_exists('register_sidebar')) {
	register_sidebar(array(
		'id' => 'mpcth_footer_extended',
		'name'=> __('Extended Footer', 'mpcth'),
		'description' => __('This is an extended footer.', 'mpcth'),
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h5 class="widget-title footer-widget-title"><span class="mpcth-color-main-border">',
		'after_title' => '</span></h5>'
	));
}

/* ---------------------------------------------------------------- */
/* Register main menu
/* ---------------------------------------------------------------- */
if (function_exists('register_nav_menus')) {
	register_nav_menus(array(
		'mpcth_menu' => __('Main Navigation Menu', 'mpcth'),
		'mpcth_mobile_menu' => __('Mobile Navigation Menu', 'mpcth'),
	));

	if (isset($mpcth_options['mpcth_header_secondary_enable_menu']) && $mpcth_options['mpcth_header_secondary_enable_menu'])
		register_nav_menus(array(
			'mpcth_secondary_menu' => __('Secondary Navigation Menu', 'mpcth'),
		));
}

/* ---------------------------------------------------------------- */
/* Get sidebar position
/* ---------------------------------------------------------------- */
function mpcth_get_sidebar_position() {
	global $page_id;
	global $mpcth_options;

	if (! empty($_GET['sidebar-pos'])) {
		if ($_GET['sidebar-pos'] == 'left')
			return 'left';
		elseif ($_GET['sidebar-pos'] == 'right')
			return 'right';
		elseif ($_GET['sidebar-pos'] == 'none')
			return 'none';
	}

	$post_type = '';

	if ($page_id != 0) {
		$post_type = get_post_type($page_id);
		$post_meta = get_post_meta($page_id);
	}

	$enable_custom_sidebar_position = get_field('mpc_custom_sidebar_position', $page_id);
	$custom_sidebar_position = get_field('mpc_sidebar_position', $page_id);

	$sidebar_position = $mpcth_options['mpcth_default_sidebar'];
	if (is_search()) {
		$sidebar_position = $mpcth_options['mpcth_search_sidebar'];
	} elseif (is_archive()) {
		$sidebar_position = $mpcth_options['mpcth_archive_sidebar'];

		if (function_exists('is_woocommerce') && is_woocommerce() && $enable_custom_sidebar_position)
			$sidebar_position = $custom_sidebar_position;

		if (function_exists('is_woocommerce') && (is_product_category() || is_product_tag())) {
			$term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
			$term_sidebar_position = get_field('mpc_sidebar_position', $term);

			if ($term_sidebar_position !== false && $term_sidebar_position != 'default')
				$sidebar_position = $term_sidebar_position;
		}
	} elseif (is_404()) {
		$sidebar_position = $mpcth_options['mpcth_error_sidebar'];
	} elseif ($enable_custom_sidebar_position) {
		$sidebar_position = $custom_sidebar_position;
	} elseif (is_page()) {
		if (isset($post_meta['_wp_page_template'][0]) && ($post_meta['_wp_page_template'][0] == 'template-lookbook.php' || $post_meta['_wp_page_template'][0] == 'template-fullwidth.php'))
			$sidebar_position = 'none';
	} elseif (is_single()) {
		if ($post_type == 'post')
			$sidebar_position = $mpcth_options['mpcth_blog_post_sidebar'];
		elseif ($post_type == 'mpc_portfolio' && isset($mpcth_options['mpcth_portfolio_post_sidebar']))
			$sidebar_position = $mpcth_options['mpcth_portfolio_post_sidebar'];
	}

	return $sidebar_position;
}

/* ---------------------------------------------------------------- */
/* Add social list
/* ---------------------------------------------------------------- */
function mpcth_display_social_list() {
	global $mpcth_options;

	if (! empty($mpcth_options['mpcth_socials']))
		foreach($mpcth_options['mpcth_socials'] as $name => $enable) {
			if($enable) {
				echo '<li>';
					echo '<a href="' . ($name == 'envelope' ? 'mailto:' : '') . $mpcth_options['mpcth_social_' . $name]. '" class="mpcth-social-' . $name . '">';
						echo '<i class="fa fa-' . $name . '"></i>';
					echo '</a>';
				echo '</li>';
			}
		}
}

/* ---------------------------------------------------------------- */
/* Single comment template
/* ---------------------------------------------------------------- */
function mpcth_single_comment_template($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	global $post;
	extract($args, EXTR_SKIP);

	$is_post_author = '';
	if(get_comment_author_email() == get_the_author_meta('email'))
		$is_post_author = "mpcth-post-author";

	?>

	<li <?php comment_class(empty($args['has_children']) ? '' : 'parent'); ?> id="comment-<?php comment_ID(); ?>">

	<?php if ($comment->comment_type == 'pingback' || $comment->comment_type == 'trackback') { ?>
		<?php _e('Pingback:', 'mpcth'); ?> <?php comment_author_link(); ?> <?php edit_comment_link(__('[Edit]', 'mpcth'), '<span class="mpcth-edit-link">', '</span>' ); ?>
	<?php } else { ?>
		<article class="mpcth-comment">
			<div class="mpcth-comment-header">
				<div class="mpcth-comment-avatar-wrap">
					<?php echo get_avatar($comment, $avatar_size); ?>
				</div>
				<span class="mpcth-comment-author <?php echo $is_post_author; ?>">
					<?php comment_author_link(); ?>
				</span>
				<a href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)); ?>" class="mpcth-comment-permalink">
					<time class="mpcth-comment-date" datetime="<?php comment_time('c'); ?>">
						<span>- </span><?php comment_date(); ?><span> <?php _e('at', 'mpcth'); ?> </span><?php comment_time(); ?>
					</time>
				</a>
				<?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $max_depth, 'reply_text' => '<i class="fa fa-reply"></i>'))); ?>
				<?php edit_comment_link('<i class="fa fa-pencil"></i>'); ?>
			</div>
			<section class="mpcth-comment-content">
				<?php comment_text(); ?>
			</section>
			<div class="mpcth-comment-footer">
				<?php if (! $comment->comment_approved) { ?>
					<p class="mpcth-comment-not-approved"><?php _e('Your comment is awaiting moderation.', 'mpcth'); ?></p>
				<?php } ?>
			</div>
		</article><!-- #comment-## -->
	<?php }
}

/* ---------------------------------------------------------------- */
/* Display pagination
/* ---------------------------------------------------------------- */
function mpcth_display_pagination($query = '') {
	global $paged;

	if(empty($query)) {
		global $wp_query;
		$query = $wp_query;
	}

	echo paginate_links(array(
		'base' => str_replace(999999, '%#%', esc_url(get_pagenum_link(999999))),
		'current' => max(1, $paged),
		'prev_text' => '<i class="fa fa-angle-left"></i>',
		'next_text' => '<i class="fa fa-angle-right"></i>',
		'total' => $query->max_num_pages
	));
}

/* ---------------------------------------------------------------- */
/* Display load more
/* ---------------------------------------------------------------- */
function mpcth_display_load_more($query) {
	global $paged;

	$load_more_settings = array(
		'pages_current'		=> $paged,
		'pages_total'		=> $query->max_num_pages,
		'pages_next_link'	=> next_posts($query->max_num_pages, false),
		'posts_per_page'	=> $query->post_count,
		'posts_total'		=> $query->found_posts
	);

	wp_localize_script('mpc-theme-main-js', 'lminfo', $load_more_settings);

	echo '<div id="mpcth_load_more_wrap">';
		echo '<a id="mpcth_load_more" href="#">' . __('Load More', 'mpcth') . '</a>';
		echo '<div id="mpcth_load_more_container"></div>';
	echo '</div>';
}

/* ---------------------------------------------------------------- */
/* Add lightbox
/* ---------------------------------------------------------------- */
function mpcth_add_lightbox() {
	$lightbox_enabled = get_field('mpc_enable_lightbox');
	$lightbox_type = get_field('mpc_lightbox_type');
	$lightbox_source = get_field('mpc_lightbox_source');
	$lightbox_source_url = get_field('mpc_lightbox_source_url');
	$lightbox_caption = get_field('mpc_lightbox_caption');

	if ($lightbox_enabled && $lightbox_type == 'image' && !empty($lightbox_source)) {
		echo '<a class="mpcth-lightbox mpcth-lightbox-type-image" href="' . $lightbox_source['url'] . '" title="' . $lightbox_source['caption'] . '"><i class="fa fa-expand"></i></a>';
	} elseif ($lightbox_enabled && $lightbox_type == 'iframe' && !empty($lightbox_source_url)) {
		$lightbox_caption = !empty($lightbox_caption) ? $lightbox_caption : '';
		$src_type = strtolower($lightbox_source_url);
		$search = preg_match('/.(jpg|jpeg|gif|png|bmp)/', $src_type);

		$type = 'iframe';
		if($search == 1)
			$type = 'image';

		$force_type = '';
		if($type == 'iframe')
			$force_type = ' mfp-iframe';

		echo '<a class="mpcth-lightbox mpcth-lightbox-type-' . $type . $force_type . '" href="' . $lightbox_source_url . '" title="' . $lightbox_caption . '"><i class="fa fa-expand"></i></a>';
	}
}

/* ---------------------------------------------------------------- */
/* Add secondary menu
/* ---------------------------------------------------------------- */
function mpcth_display_secondary_menu() {
	global $yith_wcwl;

	echo '<div id="mpcth_secondary_menu">';
		echo '<span class="mpcth-language">';
			do_action('icl_language_selector');
		echo '</span>';
		echo '<span class="mpcth-currency">';
			do_shortcode('[currency_switcher]');
		echo '</span>';

		if (! empty($yith_wcwl)) {
			// echo '<span class="mpcth-menu-divider"></span>';
			echo '<a href="' . $yith_wcwl->get_wishlist_url() . '" class="mpcth-wc-wishlist">' . __('Wishlist', 'mpcth') . '</a>';
		}

		if (class_exists('WooCommerce'))
			if (! is_user_logged_in() && get_option('woocommerce_myaccount_page_id') !== false) {
				echo '<a href="' . get_permalink(get_option('woocommerce_myaccount_page_id')) . '" class="mpcth-wp-login">' . __('Login', 'mpcth') . '</a>';
			} else {
				echo '<a href="' . get_permalink(get_option('woocommerce_myaccount_page_id')) . '" class="mpcth-wp-login">' . __('My Account', 'mpcth') . '</a>';
			}

		if(has_nav_menu('mpcth_secondary_menu'))
			wp_nav_menu(array(
				'theme_location' => 'mpcth_secondary_menu',
				'container' => '',
				'menu_id' => 'mpcth_secondary_mini_menu',
				'menu_class' => 'mpcth-secondary-mini-menu'
			));
	echo '</div>';
}

/* ---------------------------------------------------------------- */
/* Add secondary newsletter
/* ---------------------------------------------------------------- */
function mpcth_display_newsletter() {
	global $mpcth_options;

	$enable_subscribe = true;
	if (isset($mpcth_options['mpcth_header_secondary_enable_subscribe']) && ! $mpcth_options['mpcth_header_secondary_enable_subscribe'])
		$enable_subscribe = false;

	if ($enable_subscribe) {
		$message = '';
		if (isset($mpcth_options['mpcth_header_secondary_message']) && $mpcth_options['mpcth_header_secondary_message'])
			$message = $mpcth_options['mpcth_header_secondary_message'];

		if ($message) {
			echo '<div id="mpcth_newsletter">';
				echo '<span class="mpcth-newsletter-message">';
					echo $message;
				echo '</span>';
			echo '</div>';
		} elseif (shortcode_exists('subscribe2')) {
			echo '<div id="mpcth_newsletter">';
				echo '<a href="#" class="mpcth-newsletter-toggle">';
					if(isset($mpcth_options['mpcth_newsletter_text']))
						echo $mpcth_options['mpcth_newsletter_text'];
					else
						_e('Sign up for our newsletter', 'mpcth');
				echo '</a>';

				echo do_shortcode('[subscribe2]');
			echo '</div>';
		}
	}
}

/* ---------------------------------------------------------------- */
/* Add secondary header
/* ---------------------------------------------------------------- */
function mpcth_display_secondary_header() {
	global $mpcth_options;

	$header_order = 'n_s_m';
	if ($mpcth_options['mpcth_header_secondary_layout'])
		$header_order = $mpcth_options['mpcth_header_secondary_layout'];

	$header_order_items = explode('_', $header_order);

	echo '<div id="mpcth_page_header_secondary_content" class="mpcth-header-order-' . $header_order . ' mpcth-header-position-' . $mpcth_options['mpcth_header_secondary_position'] . '">';
		foreach ($header_order_items as $item) {
			if ($item == 'n')
				mpcth_display_newsletter();

			if ($item == 's')
				mpcth_display_secondary_menu();

			if ($item == 'm') {
				echo '<ul id="mpcth_header_socials" class="mpcth-socials-list">';
					mpcth_display_social_list();
				echo '</ul>';
			}
		}
	echo '</div>';
}

/* ---------------------------------------------------------------- */
/* Add post meta
/* ---------------------------------------------------------------- */
function mpcth_add_meta() {
	echo '<span class="mpcth-date"><span class="mpcth-static-text">' . __('Posted on', 'mpcth') . ' </span><a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '"><time datetime="' . get_the_date('c') . '">' . get_the_time(get_option('date_format')) . '</time></a></span>';

	if (get_post_type() == 'mpc_portfolio')
		$categories = get_the_term_list(get_the_ID(), 'mpc_portfolio_cat', '', ', ', '');
	else
		$categories = get_the_category_list(__(', ', 'mpcth'));

	if ($categories)
		echo '<span class="mpcth-categories"><span class="mpcth-static-text"> ' . __('in', 'mpcth') . ' </span>' . $categories . '</span>';

	if(comments_open()) {
		echo '<span class="mpcth-comments"><a href="' . get_comments_link(get_the_ID()) . '" title="' . esc_attr(__( 'View post comments', 'mpcth')) . '" rel="comments">';
			comments_number(__('0 comments', 'mpcth'), __('1 comment', 'mpcth') , __('% comments', 'mpcth'));
		echo '</a></span>';
	}
}

/* ---------------------------------------------------------------- */
/* Excerpt
/* ---------------------------------------------------------------- */
function mpcth_excerpt_ending($more) {
	return '...';
}
add_filter('excerpt_more', 'mpcth_excerpt_ending');

/* ---------------------------------------------------------------- */
/* ACF theme fields
/* ---------------------------------------------------------------- */
require_once MPC_THEME_PATH . '/autoimport/custom_metaboxes.php';

/* ---------------------------------------------------------------- */
/* Install required plugins
/* ---------------------------------------------------------------- */
require_once(MPC_THEME_PATH . '/php/class-tgm-plugin-activation.php');

add_action('tgmpa_register', 'mpcth_install_require_plugins');
function mpcth_install_require_plugins() {
	$plugins = array(
		array(
			'name'		=> 'MPC Extensions',
			'slug'		=> 'mpc-extensions',
			'source'	=> MPC_THEME_URI . '/plugins/mpc-extensions.zip',
			'required'	=> true,
		),
		array(
			'name'		=> 'MPC Widgets',
			'slug'		=> 'mpc-widgets',
			'source'	=> MPC_THEME_URI . '/plugins/mpc-widgets.zip',
			'required'	=> true,
		),
		array(
			'name'		=> 'MPC Shortcodes',
			'slug'		=> 'mpc-shortcodes',
			'source'	=> MPC_THEME_URI . '/plugins/mpc-shortcodes.zip',
			'required'	=> true,
		),
		array(
			'name'		=> 'Visual Composer',
			'slug'		=> 'js_composer',
			'source'	=> MPC_THEME_URI . '/plugins/js_composer.zip',
			'required'	=> true,
			'version'	=> '4.1.2',
		),
		array(
			'name'		=> 'ACF Repeater',
			'slug'		=> 'acf-repeater',
			'source'	=> MPC_THEME_URI . '/plugins/acf-repeater.zip',
			'required'	=> true,
		),
		array(
			'name'		=> 'ACF Gallery',
			'slug'		=> 'acf-gallery',
			'source'	=> MPC_THEME_URI . '/plugins/acf-gallery.zip',
			'required'	=> true,
		),
		array(
			'name'		=> 'Revolution Slider',
			'slug'		=> 'revslider',
			'source'	=> MPC_THEME_URI . '/plugins/revslider.zip',
			'required'	=> false,
		),
		array(
			'name'		=> 'Get Kudos',
			'slug'		=> 'getkudos',
			'source'	=> MPC_THEME_URI . '/plugins/getkudos.zip',
			'required'	=> false,
		),
		array(
			'name'		=> 'Woocommerce Quickview',
			'slug'		=> 'jck_woo_quickview',
			'source'	=> MPC_THEME_URI . '/plugins/jck_woo_quickview.zip',
			'required'	=> false,
		),
		array(
			'name'		=> 'Envato Toolkit',
			'slug'		=> 'envato-wordpress-toolkit',
			'source'	=> MPC_THEME_URI . '/plugins/envato-wordpress-toolkit.zip',
			'required'	=> false,
		),
		array(
			'name'		=> 'LayerSlider',
			'slug'		=> 'LayerSlider',
			'source'	=> 'http://blaszok.mpcthemes.com/plugins/layerslider_wp.zip',
			'required'	=> false,
		),
		array(
			'name'		=> 'CSS3 Pricing Tables Grids',
			'slug'		=> 'css3_web_pricing_tables_grids',
			'source'	=> 'http://blaszok.mpcthemes.com/plugins/css3-responsive-web-pricing-tables.zip',
			'required'	=> false,
		),

		array(
			'name'		=> 'Advanced Custom Fields',
			'slug'		=> 'advanced-custom-fields',
			'required'	=> true,
		),
		array(
			'name'		=> 'Contact Form 7',
			'slug'		=> 'contact-form-7',
			'required'	=> false,
		),
		array(
			'name'		=> 'Woo Sidebars',
			'slug'		=> 'woosidebars',
			'required'	=> false,
		),
		array(
			'name'		=> 'Woo Commerce',
			'slug'		=> 'woocommerce',
			'required'	=> false,
		),
		array(
			'name'		=> 'WordPress SEO by Yoast',
			'slug'		=> 'wordpress-seo',
			'required'	=> false,
		),
		array(
			'name'		=> 'Subscribe2',
			'slug'		=> 'subscribe2',
			'required'	=> false,
		),
		array(
			'name'		=> 'YITH Wishlist',
			'slug'		=> 'yith-woocommerce-wishlist',
			'required'	=> false,
		),
		array(
			'name'		=> 'Brankic Photostream',
			'slug'		=> 'brankic-photostream-widget',
			'required'	=> false,
		),
		array(
			'name'		=> 'jQuery Mega Menu',
			'slug'		=> 'jquery-mega-menu',
			'required'	=> false,
		),
	);

	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'domain'       		=> 'mpcth',         	// Text domain - likely want to be the same as your theme.
		'default_path' 		=> '',                         	// Default absolute path to pre-packaged plugins
		'parent_menu_slug' 	=> 'themes.php', 				// Default parent menu slug
		'parent_url_slug' 	=> 'themes.php', 				// Default parent URL slug
		'menu'         		=> 'install-required-plugins', 	// Menu slug
		'has_notices'      	=> true,                       	// Show admin notices or not
		'is_automatic'    	=> false,					   	// Automatically activate plugins after installation or not
		'message' 			=> '',							// Message to output right before the plugins table
		'strings'      		=> array(
			'page_title'                       			=> __( 'Install Required Plugins', 'mpcth' ),
			'menu_title'                       			=> __( 'Install Plugins', 'mpcth' ),
			'installing'                       			=> __( 'Installing Plugin: %s', 'mpcth' ), // %1$s = plugin name
			'oops'                             			=> __( 'Something went wrong with the plugin API.', 'mpcth' ),
			'notice_can_install_required'     			=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_install_recommended'			=> _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_install'  					=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
			'notice_can_activate_required'    			=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_activate_recommended'			=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_activate' 					=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
			'notice_ask_to_update' 						=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_update' 						=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
			'install_link' 					  			=> _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
			'activate_link' 				  			=> _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
			'return'                           			=> __( 'Return to Required Plugins Installer', 'mpcth' ),
			'plugin_activated'                 			=> __( 'Plugin activated successfully.', 'mpcth' ),
			'complete' 									=> __( 'All plugins installed and activated successfully. %s', 'mpcth' ), // %1$s = dashboard link
			'nag_type'									=> 'updated' // Determines admin notice type - can only be 'updated' or 'error'
		)
	);

	tgmpa( $plugins, $config );
}

/* ---------------------------------------------------------------- */
/* Activation theme
/* ---------------------------------------------------------------- */
add_action('after_switch_theme', 'mpcth_theme_activation', 10 , 2);
function mpcth_theme_activation($old_name, $old_theme = false) {
	mpcth_optionsframework_setdefaults();
}

/* ---------------------------------------------------------------- */
/* Fix for 404 on custom post types
/* ---------------------------------------------------------------- */
add_action('after_switch_theme', 'mpcth_flush_rewrite_rules');
function mpcth_flush_rewrite_rules() {
	flush_rewrite_rules();
}

/* ---------------------------------------------------------------- */
/* WooCommerce
/* ---------------------------------------------------------------- */

// Disable default wrappers
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
// Enable Theme wrappers
add_action('woocommerce_before_main_content', 'mpcth_theme_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'mpcth_theme_wrapper_end', 10);

function mpcth_theme_wrapper_start() {
	global $mpcth_options;
	global $shop_style;

	if (! empty($_GET['product_style'])) {
		if ($_GET['product_style'] == 1)
			$shop_style = 'default';
		elseif ($_GET['product_style'] == 2)
			$shop_style = 'slim';
		elseif ($_GET['product_style'] == 3)
			$shop_style = 'center';
	} elseif (! empty($_GET['product-style'])) {
		if ($_GET['product-style'] == 1)
			$shop_style = 'default';
		elseif ($_GET['product-style'] == 2)
			$shop_style = 'slim';
		elseif ($_GET['product-style'] == 3)
			$shop_style = 'center';
	} else {
		$shop_style = 'default';
		if (isset($mpcth_options['mpcth_shop_style']) && $mpcth_options['mpcth_shop_style'])
			$shop_style = $mpcth_options['mpcth_shop_style'];
	}

	if (! is_shop() && ! is_product_category() && ! is_product_tag())
		$shop_style = 'default';

	echo '<div id="mpcth_main">';
		if (is_shop()) {
			$shop_id = get_option('woocommerce_shop_page_id');
			$header_content = get_field('mpc_header_content', $shop_id);

			echo '<div class="mpcth-page-custom-header">';
				echo do_shortcode($header_content);
			echo '</div>';
		} else {
			mpcth_print_category_header();
		}
		echo '<div id="mpcth_main_container">';
			get_sidebar();
			echo '<div id="mpcth_content_wrap">';
				echo '<div id="mpcth_content" class="mpcth-shop-style-' . $shop_style . '">';
}

function mpcth_theme_wrapper_end() {
				echo '</div><!-- end #mpcth_content -->';
			echo '</div><!-- end #mpcth_content_wrap -->';
		echo '</div><!-- end #mpcth_main_container -->';
	echo '</div><!-- end #mpcth_main -->';
}

function mpcth_print_category_header() {
	if (function_exists('is_woocommerce') && (is_product_category() || is_product_tag())) {
		$term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
		$header_content_type = get_field('mpc_header_content_type', $term);
		$custom_header = get_field('mpc_custom_header', $term);
		$image_header = get_field('mpc_image_header', $term);

		if ($header_content_type !== false && $header_content_type != 'none') {
			if ($header_content_type == 'image')
				echo '<img class="mpcth-category-header-image" width="' . $image_header['width'] . '" height="' . $image_header['height'] . '" alt="' . $image_header['alt'] . '" title="' . $image_header['title'] . '" src="' . $image_header['url'] . '" />';
			else
				echo '<div class="mpcth-category-header-custom">' . $custom_header . '</div>';
		}
	}
}

remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);

// Loop product title
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);

// Sold out hook
remove_action( 'woocommerce_before_single_product_summary', 'single_sold_out_products_flash', 9 );

// Single product summary
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);

// From price
add_filter('woocommerce_variable_price_html', 'mpcth_custom_price', 10);
add_filter('woocommerce_grouped_price_html', 'mpcth_custom_price', 10);
add_filter('woocommerce_variable_sale_price_html', 'mpcth_custom_price', 10);

function mpcth_custom_price($price){
	$prices = explode('&ndash;', $price);
	if (count($prices) == 2)
		return '<span class="mpcth-from-price">' . __('From: ', 'mpcth') . '</span>' . $prices[0];
	else
		return $price;
}

add_action('mpcth_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
add_action('mpcth_before_shop_loop_item_title', 'mpcth_wc_second_product_image', 20);

function mpcth_wc_second_product_image() {
	global $product;

	$disable_hover_slide = get_field('mpc_disable_hover_slide');
	$custom_hover_image = get_field('mpc_custom_hover_image');

	if (! $disable_hover_slide) {
		if ($custom_hover_image) {
			echo '<img width="' . $custom_hover_image['sizes']['shop_catalog-width'] . '" height="' . $custom_hover_image['sizes']['shop_catalog-height'] . '" src="' . $custom_hover_image['sizes']['shop_catalog'] . '" class="attachment-shop_catalog mpcth-second-thumbnail" alt="' . $custom_hover_image['title'] . '">';
		} else {
			$thumbs = $product->get_gallery_attachment_ids();

			if (! empty($thumbs)) {
				$attr = array('class' => "attachment-shop_catalog mpcth-second-thumbnail");

				echo wp_get_attachment_image($thumbs[0], 'shop_catalog', false, $attr);
			}
		}
	}
}

function mpcth_wc_product_categories() {
	global $product;

	echo '<div class="mpcth-post-categories">';
	echo get_the_term_list($product->ID, 'product_cat', '', ', ', '');
	echo '</div>';
}

add_action('mpcth_before_shop_loop', 'woocommerce_breadcrumb', 10 );
add_action('mpcth_before_shop_loop', 'woocommerce_result_count', 20);
add_action('mpcth_before_shop_loop', 'mpcth_wc_products_per_page', 30);
add_action('mpcth_before_shop_loop', 'woocommerce_catalog_ordering', 40);

function mpcth_wc_products_per_page() {
	global $mpcth_options;
	// global $sidebar_position;

	$number = 9;

	if (isset($mpcth_options['mpcth_products_number']) && $mpcth_options['mpcth_products_number'])
		$number = $mpcth_options['mpcth_products_number'];

	// if ($sidebar_position == 'none' && $number % 2 !== 0)
	// 	$number -= 1;

	$protocol = is_ssl() ? 'https://' : 'http://';
	$host = $_SERVER["HTTP_HOST"];
	$request_uri = $_SERVER["REQUEST_URI"];
	$query_string = $_SERVER["QUERY_STRING"];

	$url = '';
	$after_url = '';
	if (empty($query_string)) {
		$url = $protocol . $host . $request_uri . '?products_per_page=';
	} elseif (strpos($query_string, 'products_per_page') === false) {
		$url = $protocol . $host . $request_uri . '&products_per_page=';
	} else {
		$parts = explode('products_per_page=' . $_GET['products_per_page'], $request_uri);

		$url = $protocol . $host . $parts[0] . 'products_per_page=';
		$after_url = $parts[1];
	}

	echo '<p class="mpcth-products-per-page">';
		echo'<span>' . __('View', 'mpcth') . ': </span>';
		echo '<a href="' . $url . ($number * 2) . $after_url . '">' . ($number * 2) . '</a> / ';
		echo '<a href="' . $url . ($number * 4) . $after_url . '">' . ($number * 4) . '</a> / ';
		echo '<a href="' . $url . 'all' . $after_url . '">' . __('All', 'mpcth') . '</a>';
	echo '</p>';
}

add_filter('woocommerce_product_tabs', 'mpcth_custom_product_tabs');
function mpcth_custom_product_tabs($tabs) {
	$custom_tabs = get_field('mpc_custom_tab');

	if (! empty($custom_tabs)) {
		$priority = 0;
		foreach ($custom_tabs as $index => $custom_tab) {
			$tabs['custom_tab_' . sanitize_title($custom_tab['mpc_custom_tab_title'])] = array(
				'title' 	=> $custom_tab['mpc_custom_tab_title'],
				'priority' 	=> 50 + $priority,
				'callback' 	=> 'mpcth_print_custom_product_tabs',
				'index' 	=> $index
			);

			$priority += 10;
		}
	}

	return $tabs;
}
function mpcth_print_custom_product_tabs($title, $atts) {
	// global $product;
	$custom_tabs = get_field('mpc_custom_tab');
	$index = $atts['index'];

	echo $custom_tabs[$index]['mpc_custom_tab_content'];
}

add_filter('add_to_cart_fragments', 'mpcth_wc_ajaxify_mini_cart_icon');
function mpcth_wc_ajaxify_mini_cart_icon($fragments) {
	ob_start();

	?>
	<span class="mpcth-mini-cart-icon-info">
		<?php if (sizeof( WC()->cart->get_cart()) > 0) { ?>
			<?php echo __('Subtotal', 'mpcth'); ?>: <?php echo WC()->cart->get_cart_subtotal(); ?> (<?php echo WC()->cart->cart_contents_count; ?>)
		<?php } ?>
	</span>

	<?php

	$fragments['span.mpcth-mini-cart-icon-info'] = ob_get_clean();

	return $fragments;
}

add_filter('add_to_cart_fragments', 'mpcth_wc_ajaxify_mini_cart');
function mpcth_wc_ajaxify_mini_cart($fragments) {
	ob_start();

	mpcth_wc_print_mini_cart();

	$fragments['div#mpcth_mini_cart_wrap'] = ob_get_clean();

	return $fragments;
}

function mpcth_wc_print_mini_cart() {
	if (function_exists('is_woocommerce')) {
	?>
	<div id="mpcth_mini_cart_wrap">
		<?php if ( sizeof( WC()->cart->get_cart() ) > 0 ) : ?>
			<ul class="mpcth-mini-cart-products">
				<?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
					$_product = $cart_item['data'];

					// Only display if allowed
					if ( ! apply_filters('woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) || ! $_product->exists() || $cart_item['quantity'] == 0 )
						continue;

					// Get price
					$product_price = get_option( 'woocommerce_tax_display_cart' ) == 'excl' ? $_product->get_price_excluding_tax() : $_product->get_price_including_tax();
					$product_price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key );
					?>

					<li class="mpcth-mini-cart-product">
						<span class="mpcth-mini-cart-thumbnail">
							<?php echo $_product->get_image(); ?>
							<?php echo apply_filters( 'woocommerce_cart_item_remove_link', '<a href="' . esc_url( WC()->cart->get_remove_url( $cart_item_key ) ) . '" class="mpcth-mini-cart-remove mpcth-color-main-color" title="' . __( 'Remove this item', 'woocommerce' ) . '">&times;</a>', $cart_item_key ); ?>
						</span>
						<span class="mpcth-mini-cart-info">
							<a class="mpcth-mini-cart-title" href="<?php echo get_permalink( $cart_item['product_id'] ); ?>">
								<?php echo apply_filters('woocommerce_widget_cart_product_title', $_product->get_title(), $_product ); ?>
							</a>
							<?php echo apply_filters( 'woocommerce_widget_cart_item_price', '<span class="mpcth-mini-cart-price">' . __('Unit Price', 'mpcth') . ': ' . $product_price . '</span>', $cart_item, $cart_item_key ); ?>
							<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="mpcth-mini-cart-quantity">' . __('Quantity', 'mpcth') . ': ' . $cart_item['quantity'] . '</span>', $cart_item, $cart_item_key ); ?>
						</span>
					</li>

				<?php endforeach; ?>
			</ul><!-- end .mpcth-mini-cart-products -->
		<?php else : ?>
			<p class="mpcth-mini-cart-product-empty"><?php _e( 'No products in the cart.', 'woocommerce' ); ?></p>
		<?php endif; ?>

		<?php if (sizeof( WC()->cart->get_cart()) > 0) : ?>
			<p class="mpcth-mini-cart-subtotal mpcth-color-main-color"><?php _e( 'Cart Subtotal', 'woocommerce' ); ?>: <?php echo WC()->cart->get_cart_subtotal(); ?></p>

			<a href="<?php echo WC()->cart->get_cart_url(); ?>" class="button cart mpcth-color-main-background-hover"><?php _e( 'View Cart', 'woocommerce' ); ?></a>
			<a href="<?php echo WC()->cart->get_checkout_url(); ?>" class="button alt checkout mpcth-color-main-background"><?php _e( 'Proceed to Checkout', 'woocommerce' ); ?></a>
		<?php endif; ?>
	</div>
	<?php
	}
}

add_action('woocommerce_after_add_to_cart_button', 'mpcth_add_wishlist', 5);
function mpcth_add_wishlist() {
	if (shortcode_exists('yith_wcwl_add_to_wishlist')) echo do_shortcode('[yith_wcwl_add_to_wishlist]');
}

add_filter('loop_shop_per_page', 'mpcth_products_per_page', 20);
function mpcth_products_per_page() {
	global $mpcth_options;

	$number = 9;

	// if ($sidebar_position == 'none' && $number % 2 !== 0)
	// 	$number -= 1;

	if (isset($mpcth_options['mpcth_products_number']) && $mpcth_options['mpcth_products_number'])
		$number = $mpcth_options['mpcth_products_number'];

	if (! empty($_GET['products_per_page']))
		if (is_numeric($_GET['products_per_page']))
			$number = (int)$_GET['products_per_page'];
		elseif ($_GET['products_per_page'] == 'all')
			$number = -1;

	return $number;
}

add_filter('loop_shop_columns', 'mpcth_products_columns');
function mpcth_products_columns() {
	return 3;
}

/* Disable the WordPress Admin Bar for all but admins. */
if (! current_user_can('edit_posts')):
show_admin_bar(false);
endif;

/* ---------------------------------------------------------------- */
/* Helpers
/* ---------------------------------------------------------------- */
add_filter('widget_text', 'do_shortcode');

function mpcth_adjust_brightness($hex, $adjust) {
	$adjust = max(-255, min(255, $adjust));

	$rgba = mpcth_hex_to_rgba($hex);

	$r = $rgba[0];
	$g = $rgba[1];
	$b = $rgba[2];

	$r = max(0, min(255, $r + $adjust));
	$g = max(0, min(255, $g + $adjust));
	$b = max(0, min(255, $b + $adjust));

	$r_hex = str_pad(dechex($r), 2, '0', STR_PAD_LEFT);
	$g_hex = str_pad(dechex($g), 2, '0', STR_PAD_LEFT);
	$b_hex = str_pad(dechex($b), 2, '0', STR_PAD_LEFT);

	return '#'.$r_hex.$g_hex.$b_hex;
}

function mpcth_hex_to_rgba($hex, $alpha = 1) {
	$hex = str_replace("#", "", $hex);

	if(strlen($hex) == 3) {
		$r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
		$g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
		$b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
	} else {
		$r = hexdec(substr($hex, 0, 2));
		$g = hexdec(substr($hex, 2, 2));
		$b = hexdec(substr($hex, 4, 2));
	}

	return array($r, $g, $b, $alpha);
}

function mpcth_random_ID($length = 5) {
	return substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $length);
}