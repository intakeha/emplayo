<div id="admin">
	<div class="content">
	
	<div>Are you sure you want to delete <span id="company_name"><?php echo $company_info['company_name'];?></span>?  This cannot be undone!</div><br>
	<?php   
		$submit_url = 'admin/company/delete/'.$company_id;
		echo form_open($submit_url);

		echo form_fieldset('');
		echo form_radio('delete', '0', TRUE);
		echo form_label('No way! Get me out of here!!','delete');
		echo "<br>";
		echo form_radio('delete', '1', FALSE);
		echo form_label('Delete','delete');
		echo form_fieldset_close();
		echo '<br>';
		echo form_submit('mysubmit', 'Submit');
		echo form_close();
	?>  
	</div>
</div>