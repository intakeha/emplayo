<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to Emplayo!</title>
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/reset-fonts-grids.css" type="text/css"/>
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/base.css" type="text/css"/>        
</head>
<body>

<div id="container">
    <div id="doc2">
    <div id="hd"><!-- header -->
	<h1>Results</h1>

    </div>

	<div id="bd"><!-- body -->
        <p>
            <?php echo $result_msg;?>
            <?php //print_r($matches);?>
            <?php //print_r($company_info);
            if (!empty($company_info))
            {
                echo "<br>";
                echo "Here are the companies that meet your criteria, in order of best match:<br>";
                foreach ($company_info as $row)
                {
                    echo '<br>';
                    echo '<a href="'.$row['company_url'].'">'.$row['company_name'].'</a>';
                    echo '<img src="'.$row['company_logo'].'" height="50" />';
                    echo '<br>';
                }
            }

            ?>

        </p>

	</div>
    </div>
</div>

</body>
</html>