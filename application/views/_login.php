<div id="login">
	<div class="content">
		<div id="login_left">
			<span>Welcome back!</span><br>
			<div>
				It's always good to see you.  While you were away, we've been hard at work finding the best companies, crunching lots of data, and ranking your matches.  
			</div>
			<div>
				Log in to see how things are stacking up!
			</div>
		</div>
		<div id="login_right">
			<div><span>Emplayo Login</span></div>
			<?php echo form_open('auth/login') ;?>
			<?php echo form_label('Email:','email')?>
			<?php echo form_input('email',set_value('email'),'id=email')?>
			<div class="errors"><?php echo form_error('email'); ?></div>
			<?php echo form_label('Password:','password')?>
			<?php echo form_password('password','','id=password')?>
			<div class="errors"><?php echo form_error('password'); ?></div>                
			<?php echo form_submit('submit','Login','class="submit"')?>			
			<?php echo form_close() ;?>
			<p><a href="forgot">Forgot your password?</a></p>
			<hr>
			<p id="new_text">New to Emplayo?</p>
			<p><a href="signup">Create an Account</a></p>
		</div>
	</div>
</div>