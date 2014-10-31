<?php

add_action('wp_enqueue_scripts', 'mpcth_child_enqueue_scripts');
function mpcth_child_enqueue_scripts() {
	wp_enqueue_style( 'mpc-styles-child', get_stylesheet_directory_uri() . '/style.css' );
}






//Override script for personalized product plugin
function personalizedproduct_script(){
	//wp_dequeue_script( 'nm_personalizedproduct-scripts' );
	wp_enqueue_script( 'new_personalizedproduct-scripts', get_stylesheet_directory_uri() . '/js/personalizedproduct/script.js', array(), '3.0', false);
	
}
add_action('wp_enqueue_scripts','personalizedproduct_script', 100);








add_filter('add_to_cart_fragments', 'mpcth_wc_ajaxify_mini_cart_icon');
function mpcth_wc_ajaxify_mini_cart_icon($fragments) {
	ob_start();

	?>
	<span class="mpcth-mini-cart-icon-info">
		<?php if (sizeof( WC()->cart->get_cart()) > 0) { ?>

		<?php
		$subttl = array();
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ){
			$_product = $cart_item['data'];
			$subttl[] = get_option( 'woocommerce_tax_display_cart' ) == 'excl' ? $_product->get_price_excluding_tax()*$cart_item['quantity'] : $_product->get_price_including_tax()*$cart_item['quantity'];
		}
		?>
			<span class="mpcth-mini-cart-subtotal"><?php echo __('Subtotal', 'mpcth'); ?>: </span><?php echo getFormatedPrice(array_sum($subttl)); ?> (<?php echo WC()->cart->cart_contents_count; ?>)
		<?php } ?>
	</span>

	<?php

	$fragments['span.mpcth-mini-cart-icon-info'] = ob_get_clean();

	return $fragments;
}

add_filter('add_to_cart_fragments', 'mpcth_wc_ajaxify_mini_cart');
function mpcth_wc_ajaxify_mini_cart($fragments) {
	ob_start();

	mpcth_wc_print_mini_cart();

	$fragments['div#mpcth_mini_cart_wrap'] = ob_get_clean();

	return $fragments;
}

function mpcth_wc_print_mini_cart() {
	if (function_exists('is_woocommerce')) {
	?>
	<div id="mpcth_mini_cart_wrap">
		<?php if ( sizeof( WC()->cart->get_cart() ) > 0 ) : ?>
			<ul class="mpcth-mini-cart-products">

				<?php $subttl = array(); ?>


				<?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
					$_product = $cart_item['data'];

					// Only display if allowed
					if ( ! apply_filters('woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) || ! $_product->exists() || $cart_item['quantity'] == 0 )
						continue;

					// Get price
					$product_price = get_option( 'woocommerce_tax_display_cart' ) == 'excl' ? $_product->get_price_excluding_tax() : $_product->get_price_including_tax();
					$product_price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key );
					?>

					<?php $subttl[] = get_option( 'woocommerce_tax_display_cart' ) == 'excl' ? $_product->get_price_excluding_tax()*$cart_item['quantity'] : $_product->get_price_including_tax()*$cart_item['quantity']; ?>

					<li class="mpcth-mini-cart-product">
						<span class="mpcth-mini-cart-thumbnail">
							<?php echo $_product->get_image(); ?>
							<?php echo apply_filters( 'woocommerce_cart_item_remove_link', '<a href="' . esc_url( WC()->cart->get_remove_url( $cart_item_key ) ) . '" class="mpcth-mini-cart-remove mpcth-color-main-color" title="' . __( 'Remove this item', 'woocommerce' ) . '">&times;</a>', $cart_item_key ); ?>
						</span>
						<span class="mpcth-mini-cart-info">
							<a class="mpcth-mini-cart-title" href="<?php echo get_permalink( $cart_item['product_id'] ); ?>">
								<?php echo apply_filters('woocommerce_widget_cart_product_title', $_product->get_title(), $_product ); ?>
							</a>
							<?php echo apply_filters( 'woocommerce_widget_cart_item_price', '<span class="mpcth-mini-cart-price">' . __('Unit Price', 'mpcth') . ': ' . $product_price . '</span>', $cart_item, $cart_item_key ); ?>
							<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="mpcth-mini-cart-quantity">' . __('Quantity', 'mpcth') . ': ' . $cart_item['quantity'] . '</span>', $cart_item, $cart_item_key ); ?>
							<div class="product-variation"><?php echo WC()->cart->get_item_data( $cart_item );?></div>
						</span>
					</li>

				<?php endforeach; ?>
			</ul><!-- end .mpcth-mini-cart-products -->
		<?php else : ?>
			<p class="mpcth-mini-cart-product-empty"><?php _e( 'No products in the cart.', 'woocommerce' ); ?></p>
		<?php endif; ?>

		<?php if (sizeof( WC()->cart->get_cart()) > 0) : ?>

		
			<p class="mpcth-mini-cart-subtotal mpcth-color-main-color"><?php _e( 'Cart Subtotal', 'woocommerce' ); ?>: <?php echo getFormatedPrice(array_sum($subttl)); ?></p>

			<a href="<?php echo WC()->cart->get_cart_url(); ?>" class="button cart mpcth-color-main-background-hover"><?php _e( 'View Cart', 'woocommerce' ); ?></a>
			<a href="<?php echo WC()->cart->get_checkout_url(); ?>" class="button alt checkout mpcth-color-main-background"><?php _e( 'Proceed to Checkout', 'woocommerce' ); ?></a>
		<?php endif; ?>
	</div>
	<?php
	}
}




function getFormatedPrice($price){
	$decimal_sep = wp_specialchars_decode(stripslashes(get_option('woocommerce_price_decimal_sep')), ENT_QUOTES);
	$thousands_sep = wp_specialchars_decode(stripslashes(get_option( 'woocommerce_price_thousand_sep')), ENT_QUOTES);
	$decimal_num = wp_specialchars_decode(stripslashes(get_option( 'woocommerce_price_num_decimals')), ENT_QUOTES);
	return get_woocommerce_currency_symbol().number_format($price, $decimal_num, $decimal_sep, $thousands_sep);
}




function getSizeChart(){
	$attribute_label = 'Size Chart';
	global $product;
	$attributes = $product->get_attributes();

	if ( ! $attributes ) {
		return;
	}

	foreach ( $attributes as $attribute ) {

		if ( $attribute['is_variation'] ) {
			continue;
		}

		if ( $attribute['is_taxonomy'] ) {

			$terms = wp_get_post_terms( $product->id, $attribute['name'], 'all' );

            // get the taxonomy
			$tax = $terms[0]->taxonomy;
			$tax_object = get_taxonomy($tax);

			if ( isset ($tax_object->labels->name) ) {
				$tax_label = $tax_object->labels->name;
			} elseif ( isset( $tax_object->label ) ) {
				$tax_label = $tax_object->label;
			}

			if($tax_label == $attribute_label){

				
				$out = '<div class="product_meta">';
				foreach ( $terms as $term ) {
					//$out .= '<li class="' . esc_attr( $attribute['name'] ) . ' ' . esc_attr( $term->slug ) . '">';
					//$out .= '<span class="attribute-value">' . $term->name . '</span></li>';

					$size = explode(":", $term->name);
					
					$out .= '<span class="'.esc_attr( $attribute['name']).'">'.$size[0].': <span class="size_value"> ' . $size[1] . '</span>.</span>';
				}

				$out .= '</div>';
			}

		} 
	}

	echo $out;
}
add_action('woocommerce_single_product_beforeprice', 'getSizeChart', 25);


