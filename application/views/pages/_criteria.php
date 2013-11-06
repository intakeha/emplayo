<script>
	$(function() {
		// Uncheck all checkboxes
		$("input[type='checkbox']").each(function() {      
			$(this).prop('checked', false);
		 });
		
		$('#header_login, #footer, #progressBar').hide();
		
		//Activiate form submit button
		$('div#show_preview').click(function(){
			window.onbeforeunload = null; // disabled onbeforeunload
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
		var currentQuestion = 0; // default 0
		var lastEmpty = 1; // default 1
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
			$('div.currentQuestion span').html(currentQuestion);
			$('div.currentQuestion').show();
			if (currentQuestion > lastQuestion){lastQuestion = currentQuestion;};
			questionTypeHints = $('div#'+currentQuestion).attr("name");
			if(questionTypeHints){
				generateHints(currentQuestion, questionTypeHints);
				$('div.hints').show().css({opacity: 0, marginTop: "-66px"}).animate({
					opacity: 1,
					marginTop: "-61px",
					}, 500 );
			};
			$('div#'+currentQuestion).show();
		
			if(currentQuestion==18){
				$("#select2custom").remove();
				$("<style type='text/css' id='select2custom'> div.select2-result-label{font-size:25px;} .select2-searching{font-size: 25px; padding: 10px 0; height: 20px;} </style>").appendTo("head");
			};

			if(currentQuestion==19){
				$("#select2custom").remove();
				$("<style type='text/css' id='select2custom'> div.select2-result-label{font-size:25px;} .select2-searching{font-size: 25px; padding: 10px 0; height: 20px;} </style>").appendTo("head");
			};
					
			if(currentQuestion==20){
				$("#select2custom").remove();
				$("<style type='text/css' id='select2custom'> div.select2-result-label{font-size:18px;} .select2-searching{font-size: 14px; padding: 10px 0; height: 20px;} </style>").appendTo("head");
			};

			// show navigation hints
			if ((currentQuestion == 1)&&($('div#firstTimeFlag').text() == 1)){ 
				$('#criteria #hints_q1_1').fadeIn(1000);
				$('#criteria #hints_q1_1 .gotIt').click(function () {
					$('#criteria #hints_q1_1').fadeOut(500);
					$('#criteria #hints_q1_2').fadeIn(1000);
				});
				$('#criteria #hints_q1_2 .gotIt').click(function () {
					$('#criteria #hints_q1_2').fadeOut(500);
					$('#criteria #hints_q1_3').fadeIn(1000);
				});
				$('#criteria #hints_q1_3 .gotIt').click(function () {
					$('#criteria #hints_q1_3').fadeOut(500);
				});				
			};
			if ((currentQuestion == 4)&&($('div#firstTimeFlag').text() == 1)){ // show navigation hints
				$('#criteria #hints_q4_1').fadeIn(1000);
				$('#criteria #hints_q4_1 .gotIt').click(function () {
					$('#criteria #hints_q4_1').fadeOut(500);
				});
			};			
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
				$('div.currentQuestion span').html(currentQuestion);
				$('div.currentQuestion').show();
				$('div.questions').hide();
				questionTypeHints = $('div#'+currentQuestion).attr("name");
				if(questionTypeHints){
					generateHints(currentQuestion, questionTypeHints);
					$('div.hints').show().css({opacity: 0, marginTop: "-66px"}).animate({
					    opacity: 1,
					    marginTop: "-61px",
					    }, 500 );
				};
				questionType = $('div#'+currentQuestion).find('input').attr('type');
				$('div#'+currentQuestion).show();
				if(currentQuestion==18){
					$("#select2custom").remove();
					$("<style type='text/css' id='select2custom'> div.select2-result-label{font-size:25px;} .select2-searching{font-size: 25px; padding: 10px 0; height: 20px;} </style>").appendTo("head");
				};

				if(currentQuestion==19){
					$("#select2custom").remove();
					$("<style type='text/css' id='select2custom'> div.select2-result-label{font-size:25px;} .select2-searching{font-size: 25px; padding: 10px 0; height: 20px;} </style>").appendTo("head");
				};
						
				if(currentQuestion==20){
					$("#select2custom").remove();
					$("<style type='text/css' id='select2custom'> div.select2-result-label{font-size:18px;} .select2-searching{font-size: 14px; padding: 10px 0; height: 20px;} </style>").appendTo("head");
				};
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
				$('div.env:eq('+(currentEnvQuestion-1)+')').delay(200).fadeOut(100);
				currentEnvQuestion = currentEnvQuestion + 1;
				$('div.env:eq('+(currentEnvQuestion-1)+')').delay(400).fadeIn(100);
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
				$('div.env:eq('+(currentEnvQuestion-1)+')').delay(200).fadeOut(100);
				currentEnvQuestion = $(this).index()+1; // assign the current environment question to the associated map index
				progressBackground = (currentEnvQuestion) * -127;
				$('#envProgressOverlay').css("background-position", progressBackground+"px 0px");
				$('div.env:eq('+(currentEnvQuestion-1)+')').delay(400).fadeIn(100);
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
		$('#industry_0').select2({
			multiple: true,
			minimumInputLength: 0,
			maximumSelectionSize: 5,
			width: 600,
			ajax: {
				url: "/survey/industry_search",
				dataType: 'json',
				data: function (term, page) {
					return {
						searchterm: term
					};
				},
				results: function (data, page) {
					return { results: data };
				}
			}
		}).on("change", function(e){
			$("input[id^=q18_]").remove();
			var industrySplit = $('input#industry_0').val().split(',');
			if($('input#industry_0').val()){
				$("div#q18_flag").text(1);
				$.each(industrySplit, function(e, value){
					$('div.q18').append('<input id="q18_'+(e+1)+'_0" type="text" class="hide" name="user_industry[]"  value="'+value+'">');
				});
			}else {
				$("div#q18_flag").empty();
			};
			lastEmpty = showNextButton(18, lastEmpty);
		});
		
		// Q19 - Work Location	
		
		$('#location_0').select2({
			multiple: true,
			minimumInputLength: 1,
			maximumSelectionSize: 5,
			width: 600,
			ajax: {
				url: "/survey/location_search",
				dataType: 'json',
				data: function (term, page) {
					return {
						searchterm: term
					};
				},
				results: function (data, page) {
					return { results: data };
				}
			}
		}).on("change", function(e){
			$("input[id^=q19_]").remove();
			var locationSplit = $('input#location_0').val().split(',');
			if($('input#location_0').val()){
				$("div#q19_flag").text(1);
				$.each(locationSplit, function(e, value){
					$('div.q19').append('<input id="q19_'+(e+1)+'_0" type="text" class="hide" name="user_industry[]"  value="'+value+'">');
				});
			}else {
				$("div#q19_flag").empty();
			};
			lastEmpty = showNextButton(19, lastEmpty);
		});		
		
		
		// Q20 - Work History
		
		ratings('.happiness', 'user_work[0][rating]');  // Initiate stars rating
		$('#history input').val(''); // reset all forms
		monthDropdown('#history .month0');
		yearDropdown('#history div#experience_layout .year0');
		yearDropdownEducation('#history div#education_layout .year0');
		presentFlag();
		educationHistorySelect(0);
		workHistorySelect(0);
		
		if (lastEmpty == 20){
			$('#next_question').hide();
			$('#show_preview').show();
		};
		
		$('#history .addButton').on("click", function(event){
			var educationRef = $('#education_layout li').length / 4;
			var experienceRef = $('#experience_layout li').length / 4;
			if ($(this).attr('id') == 'addEducation'){
				$('#education_layout ul.history_master').append(
					'<hr/> \
					<li><label>School</label>\
					<input type="hidden" id="school_name'+educationRef+'" name="user_education_placeholder['+educationRef+'][school_name]" data-placeholder="Select school name...">\
					<input type="hidden" name="user_education['+educationRef+'][school_id]" value="">\
					<input type="hidden" name="user_education['+educationRef+'][school_name]" value="">\
					</li>\
					<li><label>Degree</label>\
					<input type="hidden" id="degree_name'+educationRef+'" name="user_education_placeholder['+educationRef+'][degree_name]" data-placeholder="Select degree...">\
					<input type="hidden" name="user_education['+educationRef+'][degree_id]" value="">\
					<input type="hidden" name="user_education['+educationRef+'][degree_name]" value="">\
					</li>\
					<li><label>Field of Study</label>\
					<input type="hidden" id="field_name'+educationRef+'" name="user_education_placeholder['+educationRef+'][field_name]" data-placeholder="Select field of study...">\
					<input type="hidden" name="user_education['+educationRef+'][field_id]" value="">\
					<input type="hidden" name="user_education['+educationRef+'][field_name]" value="">\
					<li class="history_sets"><label>Time Period</label><select name="user_education['+educationRef+'][start_month]" class="month'+educationRef+'"></select>\
						<select name="user_education['+educationRef+'][start_year]" class="year'+educationRef+'"></select> &ndash; <select name="user_education['+educationRef+'][end_month]" class="month'+educationRef+'"></select> \
						<select name="user_education['+educationRef+'][end_year]" class="year'+educationRef+'"></select>\
					</li>\
					'
				);
				monthDropdown('#history div#education_layout .month'+educationRef);
				yearDropdownEducation('#history div#education_layout .year'+educationRef);
				educationHistorySelect(educationRef);
			} else {
				$('#experience_layout ul.history_master').append(
					'<hr/>\
					<li><label>Company</label>\
					<input type="hidden" id="company'+experienceRef+'" name="user_work_placeholder['+experienceRef+'][company_name]" data-placeholder="Select company...">\
					<input type="hidden" name="user_work['+experienceRef+'][company_id]" value="">\
					<input type="hidden" name="user_work['+experienceRef+'][company_name]" value="">\
					</li>\
					<li><label>Job</label>\
					<input type="hidden" id="job'+experienceRef+'" name="user_job_placeholder['+experienceRef+'][job_type]" data-placeholder="Select job type...">\
					<input type="hidden" name="user_work['+experienceRef+'][job_id]" value="">\
					<input type="hidden" name="user_work['+experienceRef+'][job_type]" value="">\
					</li>\
					<li><label class="happiness_label">Happiness</label><div class="happiness"></div></li>\
					<li class="history_sets">\
						<label>Time Period</label><select name="user_work['+experienceRef+'][start_month]" class="month'+experienceRef+'"></select>\
						<select name="user_work['+experienceRef+'][start_year]" class="year'+experienceRef+'"></select>\
						&ndash; <span class="presentFlag" style="display: none;">Present</span>\
						<select name="user_work['+experienceRef+'][end_month]" class="month'+experienceRef+' endDateFlag"></select> <select name="user_work['+experienceRef+'][end_year]" class="year'+experienceRef+' endDateFlag"></select>\
						<span class="presentText">I currently work here</span><input type="checkbox" name="user_work['+experienceRef+'][current]" value="0" />\
					</li>\
					'
				);
				ratings($(this).parent().find('.happiness').eq(experienceRef), "user_work["+experienceRef+"][rating]");
				monthDropdown('#history div#experience_layout .month'+experienceRef);
				yearDropdown('#history div#experience_layout .year'+experienceRef);
				workHistorySelect(experienceRef);
			};

			presentFlag();
			
			var education_sets = $('#education_layout li').length / 4;
			var experience_sets = $('#experience_layout li').length / 4;
			var sets, question_height, layout_height;
			sets = Math.max(education_sets, experience_sets);
			
			switch (sets)
			{
				case 2:
					if($('div#20').height() < 560){
						$('div#20').css('min-height','580px');
						$('#history div#education_layout, #history div#experience_layout').css('height','500px');
					};
					break;
				case 3:
					if($('div#20').height() < 590){
						question_height = $('div#20').height();
						layout_height = $('#history div#education_layout').height();
						$('div#20').css('min-height',question_height+180+'px');
						$('#history div#education_layout, div#experience_layout').css('height',layout_height+185+'px');
					};
					break;
				case 4:
					if($('div#20').height() < 770){
						question_height = $('div#20').height();
						layout_height = $('#history div#education_layout').height();
						$('div#20').css('min-height',question_height+185+'px');
						$('#history div#education_layout, div#experience_layout').css('height',layout_height+185+'px');
					};
					break;
				case 5:
					if($('div#20').height() < 950){
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

	// Populate question hints and instruction at the top
	function generateHints(e, questionType){
		var hint="";
		switch(questionType)
		{
			case "singleChoice":
				hint="<div id='singleChoice'>select one</div>";
				break;
			case "multipleChoice":
				hint="<div id='multipleChoice'>select one or more items</div>";
				break;
			case "rankChoice":
				hint="<div id='rankChoice'>sort by drag and drop</div>";
				break;
			case "clickChoice":
				hint="<div id='clickChoice'>click to select</div>";
				break;
			case "textChoice":
				hint="<div id='textChoice'>enter text in textbox</div>";
				break;
			default:
				hint="please select an answer";
		}
		$('div#'+e+" div.hints").remove();
		$('div#'+e).prepend("<div class='hints'>"+hint+"</div>");
	};
		
	// Generate number months for the drop-downs
	function monthDropdown(selector){
		$(selector).append('<option></option><option value="1"> Jan</option><option value="2"> Feb</option><option value="3"> Mar</option><option value="4"> Apr</option><option value="5"> May</option><option value="6"> Jun</option><option value="7"> Jul</option><option value="8"> Aug</option><option value="9"> Sept</option><option value="10"> Oct</option><option value="11"> Nov</option><option value="12"> Dec</option>');
		$(selector).select2({
			placeholder: "Month",
			width: 80
		});
	};

	// Generate number years for the drop-downs
	function yearDropdown(selector){
		var i = 1, year = 2013;
		var html = '<option></option>';
		
		for (var i=1;i<65;i++)
		{ 
			html += '<option value="'+year+'">'+year+'</option>';
			year -= 1;
		}
		
		$(selector).append(html);
		$(selector).select2({
			placeholder: "Year",
			width: 80
		});
	};

	function yearDropdownEducation(selector){
		var i = 1, year = 2017;
		var html = '<option></option>';
		
		for (var i=1;i<65;i++)
		{ 
			html += '<option value="'+year+'">'+year+'</option>';
			year -= 1;
		}
		
		$(selector).append(html);
		$(selector).select2({
			placeholder: "Year",
			width: 80
		});
	};
	
	function educationHistorySelect(educationRef){
		$('#school_name'+educationRef).select2({
			multiple: false,
			minimumInputLength: 1,
			width: 340,
			createSearchChoice:function(term, data) {
				if ($(data).filter(function() {return this.text.localeCompare(term)===0; }).length===0) {
					return {id:term, text:term};          
				} 
			},
			ajax: {
				url: "/inquire/college_name_search",
				dataType: 'json',
				data: function (term, page) {
					return {
						searchterm: term
					};
				},
				results: function (data, page) {
					return { results: data };
				}
			}
		}).on("change", function(e){
			if (e.added.id==e.added.text){
				$("#history input[name='user_education["+educationRef+"][school_id]']").val("");
				$("#history input[name='user_education["+educationRef+"][school_name]']").val(e.added.text);      
			}else {
				$("#history input[name='user_education["+educationRef+"][school_id]']").val(e.added.id);
				$("#history input[name='user_education["+educationRef+"][school_name]']").val(e.added.text);  				
			}
		});
		
		$('#degree_name'+educationRef).select2({
			multiple: false,
			minimumInputLength: 0,
			width: 340,
			createSearchChoice:function(term, data) {
				if ($(data).filter(function() {return this.text.localeCompare(term)===0; }).length===0) {
					return {id:term, text:term};          
				} 
			},
			ajax: {
				url: "/inquire/college_degree_search",
				dataType: 'json',
				data: function (term, page) {
					return {
						searchterm: term
					};
				},
				results: function (data, page) {
					return { results: data };
				}
			}
		}).on("change", function(e){
			if (e.added.id==e.added.text){
				$("#history input[name='user_education["+educationRef+"][degree_id]']").val("");
				$("#history input[name='user_education["+educationRef+"][degree_name]']").val(e.added.text);      
			}else {
				$("#history input[name='user_education["+educationRef+"][degree_id]']").val(e.added.id);
				$("#history input[name='user_education["+educationRef+"][degree_name]']").val(e.added.text);  				
			}
		});
		
		$('#field_name'+educationRef).select2({
			multiple: false,
			minimumInputLength: 0,
			width: 340,
			createSearchChoice:function(term, data) {
				if ($(data).filter(function() {return this.text.localeCompare(term)===0; }).length===0) {
					return {id:term, text:term};          
				} 
			},
			ajax: {
				url: "/inquire/college_major_search",
				dataType: 'json',
				data: function (term, page) {
					return {
						searchterm: term
					};
				},
				results: function (data, page) {
					return { results: data };
				}
			}
		}).on("change", function(e){
			if (e.added.id==e.added.text){
				$("#history input[name='user_education["+educationRef+"][field_id]']").val("");
				$("#history input[name='user_education["+educationRef+"][field_name]']").val(e.added.text);      
			}else {
				$("#history input[name='user_education["+educationRef+"][field_id]']").val(e.added.id);
				$("#history input[name='user_education["+educationRef+"][field_name]']").val(e.added.text);  				
			}
		});

	};
	
	function workHistorySelect(experienceRef){ // initialize typeahead for work history
		$('#company'+experienceRef).select2({
			multiple: false,
			minimumInputLength: 0,
			width: 340,
			createSearchChoice:function(term, data) {
				if ($(data).filter(function() {return this.text.localeCompare(term)===0; }).length===0) {
					return {id:term, text:term};          
				} 
			},
			ajax: {
				url: "/inquire/company_name_search",
				dataType: 'json',
				data: function (term, page) {
					return {
						searchterm: term
					};
				},
				results: function (data, page) {
					return { results: data };
				}
			}
		}).on("change", function(e){
			if (e.added.id==e.added.text){
				$("#history input[name='user_work["+experienceRef+"][company_id]']").val("");
				$("#history input[name='user_work["+experienceRef+"][company_name]']").val(e.added.text);      
			}else {
				$("#history input[name='user_work["+experienceRef+"][company_id]']").val(e.added.id);
				$("#history input[name='user_work["+experienceRef+"][company_name]']").val(e.added.text);  				
			}
		});


		$('#job'+experienceRef).select2({
			multiple: false,
			minimumInputLength: 0,
			width: 340,
			createSearchChoice:function(term, data) {
				if ($(data).filter(function() {return this.text.localeCompare(term)===0; }).length===0) {
					return {id:term, text:term};          
				} 
			},
			ajax: {
				url: "/inquire/job_type_search",
				dataType: 'json',
				data: function (term, page) {
					return {
						searchterm: term
					};
				},
				results: function (data, page) {
					return { results: data };
				}
			}
		}).on("change", function(e){
			if (e.added.id==e.added.text){
				$("#history input[name='user_work["+experienceRef+"][job_id]']").val("");
				$("#history input[name='user_work["+experienceRef+"][job_type]']").val(e.added.text);      
			}else {
				$("#history input[name='user_work["+experienceRef+"][job_id]']").val(e.added.id);
				$("#history input[name='user_work["+experienceRef+"][job_type]']").val(e.added.text);  				
			}
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
				$(this).val(1);
			}else{
				$(this).parent().find('.endDateFlag').show();
				$(this).parent().find('.presentFlag').hide();
				$(this).val(0);
			};
		});
	};

</script> 

<div id="criteria">
	<div id="firstTimeFlag" style="display: none;">1</div>
	<div class="modal_popup" id="modal_q1">
		<img src="<?php echo base_url() ?>assets/images/modals/q1.png">
		<div><span>Privately Held - For Profit</span><br>Privately held companies are not subject to the ups and downs of the stock market.  Employees can expect more interaction with executives and more opportunities for increased responsibility. </div>
		<div><span>Publicly Traded - For Profit</span><br>At a public company, there is constant pressure from the stock market to grow revenue.  This constant growth can result in increased headcount, expanded product lines, and opportunities for employees to grow their career.</div>
		<div><span>Government</span><br>The public sector (The Government sector) has a reputation for stability and job security, as well as a slower pace than private companies.  There can be a high level of taxpayer scrutiny, so red tape and bureaucratic procedures are common.</div>
		<div><span>Non-Profit</span><br>Non-profits are a good option for people who really want to make a difference in the lives of others.  Compensation and perks may not be as high as for-profit businesses.</div>
	</div>
	<div class="modal_popup" id="modal_q2">
		<div class="intro">Pace is an indicator of life inside a company.  Think of it like life in the big city versus life in the country.</div>
		<div><span>Slower Pace</span><br>More predictable and stable work environment, with a slower business and/or industry life cycle (e.g. research laboratory).  This could translate to less stress in the workplace and/or boredom, depending on your perspective.</div>
		<div><span>Medium Pace</span><br>A balance of planned and unplanned deadlines.  Some days are fast-paced, while others allow you to catch your breath.</div>
		<div><span>Face Pace</span><br>Tighter deadlines, more pressure, and a shorter business and/or industry lifecycle (e.g. journalism).  This could be the jolt of excitement you need, or the job you dread daily if it isn't suited to you.</div>
	</div>
	<div class="modal_popup" id="modal_q3">
		<div><span>Start Up | Co-Founders</span><br>You're interested in joining forces with others to start a business from scratch. Highest risk of success and/or failure, with highest potential for reward.</div>
		<div><span>Start Up | First Employees</span><br>You're interested in getting in on the ground floor as one of the first employees of a company. The risk is still somewhat high, and the chance for equity is still good.</div>
		<div><span>Rapid Growth</span><br>Once a startup begins to gain significant traction, it enters the Rapid Growth phase.  The risk of success has been reduced slightly, but there is still a ways to go to achieve maturity and stability.</div>
		<div><span>Maturity</span><br>A solid company structure is in place, long term investments are being made, and financial statements are strong.  The company will be around for a while.</div>
		<div><span>Rebirth</span><br>If a mature company declines, it will tend to have lower stock prices and significant employee attrition.  Joining a company at this stage entails moderate risk and reward, but with a stable infrastructure, greater resources, and a solid history of performance.</div>
	</div>	
	<div class="modal_popup" id="modal_q4">
		<div class="intro">Use drag and drop to rank/order your items on the list.</div>
		<div>Companies offer various benefits and perks to keep employees productive, healthy, and happy.  Rank your 'must have' benefits at the top and your 'nice to have' benefits at the bottom.</div>
	</div>
	<div class="modal_popup" id="modal_q5">
		<div><span>Corporate Citizenship</span> is a term used to describe a company's role and responsibilities towards society (e.g., charitable giving, environmental concerns, etc.)</div>
	</div>	
	<div class="modal_popup" id="modal_q6">
		<div>Certain jobs will require you travel for business purposes.  Locations, durations, and frequency can vary significantly depending on the company and job role.  If you like to travel, then it's time to rack up the frequent flyer miles.  Otherwise, this could put a damper on your family and/or personal life.</div>
	</div>	
	<div class="modal_popup" id="modal_q7">
		<div>Some jobs offer the ability to move into new roles and assignments on a regular basis, offering a chance to learn and do something new.  Other jobs focus more on gaining deep expertise in a single area over time.</div>
	</div>	
	<div class="modal_popup" id="modal_q8">
		<div class="intro">Use drag and drop to rank/order your items on the list.</div>
		<div><span>Business Need</span><br>A spot opened up, or the company has hired so many new people that it needs more supervisors/managers.</div>
		<div><span>Time at Level</span><br>You've put in the time, now it's your turn to be in the sweet spot.</div>
		<div><span>Skills Qualification</span><br>You are able to do the job well and have the required certifications, degrees, training, and knowledge.</div>
		<div><span>Increased Responsibilities</span><br>You have demonstrated the ability to do your job and take on other responsibilities.</div>
		<div><span>Leadership Readiness</span><br>You have displayed the characteristics required to lead and be successful in the new role.</div>
		<div><span>Job Performance Compared to Peers</span><br>You are the top performer based on quality and outcome of work products and deliverables.</div>
	</div>	
	<div class="modal_popup" id="modal_q9">
		<div>Choose one of the two choices presented that best match your work environment preferences.</div>
	</div>	
	<div class="modal_popup" id="modal_q10">
		<div class="intro">Use drag and drop to rank/order your items on the list.</div>
		<div>There are many ways to be rewarded for a job well done. Rank your most preferred method of recognition at the top of the list.</div>
	</div>
	<div class="modal_popup" id="modal_q11">
		<div class="intro">Use drag and drop to rank/order your items on the list.</div>
		<div>We all have different preferences and skillsets.  Some of us are more interested in working with the community, while others prefer using their creativity.  By using more of your natural strengths at work, you'll make it more enjoyable.</div>
	</div>	
	<div class="modal_popup" id="modal_q12">
		<div>When you have a conversation, what is your usual communication style?</div>
	</div>	
	<div class="modal_popup" id="modal_q13">
		<div class="intro">Use drag and drop to rank/order your items on the list.</div>
		<div>If you don't know something, you will naturally take steps to find the answer.  What is your usual process, in order of your first option to last?</div>
	</div>	
	<div class="modal_popup" id="modal_q14">
		<div>What do you want and expect from your ideal supervisor?</div>
	</div>
	<div class="modal_popup" id="modal_q15">
		<div class="intro">If you were in a position of leadership, which of the following would most closely match your leadership style?</div>
		<div><span>Open Dialogue</span><br>Direction comes from the top, but the lines of communication remain open for questions, comments, and feedback from workers.</div>
		<div><span>Group Facilitation</span><br>Management works with the team to generate the plan through an interactive brainstorming session.</div>
		<div><span>Top-Down Directive</span><br>A clear and non-negotiable plan is delivered to the team from management.</div>
	</div>	
	<div class="modal_popup" id="modal_q16">
		<div>What are the characteristics of the kind of people you like to be around, especially in a work setting?</div>
	</div>	
	<div class="modal_popup" id="modal_q17">
		<div class="intro">What's the most important aspect of your work?</div>
		<div><span>Working with people I like to be around</span><br>The most important thing to you is working with a great team of people that you get along with and likely spend time with outside of work.</div>
		<div><span>Working on things I am passionate about</span><br>What you work on is the most important thing to you.  Money and prestige are lower in priority.</div>
		<div><span>Working where I can make lots of money</span><br>The amount of money you make is your main motivator.  You'd be willing to do something you aren't passionate about, or work with a team that isn't that great, as long as the money is good.</div>
		<div><span>Working at a reputable company</span><br>You want to be associated with a company that is well known, successful, and impressive.  You want to be proud to tell people where you work.</div>
		<div><span>Working to live not live to work</span><br>Your life is not centered around or defined by your job.  You merely work to pay your bills; your focus is outside of work</div>
	</div>
	<div class="modal_popup" id="modal_q18">
		<div>Depending on your interests, select up to 5 industries you could see yourself enjoying a successful career in.</div>
	</div>
	<div class="modal_popup" id="modal_q19">
		<div>The city you work in can be just as important as the company you work for. Being close to family, friends and home can make or break your decision to take a job. 
		On the other hand, you may be looking for new adventures in various cities around the world.  Choose up to 5 cities you want to work in?</div>
	</div>
	<div class="modal_popup" id="modal_q20">
		<div>Your education and/or work history plays a part in determining company fit.  Use the happiness rating for each company to indicate the type of companies you thrive in.</div>
	</div>
	<div class="content">
		<form id="criteria" action="preview" method="post">
			<div id="intro" class="questions">
				<div id="intro">
					<p>Before you begin, we want to give you a quick overview of what to expect.</p>
					<div>
						<div id="questions_layout">
							<span>The Journey</span>
							<div><div id="textDecor">20</div>You&#39;re going to be presented with 20 questions - don&#39;t worry, they&#39;re pretty fun &amp; easy.
							Here are a few key elements that will help you as you answer the questions.</div>
							<img src="<?php echo base_url() ?>assets/images/survey/instructions.png">
						</div>
						<div id="questions_preview">
							<span>The Destination</span>
							<div><div id="textDecor"><img src="<?php echo base_url() ?>assets/images/progressIcon.png" height=50px></div>
								When you finish, you&#39;ll get a ranked list of top companies that fit you best.  You can then login or create an account to check out the entire list and apply for jobs!
							</div>
							<img src="<?php echo base_url() ?>assets/images/survey/instructions_preview.png">
						</div>
					</div>
					
				</div>
			</div>
			<div id="1" class="questions" name="multipleChoice">
				<div id="hints_q1_1" class="bubble">
					<div class="bubbleTitle">Navigation</div>
					<div class="bubbleContent">See what question you're on and hints for how to answer each question.</div>
					<div class="gotIt">Got It!</div>
					<div id="hints_q1_1_arrow_border"></div>
					<div id="hints_q1_1_arrow"></div>
				</div>
				<div id="hints_q1_2" class="bubble">
					<div class="bubbleTitle">Navigation</div>
					<div class="bubbleContent">Click on the progress bar if you need to go back.</div>
					<div class="gotIt">Got It!</div>
					<div id="hints_q1_2_arrow_border"></div>
					<div id="hints_q1_2_arrow"></div>
				</div>
				<div id="hints_q1_3" class="bubble">
					<div class="bubbleTitle">Navigation</div>
					<div class="bubbleContent">Use the <font style="font-style:italic;" class="blue">Quick Tip</font> icon to help you learn more about each question.</div>
					<div class="gotIt">Got It!</div>
					<div id="hints_q1_3_arrow_border"></div>
					<div id="hints_q1_3_arrow"></div>
				</div>			
				<div><div class="bulb" onclick="modal('#modal_q1','600','35');"></div><font class="blue">Select the type of companies you want to work for:</font></div>
				<ul id="co_type">
					<li id="q1_1"></li>
					<li id="q1_2"></li>
					<li id="q1_3"></li>
					<li id="q1_4"></li>
				</ul>
				<input id="q1_1_0" type="checkbox" value="1" name="user_type[]" >
				<input id="q1_2_0" type="checkbox" value="2" name="user_type[]" >
				<input id="q1_3_0" type="checkbox" value="3" name="user_type[]" >
				<input id="q1_4_0" type="checkbox" value="4" name="user_type[]" >
				<div id="q1_flag" style="display: none;"></div>
			</div>
			<div id="2" class="questions" name="multipleChoice">
				<div><div class="bulb" onclick="modal('#modal_q2','600','35');"></div><font class="blue">Select the pace of the company you want to work in:</font></div>
				<ul id="co_pace">
					<li id="q2_1">Slow</li>
					<li id="q2_2">Medium</li>
					<li id="q2_3">Fast</li>
				</ul>
				<input id="q2_1_0" type="checkbox" value="1" name="user_pace[]">
				<input id="q2_2_0" type="checkbox" value="2" name="user_pace[]">
				<input id="q2_3_0" type="checkbox" value="3" name="user_pace[]">
				<div id="q2_flag" style="display: none;"></div>
			</div>
			<div id="3" class="questions" name="multipleChoice">
				<div><div class="bulb" onclick="modal('#modal_q3','600','35');"></div><font class="blue">Select the life cycle of the companies you want to work in:</font></div>
				<div id="co_cycle_header"></div>
				<ul id="co_cycle">
					<li id="q3_1"></li>
					<li id="q3_2"></li>
					<li id="q3_3"></li>
					<li id="q3_4"></li>
					<li id="q3_5"></li>
				</ul>
				<input id="q3_1_0" type="checkbox" value="1" name="user_lifecycle[]" >
				<input id="q3_2_0" type="checkbox" value="2" name="user_lifecycle[]" >
				<input id="q3_3_0" type="checkbox" value="3" name="user_lifecycle[]" >
				<input id="q3_4_0" type="checkbox" value="4" name="user_lifecycle[]" >
				<input id="q3_5_0" type="checkbox" value="5" name="user_lifecycle[]" >
				<div id="q3_flag" style="display: none;"></div>
			</div>
			<div id="4" class="questions" name="rankChoice">
				<div id="hints_q4_1" class="bubble">
					<div class="bubbleTitle">Drag &amp; Drop</div>
					<div class="bubbleContent">Rank your desired benefits by clicking and dragging elements to a new spot within the list.<br><img src="<?php echo base_url() ?>assets/images/survey/drag_drop.png" alt="Drag and Drop" /></div>
					<div class="gotIt">Got It!</div>
					<div id="hints_q4_1_arrow_border"></div>
					<div id="hints_q4_1_arrow"></div>
				</div>		
				<div><div class="bulb" onclick="modal('#modal_q4','600','35');"></div><font class="blue">Rank the following company benefits &amp; perks you find important:</font></div>
				<div id="benefits_bar"></div>
				<ul id="co_benefits">
					<li id="q4_10"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Training / Education Reimbursement</li>
					<li id="q4_11"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Matching 401(k) Plans</li>
					<li id="q4_2"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Child Care</li>
					<li id="q4_1"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Health Care</li>
					<li id="q4_7"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Paid Time Off</li>
					<li id="q4_13"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Free Meals</li>
					<li id="q4_12"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Bonus / Profit Sharing</li>
					<li id="q4_3"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Maternity / Paternity Leave</li>
					<li id="q4_16"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Casual Dresscode</li>
					<li id="q4_14"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Paid Overtime</li>
					<li id="q4_15"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Pet Friendly</li>
					<li id="q4_8"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Paid Sabbatical</li>
					<li id="q4_5"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Dependent Care Support</li>
					<li id="q4_4"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Fitness Facilities / Membership</li>
					<li id="q4_6"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Telecommunting / Alternative Work Sites</li>
					<li id="q4_9"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Compressed Workweek / Flexible Work Schedule</li>
					
				</ul>
					<input id="q4_10_0" type="text" class="hide" name="user_benefits[10][rank]"  value="16">
					<input id="q4_11_0" type="text" class="hide" name="user_benefits[11][rank]"  value="15">
					<input id="q4_2_0" type="text" class="hide" name="user_benefits[2][rank]"  value="14">
					<input id="q4_1_0" type="text" class="hide" name="user_benefits[1][rank]"  value="13">
					<input id="q4_13_0" type="text" class="hide" name="user_benefits[13][rank]"  value="12">
					<input id="q4_12_0" type="text" class="hide" name="user_benefits[12][rank]"  value="11">
					<input id="q4_3_0" type="text" class="hide" name="user_benefits[3][rank]"  value="10">
					<input id="q4_16_0" type="text" class="hide" name="user_benefits[16][rank]"  value="9">
					<input id="q4_14_0" type="text" class="hide" name="user_benefits[14][rank]"  value="8">
					<input id="q4_15_0" type="text" class="hide" name="user_benefits[15][rank]"  value="7">
					<input id="q4_4_0" type="text" class="hide" name="user_benefits[4][rank]"  value="6">
					<input id="q4_5_0" type="text" class="hide" name="user_benefits[5][rank]"  value="5">
					<input id="q4_6_0" type="text" class="hide" name="user_benefits[6][rank]"  value="4">
					<input id="q4_8_0" type="text" class="hide" name="user_benefits[8][rank]"  value="3">
					<input id="q4_9_0" type="text" class="hide" name="user_benefits[9][rank]"  value="2">
					<input id="q4_7_0" type="text" class="hide" name="user_benefits[7][rank]"  value="1">
					<div id="q4_flag" style="display: none;"></div>
			</div>
			<div id="5" class="questions" name="singleChoice">
				<div><div class="bulb" onclick="modal('#modal_q5','600','35');"></div><font class="blue">How important is corporate citizenship to you?</font></div>
				<div class="sliderSelected"></div>
				<div id="citizenshipSlider" style="background: none; border: none; cursor: pointer;"></div>
				<div class="slider5Markers">
					<ul>
						<li class="right5Marker">Not<br>Important</li>
						<li class="right5Marker">Somewhat Important</li>
						<li class="right5Marker">Important</li>
						<li class="right5Marker">Very Important</li>
						<li>Extremely Important</li>
					</ul>
				</div>
				<input id="q5_0" type="text" class="hide" name="user_citizenship" />
				<div id="q5_flag" style="display: none;"></div>
			</div>
			<div id="6" class="questions" name="singleChoice">
				<div><div class="bulb" onclick="modal('#modal_q6','600','35');"></div><font class="blue">How much traveling would you like to do for work?</font></div>
				<div class="sliderSelected"></div>
				<div id="travelSlider" style="background: none; border: none; cursor: pointer;"></div>
				<div class="slider5Markers">
					<ul>
						<li class="right5Marker">None</li>
						<li class="right5Marker">Once a<br> Year</li>
						<li class="right5Marker">Every<br>3 Months</li>
						<li class="right5Marker">Every<br>Month</li>
						<li>Every<br>Week</li>
					</ul>
				</div>
				<input id="q6_0" type="text" class="hide" name="user_travel" />
				<div id="q6_flag" style="display: none;"></div>
			</div>
			<div id="7" class="questions" name="singleChoice">
				<div><div class="bulb" onclick="modal('#modal_q7','600','35');"></div><font class="blue">How often do you want your roles &amp; responsibilities to change?</font></div>
				<div class="sliderSelected"></div>
				<div id="roleSlider" style="background: none; border: none; cursor: pointer;"></div>
				<div class="slider4Markers">
					<ul>
						<li class="right4Marker">Every<br>3+ Years</li>
						<li class="right4Marker">Every<br>1-3 Years</li>
						<li class="right4Marker">Every<br>12 Months</li>
						<li>Every<br>6 Months</li>
					</ul>
				</div>
				<input id="q7_0" type="text" class="hide" name="user_responsibilities" />
				<div id="q7_flag" style="display: none;"></div>
			</div>
			<div id="8" class="questions" name="rankChoice">
				<div><div class="bulb" onclick="modal('#modal_q8','600','35');"></div><font class="blue">What should matter most to management in deciding on promotion?</font></div>
				<div id="promotion_bar"></div>
				<ul id="co_promotion">
					<li id="q8_6"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Business Need</li>
					<li id="q8_5"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Time at Level</li>
					<li id="q8_4"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Skills Qualification</li>
					<li id="q8_3"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Increased Responsibilities</li>
					<li id="q8_2"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Leadership Readiness</li>
					<li id="q8_1"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Job Performance</li>
				</ul>
					<input id="q8_6_0" type="text" class="hide" name="user_promotion[6][rank]"  value="6">
					<input id="q8_5_0" type="text" class="hide" name="user_promotion[5][rank]"  value="5">
					<input id="q8_4_0" type="text" class="hide" name="user_promotion[4][rank]"  value="4">
					<input id="q8_3_0" type="text" class="hide" name="user_promotion[3][rank]"  value="3">
					<input id="q8_2_0" type="text" class="hide" name="user_promotion[2][rank]"  value="2">
					<input id="q8_1_0" type="text" class="hide" name="user_promotion[1][rank]"  value="1">
					<div id="q8_flag" style="display: none;"></div>
			</div>
			<div id="9" class="questions"  name="singleChoice">
				<div><div class="bulb" onclick="modal('#modal_q9','600','35');"></div><font class="blue">Which type of work environment allows you to do your best work?</font></div>
				<div id="envQuestions">
					<div class="env">
						<div id="q9_1" class="envAnswer1">Supportive</div><div class="or">- or -</div><div id="q9_2" class="envAnswer2">Independent</div>
					</div>
					<div class="env">
						<div id="q9_3" class="envAnswer1">Customer-Focused</div><div class="or">- or -</div><div id="q9_4" class="envAnswer2">Product-Focused</div>
					</div>
					<div class="env">
						<div id="q9_5" class="envAnswer1">Quiet</div><div class="or">- or -</div><div id="q9_6" class="envAnswer2">Lively</div>
					</div>
					<div class="env">
						<div id="q9_7" class="envAnswer1">Family Oriented</div><div class="or">- or -</div><div id="q9_8" class="envAnswer2">Business Oriented</div>
					</div>
					<div class="env">
						<div id="q9_9" class="envAnswer1">Calm</div><div class="or">- or -</div><div id="q9_10" class="envAnswer2">Aggressive</div>
					</div>
					<div class="env">
						<div id="q9_11" class="envAnswer1">Planned</div><div class="or">- or -</div><div id="q9_12" class="envAnswer2">Adhoc</div>
					</div>
					<div class="env">
						<div id="q9_13" class="envAnswer1">Existing Technology</div><div class="or">- or -</div><div id="q9_14" class="envAnswer2">New Technology</div>
					</div>
					<div class="env">
						<div id="q9_15" class="envAnswer1">Open &amp; Transparent</div><div class="or">- or -</div><div id="q9_16" class="envAnswer2"> Hidden &amp; Undefined</div>
					</div>
					<div class="env">
						<div id="q9_17" class="envAnswer1">Structured</div><div class="or">- or -</div><div id="q9_18" class="envAnswer2">Relaxed</div>
					</div>
					<div class="env">
						<div id="q9_19" class="envAnswer1">High-Profile</div><div class="or">- or -</div><div id="q9_20" class="envAnswer2">Low-Key</div>
					</div>
				</div>
				<div id="harveyBall" class="clear"  name="singleChoice">
					<img  id="envProgressOverlay" src="<?php echo base_url() ?>assets/images/imgOverlay.png" alt="progress" usemap="#environmentMap" />
					<map name="environmentMap" id="environmentMap">
						  <area shape="poly" coords="64,62,64,4,82,6,98,15" alt="1 of 10" />
						  <area shape="poly" coords="64,63,99,16,112,28,119,44" alt="2 of 10" />
						  <area shape="poly" coords="64,63,119,45,123,63,119,81" alt="3 of 10" />
						  <area shape="poly" coords="64,63,119,81,111,98,98,110" alt="4 of 10" />
						  <area shape="poly" coords="64,64,98,111,82,120,64,122" alt="5 of 10" />
						  <area shape="poly" coords="63,65,63,122,44,119,29,111" alt="6 of 10" />
						  <area shape="poly" coords="63,63,29,111,15,98,8,81" alt="7 of 10" />
						  <area shape="poly" coords="63,63,8,81,4,63,7,46" alt="8 of 10" />
						  <area shape="poly" coords="63,64,8,46,14,31,27,17" alt="9 of 10" />
						  <area shape="poly" coords="64,63,27,17,44,6,64,4" alt="10 of 10" />
					</map>
				</div>
				<input id="q9_1_0" type="checkbox" value="1" name="user_environment[]" >
				<input id="q9_2_0" type="checkbox" value="2" name="user_environment[]" >
				<input id="q9_3_0" type="checkbox" value="3" name="user_environment[]" >
				<input id="q9_4_0" type="checkbox" value="4" name="user_environment[]" >
				<input id="q9_5_0" type="checkbox" value="5" name="user_environment[]" >
				<input id="q9_6_0" type="checkbox" value="6" name="user_environment[]" >
				<input id="q9_7_0" type="checkbox" value="7" name="user_environment[]" >
				<input id="q9_8_0" type="checkbox" value="8" name="user_environment[]" >
				<input id="q9_9_0" type="checkbox" value="9" name="user_environment[]" >
				<input id="q9_10_0" type="checkbox" value="10" name="user_environment[]" >
				<input id="q9_11_0" type="checkbox" value="11" name="user_environment[]" >
				<input id="q9_12_0" type="checkbox" value="12" name="user_environment[]" >
				<input id="q9_13_0" type="checkbox" value="13" name="user_environment[]" >
				<input id="q9_14_0" type="checkbox" value="14" name="user_environment[]" >
				<input id="q9_15_0" type="checkbox" value="15" name="user_environment[]" >
				<input id="q9_16_0" type="checkbox" value="16" name="user_environment[]" >
				<input id="q9_17_0" type="checkbox" value="17" name="user_environment[]" >
				<input id="q9_18_0" type="checkbox" value="18" name="user_environment[]" >
				<input id="q9_19_0" type="checkbox" value="19" name="user_environment[]" >
				<input id="q9_20_0" type="checkbox" value="20" name="user_environment[]" >
				<div id="q9_flag" style="display: none;"></div>
			</div>
			<div id="10" class="questions"  name="rankChoice">
				<div><div class="bulb" onclick="modal('#modal_q10','600','35');"></div><font class="blue">Rank your most preferred type of recognition for doing exceptional work:</font></div>
				<div id="recognition_bar"></div>
				<ul id="co_recognition">
					<li id="q10_6"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Team Dinners</li>
					<li id="q10_5"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Informal "Thank You"</li>
					<li id="q10_4"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Salary Compensation</li>
					<li id="q10_3"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Time with Senior Leadership</li>
					<li id="q10_2"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Public Recognition</li>
					<li id="q10_1"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Time Away from Work</li>
				</ul>
				<input id="q10_6_0" type="text" class="hide" name="user_recognition[6][rank]"  value="6">
				<input id="q10_5_0" type="text" class="hide" name="user_recognition[5][rank]"  value="5">
				<input id="q10_4_0" type="text" class="hide" name="user_recognition[4][rank]"  value="4">
				<input id="q10_3_0" type="text" class="hide" name="user_recognition[3][rank]"  value="3">
				<input id="q10_2_0" type="text" class="hide" name="user_recognition[2][rank]"  value="2">
				<input id="q10_1_0" type="text" class="hide" name="user_recognition[1][rank]"  value="1">
				<div id="q10_flag" style="display: none;"></div>
			</div>
			<div id="11" class="questions"  name="rankChoice">
				<div><div class="bulb" onclick="modal('#modal_q11','600','35');"></div><font class="blue">Rank the following type of tasks you typically enjoy working on:</font></div>
				<div id="task_bar"></div>
				<ul id="favTask">
					<li id="q11_6"><span class="ui-icon ui-icon-grip-dotted-vertical"></span><font>Physical</font><br>skill, strength, coordination, accuracy</li>
					<li id="q11_5"><span class="ui-icon ui-icon-grip-dotted-vertical"></span><font>Strategic</font><br>thinking, organizing, understanding</li>
					<li id="q11_4"><span class="ui-icon ui-icon-grip-dotted-vertical"></span><font>Creative</font><br>originality, imagination, innovation</li>
					<li id="q11_3"><span class="ui-icon ui-icon-grip-dotted-vertical"></span><font>Competitive</font><br>leadership, influence, selling, status</li>
					<li id="q11_2"><span class="ui-icon ui-icon-grip-dotted-vertical"></span><font>Orderly</font><br>routine, regulation, process, precision</li>
					<li id="q11_1"><span class="ui-icon ui-icon-grip-dotted-vertical"></span><font>Community</font><br>helping, healing, developing others</li>
				</ul>
				<input id="q11_6_0" type="text" class="hide" name="user_tasks[6][rank]"  value="6">
				<input id="q11_5_0" type="text" class="hide" name="user_tasks[5][rank]"  value="5">
				<input id="q11_4_0" type="text" class="hide" name="user_tasks[4][rank]"  value="4">
				<input id="q11_3_0" type="text" class="hide" name="user_tasks[3][rank]"  value="3">
				<input id="q11_2_0" type="text" class="hide" name="user_tasks[2][rank]"  value="2">
				<input id="q11_1_0" type="text" class="hide" name="user_tasks[1][rank]"  value="1">
				<div id="q11_flag" style="display: none;"></div>		
			</div>
			<div id="12" class="questions"  name="singleChoice">
				<div><div class="bulb" onclick="modal('#modal_q12','600','35');"></div><font class="blue">When communicating ...</font></div>
				<div id="communications" class="clear">
					<img id="communicationOverlay" src="<?php echo base_url() ?>assets/images/imgOverlay.png" alt="cloud" usemap="#communicationCloud" />
					<map name="communicationCloud" id="communicationCloud">
						<area shape="poly" coords="32,72,40,56,61,45,83,43,92,22,110,10,139,5,164,10,181,20,190,33,214,30,238,34,256,45,261,52,288,53,310,63,321,80,317,98,301,111,281,116,263,117,254,140,226,156,199,162,171,161,148,150,126,158,95,156,72,146,61,132,58,123,39,125,20,119,8,104,7,93,17,80"  href="#" />
						<area shape="poly" coords="440,104,467,107,487,117,500,132,521,129,544,132,561,141,571,151,593,151,616,158,630,176,628,193,608,209,589,215,573,214,567,233,546,250,513,260,482,259,457,248,435,256,400,253,378,242,367,222,347,222,325,214,315,198,322,179,343,170,348,155,367,144,393,141,400,123,418,110"  href="#" />
						<area shape="poly" coords="646,55,658,42,682,33,701,33,716,36,732,19,754,10,780,9,802,16,818,28,824,45,847,48,867,58,875,74,894,83,901,100,894,117,872,126,849,126,844,139,826,153,795,161,773,159,758,153,738,161,707,164,683,159,657,146,647,134,643,118,624,118,599,109,588,96,586,82,595,68,615,56,630,54"  href="#" />
						<area shape="poly" coords="243,257,268,253,292,258,307,267,315,276,341,275,358,284,370,294,374,309,366,326,349,336,329,341,318,340,310,357,292,373,268,383,232,385,201,374,176,381,148,380,128,371,115,358,110,347,91,347,68,339,58,324,62,309,72,301,86,295,94,279,111,268,133,266,144,247,164,234,187,229,212,232,231,243"  href="#" />
						<area shape="poly" coords="693,257,704,241,722,233,743,230,762,231,782,239,796,251,801,265,817,267,834,273,845,281,849,295,865,302,873,310,877,325,870,337,857,345,841,349,825,347,820,360,807,373,786,381,759,381,735,373,711,383,681,386,645,375,625,358,619,338,596,339,572,327,563,315,561,303,572,287,594,276,612,275,623,277,634,262,653,253,671,252"  href="#" />
					</map>
				</div>
				<input id="q12_0" type="text" class="hide" name="user_communication" />
				<div id="q12_flag" style="display: none;"></div>
			</div>
			<div id="13" class="questions"  name="rankChoice">
				<div><div class="bulb" onclick="modal('#modal_q13','600','35');"></div><font class="blue">If you don't know something about your job, what are the<br>steps you would take to find the answers?</font></div>
				<div id="steps_bar"></div>
				<ul id="resource">
					<li id="q13_5"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Search the Internet</li>
					<li id="q13_4"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Search Company Internal Websites</li>
					<li id="q13_3"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Find a Relevant Book</li>
					<li id="q13_2"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Ask Direct Supervisor / Manager</li>
					<li id="q13_1"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Ask Co-Workers</li>
				</ul>
				<input id="q13_5_0" type="text" class="hide" name="user_resource[5][rank]"  value="5">
				<input id="q13_4_0" type="text" class="hide" name="user_resource[4][rank]"  value="4">
				<input id="q13_3_0" type="text" class="hide" name="user_resource[3][rank]"  value="3">
				<input id="q13_2_0" type="text" class="hide" name="user_resource[2][rank]"  value="2">
				<input id="q13_1_0" type="text" class="hide" name="user_resource[1][rank]"  value="1">
				<div id="q13_flag" style="display: none;"></div>
			</div>
			<div id="14" class="questions"  name="singleChoice">
				<div><div class="bulb" onclick="modal('#modal_q14','600','35');"></div><font class="blue">Which of the following is most effective role of a supervisor:</font></div>
				<div id="supervisor" class="clear">
					<img id="supervisorOverlay" src="<?php echo base_url() ?>assets/images/imgOverlay.png" alt="cloud" usemap="#supervisorCloud" />
					<map name="supervisorCloud" id="supervisorCloud">
						<area shape="poly" coords="84,47,88,35,98,24,110,16,127,11,141,10,158,12,172,18,186,27,192,37,210,35,225,34,240,39,252,44,263,56,289,57,305,63,318,73,324,88,319,100,307,111,295,117,280,120,266,120,260,136,246,151,228,160,209,165,188,166,168,163,150,155,132,161,112,163,88,158,74,149,65,138,60,128,42,129,26,124,13,113,8,101,13,86,23,78,37,77,39,64,53,53,67,49" href="#" />
						<area shape="poly" coords="379,131,383,117,394,107,409,97,427,93,446,94,460,97,474,105,487,122,503,117,521,118,540,124,551,132,558,140,578,139,598,145,612,157,618,169,613,186,598,198,581,203,560,203,555,221,538,236,519,246,492,249,468,246,445,238,425,244,400,245,373,237,361,224,353,210,337,213,314,205,303,193,304,176,315,165,331,159,334,143,354,131" href="#" />
						<area shape="poly" coords="649,60,656,48,673,38,697,36,717,41,730,26,751,15,775,12,795,15,816,27,824,39,826,48,848,51,863,57,872,66,877,79,893,86,902,97,901,110,891,124,868,131,851,130,844,145,826,158,798,165,778,163,761,158,743,164,722,168,696,165,671,157,655,144,645,122,626,121,605,115,588,98,588,80,601,67,625,58" href="#" />
						<area shape="poly" coords="94,236,101,218,117,206,136,200,155,199,174,203,189,210,201,226,220,223,241,225,259,231,273,246,293,245,313,250,326,260,332,274,325,295,304,307,275,309,268,328,247,345,215,355,183,353,159,344,141,350,112,350,87,341,74,329,68,315,49,318,28,310,17,291,26,273,43,266,55,246,76,237" href="#" />
						<area shape="poly" coords="380,327,392,314,412,305,435,304,451,308,463,291,486,282,512,281,531,285,549,296,555,307,557,317,576,318,593,324,603,334,607,345,619,351,631,361,634,374,626,387,611,398,594,399,583,397,578,410,561,424,541,431,518,433,504,429,493,425,470,434,437,435,408,428,388,415,379,401,377,390,352,389,331,380,321,368,320,353,335,334,359,326" href="#" />
						<area shape="poly" coords="664,240,678,226,699,218,716,217,735,222,749,205,770,196,796,193,818,199,835,210,844,231,864,232,882,240,890,250,893,260,909,267,919,279,919,290,909,304,889,312,869,311,861,325,840,340,812,345,790,343,777,338,754,347,722,349,697,343,676,329,666,317,662,302,646,303,626,297,614,288,605,274,609,258,623,246,643,240" href="#" />
					</map> 
				</div>
				<input id="q14_0" type="text" class="hide" name="user_supervisor" />
				<div id="q14_flag" style="display: none;"></div>
			</div>
			<div id="15" class="questions" name="singleChoice">
				<div><div class="bulb" onclick="modal('#modal_q15','600','35');"></div><font class="blue">How would you effectively lead a team?</font></div>
				<div id="leadership" class="clear">
					<img id="leadershipOverlay" src="<?php echo base_url() ?>assets/images/imgOverlay.png" alt="cloud" usemap="#leadershipCloud" />
					<map name="leadershipCloud" id="leadershipCloud">
						<area shape="rect" coords="1,1,324,418" href="#" />
						<area shape="rect" coords="324,1,648,418" href="#" />
						<area shape="rect" coords="648,-1,972,418" href="#" />
					</map>
				</div>
				<input id="q15_0" type="text" class="hide" name="user_leadership" />
				<div id="q15_flag" style="display: none;"></div>
			</div>
			<div id="16" class="questions" name="clickChoice">
				<div><div class="bulb" onclick="modal('#modal_q16','600','35');"></div><font class="blue">Pick the top 5 traits of people you enjoy being around:</font></div>
				<div id="traits">				
					<div id="q16_1">Competent</div>
					<div id="q16_2">Patient</div>
					<div id="q16_3">Dependable</div>
					<div id="q16_4">Loyal</div>
					<div id="q16_5">Respectful</div>
					<div id="q16_6">Calm</div>
					<div id="q16_7">Intelligent</div>
					<div id="q16_8">Creative</div>
					<div id="q16_9">Supportive</div>
					<div id="q16_10">Ambitious</div>
					<div id="q16_11">Genuine</div>
					<div id="q16_12">Courageous</div>
					<div id="q16_13">Collaborative</div>
					<div id="q16_14">Passionate</div>
					<div id="q16_15">Energetic</div>
					<div id="q16_16">Assertive</div>
					<div id="q16_17">Clever</div>
					<div id="q16_18">Inspiring</div>
					<div id="q16_19">Confident</div>
					<div id="q16_20">Humorous</div>
				</div>
				<input id="q16_1_0" type="checkbox" value="1" name="user_traits[]" >
				<input id="q16_2_0" type="checkbox" value="2" name="user_traits[]" >
				<input id="q16_3_0" type="checkbox" value="3" name="user_traits[]" >
				<input id="q16_4_0" type="checkbox" value="4" name="user_traits[]" >
				<input id="q16_5_0" type="checkbox" value="5" name="user_traits[]" >
				<input id="q16_6_0" type="checkbox" value="6" name="user_traits[]" >
				<input id="q16_7_0" type="checkbox" value="7" name="user_traits[]" >
				<input id="q16_8_0" type="checkbox" value="8" name="user_traits[]" >
				<input id="q16_9_0" type="checkbox" value="9" name="user_traits[]" >
				<input id="q16_10_0" type="checkbox" value="10" name="user_traits[]" >
				<input id="q16_11_0" type="checkbox" value="11" name="user_traits[]" >
				<input id="q16_12_0" type="checkbox" value="12" name="user_traits[]" >
				<input id="q16_13_0" type="checkbox" value="13" name="user_traits[]" >
				<input id="q16_14_0" type="checkbox" value="14" name="user_traits[]" >
				<input id="q16_15_0" type="checkbox" value="15" name="user_traits[]" >
				<input id="q16_16_0" type="checkbox" value="16" name="user_traits[]" >
				<input id="q16_17_0" type="checkbox" value="17" name="user_traits[]" >
				<input id="q16_18_0" type="checkbox" value="18" name="user_traits[]" >
				<input id="q16_19_0" type="checkbox" value="19" name="user_traits[]" >
				<input id="q16_20_0" type="checkbox" value="20" name="user_traits[]" >
				<div id="q16_flag" style="display: none;"></div>
			</div>
			<div id="17" class="questions"  name="singleChoice">
				<div><div class="bulb" onclick="modal('#modal_q17','600','35');"></div><font class="blue">I want to work ________</font></div>
				<div id="motivation" class="clear">
					<img id="motivationOverlay" src="<?php echo base_url() ?>assets/images/imgOverlay.png" alt="cloud" usemap="#motivationCloud" />
					<map name="motivationCloud" id="motivationCloud">
						<area shape="poly" coords="32,72,40,56,61,45,83,43,92,22,110,10,139,5,164,10,181,20,190,33,214,30,238,34,256,45,261,52,288,53,310,63,321,80,317,98,301,111,281,116,263,117,254,140,226,156,199,162,171,161,148,150,126,158,95,156,72,146,61,132,58,123,39,125,20,119,8,104,7,93,17,80"  href="#" />
						<area shape="poly" coords="440,104,467,107,487,117,500,132,521,129,544,132,561,141,571,151,593,151,616,158,630,176,628,193,608,209,589,215,573,214,567,233,546,250,513,260,482,259,457,248,435,256,400,253,378,242,367,222,347,222,325,214,315,198,322,179,343,170,348,155,367,144,393,141,400,123,418,110"  href="#" />
						<area shape="poly" coords="646,55,658,42,682,33,701,33,716,36,732,19,754,10,780,9,802,16,818,28,824,45,847,48,867,58,875,74,894,83,901,100,894,117,872,126,849,126,844,139,826,153,795,161,773,159,758,153,738,161,707,164,683,159,657,146,647,134,643,118,624,118,599,109,588,96,586,82,595,68,615,56,630,54"  href="#" />
						<area shape="poly" coords="243,257,268,253,292,258,307,267,315,276,341,275,358,284,370,294,374,309,366,326,349,336,329,341,318,340,310,357,292,373,268,383,232,385,201,374,176,381,148,380,128,371,115,358,110,347,91,347,68,339,58,324,62,309,72,301,86,295,94,279,111,268,133,266,144,247,164,234,187,229,212,232,231,243"  href="#" />
						<area shape="poly" coords="693,257,704,241,722,233,743,230,762,231,782,239,796,251,801,265,817,267,834,273,845,281,849,295,865,302,873,310,877,325,870,337,857,345,841,349,825,347,820,360,807,373,786,381,759,381,735,373,711,383,681,386,645,375,625,358,619,338,596,339,572,327,563,315,561,303,572,287,594,276,612,275,623,277,634,262,653,253,671,252"  href="#" />
					</map>
				</div>
				<input id="q17_0" type="text" class="hide" name="user_motivation" />
				<div id="q17_flag" style="display: none;"></div>
			</div>
			<div id="18" class="questions q18"  name="textChoice">
				<div><div class="bulb" onclick="modal('#modal_q18','600','35');"></div><font class="blue">Which industry or field do you want to work in?</font></div>
				<div class="clear" id="industryBlock">				
					<input type="hidden" id="industry_0" name="user_industry_placeholder[]" data-placeholder="Type and select up to five choices..." />
				</div>
				<div id="q18_flag" style="display: none;"></div>
			</div>		
			<div id="19" class="questions q19"  name="textChoice">
				<div><div class="bulb" onclick="modal('#modal_q19','600','35');"></div><font class="blue">Which U.S. cities would you like to work in?</font></div>
				<div class="clear" id="locationBlock">			
					<input type="hidden" id="location_0" name="user_location_placeholder[]" data-placeholder="Type and select up to five choices..." />
				</div>
				<div id="q19_flag" style="display: none;"></div>
			</div>
			<div id="20" class="questions q20"  name="textChoice">
				<div><div class="bulb" onclick="modal('#modal_q20','600','35');"></div><font class="blue">What's your education and work history?</font></div>
				<div id="history" class="clear">
					<div>
						<div id="education_layout">
							<p class="titles">Education</p>
							<div class="details">
								<ul class="history_master">
									<li><label>School</label>
									<input type="hidden" id="school_name0" name="user_education_placeholder[0][school_name]" data-placeholder="Select school name...">
									<input type="hidden" name="user_education[0][school_id]" value="">
									<input type="hidden" name="user_education[0][school_name]" value="">
									</li>								
									<li><label>Degree</label>
									<input type="hidden" id="degree_name0" name="user_education_placeholder[0][degree_name]" data-placeholder="Select degree...">
									<input type="hidden" name="user_education[0][degree_id]" value="">
									<input type="hidden" name="user_education[0][degree_name]" value="">
									</li>
									<li><label>Field of Study</label>
									<input type="hidden" id="field_name0" name="user_education_placeholder[0][field_name]" data-placeholder="Select field of study...">
									<input type="hidden" name="user_education[0][field_id]" value="">
									<input type="hidden" name="user_education[0][field_name]" value="">
									<li class="history_sets"><label>Time Period</label><select name="user_education[0][start_month]" class="month0"></select>
										<select name="user_education[0][start_year]" class="year0"></select> &ndash; <select name="user_education[0][end_month]" class=" month0"></select> 
										<select name="user_education[0][end_year]" class="year0"></select>
									</li>
								</ul>
								<div class="addButton" id="addEducation"> </div>
							</div>
						</div>
						<div id="experience_layout">
							<p class="titles">Work Experience</p>
							<div class="details"> 
								<ul class="history_master">
									<li><label>Company</label>
									<input type="hidden" id="company0" name="user_work_placeholder[0][company_name]" data-placeholder="Select company...">
									<input type="hidden" name="user_work[0][company_id]" value="">
									<input type="hidden" name="user_work[0][company_name]" value="">
									</li>
									<li><label>Job</label>
									<input type="hidden" id="job0" name="user_job_placeholder[0][job_type]" data-placeholder="Select job type...">
									<input type="hidden" name="user_work[0][job_id]" value="">
									<input type="hidden" name="user_work[0][job_type]" value="">									
									</li>
									<li class="happiness"><label class="happiness_label">Happiness</label><div class="happiness_stars"></div></li>
									<li class="history_sets">
										<label>Time Period</label><select name="user_work[0][start_month]" class=" month0"></select>
										<select name="user_work[0][start_year]" class="year0"></select> 
										&ndash; <span class="presentFlag" style="display: none;">Present</span>
										<select name="user_work[0][end_month]" class="month0 endDateFlag"></select> <select name="user_work[0][end_year]" class="year0 endDateFlag"></select>
										<span class="presentText">I currently work here</span><input type="checkbox" name="user_work[0][current]" value="0" />
									</li>
								</ul>
								<div class="addButton" id="addWork"> </div>
							</div>
							
						</div>
					</div>
				</div>
				<div id="q20_flag" style="display: none;"></div>
			</div>
			<div id="progressBar">
				<ul>
					<li class="progress ip"></li>
					<li class="progress"></li>
					<li class="progress"></li>
					<li class="progress"></li>
					<li class="progress"></li>
					<li class="progress"></li>
					<li class="progress"></li>
					<li class="progress"></li>
					<li class="progress"></li>
					<li class="progress"></li>
					<li class="progress"></li>
					<li class="progress"></li>
					<li class="progress"></li>
					<li class="progress"></li>
					<li class="progress"></li>
					<li class="progress"></li>
					<li class="progress"></li>
					<li class="progress"></li>
					<li class="progress"></li>
					<li class="progress"></li>
				</ul>
			</div>
		</form>
	</div>
	<div class="preload">
		<img src="<?php echo base_url() ?>assets/images/survey/slider_4markers.jpg">
		<img src="<?php echo base_url() ?>assets/images/survey/harvey_ball_10.png">
		<img src="<?php echo base_url() ?>assets/images/survey/recognition_bar.png">
		<img src="<?php echo base_url() ?>assets/images/survey/politics.jpg">
		<img src="<?php echo base_url() ?>assets/images/survey/task_bar.png">		
		<img src="<?php echo base_url() ?>assets/images/survey/communication.jpg">
		<img src="<?php echo base_url() ?>assets/images/survey/resourceSteps.png">
		<img src="<?php echo base_url() ?>assets/images/survey/supervisor.jpg">
		<img src="<?php echo base_url() ?>assets/images/survey/true_false.png">
		<img src="<?php echo base_url() ?>assets/images/survey/respect.jpg">
		<img src="<?php echo base_url() ?>assets/images/survey/leadership.jpg">
		<img src="<?php echo base_url() ?>assets/images/survey/motivation.jpg">
		<img src="<?php echo base_url() ?>assets/images/progressIcon.png">
		<img src="<?php echo base_url() ?>assets/images/preview.png">
		<img src="<?php echo base_url() ?>assets/images/netapp.png">
	</div>
</div>
