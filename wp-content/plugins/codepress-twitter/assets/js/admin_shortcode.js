(function($) {

	/** Fire when DOM is ready */
	$(document).ready( function(){

		cptw_shortcode();

	});

	/**
	 * Send shortcode to editor
	 *
	 */
	function cptw_shortcode() {

		$('#cptw-insert-shortcode').live('click', function(e) {

			console.log( $(this) );

			var usernames	= '';
			var search		= '';
			var favorites	= '';
			var count		= 5;

			if ( $('#twitter_usernames').val() ) {
				usernames = ' usernames="' + $('#twitter_usernames').val() + '"';
			}

			if ( $('#twitter_search').val() ) {
				search = ' search="' + $('#twitter_search').val() + '"';
			}

			if ( $('#twitter_favorites').val() ) {
				favorites = ' favorites="' + $('#twitter_favorites').val() + '"';
			}

			if ( $('#twitter_count').val() ) {
				count = ' count="' + $('#twitter_count').val() + '"';
			}

			var shortcode = '[fetch_tweets' + usernames + search + favorites + count + ']';

			// fields are all empty
			if ( !usernames && !search && !favorites ) {
				shortcode = '';
			}

			window.send_to_editor( shortcode );

			e.preventDefault();
			return false;
		});
	}


})(jQuery);