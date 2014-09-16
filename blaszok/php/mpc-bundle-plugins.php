<?php

/* ---------------------------------------------------------------- */
/* Register plugins
/* ---------------------------------------------------------------- */
add_action('tgmpa_register', 'mpcth_install_require_plugins');
function mpcth_install_require_plugins() {
	$plugins = array(
		array(
			'name'		=> 'MPC Extensions',
			'slug'		=> 'mpc-extensions',
			'source'	=> 'http://blaszok.mpcthemes.com/plugins/mpc-extensions.zip',
			'required'	=> true,
		),
		array(
			'name'		=> 'MPC Widgets',
			'slug'		=> 'mpc-widgets',
			'source'	=> 'http://blaszok.mpcthemes.com/plugins/mpc-widgets.zip',
			'required'	=> true,
		),
		array(
			'name'		=> 'MPC Shortcodes',
			'slug'		=> 'mpc-shortcodes',
			'source'	=> 'http://blaszok.mpcthemes.com/plugins/mpc-shortcodes.zip',
			'required'	=> true,
		),
		array(
			'name'		=> 'ACF Repeater',
			'slug'		=> 'acf-repeater',
			'source'	=> 'http://blaszok.mpcthemes.com/plugins/acf-repeater.zip',
			'required'	=> true,
		),
		array(
			'name'		=> 'ACF Gallery',
			'slug'		=> 'acf-gallery',
			'source'	=> 'http://blaszok.mpcthemes.com/plugins/acf-gallery.zip',
			'required'	=> true,
		),
		array(
			'name'		=> 'Get Kudos',
			'slug'		=> 'getkudos',
			'source'	=> 'http://blaszok.mpcthemes.com/plugins/getkudos.zip',
			'required'	=> false,
		),
		array(
			'name'		=> 'Envato Toolkit',
			'slug'		=> 'envato-wordpress-toolkit',
			'source'	=> 'http://blaszok.mpcthemes.com/plugins/envato-wordpress-toolkit.zip',
			'required'	=> false,
		),

		array(
			'name'			=> 'Visual Composer',
			'slug'			=> 'js_composer',
			'source'		=> 'http://blaszok.mpcthemes.com/plugins/js_composer.zip',
			'required'		=> true,
			'version'		=> '4.3.4',
			'mpc_bundle'	=> 'js_composer/js_composer.php',
		),
		array(
			'name'			=> 'Revolution Slider',
			'slug'			=> 'revslider',
			'source'		=> 'http://blaszok.mpcthemes.com/plugins/revslider.zip',
			'required'		=> false,
			'version'		=> '4.6.0',
			'mpc_bundle'	=> 'revslider/revslider.php',
		),
		array(
			'name'			=> 'Woocommerce Quickview',
			'slug'			=> 'jck_woo_quickview',
			'source'		=> 'http://blaszok.mpcthemes.com/plugins/jck_woo_quickview.zip',
			'required'		=> false,
			'version'		=> '3.0.7',
			'mpc_bundle'	=> 'jck_woo_quickview/jck_woo_quickview.php',
		),
		array(
			'name'			=> 'LayerSlider',
			'slug'			=> 'LayerSlider',
			'source'		=> 'http://blaszok.mpcthemes.com/plugins/layerslider_wp.zip',
			'required'		=> false,
			'version'		=> '5.2.0',
			'mpc_bundle'	=> 'LayerSlider/layerslider.php',
		),
		array(
			'name'			=> 'CSS3 Pricing Tables Grids',
			'slug'			=> 'css3_web_pricing_tables_grids',
			'source'		=> 'http://blaszok.mpcthemes.com/plugins/css3_web_pricing_tables_grids.zip',
			'required'		=> false,
			'version'		=> '9.6',
			'mpc_bundle'	=> 'css3_web_pricing_tables_grids/css3_web_pricing_tables_grids.php',
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
			'name'		=> 'bbPress',
			'slug'		=> 'bbpress',
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

	$config = array(
		'domain'			=> 'mpcth',
		'default_path'		=> '',
		'parent_menu_slug'	=> 'themes.php',
		'parent_url_slug'	=> 'themes.php',
		'menu'				=> 'install-required-plugins',
		'has_notices'		=> true,
		'is_automatic'		=> false,
		'message'			=> '',
		'strings'			=> array(
			'page_title'						=> __( 'Install Required Plugins', 'mpcth' ),
			'menu_title'						=> __( 'Install Plugins', 'mpcth' ),
			'installing'						=> __( 'Installing Plugin: %s', 'mpcth' ),
			'oops'								=> __( 'Something went wrong with the plugin API.', 'mpcth' ),
			'notice_can_install_required'		=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ),
			'notice_can_install_recommended'	=> _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ),
			'notice_cannot_install'				=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ),
			'notice_can_activate_required'		=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ),
			'notice_can_activate_recommended'	=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ),
			'notice_cannot_activate'			=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ),
			'notice_ask_to_update'				=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ),
			'notice_cannot_update'				=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ),
			'install_link'						=> _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
			'activate_link'						=> _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
			'return'							=> __( 'Return to Required Plugins Installer', 'mpcth' ),
			'plugin_activated'					=> __( 'Plugin activated successfully.', 'mpcth' ),
			'complete'							=> __( 'All plugins installed and activated successfully. %s', 'mpcth' ),
			'nag_type'							=> 'updated'
		)
	);

	tgmpa( $plugins, $config );
}

/* ---------------------------------------------------------------- */
/* Update MPC bundle
/* ---------------------------------------------------------------- */
add_filter('plugins_api', 'mpcth_overwrite_bundle_details', 110, 3);
function mpcth_overwrite_bundle_details($response, $action, $args) {
	foreach (TGM_Plugin_Activation::$instance->plugins as $plugin) {
		if (isset($args->slug) && $args->slug == $plugin['slug'] && isset($plugin['mpc_bundle']) && $plugin['mpc_bundle'] != '') {
			$response           = new stdClass;
			$response->name     = $plugin['name'];
			$response->slug     = $plugin['slug'];
			$response->version  = $plugin['version'];
			$response->package  = $plugin['source'];
			$response->sections = array('description' => $plugin['name'] . __(' - plugin bundled with <strong>Blaszok</strong> Theme.', 'mpcth'));

			return $response;
		}
	}

	return $response;
}

add_filter('pre_set_site_transient_update_plugins', 'mpcth_add_bundle_update', 110);
function mpcth_add_bundle_update($transient) {
	$installed_plugins = get_plugins();

	foreach (TGM_Plugin_Activation::$instance->plugins as $plugin) {
		if (isset($plugin['version']) && isset($plugin['mpc_bundle']) && $plugin['mpc_bundle'] != '' && isset($installed_plugins[$plugin['mpc_bundle']]) && version_compare($installed_plugins[$plugin['mpc_bundle']]["Version"], $plugin['version'], '<')) {
			$response                 = new stdClass;
			$response->url            = '';
			$response->slug           = $plugin['slug'];
			$response->upgrade_notice = '';
			$response->new_version    = $plugin['version'];
			$response->package        = $plugin['source'];

			$transient->response[$plugin['mpc_bundle']] = $response;
		}
	}

	return $transient;
}

// Remove default VC updater
add_filter('upgrader_pre_download', 'removeUpgradeFilterFromEnvato', 20);
function removeUpgradeFilterFromEnvato($reply) {
	if (is_wp_error($reply) && ! empty($reply->errors['no_credentials'])) {
		return false;
	}

	return $reply;
}

add_action('in_plugin_update_message-js_composer/js_composer.php', 'mpcth_add_VC_wrap');
function mpcth_add_VC_wrap( $args ) {
	echo '<span class="mpc-hide-url"></span>';
}