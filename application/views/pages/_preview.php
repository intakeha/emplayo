<div id="preview">
	<div class="content">
		<?php
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
