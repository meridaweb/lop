(function($) {

	$(document).ready(function() {

		$('#archive').imagesLoaded( function() {
			$('#archive').masonry({
				itemSelector: '.content'
			});
		});

	});

})(jQuery);