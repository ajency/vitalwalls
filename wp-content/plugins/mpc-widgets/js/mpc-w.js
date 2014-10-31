jQuery(document).ready(function($) {
/* ---------------------------------------------------------------- */
/* Twitter widget
/* ---------------------------------------------------------------- */
	var $twitterWidgets = $('.mpc-w-twitter-wrap');

	$twitterWidgets.each(function() {
		var $this = $(this);

		if(!$this.is('.mpc-w-twitter-cached')) {
			var unique = $this.attr('data-unique'),
				id = $this.attr('data-id'),
				number = $this.attr('data-number'),
				src = document.createElement('script');

			mpcthFetcher['callback_' + unique] = function(data) {
				var $body = $('<div>').html(data.body),
					$tweets = $body.find('.stream .h-feed .tweet').slice(0, number);

				$tweets.each(function() {
					var $tweet = $(this),
						$time = $tweet.find('a.permalink'),
						$author = $tweet.find('div.header'),
						$content = $tweet.find('div.e-entry-content'),
						$detail = $tweet.find('div.detail-expander'),
						$footer = $tweet.find('div.footer');

					$tweet.append($time);

					$detail.remove();

					$footer.remove();

					$author.find('span.verified').remove();
				})

				$tweets.last().addClass('last');

				$('#mpc_w_twitter_' + unique).append($tweets);

				$.post(ajaxurl, {
					action: 'mpc_w_cache_twitter',
					tweets: encodeURIComponent($('#mpc_w_twitter_' + unique).html()),
					id: id,
					number: number
				});
			}

			src.type = 'text/javascript';
			src.src = '//cdn.syndication.twimg.com/widgets/timelines/' + id + '?&lang=en&callback=mpcthFetcher.callback_' + unique + '&suppress_response_codes=true';
			document.getElementsByTagName('head')[0].appendChild(src);
		}
	});

});

var mpcthFetcher = {};