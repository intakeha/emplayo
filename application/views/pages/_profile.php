<div id="profile">
	<div class="content">
		<?php $user = $this->ion_auth->user()->row();?>
		<?php if($this->session->userdata('message')){echo '<div class="errors">'.$this->session->userdata('message').'</div>';} ?>
		<p>You're logged in as <?php echo $user->email;?></p>

		Click here to <a href="logout">logout</a>
	</div>
</div>
