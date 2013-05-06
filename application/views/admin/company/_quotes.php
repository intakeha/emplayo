<div id="admin">
	<div class="content">
		<div id="quotes_nav">
			<a href = "/admin/company/listing">Back<br>to Listing</a>
		<?php 
			echo "<a href = '/admin/company/add_quotes/{$company_id}'>Add<br>Quotes</a></div>"; 
		?>
		
		<div id="quotes">
			<div id="company_name">Company: <a href="/company/profile/<?php echo $company_id;?>"><?php echo $company_info['company_name'];?></a></div>   
			<br>
			<form accept-charset="utf-8" action="/admin/company/quotes/<?php echo $company_id;?>" method="POST">
			<?php
			    if (!empty($quotes))
			    {
				foreach ($quotes as $row)
				{                         
				    echo "<div class='quotes'><input type='checkbox' value='{$row['id']}' name='quotes_to_delete[]' ><div>\"{$row['quote']}\"</div></div>";
				}
			    }
			?>
			<input type="submit" name="remove" value="Remove" />
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
	</div>
</div>





