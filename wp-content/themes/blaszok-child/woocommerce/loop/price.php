<?php
/**
 * Loop Price
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product;
?>

<?php if ( $price_html = $product->get_price_html() ) : ?>
	<?php if(is_painting($post->ID)){
		$price = get_post_meta( $post->ID, '_regular_price', true);
	 ?>
<span class="price"><ins><span class="amount"><?php echo getFormatedPrice($price); ?></span></ins></span>
<?php }else{ ?>
	<span class="price"><?php echo $price_html ?></span>
	<?php } ?>
<?php endif; ?>