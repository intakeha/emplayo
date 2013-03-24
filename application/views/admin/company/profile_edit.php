<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Image Upload</title>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/reset-fonts-grids.css" type="text/css"/>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/base.css" type="text/css"/>        
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/imgareaselect-default.css" type="text/css"/>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/crop.css" type="text/css"/>
<style>
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
                //console.dir(data);
                if (data.result.success == 1){
                    $('.logo_pic').imgAreaSelect({
                        hide: true
                    });
                    $('input[name=last_temp_file]').val('');
                    $('input[name=last_temp_file]').val(data.result.message);
                    $('#current_logo').hide();
                    $('#next_one').hide();
                    $('#upload_result').html('');
                    $('#crop_logo_pic').show("fast");
                    $('.logo_pic').attr('src','/assets/images/company_tiles/temp/'+data.result.message);
                    $('#logo_preview img').attr('src','/assets/images/company_tiles/temp/'+data.result.message);
                    $('input[name=cropFile]').val(data.result.message); 
                     
                } else {
                    $('#upload_result').html(data.result.message);
                }

            }
        });
    }); 


//VARIOUS CROP SHAPES/DIMENSIONS FOLLOW....
//
//SMALL...
    // Call imgAreaSelect to crop logo picture and associated coordinates
    $('#small_radio').change(function(){
        $("#logo_preview").removeClass().addClass("preview_small");
        $('.logo_pic').imgAreaSelect({
            x1: 0,
            y1: 0,
            x2: 190,
            y2: 190,            
            minWidth: 190,
            minHeight: 190,
            handles: true,
            aspectRatio: "1:1",
            onSelectChange: previewLogoSmall,
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
     });    

    // Function used by imgAreaSelect to preview logo picture	
    function previewLogoSmall(img, selection) {    
            if (!selection.width || !selection.height)
            return;
            var scaleX = 190 / selection.width;
            var scaleY = 190 / selection.height;
            $('#logo_preview img').css({
            width: Math.round(scaleX*img.width),
            height: Math.round(scaleY*img.height),
            marginLeft: -Math.round(scaleX * selection.x1),
            marginTop: -Math.round(scaleY * selection.y1) 
            });
    };  

//WIDE...
    $('#wide_radio').change(function(){
        $("#logo_preview").removeClass().addClass("preview_wide");      
        $('.logo_pic').imgAreaSelect({
            x1: 0,
            y1: 0,
            x2: 390,
            y2: 190,            
            minWidth: 390,
            minHeight: 190,
            handles: true,
            aspectRatio: "2.05:1",
            onSelectChange: previewLogoWide,
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
     });    

    // Function used by imgAreaSelect to preview logo picture	
    function previewLogoWide(img, selection) {
        
            if (!selection.width || !selection.height)
            return;
            var scaleX = 390 / selection.width;
            var scaleY = 190 / selection.height;
            $('#logo_preview img').css({
            width: Math.round(scaleX*img.width),
            height: Math.round(scaleY*img.height),
            marginLeft: -Math.round(scaleX * selection.x1),
            marginTop: -Math.round(scaleY * selection.y1) 
            });
    };

//TALL...
    $('#tall_radio').change(function(){
        $("#logo_preview").removeClass().addClass("preview_tall");      
        $('.logo_pic').imgAreaSelect({
            x1: 0,
            y1: 0,
            x2: 190,
            y2: 390,            
            minWidth: 190,
            minHeight: 390,
            handles: true,
            aspectRatio: "1:2.05",
            onSelectChange: previewLogoTall,
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
     });    

    // Function used by imgAreaSelect to preview logo picture	
    function previewLogoTall(img, selection) {
        
            if (!selection.width || !selection.height)
            return;
            var scaleX = 190 / selection.width;
            var scaleY = 390 / selection.height;
            $('#logo_preview img').css({
            width: Math.round(scaleX*img.width),
            height: Math.round(scaleY*img.height),
            marginLeft: -Math.round(scaleX * selection.x1),
            marginTop: -Math.round(scaleY * selection.y1) 
            });
    };

//LARGE...
    $('#large_radio').change(function(){
        $("#logo_preview").removeClass().addClass("preview_large");      
        $('.logo_pic').imgAreaSelect({
            x1: 0,
            y1: 0,
            x2: 390,
            y2: 390,            
            minWidth: 390,
            minHeight: 390,
            handles: true,
            aspectRatio: "1:1",
            onSelectChange: previewLogoLarge,
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
     });    

    // Function used by imgAreaSelect to preview logo picture	
    function previewLogoLarge(img, selection) {
        
            if (!selection.width || !selection.height)
            return;
            var scaleX = 390 / selection.width;
            var scaleY = 390 / selection.height;
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
            "/admin/company/tile_crop",
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
                   
                    
                    $('.logo_pic').imgAreaSelect({
                        remove: true
                    });
                    $('.logo_pic').attr('src','');
                    $('#logo_preview img').attr('src','');  
                    $('input[name=cropFile]').val('');
                     $('#crop_logo_pic').hide();
                     $('#upload_result').html(data.message+' Browse to upload and crop another one.');

                    
                    
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
        <div id="hd"><h1>Emplayo - Edit Profile Pics for <a href="/admin/company/view/<?php echo $company_id;?>"><?php echo $company_info['company_name'];?></a></h1></div>   
        <div><a href = "/admin/company/listing">Back to Listing</a></div>
        <div><a href = "/admin/company/profile_view/<?php echo $company_id;?>">Back to Profile Pic View</a></div>
        <p> Browse to select and upload a picture for the company profile page... </p>
        
        
<form id="fileupload" action="/admin/company/tile_upload" method="POST" enctype="multipart/form-data">
    <input type="file" name="userfile"/>    
    <input type="hidden" name="last_temp_file" value=""/>
</form>    
        
        <div id="upload_result"></div>
        <div id="crop_logo_pic" style="display: none;">
            <div id="logo_crop_instruction">Select a crop shape, then click and drag on the image below to create your large picture.</div>
            <div>
            <input id="small_radio" type="radio" name="shape" value="0" /> small
            <input id ="wide_radio" type="radio" name="shape" value="1" /> wide
            <input id="tall_radio" type="radio" name="shape" value="2" /> tall
            <input id="large_radio" type="radio" name="shape" value="3" /> large                   
            </div>
            
            <div id="logo_original_photo">
                <img class="logo_pic" />
            </div>
            <div id="logo_preview_area">
                <font>Profile Photo Preview</font>
                <div id="logo_preview" class="preview_small"><img /></div>    
                <div id="logo_preview_wide"><img /></div>                
            </div>

            <div id="logo_save">
                <form id="logo_crop_form" action="/admin/company/tile_crop" method="POST">       
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
                <div class="error_text logo_crop_error"></div>
            </div>
        </div>
        <div id="next" style="display: none;"><input class="buttons crop_buttons" type="button" name="next" value="Next"/></div>
   </div> 
 
    
</div>
    <div id="final" style="display: none;">
        <input class="buttons crop_buttons" type="button" name="next" value="Create Another?" onclick="location.href='/admin/company/create_step_1'"/>
    </div>

</body>
</html>    