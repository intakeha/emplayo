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
            
           echo form_open('survey/submit');

            echo '<br/>';         
            
            //company type
            $company_type = array('id' => 'company_type','name' => 'company_type[]'); 
            echo form_fieldset('What kind of company do you want to work for?');
            echo form_checkbox($company_type,'1',FALSE);
            echo form_label('For Profit - Publicly Traded','profit_public');
            echo '<br/>';            
            echo form_checkbox($company_type,'2',FALSE);
            echo form_label('For Profit - Privately Held','profit_private');
            echo '<br/>';
            echo form_checkbox($company_type,'3',FALSE);
            echo form_label('Non-Profit','nonprofit');
            echo '<br/>';
            echo form_checkbox($company_type,'4',FALSE);
            echo form_label('Government/Public','public');
            echo form_fieldset_close(); 
            
            //company pace
            $company_pace = array('id' => 'company_pace','name' => 'company_pace[]'); 
            echo form_fieldset('What company pace would you prefer?');
            echo form_checkbox($company_pace,'1',FALSE);
            echo form_label('Slow','slow');
            echo '<br/>';            
            echo form_checkbox($company_pace,'2',FALSE);
            echo form_label('Medium','medium');
            echo '<br/>';
            echo form_checkbox($company_pace,'3',FALSE);
            echo form_label('Fast','fast');
            echo '<br/>';
            echo form_fieldset_close(); 

            //lifecycle
            $lifecycle = array('id' => 'lifecycle','name' => 'lifecycle[]'); 
            echo form_fieldset('What company lifecycle would you prefer?');
            echo form_checkbox($lifecycle,'1',FALSE);
            echo form_label('Startup','startup');
            echo '<br/>';            
            echo form_checkbox($lifecycle,'2',FALSE);
            echo form_label('Rapid Growth','rapid_growth');
            echo '<br/>';
            echo form_checkbox($lifecycle,'3',FALSE);
            echo form_label('Maturity','maturity');
            echo '<br/>';
            echo form_checkbox($lifecycle,'4',FALSE);
            echo form_label('Rebirth','rebirth');
            echo '<br/>';            
            echo form_fieldset_close();             
            
            //benefits and perks
            echo form_fieldset('Rank the following company benefits in order of importance to you:');
            echo '<input type="text" name="users_benefits[1][rank]" id="1" maxlength="2" size="2" style="width:3%" />';
            echo form_label('Health Care', '1');
            echo '<br/>';
            echo '<input type="text" name="users_benefits[2][rank]" id="2" maxlength="2" size="2" style="width:3%" />';
            echo form_label('Child Care', '2');
            echo '<br/>';
            echo '<input type="text" name="users_benefits[3][rank]" id="3" maxlength="2" size="2" style="width:3%" />';
            echo form_label('Family Leave', '3');
            echo '<br/>';
            echo '<input type="text" name="users_benefits[4][rank]" id="4" maxlength="2" size="2" style="width:3%" />';
            echo form_label('Fitness Facilities', '4');
            echo '<br/>';
            echo '<input type="text" name="users_benefits[5][rank]" id="5" maxlength="2" size="2" style="width:3%" />';
            echo form_label('Dependendent Care Support', '5');
            echo '<br/>';
            echo '<input type="text" name="users_benefits[6][rank]" id="6" maxlength="2" size="2" style="width:3%" />';
            echo form_label('Telecommuting', '6');
            echo '<br/>';
            echo '<input type="text" name="users_benefits[7][rank]" id="7" maxlength="2" size="2" style="width:3%" />';
            echo form_label('Paid Time Off', '7');
            echo '<br/>';
            echo '<input type="text" name="users_benefits[8][rank]" id="8" maxlength="2" size="2" style="width:3%" />';
            echo form_label('Paid Sabbatical', '8');
            echo '<br/>';
            echo '<input type="text" name="users_benefits[9][rank]" id="9" maxlength="2" size="2" style="width:3%" />';
            echo form_label('Compressed Workweek', '9');
            echo '<br/>';
            echo '<input type="text" name="users_benefits[10][rank]" id="10" maxlength="2" size="2" style="width:3%" />';
            echo form_label('Tuition Reimbursement', '10');  
            echo '<br/>';
            echo '<input type="text" name="users_benefits[11][rank]" id="11" maxlength="2" size="2" style="width:3%" />';
            echo form_label('Matching 401K', '11');
            echo '<br/>';
            echo '<input type="text" name="users_benefits[12][rank]" id="12" maxlength="2" size="2" style="width:3%" />';
            echo form_label('Profit Sharing', '12');
            echo '<br/>';
            echo '<input type="text" name="users_benefits[13][rank]" id="13" maxlength="2" size="2" style="width:3%" />';
            echo form_label('Free Meals', '13');
            echo '<br/>';
            echo '<input type="text" name="users_benefits[14][rank]" id="14" maxlength="2" size="2" style="width:3%" />';
            echo form_label('Paid Overtime', '14');
            echo '<br/>';
            echo '<input type="text" name="users_benefits[15][rank]" id="15" maxlength="2" size="2" style="width:3%" />';
            echo form_label('Pet Friendly', '15');         
            echo '<br/>';
            echo '<input type="text" name="users_benefits[16][rank]" id="16" maxlength="2" size="2" style="width:3%" />';
            echo form_label('Casual Dresscode', '16');             
            echo form_fieldset_close(); 
            echo '<br/>';
            
            //corporate citizenship
            echo form_fieldset('How important is corporate citizenship to you?');
            echo '<input type="radio" name="corp_citizenship" value="1" id="not_important"  />';
            echo form_label('Not Important','not_important');
            echo '<br/>';            
            echo '<input type="radio" name="corp_citizenship" value="2" id="slightly_important"  />';
            echo form_label('Slightly Important','slightly_important');
            echo '<br/>';
            echo '<input type="radio" name="corp_citizenship" value="3" id="important"  />';
            echo form_label('Important','important');
            echo '<br/>';
            echo '<input type="radio" name="corp_citizenship" value="4" id="fairly_important"  />';
            echo form_label('Fairly Important','fairly_important');
            echo '<br/>';
            echo '<input type="radio" name="corp_citizenship" value="5" id="very_important"  />';
            echo form_label('Very Important','very_important');            
            echo form_fieldset_close();             
            /*
            echo form_fieldset('Which type of work environment allows you to do your best work?');
            
            echo '<div class="env_subbox">';
            echo '<div class="env_1">';
            echo '<input type="radio" name="q9_1" value="q9_1a" id="q9_1a"  />';
            echo form_label('Supportive','supportive');
            echo '</div>';
            echo '<div class="env_2">';
            echo '<input type="radio" name="q9_1" value="q9_1b" id="q9_1b"  />';
            echo form_label('Independent','independent');
            echo '</div>';   
            echo '</div>';//end of env_subbox div 
            
            echo '<br class="clearfloat" />';
            
            echo '<div class="env_subbox">';
            echo '<div class="env_1">';
            echo '<input type="radio" name="q9_2" value="q9_2a" id="q9_2a"  />';
            echo form_label('Customer-Focused','customer-focused');
            echo '</div>';
            echo '<div class="env_2">';
            echo '<input type="radio" name="q9_2" value="q9_2b" id="q9_2b"  />';
            echo form_label('Product-Focused','product-focused');
            echo '</div>';   
            echo '</div>';//end of env_subbox div             
            
            */
            echo form_fieldset_close();
            
            
            
            echo '<br class="clearfloat" />';
            
            //History
            echo form_fieldset('HISTORY: In what industry have you worked before?');
            echo form_multiselect('history[]', $categories, '');
            echo form_fieldset_close();
            
            //Do Next
            echo form_fieldset('DO NEXT: What do you want to do next?');
            echo form_multiselect('category[]', $categories, '');
            echo form_fieldset_close();  

            
            
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