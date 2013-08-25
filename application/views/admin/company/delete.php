<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Company Delete</title>
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

</style>
        
        
</head>
<body>

<div id="container">
    <div class="">Are you sure you want to delete <b><?php echo $company_info['company_name'];?></b>?  This cannot be undone!</div><br>
<?php   
$submit_url = 'admin/company/delete/'.$company_id;
    echo form_open($submit_url);

    echo form_fieldset('');
    echo form_radio('delete', '0', TRUE);
    echo form_label('No way! Get me out of here!!','delete');
    echo "<br>";
    echo form_radio('delete', '1', FALSE);
    echo form_label('Delete','delete');
    echo form_fieldset_close();
    echo '<br/>';
    echo form_submit('mysubmit', 'Submit');
    echo form_close();
?>  
</div>

</body>
</html>    