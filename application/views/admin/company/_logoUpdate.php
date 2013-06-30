<link rel="stylesheet" href="<?php echo base_url();?>assets/css/imgareaselect-default.css" type="text/css"/>
<script src="<?php echo base_url();?>assets/js/blueimp/vendor/jquery.ui.widget.js"></script>
<script src="<?php echo base_url();?>assets/js/blueimp/jquery.iframe-transport.js"></script>
<script src="<?php echo base_url();?>assets/js/blueimp/jquery.fileupload.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.imgareaselect.pack.js"></script>
<script>
$(document).ready(function(){
    //For Basic Logo Image
    $(function () {
        $('#fileupload').fileupload({
            type: 'POST',
            dataType: 'json',
            done: function (e, data) {
                //console.dir(data);
                if (data.result.success == 1){
			$('#crop_logo_pic').show("slow");
			$('#next_one').hide();
			$('.logo_pic').attr('src','<?php echo base_url().COMPANY_LOGO_TEMP_PATH;?>'+data.result.message);
			$('#logo_preview img').attr('src','<?php echo base_url().COMPANY_LOGO_TEMP_PATH;?>'+data.result.message);
			
			/*
			$('.logo_pic').imgAreaSelect({
				hide: true
			});
			$('input[name=last_temp_file]').val('');
			$('input[name=last_temp_file]').val(data.result.message);
			$('#current_logo').hide();
			$('#upload_result').html('');
			$('input[name=cropFile]').val(data.result.message); 
			*/
                     
                } else {
                    $('#upload_result').html(data.result.message);
                }

            }
        });
	
	//
	$("#next_logo").click(function(){ 
		$('input[name=x1]').val('');
		$('input[name=y1]').val('');
		$('input[name=x2]').val('');
		$('input[name=y2]').val(''); 
		$('input[name=w]').val('');
		$('input[name=h]').val('');                    
		$('.logo_crop_error').html('');
		$('div.company_logo').hide();
		$('#creative').show("slow");
		$('.logo_pic').imgAreaSelect({
			remove: true
		});
	});  
	
	
	
    }); 

/*
// Call imgAreaSelect to crop logo picture and associated coordinates
    $('.logo_pic').imgAreaSelect({
        minWidth: 250,
        minHeight: 250,
        handles: true,
        aspectRatio: "1:1",
        onSelectChange: previewLogo,
        onSelectEnd: function (img, selection) {				
            $('input[name=x1]').val(selection.x1);
            $('input[name=y1]').val(selection.y1);
            $('input[name=x2]').val(selection.x2);
            $('input[name=y2]').val(selection.y2); 
            $('input[name=w]').val(selection.width);
            $('input[name=h]').val(selection.height);
        }
    });

    // Function used by imgAreaSelect to preview logo picture	
    function previewLogo(img, selection) {
        
            if (!selection.width || !selection.height)
            return;

            var scaleX = 250 / selection.width;
            var scaleY = 250 / selection.height;

            $('#logo_preview img').css({
            width: Math.round(scaleX*img.width),
            height: Math.round(scaleY*img.height),
            marginLeft: -Math.round(scaleX * selection.x1),
            marginTop: -Math.round(scaleY * selection.y1) 
            });
    };  

    $("#logo_crop_form").submit(function(event) {
        event.preventDefault();
        $.post(
            "/admin/company/crop_png",
            $('#logo_crop_form').serialize(),
            function(data){
                //console.dir(data);
                //$('<p/>').text(data.message).appendTo('#result');
                if (data.success == 0){
                    $('.logo_crop_error').html(data.message); 
                }else{
                    //send user to the next step...
                    //window.location = "/admin/company/create_step_3";
                    $('input[name=x1]').val('');
                    $('input[name=y1]').val('');
                    $('input[name=x2]').val('');
                    $('input[name=y2]').val(''); 
                    $('input[name=w]').val('');
                    $('input[name=h]').val('');                    
                    $('.logo_crop_error').html('');
                    $('input[name=last_temp_file]').val('');
                    $('#logo').hide();
                    $('#creative').show("slow");
                    $('.logo_pic').imgAreaSelect({
                        remove: true
                    });
                    
                }
            }, "json"
                );
    });
   
 
 
//For Creative Logo Image
    $(function () {
        $('#fileupload2').fileupload({
            type: 'POST',
            dataType: 'json',
            done: function (e, data) {
                if (data.result.success == 1){
                    $('.creative_pic').imgAreaSelect({
                        hide: true
                    });    
                    $('input[name=last_temp_file]').val('');
                    $('input[name=last_temp_file]').val(data.result.message);                    
                    $('#current_creative_logo').hide();
                    $('#creative_next_one').hide();                    
                    $('#upload_result').html('');
                    $('#crop_creative_pic').show("slow");
                    $('.creative_pic').attr('src','<?php echo base_url().COMPANY_LOGO_TEMP_PATH;?>'+data.result.message);
                    $('#creative_preview img').attr('src','<?php echo base_url().COMPANY_LOGO_TEMP_PATH;?>'+data.result.message);
                    $('input[name=cropFile]').val(data.result.message);     
                } else {
                    $('#upload_result2').html(data.result.message);
                }
            }
        });
    });  
    
    // Call imgAreaSelect to crop logo picture and associated coordinates
    $('.creative_pic').imgAreaSelect({
        minWidth: 250,
        minHeight: 250,
        handles: true,
        aspectRatio: "1:1",
        onSelectChange: previewCreative,
        onSelectEnd: function (img, selection) {				
            $('input[name=x1]').val(selection.x1);
            $('input[name=y1]').val(selection.y1);
            $('input[name=x2]').val(selection.x2);
            $('input[name=y2]').val(selection.y2); 
            $('input[name=w]').val(selection.width);
            $('input[name=h]').val(selection.height);
            //console.dir(selection);
        }
    });

    // Function used by imgAreaSelect to preview logo picture	
    function previewCreative(img, selection) {
        
            if (!selection.width || !selection.height)
            return;

            var scaleX = 250 / selection.width;
            var scaleY = 250 / selection.height;

            $('#creative_preview img').css({
            width: Math.round(scaleX*img.width),
            height: Math.round(scaleY*img.height),
            marginLeft: -Math.round(scaleX * selection.x1),
            marginTop: -Math.round(scaleY * selection.y1) 
            });
    };  

    $("#creative_crop_form").submit(function(event) {
        event.preventDefault();
        $.post(
            "/admin/company/crop",
            $('#creative_crop_form').serialize(),
            function(data){
                //console.dir(data);
                //$('<p/>').text(data.message).appendTo('#result');
                if (data.success == 0){
                    $('.creative_crop_error').html(data.message); 
                }else{
                    //send user to the next step...
                  //  $('#creative').hide();
                  //  $('#final').show("slow");
                  //  $('.creative_pic').imgAreaSelect({
                  //      remove: true
                  //  });
                    $('.creative_crop_error').html('');
                    window.location = "/admin/company/update_save/<?php echo $company_id;?>";
                    
                }
            }, "json"
                );
    });
    $("#finish_button").click(function(){ 
            window.location = "/admin/company/update_save/<?php echo $company_id;?>";
    });      
    */
});//end of document ready 


</script>

<div id="admin">
	<div class="content">
	
		<div>Emplayo - Edit Existing Company (Step 2 of 3)</div>
		<div class="company_logo">
			<div class="current_logo"><img src="<?php echo base_url().COMPANY_LOGO_PATH.$company_logo;?>"> </div>
			<div class="current_logo">
				<div id="browse">
					<p> Browse to select and upload a different company logo</p><br>
					<form id="fileupload" action="/admin/company/logo_upload" method="POST" enctype="multipart/form-data">
						<input type="file" name="userfile"/>    
						<input type="hidden" name="last_temp_file" value=""/>
					</form>
					<div id="upload_result"></div>
				</div>
			</div>
		</div>
		<div class="company_logo"><input class="button_grey" id="next_logo" type="button" value="Skip"/></div>
		
		
		<div id="crop_logo_pic" style="display: none;">
		    <div id="logo_crop_instruction">Click and drag on the image below to create your logo picture.</div>
		    <div id="logo_original_photo">
			<img class="logo_pic" />
		    </div>
		    <div id="logo_preview_area">
			<font>Logo Photo Preview</font>
			<div id="logo_preview">
			    <img />
			</div>    
		    </div>        

		    <div id="logo_save">
			<form id="logo_crop_form" action="/admin/company/crop_png" method="POST">       
			    <input type="hidden" name="x1" value="" />
			    <input type="hidden" name="y1" value="" />
			    <input type="hidden" name="x2" value="" />
			    <input type="hidden" name="y2" value="" />
			    <input type="hidden" name="w" value="" />
			    <input type="hidden" name="h" value="" />
			    <input type="hidden" name="cropFile" value="" />
			    <input type="hidden" name="pic_db_field" value="company_logo" />
			    <br />
			    <input type="submit" id="crop_save" class="buttons crop_buttons" name="submit" value="Save" />
			</form>
			<div class="error_text logo_crop_error"></div>
		    
		</div>
		<div id="next" style="display: none;"><input class="buttons crop_buttons" type="button" name="next" value="Next"/></div>
	   </div> 
	    
	    <div id="creative" style="display: none;">
		<div id="hd"><h1>Emplayo - Edit Existing Company (Step 3 of 3)</h1></div>
		
		<div id="current_creative_logo">
		    <img src="<?php echo base_url().COMPANY_LOGO_PATH.$creative_logo;?>">        
		<p> Browse to select and upload a different creative logo.  Make it hot! </p>
		</div>
		
		<!--<input id="fileupload2" type="file" name="userfile" data-url="/admin/company/logo_upload" multiple> -->
		
		<form id="fileupload2" action="/admin/company/logo_upload" method="POST" enctype="multipart/form-data">
		    <input type="file" name="userfile"/>    
		    <input type="hidden" name="last_temp_file" value=""/>
		</form>          
		
		<div id="creative_next_one">
		<p> ...or click 'Finish' to keep the current photo and save any changes. </p>  
		<input class="buttons crop_buttons" id="finish_button" type="button" name="finish_button" value="Finish"/>         
		</div>        

		<div id="upload_result2"></div>
		<div id="crop_creative_pic" style="display: none;">
		    <div id="creative_crop_instruction">Click and drag on the image below to create your creative picture.</div>
		    <div id="creative_original_photo">
			<img class="creative_pic" />
		    </div>
		    <div id="creative_preview_area">
			<font>Logo Photo Preview</font>
			<div id="creative_preview">
			    <img />
			</div>    
		    </div>        

		    <div id="creative_save">
			<form id="creative_crop_form" action="/admin/company/crop" method="POST">       
			    <input type="hidden" name="x1" value="" />
			    <input type="hidden" name="y1" value="" />
			    <input type="hidden" name="x2" value="" />
			    <input type="hidden" name="y2" value="" />
			    <input type="hidden" name="w" value="" />
			    <input type="hidden" name="h" value="" />
			    <input type="hidden" name="cropFile" value="" />
			    <input type="hidden" name="pic_db_field" value="creative_logo" />
			    <br />
			    <input type="submit" id="crop_save" class="buttons crop_buttons" name="submit" value="Save and Finalize" />
			</form>
			<div class="error_text creative_crop_error"></div>
		    </div>
		</div>
		
	   </div>     
	</div>
	<div id="final" style="display: none;">
		<input class="buttons crop_buttons" type="button" name="next" value="Create Another?" onclick="location.href='/admin/company/create_step_1'"/>
	</div>	
		
		
</div>