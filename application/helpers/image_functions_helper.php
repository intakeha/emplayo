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
            imagejpeg($newImage, $new_image_name,90); 

            //if we created a new file to convert to jpeg need to delete the old one.
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
            switch($imageType) {
                    case "image/gif":
                            imagegif($newImage,$thumb_image_name); 
                            break;
            case "image/pjpeg":
                    case "image/jpeg":
                    case "image/jpg":
                            imagejpeg($newImage,$thumb_image_name,90); 
                            break;
                    case "image/png":
                    case "image/x-png":
                            imagepng($newImage,$thumb_image_name);  
                            break;
        }
            chmod($thumb_image_name, 0777);
            return $thumb_image_name;
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
    //You do not need to alter these functions
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
        
        //copy the source image to the destination canvas
        imagecopy($img_canvas,$im,0,$new_y,0,0,$width,$height);

        //write the image to the filesystem, retaining the original location and name
        imagejpeg($img_canvas, $image,90); 

        //ensure the image has the correct permissions
        chmod($image, 0777);
        return $image;            

    }
}