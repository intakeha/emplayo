<div id="admin">
	<div class="content">
		<?php  
			echo '<div id="counter" class="flip-counter"></div><div class="title">Companies</div>';
			echo '<br><br><div class ="message">';
			echo $this->session->flashdata('message');
			echo '</div>';
		?>
		<div id="company_filters">			
			<form action="/admin/company/listing" method="post">
				<input type="hidden" name="filter" value="1"/>
				<input class="submit" type="submit" name="completed_link" value="Not Started"/>
			</form>    

			<form action="/admin/company/listing" method="post">
				<input type="hidden" name="filter" value="2"/>
				<input class="submit" type="submit" name="completed_link" value="Completed"/>
			</form>   

			<form action="/admin/company/listing" method="post">
				<input type="hidden" name="filter" value="3"/>
				<input class="submit" type="submit" name="completed_link" value="All"/>
			</form>
                    
			<?php echo '<a id="add_company" href = "/admin/company/create_step_1">Add Company</a><br>'; ?>
		</div>
		<form action="/admin/company/listing" method="post" id="company_search">
			<div id="listing_search">			
				<input class="company_search" name="company_search" type="text" value=""/>
				<input type="hidden" name="search_id" value=""/>
				<input class="submit" type="submit" name="search" value="Search" />
			</div>	    
		</form>
		<?php
			echo $table;
			echo '<div id="pagination">';    
			echo $pagination;
			echo '</div>';
		?>  
	</div>
	<script>
		var myCounter = new flipCounter("counter", {
				value: <?php echo $num_rows; ?>,
				pace: 500
			});
			myCounter.stop();
	</script>
</div>

