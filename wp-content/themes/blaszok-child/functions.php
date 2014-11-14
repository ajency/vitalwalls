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











function getWidth($size){
	global $product;
	$dimension = explode('x', $product->get_attribute( 'pa_'.$size ));
	return $dimension[0];
}

function getHeight($size){
	global $product;
	$dimension = explode('x', $product->get_attribute( 'pa_'.$size ));
	return $dimension[1];
}










// Add Tryit Link to WooCommerce Products
add_action('woocommerce_single_product_summary', 'vitalwalls_add_tryit_link', 6 );

function vitalwalls_add_tryit_link() {
    global $product;
    global $nmpersonalizedproduct;
    global $the_product;
	?>
		<a href="#tryit-window" class="tryit-link" data-ob="tryitout">Try it before you buy it!</a>
		<div id="tryit-window" style="display:none;">
			<header id="tryit-header">
				<h5>You have chosen <?php echo the_title();?></h5>
				<div class="wall-size">
					Wall Size: 5'10" x 6'10"
				</div>
			</header>
			<div id="bg">
				<!--<a href="#" class="nextImageBtn" title="next"></a>
				<a href="#" class="prevImageBtn" title="previous"></a>-->
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/Living_room.png" width="1680" height="1050" alt="Living Room" title="Living Room" id="bgimg" />
			</div>
			<div id="preloader"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ajax-loader_dark.gif" width="32" height="32" /></div>
			
			<div id="color-selector">
				Paint Colour: <br/><input type='text' id="full" />

                <br/> <br/>




                <?php
                //Personalized Option
                global $post;
                $productmeta_id = get_post_meta ( $post->ID, '_product_meta_id', true );
                if ($productmeta_id) { ?>
                <div id="personalized-popup">
                <?php
                //include_once('personalized-option.php'); ?>
                </div>
                <?php }
                ?> 


                

                Size: <select name="size-drop" id="size-drop" >
                <option value="Small" data-width="<?php echo getWidth('small'); ?>" data-height="<?php echo getHeight('small'); ?>">Small</option>
                <option value="Medium" data-width="<?php echo getWidth('medium'); ?>" data-height="<?php echo getHeight('medium'); ?>">Medium</option>
                <option value="Large" data-width="<?php echo getWidth('large'); ?>" data-height="<?php echo getHeight('large'); ?>">Large</option>
           		</select>



                <script type="text/javascript">
                	jQuery(document).ready(function() {
                	    //set default dimension
                	    var defaultWidth = parseInt(jQuery( "#size-drop option:selected" ).attr('data-width'))*50;
                	    var defaultHeight = parseInt(jQuery( "#size-drop option:selected" ).attr('data-height'))*50;
                	    jQuery("#img-holder>img").css({"width": defaultWidth,"height":defaultHeight});


                	    jQuery('.frames_holder li').on('click', function(){
                	    	var newClass = jQuery(this).attr('class');
                	    	var frameName = jQuery(this).attr('title')
                	    	jQuery('.frame-title').html(frameName);
                	        jQuery('.frames_holder li').removeClass('current');
                	        jQuery(this).addClass('current');
                	        jQuery("#img-holder").removeAttr('class');
                	        jQuery("#img-holder").addClass(newClass);

                	     });


                	    jQuery('#size-drop').change(function(){
                	    var width = parseInt(jQuery( "option:selected",this ).attr('data-width'))*50;
                	    var height = parseInt(jQuery( "option:selected",this ).attr('data-height'))*50;
                	    jQuery("#img-holder>img").css({"width": width,"height":height});
                	    });
                	});
                </script>






                <!--###################################BEGIN VARIATION DROPDOWN#####################################-->
                <?php //If product is variable then only check for the variations of the product ?>
                <?php if ( $product->product_type == 'variable' ) : ?>
                    <input type="hidden" value="1" id="isVariable"/>
                    <?php
                    /*                    Code to display variations dropdown BEGINS*/

                    //Get all available variations for the product
                    $available_variations = $product->get_available_variations();?>

                    <?php //If there are variations then display the dropdown for variations ?>
                    <?php if ( ! empty( $available_variations ) ) : ?>
                        <table class="variations" cellspacing="0" style="width:313px;">
                            <tbody>
                            <?php
                            //Get variation attibutes eg. Small, Med, Large
                            $attributes = $product->get_variation_attributes();
                            ?>
                            <?php $loop = 0; foreach ( $attributes as $name => $options ) : $loop++; ?>
                                <tr>
                                    <td class="label"><label for="<?php echo sanitize_title($name); ?>"><?php echo wc_attribute_label( $name ); ?></label></td>

                                    <td class="value">
                                        <select id="<?php echo esc_attr( sanitize_title( $name ).'_popup' ); ?>" name="attribute_<?php echo sanitize_title( $name ); ?>" onchange="displayFrameSize(this);">
                                            <option value=""><?php echo __( 'Choose an option', 'woocommerce' ) ?>&hellip;</option>

                                            <?php
                                            if ( is_array( $options ) ) {

                                                if ( isset( $_REQUEST[ 'attribute_' . sanitize_title( $name ) ] ) ) {
                                                    $selected_value = $_REQUEST[ 'attribute_' . sanitize_title( $name ) ];
                                                } elseif ( isset( $selected_attributes[ sanitize_title( $name ) ] ) ) {
                                                    $selected_value = $selected_attributes[ sanitize_title( $name ) ];
                                                } else {
                                                    $selected_value = '';
                                                }

                                                // Get terms if this is a taxonomy - ordered
                                                if ( taxonomy_exists( $name ) ) {

                                                    $orderby = wc_attribute_orderby( $name );

                                                    switch ( $orderby ) {
                                                        case 'name' :
                                                            $args = array( 'orderby' => 'name', 'hide_empty' => false, 'menu_order' => false );
                                                            break;
                                                        case 'id' :
                                                            $args = array( 'orderby' => 'id', 'order' => 'ASC', 'menu_order' => false, 'hide_empty' => false );
                                                            break;
                                                        case 'menu_order' :
                                                            $args = array( 'menu_order' => 'ASC', 'hide_empty' => false );
                                                            break;
                                                    }

                                                    $terms = get_terms( $name, $args );

                                                    foreach ( $terms as $term ) {
                                                        if ( ! in_array( $term->slug, $options ) )
                                                            continue;

                                                        echo '<option value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $selected_value ), sanitize_title( $term->slug ), false ) . '>' . apply_filters( 'woocommerce_variation_option_name', $term->name ) . '</option>';
                                                    }
                                                } else {

                                                    foreach ( $options as $option ) {
                                                        echo '<option value="' . esc_attr( sanitize_title( $option ) ) . '" ' . selected( sanitize_title( $selected_value ), sanitize_title( $option ), false ) . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option ) ) . '</option>';
                                                    }

                                                }
                                            }
                                            ?>
                                        </select>
                                        <?php
                                        if ( sizeof( $attributes ) == $loop )
                                            echo '<a class="reset_variations" href="#reset">' . __( 'Clear selection', 'woocommerce' ) . '</a>';
                                        ?>

                                    </td>
                                </tr>
                            <?php endforeach;?>

                            </tbody>
                        </table>
                    <?php endif ?>
                    <?php/*Code to display variations dropdown ENDS*/?>
                    <div class="priceFrames">
                    <?php
                    //Dropdown for frames BEGINS
                    $single_form = $nmpersonalizedproduct->get_product_meta (1);
                    $existing_meta = json_decode ( $single_form->the_meta, true );
                    $row_size = 0;
                    if ($existing_meta) {
                        foreach ( $existing_meta as $key => $meta ) {
                            $type = $meta ['type'];

                            $name = strtolower ( preg_replace ( "![^a-z0-9]+!i", "_", $meta ['data_name'] ) );

                            // conditioned elements
                            $visibility = '';
                            $conditions_data = '';
                            if ($meta['logic'] == 'on') {

                                if($meta['conditions']['visibility'] == 'Show')
                                    $visibility = 'display: none';

                                $conditions_data	= 'data-rules="'.esc_attr( json_encode($meta['conditions'] )).'"';
                            }

                            if (($row_size + intval ( $meta ['width'] )) > 100 || $type == 'section') {

                                echo '<div style="clear:both; margin: 0;"></div>';

                                if ($type == 'section') {
                                    $row_size = 100;
                                } else {

                                    $row_size = intval ( $meta ['width'] );
                                }
                            } else {

                                $row_size += intval ( $meta ['width'] );
                            }

                            //$show_asterisk = ($meta ['required']) ? '<span class="show_required"> *</span>' : '';
                            //$show_description = ($meta ['description']) ? '<span class="show_description"> ' . stripslashes ( $meta ['description'] ) . '</span>' : '';

                            $the_width = intval ( $meta ['width'] ) - 1 . '%';
                            $the_margin = '1%';

                            $field_label = $meta ['title'] . $show_asterisk;

                            $default_selected = $meta['selected'];

                            $args = array(	'name'			=> $name."_popup",
                                'id'			=> $name."_popup",
                                'data-type'		=> $type,
                                'data-req'		=> $meta['required'],
                                'data-message'	=> $meta['error_message']);

                            echo '<p id="box-'.$name.'" style="width: '. $the_width.'; margin-right: '. $the_margin.';'.$visibility.'" '.$conditions_data.'>';
                            echo '<label for="'.$name.'">'. $field_label.' </label> <br />';

                            $nmpersonalizedproduct -> inputs[$type]	-> render_input($args, $meta['options'], $default_selected);

                            //for validtion message
                            echo '<span class="errors"></span>';
                            echo '</p>';
                        }
                    }
                    //Dropdown for frames ENDS
                    ?>
                    <!--Price info-->
                    <?php
                    $i=0;
                    $sizeVariationsArr = array();
                    //Try
                    foreach($available_variations as $availVar){

                        if($available_variations[$i]['attributes']['attribute_pa_size']=="small")
                        {
                            $sizeVariationsArr['small'] = $available_variations[$i]['price_html'];
                        }
                        else if($available_variations[$i]['attributes']['attribute_pa_size']=="medium")
                        {
                            $sizeVariationsArr['medium'] = $available_variations[$i]['price_html'];
                        }
                        else if($available_variations[$i]['attributes']['attribute_pa_size']=="large")
                        {
                            $sizeVariationsArr['large'] = $available_variations[$i]['price_html'];
                        }
                        $i++;
                    }
                    ?>

                    <script type="text/javascript" language="javascript">
                            <?php foreach($sizeVariationsArr as $key => $val){ ?>
                                    var jsSizeVariationsArr = <?php echo json_encode($sizeVariationsArr); ?>;
                            <?php } ?>
                    </script>

                    </div>
                        <div class="single_variation_wrap" style="display: block;">
                    <div class="single_variation" id="single_variation_popup">
                        <p class="price" id="price_popup"><span class="amount" id="amount_popup"></span></p>
                       <div class="amount-options" id="total_price_popup"><br></div>
                    </div>
                    </div>

                <?php else : ?>
                    <input type="hidden" value="0" id="isVariable"/>
                <?php endif ?>
                
                <!--###################################END VARIATION DROPDOWN12345#####################################-->
			</div>

			<div class="frame-title"></div>

			<div id="tryit-picture">

				<div id="img-holder" class="brown_wood_frame">
					<?php echo get_the_post_thumbnail(); ?>
				</div>

				<div class="frames_holder">
					<ul>
						<li class="brown_wood_frame current" title="Gallery wrap on 1 inch wood"></li>
						<li title="second frame"></li>
						<li title="third frame"></li>
						<li title="fourth frame"></li>
						<li title="fifth frame"></li>
					</ul>
				</div>

			</div>
			<!--<div id="toolbar">
				<a href="#" title="Maximize" onClick="ImageViewMode('full');return false"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/toolbar_fs_icon.png" width="50" height="50"  /></a>
			</div>-->

			<div id="thumbnails_wrapper">
				<div id="info-half">
					<h6>See It In Your Room</h6>
					<div class="current">Currently Trying <span id="img_title"></span></div>
				</div>
				<!--<a href="#" class="nextImageBtnl" title="next"></a>
				<a href="#" class="prevImageBtnl" title="previous"></a>-->
				<div id="outer_container">
					<div class="thumbScroller">
						<div class="container">
					    	<div class="tcontent">
					        	<div><a href="<?php echo get_stylesheet_directory_uri(); ?>/images/Living_room.png"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/Living_room.png" title="Living Room" alt="Living Room" class="thumb" /></a></div>
					        </div>
					        <div class="tcontent">
					        	<div><a href="<?php echo get_stylesheet_directory_uri(); ?>/images/Kitchen.png"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/Kitchen.png" title="Hall Room" alt="Hall Room" class="thumb" /></a></div>
					        </div>
					    	<div class="tcontent">
                                <div><a href="<?php echo get_stylesheet_directory_uri(); ?>/images/Dining.png"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/Dining.png" title="Hall Room" alt="Hall Room" class="thumb" /></a></div>
                            </div>
                            <div class="tcontent">
                                <div><a href="<?php echo get_stylesheet_directory_uri(); ?>/images/Bedroom.png"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/Bedroom.png" title="Hall Room" alt="Hall Room" class="thumb" /></a></div>
                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/big-slide.js"></script>
		<script type="text/javascript">
			function updateBG(color) {
			    var hexColor = "transparent";
			    if(color) {
			        hexColor = color.toHexString();
			    }
			    jQuery("#bg").css("background-color", hexColor);
			}


            //Function for changing the size of the frame and painting based on variation selected

            function displayFrameSize(sel) {
                //alert(sel.value);

                switch(sel.value){
                    case "small":
                        //alert(sel.value);
                        jQuery('#tryit-picture #img-holder').css({'width' : '50%' , 'height' : '46.5%'});
                        jQuery('.bxslider .frameSizer').css({'width' : '50%' , 'height' : '50%'});
                        break;
                    case "medium":
                        //alert(sel.value);
                        jQuery('#tryit-picture #img-holder').css({'width' : '70%' , 'height' : '66.5%'});
                        jQuery('.bxslider .frameSizer').css({'width' : '70%' , 'height' : '70%'});
                        break;
                    case "large":
                        //alert(sel.value);
                        jQuery('#tryit-picture #img-holder').css({'width' : '80%' , 'height' : '76.5%'});
                        jQuery('.bxslider .frameSizer').css({'width' : '80%' , 'height' : '80%'});
                        break;
                    default:
                        //alert("default");
                        jQuery('#tryit-picture #img-holder').css({'width' : '100%' , 'height' : '96.5%'});
                        jQuery('.bxslider .frameSizer').css({'width' : '100%' , 'height' : '100%'});
                }
            }


            jQuery(document).ready(function(){


            	
            	jQuery('.frame-title').html('Gallery wrap on 1 inch wood');
				





                //var mediumVar = jsSizeVariationsArr['medium'];
                //alert(mediumVar);
                //jQuery(".variations #size").val('small');
               /* jQuery('select[name=attribute_size] option:eq(1)').attr('selected', 'selected');
                alert("After setting default select value");*/

                //Do not display "Choose option" for size $("#target").val($("#target option:first")
                var isVariable = jQuery('#isVariable').val();
                if(isVariable ==1)
                {
                    jQuery('#pa_size option:first').hide();
                    jQuery('#pa_size_popup option:first').hide();

                }

				jQuery("#full").spectrum({
				    allowEmpty:true,
				    color: "#E14F4F",
				    className: "full-spectrum sp-dark",
				    showInitial: true,
				    showInput: false,
				    showPalette: true,
				    showSelectionPalette: true,
				    showAlpha: false,
				    maxPaletteSize: 10,
				    preferredFormat: "hex",
				    cancelText: "Cancel",
    				chooseText: "Paint",
				    move: function (color) {
				        updateBG(color);
				    },
				    show: function () {

				    },
				    beforeShow: function () {

				    },
				    hide: function (color) {
				        updateBG(color);
				    },

				    palette: [
				        ["rgb(0, 0, 0)", "rgb(67, 67, 67)", "rgb(102, 102, 102)", /*"rgb(153, 153, 153)","rgb(183, 183, 183)",*/
				        "rgb(204, 204, 204)", "rgb(217, 217, 217)", /*"rgb(239, 239, 239)", "rgb(243, 243, 243)",*/ "rgb(255, 255, 255)"],
				        ["rgb(152, 0, 0)", "rgb(255, 0, 0)", "rgb(255, 153, 0)", "rgb(255, 255, 0)", "rgb(0, 255, 0)",
				        "rgb(0, 255, 255)", "rgb(74, 134, 232)", "rgb(0, 0, 255)", "rgb(153, 0, 255)", "rgb(255, 0, 255)"],
				        ["rgb(230, 184, 175)", "rgb(244, 204, 204)", "rgb(252, 229, 205)", "rgb(255, 242, 204)", "rgb(217, 234, 211)",
				        "rgb(208, 224, 227)", "rgb(201, 218, 248)", "rgb(207, 226, 243)", "rgb(217, 210, 233)", "rgb(234, 209, 220)",
				        "rgb(221, 126, 107)", "rgb(234, 153, 153)", "rgb(249, 203, 156)", "rgb(255, 229, 153)", "rgb(182, 215, 168)",
				        "rgb(162, 196, 201)", "rgb(164, 194, 244)", "rgb(159, 197, 232)", "rgb(180, 167, 214)", "rgb(213, 166, 189)",
				        "rgb(204, 65, 37)", "rgb(224, 102, 102)", "rgb(246, 178, 107)", "rgb(255, 217, 102)", "rgb(147, 196, 125)",
				        "rgb(118, 165, 175)", "rgb(109, 158, 235)", "rgb(111, 168, 220)", "rgb(142, 124, 195)", "rgb(194, 123, 160)",
				        "rgb(166, 28, 0)", "rgb(204, 0, 0)", "rgb(230, 145, 56)", "rgb(241, 194, 50)", "rgb(106, 168, 79)",
				        "rgb(69, 129, 142)", "rgb(60, 120, 216)", "rgb(61, 133, 198)", "rgb(103, 78, 167)", "rgb(166, 77, 121)",
				        /*"rgb(133, 32, 12)", "rgb(153, 0, 0)", "rgb(180, 95, 6)", "rgb(191, 144, 0)", "rgb(56, 118, 29)",
				        "rgb(19, 79, 92)", "rgb(17, 85, 204)", "rgb(11, 83, 148)", "rgb(53, 28, 117)", "rgb(116, 27, 71)",*/
				        "rgb(91, 15, 0)", "rgb(102, 0, 0)", "rgb(120, 63, 4)", "rgb(127, 96, 0)", "rgb(39, 78, 19)",
				        "rgb(12, 52, 61)", "rgb(28, 69, 135)", "rgb(7, 55, 99)", "rgb(32, 18, 77)", "rgb(76, 17, 48)"]
				    ]
				});

				//BX SLider for frames
				slider = jQuery('.bxslider').bxSlider({
					mode: 'horizontal',
					minSlides: 1,
					maxSlides: 1,
					speed: 1000,
                    useCSS: false,
					buildPager: function(slideIndex){
						switch(slideIndex){
						  case 0:
						    return '<div class="frameSizer oneinchwood" title="Gallery wrap on 1 inch wood"></div>';
						  case 1:
						    return '<div class="frameSizer oneinchbrown" title="1 inch brown frame with acrylic and paper border"></div>';
						  case 2:
						    return '<div class="frameSizer onefiveinchbrown" title="1.5 inch brown frame with acrylic and paper border"></div>';
						  case 3:
						    return '<div class="frameSizer onefiveinchwhite" title="1.5 inch white frame with acrylic and paper border"></div>';
						  case 4:
						    return '<div class="frameSizer twoinchblack" title="2 inch black frame with acrylic and paper border"></div>';
						}
					}
				});





				// Orange Box Settings
				oB.settings.contentBorderWidth= 1;
    			oB.settings.fadeControls = true;
    			oB.settings.searchTerm = 'tryitout';
    			oB.settings.addThis = false;

    			jQuery(document).bind('oB_init', function() {

                    var isVariable = jQuery('#isVariable').val();
                    if(isVariable ==1)
                    {
                        //Set price of popup same as the one on main page
                        var price = jQuery(".single_variation .price ins .amount").text();
                        //alert("PRICE "+price);
                        jQuery("#single_variation_popup .price .amount").text(price);

                        //Get main page size dropdown's id
                        var sizeID = jQuery(".variations #pa_size").val();
                        var frame_popup = jQuery(".variations #frames_popup");
                        var frame = jQuery("#frames").val();

                        //Set popups size value same as the one on main page
                        jQuery("#pa_size_popup").val(sizeID);


                        //alert("Size popup value  "+jQuery("#size_popup").val());

                        if(jQuery("#pa_size_popup").val()!="")
                        {
                            //alert("MAIN FRAME VALUE "+frame);
                            jsFunction_popup();
                            //jQuery("#frame_popup option[value=frame]").attr('selected', 'selected');
                            jQuery("#frames_popup").val(frame);

                            //alert("MAIN FRAME VALUE "+frame);

                        }
                        else if (jQuery("#pa_size_popup").val()=="")
                        {
                                //alert("Else part for empty size");
                                //Hiding default frames dropdown
                                //jQuery("#frames_popup").hide();


                                ///Hiding label for frames dropdown
                                var label = document.getElementsByTagName('label');

                                for (var i = 0; i < label.length; i++) {

                                    if(label[i].htmlFor=='frames')
                                    {
                                        label[i].style.display = 'none';
                                    }

                                }
                        }

                    }

    				setTimeout(function() {
    					/*var h = jQuery('#tryit-picture').height();
						jQuery('#frame img').height(h);*/

						// slider.reloadSlider();
    					jQuery(window).trigger('resize');
    				}, 500)

                    if(isVariable ==1)
                    {
                        displayFrameSize(jQuery("#pa_size_popup").val());
                    }
    			});





                jQuery(document).bind('oB_closed',function(){
                    //alert("On close event of popup");
					//var frame_popup = jQuery("#frames_popup").val();
                    
					//alert("Before"+jQuery("#frames_popup").val());
					//alert("Before"+jQuery("#frames").val());
					
					//jQuery("#frames option[value='"+frame_popup+"']").prop("selected", true);


                    //jQuery("#frames option").remove();
                    //jQuery('#frames_popup option').clone().appendTo('#frames');
                    var frame_popup = jQuery("#frames_popup").val();
                    jQuery("#frames option[value='"+frame_popup+"']").prop("selected", true);
					
					//alert("After"+jQuery("#frames_popup").val());
					//alert("After"+jQuery("#frames").val());

                    //Set price of popup same as the one on main page
                    var price = jQuery("#single_variation_popup .price ins .amount").text();
                   // alert(price);

                    jQuery(".single_variation .price .amount").text(price);

                    //Total price same as popup

                    //totalamt = jQuery("#single_variation_popup .amount-options").html();

                    var pricingHTML = '<div class="amount-options">';
                    pricingHTML += jQuery("#single_variation_popup .amount-options").html();
                    pricingHTML += '</div>';
                    //alert("Main page html"+pricingHTML);
                    var $priceElem = jQuery(".single_variation .price").first();

                    //Remove amount-options
                    if(jQuery(".price .amount-options").first().length > 0)
                        jQuery(".price .amount-options").first().remove();

                    $priceElem.append(pricingHTML);
                });

                jQuery('#box-frames select').customSelect({customClass:'mpcthSelect'});

                jQuery('#size-drop').customSelect({customClass:'mpcthSelect'});


                

            });
		</script>
	<?php
}

/* enqueue js and css for jQuery Easing */
wp_enqueue_script( 'jq-easing', '//cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js', array('jquery'), true, true );

/* enqueue js and css for orange box */
wp_enqueue_script( 'orangebox', get_stylesheet_directory_uri() . '/js/orangebox.min.js', array('jquery'), true, true );
wp_enqueue_style( 'orangebox_css', get_stylesheet_directory_uri() . '/css/orangebox.css' );

/* enqueue js and css for colorpicker */
wp_enqueue_script( 'colorpicker2', get_stylesheet_directory_uri() . '/js/spectrum.js', array('jquery'), true, true );
wp_enqueue_style( 'colorpicker2_css', get_stylesheet_directory_uri() . '/css/spectrum.css' );

/* enqueue js and css for BX slider */
wp_enqueue_script( 'bxslider', get_stylesheet_directory_uri() . '/js/jquery.bxslider.min.js', array('jquery'), true, true );
wp_enqueue_style( 'bxslider_css', get_stylesheet_directory_uri() . '/css/jquery.bxslider.css' );



// Function to load theme javascript
function theme_javascript() {
	wp_enqueue_script('product',get_stylesheet_directory_uri().'/js/custom_product.js', array('jquery'), true, true);
    wp_enqueue_script( 'orangebox', get_stylesheet_directory_uri() . '/js/orangebox.min.js', array('jquery'), true, true );
	wp_enqueue_style( 'product_css', get_stylesheet_directory_uri() . '/css/custom_product.css' );
}

add_action('wp_enqueue_scripts','theme_javascript');

// Function to Add Class for Author Page
// Add specific CSS class by filter
add_filter('body_class','vital_class_name');
function vital_class_name($classes) {
	// add 'woocommerce' to the $classes array
	$classes[] = 'woocommerce';
	// return the $classes array
	return $classes;
}

// From price
add_filter( 'woocommerce_variable_sale_price_html', 'wc_wc20_variation_price_format', 10, 2 );
add_filter( 'woocommerce_variable_price_html', 'wc_wc20_variation_price_format', 10, 2 );
function wc_wc20_variation_price_format( $price, $product ) {
    // Main Price
    $prices = array( $product->get_variation_price( 'min', true ), $product->get_variation_price( 'max', true ) );
    $price = $prices[0] !== $prices[1] ? sprintf( __( '<span class="mpcth-from-price">From</span> %1$s', 'woocommerce' ), wc_price( $prices[0] ) ) : wc_price( $prices[0] );
    // Sale Price
    $prices = array( $product->get_variation_regular_price( 'min', true ), $product->get_variation_regular_price( 'max', true ) );
    sort( $prices );
    $saleprice = $prices[0] !== $prices[1] ? sprintf( __( '<span class="mpcth-from-price">From</span> %1$s', 'woocommerce' ), wc_price( $prices[0] ) ) : wc_price( $prices[0] );
 
    if ( $price !== $saleprice ) {
        $price = '<del>' . $saleprice . '</del> <ins>' . $price . '</ins>';
    }
    return $price;
}



