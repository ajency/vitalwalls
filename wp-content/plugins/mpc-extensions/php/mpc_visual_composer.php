<?php
/* ---------------------------------------------------------------- */
/* 1. Icon list
/* ---------------------------------------------------------------- */
function mpc_vc_icon_list_shortcode($atts, $content = null) {
	extract(shortcode_atts(array(
		'icon_color' => '#666666',
		'text_color' => '#666666',
		'icon_list'  => ''
	), $atts));

	try {
		$icon_items = json_decode(urldecode($icon_list));
	} catch (Exception $e) {
		$icon_items = array();
	}

	if (! is_array($icon_items)) $icon_items = array();

	$css_id = 'mpcth_icon_list_' . mpc_vc_random_ID(5);

	$return = '<div id="' . $css_id . '" class="mpc-vc-icons-list mpcth-waypoint">';
		$return .= '<style type="text/css">';
		$return .= '#' . $css_id . ' { color: ' . $text_color . '; }';
		$return .= '#' . $css_id . ' li i { color: ' . $icon_color . '; }';
		$return .= '</style>';
		$return .= '<ul>';
		foreach ($icon_items as $item) {
			$return .= '<li>';
				$return .= '<i class="' . $item->icon . '"></i>';
				$return .= $item->text;
			$return .= '</li>';
		}
		$return .= '</ul>';
	$return .= '</div>';

	return $return;
}
add_shortcode('mpc_vc_icon_list', 'mpc_vc_icon_list_shortcode');

/* ---------------------------------------------------------------- */
/* 2. Social list
/* ---------------------------------------------------------------- */
function mpcth_vc_social_list_shortcode($atts, $content = null) {
	global $mpcth_options;
	extract(shortcode_atts(array(
		'title' => ''
	), $atts));

	$return = '<div class="mpcth-socials-list-wrap">';
		if ($title != '') $return .= '<span class="mpcth-socials-list-text">' . $title . ' </span>';
		$return .= '<ul class="mpcth-socials-list">';

		foreach($mpcth_options['mpcth_socials'] as $name => $enable) {
			if($enable) {
				$return .= '<li>';
					$return .= '<a href="' . ($name == 'envelope' ? 'mailto:' . $mpcth_options['mpcth_social_' . $name] : esc_url($mpcth_options['mpcth_social_' . $name])) . '" class="mpcth-social-' . $name . '">';
						$return .= '<i class="fa fa-' . $name . '"></i>';
					$return .= '</a>';
				$return .= '</li>';
			}
		}

		$return .= '</ul><!-- end .mpcth-socials-list -->';
	$return .= '</div><!-- end .mpcth-socials-list-wrap -->';

	return $return;
}
add_shortcode('mpc_vc_social_list', 'mpcth_vc_social_list_shortcode');

/* ---------------------------------------------------------------- */
/* 3. Portfolio Meta
/* ---------------------------------------------------------------- */
function mpcth_vc_portfolio_meta_shortcode($atts, $content = null) {
	global $mpcth_options;

	if (get_post_type() != 'mpc_portfolio')
		return;

	$categories = get_the_term_list(get_the_ID(), 'mpc_portfolio_cat', '', ', ', '');

	$tags = get_the_term_list(get_the_ID(), 'mpc_portfolio_tag', '', ', ', '');
	// $tags = get_the_tag_list('', __(', ', 'mpcth'));

	$metadata = get_field('mpc_metadata');

	$return = '<ul class="mpc-sc-portfolio-meta">';
		if (! empty($metadata)) {
			foreach ($metadata as $item) {
				$return .= '<li>';
					$return .= '<span class="mpcth-portfolio-meta-name">' . $item['mpc_description_name'] . ':</span>';
					$return .= '<span class="mpcth-portfolio-meta-text">' . $item['mpc_description_text'] . '</span>';
				$return .= '</li>';
			}
		}
		if ($categories) {
			$return .= '<li class="mpc-sc-portfolio-categories">';
				$return .= '<span class="mpcth-portfolio-meta-name">' . __('Categories', 'mpcth') . ':</span>';
				$return .= '<span class="mpcth-portfolio-meta-text">' . $categories . '</span>';
			$return .= '</li>';
		}
		if ($tags) {
			$return .= '<li class="mpc-sc-portfolio-tags">';
				$return .= '<span class="mpcth-portfolio-meta-name">' . __('Tags', 'mpcth') . ':</span>';
				$return .= '<span class="mpcth-portfolio-meta-text">' . $tags . '</span>';
			$return .= '</li>';
		}
	$return .= '</ul><!-- end .mpc-sc-portfolio-meta -->';

	return $return;
}
add_shortcode('mpc_vc_portfolio_meta', 'mpcth_vc_portfolio_meta_shortcode');

/* ---------------------------------------------------------------- */
/* 4. Products slider
/* ---------------------------------------------------------------- */
function mpcth_vc_products_slider_shortcode($atts, $content = null) {
	global $post;
	global $woocommerce;
	global $page_id;
	global $mpcth_options;

	if(! function_exists('is_woocommerce'))
		return;

	extract(shortcode_atts(array(
		'type'          => 'recent',
		'number'        => '6',
		'category'      => 'all',
		'tag'           => 'all',
		'simple_arrows' => false
	), $atts));

	$post_type = get_post_type($page_id);

	if($type == 'related' && $post_type != 'product')
		return;

	$number = (int) $number;
	if ( $number < 1 ) $number = 1;
	else if ( $number > 16 ) $number = 15;

	$query_args = array(
		'posts_per_page' => $number,
		'post_status' 	 => 'publish',
		'post_type' 	 => 'product',
		'no_found_rows'  => 1,
		'post__not_in' 	 => array($post->ID),
	);

	$query_args['tax_query'] = array();
	if ($category != 'all')
		$query_args['tax_query'][] = array(
				'taxonomy' 	=> 'product_cat',
				'field' 	=> 'term_id',
				'terms' 	=> $category
		);

	if ($tag != 'all')
		$query_args['tax_query'][] = array(
				'taxonomy' 	=> 'product_tag',
				'field' 	=> 'term_id',
				'terms' 	=> $tag
		);

	if ($type == 'sellers') {
		$query_args['meta_key'] = 'total_sales';
		$query_args['orderby'] = 'meta_value_num';
	}

	if ($type == 'random')
		$query_args['orderby'] = 'rand';

	if ($type == 'related') {
		$ids = array();
		$categories = get_the_terms($post->ID, 'product_cat');

		if ($categories === false)
			return;

		foreach ($categories as $category) {
			$ids[] = $category->term_id;
		}

		$query_args['tax_query'][] = array(
			'taxonomy' 	=> 'product_cat',
			'field' 	=> 'term_id',
			'terms' 	=> $ids
		);
	}

	if ($type == 'sale') {
		$query_args['meta_query'] = array(
			'relation' => 'OR',
			array(
				'key'     => '_sale_price',
				'value'   => 0,
				'compare' => '>',
				'type'    => 'numeric'
			),
			array(
				'key'     => '_min_variation_sale_price',
				'value'   => 0,
				'compare' => '>',
				'type'    => 'numeric'
			)
		);
	}

	if ($type == 'rated') add_filter( 'posts_clauses',  array( $woocommerce->query, 'order_by_rating_post_clauses' ) );

	$custom_query = new WP_Query($query_args);

	$quickview_text = __('Quickview', 'mpcth');
	$quickview_icon = 'eye';

	global $jckqv;
	if (isset($jckqv)) {
		$quickview_settings = $jckqv->settings->__getSettings();
		$quickview_text = $quickview_settings['trigger_styling_text'];
		$quickview_icon = $quickview_settings['trigger_styling_icon'];
	}

	$products_slider_style = 'default';
	if (isset($mpcth_options['mpcth_products_slider_style']) && $mpcth_options['mpcth_products_slider_style'])
		$products_slider_style = $mpcth_options['mpcth_products_slider_style'];

	$return = '<div class="mpcth-waypoint mpcth-items-slider-wrap' . ($simple_arrows ? ' mpcth-simple-arrows' : '') . ' mpcth-shop-style-' . $products_slider_style . '">';
		$return .= '<div class="mpcth-items-slider-container-wrap">';
		$return .= '<div class="mpcth-items-slider-container woocommerce">';
			$return .= '<div class="mpc-vc-products-slider mpcth-items-slider products">';

			if ($custom_query->have_posts()) {
				while ($custom_query->have_posts()) {
					$custom_query->the_post();
					global $product;

					$product_gallery = $product->get_gallery_attachment_ids();
					$display_second_image = '';
					if (! empty($product_gallery))
						$display_second_image = ' mpcth-double-image';

					if (! empty($mpcth_options['mpcth_disable_product_hover']) && $mpcth_options['mpcth_disable_product_hover'])
						$display_second_image = '';

					ob_start();
					?>

					<div id="post-<?php the_ID(); ?>" <?php post_class('mpcth-waypoint mpcth-slide ' . $display_second_image . ($product->get_price_html() == '' ? ' mpcth-empty-price' : '')); ?> >
						<div class="mpcth-product-wrap">
							<?php do_action('woocommerce_before_shop_loop_item_title'); ?>
							<header class="mpcth-post-header">
								<a class="mpcth-post-thumbnail" href="<?php the_permalink(); ?>">
									<?php do_action('mpcth_before_shop_loop_item_title'); ?>
								</a>
								<div class="mpcth-product-panel">
									<?php if (shortcode_exists('yith_wcwl_add_to_wishlist')) echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>
								</div>
							</header>
							<section class="mpcth-post-content">
								<?php if (isset($products_slider_style)) { ?>
									<?php if ($products_slider_style == 'slim') { ?>
										<div class="mpcth-post-content-wrap">
											<?php woocommerce_template_loop_price(); ?>
											<h6 class="mpcth-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
											<?php mpcth_wc_product_categories(); ?>
											<div class="mpcth-cart-wrap">
												<?php woocommerce_template_loop_add_to_cart(); ?>
												<?php if (shortcode_exists('yith_wcwl_add_to_wishlist')) echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>
												<?php if (class_exists('jckqv')) { ?>
													<a href="<?php the_permalink(); ?>" class="mpcth-quick-view" data-jckqvpid="<?php the_ID(); ?>"><i class="fa fa-fw fa-<?php echo $quickview_icon; ?>"></i><span><?php echo $quickview_text; ?></span></a>
												<?php } ?>
											</div>
										</div>
									<?php } elseif ($products_slider_style == 'center') { ?>
										<div class="mpcth-post-content-wrap">
											<?php woocommerce_template_loop_price(); ?>
											<h6 class="mpcth-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
											<?php mpcth_wc_product_categories(); ?>
											<div class="mpcth-price-wrap">
												<?php woocommerce_template_loop_price(); ?>
											</div>
											<div class="mpcth-cart-wrap">
												<?php woocommerce_template_loop_add_to_cart(); ?>
												<?php if (shortcode_exists('yith_wcwl_add_to_wishlist')) echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>
												<?php if (class_exists('jckqv')) { ?>
													<a href="<?php the_permalink(); ?>" class="mpcth-quick-view" data-jckqvpid="<?php the_ID(); ?>"><i class="fa fa-fw fa-<?php echo $quickview_icon; ?>"></i><span><?php echo $quickview_text; ?></span></a>
												<?php } ?>
											</div>
										</div>
									<?php } else { ?>
										<div class="mpcth-cart-wrap">
											<?php woocommerce_template_loop_price(); ?>
											<?php woocommerce_template_loop_add_to_cart(); ?>
										</div>
										<h6 class="mpcth-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
										<?php mpcth_wc_product_categories(); ?>
									<?php } ?>
								<?php } else { ?>
									<div class="mpcth-cart-wrap">
										<?php woocommerce_template_loop_price(); ?>
										<?php woocommerce_template_loop_add_to_cart(); ?>
									</div>
									<h6 class="mpcth-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
									<?php mpcth_wc_product_categories(); ?>
								<?php } ?>
							</section>
						</div>
					</div>

					<?php
					$return .= ob_get_clean();
				}
			}

			$return .= '</div>';
		$return .= '</div>';
		$return .= '</div>';
		$return .= '<a href="#" class="mpcth-items-slider-next mpcth-color-main-color"><i class="fa fa-angle-right"></i></a>';
		$return .= '<a href="#" class="mpcth-items-slider-prev mpcth-color-main-color"><i class="fa fa-angle-left"></i></a>';
	$return .= '</div>';

	wp_reset_postdata();

	if ($type == 'rated') remove_filter( 'posts_clauses', array( $woocommerce->query, 'order_by_rating_post_clauses' ) );

	return $return;
}
add_shortcode('mpc_vc_products_slider', 'mpcth_vc_products_slider_shortcode');

function mpcth_vc_get_products_categories() {
	$products_categories = get_terms('product_cat');

	$categories = array('All' => 'all');
	if (! empty($products_categories)) {
		foreach ($products_categories as $category) {
			$categories[$category->name] = $category->term_id;
		}
	}

	return $categories;
}
function mpcth_vc_get_products_tags() {
	$products_tags = get_terms('product_tag');

	$tags = array('All' => 'all');
	if (! empty($products_tags)) {
		foreach ($products_tags as $tag) {
			$tags[$tag->name] = $tag->term_id;
		}
	}

	return $tags;
}

/* ---------------------------------------------------------------- */
/* 5. Products categories slider
/* ---------------------------------------------------------------- */
function mpcth_vc_products_categories_slider_shortcode($atts, $content = null) {
	global $woocommerce;

	extract(shortcode_atts(array(
		'filter'        => '',
		'simple_arrows' => false
	), $atts));

	$include = array();
	if ($filter != '') {
		$filters = explode(',', $filter);
		foreach ($filters as $key) {
			$term = get_term_by('slug', $key, 'product_cat');
			if(! empty($term))
				$include[] = $term->term_id;
		}
	}

	$args = array(
		'pad_counts' => true,
		'include' => $include
	);

	$product_categories = get_terms('product_cat', $args);

	$return = '<div class="mpcth-waypoint mpcth-items-slider-wrap' . ($simple_arrows ? ' mpcth-simple-arrows' : '') . '">';
		$return .= '<div class="mpcth-items-slider-container-wrap">';
		$return .= '<div class="mpcth-items-slider-container">';
			$return .= '<div class="mpc-vc-products-categories-slider mpcth-items-slider">';

			if (! is_wp_error($product_categories)) {
				foreach ($product_categories as $category) {
					$return .= '<a href="' . get_term_link($category, 'product_cat') . '" class="mpcth-slide">';
						ob_start();
							woocommerce_subcategory_thumbnail($category);
						$return .= ob_get_clean();

						$return .= '<div class="mpcth-slide-content">';
							$return .= '<h4 class="mpcth-slide-title">' . $category->name . '</h4>';
							$return .= '<span class="mpcth-slide-count">' . ( $category->count > 0 ? sprintf(_n( '1 Item','%s Items', $category->count, 'mpcth'), $category->count) : '' ) . '</span>';
						$return .= '</div>';
					$return .= '</a>';
				}
			}

			$return .= '</div>';
		$return .= '</div>';
		$return .= '</div>';
		$return .= '<a href="#" class="mpcth-items-slider-next mpcth-color-main-color"><i class="fa fa-angle-right"></i></a>';
		$return .= '<a href="#" class="mpcth-items-slider-prev mpcth-color-main-color"><i class="fa fa-angle-left"></i></a>';
	$return .= '</div>';

	return $return;
}
add_shortcode('mpc_vc_products_categories_slider', 'mpcth_vc_products_categories_slider_shortcode');

/* ---------------------------------------------------------------- */
/* 6. Blog post slider
/* ---------------------------------------------------------------- */
function mpcth_vc_blog_posts_slider_shortcode($atts, $content = null) {
	global $post;
	global $page_id;

	extract(shortcode_atts(array(
		'type'          => 'recent',
		'number'        => '6',
		'rows'          => '2',
		'category'      => 'all',
		'tag'           => 'all',
		'simple_arrows' => false
	), $atts));

	$post_type = get_post_type($page_id);

	if($type == 'related' && $post_type != 'post')
		return;

	$number = (int) $number;
	if ( $number < 1 ) $number = 1;
	else if ( $number > 16 ) $number = 15;

	$rows = (int) $rows;
	if ( $rows < 1 ) $rows = 1;
	else if ( $rows > 4 ) $rows = 4;

	$excluded_posts = get_option("sticky_posts");
	$excluded_posts[] = $post->ID;

	$query_args = array(
		'posts_per_page' => $number,
		'post_status' 	 => 'publish',
		'post_type' 	 => 'post',
		'no_found_rows'  => 1,
		'post__not_in' 	 => $excluded_posts,
	);

	$query_args['tax_query'] = array();
	if ($category != 'all')
		$query_args['tax_query'][] = array(
				'taxonomy' 	=> 'category',
				'field' 	=> 'term_id',
				'terms' 	=> $category
		);

	if ($tag != 'all')
		$query_args['tax_query'][] = array(
				'taxonomy' 	=> 'post_tag',
				'field' 	=> 'term_id',
				'terms' 	=> $tag
		);

	if ($type == 'random')
		$query_args['orderby'] = 'rand';

	if ($type == 'related') {
		$ids = array();
		$categories = get_the_terms($post->ID, 'category');

		if ($categories === false)
			return;

		foreach ($categories as $category) {
			$ids[] = $category->term_id;
		}

		$query_args['tax_query'][] = array(
			'taxonomy' 	=> 'category',
			'field' 	=> 'term_id',
			'terms' 	=> $ids
		);
	}

	$custom_query = new WP_Query($query_args);

	$return = '<div class="mpcth-waypoint mpcth-items-slider-wrap' . ($simple_arrows ? ' mpcth-simple-arrows' : '') . '">';
		$return .= '<div class="mpcth-items-slider-container-wrap">';
		$return .= '<div class="mpcth-items-slider-container">';
			$return .= '<div class="mpc-vc-blog-posts-slider mpcth-items-slider mpcth-items-slider-wide">';

			if ($custom_query->have_posts()) {
				$double = 1;

				while ($custom_query->have_posts()) {
					$custom_query->the_post();
					$excerpt = get_the_excerpt();

					if ($double % $rows == 1 || $rows == 1)
						$return .= '<div class="mpcth-slide-wrap">';

					$return .= '<a href="' . get_permalink() . '" class="mpcth-slide' . ($double % $rows != 0 && $rows != 1 ? ' mpcth-slide-row-gap' : '') . '">';
						$return .= (has_post_thumbnail() ? get_the_post_thumbnail( $custom_query->post->ID, 'mpcth-horizontal-columns-2') : '');
						$return .= '<div class="mpcth-slide-wrapper">';
							$return .= '<h4 class="mpcth-slide-title">' . get_the_title() . '</h4>';
							$return .= '<time class="mpcth-slide-time" datetime="' . get_the_date('c') . '">' . get_the_time(get_option('date_format')) . '</time>';
							$return .= '<p class="mpcth-slide-text">' . wp_trim_words($excerpt, 25) . '</p>';
							$return .= '<div class="mpcth-slide-trim"></div>';
						$return .= '</div>';
					$return .= '</a>';

					if ($double % $rows == 0 || $rows == 1)
						$return .= '</div>';

					$double++;
				}
			}

			$return .= '</div>';
		$return .= '</div>';
		$return .= '</div>';
		$return .= '<a href="#" class="mpcth-items-slider-next mpcth-color-main-color"><i class="fa fa-angle-right"></i></a>';
		$return .= '<a href="#" class="mpcth-items-slider-prev mpcth-color-main-color"><i class="fa fa-angle-left"></i></a>';
	$return .= '</div>';

	wp_reset_postdata();

	return $return;
}
add_shortcode('mpc_vc_blog_posts_slider', 'mpcth_vc_blog_posts_slider_shortcode');

function mpcth_vc_get_blog_posts_categories() {
	$post_categories = get_terms('category');

	$categories = array('All' => 'all');
	if (! empty($post_categories)) {
		foreach ($post_categories as $category) {
			$categories[$category->name] = $category->term_id;
		}
	}

	return $categories;
}
function mpcth_vc_get_blog_posts_tags() {
	$post_tags = get_terms('post_tag');

	$tags = array('All' => 'all');
	if (! empty($post_tags)) {
		foreach ($post_tags as $tag) {
			$tags[$tag->name] = $tag->term_id;
		}
	}

	return $tags;
}

/* ---------------------------------------------------------------- */
/* 7. Lookbooks slider
/* ---------------------------------------------------------------- */
function mpcth_vc_lookbooks_slider_shortcode($atts, $content = null) {
	extract(shortcode_atts(array(
		'simple_arrows'  => false
	), $atts));

	$args = array();

	$query_args = array(
		'post_status' 	 => 'publish',
		'post_type' 	 => 'page',
		'no_found_rows'  => 1,
		'meta_key' 		 => '_wp_page_template',
		'meta_value' 	 => 'template-lookbook.php'
	);

	$custom_query = new WP_Query($query_args);

	$return = '<div class="mpcth-waypoint mpcth-items-slider-wrap' . ($simple_arrows ? ' mpcth-simple-arrows' : '') . '">';
		$return .= '<div class="mpcth-items-slider-container-wrap">';
		$return .= '<div class="mpcth-items-slider-container">';
			$return .= '<div class="mpc-vc-lookbooks-slider mpcth-items-slider mpcth-items-slider-wide">';

			if ($custom_query->have_posts()) {

				while ($custom_query->have_posts()) {
					$custom_query->the_post();
					$return .= '<a href="' . get_permalink() . '" class="mpcth-slide">';
						$return .= (has_post_thumbnail() ? get_the_post_thumbnail( $custom_query->post->ID, 'mpcth-horizontal-columns-2') : '');
						$return .= '<div class="mpcth-slide-content">';
							$return .= '<h4 class="mpcth-slide-title mpcth-color-main-color">' . __('Take a closer look', 'mpcth') . '</h4>';
						$return .= '</div>';
					$return .= '</a>';
				}
			}

			$return .= '</div>';
		$return .= '</div>';
		$return .= '</div>';
		$return .= '<a href="#" class="mpcth-items-slider-next mpcth-color-main-color"><i class="fa fa-angle-right"></i></a>';
		$return .= '<a href="#" class="mpcth-items-slider-prev mpcth-color-main-color"><i class="fa fa-angle-left"></i></a>';
	$return .= '</div>';

	wp_reset_postdata();

	return $return;
}
add_shortcode('mpc_vc_lookbooks_slider', 'mpcth_vc_lookbooks_slider_shortcode');

/* ---------------------------------------------------------------- */
/* 8. Deco header
/* ---------------------------------------------------------------- */
function mpcth_vc_deco_header_shortcode($atts, $content = null) {
	extract(shortcode_atts(array(
		'type' => 'h6',
		'text' => ''
	), $atts));

	$return = '<' . $type . ' class="mpc-vc-deco-header"><span class="mpcth-color-main-border">';
		$return .= esc_html($text);
	$return .= '</span></' . $type . '>';

	return $return;
}
add_shortcode('mpc_vc_deco_header', 'mpcth_vc_deco_header_shortcode');

/* ---------------------------------------------------------------- */
/* 9. Icon column
/* ---------------------------------------------------------------- */
function mpcth_vc_icon_column_shortcode($atts, $content = null) {
	extract(shortcode_atts(array(
		'icon'           => '',
		'color'          => '',
		'title'          => '',
		'text'           => '',
		'link'           => '',
		'simple_version' => false
	), $atts));

	$css_id = 'mpcth_icon_column_' . mpc_vc_random_ID(5);

	if ($link)
		$return = '<a id="' . $css_id . '" class="mpc-vc-icon-column-wrap' . ($simple_version ? ' mpc-vc-icon-column-simple' : '') . '" href="' . $link . '">';
	else
		$return = '<div id="' . $css_id . '" class="mpc-vc-icon-column-wrap' . ($simple_version ? ' mpc-vc-icon-column-simple' : '') . '">';
		if ($icon != '_none') {
			$return .= '<style type="text/css">';
				if (! $simple_version) {
					$return .= '#' . $css_id . ' .mpc-vc-icon-column-icon i {color:' . $color . ';}';
					$return .= '#mpcth_page_wrap #' . $css_id . ':hover .mpc-vc-icon-column-icon .mpc-vc-icon-column-arrow {border-top-color:' . $color . ';}';
					$return .= '#mpcth_page_wrap #' . $css_id . ':hover .mpc-vc-icon-column-icon {background:' . $color . ';}';
				} else {
					$return .= '#mpcth_page_wrap #' . $css_id . '.mpc-vc-icon-column-simple:hover .mpc-vc-icon-column-icon i {color:' . $color . ';}';
				}
			$return .= '</style>';
			$return .= '<div class="mpc-vc-icon-column-icon">';
				$return .= '<i class="fa ' . $icon . '"></i>';
				if (! $simple_version) {
					$return .= '<div class="mpc-vc-icon-column-arrow mpc-vc-icon-column-arrow-bottom"></div>';
					$return .= '<div class="mpc-vc-icon-column-arrow"></div>';
				}
			$return .= '</div>';
		}
		$return .= '<div class="mpc-vc-icon-column-content">';
			if ($title) $return .= '<h5 class="mpc-vc-icon-column-title">' . $title . '</h5>';
			if ($text) $return .= '<p class="mpc-vc-icon-column-text">' . $text . '</p>';
		$return .= '</div>';

	if ($link)
		$return .= '</a>';
	else
		$return .= '</div>';

	return $return;
}
add_shortcode('mpc_vc_icon_column', 'mpcth_vc_icon_column_shortcode');

/* ---------------------------------------------------------------- */
/* 10. Code wrapper
/* ---------------------------------------------------------------- */
function mpcth_vc_code_shortcode($atts, $content = null) {
	extract(shortcode_atts(array(
		'text' => ''
	), $atts));

	$return = '<pre class="mpc-vc-code-wrapper">';
		$return .= htmlentities(rawurldecode(base64_decode($text)));
	$return .= '</pre>';

	return $return;
}
add_shortcode('mpc_vc_code', 'mpcth_vc_code_shortcode');

/* ---------------------------------------------------------------- */
/* 11. Share list
/* ---------------------------------------------------------------- */
function mpcth_vc_share_list_shortcode($atts, $content = null) {
	extract(shortcode_atts(array(
		'title'       => '',
		'facebook'    => '',
		'twitter'     => '',
		'google_plus' => '',
		'pinterest'   => '',
	), $atts));

	$return = '<div class="mpc-vc-share-list">';
		if ($title != '') $return .= '<span class="mpc-vc-share-list-text">' . $title . ' </span>';
		if ($facebook) {
			$return .= '<a href="#" class="mpc-vc-share-facebook mpcth-color-main-color-hover">';
				$return .= '<i class=" fa fa-facebook"></i>';
			$return .= '</a>';
		}
		if ($twitter) {
			$return .= '<a href="#" class="mpc-vc-share-twitter mpcth-color-main-color-hover">';
				$return .= '<i class=" fa fa-twitter"></i>';
			$return .= '</a>';
		}
		if ($google_plus) {
			$return .= '<a href="#" class="mpc-vc-share-google-plus mpcth-color-main-color-hover">';
				$return .= '<i class=" fa fa-google-plus"></i>';
			$return .= '</a>';
		}
		if ($pinterest) {
			$return .= '<a href="#" class="mpc-vc-share-pinterest mpcth-color-main-color-hover">';
				$return .= '<i class=" fa fa-pinterest"></i>';
			$return .= '</a>';
		}

	$return .= '</div>';

	return $return;
}
add_shortcode('mpc_vc_share_list', 'mpcth_vc_share_list_shortcode');

/* ---------------------------------------------------------------- */
/* 12. Portfolio post slider
/* ---------------------------------------------------------------- */
function mpcth_vc_portfolio_posts_slider_shortcode($atts, $content = null) {
	global $post;
	global $page_id;

	extract(shortcode_atts(array(
		'type'          => 'recent',
		'number'        => '6',
		'category'      => 'all',
		'tag'           => 'all',
		'simple_arrows' => false
	), $atts));

	$post_type = get_post_type($page_id);

	if($type == 'related' && $post_type != 'mpc_portfolio')
		return;

	$number = (int) $number;
	if ( $number < 1 ) $number = 1;
	else if ( $number > 16 ) $number = 15;

	$query_args = array(
		'posts_per_page' => $number,
		'post_status' 	 => 'publish',
		'post_type' 	 => 'mpc_portfolio',
		'no_found_rows'  => 1,
		'post__not_in' 	 => array($post->ID),
	);

	$query_args['tax_query'] = array();
	if ($category != 'all')
		$query_args['tax_query'][] = array(
				'taxonomy' 	=> 'mpc_portfolio_cat',
				'field' 	=> 'term_id',
				'terms' 	=> $category
		);

	if ($tag != 'all')
		$query_args['tax_query'][] = array(
				'taxonomy' 	=> 'mpc_portfolio_tag',
				'field' 	=> 'term_id',
				'terms' 	=> $tag
		);

	if ($type == 'random')
		$query_args['orderby'] = 'rand';

	if ($type == 'related') {
		$ids = array();
		$categories = get_the_terms($post->ID, 'mpc_portfolio_cat');

		if ($categories === false)
			return;

		foreach ($categories as $category) {
			$ids[] = $category->term_id;
		}

		$query_args['tax_query'][] = array(
			'taxonomy' 	=> 'mpc_portfolio_cat',
			'field' 	=> 'term_id',
			'terms' 	=> $ids
		);
	}

	$custom_query = new WP_Query($query_args);

	$return = '<div class="mpcth-waypoint mpcth-items-slider-wrap' . ($simple_arrows ? ' mpcth-simple-arrows' : '') . '">';
		$return .= '<div class="mpcth-items-slider-container-wrap">';
		$return .= '<div class="mpcth-items-slider-container portfolio">';
			$return .= '<div class="mpc-vc-portfolio-posts-slider mpcth-items-slider">';

			if ($custom_query->have_posts()) {
				while ($custom_query->have_posts()) {
					$custom_query->the_post();

					$post_format = get_post_format();

					if($post_format === false)
						$post_format = 'standard';

					$categories = get_the_terms(get_the_ID(), 'mpc_portfolio_cat');
					$categories_data = '';
					if ($categories && ! is_wp_error($categories)) {
						foreach ($categories as $category) {
							$categories_data .= ' filter-' . $category->slug ;
						}
					}
					ob_start();
					?>
					<article id="post-<?php the_ID(); ?>" <?php post_class('mpcth-slide mpcth-post mpcth-waypoint' . $categories_data); ?> data-title="<?php the_title(); ?>" data-date="<?php the_date('Ymd'); ?>">
						<header class="mpcth-post-header">
							<div class="mpcth-post-thumbnail">
								<?php if (has_post_thumbnail()) {
									the_post_thumbnail('mpcth-horizontal-columns-4');
								} elseif ($post_format == 'gallery') {
									$images = get_field('mpc_gallery_images');

									if (! empty($images))
										echo wp_get_attachment_image($images[0]['id'], 'mpcth-horizontal-columns-4');
								} ?>
							</div>
						</header>
						<section class="mpcth-post-content">
							<a href="<?php the_permalink(); ?>" class="mpcth-post-background-link"></a>
							<?php mpcth_add_lightbox(); ?>
							<div class="mpcth-post-spacer"></div>
							<div class="mpcth-post-wrapper">
								<h5 class="mpcth-post-title">
									<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
								</h5>
								<?php
								$categories = get_the_term_list(get_the_ID(), 'mpc_portfolio_cat', '', ', ', '');

								if ($categories)
									echo '<span class="mpcth-post-categories">' . $categories . '</span>';
								?>
							</div>
						</section>
					</article>
					<?php
					$return .= ob_get_clean();
				}
			}

			$return .= '</div>';
		$return .= '</div>';
		$return .= '</div>';
		$return .= '<a href="#" class="mpcth-items-slider-next mpcth-color-main-color"><i class="fa fa-angle-right"></i></a>';
		$return .= '<a href="#" class="mpcth-items-slider-prev mpcth-color-main-color"><i class="fa fa-angle-left"></i></a>';
	$return .= '</div>';

	wp_reset_query();

	return $return;
}
add_shortcode('mpc_vc_portfolio_posts_slider', 'mpcth_vc_portfolio_posts_slider_shortcode');

function mpcth_vc_get_portfolio_posts_categories() {
	$post_categories = get_terms('mpc_portfolio_cat');

	$categories = array('All' => 'all');
	if (! empty($post_categories)) {
		foreach ($post_categories as $category) {
			$categories[$category->name] = $category->term_id;
		}
	}

	return $categories;
}
function mpcth_vc_get_portfolio_posts_tags() {
	$post_tags = get_terms('mpc_portfolio_tag');

	$tags = array('All' => 'all');
	if (! empty($post_tags)) {
		foreach ($post_tags as $tag) {
			$tags[$tag->name] = $tag->term_id;
		}
	}

	return $tags;
}

/* ---------------------------------------------------------------- */
/* 13. Blockquote
/* ---------------------------------------------------------------- */
function mpcth_vc_quote_shortcode($atts, $content = null) {
	extract(shortcode_atts(array(
		'quote'  => '',
		'author' => ''
	), $atts));

	$return = '<blockquote class="mpc-vc-quote">';
		$return .= '<p><span class="mpc-vc-quote-left">&ldquo;</span>';
			$return .= $quote;
		$return .= '<span class="mpc-vc-quote-right">&rdquo;</span></p>';
		if ($author)
			$return .= '<cite>' . $author . '</cite>';
	$return .= '</blockquote>';

	return $return;
}
add_shortcode('mpc_vc_quote', 'mpcth_vc_quote_shortcode');

/* ---------------------------------------------------------------- */
/* 14. Images slider
/* ---------------------------------------------------------------- */
function mpcth_vc_images_slider_shortcode($atts, $content = null) {
	extract(shortcode_atts(array(
		'images'        => '',
		'links'         => '',
		'brands'        => '',
		'external'      => false,
		'simple_arrows' => false
	), $atts));

	if ($links != '')
		$links = explode(',', $links);

	if ($images != '')
		$images = explode(',', $images);
	else
		return;

	$first_image = wp_get_attachment_image_src($images[0], 'full');

	$return = '<div class="mpcth-waypoint mpcth-items-slider-wrap' . ($simple_arrows ? ' mpcth-simple-arrows' : '') . '">';
		$return .= '<div class="mpcth-items-slider-container-wrap">';
		$return .= '<div class="mpcth-items-slider-container">';
			$return .= '<div class="mpc-vc-images-slider mpcth-items-slider' . ($brands ? ' mpcth-brands' : '') . '"' . (!empty($first_image[1]) ? ' data-max-width="' . $first_image[1] . '"' : '') . '>';

			foreach ($images as $index => $image) {
				if (! empty($links[$index]))
					$return .= '<a href="' . $links[$index] . '" ' . ($external ? 'target="_blank"' : '') . ' class="mpcth-slide">';
				else
					$return .= '<div class="mpcth-slide">';

					$image_attr = wp_get_attachment_image_src($image, 'full');
					if (! empty($image_attr))
						$return .= '<img src="' . $image_attr[0] . '">';

				if (! empty($links[$index]))
					$return .= '</a>';
				else
					$return .= '</div>';
			}

			$return .= '</div>';
		$return .= '</div>';
		$return .= '</div>';
		$return .= '<a href="#" class="mpcth-items-slider-next mpcth-color-main-color"><i class="fa fa-angle-right"></i></a>';
		$return .= '<a href="#" class="mpcth-items-slider-prev mpcth-color-main-color"><i class="fa fa-angle-left"></i></a>';
	$return .= '</div>';

	return $return;
}
add_shortcode('mpc_vc_images_slider', 'mpcth_vc_images_slider_shortcode');

/* ---------------------------------------------------------------- */
/* 15. Testimonials
/* ---------------------------------------------------------------- */
function mpcth_vc_testimonials_slider_shortcode($atts, $content = null) {
	extract(shortcode_atts(array(
		'simple_arrows' => false
	), $atts));

	try {
		$icon_items = json_decode($content);
	} catch (Exception $e) {
		$icon_items = array();
	}

	if (! is_array($icon_items)) $icon_items = array();

	$return = '<div class="mpc-vc-testimonials mpcth-waypoint flexslider' . ($simple_arrows ? ' mpcth-simple-arrows' : '') . '">';
		$return .= '<ul class="slides">';
		foreach ($icon_items as $item) {
			$return .= '<li>';
				$return .= '<blockquote class="mpc-vc-quote">';
					$return .= '<p><span class="mpc-vc-quote-left">“</span>';
						$return .= $item->text;
					$return .= '<span class="mpc-vc-quote-right">”</span></p>';
					$return .= '<cite>' . $item->author . '</cite>';
				$return .= '</blockquote>';
			$return .= '</li>';
		}
		$return .= '</ul>';
	$return .= '</div>';

	return $return;
}
add_shortcode('mpc_vc_testimonials_slider', 'mpcth_vc_testimonials_slider_shortcode');

/* ---------------------------------------------------------------- */
/* 16. Counter
/* ---------------------------------------------------------------- */
function mpcth_vc_counter_shortcode($atts, $content = null) {
	extract(shortcode_atts(array(
		'begin' => '',
		'end'   => '',
		'color' => '',
		'size'  => '',
		'align' => '',
	), $atts));

	$id = 'mpcth_counter_' . mpc_vc_random_ID(5);

	$return = '<div id="' . $id . '" class="mpc-vc-counter mpcth-waypoint" style="color:' . $color . '; font-size:' . $size . '; text-align:' . $align . ';" data-begin="' . $begin . '" data-end="' . $end . '">' . $begin . '</div>';

	return $return;
}
add_shortcode('mpc_vc_counter', 'mpcth_vc_counter_shortcode');

/* ---------------------------------------------------------------- */
/* 17. Icon
/* ---------------------------------------------------------------- */
function mpcth_vc_icon_shortcode($atts, $content = null) {
	extract(shortcode_atts(array(
		'icon'  => '',
		'color' => '',
		'size'  => '',
		'align' => '',
	), $atts));

	$return = '<div class="mpc-vc-icon" style="color:' . $color . '; font-size:' . $size . '; text-align:' . $align . ';" ><i class="fa fa-fw fa-' . $icon . '"></i></div>';

	return $return;
}
add_shortcode('mpc_vc_icon', 'mpcth_vc_icon_shortcode');

/* ---------------------------------------------------------------- */
/* 18. Post Thumbnail
/* ---------------------------------------------------------------- */
function mpcth_vc_post_thumbnail_shortcode($atts, $content = null) {
	if (get_post_type() != 'post')
		return;

	$post_format = get_post_format();
	if($post_format === false)
		$post_format = 'standard';

	ob_start();
	?>

	<div class="mpcth-post-thumbnail">
		<?php get_template_part('post-format', $post_format); ?>
	</div><!-- end .mpcth-post-thumbnail -->

	<?php
	$return = ob_get_clean();

	return $return;
}
add_shortcode('mpc_vc_post_thumbnail', 'mpcth_vc_post_thumbnail_shortcode');

/* ---------------------------------------------------------------- */
/* 19. Grid image
/* ---------------------------------------------------------------- */
function mpcth_vc_grid_image_shortcode($atts, $content = null) {
	extract(shortcode_atts(array(
		'image'         => '',
		'url'           => '',
		'title'         => '',
		'sub_title'     => '',
		'double_column' => false,
	), $atts));

	$img_size = $double_column ? '760x400' : '400x400';

	$img_id = preg_replace( '/[^\d]/', '', $image );
	$img = wpb_getImageBySize( array( 'attach_id' => $img_id, 'thumb_size' => $img_size ) );
	if ( $img == NULL ) $img['thumbnail'] = '<img src="' . vc_asset_url( 'vc/no_image.png' ) . '" />';

	// $image = wp_get_attachment_image_src($image, 'full');

	if ($url != '') $return = '<a class="mpcth-grid-image' . ($double_column ? ' mpcth-grid-double' : '') . '" href="' . esc_url($url) . '">';
	else $return = '<div class="mpcth-grid-image' . ($double_column ? ' mpcth-grid-double' : '') . '">';

		$return .= '<span class="mpcth-grid-image-wrap">';
			// $return .= '<img src="' . $image[0] . '" width="' . $image[1] . '" height="' . $image[2] . '" alt="Grid" />';
			$return .= $img['thumbnail'];
			if ($title != '' || $sub_title != '') {
				$return .= '<span class="mpcth-grid-title-wrap">';
					if ($title != '') $return .= '<h4>' . $title . '</h4>';
					$return .= '<div class="mpcth-grid-title-break"></div>';
					if ($sub_title != '') $return .= '<small>' . $sub_title . '</small>';
				$return .= '</span>';
			}
		$return .= '</span>';

	if ($url != '') $return .= '</a>';
	else $return .= '</div>';

	return $return;
}
add_shortcode('mpc_vc_grid_image', 'mpcth_vc_grid_image_shortcode');

/* ---------------------------------------------------------------- */
/* 20. Grid
/* ---------------------------------------------------------------- */
function mpcth_vc_grid_shortcode($atts, $content = null) {
	extract(shortcode_atts(array(
		'id'     => '',
		'spaces' => '',
	), $atts));

	$grid = get_post($id);

	$return = '<div id="mpcth_grid" ' . ($spaces ? 'class="mpcth-grid-with-space"' : '') . '>';
		$return .= do_shortcode($grid->post_content);
	$return .= '</div>';

	return $return;
}
add_shortcode('mpc_vc_grid', 'mpcth_vc_grid_shortcode');


/* -------------------------------------------------------------------------- */


/* Modify VC */
add_action('init', 'mpc_vc_wpb_map_on_init');
function mpc_vc_wpb_map_on_init() {
	global $mpcth_options;
	$theme_base_color = isset($mpcth_options['mpcth_color_main']) ? $mpcth_options['mpcth_color_main'] : '#B163A3';

	/* Hidden input | START */
	function hidden_fb_input($settings, $value) {
		$dependency = vc_generate_dependencies_attributes($settings);
		$return = '<input name="' . $settings['param_name'] . '" class="wpb_vc_param_value wpb-textinput ' . $settings['param_name'] . ' ' . $settings['type'] . '_field mpc-vc-hidden-fb" type="text" value="' . $value. '" ' . $dependency . '/>';

		return $return;
	}

	if(function_exists('add_shortcode_param'))
		add_shortcode_param('hidden_fb', 'hidden_fb_input', MPC_EXTENSIONS_URL . '/js/mpc-vc-hidden-fb.js');
	/* Hidden input | END */

/* ---------------------------------------------------------------- */
/* Edit Visual Composer shortcodes
/* ---------------------------------------------------------------- */
	// if(function_exists('vc_map_update')) {
	// 	$setting = array (
	// 		'js_view' => ''
	// 	);
	// 	vc_map_update('vc_button', $setting);
	// }

	if(function_exists('vc_remove_param')) {
		vc_remove_param('vc_cta_button', 'color');
		vc_remove_param('vc_cta_button', 'icon');
		vc_remove_param('vc_cta_button', 'size');
		vc_remove_param('vc_button', 'color');
		vc_remove_param('vc_button', 'icon');
		vc_remove_param('vc_button', 'size');

		vc_remove_param('vc_separator', 'el_width');
		vc_remove_param('vc_text_separator', 'el_width');
	}

	if(function_exists('vc_add_param')) {
		$add_css_animation = array(
			"type" => "dropdown",
			"heading" => __("CSS Animation", "js_composer"),
			"param_name" => "css_animation",
			"admin_label" => true,
			"value" => array(__("No", "js_composer") => '', __("Top to bottom", "js_composer") => "top-to-bottom", __("Bottom to top", "js_composer") => "bottom-to-top", __("Left to right", "js_composer") => "left-to-right", __("Right to left", "js_composer") => "right-to-left", __("Appear from center", "js_composer") => "appear"),
			"description" => __("Select animation type if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "js_composer")
		);

		// Separator width 10-100%
		vc_add_param('vc_separator', array(
			'type' => 'dropdown',
			'heading' => __('Element width', 'mpcth'),
			'param_name' => 'el_width',
			'value' => array('100%' => 100, '90%' => 90, '80%' => 80, '70%' => 70, '60%' => 60, '50%' => 50, '40%' => 40, '30%' => 30, '20%' => 20, '10%' => 10),
			'description' => __('Separator element width in percents.', 'mpcth')
		));
		vc_add_param('vc_separator', array(
			'type' => 'dropdown',
			'heading' => __('Element alignment', 'mpcth'),
			'param_name' => 'el_align',
			'value' => array(__('Center', 'mpcth') => 'center', __('Left', 'mpcth') => 'left', __('Right', 'mpcth') => 'right'),
			'description' => __('Separator element alignment.', 'mpcth')
		));

		vc_add_param('vc_text_separator', array(
			'type' => 'dropdown',
			'heading' => __('Element width', 'mpcth'),
			'param_name' => 'el_width',
			'value' => array('100%' => 100, '90%' => 90, '80%' => 80, '70%' => 70, '60%' => 60, '50%' => 50, '40%' => 40, '30%' => 30, '20%' => 20, '10%' => 10),
			'description' => __('Separator element width in percents.', 'mpcth')
		));
		vc_add_param('vc_text_separator', array(
			'type' => 'dropdown',
			'heading' => __('Element alignment', 'mpcth'),
			'param_name' => 'el_align',
			'value' => array(__('Center', 'mpcth') => 'center', __('Left', 'mpcth') => 'left', __('Right', 'mpcth') => 'right'),
			'description' => __('Separator element alignment.', 'mpcth')
		));

		// Sliders simple arrows
		vc_add_param('rev_slider_vc', array(
			'type' => 'checkbox',
			'heading' => __('Simple Arrows', 'mpcth'),
			'param_name' => 'simple_arrows',
			'value' => array(__('Enable simple arrows', 'mpcth') => true),
			'description' => __('Enable simple arrows for this slider.', 'mpcth')
		));
		vc_add_param('vc_gallery', array(
			'type' => 'checkbox',
			'heading' => __('Simple Arrows', 'mpcth'),
			'param_name' => 'simple_arrows',
			'value' => array(__('Enable simple arrows', 'mpcth') => true),
			'description' => __('Enable simple arrows for this slider.', 'mpcth')
		));
		vc_add_param('vc_images_carousel', array(
			'type' => 'checkbox',
			'heading' => __('Simple Arrows', 'mpcth'),
			'param_name' => 'simple_arrows',
			'value' => array(__('Enable simple arrows', 'mpcth') => true),
			'description' => __('Enable simple arrows for this slider.', 'mpcth')
		));

		// Row background
		vc_add_param('vc_row', array(
			'type' => 'colorpicker',
			'heading' => __('Overlay color', 'mpcth'),
			'param_name' => 'overlay_color',
			'value' => '',
			'description' => __('Specify the overlay color for the background.', 'mpcth')
		));
		vc_add_param('vc_row', array(
			'type' => 'textfield',
			'heading' => __('Overlay color opacity', 'mpcth'),
			'param_name' => 'overlay_color_opacity',
			'value' => '50',
			'description' => __('Specify the overlay color opacity (from 0 to 100).', 'mpcth')
		));
		vc_add_param('vc_row', array(
			'type' => 'attach_image',
			'heading' => __('Pattern overlay', 'mpcth'),
			'param_name' => 'overlay_pattern',
			'value' => '',
			'description' => __('Specify the overlay image for the background.', 'mpcth')
		));
		vc_add_param('vc_row', array(
			'type' => 'textfield',
			'heading' => __('Pattern overlay opacity', 'mpcth'),
			'param_name' => 'overlay_pattern_opacity',
			'value' => '50',
			'description' => __('Specify the overlay pattern opacity (from 0 to 100).', 'mpcth')
		));
		vc_add_param('vc_row', array(
			'type' => 'checkbox',
			'heading' => __('Full width', 'mpcth'),
			'param_name' => 'full_width',
			'value' => array(__('Enable full width display', 'mpcth') => true),
			'description' => __('Enable full width display for this row.', 'mpcth')
		));
		vc_add_param('vc_row', array(
			'type' => 'checkbox',
			'heading' => __('Parallax', 'mpcth'),
			'param_name' => 'parallax',
			'value' => array(__('Enable image parallax display', 'mpcth') => true),
			'description' => __('Enable image parallax display for this row.', 'mpcth')
		));
		vc_add_param('vc_row', array(
			'type' => 'textfield',
			'heading' => __('Custom ID', 'mpcth'),
			'param_name' => 'toc_id',
			'value' => '',
			'description' => __('Specify the ID for row.', 'mpcth')
		));
		vc_add_param('vc_row', array(
			'type' => 'hidden_fb',
			'param_name' => 'bg_image_fb',
			'value' => '',
		));
		vc_add_param('vc_row', array(
			'type' => 'hidden_fb',
			'param_name' => 'bg_image_repeat_fb',
			'value' => '',
		));
		vc_add_param('vc_row', $add_css_animation);

		// Button icon and color
		vc_add_param('vc_button', array(
			'type' => 'colorpicker',
			'heading' => __('Button color', 'mpcth'),
			'param_name' => 'custom_color',
			'value' => $theme_base_color,
			'description' => __('Specify the color of the button.', 'mpcth')
		));
		vc_add_param('vc_button', array(
			'type' => 'dropdown',
			'heading' => __('Button icon', 'mpcth'),
			'param_name' => 'custom_icon',
			'value' => mpc_list_icons(),
			'description' => __('Select the icon of the button.', 'mpcth')
		));
		vc_add_param('vc_button', array(
			'type' => 'dropdown',
			'heading' => __('Icon position', 'mpcth'),
			'param_name' => 'custom_pos',
			'value' => array(__('Top', 'mpcth') => 'top', __('Right', 'mpcth') => 'right', __('Bottom', 'mpcth') => 'bottom', __('Left', 'mpcth') => 'left'),
			'description' => __('Specify the position of the icon.', 'mpcth')
		));

		vc_add_param('vc_cta_button', array(
			'type' => 'colorpicker',
			'heading' => __('Button color', 'mpcth'),
			'param_name' => 'custom_color',
			'value' => $theme_base_color,
			'description' => __('Specify the color of the button.', 'mpcth')
		));
		vc_add_param('vc_cta_button', array(
			'type' => 'dropdown',
			'heading' => __('Button icon', 'mpcth'),
			'param_name' => 'custom_icon',
			'value' => mpc_list_icons(),
			'description' => __('Select the icon of the button.', 'mpcth')
		));
		vc_add_param('vc_cta_button', array(
			'type' => 'dropdown',
			'heading' => __('Icon position', 'mpcth'),
			'param_name' => 'custom_pos',
			'value' => array(__('Top', 'mpcth') => 'top', __('Right', 'mpcth') => 'right', __('Bottom', 'mpcth') => 'bottom', __('Left', 'mpcth') => 'left'),
			'description' => __('Specify the position of the icon.', 'mpcth')
		));
	}

/* ---------------------------------------------------------------- */
/* Add MPC shortcodes to Visual Composer
/* ---------------------------------------------------------------- */
	$is_woocommerce = false;
	if (function_exists('is_woocommerce'))
		$is_woocommerce = true;

	if(function_exists('vc_map')) {
		vc_map( array(
			'name' => __('Portfolio Meta', 'mpcth'),
			'base' => 'mpc_vc_portfolio_meta',
			'class' => '',
			'icon' => 'icon-mpc',
			'controls' => 'size_delete',
			'category' => __('MPC', 'mpcth'),
			'show_settings_on_create' => false
		) );

		vc_map( array(
			'name' => __('Post Thumbnail', 'mpcth'),
			'base' => 'mpc_vc_post_thumbnail',
			'class' => '',
			'icon' => 'icon-mpc',
			'controls' => 'size_delete',
			'category' => __('MPC', 'mpcth'),
			'show_settings_on_create' => false
		) );

		vc_map( array(
			'name' => __('Deco Header', 'mpcth'),
			'base' => 'mpc_vc_deco_header',
			'class' => '',
			'icon' => 'icon-mpc',
			'category' => __('MPC', 'mpcth'),
			'params' => array(
				array(
					'type' => 'dropdown',
					'heading' => __('Type', 'mpcth'),
					'param_name' => 'type',
					'value' => array('H1' => 'h1', 'H2' => 'h2', 'H3' => 'h3', 'H4' => 'h4', 'H5' => 'h5', 'H6' => 'h6'),
					'admin_label' => true,
					'description' => __('Select header type.', 'mpcth')
				),
				array(
					'type' => 'textfield',
					'heading' => __('Text', 'mpcth'),
					'param_name' => 'text',
					'value' => '',
					'admin_label' => true,
					'description' => __('Specify header text.', 'mpcth')
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Simple Arrows', 'mpcth'),
					'param_name' => 'simple_arrows',
					'value' => array(__('Enable simple arrows', 'mpcth') => true),
					'description' => __('Enable simple arrows for this slider.', 'mpcth')
				)
			)
		) );

		vc_map( array(
			'name' => __('Counter', 'mpcth'),
			'base' => 'mpc_vc_counter',
			'class' => '',
			'icon' => 'icon-mpc',
			'category' => __('MPC', 'mpcth'),
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => __('Begin Number', 'mpcth'),
					'param_name' => 'begin',
					'value' => '1',
					'admin_label' => true,
					'description' => __('Specify beginning number.', 'mpcth')
				),
				array(
					'type' => 'textfield',
					'heading' => __('End Number', 'mpcth'),
					'param_name' => 'end',
					'value' => '100',
					'admin_label' => true,
					'description' => __('Specify ending number.', 'mpcth')
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Color', 'mpcth'),
					'param_name' => 'color',
					'value' => $theme_base_color,
					'admin_label' => true,
					'description' => __('Specify counter color.', 'mpcth')
				),
				array(
					'type' => 'textfield',
					'heading' => __('Font Size', 'mpcth'),
					'param_name' => 'size',
					'value' => '1em',
					'admin_label' => true,
					'description' => __('Specify custom font size.', 'mpcth')
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Alignment', 'mpcth'),
					'param_name' => 'align',
					'value' => array(__('Center', 'mpcth') => 'center', __('Left', 'mpcth') => 'left', __('Right', 'mpcth') => 'right'),
					'admin_label' => true,
					'description' => __('Select counter alignment.', 'mpcth')
				),
			)
		) );


		vc_map( array(
			'name' => __('Code', 'mpcth'),
			'base' => 'mpc_vc_code',
			'class' => '',
			'icon' => 'icon-mpc',
			'category' => __('MPC', 'mpcth'),
			'params' => array(
				array(
					'type' => 'textarea_raw_html',
					'heading' => __('Source Code Text', 'mpcth'),
					'param_name' => 'text',
					'value' => '',
					'description' => __('Specify source code text.', 'mpcth')
				)
			)
		) );

		vc_map( array(
			'name' => __('Quote', 'mpcth'),
			'base' => 'mpc_vc_quote',
			'class' => '',
			'icon' => 'icon-mpc',
			'category' => __('MPC', 'mpcth'),
			'params' => array(
				array(
					'type' => 'textarea',
					'heading' => __('Quote Text', 'mpcth'),
					'param_name' => 'quote',
					'value' => '',
					'description' => __('Specify quote text.', 'mpcth')
				),
				array(
					'type' => 'textfield',
					'heading' => __('Quote Author', 'mpcth'),
					'param_name' => 'author',
					'value' => '',
					'description' => __('Specify quote author.', 'mpcth')
				)
			)
		) );

		vc_map( array(
			'name' => __('Social List', 'mpcth'),
			'base' => 'mpc_vc_social_list',
			'class' => '',
			'icon' => 'icon-mpc',
			'category' => __('MPC', 'mpcth'),
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => __('Title', 'mpcth'),
					'param_name' => 'title',
					'value' => __('Social', 'mpcth'),
					'admin_label' => true,
					'description' => __('Specify the social list title.', 'mpcth')
				),
			)
		) );

		vc_map( array(
			'name' => __('Share List', 'mpcth'),
			'base' => 'mpc_vc_share_list',
			'class' => '',
			'icon' => 'icon-mpc',
			'category' => __('MPC', 'mpcth'),
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => __('Title', 'mpcth'),
					'param_name' => 'title',
					'value' => __('Share', 'mpcth'),
					'admin_label' => true,
					'description' => __('Specify the share list title.', 'mpcth')
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Facebook', 'mpcth'),
					'param_name' => 'facebook',
					'value' => array(__('Display Facebook button', 'mpcth') => true),
					'description' => __('Enable Facebook share button.', 'mpcth')
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Twitter', 'mpcth'),
					'param_name' => 'twitter',
					'value' => array(__('Display Twitter button', 'mpcth') => true),
					'description' => __('Enable Twitter share button.', 'mpcth')
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Google+', 'mpcth'),
					'param_name' => 'google_plus',
					'value' => array(__('Display Google+ button', 'mpcth') => true),
					'description' => __('Enable Google+ share button.', 'mpcth')
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Pinterest', 'mpcth'),
					'param_name' => 'pinterest',
					'value' => array(__('Display Pinterest button', 'mpcth') => true),
					'description' => __('Enable Pinterest share button.', 'mpcth')
				),
			)
		) );

		/* Icon shortcode | START */
		function icon_settings($settings, $value) {
			$dependency = vc_generate_dependencies_attributes($settings);
			$icons = mpc_simple_icons();

			$return =
				'<div class="mpc-vc-icons">' .
					'<input name="' . $settings['param_name'] . '" class="wpb_vc_param_value wpb-textinput ' . $settings['param_name'] . ' ' . $settings['type'] . '_field mpc-vc-icons-icon" type="hidden" value="' . $value . '" ' . $dependency . '/>' .
					'<div class="mpc-vc-icon-wrap">' .
						'<a class="mpc-vc-icon" href="#">' .
							'<i class="fa fa-fw fa-' . $value . '"></i>' .
						'</a>' .
					'</div>' .
					'<div class="mpc-vc-icons-wrap">';
						foreach ($icons as $icon) {
							$return .= '<i class="fa fa-fw fa-' . $icon . '"></i>';
						}
				$return .=
					'</div>' .
				'</div>';

			return $return;
		}

		if(function_exists('add_shortcode_param'))
			add_shortcode_param('icon', 'icon_settings', MPC_EXTENSIONS_URL . '/js/mpc-vc-icon.js');

		if(function_exists('vc_map')) {
			vc_map( array(
				'name' => __('Icon', 'mpcth'),
				'base' => 'mpc_vc_icon',
				'class' => '',
				'icon' => 'icon-mpc',
				'category' => __('MPC', 'mpcth'),
				'params' => array(
					array(
						'type' => 'icon',
						'heading' => __('Icon', 'mpcth'),
						'param_name' => 'icon',
						'value' => '',
						'admin_label' => true,
						'description' => __('Select your icon.', 'mpcth')
					),
					array(
						'type' => 'colorpicker',
						'heading' => __('Color', 'mpcth'),
						'param_name' => 'color',
						'value' => $theme_base_color,
						'admin_label' => true,
						'description' => __('Select icon color.', 'mpcth')
					),
					array(
						'type' => 'textfield',
						'heading' => __('Size', 'mpcth'),
						'param_name' => 'size',
						'value' => '1em',
						'admin_label' => true,
						'description' => __('Specify custom icon size.', 'mpcth')
					),
					array(
						'type' => 'dropdown',
						'heading' => __('Alignment', 'mpcth'),
						'param_name' => 'align',
						'value' => array(__('Center', 'mpcth') => 'center', __('Left', 'mpcth') => 'left', __('Right', 'mpcth') => 'right'),
						'admin_label' => true,
						'description' => __('Select icon alignment.', 'mpcth')
					),
				)
			) );
		}
		/* Icon shortcode | END */

		vc_map( array(
			'name' => __('Icon Column', 'mpcth'),
			'base' => 'mpc_vc_icon_column',
			'class' => '',
			'icon' => 'icon-mpc',
			'category' => __('MPC', 'mpcth'),
			'params' => array(
				array(
					'type' => 'dropdown',
					'heading' => __('Icon', 'mpcth'),
					'param_name' => 'icon',
					'value' => mpc_list_icons(),
					'admin_label' => true,
					'description' => __('Select icon.', 'mpcth')
				),
				array(
					'type' => 'colorpicker',
					'heading' => __('Icon Color', 'mpcth'),
					'param_name' => 'color',
					'value' => $theme_base_color,
					'admin_label' => true,
					'description' => __('Specify icon color.', 'mpcth')
				),
				array(
					'type' => 'textfield',
					'heading' => __('Title', 'mpcth'),
					'param_name' => 'title',
					'value' => '',
					'admin_label' => true,
					'description' => __('Specify column title.', 'mpcth')
				),
				array(
					'type' => 'textarea',
					'heading' => __('Text', 'mpcth'),
					'param_name' => 'text',
					'value' => '',
					'admin_label' => true,
					'description' => __('Specify column text.', 'mpcth')
				),
				array(
					'type' => 'textfield',
					'heading' => __('Link', 'mpcth'),
					'param_name' => 'link',
					'value' => '',
					'admin_label' => true,
					'description' => __('Specify column URL.', 'mpcth')
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Simple version', 'mpcth'),
					'param_name' => 'simple_version',
					'value' => array(__('Display icon column in simple version (side icon without box)', 'mpcth') => true),
					'description' => __('Enable simple version.', 'mpcth')
				),
			)
		) );

		/* Icon list shortcode | START */
		function icon_list_settings($settings, $value) {
			$dependency = vc_generate_dependencies_attributes($settings);
			$icons = mpc_simple_icons();

			$return =
				'<div class="mpc-vc-icons-list">' .
					'<input name="' . $settings['param_name'] . '" class="wpb_vc_param_value wpb-textinput ' . $settings['param_name'] . ' ' . $settings['type'] . '_field mpc-vc-icons-code" type="hidden" value="' . $value . '" ' . $dependency . '/>' .
					'<div class="mpc-vc-list-items-template">' .
						'<div class="mpc-vc-list-single-item">' .
							'<a class="mpc-vc-item-icon" href="#">' .
								'<i class="mpcth-sc-icon-list"></i>' .
							'</a>' .
							'<div class="mpc-vc-item-text-wrap"><input class="wpb_vc_param_value wpb-textinput mpc-vc-item-text" type="text" /></div>' .
							'<a class="mpc-vc-item-up" href="#"><i class="fa fa-fw fa-angle-up"></i></a>' .
							'<a class="mpc-vc-item-down" href="#"><i class="fa fa-fw fa-angle-down"></i></a>' .
							'<a class="mpc-vc-item-duplicate" href="#"><i class="fa fa-fw fa-files-o"></i></a>' .
							'<a class="mpc-vc-item-delete" href="#"><i class="fa fa-fw fa-trash-o"></i></a>' .
						'</div>' .
					'</div>' .
					'<div class="mpc-vc-list-items-wrap">' .
						'<div class="mpc-vc-list-single-item">' .
							'<a class="mpc-vc-item-icon" href="#">' .
								'<i class="mpcth-sc-icon-list"></i>' .
							'</a>' .
							'<div class="mpc-vc-item-text-wrap"><input class="wpb_vc_param_value wpb-textinput mpc-vc-item-text" type="text" /></div>' .
							'<a class="mpc-vc-item-up" href="#"><i class="fa fa-fw fa-angle-up"></i></a>' .
							'<a class="mpc-vc-item-down" href="#"><i class="fa fa-fw fa-angle-down"></i></a>' .
							'<a class="mpc-vc-item-duplicate" href="#"><i class="fa fa-fw fa-files-o"></i></a>' .
							'<a class="mpc-vc-item-delete" href="#"><i class="fa fa-fw fa-trash-o"></i></a>' .
						'</div>' .
					'</div>' .
					'<div class="mpc-vc-list-items-icons-wrap">';
						foreach ($icons as $icon) {
							$return .= '<i class="fa fa-fw fa-' . $icon . '"></i>';
						}
				$return .=
					'</div>' .
					'<a class="mpc-vc-item-add" href="#"><i class="fa fa-fw fa-plus"></i></a>' .
				'</div>';

			return $return;
		}

		if(function_exists('add_shortcode_param'))
			add_shortcode_param('icon_list', 'icon_list_settings', MPC_EXTENSIONS_URL . '/js/mpc-vc-icon-list.js');

		if(function_exists('vc_map')) {
			vc_map( array(
				'name' => __('Icon List', 'mpcth'),
				'base' => 'mpc_vc_icon_list',
				'class' => '',
				'icon' => 'icon-mpc',
				'category' => __('MPC', 'mpcth'),
				'params' => array(
					array(
						'type' => 'colorpicker',
						'heading' => __('Icon Color', 'mpcth'),
						'param_name' => 'icon_color',
						'value' => $theme_base_color,
						'admin_label' => true,
						'description' => __('Select icons color.', 'mpcth')
					),
					array(
						'type' => 'colorpicker',
						'heading' => __('Text Color', 'mpcth'),
						'param_name' => 'text_color',
						'value' => '#666666',
						'admin_label' => true,
						'description' => __('Select texts color.', 'mpcth')
					),
					array(
						'type' => 'icon_list',
						'heading' => __('List items', 'mpcth'),
						'param_name' => 'icon_list',
						'value' => '',
						'description' => __('Create your icon list.', 'mpcth')
					)
				)
			) );
		}
		/* Icon list shortcode | END */

		/* Testimonials shortcode | START */
		function testimonials_settings($settings, $value) {
			$dependency = vc_generate_dependencies_attributes($settings);

			$return =
				'<div class="mpc-vc-testimonials">' .
					'<div class="mpc-vc-testimonials-template">' .
						'<div class="mpc-vc-single-testimonial">' .
							'<div class="mpc-vc-testimonial-author-wrap"><input class="wpb_vc_param_value wpb-textinput mpc-vc-testimonial-author" type="text" /></div>' .
							'<div class="mpc-vc-testimonial-text-wrap"><textarea class="wpb_vc_param_value wpb-textinput mpc-vc-testimonial-text" rows="3"></textarea></div>' .
							'<a class="mpc-vc-testimonial-up" href="#"><i class="fa fa-fw fa-angle-up"></i></a>' .
							'<a class="mpc-vc-testimonial-down" href="#"><i class="fa fa-fw fa-angle-down"></i></a>' .
							'<a class="mpc-vc-testimonial-duplicate" href="#"><i class="fa fa-fw fa-files-o"></i></a>' .
							'<a class="mpc-vc-testimonial-delete" href="#"><i class="fa fa-fw fa-trash-o"></i></a>' .
						'</div>' .
					'</div>' .
					'<div class="mpc-vc-testimonials-wrap">' .
						'<div class="mpc-vc-single-testimonial">' .
							'<div class="mpc-vc-testimonial-author-wrap"><input class="wpb_vc_param_value wpb-textinput mpc-vc-testimonial-author" type="text" /></div>' .
							'<div class="mpc-vc-testimonial-text-wrap"><textarea class="wpb_vc_param_value wpb-textinput mpc-vc-testimonial-text"></textarea></div>' .
							'<a class="mpc-vc-testimonial-up" href="#"><i class="fa fa-fw fa-angle-up"></i></a>' .
							'<a class="mpc-vc-testimonial-down" href="#"><i class="fa fa-fw fa-angle-down"></i></a>' .
							'<a class="mpc-vc-testimonial-duplicate" href="#"><i class="fa fa-fw fa-files-o"></i></a>' .
							'<a class="mpc-vc-testimonial-delete" href="#"><i class="fa fa-fw fa-trash-o"></i></a>' .
						'</div>' .
					'</div>' .
					'<a class="mpc-vc-testimonial-add" href="#"><i class="fa fa-fw fa-plus"></i></a>' .
				'</div>';

			return $return;
		}

		if(function_exists('add_shortcode_param'))
			add_shortcode_param('testimonials', 'testimonials_settings', MPC_EXTENSIONS_URL . '/js/mpc-vc-testimonials.js');

		if(function_exists('vc_map')) {
			vc_map( array(
				'name' => __('Testimonials Slider', 'mpcth'),
				'base' => 'mpc_vc_testimonials_slider',
				'class' => 'chuj',
				'icon' => 'icon-mpc',
				'category' => __('MPC', 'mpcth'),
				'params' => array(
					array(
						'type' => 'testimonials',
						'heading' => __('Testimonials Items', 'mpcth'),
						'param_name' => 'testimonials',
						'value' => '',
						'description' => __('Create your testimonials slider.', 'mpcth')
					),
					array(
						'type' => 'textarea',
						'param_name' => 'content',
						'value' => ''
					),
					array(
						'type' => 'checkbox',
						'heading' => __('Simple Arrows', 'mpcth'),
						'param_name' => 'simple_arrows',
						'value' => array(__('Enable simple arrows', 'mpcth') => true),
						'description' => __('Enable simple arrows for this slider.', 'mpcth')
					)
				)
			) );
		}
		/* Testimonials shortcode | END */

		if ($is_woocommerce) {
			vc_map( array(
				'name' => __('Products Slider', 'mpcth'),
				'base' => 'mpc_vc_products_slider',
				'class' => '',
				'icon' => 'icon-mpc',
				'category' => __('MPC', 'mpcth'),
				'params' => array(
					array(
						'type' => 'dropdown',
						'heading' => __('Type', 'mpcth'),
						'param_name' => 'type',
						'value' => array(__('Recent', 'mpcth') => 'recent', __('Best sellers', 'mpcth') => 'sellers', __('Top rated', 'mpcth') => 'rated', __('Related', 'mpcth') => 'related',__('On Sale', 'mpcth') => 'sale', __('Random', 'mpcth') => 'random'),
						'admin_label' => true,
						'description' => __('Select slider type.', 'mpcth')
					),
					array(
						'type' => 'textfield',
						'heading' => __('Number', 'mpcth'),
						'param_name' => 'number',
						'value' => '6',
						'admin_label' => true,
						'description' => __('Specify how many products you want to display in the slider.', 'mpcth')
					),
					array(
						'type' => 'dropdown',
						'heading' => __('Category', 'mpcth'),
						'param_name' => 'category',
						'value' => mpcth_vc_get_products_categories(),
						'admin_label' => true,
						'description' => __('Filter products to selected category.', 'mpcth')
					),
					array(
						'type' => 'dropdown',
						'heading' => __('Tag', 'mpcth'),
						'param_name' => 'tag',
						'value' => mpcth_vc_get_products_tags(),
						'admin_label' => true,
						'description' => __('Filter products to selected tag.', 'mpcth')
					),
					array(
						'type' => 'checkbox',
						'heading' => __('Simple Arrows', 'mpcth'),
						'param_name' => 'simple_arrows',
						'value' => array(__('Enable simple arrows', 'mpcth') => true),
						'description' => __('Enable simple arrows for this slider.', 'mpcth')
					)
				)
			) );

			vc_map( array(
				'name' => __('Products Categories Slider', 'mpcth'),
				'base' => 'mpc_vc_products_categories_slider',
				'class' => '',
				'icon' => 'icon-mpc',
				'category' => __('MPC', 'mpcth'),
				'params' => array(
					array(
						'type' => 'exploded_textarea',
						'heading' => __('Filter', 'mpcth'),
						'param_name' => 'filter',
						'value' => '',
						'admin_label' => true,
						'description' => __('Write the categories slugs you want to display (each slug in new line). Leave empty to display all.', 'mpcth')
					),
					array(
						'type' => 'checkbox',
						'heading' => __('Simple Arrows', 'mpcth'),
						'param_name' => 'simple_arrows',
						'value' => array(__('Enable simple arrows', 'mpcth') => true),
						'description' => __('Enable simple arrows for this slider.', 'mpcth')
					)
				)
			) );
		}

		vc_map( array(
			'name' => __('Posts Slider', 'mpcth'),
			'base' => 'mpc_vc_blog_posts_slider',
			'class' => '',
			'icon' => 'icon-mpc',
			'category' => __('MPC', 'mpcth'),
			'params' => array(
				array(
					'type' => 'dropdown',
					'heading' => __('Type', 'mpcth'),
					'param_name' => 'type',
					'value' => array(__('Recent', 'mpcth') => 'recent', __('Related', 'mpcth') => 'related', __('Random', 'mpcth') => 'random'),
					'admin_label' => true,
					'description' => __('Select slider type.', 'mpcth')
				),
				array(
					'type' => 'textfield',
					'heading' => __('Number', 'mpcth'),
					'param_name' => 'number',
					'value' => '6',
					'admin_label' => true,
					'description' => __('Specify how many posts you want to display in the slider.', 'mpcth')
				),
				array(
					'type' => 'textfield',
					'heading' => __('Rows', 'mpcth'),
					'param_name' => 'rows',
					'value' => '2',
					'admin_label' => true,
					'description' => __('Specify how many posts rows you want to display in the slider.', 'mpcth')
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Category', 'mpcth'),
					'param_name' => 'category',
					'value' => mpcth_vc_get_blog_posts_categories(),
					'admin_label' => true,
					'description' => __('Filter posts to selected category.', 'mpcth')
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Tag', 'mpcth'),
					'param_name' => 'tag',
					'value' => mpcth_vc_get_blog_posts_tags(),
					'admin_label' => true,
					'description' => __('Filter posts to selected tag.', 'mpcth')
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Simple Arrows', 'mpcth'),
					'param_name' => 'simple_arrows',
					'value' => array(__('Enable simple arrows', 'mpcth') => true),
					'description' => __('Enable simple arrows for this slider.', 'mpcth')
				)
			)
		) );

		vc_map( array(
			'name' => __('Portfolio Slider', 'mpcth'),
			'base' => 'mpc_vc_portfolio_posts_slider',
			'class' => '',
			'icon' => 'icon-mpc',
			'category' => __('MPC', 'mpcth'),
			'params' => array(
				array(
					'type' => 'dropdown',
					'heading' => __('Type', 'mpcth'),
					'param_name' => 'type',
					'value' => array(__('Recent', 'mpcth') => 'recent', __('Related', 'mpcth') => 'related', __('Random', 'mpcth') => 'random'),
					'admin_label' => true,
					'description' => __('Select slider type.', 'mpcth')
				),
				array(
					'type' => 'textfield',
					'heading' => __('Number', 'mpcth'),
					'param_name' => 'number',
					'value' => '6',
					'admin_label' => true,
					'description' => __('Specify how many posts you want to display in the slider.', 'mpcth')
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Category', 'mpcth'),
					'param_name' => 'category',
					'value' => mpcth_vc_get_portfolio_posts_categories(),
					'admin_label' => true,
					'description' => __('Filter posts to selected category.', 'mpcth')
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Tag', 'mpcth'),
					'param_name' => 'tag',
					'value' => mpcth_vc_get_portfolio_posts_tags(),
					'admin_label' => true,
					'description' => __('Filter posts to selected tag.', 'mpcth')
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Simple Arrows', 'mpcth'),
					'param_name' => 'simple_arrows',
					'value' => array(__('Enable simple arrows', 'mpcth') => true),
					'description' => __('Enable simple arrows for this slider.', 'mpcth')
				)
			)
		) );

		vc_map( array(
			'name' => __('Images Slider', 'mpcth'),
			'base' => 'mpc_vc_images_slider',
			'class' => '',
			'icon' => 'icon-mpc',
			'category' => __('MPC', 'mpcth'),
			'params' => array(
				array(
					'type' => 'attach_images',
					'heading' => __('Images', 'mpcth'),
					'param_name' => 'images',
					'value' => '',
					'admin_label' => true,
					'description' => __('Select slider images.', 'mpcth')
				),
				array(
					'type' => 'exploded_textarea',
					'heading' => __('Images URLs', 'mpcth'),
					'param_name' => 'links',
					'value' => '',
					'admin_label' => false,
					'description' => __('Specify the images URLs (each URL in new line).', 'mpcth')
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Brands', 'mpcth'),
					'param_name' => 'brands',
					'value' => array(__('Display as brands slider.', 'mpcth') => true),
					'description' => __('Display as brands slider.', 'mpcth')
				),
				array(
					'type' => 'checkbox',
					'heading' => __('New Tab', 'mpcth'),
					'param_name' => 'external',
					'value' => array(__('Open in new tab.', 'mpcth') => true),
					'description' => __('Open in new tab.', 'mpcth')
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Simple Arrows', 'mpcth'),
					'param_name' => 'simple_arrows',
					'value' => array(__('Enable simple arrows', 'mpcth') => true),
					'description' => __('Enable simple arrows for this slider.', 'mpcth')
				)
			)
		) );

		vc_map( array(
			'name' => __('Lookbooks Slider', 'mpcth'),
			'base' => 'mpc_vc_lookbooks_slider',
			'class' => '',
			'icon' => 'icon-mpc',
			// 'controls' => 'size_delete',
			'category' => __('MPC', 'mpcth'),
			'show_settings_on_create' => false,
			'params' => array(
				array(
					'type' => 'checkbox',
					'heading' => __('Simple Arrows', 'mpcth'),
					'param_name' => 'simple_arrows',
					'value' => array(__('Enable simple arrows', 'mpcth') => true),
					'description' => __('Enable simple arrows for this slider.', 'mpcth')
				)
			)
		) );

		vc_map( array(
			'name' => __('Grid Image', 'mpcth'),
			'base' => 'mpc_vc_grid_image',
			'class' => '',
			'icon' => 'icon-mpc',
			'category' => __('MPC', 'mpcth'),
			'params' => array(
				array(
					'type' => 'attach_image',
					'heading' => __('Image', 'mpcth'),
					'param_name' => 'image',
					'value' => '',
					'admin_label' => true,
					'description' => __('Select image from media library.', 'mpcth')
				),
				array(
					'type' => 'textfield',
					'heading' => __('Title', 'mpcth'),
					'param_name' => 'title',
					'admin_label' => true,
					'description' => __('Specify the title for image.', 'mpcth')
				),
				array(
					'type' => 'textfield',
					'heading' => __('Sub title', 'mpcth'),
					'param_name' => 'sub_title',
					'admin_label' => true,
					'description' => __('Specify the sub title for image.', 'mpcth')
				),
				array(
					'type' => 'textfield',
					'heading' => __('Target URL', 'mpcth'),
					'param_name' => 'url',
					'description' => __('Specify the target URL for image.', 'mpcth')
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Double Column', 'mpcth'),
					'param_name' => 'double_column',
					'value' => array(__('Enable double column', 'mpcth') => true),
					'admin_label' => true,
					'description' => __('Enable double column display for this image.', 'mpcth')
				)
			)
		) );

		vc_map( array(
			'name' => __('Grid', 'mpcth'),
			'base' => 'mpc_vc_grid',
			'class' => '',
			'icon' => 'icon-mpc',
			'category' => __('MPC', 'mpcth'),
			'params' => array(
				array(
					'type' => 'dropdown',
					'heading' => __('Grid', 'mpcth'),
					'param_name' => 'id',
					'value' => list_grids(),
					'admin_label' => true,
					'description' => __('Select the grid you want to display.', 'mpcth')
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Add spaces', 'mpcth'),
					'param_name' => 'spaces',
					'value' => array(__('Enable add spaces', 'mpcth') => true),
					'admin_label' => true,
					'description' => __('Enable spaces between grid images.', 'mpcth')
				)
			)
		) );
	}
}

/* ---------------------------------------------------------------- */
/* Helpers
/* ---------------------------------------------------------------- */
function list_grids($reverse = false) {
	$query_args = array(
		'posts_per_page' => -1,
		'post_status' 	 => 'publish',
		'post_type' 	 => 'mpc_grid',
		'no_found_rows'  => 1,
	);
	$custom_query = new WP_Query($query_args);

	$grids = array();

	if ($custom_query->have_posts()) {
		while ($custom_query->have_posts()) {
			$custom_query->the_post();

			if ($reverse)
				$grids[get_the_ID()] = get_the_title();
			else
				$grids[get_the_title()] = get_the_ID();
		}
	}

	return $grids;
}

function mpc_vc_random_ID($length = 5) {
	return substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $length);
}

function mpc_simple_icons() {
	return array('adjust','adn','align-center','align-justify','align-left','align-right','ambulance','anchor','android','angle-double-down','angle-double-left','angle-double-right','angle-double-up','angle-down','angle-left','angle-right','angle-up','apple','archive','arrow-circle-down','arrow-circle-left','arrow-circle-o-down','arrow-circle-o-left','arrow-circle-o-right','arrow-circle-o-up','arrow-circle-right','arrow-circle-up','arrow-down','arrow-left','arrow-right','arrow-up','arrows','arrows-alt','arrows-h','arrows-v','asterisk','automobile','backward','ban','bank','bar-chart-o','barcode','bars','beer','behance','behance-square','bell','bell-o','bitbucket','bitbucket-square','bitcoin','bold','bolt','bomb','book','bookmark','bookmark-o','briefcase','btc','bug','building','building-o','bullhorn','bullseye','cab','calendar','calendar-o','camera','camera-retro','car','caret-down','caret-left','caret-right','caret-square-o-down','caret-square-o-left','caret-square-o-right','caret-square-o-up','caret-up','certificate','chain','chain-broken','check','check-circle','check-circle-o','check-square','check-square-o','chevron-circle-down','chevron-circle-left','chevron-circle-right','chevron-circle-up','chevron-down','chevron-left','chevron-right','chevron-up','child','circle','circle-o','circle-o-notch','circle-thin','clipboard','clock-o','cloud','cloud-download','cloud-upload','cny','code','code-fork','codepen','coffee','cog','cogs','columns','comment','comment-o','comments','comments-o','compass','compress','copy','credit-card','crop','crosshairs','css3','cube','cubes','cut','cutlery','dashboard','database','dedent','delicious','desktop','deviantart','digg','dollar','dot-circle-o','download','dribbble','dropbox','drupal','edit','eject','ellipsis-h','ellipsis-v','empire','envelope','envelope-o','envelope-square','eraser','eur','euro','exchange','exclamation','exclamation-circle','exclamation-triangle','expand','external-link','external-link-square','eye','eye-slash','facebook','facebook-square','fast-backward','fast-forward','fax','female','fighter-jet','file','file-archive-o','file-audio-o','file-code-o','file-excel-o','file-image-o','file-movie-o','file-o','file-pdf-o','file-photo-o','file-picture-o','file-powerpoint-o','file-sound-o','file-text','file-text-o','file-video-o','file-word-o','file-zip-o','files-o','film','filter','fire','fire-extinguisher','flag','flag-checkered','flag-o','flash','flask','flickr','floppy-o','folder','folder-o','folder-open','folder-open-o','font','forward','foursquare','frown-o','gamepad','gavel','gbp','ge','gear','gears','gift','git','git-square','github','github-alt','github-square','gittip','glass','globe','google','google-plus','google-plus-square','graduation-cap','group','h-square','hacker-news','hand-o-down','hand-o-left','hand-o-right','hand-o-up','hdd-o','header','headphones','heart','heart-o','history','home','hospital-o','html5','image','inbox','indent','info','info-circle','inr','instagram','institution','italic','joomla','jpy','jsfiddle','key','keyboard-o','krw','language','laptop','leaf','legal','lemon-o','level-down','level-up','life-bouy','life-ring','life-saver','lightbulb-o','link','linkedin','linkedin-square','linux','list','list-alt','list-ol','list-ul','location-arrow','lock','long-arrow-down','long-arrow-left','long-arrow-right','long-arrow-up','magic','magnet','mail-forward','mail-reply','mail-reply-all','male','map-marker','maxcdn','medkit','meh-o','microphone','microphone-slash','minus','minus-circle','minus-square','minus-square-o','mobile','mobile-phone','money','moon-o','mortar-board','music','navicon','openid','outdent','pagelines','paper-plane','paper-plane-o','paperclip','paragraph','paste','pause','paw','pencil','pencil-square','pencil-square-o','phone','phone-square','photo','picture-o','pied-piper','pied-piper-alt','pied-piper-square','pinterest','pinterest-square','plane','play','play-circle','play-circle-o','plus','plus-circle','plus-square','plus-square-o','power-off','print','puzzle-piece','qq','qrcode','question','question-circle','quote-left','quote-right','ra','random','rebel','recycle','reddit','reddit-square','refresh','renren','reorder','repeat','reply','reply-all','retweet','rmb','road','rocket','rotate-left','rotate-right','rouble','rss','rss-square','rub','ruble','rupee','save','scissors','search','search-minus','search-plus','send','send-o','share','share-alt','share-alt-square','share-square','share-square-o','shield','shopping-cart','sign-in','sign-out','signal','sitemap','skype','slack','sliders','smile-o','sort','sort-alpha-asc','sort-alpha-desc','sort-amount-asc','sort-amount-desc','sort-asc','sort-desc','sort-down','sort-numeric-asc','sort-numeric-desc','sort-up','soundcloud','space-shuttle','spinner','spoon','spotify','square','square-o','stack-exchange','stack-overflow','star','star-half','star-half-empty','star-half-full','star-half-o','star-o','steam','steam-square','step-backward','step-forward','stethoscope','stop','strikethrough','stumbleupon','stumbleupon-circle','subscript','suitcase','sun-o','superscript','support','table','tablet','tachometer','tag','tags','tasks','taxi','tencent-weibo','terminal','text-height','text-width','th','th-large','th-list','thumb-tack','thumbs-down','thumbs-o-down','thumbs-o-up','thumbs-up','ticket','times','times-circle','times-circle-o','tint','toggle-down','toggle-left','toggle-right','toggle-up','trash-o','tree','trello','trophy','truck','try','tumblr','tumblr-square','turkish-lira','twitter','twitter-square','umbrella','underline','undo','university','unlink','unlock','unlock-alt','unsorted','upload','usd','user','user-md','users','video-camera','vimeo-square','vine','vk','volume-down','volume-off','volume-up','warning','wechat','weibo','weixin','wheelchair','windows','won','wordpress','wrench','xing','xing-square','yahoo','yen','youtube','youtube-play','youtube-square');
}
function mpc_list_icons() {
	return array('None'=>'_none','Adjust'=>'fa-adjust','Adn'=>'fa-adn','Align Center'=>'fa-align-center','Align Justify'=>'fa-align-justify','Align Left'=>'fa-align-left','Align Right'=>'fa-align-right','Ambulance'=>'fa-ambulance','Anchor'=>'fa-anchor','Android'=>'fa-android','Angle Double Down'=>'fa-angle-double-down','Angle Double Left'=>'fa-angle-double-left','Angle Double Right'=>'fa-angle-double-right','Angle Double Up'=>'fa-angle-double-up','Angle Down'=>'fa-angle-down','Angle Left'=>'fa-angle-left','Angle Right'=>'fa-angle-right','Angle Up'=>'fa-angle-up','Apple'=>'fa-apple','Archive'=>'fa-archive','Arrow Circle Down'=>'fa-arrow-circle-down','Arrow Circle Left'=>'fa-arrow-circle-left','Arrow Circle O Down'=>'fa-arrow-circle-o-down','Arrow Circle O Left'=>'fa-arrow-circle-o-left','Arrow Circle O Right'=>'fa-arrow-circle-o-right','Arrow Circle O Up'=>'fa-arrow-circle-o-up','Arrow Circle Right'=>'fa-arrow-circle-right','Arrow Circle Up'=>'fa-arrow-circle-up','Arrow Down'=>'fa-arrow-down','Arrow Left'=>'fa-arrow-left','Arrow Right'=>'fa-arrow-right','Arrow Up'=>'fa-arrow-up','Arrows'=>'fa-arrows','Arrows Alt'=>'fa-arrows-alt','Arrows H'=>'fa-arrows-h','Arrows V'=>'fa-arrows-v','Asterisk'=>'fa-asterisk','Automobile'=>'fa-automobile','Backward'=>'fa-backward','Ban'=>'fa-ban','Bank'=>'fa-bank','Bar Chart O'=>'fa-bar-chart-o','Barcode'=>'fa-barcode','Bars'=>'fa-bars','Beer'=>'fa-beer','Behance'=>'fa-behance','Behance Square'=>'fa-behance-square','Bell'=>'fa-bell','Bell O'=>'fa-bell-o','Bitbucket'=>'fa-bitbucket','Bitbucket Square'=>'fa-bitbucket-square','Bitcoin'=>'fa-bitcoin','Bold'=>'fa-bold','Bolt'=>'fa-bolt','Bomb'=>'fa-bomb','Book'=>'fa-book','Bookmark'=>'fa-bookmark','Bookmark O'=>'fa-bookmark-o','Briefcase'=>'fa-briefcase','Btc'=>'fa-btc','Bug'=>'fa-bug','Building'=>'fa-building','Building O'=>'fa-building-o','Bullhorn'=>'fa-bullhorn','Bullseye'=>'fa-bullseye','Cab'=>'fa-cab','Calendar'=>'fa-calendar','Calendar O'=>'fa-calendar-o','Camera'=>'fa-camera','Camera Retro'=>'fa-camera-retro','Car'=>'fa-car','Caret Down'=>'fa-caret-down','Caret Left'=>'fa-caret-left','Caret Right'=>'fa-caret-right','Caret Square O Down'=>'fa-caret-square-o-down','Caret Square O Left'=>'fa-caret-square-o-left','Caret Square O Right'=>'fa-caret-square-o-right','Caret Square O Up'=>'fa-caret-square-o-up','Caret Up'=>'fa-caret-up','Certificate'=>'fa-certificate','Chain'=>'fa-chain','Chain Broken'=>'fa-chain-broken','Check'=>'fa-check','Check Circle'=>'fa-check-circle','Check Circle O'=>'fa-check-circle-o','Check Square'=>'fa-check-square','Check Square O'=>'fa-check-square-o','Chevron Circle Down'=>'fa-chevron-circle-down','Chevron Circle Left'=>'fa-chevron-circle-left','Chevron Circle Right'=>'fa-chevron-circle-right','Chevron Circle Up'=>'fa-chevron-circle-up','Chevron Down'=>'fa-chevron-down','Chevron Left'=>'fa-chevron-left','Chevron Right'=>'fa-chevron-right','Chevron Up'=>'fa-chevron-up','Child'=>'fa-child','Circle'=>'fa-circle','Circle O'=>'fa-circle-o','Circle O Notch'=>'fa-circle-o-notch','Circle Thin'=>'fa-circle-thin','Clipboard'=>'fa-clipboard','Clock O'=>'fa-clock-o','Cloud'=>'fa-cloud','Cloud Download'=>'fa-cloud-download','Cloud Upload'=>'fa-cloud-upload','Cny'=>'fa-cny','Code'=>'fa-code','Code Fork'=>'fa-code-fork','Codepen'=>'fa-codepen','Coffee'=>'fa-coffee','Cog'=>'fa-cog','Cogs'=>'fa-cogs','Columns'=>'fa-columns','Comment'=>'fa-comment','Comment O'=>'fa-comment-o','Comments'=>'fa-comments','Comments O'=>'fa-comments-o','Compass'=>'fa-compass','Compress'=>'fa-compress','Copy'=>'fa-copy','Credit Card'=>'fa-credit-card','Crop'=>'fa-crop','Crosshairs'=>'fa-crosshairs','Css3'=>'fa-css3','Cube'=>'fa-cube','Cubes'=>'fa-cubes','Cut'=>'fa-cut','Cutlery'=>'fa-cutlery','Dashboard'=>'fa-dashboard','Database'=>'fa-database','Dedent'=>'fa-dedent','Delicious'=>'fa-delicious','Desktop'=>'fa-desktop','Deviantart'=>'fa-deviantart','Digg'=>'fa-digg','Dollar'=>'fa-dollar','Dot Circle O'=>'fa-dot-circle-o','Download'=>'fa-download','Dribbble'=>'fa-dribbble','Dropbox'=>'fa-dropbox','Drupal'=>'fa-drupal','Edit'=>'fa-edit','Eject'=>'fa-eject','Ellipsis H'=>'fa-ellipsis-h','Ellipsis V'=>'fa-ellipsis-v','Empire'=>'fa-empire','Envelope'=>'fa-envelope','Envelope O'=>'fa-envelope-o','Envelope Square'=>'fa-envelope-square','Eraser'=>'fa-eraser','Eur'=>'fa-eur','Euro'=>'fa-euro','Exchange'=>'fa-exchange','Exclamation'=>'fa-exclamation','Exclamation Circle'=>'fa-exclamation-circle','Exclamation Triangle'=>'fa-exclamation-triangle','Expand'=>'fa-expand','External Link'=>'fa-external-link','External Link Square'=>'fa-external-link-square','Eye'=>'fa-eye','Eye Slash'=>'fa-eye-slash','Facebook'=>'fa-facebook','Facebook Square'=>'fa-facebook-square','Fast Backward'=>'fa-fast-backward','Fast Forward'=>'fa-fast-forward','Fax'=>'fa-fax','Female'=>'fa-female','Fighter Jet'=>'fa-fighter-jet','File'=>'fa-file','File Archive O'=>'fa-file-archive-o','File Audio O'=>'fa-file-audio-o','File Code O'=>'fa-file-code-o','File Excel O'=>'fa-file-excel-o','File Image O'=>'fa-file-image-o','File Movie O'=>'fa-file-movie-o','File O'=>'fa-file-o','File Pdf O'=>'fa-file-pdf-o','File Photo O'=>'fa-file-photo-o','File Picture O'=>'fa-file-picture-o','File Powerpoint O'=>'fa-file-powerpoint-o','File Sound O'=>'fa-file-sound-o','File Text'=>'fa-file-text','File Text O'=>'fa-file-text-o','File Video O'=>'fa-file-video-o','File Word O'=>'fa-file-word-o','File Zip O'=>'fa-file-zip-o','Files O'=>'fa-files-o','Film'=>'fa-film','Filter'=>'fa-filter','Fire'=>'fa-fire','Fire Extinguisher'=>'fa-fire-extinguisher','Flag'=>'fa-flag','Flag Checkered'=>'fa-flag-checkered','Flag O'=>'fa-flag-o','Flash'=>'fa-flash','Flask'=>'fa-flask','Flickr'=>'fa-flickr','Floppy O'=>'fa-floppy-o','Folder'=>'fa-folder','Folder O'=>'fa-folder-o','Folder Open'=>'fa-folder-open','Folder Open O'=>'fa-folder-open-o','Font'=>'fa-font','Forward'=>'fa-forward','Foursquare'=>'fa-foursquare','Frown O'=>'fa-frown-o','Gamepad'=>'fa-gamepad','Gavel'=>'fa-gavel','Gbp'=>'fa-gbp','Ge'=>'fa-ge','Gear'=>'fa-gear','Gears'=>'fa-gears','Gift'=>'fa-gift','Git'=>'fa-git','Git Square'=>'fa-git-square','Github'=>'fa-github','Github Alt'=>'fa-github-alt','Github Square'=>'fa-github-square','Gittip'=>'fa-gittip','Glass'=>'fa-glass','Globe'=>'fa-globe','Google'=>'fa-google','Google Plus'=>'fa-google-plus','Google Plus Square'=>'fa-google-plus-square','Graduation Cap'=>'fa-graduation-cap','Group'=>'fa-group','H Square'=>'fa-h-square','Hacker News'=>'fa-hacker-news','Hand O Down'=>'fa-hand-o-down','Hand O Left'=>'fa-hand-o-left','Hand O Right'=>'fa-hand-o-right','Hand O Up'=>'fa-hand-o-up','Hdd O'=>'fa-hdd-o','Header'=>'fa-header','Headphones'=>'fa-headphones','Heart'=>'fa-heart','Heart O'=>'fa-heart-o','History'=>'fa-history','Home'=>'fa-home','Hospital O'=>'fa-hospital-o','Html5'=>'fa-html5','Image'=>'fa-image','Inbox'=>'fa-inbox','Indent'=>'fa-indent','Info'=>'fa-info','Info Circle'=>'fa-info-circle','Inr'=>'fa-inr','Instagram'=>'fa-instagram','Institution'=>'fa-institution','Italic'=>'fa-italic','Joomla'=>'fa-joomla','Jpy'=>'fa-jpy','Jsfiddle'=>'fa-jsfiddle','Key'=>'fa-key','Keyboard O'=>'fa-keyboard-o','Krw'=>'fa-krw','Language'=>'fa-language','Laptop'=>'fa-laptop','Leaf'=>'fa-leaf','Legal'=>'fa-legal','Lemon O'=>'fa-lemon-o','Level Down'=>'fa-level-down','Level Up'=>'fa-level-up','Life Bouy'=>'fa-life-bouy','Life Ring'=>'fa-life-ring','Life Saver'=>'fa-life-saver','Lightbulb O'=>'fa-lightbulb-o','Link'=>'fa-link','Linkedin'=>'fa-linkedin','Linkedin Square'=>'fa-linkedin-square','Linux'=>'fa-linux','List'=>'fa-list','List Alt'=>'fa-list-alt','List Ol'=>'fa-list-ol','List Ul'=>'fa-list-ul','Location Arrow'=>'fa-location-arrow','Lock'=>'fa-lock','Long Arrow Down'=>'fa-long-arrow-down','Long Arrow Left'=>'fa-long-arrow-left','Long Arrow Right'=>'fa-long-arrow-right','Long Arrow Up'=>'fa-long-arrow-up','Magic'=>'fa-magic','Magnet'=>'fa-magnet','Mail Forward'=>'fa-mail-forward','Mail Reply'=>'fa-mail-reply','Mail Reply All'=>'fa-mail-reply-all','Male'=>'fa-male','Map Marker'=>'fa-map-marker','Maxcdn'=>'fa-maxcdn','Medkit'=>'fa-medkit','Meh O'=>'fa-meh-o','Microphone'=>'fa-microphone','Microphone Slash'=>'fa-microphone-slash','Minus'=>'fa-minus','Minus Circle'=>'fa-minus-circle','Minus Square'=>'fa-minus-square','Minus Square O'=>'fa-minus-square-o','Mobile'=>'fa-mobile','Mobile Phone'=>'fa-mobile-phone','Money'=>'fa-money','Moon O'=>'fa-moon-o','Mortar Board'=>'fa-mortar-board','Music'=>'fa-music','Navicon'=>'fa-navicon','Openid'=>'fa-openid','Outdent'=>'fa-outdent','Pagelines'=>'fa-pagelines','Paper Plane'=>'fa-paper-plane','Paper Plane O'=>'fa-paper-plane-o','Paperclip'=>'fa-paperclip','Paragraph'=>'fa-paragraph','Paste'=>'fa-paste','Pause'=>'fa-pause','Paw'=>'fa-paw','Pencil'=>'fa-pencil','Pencil Square'=>'fa-pencil-square','Pencil Square O'=>'fa-pencil-square-o','Phone'=>'fa-phone','Phone Square'=>'fa-phone-square','Photo'=>'fa-photo','Picture O'=>'fa-picture-o','Pied Piper'=>'fa-pied-piper','Pied Piper Alt'=>'fa-pied-piper-alt','Pied Piper Square'=>'fa-pied-piper-square','Pinterest'=>'fa-pinterest','Pinterest Square'=>'fa-pinterest-square','Plane'=>'fa-plane','Play'=>'fa-play','Play Circle'=>'fa-play-circle','Play Circle O'=>'fa-play-circle-o','Plus'=>'fa-plus','Plus Circle'=>'fa-plus-circle','Plus Square'=>'fa-plus-square','Plus Square O'=>'fa-plus-square-o','Power Off'=>'fa-power-off','Print'=>'fa-print','Puzzle Piece'=>'fa-puzzle-piece','Qq'=>'fa-qq','Qrcode'=>'fa-qrcode','Question'=>'fa-question','Question Circle'=>'fa-question-circle','Quote Left'=>'fa-quote-left','Quote Right'=>'fa-quote-right','Ra'=>'fa-ra','Random'=>'fa-random','Rebel'=>'fa-rebel','Recycle'=>'fa-recycle','Reddit'=>'fa-reddit','Reddit Square'=>'fa-reddit-square','Refresh'=>'fa-refresh','Renren'=>'fa-renren','Reorder'=>'fa-reorder','Repeat'=>'fa-repeat','Reply'=>'fa-reply','Reply All'=>'fa-reply-all','Retweet'=>'fa-retweet','Rmb'=>'fa-rmb','Road'=>'fa-road','Rocket'=>'fa-rocket','Rotate Left'=>'fa-rotate-left','Rotate Right'=>'fa-rotate-right','Rouble'=>'fa-rouble','Rss'=>'fa-rss','Rss Square'=>'fa-rss-square','Rub'=>'fa-rub','Ruble'=>'fa-ruble','Rupee'=>'fa-rupee','Save'=>'fa-save','Scissors'=>'fa-scissors','Search'=>'fa-search','Search Minus'=>'fa-search-minus','Search Plus'=>'fa-search-plus','Send'=>'fa-send','Send O'=>'fa-send-o','Share'=>'fa-share','Share Alt'=>'fa-share-alt','Share Alt Square'=>'fa-share-alt-square','Share Square'=>'fa-share-square','Share Square O'=>'fa-share-square-o','Shield'=>'fa-shield','Shopping Cart'=>'fa-shopping-cart','Sign In'=>'fa-sign-in','Sign Out'=>'fa-sign-out','Signal'=>'fa-signal','Sitemap'=>'fa-sitemap','Skype'=>'fa-skype','Slack'=>'fa-slack','Sliders'=>'fa-sliders','Smile O'=>'fa-smile-o','Sort'=>'fa-sort','Sort Alpha Asc'=>'fa-sort-alpha-asc','Sort Alpha Desc'=>'fa-sort-alpha-desc','Sort Amount Asc'=>'fa-sort-amount-asc','Sort Amount Desc'=>'fa-sort-amount-desc','Sort Asc'=>'fa-sort-asc','Sort Desc'=>'fa-sort-desc','Sort Down'=>'fa-sort-down','Sort Numeric Asc'=>'fa-sort-numeric-asc','Sort Numeric Desc'=>'fa-sort-numeric-desc','Sort Up'=>'fa-sort-up','Soundcloud'=>'fa-soundcloud','Space Shuttle'=>'fa-space-shuttle','Spinner'=>'fa-spinner','Spoon'=>'fa-spoon','Spotify'=>'fa-spotify','Square'=>'fa-square','Square O'=>'fa-square-o','Stack Exchange'=>'fa-stack-exchange','Stack Overflow'=>'fa-stack-overflow','Star'=>'fa-star','Star Half'=>'fa-star-half','Star Half Empty'=>'fa-star-half-empty','Star Half Full'=>'fa-star-half-full','Star Half O'=>'fa-star-half-o','Star O'=>'fa-star-o','Steam'=>'fa-steam','Steam Square'=>'fa-steam-square','Step Backward'=>'fa-step-backward','Step Forward'=>'fa-step-forward','Stethoscope'=>'fa-stethoscope','Stop'=>'fa-stop','Strikethrough'=>'fa-strikethrough','Stumbleupon'=>'fa-stumbleupon','Stumbleupon Circle'=>'fa-stumbleupon-circle','Subscript'=>'fa-subscript','Suitcase'=>'fa-suitcase','Sun O'=>'fa-sun-o','Superscript'=>'fa-superscript','Support'=>'fa-support','Table'=>'fa-table','Tablet'=>'fa-tablet','Tachometer'=>'fa-tachometer','Tag'=>'fa-tag','Tags'=>'fa-tags','Tasks'=>'fa-tasks','Taxi'=>'fa-taxi','Tencent Weibo'=>'fa-tencent-weibo','Terminal'=>'fa-terminal','Text Height'=>'fa-text-height','Text Width'=>'fa-text-width','Th'=>'fa-th','Th Large'=>'fa-th-large','Th List'=>'fa-th-list','Thumb Tack'=>'fa-thumb-tack','Thumbs Down'=>'fa-thumbs-down','Thumbs O Down'=>'fa-thumbs-o-down','Thumbs O Up'=>'fa-thumbs-o-up','Thumbs Up'=>'fa-thumbs-up','Ticket'=>'fa-ticket','Times'=>'fa-times','Times Circle'=>'fa-times-circle','Times Circle O'=>'fa-times-circle-o','Tint'=>'fa-tint','Toggle Down'=>'fa-toggle-down','Toggle Left'=>'fa-toggle-left','Toggle Right'=>'fa-toggle-right','Toggle Up'=>'fa-toggle-up','Trash O'=>'fa-trash-o','Tree'=>'fa-tree','Trello'=>'fa-trello','Trophy'=>'fa-trophy','Truck'=>'fa-truck','Try'=>'fa-try','Tumblr'=>'fa-tumblr','Tumblr Square'=>'fa-tumblr-square','Turkish Lira'=>'fa-turkish-lira','Twitter'=>'fa-twitter','Twitter Square'=>'fa-twitter-square','Umbrella'=>'fa-umbrella','Underline'=>'fa-underline','Undo'=>'fa-undo','University'=>'fa-university','Unlink'=>'fa-unlink','Unlock'=>'fa-unlock','Unlock Alt'=>'fa-unlock-alt','Unsorted'=>'fa-unsorted','Upload'=>'fa-upload','Usd'=>'fa-usd','User'=>'fa-user','User Md'=>'fa-user-md','Users'=>'fa-users','Video Camera'=>'fa-video-camera','Vimeo Square'=>'fa-vimeo-square','Vine'=>'fa-vine','Vk'=>'fa-vk','Volume Down'=>'fa-volume-down','Volume Off'=>'fa-volume-off','Volume Up'=>'fa-volume-up','Warning'=>'fa-warning','Wechat'=>'fa-wechat','Weibo'=>'fa-weibo','Weixin'=>'fa-weixin','Wheelchair'=>'fa-wheelchair','Windows'=>'fa-windows','Won'=>'fa-won','Wordpress'=>'fa-wordpress','Wrench'=>'fa-wrench','Xing'=>'fa-xing','Xing Square'=>'fa-xing-square','Yahoo'=>'fa-yahoo','Yen'=>'fa-yen','Youtube'=>'fa-youtube','Youtube Play'=>'fa-youtube-play','Youtube Square'=>'fa-youtube-square');
}