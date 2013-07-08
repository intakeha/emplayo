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
			crumbs = $(this).attr('name');
			$("div#settings div#crumbs").append(" &raquo; "+crumbs);
			$(this).addClass("selected");
			$("div#settings ul#menu li").fadeOut();
			$("div#settings ul#menu li.selected").fadeIn('fast', function() {
				$("div#settings div#crumbs, div#settings div#panel").fadeIn();
				switch($(this).attr('id'))
				{
					case 'key':
						$("div#settings div#panel").fadeIn();
						break;
					case 'work':
						alert('Hi 2');
						break;
					case 'education':
						alert('Hi 3');
						break;
					case 'location':
						alert('Hi 4');
						break;
					case 'industry':
						alert('Hi 5');
						break;
					case 'prefs':
						alert('Hi 6');
						break;
					case 'notification':
						alert('Hi 7');
						break;						
					default:
						break;
				}
				
			});
		}
	});
  });    
    
</script>

<div id="settings">
	<div class="content">
		<ul id="menu">
			<li id="key" name="Change Password"><div>Change Password</div></li>
			<li id="work" name="Work History"><div>Work<br/>History</div></li>
			<li id="education" name="Education"><div>Education</div></li>
			<li id="location" name="Location"><div>Location</div></li>
			<li id="industry" name="Industry Preference"><div>Industry Preference</div></li>
			<li id="prefs" name="Job Preference"><div>Job<br/>Preference</div></li>
			<li id="notification" name="Notifications"><div>Notifications</div></li>
		</ul>
		<div id="crumbs"><a href="settings">Account Settings</a></div>
		<div id="panel">
			<div id="password_form" style="display=none;">
				<form>
					<fieldset>
						<label for="old">Old Password</label>
						<input type="password" name="old" id="old"  />
						<label for="new">New Password</label>
						<input type="password" name="new" id="new"  />
						<label for="confirm">Confirm New Password</label>
						<input type="password" name="confirm" id="confirm"  /> 
					</fieldset>
				</form>
			</div>
			
			
		</div>
	</div>
</div>
