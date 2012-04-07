<?php
//ini_set('display_errors',1);
//error_reporting(7);
require('../../libs/FController.php');

$image = new fmakeGalleryImage();
if($_POST['action']=="edit"){
	$result = $image->editImageParams($_POST['id_gallery'],$_POST['image'],$_POST['title']);
	echo('<div id="qq"><p>qwerty12304</p></div>');
}
else{
	$result = $image->getImageParams($_POST['id_gallery'],$_POST['image']);
	//printAr($result);
	//echo("<div>".$result['']."</div>");
}
?>