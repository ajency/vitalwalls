!function($) {
	var $def_item = $('.wpb-element-edit-modal .mpc-vc-list-items-template .mpc-vc-list-single-item'),
		$items_wrap = $('.wpb-element-edit-modal .mpc-vc-list-items-wrap'),
		$icons_wrap = $('.wpb-element-edit-modal .mpc-vc-list-items-icons-wrap'),
		$add_item = $('.wpb-element-edit-modal .mpc-vc-item-add'),
		$code = $('.wpb-element-edit-modal .mpc-vc-icons-code'),
		$save = $('.wpb-element-edit-modal .wpb_save_edit_form');

	var edit_code = $code.val(),
		list_items = '';

/* ---------------------------------------------------------------- */
/* Parsing shortcode
/* ---------------------------------------------------------------- */

	try {
		list_items = JSON.parse(decodeURIComponent(edit_code));
	} catch(e) {
		// error
	}

	if(typeof list_items === 'object') {
		$items_wrap.html('');

		for(var item in list_items) {
			$def_item.clone()
				.find('.mpc-vc-item-icon i').attr('class', list_items[item].icon).end()
				.find('.mpc-vc-item-text').val(list_items[item].text).end()
				.appendTo($items_wrap);
		}
	}

/* ---------------------------------------------------------------- */
/* Buttons behavior
/* ---------------------------------------------------------------- */

	$add_item.on('click', function(e) {
		e.preventDefault();

		$def_item.clone().hide().appendTo($items_wrap).fadeIn();
	});

	$items_wrap.on('click', '.mpc-vc-item-delete', function(e) {
		e.preventDefault();

		var $this = $(this).parent();

		$this.fadeOut(function() { $this.remove(); });
	});

	$items_wrap.on('click', '.mpc-vc-item-duplicate', function(e) {
		e.preventDefault();

		var $this = $(this).parent();

		$this.clone().hide().insertAfter($this).fadeIn();
	});

	$items_wrap.on('click', '.mpc-vc-item-up', function(e) {
		e.preventDefault();

		var $this = $(this).parent(),
			$prev = $this.prev();

		if($prev.length)
			$prev.before($this);
	});

	$items_wrap.on('click', '.mpc-vc-item-down', function(e) {
		e.preventDefault();

		var $this = $(this).parent(),
			$next = $this.next();

		if($next.length)
			$next.after($this);
	});

	$items_wrap.on('click', '.mpc-vc-item-icon', function(e) {
		e.preventDefault();

		var $icon = $(this),
			$this = $icon.parent();

		$this.append($icons_wrap);

		$icons_wrap.fadeIn();

		$icons_wrap.one('click', 'i', function() {
			$icon.children().attr('class', $(this).attr('class'));

			$icons_wrap.fadeOut(function() {
				$icons_wrap.insertBefore($add_item);
			});
		});
	});

	$save.on('mousedown', function() {
		var code = [];

		$items_wrap.children().each(function(i) {
			var $item = $(this);

			code[i] = {'icon': $item.find('.mpc-vc-item-icon i').attr('class'), 'text': $item.find('.mpc-vc-item-text').val()};
		});

		$code.val(encodeURIComponent(JSON.stringify(code)));
	});
}(window.jQuery);