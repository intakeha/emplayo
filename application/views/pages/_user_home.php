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
				//alert("It's empty");
			}else{
				//alert("It's not empty");
			};
			return false;
		});
		$( "ul#filters li:first-child").find("a").addClass('selected');

	});

</script> 
<div id="profile">
	<div class="content">
		<?php 
			if(!empty($message)){echo '<div id="message">'.$message.'</div>';} 
			echo '<div class="messages">'.$this->session->flashdata('update_message').'</div>';
			    if (empty($matches)){
				echo "<p class=\"top\">Looks like you're just getting started!</p><p>Enter your Work-Life-Play preferences by clicking the button below:</p><br>
					<a id=\"start_btn\" href='inquire'>Get Started</a><br>
					<p>We'll then match your preferences with <br>the companies we have on file!</p>";
			    } else {
				echo "<div id=\"summary\">Here are the company results based on your <br>preferences and work history.</div>";
				echo "<ul id=\"filters\"><li><a href=\"#\" data-filter=\"*\">Show All<br><span>(Match score: 1-100)</span></a></li>
					<li id=\"good\"><a href=\"#\" data-filter=\".good\">Good Matches<br><span>(Match score: 70-100)</span></a></li>
					<li id=\"decent\"><a  href=\"#\" data-filter=\".prettyGood\">Decent Matches<br><span>(Match score: 40-70)</span></a></li>
					<li id=\"poor\"><a  href=\"#\" data-filter=\".notGood\">Poor Matches<br><span>(Match score: 0-40)</span></a></li></ul>";
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
					echo "<a href='/company/profile/{$row['company_id']}'><img class='photo' alt = '{$row['company_name']}' src='$image_path{$row['creative_logo']}' >";
					echo "<img class='logo' style='display:none;' src='$image_path{$row['company_logo']}' ></a>";
					switch ($row['score']) {
						case ($row['score'] >= 70):
							echo "<a href='/company/profile/{$row['company_id']}'><div class='fit green'>{$row['score']}</div></a></li>";
							break;
						case (($row['score'] < 70) && ($row['score'] >= 40)):
							echo "<a href='/company/profile/{$row['company_id']}'><div class='fit yellow'>{$row['score']}</div></a></li>";
							break;
						case ($row['score'] < 40):
							echo "<a href='/company/profile/{$row['company_id']}'><div class='fit red'>{$row['score']}</div></a></li>";
							break;						
					};
				};
				echo "</ul>";
			}
		?>
	</div>
</div>
