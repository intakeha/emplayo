<script>
    $( document ).ready(function() {
	$("#employers a#button").hover(
		function () {
		$(this).animate({backgroundColor: '#27c339', color: '#fff'}, 200);
		},
		function () {
		$(this).animate({backgroundColor: '#e9b60b', color: '#1D2A33'}, 200);
		}
	);
    });
</script>
<div id="employers">
	<div class="content">
		<div>
			<h1 class="titles emplayo_blue">Attract top talent with Emplayo!</h1>
			<ul>
				<li>
					<div class="icon"><img src="../assets/images/static/brand_icon.png"></div>
					<img src="../assets/images/static/brand.png">
					<p class="desc">Showcase your company&#39;s brand &amp; culture with a visual collage.</p>
				</li>
				<li>
					<div class="icon"><img src="../assets/images/static/postings_icon.png"></div>
					<img src="../assets/images/static/postings.png">
					<p class="desc">Channel job openings to the most suitable candidates.</p>
				</li>
				<li>
					<div class="icon"><img src="../assets/images/static/target_icon.png"></div>
					<img src="../assets/images/static/target.png">
					<p class="desc">Cut down your sourcing time with our matching technology.</p>
				</li>
			</ul>
			
			<p class="clear">Contact Emplayo to discuss your recruiting needs.</p>
			<a id="button" href="/contact">Contact Us</a>
		</div>
	</div>
</div>

