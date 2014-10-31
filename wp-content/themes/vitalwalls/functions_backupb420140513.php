<?php 

// Add Author Field to WooCommerce Products
add_action('init', 'vitalwalls_add_author_woocommerce', 999 );

function vitalwalls_add_author_woocommerce() {
    add_post_type_support( 'product', 'author' );
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
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/sofa.png" width="1680" height="1050" alt="Living Room" title="Living Room" id="bgimg" />
			</div>
			<div id="preloader"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ajax-loader_dark.gif" width="32" height="32" /></div>
			
			<div id="color-selector">
				Paint Colour: <input type='text' id="full" />
                <input type="hidden" value="-1" id="selectedSizeAttribPrice"/>
                <br/> <br/>
                <!--###################################BEGIN VARIATION DROPDOWN#####################################-->
                <?php //If product is variable then only check for the variations of the product ?>
                <?php if ( $product->product_type == 'variable' ) : ?>
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

                            $show_asterisk = ($meta ['required']) ? '<span class="show_required"> *</span>' : '';
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

                    <div class="single_variation_wrap" style="display: block;">
                    <div class="single_variation">
                        <p class="price" id="price_popup"><span class="amount" id="amount_popup">₹&nbsp;111.00</span></p>
                        Total price:<div class="amount-options" id="total_price_popup"><br></div>
                    </div>
                    </div>

                <?php else : ?>
                    <!--div class="varDDwn2"></div-->
                <?php endif ?>
                </div>
                <!--###################################END VARIATION DROPDOWN12345#####################################-->
			</div>

			<div id="tryit-picture">
				<div id="frame">
					<ul class="bxslider">
					  <li>
					  	<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/Wooden_Frame.png" class="frameSizer"/>
					  </li>
					  <li>
					  	<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/Wooden_Frame.png" class="frameSizer"/>
					  </li>
					  <li>
					  	<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/Wooden_Frame.png" class="frameSizer"/>
					  </li>
					</ul>
				</div>
				<div id="img-holder">
					<?php echo get_the_post_thumbnail(); ?>
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
					        	<div><a href="<?php echo get_stylesheet_directory_uri(); ?>/images/sofa.png"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/white-couch-th.png" title="Living Room" alt="Living Room" class="thumb" /></a></div>
					        </div>
					        <div class="tcontent">
					        	<div><a href="<?php echo get_stylesheet_directory_uri(); ?>/images/white-couch-hi.png"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/white-couch-th.png" title="Hall Room" alt="Hall Room" class="thumb" /></a></div>
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
                        jQuery('#tryit-picture #img-holder').css({'width' : '50%' , 'height' : '50%'});
                        jQuery('.bxslider .frameSizer').css({'width' : '50%' , 'height' : '50%'});
                        break;
                    case "medium":
                        //alert(sel.value);
                        jQuery('#tryit-picture #img-holder').css({'width' : '70%' , 'height' : '70%'});
                        jQuery('.bxslider .frameSizer').css({'width' : '70%' , 'height' : '70%'});
                        break;
                    case "large":
                        //alert(sel.value);
                        jQuery('#tryit-picture #img-holder').css({'width' : '80%' , 'height' : '80%'});
                        jQuery('.bxslider .frameSizer').css({'width' : '80%' , 'height' : '80%'});
                        break;
                    default:
                        //alert("default");
                        jQuery('#tryit-picture #img-holder').css({'width' : '100%' , 'height' : '100%'});
                        jQuery('.bxslider .frameSizer').css({'width' : '100%' , 'height' : '100%'});
                }
            }


            jQuery(document).ready(function(){


                //jQuery(".variations #size").val('small');
               /* jQuery('select[name=attribute_size] option:eq(1)').attr('selected', 'selected');
                alert("After setting default select value");*/

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
					buildPager: function(slideIndex){
						switch(slideIndex){
						  case 0:
						    return '<img src="http://vitalwalls.com/wp-content/themes/vitalwalls/images/Wooden_Frame.png" class="frameSizer">';
						  case 1:
						    return '<img src="http://vitalwalls.com/wp-content/themes/vitalwalls/images/Wooden_Frame.png" class="frameSizer">';
						  case 2:
						    return '<img src="http://vitalwalls.com/wp-content/themes/vitalwalls/images/Wooden_Frame.png" class="frameSizer">';
						}
					}
				});

				
				// Orange Box Settings
				oB.settings.contentBorderWidth= 1;
    			oB.settings.fadeControls = true;
    			oB.settings.searchTerm = 'tryitout';

    			jQuery(document).bind('oB_init', function() {

                    alert(document.getElementById('selectedSizeAttribPrice').value);

                    var price = jQuery(".nm-productmeta-box .single_variation .price").text();
                    document.getElementById('selectedSizeAttribPrice').value = price ;

                    alert(document.getElementById('selectedSizeAttribPrice').value);

                    //Get main page size dropdown's id
                    var sizeID = jQuery(".variations #size").val();
                    var frame_popup = jQuery(".variations #frames_popup");
                    var frame = jQuery("#frames").val();

                    //Set popups size value same as the one on main page
                    jQuery("#size_popup").val(sizeID);


                    //alert("Size popup value  "+jQuery("#size_popup").val());

                    if(jQuery("#size_popup").val()!="")
                    {
                        alert("MAIN FRAME VALUE "+frame);
                        jsFunction_popup();
                        //jQuery("#frame_popup option[value=frame]").attr('selected', 'selected');
                        jQuery("#frames_popup").val(frame);

                        alert("MAIN FRAME VALUE "+frame);

                    }
                    else if (jQuery("#size_popup").val()=="")
                    {
                            //alert("Else part for empty size");
                            //Hiding default frames dropdown
                            jQuery("#frames_popup").hide();


                            ///Hiding label for frames dropdown
                            var label = document.getElementsByTagName('label');

                            for (var i = 0; i < label.length; i++) {

                                if(label[i].htmlFor=='frames')
                                {
                                    label[i].style.display = 'none';
                                }

                            }
                    }

    				setTimeout(function() {
    					/*var h = jQuery('#tryit-picture').height();
						jQuery('#frame img').height(h);*/

						slider.reloadSlider();
    					jQuery(window).trigger('resize');
    				}, 500)

                    displayFrameSize(jQuery("#size_popup").val());
    			});

                /*jQuery(document).bind('oB_closed',function(){
                    var frame_popup = jQuery("#frames_popup").val();
                    jQuery("#frames option[value='"+frame_popup+"']").attr("selected", "selected");
                });*/
            });
		</script>
	<?php
}

/* enqueue js and css for orange box */
wp_enqueue_script( 'orangebox', get_stylesheet_directory_uri() . '/js/orangebox.min.js', array('jquery'), true, true );
wp_enqueue_style( 'orangebox_css', get_stylesheet_directory_uri() . '/css/orangebox.css' );

/* enqueue js and css for colorpicker */
wp_enqueue_script( 'colorpicker2', get_stylesheet_directory_uri() . '/js/spectrum.js', array('jquery'), true, true );
wp_enqueue_style( 'colorpicker2_css', get_stylesheet_directory_uri() . '/css/spectrum.css' );

/* enqueue js and css for BX slider */
wp_enqueue_script( 'bxslider', get_stylesheet_directory_uri() . '/js/jquery.bxslider.min.js', array('jquery'), true, true );
wp_enqueue_style( 'bxslider_css', get_stylesheet_directory_uri() . '/css/jquery.bxslider.css' );

// Remove Reviews Tab
add_filter( 'woocommerce_product_tabs', 'sb_woo_remove_reviews_tab', 98);
function sb_woo_remove_reviews_tab($tabs) {

 unset($tabs['reviews']);

 return $tabs;
}

// Add Facebook Like to Single Social
/* enqueue js for custom like */
wp_enqueue_script( 'custom_like', get_stylesheet_directory_uri() . '/js/jquery.fancylike.js', array('jquery'), true, true );

/* add plugin js to single product */
add_action('woocommerce_single_product_summary', 'vitalwalls_like_product', 99 );

function vitalwalls_like_product() {
	echo '<script>jQuery(document).ready(function(){ jQuery(".button_facebook_like").fancylike(); });</script>';
}

/* social share links */
function vital_socialLinkSingle() {
	global $pmc_data; 
	$social = '';
	$social ='<div class="addthis_toolbox"><div class="custom_images">';
	$social .= '<a class="button_facebook_like"></a>'; 
	$social .= '<a class="addthis_button_facebook" ></a>';            
	$social .= '<a class="addthis_button_twitter" ></a>';  
	$social .= '<a class="addthis_button_email" ></a>'; 
	$social .='<a class="addthis_button_more"></a></div><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4f3049381724ac5b"></script>';	
	$social .= '</div>'; 
	//$social .= '';
	echo $social;
}

// Function to load theme javascript
function theme_javascript() {
	wp_enqueue_script('product',get_stylesheet_directory_uri().'/js/custom_product.js', array('jquery'), true, true);
    wp_enqueue_script( 'orangebox', get_stylesheet_directory_uri() . '/js/orangebox.min.js', array('jquery'), true, true );
	//wp_enqueue_script('product_upload',get_stylesheet_directory_uri().'/js/custom_upload.js', array('jquery'), true, true);
	wp_enqueue_style( 'product_css', get_stylesheet_directory_uri() . '/css/custom_product.css' );
}

add_action('wp_enqueue_scripts','theme_javascript');

/**** Change Social Position ****/
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);

add_action('vital_single_sharer', 'woocommerce_template_single_sharing', 10);