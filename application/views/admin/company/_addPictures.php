<link rel="stylesheet" href="<?php echo base_url();?>assets/css/imgareaselect-default.css" type="text/css"/>

<script src="<?php echo base_url();?>assets/js/blueimp/vendor/jquery.ui.widget.js"></script>
<script src="<?php echo base_url();?>assets/js/blueimp/jquery.iframe-transport.js"></script>
<script src="<?php echo base_url();?>assets/js/blueimp/jquery.fileupload.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.imgareaselect.pack.js"></script>

<div id="admin">
	<div class="content">
		<div id="pictures_nav">
			<a href = "/admin/company/listing">Back<br>to Listing</a>
		<?php 
			echo "<a href = '/admin/company/pictures/{$company_id}'>View<br>Pictures</a></div>"; 
		?>

		<div id="pictures">
			<div id="company_name">Company: <a href="/company/profile/<?php echo $company_id;?>" target="_blank"><?php echo $company_info['company_name'];?></a></div><br>
			
			<p> Click browse to upload a picture</p><br>
			<form id="fileupload" action="/admin/company/tile_upload" method="POST" enctype="multipart/form-data">
				<input type="file" name="userfile"/>    
				<input type="hidden" name="last_temp_file" value=""/>
			</form>    
			<div id="upload_result"></div>
			<br>
			<div id="crop_tile_pic" style="display: none;">
			    <p>Select crop shape and size</p><br>
			    <ul>
			    <li><div class="tile_choice"><input id="small_radio" type="radio" name="shape" value="0" /></div><div id="small_tile" class="tile_frame"></div>small</li>
			    <li><div class="tile_choice"><input id ="wide_radio" type="radio" name="shape" value="1" /></div><div id="wide_tile" class="tile_frame"></div>wide</li>
			    <li><div class="tile_choice"><input id="tall_radio" type="radio" name="shape" value="2" /></div><div id="tall_tile" class="tile_frame"></div>tall</li>
			    <li><div class="tile_choice"><input id="large_radio" type="radio" name="shape" value="3" /></div><div id="large_tile" class="tile_frame"></div>large</li>             
			    </ul>
			    
			    <div id="picture_original_photo">
				<p>Drag selection or use the handles to resize crop</p>
				<img class="tile_pic" />
			    </div>
			    <div id="tile_preview_area">
				<font>Crop Preview</font>
				<div id="tile_preview" class="preview_small"><img /></div>           
			    </div>
			    <div class="clear">
				<form id="tile_crop_form" action="/admin/company/tile_crop" method="POST">       
				    <input type="hidden" name="x1" value="" />
				    <input type="hidden" name="y1" value="" />
				    <input type="hidden" name="x2" value="" />
				    <input type="hidden" name="y2" value="" />
				    <input type="hidden" name="w" value="" />
				    <input type="hidden" name="h" value="" />
				    <input type="hidden" name="cropFile" value="" />
				    <input type="hidden" name="pic_db_field" value="profile_photo" />
				    <input type="hidden" name="pic_shape" value="" />
				    <input type="hidden" name="company_id" value="<?php echo $company_id;?>" />
				    <br />
				    <input type="submit" id="crop_save" class="buttons crop_buttons" name="submit" value="Save" />
				</form>
				<div class="error_text tile_crop_error"></div>
			    </div>
			</div>
			<div id="next" style="display: none;"><input class="buttons crop_buttons" type="button" name="next" value="Next"/></div>
			</div> 


			</div>
			<div id="final" style="display: none;">
			<input class="buttons crop_buttons" type="button" name="next" value="Create Another?" onclick="location.href='/admin/company/create_step_1'"/>
			</div>

		</div>
		<script>
		$(document).ready(function(){
		
			var ias = $('.tile_pic').imgAreaSelect({ instance: true });
			
			// Upload image file for cropping
			$(function () {
				$('#fileupload').fileupload({
				    type: 'POST',
				    dataType: 'json',
				    done: function (e, data) {
					if (data.result.success == 1){
						$('input[name=last_temp_file]').val('');
						$('input[name=last_temp_file]').val(data.result.message);
						$('#upload_result').html('');
						$('.tile_pic').attr('src','<?php echo base_url().PROFILE_PIC_TEMP_PATH;?>'+data.result.message);
						$('#tile_preview img').attr('src','<?php echo base_url().PROFILE_PIC_TEMP_PATH;?>'+data.result.message);
						$('input[name=cropFile]').val(data.result.message); 
						$('#crop_tile_pic').show("fast");
						$('div#crop_tile_pic').find('input').prop('checked', false);
						$('#tile_preview').removeClass().addClass('preview_small');
					} else {
					    $('#upload_result').html(data.result.message);
					};
					ias.setOptions({ fadeSpeed: 100 });
					ias.cancelSelection();
				    }
				});
			}); 


			//VARIOUS CROP SHAPES/DIMENSIONS FOLLOW....
			//
			//SMALL...
			// Call imgAreaSelect to crop tile picture and associated coordinates
			$('div#crop_tile_pic li').on("click", function(event){
				$(this).find('input').prop('checked', true);
				if($(this).find('input').attr('id') == 'small_radio'){imgAreaSmall(); $('#tile_preview').removeClass().addClass('preview_small');};
				if($(this).find('input').attr('id') == 'wide_radio'){imgAreaWide(); $('#tile_preview').removeClass().addClass('preview_wide');};
				if($(this).find('input').attr('id') == 'tall_radio'){imgAreaTall(); $('#tile_preview').removeClass().addClass('preview_tall');};
				if($(this).find('input').attr('id') == 'large_radio'){imgAreaLarge(); $('#tile_preview').removeClass().addClass('preview_large');};
			});    

			function imgAreaSmall(){
				$('.tile_pic').imgAreaSelect({
					x1: 0,
					y1: 0,
					x2: 190,
					y2: 190,            
					minWidth: 190,
					minHeight: 190,
					handles: true,
					fadeSpeed: 1000,
					persistent: true,
					aspectRatio: "1:1",
					onSelectChange: previewTileSmall,
					onSelectEnd: function (img, selection) {				
						$('input[name=x1]').val(selection.x1);
						$('input[name=y1]').val(selection.y1);
						$('input[name=x2]').val(selection.x2);
						$('input[name=y2]').val(selection.y2); 
						$('input[name=w]').val(selection.width);
						$('input[name=h]').val(selection.height);
						$('input[name=pic_shape]').val(1);
					}
				});
			}
				
			function imgAreaWide(){
				$('.tile_pic').imgAreaSelect({
					x1: 0,
					y1: 0,
					x2: 390,
					y2: 190,            
					minWidth: 390,
					minHeight: 190,
					handles: true,
					fadeSpeed: 1000,
					persistent: true,
					aspectRatio: "2.05:1",
					onSelectChange: previewTileWide,
					onSelectEnd: function (img, selection) {				
						$('input[name=x1]').val(selection.x1);
						$('input[name=y1]').val(selection.y1);
						$('input[name=x2]').val(selection.x2);
						$('input[name=y2]').val(selection.y2); 
						$('input[name=w]').val(selection.width);
						$('input[name=h]').val(selection.height);
						$('input[name=pic_shape]').val(2);
					}
				});
			}
				
			function imgAreaTall(){
				$('.tile_pic').imgAreaSelect({
					x1: 0,
					y1: 0,
					x2: 190,
					y2: 390,            
					minWidth: 190,
					minHeight: 390,
					handles: true,
					fadeSpeed: 1000,
					persistent: true,				    
					aspectRatio: "1:2.05",
					onSelectChange: previewTileTall,
					onSelectEnd: function (img, selection) {				
						$('input[name=x1]').val(selection.x1);
						$('input[name=y1]').val(selection.y1);
						$('input[name=x2]').val(selection.x2);
						$('input[name=y2]').val(selection.y2); 
						$('input[name=w]').val(selection.width);
						$('input[name=h]').val(selection.height);
						$('input[name=pic_shape]').val(3);
					}
				});
			}		

			function imgAreaLarge(){
				$('.tile_pic').imgAreaSelect({
					x1: 0,
					y1: 0,
					x2: 390,
					y2: 390,            
					minWidth: 390,
					minHeight: 390,
					handles: true,
					fadeSpeed: 1000,
					persistent: true,					    
					aspectRatio: "1:1",
					onSelectChange: previewTileLarge,
					onSelectEnd: function (img, selection) {				
						$('input[name=x1]').val(selection.x1);
						$('input[name=y1]').val(selection.y1);
						$('input[name=x2]').val(selection.x2);
						$('input[name=y2]').val(selection.y2); 
						$('input[name=w]').val(selection.width);
						$('input[name=h]').val(selection.height);
						$('input[name=pic_shape]').val(4);
					}
				});
			}
			
			// Function used by imgAreaSelect to preview tile picture	
			function previewTileSmall(img, selection) {    
				if (!selection.width || !selection.height)
				return;
				var scaleX = 190 / selection.width;
				var scaleY = 190 / selection.height;
				$('#tile_preview img').css({
					width: Math.round(scaleX*img.width),
					height: Math.round(scaleY*img.height),
					marginLeft: -Math.round(scaleX * selection.x1),
					marginTop: -Math.round(scaleY * selection.y1) 
				});
			};  

			// Function used by imgAreaSelect to preview tile picture	
			function previewTileWide(img, selection) {			
				if (!selection.width || !selection.height)
				return;
				var scaleX = 390 / selection.width;
				var scaleY = 190 / selection.height;
				$('#tile_preview img').css({
					width: Math.round(scaleX*img.width),
					height: Math.round(scaleY*img.height),
					marginLeft: -Math.round(scaleX * selection.x1),
					marginTop: -Math.round(scaleY * selection.y1) 
				});
			};

			// Function used by imgAreaSelect to preview tile picture	
			function previewTileTall(img, selection) {			
				if (!selection.width || !selection.height)
				return;
				var scaleX = 190 / selection.width;
				var scaleY = 390 / selection.height;
				$('#tile_preview img').css({
					width: Math.round(scaleX*img.width),
					height: Math.round(scaleY*img.height),
					marginLeft: -Math.round(scaleX * selection.x1),
					marginTop: -Math.round(scaleY * selection.y1) 
				});
			};

			// Function used by imgAreaSelect to preview tile picture	
			function previewTileLarge(img, selection) {			
				if (!selection.width || !selection.height)
				return;
				var scaleX = 390 / selection.width;
				var scaleY = 390 / selection.height;
				$('#tile_preview img').css({
					width: Math.round(scaleX*img.width),
					height: Math.round(scaleY*img.height),
					marginLeft: -Math.round(scaleX * selection.x1),
					marginTop: -Math.round(scaleY * selection.y1) 
				});
			};

		    $("#tile_crop_form").submit(function(event) {
			event.preventDefault();
			$.post(
			    "/admin/company/tile_crop",
			    $('#tile_crop_form').serialize(),
			    function(data){
				if (data.success == 0){
				    $('.tile_crop_error').html(data.message); 
				}else{
				    //send user to the next step...
				    //window.location = "/admin/company/create_step_3";
				    $('input[name=x1]').val('');
				    $('input[name=y1]').val('');
				    $('input[name=x2]').val('');
				    $('input[name=y2]').val(''); 
				    $('input[name=w]').val('');
				    $('input[name=h]').val('');                    
				    $('.tile_crop_error').html('');
				    $('input[name=last_temp_file]').val('');
				    $('.tile_pic').imgAreaSelect({
					remove: true
				    });
				    $('.tile_pic').attr('src','');
				    $('#tile_preview img').attr('src','');  
				    $('input[name=cropFile]').val('');
				     $('#crop_tile_pic').hide();
				     $('#upload_result').html(data.message+' Browse to upload and crop another one.');
			    
				}
			    }, "json"
				);
		    });
		    
		});//end of document ready
		</script>
	</div>
</div>





