jQuery(document).ready(function(){
	var currentNivoSlide = 0;
	var totalNivoSlide = 0;
	jQuery('#f1').click(function(event) {
		jQuery('#fragment-1').show();
		jQuery('#fragment-2').hide();
		jQuery('#fragment-4').hide();
		event.preventDefault();

		  //alert('Handler for .click() called.');
	});
	jQuery('#f2').click(function(event) {
		jQuery('#fragment-1').hide();
		jQuery('#fragment-2').show();
		jQuery('#fragment-4').hide();
		event.preventDefault();
		  //alert('Handler for .click() called.');
	});
	jQuery('#f4').click(function(event) {
		jQuery('#fragment-1').hide();
		jQuery('#fragment-2').hide();
		jQuery('#fragment-4').show();
		event.preventDefault();
	  //alert('Handler for .click() called.');
	});
	jQuery("#link_featured").click(function(event) {
		event.preventDefault();
		jQuery("#w_news_featured").show();
		jQuery("#w_news_industry").hide();
		jQuery("#w_news_pharmacy").hide();
		//alert("Hello industry");
	});
	jQuery("#link_industry").click(function(event) {
		event.preventDefault();
		jQuery("#w_news_featured").hide();
		jQuery("#w_news_industry").show();
		jQuery("#w_news_pharmacy").hide();
		//alert("Hello industry");
	});
	jQuery("#link_pharmacy").click(function(event) {
		event.preventDefault();
		jQuery("#w_news_featured").hide();
		jQuery("#w_news_industry").hide();
		jQuery("#w_news_pharmacy").show();
		//alert("Hello pharmacy");
	});
	jQuery("#link_navi_gator").click(function(event) {
		event.preventDefault();
		$("#widget_navigator").show();
		$("#quickguide").show();
		$("#widget_about-me").hide();
		//alert("Hello industry");
	});
	jQuery("#link_about_me").click(function(event) {
		event.preventDefault();
		$("#widget_navigator").hide();
		$("#quickguide").hide();
		$("#widget_about-me").show();
		//alert("Hello pharmacy");
	});
	
	var userId = jQuery("#userid-value").attr("value");
	jQuery.ajax({
		type: "GET",
		url: document.URL + "/wp-content/plugins/sfyuserinfo-widget/sfyuserinfo.php",
		dataType: 'jsonp',
		data: {userid : userId},
		error: function(request, status) {
			// Do some error stuff
		},
		success: function(data, textStatus, jqXHR) {
			// Do some successful stuff
			//var property = data.user_name; 
			var userName = data.user_name;//UserInfo.username;
			$("#greetingContainer1").text('Welcome ' + userName);
		}
	});
	/*jQuery(".nivoSlider").click(function(event){
		 var kids = jQuery(this).children();
		totalNivoSlide = kids.size(); 
		$(kids[currentNivoSlide]).hide();  
		currentNivoSlide = (currentNivoSlide + 1) % totalNivoSlide;
		//alert(currentNivoSlide);
		$(kids[currentNivoSlide]).show();  

	});*/
	window.setInterval(function() {
    	toggle_nivo(); 
	}, 5000);

	function toggle_nivo(){
		 var kids = jQuery(".nivoSlider").children();
		totalNivoSlide = kids.size(); 
		$(kids[currentNivoSlide]).hide(); 
		var title = $(kids[currentNivoSlide]).attr("title");
		$(title).hide(); 
		currentNivoSlide = (currentNivoSlide + 1) % totalNivoSlide;
		//alert(currentNivoSlide);
		$(kids[currentNivoSlide]).show();  
		var title = $(kids[currentNivoSlide]).attr("title");
		$(title).show();

	}

});

