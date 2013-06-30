<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* ------------------------------functions:
function resizeImage($image,$width,$height,$scale);
function resizeThumbnailImage($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale);
function getHeight($image);
function getWidth($image);

------------------------------------------------------------*/
if ( ! function_exists('resizeImage'))
{
    function resizeImage($image,$width,$height,$scale) {
            list($imagewidth, $imageheight, $imageType) = getimagesize($image);
            $imageType = image_type_to_mime_type($imageType);
            $newImageWidth = ceil($width * $scale);
            $newImageHeight = ceil($height * $scale);
            $newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
            //determine the type and create an image 'resource' to work with
            switch($imageType) {
                    case "image/gif":
                            $source=imagecreatefromgif($image); 
                            $delete_old = 1; //bc changed file to jpeg
                            break;
                    case "image/pjpeg":
                            $source=imagecreatefromjpeg($image); 
                            $delete_old = 0; //already a jpeg
                            break;
                    case "image/jpeg":
                            $source=imagecreatefromjpeg($image); 
                            $delete_old = 0; //already a jpeg
                            break;
                    case "image/jpg":
                            $source=imagecreatefromjpeg($image); 
                            $delete_old = 0; //already a jpeg
                            break;
                    case "image/png":
                            $source=imagecreatefrompng($image); 
                            $delete_old = 1; //bc changed file to jpeg
                            break;
                    case "image/x-png":
                            $source=imagecreatefrompng($image); 
                            $delete_old = 1; //bc changed file to jpeg
                            break;
            }
            //the following scales the source image onto the newImage 'canvas'
            imagecopyresampled($newImage,$source,0,0,0,0,$newImageWidth,$newImageHeight,$width,$height);
        
            //adding the jpg extension onto the new image
            $new_image_name  = substr($image, 0, strrpos($image, '.')).".jpg";
            
            //$newImage is currently a 'resource'.  we need to turn it into a physical file on the 
            //file system, specifically a JPEG type, with quality of 90:
            imagejpeg($newImage, $new_image_name,100); 

            //if we created a new file to convert to jpeg need to delete the old one.
             if ($delete_old == 1){
                    unlink($image);
             }

            chmod($new_image_name, 0777);
            return $new_image_name;
    }
}

if ( ! function_exists('resizeImage_lossless'))
{
    function resizeImage_lossless($image,$width,$height,$scale) {
            list($imagewidth, $imageheight, $imageType) = getimagesize($image);
            $imageType = image_type_to_mime_type($imageType);
            $newImageWidth = ceil($width * $scale);
            $newImageHeight = ceil($height * $scale);
            $newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
            //determine the type and create an image 'resource' to work with
            switch($imageType) {
                    case "image/gif":
                            $source=imagecreatefromgif($image); 
                            $delete_old = 1;                           
                            // integer representation of the color black (rgb: 0,0,0)
                            $background = imagecolorallocate($source, 0, 0, 0);
                            // removing the black from the placeholder
                            imagecolortransparent($source, $background);                                                       
                            break;
                    case "image/pjpeg":
                    case "image/jpg":
                    case "image/jpeg":
                            $source=imagecreatefromjpeg($image); 
                            $delete_old = 1;
                            break;
                    case "image/png":
                    case "image/x-png":
                            $source=imagecreatefrompng($image); 
                            $delete_old = 0; //final format will be png...no need to delete                           
                            // Preserve alpha
                            imagesavealpha($newImage, true);
                            //$color = imagecolorallocatealpha($newImage, 0, 0, 0, 127); // Create transparent background                            
                            $color = imagecolorallocate($newImage, 255, 255, 255); //create white background
                            // Fill in background
                            imagefill($newImage, 0, 0, $color);                               
                            break;
            }           

            //the following scales the source image onto the newImage 'canvas'
            imagecopyresampled($newImage,$source,0,0,0,0,$newImageWidth,$newImageHeight,$width,$height);
            
           $newImage = pixel_bleacher($newImage, $newImageWidth, $newImageHeight); 
        
            //adding the png extension onto the new image
            $new_image_name  = substr($image, 0, strrpos($image, '.')).".png";
            
            //$newImage is currently a 'resource'.  we need to turn it into a physical file on the 
            //file system, specifically a JPEG type, with quality of 90:
            //imagejpeg($newImage, $new_image_name,100); 
            //imagepng($newImage, $new_image_name, $quality, $filters);
            imagepng($newImage, $new_image_name, NULL, NULL);
            imagedestroy($newImage);

            //if we created a new file to convert to png need to delete the old one.
             if ($delete_old == 1){
                    unlink($image);
             }

            chmod($new_image_name, 0777);
            return $new_image_name;
    }
}

if ( ! function_exists('resizeThumbnailImage'))
{
    //You do not need to alter these functions
    function resizeThumbnailImage($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale){
            list($imagewidth, $imageheight, $imageType) = getimagesize($image);
            $imageType = image_type_to_mime_type($imageType);

            $newImageWidth = ceil($width * $scale);
            $newImageHeight = ceil($height * $scale);
            $newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
            switch($imageType) {
                    case "image/gif":
                            $source=imagecreatefromgif($image); 
                            break;
                case "image/pjpeg":
                    case "image/jpeg":
                    case "image/jpg":
                            $source=imagecreatefromjpeg($image); 
                            break;
                case "image/png":
                    case "image/x-png":
                            $source=imagecreatefrompng($image); 
                            break;
            }
            
            imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);
            $newImage = pixel_bleacher($newImage, $newImageWidth, $newImageHeight); 
	    
            $jpg_quality = 100;   
            
            switch($imageType) {
                    case "image/gif":
                            imagegif($newImage,$thumb_image_name); 
                            break;
            case "image/pjpeg":
                    case "image/jpeg":
                    case "image/jpg":
                            imagejpeg($newImage,$thumb_image_name,$jpg_quality); 
                            break;
                    case "image/png":
                    case "image/x-png":
                            $png_quality = 8;
                            imagepng($newImage,$thumb_image_name,$png_quality,PNG_ALL_FILTERS);  
                            break;
        }
            chmod($thumb_image_name, 0777);
            return $thumb_image_name;
    }
}

if ( ! function_exists('resizeThumbnailImage_jpgout'))
{
    //You do not need to alter these functions
    function resizeThumbnailImage_jpgout($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale){
            list($imagewidth, $imageheight, $imageType) = getimagesize($image);
            $imageType = image_type_to_mime_type($imageType);

            $newImageWidth = ceil($width * $scale);
            $newImageHeight = ceil($height * $scale);
            $newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
            switch($imageType) {
                    case "image/gif":
                            $source=imagecreatefromgif($image); 
                            $delete_old = 1;
                            break;
                case "image/pjpeg":
                    case "image/jpeg":
                    case "image/jpg":
                            $source=imagecreatefromjpeg($image);
                            $delete_old = 0; //final format will be jpg...no need to delete
                            break;
                case "image/png":
                    case "image/x-png":
                            $source=imagecreatefrompng($image); 
                            $delete_old = 1;
                            break;
            }
            
            imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);
          $jpg_quality = 95;   
          /*
              //temporary to add identifying text to each image for testing

            // White background and blue text
            $bg = imagecolorallocate($newImage, 255, 255, 255);
            $textcolor = imagecolorallocate($newImage, 0, 0, 255);

            // Write the string at the top left
            imagestring($newImage, 5, 0, 0, $imageType.'jpeg Q: -'.$jpg_quality, $textcolor);
            // end of temp code  
            */
            
            //convert to jpeg...first change name
            //adding the png extension onto the new image
            $new_image_name  = substr($thumb_image_name, 0, strrpos($thumb_image_name, '.')).".jpg";

            imagejpeg($newImage,$new_image_name,$jpg_quality);
            
            
            
            //destroy the image resource we created and no longer need
            imagedestroy($newImage);

            //if we created a new file to convert to jpg need to delete the old one.
             if ($delete_old == 1){
                    unlink($image);
             }

            chmod($new_image_name, 0777);
            return $new_image_name;
    }
}

if ( ! function_exists('getHeight'))
{
    //You do not need to alter these functions
    function getHeight($image) {
            $size = getimagesize($image);
            $height = $size[1];
            return $height;
    }
}

if ( ! function_exists('getWidth'))
{
    //You do not need to alter these functions
    function getWidth($image) {
            $size = getimagesize($image);
            $width = $size[0];
            return $width;
    }
}
//Added by BLC on 3/11/13
if ( ! function_exists('squarify'))
{
    function squarify($image,$max_dimension) {
        //get the dimensions of the image
        $size = getimagesize($image);
        $width = $size[0];
        $height = $size[1];
        
        //determine the longest side
        if ($width > $height){
            $max_dimension_num = $width;
        }else
        {
            $max_dimension_num = $height;
        }   

        //create the new square canvas based on the longest dimension
        $img_canvas = imagecreatetruecolor($max_dimension_num, $max_dimension_num);

        // set background to white
        $white = imagecolorallocate($img_canvas, 255, 255, 255);
        imagefill($img_canvas, 0, 0, $white);  
        
        //turn the file-based image into a 'resource' so we can work with it
        $im = imagecreatefromjpeg($image);
        
        //determine vertical position for centering the image in the canvas
        $new_y = ($max_dimension/2) - ($height/2);       
        if (!$new_y>0){$new_y = 0;}
        
        //TODO: what about horizontal centering?
        
        //copy the source image to the destination canvas
        //imagecopy($img_canvas,$im,0,$new_y,0,0,$width,$height);
        imagecopyresampled($img_canvas,$im,0,$new_y,0,0,$width,$height,$width,$height);
        
        $jpg_quality = 100;       
        
        
        //write the image to the filesystem, retaining the original location and name
        imagejpeg($img_canvas, $image,$jpg_quality); 

        //ensure the image has the correct permissions
        chmod($image, 0777);
        return $image;            

    }
}

if ( ! function_exists('squarify_lossless'))
{
    function squarify_lossless($image) {
        //get the dimensions of the image    
        $size = getimagesize($image);
        $width = $size[0];
        $height = $size[1];
        //$imageType = image_type_to_mime_type($size[2]);
        
        //determine the longest side
        if ($width > $height){
            $max_dimension_num = $width;
        }else
        {
            $max_dimension_num = $height;
        }   

        //create the new square canvas based on the longest dimension
        $img_canvas = imagecreatetruecolor($max_dimension_num, $max_dimension_num);

        // set background to white
        $white = imagecolorallocate($img_canvas, 255, 255, 255);
        imagefill($img_canvas, 0, 0, $white);  
        
        //turn the file-based image into a 'resource' so we can work with it
        //$im = imagecreatefromjpeg($image);
        $im = imagecreatefrompng($image);
        
        // Preserve alpha
        imagesavealpha($img_canvas, true);
        //$color = imagecolorallocatealpha($newImage, 0, 0, 0, 127); // Create transparent background                            
        $color = imagecolorallocate($img_canvas, 255, 255, 255); //create white background
        // Fill in background
        imagefill($img_canvas, 0, 0, $color);         
        
        //determine vertical position for centering the image in the canvas
        //$new_y = ($max_dimension/2) - ($height/2);  
        $new_y = ($max_dimension_num/2) - ($height/2);  
        if (!$new_y>0){$new_y = 0;}
        
        //TODO: what about horizontal centering?
        
        //copy the source image to the destination canvas
        //imagecopy($img_canvas,$im,0,$new_y,0,0,$width,$height);
        imagecopyresampled($img_canvas,$im,0,$new_y,0,0,$width,$height,$width,$height);
  
        //write the image to the filesystem, retaining the original location and name
        //imagejpeg($img_canvas, $image,$jpg_quality); 
        imagepng($img_canvas, $image, NULL, NULL);
        imagedestroy($img_canvas);

        //ensure the image has the correct permissions
        chmod($image, 0777);
        return $image;            

    }
}

if ( ! function_exists('pixel_bleacher'))
{
    function pixel_bleacher($newImage, $width, $height) {
        //resource: http://jasuten.com/background-noise-in-magento-image-resize/
        // Clean noise on white background images
        
            $colorWhite = imagecolorallocate($newImage,255,255,255);//resource
            //$processHeight = $dstHeight+$dstY;
            //$processWidth = $dstWidth+$dstX;
            //Travel y axis
            for($y=0; $y<($height); ++$y){
                // Travel x axis
                for($x=0; $x<($width); ++$x){
                    // Change pixel color
                    $colorat=imagecolorat($newImage, $x, $y);
                    $r = ($colorat >> 16) & 0xFF;
                    $g = ($colorat >> 8) & 0xFF;
                    $b = $colorat & 0xFF;
                    if(($r==253 && $g == 253 && $b ==253) || ($r==254 && $g == 254 && $b ==254)) {
                        imagesetpixel($newImage, $x, $y, $colorWhite);
                    }
                }
            }
            
            return $newImage;
        
    }
}