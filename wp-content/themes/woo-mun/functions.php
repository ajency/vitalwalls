<?php

add_action( 'after_setup_theme', 'pmc_westy_theme_setup' );

function pmc_westy_theme_setup() {

	/*woocommerce support*/
	add_theme_support('woocommerce'); // so they don't advertise their themes :)

	/*post formats support*/
	add_theme_support( 'post-formats', array( 'link', 'gallery', 'video' , 'audio') );

	/*feed support*/
	add_theme_support( 'automatic-feed-links' );

	/*post thumb support*/
	add_theme_support( 'post-thumbnails' ); // this enable thumbnails and stuffs

	/*setting thumb size*/
	add_image_size( 'gallery', 95,95, true );
	add_image_size( 'port2',230,150, true );
	add_image_size( 'advertise', 235,130, true );
	add_image_size( 'homeProduct', 280 ,240, true );
	add_image_size( 'homePort', 380 ,340, true );
	add_image_size( 'shop', 280 ,240, true );
	add_image_size( 'shop-sidebar', 272 ,240, true );
	add_image_size( 'widget', 255,140, true );
	add_image_size( 'postBlock', 375,170, true );
	add_image_size( 'productBig', 720,600, true );
	add_image_size( 'productSmall', 132,113, true );
	add_image_size( 'blog', 800, 390, true );
	add_image_size( 'port3', 380,340, true );
	add_image_size( 'port4', 270,230, true );
	add_image_size( 'related', 180,90, true );
	add_image_size( 'homepost', 1180,490, true );

	/*register custom menus*/
	register_nav_menus(array(

        'main-menu' => 'Main Menu',
		
		'top_menu' => 'Top Menu',	

		'resp_menu' => 'Responsive Menu',		
		
		'scroll_menu' => 'Scroll Menu'			
			
	));
	
   register_sidebar(array(
        'id' => 'sidebar',
        'name' => 'Sidebar Widget',
        'before_widget' => '<div class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3><div class="widget-line"></div>'
    ));		    		

	register_sidebar(array(        		
		'id' => 'sidebar_category',
		'name' => 'Sidebar Category Widget',
		'before_widget' => '<div class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3><div class="widget-line"></div>'
		));

	register_sidebar(array(
		'id' => 'sidebar_category_top',
		'name' => 'Full width Shop Top Widget',
		'before_widget' => '<div class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
		));	
		
    register_sidebar(array(
        'id' => 'homepost',
        'name' => 'Home post Widget',
        'before_widget' => '<div class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3><div class="widget-line"></div>'
    ));		 

    register_sidebar(array(
        'id' => 'contact',
        'name' => 'Contact Widget',
        'before_widget' => '<div class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3><div class="widget-line"></div>'
    ));

    
    register_sidebar(array(
        'id' => 'footer1',
        'name' => 'Footer Widget 1',
        'before_widget' => '<div class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
    
    register_sidebar(array(
        'id' => 'footer2',
        'name' => 'Footer Widget 2',
        'before_widget' => '<div class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
	
    register_sidebar(array(
        'id' => 'footer3',
        'name' => 'Footer Widget 3',
        'before_widget' => '<div class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
    
    register_sidebar(array(
        'id' => 'footer4',
        'name' => 'Footer Widget 4',
        'before_widget' => '<div class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));	
	
    register_sidebar(array(
        'id' => 'search',
        'name' => 'Top bar search',
        'before_widget' => '<div class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));	
	
    register_sidebar(array(
        'id' => 'footer_bottom',
        'name' => 'Bottom footer widget',
        'before_widget' => '<div class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '',
        'after_title' => ''
    ));		

    register_sidebar(array(
        'id' => 'bottom_support_tab',
        'name' => 'Bottom Support Tab',
        'before_widget' => '<div class="support-widget"><i class="fa fa-chevron-down"></i>',
        'after_widget' => '</div></div>',
        'before_title' => '<h3>',
        'after_title' => '<i class="fa fa-chevron-up"></i></h3><div class="support-content">'
    ));		
	
	
	
	// Responsive walker menu
		class Walker_Responsive_Menu extends Walker_Nav_Menu {
			function start_lvl(&$output, $depth){
			  $indent = str_repeat("\t", $depth); // don't output children opening tag (`<ul>`)
			}

			function end_lvl(&$output, $depth){
			  $indent = str_repeat("\t", $depth); // don't output children closing tag
			}
			
			function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
				global $wp_query;		
				$item_output = $attributes = $prepend ='';
				// Create a visual indent in the list if we have a child item.
				$visual_indent = ( $depth ) ? str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-circle"></i>', $depth) : '';

				// Load the item URL
				$attributes .= ! empty( $item->url ) ? ' href="'   . esc_attr( $item->url ) .'"' : '';

				// If we have hierarchy for the item, add the indent, if not, leave it out.
				// Loop through and output each menu item as this.
				if($depth != 0) {
					$item_output .= '<a ' . $attributes .'>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-circle"></i>' . $item->title. '</a><br>';
				} else {
					$item_output .= '<a ' . $attributes .'>'.$prepend.$item->title.'</a><br>';
				}


				// Make the output happen.
				$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
			}
		}


	// Main walker menu	
	class description_walker extends Walker_Nav_Menu
	{
		  function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
			   global $wp_query;
			   $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
			   $class_names = $value = '';
			   $classes = empty( $item->classes ) ? array() : (array) $item->classes;
			   $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
			   $class_names = ' class="'. esc_attr( $class_names ) . '"';
			   $output .= $indent . '<li id="menu-item-'.rand(0,9999).'-'. $item->ID . '"' . $value . $class_names .'>';
			   $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
			   $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
			   $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
			   $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
			   $prepend = '<strong>';
			   $append = '</strong>';
			   if($depth != 0)
			   {
					$append = $prepend = "";
			   }
				$item_output = $args->before;
				$item_output .= '<a'. $attributes .'>';
				$item_output .= $args->link_before .$prepend.apply_filters( 'the_title', $item->title, $item->ID ).$append;
				$item_output .= $args->link_after;
				$item_output .= '</a>';	
				$item_output .= $args->after;
				$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	}

}



/*-----------------------------------------------------------------------------------*/
// Options Framework
/*-----------------------------------------------------------------------------------*/


// Paths to admin functions
define('MY_TEXTDOMAIN', 'wp-munditia');
load_theme_textdomain( 'wp-munditia', get_template_directory() . '/languages' );
load_theme_textdomain( 'woocommerce', get_template_directory() . '/languages' );
define('ADMIN_PATH', get_stylesheet_directory() . '/admin/');
define('BOX_PATH', get_stylesheet_directory() . '/includes/boxes/');
define('ADMIN_DIR', get_template_directory_uri() . '/admin/');
define('LAYOUT_PATH', ADMIN_PATH . '/layouts/');

// You can mess with these 2 if you wish.
$themedata = wp_get_theme(get_stylesheet_directory() . '/style.css');
define('THEMENAME', $themedata['Name']);
define('OPTIONS', 'of_options_munditia_pmc'); // Name of the database row where your options are stored

if (is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php" ) {
	//Call action that sets
	add_action('admin_head','pmc_options');
}

/* import theme options */
function pmc_options()	{


		
	if (!get_option('of_options_munditia_pmc')){
	
		$pmc_data = 'YTo5MTp7czoxNDoic2hvd3Jlc3BvbnNpdmUiO3M6MToiMSI7czo5OiJwb3J0X3NsdWciO3M6OToicG9ydGZvbGlvIjtzOjE4OiJob21lX3JlY2VudF9udW1iZXIiO3M6MjoiMTIiO3M6MjY6ImhvbWVfcmVjZW50X251bWJlcl9kaXNwbGF5IjtzOjE6IjMiO3M6MTA6ImNhdHdvb3R5cGUiO3M6MToiMyI7czo4OiJ3b29fem9vbSI7czoxOiIxIjtzOjI3OiJob21lX3JlY2VudF9wcm9kdWN0c19udW1iZXIiO3M6MjoiMTIiO3M6MzQ6ImhvbWVfcmVjZW50X251bWJlcl9kaXNwbGF5X3Byb2R1Y3QiO3M6MTY6IlNlbGVjdCBhIG51bWJlcjoiO3M6Mjg6ImhvbWVfcmVjZW50X3Byb2R1Y3RzRl9udW1iZXIiO3M6MjoiMTIiO3M6MzU6ImhvbWVfcmVjZW50X251bWJlcl9kaXNwbGF5X2Zwcm9kdWN0IjtzOjE2OiJTZWxlY3QgYSBudW1iZXI6IjtzOjE2OiJ0cmFuc2xhdGlvbl9jYXJ0IjtzOjU6Ikl0ZW1zIjtzOjI1OiJ0cmFuc2xhdGlvbl9zaGFyZV9wcm9kdWN0IjtzOjI0OiJTaGFyZSB0aGlzIHByb2R1Y3QgdGl0bGUiO3M6MjE6InRyYW5zbGF0aW9uX2Fsc29fbGlrZSI7czoxOToiWW91IG1pZ2h0IGFsc28gbGlrZSI7czoyNjoidHJhbnNsYXRpb25fbG9naW5fcmVnaXN0ZXIiO3M6MTY6IkxvZ2luIC8gUmVnaXN0ZXIiO3M6MjA6InRyYW5zbGF0aW9uX2ZlYXR1cmVkIjtzOjE3OiJGZWF0dXJlZCBQcm9kdWN0cyI7czozMjoidHJhbnNsYXRpb25fcmVjZW50X3BydWR1Y3RfdGl0bGUiO3M6MTI6Ik5ldyBBcnJpdmFscyI7czoyMDoidHJhbnNsYXRpb25fbW9yZWxpbmsiO3M6MjE6IlJlYWQgbW9yZSBmb3IgcHJvZHVjdCI7czoxNjoicHJvZHVjdF9jYXRfcGFnZSI7czoyOiIxMiI7czo5OiJxdW90ZV9iaWciO3M6NTA6IuKAnEEgQ2xhc3N5IFRoZW1lIGZvciBhIHBlcmZlY3QgV29yZHByZXNzIFN0b3Jl4oCdIjtzOjExOiJxdW90ZV9zbWFsbCI7czoxNjoiLSBIYXBweSBDdXN0b21lciI7czoxNjoidG9wX25vdGlmaWNhdGlvbiI7czo2OToiSU4gQ0FTRSBPRiBBTlkgUVVFU1RJT05TLCBDQUxMIFRISVMgTlVNQkVSOiA8c3Bhbj4rNTY1IDk3NSA2NTg8L3NwYW4+IjtzOjE0OiJhZHZlcnRpc2VpbWFnZSI7YTo2OntpOjE7YTo0OntzOjU6Im9yZGVyIjtzOjE6IjEiO3M6NToidGl0bGUiO3M6OToiU3BvbnNvciAxIjtzOjM6InVybCI7czo4NDoiaHR0cDovL211bmRpdGlhLnByZW1pdW1jb2RpbmcuY29tL3dwLWNvbnRlbnQvdXBsb2Fkcy8yMDEzLzA4L3Nwb25zb3ItcGxhY2Vob2xkZXIucG5nIjtzOjQ6ImxpbmsiO3M6MjQ6Imh0dHA6Ly9wcmVtaXVtY29kaW5nLmNvbSI7fWk6MjthOjQ6e3M6NToib3JkZXIiO3M6MToiMiI7czo1OiJ0aXRsZSI7czo5OiJTcG9uc29yIDYiO3M6MzoidXJsIjtzOjg0OiJodHRwOi8vbXVuZGl0aWEucHJlbWl1bWNvZGluZy5jb20vd3AtY29udGVudC91cGxvYWRzLzIwMTMvMDgvc3BvbnNvci1wbGFjZWhvbGRlci5wbmciO3M6NDoibGluayI7czoyNDoiaHR0cDovL3ByZW1pdW1jb2RpbmcuY29tIjt9aTozO2E6NDp7czo1OiJvcmRlciI7czoxOiIzIjtzOjU6InRpdGxlIjtzOjk6IlNwb25zb3IgNCI7czozOiJ1cmwiO3M6ODQ6Imh0dHA6Ly9tdW5kaXRpYS5wcmVtaXVtY29kaW5nLmNvbS93cC1jb250ZW50L3VwbG9hZHMvMjAxMy8wOC9zcG9uc29yLXBsYWNlaG9sZGVyLnBuZyI7czo0OiJsaW5rIjtzOjI0OiJodHRwOi8vcHJlbWl1bWNvZGluZy5jb20iO31pOjQ7YTo0OntzOjU6Im9yZGVyIjtzOjE6IjQiO3M6NToidGl0bGUiO3M6OToiU3BvbnNvciAyIjtzOjM6InVybCI7czo4NDoiaHR0cDovL211bmRpdGlhLnByZW1pdW1jb2RpbmcuY29tL3dwLWNvbnRlbnQvdXBsb2Fkcy8yMDEzLzA4L3Nwb25zb3ItcGxhY2Vob2xkZXIucG5nIjtzOjQ6ImxpbmsiO3M6MjQ6Imh0dHA6Ly9wcmVtaXVtY29kaW5nLmNvbSI7fWk6NTthOjQ6e3M6NToib3JkZXIiO3M6MToiNSI7czo1OiJ0aXRsZSI7czo5OiJTcG9uc29yIDMiO3M6MzoidXJsIjtzOjg0OiJodHRwOi8vbXVuZGl0aWEucHJlbWl1bWNvZGluZy5jb20vd3AtY29udGVudC91cGxvYWRzLzIwMTMvMDgvc3BvbnNvci1wbGFjZWhvbGRlci5wbmciO3M6NDoibGluayI7czoyNDoiaHR0cDovL3ByZW1pdW1jb2RpbmcuY29tIjt9aTo2O2E6NDp7czo1OiJvcmRlciI7czoxOiI2IjtzOjU6InRpdGxlIjtzOjk6IlNwb25zb3IgNSI7czozOiJ1cmwiO3M6ODQ6Imh0dHA6Ly9tdW5kaXRpYS5wcmVtaXVtY29kaW5nLmNvbS93cC1jb250ZW50L3VwbG9hZHMvMjAxMy8wOC9zcG9uc29yLXBsYWNlaG9sZGVyLnBuZyI7czo0OiJsaW5rIjtzOjI0OiJodHRwOi8vcHJlbWl1bWNvZGluZy5jb20iO319czoxMjoic2hvd19zdXBwb3J0IjtzOjE6IjEiO3M6NDoibG9nbyI7czo3ODoiaHR0cDovL211bmRpdGlhLnByZW1pdW1jb2RpbmcuY29tL3dwLWNvbnRlbnQvdXBsb2Fkcy8yMDE0LzAxL211bmRpdGlhLWxvZ28ucG5nIjtzOjc6ImZhdmljb24iO3M6NzU6Imh0dHA6Ly9tdW5kaXRpYS5wcmVtaXVtY29kaW5nLmNvbS93cC1jb250ZW50L3VwbG9hZHMvMjAxNC8wMS9mYXZpY29uLTMyLnBuZyI7czoxNjoiZ29vZ2xlX2FuYWx5dGljcyI7czowOiIiO3M6OToibWFpbkNvbG9yIjtzOjc6IiNlMTRmNGYiO3M6MTQ6ImdyYWRpZW50X2NvbG9yIjtzOjc6IiNGNUY2RjEiO3M6MjE6ImdyYWRpZW50X2JvcmRlcl9jb2xvciI7czo3OiIjRjJGMkYwIjtzOjg6ImJveENvbG9yIjtzOjc6IiNmZmZmZmYiO3M6MTU6IlNoYWRvd0NvbG9yRm9udCI7czo3OiIjMDAwMDAwIjtzOjIzOiJTaGFkb3dPcGFjaXR0eUNvbG9yRm9udCI7czoxOiIwIjtzOjIxOiJib2R5X2JhY2tncm91bmRfY29sb3IiO3M6NDoiI2ZmZiI7czoxNjoiaW1hZ2VfYmFja2dyb3VuZCI7czo3NjoiaHR0cDovL211bmRpdGlhLnByZW1pdW1jb2RpbmcuY29tL3dwLWNvbnRlbnQvdXBsb2Fkcy8yMDE0LzAxL3NsaWRlc2hvdy0yLmpwZyI7czoyMzoiaGVhZGVyX2JhY2tncm91bmRfY29sb3IiO3M6NzoiI2ZmZmZmZiI7czoxMjoiY3VzdG9tX3N0eWxlIjtzOjA6IiI7czo5OiJib2R5X2ZvbnQiO2E6Mzp7czo0OiJzaXplIjtzOjQ6IjE2cHgiO3M6NToiY29sb3IiO3M6NzoiIzU5NTk1OSI7czo0OiJmYWNlIjtzOjY6IlJvYm90byI7fXM6MTI6ImhlYWRpbmdfZm9udCI7YToyOntzOjQ6ImZhY2UiO3M6MTM6IlJvYm90byUyMFNsYWIiO3M6NToic3R5bGUiO3M6Njoibm9ybWFsIjt9czo5OiJtZW51X2ZvbnQiO3M6MTM6IlJvYm90byUyMFNsYWIiO3M6MTA6Im1lbnVfY29sb3IiO3M6NzoiIzEyMTIxMiI7czoxNDoiYm9keV9ib3hfY29sZXIiO3M6NzoiI2ZmZmZmZiI7czoxNToiYm9keV9saW5rX2NvbGVyIjtzOjc6IiMxMjEyMTIiO3M6MTU6ImhlYWRpbmdfZm9udF9oMSI7YToyOntzOjQ6InNpemUiO3M6NDoiMzZweCI7czo1OiJjb2xvciI7czo3OiIjMTIxMjEyIjt9czoxNToiaGVhZGluZ19mb250X2gyIjthOjI6e3M6NDoic2l6ZSI7czo0OiIzMHB4IjtzOjU6ImNvbG9yIjtzOjc6IiMxMjEyMTIiO31zOjE1OiJoZWFkaW5nX2ZvbnRfaDMiO2E6Mjp7czo0OiJzaXplIjtzOjQ6IjI0cHgiO3M6NToiY29sb3IiO3M6NzoiIzEyMTIxMiI7fXM6MTU6ImhlYWRpbmdfZm9udF9oNCI7YToyOntzOjQ6InNpemUiO3M6NDoiMThweCI7czo1OiJjb2xvciI7czo3OiIjMTIxMjEyIjt9czoxNToiaGVhZGluZ19mb250X2g1IjthOjI6e3M6NDoic2l6ZSI7czo0OiIxN3B4IjtzOjU6ImNvbG9yIjtzOjc6IiMxMjEyMTIiO31zOjE1OiJoZWFkaW5nX2ZvbnRfaDYiO2E6Mjp7czo0OiJzaXplIjtzOjQ6IjE2cHgiO3M6NToiY29sb3IiO3M6NzoiIzEyMTIxMiI7fXM6MTE6InNvY2lhbGljb25zIjthOjU6e2k6MTthOjU6e3M6NToib3JkZXIiO3M6MToiMSI7czo1OiJ0aXRsZSI7czoyMjoiUHJlbWl1bUNvZGluZyBGYWNlYm9vayI7czo1OiJjbGFzcyI7czozOiJ0b3AiO3M6MzoidXJsIjtzOjg1OiJodHRwOi8vbXVuZGl0aWEucHJlbWl1bWNvZGluZy5jb20vd3AtY29udGVudC91cGxvYWRzLzIwMTQvMDEvc29jaWFsLWljb24tZmFjZWJvb2sucG5nIjtzOjQ6ImxpbmsiO3M6Mzg6Imh0dHBzOi8vd3d3LmZhY2Vib29rLmNvbS9QcmVtaXVtQ29kaW5nIjt9aToyO2E6NTp7czo1OiJvcmRlciI7czoxOiIyIjtzOjU6InRpdGxlIjtzOjIxOiJQcmVtaXVtQ29kaW5nIFR3aXR0ZXIiO3M6NToiY2xhc3MiO3M6MzoidG9wIjtzOjM6InVybCI7czo4NDoiaHR0cDovL211bmRpdGlhLnByZW1pdW1jb2RpbmcuY29tL3dwLWNvbnRlbnQvdXBsb2Fkcy8yMDE0LzAxL3NvY2lhbC1pY29uLXR3aXR0ZXIucG5nIjtzOjQ6ImxpbmsiO3M6MzM6Imh0dHBzOi8vdHdpdHRlci5jb20vcHJlbWl1bWNvZGluZyI7fWk6MzthOjU6e3M6NToib3JkZXIiO3M6MToiMyI7czo1OiJ0aXRsZSI7czoyMzoiUHJlbWl1bUNvZGluZyBQaW50ZXJlc3QiO3M6NToiY2xhc3MiO3M6MzoidG9wIjtzOjM6InVybCI7czo4NjoiaHR0cDovL211bmRpdGlhLnByZW1pdW1jb2RpbmcuY29tL3dwLWNvbnRlbnQvdXBsb2Fkcy8yMDE0LzAxL3NvY2lhbC1pY29uLXBpbnRlcmVzdC5wbmciO3M6NDoibGluayI7czozMzoiaHR0cDovL3d3dy5waW50ZXJlc3QuY29tL2dsaml2ZWMvIjt9aTo0O2E6NTp7czo1OiJvcmRlciI7czoxOiI0IjtzOjU6InRpdGxlIjtzOjIyOiJQcmVtaXVtQ29kaW5nIERyaWJiYmxlIjtzOjU6ImNsYXNzIjtzOjM6InRvcCI7czozOiJ1cmwiO3M6ODQ6Imh0dHA6Ly9tdW5kaXRpYS5wcmVtaXVtY29kaW5nLmNvbS93cC1jb250ZW50L3VwbG9hZHMvMjAxNC8wMS9zb2NpYWwtaWNvbi1kcmliYmJsLnBuZyI7czo0OiJsaW5rIjtzOjI3OiJodHRwOi8vZHJpYmJibGUuY29tL2dsaml2ZWMiO31pOjU7YTo1OntzOjU6Im9yZGVyIjtzOjE6IjUiO3M6NToidGl0bGUiO3M6MTk6IlByZW1pdW1Db2RpbmcgRW1haWwiO3M6NToiY2xhc3MiO3M6MzoidG9wIjtzOjM6InVybCI7czo4MjoiaHR0cDovL211bmRpdGlhLnByZW1pdW1jb2RpbmcuY29tL3dwLWNvbnRlbnQvdXBsb2Fkcy8yMDE0LzAxL3NvY2lhbC1pY29uLWVtYWlsLnBuZyI7czo0OiJsaW5rIjtzOjI5OiJtYWlsdG86aW5mb0BwcmVtaXVtY29kaW5nLmNvbSI7fX1zOjE0OiJlcnJvcnBhZ2V0aXRsZSI7czoxMDoiT09PUFMhIDQwNCI7czoxNzoiZXJyb3JwYWdlc3VidGl0bGUiO3M6NjU6IlNlZW1zIGxpa2UgeW91IHN0dW1ibGVkIGF0IHNvbWV0aGluZyB0aGF0IGRvZXNuXFxcJ3QgcmVhbGx5IGV4aXN0IjtzOjk6ImVycm9ycGFnZSI7czozMjY6IlNvcnJ5LCBidXQgdGhlIHBhZ2UgeW91IGFyZSBsb29raW5nIGZvciBoYXMgbm90IGJlZW4gZm91bmQuPGJyLz5UcnkgY2hlY2tpbmcgdGhlIFVSTCBmb3IgZXJyb3JzLCB0aGVuIGhpdCByZWZyZXNoLjwvYnI+T3IgeW91IGNhbiBzaW1wbHkgY2xpY2sgdGhlIGljb24gYmVsb3cgYW5kIGdvIGhvbWU6KQ0KPGJyPjxicj4NCjxhIGhyZWYgPSBcImh0dHA6Ly9idWxsc3kucHJlbWl1bWNvZGluZy5jb20vXCI+PGltZyBzcmMgPSBcImh0dHA6Ly9idWxsc3kucHJlbWl1bWNvZGluZy5jb20vd3AtY29udGVudC91cGxvYWRzLzIwMTMvMDgvaG9tZUhvdXNlSWNvbi5wbmdcIj48L2E+IjtzOjk6ImNvcHlyaWdodCI7czoxMDQ6IkJ1bGxzeSBAMjAxMyBEZXNpZ25lZCBieSA8YSBocmVmID0gXCJodHRwOi8vcHJlbWl1bWNvZGluZy5jb20vXCI+UHJlbWl1bUNvZGluZzwvYT4gfCBBbGwgUmlnaHRzIFJlc2VydmVkIjtzOjE2OiJ0cmFuc2xhdGlvbl9wb3N0IjtzOjE2OiJPdXIgbGF0ZXN0IHBvc3RzIjtzOjI0OiJ0cmFuc2xhdGlvbl9lbnRlcl9zZWFyY2giO3M6OToiU2VhcmNoLi4uIjtzOjE2OiJ0cmFuc2xhdGlvbl9wb3J0IjtzOjE2OiJSZWNlbnQgcG9ydGZvbGlvIjtzOjIzOiJ0cmFuc2xhdGlvbl9yZWxhdGVkcG9zdCI7czoxMzoiUmVsYXRlZCBQb3N0cyI7czoyNzoidHJhbnNsYXRpb25fYWR2ZXJ0aXNlX3RpdGxlIjtzOjE2OiJPdXIgTWFqb3IgQnJhbmRzIjtzOjI0OiJ0cmFuc2xhdGlvbl9tb3JlbGlua2Jsb2ciO3M6OToiUmVhZCBtb3JlIjtzOjI0OiJ0cmFuc2xhdGlvbl9tb3JlbGlua3BvcnQiO3M6MTU6IlJlYWQgbW9yZSBhYm91dCI7czoyNDoicG9ydF9wcm9qZWN0X2Rlc2NyaXB0aW9uIjtzOjIwOiJQcm9qZWN0IERlc2NyaXB0aW9uOiI7czoyMDoicG9ydF9wcm9qZWN0X2RldGFpbHMiO3M6MTY6IlByb2plY3QgZGV0YWlsczoiO3M6MTY6InBvcnRfcHJvamVjdF91cmwiO3M6MTI6IlByb2plY3QgVVJMOiI7czoyMToicG9ydF9wcm9qZWN0X2Rlc2lnbmVyIjtzOjE3OiJQcm9qZWN0IGRlc2lnbmVyOiI7czoxNzoicG9ydF9wcm9qZWN0X2RhdGUiO3M6Mjc6IlByb2plY3QgRGF0ZSBvZiBjb21wbGV0aW9uOiI7czoxOToicG9ydF9wcm9qZWN0X2NsaWVudCI7czoxNToiUHJvamVjdCBDbGllbnQ6IjtzOjE4OiJwb3J0X3Byb2plY3Rfc2hhcmUiO3M6MTc6IlNoYXJlIHRoZSBwcm9qZWN0IjtzOjIwOiJwb3J0X3Byb2plY3RfcmVsYXRlZCI7czoxNjoiUmVsYXRlZCBQcm9qZWN0cyI7czoxNToidHJhbnNsYXRpb25fYWxsIjtzOjg6IlNIT1cgQUxMIjtzOjE0OiJ0cmFuc2xhdGlvbl9ieSI7czoyOiJieSI7czoyNToidHJhbnNsYXRpb25fbGVhdmVfY29tbWVudCI7czoxNzoiTGVhdmUgdGhlIGNvbW1lbnQiO3M6MjI6InRyYW5zbGF0aW9uX3NoYXJlX3Bvc3QiO3M6MTU6IlNoYXJlIHRoaXMgUG9zdCI7czoyNzoidHJhbnNsYXRpb25fcmVjZW50X2NvbW1lbnRzIjtzOjE1OiJSZWNlbnQgQ29tbWVudHMiO3M6MzI6InRyYW5zbGF0aW9uX2NvbW1lbnRfbGVhdmVfcmVwbGF5IjtzOjE1OiJMZWF2ZSBhIENvbW1lbnQiO3M6MzU6InRyYW5zbGF0aW9uX2NvbW1lbnRfbGVhdmVfcmVwbGF5X3RvIjtzOjE2OiJMZWF2ZSBhIFJlcGx5IHRvIjtzOjM5OiJ0cmFuc2xhdGlvbl9jb21tZW50X2xlYXZlX3JlcGxheV9jYW5jbGUiO3M6MTI6IkNhbmNlbCBSZXBseSI7czoyNDoidHJhbnNsYXRpb25fY29tbWVudF9uYW1lIjtzOjQ6Ik5hbWUiO3M6MjQ6InRyYW5zbGF0aW9uX2NvbW1lbnRfbWFpbCI7czo0OiJNYWlsIjtzOjI3OiJ0cmFuc2xhdGlvbl9jb21tZW50X3dlYnNpdGUiO3M6NzoiV2Vic2l0ZSI7czoyODoidHJhbnNsYXRpb25fY29tbWVudF9yZXF1aXJlZCI7czo4OiJyZXF1aXJlZCI7czoyNjoidHJhbnNsYXRpb25fY29tbWVudF9jbG9zZWQiO3M6MjA6IkNvbW1lbnRzIGFyZSBjbG9zZWQuIjtzOjMxOiJ0cmFuc2xhdGlvbl9jb21tZW50X25vX3Jlc3BvbmNlIjtzOjEwOiJObyBSZXBsaWVzIjtzOjMxOiJ0cmFuc2xhdGlvbl9jb21tZW50X29uZV9jb21tZW50IjtzOjk6Ik9uZSBSZXBseSI7czozMToidHJhbnNsYXRpb25fY29tbWVudF9tYXhfY29tbWVudCI7czo3OiJSZXBsaWVzIjtzOjk6InVzZV9ib3hlZCI7czowOiIiO3M6MTQ6InVzZV9iYWNrZ3JvdW5kIjtzOjA6IiI7czoxNjoiYmFja2dyb3VuZF9pbWFnZSI7czowOiIiO3M6NzoiYm9keV9iZyI7czowOiIiO3M6MjE6ImJhY2tncm91bmRfaW1hZ2VfZnVsbCI7czowOiIiO3M6MzI6ImJhY2tncm91bmRfcGF0dGVybV9mb290ZXJfaGVhZGVyIjtzOjA6IiI7czo2OiJoX2ZfYmciO3M6MDoiIjt9';
		$pmc_data = unserialize(base64_decode($pmc_data)); //100% safe - ignore theme check nag
		update_option('of_options_munditia_pmc', $pmc_data);
		
	}
	//delete_option(OPTIONS);
	
}

// Build Options
$root =  get_template_directory() .'/';
$admin =  get_template_directory() . '/admin/';

require_once ($admin . 'theme-options.php');   // Options panel settings and custom settings
require_once ($admin . 'admin-interface.php');  // Admin Interfaces
require_once ($admin . 'admin-functions.php');  // Theme actions based on options settings
require_once ($admin . 'medialibrary-uploader.php'); // Media Library Uploader


$includes =  get_template_directory() . '/includes/';
$widget_includes =  get_template_directory() . '/includes/widgets/';

/* include custom widgets */
require_once ($widget_includes . 'recent_post_widget.php'); 
require_once ($widget_includes . 'popular_post_widget.php');



/* include scripts */
function pmc_scripts() {
	global $pmc_data;
	/*scripts*/
	wp_enqueue_script('pmc_customjs', get_template_directory_uri() . '/js/custom.js', array('jquery'),true,true);  	      
	wp_enqueue_script('pmc_prettyphoto', get_template_directory_uri() . '/js/jquery.prettyPhoto.js', array('jquery'),true,true);
	wp_enqueue_script('pmc_easing', get_template_directory_uri() . '/js/jquery.easing.1.3.js', array('jquery'),true,true);
	wp_enqueue_script('pmc_cycle', get_template_directory_uri() . '/js/jquery.cycle.all.min.js', array('jquery'),true,true);
	wp_register_script('pmc_nivo', get_template_directory_uri() . '/js/jquery.nivo.slider.pack.js', array('jquery'),true,true);
	wp_register_script('pmc_any', get_template_directory_uri() . '/js/jquery.anythingslider.js', array('jquery'),true,true);
	wp_register_script('pmc_isotope', get_template_directory_uri() . '/js/jquery.isotope.min.js', array('jquery'),true,true);  		
	wp_register_script('pmc_ba-bbq', get_template_directory_uri() . '/js/jquery.ba-bbq.js', array('jquery'),true,true);  
	wp_register_script('pmc_news', get_template_directory_uri() . '/js/jquery.li-scroller.1.0.js', array('jquery'),true,true);  
	wp_enqueue_script('pmc_gistfile', get_template_directory_uri() . '/js/gistfile_pmc.js', array('jquery') ,true,true);  
	wp_register_script('pmc_bxSlider', get_template_directory_uri() . '/js/jquery.bxslider.js', array('jquery') ,true,true);  			
	wp_register_script('pmc_iosslider', get_template_directory_uri() . '/js/jquery.iosslider.min.js', array('jquery') ,true,true);  	
	wp_register_script('googlemap', 'http://maps.google.com/maps/api/js?sensor=false', array('jquery'), '', true);	
	wp_enqueue_script('zoom', get_template_directory_uri() . '/js/jquery.elevateZoom-3.0.8.min.js', array('jquery'), '', true);	
	wp_enqueue_script('favi', get_template_directory_uri() . '/js/tinycon.js', array('jquery'), '', true);	

	
	/*style*/
	wp_enqueue_style('font-awesome_pms', get_template_directory_uri() . '/css/font-awesome.css' ,'',NULL);	
	wp_enqueue_style( 'main', get_stylesheet_uri(), 'style');
	wp_enqueue_style( 'prettyp', get_template_directory_uri() . '/css/prettyPhoto.css', 'style');
	if(isset($pmc_data['heading_font'])){			
	if($pmc_data['heading_font']['face'] != 'verdana' and $pmc_data['heading_font']['face'] != 'trebuchet' and $pmc_data['heading_font']['face'] != 'georgia' and $pmc_data['heading_font']['face'] != 'Helvetica Neue' and $pmc_data['heading_font']['face'] != 'times,tahoma') {				
	wp_enqueue_style('googleFont', 'http://fonts.googleapis.com/css?family='.$pmc_data['heading_font']['face'] ,'',NULL);				}				}
	if(isset($pmc_data['body_font'])){			
	if(($pmc_data['body_font']['face'] != 'verdana') and ($pmc_data['body_font']['face'] != 'trebuchet') and ($pmc_data['body_font']['face'] != 'georgia') and ($pmc_data['body_font']['face'] != 'Helvetica Neue') and ($pmc_data['body_font']['face'] != 'times,tahoma')) {	
	wp_enqueue_style('googleFontbody', 'http://fonts.googleapis.com/css?family='.$pmc_data['body_font']['face'] ,'',NULL);			}						}		
	wp_enqueue_style('options',  get_stylesheet_directory_uri() . '/css/options.css', 'style');		
}

add_action( 'wp_enqueue_scripts', 'pmc_scripts' ); 

// Other theme options
require_once ($includes . 'custom_functions.php');


	
if (function_exists( 'is_woocommerce' ) ) { 
	

	
	
	
	function pmc_cartShow(){
		global $woocommerce, $pmc_data, $sitepress,$product; ?>
		<div class="cartWrapper">
			<?php 
			$check_out = '';
			if($woocommerce->cart->get_cart_url() != ''){ 
			if (function_exists('icl_object_id')) {
				$cart= get_permalink(icl_object_id(woocommerce_get_page_id( 'cart' ), 'page', false));
				$check_out = get_permalink(icl_object_id(woocommerce_get_page_id( 'checkout' ), 'page', false));
				}
			else {
				$cart=$woocommerce->cart->get_cart_url();
				$check_out = $woocommerce->cart->get_checkout_url(); 
			}
			}
			else {$cart = home_url().'cart/';};
			?>
			<div class="header-cart-left">
				<div class="header-cart-items">
					<a href="<?php echo $cart; ?>" class="cart-top"><?php if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { echo pmc_stripText($pmc_data['translation_cart']); } else {  _e('Cart','wp-camy'); } ?></a>
					<a class="cart-bubble cart-contents">(<?php echo sprintf(_n('%d', '%d', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?>)</a>
				</div>
				<div class="header-cart-total">
					<a class="cart-total"><?php //echo $woocommerce->cart->get_cart_total(); ?></a>
				</div>
			</div>
			<div class="header-cart-icon"></div>
			<div class="cartTopDetails">
				<div class="cart_list product_list_widget">
					<div class="widget_shopping_cart_top widget_shopping_cart_content">	

						<?php get_template_part('woocommerce/cart/mini-cart') ?>

					</div>	
				</div>	
			</div>
		</div>	
	<?php
	}

	/*== WOO CUSTOMIZATION ==*/
	$average = '';

	
	if(isset($pmc_data['product_cat_page']) && $pmc_data['product_cat_page'] != 'Select a number:'){

	add_filter('loop_shop_per_page', create_function('$cols', 'return '.$pmc_data['product_cat_page'].';'));
	
	}




	add_filter('woocommerce_get_catalog_ordering_args', 'custom_woocommerce_get_catalog_ordering_args');
	
	function custom_woocommerce_get_catalog_ordering_args( $args ) {
			if (isset($_GET['orderby'])) {
				switch ($_GET['orderby']) :
					case 'date' :
						$args['orderby'] = 'date';
						$args['order'] = 'asc';
						$args['meta_key'] = '';
					break;
					case 'price_desc' :
						$args['orderby'] = 'meta_value_num';
						$args['order'] = 'desc';
						$args['meta_key'] = '_price';
					break;
					case 'title_desc' :
						$args['orderby'] = 'title';
						$args['order'] = 'desc';
						$args['meta_key'] = '';
					break;
					case 'menu_order' :
						$args['orderby'] = '';
						$args['order'] = '';
						$args['meta_key'] = '';
					break;
					case 'price' :
						$args['orderby'] = 'meta_value_num';
						$args['order'] = 'asc';
						$args['meta_key'] = '_price';
					break;
					case 'title_asc' :
						$args['orderby'] = 'title';
						$args['order'] = 'asc';
						$args['meta_key'] = '';
					break;	
					case 'select' :
						$args['orderby'] = '';
						$args['order'] = '';
						$args['meta_key'] = '';
					break;					
				endswitch;
			}
		return $args;
	}



	add_filter('add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');

	function woocommerce_header_add_to_cart_fragment( $fragments ) {
		global $woocommerce;
		ob_start();
		?>
		<a class="cart-bubble cart-contents">(<?php echo sprintf(_n('%d', '%d', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?>)</a>

		<script>
		Tinycon.setBubble(<?php echo $woocommerce->cart->cart_contents_count; ?>);
		</script>
		<?php

		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;
	}
	
	
	
	define('WOOCOMMERCE_USE_CSS', false);
	
	add_action('woocommerce_before_main_content', create_function('', 'echo "";'), 10);
	add_action('woocommerce_after_main_content', create_function('', 'echo "";'), 10);
	
	remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
	remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
	
	// change add to cart location
	
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
	add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 10);
	
	// remove ordering
	
	remove_action( 'woocommerce_pagination', 'woocommerce_catalog_ordering', 20 );
	
	// excerpt on top
	
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
	add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 5);
	
	// remove categories
	
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
	
	// remove title from single
	
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
	
	// remove default related
	
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

	//remove add to cart
	
	//update_option( 'woocommerce_enable_ajax_add_to_cart' , 'no' );	
	
}

/* top bar function */
function pmc_showTop() {
	
	global $pmc_data, $sitepress;
	?>
	<div class="top-nav">
		<div class="topNotification">
			<?php if(isset($pmc_data['top_notification']))  echo pmc_translation('top_notification', 'In case of any question call this number <span>+386 415 686 32</span>')  ?>
		</div>		
		<ul>
		
		<?php 
		if ( has_nav_menu( 'top_menu' ) ) {
			wp_nav_menu( array('theme_location' => 'top_menu', 'container' => 'false', 'menu_class' => 'top-nav', 'echo' => true, 'items_wrap' => '%3$s' )); 
		}
		?>
		
		<li>
			<div class="menu-src">
				<i class="fa fa-search "></i>
				<div class = "menu-src-input">
					<?php if ( is_active_sidebar( 'search' ) ) : ?>

						<?php dynamic_sidebar( 'search' ); ?>

					<?php else : ?>

						<?php the_widget( 'WP_Widget_Search' ); ?>

					<?php endif; ?>				

				</div>
			</div>
		</li>
		</ul>
	</div>
	<?php
}
	

/* custom short content */
function shortcontent($start, $end, $new, $source, $lenght){
	$countopen = $countclose = 0;
	$text = strip_tags(preg_replace('/<h(.*)>(.*)<\/h(.*)>.*/iU', '', $source), '<b><strong>');
	$text = str_replace( '<strong>' , '<b>', $text );
	$text = str_replace( '</strong>' , '</b>', $text );
	$text = preg_replace('#\[video\](.*)\[\/video\]#si', '', $text);
	$text = preg_replace('#\[pmc_link\](.*)\[\/pmc_link\]#si', '', $text);
	$text = preg_replace('/\[[^\]]*\]/', $new, $text); 
	$text = substr(preg_replace('/\s[\s]+/','',$text),0,$lenght);
	$countopen = substr_count($text, '<b>');
	$countclose = substr_count($text, '</b>');
	if ($countopen > $countclose)
		return $text.'</b>';
	else
		return $text;
}


/* custom breadcrumb */
function pmc_breadcrumb() {
	global $pmc_data;
	$breadcrumb = '';
	if (!is_home()) {
		$breadcrumb .= '<a href="';
		$breadcrumb .=  home_url();
		$breadcrumb .=  '">';
		$breadcrumb .= get_bloginfo('name');
		$breadcrumb .=  "</a> &#187; ";
		if (is_single()) {
			if (is_single()) {
				$name = '';
				if(!get_query_var($pmc_data['port_slug'])){
					$category = get_the_category(); +
					$category_id = get_cat_ID($category[0]->cat_name);
					$category_link = get_category_link($category_id);					
					$name = '<a href="'. esc_url( $category_link ).'">'.$category[0]->cat_name .'</a>';
				}
				else{
					$taxonomy = 'portfoliocategory';
					$entrycategory = get_the_term_list( get_the_ID(), $taxonomy, '', ',', '' );
					$catstring = $entrycategory;
					$catidlist = explode(",", $catstring);	
					$name = $catidlist[0];
				}
				
				$breadcrumb .= $name .' &#187; <span>'. get_the_title().'</span>';
			}	
		} elseif (is_page()) {
			$breadcrumb .=  '<span>'.get_the_title().'</span>';
		}
		elseif(get_query_var('portfoliocategory')){
			$term = get_term_by('slug', get_query_var('portfoliocategory'), 'portfoliocategory'); $name = $term->name; 
			$breadcrumb .=  '<span>'.$name.'</span>';
		}	
		else if(get_query_var('tag')){
			$tag = get_query_var('tag');
			$tag = str_replace('-',' ',$tag);
			$breadcrumb .=  '<span>'.$tag.'</span>';
		}
		else if(get_query_var('s')){

			$breadcrumb .= __('Search results for ', 'wp-munditia') .'"<span>'.get_search_query().'</span>"';			
		} 
		else if(get_query_var('cat')){
			$cat = get_query_var('cat');
			$cat = get_category($cat);
			$breadcrumb .=  '<span>'.$cat->name.'</span>';
		}
		else if(get_query_var('m')){
			$breadcrumb .=  '<span>'.__('Archive','wp-munditia').'</span>';
		}	
	
		else{
			$breadcrumb .=  'Home';
		}
	}
	return $breadcrumb ;
}
/* social share links */
function pmc_socialLinkSingle() {
	global $pmc_data; 
	$social = '';
	$social ='<div class="addthis_toolbox"><div class="custom_images">';
	$social .= '<a class="addthis_button_facebook" ></a>';            
	$social .= '<a class="addthis_button_twitter" ></a>';  
	$social .= '<a class="addthis_button_email" ></a>'; 
	$social .='<a class="addthis_button_more"></a></div><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4f3049381724ac5b"></script>';	
	$social .= '</div>'; 
	echo $social;
}

/* links to social profile */
function pmc_socialLink() {
	$social = '';
	global $pmc_data; 
	$icons = $pmc_data['socialicons'];
	foreach ($icons as $icon){
		$social .= '<a target="_blank" class="'.$icon['class'].'" href="'.$icon['link'].'" title="'.$icon['title'].'"><img src = "'.$icon['url'].'" alt="'.$icon['title'].'"></a>';	
	}

	echo $social;
}


/*translation function*/
function pmc_translation($theme_name, $translation_name){
	global $pmc_data, $sitepress;
	if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { 
		if(isset($pmc_data[$theme_name]))
			$string = pmc_stripText($pmc_data[$theme_name]); 
		else
			$string = '';
		} 
	else {  
		$string = sprintf( __('%s','wp-munditia'),$translation_name); 				
	} 
	return $string;

}
add_filter('the_content', 'pmc_addlightbox');

/* add lightbox to images*/
function pmc_addlightbox($content)
{	global $post;
	$pattern = "/<a(.*?)href=('|\")(.*?).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>/i";
  	$replacement = '<a$1href=$2$3.$4$5 rel="lightbox[%LIGHTID%]"$6>';
    $content = preg_replace($pattern, $replacement, $content);
	if(isset($post->ID))
		$content = str_replace("%LIGHTID%", $post->ID, $content);
    return $content;
}

/* remove double // char */
function pmc_stripText($string) 
{ 
    return str_replace("\\",'',$string);
} 


/*portfolio loop*/
function pmc_portfolio($portSize, $item, $post = 'port' ,$number = 0,$cat = '',$postIn = ''){
	wp_enqueue_script('pmc_isotope');	
	global $pmc_data; 
	$categport = '';
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	
	if($number != 0)
		$showposts = $number;
			
		
	if($item == 3){
		$titleChar = 999;
	}
	else if($item == 2){
		$titleChar = 25;
	}	
	else {
		$titleChar = 28;
	}	

	if($post == 'post'){
		$postT = 'post';
		$postC = 'category';	
		$categport="";		
		}
	else{

		$postT = $pmc_data['port_slug'];
		$postC = 'portfoliocategory';
			
		}
		
	if($cat != ''){	
			$args = array(
			'tax_query' => array(array('taxonomy' => $postC,'field' => 'id','terms' => $cat)),
			'showposts'     => $showposts,
			'post_type' => $postT,
			'paged'    => $paged,
			'post__not_in' => array($postIn)
			);
		}
	else{
			$args = array(
			'showposts'     => $showposts,
			'post_type' => $postT,
			'paged'    => $paged,
			'post__not_in' => array($postIn)
			);
		}

	query_posts( $args );

	
	$currentindex = $linkPost = '';
	$counter = 0;
	$portfolio = '';
	$count = 0;
	while ( have_posts() ) : the_post();
		$postmeta = get_post_custom(get_the_ID()); 
		$do_not_duplicate = get_the_ID(); 
		$image = wp_get_attachment_image_src(get_post_thumbnail_id(), $portSize, false);
		$full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full', false);
		$entrycategory = get_the_term_list( get_the_ID(), $postC, '', ',', '' );
		$catstring = $entrycategory;
		$catstring = strip_tags($catstring);
		$catidlist = explode(",", $catstring);
		$catlist = '';
		for($i = 0; $i < sizeof($catidlist); ++$i){
			$catidlist[$i].=$currentindex;
			$find =     array("&", "/", " ","amp;","&#38;");
			$replace  = array("", "", "", "","");			
			$catlist .= str_replace($find,$replace,$catidlist[$i]). ' ';
			
		}


		$counter++;
		$categoryIn = get_the_term_list( get_the_ID(), $postC, '', ', ', '' );	
		$category = explode(',',$categoryIn);	
		if ( has_post_format( 'link' , get_the_ID()) and $post == 'post') {
			if(isset($postmeta["link_post_url"][0] )) $linkPost = $postmeta["link_post_url"][0];
			}
		else{
			if (function_exists('icl_object_id')) 
				$linkPost = get_permalink(icl_object_id(get_the_ID(), $pmc_data['port_slug'], true, true));
			else 
				$linkPost = get_permalink();
		}		
		if(isset($postmeta['show_video'][0])){
			$linkport = $postmeta['video'][0];
		}
		else{
			$linkport = $full_image[0];
		}
		$portfolio .= '<div class="item'.$item.' '.$catlist .'" data-category="'. $catlist.'">';
	
		$portfolio .= '		
				<a href = "'.$linkport.'" title="'.esc_attr(  get_the_title(get_the_id()) ) .'" rel="lightbox" >
					<div class="recentimage">
							<div class="overdefult">
								<div class="portIcon"></div>
							</div>			
						<div class="image">
							<div class="loading"></div>
								<img src="'.$image[0].'" alt="'.get_the_title().'">
						</div>
					</div>
				</a>';


		$title = substr(the_title('','',FALSE), 0, 99);  
		
		if(strlen(the_title('','',FALSE)) > 99) 
			$title = substr(the_title('','',FALSE), 0, 99). '...';				
		$portfolio .= '<div class="shortDescription">
				
				<div class="descriptionHomePortText">					
					<h3><a href="'. $linkPost .'">'. $title .'</a></h3>
				</div>';
		if($item == 4){		
			$portfolio .= '<div class="description">'. shortcontent("[", "]", "", get_the_content() ,90) .'...'.pmc_closeTagsReturn(shortcontent("[", "]", "", get_the_content() ,90)).'</div>';
		}else{
			$portfolio .= '<div class="description">'. shortcontent("[", "]", "", get_the_content() ,150) .'...'.pmc_closeTagsReturn(shortcontent("[", "]", "", get_the_content() ,150)).'</div>';
		}
		$portfolio .= '<div class="recentdescription-text"><a href="'. get_permalink( get_the_id() ) .'">'. pmc_translation('translation_morelinkblog', 'Read more about this...') .'</a></div>
			</div>';

			

		$portfolio .= '</div>';


		

	endwhile; 	
	
						

		
	echo $portfolio;
}

/* custom post type -- portfolio */
register_taxonomy("portfoliocategory", array($pmc_data['port_slug']), array("hierarchical" => true, "label" => "Portfolio Categories", "singular_label" => "Portfolio Category", "rewrite" => true));
add_action('init', 'pmc_create_portfolio');

function pmc_create_portfolio() {
	global $pmc_data;
	$portfolio_args = array(
		'label' => 'Portfolio',
		'singular_label' => 'Portfolio',
		'public' => true,
		'show_ui' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'rewrite' => true,
		'supports' => array('title', 'editor', 'thumbnail', 'author', 'comments', 'excerpt')
	);
	register_post_type($pmc_data['port_slug'],$portfolio_args);
}

add_action("admin_init", "pmc_add_portfolio");
add_action('save_post', 'pmc_update_portfolio_data');

function pmc_add_portfolio(){
	global $pmc_data;
	add_meta_box("portfolio_details", "Portfolio Entry Options", "pmc_portfolio_options", $pmc_data['port_slug'], "normal", "high");
}

function pmc_update_portfolio_data(){
	global $post;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return $post_id;
    }
	if($post){
		if( isset($_POST["author"]) ) {
			update_post_meta($post->ID, "author", $_POST["author"]);
		}
		if( isset($_POST["date"]) ) {
			update_post_meta($post->ID, "date", $_POST["date"]);
		}
		if( isset($_POST["detail_active"]) ) {
			update_post_meta($post->ID, "detail_active", $_POST["detail_active"]);
		}else{
			update_post_meta($post->ID, "detail_active", 0);
		}
		if( isset($_POST["website_url"]) ) {
			update_post_meta($post->ID, "website_url", $_POST["website_url"]);
		}
		if( isset($_POST["status"]) ) {
			update_post_meta($post->ID, "status", $_POST["status"]);
		}		
		if( isset($_POST["customer"]) ) {
			update_post_meta($post->ID, "customer", $_POST["customer"]);
		}			
		if( isset($_POST["skils"]) ) {
			update_post_meta($post->ID, "skils", $_POST["skils"]);
		}			
		if( isset($_POST["video"]) ) {
			update_post_meta($post->ID, "video", $_POST["video"]);
		}
		if( isset($_POST["show_video"]) ) {
			update_post_meta($post->ID, "show_video", $_POST["show_video"]);
		}		
	}
}

function pmc_portfolio_options(){
	global $post;
	$pmc_data = get_post_custom($post->ID);
	if (isset($pmc_data["author"][0])){
		$author = $pmc_data["author"][0];
	}else{
		$author = "";
	}
	if (isset($pmc_data["date"][0])){
		$date = $pmc_data["date"][0];
	}else{
		$date = "";
	}
	if (isset($pmc_data["status"][0])){
		$status = $pmc_data["status"][0];
	}else{
		$status = "";
	}	
	if (isset($pmc_data["detail_active"][0])){
		$detail_active = $pmc_data["detail_active"][0];
	}else{
		$detail_active = 0;
		$pmc_data["detail_active"][0] = 0;
	}
	if (isset($pmc_data["website_url"][0])){
		$website_url = $pmc_data["website_url"][0];
	}else{
		$website_url = "";
	}
	
	if (isset($pmc_data["customer"][0])){
		$customer = $pmc_data["customer"][0];
	}else{
		$customer = "";
	}	 

	if (isset($pmc_data["skils"][0])){
		$skils = $pmc_data["skils"][0];
	}else{
		$skils = "";
	}	 	
	
	if (isset($pmc_data["video"][0])){
		$video = $pmc_data["video"][0];
	}else{
		$video = "";
	}

	if (isset($pmc_data["show_video"][0])){
		$show_video = $pmc_data["show_video"][0];
	}else{
		$show_video = "";
	}	
	
	?>
    <div id="portfolio-options">
        <table cellpadding="15" cellspacing="15">
        	<tr>
                <td colspan="2"><strong>Portfolio Overview Options:</strong></td>
            </tr>
            <tr>
                <td><label>Link to Detail Page: <i style="color: #999999;">(Do you want a project detail page?)</i></label></td><td><input type="checkbox" name="detail_active" value="1" <?php if( isset($detail_active)){ checked( '1', $pmc_data["detail_active"][0] ); } ?> /></td>	
            </tr>
            <tr>
            	<td><label>Project Link: <i style="color: #999999;">(The URL of your project)</i></label></td><td><input name="website_url" style="width:100%" value="<?php echo $website_url; ?>" /></td>
            </tr>
            <tr>
            	<td><label>Project Author: <i style="color: #999999;">(The URL of your project)</i></label></td><td><input name="author" style="width:100%" value="<?php echo $author; ?>" /></td>
            </tr>
            <tr>
            	<td><label>Project date: <i style="color: #999999;">(Date of project)</i></label></td><td><input name="date" style="width:100%" value="<?php echo $date; ?>" /></td>
            </tr>	
            <tr>
            	<td><label>Customer: <i style="color: #999999;">(Customer of project)</i></label></td><td><input name="customer" style="width:100%" value="<?php echo $customer; ?>" /></td>
            </tr>				
            <tr>
            	<td><label>Project status: <i style="color: #999999;">(Status of project)</i></label></td><td><input name="status" style="width:100%" value="<?php echo $status; ?>" /></td>
            </tr>	
            <tr>
            	<td><label>Required skils: <i style="color: #999999;">(each skill into new line)</i></label></td><td><textarea name="skils" style="width:100%; height:300px;" /><?php echo $skils; ?></textarea></td>
            </tr>				
        </table>
    </div>
    <div id="portfolio-options-video">
        <table cellpadding="15" cellspacing="15">
        	<tr>
                <td colspan="2"><strong>Portfolio Options for video:</strong></td>
            </tr>
            <tr>
                <td><label>Display video insted of images: <i style="color: #999999;">(Video will replace images!)</i></label></td><td><input type="checkbox" name="show_video" value="1" <?php if( isset($show_video)){ checked( '1', $pmc_data["show_video"][0] ); } ?> /></td>	
            </tr>
            <tr>
            	<td><label>Video URL: <i style="color: #999999;">(The URL of your video)</i></label></td><td><input name="video" style="width:100%" value="<?php echo $video; ?>" /></td>
            </tr>				
        </table>
    </div>	
      
<?php
}	
	
add_action('save_post', 'update_post_type');
add_action("admin_init", "add_post_type");


/* get category name */
/* get category name */
function pmc_getcatname($catID,$posttype){
		if($catID != 0){
		$cat_obj = get_term($catID, $posttype);
		$cat_name = '';
		$cat_name = $cat_obj->name;
		return $cat_name;
		}
	}
	
/* custom post types */	
function add_post_type(){
	add_meta_box("slider_categories", "Post type", "post_type", "post", "normal", "high");
	
}	


function post_type(){
	global $post;
	$pmc_data = get_post_custom($post->ID);
	if (isset($pmc_data["slider_category"][0])){
		$slider_category = $pmc_data["slider_category"][0];
	}else{
		$slider_category = "";
	}
	if (isset($pmc_data["video_post_url"][0])){
		$video_post_url = $pmc_data["video_post_url"][0];
	}else{
		$video_post_url = "";
	}	
	if (isset($pmc_data["video_active_post"][0])){
		$video_active_post = $pmc_data["video_active_post"][0];
	}else{
		$video_active_post = 0;
		$pmc_data["video_active_post"][0] = 0;
	}	
	
	if (isset($pmc_data["link_post_url"][0])){
		$link_post_url = $pmc_data["link_post_url"][0];
	}else{
		$link_post_url = "";
	}	
	
	if (isset($pmc_data["audio_post_url"][0])){
		$audio_post_url = $pmc_data["audio_post_url"][0];
	}else{
		$audio_post_url = "";
	}	

	if (isset($pmc_data["audio_post_title"][0])){
		$audio_post_title = $pmc_data["audio_post_title"][0];
	}else{
		$audio_post_title = "";
	}	
	
	if (isset($pmc_data["selectv"][0])){
		$selectv = $pmc_data["selectv"][0];
	}else{
		$selectv = "";
	}	
	
	

?>
    <div id="portfolio-category-options">
        <table cellpadding="15" cellspacing="15">
	
            <tr class="videoonly" style="border-bottom:1px solid #000;">
            	<td style="border-bottom:1px solid #000;width:100%;"><label>Video URL(*required) - add if you select video post: <i style="color: #999999;">
				<br>Link should look for Youtube: http://www.youtube.com/watch?v=WhBoR_tgXCI - So ID is WhBoR_tgXCI
				<br>Link should look for Vimeo: http://vimeo.com/29017795 so ID is 29017795 <br></i></label><br><input name="video_post_url" style="width:500px" value="<?php echo $video_post_url; ?>" /></td>
            	
            <td class="select_video" style="text-align:left;border-bottom:1px solid #000;width:100%; " >
            	<label>Select video: <br/><i style="color: #999999;">
				<select name="selectv">
				<?php if ($selectv == 'vimeo') {?>
				  <option value="vimeo" selected>Vimeo</option>
				 <?php } else {?>
				  <option value="vimeo">Vimeo</option>						
				 <?php }?>	
				<?php if ($selectv == 'youtube') {?>				 
				  <option value="youtube" selected>YouTube</option>
				 <?php } else {?>
				  <option value="youtube">YouTube</option>						
				 <?php }?>					  
				</select>
	
            </td>	
				
			</tr>
						
            <tr class="linkonly" >
			
            	<td style="border-bottom:1px solid #000;width:100%;"><label>Link URL - add if you select link post : <i style="color: #999999;"></i></label><br></td><td style="text-align:left;border-bottom:1px solid #000;width:100%; " ><input name="link_post_url" style="width:500px" value="<?php echo $link_post_url; ?>" /></td>
            </tr>				

            <tr class="audioonly">
            	<td style="border-bottom:1px solid #000;width:100%;"><label>Audio URL - add if you select audio post: <i style="color: #999999;"></i></label><br></td><td style="text-align:left;border-bottom:1px solid #000;width:100%; " ><input name="audio_post_url" style="width:500px" value="<?php echo $audio_post_url; ?>" /></td>
            </tr>
            <tr class="audioonly">
            	<td style="border-bottom:1px solid #000;width:100%;"><label>Audio title - add if you select audio post: <i style="color: #999999;"></i></label><br></td><td style="text-align:left;border-bottom:1px solid #000;width:100%; " ><input name="audio_post_title" style="width:500px" value="<?php echo $audio_post_title; ?>" /></td>
            </tr>			
			
        </table>

    </div>
	
      
<?php


	
}


function update_post_type(){
	global $post;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return $post_id;
    }
	if($post){
		if( isset($_POST["slider_category"]) ) {
			update_post_meta($post->ID, "slider_category", $_POST["slider_category"]);
		}	
		if( isset($_POST["video_post_url"]) ) {
			update_post_meta($post->ID, "video_post_url", $_POST["video_post_url"]);
		}	
		if( isset($_POST["video_active_post"]) ) {
			update_post_meta($post->ID, "video_active_post", $_POST["video_active_post"]);
		}else{
			update_post_meta($post->ID, "video_active_post", 0);
		}		
		if( isset($_POST["link_post_url"]) ) {
			update_post_meta($post->ID, "link_post_url", $_POST["link_post_url"]);
		}	
		if( isset($_POST["audio_post_url"]) ) {
			update_post_meta($post->ID, "audio_post_url", $_POST["audio_post_url"]);
		}		
		if( isset($_POST["audio_post_title"]) ) {
			update_post_meta($post->ID, "audio_post_title", $_POST["audio_post_title"]);
		}					
		if( isset($_POST["selectv"]) ) {
			update_post_meta($post->ID, "selectv", $_POST["selectv"]);
		}			
	}
	
	
	
}




if( !function_exists( 'munditia_fallback_menu' ) )
{
	/**
	 * Create a navigation out of pages if the user didnt create a menu in the backend
	 *
	 */
	function munditia_fallback_menu()
	{
		$current = "";
		if (is_front_page()){$current = "class='current-menu-item'";} 
		
		
		echo "<div class='fallback_menu'>";
		echo "<ul class='munditia_fallback menu'>";
		echo "<li $current><a href='".get_bloginfo('url')."'>Home</a></li>";
		wp_list_pages('title_li=&sort_column=menu_order');
		echo "</ul></div>";
	}
}



/* close bold tags*/
function pmc_closeTagsReturn($string){
	$output  = '';
	$open = $close = 0;
	$open = substr_count($string , '<strong>');
	$close = substr_count($string , '</strong>');
	if($open > $close )	
		$output .='</strong>'; 
	return $output;
}


add_filter( 'the_category', 'add_nofollow_cat' );  

function add_nofollow_cat( $text ) { 
	$text = str_replace('rel="category tag"', "", $text); 
	return $text; 
}

/* get image from post */
function pmc_getImage($image){
	if ( has_post_thumbnail() ){
		the_post_thumbnail($image);
		}
	else
		echo '<img src ="'.get_template_directory_uri() . '/images/placeholder-580.png" alt="'.the_title('','',FALSE).'" >';
							
}

function pmc_add_this_script_footer(){ 
	global $pmc_data, $sitepress, $woocommerce, $product;
	
		if (!function_exists('icl_object_id') or (ICL_LANGUAGE_CODE == $sitepress->get_default_language()) ) { 
			$search = pmc_stripText($pmc_data['translation_enter_search']); 
			
			} 
		else {  
			$search = __('Enter search...','wp-munditia'); 
				
		} 


?>
<script>	
	jQuery(document).ready(function(){	
		jQuery('.searchform #s').val('<?php echo $search ?>');
		
		jQuery('.searchform #s').focus(function() {
			jQuery('.searchform #s').val('');
		});
		
		jQuery('.searchform #s').focusout(function() {
			jQuery('.searchform #s').val('<?php echo $search ?>');
		});	

		<?php if (function_exists( 'is_woocommerce' ) ) { ?>
		Tinycon.setBubble(<?php echo $woocommerce->cart->cart_contents_count; ?>);

		Tinycon.setOptions({
			width: 7,
			height: 10,
			font: '9px Roboto',
			colour: '#ffffff',
			background: '<?php echo $pmc_data['mainColor'] ?>',
			fallback: true,
			abbreviate: true
		});
		<?php } ?>
	
	});	</script>
	


<?php  }


add_action('wp_footer', 'pmc_add_this_script_footer'); 	

if ( ! isset( $content_width ) ) $content_width = 800;




add_filter( 'woocommerce_currencies', 'add_inr_currency' );
add_filter( 'woocommerce_currency_symbol', 'add_inr_currency_symbol' );
 
function add_inr_currency( $currencies ) {
    $currencies['INR'] = 'INR';
    return $currencies;
}
 
function add_inr_currency_symbol( $symbol ) {
	$currency = get_option( 'woocommerce_currency' );
	switch( $currency ) {
		case 'INR': $symbol = '&#8377'; break;
	}
	return $symbol;
}
?>