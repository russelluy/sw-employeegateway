jQuery(document).ready(function($){
// do stuff when DOM is ready
// You can safely use $ in this code block to reference jQuery
	var userId = $("#userid-value").attr("value");
	var userName = UserInfo.username;
	$("#greetingContainer1").text('Welcome ' + userName);
	/*
	$.ajax({
		type: "GET",
		url: "http://scvgdv38.safeway.com/employeegateway/wp-content/plugins/sfyuserinfo-widget/sfyuserinfo.php",
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
	});*/
});