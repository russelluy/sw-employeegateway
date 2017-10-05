/* 
THIS CODE IS CREATED BY THE FOLKS AT WEBSITEDESIGNERNC.COM 
GO VISIT FOR ALL YOUR PROGRAMMING AND WEB DESIGN NEEDS!
*/
var $jx = jQuery.noConflict();
$jx(document).ready(function() {
	
	if($jx("#jquiz1").get(0) && $jx("#jquiz2").get(0)){
		if(!Array.indexOf){
			Array.prototype.indexOf = function(obj){
				for(var i=0; i<this.length; i++){
					if(this[i]==obj){
						return i;
					}
				}
				return -1;
			}
		}
		
		var count = 0;	
		var howmanyquestions = $jx("#jquiz > li").length;
		
		var names = new Array();
		var links = new Array();
		
		var content1 = $jx("#jquiz1 li ul li.correct").html().split("#"); 
		var content2 = $jx("#jquiz2 li ul li.correct").html().split("#"); 
		names[0] = content1[0];
		names[1] = content2[0];
		links[0] = content1[1];
		links[1] = content2[1];
		
		$jx("#jquiz1 li ul li.correct").html(names[0]);
		$jx("#jquiz2 li ul li.correct").html(names[1]);
		
		$jx("#jquiz1 li ul li,#jquiz2 li ul li").click(function(){
			if (!($jx(this).parent("ul").hasClass("answered"))) {
				var selected_name = $jx(this).html();
				
				// removes unanswered class and adds answered class so they cannot change answer
				$jx(this).parent("ul").addClass("answered");
				
				// runs if they clicked the incorrect answer
				if (!($jx(this).hasClass("correct"))) {
					// puts strike-through wrong answer and makes their answer red for incorrect
					$jx(this).addClass("wronganswer");
					$jx(this).siblings(".correct").addClass("realanswer");
					// animate explanation & add styling depending on answer
					$jx(this).parent().parent().children("div").prepend('<p style="text-align:center">My name is not<br/>' + selected_name + '</p>');
					$jx(this).parent().parent().children("div").prepend('<p style="text-align:center">INCORRECT</p>');
					$jx(this).parent().parent().children("div").addClass("wrongbox");
					$jx(this).parent().parent().children("div").fadeTo(500, 1);
					$jx('.try_again').show();
				}
				
				// runs if they clicked the correct answer
				if ($jx(this).hasClass("correct")) {
					var selected_link = links[names.indexOf(selected_name)];
					//alert(selected_link);
					//adds one to quiz total correct tally
					count++;
					// makes correct answer green
					$jx(this).addClass("correctanswer");

					// animate explanation & add styling depending on answer
					$jx(this).parent().parent().children("div").prepend('<p style="text-align:center;color:#287AE3;">Click to view the bio of<br/>' + selected_name + '</p>');
					$jx(this).parent().parent().children("div").prepend('<p style="text-align:center;color:#287AE3;">CORRECT</p>');
					$jx(this).parent().parent().children("div").addClass("rightbox");
					
					// makes correct answer clickable
					$jx("div.rightbox").css("cursor","pointer").click(function(evt) {
						$jx.fancybox({
									'width': 640,
									'height': 250,
									'autoScale': true,
									'transitionIn': 'fade',
									'transitionOut': 'fade',
									'type': 'iframe',
									'href': selected_link
								});
					});
					
					$jx(this).parent().parent().children("div").fadeTo(750, 1);
				}
				
				if ($jx('ul.answered').length == howmanyquestions) {
					$jx('#jquizremarks').fadeIn('slow');
					$jx('#jquiztotal').html('You got a '+count+' out of '+howmanyquestions+' on the quiz.');
				}
			}
		});	
	}
	
	$jx("#jquiz-tryagain").click(function(){
			$jx('.try_again').hide();
			if (($jx("#jquiz1 > li > ul").hasClass("answered")) && ($jx("#jquiz1 > li > ul > li").hasClass("wronganswer"))){
				//alert("here");
				// removes answered class so they can again change
				$jx("#jquiz1 > li > ul").removeClass("answered");
				$jx("#jquiz1 > li > ul > li").removeClass("wronganswer");
				$jx("#jquiz1 > li > ul > li").removeClass("realanswer");
				$jx('#jquiz1 > li > .explanation > p').remove();
				$jx("#jquiz1 > li > .explanation").removeClass("wrongbox");
				$jx('#jquiz1 > li > .explanation').hide();
			}
			if (($jx("#jquiz2 > li > ul").hasClass("answered")) && ($jx("#jquiz2 > li > ul > li").hasClass("wronganswer"))){
				//alert("here");
				// removes answered class so they can again change
				$jx("#jquiz2 > li > ul").removeClass("answered");
				$jx("#jquiz2 > li > ul > li").removeClass("wronganswer");
				$jx("#jquiz2 > li > ul > li").removeClass("realanswer");
				$jx('#jquiz2 > li > .explanation > p').remove();
				$jx("#jquiz2 > li > .explanation").removeClass("wrongbox");
				$jx('#jquiz2 > li > .explanation').hide();
			}
	});
});