<?php

	# include our watermerking class
	include 'api.watermark.php';
	$watermark = new watermark();

	# create image objects using our user-specified images
	# NOTE: we're just going to assume we're dealing with a JPG and a PNG here - for example purposes
	$main_img_obj = imagecreatefromjpeg(	$_GET['main']			);
	$watermark_img_obj	= imagecreatefrompng(	$_GET['watermark']	);

	# create our watermarked image - set 66% alpha transparency for our watermark
	$return_img_obj = $watermark->create_watermark( $main_img_obj, $watermark_img_obj, 66 );
	

	# display our watermarked image - first telling the browser that it's a JPEG, 
	# and that it should be displayed inline
	header( 'Content-Type: image/jpeg' );
	header( 'Content-Disposition: inline; filename=' . $_GET['src'] );
	imagejpeg( $return_img_obj, '', 50 );

?>