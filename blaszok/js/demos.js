jQuery(document).ready(function($) {
	/* Cache panel elements */
	var $demos = $('#mpcth_demos').find('.preview-item'),
		$options = $('#mpcth_options').find('.install-option'),
		$import_btn = $('#mpcth_import'),
		$import_process = $('#mpcth_import_process'),
		$import_success = $('#mpcth_import_success'),
		$import_backups = $('#mpcth_import_backups');

	var backup_flag = false;

	/* Set active demo theme */
	$demos.on('click', function(e) {
		$demos.removeClass('active').find('.install-option').removeClass('active');

		$(this).toggleClass('active')
			.find('.install-option').toggleClass('active');

		$import_btn.children('strong').text($(this).text());

		e.preventDefault();
	});

	/* Set import elements */
	$options.on('click', function(e) {
		$(this).toggleClass('active');

		$(this).next('.option-extension').toggleClass('active');

		if($options.filter('.active').length)
			$import_btn.addClass('active');
		else
			$import_btn.removeClass('active');

		e.preventDefault();
	});

	/* Begin the import */
	$import_btn.on('click', function (e) {
		if ($(this).is('.active'))
			mpcth_begin_import();

		e.preventDefault();
	});

	function mpcth_begin_import() {
		/* Set elements flags */
		var theme = $demos.filter('.active').attr('data-theme'),
			install_content = $('#mpcth_opt_content').is('.active'),
			install_widgets = $('#mpcth_opt_widgets').is('.active'),
			install_panel = $('#mpcth_opt_panel').is('.active'),
			install_sliders = $('#mpcth_opt_sliders').is('.active');

		$import_success.css('display', 'none');
		$import_btn.css('display', 'none');
		$import_process.css('display', 'inline-block');

		import_step_backup();

		/* Backup the whole settings before import */
		function import_step_backup() {
			$import_process.attr('class', 'step-backup');

			$.post(ajaxurl, {
				action: 'mpcth_import_step_backup'
			}, function(response) {
				import_step_content();
			});
		}

		/* Import the whole demo content with menu */
		function import_step_content() {
			if (install_content) {
				$import_process.attr('class', 'step-content');

				$.post(ajaxurl, {
					theme: theme,
					action: 'mpcth_import_step_content'
				}, function(response) {
					import_step_widgets();
				});
			} else {
				import_step_widgets();
			}
		}

		/* Import all widgets */
		function import_step_widgets() {
			if (install_widgets) {
				$import_process.attr('class', 'step-widgets');

				$.post(ajaxurl, {
					theme: theme,
					action: 'mpcth_import_step_widgets'
				}, function(response) {
					import_step_panel();
				});
			} else {
				import_step_panel();
			}
		}

		/* Import theme options */
		function import_step_panel() {
			if (install_panel) {
				$import_process.attr('class', 'step-panel');

				$.post(ajaxurl, {
					theme: theme,
					action: 'mpcth_import_step_panel'
				}, function(response) {
					import_step_sliders();
				});
			} else {
				import_step_sliders();
			}
		}

		/* Import basic slider */
		function import_step_sliders() {
			if (install_sliders) {
				$import_process.attr('class', 'step-sliders');

				$.post(ajaxurl, {
					theme: theme,
					action: 'mpcth_import_step_sliders'
				}, function(response) {
					clear_wizard();
				});
			} else {
				clear_wizard();
			}
		}

		/* Reset import wizard to default values */
		function clear_wizard() {
			$options.removeClass('active');

			$import_btn.removeClass('active');

			$import_success.css('display', 'inline-block');
			$import_process.css('display', 'none');

			setTimeout(function () {
				$import_success.css('display', 'none');
				$import_btn.css('display', 'inline-block');
			}, 5000);

			$.post(ajaxurl, {
				theme: theme,
				action: 'mpcth_import_backups_list'
			}, function(response) {
				$import_backups.find('ol').html(response);
			});
		}
	}

	/* Restore/Delete backup */
	$import_backups.on('click', '.mpcth-backup-delete, .mpcth-backup-restore', function (e) {
		if (backup_flag)
			return false;

		var $this = $(this),
			$parent = $this.parent(),
			is_delete = $this.is('.mpcth-backup-delete');

		if (! window.confirm($this.attr('data-msg')))
			return false;

		$parent.addClass('active');
		backup_flag = true;

		$.post(ajaxurl, {
			id: $parent.attr('data-id'),
			action: is_delete ? 'mpcth_import_backup_delete' : 'mpcth_import_backup_restore'
		}, function(response) {
			if (is_delete) {
				$parent.slideUp(function () {
					$parent.remove();
					backup_flag = false;
				});
			} else {
				$parent.removeClass('active');
				backup_flag = false;
			}
		});

		e.preventDefault();
	});
});
