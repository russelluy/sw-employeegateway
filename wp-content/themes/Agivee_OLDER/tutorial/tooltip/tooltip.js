// JavaScript Document

jQuery(document).ready(function(){
	jQuery("#tooltip3 li, #tooltip5 li, #tooltip8 li, #tooltip11 li, #tooltip12 li").hover(
		function(){
			var iconName = jQuery(this).find("li").attr("tooltip");
			jQuery(this).find("span.tool").attr({
				"style": 'display:inline'
			});
			jQuery(this).find("span.tool").animate({opacity: 1, left: "90%"}, {queue:false, duration:600});
		},
		function(){
			var iconName = jQuery(this).find("li").attr("tooltip");
			jQuery(this).find("span.tool").animate({opacity: 0, left: "80%"}, {queue:false, duration:600, complete: function(){
				
								jQuery(this).attr({"style": 'display:none'});
							}
						}
			);
		});
});
