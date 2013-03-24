<div id="company">
	<div class="content">
		<ul id="filters">
			<li><a href="#" data-filter=".highlights, .pictures">company</a></li>
			<li><a href="#" data-filter=".highlights">highlights</a></li>
			<li><a href="#" data-filter=".pictures">pictures</a></li>
		</ul>
            <?php
            /*
            echo '<pre>';
            print_r($pic_array);
            echo '</pre>';
            */
            ?>
            <div id="tiles">
                <div class="smallTile highlights pictures"><div class="smallContent"><img src="/assets/images/tiles/square_190x190.1.png"/></div></div>
                    <?php
                    if (!empty($pic_array) && !empty($company_info))
                    {
                        //echo "name: ".$company_info['company_name'];
                        $image_path = "/assets/images/company_tiles/";
                        foreach ($pic_array as $row)
                        {
                            switch ($row['pic_shape']) {
                                case 1://small
                                    echo "<div class='smallTile pictures'><div class='smallContent'>";
                                    break;
                                case 2://horizontal
                                    echo "<div class='horizontalTile pictures'><div class='horizontalContent'>";
                                    break;
                                case 3://vertical
                                    echo "<div class='verticalTile pictures'><div class='verticalContent'>";
                                    break;
                                case 4://large
                                    echo "<div class='bigTile pictures'><div class='bigContent'>";
                                    break;                                
                            }                            
                            echo "<img src='{$image_path}{$row['file_name']}'/>";
                            echo "</div></div>";
                        }
                    }

                    if (!empty($quote_array) && !empty($company_info))
                    {
                        foreach ($quote_array as $row)
                        {
                            switch ($row['tile_shape']) {
                                case 1://small
                                    echo "<div class='smallTile highlights'><div class='smallContent'><div class='message'>";
                                    break;
                                case 2://horizontal
                                    echo "<div class='horizontalTile highlights'><div class='horizontalContent'><div class='message'>";
                                    break;
                                case 3://vertical
                                    echo "<div class='verticalTile highlights'><div class='verticalContent'><div class='message'>";
                                    break;
                                case 4://large
                                    echo "<div class='bigTile highlights'><div class='bigContent'><div class='message'>";
                                    break;                                
                            }                            
                            echo "{$row['quote']}";
                            echo "</div></div></div>";
                        }
                    }                    
                    ?>            

			
			<div class="horizontalTile pictures"><div class="horizontalContent"><img src="/assets/images/tiles/square_390x190.1.png"/></div></div>
			<div class="smallTile pictures"><div class="smallContent"><img src="/assets/images/tiles/square_190x190.2.png"/><img class="smallPic" style="display: none;" src="/assets/images/tiles/square_390x390.7.png"/></div></div>
			<div class="horizontalTile highlights"><div class="horizontalContent"><div class="message">Make an impact. Rethink commerce at Square.</div></div></div>
			<div class="bigTile pictures"><div class="bigContent"><img src="/assets/images/tiles/square_390x390.1.png"/></div></div>
			<div class="smallTile highlights"><div class="smallContent"><a href="http://squareup.com/careers/"><div class="message">Job Openings</div></a></div></div>
			<div class="smallTile pictures"><div class="smallContent"><img src="/assets/images/tiles/square_190x190.3.png"/></div></div>
			<div class="verticalTile highlights"><div class="verticalContent"><img src="/assets/images/tiles/square_190x390.1.png"/></div></div>
			<div class="horizontalTile highlights"><div class="horizontalContent"><img src="/assets/images/tiles/square_390x190.2.png"/></div></div>
			<div class="bigTile pictures"><div class="bigContent"></div></div>
			<div class="horizontalTile pictures"><div class="horizontalContent"><img src="/assets/images/tiles/square_390x190.3.png"/></div></div>
			<div class="smallTile highlights"><div class="smallContent"><img src="/assets/images/tiles/square_190x190.4.png"/></div></div>
			<div class="horizontalTile pictures"><div class="horizontalContent"><img src="/assets/images/tiles/square_390x190.4.png"/></div></div>
			<div class="verticalTile pictures "><div class="verticalContent ">1234567890 </div></div>
			<div class="smallTile highlights"><div class="smallContent"><img src="/assets/images/tiles/square_190x190.5.png"/></div></div>
			<div class="bigTile pictures"><div class="bigContent"><img src="/assets/images/tiles/square_390x390.2.png"/></div></div>
			<div class="verticalTile highlights"><div class="verticalContent"><img src="/assets/images/tiles/square_190x390.2.png"/></div></div>
			<div class="horizontalTile highlights"><div class="horizontalContent"><img src="/assets/images/tiles/square_390x190.5.png"/></div></div>
			<div class="bigTile pictures"><div class="bigContent"><img src="/assets/images/tiles/square_390x390.3.png"/></div></div>
			<div class="smallTile pictures"><div class="smallContent"></div></div>
			<div class="horizontalTile highlights"><div class="horizontalContent"><img src="/assets/images/tiles/square_390x190.6.png"/></div></div>
			<div class="verticalTile highlights"><div class="verticalContent"><img src="/assets/images/tiles/square_190x390.3.png"/></div></div>
			<div class="smallTile pictures"><div class="smallContent"></div></div>
			<div class="verticalTile pictures"><div class="verticalContent"><img src="/assets/images/tiles/square_190x390.4.png"/></div></div>
			<div class="bigTile pictures"><div class="bigContent"><img src="/assets/images/tiles/square_390x390.4.png"/></div></div>
			<div class="bigTile highlights"><div class="bigContent"><img src="/assets/images/tiles/square_390x390.5.png"/></div></div>
			<div class="horizontalTile pictures"><div class="horizontalContent"></div></div>
			<div class="verticalTile highlights"><div class="verticalContent"><img src="/assets/images/tiles/square_190x390.5.png"/></div></div>
			<div class="bigTile pictures"><div class="bigContent"><img src="/assets/images/tiles/square_390x390.6.png"/></div></div>
			<div class="smallTile highlights"><div class="smallContent"></div></div>
			<div class="verticalTile highlights"><div class="verticalContent"><img src="/assets/images/tiles/square_190x390.6.png"/></div></div>
			<div class="horizontalTile highlights"><div class="horizontalContent"><div class="message"></div></div></div>
			<div class="horizontalTile highlights"><div class="horizontalContent"><div class="message"></div></div></div>
			<div class="horizontalTile pictures"><div class="horizontalContent"><div class="message"></div></div></div>
			<div class="smallTile pictures"><div class="smallContent"></div></div>
			<div class="verticalTile pictures"><div class="verticalContent"><img src="/assets/images/tiles/square_190x390.7.png"/></div></div>
			<div class="horizontalTile pictures"><div class="horizontalContent"></div></div>
			<div class="smallTile pictures"><div class="smallContent"></div></div>
			<div class="verticalTile highlights"><div class="verticalContent"><img src="/assets/images/tiles/square_190x390.8.png"/></div></div>
			<div class="smallTile highlights"><div class="smallContent"></div></div>
                    
	
		</div>
</div>
