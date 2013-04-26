<div id="admin">
	<div class="content">
		<?php  
			echo '<div id="counter" class="flip-counter"></div><div class="title">Companies</div>';
			echo '<a id="add_company" href = "/admin/company/create_step_1">Add Entry</a><br>';
			echo '<br><br><div class ="message">';
			echo $this->session->flashdata('message');
			echo '</div>';

			echo '<div id="table">';
			echo $table;
			echo '</div>';
			echo '<div id="pagination">';    
			echo $pagination;
			echo '</div>';
		?>  
	</div>
	<script>
		var myCounter = new flipCounter("counter", {
				value: <?php echo $num_rows; ?>,
				pace: 0
			});
			myCounter.stop();
	</script>
</div>

