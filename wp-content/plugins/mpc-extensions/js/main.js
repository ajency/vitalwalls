(function($) {
	$('.mpcth-items-slider').flexslider({
		animation: 'slide',
		controlNav: false,
		animationLoop: true,
		slideshow: false,
		minItems: 1,
		maxItems: 4,
		itemWidth: 260,
		itemMargin: 40
	});

	$('.mpc-vc-share-facebook').on('click', function(e) {
		window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(location.href), 'facebook-share', 'width=630,height=430');

		e.preventDefault();
	});

	$('.mpc-vc-share-twitter').on('click', function(e) {
		window.open('https://twitter.com/intent/tweet?url=' + encodeURIComponent(location.href) + '&text=' +  encodeURIComponent(document.title), 'twitter-share', 'width=630,height=430');

		e.preventDefault();
	});

	$('.mpc-vc-share-google-plus').on('click', function(e) {
		window.open('https://plus.google.com/share?url=' + encodeURIComponent(location.href), 'googleplus-share', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');

		e.preventDefault();
	});

	$('.mpc-vc-share-pinterest').on('click', function(e) {
		var $img = $('#mpcth_page_wrap .mpcth-post-thumbnail img'),
			img_src = $img.length > 0 ? encodeURIComponent($img.first().attr('src')) : '';

		window.open('https://pinterest.com/pin/create/button/?url=' + encodeURIComponent(location.href) + '&amp;description=' + encodeURIComponent(document.title) + '&media=' + img_src, 'pinterest-share', 'width=630,height=430');

		e.preventDefault();
	});
})(jQuery);