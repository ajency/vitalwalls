!function($) {
	var $icon = $('.wpb-edit-form .mpc-vc-icons .mpc-vc-icon'),
		$icon_input = $('.wpb-edit-form .mpc-vc-icons .mpc-vc-icons-icon'),
		$icons_list = $('.wpb-edit-form .mpc-vc-icons .mpc-vc-icons-wrap');

/* ---------------------------------------------------------------- */
/* Buttons behavior
/* ---------------------------------------------------------------- */

	$icon.on('click', function(e) {
		$icons_list.toggleClass('open');

		if ($icons_list.is('.open'))
			$icons_list.slideDown();
		else
			$icons_list.slideUp();

		e.preventDefault();
	});

	$icons_list.on('click', '.fa', function() {
		var icon_class = $(this).attr('class');

		$icon.children('i').attr('class', icon_class);
		$icon_input.val(icon_class.substring(12));

		$icon.trigger('click');
	});
}(window.jQuery);