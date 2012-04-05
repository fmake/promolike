<?php
//
// jQuery File Tree PHP Connector
//

define('ROOT', realpath(dirname(__FILE__).'/..'));

$_POST['dir'] = urldecode($_POST['dir']);

$f = fopen("qq.txt","w+");
fwrite($f,$_POST['dir']);

if( file_exists(ROOT . $_POST['dir']) ) {
	$files = scandir(ROOT . $_POST['dir']);
	natcasesort($files);
	if( count($files) > 2 ) { /* The 2 accounts for . and .. */
		$str =  "<ul class=\"jqueryFileTree\" style=\"display: none;\">";
		// All dirs
		foreach( $files as $file ) {
			if( file_exists(ROOT . $_POST['dir'] . $file) && $file != '.' && $file != '..' && is_dir(ROOT . $_POST['dir'] . $file) ) {
				$str .= "<li class=\"directory collapsed\"><a href=\"#\" rel=\"" . htmlentities($_POST['dir'] . $file) . "/\">" . htmlentities($file) . "</a></li>";
			}
		}
		// All files
		foreach( $files as $file ) {
			if( file_exists(ROOT . $_POST['dir'] . $file) && $file != '.' && $file != '..' && !is_dir(ROOT . $_POST['dir'] . $file) ) {
				$ext = preg_replace('/^.*\./', '', $file);
				$str .= "<li class=\"file ext_$ext\"><a href=\"#\" rel=\"" . htmlentities($_POST['dir'] . $file) . "\">" . htmlentities($file) . "</a></li>";
			}
		}
		$str .= "</ul>";	
	}
}
	echo $str;
	fwrite($f,$str);
?>