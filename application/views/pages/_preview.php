<script>
	$(function() {
		lockedModal('#modal_preview', '600','75');	
		$("#preview a").hover(
			function () {
			$(this).animate({backgroundColor: '#009900'}, 200);
			},
			function () {
			$(this).animate({backgroundColor: '#33CC00'}, 200);
			}
		);
	});

</script> 
<div id="preview">
	<div class="content"> 
		<div class="modal_popup" id="modal_preview">
			<?php
			       if ($this->ion_auth->logged_in()){
				    //USER IS ALREADY LOGGED IN
			?>
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
				<p id="info">
					Based on your answers, we have customized a list of companies that fit <font>your</font> work-life-play preferences.  
					<br><br>
					Click 'Save' to save this data in your profile.
				</p><br><br>
			    <?php                    
			    
			} else {
			    ?>
			    <p id="info">
				Based on your answers, we have customized a list of companies that fit <font>your</font> work-life-play
				preferences.
			    </p>
			   <div id="previewButtons">
				<a href="signup" id="signUp">Sign Up</a>
				<div id="progressIcon">
				    <img src="<?php echo base_url() ?>assets/images/progressIcon.png"></img>
				</div>
				<a href="login" id="signIn">Sign In</a>
			    </div> 
			    <div>
				Click Sign Up or Sign In to see the list.
			    </div>
			    <hr>
			    <div id="benefits_title">
				Fast and free. Get started now!
			    </div>
			    <div id="benefits">
				<div><img src="<?php echo base_url() ?>assets/images/modals/signup_benefits_list.png"></img><br>See the full list of your best-fit companies</div>
				<div><img src="<?php echo base_url() ?>assets/images/modals/signup_benefits_notify.png"></img><br>Receive alerts on new company matches</div>
				<div><img src="<?php echo base_url() ?>assets/images/modals/signup_benefits_find.png"></img><br>Connect with employers and apply for jobs</div>
			    </div>

			    <?php
			}
			?>
		</div>

		<?php
                if ($company_count>0)
                {
                    if (!empty($full_company_info))
                    {
                        echo "<div class = 'company'>";
                        foreach ($full_company_info as $row)
                        {
                            echo "<img src='{$image_path}{$row['creative_logo']}' />";

                        }
                        echo "</div>";
			?>
			<img class="transparent_fade" src="<?php echo base_url() ?>assets/images/modals/preview_matches_bg.png"></img>
			<?php
			
                    } //end of if (!empty(full company info))
                } //end of if company count >0
                else
                {
                    echo '<p id="title">Bummer!</p>';
                    echo "<p>We didn't find any matches for you.</p>";                   
                };
		?>
 	</div>
</div>
