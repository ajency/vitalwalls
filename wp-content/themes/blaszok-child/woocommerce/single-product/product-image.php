<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.14
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $woocommerce, $product;

$attachment_ids = $product->get_gallery_attachment_ids();

?>
<div class="images mpcth-post-thumbnail">
	<div class="flexslider-wrap">
	<div id="main_slider" class="flexslider">
		<ul class="slides">

		<?php
			if ( has_post_thumbnail() ) {
				$attachment_id = get_post_thumbnail_id( $post->ID );
				$image = wp_get_attachment_image_src( $attachment_id, 'shop_single' );
				$image_full = wp_get_attachment_image_src( $attachment_id, 'full' );
				$image_title = esc_attr( get_the_title( $attachment_id ) );

				echo '<li><a class="mpcth-lightbox mpcth-lightbox-type-image" href="' . $image_full[0] . '" title="' . $image_title . '"><img width="' . $image[1] . '" height="' . $image[2] . '" alt="' . $image_title . '" title="' . $image_title . '" src="' . $image[0] . '" /><i class="fa fa-fw fa-expand"></i></a></li>';

			}

			if ( $attachment_ids ) {
				foreach ( $attachment_ids as $attachment_id ) {
					$image = wp_get_attachment_image_src( $attachment_id, 'shop_single' );
					$image_full = wp_get_attachment_image_src( $attachment_id, 'full' );
					$image_title = esc_attr( get_the_title( $attachment_id ) );

					if ( ! $image[0] )
						continue;

					echo '<li><a class="mpcth-lightbox mpcth-lightbox-type-image" href="' . $image_full[0] . '" title="' . $image_title . '"><img width="' . $image[1] . '" height="' . $image[2] . '" alt="' . $image_title . '" title="' . $image_title . '" src="' . $image[0] . '" /><i class="fa fa-fw fa-expand"></i></a></li>';
				}
			}
		?>

		</ul>
	</div>
	</div>

	<?php do_action( 'woocommerce_product_thumbnails' ); ?>
	<?php woocommerce_show_product_sale_flash(); ?>
</div>