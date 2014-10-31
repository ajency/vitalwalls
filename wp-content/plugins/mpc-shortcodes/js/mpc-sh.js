jQuery(document).ready(function($) {
	if ($('.mpcth-lightbox').length == 0) {
		$('.mpc-sc-lightbox').magnificPopup({
			type:'image',
			key: 'mpcth-popup',
			image: {
				verticalFit: true
			},
			gallery: {
				enabled: true
			}
		});
	}
});