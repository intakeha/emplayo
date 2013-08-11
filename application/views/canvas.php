<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo isset($title) ? "Emplayo - $title" : "Emplayo"; ?></title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/global.css" type="text/css"/>  
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/view.css" type="text/css"/>
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery-ui.css" type="text/css"/>
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/typeahead.css" type="text/css"/>
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/counter.css" type="text/css"/>
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/select2.css" type="text/css"/> 
	
	<script type="text/javascript" src="<?php echo base_url() ?>assets/js/hogan-2.0.0.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-ui.min.js"></script>	
	<script type="text/javascript" src="<?php echo base_url() ?>assets/js/typeahead.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.raty.min.js"></script> 
	<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.isotope.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/js/flipcounter.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/js/select2.min.js"></script> 

        
	<script type="text/javascript" src="<?php echo base_url() ?>assets/js/global.js"></script> 
	
	
</head>
<body>
	<div id="header">
		<div class="content">
			<div id="header_login" class="clear"><a href="signup">Sign Up</a> | <a href="login">Log In</a></div>
			<div id="next_question"><div class="next">next</div><div class="arrow"></div></div>
			<div id="show_preview"><div class="next">next</div><div class="arrow"></div></div>
			<div id="header_icon" onclick="settings('#modal_settings');"></div>
			<div id="header_email"><a href="/"><?php if ($this->ion_auth->user()->row()){$user = $this->ion_auth->user()->row(); echo $user->email;}?></a></div>
			<div id="modal_settings">
				<ul>
					<li><a href="/">Home</a></li>
                                        <?php
                                        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
                                            {
                                                echo '<li><a href="/admin">Admin</a></li>';
                                            }                                        
                                        ?>
					<li><a href="/settings">Account Settings</a></li>
					<li><a href="/">Send Invite</a></li>
					<li><a href="/logout">Logout</a></li>
				</ul>
			</div>
			
			<a id="logo" href="/"></a>
			<div class="hints">
				<div id="singleChoice">select one</div>
				<div id="multipleChoice">select one or more items</div>
				<div id="rankChoice">sort by drag and drop</div>
				<div id="clickChoice">click to select</div>
				<div id="textChoice">enter text in textbox</div>
			</div>
		</div>
	</div>
	<div id="container">
		<?php $this->load->view($content); ?>
	</div>
	<div id="footer">
		<div id="skyline">
		</div>
		<div id="navigation">
			<div class="content">
				<ul id="nav-list">
					<li class="borders"><a href="">Testimonials</a></li>
					<li class="borders"><a href="">Employers</a></li>
					<li class="borders"><a href="">Pricing</a></li>
					<li class="borders"><a href="">Contact</a></li>
					<li class="borders"><a href="">Terms</a></li>
					<li><a href="">Privacy</a></li>
				</ul>
				<div class="clear">&copy; 2013 Emplayo, Inc. All rights reserved.</div>
			</div>
		</div>
	</div>
</body>
</html>