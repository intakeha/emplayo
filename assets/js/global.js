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
		
		 $container.on('click', '.smallTile', function(){
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
		var currentQuestion = 8;
		var lastEmpty = 9;
		var lastQuestion = 9;
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
		$('div#q9_1').show();	
		$("input[id^=q9]").val(0);
		
		$('div.envAnswer1, div.envAnswer2').click(function () {
			var inputName = $(this).parent().attr('id');
			if ($(this).hasClass('envAnswer1')){
				$(this).addClass('selected');
				$('input[id='+inputName+'_0]').val((currentEnvQuestion*2)-1);
				$(this).parent().children('div.envAnswer2').removeClass('selected');
			};
			if ($(this).hasClass('envAnswer2')){
				$(this).addClass('selected');
				$('input[id='+inputName+'_0]').val(currentEnvQuestion*2);
				$(this).parent().children('div.envAnswer1').removeClass('selected');
			};

			//update progress bar
			if (envComplete == 0){
				progressBackground = (currentEnvQuestion) * -127;
				$('#envProgressOverlay').css("background-position", progressBackground+"px 0px");
			} else {
				if (currentEnvQuestion < 10){
					progressBackground = (currentEnvQuestion+1) * -127;
					$('#envProgressOverlay').css("background-position", progressBackground+"px 0px");
				};
			};
			
			//update next subquestion
			if ((currentEnvQuestion < 10)&&(parseFloat($("input[id^=q9_"+currentEnvQuestion+"]").val())!=0)){
				$('div#q9_'+currentEnvQuestion).delay(400).animate({opacity: 0, marginLeft:'300px'},300).hide(500);
				currentEnvQuestion = currentEnvQuestion + 1;
				$('div#q9_'+currentEnvQuestion).delay(600).animate({opacity: 1, marginLeft:'149px'},300).show(500);
			};
			
			//check for next button
			var nextEnvFlag = 1;
			$("input[id^=q9]").each(function() {
				if (parseFloat($(this).val())==0){
					nextEnvFlag=0;
				};
			 });
			if (nextEnvFlag == 1){$('#next_question').show(); $('map#environmentMap area').attr('href','#');}else{$('#next_question').hide(); lastEmpty = 9;};
			
		});
		
		// Activating image map
		$("map#environmentMap area").click(function(){
			if (parseFloat($("input[name^=q9_"+currentEnvQuestion+"]").val())!=0){
				envComplete = 1;
				$('div#q9_'+currentEnvQuestion).delay(400).animate({opacity: 0, marginLeft:'300px'},300).hide(500);
				currentEnvQuestion = $(this).index()+1;
				progressBackground = (currentEnvQuestion) * -127;
				$('#envProgressOverlay').css("background-position", progressBackground+"px 0px");
				$('div#q9_'+(currentEnvQuestion)).delay(600).animate({opacity: 1, marginLeft:'149px'},300).show(500);
			};
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
			
			/*lastEmpty = 17;
			$('#next_question').hide();
			$('#show_preview').show(); */
		});
		
		// Q18 - Industry
		 $('.industry').typeahead({
			local: [
				"Accounting",
				"Agriculture",
				"Airlines - Aviation",
				"Alternative Dispute Resolution",
				"Alternative Medicine",
				"Animation",
				"Apparel - Fashion",
				"Architecture - Planning",
				"Arts and Crafts",
				"Automotive",
				"Aviation - Aerospace",
				"Banking",
				"Biotechnology",
				"Broadcast Media",
				"Building Materials",
				"Business Supplies and Equipment",
				"Capital / Markets",
				"Chemicals",
				"Civic - Social Organization",
				"Civil Engineering",
				"Commercial Real Estate",
				"Computer - Network Security",
				"Computer Games",
				"Computer Hardware",
				"Computer Networking",
				"Computer Software",
				"Construction",
				"Consumer Electronics",
				"Consumer Goods",
				"Consumer Services",
				"Cosmetics",
				"Dairy",
				"Defense - Space",
				"Design",
				"Education Management",
				"E-Learning",
				"Electrical - Electronic Manufacturing",
				"Entertainment",
				"Environmental Services",
				"Events Services"
			]
		});
		
		// Q19 - Work Location
		 $('.location').typeahead({
			local: [
				"San Francisco, CA",
				"Las Vegas, NV",
				"New York, NY",
				"Miami, FL",
				"San Jose, CA",
				"London, United Kingdom",
				"Bangkok, Thailand",
				"Sydney, Australia",
				"Paris, France"
			]
		});
		
		// Q20 - Work History
		$('#history img').mouseenter(function() {
			$(this).toggleClass('addhover');
		}).mouseleave(function(){
			$(this).toggleClass('addhover');
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