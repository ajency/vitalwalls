if (!window.console) console = {log: function() {}};

jQuery(document).ready(function($) {
	var $window = $(window),
		is_admin_bar_enabled = $('#wpadminbar').length,
		is_touch = 'ontouchstart' in window;

/* ---------------------------------------------------------------- */
/* Smart resize
/* ---------------------------------------------------------------- */
	var resize_timer;

	$window.on('resize', function(e) {
		clearTimeout(resize_timer);
		resize_timer = setTimeout(function() {
			$window.trigger('smart_resize');
		}, 250);
	});

	$window.on('load', function() {
		$window.trigger('resize');
	})

/* ---------------------------------------------------------------- */
/* Search
/* ---------------------------------------------------------------- */
	var $search_toggle = $('#mpcth_search'),
		$search_wrap = $('#mpcth_smart_search_wrap');

	$search_toggle.on('click', function(e) {
		$search_toggle.toggleClass('active');

		if ($search_toggle.is('.active')) {
			$search_wrap.slideDown();

			$search_toggle.on('mousedown', catch_search_wrap_mousedown);
			$search_wrap.on('mousedown', catch_search_wrap_mousedown);
			$window.one('mousedown', close_smart_search);
		} else {
			$search_wrap.slideUp();

			$search_toggle.off('mousedown', catch_search_wrap_mousedown);
			$search_wrap.off('mousedown', catch_search_wrap_mousedown);
			$window.off('mousedown', close_smart_search);
		}

		e.preventDefault();
	});

	function catch_search_wrap_mousedown(e) {
		e.stopPropagation();
	}
	function close_smart_search() {
		$search_toggle.off('mousedown', catch_search_wrap_mousedown);
		$search_wrap.off('mousedown', catch_search_wrap_mousedown);
		$search_toggle.trigger('click');
	}

	var $search_category = $('#mpcth_smart_search_wrap .mpc-w-smart-search-filter-category'),
		$search_form = $('#mpcth_smart_search_wrap #searchform'),
		$search_prices = $('#mpcth_smart_search_wrap .mpc-w-smart-search-filter-price'),
		$search_fields = $('#mpcth_smart_search'),
		$search_field = $('#mpcth_smart_search_wrap #s'),
		$search_button = $('#mpcth_smart_search_wrap #searchsubmit');

	var search_currency = $('#mpcth_currency_symbol').val(),
		search_currency_position = $('#mpcth_currency_symbol').attr('data-position');

	$search_category.on('change', function() {
		$search_form.attr('action', $search_category.val());
	});

	$search_button.on('click', function() {
		if ($search_field.val() == '') {
			var $min_price = $search_prices.filter('[name=min_price]');
			var $max_price = $search_prices.filter('[name=max_price]');

			if ($min_price.val() == '')
				$min_price.val(0);

			if ($max_price.val() == '')
				if ($max_price.next('.mpc-w-smart-search-filter-price-max').length)
					$max_price.val($max_price.next('.mpc-w-smart-search-filter-price-max').val());
				else
					$max_price.val(9999999);

			$search_fields.find('select, input').each(function() {
				var $this = $(this);

				if ($this.val() == '')
					$this.attr('name', '');
			});

			$search_prices.each(function() {
				var $this = $(this);

				$this.val($this.val().replace(search_currency, ''));
			});

			$search_field.attr('name', '');
		} else {
			$search_fields.find('select, input:not(#s)').attr('name', '');
		}
	});

	$search_prices.on('focus', function() {
		var $this = $(this);

		$this.val($this.val().replace(search_currency, ''));
	});
	$search_prices.on('blur', function() {
		var $this = $(this);

		if ($this.val().length > 0)
			if (search_currency_position == 'right' || search_currency_position == 'right_space')
				$this.val($this.val() + search_currency);
			else
				$this.val(search_currency + $this.val());
	});

/* ---------------------------------------------------------------- */
/* Header setup
/* ---------------------------------------------------------------- */
	var $logo = $('#mpcth_logo'),
		$header_container = $('#mpcth_page_header_container'),
		$header_menu = $('#mpcth_nav');

	if ($logo.children('img').length) {
		var $logo_image = $logo.children('img').last(),
			$temp_image = $('<img>');

		$temp_image.on('load', function() {
			setup_sticky();
		}).attr('src', $logo_image.attr('src'));
	} else {
		setup_sticky();
	}

/* ---------------------------------------------------------------- */
/* Sticky header
/* ---------------------------------------------------------------- */
	function setup_sticky() {
		var $sticky_header = $('#mpcth_page_header_wrap'),
			$sticky_header_spacer = $('#mpcth_page_header_wrap_spacer');

		if ($sticky_header.is('.mpcth-sticky-header-enabled')) {
			$sticky_header_spacer.waypoint({
				handler: function(direction) {
					if ($window.width() > 979) {
						var height = $header_container.height();

						if (direction == 'up') {
							$sticky_header.stop(true, true).animate({top: -height}, 200, function() {
								$sticky_header.css('top', 0).removeClass('mpcth-sticky-header');
								$sticky_header_spacer.height(0);
								center_menu_dropdowns();
							});
						} else {
							$sticky_header.addClass('mpcth-sticky-header').css('top', -height).animate({top: is_admin_bar_enabled ? 32 : 0}, 700, function() {
								center_menu_dropdowns();
							});
							$sticky_header_spacer.height(height);
						}
					}
				},
				offset: '-25%'
			});
		}

		$header_container.addClass('mpcth-header-ready');
	}

/* ---------------------------------------------------------------- */
/* Back to top
/* ---------------------------------------------------------------- */
	var $back_to_top = $('#mpcth_back_to_top'),
		$page_top = $('#mpcth_page_header_wrap_spacer');;

	if ($back_to_top.length > 0) {
		$back_to_top.on('click', function() {
			$('html, body').animate({scrollTop: 0});
			$back_to_top.removeClass('active');
		});

		$page_top.waypoint({
			handler: function(direction) {
				if (direction == 'up')
					$back_to_top.removeClass('active');
				else
					$back_to_top.addClass('active');
			},
			offset: '-25%'
		});
	}

/* ---------------------------------------------------------------- */
/* Mega menu
/* ---------------------------------------------------------------- */
	var $mega_menu = $('#mpcth_mega_menu');

	$window.on('load', function() {
		$mega_menu.find('.menu-item').off('mouseover');

		$mega_menu.find('.mega-hdr-a').each(function() {
			var $this = $(this),
				text = $this.html();

			$this.html('<span class="mpcth-color-main-border">' + text + '</span>');
		});
	});

/* ---------------------------------------------------------------- */
/* Menu center dropdowns
/* ---------------------------------------------------------------- */
	var $main_menu = $('#mpcth_nav'),
		menu_checker;

	$main_menu.find('.mpcth-menu > ul > .page_item > .children, .mpcth-menu > .menu-item > .sub-menu').each(function() {
		var $this = $(this);

		$this.css('left', $this.width() * -.5);
	});

	if ($mega_menu.length) {
		menu_checker = setInterval(center_menu_dropdowns, 50);
	}

	$window.on('load', function() {
		center_menu_dropdowns();
	});

	$window.on('smart_resize', function() {
		center_menu_dropdowns();
	});

	function center_menu_dropdowns() {
		if ($main_menu.find('.sub-container').length) {
			var window_width = $window.width();

			$main_menu.find('.sub-container').each(function() {
				var $this = $(this),
					$parent = $this.parent(),
					center = $parent.offset().left + $parent.width() * .5,
					move = $this.width() * .5;

				$this.css('left', -move);

				if (center + move > window_width)
					$this.css('left', -move + (window_width - (center + move)));

				if (center - move < 0)
					$this.css('left', -move + (move - center));
			});

			if ($('html').is('.ie'))
				$mega_menu.find('.row').each(function() {
					var $this = $(this);

					if (! $this.is('.extended')) {
						$this.width($this.width() + 10);
						$this.addClass('extended');
					}
				});

			clearInterval(menu_checker);
		} else {
			clearInterval(menu_checker);
		}
	}

/* ---------------------------------------------------------------- */
/* Menu touch hover
/* ---------------------------------------------------------------- */
	if (is_touch) {
		$('#mpcth_secondary_mini_menu .menu-item-has-children > a, #mpcth_nav .menu-item-has-children > a').on('click', function(e) {
			e.preventDefault();
		});
	}

/* ---------------------------------------------------------------- */
/* Menu nav fixed width
/* ---------------------------------------------------------------- */
	if ($('#mpcth_page_header_content').is('.mpcth-header-order-m_s_l')) {
		$main_menu.width($main_menu.children().width());

		$window.on('smart_resize', function() {
			$main_menu.width($main_menu.children().width());
		});
	}

/* ---------------------------------------------------------------- */
/* Mobile footer
/* ---------------------------------------------------------------- */
	var $mobile_footer_toggle = $('#mpcth_toggle_mobile_footer'),
		$mobile_footer_wrap = $('#mpcth_footer_content');

	$mobile_footer_toggle.on('click', function(e) {
		$mobile_footer_toggle.toggleClass('active');

		if ($mobile_footer_toggle.is('.active'))
			$mobile_footer_wrap.slideDown();
		else
			$mobile_footer_wrap.stop(true, true).slideUp();

		e.preventDefault();
	});

	$window.on('smart_resize', function() {
		if ($window.width() > 480) {
			$mobile_footer_toggle.removeClass('active');
			$mobile_footer_wrap.css('display', '');
		}
	});

/* ---------------------------------------------------------------- */
/* Mobile extended footer
/* ---------------------------------------------------------------- */
	var $mobile_extended_footer_toggle = $('#mpcth_toggle_mobile_extended_footer'),
		$mobile_extended_footer_wrap = $('#mpcth_footer_extended_content');

	$mobile_extended_footer_toggle.on('click', function(e) {
		$mobile_extended_footer_toggle.toggleClass('active');

		if ($mobile_extended_footer_toggle.is('.active'))
			$mobile_extended_footer_wrap.slideDown();
		else
			$mobile_extended_footer_wrap.stop(true, true).slideUp();

		e.preventDefault();
	});

	$window.on('smart_resize', function() {
		if ($window.width() > 480) {
			$mobile_extended_footer_toggle.removeClass('active');
			$mobile_extended_footer_wrap.css('display', '');
		}
	});

/* ---------------------------------------------------------------- */
/* Mobile sidebar
/* ---------------------------------------------------------------- */
	var $mobile_sidebar_toggle = $('#mpcth_toggle_mobile_sidebar'),
		$mobile_sidebar_wrap = $('#mpcth_sidebar');

	$mobile_sidebar_toggle.on('click', function(e) {
		$mobile_sidebar_toggle.toggleClass('active');
		$mobile_sidebar_wrap.toggleClass('active');

		e.preventDefault();
	});

	$window.on('smart_resize', function() {
		if ($window.width() > 979) {
			$mobile_sidebar_toggle.toggleClass('active');
			$mobile_sidebar_wrap.removeClass('active');
		}
	});

/* ---------------------------------------------------------------- */
/* Mobile menu
/* ---------------------------------------------------------------- */
	var $mobile_menu_toggle = $('#mpcth_toggle_mobile_menu'),
		$mobile_menu_wrap = $('#mpcth_mobile_nav_wrap');

	$mobile_menu_toggle.on('click', function(e) {
		$mobile_menu_toggle.toggleClass('active');
		$mobile_menu_wrap.toggleClass('active');

		e.preventDefault();
	});

	$window.on('smart_resize', function() {
		if ($window.width() > 979) {
			$mobile_menu_toggle.removeClass('active');
			$mobile_menu_wrap.removeClass('active');
		}
	});

	var $secondary_header = $('#mpcth_page_header_secondary_content');
	var $header_container = $('#mpcth_page_header_container');
	var mobile = false;

	function swap_menu() {
		if ($window.width() > 979) {
			if (mobile) {
				mobile = false;
				$header_container.prepend($secondary_header);
			}
		} else {
			if (! mobile) {
				mobile = true;
				$mobile_menu_wrap.prepend($secondary_header);
			}
		}
	}

	$window.on('smart_resize', swap_menu);
	swap_menu();

/* ---------------------------------------------------------------- */
/* Lightbox
/* ---------------------------------------------------------------- */
	init_lightbox($('#mpcth_content'));

	function init_lightbox($target) {
		$target.find('.mpcth-lightbox, .mpc-sc-lightbox').magnificPopup({
			type: 'image',
			// key: 'mpcth-popup',
			removalDelay: 300,
			mainClass: 'mfp-fade mpcth-popup',
			image: {
				verticalFit: true
			},
			gallery: {
				enabled: true
			}
		});

		$target.find('.mpcth-alt-lightbox').magnificPopup({
			type: 'image',
			// key: 'mpcth-alt-popup',
			removalDelay: 300,
			mainClass: 'mfp-fade mpcth-alt-popup',
			image: {
				verticalFit: true
			},
			gallery: {
				enabled: false
			}
		});
	}

/* ---------------------------------------------------------------- */
/* Portfolio filters & sorts
/* ---------------------------------------------------------------- */
	$('.page-template-template-portfolio-php #mpcth_content').mixitup({
		targetSelector: '.mpcth-post',
		filterSelector: '.mpcth-portfolio-filter',
		sortSelector: '.mpcth-portfolio-sort',
		buttonEvent: 'click',
		effects: ['fade'],
		listEffects: null,
		easing: 'snap',
		layoutMode: 'grid',
		targetDisplayGrid: 'inline-block',
		targetDisplayList: 'block',
		gridClass: '',
		listClass: '',
		transitionSpeed: 600,
		showOnLoad: 'all',
		sortOnLoad: false,
		multiFilter: false,
		filterLogic: 'or',
		resizeContainer: true,
		minHeight: 0,
		failClass: 'fail',
		perspectiveDistance: '0',
		perspectiveOrigin: '50% 50%',
		animateGridList: true,
		onMixLoad: null,
		onMixStart: null,
		onMixEnd: null
	});

	var $portfolio_filters_and_sorts = $('#mpcth_portfolio_filters, #mpcth_portfolio_sorts');

	$portfolio_filters_and_sorts.on('click', 'li', function() {
		$portfolio_filters_and_sorts.children().removeClass('active');
		$(this).addClass('active');
	});

	var $portfolio_mobile_filters_and_sorts = $portfolio_filters_and_sorts.children('select');

	$portfolio_mobile_filters_and_sorts.on('change', function() {
		var $this = $(this);

		$this.siblings('ul').find('li').filter('[data-filter=' + $this.val() + '], [data-sort=' +  $this.val() + ']').click();
	});

/* ---------------------------------------------------------------- */
/* Parallax
/* ---------------------------------------------------------------- */
	$('.mpcth-vc-row-wrap-parallax').waypoint(function() {
		$(this).children('.mpcth-overlay-image').delay(1000).animate({'opacity': 1}, 500);
	}, { offset: '85%' });

/* ---------------------------------------------------------------- */
/* Waypoint
/* ---------------------------------------------------------------- */
	$('.mpcth-waypoint').waypoint(function() {
		$(this).addClass('mpcth-waypoint-triggered').trigger('mpc_waypoint');
	}, { offset: '85%' });

/* ---------------------------------------------------------------- */
/* iFrame resize
/* ---------------------------------------------------------------- */
	var $frame_container = $('#mpcth_main');
	iframe_check();

	function iframe_check() {
		var frame_count = $frame_container.find('iframe').length,
			frame_loaded = 0,
			frame_checker = setInterval(function() {
				frame_count = $frame_container.find('iframe').length;
				frame_loaded = 0;
				$frame_container.find('iframe').each(function() {
					if($(this).height() > 0)
						frame_loaded++;
				});
				if (frame_count == frame_loaded) {
					clearInterval(frame_checker);

					$window.trigger('iframe_loaded');
				}
			}, 500);
	}

/* ---------------------------------------------------------------- */
/* Flexslider
/* ---------------------------------------------------------------- */
	init_flexslider($('#mpcth_content'));

	function init_flexslider($target) {
		$target.find('.flexslider:not(#main_slider, #main_thumbs, .mpcth-items-slider, .flexslider_fade)').flexslider({
			animation: 'slide',
			useCSS: false,
			slideshow: false
		});

		$('.flex-direction-nav .flex-prev').addClass('fa fa-fw fa-angle-left');
		$('.flex-direction-nav .flex-next').addClass('fa fa-fw fa-angle-right');
	}

	$window.on('load', function() {
		$('.flex-direction-nav .flex-prev').addClass('fa fa-fw fa-angle-left');
		$('.flex-direction-nav .flex-next').addClass('fa fa-fw fa-angle-right');
	});

	$('#main_slider').flexslider({
		animation: 'slide',
		useCSS: false,
		controlNav: false,
		animationLoop: false,
		slideshow: false,
		sync: '#main_thumbs',
		smoothHeight: true
	});

	$('#main_thumbs').flexslider({
		animation: 'slide',
		useCSS: false,
		controlNav: false,
		animationLoop: false,
		slideshow: false,
		minItems: 3,
		maxItems: 4,
		itemWidth: 80,
		itemMargin: 20,
		asNavFor: '#main_slider'
	});

	$('.mpcth-items-slider.mpc-vc-blog-posts-slider').flexslider({
		animation: 'slide',
		useCSS: false,
		controlNav: false,
		animationLoop: true,
		slideshow: false,
		minItems: 1,
		maxItems: 2,
		itemWidth: 560,
		itemMargin: 40
	});

/* ---------------------------------------------------------------- */
/* CarouFredSel
/* ---------------------------------------------------------------- */
	var $carousels = $('.mpcth-items-slider-wrap');
	var carousel_defaults = {
		responsive: true,
		width: '100%',
		height: 'variable',
		items: {
			visible: {
				min: 1,
				max: 4
			},
			width: 300,
			height: 'variable'
		},
		next: {
			button: ''
		},
		prev: {
			button: ''
		},
		auto: {
			play: false
		}
	}

	$carousels.each(function() {
		var $this = $(this),
			$carousel = $this.find('.mpcth-items-slider'),
			$prev = $this.find('.mpcth-items-slider-prev'),
			$next = $this.find('.mpcth-items-slider-next');

		carousel_defaults.items.visible.max = 4;
		carousel_defaults.items.width = 300;

		carousel_defaults.prev.button = $prev;
		carousel_defaults.next.button = $next;

		if ($carousel.is('.mpcth-items-slider-wide')) {
			carousel_defaults.items.visible.max = 2;
			carousel_defaults.items.width = 800;
		}

		if ($carousel.is('.mpc-vc-blog-posts-slider') && (! $carousel.parents('.wpb_column').first().is('.vc_span12') || ! $('body').is('.mpcth-sidebar-none'))) {
			carousel_defaults.items.visible.max = 1;
		}

		if ($carousel.attr('data-max-width') != '' && $carousel.attr('data-max-width') < 300) {
			var max_width = $carousel.attr('data-max-width');

			carousel_defaults.items.width = max_width;
			carousel_defaults.items.visible.max = Math.ceil($carousel.width() / max_width);
		}

		$carousel.carouFredSel(carousel_defaults);

		$window.on('load', function() {
			$carousel.trigger('updateSizes');
		});
		$window.on('smart_resize', function() {
			$carousel.trigger('updateSizes');
		});
	});
	$carousels.swipe({
		excludedElements: "button, input, select, textarea, .noSwipe",
		swipeLeft: function() {
			$(this).children('.mpcth-items-slider-next').trigger('click');
		},
		swipeRight: function() {
			$(this).children('.mpcth-items-slider-prev').trigger('click');
		},
		tap: function(event, target) {
			var $target = $(target).closest('a');

			if ($target.is(':not(.mpcth-items-slider-next, .mpcth-items-slider-prev)'))
				window.open($target.attr('href'), '_self');
		}
	});

/* ---------------------------------------------------------------- */
/* Nivoslider
/* ---------------------------------------------------------------- */
	$window.on('load', function() {
		$('.nivoSlider .nivo-prevNav').addClass('fa fa-fw fa-angle-left');
		$('.nivoSlider .nivo-nextNav').addClass('fa fa-fw fa-angle-right');
	});

/* ---------------------------------------------------------------- */
/* Newsletter
/* ---------------------------------------------------------------- */
	var $newsletter = $('#mpcth_newsletter');

	$newsletter.find('br').remove();
	$newsletter.find('input[name=subscribe]').wrap('<span class="mpcth-newsletter-subscribe">');

	$newsletter.on('click', '.mpcth-newsletter-toggle', function(e) {
		$newsletter.toggleClass('mpcth-toggled');
		e.preventDefault();
	});

/* ---------------------------------------------------------------- */
/* WooCommerce
/* ---------------------------------------------------------------- */
	/* Wrap quantity buttons */
	if ($('body').is('.woocommerce-cart') || $('body').is('.single-product')) {
		var $quantity = $('.cart .quantity');

		var checker = setInterval(function() {
			if ($quantity.is('.buttons_added')) {
				clearInterval(checker);

				$quantity.children('.plus').wrap('<span class="plus-wrap mpcth-color-main-background-hover">');
				$quantity.children('.minus').wrap('<span class="minus-wrap mpcth-color-main-background-hover">');
			}
		}, 50);
	}

	/* Update cart quantity inputs */
	if ($('body').is('.woocommerce-cart')) {
		$('.shop_table_wrap table.cart').on('click', '.plus, .minus', function() {
			var $button = $(this);
				$input = $button.parents('.quantity').find('.qty'),
				value = parseInt($input.val()) + ($button.is('.plus') ? 1 : -1);

			$('.shop_table_wrap .mpcth-mobile-cart').find('input[name="' + $input.attr('name') + '"]').val(value >= 0 ? value : 0);
		});
	}

	/* Sidebar height */
	$('.woocommerce-cart .shop_table_wrap').css('min-height', $('.woocommerce-cart .cart-sidebar').outerHeight() + 1);

	/* Display mini-cart */
	var $mini_cart = $('#mpcth_mini_cart');
	$('#mpcth_controls_wrap').on('mouseenter mouseleave', '#mpcth_cart, #mpcth_mini_cart', function(e) {
		if (e.type == 'mouseenter') {
			$mini_cart.stop(true, true).fadeIn();
		} else {
			$mini_cart.delay(400).fadeOut();
		}
	});

	/* Remove product from mini-cart */
	$mini_cart.on('click', '.mpcth-mini-cart-remove', function(e) {
		var $this = $(this);

		$.ajax($this.attr('href'), {
			complete: function() {
				location.reload(false);
			}
		});

		$this.parents('.mpcth-mini-cart-product').slideUp();

		e.preventDefault();
	});

	/* Refresh custom tabs */
	$('.single-product .woocommerce-tabs .tabs a').on('click', function() {
		$window.trigger('resize');
	});

	/* Added to cart icon */
	$('body').on('added_to_cart', function() {
		$('.mpcth-cart-wrap .added_to_cart').wrapInner('<span>').prepend('<i class="fa fa-fw fa-check"></i>');

		$('#mpcth_cart').addClass('active');
	});

	/* Wishlist icon */
	$('.mpcth-post-header .yith-wcwl-add-to-wishlist, .mpcth-post-thumbnail .yith-wcwl-add-to-wishlist').find('a').wrapInner('<div class="mpcth-tooltip-message mpcth-color-main-background mpcth-color-main-border">').prepend('<div class="mpcth-tooltip-text"><i class="fa fa-fw fa-star"></i></div>').wrapInner('<div class="mpcth-tooltip-wrap">');

	$('.mpcth-post-content .yith-wcwl-add-to-wishlist, .summary .yith-wcwl-add-to-wishlist').find('a').prepend('<i class="fa fa-fw fa-star"></i>');

	$window.on('quickview_loaded', function() {
		$('#jckqv .yith-wcwl-add-to-wishlist, .summary .yith-wcwl-add-to-wishlist').find('a').prepend('<i class="fa fa-fw fa-star"></i>');
	});

	/* Masonry layout */
	var $masonry_shop = $('.mpcth-masonry-shop #mpcth_content > .products');

	if ($masonry_shop.length) {
		$masonry_shop.imagesLoaded(function() {
			$masonry_shop.masonry({
				itemSelector: '.product'
			});

			$masonry_shop.children('.product').addClass('mpcth-product-fading').addClass('mpcth-product-added');
			setTimeout(function() {
				$masonry_shop.children('.product').removeClass('mpcth-product-fading')
			}, 300);
		});
	}

	/* Load more */
	var $load_more = $('#mpcth_shop_load_more'),
		$load_more_icon = $load_more.children('.mpcth-load-more-icon'),
		$load_more_pagination = $('.woocommerce-pagination .page-numbers'),
		$load_more_target = $('#mpcth_content .products'),
		$load_more_container = $('#mpcth_shop_load_more_wrapper');

	if($load_more.length) {
		var pages_current = $load_more_pagination.find('.page-numbers.current').text(),
			pages_total = $load_more_container.attr('data-max-pages'),
			pages_next_link = $load_more_pagination.find('.page-numbers.next').attr('href'),
			is_loading = false,
			can_pushState = typeof history.pushState === "function" ? true : false;

		function ajax_load_more(e) {
			if (! is_loading) {
				is_loading = true;

				$load_more.addClass('active');

				$load_more_container.load(pages_next_link + ' #mpcth_content .product', function() {
					var $loaded_posts = $load_more_container.children();

					$loaded_posts.appendTo($load_more_target);
					is_loading = false;

					$load_more.removeClass('active');

					$load_more.on('click', ajax_load_more);

					$load_more_target.imagesLoaded(function() {
						$masonry_shop.masonry('appended', $loaded_posts);
						$masonry_shop.children('.product').addClass('mpcth-product-added');

						$('.mpcth-post-header .yith-wcwl-add-to-wishlist, .mpcth-post-thumbnail .yith-wcwl-add-to-wishlist').find('a').html('<i class="fa fa-fw fa-star"></i>');
						$('.mpcth-post-header .yith-wcwl-add-to-wishlist, .mpcth-post-thumbnail .yith-wcwl-add-to-wishlist').find('.yith-wcwl-add-button a').html('<i class="fa fa-fw fa-star-o"></i>');
					});

					if(++pages_current < pages_total) {
						if(pages_next_link.indexOf('page/') != -1)
							pages_next_link = pages_next_link.replace(/page\/[0-9]+\//, 'page/' + (pages_current + 1) + '/');
						else
							pages_next_link = pages_next_link.replace(/paged=[0-9]+/, 'paged=' + (pages_current + 1));
					} else {
						$load_more.remove();
					}

					$window.trigger('loaded_more');
				});

			}

			e.preventDefault();
		}

		$load_more.on('click', ajax_load_more);
	}

/* ---------------------------------------------------------------- */
/* Quickview
/* ---------------------------------------------------------------- */
	$('body').on('jckqv_open', function(e) {
		default_function = $.magnificPopup.instance.st.callbacks.ajaxContentAdded;
		$.magnificPopup.instance.st.callbacks.ajaxContentAdded = function() {
			default_function();

			$('#jckqv_summary .onsale').wrap('<div class="mpcth-sale-wrap">');

			$window.trigger('quickview_loaded');
		}
	});

/* ---------------------------------------------------------------- */
/* Visual Composer
/* ---------------------------------------------------------------- */
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

/* ---------------------------------------------------------------- */
/* Contact Form 7
/* ---------------------------------------------------------------- */
	var $contact_form = $('.wpcf7-form');

	if ($contact_form.find('.contact-form-input').length) {
		$contact_form.find('label').each(function() {
			$(this).appendTo($(this).siblings('span'));
		});
	}

/* ---------------------------------------------------------------- */
/* Custom select
/* ---------------------------------------------------------------- */
	var $variations = $('.single-product .variations select'),
		$variations_form = $('.single-product .variations_form');

	$variations.customSelect({customClass: 'mpcthSelect'});

	$window.on('load', function() {
		$variations_form.on('woocommerce_variation_select_change', function() {
			$variations.trigger('update');
		});
	});

	$window.on('quickview_loaded', function() {
		$('#jckqv .variations select').customSelect({customClass: 'mpcthSelect'});
		$('#jckqv .variations_form').on('woocommerce_variation_select_change', function() {
			$('#jckqv .variations select').trigger('update');
		});
	});

	$('.page-template-template-portfolio-php #mpcth_portfolio_sorts .mpcth-portfolio-sort-select').customSelect({customClass: 'mpcthSelect'});
	$('.page-template-template-portfolio-php #mpcth_portfolio_sorts').addClass('mpcth-select-ready');
	$('.page-template-template-portfolio-php #mpcth_portfolio_filters .mpcth-portfolio-filter-select').customSelect({customClass: 'mpcthSelect'});
	$('.page-template-template-portfolio-php #mpcth_portfolio_filters').addClass('mpcth-select-ready');

	$('.woocommerce-page .woocommerce-ordering select').customSelect({customClass: 'mpcthSelect'});

	$('.woocommerce-page .shipping select').customSelect({customClass: 'mpcthSelect'});
	$window.on('updated_checkout', function() {
		$('.woocommerce-page .shipping select').customSelect({customClass: 'mpcthSelect'});
	});

	$('.widget select').customSelect({customClass: 'mpcthSelect'});

	$('#mpcth_secondary_menu .wcml_currency_switcher').customSelect({customClass: 'mpcthSelect'});

	$('#mpcth_smart_search_wrap select').customSelect({customClass: 'mpcthSelect'});
	$('#mpcth_smart_search_wrap').addClass('mpcth-search-ready');

	var $mpcth_custom_selects = $('.widget .mpcthSelect');
	$window.on('smart_resize', function() {
		$mpcth_custom_selects.trigger('update').prev('.hasCustomSelect').outerWidth($mpcth_custom_selects.outerWidth());
	});

/* ---------------------------------------------------------------- */
/* Comment form validation
/* ---------------------------------------------------------------- */
	function is_mail_valid(value) {
		// contributed by Scott Gonzalez: http://projects.scottsplayground.com/email_address_validation/
		return /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i.test(value);
	}

	function is_url_valid(value) {
		// contributed by Scott Gonzalez: http://projects.scottsplayground.com/iri/
		return /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(value);
	}

	var $comment_form = $('#mpcth_comment_form'),
		$input_author = $('#mpcth_comment_form_author'),
		$input_mail = $('#mpcth_comment_form_mail'),
		$input_url = $('#mpcth_comment_form_url'),
		$input_message = $('#mpcth_comment_form_message');

	if (typeof mpc_cf != 'undefined') {
		var default_author = mpc_cf.field_name,
			default_mail = mpc_cf.field_email,
			default_url = mpc_cf.field_url,
			default_message = mpc_cf.field_comment;
	} else {
		var default_author = default_mail = default_url = default_message = '';
	}

	$comment_form.on('focus', 'input, textarea', function() {
		$(this).removeClass('mpcth-input-invalid');
	});

	$comment_form.on('blur', 'input, textarea', function() {
		check_input($(this));
	});

	$comment_form.on('submit', function(e) {
		var is_form_valid = true;

		if(! check_input($input_author))
			is_form_valid = false;

		if(! check_input($input_mail))
			is_form_valid = false;

		if(! check_input($input_url))
			is_form_valid = false;

		if(! check_input($input_message))
			is_form_valid = false;

		if(! is_form_valid)
			e.preventDefault();
		else if($input_url.val() == default_url)
			$input_url.val('');
	});

	function check_input($input) {
		var is_valid = true,
			value = $input.val();

		if ($input.is('#mpcth_comment_form_author'))
			if (value == default_author || value.replace(' ', '') == '') {
				is_valid = false;
			} else if (value.length < 2) {
				is_valid = false;
				$input.addClass('mpcth-input-invalid');
			} else {
				$input.removeClass('mpcth-input-invalid');
			}

		else if ($input.is('#mpcth_comment_form_mail'))
			if (value == default_mail || value == '') {
				is_valid = false;
			} else if (! is_mail_valid(value) || value.length < 6) {
				is_valid = false;
				$input.addClass('mpcth-input-invalid');
			} else {
				$input.removeClass('mpcth-input-invalid');
			}

		else if ($input.is('#mpcth_comment_form_url'))
			if (value != '' && value != default_url && ! is_url_valid(value)) {
				is_valid = false;
				$input.addClass('mpcth-input-invalid');
			} else {
				$input.removeClass('mpcth-input-invalid');
			}

		else if ($input.is('#mpcth_comment_form_message'))
			if (value == default_message || value.replace(' ', '') == '') {
				is_valid = false;
			} else if (value.length < 5) {
				is_valid = false;
				$input.addClass('mpcth-input-invalid');
			} else {
				$input.removeClass('mpcth-input-invalid');
			}

		return is_valid;
	}
});