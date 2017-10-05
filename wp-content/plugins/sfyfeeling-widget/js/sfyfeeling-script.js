jQuery(document).ready(function($){
// do stuff when DOM is ready
// You can safely use $ in this code block to reference jQuery
	var emoID = MyAjax.lastemo;
	var userID = MyAjax.userid;
	//var init; 
	$("#feeling-image").attr("src",MyAjax.pluginurl + "imgs/emoticon" + emoID + ".jpg");
	//$("#feeling-image").attr("alt",""+emoID);
	$("#fi-value").attr("value",""+emoID);
	
	$( "#feelingform" ).dialog({
		autoOpen: false,
		show: "blind",
		hide: "blind",
		height: 'auto',
		width: 430,
		resizable: false,
		modal: true,
		buttons: {
			Ok: function() {
					//$("#feeling-image").attr("alt",""+$emoID);
					$("#fi-value").attr("value",""+$emoID);
					//alert(userID);
					jQuery.post(    
						// see tip #1 for how we declare global javascript variables    
						MyAjax.ajaxurl,    
						{        
						// here we declare the parameters to send along with the request        
						// this means the following action hooks will be fired:        
						// wp_ajax_nopriv_myajax-submit and wp_ajax_myajax-submit        
						action : 'myajax-submit',         
						// other parameters can be added along with "action"        
						emoID : $emoID,
						userID : userID
						},    
						function( response ) 
						{
						//alert( response['userId'] );
						}
					);
					$( this ).dialog( "close" );
			},
			Cancel: function() {
				$( this ).dialog( "close" );
			}
		},
		create: function(event, ui) { 
			$( "#slider" ).slider({
				orientation: "horizontal",
				value:emoID,
				disabled: false,
				min: 1,
				max: 10,
				step: 1,
				range: "min",
				slide: function( event, ui ) {
					$emoID = ui.value;
					$("#feeling-image").attr("src", MyAjax.pluginurl + "imgs/emoticon" + ui.value + ".jpg");
				}
			});
			$("#feeling-image").attr("src",MyAjax.pluginurl + "imgs/emoticon" + $( "#slider" ).slider( "value" ) + ".jpg");
		},
		close: function() {
			//add cleanup code if necessary
			var tmp = $("#fi-value").attr("value");//$("#feeling-image").attr("alt");
			$("#feeling-image").attr("src",MyAjax.pluginurl + "imgs/emoticon" + tmp + ".jpg");
			$( "#slider" ).slider("value",tmp);
		}
	});
	
	$("#link_feeling").click(function(event) {
		event.preventDefault();
		//var position =  $("#feeling_widget").position();
		var pos_left = 368 - $(window).scrollLeft();
		var pos_top = 960 - $(window).scrollTop();
		$("#feelingform").dialog("option", "position", [pos_left,pos_top ]);					
		//$("#feelingform").dialog('widget').position({ my: 'left top', at: 'left bottom', of: $("#feeling_widget")});
		$("#feelingform").dialog("open");
		//alert(x + ' : ' + y);
		//alert("scroll " + );
		
	});
});