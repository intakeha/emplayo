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
        <div id="hd"><h1>Emplayo - Profile Pics for <a href="/admin/company/view/<?php echo $company_id;?>"><?php echo $company_info['company_name'];?></a></h1></div>   
        <?php
        echo "<a href = '/admin/company/profile_edit/{$company_id}'>Add New Profile Pics...</a>";
        echo "<div>".$this->session->flashdata('message')."</div>";
        echo "<br>";
        echo form_error('pics_to_delete');
        echo "<br>";
        
        ?>
        <a href = "/admin/company/listing">Back to Listing</a>
    </div>
</div>
       
<form accept-charset="utf-8" action="/admin/company/profile_view/<?php echo $company_id;?>" method="POST">
    
<?php
    if (!empty($profile_pics))
    {
        $image_path = "/assets/images/company_tiles/";
        foreach ($profile_pics as $row)
        {                         
            echo "<div><img src='{$image_path}{$row['file_name']}' height='100px'/>";
            echo "<input id='pics_to_delete' type='checkbox' value='{$row['file_name']}' name='pics_to_delete[]' >";
            echo "</div>";
        }
    }



?>
    

    <input type="submit" name="mysubmit" value="Submit" />
</form>      


</body>
</html>    