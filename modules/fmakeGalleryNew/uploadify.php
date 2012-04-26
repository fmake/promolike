<?php
/*
Uploadify v3.0.0
Copyright (c) 2010 Ronnie Garcia, Travis Nickels
*/

require('../../libs/FController.php');
ini_set('memory_limit','128M' );
$targetFolder = '/images/galleries/'; // Relative to the root
$id=$_GET[id_gallery];
if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder.$id.'/';
	$targetFile = $targetPath . $_FILES['Filedata']['name'];
	$targetFileThumb = $targetPath .'thumbs/'. $_FILES['Filedata']['name'];
	
	if (!file_exists($targetPath))
	{
		mkdir($targetPath, 0777);
		mkdir($targetPath . 'thumbs/', 0777);
	}
		
	// Validate the file type
	$fileTypes = array('jpg','jpeg','gif','png'); // File extensions
	$name_image = $_FILES['Filedata']['name'];
	$fileParts = pathinfo($_FILES['Filedata']['name']);
	if (in_array($fileParts['extension'],$fileTypes)) {
		$item_photo = new fmakeGalleryNew_Image();
		$item_photo->addPreviewFoto($_FILES['Filedata'], $id);
		if(!$item_photo->isPhoto($name_image,$id)){
			$item_photo->addParam('id_catalog',$id);
			$item_photo->addParam('image',$name_image);
			$item_photo->newItem();
		}

	} else {
		echo 'Invalid file type.';
	}
}
?>