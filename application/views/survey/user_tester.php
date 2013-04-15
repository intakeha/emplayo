<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Survey</title>
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/reset-fonts-grids.css" type="text/css"/>
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/base.css" type="text/css"/>        
<!--begin jquery sortabe stuff-->

 <!--end jquery sortabe stuff-->       
        <style>
            .clearfloat {
                    font-size: 1px;
                    line-height: 0px;
                    margin: 0px;
                    clear: both;
                    height: 0px;
            }       
            .env_1 {
                    float: left;
                    margin: 10px 10px 0px 0px;
                    width: 140px;
            }
            .env_2 {
                float: left;
                margin: 10px 10px 0px 0px;
            }
            .env_subbox {
                width: 400px;
            }
            
        </style>
</head>
<body>

<div id="container">
  
    <div id="doc2">
    <div id="hd"><!-- header -->
	<h1>The Work.Life.Play Survey</h1>

    </div>

	<div id="bd"><!-- body -->
            <div id="type">
        <p>
           <?php 
           $this->load->helper("form");
           echo $message;
           echo validation_errors();
           /*
            ?>
            <?php foreach ($message as $message_item){ ?>
            <br>
            <?php echo $message_item['company_type'] ?>

            <?php }?>
            <?php
           */
           //if there are errors after the form has been submitted, echo them here
           echo validation_errors();
           //
            
           echo form_open('preview');

            echo '<br/>';         
            
            //company type
            $company_type = array('id' => 'user_type','name' => 'user_type[]'); 
            echo form_fieldset('What kind of company do you want to work for?');
            echo form_checkbox($company_type,'1',TRUE);
            echo form_label('For Profit - Publicly Traded','profit_public');
            echo '<br/>';            
            echo form_checkbox($company_type,'2',TRUE);
            echo form_label('For Profit - Privately Held','profit_private');
            echo '<br/>';
            echo form_checkbox($company_type,'3',FALSE);
            echo form_label('Non-Profit','nonprofit');
            echo '<br/>';
            echo form_checkbox($company_type,'4',FALSE);
            echo form_label('Government/Public','public');
            echo form_fieldset_close(); 
            
            //company pace
            $company_pace = array('id' => 'user_pace','name' => 'user_pace[]'); 
            echo form_fieldset('What company pace would you prefer?');
            echo form_checkbox($company_pace,'1',FALSE);
            echo form_label('Slow','slow');
            echo '<br/>';            
            echo form_checkbox($company_pace,'2',TRUE);
            echo form_label('Medium','medium');
            echo '<br/>';
            echo form_checkbox($company_pace,'3',TRUE);
            echo form_label('Fast','fast');
            echo '<br/>';
            echo form_fieldset_close(); 

            //lifecycle
            $lifecycle = array('id' => 'user_lifecycle','name' => 'user_lifecycle[]'); 
            echo form_fieldset('What company lifecycle would you prefer?');
            echo form_checkbox($lifecycle,'1',FALSE);
            echo form_label('Startup','startup');
            echo '<br/>';            
            echo form_checkbox($lifecycle,'2',TRUE);
            echo form_label('Rapid Growth','rapid_growth');
            echo '<br/>';
            echo form_checkbox($lifecycle,'3',TRUE);
            echo form_label('Maturity','maturity');
            echo '<br/>';
            echo form_checkbox($lifecycle,'4',FALSE);
            echo form_label('Rebirth','rebirth');
            echo '<br/>';            
            echo form_fieldset_close();             
            
            //benefits and perks
            echo form_fieldset('Rank the following company benefits in order of importance to you:');
            echo '<input type="text" name="user_benefits[1][rank]" id="1" maxlength="2" size="2" value = "16" style="width:3%" />';
            echo form_label('Health Care', '1');
            echo '<br/>';
            echo '<input type="text" name="user_benefits[2][rank]" id="2" maxlength="2" size="2" value = "15" style="width:3%" />';
            echo form_label('Child Care', '2');
            echo '<br/>';
            echo '<input type="text" name="user_benefits[3][rank]" id="3" maxlength="2" size="2" value = "14" style="width:3%" />';
            echo form_label('Family Leave', '3');
            echo '<br/>';
            echo '<input type="text" name="user_benefits[4][rank]" id="4" maxlength="2" size="2" value = "13" style="width:3%" />';
            echo form_label('Fitness Facilities', '4');
            echo '<br/>';
            echo '<input type="text" name="user_benefits[5][rank]" id="5" maxlength="2" size="2" value = "12" style="width:3%" />';
            echo form_label('Dependendent Care Support', '5');
            echo '<br/>';
            echo '<input type="text" name="user_benefits[6][rank]" id="6" maxlength="2" size="2" value = "11" style="width:3%" />';
            echo form_label('Telecommuting', '6');
            echo '<br/>';
            echo '<input type="text" name="user_benefits[7][rank]" id="7" maxlength="2" size="2" value = "10" style="width:3%" />';
            echo form_label('Paid Time Off', '7');
            echo '<br/>';
            echo '<input type="text" name="user_benefits[8][rank]" id="8" maxlength="2" size="2" value = "9" style="width:3%" />';
            echo form_label('Paid Sabbatical', '8');
            echo '<br/>';
            echo '<input type="text" name="user_benefits[9][rank]" id="9" maxlength="2" size="2" value = "8" style="width:3%" />';
            echo form_label('Compressed Workweek', '9');
            echo '<br/>';
            echo '<input type="text" name="user_benefits[10][rank]" id="10" maxlength="2" size="2" value = "7" style="width:3%" />';
            echo form_label('Tuition Reimbursement', '10');  
            echo '<br/>';
            echo '<input type="text" name="user_benefits[11][rank]" id="11" maxlength="2" size="2" value = "6" style="width:3%" />';
            echo form_label('Matching 401K', '11');
            echo '<br/>';
            echo '<input type="text" name="user_benefits[12][rank]" id="12" maxlength="2" size="2" value = "5" style="width:3%" />';
            echo form_label('Profit Sharing', '12');
            echo '<br/>';
            echo '<input type="text" name="user_benefits[13][rank]" id="13" maxlength="2" size="2" value = "4" style="width:3%" />';
            echo form_label('Free Meals', '13');
            echo '<br/>';
            echo '<input type="text" name="user_benefits[14][rank]" id="14" maxlength="2" size="2" value = "3" style="width:3%" />';
            echo form_label('Paid Overtime', '14');
            echo '<br/>';
            echo '<input type="text" name="user_benefits[15][rank]" id="15" maxlength="2" size="2" value = "2" style="width:3%" />';
            echo form_label('Pet Friendly', '15');         
            echo '<br/>';
            echo '<input type="text" name="user_benefits[16][rank]" id="16" maxlength="2" size="2" value = "1" style="width:3%" />';
            echo form_label('Casual Dresscode', '16');             
            echo form_fieldset_close(); 
            echo '<br/>';
            
            //corporate citizenship
            echo form_fieldset('How important is corporate citizenship to you?');
            echo '<input type="radio" name="user_citizenship" value="1" id="not_important"  />';
            echo form_label('Not Important','not_important');
            echo '<br/>';            
            echo '<input type="radio" name="user_citizenship" value="2" id="slightly_important"  />';
            echo form_label('Slightly Important','slightly_important');
            echo '<br/>';
            echo '<input type="radio" name="user_citizenship" value="3" checked="checked" id="important"  />';
            echo form_label('Important','important');
            echo '<br/>';
            echo '<input type="radio" name="user_citizenship" value="4" id="fairly_important"  />';
            echo form_label('Fairly Important','fairly_important');
            echo '<br/>';
            echo '<input type="radio" name="user_citizenship" value="5" id="very_important"  />';
            echo form_label('Very Important','very_important');            
            echo form_fieldset_close();             
 
            /*
      x          $user_type = $this->input->post('user_type');
      x          $user_pace = $this->input->post('user_pace');
      x          $user_lifecycle = $this->input->post('user_lifecycle');
      x          $user_benefits = $this->input->post('user_benefits');
      x         $user_citizenship = $this->input->post('user_citizenship');
                $user_travel = $this->input->post('user_travel');
                $user_responsibilities = $this->input->post('user_responsibilities');
                $user_promotion = $this->input->post('user_promotion');
              $user_environment = $this->input->post('user_environment');
               $user_recognition = $this->input->post('user_recognition');
                $user_tasks = $this->input->post('user_tasks');
                $user_communication = $this->input->post('user_communication');
                $user_resource = $this->input->post('user_resource');
               $user_supervisor = $this->input->post('user_supervisor');
                $user_leadership = $this->input->post('user_leadership');
                $user_traits = $this->input->post('user_traits');
                $user_motivation = $this->input->post('user_motivation');
                $user_education = $this->input->post('user_education');
                $user_work = $this->input->post('user_work');
               $user_location = $this->input->post('user_location');                
                $categories = $this->input->post('category');//NOT SURE OF THIS NAME!!!                
                $history = $this->input->post('history'); //NOT SURE OF THIS NAME!!!  
           
             */
            
            //travel
            echo form_fieldset('Travel');
            echo '<input type="radio" name="user_travel" checked="checked" value="1" id="not_important"  />';
            echo form_label('None','none');
            echo '<br/>';                     
            echo form_fieldset_close();             
   
            //user_responsibilities
            echo form_fieldset('user_responsibilities');
            echo '<input type="radio" name="user_responsibilities" checked="checked" value="1" id="not_important"  />';
            echo form_label('Every 3+ years','3years');
            echo '<br/>';                     
            echo form_fieldset_close();              

            //user_promotion
            echo form_fieldset('Promotion');
            echo '<input type="text" name="user_promotion[1][rank]" id="1" maxlength="2" size="2" value = "2" style="width:3%" />';
            echo form_label('Biz Need', '1');
            echo '<br/>';
            echo '<input type="text" name="user_promotion[2][rank]" id="2" maxlength="2" size="2" value = "1" style="width:3%" />';
            echo form_label('Time At Level', '2');
            echo '<br/>';
            echo '<br/>';   
            echo form_fieldset_close();             
            
            //user_environment
            $user_environment = array('id' => 'user_environment','name' => 'user_environment[]'); 
            echo form_fieldset('user_environment');
            echo form_checkbox($user_environment,'1',TRUE);
            echo form_label('Supportive','slow');
            echo '<br/>';            
            echo form_checkbox($user_environment,'3',TRUE);
            echo form_label('Customer-Focused','medium');
            echo '<br/>';
            echo form_fieldset_close();  
            
          //user_recognition  
            echo form_fieldset('user_recognition');
            echo '<input type="text" name="user_recognition[1][rank]" id="1" maxlength="2" size="2" value = "2" style="width:3%" />';
            echo form_label('Team Dinners', '1');
            echo '<br/>';
            echo '<input type="text" name="user_recognition[2][rank]" id="2" maxlength="2" size="2" value = "1" style="width:3%" />';
            echo form_label('Informal Thank You', '2');
            echo '<br/>';
            echo '<br/>';   
            echo form_fieldset_close();              
     
            
          //user_tasks  
            echo form_fieldset('user_recognition');
            echo '<input type="text" name="user_tasks[1][rank]" id="1" maxlength="2" size="2" value = "2" style="width:3%" />';
            echo form_label('Strategic', '1');
            echo '<br/>';
            echo '<input type="text" name="user_tasks[2][rank]" id="2" maxlength="2" size="2" value = "1" style="width:3%" />';
            echo form_label('Physical', '2');
            echo '<br/>';
            echo '<br/>';   
            echo form_fieldset_close();             
            
            //user_communication
            echo form_fieldset('user_communication');
            echo '<input type="radio" name="user_communication" checked="checked" value="1" id="not_important"  />';
            echo form_label('Time to relate','none');
            echo '<br/>';                     
            echo form_fieldset_close();              
    
          //user_resource  
            echo form_fieldset('user_resource');
            echo '<input type="text" name="user_resource[1][rank]" id="1" maxlength="2" size="2" value = "2" style="width:3%" />';
            echo form_label('Internet', '1');
            echo '<br/>';
            echo '<input type="text" name="user_resource[2][rank]" id="2" maxlength="2" size="2" value = "1" style="width:3%" />';
            echo form_label('Company websites', '2');
            echo '<br/>';
            echo '<br/>';   
            echo form_fieldset_close();             
            
            //user_supervisor
            echo form_fieldset('user_supervisor');
            echo '<input type="radio" name="user_supervisor" checked="checked" value="1" id="not_important"  />';
            echo form_label('Teach me relevant skills','none');
            echo '<br/>';                     
            echo form_fieldset_close();  
            
            //user_leadership
            echo form_fieldset('user_leadership');
            echo '<input type="radio" name="user_leadership" checked="checked" value="1" id="not_important"  />';
            echo form_label('Open dialogue','none');
            echo '<br/>';                     
            echo form_fieldset_close();              
            
            //user_traits
            $user_traits = array('id' => 'user_traits','name' => 'user_traits[]'); 
            echo form_fieldset('user_traits');
            echo form_checkbox($user_traits,'1',TRUE);
            echo form_label('Competent','competent');
            echo '<br/>';            
            echo form_checkbox($user_traits,'2',TRUE);
            echo form_label('Patient','patient');
            echo '<br/>';
            echo form_fieldset_close();             
            
            //user_motivation
            echo form_fieldset('user_motivation');
            echo '<input type="radio" name="user_motivation" checked="checked" value="1" id="not_important"  />';
            echo form_label('with people i like to be around','none');
            echo '<br/>';                     
            echo form_fieldset_close();             
            
            $default_next = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16);
            //user_industry
            echo form_fieldset('DO NEXT: What do you want to do next?');
            echo form_multiselect('user_industry[]', $categories, $default_next);
            echo form_fieldset_close();              
            
            //user_location
            $locations = array(1=>'San Jose',2=>'Oakland', 8=>'Birmingham');
            $locations_choice = array(8);
            echo form_fieldset('Where do you want to work?');
            echo form_multiselect('user_location[]', $locations, $locations_choice);
            echo form_fieldset_close();             
            
    /*
     * 
user_education[0][school_name]
user_education[0][school_id]
user_education[0][degree_name]
user_education[0][degree_id]
user_education[0][field_name]
user_education[0][field_id]
user_education[0][start_month]
user_education[0][start_year]
user_education[0][end_month]
user_education[0][end_month]
     */        
 ?>           
    <ul>
            <li><label>School</label><input class="text_form" type="text" maxlength="150" name="user_education[0][school_name]" value="University of Alabama at Birmingham">
                <input type="hidden" name="user_education[0][school_id]" value="3"></li>								
            <li><label>Degree</label><input class="text_form" type="text" maxlength="150" name="user_education[0][degree_name]" value="Bachelor of Science">
                <input type="hidden" name="user_education[0][degree_id]" value="5"></li>
            <li><label>Field of Study</label><input class="text_form" type="text" maxlength="150" name="user_education[0][field_name]" value="Accounting">
                <input type="hidden" name="user_education[0][field_id]" value="9"></li>
            <li class="history_sets"><label>Time Period</label>
                <select name="user_education[0][start_month]">
                    <option selected="selected" value="01">Jan</option>
                    <option value="02">Feb</option>
                </select>
                    <select name="user_education[0][start_year]" class=" year prefill">
                    <option selected="selected" value="1999">1999</option>
                    <option value="2000">2001</option>                        
                    </select> 
                    <select name="user_education[0][end_month]" class=" month prefill">
                    <option selected="selected" value="03">Mar</option>
                    <option value="04">Apr</option>                        
                    </select> 
                    <select name="user_education[0][end_year]" class=" year prefill">
                    <option selected="selected" value="2001">2001</option>
                    <option value="2002">2002</option>                        
                    </select>
            </li>
    </ul>            
    
    <ul>
            <li><label>School</label><input class="text_form" type="text" maxlength="150" name="user_education[1][school_name]" value="School of Hard Knocks">
                <input type="hidden" name="user_education[1][school_id]" value=""></li>								
            <li><label>Degree</label><input class="text_form" type="text" maxlength="150" name="user_education[1][degree_name]" value="Bachelor of Science">
                <input type="hidden" name="user_education[1][degree_id]" value="5"></li>
            <li><label>Field of Study</label><input class="text_form" type="text" maxlength="150" name="user_education[1][field_name]" value="Chemistry">
                <input type="hidden" name="user_education[1][field_id]" value="154"></li>
            <li class="history_sets"><label>Time Period</label>
                <select name="user_education[1][start_month]">
                    <option selected="selected" value="01">Jan</option>
                    <option value="02">Feb</option>
                </select>
                    <select name="user_education[1][start_year]" class=" year prefill">
                    <option selected="selected" value="1999">1999</option>
                    <option value="2000">2001</option>                        
                    </select> 
                    <select name="user_education[1][end_month]" class=" month prefill">
                    <option selected="selected" value="03">Mar</option>
                    <option value="04">Apr</option>                        
                    </select> 
                    <select name="user_education[1][end_year]" class=" year prefill">
                    <option selected="selected" value="2001">2001</option>
                    <option value="2002">2002</option>                        
                    </select>
            </li>
    </ul>        
 <?php          
            
            
/*            
user_work[0][company_name]
user_work[0][company_id]
user_work[0][job_type]
user_work[0][job_id]
user_work[0][rating]
user_work[0][start_month]
user_work[0][start_year]
user_work[0][end_month]
user_work[0][end_year]
user_work[0][current]                    
 */           
 ?>  

<ul>
        <li><label>Company</label><input class="text_form" type="text" maxlength="150" name="user_work[0][company_name]" value="Apple Inc">
            <input type="hidden" name="user_work[0][company_id]" value="69"></li>
        <li><label>Job</label><input class="text_form" type="text" maxlength="150" name="user_work[0][job_type]" value="Accounting">
            <input type="hidden" name="user_work[0][job_id]" value="1"></li>
        <li><label class="happiness_label">Happiness</label><div class="happiness"></div></li>
        <input type="hidden" value="7" name="user_work[0][rating]">
        <li class="history_sets">
                <label>Time Period</label>
                <select name="user_work[0][start_month]">
                    <option selected="selected" value="01">Jan</option>
                    <option value="02">Feb</option>
                </select>
                    <select name="user_work[0][start_year]" class=" year prefill">
                    <option selected="selected" value="2003">2003</option>
                    <option value="2004">2004</option>                        
                    </select> 
                    <select name="user_work[0][end_month]" class=" month prefill">
                    <option selected="selected" value="03">Mar</option>
                    <option value="04">Apr</option>                        
                    </select> 
                    <select name="user_work[0][end_year]" class=" year prefill">
                    <option selected="selected" value="2005">2005</option>
                    <option value="2006">2006</option>                        
                    </select>                
                <span class="presentText">I currently work here</span><input type="checkbox" name="user_work[0][current]" value="0"/>
        </li>
</ul>  
        
<ul>
        <li><label>Company</label><input class="text_form" type="text" maxlength="150" name="user_work[1][company_name]" value="Banana Factory">
            <input type="hidden" name="user_work[1][company_id]" value=""></li>
        <li><label>Job</label><input class="text_form" type="text" maxlength="150" name="user_work[1][job_type]" value="Accounting">
            <input type="hidden" name="user_work[1][job_id]" value="1"></li>
        <li><label class="happiness_label">Happiness</label><div class="happiness"></div></li>
        <input type="hidden" value="4" name="user_work[1][rating]">
        <li class="history_sets">
                <label>Time Period</label>
                <select name="user_work[1][start_month]">
                    <option selected="selected" value="01">Jan</option>
                    <option value="02">Feb</option>
                </select>
                    <select name="user_work[1][start_year]" class=" year prefill">
                    <option selected="selected" value="2003">2003</option>
                    <option value="2004">2004</option>                        
                    </select> 
                    <select name="user_work[1][end_month]" class=" month prefill">
                    <option selected="selected" value="03">Mar</option>
                    <option value="04">Apr</option>                        
                    </select> 
                    <select name="user_work[1][end_year]" class=" year prefill">
                    <option selected="selected" value="2005">2005</option>
                    <option value="2006">2006</option>                        
                    </select>                
                <span class="presentText">I currently work here</span><input type="checkbox" checked="checked" name="user_work[1][current]" value="1"/>
        </li>
</ul>          
 <?php   
            
            echo '<br/>';
            echo form_submit('mysubmit', 'Submit');
            echo form_close();
            
           
           ?>
            
        </p>
            </div><!--end div "type"-->
            <div id="benefits">

                
            </div>

	</div>
    </div>
</div>

</body>
</html>