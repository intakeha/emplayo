<div id="reset">
	<div class="content">
		<div id="panel">
			<div><span>Reset your password</span></div>
			<?php echo form_open('auth/reset_password/'. $code) ;?>
			<div id="reset_input">
				<?php echo form_label('Password:','new_password');?>
				<?php echo form_input($new_password);?>
				<div class="errors"><?php echo form_error('new_password'); ?></div>
				
				<?php echo form_label('Confirm Password:','new_password_confirm');?>
				<?php echo form_input($new_password_confirm)?>
				<div class="errors"><?php echo form_error('new_password_confirm'); ?></div>
			</div>
			<?php echo form_input($user_id);?>
			<?php echo form_hidden($csrf); ?>
			<?php echo form_submit('submit','Reset','class="submit"');?>	
			<?php echo $message;?>
			<?php echo form_close() ;?>
		</div>
	</div>
</div>