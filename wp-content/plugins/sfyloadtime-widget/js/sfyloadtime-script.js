jQuery(window).load(function(){
	var lTime = jQuery('#footer_loadtime').attr("value");
	//calculate the current time in afterload
	afterload = (new Date()).getTime();
	// now use the beforeload and afterload to calculate the seconds
	seconds = 0;
	if(typeof beforeload != 'undefined'){
		seconds = (afterload-beforeload)/1000;
	}
	jQuery('#browser_load').replaceWith('<b>' + seconds + '</b>');
	jQuery.post(    
						// see tip #1 for how we declare global javascript variables    
						LoadTime.ajaxurl,    
						{        
						// here we declare the parameters to send along with the request        
						// this means the following action hooks will be fired:        
						// wp_ajax_nopriv_loadtime-submit and wp_ajax_loadtime-submit        
						action : 'loadtime-submit',         
						// other parameters can be added along with "action"        
						loadTime : lTime,
						bLoadTime : seconds,
						location : UserInfo.location,
						userId : UserInfo.userid
						},    
						function( response ) 
						{
						}
				);
});