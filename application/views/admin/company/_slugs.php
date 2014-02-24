<div id="admin">
	<div class="content">
		Click to create batch slugs:
		<a href="/admin/batch/create_slugs">Create Slugs</a>
		<?php  
			echo '<br><br><div class ="messages">';
			echo $this->session->flashdata('message');
			echo '</div>';
		?>
</div>

