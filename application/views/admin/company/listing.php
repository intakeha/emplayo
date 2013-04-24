<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Company Listing</title>
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/reset-fonts-grids.css" type="text/css"/>
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/base.css" type="text/css"/>     
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/crud.css" type="text/css"/>  
     
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/hogan-2.0.0.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-ui.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/typeahead.js"></script>
        
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
            
    .hyperlink-style-button{
      background:none;
      border:0;
      color:#666;
      text-decoration:underline;
    }

    .hyperlink-style-button:hover{
      background:none;
      border:0;
      color:#666;
      text-decoration:none;
      cursor:pointer;
      cursor:hand;
    }            


</style>
  
<script>
$(document).ready(function(){
    $('.company_search').typeahead({
            name: 'company_search',
            limit: 5,
            remote: '/inquire/company_search/%QUERY',
            template: '<p><strong>{{value}}</strong></p>',
            engine: Hogan
    }).on('typeahead:selected typeahead:autocompleted', function($e, datum){
            $("#listing_search input[name='search_id']").val(datum.id);
            //alert(datum.id);
    });    
});//end of document ready    
    
</script>

        
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
     
?>
    <br><br>
    <form action="/admin/company/listing" method="post">
        <input type="hidden" name="filter" value="1"/>
        <input type="submit" name="completed_link" value="Show Not Started" class="hyperlink-style-button"/>
    </form>    

    <form action="/admin/company/listing" method="post">
        <input type="hidden" name="filter" value="2"/>
        <input type="submit" name="completed_link" value="Show Completed" class="hyperlink-style-button"/>
    </form>   
    
    <form action="/admin/company/listing" method="post">
        <input type="hidden" name="filter" value="3"/>
        <input type="submit" name="completed_link" value="Show All" class="hyperlink-style-button"/>
    </form>     
 
    <form action="/admin/company/listing" method="post">
        <div id="listing_search">			
                <input class="company_search" name="company_search" type="text" value=""/>
                <input type="hidden" name="search_id" value=""/>
                <input type="submit" name="search" value="Submit" />
        </div>	    
    </form>
    
<?php
    
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