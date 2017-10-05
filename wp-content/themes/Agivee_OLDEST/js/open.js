function Area(){  
var page = document.myForm.Division[document.myForm.Division.selectedIndex].value;
var href = "" + page;
	if(href != ""){
		jQuery.fancybox({
			'padding' : 10,
			'margin' : 20,
			'width'				: 767,
			'height'			: 470,
			'autoScale'     	: false,
			'transitionIn'		: 'none',
			'transitionOut'		: 'none',
			'href'			: 	href,
			'type'				: 'iframe'
		});
	}
}
