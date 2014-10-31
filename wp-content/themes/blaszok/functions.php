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

/* WooCommerce jquery.cookie server issue workaround */
add_action('init', 'mpcth_woo_fix');
function mpcth_woo_fix() {
	wp_register_script('jquery-cookie', MPC_THEME_URI . '/js/jquery.cokies' . (defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min') . '.js', array('jquery'), '1.3.1', true);
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
/* Panel notice
/* ---------------------------------------------------------------- */
add_action('admin_notices', 'mpcth_theme_update');
function mpcth_theme_update() {
	$mpc_theme = wp_get_theme();
	$saved_version = get_option('mpc_theme_version');

	if($mpc_theme->get('Version') !== $saved_version) {
		echo '<div id="mpcth_theme_update" class="updated fade"><p><strong>' . __('Blaszok theme', 'mpcth') . '</strong> ' . __('was successfully updated. Please go to', 'mpcth') . ' <em>' . __('Theme Options', 'mpcth') . '</em>.</p></div>';
	}
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
	if (isset($mpcth_options['mpcth_menu_font']) && is_array($mpcth_options['mpcth_menu_font'])) {
		if ($mpcth_options['mpcth_menu_font']['type'] == 'google') {
			$menu_family = str_replace(' ', '+', $mpcth_options['mpcth_menu_font']['family']);
			$menu_style = $mpcth_options['mpcth_menu_font']['style'] != 'regular' ? ':' . $mpcth_options['mpcth_menu_font']['style'] : '';
			wp_enqueue_style('mpc-menu-font', "$protocol://fonts.googleapis.com/css?family={$menu_family}{$menu_style}");
		}
	}

	if (! is_rtl())
		wp_enqueue_style('mpc-styles', get_template_directory_uri() . '/style.css');
	else
		wp_enqueue_style('mpc-styles', get_template_directory_uri() . '/style-rtl.css');

//	if (get_template_directory_uri() != get_stylesheet_directory_uri())
//		wp_enqueue_style('mpc-styles-child', get_stylesheet_directory_uri() . '/style.css');

	if ($mpcth_options['mpcth_theme_skin'] != 'default')
		wp_enqueue_style('mpc-skins-styles', get_template_directory_uri() . '/css/' . $mpcth_options['mpcth_theme_skin'] . '.css');

	wp_enqueue_style('mpc-styles-custom', get_stylesheet_directory_uri() . '/style_custom.css');

	/* Transparent Header */
	// $enable_transparent_header = get_field('mpc_enable_transparent_header') && get_field('mpc_header_content') != '';
	$enable_transparent_header = get_field('mpc_enable_transparent_header');
	if ($enable_transparent_header) {
		$force_simple_buttons = $enable_transparent_header && get_field('mpc_force_simple_buttons');
		$background_opacity = $enable_transparent_header ? get_field('mpc_background_opacity') : false;
		$force_background_color = $enable_transparent_header ? get_field('mpc_force_background_color') : false;
		$force_font_color = $enable_transparent_header ? get_field('mpc_force_font_color') : false;
		$sticky_force_background_color = $enable_transparent_header ? get_field('mpc_force_background_color_sticky') : false;
		$sticky_force_font_color = $enable_transparent_header ? get_field('mpc_force_font_color_sticky') : false;

		$rgba_background = mpcth_hex_to_rgba($force_background_color, $background_opacity / 100);
		$sticky_rgba_background = mpcth_hex_to_rgba($sticky_force_background_color, .95);

		$custom_styles = "";

		if ($force_font_color !== '')
			$custom_styles .= "
#mpcth_header_second_section #mpcth_page_header_secondary_content,
#mpcth_header_second_section #mpcth_page_header_secondary_content a,
#mpcth_header_second_section,
#mpcth_page_header_wrap #mpcth_header_section,
#mpcth_page_header_wrap #mpcth_header_section a,
#mpcth_page_header_wrap #mpcth_header_section #mpcth_nav a,
#mpcth_page_header_wrap.mpcth-simple-buttons-enabled #mpcth_header_section #mpcth_controls_wrap #mpcth_controls_container > a
		{ color: $force_font_color; }

#mpcth_nav .mpcth-menu > .page_item.menu-item-has-children > a:after,
#mpcth_nav .mpcth-menu > .menu-item.menu-item-has-children > a:after,
#mpcth_header_section #mpcth_page_header_content #mpcth_mega_menu .menu-item-has-children > a:after
		{ border-color: $force_font_color; }";

		if ($sticky_force_font_color !== '')
			$custom_styles .= "
.mpcth-sticky-header #mpcth_header_second_section #mpcth_page_header_secondary_content,
.mpcth-sticky-header #mpcth_header_second_section #mpcth_page_header_secondary_content a,
.mpcth-sticky-header #mpcth_header_second_section,
#mpcth_page_header_wrap.mpcth-sticky-header #mpcth_header_section,
#mpcth_page_header_wrap.mpcth-sticky-header #mpcth_header_section a,
#mpcth_page_header_wrap.mpcth-sticky-header #mpcth_header_section #mpcth_nav .mpcth-menu > li > a,
#mpcth_page_header_wrap.mpcth-sticky-header #mpcth_header_section #mpcth_nav .menu > li > a,
#mpcth_page_header_wrap.mpcth-sticky-header.mpcth-simple-buttons-enabled #mpcth_header_section #mpcth_controls_wrap #mpcth_controls_container > a
		{ color: $sticky_force_font_color; }

.mpcth-sticky-header #mpcth_nav .mpcth-menu > .page_item.menu-item-has-children > a:after,
.mpcth-sticky-header #mpcth_nav .mpcth-menu > .menu-item.menu-item-has-children > a:after,
.mpcth-sticky-header #mpcth_header_section #mpcth_page_header_content #mpcth_mega_menu .menu-item-has-children > a:after
		{ border-color: $sticky_force_font_color; }";

		if ($force_background_color !== '')
			$custom_styles .= "
#mpcth_page_header_wrap #mpcth_header_section,
#mpcth_page_header_wrap #mpcth_header_second_section
		{
			background-color: transparent;
			background-color: rgba($rgba_background[0], $rgba_background[1], $rgba_background[2], $rgba_background[3]);
		}";

		if ($sticky_force_background_color !== '')
			$custom_styles .= "
#mpcth_page_header_wrap.mpcth-sticky-header #mpcth_header_section,
#mpcth_page_header_wrap.mpcth-sticky-header:hover #mpcth_header_section,
#mpcth_page_header_wrap.mpcth-sticky-header #mpcth_header_second_section
		{
			background-color: $sticky_force_background_color;
			background-color: rgba($sticky_rgba_background[0], $sticky_rgba_background[1], $sticky_rgba_background[2], $sticky_rgba_background[3]);
		}";

		$custom_styles .= "
#mpcth_page_header_wrap #mpcth_header_second_section,
#mpcth_page_header_wrap #mpcth_header_section
		{ border: none; }";

		wp_add_inline_style('mpc-styles-custom', $custom_styles);
	}
	/* END - Transparent Header */

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
/* Cache Google Webfonts
/* ---------------------------------------------------------------- */
add_action('wp_ajax_mpcth_cache_google_webfonts', 'mpcth_cache_google_webfonts');
function mpcth_cache_google_webfonts() {
	$google_webfonts = isset($_POST['google_webfonts']) ? $_POST['google_webfonts'] : '';

	if(!empty($google_webfonts)) {
		set_transient('mpcth_google_webfonts', $google_webfonts, DAY_IN_SECONDS);
	}

	die();
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
/* Register demo install
/* ---------------------------------------------------------------- */
require_once(MPC_THEME_PATH . '/demos/demo_content_install.php');

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
	} elseif (is_single()) {
		if ($post_type == 'post')
			$sidebar_position = $mpcth_options['mpcth_blog_post_sidebar'];
		elseif ($post_type == 'mpc_portfolio' && isset($mpcth_options['mpcth_portfolio_post_sidebar']))
			$sidebar_position = $mpcth_options['mpcth_portfolio_post_sidebar'];
	}

	if (isset($post_meta['_wp_page_template'][0]) && ($post_meta['_wp_page_template'][0] == 'template-lookbook.php' || $post_meta['_wp_page_template'][0] == 'template-fullwidth.php'))
			$sidebar_position = 'none';

	if (class_exists('bbPress') && is_bbpress()) {
		if (isset($mpcth_options['mpcth_forum_sidebar']))
			$sidebar_position = $mpcth_options['mpcth_forum_sidebar'];
		else
			$sidebar_position = 'none';
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
					echo '<a href="' . ($name == 'envelope' ? 'mailto:' . $mpcth_options['mpcth_social_' . $name] : esc_url($mpcth_options['mpcth_social_' . $name])) . '" class="mpcth-social-' . $name . '">';
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
		'prev_text' => '<i class="fa fa-angle-' . (is_rtl() ? 'right' : 'left') . '"></i>',
		'next_text' => '<i class="fa fa-angle-' . (is_rtl() ? 'left' : 'right') . '"></i>',
		'total' => $query->max_num_pages
	));
}

/* ---------------------------------------------------------------- */
/* Display load more
/* ---------------------------------------------------------------- */
function mpcth_display_load_more($query) {
	if ($query->max_num_pages <= 1)
		return;
	?>
	<a href="#" id="mpcth_load_more"><?php _e('Load more', 'mpcth'); ?><span class="mpcth-load-more-icon"></span></a>
	<?php
		echo paginate_links(array(
			'base' 			=> str_replace(999999, '%#%', get_pagenum_link(999999)),
			'format' 		=> '',
			'current' 		=> max(1, get_query_var('paged')),
			'total' 		=> $query->max_num_pages,
			'prev_text' 	=> '',
			'next_text' 	=> '',
			'type'			=> 'list',
			'end_size'		=> 1,
			'mid_size'		=> 1
		));
	?>
	<div id="mpcth_load_more_wrapper" data-max-pages="<?php echo $query->max_num_pages; ?>"></div>
	<?php
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
			$wishlist_name = get_option('yith_wcwl_wishlist_title');
			echo '<a href="' . $yith_wcwl->get_wishlist_url() . '" class="mpcth-wc-wishlist">' . $wishlist_name . '</a>';
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

add_filter('woocommerce_product_description_tab_title', 'my_product_description_tab_title');
function my_product_description_tab_title($default) {
	global $mpcth_options;

	if (isset($mpcth_options['mpcth_tab_description_label']) && $mpcth_options['mpcth_tab_description_label'] != '')
		$default = $mpcth_options['mpcth_tab_description_label'];

	echo $default;
}

add_filter('woocommerce_product_additional_information_tab_title', 'my_product_additional_information_tab_title');
function my_product_additional_information_tab_title($default) {
	global $mpcth_options;

	if (isset($mpcth_options['mpcth_tab_additional_information_label']) && $mpcth_options['mpcth_tab_additional_information_label'] != '')
		$default = $mpcth_options['mpcth_tab_additional_information_label'];

	echo $default;
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
		} elseif (shortcode_exists('subscribe2') || shortcode_exists('mc4wp_form')) {
			echo '<div id="mpcth_newsletter">';
				echo '<a href="#" class="mpcth-newsletter-toggle">';
					if(isset($mpcth_options['mpcth_newsletter_text']))
						echo $mpcth_options['mpcth_newsletter_text'];
					else
						_e('Sign up for our newsletter', 'mpcth');
				echo '</a>';

				if (shortcode_exists('subscribe2'))
					echo do_shortcode('[subscribe2]');
				else
					echo do_shortcode('[mc4wp_form]');
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

	echo '<div id="mpcth_page_header_secondary_content" class="mpcth-header-order-' . $header_order . ' mpcth-header-position-' . $mpcth_options['mpcth_header_secondary_position'] . '">';
		if ($header_order == 'n_s_m') {
			mpcth_display_newsletter();
			mpcth_display_secondary_menu();
			echo '<ul id="mpcth_header_socials" class="mpcth-socials-list">';
				mpcth_display_social_list();
			echo '</ul>';
		} elseif ($header_order == 's_m_n') {
			echo '<ul id="mpcth_header_socials" class="mpcth-socials-list">';
				mpcth_display_social_list();
			echo '</ul>';
			mpcth_display_newsletter();
			mpcth_display_secondary_menu();
		} elseif ($header_order == 'm_n_s') {
			mpcth_display_secondary_menu();
			mpcth_display_newsletter();
			echo '<ul id="mpcth_header_socials" class="mpcth-socials-list">';
				mpcth_display_social_list();
			echo '</ul>';
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

require_once(MPC_THEME_PATH . '/php/mpc-bundle-plugins.php');

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
/* bbPress
/* ---------------------------------------------------------------- */

// add_filter('bbp_register_forum_post_type', 'mpcth_bbp_register_post_type');
// add_filter('bbp_register_topic_post_type', 'mpcth_bbp_register_post_type');
// add_filter('bbp_register_reply_post_type', 'mpcth_bbp_register_post_type');
// function mpcth_bbp_register_post_type($args) {
// 	$args['menu_position'] = 60;

// 	return $args;
// }

add_filter('bbp_topic_pagination', 'mpcth_bbp_change_pagination_arrows');
add_filter('bbp_search_results_pagination', 'mpcth_bbp_change_pagination_arrows');
add_filter('bbp_replies_pagination', 'mpcth_bbp_change_pagination_arrows');
function mpcth_bbp_change_pagination_arrows($args) {
	$args['prev_text'] = '<i class="fa fa-angle-' . (is_rtl() ? 'right' : 'left') . '"></i>';
	$args['next_text'] = '<i class="fa fa-angle-' . (is_rtl() ? 'left' : 'right') . '"></i>';

	return $args;
}

add_filter('bbp_before_get_breadcrumb_parse_args', 'mpcth_bbp_change_separator_arrows', 1);
function mpcth_bbp_change_separator_arrows($args) {
	$args['sep'] = '<i class="fa fa-angle-' . (is_rtl() ? 'left' : 'right') . '"></i>';

	return apply_filters('bbpsswap_filter_breadcrumb_sep', $args);
}

add_action('bbp_theme_before_topic_form_tags', 'mpcth_bbp_open_form_section_wrapper');
add_action('bbp_theme_before_topic_form_forum', 'mpcth_bbp_open_form_section_wrapper');
add_action('bbp_theme_before_topic_form_type', 'mpcth_bbp_open_form_section_wrapper');
add_action('bbp_theme_before_topic_form_status', 'mpcth_bbp_open_form_section_wrapper');
add_action('bbp_theme_before_topic_form_revisions', 'mpcth_bbp_open_form_section_wrapper');
add_action('bbp_theme_before_reply_form_tags', 'mpcth_bbp_open_form_section_wrapper');
add_action('bbp_theme_before_reply_form_revisions', 'mpcth_bbp_open_form_section_wrapper');
function mpcth_bbp_open_form_section_wrapper() {
	echo '<div class="mpcth-bbp-form-section">';
}

add_action('bbp_theme_after_topic_form_tags', 'mpcth_bbp_close_form_section_wrapper');
add_action('bbp_theme_after_topic_form_forum', 'mpcth_bbp_close_form_section_wrapper');
add_action('bbp_theme_after_topic_form_type', 'mpcth_bbp_close_form_section_wrapper');
add_action('bbp_theme_after_topic_form_status', 'mpcth_bbp_close_form_section_wrapper');
add_action('bbp_theme_after_topic_form_revisions', 'mpcth_bbp_close_form_section_wrapper');
add_action('bbp_theme_after_reply_form_tags', 'mpcth_bbp_close_form_section_wrapper');
add_action('bbp_theme_after_reply_form_revisions', 'mpcth_bbp_close_form_section_wrapper');
function mpcth_bbp_close_form_section_wrapper() {
	echo '</div>';
}

add_action('bbp_theme_before_topic_form_subscriptions', 'mpcth_bbp_open_form_subscriptions_wrapper');
add_action('bbp_theme_before_reply_form_subscription', 'mpcth_bbp_open_form_subscriptions_wrapper');
function mpcth_bbp_open_form_subscriptions_wrapper() {
	echo '<div class="mpcth-bbp-form-subscriptions">';
}

add_action('bbp_theme_after_topic_form_subscriptions', 'mpcth_bbp_close_form_subscriptions_wrapper');
add_action('bbp_theme_after_reply_form_subscription', 'mpcth_bbp_close_form_subscriptions_wrapper');
function mpcth_bbp_close_form_subscriptions_wrapper() {
	echo '</div>';
}

add_action('bbp_theme_before_topic_form_title', 'mpcth_bbp_open_form_title_wrapper');
function mpcth_bbp_open_form_title_wrapper() {
	echo '<div class="mpcth-bbp-form-title">';
}

add_action('bbp_theme_after_topic_form_title', 'mpcth_bbp_close_form_title_wrapper');
function mpcth_bbp_close_form_title_wrapper() {
	echo '</div>';
}

add_filter('bbp_get_single_forum_description', 'mpcth_bbp_blank_notice');
add_filter('bbp_get_single_topic_description', 'mpcth_bbp_blank_notice');
function mpcth_bbp_blank_notice() {
	return '';
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
	global $sidebar_position;
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

	if ($sidebar_position == 'none')
		$columns = 4;
	else
		$columns = 3;

	if ($shop_style == 'default' && isset($mpcth_options['mpcth_shop_columns_def']) && $mpcth_options['mpcth_shop_columns_def'])
		$columns = $mpcth_options['mpcth_shop_columns_def'];
	elseif ($shop_style != 'default' && isset($mpcth_options['mpcth_shop_columns_ext']) && $mpcth_options['mpcth_shop_columns_ext'])
		$columns = $mpcth_options['mpcth_shop_columns_ext'];

	if (! is_shop() && ! is_product_category() && ! is_product_tag())
		$columns = '';
	else
		$columns = ' mpcth-shop-columns-' . $columns;

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
				echo '<div id="mpcth_content" class="mpcth-shop-style-' . $shop_style . $columns . '">';
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
// add_filter('woocommerce_variable_sale_price_html', 'mpcth_custom_price', 10);

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