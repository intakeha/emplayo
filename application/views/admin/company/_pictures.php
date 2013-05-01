<div id="admin">
	<div class="content">
		
		<a href = "/admin/company/listing">Back to Listing</a>
		<?php
		echo "<a href = '/admin/company/profile_edit/{$company_id}'>Add picture</a>";
		echo "<div>".$this->session->flashdata('message')."</div>";
		?>
		
		<div>
			<div id="company_name">Company: <a href="/admin/company/view/<?php echo $company_id;?>"><?php echo $company_info['company_name'];?></a></div> 
			<form accept-charset="utf-8" action="/admin/company/pictures/<?php echo $company_id;?>" method="POST">
				<?php
				    if (!empty($profile_pics))
				    {
					$image_path = "/assets/images/company_tiles/";
					foreach ($profile_pics as $row)
					{                         
					    echo "<div><img src='{$image_path}{$row['file_name']}' height='100px'/>";
					    echo "<input id='pics_to_delete' type='checkbox' value='{$row['file_name']}' name='pics_to_delete[]' >";
					    echo "</div>";
					}
				    }
				?>
			    
				<input type="submit" name="remove" value="Remove" />
			</form>
			<?php echo form_error('pics_to_delete'); ?>
		</div>
 
	</div>
</div>







