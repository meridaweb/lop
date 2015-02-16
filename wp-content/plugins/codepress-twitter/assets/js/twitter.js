(function($) {

	/** Fire when DOM is ready */
	$(document).ready( function(){

		codepress_fetch_tweets();
	});

	/** Fetch Tweets */
	function codepress_fetch_tweets() {

		setTimeout( codepress_fetch_tweets, 30 * 1000 ); // every 30 seconds

		$('.cp-tweets').each( function(){
			var container = $(this);
			var count = $(this).attr('data-count');

			$.ajax({
				url: cptw.ajaxurl,
				data: {
					action: 'codepress_get_tweets',
					usernames: $(this).attr('data-usernames'),
					search: $(this).attr('data-search'),
					favorites: $(this).attr('data-favorites'),
					count: count,
					is_empty: $('.cp-tweet', container).size()
				},
				type: 'post',
				dataType: 'html',
				success: function( html ){

					// success
					if ( html ) {

						container.prepend( html );

						$('.cp-tweet:gt(' + count + ')', container).remove();
					}

					// error message
					else {}
				}
			});
		});
	}

})(jQuery);
