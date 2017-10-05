jQuery(function ($) {
		/* You can safely use $ in this code block to reference jQuery */
		$(document).ready(function() {
			// do stuff when DOM is ready
			$("#link_featured").click(function(event) {
				event.preventDefault();
				$("#w_news_featured").show();
				$("#w_news_industry").hide();
				$("#w_news_pharmacy").hide();
				//alert("Hello industry");
			});
			$("#link_industry").click(function(event) {
				event.preventDefault();
				$("#w_news_featured").hide();
				$("#w_news_industry").show();
				$("#w_news_pharmacy").hide();
				//alert("Hello industry");
			});
			$("#link_pharmacy").click(function(event) {
				event.preventDefault();
				$("#w_news_featured").hide();
				$("#w_news_industry").hide();
				$("#w_news_pharmacy").show();
				//alert("Hello pharmacy");
			});
			$("a[rel=more_link]").fancybox({
				'padding' : 10,
				'margin' : 20,
				'width'				: 850,
				'height'			: 450,
				'autoScale'     	: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe',
				'padding'			: '50'
			});
		});
	});