
<script>
	$(document).ready(function(){
		
		// Display default checked radio on company type
		var typeValue = $("input[name=company_type]:checked").val();
		$('fieldset#type li#coType_'+typeValue).addClass("coTypeSelected");
		
		$('fieldset#type li').on("click", function(event){
			$('fieldset#type li').removeClass();
			$(this).addClass("coTypeSelected");
			
			coTypeIndex = $(this).index('ul#co_type li');
			$("fieldset#type input").eq(coTypeIndex).prop('checked',true);
		});
		
		// Display default checked radio on company pace
		var paceValue = $("input[name=company_pace]:checked").val();
		if (paceValue == 1){
			$('li#coPace_1').css('background-position','-360px 0px');
			$('li#coPace_2').css('background-position','-120px 0px');
			$('li#coPace_3').css('background-position','-240px 0px');
		};
		if (paceValue == 2){
			$('li#coPace_1').css('background-position','0px 0px');
			$('li#coPace_2').css('background-position','-480px 0px');
			$('li#coPace_3').css('background-position','-240px 0px');
		};			
		if (paceValue == 3){
			$('li#coPace_1').css('background-position','0px 0px');
			$('li#coPace_2').css('background-position','-120px 0px');
			$('li#coPace_3').css('background-position','-600px 0px');
		};
		$('fieldset#pace li#coPace_'+paceValue).addClass("selected");
		
		$('fieldset#pace li').on("click", function(event){
			$('fieldset#pace li').removeClass();
			$(this).addClass("selected");
			
			coPaceIndex = $(this).index('ul#coPace li');
			$("fieldset#pace input").eq(coPaceIndex).prop('checked',true);
			
			if (coPaceIndex == 0){
				$('li#coPace_1').css('background-position','-360px 0px');
				$('li#coPace_2').css('background-position','-120px 0px');
				$('li#coPace_3').css('background-position','-240px 0px');
			};
			if (coPaceIndex == 1){
				$('li#coPace_1').css('background-position','0px 0px');
				$('li#coPace_2').css('background-position','-480px 0px');
				$('li#coPace_3').css('background-position','-240px 0px');
			};			
			if (coPaceIndex == 2){
				$('li#coPace_1').css('background-position','0px 0px');
				$('li#coPace_2').css('background-position','-120px 0px');
				$('li#coPace_3').css('background-position','-600px 0px');
			};			
		});
		
		// Display selected lifecycle data
		var lifecycleValue = $("input[name=company_lifecycle]:checked").val();
		$('fieldset#lifecycle li#coLifecycle_'+lifecycleValue).addClass("coCycleSelected");
		
		$('fieldset#lifecycle li').on("click", function(event){
			$('fieldset#lifecycle li').removeClass();
			$(this).addClass("coCycleSelected");
			
			coCycleIndex = $(this).index('ul#co_cycle li');
			$("fieldset#lifecycle input").eq(coCycleIndex).prop('checked',true);
		});
		
		// Display company corporate citizenship
		var citizenshipValue = $("input[name=corp_citizenship]:checked").val();
		$('#citizenshipSlider').slider({
			animate: true,
			min: 1,
			max: 5,
			width: 'resolve',
			value: citizenshipValue,
			change: function(event, ui){
				$('div#citizenshipSlider a').addClass('sliderActive');
				switch(ui.value)
				{
				case 1:
					$("fieldset#citizenship input").eq(ui.value-1).prop('checked',true);
					break;
				case 2:
					$("fieldset#citizenship input").eq(ui.value-1).prop('checked',true);
					break;
				case 3:
					$("fieldset#citizenship input").eq(ui.value-1).prop('checked',true);
					break;
				case 4:
					$("fieldset#citizenship input").eq(ui.value-1).prop('checked',true);
					break;
				case 5:
					$("fieldset#citizenship input").eq(ui.value-1).prop('checked',true);
					break;
				default:
					break;
				};
			}
		});

	
		// Display selected benefits data
		$('div.benefits_wrapper').on("click", function(event){
			$(this).find('div').toggleClass('selected');
						
			var $checkbox = $(this).find('input');
			if($(this).find('div').hasClass('selected')) {
				$checkbox.prop('checked', true);
			} else {
				$checkbox.prop('checked', false);
			}			
			
		});
		
		$("fieldset#categories select").select2();
	});
</script>
 
<div id="admin">
	<div id="dataUpdate" class="content">
	
           <?php 

		if ($this->session->flashdata('upload_error') != ''){
			$upload_error = $this->session->flashdata('upload_error');
		}   

		if (isset($company_info['company_name'])){
			$default_name = $company_info['company_name'];
		} else {$default_name = '';}
		
		$name_data = array(
			'name' => 'company_name',
			'id' => 'company_name',
			'value' => set_value('company_name',$default_name)
		);

		if (isset($company_info['company_url'])){
			$default_url = $company_info['company_url'];
		} else {$default_url = '';}   
		
		$url_data = array(
			'name' => 'company_url',
			'id' => 'company_url',
			'value' => set_value('company_url',$default_url)
		);
		
		if (isset($company_info['jobs_url'])){
			$jobs_url = $company_info['jobs_url'];
		} else {$jobs_url = '';} 
					
		$jobs_data = array(
			'name' => 'jobs_url',
			'id' => 'jobs_url',
			'value' => set_value('jobs_url',$jobs_url)
		);
		
		if (isset($company_info['facebook_url'])){
			$facebook_url = $company_info['facebook_url'];
		} else {$facebook_url = '';}   
			    
		$facebook_data = array(
			'name' => 'facebook_url',
			'id' => 'facebook_url',
			'value' => set_value('facebook_url',$facebook_url)
		);

		if (isset($company_info['twitter_url'])){
			$twitter_url = $company_info['twitter_url'];
		} else {$twitter_url = '';}
			    
		$twitter_data = array(
			'name' => 'twitter_url',
			'id' => 'twitter_url',
			'value' => set_value('twitter_url',$twitter_url)
		);
		
		$submit_url = 'admin/company/create_step_1';
		echo form_open_multipart($submit_url);
		
		$companyName = array('id' => 'companyName');
		echo form_fieldset('Company Name', $companyName);		
		echo form_input($name_data);
		echo form_fieldset_close();
		
		$companyURL = array('id' => 'companyURL');
		echo form_fieldset('Company URL', $companyURL); 
		echo form_input($url_data);
		echo form_fieldset_close();

		$jobURL = array('id' => 'jobURL');
		echo form_fieldset('Jobs URL', $jobURL); 
		echo form_input($jobs_data);
		echo form_fieldset_close();   
		
		$facebookURL = array('id' => 'facebookURL');
		echo form_fieldset('Facebook URL', $facebookURL); 
		echo form_input($facebook_data);
		echo form_fieldset_close();   

		$twitterURL = array('id' => 'twitterURL');
		echo form_fieldset('Twitter URL',$twitterURL); 
		echo form_input($twitter_data);
		echo form_fieldset_close();  

		$type = array('id' => 'type', 'class' => 'hide');
		echo form_fieldset('Company Type', $type);
		echo '<ul id="co_type"><li id="coType_1"></li><li id="coType_2"></li><li id="coType_3"></li><li id="coType_4"></li></ul>';
		foreach ($type_array as $row) 
		{?>
			<input type="radio" name="company_type" value="<?php echo $row['id'];?>" id="company_type" 
			<?php 
			if (isset($company_info['type_id'])){
				if ($company_info['type_id'] == $row['id'])
				{
					echo set_radio('company_type', ''.$row['id'].'',TRUE);
				} else {
					echo set_radio('company_type', ''.$row['id'].'',FALSE);
				}
			}else{
				echo set_radio('company_type', ''.$row['id'].'');   
			} 
			?> />
			<?php
			echo form_label($row['type'],'company_type');
		}
		echo form_fieldset_close();
		
		$pace = array('id' => 'pace', 'class' => 'hide');
		echo form_fieldset('Company Pace', $pace);
		echo '<ul id="coPace"><li id="coPace_1">Slow</li><li id="coPace_2">Medium</li><li id="coPace_3">Fast</li></ul>';
		foreach ($pace_array as $row) 
		{?>
			<input type="radio" name="company_pace" value="<?php echo $row['id'];?>" id="company_pace" 
			<?php 
			if (isset($company_info['pace_id'])){
				if ($company_info['pace_id'] == $row['id'])
				{                       
					echo set_radio('company_pace', ''.$row['id'].'',TRUE); 
				} else {
					echo set_radio('company_pace', ''.$row['id'].'',FALSE);
				}
			} else {
				echo set_radio('company_pace', ''.$row['id'].'');
			}
			?>/>
			<?php               
			echo form_label($row['pace'],'company_pace');
		}
		echo form_fieldset_close();
		
		$lifecycle = array('id' => 'lifecycle', 'class' => 'hide');
		echo form_fieldset('Company Lifecycle', $lifecycle);
		echo '<div id="co_cycle_header"></div><ul id="co_cycle"><li id="coLifecycle_1"></li><li id="coLifecycle_2"></li><li id="coLifecycle_3"></li><li id="coLifecycle_4"></li><li id="coLifecycle_5"></li></ul>';
		foreach ($lifecycle_array as $row) 
		{?>
			<input type="radio" name="company_lifecycle" value="<?php echo $row['id'];?>" id="company_lifecycle"
			<?php 
			if (isset($company_info['lifecycle_id'])){
				if ($company_info['lifecycle_id'] == $row['id'])
				{                       
					echo set_radio('company_lifecycle', ''.$row['id'].'',TRUE); 
				} else {
					echo set_radio('company_lifecycle', ''.$row['id'].'',FALSE);
				}
			} else {
				echo set_radio('company_lifecycle', ''.$row['id'].'');
			}                       
			?>/>
			<?php                
			echo form_label($row['lifecycle'],'company_lifecycle');
			echo '<br/>';
		}	
		echo form_fieldset_close();

		$citizenship = array('id' => 'citizenship', 'class' => 'hide');
		echo form_fieldset('Corporate Citizenship', $citizenship);
		?>
		
		<div id="citizenshipSlider" style="background: none; border: none; cursor: pointer;"></div>
		<div class="coCitizenshipMarkers">
			<ul>
				<li class="right5Marker">Not<br>Important</li>
				<li class="right5Marker">Somewhat Important</li>
				<li class="right5Marker">Important</li>
				<li class="right5Marker">Very Important</li>
				<li>Extremely Important</li>
			</ul>
		</div>
		<div class="clear" style="margin-top: 100px;"></div>
		<?php
		
		foreach ($corp_citizenship_array as $row) 
		{?>
			<input type="radio" name="corp_citizenship" value="<?php echo $row['id'];?>" id="corp_citizenship"
			<?php 
			if (isset($company_info['corp_citizenship_id'])){
				if ($company_info['corp_citizenship_id'] == $row['id'])
				{                       
					echo set_radio('corp_citizenship', ''.$row['id'].'',TRUE); 
				} else {
					echo set_radio('corp_citizenship', ''.$row['id'].'',FALSE);
				}
			} else {
				echo set_radio('corp_citizenship', ''.$row['id'].'');
			}
			?>/>
			<?php                   
			echo form_label($row['corp_citizenship'],'corp_citizenship');
		}            
		echo form_fieldset_close();
		
		$benefits = array('id' => 'benefits', 'class' => 'hide');
		echo form_fieldset('Company Benefits', $benefits); 
		foreach ($benefits_array as $row) 
		{
			if (isset($benefits_info) && in_array($row['id'],$benefits_info))
			{

				$check = 'checked="checked"';
				$selected = 'selected';
				echo "<div class='benefits_wrapper'><div class='benefits_".$row['id']." benefits ".$selected."'>".$row['benefits']."</div><input type='checkbox' value='".$row['id']."' name='benefits[] '".$check." /></div>";
			}else{
				$check = $selected = ''; 
				echo "<div class='benefits_wrapper'><div class='benefits_".$row['id']." benefits ".$selected."'>".$row['benefits']."</div><input type='checkbox' value='".$row['id']."' name='benefits[]' /></div>";
			}
			
			//echo "<div class='benefits_wrapper'><div class='benefits_".$row['id']." benefits ".$selected."'>".$row['benefits']."</div><input type='checkbox' value='".$row['id']."' name='benefits[]' ".$check." /></div>";
		}
		echo form_fieldset_close();
		
		$categories = array('id' => 'categories');
		echo form_fieldset('Categories', $categories);
		if (isset($categories_info))
		{
			$postcat = $categories_info;
		}else
		{
			$postcat = $this->input->post('category'); 
		}
		echo form_multiselect('category[]', $category_array, $postcat);
		
		echo form_fieldset_close();  

		$submitButton = array('class' => 'button_green');
		echo form_submit($submitButton, 'Next');
		echo form_close();
	   
	?>

	</div>
</div>

