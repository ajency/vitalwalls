<?php
/**
 * Single Product Thumbnails
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.3
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product, $woocommerce;

$attachment_ids = $product->get_gallery_attachment_ids();

if ( $attachment_ids ) {
	?>
<div id="main_thumbs" class="flexslider">
	<ul class="slides"><?php
		if ( has_post_thumbnail() ) {
			$attachment_id = get_post_thumbnail_id( $post->ID );
			$image = wp_get_attachment_image_src( $attachment_id, 'thumbnail' );
			$image_title = esc_attr( get_the_title( $attachment_id ) );

			echo '<li><img src="' . $image[0] . '" width="' . $image[1] . '" height="' . $image[2] . '" title="' . $image_title . '" /></li>';
		}

		foreach ( $attachment_ids as $attachment_id ) {
			$image = wp_get_attachment_image_src( $attachment_id, 'thumbnail' );
			$image_title = esc_attr( get_the_title( $attachment_id ) );

			if ( ! $image[0] )
				continue;

			echo '<li><img src="' . $image[0] . '" width="' . $image[1] . '" height="' . $image[2] . '" title="' . $image_title . '" /></li>';
		}

	?></ul>
</div>
	<?php
}