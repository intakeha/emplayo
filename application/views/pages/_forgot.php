<div id="forgot">
	<div class="content">
		<div id="panel">
			<div><span>Forgot your password?</span></div>
			<div>Don't worry, it happens to everyone!<br>Enter your email address and we'll send you instructions for your password reset.</div>
			<?php echo form_open('forgot') ;?>
			<div id="forgot_input">
				<?php echo form_label('Email:','email')?>
				<?php echo form_input('email',set_value('email'),'id=email')?>
				<?php if($message){echo '<div class="errors">'.$message.'</div>';} ?>
			</div>
			<?php echo form_submit('submit','Send','class="submit"')?>			
			<?php echo form_close() ;?>
			<hr>
			<p><span>I remember now...</span></p>
			<p><a href="login">Log In</a></p>
		</div>
	</div>
</div>