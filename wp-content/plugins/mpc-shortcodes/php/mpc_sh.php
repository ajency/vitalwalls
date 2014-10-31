<?php
/* Drop Caps */
add_shortcode('mpc_sh_dropcaps', 'mpc_sh_dropcaps_shortcode');
function mpc_sh_dropcaps_shortcode($atts, $content = null) {
	extract(shortcode_atts(array(
		'background' => '',
		'color' => '',
		'size' => 'normal'
	), $atts));

	$return = '<span class="mpc-sc-dropcaps mpc-sc-dropcaps-size-' . $size . '" style="background: ' . $background . '; color: ' . $color . ';">' . $content . '</span>';

	$return = mpc_sh_content_parser($return);
	return $return;
}

/* Highlight */
add_shortcode('mpc_sh_highlight', 'mpc_sh_highlight_shortcode');
function mpc_sh_highlight_shortcode($atts, $content = null) {
	extract(shortcode_atts(array(
		'background' => '',
		'color' => ''
	), $atts));

	$return = '<span class="mpc-sc-highlight" style="background: ' . $background . '; color: ' . $color . ';">' . $content . '</span>';

	$return = mpc_sh_content_parser($return);
	return $return;
}

/* Lightbox */
add_shortcode('mpc_sh_lightbox', 'mpc_sh_lightbox_shortcode');
function mpc_sh_lightbox_shortcode($atts, $content = null) {
	extract(shortcode_atts(array(
		'src' => '',
		'caption' => ''
	), $atts));

	$type = 'iframe';
	$src_type = strtolower($src);

	$search = preg_match('/.(jpg|jpeg|gif|png|bmp)/', $src_type);
	if($search == 1) {
		$type = 'image';
	}

	$force_type = '';
	if($type == 'iframe')
		$force_type = ' mfp-iframe';

	$return = '<a class="mpc-sc-lightbox mpc-sc-lightbox-type-' . $type . $force_type . '" href="' . $src . '" title="' . $caption . '">' . $content . '</a>';

	$return = mpc_sh_content_parser($return);
	return $return;
}

/* Tooltip */
add_shortcode('mpc_sh_tooltip', 'mpc_sh_tooltip_shortcode');
function mpc_sh_tooltip_shortcode($atts, $content = null) {
	extract(shortcode_atts(array(
		'message' => '',
		'background' => '',
		'color' => ''
	), $atts));

	$css_id = 'mpc_sc_tooltip_' . mpc_sh_random_ID();

	$return = '<span id="' . $css_id . '" class="mpc-sc-tooltip-wrap">';
		// $return .= '<style>#' . $css_id . ' .mpc-sc-tooltip-message:after {border-top-color: ' . $background . ';}</style>';
		$return .= '<span class="mpc-sc-tooltip-text">' . $content . '</span><span class="mpc-sc-tooltip-message" style="background: ' . $background . '; color: ' . $color . '; border-top-color: ' . $background . ';">' . $message . '</span>';
	$return .= '</span>';

	$return = mpc_sh_content_parser($return);
	return $return;
}

/* Grid */
add_shortcode('mpc_sh_grid', 'mpc_sh_grid_shortcode');
function mpc_sh_grid_shortcode($atts, $content = null) {
	extract(shortcode_atts(array(
		'id' => '',
		'spaces' => '',
	), $atts));

	if ($id == 'select')
		return;

	$grid = get_post($id);

	$return = '<div id="mpcth_grid" ' . ($spaces == 'true' ? 'class="mpcth-grid-with-space"' : '') . '>';
		$return .= $grid->post_content;
	$return .= '</div>';

	$return = mpc_sh_content_parser($return);
	return $return;
}

/* Parse shortcode content */
function mpc_sh_content_parser($content) {
	$content = trim(do_shortcode(shortcode_unautop($content)));

	if (substr($content, 0, 4) == '')
		$content = substr($content, 4);

	if (substr($content, -3, 3) == '')
		$content = substr($content, 0, -3);

	$content = str_replace(array('<p></p>'), '', $content);
	$content = str_replace(array('<p>  </p>'), '', $content);

	return $content;
}

/* Helpers */
function mpc_sh_random_ID($length = 5) {
	return substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $length);
}