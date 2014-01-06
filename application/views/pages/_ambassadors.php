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
			<a id="button" href="/contact">Apply</a>
		</div>		
	</div>
</div>
