<?php
/*
 * this is main plugin class
 */


/* ======= the model main class =========== */
if (! class_exists ( 'NM_Framwork_V1' )) {
	$_framework = dirname ( __FILE__ ) . DIRECTORY_SEPARATOR . 'nm-framework.php';
	if (file_exists ( $_framework ))
		include_once ($_framework);
	else
		die ( 'Reen, Reen, BUMP! not found ' . $_framework );
}

/*
 * [1]
 */
class NM_PersonalizedProduct extends NM_Framwork_V1 {
	
	static $tbl_productmeta = 'nm_personalized';
	var $inputs;
	
	
	private static $ins = null;
	
	public static function init()
	{
		add_action('plugins_loaded', array(self::get_instance(), '_setup'));
	}
	
	public static function get_instance()
	{
		// create a new object if it doesn't exist.
		is_null(self::$ins) && self::$ins = new self;
		return self::$ins;
	}
	/*
	 * plugin constructur
	 */
	function _setup() {
		
		// setting plugin meta saved in config.php
		
		add_action( 'woocommerce_init', array( $this, 'setup_personalized_plugin' ) );
	}
	
	function setup_personalized_plugin(){
		
		$this -> plugin_meta = get_plugin_meta_productmeta();
		
		// getting saved settings
		$this -> plugin_settings = get_option ( 'nm-personalizedproduct' . '_settings' );
		
		// file upload dir name
		$this -> product_files = 'product_files';
		
		// this will hold form productmeta_id
		$this -> productmeta_id = '';
		
		// populating $inputs with NM_Inputs object
		$this -> inputs = self::get_all_inputs ();
		
		/*
		 * [2] TODO: update scripts array for SHIPPED scripts only use handlers
		 */
		// setting shipped scripts
		$this -> wp_shipped_scripts = array (
				'jquery',
				'jquery-ui-datepicker' 
		);
		

		/*
		 * [3] TODO: update scripts array for custom scripts/styles
		 */
		// setting plugin settings
		$this -> plugin_scripts = array (
				
				array (
						'script_name' => 'scripts',
						'script_source' => '/js/script.js',
						'localized' => true,
						'type' => 'js' 
				),
				
				array (
						'script_name' => 'styles',
						'script_source' => '/plugin.styles.css',
						'localized' => false,
						'type' => 'style' 
				),
				
				array (
						'script_name' => 'nm-ui-style',
						'script_source' => '/js/ui/css/smoothness/jquery-ui-1.10.3.custom.min.css',
						'localized' => false,
						'type' => 'style',
						'page_slug' => array (
								'nm-new-form' 
						) 
				) 
		);
		
		/*
		 * [4] Localized object will always be your pluginshortname_vars e.g: pluginshortname_vars.ajaxurl
		 */
		$this -> localized_vars = array (
				'ajaxurl' => admin_url ( 'admin-ajax.php' ),
				'plugin_url' => $this -> plugin_meta ['url'],
				'doing' => $this -> plugin_meta ['url'] . '/images/loading.gif',
				'settings' => $this -> plugin_settings,
				'file_upload_path_thumb' => $this -> get_file_dir_url ( true ),
				'file_upload_path' => $this -> get_file_dir_url (),
				'file_meta' => '',
				'section_slides' => '',
				'is_html5' => $is_html5,
				'option_amount_text' => __('Total price: ', 'nm-personalizedproduct'),
				'woo_currency'	=> get_woocommerce_currency_symbol(),
		);
		
		/*
		 * [5] TODO: this array will grow as plugin grow all functions which need to be called back MUST be in this array setting callbacks
		 */
		// following array are functions name and ajax callback handlers
		$this -> ajax_callbacks = array (
				'save_settings', // do not change this action, is for admin
				'save_form_meta',
				'update_form_meta',
				'upload_file',
				'delete_file',
				'delete_meta',
				'save_edited_photo',
				'get_option_price'
		);
		
		/*
		 * plugin localization being initiated here
		 */
		add_action ( 'init', array (
				$this,
				'wpp_textdomain' 
		) );
		
		/*
		 * hooking up scripts for front-end
		 */
		add_action ( 'wp_enqueue_scripts', array (
				$this,
				'load_scripts' 
		) );
		
		/*
		 * registering callbacks
		 */
		$this -> do_callbacks ();
		
		/*
		 * adding a panel on product single page in admin
		 */
		add_action ( 'add_meta_boxes', array (
				$this,
				'add_productmeta_meta_box' 
		) );
		
		/*
		 * saving product meta in admin/product signel page
		 */
		add_action ( 'woocommerce_process_product_meta', array (
				$this,
				'process_product_meta' 
		), 1, 2 );
		
		/*
		 * 1- redering all product meta front-end
		 */
		add_action ( 'woocommerce_before_add_to_cart_button', array (
				$this,
				'render_product_meta' 
		), 15 );
		
		/*
		 * 2- validating the meta before adding to cart
		 */
		add_filter ( 'woocommerce_add_to_cart_validation', array (
				$this,
				'validate_data_before_cart' 
		), 10, 3 );
		
		/*
		 * 3- adding product meta to cart
		 */
		add_filter ( 'woocommerce_add_cart_item_data', array (
				$this,
				'add_product_meta_to_cart' 
		), 10, 2 );
		
		/*
		 * 4- now loading all meta on cart/checkout page from session confirmed that it is loading for cart and checkout
		 */
		add_filter ( 'woocommerce_get_cart_item_from_session', array (
				&$this,
				'get_cart_session_data' 
		), 10, 2 );
		
		/*
		 * 5- this is showing meta on cart/checkout page confirmed that it is loading for cart and checkout
		 */
		add_filter ( 'woocommerce_get_item_data', array (
				$this,
				'add_item_meta' 
		), 10, 2 );
		
		/*
		 * 6- Adding item_meta to orders 2.0 it is in classes/class-wc-checkout function: create_order() do_action( 'woocommerce_add_order_item_meta', $item_id, $values );
		 */
		add_action ( 'woocommerce_add_order_item_meta', array (
				$this,
				'order_item_meta' 
		), 10, 2 );
		
		/*
		 * 7- Another panel in orders to display files uploaded against each product
		 */
		add_action ( 'admin_init', array (
				$this,
				'render_product_files_in_orders' 
		) );
		
		/*
		 * 7- movnig confirmed/paid orders into another directory
		 * dir_name: confirmed
		*/
		add_action ( 'woocommerce_checkout_order_processed', array (
		$this,
		'move_files_when_paid'
		) );
		
		
		/*
		 * 8- cron job (shedualed hourly)
		 * to remove un-paid images
		 */
		add_action('do_action_remove_images', array($this, 'remove_unpaid_orders_images'));
		
		/*
		 * 9- adding file download link into order email
		 */
		add_action('woocommerce_email_after_order_table', array($this, 'add_files_link_in_email'), 10, 2);
		
		/*
		 * 10- adding meta list in product page
		*/
		//add_action( 'restrict_manage_posts', array( $this, 'nm_meta_dropdown' ) );
		
		add_action('admin_footer-edit.php', array($this, 'nm_add_bulk_meta'));
		
		add_action('load-edit.php', array(&$this, 'nm_meta_bulk_action'));
		
		add_action('admin_notices', array(&$this, 'nm_add_meta_notices'));
	}
	
	/*
	 * ============================================================== All about Admin -> Single Product page ==============================================================
	 */
	
	// i18n and l10n support here
	// plugin localization
	function wpp_textdomain() {
		$locale_dir = $this->plugin_meta['dir_name'] . '/locale/';
		load_plugin_textdomain('nm-personalizedproduct', false, $locale_dir);
	}
	
	/**
	 * Adds meta groups in admin dropdown to apply on products.
	 *
	 */
	function nm_add_bulk_meta() {
		global $post_type;
			
		if($post_type == 'product' and $all_meta = $this -> get_product_meta_all ()) {
			foreach ( $all_meta as $meta ) {
				?>
<script type="text/javascript">
						jQuery(document).ready(function() {
							jQuery('<option>').val('<?php printf(__('nm_action_%d', 'nm-personalizedproduct'), $meta->productmeta_id)?>', 'nm-personalizedproduct').text('<?php _e($meta->productmeta_name)?>').appendTo("select[name='action']");
							jQuery('<option>').val('<?php printf(__('nm_action_%d', 'nm-personalizedproduct'), $meta->productmeta_id)?>').text('<?php _e($meta->productmeta_name)?>').appendTo("select[name='action2']");
						});
					</script>
<?php
			}
			?>
<script type="text/javascript">
					jQuery(document).ready(function() {
						jQuery('<option>').val('nm_delete_meta').text('<?php _e('Remove Meta', 'nm-personalizedproduct')?>').appendTo("select[name='action']");
						jQuery('<option>').val('nm_delete_meta').text('<?php _e('Remove Meta', 'nm-personalizedproduct')?>').appendTo("select[name='action2']");
					});
				</script>
<?php
	    }
	}

	function nm_meta_bulk_action() {
		global $typenow;
		$post_type = $typenow;
			
		if($post_type == 'product') {
				
			// get the action
			$wp_list_table = _get_list_table('WP_Posts_List_Table');  // depending on your resource type this could be WP_Users_List_Table, WP_Comments_List_Table, etc
			$action = $wp_list_table->current_action();
			
			// make sure ids are submitted.  depending on the resource type, this may be 'media' or 'ids'
			if(isset($_REQUEST['post']) && is_array($_REQUEST['post'])){
				$post_ids = array_map('intval', $_REQUEST['post']);
			}
			
			if(empty($post_ids)) return;
			
			// this is based on wp-admin/edit.php
			$sendback = remove_query_arg( array('nm_updated', 'nm_removed', 'untrashed', 'deleted', 'ids'), wp_get_referer() );
			if ( ! $sendback )
				$sendback = admin_url( "edit.php?post_type=$post_type" );
				
			$pagenum = $wp_list_table->get_pagenum();
			$sendback = add_query_arg( 'paged', $pagenum, $sendback );
			
			$nm_do_action = substr($action, 0, 10);
			switch($nm_do_action) {
				case 'nm_action_':
				$nm_updated = 0;
				foreach( $post_ids as $post_id ) {
							
					update_post_meta ( $post_id, '_product_meta_id', substr($action, 10) );
			
					$nm_updated++;
				}
				$sendback = add_query_arg( array('nm_updated' => $nm_updated, 'ids' => join(',', $post_ids)), $sendback );
			}
			switch($action) {
				case 'nm_delete_meta':
				$nm_removed = 0;
				foreach( $post_ids as $post_id ) {
							
					delete_post_meta ( $post_id, '_product_meta_id' );
			
					$nm_removed++;
				}
				$sendback = add_query_arg( array('nm_removed' => $nm_removed, 'ids' => join(',', $post_ids)), $sendback );
			}
			$sendback = remove_query_arg( array('action', 'action2', 'tags_input', 'post_author', 'comment_status', 'ping_status', '_status',  'post', 'bulk_edit', 'post_view'), $sendback );
			wp_redirect($sendback);
			exit();
		}
	}
	/**
	 * display an admin notice on the Products page after updating meta
	 */
	function nm_add_meta_notices() {
		global $post_type, $pagenow;
			
		if($pagenow == 'edit.php' && $post_type == 'product' && isset($_REQUEST['nm_updated']) && (int) $_REQUEST['nm_updated']) {
			$message = sprintf( _n( 'Product meta updated.', '%s Products meta updated.', $_REQUEST['nm_updated'] ), number_format_i18n( $_REQUEST['nm_updated'] ) );
			echo "<div class=\"updated\"><p>{$message}</p></div>";
		}
		elseif($pagenow == 'edit.php' && $post_type == 'product' && isset($_REQUEST['nm_removed']) && (int) $_REQUEST['nm_removed']){
			$message = sprintf( _n( 'Product meta removed.', '%s Products meta removed.', $_REQUEST['nm_removed'] ), number_format_i18n( $_REQUEST['nm_removed'] ) );
			echo "<div class=\"updated\"><p>{$message}</p></div>";	
		}
	}
	 	
	function add_productmeta_meta_box() {
		add_meta_box ( 'woocommerce-image-upload', __ ( 'Select Personalized Meta', 'nm-personalizedproduct' ), array (
				$this,
				'product_meta_box' 
		), 'product', 'side', 'default' );
	}
	function product_meta_box($post) {
		$existing_meta_id = get_post_meta ( $post->ID, '_product_meta_id', true );
		$all_meta = $this -> get_product_meta_all ();
		
		echo '<p>';
		
		// NONE
		echo '<label class="single-product-label" for="select_meta_group-none">';
		echo '<input name="nm_product_meta" type="radio" value="0" checked="checked" id="select_meta_group-none" />';
		echo ' ' . __('None', 'nm-personalizedproduct'). '</label><br>';
		
		
		foreach ( $all_meta as $meta ) {
			
			if ($meta->productmeta_id == $existing_meta_id)
				$selected = 'checked="checked"';
			else
				$selected = '';
			
			echo '<label class="single-product-label" for="select_meta_group-' . $meta->productmeta_id . '">';
			echo '<input name="nm_product_meta" type="radio" value="' . $meta->productmeta_id . '" ' . $selected . ' id="select_meta_group-' . $meta->productmeta_id . '" />';
			echo ' ' . $meta->productmeta_name . '</label><br>';
		}
		
		echo '</p>';
	}
	
	
	function get_product_meta_all() {
		global $wpdb;
		
		$qry = "SELECT * FROM " . $wpdb->prefix . self::$tbl_productmeta;
		$res = $wpdb->get_results ( $qry );
		
		return $res;
	}
	
	/*
	 * saving meta data against product
	 */
	function process_product_meta($post_id, $post) {
		
		
		/* nm_personalizedproduct_pa($_POST); exit; */

		if($_POST ['nm_product_meta'] != '')
			update_post_meta ( $post_id, '_product_meta_id', $_POST ['nm_product_meta'] );
	}
	
	/*
	 * rendering shortcode meat
	 */
	function render_product_meta() {
		global $post;
		
		$this -> productmeta_id = get_post_meta ( $post->ID, '_product_meta_id', true );
		
		if ($this -> productmeta_id) {
			
			$this -> load_template ( 'render.input.php' );
		}
		
		return false;
	}
	
	/*
	 * validating before adding to cart
	 */
	function validate_data_before_cart($passed, $product_id, $qty) {
		global $woocommerce;
		
		$selected_meta_id = get_post_meta ( $product_id, '_product_meta_id', true );
		
		$single_meta = $this -> get_product_meta ( $selected_meta_id );
		$existing_meta = json_decode ( $single_meta->the_meta );
		
		//nm_personalizedproduct_pa($_POST);
		
		if ($existing_meta) {
			foreach ( $existing_meta as $meta ) {
				
				$element_name = strtolower ( preg_replace ( "![^a-z0-9]+!i", "_", $meta->data_name ) );
				//
				
				if ($meta->type == 'checkbox') {
					
					$element_value = $_POST [$element_name];
					if ($meta->required == 'on' && (count ( $element_value ) == 0)) {
						$passed = false;
						if ($meta->error_message)
							$woocommerce->add_error ( stripslashes ( $meta->error_message ) );
						else
							$woocommerce->add_error ( sprintf ( __ ( '"%s" is a required field.', 'woocommerce' ), $meta->title ) );
					} elseif ($meta->min_checked != '' && (count ( $element_value ) < $meta->min_checked)) {
						$passed = false;
						if ($meta->error_message)
							$woocommerce->add_error ( stripslashes ( $meta->error_message ) );
						else
							$woocommerce->add_error ( sprintf ( __ ( '"%s" is a required field.', 'woocommerce' ), $meta->title ) );
					} elseif ($meta->max_checked != '' && (count ( $element_value ) > $meta->max_checked)) {
						$passed = false;
						if ($meta->error_message)
							$woocommerce->add_error ( stripslashes ( $meta->error_message ) );
						else
							$woocommerce->add_error ( sprintf ( __ ( '"%s" is a required field.', 'woocommerce' ), $meta->title ) );
					}
				} elseif ($meta->type == 'file') {
					$element_value = $_POST ['thefile_' . $element_name];
					if ($meta->required == 'on' && (count ( $element_value ) == 0)) {
						$passed = false;
						if ($meta->error_message)
							$woocommerce->add_error ( stripslashes ( $meta->error_message ) );
						else
							$woocommerce->add_error ( sprintf ( __ ( '"%s" is a required field.', 'woocommerce' ), $meta->title ) );
					}
				} elseif ($meta->type == 'image') {
					$element_value = $_POST [$element_name];
					
					if ($meta->required == 'on') {
						if (is_array ( $element_value )) {
							
							if (count ( $element_value ) == 0) {
								$passed = false;
								if ($meta->error_message)
									$woocommerce->add_error ( stripslashes ( $meta->error_message ) );
								else
									$woocommerce->add_error ( sprintf ( __ ( '"%s" is a required field.', 'woocommerce' ), $meta->title ) );
							}
						} elseif ($element_value == '') {
							$passed = false;
							if ($meta->error_message)
								$woocommerce->add_error ( stripslashes ( $meta->error_message ) );
							else
								$woocommerce->add_error ( sprintf ( __ ( '"%s" is a required field.', 'woocommerce' ), $meta->title ) );
						}
					}
					
				} else {
					$element_value = sanitize_text_field ( $_POST [$element_name] );
					
					if ($meta->required == 'on' && $element_value == '') {
						$passed = false;
						if ($meta->error_message)
							$woocommerce->add_error ( stripslashes ( $meta->error_message ) );
						else
							$woocommerce->add_error ( sprintf ( __ ( '"%s" is a required field.', 'woocommerce' ), $meta->title ) );
					}
				}
				
			}
		}
		
		return $passed;
	}
	function get_product_meta($meta_id) {
		global $wpdb;
		
		$qry = "SELECT * FROM " . $wpdb->prefix . self::$tbl_productmeta . " WHERE productmeta_id = $meta_id";
		$res = $wpdb->get_row ( $qry );
		
		return $res;
	}
	
	/*
	 * Adding product meta to cart A very important function
	 */
	function add_product_meta_to_cart($the_cart_data, $product_id) {
		global $woocommerce;
		
		$selected_meta_id = get_post_meta ( $product_id, '_product_meta_id', true );
		/* nm_personalizedproduct_pa($_POST);
		exit; */
		
		/*
		 * now extracting product meta values
		 */
		
		$single_meta = $this -> get_product_meta ( $selected_meta_id );
		$product_meta = json_decode ( $single_meta->the_meta );
		
		$product_meta_data = array (); // this array is giong to be pushed into with data
		
		if ($product_meta) {
			
			// nm_personalizedproduct_pa($product_meta);
			
			$var_price = 0;
			foreach ( $product_meta as $meta ) {
				
				$element_name = strtolower ( preg_replace ( "![^a-z0-9]+!i", "_", $meta->data_name ) );
				
				/* nm_personalizedproduct_pa($_POST);
				exit; */
				if ($meta->type == 'checkbox') {
					
					
					if ($_POST [$element_name])
						$element_value = implode ( ",", $_POST [$element_name] );
				} else if ($meta->type == 'select' || $meta->type == 'radio') {
					
				$element_value = sanitize_text_field ( $_POST [$element_name] );
				} elseif ($meta->type == 'file') {
					
					$element_value = $_POST ['thefile_' . $element_name];
					
					if($element_value){
						$all_files[$meta->title] = $element_value;	
						$file_key = __ ( '_File(s) attached', 'nm-personalizedproduct' );
					}
					
				}elseif ($meta->type == 'image') {
					
					$element_value = $_POST [$element_name];
										
					if($element_value){
						$selected_images = array('type'		=> 'image',
							'selected'	=> $element_value);
												
						//$selected_image_key = __ ( 'Image(s) selected', 'nm-personalizedproduct' );
						$product_meta_data [$meta->title] = $selected_images;
					}
					
				} else {
					$element_value = sanitize_text_field ( $_POST [$element_name] );
					
				}
				
				// finally saving values into meta array
				if ($meta->type != 'section' && $meta->type != 'image'){
					
					if (is_array($element_value)){
						$product_meta_data [$meta->title] = $element_value;
					}else{
						$product_meta_data [$meta->title] = stripslashes( $element_value );
					}	
				}
				
				// calculating price
				/* $var_price += $the_price;
				$the_price = 0; */
				
				
			}
		}
		
		//adding attachments
		if($all_files){
			$product_meta_data [$file_key] = $this -> make_filename_link ( $all_files );
			$product_ref_data ['_product_attached_files'] = $all_files;
		}
			
		
		// options price
		if(isset($_POST['woo_option_price']) && $_POST['woo_option_price'] != 0){
			$var_price = $_POST['woo_option_price'];
		}
		
		//nm_personalizedproduct_pa($product_meta_data); exit;
		
		$the_cart_data ['product_meta'] = array (
				'meta_data' => $product_meta_data,
				'var_price' => $var_price,
				'_product_attached_files'	=> $all_files
		);
		
		/* nm_personalizedproduct_pa($the_cart_data); exit; */
		
		return $the_cart_data;
	}
	
	/*
	 * cart session data Ok, this value is being pulled on Cart/Checkout page
	 */
	function get_cart_session_data($the_cart_data, $values) {
		
		//nm_personalizedproduct_pa($values); 
		
		if (isset ( $values ['product_meta'] )) :
			$the_cart_data ['product_meta'] = $values ['product_meta'];		
		endif;
		
		$the_cart_data ['data']->adjust_price ( $values ['product_meta'] ['var_price'] );
		
		/* nm_personalizedproduct_pa($the_cart_data); */
		
		return $the_cart_data;
	}
	
	/*
	 * this function is showing item meta on cart/checkout page
	 */
	function add_item_meta($item_meta, $existing_item_meta) {
		
		//nm_personalizedproduct_pa($existing_item_meta ['product_meta']['meta_data']);
		
		if ($existing_item_meta ['product_meta']['meta_data']) {
			foreach ( $existing_item_meta ['product_meta'] ['meta_data'] as $key => $val ) {
				
				if($val)
					if (is_array($val)) {
						if($val['type'] == 'image'){
							
							// if selected designs are more then one
							if(is_array($val['selected'])){
								$_v = '';
								foreach ($val['selected'] as $selected){
									$_v .= basename($selected).',';
								}
								$item_meta [] = array (
										'name' => $key,
										'value' => $_v,
								);
							}else{
								$item_meta [] = array (
										'name' => $key,
										'value' => basename($val['selected'])
								);
							}
						}else{
							$item_meta [] = array (
									'name' => $key,
									'value' => implode(',', $val),
							);
						}
						
					}else{
						
						$item_meta [] = array (
								'name' => $key,
								'value' => stripslashes( $val ),
						);
					}
					
			}
		}
		
		
		/* nm_personalizedproduct_pa($item_meta); */
		return $item_meta;
	}
	
	/*
	 * Adding item meta to order from $cart_item On checkout page, saving meta from CART to ITEM__ORDER
	 */
	function order_item_meta($item_id, $cart_item) {
		
		
		 //nm_personalizedproduct_pa($cart_item); exit;
		
		if (isset ( $cart_item ['product_meta'] )) {
			
			foreach ( $cart_item ['product_meta'] ['meta_data'] as $key => $val ) {
				// $item_meta->add( $key, $val );
				
				if($val)
					woocommerce_add_order_item_meta ( $item_id, $key, $val );
			}
			
			// adding _product_attached_files
			woocommerce_add_order_item_meta ( $item_id, '_product_attached_files', $cart_item ['product_meta']['_product_attached_files'] );
			
		}
	}
	
	/*
	 * make filename linkable used in cart data
	 */
	function make_filename_link($all_files) {

		$linkable = '';
		
		if ($all_files) {
				
			foreach ($all_files as $title => $product_files ) {
				
				$linkable .= '<br><strong>' . $title . '</strong>';
				foreach ( $product_files as $key => $filename ) {
					
					$ext = strtolower ( substr ( strrchr ( $filename, '.' ), 1 ) );
					
					if ($ext == 'png' || $ext == 'jpg' || $ext == 'gif' || $ext == 'jpeg')
						$src_thumb = $this->get_file_dir_url ( true ) . $filename;
					else
						$src_thumb = $this->plugin_meta ['url'] . '/images/file.png';
					
					$img = '<img src="' . $src_thumb . '" alt="uploaded file">';
					
					$edited_file = $this->get_file_dir_path () . 'edits/' . $filename;
					
					if (file_exists ( $edited_file )) {
						$file_link = $this->get_file_dir_url () . 'edits/' . $filename;
					} else {
						$file_link = $this->get_file_dir_url () . $filename;
					}
					
					// $linkable = '<a href='.$this -> get_file_dir_url() . $filename.' class="zoom" itemprop="image" title="'.$filename.'" rel="prettyPhoto">'.$filename.'</a>';
					$linkable .= '<br><a href=' . $file_link . ' class="lightbox" itemprop="image" title="' . $filename . '">' . $img . '</a>';
					$linkable .= ' ' . $filename;
				}
			}
			
			return $linkable;
		}
		
	}
	
	/*
	 * rendering meta box in orders
	 */
	function render_product_files_in_orders() {
		add_meta_box ( 'orders_product_file_uploaded', __('Files attached/uploaded against Products','nm-personalizedproduct'),
					array ($this, 'display_uploaded_files'), 
					'shop_order', 'normal', 'default' );
		
		
		// adding meta box for pre-defined images selection
		add_meta_box ( 'selected_images_in_orders', __('Selected images/designs', 'nm-personalizedproduct'), 
						array ( $this, 'display_selected_files'),
						'shop_order', 'normal', 'default' );
	}
	
	
	function display_uploaded_files($order) {
		
		global $wpdb;
		$files_found = 0;
		$order_items = $wpdb->get_results ( $wpdb->prepare ( "SELECT * FROM {$wpdb->prefix}woocommerce_order_items WHERE order_id = %d", $order->ID ) );
		
		$order = new WC_Order ( $order->ID );
		//nm_personalizedproduct_pa($order);
		if (sizeof ( $order->get_items () ) > 0) {
			foreach ( $order->get_items () as $item ) {
				
				/* get_metadata( 'order_item', $item_id, $key, $single );
				$all_files = wc_get_order_item_meta($item ['product_id'], 'Your title', true);
				nm_personalizedproduct_pa($item); */
				
				$selected_meta_id = get_post_meta ( $item ['product_id'], '_product_meta_id', true );
				
				$single_meta = $this -> get_product_meta ( $selected_meta_id);
				$product_meta = json_decode ( $single_meta->the_meta );

				
				
				//nm_personalizedproduct_pa($product_meta);
				if($product_meta){
					
					foreach ( $product_meta as $meta => $data ) {
					
						if ($data -> type == 'file') {
							$product_files = $item[$data -> title];
							$product_id = $item ['product_id'];
					
							if ($product_files) {
								
								echo '<strong>';
								printf(__('File attached %s', 'nm-personalizedproduct'), $data->title);
								echo '</strong>';
									
								$product_files = unserialize( $product_files );
								
								foreach ( $product_files as $file ) {
					
									$files_found++;
									$ext = strtolower ( substr ( strrchr ( $file, '.' ), 1 ) );
					
									if ($ext == 'png' || $ext == 'jpg' || $ext == 'gif' || $ext == 'jpeg')
										$src_thumb = $this -> get_file_dir_url ( true ) . $file;
									else
										$src_thumb = $this -> plugin_meta ['url'] . '/images/file.png';
					
									$src_file = $this -> get_file_dir_url () . $file;
									
									if(!file_exists($src_file)){
										$file_name = $order -> id . '-' . $product_id . '-' . $file;		// from version 3.4
										$src_file = $this -> get_file_dir_url () . 'confirmed/' . $file_name;
									}else{
										$file_name = $file;
									}
									
					
									echo '<table>';
									echo '<tr><td width="100"><img src="' . $src_thumb . '"><td><td><a href="' . $src_file . '">' . __ ( 'Download ' ) . $file_name . '</a> ' . $this -> size_in_kb ( $file_name ) . '</td>';
									
									$edited_path = $this->get_file_dir_path() . 'edits/' . $file;
									if (file_exists($edited_path)) {
										$file_url_edit = $this->get_file_dir_url () .  'edits/' . $file;
										echo '<td><a href="' . $file_url_edit . '" target="_blank">' . __ ( 'Download edited image', $this->plugin_meta ['shortname'] ) . '</a></td>';
									}
									
									echo '</tr>';
									echo '</table>';
								}
							}

							 if ($files_found == 0){
									
								echo __ ( 'No file attached/uploaded', 'nm-personalizedproduct' );
							}
						}
					}
				}
				
			}
		}
	}
	
	
	function display_selected_files($order) {
		// woo_pa($order);
		global $wpdb;
		$order_items = $wpdb->get_results ( $wpdb->prepare ( "SELECT * FROM {$wpdb->prefix}woocommerce_order_items WHERE order_id = %d", $order->ID ) );
	
		$order = new WC_Order ( $order->ID );
	
		if (sizeof ( $order->get_items () ) > 0) {
			foreach ( $order->get_items () as $item ) {
	
				//nm_personalizedproduct_pa($item);
	
				$selected_meta_id = get_post_meta ( $item ['product_id'], '_product_meta_id', true );
	
				$single_meta = $this -> get_product_meta ( $selected_meta_id);
				$product_meta = json_decode ( $single_meta->the_meta );
	
				echo '<h2>' . __ ( 'Selected pre defined image: ' . $item ['name'], 'nm-personalizedproduct' ) . '</h2>';
				echo '<p>';
				// nm_personalizedproduct_pa($product_meta);
				if($product_meta){
						
					foreach ( $product_meta as $meta => $data ) {
							
						if ($data -> type == 'image') {
							$product_files = $item[$data -> title];
								
							if ($product_files) {
									
								echo '<h3>' . $data -> title . '</h3>';
									
								$product_files = unserialize( $product_files );

								// nm_personalizedproduct_pa($product_files);
								
								if (is_array($product_files['selected'])) {
									
									foreach ( $product_files['selected'] as $file ) {
										
										$ext = strtolower ( substr ( strrchr ( $file, '.' ), 1 ) );
											
										if ($ext == 'png' || $ext == 'jpg' || $ext == 'gif')
											$src_thumb = $this -> get_file_dir_url ( true ) . $file;
										else
											$src_thumb = $this -> plugin_meta ['url'] . '/images/file.png';
											
										$src = $file;
											
										echo '<table>';
										echo '<tr><td width="100"><img width="250" src="' . $src . '"><td><td><a href="' . $src . '">' . __ ( 'Download ' ) . $file . '</a></td>';
											
										echo '</tr>';
										echo '</table>';
										
									}
								}else{
									
									$file = $product_files['selected'];
									$ext = strtolower ( substr ( strrchr ( $file, '.' ), 1 ) );
									
									if ($ext == 'png' || $ext == 'jpg' || $ext == 'gif')
										$src_thumb = $this -> get_file_dir_url ( true ) . $file;
									else
										$src_thumb = $this -> plugin_meta ['url'] . '/images/file.png';
									
									$src = $file;
									
									echo '<table>';
									echo '<tr><td width="100"><img width="250" src="' . $src . '"><td><td><a href="' . $src . '">' . __ ( 'View ' ) . $file . '</a></td>';
									
									echo '</tr>';
									echo '</table>';
								}
								
							} else {
									
								echo __ ( 'No file attached/uploaded', 'nm-personalizedproduct' );
							}
						}
					}
				}
	
				echo '</p>';
			}
		}
	}
	
	
	function size_in_kb($file_name) {
		$base_dir = $this -> get_file_dir_path ();
		$size = filesize ( $base_dir . 'confirmed/' . $file_name );
		
		return round ( $size / 1024, 2 ) . ' KB';
	}
	
	/*
	 * saving form meta in admin call
	 */
	function save_form_meta() {
		
		// print_r($_REQUEST); exit;
		global $wpdb;
		
		extract ( $_REQUEST );
		
		$dt = array (
				'productmeta_name' => $productmeta_name,
				'aviary_api_key' => trim ( $aviary_api_key ),
				'productmeta_style' => $productmeta_style,
				'the_meta' => json_encode ( $product_meta ),
				'productmeta_created' => current_time ( 'mysql' ) 
		);
		
		$format = array (
				'%s',
				'%s',
				'%s',
				'%s',
				'%s' 
		);
		
		$res_id = $this -> insert_table ( self::$tbl_productmeta, $dt, $format );
		
		/* $wpdb->show_errors(); $wpdb->print_error(); */
		
		$resp = array ();
		if ($res_id) {
			
			$resp = array (
					'message' => __ ( 'Form added successfully', 'nm-personalizedproduct' ),
					'status' => 'success',
					'productmeta_id' => $res_id 
			);
		} else {
			
			$resp = array (
					'message' => __ ( 'Error while savign form, please try again', 'nm-personalizedproduct' ),
					'status' => 'failed',
					'productmeta_id' => '' 
			);
		}
		
		echo json_encode ( $resp );
		
		die ( 0 );
	}
	
	/*
	 * updating form meta in admin call
	 */
	function update_form_meta() {
		
		// print_r($_REQUEST); exit;
		global $wpdb;
		
		extract ( $_REQUEST );
		
		$dt = array (
				'productmeta_name' => $productmeta_name,
				'aviary_api_key' => trim ( $aviary_api_key ),
				'productmeta_style' => $productmeta_style,
				'the_meta' => json_encode ( $product_meta ) 
		);
		
		$where = array (
				'productmeta_id' => $productmeta_id 
		);
		
		$format = array (
				'%s',
				'%s',
				'%s',
				'%s' 
		);
		$where_format = array (
				'%d' 
		);
		
		$res_id = $this -> update_table ( self::$tbl_productmeta, $dt, $where, $format, $where_format );
		
		// $wpdb->show_errors(); $wpdb->print_error();
		
		$resp = array ();
		if ($res_id) {
			
			$resp = array (
					'message' => __ ( 'Form updated successfully', 'nm-personalizedproduct' ),
					'status' => 'success',
					'productmeta_id' => $productmeta_id 
			);
		} else {
			
			$resp = array (
					'message' => __ ( 'Error while updating form, please try again', 'nm-personalizedproduct' ),
					'status' => 'failed',
					'productmeta_id' => $productmeta_id 
			);
		}
		
		echo json_encode ( $resp );
		
		die ( 0 );
	}
	
	/*
	 * saving admin setting in wp option data table
	 */
	function save_settings() {
		
		// $this -> pa($_REQUEST);
		$existingOptions = get_option ( 'nm-personalizedproduct' . '_settings' );
		// pa($existingOptions);
		
		update_option ( 'nm-personalizedproduct' . '_settings', $_REQUEST );
		_e ( 'All options are updated', 'nm-personalizedproduct' );
		die ( 0 );
	}
	
	/*
	 * rendering template against shortcode
	 */
	function render_shortcode_template($atts) {
		extract ( shortcode_atts ( array (
				'productmeta_id' => '' 
		), $atts ) );
		
		$this -> productmeta_id = $productmeta_id;
		
		ob_start ();
		
		$this -> load_template ( 'render.input.php' );
		
		$output_string = ob_get_contents ();
		ob_end_clean ();
		
		return $output_string;
	}
	
	
	/*
	 * returning price for option in wc price format
	 */
	function get_option_price(){

		echo wc_price(intval($_REQUEST['price1']));
		
		die(0);
	}
	
	/*
	 * uploading file here
	 */
	function upload_file() {
		
		
		header ( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
		header ( "Last-Modified: " . gmdate ( "D, d M Y H:i:s" ) . " GMT" );
		header ( "Cache-Control: no-store, no-cache, must-revalidate" );
		header ( "Cache-Control: post-check=0, pre-check=0", false );
		header ( "Pragma: no-cache" );
		
		// setting up some variables
		$file_dir_path = $this->setup_file_directory ();
		$response = array ();
		if ($file_dir_path == 'errDirectory') {
			
			$response ['status'] = 'error';
			$response ['message'] = __ ( 'Error while creating directory', $this->plugin_shortname );
			die ( 0 );
		}
		
		$cleanupTargetDir = true; // Remove old files
		$maxFileAge = 5 * 3600; // Temp file age in seconds
		                        
		// 5 minutes execution time
		@set_time_limit ( 5 * 60 );
		
		// Uncomment this one to fake upload time
		// usleep(5000);
		
		// Get parameters
		$chunk = isset ( $_REQUEST ["chunk"] ) ? intval ( $_REQUEST ["chunk"] ) : 0;
		$chunks = isset ( $_REQUEST ["chunks"] ) ? intval ( $_REQUEST ["chunks"] ) : 0;
		$file_name = isset ( $_REQUEST ["name"] ) ? $_REQUEST ["name"] : '';
		
		// Clean the fileName for security reasons
		$file_name = preg_replace ( '/[^\w\._]+/', '_', $file_name );
		
		// Make sure the fileName is unique but only if chunking is disabled
		if ($chunks < 2 && file_exists ( $file_dir_path . $file_name )) {
			$ext = strrpos ( $file_name, '.' );
			$file_name_a = substr ( $file_name, 0, $ext );
			$file_name_b = substr ( $file_name, $ext );
			
			$count = 1;
			while ( file_exists ( $file_dir_path . $file_name_a . '_' . $count . $file_name_b ) )
				$count ++;
			
			$file_name = $file_name_a . '_' . $count . $file_name_b;
		}
		
		// Remove old temp files
		if ($cleanupTargetDir && is_dir ( $file_dir_path ) && ($dir = opendir ( $file_dir_path ))) {
			while ( ($file = readdir ( $dir )) !== false ) {
				$tmpfilePath = $file_dir_path . $file;
				
				// Remove temp file if it is older than the max age and is not the current file
				if (preg_match ( '/\.part$/', $file ) && (filemtime ( $tmpfilePath ) < time () - $maxFileAge) && ($tmpfilePath != "{$file_path}.part")) {
					@unlink ( $tmpfilePath );
				}
			}
			
			closedir ( $dir );
		} else
			die ( '{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}' );
		
		$file_path = $file_dir_path . $file_name;
		
		// Look for the content type header
		if (isset ( $_SERVER ["HTTP_CONTENT_TYPE"] ))
			$contentType = $_SERVER ["HTTP_CONTENT_TYPE"];
		
		if (isset ( $_SERVER ["CONTENT_TYPE"] ))
			$contentType = $_SERVER ["CONTENT_TYPE"];
			
			// Handle non multipart uploads older WebKit versions didn't support multipart in HTML5
		if (strpos ( $contentType, "multipart" ) !== false) {
			if (isset ( $_FILES ['file'] ['tmp_name'] ) && is_uploaded_file ( $_FILES ['file'] ['tmp_name'] )) {
				// Open temp file
				$out = fopen ( "{$file_path}.part", $chunk == 0 ? "wb" : "ab" );
				if ($out) {
					// Read binary input stream and append it to temp file
					$in = fopen ( $_FILES ['file'] ['tmp_name'], "rb" );
					
					if ($in) {
						while ( $buff = fread ( $in, 4096 ) )
							fwrite ( $out, $buff );
					} else
						die ( '{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}' );
					fclose ( $in );
					fclose ( $out );
					@unlink ( $_FILES ['file'] ['tmp_name'] );
				} else
					die ( '{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}' );
			} else
				die ( '{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}' );
		} else {
			// Open temp file
			$out = fopen ( "{$file_path}.part", $chunk == 0 ? "wb" : "ab" );
			if ($out) {
				// Read binary input stream and append it to temp file
				$in = fopen ( "php://input", "rb" );
				
				if ($in) {
					while ( $buff = fread ( $in, 4096 ) )
						fwrite ( $out, $buff );
				} else
					die ( '{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}' );
				
				fclose ( $in );
				fclose ( $out );
			} else
				die ( '{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}' );
		}
		
		// Check if file has been uploaded
		if (! $chunks || $chunk == $chunks - 1) {
			// Strip the temp .part suffix off
			rename ( "{$file_path}.part", $file_path );
			
			// making thumb if images
			if($this -> is_image($file_name))
			{
				$thumb_size = 175;
				$this->create_thumb($file_dir_path, $file_name, $thumb_size);
			}
			
		}
		
		if($this -> is_image($file_name))
		{
			list($fw, $fh) = getimagesize($this->get_file_dir_url(true) . $file_name);
			$response = array(
					'file_name'			=> $file_name,
					'file_w'			=> $fw,
					'file_h'			=> $fh);
		}else{
			$response = array(
					'file_name'			=> $file_name,
					'file_w'			=> 'na',
					'file_h'			=> 'na');
		}
		
		
		// Return JSON-RPC response
		//die ( '{"jsonrpc" : "2.0", "result" : '. json_encode($response) .', "id" : "id"}' );
		die ( json_encode($response) );
		
		/*
		 * if (! empty ( $_FILES )) { $tempFile = $_FILES ['Filedata'] ['tmp_name']; $targetPath = $file_dir_path; $new_filename = strtotime ( "now" ) . '-' . preg_replace ( "![^a-z0-9.]+!i", "_", $_FILES ['Filedata'] ['name'] ); $targetFile = rtrim ( $targetPath, '/' ) . '/' . $new_filename; $thumb_size = $this->get_option ( '_thumb_size' ); $thumb_size = ($thumb_size == '') ? 75 : $thumb_size; $type = strtolower ( substr ( strrchr ( $new_filename, '.' ), 1 ) ); if (move_uploaded_file ( $tempFile, $targetFile )) { if (($type == "gif") || ($type == "jpeg") || ($type == "png") || ($type == "pjpeg") || ($type == "jpg")) $this->create_thumb ( $targetPath, $new_filename, $thumb_size ); $response ['status'] = 'uploaded'; $response ['filename'] = $new_filename; } else { $response ['status'] = 'error'; $response ['message'] = __ ( 'Error while uploading file', $this->plugin_shortname ); } } echo json_encode ( $response );
		 */
	}
	
	/*
	 * deleting uploaded file from directory
	 */
	function delete_file() {
		$dir_path = $this -> setup_file_directory ();
		echo "file path along with the file name".$file_path = $dir_path . $_REQUEST ['file_name'];
		
		if (unlink ( $file_path )) {
			echo __ ( 'File removed', 'nm-personalizedproduct' );
			
			if ($_REQUEST ['is_image'] == "true")
				unlink ( $dir_path . 'thumbs/' . $_REQUEST ['file_name'] );
		} else {
			echo __ ( 'Error while deleting file ' . $file_path );
		}
		
		die ( 0 );
	}
	
	/*
	 * this function is saving photo returned by Aviary
	 */
	function save_edited_photo() {
		$file_path = $this -> plugin_meta ['path'] . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'aviary.php';
		if (! file_exists ( $file_path )) {
			die ( 'Could not find file ' . $file_path );
		}
		
		include_once $file_path;
		
		$aviary = new NM_Aviary ();
		
		// setting plugin meta saved in config.php
		$aviary->plugin_meta = get_plugin_meta_productmeta ();
		
		$aviary->dir_path = $this->get_file_dir_path ();
		$aviary->dir_name = $this -> product_files;
		$aviary->posted_data = json_decode ( stripslashes ( $_REQUEST ['postdata'] ) );
		$aviary->image_data = file_get_contents ( $_REQUEST ['url'] );
		$aviary->image_url	= $_REQUEST ['url'];
		
		$aviary -> save_file_locally();
		
		die ( 0 );
	}
	
	/*
	 * 9- adding files link in order email
	 */
	function add_files_link_in_email($order, $is_admin){
		
		if (sizeof ( $order->get_items () ) > 0) {
			foreach ( $order->get_items () as $item ) {
		
				// nm_personalizedproduct_pa($item);
		
				$selected_meta_id = get_post_meta ( $item ['product_id'], '_product_meta_id', true );
		
				$single_meta = $this -> get_product_meta ( $selected_meta_id);
				$product_meta = json_decode ( $single_meta->the_meta );
		
		
				
				// nm_personalizedproduct_pa($product_meta);
				if($product_meta){
						
					foreach ( $product_meta as $meta => $data ) {
							
						if ($data -> type == 'file') {
							$product_files = $item[$data -> title];
							$product_id = $item ['product_id'];
								
							if ($product_files) {
								
								echo '<strong>';
								printf(__('File attached %s', 'nm-personalizedproduct'), $data->title);
								echo '</strong>';
									
									
								$product_files = unserialize( $product_files );
		
								foreach ( $product_files as $file ) {
										
									$files_found++;
									$ext = strtolower ( substr ( strrchr ( $file, '.' ), 1 ) );
										
									if ($ext == 'png' || $ext == 'jpg' || $ext == 'gif' || $ext == 'jpeg')
										$src_thumb = $this -> get_file_dir_url ( true ) . $file;
									else
										$src_thumb = $this -> plugin_meta ['url'] . '/images/file.png';
										
									$src_file = $this -> get_file_dir_url () . $file;
										
									if(!file_exists($src_file)){
										$file_name = $order -> id . '-' . $product_id . '-' . $file;		// from version 3.4
										$src_file = $this -> get_file_dir_url () . 'confirmed/' . $file_name;
									}else{
										$file_name = $file;
									}
										
										
									echo '<table>';
									echo '<tr><td width="100"><img src="' . $src_thumb . '"><td><td><a href="' . $src_file . '">' . __ ( 'Download ' ) . $file_name . '</a> ' . $this -> size_in_kb ( $file_name ) . '</td>';
										
									$edited_path = $this->get_file_dir_path() . 'edits/' . $file;
									if (file_exists($edited_path)) {
										$file_url_edit = $this->get_file_dir_url () .  'edits/' . $file;
										echo '<td><a href="' . $file_url_edit . '" target="_blank">' . __ ( 'Download edited image', $this->plugin_meta ['shortname'] ) . '</a></td>';
									}
										
									echo '</tr>';
									echo '</table>';
								}
							}
		
							
						}
					}
				}
		
			}
		}
	}
	
	// ================================ SOME HELPER FUNCTIONS =========================================
	
	/*
	 * simplifying meta for admin view in existing-meta.php
	 */
	function simplify_meta($meta) {
		$metas = json_decode ( $meta );
		
		if ($metas) {
			echo '<ul>';
			foreach ( $metas as $meta => $data ) {
				
				$req = ($data->required == 'on') ? 'yes' : 'no';
				
				echo '<li>';
				echo '<strong>label:</strong> ' . $data->title;
				echo ' | <strong>type:</strong> ' . $data->type;
				
				if (! is_object ( $data->options ))
					echo ' | <strong>options:</strong> ' . $data->options;
				echo ' | <strong>required:</strong> ' . $req;
				echo '</li>';
			}
			
			echo '</ul>';
		}
	}
	
	/*
	 * delete meta
	 */
	function delete_meta() {
		global $wpdb;
		
		extract ( $_REQUEST );
		
		$res = $wpdb->query ( "DELETE FROM `" . $wpdb->prefix . self::$tbl_productmeta . "` WHERE productmeta_id = " . $productmeta_id );
		
		if ($res) {
			
			_e ( 'Meta deleted successfully', 'nm-personalizedproduct' );
		} else {
			$wpdb->show_errors ();
			$wpdb->print_error ();
		}
		
		die ( 0 );
	}
	
	/*
	 * setting up user directory
	 */
	function setup_file_directory() {
		$upload_dir = wp_upload_dir ();
		
		$dirPath = $upload_dir ['basedir'] . '/' . $this -> product_files . '/';
		
		if (! is_dir ( $dirPath )) {
			if (mkdir ( $dirPath, 0775, true ))
				$dirThumbPath = $dirPath . 'thumbs/';
			if (mkdir ( $dirThumbPath, 0775, true ))
				return $dirPath;
			else
				return 'errDirectory';
		} else {
			$dirThumbPath = $dirPath . 'thumbs/';
			if (! is_dir ( $dirThumbPath )) {
				if (mkdir ( $dirThumbPath, 0775, true ))
					return $dirPath;
				else
					return 'errDirectory';
			} else {
				return $dirPath;
			}
		}
	}
	
	/*
	 * getting file URL
	 */
	function get_file_dir_url($thumbs = false) {

		$upload_dir = wp_upload_dir ();		
		
		if ($thumbs)
			return $upload_dir ['baseurl'] . '/' . $this -> product_files . '/thumbs/';
		else
			return $upload_dir ['baseurl'] . '/' . $this -> product_files . '/';
	}
	function get_file_dir_path() {
		$upload_dir = wp_upload_dir ();
		return $upload_dir ['basedir'] . '/' . $this -> product_files . '/';
	}
	
	/*
	 * creating thumb using WideImage Library Since 21 April, 2013
	 */
	function create_thumb($dest, $image_name, $thumb_size) {
		$wide_image_file = $this -> plugin_meta ['path'] . '/lib/wide-image/WideImage.php';
		
		if (file_exists ( $wide_image_file ))
			include $wide_image_file;
		else
			die ( 'File not found' . $wide_image_file );
		
		$image = WideImage::load ( $dest . $image_name );
		
		$dest_file = $dest . 'thumbs/' . $image_name;
		$result = $image->resize ( $thumb_size )->saveToFile ( $dest_file );
	}
	
	
	function activate_plugin() {
		global $wpdb;
		$plugin_db_version = 3.0;
		/*
		 * meta_for: this is to make this table to contact more then one metas for NM plugins in future in this plugin it will be populated with: forms
		 */
		$forms_table_name = $wpdb->prefix . self::$tbl_productmeta;
		
		$sql = "CREATE TABLE $forms_table_name (
		productmeta_id INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		productmeta_name VARCHAR(50) NOT NULL,
		aviary_api_key VARCHAR(15),
		productmeta_style MEDIUMTEXT,
		the_meta MEDIUMTEXT NOT NULL,
		productmeta_created DATETIME NOT NULL
		);";
		
		require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta ( $sql );
		
		update_option ( "personalizedproduct_db_version", $plugin_db_version );
		
		// this is to remove un-confirmed files daily
		if ( ! wp_next_scheduled( 'do_action_remove_images' ) ) {
			wp_schedule_event( time(), 'daily', 'do_action_remove_images');
		}
	}
	
	/*
	 * removing ununsed order files
	*/
	
	function remove_unpaid_orders_images(){
		
		$dir = $this -> setup_file_directory();
		
		if(is_dir($dir)){

		$dir_handle = opendir($dir);
		while ($file = readdir($dir_handle)){
				
			if(!is_dir($file)){
				@unlink($dir . $file);
			}
		}
				
		}
		
		
		closedir($dir_handle);
	}
	
	
	
	function deactivate_plugin() {
		
		// do nothing so far.
		wp_clear_scheduled_hook( 'do_action_remove_images' );
	}
	
	
	/*
	 * cloning product meta for admin
	 * being called from: templates/admin/create-form.php
	 */
	function clone_product_meta($meta_id){
		
		global $wpdb;
		
		$forms_table_name = $wpdb->prefix . self::$tbl_productmeta;
		
		$sql = "INSERT INTO $forms_table_name
		(productmeta_name, aviary_api_key, productmeta_style, the_meta, productmeta_created) 
		SELECT productmeta_name, aviary_api_key, productmeta_style, the_meta, productmeta_created 
		FROM $forms_table_name 
		WHERE productmeta_id = %d;";
		
		$result = $wpdb -> query($wpdb -> prepare($sql, array($meta_id)));
		
		/* var_dump($result);
		
		$wpdb->show_errors();
		$wpdb->print_error(); */
		
	}
	
	
	/*
	 * checking if aviary addon is installed or not
	 */
	function is_aviary_installed() {
		$aviary_file = $this -> plugin_meta ['path'] . '/lib/aviary.php';
		
		if (file_exists ( $aviary_file ))
			return true;
		else
			return false;
	}
	
	/*
	 * returning NM_Inputs object
	*/
	private function get_all_inputs() {
	
		if (! class_exists ( 'NM_Inputs_wooproduct' )) {
			$_inputs = $this -> plugin_meta ['path'] . '/classes/input.class.php';
			
			if (file_exists ( $_inputs ))
				include_once ($_inputs);
			else
				die ( 'Reen, Reen, BUMP! not found ' . $_inputs );
		}
	
		$nm_inputs = new NM_Inputs_wooproduct ();
		// webcontact_pa($this->plugin_meta);
	
		// registering all inputs here
	
		return array (
				
				'text' 		=> $nm_inputs->get_input ( 'text' ),
				'masked' 	=> $nm_inputs->get_input ( 'masked' ),
				'hidden' 	=> $nm_inputs->get_input ( 'hidden' ),
				'email' 	=> $nm_inputs->get_input ( 'email' ),
				'date' 		=> $nm_inputs->get_input ( 'date' ),
				'color'		=> $nm_inputs->get_input ( 'color' ),
				'textarea' 	=> $nm_inputs->get_input ( 'textarea' ),
				'select' 	=> $nm_inputs->get_input ( 'select' ),
				'radio' 	=> $nm_inputs->get_input ( 'radio' ),
				'checkbox' 	=> $nm_inputs->get_input ( 'checkbox' ),
				'file' 		=> $nm_inputs->get_input ( 'file' ),
				'image' 	=> $nm_inputs->get_input ( 'image' ),
				'instagram'	=> $nm_inputs->get_input ( 'instagram' ),
				'section' 	=> $nm_inputs->get_input ( 'section' ),				
		);
	
		// return new NM_Inputs($this->plugin_meta);
	}
	
	
	/*
	 * check if file is image and return true
	*/
	function is_image($file){
	
		$type = strtolower ( substr ( strrchr ( $file, '.' ), 1 ) );
	
		if (($type == "gif") || ($type == "jpeg") || ($type == "png") || ($type == "pjpeg") || ($type == "jpg"))
			return true;
		else
			return false;
	}
	
	function move_files_when_paid($order_id){
	
	
		global $woocommerce;
	
		// getting product id in cart
		$cart = $woocommerce->cart->get_cart();
	
		$base_path 	= $this -> setup_file_directory();
		$confirmed_dir = $this -> setup_file_directory() . 'confirmed/';
		
		if (! is_dir ( $confirmed_dir )) {
			if (!mkdir ( $confirmed_dir, 0775, true ))
				die('Error while created directory '.$confirmed_dir);
		}	
	
		
		/* nm_personalizedproduct_pa($cart); exit; */
		foreach ($cart as $item){
			$product_id = $item['product_id'];
			$attached_files = $item['product_meta']['_product_attached_files'];
			
			foreach ( $attached_files as $title => $item_files ) {
				
				foreach ( $item_files as $key => $file ) {
					
					$new_filename = $order_id . '-' . $product_id . '-' . $file;
					$source_file = $base_path . $file;
					$destination = $confirmed_dir . $new_filename;
					
					if (file_exists ( $destination ))
						break;
					
					if (file_exists ( $source_file )) {
						
						if (! rename ( $source_file, $destination ))
							die ( 'Error while re-naming order image ' . $source_file );
					}
				}
			}

			
			
		}
		
		
	}
}