(function () {
	tinymce.create('tinymce.plugins.mpc_sh', {
		base_url: '',
		init: function (editor, url) {
			var self = this;
			self.base_url = url;

			editor.addCommand('mpc_sh_popup', function(attr, params) {
				tb_show('Insert Shortcode: ' + params.title, url + '/../php/mpc_sh_popup.php?type=' + params.identifier + '&width=640');
			});

			if (tinymce.majorVersion >= 4) {
				editor.addButton( 'mpc_sh_button', {
					type: 'menubutton',
					title: 'MPC Shortcodes',
					icon: 'mpc_add',
					menu: [
						{ text: 'Dropcaps', onclick: function() {
							tinyMCE.activeEditor.execCommand('mpc_sh_popup', false, {
								title: 'Dropcaps',
								identifier: 'mpc_sh_dropcaps'
							});
						} },
						{ text: 'Highlight', onclick: function() {
							tinyMCE.activeEditor.execCommand('mpc_sh_popup', false, {
								title: 'Highlight',
								identifier: 'mpc_sh_highlight'
							});
						} },
						{ text: 'Lightbox', onclick: function() {
							tinyMCE.activeEditor.execCommand('mpc_sh_popup', false, {
								title: 'Lightbox',
								identifier: 'mpc_sh_lightbox'
							});
						} },
						{ text: 'Tooltip', onclick: function() {
							tinyMCE.activeEditor.execCommand('mpc_sh_popup', false, {
								title: 'Tooltip',
								identifier: 'mpc_sh_tooltip'
							});
						} }
					]
				});
			}
		},
		createControl: function(button, e) {
			if(button == 'mpc_sh_button') {
				var self = this;

				button = e.createMenuButton('mpc_sh_button', {
					title: 'Insert Shortcode',
					image: this.base_url + '/../img/add.png',
					icons: false
				});

				button.onRenderMenu.add(function (first, second) {
					self.showPopup(second, 'Dropcaps', 'mpc_sh_dropcaps');
					self.showPopup(second, 'Highlight', 'mpc_sh_highlight');
					self.showPopup(second, 'Lightbox', 'mpc_sh_lightbox');
					self.showPopup(second, 'Tooltip', 'mpc_sh_tooltip');
				});
				return button;
			}
			return null;
		},
		showPopup: function(obj, title, id) {
			obj.add({
				title: title,
				onclick: function () {
					tinyMCE.activeEditor.execCommand('mpc_sh_popup', false, {
						title: title,
						identifier: id
					})
				}
			})
		},
		getInfo: function() {
			return {
				longname: 'MPC Shortcodes',
				author: 'MassivePixelCreation',
				authorurl: 'http://themeforest.net/user/mpc/',
				infourl: 'http://themeforest.net/user/mpc/',
				version: '1.1'
			}
		}
	});

	tinymce.PluginManager.add('mpc_sh', tinymce.plugins.mpc_sh);
})();