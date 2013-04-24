<div id="preview">
	<div class="content">

                        
                <?php
                if ($company_count>0)
                {
                    echo '<p id="title">Here are your results!</p>';
                    echo "<p>You have <span>{$company_count} companies</span> in your list. Here are the first few...</p>";
                    echo '<p><a href="jobs">';

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
                }
                else
                {
                    echo '<p id="title">Bummer!</p>';
                    echo "<p>We didn't find any matches for you.</p>";                   
                }
                
                
                
                ?>
                        
                        <!--<img src="<?php echo base_url() ?>assets/images/preview.png"></img></a><p>-->
		<p id="info">Based on your answers, we have customized a list of companies<br>that fit <font>your</font> work-life-play
		preferences.  Sign in or create a free account<br>to see the entire list and immediately apply for jobs.</p>
		<div id="previewButtons">
			<a href="signup" id="signUp">Sign Up</a>
			<div id="progressIcon"><img src="<?php echo base_url() ?>assets/images/progressIcon.png"></img></div>
			<a href="login" id="signIn">Sign In</a>
		</div>
	</div>
</div>
