<div id="preview">
    <?php
                if ($this->ion_auth->logged_in()){
                    //USER IS ALREADY LOGGED IN
                    if ($last_survey_date){
                        ?>
                    <p id="info">  
                        According to our records, you last updated your Work.Life.Play preferences on <?php echo $last_survey_date;?>, PST.
                        <br><br>
                        Click 'Overwrite' and we will overwrite your previously entered preferences with the data you just provided. 
                        Click 'Cancel' and we'll discard your newly entered data, take you back to where this all started and act like nothing ever happened.
                    </p>  
                    <div id="previewButtons">
                        <form action="/home/manage_prefs" method="post">
                            <input type="hidden" name="prefs_action" value="0"/>
                            <input type="submit" name="cancel" value="Cancel" id="signUp"/>
                        </form> 
                        
                        <div id="progressIcon">
                            <img src="<?php echo base_url() ?>assets/images/progressIcon.png"></img>
                        </div>
                        <!--Implement modal confirmation popup....-->
                        <form action="/home/manage_prefs" method="post">
                            <input type="hidden" name="prefs_action" value="1"/>
                            <input type="submit" name="overwrite" value="Overwrite" id="signIn"/>
                        </form>                         
                    </div>                  
                    <?
                        
                    } else {
                        ?>
                    <p id="info">  
                        According to our records, this is your first time taking the Work.Life.Play survey.
                        <br><br>
                        Click 'Save' to save your preferences.
                    </p>   
                    <div id="previewButtons">
                        <form action="/home/manage_prefs" method="post">
                            <input type="hidden" name="prefs_action" value="0"/>
                            <input type="submit" name="cancel" value="Cancel" id="signUp"/>
                        </form> 
                        
                        <div id="progressIcon">
                            <img src="<?php echo base_url() ?>assets/images/progressIcon.png"></img>
                        </div>
                        <!--Implement modal confirmation popup....-->
                        <form action="/home/manage_prefs" method="post">
                            <input type="hidden" name="prefs_action" value="2"/>
                            <input type="submit" name="save" value="Save" id="signIn"/>
                        </form>                         
                    </div>                    
                    
                    
                    <?                        
                        
                    }
                    
                   
                    
                } else {
                    ?>
                    <p id="info">
                        You must be logged in to view this page.  Click <a href="/">here</a> to return home.
                    </p>          
            
                    <?
                    
                    
                }
                ?>
</div>
