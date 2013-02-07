<!DOCTYPE html>
<html>
<head>
	<title><?php echo isset($title) ? "Emplayo - $title" : "Emplayo"; ?></title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/global.css" type="text/css"/>  
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/view.css" type="text/css"/>
        
	<!--<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />-->
	<!--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>-->
	<!--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script> -->     
        
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery-ui.css" />
	<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-ui.min.js"></script>
        
	<script type="text/javascript" src="<?php echo base_url() ?>assets/js/global.js"></script>
</head>
<body>
	<div id="header">
		<div class="content">
			<div id="headerLogin" class="clear"><a href="user/signup">Sign Up</a> | <a href="login">Log In</a></div>
			<div id="nextQuestion"><div class="next">next</div><div class="arrow"></div></div>
			<div id="showPreview"><a href="preview"><div class="next">next</div><div class="arrow"></div></a></div>
			<a id="logo" href="./"></a>
			<div class="hints">
				<div id="singleChoice">select one</div>
				<div id="multipleChoice">select one or more items</div>
				<div id="rankChoice">sort by drag and drop</div>
				<div id="clickChoice">click to select</div>
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