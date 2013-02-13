<div id="reset">
	<div class="content">
		<div id="panel">
			<div><span>Reset your password</span></div>
			<?php echo form_open('reset') ;?>
			<div id="reset_input">
				<?php echo form_label('Password:','password')?>
				<?php echo form_password('password','','id=password')?>
				<div class="errors"><?php echo form_error('password'); ?></div>
				
				<?php echo form_label('Confirm Password:','password_confirm')?>
				<?php echo form_password('password','','id=password_confirm')?>
				<div class="errors"><?php echo form_error('password_confirm'); ?></div>
			</div>
			<?php echo form_submit('submit','Reset','class="submit"')?>			
			<?php echo form_close() ;?>
		</div>
	</div>
</div>