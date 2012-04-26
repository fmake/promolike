<?php
//$images = new absImages();
require_once('ImageMaker.php');
$images = new ImageMaker(ROOT.'/libs/ImageMaker/catalog/main.jpg');
//$images->wantermark_te('watermark.png');
//$images->wantermark_text('www.zachetov.net', 'tahoma.ttf', 0, 0, 0);
$images->resize(100,50,true,false,'','png');
//echo("ok");
exit;


?>