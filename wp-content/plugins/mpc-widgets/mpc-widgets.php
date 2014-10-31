<?php
/*
Plugin Name: MPC Widgets
Plugin URI: http://themeforest.net/user/mpc/
Description: Basic sidebar/footer widgets. Created as an extension for all MPC Themes but should work everywhere with default styles.
Author: MassivePixelCreation
Version: 1.2.3
Author URI: http://themeforest.net/user/mpc/
*/

if(!function_exists('add_action')) {
	echo 'MPC Widgets plugin.';
	exit;
}

/* Constants */
define('MPC_WIDGETS_URL', plugin_dir_url(__FILE__));
define('MPC_WIDGETS_DIR', plugin_dir_path(__FILE__));

/* Functions */
add_action('widgets_init', 'mpc_w_register_widgets');
function mpc_w_register_widgets() {
	register_widget('MPC_Twitter');
	register_widget('MPC_Smart_Search');
	register_widget('MPC_Shop_Info');
}

add_action('wp_enqueue_scripts', 'mpc_w_enqueue_scripts');
function mpc_w_enqueue_scripts() {
	if(!defined('MPC_THEME_ENABLED')) {
		wp_enqueue_style('mpc-w-styles', MPC_WIDGETS_URL . '/css/mpc-w.css');
	}
	wp_enqueue_script('mpc-w-scripts', MPC_WIDGETS_URL . '/js/mpc-w.js', array('jquery'), '1.0', true);
	wp_localize_script('mpc-w-scripts', 'ajaxurl', admin_url('admin-ajax.php'));
}

/* Cache tweets */
add_action('wp_ajax_mpc_w_cache_twitter', 'mpc_w_cache_twitter');
function mpc_w_cache_twitter() {
	$tweets = isset($_POST['tweets']) ? $_POST['tweets'] : '';
	$id = isset($_POST['id']) ? $_POST['id'] : '';
	$number = isset($_POST['number']) ? $_POST['number'] : '';

	if(!empty($tweets) && !empty($id) && !empty($number)) {
		set_transient('mpc_w_twitter_' . $id . '_' . $number, $tweets, 900); // 15min
	}

	die();
}

/* ---------------------------------------------------------------- */
/* Widgets
/* ---------------------------------------------------------------- */

/* 1. Twitter */
class MPC_Twitter extends WP_Widget {
	function MPC_Twitter() {
		$args = array(
			'classname' => 'mpc-w-twitter-widget',
			'description' => __('Display your latest tweets.', 'mpcth')
			);
		$this->WP_Widget('twitter_widget', __('MPC - Latest Tweets', 'mpcth'), $args);
	}

	function form($instance) {
		$instance = wp_parse_args((array)$instance, array('title' => __('Latest Tweets', 'mpcth'), 'number' => 2, 'id' => ''));
		$title = esc_attr($instance['title']);
		$id = esc_attr($instance['id']);
		$number = absint($instance['number']);
	?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'mpcth'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('id'); ?>"><?php _e('Twitter Widget ID:', 'mpcth'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('id'); ?>" name="<?php echo $this->get_field_name('id'); ?>" type="text" value="<?php echo $id; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of Tweets:', 'mpcth'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" />
		</p>
	<?php
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['id'] = $new_instance['id'];
		$instance['number'] = $new_instance['number'];

		return $instance;
	}

	function widget($args, $instance) {
		extract($args);

		$title = apply_filters('widget_title', $instance['title']);
		$id = $instance['id'];
		$number = absint($instance['number']);
		$unique = mpc_w_random_ID(5);

		$tweets = get_transient('mpc_w_twitter_' . $id . '_' . $number);
		$is_cached = $tweets !== false;

		echo $before_widget;
		if (! empty($title)) {
			echo $before_title;
				echo $title;
			echo $after_title;
		}
			?>
			<ul id="mpc_w_twitter_<?php echo $unique ?>" class="mpc-w-twitter-wrap<?php echo $is_cached ? ' mpc-w-twitter-cached' : ''; ?>" data-number="<?php echo $number; ?>" data-id="<?php echo $id; ?>" data-unique="<?php echo $unique; ?>">
				<?php if($is_cached) echo urldecode($tweets); ?>
			</ul>
		<?php
		echo $after_widget;
	}
}

/* 2. Smart search field */
class MPC_Smart_Search extends WP_Widget {
	function MPC_Smart_Search() {
		$args = array(
			'classname' => 'mpc-w-smart-search-widget',
			'description' => __('Display smart search field.', 'mpcth')
			);
		$this->WP_Widget('smart_search_widget', __('MPC - Smart Search Field', 'mpcth'), $args);
	}

	function form($instance) {
		$instance = wp_parse_args((array)$instance, array('title' => __('Smart Filter', 'mpcth'), 'before_text' => '', 'filter' => '', 'after_text' => '', 'default' => ''));
		$title = esc_attr($instance['title']);
		$before_text = esc_attr($instance['before_text']);
		$filter = esc_attr($instance['filter']);
		$after_text = esc_attr($instance['after_text']);
		$default = esc_attr($instance['default']);

		$attributes = array();
		if (function_exists('wc_get_attribute_taxonomies')) {
			$attributes = wc_get_attribute_taxonomies();
		}
	?>
		<p>
			<label for="<?php echo $this->get_field_id('before_text'); ?>"><?php _e('Before text:', 'mpcth'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('before_text'); ?>" name="<?php echo $this->get_field_name('before_text'); ?>" type="text" value="<?php echo $before_text; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('filter'); ?>"><?php _e('Filter:', 'mpcth'); ?></label>
			<select class="widefat" name="<?php echo $this->get_field_name('filter'); ?>">
				<?php
				foreach ($attributes as $attribute) {
					echo '<option value="' . $attribute->attribute_name . '" ' . ($filter == $attribute->attribute_name ? 'selected=selected' : '') . '>' . $attribute->attribute_label . '</option>';
					if ($filter == $attribute->attribute_name) $title = $attribute->attribute_label;
				}
				?>
				<option value="product_cat" <?php echo $filter == 'product_cat' ? 'selected=selected' : ''; ?>><?php _e('Category', 'mpcth'); ?></option>
				<?php if ($filter == 'product_cat') $title = __('Category', 'mpcth'); ?>
				<option value="min_price" <?php echo $filter == 'min_price' ? 'selected=selected' : ''; ?>><?php _e('Min price', 'mpcth'); ?></option>
				<?php if ($filter == 'min_price') $title = __('Min price', 'mpcth'); ?>
				<option value="max_price" <?php echo $filter == 'max_price' ? 'selected=selected' : ''; ?>><?php _e('Max price', 'mpcth'); ?></option>
				<?php if ($filter == 'max_price') $title = __('Max price', 'mpcth'); ?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('after_text'); ?>"><?php _e('After text:', 'mpcth'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('after_text'); ?>" name="<?php echo $this->get_field_name('after_text'); ?>" type="text" value="<?php echo $after_text; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('default'); ?>"><?php _e('Default value (slug):', 'mpcth'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('default'); ?>" name="<?php echo $this->get_field_name('default'); ?>" type="text" value="<?php echo $default; ?>" />
		</p>
		<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="hidden" value="<?php echo $title; ?>" />
	<?php
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;

		$instance['title'] = $new_instance['title'];
		$instance['before_text'] = $new_instance['before_text'];
		$instance['filter'] = $new_instance['filter'];
		$instance['after_text'] = $new_instance['after_text'];
		$instance['default'] = $new_instance['default'];

		return $instance;
	}

	function widget($args, $instance) {
		extract($args);

		$before_text = $instance['before_text'];
		$filter = $instance['filter'];
		$after_text = $instance['after_text'];
		$default = $instance['default'];

		$is_select = $filter != 'min_price' && $filter != 'max_price';

		if ($is_select) {
			$items = array();
			if ($filter != 'product_cat') {
				if (taxonomy_exists('pa_' . $filter)) {
					$args = array(
						'hide_empty' => 0,
					);
					$items = get_terms('pa_' . $filter, $args);
				}
			} else {
				$args = array(
					'orderby'    => 'name',
					'hide_empty' => 0,
					'taxonomy'   => 'product_cat',
					'echo'       => 0,
					'style'      => 'none',
					'walker'     => new MPC_Simple_List_Walker,
					'default'    => $default,
				);
				$items = wp_list_categories($args);
			}
		// } elseif ($filter == 'max_price' && $default == '') {
		} elseif ($filter == 'max_price') {
			global $wpdb;

			$default_max = 0;
			if (! empty($wpdb)) {
				if ( sizeof( WC()->query->layered_nav_product_ids ) === 0 ) {
					$default_max = ceil( $wpdb->get_var(
						$wpdb->prepare('
							SELECT max(meta_value + 0)
							FROM %1$s
							LEFT JOIN %2$s ON %1$s.ID = %2$s.post_id
							WHERE meta_key = \'%3$s\'
						', $wpdb->posts, $wpdb->postmeta, '_price' )
					) );
				} else {
					$default_max = ceil( $wpdb->get_var(
						$wpdb->prepare('
							SELECT max(meta_value + 0)
							FROM %1$s
							LEFT JOIN %2$s ON %1$s.ID = %2$s.post_id
							WHERE meta_key =\'%3$s\'
							AND (
								%1$s.ID IN (' . implode( ',', array_map( 'absint', WC()->query->layered_nav_product_ids ) ) . ')
								OR (
									%1$s.post_parent IN (' . implode( ',', array_map( 'absint', WC()->query->layered_nav_product_ids ) ) . ')
									AND %1$s.post_parent != 0
								)
							)
						', $wpdb->posts, $wpdb->postmeta, '_price'
					) ) );
				}
			}
		}

		echo $before_widget; ?>
			<div class="mpc-w-smart-search-field">
				<span class="mpc-w-smart-search-before"><?php echo $before_text; ?></span>
				<?php if ($is_select) { ?>
					<?php if ($filter != 'product_cat') { ?>
						<div class="mpc-w-smart-search-filter-wrap">
							<select class="mpc-w-smart-search-filter" name="filter_<?php echo $filter; ?>">
								<option value=""><?php _e('Any', 'mpcth'); ?></option>
								<?php
								foreach ($items as $item) {
									echo '<option value="' . $item->term_id . '"' . ($item->slug == $default ? ' selected=selected' : '') . '>' . $item->name . '</option>';
								}
								?>
							</select>
						</div>
					<?php } else { ?>
						<div class="mpc-w-smart-search-filter-wrap">
							<select class="mpc-w-smart-search-filter mpc-w-smart-search-filter-category" name="">
								<option value="<?php echo get_bloginfo('url'); ?>"><?php _e('Any', 'mpcth'); ?></option>
								<?php
								echo $items;
								?>
							</select>
						</div>
					<?php } ?>
				<?php } else { ?>
					<?php
						$currency_position = get_option('woocommerce_currency_pos');
						$add_space = $currency_position == 'right_space' || $currency_position == 'left_space' ? ' ' : '';
					?>

					<?php if ($filter == 'min_price') { ?>
						<?php if ($currency_position == 'right' || $currency_position == 'right_space') { ?>
							<input type="text" class="mpc-w-smart-search-filter mpc-w-smart-search-filter-price" name="min_price" value="<?php echo ($default != '' ? $default : 0) . $add_space . get_woocommerce_currency_symbol(); ?>">
						<?php } else { ?>
							<input type="text" class="mpc-w-smart-search-filter mpc-w-smart-search-filter-price" name="min_price" value="<?php echo get_woocommerce_currency_symbol() . $add_space . ($default != '' ? $default : 0); ?>">
						<?php } ?>
					<?php } else { ?>
						<?php if ($currency_position == 'right' || $currency_position == 'right_space') { ?>
							<input type="text" class="mpc-w-smart-search-filter mpc-w-smart-search-filter-price" name="max_price" value="<?php echo $default . $add_space . get_woocommerce_currency_symbol(); ?>">
						<?php } else { ?>
							<input type="text" class="mpc-w-smart-search-filter mpc-w-smart-search-filter-price" name="max_price" value="<?php echo get_woocommerce_currency_symbol() . $add_space . $default; ?>">
						<?php } ?>
						<input type="hidden" class="mpc-w-smart-search-filter-price-max" value="<?php echo $default_max; ?>">
					<?php } ?>
				<?php } ?>
				<span class="mpc-w-smart-search-after"><?php echo $after_text; ?></span>
			</div>
		<?php echo $after_widget;
	}
}

/* 3. Shop info */
class MPC_Shop_Info extends WP_Widget {
	function MPC_Shop_Info() {
		$args = array(
			'classname' => 'mpc-w-shop-info-widget',
			'description' => __('Display shop info.', 'mpcth')
			);
		$this->WP_Widget('shop_info_widget', __('MPC - Shop Info', 'mpcth'), $args);
	}

	function widget($args, $instance) {
		extract($args);

		// $protocol = is_ssl() ? 'https://' : 'http://';
		// $host = $_SERVER["HTTP_HOST"];
		// $request_uri = $_SERVER["REQUEST_URI"];
		// $query_string = $_SERVER["QUERY_STRING"];

		// $url = '';
		// $after_url = '';
		// if (empty($query_string)) {
		// 	$url = $protocol . $host . $request_uri . '?orderby=';
		// } elseif (strpos($query_string, 'orderby') === false) {
		// 	$url = $protocol . $host . $request_uri . '&orderby=';
		// } else {
		// 	$parts = explode('orderby=' . $_GET['orderby'], $request_uri);

		// 	$url = $protocol . $host . $parts[0] . 'orderby=';
		// 	$after_url = $parts[1];
		// }

		echo $before_widget;
		if (! empty($title)) {
			echo $before_title;
				echo $title;
			echo $after_title;
		}
			if (function_exists('woocommerce_page_title'))
				echo '<h2 class="mpcth-color-main-color">' . woocommerce_page_title(false) . '</h2>';

			// echo '<div><a class="mpcth-color-main-color" href="' . $url . 'date' . $after_url . '">' . __('New', 'mpcth') . '</a></div>';
			// echo '<div><a class="mpcth-color-main-color" href="' . $url . 'popularity' . $after_url . '">' . __('Top Sellers', 'mpcth') . '</a></div>';
			// echo '<div><a class="mpcth-color-main-color" href="' . $url . 'rating' . $after_url . '">' . __('Top Rated', 'mpcth') . '</a></div>';

		echo $after_widget;
	}
}

/* ---------------------------------------------------------------- */
/* Helpers
/* ---------------------------------------------------------------- */

require_once(MPC_WIDGETS_DIR . '/php/class-custom-category-walker.php');

function mpc_w_random_ID($length = 15) {
	return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
}

/* ---------------------------------------------------------------- */
/* Update
/* ---------------------------------------------------------------- */

$mpc_api_url = 'http://mpcreation.net/api/';
$mpc_w_slug = basename(dirname(__FILE__));

add_filter('pre_set_site_transient_update_plugins', 'mpc_w_check_for_plugin_update');
function mpc_w_check_for_plugin_update($checked_data) {
	global $mpc_api_url, $mpc_w_slug, $wp_version;

	if (empty($checked_data->checked))
		return $checked_data;

	$args = array(
		'slug' => $mpc_w_slug,
		'version' => $checked_data->checked[$mpc_w_slug .'/'. $mpc_w_slug .'.php'],
	);
	$request_string = array(
		'body' => array(
			'action' => 'basic_check',
			'request' => serialize($args),
			'api-key' => md5(get_bloginfo('url'))
		),
		'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')
	);

	$raw_response = wp_remote_post($mpc_api_url, $request_string);

	if (!is_wp_error($raw_response) && ($raw_response['response']['code'] == 200))
		$response = unserialize($raw_response['body']);

	if (is_object($response) && !empty($response))
		$checked_data->response[$mpc_w_slug .'/'. $mpc_w_slug .'.php'] = $response;

	return $checked_data;
}

add_filter('plugins_api', 'mpc_w_plugin_api_call', 100, 3);
function mpc_w_plugin_api_call($def, $action, $args) {
	global $mpc_api_url, $mpc_w_slug, $wp_version;

	if (!isset($args->slug) || ($args->slug != $mpc_w_slug))
		return $def;

	$plugin_info = get_site_transient('update_plugins');
	$current_version = $plugin_info->checked[$mpc_w_slug .'/'. $mpc_w_slug .'.php'];
	$args->version = $current_version;

	$request_string = array(
			'body' => array(
				'action' => $action,
				'request' => serialize($args),
				'api-key' => md5(get_bloginfo('url'))
			),
			'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')
		);

	$request = wp_remote_post($mpc_api_url, $request_string);

	if (is_wp_error($request)) {
		$res = new WP_Error('plugins_api_failed', __('An Unexpected HTTP Error occurred during the API request.</p> <p><a href="?" onclick="document.location.reload(); return false;">Try again</a>'), $request->get_error_message());
	} else {
		$res = unserialize($request['body']);

		if ($res === false)
			$res = new WP_Error('plugins_api_failed', __('An unknown error occurred'), $request['body']);
	}

	return $res;
}