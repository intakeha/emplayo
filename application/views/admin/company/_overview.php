<div id="admin">
	<div class="content">
		<div id="overview_nav">
			<a href = "/admin/company/listing">Back<br>to Listing</a> 
			<a href = "/admin/company/update_step_1/<?php echo $company_id;?>">Edit<br>This Company</a>
			<a href = "/company/profile/<?php echo $company_id;?>">Preview<br>Company Page</a>
		</div>

		<div id="company_overview">
			<?php 
			if ($this->session->flashdata('upload_error') != ''){
				$upload_error = $this->session->flashdata('upload_error');
			}
			
			if (isset($message)) {echo $message;}
			echo "<div class='errors'>";
			if (isset($errors)){
				foreach ($errors as $value) {
					echo $value.'<br>';
				}
			}
			echo '</div>';

			//COMPANY NAME        
			echo form_fieldset('Company Name');  

			if (isset($company_info['company_name'])){
				$default_name = $company_info['company_name'];
			} else {$default_name = '';}
			echo "<div class='data'>".$default_name."</div>";
			echo form_fieldset_close();

			//COMPANY LOGO        
			echo form_fieldset('Company Logo'); 
			$image_path = base_url().COMPANY_LOGO_PATH.$company_info['company_logo'];
			echo "<div class='data'><img src=\"$image_path\"></div>";
			echo "<div class='file_name'>File Name: <br>".$company_info['company_logo']."</div>";
			echo form_fieldset_close();

			//CREATIVE LOGO        
			echo form_fieldset('Creative Logo');   
			$image_path2 = base_url().COMPANY_LOGO_PATH.$company_info['creative_logo'];
			echo "<div class='data'><img src=\"$image_path2\"></div>";
			echo "<div class='file_name'>File Name: <br>".$company_info['creative_logo']."</div>";
			echo form_fieldset_close();            

			//COMPANY URL        
			echo form_fieldset('Company URL');  
			if (isset($company_info['company_url'])){
			$default_url = $company_info['company_url'];
			} else {$default_url = '';}   

			echo "<div class='data'><a href=\"$default_url\" target=\"_blank\">$default_url</a></div>";
			echo form_fieldset_close();            

			//JOBS URL        
			echo form_fieldset('Jobs URL');  

			if (isset($company_info['jobs_url'])){
			$jobs_url = $company_info['jobs_url'];
			} else {$jobs_url = '';}              

			echo "<div class='data'><a href='{$jobs_url}' target='_blank'>$jobs_url</a></div>";
			echo form_fieldset_close();             

			//FACEBOOK URL        
			echo form_fieldset('Facebook URL');  

			if (isset($company_info['facebook_url'])){
			$facebook_url = $company_info['facebook_url'];
			} else {$facebook_url = '';}             

			echo "<div class='data'><a href='{$facebook_url}' target='_blank'>$facebook_url</a></div>";            
			echo form_fieldset_close();             

			//TWITTER URL      
			echo form_fieldset('Twitter URL');  

			if (isset($company_info['twitter_url'])){
			$twitter_url = $company_info['twitter_url'];
			} else {$twitter_url = '';}              

			echo "<div class='data'><a href='{$twitter_url}' target='_blank'>$twitter_url</a></div>"; 
			echo form_fieldset_close();              

			//COMPANY TYPE        
			echo form_fieldset('Company Type');

			foreach ($type_array as $row) 
			{         
				if (isset($company_info['type_id'])){
					if ($company_info['type_id'] == $row['id'])
					{
						echo "<div class='data'>".$row['type']."</div>";
					} 
				}
			}
			echo form_fieldset_close();               


			//COMPANY PACE
			echo form_fieldset('Company Pace');
			foreach ($pace_array as $row) 
			{
				if (isset($company_info['pace_id'])){
					if ($company_info['pace_id'] == $row['id'])
					{                       
						echo "<div class='data'>".$row['pace']."</div>"; 
					} 
				}
			}
			echo form_fieldset_close();                       

			//COMPANY LIFECYCLE
			echo form_fieldset('Company Lifecycle');
			foreach ($lifecycle_array as $row) 
			{                      
				if (isset($company_info['lifecycle_id'])){
					if ($company_info['lifecycle_id'] == $row['id'])
					{                       
						echo "<div class='data'>".$row['lifecycle']."</div>"; 
					} 
				}
			}
			echo form_fieldset_close();  

			//CORPORATE CITIZENSHIP
			echo form_fieldset('Corporate citizenship');

			foreach ($corp_citizenship_array as $row) 
			{
				if (isset($company_info['corp_citizenship_id'])){
					if ($company_info['corp_citizenship_id'] == $row['id'])
					{                       
						echo "<div class='data'>".$row['corp_citizenship']."</div>"; 
					}
				}
			}            
			echo form_fieldset_close();               

			//BENEFITS
			$benefits = array('id' => 'benefits','name' => 'benefits[]');
			echo form_fieldset('Company Benefits'); 

			echo "<div class='data'><ul>";
			foreach ($benefits_array as $row) 
			{
				if (isset($benefits_info) && in_array($row['id'],$benefits_info))
				{
					echo "<li>";
					echo $row['benefits'];
					echo "</li>";
				}
			}   
			echo "</ul></div>";
			echo form_fieldset_close();             

			//Category Info
			echo form_fieldset('Categories');
			echo "<div class='data'><ul>";

			foreach ($category_array as $key=>$value) 
			{
				if (isset($categories_info) && in_array($key,$categories_info))
				{
					echo "<li>";
					echo $value;
					echo "</li>";
				}
			}   
			echo "</ul></div>";
			echo form_fieldset_close();             
			?>
		</div><!--end div "type"-->
	</div>
</div>