(function($) {

	$(document).ready(function() {
		externalLinks();
		autoLightBox();

		$('.flexslider').flexslider({
			animation: "slide"
		});
        
        //Re-locate images to the left if they are big
        $('#archive img.aligncenter.size-full, .entry img.aligncenter.size-large').each(function() {
            if ( $(this).attr('width') >= 850 ) {
                $(this).css('margin-left', '-220px');
            }
        });

	});

	/**
	 * wordpress theme url
	 *
	 */
	function wpUrl(){
		return $('#cp-normalize-css').attr('href').replace(/\/assets\/css.*/,'');
	}

	/**
	 * External Link; New-Window Links in a Standards-Compliant W3C
	 */
	function externalLinks()
	{
		$("a[rel*=external]").each(function(i){
			this.target="_blank";
		});
	}

	/**
	 *	Adds lightbox to post images that are wrapped in a imagelink
	 *
	 *	Uses Fancybox 2
	 *
	 */
	function autoLightBox()
	{
		var include = '.entry img, .overlay-inner img';
		var gallery = '.entry .gallery img, .overlay-inner .gallery img';

		// check function
		if (! $.fn.fancybox)
			return;

		// single images
		$(include).not(gallery).click( function(e) {
			var link	= $(this).closest('a');
			var href	= $(link).attr('href');

			if ( link && href && href.match(/\.(jpg|jpeg|png|gif|bmp)/) ) {
				e.preventDefault();

				$.fancybox(link,{
					fitToView	: true, // fancybox 2
					padding     : 0,
					closeClick	: true,
					title		: false,
					helpers	: {
						overlay	: {
							opacity : 0.6,
							css : {
								'background-color' : '#000'
							}
						}
					}
				});
			}
		});

		// gallery images
		$(gallery).each( function(e){

			var id 		= $(this).closest('.gallery').attr('id');
			var link 	= $(this).closest('a').attr('rel', id).addClass('cp-' + id );

			$('.cp-' + id).fancybox({
				prevEffect	: 'fade',
				nextEffect	: 'fade',
				padding		: 0,
				closeClick	: true,
				helpers	: {
					title	: {
						type: 'outside'
					},
					overlay	: {
						opacity : 0.8,
						css : {
							'background-color' : '#000'
						}
					},
					thumbs	: {
						width	: 50,
						height	: 50
					}
				}
			});
		});
	}
})(jQuery);