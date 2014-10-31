<?php
if(function_exists("register_field_group")) {
	/* Page Header */
	register_field_group(array (
		'id' => 'acf_page-header',
		'title' => 'Page Header',
		'fields' => array (
			array (
				'key' => 'field_52ef41f52a926',
				'label' => 'Header Content',
				'name' => 'mpc_header_content',
				'type' => 'wysiwyg',
				'instructions' => 'This content will be displayed at the top of the page.',
				'default_value' => '',
				'toolbar' => 'full',
				'media_upload' => 'yes',
			),
			array (
				'key' => 'field_53045ff3dc44b',
				'label' => 'Hide Title',
				'name' => 'mpc_hide_title',
				'type' => 'true_false',
				'instructions' => 'Check this if you want to hide page title.',
				'message' => 'Hide Title',
				'default_value' => 0,
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'template-fullwidth.php',
					'order_no' => 0,
					'group_no' => 1,
				),
			),
			array (
				array (
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'template-lookbook.php',
					'order_no' => 0,
					'group_no' => 2,
				),
			),
			array (
				array (
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'template-fullwidth-with-sidebar.php',
					'order_no' => 0,
					'group_no' => 3,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));

	/* Sidebar */
	register_field_group(array (
		'id' => 'acf_sidebar',
		'title' => __('Sidebar', 'mpcth'),
		'fields' => array (
			array (
				'key' => 'field_526129a80e850',
				'label' => __('Custom Sidebar Position', 'mpcth'),
				'name' => 'mpc_custom_sidebar_position',
				'type' => 'true_false',
				'instructions' => __('Check this if you want to specify custom position for this post sidebar.', 'mpcth'),
				'message' => 'Set Custom Position',
				'default_value' => 0,
			),
			array (
				'key' => 'field_52611babe5525',
				'label' => __('Sidebar Position', 'mpcth'),
				'name' => 'mpc_sidebar_position',
				'type' => 'radio',
				'instructions' => __('Select the position of sidebar for this single post.', 'mpcth'),
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_526129a80e850',
							'operator' => '==',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'choices' => array (
					'left' => __('Left', 'mpcth'),
					'none' => __('None', 'mpcth'),
					'right' => __('Right', 'mpcth'),
				),
				'other_choice' => 0,
				'save_other_choice' => 0,
				'default_value' => 'right',
				'layout' => 'horizontal',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'mpc_portfolio',
					'order_no' => 0,
					'group_no' => 1,
				),
			),
			array (
				array (
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'template-portfolio.php',
					'order_no' => 0,
					'group_no' => 2,
				),
			),
			array (
				array (
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'default',
					'order_no' => 0,
					'group_no' => 3,
				),
			),
			array (
				array (
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'template-blog.php',
					'order_no' => 0,
					'group_no' => 4,
				),
			),
			array (
				array (
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'template-fullwidth-with-sidebar.php',
					'order_no' => 0,
					'group_no' => 5,
				),
			),
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'product',
					'order_no' => 0,
					'group_no' => 6,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));

	/* Extended Footer */
	register_field_group(array (
		'id' => 'acf_extended-footer',
		'title' => 'Extended Footer',
		'fields' => array (
			array (
				'key' => 'field_5315b1e623106',
				'label' => 'Hide Extended Footer',
				'name' => 'mpc_hide_extended_footer',
				'type' => 'true_false',
				'instructions' => 'Check this if you want to hide extended footer for this page.',
				'message' => 'Hide Extended Footer',
				'default_value' => 0,
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'page',
					'order_no' => 0,
					'group_no' => 1,
				),
			),
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'product',
					'order_no' => 0,
					'group_no' => 2,
				),
			),
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'mpc_portfolio',
					'order_no' => 0,
					'group_no' => 3,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));

	/* Size Guide */
	register_field_group(array (
		'id' => 'acf_size-guide',
		'title' => 'Size Guide',
		'fields' => array (
			array (
				'key' => 'field_534a6f1c38534',
				'label' => 'Custom Size Guide',
				'name' => 'mpc_enable_custom_size_guide',
				'type' => 'true_false',
				'instructions' => 'Check this if you want to specify a custom "Size Guide" for this product.',
				'message' => 'Enable custom "Size Guide"',
				'default_value' => 0,
			),
			array (
				'key' => 'field_534a6f6a38535',
				'label' => 'Size Guide Image',
				'name' => 'mpc_custom_size_guide',
				'type' => 'image',
				'instructions' => 'Select the "Size Guide" image to display. Leave empty if you want to disable "Size Guide".',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_534a6f1c38534',
							'operator' => '==',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'save_format' => 'url',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'product',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));

	/* Page Settings */
	register_field_group(array (
		'id' => 'acf_page-settings-2',
		'title' => 'Page Settings',
		'fields' => array (
			array (
				'key' => 'field_5308b503e4a78',
				'label' => 'Hide Title',
				'name' => 'mpc_hide_title',
				'type' => 'true_false',
				'instructions' => 'Check this if you want to hide page title.',
				'message' => 'Hide Title',
				'default_value' => 0,
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'default',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));

	/* Lightbox Settings */
	register_field_group(array (
		'id' => 'acf_lightbox-settings',
		'title' => __('Lightbox Settings', 'mpcth'),
		'fields' => array (
			array (
				'key' => 'field_526122a787e6a',
				'label' => __('Enable Lightbox', 'mpcth'),
				'name' => 'mpc_enable_lightbox',
				'type' => 'true_false',
				'instructions' => __('Check this to enable lightbox for current post.', 'mpcth'),
				'message' => __('Enable Lightbox', 'mpcth'),
				'default_value' => 0,
			),
			array (
				'key' => 'field_527b983b7eabb',
				'label' => __('Lightbox Type', 'mpcth'),
				'name' => 'mpc_lightbox_type',
				'type' => 'select',
				'instructions' => __('Select the kind of Lightbox you want to display for the post.', 'mpcth'),
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_526122a787e6a',
							'operator' => '==',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'choices' => array (
					'image' => 'Image',
					'iframe' => 'iFrame',
				),
				'default_value' => 'image',
				'allow_null' => 0,
				'multiple' => 0,
			),
			array (
				'key' => 'field_526122ff87e6b',
				'label' => __('Lightbox Source', 'mpcth'),
				'name' => 'mpc_lightbox_source',
				'type' => 'file',
				'instructions' => __('Select the lightbox source from your Media Library.', 'mpcth'),
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_526122a787e6a',
							'operator' => '==',
							'value' => '1',
						),
						array (
							'field' => 'field_527b983b7eabb',
							'operator' => '==',
							'value' => 'image',
						),
					),
					'allorany' => 'all',
				),
				'save_format' => 'object',
				'library' => 'all',
			),
			array (
				'key' => 'field_5261235f87e6c',
				'label' => __('Lightbox Source URL', 'mpcth'),
				'name' => 'mpc_lightbox_source_url',
				'type' => 'text',
				'instructions' => __('Specify the URL address of your lightbox (Vimeo, Youtube, Google Maps, etc).', 'mpcth'),
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_526122a787e6a',
							'operator' => '==',
							'value' => '1',
						),
						array (
							'field' => 'field_527b983b7eabb',
							'operator' => '==',
							'value' => 'iframe',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => '',
				'placeholder' => __('Source URL', 'mpcth'),
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'mpc_portfolio',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
					'order_no' => 0,
					'group_no' => 1,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));

	/* Portfolio Metadata */
	register_field_group(array (
		'id' => 'acf_portfolio-metadata',
		'title' => __('Portfolio Metadata', 'mpcth'),
		'fields' => array (
			array (
				'key' => 'field_5270f99e95ae3',
				'label' => __('Metadata', 'mpcth'),
				'name' => 'mpc_metadata',
				'type' => 'repeater',
				'sub_fields' => array (
					array (
						'key' => 'field_52711de9d3e37',
						'label' => __('Name', 'mpcth'),
						'name' => 'mpc_description_name',
						'type' => 'text',
						'column_width' => '',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'none',
						'maxlength' => '',
					),
					array (
						'key' => 'field_5270f9f995ae5',
						'label' => __('Text', 'mpcth'),
						'name' => 'mpc_description_text',
						'type' => 'text',
						'column_width' => '',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'html',
						'maxlength' => '',
					),
				),
				'row_min' => '',
				'row_limit' => '',
				'layout' => 'table',
				'button_label' => 'Add Row',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'mpc_portfolio',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));

	/* Portfolio Settings */
	register_field_group(array (
		'id' => 'acf_portfolio-settings',
		'title' => __('Portfolio Settings', 'mpcth'),
		'fields' => array (
			array (
				'key' => 'field_528b13d243f09',
				'label' => __('Display Posts Number', 'mpcth'),
				'name' => 'mpc_display_posts_number',
				'type' => 'number',
				'instructions' => __('Specify the number of portfolio items displayed.', 'mpcth'),
				'default_value' => 10,
				'placeholder' => '',
				'prepend' => '',
				'append' => __('Posts', 'mpcth'),
				'min' => 1,
				'max' => 99,
				'step' => 1,
			),
			array (
				'key' => 'field_52d90a75edb9a',
				'label' => __('Portfolio Columns', 'mpcth'),
				'name' => 'mpc_portfolio_columns',
				'type' => 'number',
				'instructions' => __('Select the number of portfolio columns.', 'mpcth'),
				'default_value' => 4,
				'placeholder' => '',
				'prepend' => '',
				'append' => __('Columns', 'mpcth'),
				'min' => 1,
				'max' => 4,
				'step' => 1,
			),
			array (
				'key' => 'field_529f03a731dee',
				'label' => __('Enable Category Filters', 'mpcth'),
				'name' => 'mpc_enable_category_filters',
				'type' => 'true_false',
				'instructions' => __('Select this if you want to display category filter at the top of your page.', 'mpcth'),
				'message' => __('Enable', 'mpcth'),
				'default_value' => 0,
			),
			array (
				'key' => 'field_529f040b31def',
				'label' => __('Limit Visible Categories', 'mpcth'),
				'name' => 'mpc_limit_visible_categories',
				'type' => 'taxonomy',
				'instructions' => __('Select the categories for posts you wish to display. Only the posts that contains at least one of selected category will be displayed. Selecting <em>None</em> will show all posts.', 'mpcth'),
				'taxonomy' => 'mpc_portfolio_cat',
				'field_type' => 'multi_select',
				'allow_null' => 1,
				'load_save_terms' => 0,
				'return_format' => 'id',
				'multiple' => 0,
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'template-portfolio.php',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));

	/* Blog Settings */
	register_field_group(array (
		'id' => 'acf_blog-settings',
		'title' => 'Blog Settings',
		'fields' => array (
			array (
				'key' => 'field_52fe1370f5e02',
				'label' => 'Layout',
				'name' => 'mpc_blog_layout',
				'type' => 'select',
				'instructions' => 'Select blog layout.',
				'choices' => array (
					'full' => 'Full width thumbnails',
					'small' => 'Small thumbnails',
				),
				'default_value' => 'full',
				'allow_null' => 0,
				'multiple' => 0,
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'template-blog.php',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));

	/* Post Type: Audio */
	register_field_group(array (
		'id' => 'acf_post-type-audio',
		'title' => __('Post Type: Audio', 'mpcth'),
		'fields' => array (
			array (
				'key' => 'field_52612ca0936d5',
				'label' => __('Audio Type', 'mpcth'),
				'name' => 'mpc_audio_type',
				'type' => 'select',
				'instructions' => __('Select the audio type you want to show as the post thumbnail.', 'mpcth'),
				'choices' => array (
					'upload' => __('Upload', 'mpcth'),
					'embed' => __('Embed', 'mpcth'),
				),
				'default_value' => 'upload',
				'allow_null' => 0,
				'multiple' => 0,
			),
			array (
				'key' => 'field_52613175936d6',
				'label' => __('MP3 File', 'mpcth'),
				'name' => 'mpc_audio_mp3_file',
				'type' => 'file',
				'instructions' => __('Select the MP3 file from you Media Library.', 'mpcth'),
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_52612ca0936d5',
							'operator' => '==',
							'value' => 'upload',
						),
					),
					'allorany' => 'all',
				),
				'save_format' => 'object',
				'library' => 'all',
			),
			array (
				'key' => 'field_526131c6936d7',
				'label' => __('OGG File', 'mpcth'),
				'name' => 'mpc_audio_ogg_file',
				'type' => 'file',
				'instructions' => __('Select the OGG file from you Media Library.', 'mpcth'),
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_52612ca0936d5',
							'operator' => '==',
							'value' => 'upload',
						),
					),
					'allorany' => 'all',
				),
				'save_format' => 'object',
				'library' => 'all',
			),
			array (
				'key' => 'field_526131e9936d8',
				'label' => __('Embed Source', 'mpcth'),
				'name' => 'mpc_audio_embed_src',
				'type' => 'textarea',
				'instructions' => __('Specify the embed source.', 'mpcth'),
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_52612ca0936d5',
							'operator' => '==',
							'value' => 'embed',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => '',
				'placeholder' => 'Embed source',
				'maxlength' => '',
				'formatting' => 'html',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
					'order_no' => 0,
					'group_no' => 0,
				),
				array (
					'param' => 'post_format',
					'operator' => '==',
					'value' => 'audio',
					'order_no' => 1,
					'group_no' => 0,
				),
			),
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'mpc_portfolio',
					'order_no' => 0,
					'group_no' => 1,
				),
				array (
					'param' => 'post_format',
					'operator' => '==',
					'value' => 'audio',
					'order_no' => 1,
					'group_no' => 1,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));

	/* Post Type: Chat */
	register_field_group(array (
		'id' => 'acf_post-type-chat',
		'title' => __('Post Type: Chat', 'mpcth'),
		'fields' => array (
			array (
				'key' => 'field_5277b1a8b63e8',
				'label' => __('Chat', 'mpcth'),
				'name' => 'mpc_chat',
				'type' => 'repeater',
				'sub_fields' => array (
					array (
						'key' => 'field_5277b218b63e9',
						'label' => __('Name', 'mpcth'),
						'name' => 'mpc_chat_name',
						'type' => 'text',
						'column_width' => 25,
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'none',
						'maxlength' => '',
					),
					array (
						'key' => 'field_5277b236b63ea',
						'label' => __('Message', 'mpcth'),
						'name' => 'mpc_chat_message',
						'type' => 'textarea',
						'column_width' => 75,
						'default_value' => '',
						'placeholder' => '',
						'maxlength' => '',
						'formatting' => 'html',
					),
				),
				'row_min' => 0,
				'row_limit' => '',
				'layout' => 'table',
				'button_label' => 'Add Row',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
					'order_no' => 0,
					'group_no' => 0,
				),
				array (
					'param' => 'post_format',
					'operator' => '==',
					'value' => 'chat',
					'order_no' => 1,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));

	/* Post Type: Gallery */
	register_field_group(array (
		'id' => 'acf_post-type-gallery',
		'title' => __('Post Type: Gallery', 'mpcth'),
		'fields' => array (
			array (
				'key' => 'field_5270f500ae50f',
				'label' => __('Gallery Images', 'mpcth'),
				'name' => 'mpc_gallery_images',
				'type' => 'gallery',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
					'order_no' => 0,
					'group_no' => 0,
				),
				array (
					'param' => 'post_format',
					'operator' => '==',
					'value' => 'gallery',
					'order_no' => 1,
					'group_no' => 0,
				),
			),
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'mpc_portfolio',
					'order_no' => 0,
					'group_no' => 1,
				),
				array (
					'param' => 'post_format',
					'operator' => '==',
					'value' => 'gallery',
					'order_no' => 1,
					'group_no' => 1,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));

	/* Post Type: Link */
	register_field_group(array (
		'id' => 'acf_post-type-link',
		'title' => __('Post Type: Link', 'mpcth'),
		'fields' => array (
			array (
				'key' => 'field_52613356beee6',
				'label' => __('Link URL', 'mpcth'),
				'name' => 'mpc_link_url',
				'type' => 'text',
				'instructions' => __('Specify the URL to replace post title permalink.', 'mpcth'),
				'default_value' => '',
				'placeholder' => __('URL', 'mpcth'),
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
					'order_no' => 0,
					'group_no' => 0,
				),
				array (
					'param' => 'post_format',
					'operator' => '==',
					'value' => 'link',
					'order_no' => 1,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));

	/* Post Type: Quote */
	register_field_group(array (
		'id' => 'acf_post-type-quote',
		'title' => __('Post Type: Quote', 'mpcth'),
		'fields' => array (
			array (
				'key' => 'field_526135682f07d',
				'label' => __('Quote Text', 'mpcth'),
				'name' => 'mpc_quote_text',
				'type' => 'textarea',
				'instructions' => __('Specify the quote text.', 'mpcth'),
				'default_value' => '',
				'placeholder' => __('Quote text', 'mpcth'),
				'maxlength' => '',
				'formatting' => 'br',
			),
			array (
				'key' => 'field_526135822f07e',
				'label' => __('Quote Author', 'mpcth'),
				'name' => 'mpc_quote_author',
				'type' => 'text',
				'instructions' => __('Specify the quote author.', 'mpcth'),
				'default_value' => '',
				'placeholder' => __('Quote author', 'mpcth'),
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
					'order_no' => 0,
					'group_no' => 0,
				),
				array (
					'param' => 'post_format',
					'operator' => '==',
					'value' => 'quote',
					'order_no' => 1,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));

	/* Post Type: Status */
	register_field_group(array (
		'id' => 'acf_post-type-status',
		'title' => __('Post Type: Status', 'mpcth'),
		'fields' => array (
			array (
				'key' => 'field_526133cd3e25f',
				'label' => __('Twitter Embed', 'mpcth'),
				'name' => 'mpc_twitter_embed',
				'type' => 'textarea',
				'instructions' => __('Specify the Twitter Embed code.', 'mpcth'),
				'default_value' => '',
				'placeholder' => __('Twitter Embed', 'mpcth'),
				'maxlength' => '',
				'formatting' => 'html',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
					'order_no' => 0,
					'group_no' => 0,
				),
				array (
					'param' => 'post_format',
					'operator' => '==',
					'value' => 'status',
					'order_no' => 1,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));

	/* Post Type: Video */
	register_field_group(array (
		'id' => 'acf_post-type-video',
		'title' => __('Post Type: Video', 'mpcth'),
		'fields' => array (
			array (
				'key' => 'field_525bd5ad050e3',
				'label' => __('Video Type', 'mpcth'),
				'name' => 'mpc_video_type',
				'type' => 'select',
				'instructions' => __('Select the video type you want to show as the post thumbnail.', 'mpcth'),
				'choices' => array (
					'embed' => __('Embed', 'mpcth'),
					'upload' => __('Upload', 'mpcth'),
				),
				'default_value' => 'embed',
				'allow_null' => 0,
				'multiple' => 0,
			),
			array (
				'key' => 'field_525bd577050e1',
				'label' => __('MP4 File', 'mpcth'),
				'name' => 'mpc_video_mp4_file',
				'type' => 'file',
				'instructions' => __('Select the MP4 file from you Media Library.', 'mpcth'),
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_525bd5ad050e3',
							'operator' => '==',
							'value' => 'upload',
						),
					),
					'allorany' => 'all',
				),
				'save_format' => 'object',
				'library' => 'all',
			),
			array (
				'key' => 'field_525bd591050e2',
				'label' => __('OGG File', 'mpcth'),
				'name' => 'mpc_video_ogg_file',
				'type' => 'file',
				'instructions' => __('Select the OGG file from you Media Library.', 'mpcth'),
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_525bd5ad050e3',
							'operator' => '==',
							'value' => 'upload',
						),
					),
					'allorany' => 'all',
				),
				'save_format' => 'object',
				'library' => 'all',
			),
			array (
				'key' => 'field_525bd61b050e4',
				'label' => __('Embed Source', 'mpcth'),
				'name' => 'mpc_video_embed_src',
				'type' => 'textarea',
				'instructions' => __('Specify the embed source.', 'mpcth'),
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_525bd5ad050e3',
							'operator' => '==',
							'value' => 'embed',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => '',
				'placeholder' => __('Insert your embed code here...', 'mpcth'),
				'maxlength' => '',
				'formatting' => 'html',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'mpc_portfolio',
					'order_no' => 0,
					'group_no' => 0,
				),
				array (
					'param' => 'post_format',
					'operator' => '==',
					'value' => 'video',
					'order_no' => 1,
					'group_no' => 0,
				),
			),
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
					'order_no' => 0,
					'group_no' => 1,
				),
				array (
					'param' => 'post_format',
					'operator' => '==',
					'value' => 'video',
					'order_no' => 1,
					'group_no' => 1,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));

	/* Product Custom Tabs */
	register_field_group(array (
		'id' => 'acf_custom-tabs',
		'title' => 'Custom Tabs',
		'fields' => array (
			array (
				'key' => 'field_534a8c0d15a90',
				'label' => 'Custom Tab',
				'name' => 'mpc_custom_tab',
				'type' => 'repeater',
				'instructions' => 'Add custom tabs to your product.',
				'sub_fields' => array (
					array (
						'key' => 'field_534a8c4615a91',
						'label' => 'Tab Title',
						'name' => 'mpc_custom_tab_title',
						'type' => 'text',
						'instructions' => 'Specify the tab title.',
						'column_width' => '',
						'default_value' => '',
						'placeholder' => 'Tab Title',
						'prepend' => '',
						'append' => '',
						'formatting' => 'html',
						'maxlength' => '',
					),
					array (
						'key' => 'field_534a8c7915a92',
						'label' => 'Tab Content',
						'name' => 'mpc_custom_tab_content',
						'type' => 'wysiwyg',
						'instructions' => 'Specify the tab content.',
						'column_width' => '',
						'default_value' => '',
						'toolbar' => 'full',
						'media_upload' => 'yes',
					),
				),
				'row_min' => '',
				'row_limit' => '',
				'layout' => 'row',
				'button_label' => 'Add Tab',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'product',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));

	/* Product Settings */
	register_field_group(array (
		'id' => 'acf_product-settings',
		'title' => 'Product Settings',
		'fields' => array (
			array (
				'key' => 'field_534cdc13415ae',
				'label' => 'Disable Hover Slide',
				'name' => 'mpc_disable_hover_slide',
				'type' => 'true_false',
				'instructions' => 'Check this if you don\'t want to display second image on hover.',
				'message' => 'Disable Hover Slide',
				'default_value' => 0,
			),
			array (
				'key' => 'field_534cdcc8415af',
				'label' => 'Custom Hover Image',
				'name' => 'mpc_custom_hover_image',
				'type' => 'image',
				'instructions' => 'Specify custom second image.',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_534cdc13415ae',
							'operator' => '!=',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'save_format' => 'object',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'product',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));

	/* Woo Categories / Tags Settings */
	register_field_group(array (
		'id' => 'acf_products-categories',
		'title' => 'Products categories',
		'fields' => array (
			array (
				'key' => 'field_53689e83b26e6',
				'label' => 'Sidebar Position',
				'name' => 'mpc_sidebar_position',
				'type' => 'radio',
				'choices' => array (
					'default' => 'Default',
					'left' => 'Left',
					'none' => 'None',
					'right' => 'Right',
				),
				'other_choice' => 0,
				'save_other_choice' => 0,
				'default_value' => 'default',
				'layout' => 'vertical',
			),
			array (
				'key' => 'field_5368bcd089ecf',
				'label' => 'Header Content Type',
				'name' => 'mpc_header_content_type',
				'type' => 'select',
				'instructions' => 'Select the type of header content area.',
				'choices' => array (
					'none' => 'None',
					'image' => 'Image',
					'custom' => 'Custom',
				),
				'default_value' => 'none',
				'allow_null' => 0,
				'multiple' => 0,
			),
			array (
				'key' => 'field_53689eb2b26e7',
				'label' => 'Custom Header',
				'name' => 'mpc_custom_header',
				'type' => 'wysiwyg',
				'instructions' => 'Specify the content you want to display at the top of current category page.',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_5368bcd089ecf',
							'operator' => '==',
							'value' => 'custom',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => '',
				'toolbar' => 'full',
				'media_upload' => 'yes',
			),
			array (
				'key' => 'field_5368bd5589ed0',
				'label' => 'Image Header',
				'name' => 'mpc_image_header',
				'type' => 'image',
				'instructions' => 'Specify the image you want to display at the top of current category page.',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_5368bcd089ecf',
							'operator' => '==',
							'value' => 'image',
						),
					),
					'allorany' => 'all',
				),
				'save_format' => 'object',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'ef_taxonomy',
					'operator' => '==',
					'value' => 'product_cat',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
			array (
				array (
					'param' => 'ef_taxonomy',
					'operator' => '==',
					'value' => 'product_tag',
					'order_no' => 0,
					'group_no' => 1,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}
