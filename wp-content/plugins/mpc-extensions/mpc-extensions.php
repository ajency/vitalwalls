<?php
/*
Plugin Name: MPC Extensions
Plugin URI: http://themeforest.net/user/mpc/
Description: Collection of extensions (custom post types, Visual Composer components). Created as an extension for all MPC Themes but should work everywhere with default styles.
Author: MassivePixelCreation
Version: 2.0
Author URI: http://themeforest.net/user/mpc/
*/

if(!function_exists('add_action')) {
	echo 'MPC Extensions plugin.';
	exit;
}

/* Constants */
define('MPC_EXTENSIONS_URL', plugin_dir_url(__FILE__));
define('MPC_EXTENSIONS_DIR', plugin_dir_path(__FILE__));

/* Functions */
add_action('admin_enqueue_scripts', 'mpc_ex_admin_enqueue_scripts', 10, 1);
function mpc_ex_admin_enqueue_scripts($hook) {
	wp_enqueue_style('font-awesome', MPC_EXTENSIONS_URL . 'fonts/font-awesome.css');
	wp_enqueue_style('mpc-visual-composer-admin', MPC_EXTENSIONS_URL . 'css/mpc_vc_admin.css');
}

add_action('wp_enqueue_scripts', 'mpc_ex_enqueue_scripts');
function mpc_ex_enqueue_scripts($hook) {
	if (! defined('MPC_THEME_ENABLED') || (defined('MPC_THEME_ENABLED') && ! MPC_THEME_ENABLED)) {
		wp_enqueue_style('mpc-visual-composer', MPC_EXTENSIONS_URL . 'css/mpc_vc.css');

		wp_enqueue_style('font-awesome', MPC_EXTENSIONS_URL . 'fonts/font-awesome.css');
		wp_enqueue_style('flexslider-css', MPC_EXTENSIONS_URL . 'css/flexslider.min.css');

		wp_enqueue_script('flexslider-js', MPC_EXTENSIONS_URL . 'js/jquery.flexslider.min.js', array('jquery'), '2.2.0', true);
		wp_enqueue_script('mpc-ex-main-js', MPC_EXTENSIONS_URL . 'js/main.js', array('jquery'), '1.0', true);
	}
}

require_once('php/mpc_portfolio.php');

require_once('php/mpc_grid.php');

require_once('php/mpc_visual_composer.php');

/* ---------------------------------------------------------------- */
/* Fix for 404 on custom post types
/* ---------------------------------------------------------------- */
register_activation_hook(__FILE__, 'mpc_ex_activate');
function mpc_ex_activate() {
	flush_rewrite_rules();
}

register_deactivation_hook(__FILE__, 'mpc_ex_deactivate');
function mpc_ex_deactivate() {
	flush_rewrite_rules();
}

/* ---------------------------------------------------------------- */
/* Update
/* ---------------------------------------------------------------- */

$mpc_api_url = 'http://mpcreation.net/api/';
$mpc_ex_slug = basename(dirname(__FILE__));

add_filter('pre_set_site_transient_update_plugins', 'mpc_ex_check_for_plugin_update');
function mpc_ex_check_for_plugin_update($checked_data) {
	global $mpc_api_url, $mpc_ex_slug, $wp_version;

	if (empty($checked_data->checked))
		return $checked_data;

	$args = array(
		'slug' => $mpc_ex_slug,
		'version' => $checked_data->checked[$mpc_ex_slug .'/'. $mpc_ex_slug .'.php'],
	);
	$request_string = array(
		'body' => array(
			'action' => 'basic_check',
			'request' => serialize($args),
			'api-key' => md5(get_bloginfo('url'))
		),
		'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')
	);

	$raw_response = wp_remote_post($mpc_api_url, $request_string);

	if (!is_wp_error($raw_response) && ($raw_response['response']['code'] == 200))
		$response = unserialize($raw_response['body']);

	if (is_object($response) && !empty($response))
		$checked_data->response[$mpc_ex_slug .'/'. $mpc_ex_slug .'.php'] = $response;

	return $checked_data;
}

add_filter('plugins_api', 'mpc_ex_plugin_api_call', 100, 3);
function mpc_ex_plugin_api_call($def, $action, $args) {
	global $mpc_api_url, $mpc_ex_slug, $wp_version;

	if (!isset($args->slug) || ($args->slug != $mpc_ex_slug))
		return $def;

	$plugin_info = get_site_transient('update_plugins');
	$current_version = $plugin_info->checked[$mpc_ex_slug .'/'. $mpc_ex_slug .'.php'];
	$args->version = $current_version;

	$request_string = array(
			'body' => array(
				'action' => $action,
				'request' => serialize($args),
				'api-key' => md5(get_bloginfo('url'))
			),
			'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')
		);

	$request = wp_remote_post($mpc_api_url, $request_string);

	if (is_wp_error($request)) {
		$res = new WP_Error('plugins_api_failed', __('An Unexpected HTTP Error occurred during the API request.</p> <p><a href="?" onclick="document.location.reload(); return false;">Try again</a>'), $request->get_error_message());
	} else {
		$res = unserialize($request['body']);

		if ($res === false)
			$res = new WP_Error('plugins_api_failed', __('An unknown error occurred'), $request['body']);
	}

	return $res;
}