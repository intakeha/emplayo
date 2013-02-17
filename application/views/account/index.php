<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>User Home</title>
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/reset-fonts-grids.css" type="text/css"/>
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/base.css" type="text/css"/>        


</head>
<body>

<div id="container">
    <div id="doc2">
    <div id="hd"><!-- header -->
	<h1>User Home!</h1>

    </div>

	<div id="bd"><!-- body -->
            <p>
            <?php $user = $this->ion_auth->user()->row();?>
		Welcome back, <span style = color:red;><?php echo $user->email;?></span>!
                </p>
            
        <p>
            [companies will be listed here...]
        </p>
        <p>
            <a href="logout">logout</a>
        </p>        

	</div>
    </div>
</div>

</body>
</html>
