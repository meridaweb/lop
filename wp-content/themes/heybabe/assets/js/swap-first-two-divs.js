(function($) {

	$(document).ready(function() {

		// Swap first div with second div before masonry so the page content gets in second place and gets gridded right.
		$(".content:first-child").before($(".content:nth-child(2)"));

	});

})(jQuery);