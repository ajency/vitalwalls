<?php

add_action('admin_menu', 'mpcth_register_demo_install_page');
function mpcth_register_demo_install_page(){
	global $mpcth_options;

	if (isset($mpcth_options['mpcth_disable_demo_wizard']) && $mpcth_options['mpcth_disable_demo_wizard'] !== '1') {
		add_menu_page(__('Demo Install', 'mpcth'), __('Demo Install', 'mpcth'), 'manage_options', 'demo-install', 'mpcth_demo_install_page', 'dashicons-lightbulb', 201);

		add_action('admin_enqueue_scripts', 'mpcth_demo_install_scripts');
	}
}

function mpcth_demo_install_scripts($hook) {
	if ($hook != 'toplevel_page_demo-install')
		return;

	wp_enqueue_style('mpcth-demos-css', MPC_THEME_URI . '/css/demos.css');

	wp_enqueue_script('mpcth-demos-js', MPC_THEME_URI . '/js/demos.js', array('jquery'));
}

function mpcth_demo_install_page() {
	$images_root = MPC_THEME_URI . '/images/demos/';

	$wordpress_importer_enabled = function_exists('wordpress_importer_init');
	$permalinks_enabled = get_option('permalink_structure');

	$demos_images = array();
	$demos_images[] = array('img' => 'default.jpg',            'bg' => '',                          'anim' => 'long');
	$demos_images[] = array('img' => 'grid.jpg',               'bg' => '',                          'anim' => 'long');
	$demos_images[] = array('img' => 'shop.png',               'bg' => 'shop_bg.jpg',               'anim' => 'medium');
	$demos_images[] = array('img' => 'lookbook.jpg',           'bg' => '',                          'anim' => 'long');
	$demos_images[] = array('img' => 'top_parallax.jpg',       'bg' => '',                          'anim' => 'medium');
	$demos_images[] = array('img' => 'flex_slider.png',        'bg' => 'flex_slider_bg.jpg',        'anim' => 'long');
	$demos_images[] = array('img' => 'alternate.jpg',          'bg' => '',                          'anim' => 'medium');
	$demos_images[] = array('img' => 'contact.png',            'bg' => 'contact_bg.jpg',            'anim' => 'medium');
	$demos_images[] = array('img' => 'one_page.jpg',           'bg' => '',                          'anim' => 'longer');
	$demos_images[] = array('img' => 'photography.jpg',        'bg' => '',                          'anim' => 'medium');
	$demos_images[] = array('img' => 'real_estate.png',        'bg' => 'real_estate_bg.jpg',        'anim' => 'long');
	$demos_images[] = array('img' => 'creative.png',           'bg' => 'creative_bg.jpg',           'anim' => 'long');
	$demos_images[] = array('img' => 'restaurant.jpg',         'bg' => '',                          'anim' => 'medium');
	$demos_images[] = array('img' => 'corporate.png',          'bg' => 'corporate_bg.jpg',          'anim' => 'medium');
	$demos_images[] = array('img' => 'dance.jpg',              'bg' => '',                          'anim' => 'medium');
?>
	<div id="mpcth_import_wizard" class="wrap">
		<h2><?php _e('Demo Install', 'mpcth'); ?></h2>
		<?php if ($wordpress_importer_enabled) { ?>
			<span class="mpcth-import-warning"><span class="dashicons dashicons-no-alt"></span><?php _e('Please disable <em>WordPress Importer</em> plugin and refresh this page.', 'mpcth'); ?></span>
		<?php } ?>
		<?php if ($permalinks_enabled === '') { ?>
			<span class="mpcth-import-warning"><span class="dashicons dashicons-no-alt"></span><?php _e('Please enable <em>Pretty Permalinks</em> and refresh this page. You can enable it in <em>Settings > Permalinks > Day and Name</em>.', 'mpcth'); ?></span>
		<?php } ?>
		<!-- Demos -->
		<h3 class="install-steps"><?php _e('Step 1', 'mpcth'); ?><small>: <?php _e('Choose the demo.', 'mpcth'); ?></small></h3>
		<div id="mpcth_demos">
			<ul>
				<?php foreach ($demos_images as $demo) {?>
				<li class="preview-item <?php echo $demo['img'] == 'default.jpg' ? 'active' : ''; ?>" data-theme="<?php echo substr($demo['img'], 0, -4); ?>">
					<a href="#">
						<span class="image-bg" <?php echo empty($demo['bg']) ? '' : 'style="background-image: url(' . $images_root . $demo['bg'] . ');"'; ?>>
							<span class="image-wrap move-<?php echo $demo['anim']; ?>" style="background-image: url('<?php echo $images_root . $demo['img']; ?>');"></span>
						</span>
						<p class="install-option <?php echo $demo['img'] == 'default.jpg' ? 'active' : ''; ?>"><span class="dashicons dashicons-yes"></span><?php echo ucwords(str_replace('_', ' ', substr($demo['img'], 0, -4))); ?></p>
					</a>
				</li>
				<?php } ?>
			</ul>
		</div>

		<!-- Options -->
		<h3 class="install-steps"><?php _e('Step 2', 'mpcth'); ?><small>: <?php _e('Select the elements for import.', 'mpcth'); ?></small></h3>
		<div id="mpcth_options">
			<a id="mpcth_opt_content" class="install-option" href="#"><span class="dashicons dashicons-yes"></span><?php _e('Content', 'mpcth'); ?></a>
			<a id="mpcth_opt_widgets" class="install-option" href="#"><span class="dashicons dashicons-yes"></span><?php _e('Widgets', 'mpcth'); ?></a>
			<a id="mpcth_opt_panel" class="install-option" href="#"><span class="dashicons dashicons-yes"></span><?php _e('Panel settings', 'mpcth'); ?></a>
			<a id="mpcth_opt_sliders" class="install-option" href="#"><span class="dashicons dashicons-yes"></span><?php _e('Sliders', 'mpcth'); ?></a>
		</div>

		<!-- Buttons and messages -->
		<h3 class="install-steps"><?php _e('Step 3', 'mpcth'); ?><small>: <?php _e('Proceed with the import.', 'mpcth'); ?></small></h3>
		<span id="mpcth_import_success"><span class="dashicons dashicons-yes"></span><?php _e('All data was successfully imported.', 'mpcth'); ?></span>
		<span id="mpcth_import_process">
			<span class="spinner"></span>
			<span class="step step-backup"><?php _e('Creating backup...', 'mpcth'); ?></span>
			<span class="step step-content"><?php _e('Importing demo content...', 'mpcth'); ?></span>
			<span class="step step-widgets"><?php _e('Importing widgets...', 'mpcth'); ?></span>
			<span class="step step-panel"><?php _e('Importing panel settings...', 'mpcth'); ?></span>
			<span class="step step-sliders"><?php _e('Importing sliders...', 'mpcth'); ?></span>
		</span>
		<a id="mpcth_import" href="#" class="move-quicker"><?php _e('Begin import of', 'mpcth'); ?> <strong>Default</strong></a>
		<span id="mpcth_import_warning" class="move-quicker"><span class="dashicons dashicons-no-alt"></span><?php _e('You must select at least one option for import.', 'mpcth'); ?></span>

		<!-- Backups -->
		<div id="mpcth_import_backups">
			<h3 class="install-steps"><?php _e('Backups', 'mpcth'); ?><small>: <?php _e('Your previous WordPress settings.', 'mpcth'); ?></small></h3>
			<ol><?php mpcth_import_backups_list(); ?></ol>
		</div>
	</div>
<?php
}

add_action('wp_ajax_mpcth_import_step_backup', 'mpcth_import_step_backup');
function mpcth_import_step_backup() {
	$mpcth_import_backups_ids = get_option('mpcth_import_backups_ids');

	if (empty($mpcth_import_backups_ids))
		$mpcth_import_backups_ids = array();

	$current_time = (String)time();
	$mpcth_import_backup = array();

	$mpcth_import_backup['show_on_front'] = get_option('show_on_front');
	$mpcth_import_backup['page_on_front'] = get_option('page_on_front');
	$mpcth_import_backup['nav_menu_locations'] = get_theme_mod('nav_menu_locations');
	$mpcth_import_backup['sidebars_widgets'] = get_option('sidebars_widgets');
	$mpcth_import_backup['widgets_settings'] = mpcth_get_used_widgets_settings();
	$mpcth_import_backup['woocommerce'] = array(
		'yith_wcwl_button_position' => get_option('yith_wcwl_button_position'),
		'yith_wcwl_wishlist_page_id' => get_option('yith_wcwl_wishlist_page_id'),
		'woocommerce_shop_page_id' => get_option('woocommerce_shop_page_id'),
		'woocommerce_myaccount_page_id' => get_option('woocommerce_myaccount_page_id'),
		'woocommerce_cart_page_id' => get_option('woocommerce_cart_page_id'),
		'woocommerce_checkout_page_id' => get_option('woocommerce_checkout_page_id'),
		'shop_catalog_image_size' => get_option('shop_catalog_image_size'),
		'shop_single_image_size' => get_option('shop_single_image_size'),
		'shop_thumbnail_image_size' => get_option('shop_thumbnail_image_size'),
	);

	array_unshift($mpcth_import_backups_ids, $current_time);
	update_option('mpcth_import_backups_ids', $mpcth_import_backups_ids);
	add_option('mpcth_import_backup_' . $current_time, $mpcth_import_backup);

	die(1);
}

add_action('wp_ajax_mpcth_import_step_content', 'mpcth_import_step_content');
function mpcth_import_step_content() {
	if (! isset($_POST['theme']))
		die(0);

	$content = mpcth_check_for_menu_duplication();

	if (! defined('WP_LOAD_IMPORTERS')) define('WP_LOAD_IMPORTERS', true);
	require_once(MPC_THEME_PATH . '/demos/inc/wordpress-importer.php');

	mpcth_pre_import_settings();

	$wp_import = new WP_Import();
	$wp_import->fetch_attachments = true;
	$wp_import->import($content);

	$import_demo = $_POST['theme'];
	if ($import_demo != 'default' && $import_demo != 'one_page') {
		$content = MPC_THEME_PATH . '/demos/data/' . $import_demo . '/content.xml';

		$wp_import = new WP_Import();
		$wp_import->fetch_attachments = true;
		$wp_import->import($content);
	}

	mpcth_import_step_wp_menu();
	mpcth_import_step_wp_settings();

	die(1);
}

function mpcth_pre_import_settings() {
//	Register Woocommerce taxonomies
	$product_attributes = array('pa_color', 'pa_size', 'pa_fabric', 'pa_brand', 'pa_weight');
	foreach ($product_attributes as $attribute) {
		if (! get_taxonomy($attribute))
			register_taxonomy( $attribute,
				apply_filters( 'woocommerce_taxonomy_objects_' . $attribute, array('product') ),
				apply_filters( 'woocommerce_taxonomy_args_' . $attribute, array(
					'hierarchical' => true,
					'show_ui' => false,
					'query_var' => true,
					'rewrite' => false,
				) )
			);
	}

//	Register Woocommerce image sizes
	add_image_size('shop_thumbnail', 100, 100, 1);
	add_image_size('shop_catalog', 300, 400, 1);
	add_image_size('shop_single', 600, 800, 1);
}

function mpcth_import_step_wp_menu() {
	$import_demo = $_POST['theme'];

	$menu_locations = get_theme_mod('nav_menu_locations');
	$main_menu = get_term_by('slug', 'demo-main-menu', 'nav_menu');
	$mobile_menu = get_term_by('slug', 'demo-main-menu', 'nav_menu');
	$secondary_menu = get_term_by('slug', 'demo-custom-menu', 'nav_menu');
	$one_page_menu = get_term_by('slug', 'demo-one-page', 'nav_menu');

	if ($main_menu)
		$menu_locations['mpcth_menu'] = $import_demo == 'one_page' ? $one_page_menu->term_id : $main_menu->term_id;
	if ($mobile_menu)
		$menu_locations['mpcth_mobile_menu'] = $import_demo == 'one_page' ? $one_page_menu->term_id : $mobile_menu->term_id;
	if ($secondary_menu)
		$menu_locations['mpcth_secondary_menu'] = $import_demo == 'one_page' ? '' : $secondary_menu->term_id;

	set_theme_mod('nav_menu_locations', $menu_locations);
}

function mpcth_import_step_wp_settings() {
	$import_demo = $_POST['theme'];

//	Assigning default pages
	global $wpdb;

	$home_id = (int) $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE 1=1 AND post_date = '2014-02-19 10:20:19' AND post_title = 'Demo " . str_replace('_', ' ', ucwords($import_demo)) . " - Home'");

	if ($import_demo != 'one_page') {
		$shop_id      = (int) $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE 1=1 AND post_date = '2014-02-06 11:55:33' AND post_title = 'Shop'");
		$myaccount_id = (int) $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE 1=1 AND post_date = '2014-02-06 11:55:33' AND post_title = 'My Account'");
		$cart_id      = (int) $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE 1=1 AND post_date = '2014-02-06 11:55:33' AND post_title = 'Cart'");
		$checkout_id  = (int) $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE 1=1 AND post_date = '2014-02-06 11:55:33' AND post_title = 'Checkout'");
		$wishlist_id  = (int) $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE 1=1 AND post_date = '2014-02-14 11:27:27' AND post_title = 'Wishlist'");

		if ($import_demo == 'shop') {
			$shop_id = $home_id;
		}

		update_option('woocommerce_shop_page_id', $shop_id);
		update_option('woocommerce_myaccount_page_id', $myaccount_id);
		update_option('woocommerce_cart_page_id', $cart_id);
		update_option('woocommerce_checkout_page_id', $checkout_id);
		update_option('yith_wcwl_wishlist_page_id', $wishlist_id);

//	    Update Home menu item
		$menu_home_id = (int) $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE 1=1 AND post_type = 'nav_menu_item' AND post_title = 'Home'");
		update_post_meta($menu_home_id, '_menu_item_object_id', $home_id);
	}

//	Get import settings file content
	$import_settings = mpcth_get_import_settings();

	if (empty($import_settings))
		die(0);

//	Overwrite the WordPress settings with the values from import settings file
	update_option('show_on_front', 'page');
	update_option('page_on_front', $home_id);

	update_option('yith_wcwl_button_position', $import_settings['woocommerce']['yith_wcwl_button_position']);
	update_option('shop_catalog_image_size', $import_settings['woocommerce']['shop_catalog_image_size']);
	update_option('shop_single_image_size', $import_settings['woocommerce']['shop_single_image_size']);
	update_option('shop_thumbnail_image_size', $import_settings['woocommerce']['shop_thumbnail_image_size']);

	if ($import_demo != 'one_page') {
		$attribute_taxonomies = $wpdb->get_results("SELECT attribute_label FROM " . $wpdb->prefix . "woocommerce_attribute_taxonomies", 'ARRAY_A');
		$current_attribute_values = array();
		foreach ($attribute_taxonomies as $attribute_taxonomy) {
			$current_attribute_values[] = $attribute_taxonomy['attribute_label'];
		}

		$attribute_taxonomies = array_diff(array('color', 'size', 'fabric', 'brand', 'weight'), $current_attribute_values);
		foreach ($attribute_taxonomies as $attribute_taxonomy) {
			$attribute = array(
				'attribute_label'   => $attribute_taxonomy,
				'attribute_name'    => ucwords($attribute_taxonomy),
				'attribute_type'    => 'select',
				'attribute_orderby' => 'menu_order',
			);

			$wpdb->insert($wpdb->prefix . 'woocommerce_attribute_taxonomies', $attribute);
		}

		delete_transient('wc_attribute_taxonomies');
		$attribute_taxonomies = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "woocommerce_attribute_taxonomies");
		set_transient('wc_attribute_taxonomies', $attribute_taxonomies);
	}

//	Change Quickview content setting
	$quickview_settings = get_option('jckqvsettings_settings');
	if (! empty($quickview_settings)) {
		$quickview_settings['popup_content_showdesc'] = 'short';
		update_option('jckqvsettings_settings', $quickview_settings);
	}

//	Update menu permalinks
	if ($import_demo != 'one_page')
		mpcth_update_shop_permalinks();

//  Refresh Woocommerce pages
	flush_rewrite_rules();
}

add_action('wp_ajax_mpcth_import_step_widgets', 'mpcth_import_step_widgets');
function mpcth_import_step_widgets() {
	if (! isset($_POST['theme']))
		die(0);

//	Get import settings file content
	$import_settings = mpcth_get_import_settings();

	if (empty($import_settings))
		die(0);

//	Get all active widgets and remove them
	$widgets_settings = mpcth_get_used_widgets_settings();

	foreach ($widgets_settings as $name => $settings) {
		update_option('widget_' . $name, array());
	}

//	Overwrite the options with the values from import settings file
	update_option('sidebars_widgets', $import_settings['sidebars_widgets']);

	foreach ($import_settings['widgets_settings'] as $name => $settings) {
		if ($name == 'nav_menu' || $name == 'dc_jqmegamenu_widget')
			$settings = mpcth_update_menu_id($settings);

		update_option('widget_' . $name, $settings);
	}

	die(1);
}

add_action('wp_ajax_mpcth_import_step_panel', 'mpcth_import_step_panel');
function mpcth_import_step_panel() {
	if (! isset($_POST['theme']))
		die(0);

	$mpcth_import_dir = MPC_THEME_PATH . '/demos/data/' . $_POST['theme'];

	$_FILES["import_settings_file"] = array();
	$_FILES["import_settings_file"]["name"] = 'panel.mps';
	$_FILES["import_settings_file"]["type"] = 'application/octet-stream';
	$_FILES["import_settings_file"]["tmp_name"] = $mpcth_import_dir . '/panel.mps';

	mpcth_import_settings(true);
	mpcth_update_custom_styles();

	die(1);
}

add_action('wp_ajax_mpcth_import_step_sliders', 'mpcth_import_step_sliders');
function mpcth_import_step_sliders() {
	if (! isset($_POST['theme']))
		die(0);

	if(class_exists('RevSlider')) {
		$import_demo = $_POST['theme'];
		$rev_slider = new RevSlider();

		if ($import_demo != 'one_page') {
			$sliders = array('lookbook1', 'lookbook3', 'default');
			$mpcth_import_dir = MPC_THEME_PATH . '/demos/data/default';

			foreach ($sliders as $slider) {
				$slider_exists = $rev_slider->isAliasExists($slider . '-demo_slider');

				if (! $slider_exists) {
					$_FILES["import_file"]             = array();
					$_FILES["import_file"]["name"]     = 'slider.zip';
					$_FILES["import_file"]["type"]     = 'application/octet-stream';
					$_FILES["import_file"]["tmp_name"] = $mpcth_import_dir . '/' . $slider . '.zip';

					$rev_slider->importSliderFromPost();
				}
			}
		}

		if (file_exists(MPC_THEME_PATH . '/demos/data/' . $import_demo . '/slider.zip')) {
			$mpcth_import_dir = MPC_THEME_PATH . '/demos/data/' . $import_demo;
			$slider_exists = $rev_slider->isAliasExists($import_demo . '-demo_slider');

			if (! $slider_exists) {
				$_FILES["import_file"]             = array();
				$_FILES["import_file"]["name"]     = 'slider.zip';
				$_FILES["import_file"]["type"]     = 'application/octet-stream';
				$_FILES["import_file"]["tmp_name"] = $mpcth_import_dir . '/slider.zip';

				$rev_slider->importSliderFromPost();
			}
		}
	}

	die(1);
}

add_action('wp_ajax_mpcth_import_backup_restore', 'mpcth_import_backup_restore');
function mpcth_import_backup_restore() {
	if (! isset($_POST['id']))
		die(0);

	$id = $_POST['id'];
	$mpcth_import_backup = get_option('mpcth_import_backup_' . $id);

	if ($mpcth_import_backup) {
		set_theme_mod('nav_menu_locations', $mpcth_import_backup['nav_menu_locations']);

		update_option('show_on_front', $mpcth_import_backup['show_on_front']);
		update_option('page_on_front', $mpcth_import_backup['page_on_front']);
		update_option('sidebars_widgets', $mpcth_import_backup['sidebars_widgets']);

		foreach ($mpcth_import_backup['woocommerce'] as $name => $settings) {
			update_option($name, $settings);
		}

		foreach ($mpcth_import_backup['widgets_settings'] as $name => $settings) {
			update_option('widget_' . $name, $settings);
		}
	}

	die(1);
}

add_action('wp_ajax_mpcth_import_backup_delete', 'mpcth_import_backup_delete');
function mpcth_import_backup_delete() {
	if (! isset($_POST['id']))
		die(0);

	$id = $_POST['id'];
	$mpcth_import_backups_ids = get_option('mpcth_import_backups_ids');
	$mpcth_import_backup = get_option('mpcth_import_backup_' . $id);
	$backups_index = array_search($id, $mpcth_import_backups_ids);

	if ($backups_index !== false) {
		unset($mpcth_import_backups_ids[$backups_index]);

		update_option('mpcth_import_backups_ids', $mpcth_import_backups_ids);
	}

	if (isset($mpcth_import_backup))
		delete_option('mpcth_import_backup_' . $id);

	die(1);
}

add_action('wp_ajax_mpcth_import_backups_list', 'mpcth_import_backups_list');
function mpcth_import_backups_list() {
	$mpcth_import_backups_ids = get_option('mpcth_import_backups_ids');

	if (! empty($mpcth_import_backups_ids)) {
		foreach ($mpcth_import_backups_ids as $id) { ?>
			<li class="mpcth-backup-info" data-id="<?php echo $id; ?>">
				<?php echo __('Created on ', 'mpcth') . '<em>' . date('Y-m-d', $id) . '</em>' . __(' at ', 'mpcth') . '<em>' . date('H:i:s', $id) . '</em>'; ?>
				<a href="#" class="mpcth-backup-restore move-quicker" data-msg="<?php _e('Are you sure you want to RESTORE the backup?', 'mpcth'); ?>"><span class="dashicons dashicons-yes"></span><?php _e('Restore', 'mpcth'); ?></a>
				<a href="#" class="mpcth-backup-delete move-quicker" data-msg="<?php _e('Are you sure you want to DELETE the backup?', 'mpcth'); ?>"><span class="dashicons dashicons-no-alt"></span><?php _e('Delete', 'mpcth'); ?></a>
				<span class="spinner"></span>
			</li>
		<?php }
	} ?>
	<li class="mpcth-backup-info mpcth-no-backup" data-id="0">
		<?php _e('No backups available.', 'mpcth'); ?>
	</li>
	<?php

	if (isset($_POST['theme']))
		die(1);
}

function mpcth_update_menu_id($settings) {
	foreach ($settings as $key => $values) {
		if ($key == '_multiwidget') continue;

		$slug = $values['nav_menu'];
		$menu = get_term_by('slug', $slug, 'nav_menu');
		$values['nav_menu'] = $menu->term_id;

		$settings[$key] = $values;
	}

	return $settings;
}

function mpcth_update_shop_permalinks() {
	global $wpdb;

	$shop_id = (int) $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE 1=1 AND post_date = '2014-02-06 11:55:33' AND post_title = 'Shop'");
	$shop_url = get_permalink($shop_id);

	$args = array(
		'posts_per_page'   => 10,
		'post_type'    => 'nav_menu_item',
		'meta_key'     => '_menu_item_url',
		'meta_compare' => 'LIKE',
		'meta_value'   => 'http://demo_default.dev/product-category/'
	);
	$menu_items = get_posts($args);

	foreach ($menu_items as $menu_item) {
		$url = $shop_url;

		switch ($menu_item->post_title) {
			case '<i class="fa- fa-angle-right fa"></i>Products Style 1': $url = add_query_arg(array('product_style' => '1'), $url); break;
			case '<i class="fa- fa-angle-right fa"></i>Products Style 2<span class="mpcth-menu-label-hot">NEW 1.2</span>': $url = add_query_arg(array('sidebar-pos' => 'right', 'product_style' => '2'), $url); break;
			case '<i class="fa- fa-angle-right fa"></i>Products Style 3<span class="mpcth-menu-label-hot">NEW 1.2</span>': $url = add_query_arg(array('sidebar-pos' => 'none', 'product_style' => '3'), $url); break;
			case '<i class="fa- fa-angle-right fa"></i>Masonry<span class="mpcth-menu-label-hot">NEW 1.1</span>': $url = add_query_arg(array('sidebar-pos' => 'none', 'masonry' => '1'), $url); break;

			case '<i class="fa- fa-angle-right fa"></i>Sidebar Left': break;
			case '<i class="fa- fa-angle-right fa"></i>Sidebar Right': $url = add_query_arg(array('sidebar-pos' => 'right'), $url); break;
			case '<i class="fa- fa-angle-right fa"></i>Full-Width': $url = add_query_arg(array('sidebar-pos' => 'none'), $url); break;
			case '<i class="fa- fa-angle-right fa"></i>Load More <span class="mpcth-menu-label-hot">NEW 1.1</span>': $url = add_query_arg(array('sidebar-pos' => 'none', 'masonry' => '2'), $url); break;

			case 'Women\'s Fashion': break;
			case 'Men\'s Fashion': break;
		}

		update_post_meta($menu_item->ID, '_menu_item_url', $url);
	}
}

function mpcth_get_import_settings() {
	$import_dir = MPC_THEME_PATH . '/demos/data/default';

	try {
		$settings = file_get_contents($import_dir . '/settings.dis');
		$settings = json_decode($settings, true);
	} catch(Exception $e) {
		$settings = array();
	}

	return $settings;
}

function mpcth_get_used_widgets_settings() {
	global $wp_registered_widget_controls;

	$widgets_names = array();
	$widgets_settings = array();

	foreach ($wp_registered_widget_controls as $widget) {
		$widgets_names[$widget['id_base']] = $widget['id_base'];
	}

	foreach ($widgets_names as $name) {
		$widget_settings = get_option('widget_' . $name);

		if(! empty($widget_settings))
			$widgets_settings[$name] = $widget_settings;
	}

	return $widgets_settings;
}

function mpcth_check_for_menu_duplication() {
	$import_demo = $_POST['theme'];
	$base = $import_demo == 'one_page' ? 'one_page' : 'default';

	$import_dir = MPC_THEME_PATH . '/demos/data/' . $base;

	$demo_importer = get_option('mpcth_demo_importer_' . $base);

	if ($demo_importer !== false) {
		$content = $import_dir . '/content.xml';
	} else {
		update_option('mpcth_demo_importer_' . $base, 1);

		$content = $import_dir . '/content_menu.xml';
	}

	return $content;
}

function mpcth_export_widgets() {
	global $wp_registered_widget_controls;

	$widgets_names = array();
	$widgets_settings = array();

	foreach ($wp_registered_widget_controls as $widget) {
		$widgets_names[$widget['id_base']] = $widget['id_base'];
	}

	foreach ($widgets_names as $name) {
		$widget_settings = get_option('widget_' . $name);

		if(! empty($widget_settings))
			$widgets_settings[$name] = $widget_settings;
	}

	return base64_encode(serialize($widgets_settings));
}

function mpcth_export_sidebars() {
	$sidebars = get_option('sidebars_widgets');

	unset($sidebars['wp_inactive_widgets']);
	unset($sidebars['array_version']);

	return base64_encode(serialize($sidebars));
}