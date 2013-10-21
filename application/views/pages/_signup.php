<div id="signup">
	<div class="content">
		<div id="signup_left">
			<div><span>Create Account</span></div>
			
			<?php echo form_open('signup') ;?>
			<?php echo form_label('Email:','email')?>
			<?php echo form_input('email',set_value('email'),'id=email')?>
			<div class="errors"><?php echo form_error('email'); ?></div>
			<?php echo form_label('Password:','password')?>
			<?php echo form_password('password','','id=password')?>
			<div class="errors"><?php echo form_error('password'); ?></div>
			<?php echo form_label('Confirm Password:','password_confirm')?>
			<?php echo form_password('password_confirm','','id=password_confirm')?>
			<div class="errors"><?php echo form_error('password_confirm'); ?></div>
			<?php if($message){echo '<div id="signup_message">'.$message.'</div>';} ?>
			<?php echo form_submit('submit','Sign Up','class="submit"')?>			
			<?php echo form_close() ;?>
			
			<p>By clicking Sign Up, you agree to Emplayo's <a href="/terms">Terms of Service</a>.</p>
			<hr>
			<p><span>Already have an account?</span></p>
			<p><a href="login">Log In</a></p>
		</div>
		<div id="signup_right">
			<div><span>Fast and free. Get started now!</span></div>
			<div><img src="<?php echo base_url() ?>assets/images/modals/signup_benefits_list.png"></img><span>See the full list of your best-fit companies</span><br>If you haven't created an account yet, then you haven't even scratched the surface of your company matches.</div>
			<div><img src="<?php echo base_url() ?>assets/images/modals/signup_benefits_notify.png"></img><span>Receive alerts on new company matches</span><br>We're constantly looking for companies that fit you, and when you save your preferences we'll let you know when we find new matches.</div>
			<div><img src="<?php echo base_url() ?>assets/images/modals/signup_benefits_find.png"></img><span>Connect with employers and apply for jobs</span><br>It's a two-way street: you're looking for the perfect company, and employers are looking for you.  With your profile saved, you're one step closer to being found!</div>
			
		</div>
	</div>
</div>