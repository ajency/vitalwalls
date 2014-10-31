<?php
global $mpcth_options;
$base_color = isset($mpcth_options['mpcth_color_main']) ? $mpcth_options['mpcth_color_main'] : '#B163A3';
$mpc_sh_options = array();

/* Dropcaps */
$mpc_sh_options['mpc_sh_dropcaps'] = array(
	'shortcode' => '[mpc_sh_dropcaps background="{{background}}" color="{{color}}" size="{{size}}"]{{content}}[/mpc_sh_dropcaps]',
	'fields' => array(
		'content' => array(
			'std' => 'A',
			'type' => 'text',
			'title' => __('Letter', 'mpc_sh'),
			'desc' => __('Specify the letter which will be displayed inside the dropcap.', 'mpc_sh')
		),
		'size' => array(
			'std' => 'normal',
			'type' => 'select',
			'title' => __('Size', 'mpc_sh'),
			'desc' => __('Select the dropcap size.', 'mpc_sh'),
			'options' => array(
				'small' => __('Small', 'mpc_sh'),
				'normal' => __('Normal', 'mpc_sh'),
				'large' => __('Large', 'mpc_sh'),
				'huge' => __('Huge', 'mpc_sh')
			)
		),
		'background' => array(
			'std' => $base_color,
			'type' => 'color',
			'title' => __('Background Color', 'mpc_sh'),
			'desc' => __('Specify dropcap background color.', 'mpc_sh')
		),
		'color' => array(
			'std' => '#ffffff',
			'type' => 'color',
			'title' => __('Letter Color', 'mpc_sh'),
			'desc' => __('Specify dropcap letter color.', 'mpc_sh')
		)
	)
);

/* Highlight */
$mpc_sh_options['mpc_sh_highlight'] = array(
	'shortcode' => '[mpc_sh_highlight background="{{background}}" color="{{color}}"]{{content}}[/mpc_sh_highlight]',
	'fields' => array(
		'content' => array(
			'std' => __('Highlight Text', 'mpc_sh'),
			'type' => 'text',
			'title' => __('Text', 'mpc_sh'),
			'desc' => __('Specify text which will be displayed inside the highlight.', 'mpc_sh')
		),
		'background' => array(
			'std' => $base_color,
			'type' => 'color',
			'title' => __('Background Color', 'mpc_sh'),
			'desc' => __('Specify highlight background color.', 'mpc_sh')
		),
		'color' => array(
			'std' => '#ffffff',
			'type' => 'color',
			'title' => __('Text Color', 'mpc_sh'),
			'desc' => __('Specify highlight text color.', 'mpc_sh')
		)
	)
);

/* Lightbox */
$mpc_sh_options['mpc_sh_lightbox'] = array(
	'shortcode' => '[mpc_sh_lightbox src="{{src}}" caption="{{caption}}"]{{content}}[/mpc_sh_lightbox]',
	'fields' => array(
		'content' => array(
			'std' => __('Lightbox text', 'mpc_sh'),
			'type' => 'text',
			'title' => __('Lightbox Text', 'mpc_sh'),
			'desc' => __('Specify text which will trigger the lightbox.', 'mpc_sh')
		),
		'src' => array(
			'std' => '#',
			'type' => 'text',
			'title' => __('Lightbox Source', 'mpc_sh'),
			'desc' => __('Specify URL to the lightbox target.', 'mpc_sh')
		),
		'caption' => array(
			'std' => 'Lightbox caption',
			'type' => 'text',
			'title' => __('Lightbox Caption', 'mpc_sh'),
			'desc' => __('Specify caption text for the lightbox target.', 'mpc_sh')
		)
	)
);

/* Tooltip */
$mpc_sh_options['mpc_sh_tooltip'] = array(
	'shortcode' => '[mpc_sh_tooltip background="{{background}}" color="{{color}}" message="{{message}}"]{{content}}[/mpc_sh_tooltip]',
	'fields' => array(
		'content' => array(
			'std' => __('Text with tooltip.', 'mpc_sh'),
			'type' => 'text',
			'title' => __('Text', 'mpc_sh'),
			'desc' => __('Specify tooltip text.', 'mpc_sh')
		),
		'message' => array(
			'std' => __('Tooltip message', 'mpc_sh'),
			'type' => 'text',
			'title' => __('Tooltip Message', 'mpc_sh'),
			'desc' => __('Specify tooltip message.', 'mpc_sh')
		),
		'background' => array(
			'std' => $base_color,
			'type' => 'color',
			'title' => __('Background Color', 'mpc_sh'),
			'desc' => __('Specify tooltip background color.', 'mpc_sh')
		),
		'color' => array(
			'std' => '#ffffff',
			'type' => 'color',
			'title' => __('Message Color', 'mpc_sh'),
			'desc' => __('Specify tooltip message color.', 'mpc_sh')
		)
	)
);