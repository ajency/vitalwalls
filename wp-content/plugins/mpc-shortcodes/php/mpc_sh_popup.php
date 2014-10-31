<?php
$wp_content_path = explode('wp-content', __FILE__);
require_once($wp_content_path[0] . '/wp-load.php');

require_once('mpc_sh_options.php');

function mpc_sh_popup_markup() {
	global $mpc_sh_options;

	if(!empty($mpc_sh_options)){
		$type = isset($_GET['type']) ? $_GET['type'] : '';
		$shortcode = $mpc_sh_options[$type]['shortcode'];
		$output = '<div id="mpc_shp_structure" class="mpc-hidden">' . $shortcode . '</div>' . PHP_EOL;

		foreach($mpc_sh_options[$type]['fields'] as $field => $value) {
			$field = 'mpc_shp_field_' . $field;

			$output .= '<div class="mpc-shp-option">' . PHP_EOL;
				$output .= '<h3 class="mpc-shp-option-heading">' . $value['title'] . '</h3>' . PHP_EOL;
				$output .= '<div class="mpc-shp-option-field-wrap">' . PHP_EOL;

				switch($value['type']) {
					case 'text':
						$output .= '<input type="text" class="mpc-shp-option-text mpc-shp-option-field" name="' . $field . '" id="' . $field . '" value="' . $value['std'] . '" />' . PHP_EOL;
						break;

					case "color":
						$output .= '<input type="text" class="mpc-shp-option-color mpc-shp-option-field" name="' . $field . '" id="' . $field . '" value="' . $value['std'] . '" />' . PHP_EOL;
						break;

					case 'select':
						$output .= '<select class="mpc-shp-option-select mpc-shp-option-field" name="' . $field . '" id="' . $field . '" >' . PHP_EOL;
							foreach($value['options'] as $opt_val => $opt_name) {
								$output .= '<option value="' . $opt_val . '"' . ($value['std'] == $opt_val ? ' selected=selected' : '') . '>' . $opt_name . '</option>' . PHP_EOL;
							}
						$output .= '</select>' . PHP_EOL;
					break;

					case 'checkbox':
						$output .= '<input type="checkbox" class="mpc-shp-option-checkbox mpc-shp-option-field" name="' . $field . '" id="' . $field . '" ' . $value['std'] . ' />' . PHP_EOL;
					break;
				}

				$output .= '</div>' . PHP_EOL;
				$output .= '<div class="mpc-shp-option-description">' . $value['desc'] . '</div>' . PHP_EOL;
			$output .= '</div>' . PHP_EOL;
		}

		echo $output;
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head></head>
	<body>
		<div id="mpc_shp_window">
			<form method="post" id="mpc_shp_form">
				<div id="mpc_shp_form_options_wrap">
					<?php mpc_sh_popup_markup(); ?>
					<a id="mpc_shp_accept" href="#">Insert Shortcode</a>
					<a id="mpc_shp_cancel" href="#">Cancel</a>
				</div>
			</form>

			<script type="text/javascript">
				!function($) {
					$('#mpc_shp_form_options_wrap .mpc-shp-option-color.mpc-shp-option-field').wpColorPicker();
					$('#TB_window').addClass('mpc-shp');

					$('#mpc_shp_accept').on('click', function(e) {
						e.preventDefault();

						var shortcode = $('#mpc_shp_structure').text();

						$('#mpc_shp_window .mpc-shp-option-field').each(function() {
							var $field = $(this),
								name = '{{'+ $field.attr('id').replace('mpc_shp_field_', '') + '}}';

							if ($field.is('[type=checkbox]'))
								shortcode = shortcode.replace(name, $field.is(':checked'));
							else
								shortcode = shortcode.replace(name, $field.val());
						});

						if(window.tinymce) {

							if (window.tinymce.majorVersion >= 4)
								window.tinymce.execCommand('mceInsertContent', false, shortcode);
							else
								window.tinymce.execInstanceCommand(tinymce.activeEditor.id, 'mceInsertContent', false, shortcode);

							tb_remove();
						}
					});

					$('#mpc_shp_cancel').on('click', function(e) {
						e.preventDefault();

						if(window.tinymce) {
							tb_remove();
						}
					});
				}(window.jQuery);
			</script>
		</div>
	</body>
</html>