<div id="signup">
	<div class="content">
		<div id="signup_left">
			<div><span>Create Account</span></div>
			<?php echo form_open('signup') ;?>
			<?php echo form_label('Email:','email_address')?>
			<?php echo form_input('email_address',set_value('email_address'),'id=email_address')?>
			<div class="errors"><?php echo form_error('email_address'); ?></div>
			<?php echo form_label('Password:','password')?>
			<?php echo form_password('password','','id=password')?>
			<div class="errors"><?php echo form_error('password'); ?></div>
			<?php echo form_submit('submit','Sign Up','class="submit"')?>			
			<?php echo form_close() ;?>
			<p>By clicking Sign Up, you agree to Emplayo's Terms of Service.</p>
			<hr>
			<p><span>Already have an account?</span></p>
			<p><a href="login">Log In</a></p>
		</div>
		<div id="signup_right">
			<div><span>Fast and free. Get started now!</span></div>
			<div><span>See the full list of your best-fit companies</span><br>If you haven't created an account yet, then you haven't even scratched the surface of your company matches.</div>
			<div><span>Receive automatic alerts for new company matches</span><br>We're constantly looking for companies that fit you, and when you save your preferences we'll let you know when we find new matches.</div>
			<div><span>Allow employers to find you</span><br>It's a two-way street: you're looking for the perfect company, and employers are looking for you.  With your profile saved, you're one step closer to being found!</div>
			
		</div>
	</div>
</div>