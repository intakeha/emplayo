<div id="admin">
	<div class="content">
		<div id="quotes_nav">
			<a href = "/admin/company/listing">Back<br>to Listing</a>
		<?php 
			echo "<a href = '/admin/company/add_quotes/{$company_id}'>Add<br>Quotes</a></div>"; 
		?>
		
		<div id="quotes">
			<div id="company_name">Company: <a href="/company/profile/<?php echo $company_id;?>" target="_blank"><?php echo $company_info['company_name'];?></a></div>   
			<br>
			<form accept-charset="utf-8" action="/admin/company/quotes/<?php echo $company_id;?>" method="POST">
			<?php
			    if (!empty($quotes))
			    {
				foreach ($quotes as $row)
				{                         
				    echo "<div class='quotes'><div class='delete_icon'></div><input type='checkbox' value='{$row['id']}' name='remove_quotes[]' ><div>\"{$row['quote']}\"</div></div>";
				}
			    }
			?>
			<input type="submit" name="remove" value="Remove" />
			</form>			
			
			<?php
				if (form_error('remove_quotes')) {
					echo "<div class='errors messages'>".form_error('remove_quotes')."</div>"; 
				};
				if ($this->session->flashdata('message')) {
					echo "<div class='messages'>".$this->session->flashdata('message')."</div>";
				};
			?>
		</div>
		
		<script>
			$(document).ready(function(){
				$('div#admin div.quotes').on("click", function(){
					if($(this).find('input').is(':checked')){
						$(this).find('input').prop('checked', false);
						$(this).find('.delete_icon').removeClass('selected');
					} else {
						$(this).find('input').prop('checked', true);
						$(this).find('.delete_icon').addClass('selected');
					};
				});
				
				
			});//end of document ready 
		</script>
	</div>
</div>





