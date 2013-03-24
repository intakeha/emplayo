<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Image Upload</title>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/reset-fonts-grids.css" type="text/css"/>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/base.css" type="text/css"/>        
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/imgareaselect-default.css" type="text/css"/>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/crop.css" type="text/css"/>
<style>
</style>
<script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>


<script>
$(document).ready(function(){
    
    $('#quote').bind('keyup', function(e){
        var len = $(this).val().length;
        $('#charNum').text(200 - len);
    });    

});//end of document ready
</script>

</head>
<body>

<div id="container">
    <div id="header">
        <div id="hd"><h1>Emplayo - Enter Quotes, Slogans, etc. for <a href="/admin/company/view/<?php echo $company_id;?>"><?php echo $company_info['company_name'];?></a></h1></div>   
        <?php
        echo $this->session->flashdata('message');
        echo "<br>";
        echo form_error('quote');
        echo "<br>";
        
        ?>
        <div><a href = "/admin/company/listing">Back to Listing</a></div>
        <div><a href = "/admin/company/quotes_view/<?php echo $company_id;?>">Back to Quotes View</a></div>
    </div>
</div>
       
<form accept-charset="utf-8" action="/admin/company/enter_quotes/<?php echo $company_id;?>" method="POST">

    <textarea id="quote" name="quote" rows="5" cols="50" wrap="hard"></textarea>
    <div id="charNum"></div>
    <input type="submit" name="mysubmit" value="Submit" />
</form>      


</body>
</html>    