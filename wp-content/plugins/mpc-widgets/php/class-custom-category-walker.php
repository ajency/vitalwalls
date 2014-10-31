<?php
/**
 * MPC_Simple_List_Walker class.
 *
 * @extends 	Walker
 * @class 		MPC_Simple_List_Walker
 * @version		1.0
 * @author 		MPC
 */
class MPC_Simple_List_Walker extends Walker {
	var $tree_type = 'product_cat';
	var $db_fields = array ('parent' => 'parent', 'id' => 'term_id');

	function start_lvl( &$output, $depth = 0, $args = array() ) {
		return;
	}

	function end_lvl( &$output, $depth = 0, $args = array() ) {
		return;
	}

	function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
		extract($args);

		$cat_name = esc_attr( $category->name );
		$cat_name = apply_filters( 'list_cats', $cat_name, $category );
		$link = '<option value="' . esc_url( get_term_link($category) ) . '" ';
		if ($category->slug == $default) $link .= 'selected=selected';
		$link .= '>';
		$link .= $cat_name . '</option>';

		$output .= $link;
	}

	function end_el( &$output, $page, $depth = 0, $args = array() ) {
		return;
	}
}