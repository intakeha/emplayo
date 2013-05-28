<div id="admin">
	<div class="content">
		<div id="pictures_nav">
		<a href = "/admin/company/listing">Back<br>to Listing</a>
		<?php
		echo "<a href = '/admin/company/add_pictures/{$company_id}'>Add<br>Picture</a></div>";
		?>
		
		<div id="pictures">
			<div id="company_name">Company: <a href="/company/profile/<?php echo $company_id;?>" target="_blank"><?php echo $company_info['company_name'];?></a></div><br>
			<form accept-charset="utf-8" action="/admin/company/pictures/<?php echo $company_id;?>" method="POST">
				<?php
				    if (!empty($profile_pics))
				    {
					$image_path = base_url().PROFILE_PIC_PATH;
					foreach ($profile_pics as $row)
					{                         
					    echo "<div><img src='{$image_path}{$row['file_name']}' height='100px'/>";
					    echo "<br><input id='remove_pics' type='checkbox' value='{$row['file_name']}' name='remove_pics[]' >";
					    echo "</div>";
					}
				    }
				?>
				<p class="clear"><br>
					<input type="submit" name="remove" value="Remove" />
				</p>
			</form>
			
			<?php
				if (form_error('remove_pics')) {
					echo "<div class='clear errors messages'>".form_error('remove_pics')."</div>"; 
				};
				if ($this->session->flashdata('message')) {
					echo "<div class='clear messages'>".$this->session->flashdata('message')."</div>";
				};
			?>

		</div>
		<script>
			$(document).ready(function(){
				$('div#admin div#pictures form div').on("click", function(){
					if($(this).find('input').is(':checked')){
						$(this).find('input').prop('checked', false);
						$(this).find('.delete_icon').remove();
					} else {
						$(this).find('input').prop('checked', true);
						$(this).find('input').after('<div class="delete_icon"></div>');
					};
				}).mouseenter(function(){
					$(this).addClass("highlight");
				}).mouseleave(function(){
					$(this).removeClass("highlight");
				});
				
				
			});//end of document ready 
		</script>
	</div>
</div>







