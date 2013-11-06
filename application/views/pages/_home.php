<script>
	$(function() {
		// Homepage animation
		$('#start, #start a').delay(500).animate({ opacity: 1, left: "0px" }, 500);
		$('#icon').delay(500).animate({ opacity: 1, top: "-=10px" }, 500);
		$("#start a").hover(
			function () {
			$(this).animate({backgroundColor: '#ad27c1'}, 200);
			},
			function () {
			$(this).animate({backgroundColor: '#e9b60b'}, 200);
			}
		);

		// User Home Start button animation
		$("#profile a#start_btn").hover(
			function () {
			$(this).animate({backgroundColor: '#27c339', color: '#fff'}, 200);
			},
			function () {
			$(this).animate({backgroundColor: '#e9b60b', color: '#1D2A33'}, 200);
			}
		);
	});

</script> 
<div id="home">
	<div id="banner">
		<div class="content">
			<div id="icon"></div>
			<div id="start">Emplayo helps you find the companies<br>that fit you best.
                                <a href="inquire">Get Started</a>
			</div>
		</div>
	</div>
	<div id="belt">
		<div class="content">
			<div id="step1" class="steps">Step through 20 questions on your Work-Life-Play preferences.</div>
			<div id="step2" class="steps">See which companies fit you best based on your answers.</div>
			<div id="step3" class="steps">Get a personalized listing to apply for jobs instantly!</div>
		</div>
	</div>
	<div id="story">
		<div class="content">
			<iframe id="video" width="560" height="315" src="//www.youtube.com/embed/Y7_LRkcyKmg?rel=0&showinfo=0" frameborder="0" allowfullscreen></iframe>
			<p>Every company has different culture, different perks, and different style. Each job has different expectations,
			different management, and different team members.</p>
			<p>Forget about those "Best Places To Work" lists, because one size definitely doesn't fit all.  Forget about those
			generic job boards that spit out every single job in the known universe.</p>
			<p>Which one is right for you? We'll help you figure it out.</p>
		</div>
	</div>
	<div class="preload">
		<img src="<?php echo base_url() ?>assets/images/survey/co_type.jpg">
		<img src="<?php echo base_url() ?>assets/images/survey/progressBar.jpg">
		<img src="<?php echo base_url() ?>assets/images/survey/progressBar.png">
		<img src="<?php echo base_url() ?>assets/images/survey/co_pace.jpg">
		<img src="<?php echo base_url() ?>assets/images/survey/co_cycle_header.jpg">
		<img src="<?php echo base_url() ?>assets/images/survey/co_cycle.jpg">
		<img src="<?php echo base_url() ?>assets/images/survey/co_type.jpg">
		<img src="<?php echo base_url() ?>assets/images/survey/benefits_bar.png">
		<img src="<?php echo base_url() ?>assets/images/survey/slider_5markers.jpg">
		<img src="<?php echo base_url() ?>assets/images/survey/sliderHandleDefault.png">
		<img src="<?php echo base_url() ?>assets/images/survey/sliderHandle.png">
		<img src="<?php echo base_url() ?>assets/images/survey/instructions.png">
		<img src="<?php echo base_url() ?>assets/images/survey/instructions_preview.png">
		<img src="<?php echo base_url() ?>assets/images/survey/industries.png">
		<img src="<?php echo base_url() ?>assets/images/survey/globe.jpg">
		<img src="<?php echo base_url() ?>assets/images/survey/leadership.jpg">
</div>
</div>