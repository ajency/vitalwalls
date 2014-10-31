<?php
/* Register portfolio custom post type */
add_action('init', 'mpc_ex_portfolio');
function mpc_ex_portfolio() {
	register_taxonomy('mpc_portfolio_cat', 'mpc_portfolio', array(
		'hierarchical' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array(
			'slug' => __('portfolio_category', 'mpcth'),
			'with_front' => false
		),
	));
	register_taxonomy('mpc_portfolio_tag', 'mpc_portfolio', array(
		'hierarchical' => false,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array(
			'slug' => __('portfolio_tag', 'mpcth'),
			'with_front' => false
		),
	));

	$labels = array(
		'name' => __('Portfolio', 'mpcth'),
		'singular_name' => __('Portfolio Item', 'mpcth'),
		'all_items' => __('Portfolio Items', 'mpcth'),
		'add_new_item' => __('Add New Portfolio Item', 'mpcth'),
		'edit_item' => __('Edit Portfolio Item', 'mpcth'),
		'new_item' => __('New Portfolio Item', 'mpcth'),
		'view_item' => __('View Portfolio Item', 'mpcth'),
		'search_items' => __('Search Portfolio Items', 'mpcth'),
		'not_found' => __('No Portfolio Items found', 'mpcth'),
		'not_found_in_trash' => __('No Portfolio Items found in Trash', 'mpcth')
	);

	$portfolio_args = array(
		'labels' => $labels,
		'public' => true,
		'show_ui' => true,
		'menu_icon' => MPC_EXTENSIONS_URL . 'icon/portfolio.png',
		'capability_type' => 'post',
		'hierarchical' => false,
		'rewrite' => array(
			'slug' => __('portfolios', 'mpcth'),
			'with_front' => false
		),
		'supports' => array('title', 'editor', 'post-formats', 'thumbnail', 'comments', 'author'),
		// 'taxonomies' => array('portfolio_tag')
	);

	register_post_type('mpc_portfolio', $portfolio_args);
}

/* Disable portfolio not used post formats */
add_action('admin_head', 'mpc_ex_portfolio_icons');
function mpc_ex_portfolio_icons() {
	global $post_type;

	if(($post_type == 'mpc_portfolio')) {
		echo '<style>';
			echo '#icon-edit { background:transparent url("' . MPC_EXTENSIONS_URL . 'icon/portfolio_large.png' . '") no-repeat; }';
			echo '#post-format-aside, #post-formats-select .post-format-aside, #post-formats-select .post-format-aside + br { display: none; }';
			echo '#post-format-chat, #post-formats-select .post-format-chat, #post-formats-select .post-format-chat + br { display: none; }';
			echo '#post-format-image, #post-formats-select .post-format-image, #post-formats-select .post-format-image + br { display: none; }';
			echo '#post-format-link, #post-formats-select .post-format-link, #post-formats-select .post-format-link + br { display: none; }';
			echo '#post-format-quote, #post-formats-select .post-format-quote, #post-formats-select .post-format-quote + br { display: none; }';
			echo '#post-format-status, #post-formats-select .post-format-status, #post-formats-select .post-format-status + br { display: none; }';
		echo '</style>';
	}
}