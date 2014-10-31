<?php
/*
 * this file contains pluing meta information and then shared
 * between pluging and admin classes
 * 
 * [1]
 */



if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
	define('NM_DIR_SEPERATOR', '\\');
} else {
	define('NM_DIR_SEPERATOR', '/');
}

function get_plugin_meta_productmeta(){
	
	$plugin_dir = 'nm-woocommerce-personalized-product-v3.5';
	
	return array('name'			=> 'Personalized Product',
							'dir_name'		=> $plugin_dir,
							'shortname'		=> 'nm_personalizedproduct',
							'path'			=> WP_PLUGIN_DIR . NM_DIR_SEPERATOR . $plugin_dir,
							'url'			=> WP_PLUGIN_URL . NM_DIR_SEPERATOR . $plugin_dir,
							'db_version'	=> 3.0,
							'logo'			=> WP_PLUGIN_URL . NM_DIR_SEPERATOR . $plugin_dir . NM_DIR_SEPERATOR . 'images' . NM_DIR_SEPERATOR . 'logo.png',
							'menu_position'	=> 60
	);
}


function nm_personalizedproduct_pa($arr){
	
	echo '<pre>';
	print_r($arr);
	echo '</pre>';
}
