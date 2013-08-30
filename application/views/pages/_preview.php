<div id="preview">
	<div class="content">

                        
                <?php
                if ($company_count>0)
                {
                    echo '<p id="title">Here are your results!</p>';
                    echo "<p>You have <span>{$company_count} companies</span> in your list. Here are the first few...</p>";

                    if (!empty($full_company_info))
                    {
                        echo "<div class = 'company'>";
                        foreach ($full_company_info as $row)
                        {
                            echo "<img src='{$image_path}{$row['company_logo']}' height='100' style = 'margin:30px;'/>";

                        }
                        echo "</div>";
                        /**************************************************/
                        /*** Temmporary tables for debugging & refining ***/
                        /**************************************************/
                        function table_print($title,$this_array) 
                        {               
                            $keys = array_keys($this_array[0]);
                            echo "<div class = 'table'>";
                            echo "<br><h3>$title</h3>";
                            echo "<table style ='border:1px solid #FF0000;padding:5px;'><tr><th style='border:1px solid #FF0000;padding:5px;'>".implode("</th><th style='border:1px solid #FF0000;padding:5px;'>", $keys)."</th></tr>";
                            foreach ($this_array as $row) {
                              if (!is_array($row))
                                continue;
                              echo "<tr><td style='border:1px solid #FF0000;padding:5px;'>".implode("</td><td style='border:1px solid #FF0000;padding:5px;'>", $row )."</td></tr>";
                            }
                            echo "</table>";
                            echo "</div>";
                        }                              
                        function header_print_to_file() 
                        {                              
                            //$keys = array_keys($this_array[0]);
                            $header = '<html><head><title>Algorithm Diagnostic Tables</title></head><body>';
                            file_put_contents('temp_arrays/algotables.html', $header);//will create a new file

                        }       
                        
                        function table_print_to_file($title,$this_array) 
                        {    
                            $keys = array_keys($this_array[0]);
                            $open_table =  "<div class = 'table'><br><h3>$title</h3>";
                            file_put_contents('temp_arrays/algotables.html', $open_table, FILE_APPEND);
                            $table_header = "<table style ='border:1px solid #FF0000;padding:5px;'><tr><th style='border:1px solid #FF0000;padding:5px;'>".implode("</th><th style='border:1px solid #FF0000;padding:5px;'>", $keys)."</th></tr>";
                            file_put_contents('temp_arrays/algotables.html', $table_header, FILE_APPEND);                            
                            foreach ($this_array as $row) {
                              if (!is_array($row))
                                continue;
                              $row = "<tr><td style='border:1px solid #FF0000;padding:5px;'>".implode("</td><td style='border:1px solid #FF0000;padding:5px;'>", $row )."</td></tr>";
                              file_put_contents('temp_arrays/algotables.html', $row, FILE_APPEND);
                            }
                            $close_table = "</table></div>";
                            file_put_contents('temp_arrays/algotables.html', $close_table, FILE_APPEND);
                        }              

                        function footer_print_to_file() 
                        {                              
                            //$keys = array_keys($this_array[0]);
                            $footer = '</body></html>';
                            file_put_contents('temp_arrays/algotables.html', $footer, FILE_APPEND);
                        }                           
                        
                        function make_tables(){   
                            header_print_to_file();
                            $raw_data = unserialize(file_get_contents('temp_arrays/raw_array.txt'));
                            table_print_to_file('Raw Data', $raw_data);
                            $coord_data = unserialize(file_get_contents('temp_arrays/coord_array.txt')); 
                            table_print_to_file('Coordinate Data', $coord_data);
                            $dist_data = unserialize(file_get_contents('temp_arrays/dist_array.txt'));
                            table_print_to_file('Distance Data', $dist_data);
                            $norm_disp_data = unserialize(file_get_contents('temp_arrays/norm_disp_array.txt'));
                            table_print_to_file('Normalized Data', $norm_disp_data);
                            $weight_data = unserialize(file_get_contents('temp_arrays/weight_array.txt'));
                            table_print_to_file('Weight Data', $weight_data);                            
                            $aggregate_data = unserialize(file_get_contents('temp_arrays/aggregate_array.txt'));
                            table_print_to_file('Aggregate Data', $aggregate_data);
                            $company_fit = unserialize(file_get_contents('temp_arrays/fit_array.txt'));
                            table_print_to_file('Company Fit Data', $company_fit);  
                            footer_print_to_file();
                        }           
                        make_tables();           
                        /************************/
                        /*** End temp tables ****/ 
                        /************************/
                        
                        
                    } //end of if (!empty(full company info))
                } //end of if company count >0
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
                            <input type="submit" name="cancel" value="Cancel" id="cancel"/>
                        </form> 
                        <div id="progressIcon">
                            <img src="<?php echo base_url() ?>assets/images/progressIcon.png"></img>
                        </div>
                        <a href="home" id="signIn">Save</a>
                    </div> 
                    
                    
                    <?php                    
                    
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
            
                    <?php
                    
                    
                }
                ?>
	</div>
</div>
