// JavaScript Document

jQuery(document).ready(function(){
	jQuery("#tooltip4 li, #tooltip7 li, #tooltip13 li").hover(
		function(){
			var iconName = jQuery(this).find("li").attr("tooltip");
			jQuery(this).find("span.tool").attr({
				"style": 'display:inline'
			});
			jQuery(this).find("span.tool").animate({opacity: 1, right: "100%"}, {queue:false, duration:600});
		},
		function(){
			var iconName = jQuery(this).find("li").attr("tooltip");
			jQuery(this).find("span.tool").animate({opacity: 0, right: "90%"}, {queue:false, duration:600, complete: function(){
				
								jQuery(this).attr({"style": 'display:none'});
							}
						}
			);
		});
});