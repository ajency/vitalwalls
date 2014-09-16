<?php

/**
 * The theme option name is set as 'options-theme-customizer' here.
 * In your own project, you should use a different option name.
 * I'd recommend using the name of your theme.
 *
 * This option name will be used later when we set up the options
 * for the front end theme customizer.
 *
 * @package WordPress
 * @subpackage MPC WP Boilerplate
 * @since 1.0
 *
 */

function mpcth_optionsframework_option_name() {
	$mpcth_optionsframework_settings = get_option('mpcth_optionsframework');

	$mpcth_optionsframework_settings['id'] = MPC_OPTIONS_NAME;
	update_option('mpcth_optionsframework', $mpcth_optionsframework_settings);
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the "id" fields, make sure to use all lowercase and no spaces.
 */

function mpcth_optionsframework_options() {
	$default_values = array(
		// LOGO
		'enableTextLogo'  => '1',
		'logoText'        => __('MPC Theme', 'mpcth'),
		'logoDescription' => '0',

		/* FONT SIZES */
		'baseFontSize' => '12px',

		'advanceFontSizes' => array(
			'headerMenu'           => '12px',
			'headerDropdown'       => '12px',
			'headerButton'         => '12px',

			'headerSearch'         => '12px',

			'headerSecond'         => '11px',
			'headerSecondDropdown' => '12px',

			'contentHeader'        => '16px',
			'contentContent'       => '13px',
			'contentSmall'         => '12px',

			'sidebarHeader'        => '13px',
			'sidebarContent'       => '13px',
			'sidebarSmall'         => '12px',

			'footerHeader'         => '13px',
			'footerContent'        => '13px',
			'footerSmall'          => '12px',

			'footerExHeader'       => '13px',
			'footerExContent'      => '13px',
			'footerExSmall'        => '12px',

			'footerCopyright'      => '12px',
		),

		/* COLORS */
		'mainColor' => '#b363a0',
		'bgColor'   => '#ffffff',

		'advanceColors' => array(
			'headerBackground'       => '#ffffff',
			'headerBorder'           => '#eeeeee',
			'headerFont'             => '#666666',
			'headerActive'           => '#b363a0',

			'headerSecondBackground' => '#ffffff',
			'headerSecondBorder'     => '#eeeeee',
			'headerSecondFont'       => '#666666',
			'headerSecondActive'     => '#b363a0',

			'dropdownBackground'     => '#ffffff',
			'dropdownBorder'         => '#eeeeee',
			'dropdownFont'           => '#666666',
			'dropdownActive'         => '#b363a0',

			'searchBackground'       => '#ffffff',
			'searchBorder'           => '#eeeeee',
			'searchFont'             => '#666666',
			'searchActive'           => '#b363a0',

			'sidebarBackground'      => '#ffffff',
			'sidebarBorder'          => '#eeeeee',
			'sidebarFont'            => '#666666',
			'sidebarActive'          => '#b363a0',

			'contentBackground'      => '#ffffff',
			'contentBorder'          => '#eeeeee',
			'contentFont'            => '#666666',

			'footerBackground'       => '#ffffff',
			'footerBorder'           => '#eeeeee',
			'footerFont'             => '#666666',
			'footerActive'           => '#b363a0',

			'footerExBackground'     => '#ffffff',
			'footerExBorder'         => '#eeeeee',
			'footerExFont'           => '#666666',
			'footerExActive'         => '#b363a0',

			'copyrightBackground'    => '#ffffff',
			'copyrightBorder'        => '#eeeeee',
			'copyrightFont'          => '#666666',
			'copyrightActive'        => '#b363a0',
		),

		/* DISPLAY */
		'boxedType' => 'fullwidth',
		'themeSkin' => 'default',

		/* HEADER */
		'headerMainLayout'         => 'l_m_s',
		'newsletterText'           => __('Sign up to newsletter', 'mpcth'),
		'enableMegaMenu'           => '0',
		'enableHeaderSearch'       => '1',
		'enableSmartSearch'        => '0',
		'enableStickyHeader'       => '1',
		'enableMobileStickyHeader' => '0',
		'enableSimpleMenu'         => '0',
		'enableSimpleMenuLabel'    => '0',
		'enableSimpleButtons'      => '0',

		'enableSecondaryHeader'   => '1',
		'headerSecondaryLayout'   => 'n_s_m',
		'headerSecondaryPosition' => 'top',

		/* FOOTER */
		'enableFooter'       => '1',
		'footerColNum'       => '4',
		'enableToggleFooter' => '1',

		'enableFooterExtended'       => '1',
		'footerExtendedColNum'       => '4',
		'enableToggleFooterExtended' => '1',

		'enableCopyrights' => '1',
		'copyrightText'    => __('Copyright MassivePixelCreation 2013', 'mpcth'),

		/* WOOCOMMERCE */
		'shopColNum' => '4',
	 );

	$footer_columns = array(
		'1' => '1',
		'2' => '2',
		'3' => '3',
		'4' => '4'
	);

	$shop_columns_def = array(
		'2' => '2',
		'3' => '3',
		'4' => '4'
	);
	$shop_columns_ext = array(
		'2' => '2',
		'3' => '3',
		'4' => '4',
		'5' => '5',
		'6' => '6'
	);

	$back_to_top_position = array(
		'left'   => 'left',
		'center' => 'center',
		'right'  => 'right',
		'none'   => 'none'
	);

	$boxed_layouts = array(
		'fullwidth'      => __('Fullwidth', 'mpcth'),
		'boxed'          => __('Boxed', 'mpcth'),
		'floating_boxed' => __('Floating Boxed', 'mpcth'),
	);

	$header_main_layouts = array(
		'l_m_s'    => __('Logo, Menu, Search', 'mpcth'),
		'l_s_m'    => __('Logo, Search, Menu', 'mpcth'),
		'm_l_s'    => __('Menu, Center Logo, Search', 'mpcth'),
		'tl_m_s'   => __('Menu, Top Logo, Search', 'mpcth'),
		'l_rm_s'   => __('Logo, Right Menu, Search', 'mpcth'),
		'm_s_l'    => __('Menu, Search, Right Logo', 'mpcth'),
		'tl_cm_cs' => __('Logo, Center Menu & Search', 'mpcth'),
	);

	$header_secondary_layouts = array(
		'n_s_m' => __('Newsletter, Socials, Menu', 'mpcth'),
		's_m_n' => __('Socials, Menu, Newsletter', 'mpcth'),
		'm_n_s' => __('Menu, Newsletter, Socials', 'mpcth'),
	);
	$header_secondary_positions = array(
		'top'    => __('Top', 'mpcth'),
		'bottom' => __('Bottom', 'mpcth'),
	);

	$dropdown_image_alignment = array(
		'top left'      => __('Top Left', 'mpcth'),
		'top center'    => __('Top Center', 'mpcth'),
		'top right'     => __('Top Right', 'mpcth'),
		'center left'   => __('Center Left', 'mpcth'),
		'center center' => __('Center Center', 'mpcth'),
		'center right'  => __('Center Right', 'mpcth'),
		'bottom left'   => __('Bottom Left', 'mpcth'),
		'bottom center' => __('Bottom Center', 'mpcth'),
		'bottom right'  => __('Bottom Right', 'mpcth'),
	);

	$shop_styles = array(
		"default" => __("default", 'mpcth'),
		"slim"    => __("slim", 'mpcth'),
		"center"  => __("center", 'mpcth'),
	);

	$skins_options = array(
		"default"   => __("default", 'mpcth'),
		"skin_gray" => __("gray", 'mpcth'),
		"skin_gold" => __("gold", 'mpcth'),
		"skin_dark" => __("dark", 'mpcth'),
	);
	if (file_exists(get_stylesheet_directory() . '/css/skin_custom.css'))
		$skins_options["skin_custom"] = __("custom", 'mpcth');

	$background_options = array(
		"none"               => __("none", 'mpcth'),
		"color"              => __("color", 'mpcth'),
		"custom_background"  => __("custom background", 'mpcth'),
		"pattern_background" => __("pattern background", 'mpcth'),
	);

	$background_patterns = array(
		'pattern01' => 'patterns/pattern01.png',
		'pattern02' => 'patterns/pattern02.png',
		'pattern03' => 'patterns/pattern03.png',
		'pattern04' => 'patterns/pattern04.png',
		'pattern05' => 'patterns/pattern05.png',
		'pattern06' => 'patterns/pattern06.png',
		'pattern07' => 'patterns/pattern07.png',
		'pattern08' => 'patterns/pattern08.png',
		'pattern09' => 'patterns/pattern09.png',
		'pattern10' => 'patterns/pattern10.png',
		'pattern11' => 'patterns/pattern11.png',
		'pattern12' => 'patterns/pattern12.png'
	 );

	$socials = array(
		"adn" => "", "android" => "", "apple" => "", "behance" => "", "bitbucket" => "", "btc" => "", "codepen" => "", "css3" => "", "delicious" => "", "deviantart" => "", "digg" => "", "dribbble" => "", "dropbox" => "", "drupal" => "", "empire" => "", "envelope" => "", "facebook" => "", "flickr" => "", "foursquare" => "", "ge" => "", "git" => "", "github" => "", "gittip" => "", "google" => "", "google-plus" => "", "hacker-news" => "", "html5" => "", "instagram" => "", "joomla" => "", "jsfiddle" => "", "linkedin" => "", "linux" => "", "maxcdn" => "", "openid" => "", "pagelines" => "", "pied-piper" => "", "pinterest" => "", "qq" => "", "rebel" => "", "reddit" => "", "renren" => "", "rss" => "", "share-alt" => "", "skype" => "", "slack" => "", "soundcloud" => "", "spotify" => "", "stack-exchange" => "", "stack-overflow" => "", "steam" => "", "stumbleupon" => "", "tencent-weibo" => "", "trello" => "", "tumblr" => "", "twitter" => "", "vimeo-square" => "", "vine" => "", "vk" => "", "wechat" => "", "weibo" => "", "windows" => "", "wordpress" => "", "xing" => "", "yahoo" => "", "youtube" => ""
	 );

	$options = array();

/* ---------------------------------------------------------------- */
/* General
/* ---------------------------------------------------------------- */
	$options[] = array(
		"name" 	=> __("General", 'mpcth'),
		"icon" 	=> "fa fa-fw fa-cogs",
		"type" 	=> "heading" );

/* ---------------------------------------------------------------- */
/* Fav Icon
/* ---------------------------------------------------------------- */
	$options[] = array(
		"name" => __("Fav Icon", 'mpcth'),
		"type" => "accordion");

	$options['mpcth_enable_fav_icon'] = array(
		"id" 				=> "mpcth_enable_fav_icon",
		"name" 				=> __("Enable Fav Icon", 'mpcth'),
		"desc" 				=> __("Check this option to enable fav icon.", 'mpcth'),
		"type" 				=> "checkbox",
		"std" 				=> "0",
		"additional_fun" 	=> "hide",
		"hide_class" 		=> "mpcth_fav_icon" );

	$options['mpcth_fav_icon'] = array(
		"id" 	=> "mpcth_fav_icon",
		"name" 	=> __("Upload Fav Icon", 'mpcth'),
		"desc" 	=> __("Use the upload to upload your custom fav icon. To learn more about the Fav Icon please read <a href='http://en.wikipedia.org/wiki/Favicon' target='_blank'>this article</a>.", 'mpcth'),
		"class" => "mpcth_fav_icon",
		"type" 	=> "upload" );

/* ---------------------------------------------------------------- */
/* Google Analytics
/* ---------------------------------------------------------------- */
	$options[] = array(
		"name" => __("Google Analytics", 'mpcth'),
		"type" => "accordion");

	$options['mpcth_enable_analytics'] = array(
		"id" 				=> "mpcth_enable_analytics",
		"name" 				=> __("Enable Google Analytics", 'mpcth'),
		"desc" 				=> __("Check this option to enable Google Analytics.", 'mpcth'),
		"type" 				=> "checkbox",
		"std" 				=> "0",
		"additional_fun" 	=> "hide",
		"hide_class" 		=> "mpcth_analytics_code" );

	$options['mpcth_analytics_code'] = array(
		"id" 		=> "mpcth_analytics_code",
		"name" 		=> __("Google Analytics Code", 'mpcth'),
		"desc" 		=> __('Insert your google analytics code, for more information read <a href="https://support.google.com/analytics/bin/answer.py?hl=en&utm_medium=et&utm_campaign=en_us&utm_source=SetupChecklist&answer=1008080">this</a>. Don\'t worry that your script tags where removed, they will be added automatically.', 'mpcth'),
		"type" 		=> "textarea-big",
		"std" 		=> "",
		"class" 	=> "mpcth_analytics_code" );

/* ---------------------------------------------------------------- */
/* Demo Wizard
/* ---------------------------------------------------------------- */
	$options[] = array(
		"name" => __("Demo Wizard", 'mpcth'),
		"type" => "accordion");

	$options['mpcth_disable_demo_wizard'] = array(
		"id" 	=> "mpcth_disable_demo_wizard",
		"name" 	=> __("Disable Demo Wizard", 'mpcth'),
		"desc" 	=> __("Check this option to disable demo wizard.", 'mpcth'),
		"type" 	=> "checkbox",
		"std" 	=> "0" );

/* ---------------------------------------------------------------- */
/* Fonts
/* ---------------------------------------------------------------- */
	$options[] = array(
		"name" => __("Fonts", 'mpcth'),
		"icon" => "fa fa-fw fa-font",
		"type" => "heading" );

/* ---------------------------------------------------------------- */
/* Font Family
/* ---------------------------------------------------------------- */
	$options[] = array(
		"name" => __("Font Family", 'mpcth'),
		"type" => "accordion");

	$options['mpcth_heading_font'] = array(
		"id" 	=> "mpcth_heading_font",
		"name" 	=> __("Heading Font", 'mpcth'),
		"desc" 	=> __("Specify headings font.", 'mpcth'),
		"type" 	=> "font_select",
		"std" 	=> "default" );

	$options['mpcth_content_font'] = array(
		"id" 	=> "mpcth_content_font",
		"name" 	=> __("Content Font", 'mpcth'),
		"desc" 	=> __("Specify content font.", 'mpcth'),
		"type" 	=> "font_select",
		"std" 	=> "default" );

	$options['mpcth_menu_font'] = array(
		"id" 	=> "mpcth_menu_font",
		"name" 	=> __("Menu Font", 'mpcth'),
		"desc" 	=> __("Specify menu font.", 'mpcth'),
		"type" 	=> "font_select",
		"std" 	=> "default" );

/* ---------------------------------------------------------------- */
/* Font Size
/* ---------------------------------------------------------------- */
	$options[] = array(
		"name" => __("Font Size", 'mpcth'),
		"type" => "accordion");

	$options['mpcth_base_font_size'] = array(
	 	"id" 	=> "mpcth_base_font_size",
	 	"name" 	=> __("Base Font Size", 'mpcth'),
	 	"desc" 	=> __("Specify base font size.", 'mpcth'),
	 	"type" 	=> "slider",
	 	"std" 	=> $default_values['baseFontSize'],
	 	"min" 	=> "10",
	 	"max" 	=> "30" );

/* ---------------------------------------------------------------- */
/* Elements
/* ---------------------------------------------------------------- */
	$options[] = array(
		"name" => __("Elements", 'mpcth'),
		"icon" => "fa fa-fw fa-th",
		"type" => "heading" );

/* ---------------------------------------------------------------- */
/* Logo
/* ---------------------------------------------------------------- */
	$options[] = array(
		"name" => __("Logo", 'mpcth'),
		"type" => "accordion");

	$options['mpcth_enable_text_logo'] = array(
		"id" 				=> "mpcth_enable_text_logo",
		"name" 				=> __("Use Text Logo", 'mpcth'),
		"desc" 				=> __("Check it if you want to use text logo.", 'mpcth'),
		"type" 				=> "checkbox",
		"std" 				=> $default_values['enableTextLogo'],
		"additional_fun" 	=> "toggle",
		"toggle_on"			=> "mpcth_text_logo",
		"toggle_off"		=> "mpcth_logo" );

	$options['mpcth_text_logo'] = array(
		"id" 	=> "mpcth_text_logo",
		"name" 	=> __("Text", 'mpcth'),
		"desc" 	=> __('Specify your site logo text.', 'mpcth'),
		"class" => "mpcth_text_logo",
		"type" 	=> "text",
		"std" 	=> $default_values['logoText'] );

	$options['mpcth_logo'] = array(
		"id" 	=> "mpcth_logo",
		"name" 	=> __("Upload Logo", 'mpcth'),
		"desc" 	=> __("Upload your logo here.", 'mpcth'),
		"class" => "mpcth_logo",
		"type" 	=> "upload",
		"std"	=> "" );

	$options['mpcth_logo_2x'] = array(
		"id" 	=> "mpcth_logo_2x",
		"name" 	=> __("Upload Retina Logo", 'mpcth'),
		"desc" 	=> __("Upload your retina logo here.", 'mpcth'),
		"class" => "mpcth_logo",
		"type" 	=> "upload",
		"std"	=> "" );

	$options['mpcth_logo_mobile'] = array(
		"id" 	=> "mpcth_logo_mobile",
		"name" 	=> __("Upload Mobile Logo", 'mpcth'),
		"desc" 	=> __("Upload your mobile logo here (leave empty to use default logo).", 'mpcth'),
		"class" => "mpcth_logo",
		"type" 	=> "upload",
		"std"	=> "" );

	$options['mpcth_logo_mobile_2x'] = array(
		"id" 	=> "mpcth_logo_mobile_2x",
		"name" 	=> __("Upload Retina Mobile Logo", 'mpcth'),
		"desc" 	=> __("Upload your retina mobile logo here (leave empty to use default logo).", 'mpcth'),
		"class" => "mpcth_logo",
		"type" 	=> "upload",
		"std"	=> "" );

	$options['mpcth_logo_sticky'] = array(
		"id" 	=> "mpcth_logo_sticky",
		"name" 	=> __("Upload Sticky Logo", 'mpcth'),
		"desc" 	=> __("Upload your sticky logo here.", 'mpcth'),
		"class" => "mpcth_logo",
		"type" 	=> "upload",
		"std"	=> "" );

	$options['mpcth_logo_sticky_2x'] = array(
		"id" 	=> "mpcth_logo_sticky_2x",
		"name" 	=> __("Upload Sticky Retina Logo", 'mpcth'),
		"desc" 	=> __("Upload your sticky retina logo here.", 'mpcth'),
		"class" => "mpcth_logo",
		"type" 	=> "upload",
		"std"	=> "" );

	$options['mpcth_text_logo_description'] = array(
		"id" 	=> "mpcth_text_logo_description",
		"name" 	=> __("Description", 'mpcth'),
		"desc" 	=> __('Specify if the description (tagline) for your site should be displayed next to a logo.', 'mpcth'),
		"type" 	=> "checkbox",
		"std" 	=> 0 );

/* ---------------------------------------------------------------- */
/* Sidebar
/* ---------------------------------------------------------------- */
	$options[] = array(
		"name" 	=> __("Sidebar", 'mpcth'),
		"type" 	=> "accordion");

	$options['mpcth_default_sidebar'] = array(
		"id" 		=> "mpcth_default_sidebar",
		"name" 		=> __("Default Sidebar Position", 'mpcth'),
		"desc" 		=> __("Set the default sidebar position for all pages.", 'mpcth'),
		"type" 		=> "sidebar",
		"std" 		=> "right",
		"options" 	=> array(
			'right' => 'right',
			'none' 	=> 'none',
			'left' 	=> 'left'
		) );

	$options['mpcth_blog_post_sidebar'] = array(
		"id" 		=> "mpcth_blog_post_sidebar",
		"name" 		=> __("Default Blog Post Sidebar Position", 'mpcth'),
		"desc" 		=> __("Set the default sidebar position for all of blog posts.", 'mpcth'),
		"type" 		=> "sidebar",
		"std" 		=> "right",
		"options" 	=> array(
			'right' => 'right',
			'none' 	=> 'none',
			'left' 	=> 'left'
		) );

	if(post_type_exists('mpc_portfolio')) {
		$options['mpcth_portfolio_post_sidebar'] = array(
			"id" 		=> "mpcth_portfolio_post_sidebar",
			"name" 		=> __("Default Portfolio Post Sidebar Position", 'mpcth'),
			"desc" 		=> __("Set the default sidebar position for all of portfolio posts.", 'mpcth'),
			"type" 		=> "sidebar",
			"std" 		=> "right",
			"options" 	=> array(
				'right' => 'right',
				'none' 	=> 'none',
				'left' 	=> 'left'
			) );
	}

	$options['mpcth_search_sidebar'] = array(
		"id" 		=> "mpcth_search_sidebar",
		"name" 		=> __("Default Search Sidebar Position", 'mpcth'),
		"desc" 		=> __("Set the default sidebar position for Search page.", 'mpcth'),
		"type" 		=> "sidebar",
		"std" 		=> "right",
		"options" 	=> array(
			'right' => 'right',
			'none' 	=> 'none',
			'left' 	=> 'left'
		) );

	$options['mpcth_archive_sidebar'] = array(
		"id" 		=> "mpcth_archive_sidebar",
		"name" 		=> __("Default Archive Sidebar Position", 'mpcth'),
		"desc" 		=> __("Set the default sidebar position for Archive page.", 'mpcth'),
		"type" 		=> "sidebar",
		"std" 		=> "right",
		"options" 	=> array(
			'right' => 'right',
			'none' 	=> 'none',
			'left' 	=> 'left'
		) );

	$options['mpcth_error_sidebar'] = array(
		"id" 		=> "mpcth_error_sidebar",
		"name" 		=> __("Default 404 Error Sidebar Position", 'mpcth'),
		"desc" 		=> __("Set the default sidebar position for 404 Error page.", 'mpcth'),
		"type" 		=> "sidebar",
		"std" 		=> "right",
		"options" 	=> array(
			'right' => 'right',
			'none' 	=> 'none',
			'left' 	=> 'left'
		) );

	if (class_exists('bbPress')) {
		$options['mpcth_forum_sidebar'] = array(
			"id" 		=> "mpcth_forum_sidebar",
			"name" 		=> __("Default Forum Sidebar Position", 'mpcth'),
			"desc" 		=> __("Set the default sidebar position for forum page.", 'mpcth'),
			"type" 		=> "sidebar",
			"std" 		=> "right",
			"options" 	=> array(
				'right' => 'right',
				'none' 	=> 'none',
				'left' 	=> 'left'
			) );
	}

/* ---------------------------------------------------------------- */
/* Header
/* ---------------------------------------------------------------- */
	$options[] = array(
		"name" 	=> __("Header", 'mpcth'),
		"type" 	=> "accordion");

	$options['mpcth_header_main_layout'] = array(
		"id" 		=> "mpcth_header_main_layout",
		"name" 		=> __("Main Header Layout", 'mpcth'),
		"desc" 		=> __("Choose one of main header layouts.", 'mpcth'),
		"type" 		=> "select",
		"std" 		=> $default_values['headerMainLayout'],
		"options" 	=> $header_main_layouts );

	$options['mpcth_enable_mega_menu'] = array(
		"id" 		=> "mpcth_enable_mega_menu",
		"name" 		=> __("Enable Mega Menu", 'mpcth'),
		"desc" 		=> __("Specify if you want to display mega menu.", 'mpcth'),
		"type" 		=> "checkbox",
		"std" 		=> $default_values['enableMegaMenu']);

	$options['mpcth_enable_header_search'] = array(
		"id" 		=> "mpcth_enable_header_search",
		"name" 		=> __("Enable Search", 'mpcth'),
		"desc" 		=> __("Specify if you want to display search in header.", 'mpcth'),
		"type" 		=> "checkbox",
		"std" 		=> $default_values['enableHeaderSearch']);

	$options['mpcth_enable_smart_search'] = array(
		"id" 		=> "mpcth_enable_smart_search",
		"name" 		=> __("Enable Smart Search", 'mpcth'),
		"desc" 		=> __("Specify if you want to display smart search.", 'mpcth'),
		"type" 		=> "checkbox",
		"std" 		=> $default_values['enableSmartSearch']);

	$options['mpcth_enable_sticky_header'] = array(
		"id" 		=> "mpcth_enable_sticky_header",
		"name" 		=> __("Enable Sticky Header", 'mpcth'),
		"desc" 		=> __("Specify if you want to show sticky header at the top of page.", 'mpcth'),
		"type" 		=> "checkbox",
		"std" 		=> $default_values['enableStickyHeader']);

	$options['mpcth_enable_mobile_sticky_header'] = array(
		"id" 		=> "mpcth_enable_mobile_sticky_header",
		"name" 		=> __("Enable Mobile Sticky Header", 'mpcth'),
		"desc" 		=> __("Specify if you want to show sticky header at the top of page on mobile.", 'mpcth'),
		"type" 		=> "checkbox",
		"std" 		=> $default_values['enableMobileStickyHeader']);

	$options['mpcth_enable_simple_menu'] = array(
		"id" 				=> "mpcth_enable_simple_menu",
		"name" 				=> __("Enable Simple Menu", 'mpcth'),
		"desc" 				=> __("Specify if you want to display simple slide down mobile menu under the header. It will disable the side menu.", 'mpcth'),
		"type" 				=> "checkbox",
		"std" 				=> $default_values['enableSimpleMenu'],
		"additional_fun" 	=> "hide",
		"hide_class" 		=> "simple_menu_label" );

	$options['mpcth_enable_simple_menu_label'] = array(
		"id" 		=> "mpcth_enable_simple_menu_label",
		"name" 		=> __("Enable Simple Menu Label", 'mpcth'),
		"desc" 		=> __("Specify if you want to display \"Menu\" label for simple menu button.", 'mpcth'),
		"class" 	=> "simple_menu_label",
		"type" 		=> "checkbox",
		"std" 		=> $default_values['enableSimpleMenuLabel']);

	$options['mpcth_enable_simple_buttons'] = array(
		"id" 		=> "mpcth_enable_simple_buttons",
		"name" 		=> __("Enable Simple Buttons", 'mpcth'),
		"desc" 		=> __("Specify if you want to display simple buttons (only icon).", 'mpcth'),
		"type" 		=> "checkbox",
		"std" 		=> $default_values['enableSimpleButtons']);

/* ---------------------------------------------------------------- */
/* Secondary Header
/* ---------------------------------------------------------------- */
	$options[] = array(
		"name" 	=> __("Secondary Header", 'mpcth'),
		"type" 	=> "accordion");

	$options['mpcth_enable_secondary_header'] = array(
		"id" 				=> "mpcth_enable_secondary_header",
		"name" 				=> __("Enable Secondary Header", 'mpcth'),
		"desc" 				=> __("Uncheck this option to disable secondary header.", 'mpcth'),
		"type" 				=> "checkbox",
		"std" 				=> $default_values['enableSecondaryHeader'],
		"additional_fun" 	=> "hide",
		"hide_class" 		=> "secondary_header" );

	$options['mpcth_header_secondary_layout'] = array(
		"id" 		=> "mpcth_header_secondary_layout",
		"name" 		=> __("Secondary Header Layout", 'mpcth'),
		"desc" 		=> __("Choose one of secondary header layouts.", 'mpcth'),
		"class" 	=> "secondary_header",
		"type" 		=> "select",
		"std" 		=> $default_values['headerSecondaryLayout'],
		"options" 	=> $header_secondary_layouts );

	$options['mpcth_header_secondary_position'] = array(
		"id" 		=> "mpcth_header_secondary_position",
		"name" 		=> __("Secondary Header Position", 'mpcth'),
		"desc" 		=> __("Choose secondary header position.", 'mpcth'),
		"class" 	=> "secondary_header",
		"type" 		=> "select",
		"std" 		=> $default_values['headerSecondaryPosition'],
		"options" 	=> $header_secondary_positions );

	$options['mpcth_header_secondary_enable_subscribe'] = array(
		"id" 				=> "mpcth_header_secondary_enable_subscribe",
		"name" 				=> __("Enable Subscribe Form", 'mpcth'),
		"desc" 				=> __("Uncheck this option to disable subscribe form.", 'mpcth'),
		"class" 			=> "secondary_header",
		"type" 				=> "checkbox",
		"std" 				=> 1,
		"additional_fun" 	=> "hide",
		"hide_class" 		=> "subscribe_form" );

	$options['mpcth_newsletter_text'] = array(
		"id" 		=> "mpcth_newsletter_text",
		"name" 		=> __("Newsletter Text", 'mpcth'),
		"desc" 		=> __("Specify your newsletter message.", 'mpcth'),
		"class" 	=> "subscribe_form secondary_header",
		"type" 		=> "text",
		"std" 		=> $default_values['newsletterText']);

	$options['mpcth_header_secondary_message'] = array(
		"id" 	=> "mpcth_header_secondary_message",
		"name" 	=> __("Secondary Header Message", 'mpcth'),
		"desc" 	=> __("Specify the message you want to display in place of subscribe form. Leave empty to display default subscribe form.", 'mpcth'),
		"class" => "subscribe_form secondary_header",
		"type" 	=> "text",
		"std" 	=> '' );

	$options['mpcth_header_secondary_enable_menu'] = array(
		"id" 		=> "mpcth_header_secondary_enable_menu",
		"name" 		=> __("Enable Secondary Header Menu", 'mpcth'),
		"desc" 		=> __("Check this option to enable secondary header menu.", 'mpcth'),
		"class" 	=> "secondary_header",
		"type" 		=> "checkbox",
		"std" 		=> 0 );

/* ---------------------------------------------------------------- */
/* Footer
/* ---------------------------------------------------------------- */
	$options[] = array(
		"name" 	=> __("Footer", 'mpcth'),
		"type" 	=> "accordion");

	$options['mpcth_enable_footer'] = array(
		"id" 				=> "mpcth_enable_footer",
		"name" 				=> __("Enable Footer", 'mpcth'),
		"desc" 				=> __("Uncheck this option to disable footer.", 'mpcth'),
		"type" 				=> "checkbox",
		"std" 				=> $default_values['enableFooter'],
		"additional_fun" 	=> "hide",
		"hide_class" 		=> "footer_settings" );

	$options['mpcth_footer_columns'] = array(
		"id" 		=> "mpcth_footer_columns",
		"name" 		=> __("Footer Columns Number", 'mpcth'),
		"desc" 		=> __("Specify default number of footer columns.", 'mpcth'),
		"class" 	=> "footer_settings",
		"type" 		=> "select",
		"std" 		=> $default_values['footerColNum'],
		"options" 	=> $footer_columns );

	$options['mpcth_enable_toggle_footer'] = array(
		"id" 		=> "mpcth_enable_toggle_footer",
		"name" 		=> __("Enable Toggle Footer", 'mpcth'),
		"desc" 		=> __("Uncheck this option to disable mobile toggle footer button.", 'mpcth'),
		"class" 	=> "footer_settings",
		"type" 		=> "checkbox",
		"std" 		=> $default_values['enableToggleFooter'] );

	$options['mpcth_back_to_top_position'] = array(
		"id" 		=> "mpcth_back_to_top_position",
		"name" 		=> __("Back To Top Position", 'mpcth'),
		"desc" 		=> __("Specify the position of \"Back to Top\" button.", 'mpcth'),
		"type" 		=> "select",
		"std" 		=> 'none',
		"options" 	=> $back_to_top_position );

/* ---------------------------------------------------------------- */
/* Footer Extended
/* ---------------------------------------------------------------- */
	$options[] = array(
		"name" 	=> __("Extended Footer", 'mpcth'),
		"type" 	=> "accordion");

	$options['mpcth_enable_footer_extended'] = array(
		"id" 				=> "mpcth_enable_footer_extended",
		"name" 				=> __("Enable Extended Footer", 'mpcth'),
		"desc" 				=> __("Uncheck this option to disable extended footer.", 'mpcth'),
		"type" 				=> "checkbox",
		"std" 				=> $default_values['enableFooterExtended'],
		"additional_fun" 	=> "hide",
		"hide_class" 		=> "footer_settings_extended" );

	$options['mpcth_footer_extended_columns'] = array(
		"id" 		=> "mpcth_footer_extended_columns",
		"name" 		=> __("Extended Footer Columns Number", 'mpcth'),
		"desc" 		=> __("Specify default number of extended footer columns.", 'mpcth'),
		"class" 	=> "footer_settings_extended",
		"type" 		=> "select",
		"std" 		=> $default_values['footerExtendedColNum'],
		"options" 	=> $footer_columns );

	$options['mpcth_enable_toggle_footer_extended'] = array(
		"id" 		=> "mpcth_enable_toggle_footer_extended",
		"name" 		=> __("Enable Toggle Extended Footer", 'mpcth'),
		"desc" 		=> __("Uncheck this option to disable mobile toggle extended footer button.", 'mpcth'),
		"class" 	=> "footer_settings_extended",
		"type" 		=> "checkbox",
		"std" 		=> $default_values['enableToggleFooterExtended'] );

/* ---------------------------------------------------------------- */
/* Copyrights & Socials
/* ---------------------------------------------------------------- */
	$options[] = array(
		"name" 	=> __("Copyrights", 'mpcth'),
		"type" 	=> "accordion");

	$options['mpcth_enable_copyrights'] = array(
		"id" 				=> "mpcth_enable_copyrights",
		"name" 				=> __("Enable Copyrights & Socials", 'mpcth'),
		"desc" 				=> __("Uncheck this option to disable copyrights/socials section below the footer.", 'mpcth'),
		"type" 				=> "checkbox",
		"std" 				=> $default_values['enableCopyrights'],
		"additional_fun" 	=> "hide",
		"hide_class" 		=> "mpcth_copyright_text" );

	$options['mpcth_copyright_text'] = array(
		"id" 		=> "mpcth_copyright_text",
		"name" 		=> __("Copyright Text", 'mpcth'),
		"desc" 		=> __("Specify your copyrights.", 'mpcth'),
		"class" 	=> "mpcth_copyright_text",
		"type" 		=> "text-big",
		"std" 		=> $default_values['copyrightText']);

/* ---------------------------------------------------------------- */
/* Social
/* ---------------------------------------------------------------- */
	$options[] = array(
		"name" => __("Social Networks", 'mpcth'),
		"type" => "accordion");

	$options['mpcth_socials'] = array(
		"id" 		=> "mpcth_socials",
		"name" 		=> __("Socials", 'mpcth'),
		"desc" 		=> __("Select the socials you want to display.", 'mpcth'),
		"type"		=> "multicheck",
		"options" 	=> $socials,
		"std" 		=> "" );

	foreach ($socials as $key => $value) {
		$options['mpcth_social_' . $key] = array(
			"id" 	=> "mpcth_social_" . $key,
			"name" 	=> $key,
			"desc" 	=> __("Specify the URL to your account.", 'mpcth'),
			"type" 	=> "text",
			"std" 	=> "" );
	}

/* ---------------------------------------------------------------- */
/* Visuals
/* ---------------------------------------------------------------- */
	$options[] = array(
		"name" => __("Visuals", 'mpcth'),
		"icon" => "fa fa-fw fa-eye",
		"type" => "heading" );

/* ---------------------------------------------------------------- */
/* Colors
/* ---------------------------------------------------------------- */
	$options[] = array(
		"name" 					=> __("Colors", 'mpcth'),
		"type" 					=> "accordion",
		"visual_panel" 			=> "true",
		"visual_panel_title" 	=> __("Colors", 'mpcth'));

	$options['mpcth_color_main'] = array(
		"id" 	=> "mpcth_color_main",
		"name" 	=> __("Main Color", 'mpcth'),
		"desc" 	=> __("Specify main color for the theme.", 'mpcth'),
		"class" => "mpcth_color_main",
		"type" 	=> "color",
		"std" 	=> $default_values['mainColor'] );

/* ---------------------------------------------------------------- */
/* Display
/* ---------------------------------------------------------------- */
	$options[] = array(
		"name" => __("Display", 'mpcth'),
		"type" => "accordion");

	$options['mpcth_disable_responsive'] = array(
		"id" 	=> "mpcth_disable_responsive",
		"name" 	=> __("Disable Responsive", 'mpcth'),
		"desc" 	=> __("Check this option if you want to disable responsive layout.", 'mpcth'),
		"type" 	=> "checkbox",
		"std" 	=> 0 );

	$options['mpcth_enable_large_archive_thumbs'] = array(
		"id" 	=> "mpcth_enable_large_archive_thumbs",
		"name" 	=> __("Large Archive Thumbnails", 'mpcth'),
		"desc" 	=> __("Check this option if you want to display archive thumbnails in fullwidth.", 'mpcth'),
		"type" 	=> "checkbox",
		"std" 	=> 0 );

	$options['mpcth_boxed_type'] = array(
		"id" 		=> "mpcth_boxed_type",
		"name" 		=> __("Theme Layout Type", 'mpcth'),
		"desc" 		=> __("Specify if you want to display the page as boxed, floating boxed or fullwidth site.", 'mpcth'),
		"type" 		=> "select",
		"std" 		=> $default_values['boxedType'],
		"options" 	=> $boxed_layouts );

	$options['mpcth_theme_skin'] = array(
		"id" 		=> "mpcth_theme_skin",
		"name" 		=> __("Skin", 'mpcth'),
		"desc" 		=> __("Select theme skin.", 'mpcth'),
		"class" 	=> "mpcth_theme_skin",
		"type" 		=> "select",
		"std" 		=> $default_values['themeSkin'],
		"options" 	=> $skins_options );

	$options['mpcth_disable_mobile_slider_nav'] = array(
		"id" 	=> "mpcth_disable_mobile_slider_nav",
		"name" 	=> __("Disable Mobile Sliders Navigation", 'mpcth'),
		"desc" 	=> __("Uncheck this option if you want to display sliders navigation on mobile devices.", 'mpcth'),
		"type" 	=> "checkbox",
		"std" 	=> 0 );

/* ---------------------------------------------------------------- */
/* Background
/* ---------------------------------------------------------------- */
	$options[] = array(
		"name" => __("Background", 'mpcth'),
		"type" => "accordion");

	$options['mpcth_background_type'] = array(
		"id" 				=> "mpcth_background_type",
		"name" 				=> __("Type", 'mpcth'),
		"desc" 				=> __("Select background type for your site.", 'mpcth'),
		"class" 			=> "mpcth_background_type",
		"type" 				=> "select",
		"std" 				=> "none",
		"options" 			=> $background_options,
		"additional_fun" 	=> "hide",
		"options_class" 	=> array('mpcth_none_opt', 'mpcth_color_opt', 'mpcth_image_opt', 'mpcth_pattern_opt') );

	$options['mpcth_bg_color'] = array(
		"id" 	=> "mpcth_bg_color",
		"name" 	=> __("Background Color", 'mpcth'),
		"desc" 	=> __("Specify background color.", 'mpcth'),
		"class" => "mpcth_color_opt",
		"type" 	=> "color",
		"std" 	=> $default_values['bgColor'] );

	$options['mpcth_bg_image'] = array(
		"id" 	=> "mpcth_bg_image",
		"name" 	=> __("Background Image", 'mpcth'),
		"desc" 	=> __("Upload your background image here.", 'mpcth'),
		"class" => "mpcth_image_opt",
		"type" 	=> "upload" );

	$options['mpcth_enable_bg_image_repeat'] = array(
		"id" 	=> "mpcth_enable_bg_image_repeat",
		"name" 	=> __("Repeat Background", 'mpcth'),
		"desc" 	=> __("Check this option if you want to use your custom background as pattern.", 'mpcth'),
		"class" => "mpcth_image_opt",
		"type" 	=> "checkbox",
		"std" 	=> "1" );

	$options['mpcth_bg_pattern'] = array(
		"id" 		=> "mpcth_bg_pattern",
		"name" 		=> __("Background Pattern", 'mpcth'),
		"desc" 		=> __("Choose background pattern for your site.", 'mpcth'),
		"class" 	=> "mpcth_pattern_opt",
		"type" 		=> "images",
		"std" 		=> "pattern01",
		"options" 	=> $background_patterns );

/* ---------------------------------------------------------------- */
/* Menu Backgrounds
/* ---------------------------------------------------------------- */
	$menu_id = get_nav_menu_locations();
	if(isset($menu_id['mpcth_menu'])) {
		$menu_items = wp_get_nav_menu_items($menu_id['mpcth_menu']);

		if ($menu_items) {
			$options[] = array(
				"name" => __("Dropdowns Backgrounds", 'mpcth'),
				"type" => "accordion");

			foreach ($menu_items as $item) {
				if ($item->menu_item_parent === '0') {
					$options['mpcth_menu_bg_image_' . $item->object_id] = array(
						"id" 	=> "mpcth_menu_bg_image_" . $item->object_id,
						"name" 	=> "\"" . $item->title . "\" " . __("Background Image", 'mpcth'),
						"desc" 	=> __("Upload your dropdown background image here.", 'mpcth'),
						"class" => "mpcth_image_opt",
						"type" 	=> "upload" );

					$options['mpcth_menu_bg_padding_' . $item->object_id] = array(
						"id" 	=> "mpcth_menu_bg_padding_" . $item->object_id,
						"name" 	=> "\"" . $item->title . "\" " . __("Paddings", 'mpcth'),
						"desc" 	=> __('Specify your dropdown padding.', 'mpcth'),
						"type" 	=> "text",
						"std" 	=> "" );

					$options['mpcth_menu_bg_align_' . $item->object_id] = array(
						"id" 		=> "mpcth_menu_bg_align_" . $item->object_id,
						"name" 		=> "\"" . $item->title . "\" " . __("Alignment", 'mpcth'),
						"desc" 		=> __("Select background type for your site.", 'mpcth'),
						"type" 		=> "select",
						"std" 		=> "bottom center",
						"options" 	=> $dropdown_image_alignment );
				}
			}
		}
	}

/* ---------------------------------------------------------------- */
/* WooCommerce
/* ---------------------------------------------------------------- */
	$options[] = array(
		"name" => __("WooCommerce", 'mpcth'),
		"type" => "accordion");

	$options['mpcth_products_number'] = array(
		"id" 	=> "mpcth_products_number",
		"name" 	=> __("Products Number", 'mpcth'),
		"desc" 	=> __("Specify the products number you want to display in the \"Shop\" page.", 'mpcth'),
		"type" 	=> "text",
		"std" 	=> 9 );

	$options['mpcth_enable_masonry_shop'] = array(
		"id" 				=> "mpcth_enable_masonry_shop",
		"name" 				=> __("Masonry Shop", 'mpcth'),
		"desc" 				=> __("Check this option if you want to enable masonry on \"Shop\" page.", 'mpcth'),
		"type" 				=> "checkbox",
		"std" 				=> "0",
		"additional_fun" 	=> "hide",
		"hide_class" 		=> "mpcth_masonry_options" );

	$options['mpcth_enable_shop_load_more'] = array(
		"id" 	=> "mpcth_enable_shop_load_more",
		"name" 	=> __("Shop Load More", 'mpcth'),
		"desc" 	=> __("Check this option if you want to enable load more on \"Shop\" page.", 'mpcth'),
		"class" => "mpcth_masonry_options",
		"type" 	=> "checkbox",
		"std" 	=> "0" );

	// $options['mpcth_enable_shop_dynamic_height'] = array(
	// 	"id" 	=> "mpcth_enable_shop_dynamic_height",
	// 	"name" 	=> __("Shop Dynamic Height", 'mpcth'),
	// 	"desc" 	=> __("Check this option if you want to enable dynamic products height on \"Shop\" page.", 'mpcth'),
	// 	"class" => "mpcth_masonry_options",
	// 	"type" 	=> "checkbox",
	// 	"std" 	=> "0" );

	$options['mpcth_shop_style'] = array(
		"id" 				=> "mpcth_shop_style",
		"name" 				=> __("Shop Style", 'mpcth'),
		"desc" 				=> __("Choose one of shop styles.", 'mpcth'),
		"type" 				=> "select",
		"std" 				=> 'default',
		"options" 			=> $shop_styles,
		"additional_fun" 	=> "swap",
		"options_class" 	=> array('shop_columns_def', 'shop_columns_ext', 'shop_columns_ext') );

	$options['mpcth_shop_columns_def'] = array(
		"id" 		=> "mpcth_shop_columns_def",
		"name" 		=> __("Shop Columns Number (Default style)", 'mpcth'),
		"desc" 		=> __("Specify default number of shop columns for default style.", 'mpcth'),
		"class" 	=> "shop_columns_def",
		"type" 		=> "select",
		"std" 		=> $default_values['shopColNum'],
		"options" 	=> $shop_columns_def );

	$options['mpcth_shop_columns_ext'] = array(
		"id" 		=> "mpcth_shop_columns_ext",
		"name" 		=> __("Shop Columns Number (Other styles)", 'mpcth'),
		"desc" 		=> __("Specify default number of shop columns for other styles.", 'mpcth'),
		"class" 	=> "shop_columns_ext",
		"type" 		=> "select",
		"std" 		=> $default_values['shopColNum'],
		"options" 	=> $shop_columns_ext );

	$options['mpcth_products_slider_style'] = array(
		"id" 		=> "mpcth_products_slider_style",
		"name" 		=> __("Products Slider Style", 'mpcth'),
		"desc" 		=> __("Choose one of products slider styles.", 'mpcth'),
		"type" 		=> "select",
		"std" 		=> 'default',
		"options" 	=> $shop_styles );

	$options['mpcth_product_accordions'] = array(
		"id" 		=> "mpcth_product_accordions",
		"name" 		=> __("Product Accordions", 'mpcth'),
		"desc" 		=> __("Check this option if you want to change tabs to accordions for products descriptions.", 'mpcth'),
		"type" 		=> "checkbox",
		"std" 		=> "0" );

	$options['mpcth_enable_size_guide'] = array(
		"id" 				=> "mpcth_enable_size_guide",
		"name" 				=> __("Size Guide", 'mpcth'),
		"desc" 				=> __("Check this option if you want to enable size guide for products.", 'mpcth'),
		"type" 				=> "checkbox",
		"std" 				=> "0",
		"additional_fun" 	=> "hide",
		"hide_class" 		=> "mpcth_size_quide" );

	$options['mpcth_size_quide'] = array(
		"id" 		=> "mpcth_size_quide",
		"name" 		=> __("Size Guide Image", 'mpcth'),
		"desc" 		=> __("Upload your size guide image here.", 'mpcth'),
		"class" 	=> "mpcth_size_quide",
		"type" 		=> "upload" );

	$options['mpcth_disable_header_cart'] = array(
		"id" 		=> "mpcth_disable_header_cart",
		"name" 		=> __("Disable Header Cart", 'mpcth'),
		"desc" 		=> __("Check this option if you want to disable the cart icon in the header.", 'mpcth'),
		"type" 		=> "checkbox",
		"std" 		=> "0" );

	$options['mpcth_disable_product_cart'] = array(
		"id" 				=> "mpcth_disable_product_cart",
		"name" 				=> __("Disable Products \"Add to Cart\"", 'mpcth'),
		"desc" 				=> __("Check this option if you want to disable \"Add to Cart\" in the products.", 'mpcth'),
		"type" 				=> "checkbox",
		"std" 				=> "0",
		"additional_fun" 	=> "hide",
		"hide_class" 		=> "mpcth_disable_product_price" );

	$options['mpcth_disable_product_price'] = array(
		"id" 		=> "mpcth_disable_product_price",
		"name" 		=> __("Disable Products \"Price\"", 'mpcth'),
		"desc" 		=> __("Check this option if you want to disable \"Price\" in the products.", 'mpcth'),
		"class" 	=> "mpcth_disable_product_price",
		"type" 		=> "checkbox",
		"std" 		=> "0" );

	$options['mpcth_disable_product_hover'] = array(
		"id" 		=> "mpcth_disable_product_hover",
		"name" 		=> __("Disable Products Hover Effect", 'mpcth'),
		"desc" 		=> __("Check this option if you want to disable the hover effect for the products.", 'mpcth'),
		"type" 		=> "checkbox",
		"std" 		=> "0" );

	$options['mpcth_tab_description_label'] = array(
		"id" 	=> "mpcth_tab_description_label",
		"name" 	=> __("\"Description\" Tab Label", 'mpcth'),
		"desc" 	=> __('Specify your custom label for product "Description" label.', 'mpcth'),
		"type" 	=> "text",
		"std" 	=> "" );

	$options['mpcth_tab_additional_information_label'] = array(
		"id" 	=> "mpcth_tab_additional_information_label",
		"name" 	=> __("\"Additional Information\" Tab Label", 'mpcth'),
		"desc" 	=> __('Specify your custom label for product "Additional Information" label.', 'mpcth'),
		"type" 	=> "text",
		"std" 	=> "" );

/* ---------------------------------------------------------------- */
/* Custom CSS
/* ---------------------------------------------------------------- */
	$options[] = array(
		"name" => __("Custom CSS", 'mpcth'),
		"type" => "accordion");

	$options['mpcth_custom_css'] = array(
		"id" 		=> "mpcth_custom_css",
		"name" 		=> __("CSS", 'mpcth'),
		"desc" 		=> __('Insert your custom CSS.', 'mpcth'),
		"type" 		=> "textarea-big",
		"std" 		=> "", );

	$options['mpcth_overwrite_shortcodes_colors'] = array(
		"id" 		=> "mpcth_overwrite_shortcodes_colors",
		"name" 		=> __("Overwrite Shortcodes Colors", 'mpcth'),
		"desc" 		=> __("Check this option if you want to overwrite shortcodes colors with the Main Color.", 'mpcth'),
		"type" 		=> "checkbox",
		"std" 		=> "0" );

/* ---------------------------------------------------------------- */
/* Styles
/* ---------------------------------------------------------------- */
	$options[] = array(
		"name" => __("Styles", 'mpcth'),
		"icon" => "fa fa-fw fa-magic",
		"type" => "heading" );

/* ---------------------------------------------------------------- */
/* Options
/* ---------------------------------------------------------------- */
	$options[] = array(
		"name" => __("Options", 'mpcth'),
		"type" => "accordion");

	$options['mpcth_use_advance_colors'] = array(
		"id" 	=> "mpcth_use_advance_colors",
		"name" 	=> __("Use Advance Colors", 'mpcth'),
		"desc" 	=> __("Check this option if you want to use the below colors.", 'mpcth'),
		"type" 	=> "checkbox",
		"std" 	=> 0 );

	$options['mpcth_use_advance_font_sizes'] = array(
		"id" 	=> "mpcth_use_advance_font_sizes",
		"name" 	=> __("Use Advance Font Sizes", 'mpcth'),
		"desc" 	=> __("Check this option if you want to use the below font sizes.", 'mpcth'),
		"type" 	=> "checkbox",
		"std" 	=> 0 );

/* ---------------------------------------------------------------- */
/* Header
/* ---------------------------------------------------------------- */
	$options[] = array(
		"name" => __("Header", 'mpcth'),
		"type" => "accordion");

	/* Colors */
	$options['mpcth_colors_header_background'] = array(
		"id" 	=> "mpcth_colors_header_background",
		"name" 	=> __("Header Background", 'mpcth'),
		"desc" 	=> __("Specify header background color.", 'mpcth'),
		"type" 	=> "color",
		"std" 	=> $default_values['advanceColors']['headerBackground'] );

	$options['mpcth_colors_header_border'] = array(
		"id" 	=> "mpcth_colors_header_border",
		"name" 	=> __("Header Border", 'mpcth'),
		"desc" 	=> __("Specify header border color.", 'mpcth'),
		"type" 	=> "color",
		"std" 	=> $default_values['advanceColors']['headerBorder'] );

	$options['mpcth_colors_header_font'] = array(
		"id" 	=> "mpcth_colors_header_font",
		"name" 	=> __("Header Font", 'mpcth'),
		"desc" 	=> __("Specify header font color.", 'mpcth'),
		"type" 	=> "color",
		"std" 	=> $default_values['advanceColors']['headerFont'] );

	$options['mpcth_colors_header_active'] = array(
		"id" 	=> "mpcth_colors_header_active",
		"name" 	=> __("Header Active/Hover", 'mpcth'),
		"desc" 	=> __("Specify header active/hover color.", 'mpcth'),
		"type" 	=> "color",
		"std" 	=> $default_values['advanceColors']['headerActive'] );

	/* Sizes */
	$options['mpcth_font_sizes_header_menu'] = array(
		"id" 	=> "mpcth_font_sizes_header_menu",
		"name" 	=> __("Header Menu", 'mpcth'),
		"desc" 	=> __("Specify header menu font size.", 'mpcth'),
		"type" 	=> "slider",
		"std" 	=> $default_values['advanceFontSizes']['headerMenu'],
	 	"min" 	=> "8",
	 	"max" 	=> "64" );

	$options['mpcth_font_sizes_header_button'] = array(
		"id" 	=> "mpcth_font_sizes_header_button",
		"name" 	=> __("Header Button", 'mpcth'),
		"desc" 	=> __("Specify header button font size.", 'mpcth'),
		"type" 	=> "slider",
		"std" 	=> $default_values['advanceFontSizes']['headerButton'],
	 	"min" 	=> "8",
	 	"max" 	=> "64" );

/* ---------------------------------------------------------------- */
/* Secondary Header
/* ---------------------------------------------------------------- */
	$options[] = array(
		"name" => __("Secondary Header", 'mpcth'),
		"type" => "accordion");

	/* Colors */
	$options['mpcth_colors_header_second_background'] = array(
		"id" 	=> "mpcth_colors_header_second_background",
		"name" 	=> __("Secondary Header Background", 'mpcth'),
		"desc" 	=> __("Specify secondary header background color.", 'mpcth'),
		"type" 	=> "color",
		"std" 	=> $default_values['advanceColors']['headerSecondBackground'] );

	$options['mpcth_colors_header_second_border'] = array(
		"id" 	=> "mpcth_colors_header_second_border",
		"name" 	=> __("Secondary Header Border", 'mpcth'),
		"desc" 	=> __("Specify secondary header border color.", 'mpcth'),
		"type" 	=> "color",
		"std" 	=> $default_values['advanceColors']['headerSecondBorder'] );

	$options['mpcth_colors_header_second_font'] = array(
		"id" 	=> "mpcth_colors_header_second_font",
		"name" 	=> __("Secondary Header Font", 'mpcth'),
		"desc" 	=> __("Specify secondary header font color.", 'mpcth'),
		"type" 	=> "color",
		"std" 	=> $default_values['advanceColors']['headerSecondFont'] );

	$options['mpcth_colors_header_second_active'] = array(
		"id" 	=> "mpcth_colors_header_second_active",
		"name" 	=> __("Secondary Header Active/Hover", 'mpcth'),
		"desc" 	=> __("Specify secondary header active/hover color.", 'mpcth'),
		"type" 	=> "color",
		"std" 	=> $default_values['advanceColors']['headerSecondActive'] );

	/* Sizes */
	$options['mpcth_font_sizes_header_second'] = array(
		"id" 	=> "mpcth_font_sizes_header_second",
		"name" 	=> __("Secondary Header", 'mpcth'),
		"desc" 	=> __("Specify secondary header font size.", 'mpcth'),
		"type" 	=> "slider",
		"std" 	=> $default_values['advanceFontSizes']['headerSecond'],
	 	"min" 	=> "8",
	 	"max" 	=> "64" );

/* ---------------------------------------------------------------- */
/* Dropdowns
/* ---------------------------------------------------------------- */
	$options[] = array(
		"name" => __("Dropdowns", 'mpcth'),
		"type" => "accordion");

	/* Colors */
	$options['mpcth_colors_dropdown_background'] = array(
		"id" 	=> "mpcth_colors_dropdown_background",
		"name" 	=> __("Dropdown Background", 'mpcth'),
		"desc" 	=> __("Specify dropdown background color.", 'mpcth'),
		"type" 	=> "color",
		"std" 	=> $default_values['advanceColors']['dropdownBackground'] );

	$options['mpcth_colors_dropdown_border'] = array(
		"id" 	=> "mpcth_colors_dropdown_border",
		"name" 	=> __("Dropdown Border", 'mpcth'),
		"desc" 	=> __("Specify dropdown border color.", 'mpcth'),
		"type" 	=> "color",
		"std" 	=> $default_values['advanceColors']['dropdownBorder'] );

	$options['mpcth_colors_dropdown_font'] = array(
		"id" 	=> "mpcth_colors_dropdown_font",
		"name" 	=> __("Dropdown Font", 'mpcth'),
		"desc" 	=> __("Specify dropdown font color.", 'mpcth'),
		"type" 	=> "color",
		"std" 	=> $default_values['advanceColors']['dropdownFont'] );

	$options['mpcth_colors_dropdown_active'] = array(
		"id" 	=> "mpcth_colors_dropdown_active",
		"name" 	=> __("Dropdown Active/Hover", 'mpcth'),
		"desc" 	=> __("Specify dropdown active/hover color.", 'mpcth'),
		"type" 	=> "color",
		"std" 	=> $default_values['advanceColors']['dropdownActive'] );

	/* Sizes */
	$options['mpcth_font_sizes_header_dropdown'] = array(
		"id" 	=> "mpcth_font_sizes_header_dropdown",
		"name" 	=> __("Header Dropdown", 'mpcth'),
		"desc" 	=> __("Specify header dropdown font size.", 'mpcth'),
		"type" 	=> "slider",
		"std" 	=> $default_values['advanceFontSizes']['headerDropdown'],
	 	"min" 	=> "8",
	 	"max" 	=> "64" );

	$options['mpcth_font_sizes_header_second_dropdown'] = array(
		"id" 	=> "mpcth_font_sizes_header_second_dropdown",
		"name" 	=> __("Secondary Header Dropdown", 'mpcth'),
		"desc" 	=> __("Specify secondary header dropdown font size.", 'mpcth'),
		"type" 	=> "slider",
		"std" 	=> $default_values['advanceFontSizes']['headerSecondDropdown'],
	 	"min" 	=> "8",
	 	"max" 	=> "64" );

/* ---------------------------------------------------------------- */
/* Search
/* ---------------------------------------------------------------- */
	$options[] = array(
		"name" => __("Search", 'mpcth'),
		"type" => "accordion");

	/* Colors */
	$options['mpcth_colors_search_background'] = array(
		"id" 	=> "mpcth_colors_search_background",
		"name" 	=> __("Search Background", 'mpcth'),
		"desc" 	=> __("Specify search background color.", 'mpcth'),
		"type" 	=> "color",
		"std" 	=> $default_values['advanceColors']['searchBackground'] );

	$options['mpcth_colors_search_border'] = array(
		"id" 	=> "mpcth_colors_search_border",
		"name" 	=> __("Search Border", 'mpcth'),
		"desc" 	=> __("Specify search border color.", 'mpcth'),
		"type" 	=> "color",
		"std" 	=> $default_values['advanceColors']['searchBorder'] );

	$options['mpcth_colors_search_font'] = array(
		"id" 	=> "mpcth_colors_search_font",
		"name" 	=> __("Search Font", 'mpcth'),
		"desc" 	=> __("Specify search font color.", 'mpcth'),
		"type" 	=> "color",
		"std" 	=> $default_values['advanceColors']['searchFont'] );

	$options['mpcth_colors_search_active'] = array(
		"id" 	=> "mpcth_colors_search_active",
		"name" 	=> __("Search Active/Hover", 'mpcth'),
		"desc" 	=> __("Specify search active/hover color.", 'mpcth'),
		"type" 	=> "color",
		"std" 	=> $default_values['advanceColors']['searchActive'] );

	/* Sizes */
	$options['mpcth_font_sizes_header_search'] = array(
		"id" 	=> "mpcth_font_sizes_header_search",
		"name" 	=> __("Search", 'mpcth'),
		"desc" 	=> __("Specify search font size.", 'mpcth'),
		"type" 	=> "slider",
		"std" 	=> $default_values['advanceFontSizes']['headerSearch'],
	 	"min" 	=> "8",
	 	"max" 	=> "64" );

/* ---------------------------------------------------------------- */
/* Sidebar
/* ---------------------------------------------------------------- */
	$options[] = array(
		"name" => __("Sidebar", 'mpcth'),
		"type" => "accordion");

	/* Colors */
	$options['mpcth_colors_sidebar_background'] = array(
		"id" 	=> "mpcth_colors_sidebar_background",
		"name" 	=> __("Sidebar Background", 'mpcth'),
		"desc" 	=> __("Specify sidebar background color.", 'mpcth'),
		"type" 	=> "color",
		"std" 	=> $default_values['advanceColors']['sidebarBackground'] );

	$options['mpcth_colors_sidebar_border'] = array(
		"id" 	=> "mpcth_colors_sidebar_border",
		"name" 	=> __("Sidebar Border", 'mpcth'),
		"desc" 	=> __("Specify sidebar border color.", 'mpcth'),
		"type" 	=> "color",
		"std" 	=> $default_values['advanceColors']['sidebarBorder'] );

	$options['mpcth_colors_sidebar_font'] = array(
		"id" 	=> "mpcth_colors_sidebar_font",
		"name" 	=> __("Sidebar Font", 'mpcth'),
		"desc" 	=> __("Specify sidebar font color.", 'mpcth'),
		"type" 	=> "color",
		"std" 	=> $default_values['advanceColors']['sidebarFont'] );

	$options['mpcth_colors_sidebar_active'] = array(
		"id" 	=> "mpcth_colors_sidebar_active",
		"name" 	=> __("Sidebar Active/Hover", 'mpcth'),
		"desc" 	=> __("Specify sidebar active/hover color.", 'mpcth'),
		"type" 	=> "color",
		"std" 	=> $default_values['advanceColors']['sidebarActive'] );

	/* Sizes */
	$options['mpcth_font_sizes_sidebar_header'] = array(
		"id" 	=> "mpcth_font_sizes_sidebar_header",
		"name" 	=> __("Sidebar Header", 'mpcth'),
		"desc" 	=> __("Specify sidebar header font size.", 'mpcth'),
		"type" 	=> "slider",
		"std" 	=> $default_values['advanceFontSizes']['sidebarHeader'],
	 	"min" 	=> "8",
	 	"max" 	=> "64" );

	$options['mpcth_font_sizes_sidebar_content'] = array(
		"id" 	=> "mpcth_font_sizes_sidebar_content",
		"name" 	=> __("Sidebar Content", 'mpcth'),
		"desc" 	=> __("Specify sidebar content font size.", 'mpcth'),
		"type" 	=> "slider",
		"std" 	=> $default_values['advanceFontSizes']['sidebarContent'],
	 	"min" 	=> "8",
	 	"max" 	=> "64" );

	$options['mpcth_font_sizes_sidebar_small'] = array(
		"id" 	=> "mpcth_font_sizes_sidebar_small",
		"name" 	=> __("Sidebar Small", 'mpcth'),
		"desc" 	=> __("Specify sidebar small font size.", 'mpcth'),
		"type" 	=> "slider",
		"std" 	=> $default_values['advanceFontSizes']['sidebarSmall'],
	 	"min" 	=> "8",
	 	"max" 	=> "64" );

/* ---------------------------------------------------------------- */
/* Content
/* ---------------------------------------------------------------- */
	$options[] = array(
		"name" => __("Content", 'mpcth'),
		"type" => "accordion");

	/* Colors */
	$options['mpcth_colors_content_background'] = array(
		"id" 	=> "mpcth_colors_content_background",
		"name" 	=> __("Content Background", 'mpcth'),
		"desc" 	=> __("Specify content background color.", 'mpcth'),
		"type" 	=> "color",
		"std" 	=> $default_values['advanceColors']['contentBackground'] );

	$options['mpcth_colors_content_border'] = array(
		"id" 	=> "mpcth_colors_content_border",
		"name" 	=> __("Content Border", 'mpcth'),
		"desc" 	=> __("Specify content border color.", 'mpcth'),
		"type" 	=> "color",
		"std" 	=> $default_values['advanceColors']['contentBorder'] );

	$options['mpcth_colors_content_font'] = array(
		"id" 	=> "mpcth_colors_content_font",
		"name" 	=> __("Content Font", 'mpcth'),
		"desc" 	=> __("Specify content font color.", 'mpcth'),
		"type" 	=> "color",
		"std" 	=> $default_values['advanceColors']['contentFont'] );

	/* Sizes */
	$options['mpcth_font_sizes_content_header'] = array(
		"id" 	=> "mpcth_font_sizes_content_header",
		"name" 	=> __("Content Header", 'mpcth'),
		"desc" 	=> __("Specify content header font size.", 'mpcth'),
		"type" 	=> "slider",
		"std" 	=> $default_values['advanceFontSizes']['contentHeader'],
	 	"min" 	=> "8",
	 	"max" 	=> "64" );

	$options['mpcth_font_sizes_content_content'] = array(
		"id" 	=> "mpcth_font_sizes_content_content",
		"name" 	=> __("Content Content", 'mpcth'),
		"desc" 	=> __("Specify content content font size.", 'mpcth'),
		"type" 	=> "slider",
		"std" 	=> $default_values['advanceFontSizes']['contentContent'],
	 	"min" 	=> "8",
	 	"max" 	=> "64" );

	$options['mpcth_font_sizes_content_small'] = array(
		"id" 	=> "mpcth_font_sizes_content_small",
		"name" 	=> __("Content Small", 'mpcth'),
		"desc" 	=> __("Specify content small font size.", 'mpcth'),
		"type" 	=> "slider",
		"std" 	=> $default_values['advanceFontSizes']['contentSmall'],
	 	"min" 	=> "8",
	 	"max" 	=> "64" );

/* ---------------------------------------------------------------- */
/* Footer
/* ---------------------------------------------------------------- */
	$options[] = array(
		"name" => __("Footer", 'mpcth'),
		"type" => "accordion");

	/* Colors */
	$options['mpcth_colors_footer_background'] = array(
		"id" 	=> "mpcth_colors_footer_background",
		"name" 	=> __("Footer Background", 'mpcth'),
		"desc" 	=> __("Specify footer background color.", 'mpcth'),
		"type" 	=> "color",
		"std" 	=> $default_values['advanceColors']['footerBackground'] );

	$options['mpcth_colors_footer_border'] = array(
		"id" 	=> "mpcth_colors_footer_border",
		"name" 	=> __("Footer Border", 'mpcth'),
		"desc" 	=> __("Specify footer border color.", 'mpcth'),
		"type" 	=> "color",
		"std" 	=> $default_values['advanceColors']['footerBorder'] );

	$options['mpcth_colors_footer_font'] = array(
		"id" 	=> "mpcth_colors_footer_font",
		"name" 	=> __("Footer Font", 'mpcth'),
		"desc" 	=> __("Specify footer font color.", 'mpcth'),
		"type" 	=> "color",
		"std" 	=> $default_values['advanceColors']['footerFont'] );

	$options['mpcth_colors_footer_active'] = array(
		"id" 	=> "mpcth_colors_footer_active",
		"name" 	=> __("Footer Active/Hover", 'mpcth'),
		"desc" 	=> __("Specify footer active/hover color.", 'mpcth'),
		"type" 	=> "color",
		"std" 	=> $default_values['advanceColors']['footerActive'] );

	/* Sizes */
	$options['mpcth_font_sizes_footer_header'] = array(
		"id" 	=> "mpcth_font_sizes_footer_header",
		"name" 	=> __("Footer Header", 'mpcth'),
		"desc" 	=> __("Specify footer header font size.", 'mpcth'),
		"type" 	=> "slider",
		"std" 	=> $default_values['advanceFontSizes']['footerHeader'],
	 	"min" 	=> "8",
	 	"max" 	=> "64" );

	$options['mpcth_font_sizes_footer_content'] = array(
		"id" 	=> "mpcth_font_sizes_footer_content",
		"name" 	=> __("Footer Content", 'mpcth'),
		"desc" 	=> __("Specify footer content font size.", 'mpcth'),
		"type" 	=> "slider",
		"std" 	=> $default_values['advanceFontSizes']['footerContent'],
	 	"min" 	=> "8",
	 	"max" 	=> "64" );

	$options['mpcth_font_sizes_footer_small'] = array(
		"id" 	=> "mpcth_font_sizes_footer_small",
		"name" 	=> __("Footer Small", 'mpcth'),
		"desc" 	=> __("Specify footer small font size.", 'mpcth'),
		"type" 	=> "slider",
		"std" 	=> $default_values['advanceFontSizes']['footerSmall'],
	 	"min" 	=> "8",
	 	"max" 	=> "64" );

/* ---------------------------------------------------------------- */
/* Extended Footer
/* ---------------------------------------------------------------- */
	$options[] = array(
		"name" => __("Extended Footer", 'mpcth'),
		"type" => "accordion");

	/* Colors */
	$options['mpcth_colors_footer_ex_background'] = array(
		"id" 	=> "mpcth_colors_footer_ex_background",
		"name" 	=> __("Extended Footer Background", 'mpcth'),
		"desc" 	=> __("Specify extended footer background color.", 'mpcth'),
		"type" 	=> "color",
		"std" 	=> $default_values['advanceColors']['footerExBackground'] );

	$options['mpcth_colors_footer_ex_border'] = array(
		"id" 	=> "mpcth_colors_footer_ex_border",
		"name" 	=> __("Extended Footer Border", 'mpcth'),
		"desc" 	=> __("Specify extended footer border color.", 'mpcth'),
		"type" 	=> "color",
		"std" 	=> $default_values['advanceColors']['footerExBorder'] );

	$options['mpcth_colors_footer_ex_font'] = array(
		"id" 	=> "mpcth_colors_footer_ex_font",
		"name" 	=> __("Extended Footer Font", 'mpcth'),
		"desc" 	=> __("Specify extended footer font color.", 'mpcth'),
		"type" 	=> "color",
		"std" 	=> $default_values['advanceColors']['footerExFont'] );

	$options['mpcth_colors_footer_ex_active'] = array(
		"id" 	=> "mpcth_colors_footer_ex_active",
		"name" 	=> __("Extended Footer Active/Hover", 'mpcth'),
		"desc" 	=> __("Specify extended footer active/hover color.", 'mpcth'),
		"type" 	=> "color",
		"std" 	=> $default_values['advanceColors']['footerExActive'] );

	/* Sizes */
	$options['mpcth_font_sizes_footer_ex_header'] = array(
		"id" 	=> "mpcth_font_sizes_footer_ex_header",
		"name" 	=> __("Extended Footer Header", 'mpcth'),
		"desc" 	=> __("Specify extended footer header font size.", 'mpcth'),
		"type" 	=> "slider",
		"std" 	=> $default_values['advanceFontSizes']['footerExHeader'],
	 	"min" 	=> "8",
	 	"max" 	=> "64" );

	$options['mpcth_font_sizes_footer_ex_content'] = array(
		"id" 	=> "mpcth_font_sizes_footer_ex_content",
		"name" 	=> __("Extended Footer Content", 'mpcth'),
		"desc" 	=> __("Specify extended footer content font size.", 'mpcth'),
		"type" 	=> "slider",
		"std" 	=> $default_values['advanceFontSizes']['footerExContent'],
	 	"min" 	=> "8",
	 	"max" 	=> "64" );

	$options['mpcth_font_sizes_footer_ex_small'] = array(
		"id" 	=> "mpcth_font_sizes_footer_ex_small",
		"name" 	=> __("Extended Footer Small", 'mpcth'),
		"desc" 	=> __("Specify extended footer small font size.", 'mpcth'),
		"type" 	=> "slider",
		"std" 	=> $default_values['advanceFontSizes']['footerExSmall'],
	 	"min" 	=> "8",
	 	"max" 	=> "64" );

/* ---------------------------------------------------------------- */
/* Copyright
/* ---------------------------------------------------------------- */
	$options[] = array(
		"name" => __("Copyright", 'mpcth'),
		"type" => "accordion");

	/* Colors */
	$options['mpcth_colors_copyright_background'] = array(
		"id" 	=> "mpcth_colors_copyright_background",
		"name" 	=> __("Copyright Background", 'mpcth'),
		"desc" 	=> __("Specify copyright background color.", 'mpcth'),
		"type" 	=> "color",
		"std" 	=> $default_values['advanceColors']['copyrightBackground'] );

	$options['mpcth_colors_copyright_border'] = array(
		"id" 	=> "mpcth_colors_copyright_border",
		"name" 	=> __("Copyright Border", 'mpcth'),
		"desc" 	=> __("Specify copyright border color.", 'mpcth'),
		"type" 	=> "color",
		"std" 	=> $default_values['advanceColors']['copyrightBorder'] );

	$options['mpcth_colors_copyright_font'] = array(
		"id" 	=> "mpcth_colors_copyright_font",
		"name" 	=> __("Copyright Font", 'mpcth'),
		"desc" 	=> __("Specify copyright font color.", 'mpcth'),
		"type" 	=> "color",
		"std" 	=> $default_values['advanceColors']['copyrightFont'] );

	$options['mpcth_colors_copyright_active'] = array(
		"id" 	=> "mpcth_colors_copyright_active",
		"name" 	=> __("Copyright Active/Hover", 'mpcth'),
		"desc" 	=> __("Specify copyright active/hover color.", 'mpcth'),
		"type" 	=> "color",
		"std" 	=> $default_values['advanceColors']['copyrightActive'] );

	/* Sizes */
	$options['mpcth_font_sizes_footer_copyright'] = array(
		"id" 	=> "mpcth_font_sizes_footer_copyright",
		"name" 	=> __("Copyright", 'mpcth'),
		"desc" 	=> __("Specify copyright font size.", 'mpcth'),
		"type" 	=> "slider",
		"std" 	=> $default_values['advanceFontSizes']['footerCopyright'],
	 	"min" 	=> "8",
	 	"max" 	=> "64" );

	return $options;
}