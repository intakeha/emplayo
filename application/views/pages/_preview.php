<div id="preview">
	<div class="content">
		<p id="title">Here are your results!</p>
		<p>You have <span><?php echo $company_count;?> companies</span> in your list. Here are the first few...</p>
		<p><a href="jobs">
                        
                <?php
                
                if (!empty($full_company_info))
                {
                    echo "<div class = 'company'>";
                    foreach ($full_company_info as $row)
                    {
                        
                        //echo '<br>';
                        //echo '<a href="'.$row['company_url'].'">'.$row['company_name'].'</a>';
                        //echo '<br>';
                        echo "<img src='{$image_path}{$row['company_logo']}' height='100' style = 'margin:30px;'/>";
                        //echo '<br>';
                        //echo "fit score: ".$row['fit_score'];
                        //echo '<br>';
                        
                    }
                    echo "</div>";
                }
                
                ?>
                        
                        <!--<img src="<?php echo base_url() ?>assets/images/preview.png"></img></a><p>-->
		<p id="info">Based on your answers, we have customized a list of companies<br>that fit <font>your</font> work-life-play
		preferences.  Sign in or create a free account<br>to see the entire list and immediately apply for jobs.</p>
		<div id="previewButtons">
			<div id="signUp">Sign Up</div>
			<div id="progressIcon"><img src="<?php echo base_url() ?>assets/images/progressIcon.png"></img></div>
			<div id="signIn">Sign In</div>
		</div>
	</div>
</div>
