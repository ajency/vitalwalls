!function($) {
	var $input_image = $('.wpb-element-edit-modal .mpc-vc-hidden-fb.bg_image_fb'),
		$input_style = $('.wpb-element-edit-modal .mpc-vc-hidden-fb.bg_image_repeat_fb'),
		$bg_image = $('.wpb-element-edit-modal .vc-background-image img'),
		$bg_style = $('.wpb-element-edit-modal .vc-background-style select.vc-background-style'),
		$save = $('.wpb-element-edit-modal .wpb_save_edit_form');

/* ---------------------------------------------------------------- */
/* Buttons behavior
/* ---------------------------------------------------------------- */

	$save.on('mousedown', function() {
		$input_image.val($bg_image.attr('data-image-id'));
		$input_style.val($bg_style.val());
	});
}(window.jQuery);