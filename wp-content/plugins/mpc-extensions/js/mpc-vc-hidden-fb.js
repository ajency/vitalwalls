!function($) {
	var $input_image = $('.wpb-edit-form .mpc-vc-hidden-fb.bg_image_fb'),
		$input_style = $('.wpb-edit-form .mpc-vc-hidden-fb.bg_image_repeat_fb'),
		$bg_image = $('.wpb-edit-form .vc-background-image img, .wpb-edit-form .vc_background-image img'),
		$bg_style = $('.wpb-edit-form .vc-background-style select.vc-background-style, .wpb-edit-form .vc_background-style select.vc_background-style'),
		$save = $('.wpb-element-edit-modal .wpb_save_edit_form, .vc_shortcode-edit-form .vc_panel-btn-save');

/* ---------------------------------------------------------------- */
/* Buttons behavior
/* ---------------------------------------------------------------- */

	$save.on('mousedown', function() {
		$input_image.val($bg_image.attr('data-image-id'));
		$input_style.val($bg_style.val());
	});
}(window.jQuery);