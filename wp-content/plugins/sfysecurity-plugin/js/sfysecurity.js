jQuery(function ($) {
		/* You can safely use $ in this code block to reference jQuery */
		$(document).ready(function() {
			/*$('.popup_search').click(function(){
				alert('here');
			});*/
			$("a[rel=popup_search]").fancybox({
										'padding' : 5,
										'margin' : 5,
										'width'				: 600,
										'height'			: 400,
										'autoScale'     	: false,
										'transitionIn'		: 'none',
										'transitionOut'		: 'none',
										'type'				: 'iframe',
									});
		});
	});