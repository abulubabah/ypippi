<?php
include_once("image.php");
include_once("uploader.php");
class Resize {
    public function ubah($filename,$width,$height){
        
        if (!is_file(DIR_PICTURE . $filename)) {
			return;
		}
		
        $validasi=new Validasi();
		$extension = pathinfo($filename, PATHINFO_EXTENSION);
        
		$image_old = $filename;
		$filename=$validasi->clean($filename);
        $filename=$validasi->gantiSpasi($filename);
		$image_new = $filename . '-' . (int)$width . 'x' . (int)$height . '.' . $extension;

		if (!is_file(DIR_IMAGECACHE.$image_new)) {
			list($width_orig, $height_orig, $image_type) = getimagesize(DIR_PICTURE . $image_old);
				 
			if (!in_array($image_type, array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF))) { 
				return DIR_PICTURE . $image_old;
			}

			if ($width_orig != $width || $height_orig != $height) {
				$image = new Image(DIR_PICTURE . $image_old);
				$image->resize($width, $height,'w');
				$image->save(DIR_IMAGECACHE . $image_new);

			} else {
				copy(DIR_PICTURE . $image_old, DIR_IMAGECACHE . $image_new);
			}
		}
		
		$image_new = str_replace(' ', '%20', $image_new);
		
		return '//www.ypippijkt.localhost/cms/imagecache/' . $image_new;
		
    }
    
    private function UR_exists($url){
       $headers=get_headers($url);
       return stripos($headers[0],"200 OK")?true:false;
    }
}