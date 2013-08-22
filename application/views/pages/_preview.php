<div id="preview">
	<div class="content">

                        
                <?php
                if ($company_count>0)
                {
                    echo '<p id="title">Here are your results!</p>';
                    echo "<p>You have <span>{$company_count} companies</span> in your list. Here are the first few...</p>";
                    //echo '<p><a href="jobs">';

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
                        
// Temmporary tables for debugging & refining
            function table_print($title,$this_array) 
            {               
                $keys = array_keys($this_array[0]);
                echo "<div class = 'table'>";
                //echo "<div style='float:left;margin:10px'>";
                echo "<h3>$title</h3>";
                echo "<table style ='border:1px solid #FF0000;padding:5px;'><tr><th>".implode("</th><th>", $keys)."</th></tr>";
                foreach ($this_array as $row) {
                  if (!is_array($row))
                    continue;
                  echo "<tr><td style='border:1px solid #FF0000;padding:5px;'>".implode("</td><td style='border:1px solid #FF0000;padding:5px;'>", $row )."</td></tr>";
                }
                echo "</table>";
                echo "</div>";
            }                              
                        
                        
                echo "<div>";        
                $raw_data = unserialize(file_get_contents('temp_arrays/raw_array.txt'));
                table_print('Raw Data', $raw_data);
                $coord_data = unserialize(file_get_contents('temp_arrays/coord_array.txt')); 
                table_print('Coordinate Data', $coord_data);
                $dist_data = unserialize(file_get_contents('temp_arrays/dist_array.txt'));
                table_print('Distance Data', $dist_data);
                $norm_disp_data = unserialize(file_get_contents('temp_arrays/norm_disp_array.txt'));
                table_print('Normalized Data', $norm_disp_data);
                $aggregate_data = unserialize(file_get_contents('temp_arrays/aggregate_array.txt'));
                table_print('Aggregate Data', $aggregate_data);
                $company_fit = unserialize(file_get_contents('temp_arrays/fit_array.txt'));
                table_print('Company Fit Data', $company_fit);    
                echo "</div>";
                   
                    
                        
// End temp tables                        
                        
                        
                    }
                }
                else
                {
                    echo '<p id="title">Bummer!</p>';
                    echo "<p>We didn't find any matches for you.</p>";                   
                }
                
                
                if ($this->ion_auth->logged_in()){
                    //USER IS ALREADY LOGGED IN
                    ?>
                    <p id="info">
                        Based on your answers, we have customized a list of companies<br>that fit <font>your</font> work-life-play
                        preferences.  
                        <br><br>
                        Click 'Save' to save this data in your profile.
                    </p>
                    <div id="previewButtons">
                        <form action="/home/manage_prefs" method="post">
                            <input type="hidden" name="prefs_action" value="0"/>
                            <input type="submit" name="cancel" value="Cancel" id="signUp"/>
                        </form> 
                        <div id="progressIcon">
                            <img src="<?php echo base_url() ?>assets/images/progressIcon.png"></img>
                        </div>
                        <a href="home" id="signIn">Save</a>
                    </div> 
                    
                    
                    <?                    
                    
                } else {
                    ?>
                    <p id="info">
                        Based on your answers, we have customized a list of companies<br>that fit <font>your</font> work-life-play
                        preferences.  Sign in or create a free account<br>to see the entire list and immediately apply for jobs.
                    </p>
                    <div id="previewButtons">
                        <a href="signup" id="signUp">Sign Up</a>
                        <div id="progressIcon">
                            <img src="<?php echo base_url() ?>assets/images/progressIcon.png"></img>
                        </div>
                        <a href="login" id="signIn">Sign In</a>
                    </div>            
            
                    <?
                    
                    
                }
                ?>
	</div>
</div>
