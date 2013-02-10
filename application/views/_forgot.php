<div id="login">
	<div class="content">
		<div id="login_left">
			<span>Forgot your password?</span><br>
			<div>
				Enter your email address and we'll send you a link to reset your password.  
			</div>

		</div>
		<div id="login_right">
			<div><span>Forgot Password</span></div>
                        
                        <div id="infoMessage"><?php //echo $message;?></div>
                        
			<?php echo form_open('auth/forgot_password') ;?>
			<?php echo form_label('Email:','email')?>
			<?php echo form_input('email',set_value('email'),'id=email')?>
			<div class="errors"><?php echo form_error('email'); ?></div>
               
			<?php echo form_submit('submit','Submit','class="submit"')?>			
			<?php echo form_close() ;?>

		</div>
	</div>
</div>