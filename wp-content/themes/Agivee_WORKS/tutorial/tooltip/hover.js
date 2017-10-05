// JavaScript Document
jQuery(document).ready(function(){
		jQuery('#tooltip li, #tooltip2 li, #tooltip3 li, #tooltip4 li, #tooltip5 li, #tooltip6 li, #tooltip7 li, #tooltip8 li, #tooltip9 li, #tooltip10 li, #tooltip11 li, #tooltip12 li, #tooltip13 li').append('<span class="hover"></span>').each(function () {
	  		var jQueryspan = jQuery('> span.hover', this).css('opacity', 0);
	  		jQuery(this).hover(function () {
	    		jQueryspan.stop().fadeTo(300, 1);
	 		}, function () {
	   	jQueryspan.stop().fadeTo(300, 0);
	  		});
		});
	});