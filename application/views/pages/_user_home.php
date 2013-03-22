<div id="profile">
	<div class="content">
            <?php if(!empty($message)){echo '<div id="message">'.$message.'</div>';} ?>
		<div id="summary">Here are the company results based on your <br>preferences and work history.</div>
               
		<ul>
                    <?php
                    if (empty($matches)){
                        echo "No company matches were found for your profile.";
                    } else {
                        foreach ($matches as $row) {
                            echo "<li><a href='/company/temp/{$row['company_id']}'><img class='photo' alt = '{$row['company_name']}' src='$image_path{$row['creative_logo']}' >";
                            echo "<img class='logo' style='display:none;' src='$image_path{$row['company_logo']}' ></a>";
                            echo "<div class='fit' style='display:none;'>{$row['score']}</div></li>";
                        }
                    }
                    ?>
		</ul>                
	</div>
</div>
