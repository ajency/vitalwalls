<?php
/**
 * Product loop sale flash
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product;
?>
<?php if ( $product->is_on_sale() && !is_painting($post->ID) ) : ?>

	<?php echo apply_filters( 'woocommerce_sale_flash', '<div class="mpcth-sale-wrap"><span class="onsale mpcth-color-main-background">' . __( 'Sale!', 'woocommerce' ) . '</span></div>', $post, $product ); ?>

<?php endif; ?>