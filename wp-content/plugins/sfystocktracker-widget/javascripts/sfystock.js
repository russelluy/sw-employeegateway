jQuery(function($){
	$('#coda-slider-1').show();
	$('#coda-slider-1').codaSlider(
				{
					dynamicTabs: false, 
					dynamicArrows: false,
					autoHeight: false
				}
				);
	$("#ticker01").webTicker();
	$("#ticker02").webTicker();
	$("a#all_stocks").fancybox({
										'padding' : 10,
										'margin' : 20,
										'width'				: 230,
										'height'			: 390,
										'autoScale'     	: false,
										'transitionIn'		: 'none',
										'transitionOut'		: 'none',
										'type'				: 'iframe',
										'padding'			: '10'
									});
});