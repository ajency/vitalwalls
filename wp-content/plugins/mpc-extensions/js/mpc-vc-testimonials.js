!function($) {
	var $testimonial_template = $('.wpb-edit-form .mpc-vc-testimonials-template .mpc-vc-single-testimonial'),
		$testimonials_wrap = $('.wpb-edit-form .mpc-vc-testimonials-wrap'),
		$add_testimonial = $('.wpb-edit-form .mpc-vc-testimonial-add'),
		$content = $('.wpb-edit-form .wpb_el_type_testimonials + .wpb_el_type_textarea .textarea.content'),
		// $code = $('.wpb-edit-form .mpc-vc-icons-code'),
		$save = $('.wpb-element-edit-modal .wpb_save_edit_form, .vc_shortcode-edit-form .vc_panel-btn-save');

	var edit_content = $content.val(),
		testimonials = '';

/* ---------------------------------------------------------------- */
/* Parsing shortcode
/* ---------------------------------------------------------------- */

	try {
		testimonials = JSON.parse(edit_content);
	} catch(e) {
		// error
	}

	if(typeof testimonials === 'object') {
		$testimonials_wrap.html('');

		for(var testimonial in testimonials) {
			$testimonial_template.clone()
				.find('.mpc-vc-testimonial-author').val(testimonials[testimonial].author).end()
				.find('.mpc-vc-testimonial-text').val(testimonials[testimonial].text).end()
				.appendTo($testimonials_wrap);
		}
	}

/* ---------------------------------------------------------------- */
/* Buttons behavior
/* ---------------------------------------------------------------- */

	$add_testimonial.on('click', function(e) {
		e.preventDefault();

		$testimonial_template.clone().hide().appendTo($testimonials_wrap).fadeIn();
	});

	$testimonials_wrap.on('click', '.mpc-vc-testimonial-delete', function(e) {
		e.preventDefault();

		var $this = $(this).parent();

		$this.fadeOut(function() { $this.remove(); });
	});

	$testimonials_wrap.on('click', '.mpc-vc-testimonial-duplicate', function(e) {
		e.preventDefault();

		var $this = $(this).parent(),
			$clone = $this.clone();

		// $this.clone().hide().insertAfter($this).fadeIn();
		$clone.find('.mpc-vc-testimonial-text').val($this.find('.mpc-vc-testimonial-text').val());
		$clone.hide().insertAfter($this).fadeIn();
	});

	$testimonials_wrap.on('click', '.mpc-vc-testimonial-up', function(e) {
		e.preventDefault();

		var $this = $(this).parent(),
			$prev = $this.prev();

		if($prev.length)
			$prev.before($this);
	});

	$testimonials_wrap.on('click', '.mpc-vc-testimonial-down', function(e) {
		e.preventDefault();

		var $this = $(this).parent(),
			$next = $this.next();

		if($next.length)
			$next.after($this);
	});

	$save.on('mousedown', function() {
		var testimonials_code = [];

		$testimonials_wrap.children().each(function(i) {
			var $testimonial = $(this);

			testimonials_code[i] = {'author': $testimonial.find('.mpc-vc-testimonial-author').val(), 'text': $testimonial.find('.mpc-vc-testimonial-text').val()};
		});

		$content.val(JSON.stringify(testimonials_code));
	});
}(window.jQuery);