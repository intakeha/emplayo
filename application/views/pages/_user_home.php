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
				echo "<div id=\"summary\">Here are the company results based on your <br>preferences and work history.</div><ul>";
				foreach ($matches as $row) {
				    echo "<li><a href='/company/profile/{$row['company_id']}'><img class='photo' alt = '{$row['company_name']}' src='$image_path{$row['creative_logo']}' >";
				    echo "<img class='logo' style='display:none;' src='$image_path{$row['company_logo']}' ></a>";
				    echo "<div class='fit' style='display:none;'>{$row['score']}</div></li>";
				};
				echo "</ul>";
			}
		?>
	</div>
</div>
