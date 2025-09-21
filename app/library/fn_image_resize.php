<?php namespace App\library {

class Fn_image_resize{

	function createThumb($path1, $path2, $file_type, $new_w, $new_h, $squareSize = ''){
		/* read the source image */
		$source_image = FALSE;
		
		if (preg_match("/jpg|JPG|jpeg|JPEG/", $file_type)) {
			$source_image = imagecreatefromjpeg($path1);
		}
		elseif (preg_match("/png|PNG/", $file_type)) {
			
			if (!$source_image = @imagecreatefrompng($path1)) {
				$source_image = imagecreatefromjpeg($path1);
			}
		}
		elseif (preg_match("/gif|GIF/", $file_type)) {
			$source_image = imagecreatefromgif($path1);
		}		
		if ($source_image == FALSE) {
			$source_image = imagecreatefromjpeg($path1);
		}
	
		$orig_w = imageSX($source_image);
		$orig_h = imageSY($source_image);
		
		if ($orig_w < $new_w && $orig_h < $new_h) {
			$desired_width = $orig_w;
			$desired_height = $orig_h;
		} else {
			if(!empty($new_w) && !empty($orig_w) && !empty($orig_h))
			{
            $scale = min($new_w / $orig_w, $new_h / $orig_h);
			$desired_width = ceil($scale * $orig_w);
			$desired_height = ceil($scale * $orig_h);
			}
		}
				
		if ($squareSize != '') {
			$desired_width = $desired_height = $squareSize;
		}
	
		/* create a new, "virtual" image */
		$virtual_image = imagecreatetruecolor($desired_width, $desired_height);
		// for PNG background white-----------
		$kek = imagecolorallocate($virtual_image, 255, 255, 255);
		imagefill($virtual_image, 0, 0, $kek);
		
		if ($squareSize == '') {
			/* copy source image at a resized size */
			imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $orig_w, $orig_h);
		} else {
			$wm = $orig_w / $squareSize;
			$hm = $orig_h / $squareSize;
			$h_height = $squareSize / 2;
			$w_height = $squareSize / 2;
			
			if ($orig_w > $orig_h) {
				$adjusted_width = $orig_w / $hm;
				$half_width = $adjusted_width / 2;
				$int_width = $half_width - $w_height;
				imagecopyresampled($virtual_image, $source_image, -$int_width, 0, 0, 0, $adjusted_width, $squareSize, $orig_w, $orig_h);
			}
	
			elseif (($orig_w <= $orig_h)) {
				$adjusted_height = $orig_h / $wm;
				$half_height = $adjusted_height / 2;
				imagecopyresampled($virtual_image, $source_image, 0,0, 0, 0, $squareSize, $adjusted_height, $orig_w, $orig_h);
			} else {
				imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $squareSize, $squareSize, $orig_w, $orig_h);
			}
		}
		
		if (@imagejpeg($virtual_image, $path2, 90)) {
			imagedestroy($virtual_image);
			imagedestroy($source_image);
			return TRUE;
		} else {
			return FALSE;
		}
	}
    
    function createCrop($target,$newcopy,$file_type, $w, $h) {
        
        list($w_orig, $h_orig) = getimagesize($target);
        $img = "";
        
        if (preg_match("/jpg|JPG|jpeg|JPEG/", $file_type)) {
            $img = imagecreatefromjpeg($target);
        }
		elseif (preg_match("/png|PNG/", $file_type)) {
			if (!$img = @imagecreatefrompng($target)) {
				$img = imagecreatefromjpeg($target);
			}
		}
		elseif (preg_match("/gif|GIF/", $file_type)) {
			$img = imagecreatefromgif($target);
		}
        else{
            $img = imagecreatefromjpeg($target);
        }

        $tci = imagecreatetruecolor($w, $h);
			$wm = $w_orig / $w;
			$hm = $h_orig / $h;
			$h_height = $h / 2;
			$w_height = $w / 2;
			
			if ($w_orig > $h_orig) {
				
				if($w>=$h){
					$adjusted_width = $w_orig / $wm;
				}
				else{
					$adjusted_width = $w_orig / $hm;
				}
				$half_width = $adjusted_width / 2;
				$int_width = $half_width - $w_height;
				imagecopyresampled($tci, $img, -$int_width, 0, 0, 0, $adjusted_width, $h, $w_orig, $h_orig);
			}
	
			elseif (($w_orig <= $h_orig)) {
				$adjusted_height = $h_orig / $wm;
				$half_height = $adjusted_height / 2;
				imagecopyresampled($tci, $img, 0,0, 0, 0, $w, $adjusted_height, $w_orig, $h_orig);
			} else {
				imagecopyresampled($tci, $img, 0, 0, 0, 0, $w, $h, $w_orig, $h_orig);
			}
        if (preg_match("/gif|GIF/", $file_type)){ 
            @imagegif($tci, $newcopy);
        } else if(preg_match("/png|PNG/", $file_type)){
            @imagepng($tci, $newcopy);
        } else { 
            @imagejpeg($tci, $newcopy, 90);
        }
    }
	
    function createWatermark($image_type,$image_temp,$destination_folderAndFileName,$watermark_png_file){
		
		switch(strtolower($image_type)){ //determine uploaded image type 
			//Create new image from file
			case 'image/png': 
				$image_resource =  imagecreatefrompng($image_temp);
				break;
			case 'image/gif':
				$image_resource =  imagecreatefromgif($image_temp);
				break;          
			case 'image/jpeg': case 'image/pjpeg':
				$image_resource = imagecreatefromjpeg($image_temp);
				break;
			default:
				$image_resource = false;
		}
		
		if($image_resource){
			//Copy and resize part of an image with resampling
			list($img_width, $img_height) = getimagesize($image_temp);
			
			//Construct a proportional size of new image
			$new_image_width    = $img_width;
			$new_image_height   = $img_height;
			$new_canvas         = imagecreatetruecolor($new_image_width , $new_image_height);
	
			if(imagecopyresampled($new_canvas, $image_resource , 0, 0, 0, 0, $new_image_width, $new_image_height, $img_width, $img_height))
			{
				
				//center watermark
				$watermark_left = ($new_image_width/2)-(400/2); //watermark left
				$watermark_bottom = ($new_image_height/2)-(100/2); //watermark bottom
	
				$watermark = imagecreatefrompng($watermark_png_file); //watermark image
				imagecopy($new_canvas, $watermark, $watermark_left, $watermark_bottom, 0, 0, 400, 100); //merge image
				
				//output image direcly on the browser.
				//header('Content-Type: image/jpeg');
				//imagejpeg($new_canvas, NULL , 90);
				
				//Or Save image to the folder
				imagejpeg($new_canvas, $destination_folderAndFileName , 90);
				
				//free up memory
				imagedestroy($new_canvas); 
				imagedestroy($image_resource);
				return true;
			}
			else{
				return false;
			}
		}
		else{
			return false;
		}
		
	}
}
}