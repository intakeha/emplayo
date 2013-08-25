<script>

  $(function() {
	$("div#settings ul#menu li").mouseenter(function() {
		if (!$(this).hasClass("selected")){
			$(this).find('div').hide();
		}
	}).mouseleave(function() {
		$(this).find('div').show();
	});
	
	$("div#settings ul#menu li").on("click", function(event){
		if (!$(this).hasClass("selected")){
			var crumbs = $(this).attr('name');
			$("div#settings div#crumbs").append(" &raquo; "+crumbs);
			$(this).addClass("selected");
			$("div#settings ul#menu li").fadeOut();
			$("div#settings ul#menu li.selected").fadeIn('fast', function() {
				$("div#settings div#crumbs, div#settings div#panel").fadeIn();
				switch($(this).attr('id'))
				{
					case 'key':
						$("div#settings div#password_update").fadeIn();
						break;
					case 'work':
						$("div#settings div#work_update").fadeIn();
						break;
					case 'education':
						$("div#settings div#education_update").fadeIn();
						break;
					case 'location':
						$("div#settings div#location_update").fadeIn();
						break;
					case 'industry':
						$("div#settings div#industry_update").fadeIn();
						break;
					case 'prefs':
						$("div#settings div#prefs_update").fadeIn();
						break;
					case 'notification':
						$("div#settings div#notification_update").fadeIn();
						break;						
					default:
						break;
				}
				
			});
		}
	});
	
	// Change password ajax call
	
	$('#password_update form').submit(function(e){
		e.preventDefault();
		$.post(
			"settings/change_password", 
			$("#password_update form").serialize(),
			function(data){
				$('#infoMessage').html(data.message);
				$('#password_update form').find("input[type=password]").val("");
			},
			"json"
		);
	});
	
	company_ratings('.happiness', 'user_work[0][rating]');  // Initiate stars rating
	dateSelect('select.prefill'); // Change font color when selected
	monthDropdown('#work_update .month');
	yearDropdown('#work_update .year');
	presentFlagSettings();
	educationHistoryTypeahead(0);
	workHistoryTypeahead(0);
	
	$('#work_update .addButton').on("click", function(event){
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
			company_ratings($(this).parent().find('.happiness').eq(experienceRef), "user_work["+experienceRef+"][rating]");
			workHistoryTypeahead(experienceRef);
		}
		dateSelect('#work_update .prefill');
		monthDropdown('#work_update .monthEmpty');
		yearDropdown('#work_update .yearEmpty');
		presentFlagSettings();
		
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
	
  });    
  
  function company_ratings(containerID, scoreID){ // initialize raty
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
		width: 600,
		space: false,
		scoreName: scoreID,
		targetType: 'number',
		targetKeep: true
	});
};

function presentFlagSettings(){
	$("#work_update input[type='checkbox']").on("change",function(event){
		if ($(this).prop('checked')){
			$(this).parent().find('.endDateFlag').hide();
			$(this).parent().find('.presentFlag').show();
		}else{
			$(this).parent().find('.endDateFlag').show();
			$(this).parent().find('.presentFlag').hide();
		};
	});
};
    
</script>

<div id="settings">
	<div class="content">
		<ul id="menu">
			<li id="key" name="Change Password"><div>Change Password</div></li>
			<li id="work" name="Work History" style="display: none;"><div>Work<br/>History</div></li>
			<li id="education" name="Education" style="display: none;"><div>Education</div></li>
			<li id="location" name="Location" style="display: none;"><div>Location</div></li>
			<li id="industry" name="Industry Preference" style="display: none;"><div>Industry Preference</div></li>
			<li id="prefs" name="Job Preference"><div>Retake Survey</div></li>
			<li id="notification" name="Notifications" style="display: none;"><div>Notifications</div></li>
		</ul>
		<div id="crumbs"><a href="settings">Account Settings</a></div>
		<div id="panel">
			<div id="password_update" style="display: none;">
				<?php echo form_open("settings/change_password");?>
					<fieldset>
						<label for="old">Old Password</label>
						<?php echo form_input($old_password);?>
						<label for="new">New Password</label>
						<?php echo form_input($new_password);?>
						<label for="confirm">Confirm New Password</label>
						<?php echo form_input($new_password_confirm);?>
						<?php echo form_input($user_id);?>
						<input type="submit" class="buttons save float_right" value="Save" />
						<a class="buttons cancel float_right" href="settings">Cancel</a>
					</fieldset>
				<?php echo form_close();?>
				<div id="infoMessage"><?php echo $message;?></div>
			</div>
			
			<div id="work_update" style="display: none;">
				<div id="experience_layout">
					<div class="details"> 
						<ul>
							<li><label>Company</label><input class="text_form company0" type="text" maxlength="150" name="user_work[0][company_name]"><input type="hidden" name="user_work[0][company_id]" value=""></li>
							<li><label>Job</label><input class="text_form job0" type="text" maxlength="150" name="user_work[0][job_type]"><input type="hidden" name="user_work[0][job_id]" value=""></li>
							<li><label class="happiness_label">Happiness</label><div class="happiness"></div></li>
							<li class="history_sets">
								<label>Time Period</label><select name="user_work[0][start_month]" class=" month prefill"></select>
								<select name="user_work[0][start_year]" class=" year prefill"></select> 
								&ndash; <span class="presentFlag" style="display: none;">Present</span>
								<select name="user_work[0][end_month]" class=" month prefill endDateFlag"></select> <select name="user_work[0][end_year]" class=" year prefill endDateFlag"></select>
								<span class="presentText">I currently work here</span><input type="checkbox" style="width: 13px; float: left;" name="user_work[0][current]"/>
							</li>
						</ul>
						<div class="addButton" id="addWork"> </div>
					</div>
				</div>
			</div>

			<div id="education_update" style="display: none;">
				<div id="education_layout">
					<div class="details">
						<ul>
							<li><label>School</label><input class="text_form school0" type="text" maxlength="150" name="user_education[0][school_name]"><input type="hidden" name="user_education[0][school_id]" value=""></li>								
							<li><label>Degree</label><input class="text_form degree0" type="text" maxlength="150" name="user_education[0][degree_name]"><input type="hidden" name="user_education[0][degree_id]" value=""></li>
							<li><label>Field of Study</label><input class="text_form study0" type="text" maxlength="150" name="user_education[0][field_name]"><input type="hidden" name="user_education[0][field_id]" value=""></li>
							<li class="history_sets"><label>Time Period</label><select name="user_education[0][start_month]" class=" month prefill"></select>
								<select name="user_education[0][start_year]" class=" year prefill"></select> &ndash; <select name="user_education[0][end_month]" class=" month prefill"></select> 
								<select name="user_education[0][end_year]" class=" year prefill"></select>
							</li>
						</ul>
						<div class="addButton" id="addEducation"> </div>
					</div>
				</div>
			</div>
			
			<div id="location_update" style="display: none;">
				<label>Where would you like to work?</label> <input class="location text_form clear" type="text" value=""/>
			</div>
			
			<div id="industry_update" style="display: none;">
				<label>Which industry or field do you want to work in?</label><input class="industry text_form clear" type="text" value=""/>
			</div>
			
			<div id="prefs_update" style="display: none;">
				Click start to re-enter your career preferences.<a href="/inquire" class="buttons save">Start</a>
			</div>
			
			<div id="notification_update" style="display: none;">
				Receive Emplayo Communications
			</div>
			
		</div>
	</div>
</div>
