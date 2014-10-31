<?php
/**
 * The Standard post header base for MPC Themes
 *
 * Displays the thumbnail for posts in the Standard post format.
 *
 * @package WordPress
 * @subpackage MPC Themes
 * @since 1.0
 */

global $sidebar_position;
global $blog_layout;

$default = 1;
if ($blog_layout == 'small')
	$default += 1;

if (has_post_thumbnail()) {
	the_post_thumbnail('mpcth-horizontal-columns-' . $default);
}