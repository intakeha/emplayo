<h1>Signup</h1>
<p>Please enter your information below.</p>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open("auth/signup");?>

      <p>
            Email: <br />
            <?php echo form_input($email);?>
      </p>

      <p>
            Password: <br />
            <?php echo form_input($password);?>
      </p>

      <p>
            Confirm Password: <br />
            <?php echo form_input($password_confirm);?>
      </p>


      <p><?php echo form_submit('submit', 'Signup');?></p>

<?php echo form_close();?>