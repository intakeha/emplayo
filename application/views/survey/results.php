<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to Emplayo!</title>
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/reset-fonts-grids.css" type="text/css"/>
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/base.css" type="text/css"/>   
        <style>
            .table  {
                    float: left;
                    margin: 10px;
            }
            .company  {
                    float: left;
                    margin: 10px;
            }    
            .clearfloat {
                    font-size: 1px;
                    line-height: 0px;
                    margin: 0px;
                    clear: both;
                    height: 0px;
            }            
            
        </style>
</head>
<body>

<div class="content">
  
    <div id="hd"><!-- header -->
	<h1>Preview</h1>

    </div>

	<div id="bd"><!-- body -->
        <p>
            <?php echo $result_msg;?>
            <?php //print_r($matches);?>
            <?php //print_r($company_info);
            
            function table_print($title,$this_array) 
            {               
                $keys = array_keys($this_array[0]);
                echo "<div class = 'table'>";
                echo "<h3>$title</h3>";
                echo "<table><tr><th>".implode("</th><th>", $keys)."</th></tr>";
                foreach ($this_array as $row) {
                  if (!is_array($row))
                    continue;
                  echo "<tr><td>".implode("</td><td>", $row )."</td></tr>";
                }
                echo "</table>";
                echo "</div>";
            }            
            
            //$this->session->all_userdata();
            
            
            if (!empty($full_company_info))
            {
                echo "<br>";
                echo "Here are the companies that meet your criteria, in order of best match:<br>";
                
                foreach ($full_company_info as $row)
                {
                    echo "<div class = 'company'>";
                    echo '<br>';
                    echo '<a href="'.$row['company_url'].'">'.$row['company_name'].'</a>';
                    echo '<br>';
                    echo "id: ".$row['id'];
                    echo '<br>';
                    echo '<img src="'.$row['company_logo'].'" height="50" />';
                    echo '<br>';
                    echo "fit score: ".$row['fit_score'];
                    echo '<br>';
                    echo "</div>";
                }
                
                echo '<br class="clearfloat" />';
                /*
                echo "Citizenship Weight: .4<br> ";
                echo "Benefits Weight: .4<br> ";
                echo "History Weight: .2<br> ";
                */
                
                /*
                echo '<pre>raw data:<br>',print_r($raw_data,1),'</pre>';
                echo '<pre>coordinate data:<br>',print_r($coord_data,1),'</pre>';
                echo '<pre>distance data:<br>',print_r($dist_data,1),'</pre>';
                echo '<pre>normalized disparate data:<br>',print_r($norm_disp_data,1),'</pre>';
                echo '<pre>aggregate data:<br>',print_r($aggregate_data,1),'</pre>';
                echo '<pre>company fit:<br>',print_r($company_fit,1),'</pre>';
                */
                $raw_data = unserialize(file_get_contents('temp_arrays/raw_array.txt'));
                table_print('Raw Data', $raw_data);
                $coord_data = unserialize(file_get_contents('temp_arrays/coord_array.txt')); 
                table_print('Coordinate Data', $coord_data);
                $dist_data = unserialize(file_get_contents('temp_arrays/dist_array.txt'));
                table_print('Distance Data', $dist_data);
                $norm_disp_data = unserialize(file_get_contents('temp_arrays/norm_disp_array.txt'));
                table_print('Normalized Data', $norm_disp_data);
                $aggregate_data = unserialize(file_get_contents('temp_arrays/aggregate_array.txt'));
                table_print('Aggregate Data', $aggregate_data);
                $company_fit = unserialize(file_get_contents('temp_arrays/fit_array.txt'));
                table_print('Company Fit Data', $company_fit);
                
                //this action will simulate what happens once they sign up
                echo form_open('survey/insert_matches');
                echo form_submit('mysubmit', 'Save My Data');
                echo form_close();                
                
                echo '<br>';
                echo "<a href='/signup'>Signup to see the full list!</a>";
                
                
            }

            ?>

        </p>

	</div>

</div>

</body>
</html>