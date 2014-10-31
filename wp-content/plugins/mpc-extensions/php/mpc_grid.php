<?php
/* Register grid custom post type */
add_action('init', 'mpc_ex_grid');
function mpc_ex_grid() {
	$labels = array(
		'name' => __('Grid', 'mpcth'),
		'singular_name' => __('Grid Item', 'mpcth'),
		'all_items' => __('Grid Items', 'mpcth'),
		'add_new_item' => __('Add New Grid Item', 'mpcth'),
		'edit_item' => __('Edit Grid Item', 'mpcth'),
		'new_item' => __('New Grid Item', 'mpcth'),
		'view_item' => __('View Grid Item', 'mpcth'),
		'search_items' => __('Search Grid Items', 'mpcth'),
		'not_found' => __('No Grid Items found', 'mpcth'),
		'not_found_in_trash' => __('No Grid Items found in Trash', 'mpcth')
	);

	$grid_args = array(
		'labels' => $labels,
		'public' => true,
		'show_ui' => true,
		'exclude_from_search' => true,
		'menu_icon' => 'dashicons-screenoptions',
		'capability_type' => 'post',
		'hierarchical' => false,
		'supports' => array('title', 'editor'),
	);

	register_post_type('mpc_grid', $grid_args);
}