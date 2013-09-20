<div id="preview">
    <?php
                if ($this->ion_auth->logged_in()){
                    //USER IS ALREADY LOGGED IN
                    if ($last_survey_date){
                        ?>
			<div class="content">
				<p id="info">
					<p>Click <font class="yellow">Update</font> to see your <font class="blue">new list of ranked companies.</font><br/>
					This will overwrite the Work-Life-Play data you provided last time on <br/><font class="blue"><?php echo $last_survey_date;?> (Pacific)</font>
					</p>To discard your recently entered data, <br/>just click <font class="yellow">Cancel</font> and it&#39;s like nothing ever happened.
				</p>
				<div id="previewButtons">
					<form action="/home/manage_prefs" method="post">
					    <input type="hidden" name="prefs_action" value="0"/>
					    <input type="submit" name="cancel" value="Cancel" id="cancel"/>
					</form> 
					
					<div id="progressIcon">
					    <img src="<?php echo base_url() ?>assets/images/progressIcon.png"></img>
					</div>
					<!--Implement modal confirmation popup....-->
					<form action="/home/manage_prefs" method="post">
					    <input type="hidden" name="prefs_action" value="1"/>
					    <input type="submit" name="overwrite" value="Update" id="update"/>
					</form>                         
				</div>
			</div>
                    <?php
                        
                    } else {
                        ?>
			<div class="content">
				<p id="info">  
					<p>According to our records, this is your first time <br>entering the Work.Life.Play preferences.</p>
					<br>
					<p>Click the &#34;Save&#34; button below to see your list of company matches.</p>
				</p>   
				<div id="previewButtons">
					<form action="/home/manage_prefs" method="post">
					    <input type="hidden" name="prefs_action" value="0"/>
					    <input type="submit" name="cancel" value="Cancel" id="cancel"/>
					</form> 

					<div id="progressIcon">
					    <img src="<?php echo base_url() ?>assets/images/progressIcon.png"></img>
					</div>
					<!--Implement modal confirmation popup....-->
					<form action="/home/manage_prefs" method="post">
					    <input type="hidden" name="prefs_action" value="2"/>
					    <input type="submit" name="save" value="Save" id="update"/>
					</form>                         
				</div>                    
			</div>
                    
                    <?php                        
                        
                    }
                } else {
                    ?>
                    <p id="info">
                        You must be logged in to view this page.  Click <a href="/">here</a> to return home.
                    </p>          
            
                    <?php
                    
                    
                }
                ?>
</div>
