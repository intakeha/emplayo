<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Login</title>

	
</head>
<body>
    <h1>Find The Companies That Fit You Best!</h1>
    <p>
    <ul>
        <li>See the entire list your best-fit companies</li>
    <li>Save your information so you don’t have to enter it again</li>
    <li>Receive automated alerts for new company matches</li>
    <li>Allow potential employers to find you and make job offer</li>
    <li>Retain complete control of the visibility of your information</li>
    <li>Fast and free</li>
    </ul>
    </p>
    
    <h2>Login</h2>
    <?php echo form_open('user/login') ;?>
    <p>
        <?php echo form_label('Email Address:','email_address')?>
        <?php echo form_input('email_address',set_value('email_address'),'id=email_address')?>
        <div class="errors"><?php echo form_error('email_address'); ?></div>
        
    </p>
    <p>
        <?php echo form_label('Password:','password')?>
        <?php echo form_password('password','','id=password')?>
        <div class="errors"><?php echo form_error('password'); ?></div>
        
    </p>
    <p>
    <?php echo form_submit('submit','Login')?>
        </p>
    <?php echo form_close() ;?>
        
        <div class="errors"><?php //echo validation_errors();?></div>  
        
        
        
        <p><a href="forgot">Forgot your password?</a></p>
        
    <h2>Not a member?</h2>
    <p><a href="signup">Sign up now!</a></p>
</body>
</html>