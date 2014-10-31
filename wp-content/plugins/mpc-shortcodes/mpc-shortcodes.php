<?php
/*
Plugin Name: MPC Shortcodes
Plugin URI: http://themeforest.net/user/mpc/
Description: Basic inline shortcodes available from TinyMCE Editor. Created as an extension for all MPC Themes but should work everywhere with default styles.
Author: MassivePixelCreation
Version: 2.0
Author URI: http://themeforest.net/user/mpc/
*/

if(!function_exists('add_action')) {
	echo 'MPC Shortcodes plugin.';
	exit;
}

/* Constants */
define('MPC_SHORTCODES_URL', plugin_dir_url(__FILE__));
define('MPC_SHORTCODES_PATH', dirname(__FILE__));

/* Functions */
add_action('admin_enqueue_scripts', 'mpc_sh_admin_enqueue_scripts');
function mpc_sh_admin_enqueue_scripts() {
	wp_enqueue_style('wp-color-picker');
	wp_enqueue_style('mpc-sh-admin-styles', MPC_SHORTCODES_URL . 'css/mpc-sh-admin.css');

	wp_enqueue_script('wp-color-picker');
}

require_once(MPC_SHORTCODES_PATH . '/php/mpc_sh.php');

add_action('wp_enqueue_scripts', 'mpc_sh_enqueue_scripts');
function mpc_sh_enqueue_scripts() {
	global $post;

	if(isset($post->post_content)) {
		if(!defined('MPC_THEME_ENABLED')) {
			wp_enqueue_style('magnific-popup-css', MPC_SHORTCODES_URL . 'css/magnific-popup.min.css');
			wp_enqueue_script('magnific-popup-js', MPC_SHORTCODES_URL . 'js/jquery.magnific-popup.min.js', array('jquery'), '0.9.6', true);
		}

		wp_enqueue_style('mpc-sh-styles', MPC_SHORTCODES_URL . 'css/mpc-sh.css');
		wp_enqueue_script('mpc-sh-scripts', MPC_SHORTCODES_URL . 'js/mpc-sh.js', array('jquery'), '1.0', true);
	}
}

/* Enable tinyMCE shortcode button */
add_action('admin_init', 'mpc_sh_register_buttons');
function mpc_sh_register_buttons(){
	if(current_user_can('edit_posts') && current_user_can('edit_pages')) {
		if(get_user_option('rich_editing') == 'true'){
			add_filter('mce_external_plugins', 'mpc_sh_plugin');
			add_filter('mce_buttons', 'mpc_sh_button');
		}
	}
}

function mpc_sh_plugin($array){
	$array['mpc_sh'] = MPC_SHORTCODES_URL . 'js/mpc-sh-plugin.js';
	return $array;
}

function mpc_sh_button($buttons){
	array_push($buttons, '|', 'mpc_sh_button');
	return $buttons;
}

function mpc_has_shortcode($content = '', $shortcode = '') {
	$found = false;

	if (empty($content) || empty($shortcode))
		return $found;

	if (stripos($content, '[' . $shortcode) !== false)
		$found = true;

	return $found;
}
/* ---------------------------------------------------------------- */
/* Update
/* ---------------------------------------------------------------- */

$mpc_api_url = 'http://mpcreation.net/api/';
$mpc_sh_slug = basename(dirname(__FILE__));

add_filter('pre_set_site_transient_update_plugins', 'mpc_sh_check_for_plugin_update');
function mpc_sh_check_for_plugin_update($checked_data) {
	global $mpc_api_url, $mpc_sh_slug, $wp_version;

	if (empty($checked_data->checked))
		return $checked_data;

	$args = array(
		'slug' => $mpc_sh_slug,
		'version' => $checked_data->checked[$mpc_sh_slug .'/'. $mpc_sh_slug .'.php'],
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
		$checked_data->response[$mpc_sh_slug .'/'. $mpc_sh_slug .'.php'] = $response;

	return $checked_data;
}

add_filter('plugins_api', 'mpc_sh_plugin_api_call', 100, 3);
function mpc_sh_plugin_api_call($def, $action, $args) {
	global $mpc_api_url, $mpc_sh_slug, $wp_version;

	if (!isset($args->slug) || ($args->slug != $mpc_sh_slug))
		return $def;

	$plugin_info = get_site_transient('update_plugins');
	$current_version = $plugin_info->checked[$mpc_sh_slug .'/'. $mpc_sh_slug .'.php'];
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