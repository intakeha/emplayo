<div id="admin">
	<div class="content">
		<div id="quotes_nav">
			<a href = "/admin/company/listing">Back<br>to Listing</a>
		<?php 
			echo "<a href = '/admin/company/quotes/{$company_id}'>View<br>Quotes</a></div>"; 
		?>

		<div id="quotes">
			<div id="company_name">Company: <a href="/company/profile/<?php echo $company_id;?>" target="_blank"><?php echo $company_info['company_name'];?></a></div>   
			<br>
			<form accept-charset="utf-8" action="/admin/company/add_quotes/<?php echo $company_id;?>" method="POST">
			    <textarea id="quote" name="quote" rows="5" cols="50" maxlength="200"></textarea>
			    <div id="limit">Characters left: <span>200</span></div>
			    <input type="submit" name="mysubmit" value="Submit" />
			</form>
			
			<?php
				if (form_error('quote')) {
					echo "<div class='errors messages'>".form_error('quote')."</div>"; 
				};
				if ($this->session->flashdata('message')) {
					echo "<div class='messages'>".$this->session->flashdata('message')."</div>";
				};
			?>
		</div>
		<script>
		$(document).ready(function(){
			$('#quotes textarea').val('').focus();
			$('#quote').bind('keyup', function(e){
				var len = $(this).val().length;
				$('#limit span').text(200 - len);
			});    
		});//end of document ready
		</script>

	</div>
</div>





