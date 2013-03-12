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
select {height: 260px;}

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
            
           echo form_open('survey/submit2');

            echo '<br/>';         
            

            
            //History
            
            
            //Do Next

            
            echo form_fieldset('HISTORY: In what industry have you worked before?');
            echo form_multiselect('history[]', $categories, '');
            echo form_fieldset_close();

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