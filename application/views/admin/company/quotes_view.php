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

});//end of document ready
</script>

</head>
<body>

<div id="container">
    <div id="header">
        <div id="hd"><h1>Emplayo - View Quotes for <a href="/admin/company/view/<?php echo $company_id;?>"><?php echo $company_info['company_name'];?></a></h1></div>   
        <?php
        echo "<a href = '/admin/company/enter_quotes/{$company_id}'>Enter New Quotes...</a>";
        echo "<div>".$this->session->flashdata('message')."<div>";
        echo "<br>";
        echo form_error('quote');
        echo "<br>";
        
        ?>
        <a href = "/admin/company/listing">Back to Listing</a>
    </div>
</div>
       
<form accept-charset="utf-8" action="/admin/company/quotes_view/<?php echo $company_id;?>" method="POST">
    
<?php
    if (!empty($quotes))
    {
        foreach ($quotes as $row)
        {                         
            echo "<div>{$row['quote']}";
            echo "<input id='quotes_to_delete' type='checkbox' value='{$row['id']}' name='quotes_to_delete[]' >";
            echo "</div>";
        }
    }



?>
    

    <input type="submit" name="mysubmit" value="Submit" />
</form>      


</body>
</html>    