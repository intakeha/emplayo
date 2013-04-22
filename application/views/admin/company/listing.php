<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Company Listing</title>
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/reset-fonts-grids.css" type="text/css"/>
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/base.css" type="text/css"/>     
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/crud.css" type="text/css"/>  
     
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


</style>
        
        
</head>
<body>

<div id="container">
    <div id="hd">
	<h1>Emplayo - Company Listing</h1>
    </div>    

<?php   
    echo '<div class ="message">';
    echo $this->session->flashdata('message');
    echo '</div>';
    
    echo '<a href = "/admin/company/create_step_1">Add New...</a>';
     
    echo '<br><br>A total of '.$num_rows.' companies were returned.';
    echo '<div id="table">';
    echo $table;
    echo '</div>';
    echo '<div id="pagination">';    
    echo $pagination;
    echo '</div>';
?>  
</div>

</body>
</html>    