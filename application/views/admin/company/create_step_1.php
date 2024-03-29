<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>New Company Entry</title>
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/reset-fonts-grids.css" type="text/css"/>
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/base.css" type="text/css"/>        
     
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
        
        <style>
            .clearfloat {
                font-size: 1px;
                line-height: 0px;
                margin: 0px;
                clear: both;
                height: 0px;
            }       
            fieldset legend {
                font-size: 110%;
                font-weight: bold;
                color: blue;
            }
            .errors {
                color: red;                 
            }
            #leftside {
                /*float: left;*/
            }
            #rightside {
                /*float: left;*/
            }
            select {
                height: 260px;
            }         

            


            #results {
                margin-left:150px;
                margin-top:1px;
                width:400px;
                z-index:99;
                position:relative;
            }

            #inputbox{
                position:relative;
                z-index:99;
            }
            .overlay{
                position:relative; 
                background-image: url('/assets/images/x-icon.png');
                background-size: 20px;
                background-repeat:no-repeat;
                background-position: 0px 0px;
                left:0px; top:0px; 
                width:300px; 
                height:100%; 
                z-index:98;
            }  
            
</style>
        
<script type="text/javascript">
$(document).ready(function()
{
  $("#company_name").keyup(function()
  {
    var kw = $("#company_name").val();
    //alert(kw);
    if(kw != '')
     {
      $.ajax
      ({
         type: "POST",
         url: "company_name_search",
         data: "kw="+ kw,
         success: function(option)
         {
           $("#results").html(option);
         }
      });
     }
     else
     {
       $("#results").html("");
     }
    return false;
  });
  
//to hide and show the results...
   $(".overlay").click(function()
   {
     $(".overlay").css('display','none');
     $("#results").css('display','none');
   });
   $("#company_name").focus(function()
   {
     $(".overlay").css('display','block');
     $("#results").css('display','block');
   });  
});
 
</script>        
        
        
</head>
<body>

<div id="container">
  
    <div id="doc2">
    <div id="hd"><!-- header -->
	<h1>Emplayo - New Company Entry (Step 1 of 3)</h1>

    </div>
        <a href = "/admin/company/listing">Back to Listing</a>

	<div id="bd"><!-- body -->
            <div id="type">
        <p>
           <?php 
           if ($this->session->flashdata('upload_error') != ''){
               $upload_error = $this->session->flashdata('upload_error');
           }
           if (isset($message)) {echo $message;}
           
           echo "<div class='errors'>";
           if (isset($errors)) 
               {
                   foreach ($errors as $value) {
                       echo $value.'<br>';
                   }
               }
           echo '</div>';
           
           if (isset($upload_data)){
               foreach ($upload_data as $item => $value)
               {
                   echo $item.':'.$value.'<br>'; 
               }
               echo "<br>this is the file name:".$upload_data['file_name'];
           }
     
           echo form_open('admin/company/create_step_1');

            echo '<br/>';    
            
            //COMPANY NAME        
            echo form_fieldset('Company Name');  
       
            echo "<div class='errors'>";
            echo form_error('company_name');
            echo "</div>";
            
            $name_data = array(
              'name'        => 'company_name',
              'id'          => 'company_name',
              'value'       => set_value('company_name'),
              'maxlength'   => '100',
              'size'        => '20',
              'style'       => 'width: 250px',
            );

            echo '<div id="inputbox">';
            echo form_input($name_data);
            echo '</div>';
            echo '<div class="overlay">';
            echo '<div id="results"></div>';
            echo '</div>';
            echo form_fieldset_close();
            
            
            //COMPANY URL        
            echo form_fieldset('Company URL');  
       
            echo "<div class='errors'>";
            echo form_error('company_url');
            echo "</div>";
            
            $url_data = array(
              'name'        => 'company_url',
              'id'          => 'company_url',
              'value'       => set_value('company_url'),
              'maxlength'   => '100',
              'size'        => '20',
              'style'       => 'width: 250px',
            );

            echo form_input($url_data);
            echo form_fieldset_close();            

            //JOBS URL        
            echo form_fieldset('Jobs URL');  
       
            echo "<div class='errors'>";
            echo form_error('jobs_url');
            echo "</div>";
            
            $jobs_data = array(
              'name'        => 'jobs_url',
              'id'          => 'jobs_url',
              'value'       => set_value('jobs_url'),
              'maxlength'   => '100',
              'size'        => '20',
              'style'       => 'width: 250px',
            );

            echo form_input($jobs_data);
            echo form_fieldset_close();             

            //FACEBOOK URL        
            echo form_fieldset('Facebook URL');  
       
            echo "<div class='errors'>";
            echo form_error('facebook_url');
            echo "</div>";
            
            $facebook_data = array(
              'name'        => 'facebook_url',
              'id'          => 'facebook_url',
              'value'       => set_value('facebook_url'),
              'maxlength'   => '100',
              'size'        => '20',
              'style'       => 'width: 250px',
            );

            echo form_input($facebook_data);
            echo form_fieldset_close();             

            //TWITTER URL      
            echo form_fieldset('Twitter URL');  
       
            echo "<div class='errors'>";
            echo form_error('twitter_url');
            echo "</div>";
            
            $twitter_data = array(
              'name'        => 'twitter_url',
              'id'          => 'twitter_url',
              'value'       => set_value('twitter_url'),
              'maxlength'   => '100',
              'size'        => '20',
              'style'       => 'width: 250px',
            );

            echo form_input($twitter_data);
            echo form_fieldset_close();             
            
            //COMPANY TYPE        
            echo form_fieldset('Company Type');
            echo "<div class='errors'>";
            echo form_error('company_type');
            echo "</div>";
            
            foreach ($type_array as $row) 
            {
                ?>
                <input type="radio" name="company_type" value="<?php echo $row['id'];?>" 
                       id="company_type" <?php echo set_radio('company_type', ''.$row['id'].''); ?>/>
                <?php                echo form_label($row['type'],'company_type');
                echo '<br/>';
            }
            echo form_fieldset_close();               

            
            //COMPANY PACE
            echo form_fieldset('Company Pace');
            echo "<div class='errors'>";
            echo form_error('company_pace');
            
            echo "</div>";
            
            foreach ($pace_array as $row) 
            {
                ?>
                <input type="radio" name="company_pace" value="<?php echo $row['id'];?>" 
                       id="company_pace" <?php echo set_radio('company_pace', ''.$row['id'].''); ?>/>
                <?php               
                echo form_label($row['pace'],'company_pace');
                echo '<br/>';
            }
            echo form_fieldset_close();                       
 
            //COMPANY LIFECYCLE
            echo form_fieldset('Company Lifecycle');
            echo "<div class='errors'>";
            echo form_error('company_lifecycle');
            echo "</div>";
            
            foreach ($lifecycle_array as $row) 
            {
                ?>
                <input type="radio" name="company_lifecycle" value="<?php echo $row['id'];?>" 
                       id="company_lifecycle" <?php echo set_radio('company_lifecycle', ''.$row['id'].''); ?>/>
                <?php                
                echo form_label($row['lifecycle'],'company_lifecycle');
                echo '<br/>';
            }
            echo form_fieldset_close();  

            //CORPORATE CITIZENSHIP
            echo form_fieldset('Corporate citizenship');
            echo "<div class='errors'>";
            echo form_error('corp_citizenship');
            echo "</div>";
            
            foreach ($corp_citizenship_array as $row) 
            {
                ?>
                <input type="radio" name="corp_citizenship" value="<?php echo $row['id'];?>" 
                       id="corp_citizenship" <?php echo set_radio('corp_citizenship', ''.$row['id'].''); ?>/>
                <?php                   
                echo form_label($row['corp_citizenship'],'corp_citizenship');
                echo '<br/>';
            }            
            echo form_fieldset_close();               

            //BENEFITS
            $benefits = array('id' => 'benefits','name' => 'benefits[]');
            echo form_fieldset('Company Benefits'); 
            echo "<div class='errors'>";
            echo form_error('benefits');
            echo "</div>";
            
            foreach ($benefits_array as $row) 
            {
                echo form_checkbox($benefits, $row['id'],set_checkbox('benefits', $row['id']));
                echo form_label($row['benefits'],$row['id']);                
                echo '<br/>';
            }            
            echo form_fieldset_close();             

            echo '<br class="clearfloat" />';
            
            //Category Info
            echo form_fieldset('Categories');
            echo "<div class='errors'>";
            echo form_error('category[]');
            echo "</div>";

            $postcat = $this->input->post('category');//to re-populate the form
            echo form_multiselect('category[]', $category_array, $postcat);
            echo form_fieldset_close();  
            
            
            
            echo '<br/>';
            echo form_submit('mysubmit', 'Next');
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