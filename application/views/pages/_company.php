<script>
	$(function() {
		$( "ul#filters li:first-child").find("a").addClass('selected');
		$( "ul#filters a").on("click", function(event){
			$( "ul#filters a").removeClass();
			$(this).addClass('selected');
		});
	});
</script> 
<div id="company">
	<div class="content">
		<ul id="filters">
			<li><a href="#" data-filter=".highlights, .pictures">company</a></li>
			<li><a href="#" data-filter=".highlights">highlights</a></li>
			<li><a href="#" data-filter=".pictures">pictures</a></li>
		</ul>

            <div id="tiles">
                    <?php
                    $image_path = base_url().PROFILE_PIC_PATH;
                    $logo_path = base_url().COMPANY_LOGO_PATH;
                    $counter = 0;
                    
                    //display the logo
                    echo "<div class='smallTile highlights pictures'><div class='smallContent'>";
                    echo "<a  href='{$company_info['company_url']}' target='_blank'><img src='{$logo_path}{$company_info['company_logo']}'/ width='190'></a>";
                    echo "</div></div>";   
 
                    //job openings
                    $jobs_tile = "<div class='smallTile highlights'><a href='{$company_info['jobs_url']}' target='_blank' class='jobTile'></a></div>";
                    $facebook_tile = "<div class='smallTile highlights'><a href='{$company_info['facebook_url']}' target='_blank' class='facebookTile'></a></div>";
		    $twitter_tile = "<div class='smallTile highlights'><a href='{$company_info['twitter_url']}' target='_blank' class='twitterTile'></a></div>";
   
                    //loop through and display the tiles
                    //
                    //TODO: Figure out how important this conditional is.  Commenting out for
                    //now to faciliate the seed data entry process...
                    //
                   // if (!empty($pic_array) && !empty($company_info) && !empty($quote_array))
                        
                        foreach ($merged_array as $row)
                        {
                            if ($counter == 3)
                            {
                                echo $jobs_tile;                                
                            }
                            if ($counter == 5)
                            {
                                echo $facebook_tile;                                
                            }       
                            if ($counter == 6)
                            {
                                echo $twitter_tile;                                
                            }    			    

                            if (!empty($row['file_name']))
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
                                $counter++;
                            }
                            else 
                            {       
                                switch ($row['tile_shape']) {
					case 1://small
						//echo "<div class='smallTile highlights'><div class='smallContent'><div class='smallQuote'>";
						echo "<div class='smallTile highlights'><div class='smallQuoteContent'><div class='smallQuote'>";
						break;
					case 2://vertical
						echo "<div class='verticalTile highlights'><div class='verticalQuoteContent'><div class='verticalQuote'>";
						break;
					case 3://horizontal
						echo "<div class='horizontalTile highlights'><div class='horizontalQuoteContent'><div class='horizontalQuote'>";
						break;
					case 4://large
						echo "<div class='bigTile highlights'><div class='bigQuoteContent'><div class='bigQuote'>";
						break;                                
                                }                            
                                echo "{$row['quote']}";
                                echo "</div></div></div>";  
                                $counter++;
                            }
                        }
		?>
		</div>
</div>
