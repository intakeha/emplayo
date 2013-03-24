<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Image Upload</title>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/reset-fonts-grids.css" type="text/css"/>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/base.css" type="text/css"/>        
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/imgareaselect-default.css" type="text/css"/>
<style>
#logo_preview_area {
	float: left;
	padding: 10px;
	border: 1px solid #ccc;
	text-align: center;
	font-size: 12px;
	font-weight: bold;
        background-color: #999;
}    
    
#logo_preview {
        width: 250px;
        height: 250px;
        margin-top: 20px;
        overflow: hidden;
}
#logo_original_photo{
	width: 600px;
	float: left;
	margin-right: 30px;
        border: 1px solid #ccc;
}

#creative_preview_area {
	float: left;
	padding: 10px;
	border: 1px solid #ccc;
	text-align: center;
	font-size: 12px;
	font-weight: bold;
        background-color: #999;
}    
    
#creative_preview {
        width: 250px;
        height: 250px;
        margin-top: 20px;
        overflow: hidden;
}
#creative_original_photo{
	width: 600px;
	float: left;
	margin-right: 30px;
        border: 1px solid #ccc;
}
</style>
<script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
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
                console.dir(data);
                if (data.result.success == 1){
                    $('.logo_pic').imgAreaSelect({
                        hide: true
                    });                    
                    $('#upload_result').html('');
                    $('#crop_logo_pic').show();
                    $('.logo_pic').attr('src','/assets/images/company_logos/temp/'+data.result.message);
                    $('#logo_preview img').attr('src','/assets/images/company_logos/temp/'+data.result.message);
                    $('input[name=cropFile]').val(data.result.message);    
                } else {
                    $('#upload_result').html(data.result.message);
                }

            }
        });
    });  

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
            "/admin/company/crop",
            $('#logo_crop_form').serialize(),
            function(data){
                console.dir(data);
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
                    $('#upload_result').html('');
                    $('#crop_creative_pic').show();
                    $('.creative_pic').attr('src','/assets/images/company_logos/temp/'+data.result.message);
                    $('#creative_preview img').attr('src','/assets/images/company_logos/temp/'+data.result.message);
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
                console.dir(data);
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
                    window.location = "/admin/company/create_save";
                    
                }
            }, "json"
                );
    });
});//end of document ready
</script>

</head>
<body>

<div id="container">
    <div id="logo">
        <div id="hd"><h1>Emplayo - New Company Entry (Step 2 of 3)</h1></div>
        <p> Browse to select and upload the company logo </p>
        <input id="fileupload" type="file" name="userfile" data-url="logo_upload" multiple> 
        <div id="upload_result"></div>
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
                <form id="logo_crop_form" action="/admin/company/crop" method="POST">       
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
        </div>
        <div id="next" style="display: none;"><input class="buttons crop_buttons" type="button" name="next" value="Next" onclick="location.href='/admin/company/create_step_3'"/></div>
   </div> 
    
    <div id="creative" style="display: none;">
        <div id="hd"><h1>Emplayo - New Company Entry (Step 3 of 3)</h1></div>
        <p> Now, browse to select and upload a CREATIVE logo.  Make it hot! </p>
        <input id="fileupload2" type="file" name="userfile" data-url="logo_upload" multiple> 
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

</body>
</html>    