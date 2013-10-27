<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo isset($title) ? "Emplayo - $title" : "Emplayo"; ?></title>
	<meta charset="utf-8">
	
	<link rel="shortcut icon" href="<?php echo base_url()?>assets/images/favicon.ico" type="image/x-icon">
	
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
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/uservoice.js"></script>
        <?php //Only load google analytics when we're in production, so as not to pollute our data
        if (ENVIRONMENT == 'production') {?>
            <script type="text/javascript" src="<?php echo base_url() ?>assets/js/googleanalytics.js"></script>
        <?php }?>
	
</head>
<body>
	<div id="header">
		<div class="content">
			<!-- <div id="header_login" class="clear"><a href="signup">Sign Up</a> | <a href="login">Log In</a></div> -->
			<div id="next_question"><div class="next">next</div><div class="arrow"></div></div>
			<div id="show_preview"><div class="next">next</div><div class="arrow"></div></div>
			<?php 
			if ($this->ion_auth->user()->row()){
				$user = $this->ion_auth->user()->row();
				echo "<div id=\"header_icon\" onclick=\"settings('#modal_settings');\"></div>";
				echo "<div id=\"header_email\"><a href=\"/\">";
				echo $user->email;
				echo "</a></div>";
			}else{
				echo "<div id=\"header_login\" class=\"clear\"><a href=\"signup\">Sign Up</a> | <a href=\"login\">Log In</a></div>";
			}
			?>
			
			<!--
			<div id="header_icon" onclick="settings('#modal_settings');"></div>
			<div id="header_email"><a href="/"><?php if ($this->ion_auth->user()->row()){$user = $this->ion_auth->user()->row(); echo $user->email;}?></a></div>
			-->
			
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
					<li style="display: none;"><a href="/">Send Invite</a></li>
					<li><a href="/logout">Logout</a></li>
				</ul>
			</div>
			
			<a id="logo" href="/"></a>
			<div class="currentQuestion">
				<div><font>Question <span></span> of 20</font></div>
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
					<li class="borders"><a href="/employers">Employers</a></li>
					<li class="borders"><a href="/about">About</a></li>
					<li class="borders"><a href="/contact">Contact</a></li>
					<li class="borders"><a href="/terms">Terms</a></li>
					<li><a href="/privacy">Privacy</a></li>
				</ul>
				<div class="clear">&copy; 2013 Emplayo, Inc. All rights reserved.</div>
			</div>
		</div>
	</div>
</body>
</html>