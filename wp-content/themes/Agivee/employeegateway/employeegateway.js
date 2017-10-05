			var offsetY = 0;
			 jQuery.each(jQuery.browser, function(i, val) {
      				if(i == 'mozilla'){offsetY = -240;}
				else if(i == 'msie' && val < 8){offsetY = 0;}
    			});    
			jQuery(function ($) {
		/* You can safely use $ in this code block to reference jQuery */
				$(document).ready(function() {
					// do stuff when DOM is ready
					$("#link_navi_gator").click(function(event) {
						event.preventDefault();
						$("#widget_navigator").show();
						$("#quickguide").show();
						$("#widget_about-me").hide();
						//alert("Hello industry");
					});
					$("#link_about_me").click(function(event) {
						event.preventDefault();
						$("#widget_navigator").hide();
						$("#quickguide").hide();
						$("#widget_about-me").show();
                        $("#widget_archive").hide();
						//alert("Hello pharmacy");
					});
                    $("a#link_archive").fancybox({
						'padding' : 10,
						'margin' : 20,
						'width'				: 700,
						'height'			: 650,
						'autoScale'     	: false,
						'transitionIn'		: 'none',
						'transitionOut'		: 'none',
						'type'				: 'iframe'
					});
					$("a#request_plus_featuredfocus").fancybox({
						'padding' : 10,
						'margin' : 20,
						'width'				: 700,
						'height'			: 650,
						'autoScale'     	: false,
						'transitionIn'		: 'none',
						'transitionOut'		: 'none',
						'type'				: 'iframe'
					});
					$("a#request_plus_featuredpromotions").fancybox({
						'padding' : 10,
						'margin' : 20,
						'width'				: 700,
						'height'			: 650,
						'autoScale'     	: false,
						'transitionIn'		: 'none',
						'transitionOut'		: 'none',
						'type'				: 'iframe'
					});
					$("a#request_plus_news").fancybox({
						'padding' : 10,
						'margin' : 20,
						'width'				: 700,
						'height'			: 650,
						'autoScale'     	: false,
						'transitionIn'		: 'none',
						'transitionOut'		: 'none',
						'type'				: 'iframe'
					});
					$("a#learnlets").fancybox({
						'padding' : 10,
						'margin' : 20,
						'width'				: 930,
						'height'			: 650,
						'autoScale'     	: false,
						'transitionIn'		: 'none',
						'transitionOut'		: 'none',
						'type'				: 'iframe'
					});
					$("a#link_qtw_comment").fancybox({
						'padding' : 10,
						'margin' : 20,
						'width'				: 700,
						'height'			: 650,
						'autoScale'     	: false,
						'transitionIn'		: 'none',
						'transitionOut'		: 'none',
						'type'				: 'iframe'
					});
					$("a#requestplus_ques_week").fancybox({
						'padding' : 10,
						'margin' : 20,
						'width'				: 700,
						'height'			: 650,
						'autoScale'     	: false,
						'transitionIn'		: 'none',
						'transitionOut'		: 'none',
						'type'				: 'iframe'
					});
					$("a#safeway_advertisement").fancybox({
						'padding' : 10,
						'margin' : 20,
						'width'				: 767,
						'height'			: 370,
						'autoScale'     	: false,
						'transitionIn'		: 'none',
						'transitionOut'		: 'none',
						'type'				: 'iframe'
					});
					$("a#poll-answer").live("click", function(event){
						$.fancybox({
							'padding' : 10,
							'margin' : 20,
							'width'				: 753,
							'height'			: 600,
							'autoScale'     	: false,
							'transitionIn'		: 'none',
							'transitionOut'		: 'none',
							'href'			: 	this.href,
							'type'				: 'iframe'
						});
						event.preventDefault();
					});
					
					$("a#safeway_sites").fancybox({
						'padding' : 10,
						'margin' : 20,
						'width'				: 340,
						'height'			: 235,
						'autoScale'     	: false,
						'transitionIn'		: 'none',
						'transitionOut'		: 'none',
						'type'				: 'iframe'
					});
					$("a#safeway_about").fancybox({
						'padding' : 10,
						'margin' : 20,
						'width'				: 767,
						'height'			: 320,
						'autoScale'     	: false,
						'transitionIn'		: 'none',
						'transitionOut'		: 'none',
						'type'				: 'iframe'
					});
					$("a#noticesfloat").fancybox({
						'padding' : 10,
						'margin' : 20,
						'width'				: 750,
						'height'			: 450,
						'autoScale'     	: false,
						'transitionIn'		: 'none',
						'transitionOut'		: 'none',
						'type'				: 'iframe'
					});
					$("a.menufloat").fancybox({
						'padding' : 10,
						'margin' : 20,
						'width'				: 800,
						'height'			: 450,
						'autoScale'     	: false,
						'transitionIn'		: 'none',
						'transitionOut'		: 'none',
						'type'				: 'iframe'
					});
					$("a.guidefloat").fancybox({
						'padding' : 10,
						'margin' : 20,
						'width'				: 914,
						'height'			: 589,
						'autoScale'     	: false,
						'transitionIn'		: 'none',
						'transitionOut'		: 'none',
						'type'				: 'iframe'
					});
					$("a#mission_vision").fancybox({
						'padding' : 10,
						'margin' : 20,
						'width'				: 970,
						'height'			: 589,
						'autoScale'     	: false,
						'transitionIn'		: 'none',
						'transitionOut'		: 'none',
						'type'				: 'iframe'
					});
					$("a#link-directory").fancybox({
						'padding' : 10,
						'margin' : 20,
						'width'				: 970,
						'height'			: 589,
						'autoScale'     	: false,
						'transitionIn'		: 'none',
						'transitionOut'		: 'none',
						'type'				: 'iframe'
					});
                    $("a.more_archive").fancybox({
						'padding' : 10,
						'margin' : 20,
						'width'				: 700,
						'height'			: 650,
						'autoScale'     	: false,
						'transitionIn'		: 'none',
						'transitionOut'		: 'none',
						'type'				: 'iframe'
					});
					/*$("a#quickguide").fancybox({
						'padding' : 0,
						'margin' : 0,
						'width'				: 980,
						'height'			: 1200,
						'autoScale'     	: false,
						'transitionIn'		: 'none',
						'transitionOut'		: 'none',
						'type'				: 'iframe',
						 onComplete : function() {
								$('#fancybox-outer').css('opacity', '0.6');
						},
						onClosed : function(){
							$('#fancybox-outer').css('opacity', '1');
						}
					});*/
					/*$(".fa_bot a[title]").tooltip({
						// tweak the position
						position: "top center",
						offset : [233,offsetY],
						onBeforeShow : function(e1,e2){
							//alert(offsetY);
							var blogurl =  'https://' + document.domain + '/employeegateway/wp-content/services/fftb/blogdata/blog.html';
							//alert(document.domain);
							$.get(blogurl, 
							function(data) {
								$('#link_fftb').data('tooltip').getTip().html(data) ;
							});
						}
					});*/
				});
			});

