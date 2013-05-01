<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>View Company </title>
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
               /* float: none;*/
            }
            #rightside {
              /*  float: none;*/
            }
            select {
                height: 260px;
            }  
            .logo img{
                border: thin solid #999;
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
      
        
        
</head>
<body>

<div id="container">
  
    <div id="doc2">
    <div id="hd"><!-- header -->
	<h1>Emplayo - View Company</h1>

    </div>
        <a href = "/admin/company/listing">Back to Listing</a> &nbsp
        
        <a href = "/admin/company/update_step_1/<?php echo $company_id;?>">Edit This Company</a>
        
        <a href = "/company/temp/<?php echo $company_id;?>">Preview Company Page</a>
        
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


            echo '<br/>';    
            //COMPANY NAME        
            echo form_fieldset('Company Name');  

            if (isset($company_info['company_name'])){
                $default_name = $company_info['company_name'];
            } else {$default_name = '';}
            echo $default_name;
            echo form_fieldset_close();
  
            //COMPANY LOGO        
            echo form_fieldset('Company Logo'); 
            $image_path = base_url().COMPANY_LOGO_PATH.$company_info['company_logo'];
            echo "<div class=\"logo\"><img src=\"$image_path\"></div>";
            echo $company_info['company_logo'];
            echo form_fieldset_close();
            
            //CREATIVE LOGO        
            echo form_fieldset('Creative Logo');   
            $image_path2 = base_url().COMPANY_LOGO_PATH.$company_info['creative_logo'];
            echo "<div class=\"logo\"><img src=\"$image_path2\"></div>";
            echo $company_info['creative_logo'];
            echo form_fieldset_close();            
            
            //COMPANY URL        
            echo form_fieldset('Company URL');  

            if (isset($company_info['company_url'])){
                $default_url = $company_info['company_url'];
            } else {$default_url = '';}   
            
            echo "<a href=\"$default_url\" target=\"_blank\">$default_url</a>";
            echo form_fieldset_close();            

            //JOBS URL        
            echo form_fieldset('Jobs URL');  

            if (isset($company_info['jobs_url'])){
                $jobs_url = $company_info['jobs_url'];
            } else {$jobs_url = '';}              
            
            echo "<a href='{$jobs_url}' target='_blank'>$jobs_url</a>";
            echo form_fieldset_close();             

            //FACEBOOK URL        
            echo form_fieldset('Facebook URL');  
       
            if (isset($company_info['facebook_url'])){
                $facebook_url = $company_info['facebook_url'];
            } else {$facebook_url = '';}             

            echo "<a href='{$facebook_url}' target='_blank'>$facebook_url</a>";            
            echo form_fieldset_close();             

            //TWITTER URL      
            echo form_fieldset('Twitter URL');  

            if (isset($company_info['twitter_url'])){
                $twitter_url = $company_info['twitter_url'];
            } else {$twitter_url = '';}              
            
            echo "<a href='{$twitter_url}' target='_blank'>$twitter_url</a>"; 
            echo form_fieldset_close();              
            
            //COMPANY TYPE        
            echo form_fieldset('Company Type');

            foreach ($type_array as $row) 
            {         
                if (isset($company_info['type_id'])){
                    if ($company_info['type_id'] == $row['id'])
                    {
                        echo $row['type'];
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
                       echo $row['pace']; 
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
                       echo $row['lifecycle']; 
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
                       echo $row['corp_citizenship']; 
                    }
                }
            }            
            echo form_fieldset_close();               

            //BENEFITS
            $benefits = array('id' => 'benefits','name' => 'benefits[]');
            echo form_fieldset('Company Benefits'); 
           
            echo "<ul>";
            foreach ($benefits_array as $row) 
            {
                if (isset($benefits_info) && in_array($row['id'],$benefits_info))
                {
                    echo "<li>";
                    echo $row['benefits'];
                    echo "</li>";
                }
            }   
            echo "</ul>";
            echo form_fieldset_close();             
            
            //Category Info
            echo form_fieldset('Categories');
            echo "<ul>";
            
            
            foreach ($category_array as $key=>$value) 
            {
                if (isset($categories_info) && in_array($key,$categories_info))
                {
                    echo "<li>";
                    echo $value;
                    echo "</li>";
                }
            }   
            echo "</ul>";
            echo form_fieldset_close();             
           ?>
            
        </p>
            </div><!--end div "type"-->

	</div>
    </div>
</div>

</body>
</html>