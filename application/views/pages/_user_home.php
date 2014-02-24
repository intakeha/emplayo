<script>
	$(function() {
		var $container = $('ul#company_match');
		// initialize isotope
		$container.isotope({
		});
		$('ul#filters a').click(function(){
			var selector = $(this).attr('data-filter');
			$container.isotope({ filter: selector });
			$( "ul#filters a").removeClass();
			$(this).addClass('selected');
			if(!$container.data('isotope').$filteredAtoms.length){
				$( "div#noMatch" ).remove();
				$( "ul#company_match" ).after("<div id='noMatch'>There are no results for this category at the moment.<br><br>Our company list is constantly growing,<br>so be sure to check back for updates.</div>");
			}else{
				$( "div#noMatch" ).remove();
			};
			return false;
		});
		$( "ul#filters li:first-child").find("a").addClass('selected');

		// User Home Start button animation
		$("#profile a#start_btn").hover(
			function () {
			$(this).animate({backgroundColor: '#27c339', color: '#fff'}, 200);
			},
			function () {
			$(this).animate({backgroundColor: '#e9b60b', color: '#1D2A33'}, 200);
			}
		);

	});

</script> 

<div id="profile">
	<div id="modal_filter" class="modal_popup">
		<img src="<?php echo base_url() ?>assets/images/user/company_filters.png">
		<div><span>Your personalized list of company matches are organized into three categories: Good Matches, Decent Matches, and Poor Matches.</span></div>
		<div>By clicking on any of the category names, you can filter your results list to only show that category.  Click on 'Show All' to reset the filter and see the complete list.</div>
		<div>Our matching algorithm takes into account your Work-Life-Play preferences and compares them to our database of companies.</div>
		<ul id="modal">
		<li>Companies that match <span>at least 70%</span> of your preferences are considered Good Matches for you.  This is where you should focus
		the majority of your job search time and effort.</li>
		<li>Those that match <span>40-70%</span> of your preferences are considered Decent Matches. These companies just might be a good fit for you, so they're worth checking out if you have the time.</li>
		<li>Companies that match <span>less than 40%</span> are considered Poor Matches for you.  Don't waste your time on them.</li>
		</ul>
	</div>
	<div class="content">
		<?php 
			if(!empty($message)){echo '<div id="message">'.$message.'</div>';} 
			echo '<div class="messages">'.$this->session->flashdata('update_message').'</div>';
			    if (empty($matches)){
				echo "<p class=\"top\">Looks like you're just getting started!</p><p>Enter your Work-Life-Play preferences by clicking the button below:</p><br>
					<a id=\"start_btn\" href='inquire'>Get Started</a><br>
					<p>We'll then match your preferences with <br>the companies we have on file!</p>";
			    } else {
				echo "<div id=\"summary\">Here is your personalized list of company matches<br>based on your preferences and work history.</div>";
				echo "<div onclick=\"modal('#modal_filter','600','100');\" class=\"bulb\"></div>
					<ul id=\"filters\"><li><a href=\"#\" data-filter=\"*\">Show All<br><span>(Scores: 1-100)</span></a></li>
					<li id=\"good\"><a href=\"#\" data-filter=\".good\">Good Matches<br><span>(Scores: 70-100)</span></a></li>
					<li id=\"decent\"><a  href=\"#\" data-filter=\".prettyGood\">Decent Matches<br><span>(Scores: 40-70)</span></a></li>
					<li id=\"poor\"><a  href=\"#\" data-filter=\".notGood\">Poor Matches<br><span>(Scores: 0-40)</span></a></li></ul>";
				echo "<ul id='company_match'>";
				foreach ($matches as $row) {
					switch ($row['score']) {
						case ($row['score'] >= 70):
							echo "<li class='good'>";
							break;
						case (($row['score'] < 70) && ($row['score'] >= 40)):
							echo "<li class='prettyGood'>";
							break;
						case ($row['score'] < 40):
							echo "<li class='notGood'>";
							break;			
					};
					echo "<a href='/company/{$row['company_slug']}'><img class='photo' alt = '{$row['company_name']}' src='$image_path{$row['creative_logo']}' >";
					echo "<img class='logo' style='display:none;' src='$image_path{$row['company_logo']}' ></a>";
					switch ($row['score']) {
						case ($row['score'] >= 70):
							echo "<a href='/company/{$row['company_slug']}'><div class='fit green'>{$row['score']}</div></a></li>";
							break;
						case (($row['score'] < 70) && ($row['score'] >= 40)):
							echo "<a href='/company/{$row['company_slug']}'><div class='fit yellow'>{$row['score']}</div></a></li>";
							break;
						case ($row['score'] < 40):
							echo "<a href='/company/{$row['company_slug']}'><div class='fit red'>{$row['score']}</div></a></li>";
							break;						
					};
				};
				echo "</ul>";
			}
		?>
	</div>
</div>
