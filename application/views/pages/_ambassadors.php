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
			<h1 class="titles blue">Student Ambassador Program!</h1>
			<p>Emplayo is committed to growing and preparing the next generation of leaders for the future workforce.</p>
			<p>The Emplayo Student Ambassador Program is an opportunity for active students to experience entrepreneurship
			at their universities and to prepare for a successful start in their careers. The program is designed to enhance professional
			development and soft skills, to meet and collaborate with other student ambassadors around the world, and to have fun creating
			a legacy for their university.</p>
			<p>Every student ambassador will have an opportunity to:</p>
			<ul>
				<li>Gain experience in marketing, promotion and entrepreneurship</li>
				<li>Network with other student ambassadors around the world</li>
				<li>Strengthen resume with relevant experiences</li>
				<li>Obtain references for job applications</li>
				<li>Be recognized as a university ambassador on Emplayo's website</li>
				<li>Be a part of Emplayo's Student Ambassador Alumni Network</li>
			</ul>
			<a id="button" href="/contact">Apply</a>
		</div>		
	</div>
</div>
