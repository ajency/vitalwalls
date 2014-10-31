<?php 

// Add Author Field to WooCommerce Products
add_action('init', 'vitalwalls_add_author_woocommerce', 999 );

function vitalwalls_add_author_woocommerce() {
    add_post_type_support( 'product', 'author' );
}

// Add Tryit Link to WooCommerce Products
add_action('woocommerce_single_product_summary', 'vitalwalls_add_tryit_link', 6 );

function vitalwalls_add_tryit_link() {
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
			</div>
			<div id="tryit-picture">
				<div id="frame">
					<ul class="bxslider">
					  <li>
					  	<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/Wooden_Frame.png" />
					  </li>
					  <li>
					  	<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/Wooden_Frame.png" />
					  </li>
					  <li>
					  	<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/Wooden_Frame.png" />
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
			jQuery(document).ready(function(){
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
						    return '<img src="http://vitalwalls.com/wp-content/themes/vitalwalls/images/Wooden_Frame.png">';
						  case 1:
						    return '<img src="http://vitalwalls.com/wp-content/themes/vitalwalls/images/Wooden_Frame.png">';
						  case 2:
						    return '<img src="http://vitalwalls.com/wp-content/themes/vitalwalls/images/Wooden_Frame.png">';
						}
					}
				});

				
				// Orange Box Settings
				oB.settings.contentBorderWidth= 1;
    			oB.settings.fadeControls = true;
    			oB.settings.searchTerm = 'tryitout';

    			jQuery(document).bind('oB_init', function() {
    				setTimeout(function() { 
    					var h = jQuery('#tryit-picture').height();
						jQuery('#frame img').height(h);

						slider.reloadSlider(); 
    					jQuery(window).trigger('resize');
    				}, 500)
    			});
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

add_action('wp_enqueue_scripts','theme_javascript');
 
 
// Function to load theme javascript
function theme_javascript() {
 
	echo get_stylesheet_directory_uri()."aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";
	wp_enqueue_script('product',get_stylesheet_directory_uri().'/js/custom_product.js', array('jquery'), true, true);
 wp_enqueue_script( 'orangebox', get_stylesheet_directory_uri() . '/js/orangebox.min.js', array('jquery'), true, true );
}