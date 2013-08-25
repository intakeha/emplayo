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
            <?php //echo $result_msg;?>
            <?php //print_r($matches);?>
            <?php //print_r($company_info);
            if (!empty($category_tags))
            {
                echo "<br>";
                echo "Here are the category tags";
                print_r($category_tags);
                /*
                foreach ($category_tags as $row)
                {
                    echo '<br>';
                    echo '<a href="'.$row['company_url'].'">'.$row['company_name'].'</a>';
                    echo '<img src="'.$row['company_logo'].'" height="50" />';
                    echo '<br>';
                }
                */
            }

            ?>

        </p>

	</div>
    </div>
</div>

</body>
</html>