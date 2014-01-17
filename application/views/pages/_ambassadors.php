<script>
    $( document ).ready(function() {
	$("#ambassadors a#button").hover(
		function () {
		$(this).animate({backgroundColor: '#27c339', color: '#fff'}, 200);
		},
		function () {
		$(this).animate({backgroundColor: '#e9b60b', color: '#1D2A33'}, 200);
		}
	);
	$("#mc_embed_signup .button").hover(
		function () {
		$(this).animate({backgroundColor: '#27c339', color: '#fff'}, 200);
		},
		function () {
		$(this).animate({backgroundColor: '#e9b60b', color: '#1D2A33'}, 200);
		}
	);
    });
</script>
<div id="ambassadors">
	<div class="content">
		<div>
			<h1 class="titles blue">Student Ambassadors</h1>
			<img style="float: right;" src="/assets/images/static/university.jpg">
			<p>Emplayo is committed to growing and preparing the next generation of leaders for the future workforce.</p>
			<p>The Emplayo Student Ambassador Program is an opportunity for active students to experience entrepreneurship
			at their universities and to prepare for a successful start in their careers. The program is designed to enhance professional
			development and soft skills, to meet and collaborate with other student ambassadors around the world, and to have fun while creating
			a legacy at their alma mater.</p>
			<p>Every student ambassador will have an opportunity to:</p>
			<ul>
				<li>Gain experience in marketing, promotion and entrepreneurship</li>
				<li>Network with other student ambassadors around the world</li>
				<li>Strengthen his/her resume with real-life experiences</li>
				<li>Obtain references for future job applications</li>
				<li>Be a part of Emplayo's Student Ambassador Network</li>
			</ul>
			<!-- <a id="button" href="/contact">Apply</a> -->
		</div>
		
		<!-- Begin MailChimp Signup Form -->
		<link href="//cdn-images.mailchimp.com/embedcode/classic-081711.css" rel="stylesheet" type="text/css">
		<style type="text/css">
			#mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif; margin: 20px 355px 0 85px;}
			#mc_embed_signup div{margin-top: 0px !important;}
			#mc_embed_signup .button{
				background-color: #E9B60B;
				color: #1D2A33;
				display: block;
				font-size: 30px;
				height: 60px;
				text-align: center;
				width: 200px;
				cursor: pointer;
				-moz-border-radius: 10px;
				-webkit-border-radius: 10px;
				border-radius: 10px;	
			}
			/* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
			   We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
		</style>
		<div id="mc_embed_signup">
		<form action="http://emplayo.us3.list-manage.com/subscribe/post?u=28bd9f715aa97b4488567d729&amp;id=c666d02534" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
			<h2>Fill out below to apply:</h2>
		<div class="indicates-required"><span class="asterisk">*</span> indicates required</div>
		<div class="mc-field-group">
			<label for="mce-EMAIL">Email Address  <span class="asterisk">*</span>
		</label>
			<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
		</div>
		<div class="mc-field-group">
			<label for="mce-FNAME">First Name  <span class="asterisk">*</span>
		</label>
			<input type="text" value="" name="FNAME" class="required" id="mce-FNAME">
		</div>
		<div class="mc-field-group">
			<label for="mce-LNAME">Last Name  <span class="asterisk">*</span>
		</label>
			<input type="text" value="" name="LNAME" class="required" id="mce-LNAME">
		</div>
		<div class="mc-field-group">
			<label for="mce-UNIVERSITY">University / College  <span class="asterisk">*</span>
		</label>
			<input type="text" value="" name="UNIVERSITY" class="required" id="mce-UNIVERSITY">
		</div>
		<div class="mc-field-group">
			<label for="mce-ORG">Student Group / Organization </label>
			<input type="text" value="" name="ORG" class="" id="mce-ORG">
		</div>
		<div class="mc-field-group input-group">
		    <strong>Email Format </strong>
		    <ul><li><input type="radio" value="html" name="EMAILTYPE" id="mce-EMAILTYPE-0"><label for="mce-EMAILTYPE-0">html</label></li>
		<li><input type="radio" value="text" name="EMAILTYPE" id="mce-EMAILTYPE-1"><label for="mce-EMAILTYPE-1">text</label></li>
		</ul>
		</div>
			<div id="mce-responses" class="clear">
				<div class="response" id="mce-error-response" style="display:none"></div>
				<div class="response" id="mce-success-response" style="display:none"></div>
			</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
		    <div style="position: absolute; left: -5000px;"><input type="text" name="b_28bd9f715aa97b4488567d729_c666d02534" value=""></div>
			<div class="clear"><input type="submit" value="Apply" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
		</form>
		</div>
		<script type="text/javascript">
		var fnames = new Array();var ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';fnames[3]='UNIVERSITY';ftypes[3]='text';fnames[4]='ORG';ftypes[4]='text';
		try {
		    var jqueryLoaded=jQuery;
		    jqueryLoaded=true;
		} catch(err) {
		    var jqueryLoaded=false;
		}
		var head= document.getElementsByTagName('head')[0];
		if (!jqueryLoaded) {
		    var script = document.createElement('script');
		    script.type = 'text/javascript';
		    script.src = '//ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js';
		    head.appendChild(script);
		    if (script.readyState && script.onload!==null){
			script.onreadystatechange= function () {
			      if (this.readyState == 'complete') mce_preload_check();
			}    
		    }
		}

		var err_style = '';
		try{
		    err_style = mc_custom_error_style;
		} catch(e){
		    err_style = '#mc_embed_signup input.mce_inline_error{border-color:#6B0505;} #mc_embed_signup div.mce_inline_error{margin: 0 0 1em 0; padding: 5px 10px; background-color:#6B0505; font-weight: bold; z-index: 1; color:#fff;}';
		}
		var head= document.getElementsByTagName('head')[0];
		var style= document.createElement('style');
		style.type= 'text/css';
		if (style.styleSheet) {
		  style.styleSheet.cssText = err_style;
		} else {
		  style.appendChild(document.createTextNode(err_style));
		}
		head.appendChild(style);
		setTimeout('mce_preload_check();', 250);

		var mce_preload_checks = 0;
		function mce_preload_check(){
		    if (mce_preload_checks>40) return;
		    mce_preload_checks++;
		    try {
			var jqueryLoaded=jQuery;
		    } catch(err) {
			setTimeout('mce_preload_check();', 250);
			return;
		    }
		    var script = document.createElement('script');
		    script.type = 'text/javascript';
		    script.src = 'http://downloads.mailchimp.com/js/jquery.form-n-validate.js';
		    head.appendChild(script);
		    try {
			var validatorLoaded=jQuery("#fake-form").validate({});
		    } catch(err) {
			setTimeout('mce_preload_check();', 250);
			return;
		    }
		    mce_init_form();
		}
		function mce_init_form(){
		    jQuery(document).ready( function($) {
		      var options = { errorClass: 'mce_inline_error', errorElement: 'div', onkeyup: function(){}, onfocusout:function(){}, onblur:function(){}  };
		      var mce_validator = $("#mc-embedded-subscribe-form").validate(options);
		      $("#mc-embedded-subscribe-form").unbind('submit');//remove the validator so we can get into beforeSubmit on the ajaxform, which then calls the validator
		      options = { url: 'http://emplayo.us3.list-manage1.com/subscribe/post-json?u=28bd9f715aa97b4488567d729&id=c666d02534&c=?', type: 'GET', dataType: 'json', contentType: "application/json; charset=utf-8",
				    beforeSubmit: function(){
					$('#mce_tmp_error_msg').remove();
					$('.datefield','#mc_embed_signup').each(
					    function(){
						var txt = 'filled';
						var fields = new Array();
						var i = 0;
						$(':text', this).each(
						    function(){
							fields[i] = this;
							i++;
						    });
						$(':hidden', this).each(
						    function(){
							var bday = false;
							if (fields.length == 2){
							    bday = true;
							    fields[2] = {'value':1970};//trick birthdays into having years
							}
							if ( fields[0].value=='MM' && fields[1].value=='DD' && (fields[2].value=='YYYY' || (bday && fields[2].value==1970) ) ){
								this.value = '';
											    } else if ( fields[0].value=='' && fields[1].value=='' && (fields[2].value=='' || (bday && fields[2].value==1970) ) ){
								this.value = '';
											    } else {
												if (/\[day\]/.test(fields[0].name)){
								this.value = fields[1].value+'/'+fields[0].value+'/'+fields[2].value;									        
												} else {
								this.value = fields[0].value+'/'+fields[1].value+'/'+fields[2].value;
								}
							    }
						    });
					    });
					$('.phonefield-us','#mc_embed_signup').each(
					    function(){
						var fields = new Array();
						var i = 0;
						$(':text', this).each(
						    function(){
							fields[i] = this;
							i++;
						    });
						$(':hidden', this).each(
						    function(){
							if ( fields[0].value.length != 3 || fields[1].value.length!=3 || fields[2].value.length!=4 ){
								this.value = '';
											    } else {
												this.value = 'filled';
							    }
						    });
					    });
					return mce_validator.form();
				    }, 
				    success: mce_success_cb
				};
		      $('#mc-embedded-subscribe-form').ajaxForm(options);
		      
		      
		    });
		}
		function mce_success_cb(resp){
		    $('#mce-success-response').hide();
		    $('#mce-error-response').hide();
		    if (resp.result=="success"){
			$('#mce-'+resp.result+'-response').show();
			$('#mce-'+resp.result+'-response').html(resp.msg);
			$('#mc-embedded-subscribe-form').each(function(){
			    this.reset();
			});
		    } else {
			var index = -1;
			var msg;
			try {
			    var parts = resp.msg.split(' - ',2);
			    if (parts[1]==undefined){
				msg = resp.msg;
			    } else {
				i = parseInt(parts[0]);
				if (i.toString() == parts[0]){
				    index = parts[0];
				    msg = parts[1];
				} else {
				    index = -1;
				    msg = resp.msg;
				}
			    }
			} catch(e){
			    index = -1;
			    msg = resp.msg;
			}
			try{
			    if (index== -1){
				$('#mce-'+resp.result+'-response').show();
				$('#mce-'+resp.result+'-response').html(msg);            
			    } else {
				err_id = 'mce_tmp_error_msg';
				html = '<div id="'+err_id+'" style="'+err_style+'"> '+msg+'</div>';
				
				var input_id = '#mc_embed_signup';
				var f = $(input_id);
				if (ftypes[index]=='address'){
				    input_id = '#mce-'+fnames[index]+'-addr1';
				    f = $(input_id).parent().parent().get(0);
				} else if (ftypes[index]=='date'){
				    input_id = '#mce-'+fnames[index]+'-month';
				    f = $(input_id).parent().parent().get(0);
				} else {
				    input_id = '#mce-'+fnames[index];
				    f = $().parent(input_id).get(0);
				}
				if (f){
				    $(f).append(html);
				    $(input_id).focus();
				} else {
				    $('#mce-'+resp.result+'-response').show();
				    $('#mce-'+resp.result+'-response').html(msg);
				}
			    }
			} catch(e){
			    $('#mce-'+resp.result+'-response').show();
			    $('#mce-'+resp.result+'-response').html(msg);
			}
		    }
		}

		</script>
		<!--End mc_embed_signup-->
		
		
	</div>
</div>
