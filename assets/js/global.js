// Prevent delete button to send user to previous browser page
$(document).unbind('keydown').bind('keydown', function (event) {
    var doPrevent = false;
    if (event.keyCode === 8) {
        var d = event.srcElement || event.target;
        if ((d.tagName.toUpperCase() === 'INPUT' && (d.type.toUpperCase() === 'TEXT' || d.type.toUpperCase() === 'PASSWORD')) 
             || d.tagName.toUpperCase() === 'TEXTAREA') {
            doPrevent = d.readOnly || d.disabled;
        }
        else {
            doPrevent = true;
        }
    }

    if (doPrevent) {
        event.preventDefault();
    }
});



// Using jQuery for front-end functionalities
$(document).ready(function(){
	
	// Determine current page
	var currentPage = $('div#container div').eq(0).attr('id');
		

	// Default cursor location
	if(currentPage == 'login' || currentPage == 'signup' || currentPage == 'reset' || currentPage == 'forgot'){
		$('input#email').focus();
		$('#header_login').hide(); // hide login link
		$('#header_icon, #header_email').hide(); // show profile navigation
	};
	
	// Customize header elements based on current page
	if(currentPage == 'profile'){
		$('#header_login').hide(); // hide login link
		$('#header_icon, #header_email').show(); // show profile navigation

		//mouseover on company tiles
		$('div#profile li').mouseenter(function() {
			$(this).find('img.photo').hide();
			$(this).find('div.fit').slideDown(50);
			$(this).find('img.logo').show();
		}).mouseleave(function(){
			$(this).find('img.photo').show();
			$(this).find('div.fit').hide();
			$(this).find('img.logo').hide();
		});
	};
	
	if(currentPage == 'company'){
		$('#header_login').hide(); // hide login link
		$('#header_icon, #header_email').show(); // show profile navigation

		var $container = $('#tiles');
		// initialize isotope
		$container.isotope({
			masonry: {
				columnWidth: 200,
			}
		});

		// filter items when filter link is clicked
		$('#filters a').click(function(){
			var selector = $(this).attr('data-filter');
			$container.isotope({ filter: selector });
			return false;
		});
		
		 $container.on('click', '.smallHighlight', function(){
			$('#profile img.smallTile.bigTile').removeClass('bigTile');
			$(this).toggleClass('bigTile');
			$(this).find('div').toggleClass('bigContent');
			$(this).find('img').toggle();
			if ($(this).find('img').eq(1).hasClass('smallPic')){
				$(this).find('img').eq(1).switchClass('smallPic','bigPic',100);
			}else{
				$(this).find('img').eq(1).switchClass('bigPic','smallPic',100);
			};
			$container.isotope('reLayout');
		}); 
		
	};

	//Close Modal and Fade Layer	
	$(document).on("click", "#fade, a.close, #transparent_fade", function() {
		$('#fade , .modal_popup, #modal_settings, #transparent_fade').fadeOut(function() {
			$('#fade, a.close, #transparent_fade').remove();
		});
		return false;
	});
	
	// Homepage animation
	$('#start').delay(500).animate({ opacity: 1, left: "0px" }, 500);
	$('#icon').delay(500).animate({ opacity: 1, top: "-=10px" }, 500);
	$("#start a").hover(
		function () {
		$(this).animate({backgroundColor: '#ad27c1'}, 200);
		},
		function () {
		$(this).animate({backgroundColor: '#e9b60b'}, 200);
		}
	);	
	
	// Uncheck all checkboxes
	$("input[type='checkbox']").each(function() {      
		$(this).prop('checked', false);
	 });
	
	// Display questionnaire	 
	if(currentPage == 'criteria'){
		
		$('#header_login, #footer, #progressBar').hide();
		
		//Activiate form submit button
		$('div#show_preview').click(function(){
			$('form#criteria').submit();
		});

		// Hover animation for next button
		$("div#next_question, div#show_preview").hover(
			function () {
				$('div#next_question .next, div#show_preview .next').animate({backgroundColor: '#27c339', color:'#fff'}, 200);
				$('div#next_question .arrow, div#show_preview .arrow').animate({borderLeftColor: '#27c339'}, 200);
			},
			function () {
				$('div#next_question .next, div#show_preview .next').animate({backgroundColor: '#e9b60b', color:'#364954'}, 200);
				$('div#next_question .arrow, div#show_preview .arrow').animate({borderLeftColor: '#e9b60b'}, 200);
			}
		);
			
		// Set variables for pagination 
		var currentQuestion = 0;
		var lastEmpty = 1;
		var lastQuestion = 1;
		$('div#0, #next_question').show(); //default to first question on refresh

		// Assign actions when next is clicked
		$('#next_question').click(function(){
			$('div#progressBar').show();
			$('div.hints, div.hints div').hide();
			
			// Update progress bar
			if(currentQuestion>=1){
				$('#progressBar li').eq(currentQuestion-1).removeClass().addClass('progress filled');
				$('#progressBar li').eq(currentQuestion).removeClass().addClass('progress ip');
			}
			
			// Show next question
			$('div.questions').hide();
			currentQuestion = currentQuestion + 1;
			if (currentQuestion > lastQuestion){lastQuestion = currentQuestion;};
			questionType = $('div#'+currentQuestion).attr("name");
			if(questionType){$('div.hints, div#'+questionType).show();};
			$('div#'+currentQuestion).show();
			if ((currentQuestion == 20)&&($('input[name=q20]').val()!=0)){
				$('#next_question').hide();
				$('#show_preview').show();
			}else{
				$('#next_question').hide();
				// Determine type of questions
				questionType = $('div#'+currentQuestion).find('input').attr('type');
				if (questionType == "checkbox"){
					lastEmpty = showNextButtonCheckbox(currentQuestion, lastEmpty);
				};
				if (questionType == "text"){
					lastEmpty = showNextButton(currentQuestion, lastEmpty);
				};
			};
		});
		
		// Assign actions for the progress bar
		$('li.progress').click(function(){
			if ((lastQuestion >= (1+$(this).index()))&&(lastEmpty >=(1+$(this).index()))){
				// Hide preview button
				$('div#show_preview').hide();
				$('div.hints, div.hints div').hide();
				
				// Update progress bar
				$('#progressBar li').eq(currentQuestion-1).removeClass().addClass('progress filled');
				$(this).removeClass().addClass('progress ip');
				
				//Show current question
				currentQuestion = 1+$(this).index();
				$('div.questions').hide();
				questionType = $('div#'+currentQuestion).attr("name");
				if(questionType){$('div.hints, div#'+questionType).show();};
				$('div#'+currentQuestion).show();
				if ((currentQuestion == 20)&&($('input[name=q20]').val()!=0)){
					$('#next_question').hide();
					$('#show_preview').show();
				}else{
					if (questionType == "checkbox"){
						lastEmpty = showNextButtonCheckbox(currentQuestion, lastEmpty);
					};
					if (questionType == "text"){
						lastEmpty = showNextButton(currentQuestion, lastEmpty);
					};
					if(currentQuestion == 19){showNextButtonDropdown($('.chosenCities li').length, lastEmpty);};
				};
			};
		});
			
		// Q1 - Company type
		$('#co_type li').click(function () {
			var selected = $(this).attr('id');  // get id of selected choice
			$(this).toggleClass('coTypeSelected'); // mark selected choice		
			if ($(this).hasClass('coTypeSelected')){
				$('input[id='+selected+'_0]').prop('checked', true);
			}else{
				$('input[id='+selected+'_0]').prop('checked', false);
			};
			lastEmpty = showNextButtonCheckbox(1, lastEmpty);
		});

		// Q2 - Company pace
		$('#co_pace li').click(function () {
			var selected = $(this).attr('id');  // get id of selected choice
			
			if(selected == 'q2_1'){
				if($('li#q2_1').hasClass('selected')){
					$('li#q2_1').removeClass('selected');
					$('li#q2_1').css('background-position','-0px 0px');
					$('input[id='+selected+'_0]').prop('checked', false);
				}else{
					$('li#q2_1').addClass('selected');
					$('li#q2_1').css('background-position','-360px 0px');
					$('input[id='+selected+'_0]').prop('checked', true);
				};
			};
			if(selected == 'q2_2'){
				if($('li#q2_2').hasClass('selected')){
					$('li#q2_2').removeClass('selected');
					$('li#q2_2').css('background-position','-120px 0px');
					$('input[id='+selected+'_0]').prop('checked', false);
				}else{
					$('li#q2_2').addClass('selected');
					$('li#q2_2').css('background-position','-480px 0px');
					$('input[id='+selected+'_0]').prop('checked', true);
				};
			};
			if(selected == 'q2_3'){
				if($('li#q2_3').hasClass('selected')){
					$('li#q2_3').removeClass('selected');
					$('li#q2_3').css('background-position','-240px 0px');
					$('input[id='+selected+'_0]').prop('checked', false);
				}else{
					$('li#q2_3').addClass('selected');
					$('li#q2_3').css('background-position','-600px 0px');
					$('input[id='+selected+'_0]').prop('checked', true);
				};
			};
			lastEmpty = showNextButtonCheckbox(2, lastEmpty);
		});
		
		// Q3 - Company cycle
		$('#co_cycle li').click(function () {
			var selected = $(this).attr('id');  // get id of selected choice
			$(this).toggleClass('coCycleSelected'); // mark selected choice		
			if ($(this).hasClass('coCycleSelected')){
				$('input[id='+selected+'_0]').prop('checked', true);
			}else{
				$('input[id='+selected+'_0]').prop('checked', false);
			};			
			lastEmpty = showNextButtonCheckbox(3, lastEmpty);
		});
		
		// Q4 - Company benefits
		$('#co_benefits').sortable({
			placeholder: "benefits_placeholder",
			revert: true,
			create: function( event, ui ) { // initialize ranking
				var count = $("#co_benefits li").length;
				for (var i=0;i<count;i++)
				{
					sortID = $('#co_benefits').find('li:eq('+i+')').attr("id");
					$('input[id='+sortID+'_0]').val(count-i);
				}
			},
			start: function( event, ui ) {
				$("div#q4_flag").text(1);
				lastEmpty = showNextButton(4, lastEmpty);
			},
			stop: function( event, ui ) {
				var count = $("#co_benefits li").length;
				for (var i=0;i<count;i++)
				{
					sortID = $('#co_benefits').find('li:eq('+i+')').attr("id");
					$('input[id='+sortID+'_0]').val(count-i);
				}
			}
		});
		$('#co_benefits').disableSelection();
		
		// Q5 - Company citizenship
		$('#citizenshipSlider').slider({
			animate: true,
			min: 1,
			max: 5,
			value: 1,
			create: function( event, ui ) { // reset choices
				$('input[id=q5_0]').val(1);
			},
			change: function(event, ui){
				$('div#citizenshipSlider a').addClass('sliderActive');
				$("div#q5_flag").text(1);
				switch(ui.value)
				{
				case 1:
					$('div#5 .sliderSelected').html("Not Important");
					$('input[id=q5_0]').val(1);
					break;
				case 2:
					$('div#5 .sliderSelected').html("Somewhat Important");
					$('input[id=q5_0]').val(2);
					break;
				case 3:
					$('div#5 .sliderSelected').html("Important");
					$('input[id=q5_0]').val(3);
					break;
				case 4:
					$('div#5 .sliderSelected').html("Very Important");
					$('input[id=q5_0]').val(4);
					break;
				case 5:
					$('div#5 .sliderSelected').html("Extremely Important");
					$('input[id=q5_0]').val(5);
					break;
				default:
					$('div#5 .sliderSelected').html("Not Important");
					break;
				};
				lastEmpty = showNextButton(5, lastEmpty);
			}
		});
		
		// Q6 - Work travel
		$( '#travelSlider').slider({
			animate: true,
			min: 1,
			max: 5,
			value: 1,
			create: function( event, ui ) { // reset choices
				$('input[id=q6_0]').val(1);
			},
			change: function(event, ui){
				$('#travelSlider a').addClass('sliderActive');
				$("div#q6_flag").text(1);
				switch(ui.value)
				{
				case 1:
					$('div#6 .sliderSelected').html("No Travel");
					$('input[id=q6_0]').val(1);
					break;
				case 2:
					$('div#6 .sliderSelected').html("Seldom Travel");
					$('input[id=q6_0]').val(2);
					break;					
				case 3:
					$('div#6 .sliderSelected').html("Little Travel");
					$('input[id=q6_0]').val(3);
					break;
				case 4:
					$('div#6 .sliderSelected').html("Some Travel");
					$('input[id=q6_0]').val(4);
					break;
				case 5:
					$('div#6 .sliderSelected').html("Frequent Travel");
					$('input[id=q6_0]').val(5);
					break;
				default:
					$('div#6 .sliderSelected').html("No Travel");
					break;
				};
				lastEmpty = showNextButton(6, lastEmpty);
			}
		});
		
		//Q7 - Role variety
		$( '#roleSlider').slider({
			animate: true,
			min: 1,
			max: 4,
			value: 1,
			create: function( event, ui ) { // reset choices
				$('input[id=q7_0]').val(1);
			},			
			change: function(event, ui){
				$('#roleSlider a').addClass('sliderActive');
				$("div#q7_flag").text(1);
				switch(ui.value)
				{
				case 1:
					$('div#7 .sliderSelected').html("Seldom");
					$('input[id=q7_0]').val(1);
					break;
				case 2:
					$('div#7 .sliderSelected').html("Occasionally");
					$('input[id=q7_0]').val(2);
					break;
				case 3:
					$('div#7 .sliderSelected').html("Frequent");
					$('input[id=q7_0]').val(3);
					break;
				case 4:
					$('div#7 .sliderSelected').html("Always");
					$('input[id=q7_0]').val(4);
					break;
				default:
					$('div#7 .sliderSelected').html("Seldom");
					break;
				};
				lastEmpty = showNextButton(7, lastEmpty);
			}
		});
		
		// Q8 - Promotion criteria
		$('#co_promotion').sortable({
			placeholder: "sort6_placeholder",
			revert: true,
			create: function( event, ui ) { // initialize ranking
				var count = $("#co_promotion li").length;
				for (var i=0;i<count;i++)
				{
					sortID = $('#co_promotion').find('li:eq('+i+')').attr("id");
					$('input[id='+sortID+'_0]').val(count-i);
				}
			},
			start: function( event, ui ) {
				$("div#q8_flag").text(1);
				lastEmpty = showNextButton(8, lastEmpty);
			},
			stop: function( event, ui ) {
				var count = $("#co_promotion li").length;
				for (var i=0;i<count;i++)
				{
					sortID = $('#co_promotion').find('li:eq('+i+')').attr("id");
					$('input[id='+sortID+'_0]').val(count-i);
				}
			}
		});
		$('#co_promotion').disableSelection();
		
		// Q9 - Work environment
		var currentEnvQuestion = 1;
		var envComplete = 0;
		var progressBackground = 0;
		$('div.env:eq('+(currentEnvQuestion-1)+')').show();
		
		$('div.envAnswer1, div.envAnswer2').click(function () {
			var inputName = $(this).attr('id');
			if ($(this).hasClass('envAnswer1')){
				$(this).addClass('selected');
				$('input[id='+inputName+'_0]').prop('checked', true);
				removeCheckmark = $(this).parent().children('div.envAnswer2').attr('id');
				$('input[id='+removeCheckmark+'_0]').prop('checked', false);
				$(this).parent().children('div.envAnswer2').removeClass('selected');
			};
			if ($(this).hasClass('envAnswer2')){
				$(this).addClass('selected');
				$('input[id='+inputName+'_0]').prop('checked', true);
				removeCheckmark = $(this).parent().children('div.envAnswer1').attr('id');
				$('input[id='+removeCheckmark+'_0]').prop('checked', false);
				$(this).parent().children('div.envAnswer1').removeClass('selected');
			};

			//update progress bar
			if (envComplete == 0){
				progressBackground = (currentEnvQuestion) * -127;
				$('#envProgressOverlay').css("background-position", progressBackground+"px 0px");
				$('map#environmentMap area').eq(currentEnvQuestion-1).addClass('block');
			} else {
				if (currentEnvQuestion < 10){
					progressBackground = (currentEnvQuestion+1) * -127;
					$('#envProgressOverlay').css("background-position", progressBackground+"px 0px");
					$('map#environmentMap area').eq(currentEnvQuestion).addClass('block');
				};
			};
			
			//update next subquestion
			if (currentEnvQuestion < 10){
				$('div.env:eq('+(currentEnvQuestion-1)+')').delay(50).animate({opacity: 0, marginLeft:'300px'},50).hide(50);
				currentEnvQuestion = currentEnvQuestion + 1;
				$('div.env:eq('+(currentEnvQuestion-1)+')').delay(80).animate({opacity: 1, marginLeft:'149px'},80).show(80);
			};
			
			//check for next button
			var nextEnvFlag = 0;
			if ($('div#9 input:checked').length==10){
				nextEnvFlag=1;
			};
			 
			if (nextEnvFlag == 1){$('#next_question').show(); $('map#environmentMap area').attr('href','#');}else{$('#next_question').hide(); lastEmpty = 9;};
			
		});
		
		// Activating image map
		$("map#environmentMap area").click(function(){			
			if(($(this).index()+1)<=$('div#9 input:checked').length){
				envComplete = 1;
				$('div.env:eq('+(currentEnvQuestion-1)+')').delay(50).animate({opacity: 0, marginLeft:'300px'},50).hide(50);
				currentEnvQuestion = $(this).index()+1; // assign the current environment question to the associated map index
				progressBackground = (currentEnvQuestion) * -127;
				$('#envProgressOverlay').css("background-position", progressBackground+"px 0px");
				$('div.env:eq('+(currentEnvQuestion-1)+')').delay(80).animate({opacity: 1, marginLeft:'149px'},80).show(80);
			}
		});
		
		// Q10 - Recognition
		$('#co_recognition').sortable({
			placeholder: "sort6_placeholder",
			revert: true,
			create: function( event, ui ) { // initialize ranking
				var count = $("#co_recognition li").length;
				for (var i=0;i<count;i++)
				{
					sortID = $('#co_recognition').find('li:eq('+i+')').attr("id");
					$('input[id='+sortID+'_0]').val(count-i);
				}
			},
			start: function( event, ui ) {
				$("div#q10_flag").text(1);
				lastEmpty = showNextButton(10, lastEmpty);
			},
			stop: function( event, ui ) {
				var count = $("#co_recognition li").length;
				for (var i=0;i<count;i++)
				{
					sortID = $('#co_recognition').find('li:eq('+i+')').attr("id");
					$('input[id='+sortID+'_0]').val(count-i);
				}
			}
		});
		$('#co_recognition').disableSelection();
		
		// Q11 - Favorite tasks
		$('#favTask').sortable({
			placeholder: "task_placeholder",
			revert: true,
			create: function( event, ui ) { // initialize ranking
				var count = $("#favTask li").length;
				for (var i=0;i<count;i++)
				{
					sortID = $('#favTask').find('li:eq('+i+')').attr("id");
					$('input[id='+sortID+'_0]').val(count-i);
				}
			},
			start: function( event, ui ) {
				$("div#q11_flag").text(1);
				lastEmpty = showNextButton(11, lastEmpty);
			},
			stop: function( event, ui ) {
				var count = $("#favTask li").length;
				for (var i=0;i<count;i++)
				{
					sortID = $('#favTask').find('li:eq('+i+')').attr("id");
					$('input[id='+sortID+'_0]').val(count-i);
				}
			}
		});
		$('#favTask').disableSelection();
		
		// Q12 - Communications
		$("input[id=q12_0]").val("");
		$("map#communicationCloud area").click(function(){
			$('#communications img').css("background-position", "0px "+(-390*($(this).index()+1))+"px");
			$('input[id=q12_0]').val($(this).index()+1);
			$("div#q12_flag").text(1);
			lastEmpty = showNextButton(12, lastEmpty);
		});
		
		// Q13 - Resources
		$('#resource').sortable({
			placeholder: "resource_placeholder",
			revert: true,
			create: function( event, ui ) { // initialize ranking
				var count = $("#resource li").length;
				for (var i=0;i<count;i++)
				{
					sortID = $('#resource').find('li:eq('+i+')').attr("id");
					$('input[id='+sortID+'_0]').val(count-i);
				}
			},
			start: function( event, ui ) {
				$("div#q13_flag").text(1);
				lastEmpty = showNextButton(11, lastEmpty);
			},
			stop: function( event, ui ) {
				var count = $("#resource li").length;
				for (var i=0;i<count;i++)
				{
					sortID = $('#resource').find('li:eq('+i+')').attr("id");
					$('input[id='+sortID+'_0]').val(count-i);
				}
			}
		});
		$('#resource').disableSelection();
		
		// Q14 - Supervisor
		$("input[id=q14_0]").val("");
		$('map#supervisorCloud area').click(function(){
			$('#supervisor img').css("background-position", "0px "+(-445*($(this).index()+1))+"px");
			$('input[id=q14_0]').val($(this).index()+1);
			$("div#q14_flag").text(1);
			lastEmpty = showNextButton(14, lastEmpty);
		});
		
		// Q15 - Leadership
		$("input[id=q15_0]").val("");
		$("map#leadershipCloud area").click(function(){
			$('#leadership img').css("background-position", "0px "+(-418*($(this).index()+1))+"px");
			$('input[id=q15_0]').val($(this).index()+1);
			$("div#q15_flag").text(1);
			lastEmpty = showNextButton(15, lastEmpty);
		});
		
		// Q16 - Traits
		var traitCount = 0;
		
		$("div#traits div").click(function(){
			var selected = $(this).attr('id');  // get id of selected choice
			if (traitCount < 5){
				$(this).toggleClass("selected");
				if ($(this).hasClass("selected")){
					traitCount = traitCount + 1;
					$('input[id='+selected+'_0]').prop('checked', true);
				}else{
					traitCount = traitCount - 1;
					$('input[id='+selected+'_0]').prop('checked', false);
				};
			}else{
				if ($(this).hasClass("selected")){
					$(this).toggleClass("selected");
					traitCount = traitCount - 1;
					$('input[id='+selected+'_0]').prop('checked', false);
				};
			};
			if (traitCount == 5){$('#next_question').show();}else{$('#next_question').hide(); lastEmpty = 16;};
		});
		
		// Q17 - Motivation
		$("input[id=q17_0]").val("");
		$("map#motivationCloud area").click(function(){
			$('#motivation img').css("background-position", "0px "+(-390*($(this).index()+1))+"px");
			$('input[id=q17_0]').val($(this).index()+1);
			$("div#q17_flag").text(1);
			lastEmpty = showNextButton(17, lastEmpty);
		});
		
		// Q18 - Industry
		$('.industry').typeahead({
			name: 'industry',
			limit: 5,
			remote: '/inquire/industry_search/%QUERY',
			template: '<p><strong>{{value}}</strong></p>',
			engine: Hogan
		}).on('typeahead:selected typeahead:autocompleted', function($e, datum){
			numChosen = $('.chosenIndustry li').length;
			if(numChosen >= 0 && numChosen < 5){
				var duplicationFlag = 0;
				$('.chosenIndustry').show("slide", { direction: "right" }, 100);
				if (numChosen == 0){
					$('.chosenIndustry ul').append('<li>'+datum.value+'</li>');
					$('div.q18').append('<input id="q18_1_0" type="text" name="user_industry[]"  value="'+datum.id+'">');
					$("div#q18_flag").text(1);
				} else {
					$("input[id^=q18]").each(function(){
						if($(this).val() == datum.id){
							duplicationFlag = 1;
						};
					});
					if (duplicationFlag == 1){
						console.log('You already picked this one');
					}else{
						$('div.q18').append('<input id="q18_'+(numChosen+1)+'_0" type="text" name="user_industry[]"  value="'+datum.id+'">');
						$('.chosenIndustry ul').append('<li>'+datum.value+'</li>');
					};
				}
			};
			lastEmpty = showNextButton(18, lastEmpty);
		});
		
		$(".chosenIndustry img").click(function(){
			numChosen = $('.chosenIndustry li').length;
			if (numChosen > 0){
				$('.chosenIndustry li:last').remove();
				$('input#q18_'+(numChosen)+'_0').remove();
			};
			if(numChosen == 1){$('.chosenIndustry').hide(); $("div#q18_flag").text("");};
			lastEmpty = showNextButton(18, lastEmpty);
		});
		
		// Q19 - Work Location	
		$('.location').typeahead({
			name: 'cities',
			limit: 5,
			remote: '/inquire/location_search/%QUERY',
			template: '<p><strong>{{value}}</strong></p>',
			engine: Hogan
		}).on('typeahead:selected typeahead:autocompleted', function($e, datum){
			numChosen = $('.chosenCities li').length;
			if(numChosen >= 0 && numChosen < 5){
				var duplicationFlag = 0;
				$('.chosenCities').show("slide", { direction: "right" }, 100);
				if (numChosen == 0){
					$('.chosenCities ul').append('<li>'+datum.value+'</li>');
					$('div.q19').append('<input id="q19_1_0" type="text" name="user_location[]"  value="'+datum.id+'">');
					$("div#q19_flag").text(1);
				} else {
					$("input[id^=q19]").each(function(){
						if($(this).val() == datum.id){
							duplicationFlag = 1;
						};
					});
					if (duplicationFlag == 1){
						console.log('You already picked this one');
					}else{
						$('div.q19').append('<input id="q19_'+(numChosen+1)+'_0" type="text" name="user_location[]"  value="'+datum.id+'">');
						$('.chosenCities ul').append('<li>'+datum.value+'</li>');
					};
				}
			};
			lastEmpty = showNextButton(19, lastEmpty);
		});
		
		$(".chosenCities img").click(function(){
			numChosen = $('.chosenCities li').length;
			if (numChosen > 0){
				$('.chosenCities li:last').remove();
				$('input#q19_'+(numChosen)+'_0').remove();
			};
			if(numChosen == 1){$('.chosenCities').hide(); $("div#q19_flag").text("");};
			lastEmpty = showNextButton(19, lastEmpty);
		});
		
		// Q20 - Work History
		ratings('.happiness', 'user_work[0][rating]');  // Initiate stars rating
		dateSelect('#history .prefill'); // Change font color when selected
		$('#history input').val(''); // reset all forms
		monthDropdown('#history .month');
		yearDropdown('#history .year');
		presentFlag();
		educationHistoryTypeahead(0);
		workHistoryTypeahead(0);
		
		if (lastEmpty == 20){
			$('#next_question').hide();
			$('#show_preview').show();
		};
		
		$('#history .addButton').on("click", function(event){
			var educationRef = $('#education_layout li').length / 4;
			var experienceRef = $('#experience_layout li').length / 4;
			if ($(this).attr('id') == 'addEducation'){
				$('#education_layout ul').append(
					'<hr/> \
					<li><label>School</label><input class="text_form school'+educationRef+'" type="text" maxlength="150" name="user_education['+educationRef+'][school_name]"><input type="hidden" name="user_education['+educationRef+'][school_id]" value=""></li>\
					<li><label>Degree</label><input class="text_form degree'+educationRef+'" type="text" maxlength="150" name="user_education['+educationRef+'][degree_name]"><input type="hidden" name="user_education['+educationRef+'][degree_id]" value=""></li>\
					<li><label>Field of Study</label><input class="text_form study'+educationRef+'" type="text" maxlength="150" name="user_education['+educationRef+'][field_name]"><input type="hidden" name="user_education['+educationRef+'][field_id]" value=""></li>\
					<li class="history_sets"><label>Time Period</label><select name="user_education['+educationRef+'][start_month]" class=" monthEmpty prefill"></select>\
						<select name="user_education['+educationRef+'][start_year]" class=" yearEmpty prefill"></select> &ndash; <select name="user_education['+educationRef+'][end_month]" class=" monthEmpty prefill"></select> \
						<select name="user_education['+educationRef+'][end_month]" class=" yearEmpty prefill"></select>\
					</li>\
					'
				);
				educationHistoryTypeahead(educationRef);
			} else {
				$('#experience_layout ul').append(
					'<hr/> \
						<li><label>Company</label><input class="text_form company'+educationRef+'" type="text" maxlength="150" name="user_work['+experienceRef+'][company_name]"><input type="hidden" name="user_work['+experienceRef+'][company_id]" value=""></li>\
						<li><label>Job</label><input class="text_form job'+educationRef+'" type="text" maxlength="150" name="user_work['+experienceRef+'][job_type]"><input type="hidden" name="user_work['+experienceRef+'][job_id]" value=""></li>\
						<li><label class="happiness_label">Happiness</label><div class="happiness"></div></li>\
						<li class="history_sets">\
							<label>Time Period</label><select name="user_work['+experienceRef+'][start_month]" class=" monthEmpty prefill"></select>\
							<select name="user_work['+experienceRef+'][start_year]" class=" yearEmpty prefill"></select> \
							&ndash; <span class="presentFlag" style="display: none;">Present</span>\
							<select name="user_work['+experienceRef+'][end_month]" class=" monthEmpty prefill endDateFlag"></select> <select name="user_work['+experienceRef+'][end_year]" class=" yearEmpty prefill endDateFlag"></select>\
							<span class="presentText">I currently work here</span><input type="checkbox" style="width: 13px; float: left;" name="user_work['+experienceRef+'][current]"/>\
						</li>\
					'
				);
				ratings($(this).parent().find('.happiness').eq(experienceRef), "user_work["+experienceRef+"][rating]");
				workHistoryTypeahead(experienceRef);
			}
			dateSelect('#history .prefill');
			monthDropdown('#history .monthEmpty');
			yearDropdown('#history .yearEmpty');
			presentFlag();
			
			var education_sets = $('#education_layout li').length / 4;
			var experience_sets = $('#experience_layout li').length / 4;
			var sets, question_height, layout_height;
			
			sets = Math.max(education_sets, experience_sets);
			
			switch (sets)
			{
				case 2:
					if($('div#20').height() < 620){
						$('div#20').css('min-height','600px');
						$('#history div#education_layout, #history div#experience_layout').css('height','510px');
					};
					break;
				case 3:
					if($('div#20').height() < 620){
						question_height = $('div#20').height();
						layout_height = $('#history div#education_layout').height();
						$('div#20').css('min-height',question_height+210+'px');
						$('#history div#education_layout, div#experience_layout').css('height',layout_height+210+'px');
					};
					break;
				case 4:
					if($('div#20').height() < 830){
						question_height = $('div#20').height();
						layout_height = $('#history div#education_layout').height();
						$('div#20').css('min-height',question_height+210+'px');
						$('#history div#education_layout, div#experience_layout').css('height',layout_height+210+'px');
					};
					break;
				case 5:
					if($('div#20').height() < 1100){
						question_height = $('div#20').height();
						layout_height = $('#history div#education_layout').height();
						$('div#20').css('min-height',question_height+100+'px');
						$('#history div#education_layout, div#experience_layout').css('height',layout_height+100+'px');
					};
					if (education_sets == 5) {
						$('#history #addEducation').hide();
					}
					if (experience_sets == 5) {
						$('#history #addWork').hide();
					};
					break;
			};
			
		});
		
	};
});

// Questionnaire function | Show next button when user clicks an answer
function showNextButton(e, lastEmpty) { // determine if user selected an answer
	if ($("div#q"+e+"_flag").text()){$('#next_question').show();}else{$('#next_question').hide(); lastEmpty = e;};
	return lastEmpty;
};

function showNextButtonCheckbox(e, lastEmpty) { // determine if user selected an answer
	var nextFlag = 0;
	$("input[id^=q"+e+"]").each(function() { 
		if ($(this).prop('checked')){
			nextFlag = 1;
		};
	 });
	if (nextFlag > 0){$('#next_question').show();}else{$('#next_question').hide(); lastEmpty = e;};
	return lastEmpty;
};

function monthDropdown(selector){
	$(selector).append('<option value="0"> Month</option><option value="1"> Jan</option><option value="2"> Feb</option><option value="3"> Mar</option><option value="4"> Apr</option><option value="5"> May</option><option value="6"> Jun</option><option value="7"> Jul</option><option value="8"> Aug</option><option value="9"> Sept</option><option value="10"> Oct</option><option value="11"> Nov</option><option value="12"> Dec</option>');
	$(selector).removeClass('monthEmpty').addClass('month');
	
};

function yearDropdown(selector){
	var i = 1, year = 2013;
	var html = '<option value="0">Year</option>';
	
	for (var i=1;i<65;i++)
	{ 
		html += '<option value="'+year+'">'+year+'</option>';
		year -= 1;
	}
	
	$(selector).append(html);
	$(selector).switchClass('yearEmpty').addClass('year');
};

function educationHistoryTypeahead(educationRef){ // initialize typeahead for education history
	$('.school'+educationRef).typeahead({
		name: 'schools',
		limit: 5,
		remote: '/inquire/college_search/%QUERY',
		template: '<p><strong>{{value}}</strong></p>',
		engine: Hogan
	}).on('typeahead:selected typeahead:autocompleted', function($e, datum){
		$("#history input[name='user_education["+educationRef+"][school_id]']").val(datum.id);
	});

	$('.degree'+educationRef).typeahead({
		name: 'degrees',
		limit: 5,
		remote: '/inquire/degree_type_search/%QUERY',
		template: '<p><strong>{{value}}</strong></p>',
		engine: Hogan
	}).on('typeahead:selected typeahead:autocompleted', function($e, datum){
		$("#history input[name='user_education["+educationRef+"][degree_id]']").val(datum.id);
	});
	
	$('.study'+educationRef).typeahead({
		name: 'studies',
		limit: 5,
		remote: '/inquire/major_search/%QUERY',
		template: '<p><strong>{{value}}</strong></p>',
		engine: Hogan
	}).on('typeahead:selected typeahead:autocompleted', function($e, datum){
		$("#history input[name='user_education["+educationRef+"][field_id]']").val(datum.id);
	});
};

function workHistoryTypeahead(experienceRef){ // initialize typeahead for work history
	$('.company'+experienceRef).typeahead({
		name: 'companies',
		limit: 5,
		remote: '/inquire/company_search/%QUERY',
		template: '<p><strong>{{value}}</strong></p>',
		engine: Hogan
	}).on('typeahead:selected typeahead:autocompleted', function($e, datum){
		$("#history input[name='user_education["+experienceRef+"][company_id]']").val(datum.id);
	});
	
	$('.job'+experienceRef).typeahead({
		name: 'jobs',
		limit: 5,
		remote: '/inquire/jobtype_search/%QUERY',
		template: '<p><strong>{{value}}</strong></p>',
		engine: Hogan
	}).on('typeahead:selected typeahead:autocompleted', function($e, datum){
		$("#history input[name='user_education["+experienceRef+"][job_id]']").val(datum.id);
	});
};

function ratings(containerID, scoreID){ // initialize raty
	$(containerID).raty({ 
		path: 'assets/images/survey',
		number: 10,
		starOff  : 'star00.jpg',
		iconRange: [
			{ range: 1, on: 'star01.jpg'},
			{ range: 2, on: 'star02.jpg'},
			{ range: 3, on: 'star03.jpg'},
			{ range: 4, on: 'star04.jpg'},
			{ range: 5, on: 'star05.jpg'},
			{ range: 6, on: 'star06.jpg'},
			{ range: 7, on: 'star07.jpg'},
			{ range: 8, on: 'star08.jpg'},
			{ range: 9, on: 'star09.jpg'},
			{ range: 10, on: 'star10.jpg'}
		  ],
		hints: ['Terrible', 'Dissatisfied', 'Sucky', 'Sad', 'So-So', 'Decent', 'Good', 'Thrilled', 'Ecstatic', 'Unreal'],
		width: 490,
		space: false,
		scoreName: scoreID,
		targetType: 'number',
		targetKeep: true
	});
};

function presentFlag(){
	$("#history input[type='checkbox']").on("change",function(event){
		if ($(this).prop('checked')){
			$(this).parent().find('.endDateFlag').hide();
			$(this).parent().find('.presentFlag').show();
		}else{
			$(this).parent().find('.endDateFlag').show();
			$(this).parent().find('.presentFlag').hide();
		};
	});
};

function dateSelect(id){  // remove the prefill color on click
	$(id).on("focusin",function () {
		$(this).removeClass("prefill");
	});
};


// Modal popup function
function modal(modalID, modalWidth, topMargin){

	//Fade in the Popup and add close button
	$(modalID).fadeIn().css({ 'width': modalWidth }).prepend('<a href="#" class="close"><img src="../assets/images/modals/close_modal.png" class="btn_close" title="Close Window" alt="Close" /></a>');

	//Define margin for center alignment (vertical   horizontal) - we add 80px to the height/width to accomodate for the padding  and border width defined in the css
	//var popMargTop = ($(modalID).height() + 80) / 2;
	var popMargLeft = ($(modalID).width() + 80) / 2;

	//Apply Margin to Popup
	$(modalID).css({
		//'margin-top' : -popMargTop,
		'margin-top' : topMargin+'px',
		'margin-left' : -popMargLeft
	});

	//Fade in Background
	$('body').append('<div id="fade"></div>'); //Add the fade layer to bottom of the body tag.
	$('#fade').css({'filter' : 'alpha(opacity=80)'}).fadeIn(); //Fade in the fade layer - .css({'filter' : 'alpha(opacity=80)'}) is used to fix the IE Bug on fading transparencies 

	return false;

};

// Settings modal popup function
function settings(modalID){

	//Fade in the Popup
	$(modalID).fadeIn();

	//Fade in Background
	$('body').append('<div id="transparent_fade"></div>'); //Add the fade layer to bottom of the body tag.
	$('#transparent_fade').css({'filter' : 'alpha(opacity=0)'}).fadeIn(); //Fade in the fade layer - .css({'filter' : 'alpha(opacity=80)'}) is used to fix the IE Bug on fading transparencies 

	return false;

};