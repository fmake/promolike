<?php
	//include 'api.watermark.php';
	function wantermark_images($image){
		$watermark = new absImages($image);
		//$watermark->wantermark_text("www.zachetov.net", $font, $r, $g, $b)
		$watermark->wantermark_text('www.zachetov.net', '/images/fonts/tahoma.ttf', 0, 0, 0);
		//$watermark_img = "watermark.png";
		//$image = "main.jpg";
		//$main_img_obj = imagecreatefromjpeg($image);
		//$watermark_img_obj	= imagecreatefrompng($watermark_img);
		//$return_img_obj			= $watermark->create_watermark( $main_img_obj, $watermark_img_obj, 66 );
		//imagejpeg( $return_img_obj,$image, 50 );
	}
	
	//$url=MODX_BASE_PATH."assets/images/catalog/";
	$url = "images/books_gdz";
	function find_pictures($url){
		if (is_dir($url)){
			if($dir  = opendir($url)){
				while($file = readdir($dir)){
					echo '<pre>'.$file.'</pre>';
					if(!is_dir($url."/".$file)){
						if ($file  != "." && $file != ".."){
							wantermark_images($url."/".$file);
						} 						
					}
					else if ($file  != "." && $file != "..") find_pictures($url."/".$file);
				}
			}
		}
	}
echo('ku');
	//find_pictures($url);
?>