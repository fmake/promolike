<?
header('Content-type: text/html; charset=utf-8'); 
session_start();

ini_set('display_errors',1);
ini_set('memory_limit','128M' );
error_reporting(7);
require_once('../libs/FController.php');
	set_include_path(
		get_include_path().PATH_SEPARATOR
		.ROOT.DIRECTORY_SEPARATOR.'admin'.PATH_SEPARATOR
		.ROOT.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'core'.PATH_SEPARATOR
		.ROOT.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'modules'.PATH_SEPARATOR
		.ROOT.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'includes'.PATH_SEPARATOR
		.ROOT.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'blocks'.PATH_SEPARATOR
		.ROOT.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'classes'.PATH_SEPARATOR
	);

$modulObj = new fmakeAdminController();

require_once('checklogin.php');


$mod = $modulObj->getModul( $admin->getRole(),$request->modul);

include 'modulNamespace.php';

$template = "admin/main";

// Проверка пользователя
if(!$mod) {
	$content = "Недоступна для данного типа пользователь: {$modulObj->getUserObj()->login}";
	echo $content;
	exit(); 
}else{

	$block = $mod['template'];	
	if($block){
		$block = "admin/main_template/".$block;
	}else{
		$block = "admin/main_template/simple_table";
	}
	
	if($mod['file']){
		include($mod['file'].'.php');
	}
	
}

if($admin->acces == 'God'){
	$admin->acces = false;
}
$modulObj->id = $mod['id'];
$menu = $modulObj->_getAllForMenu(0,true,false,$admin->getRole(),$q=false,$flag=true);

$tpl = new utlTemplate();
$tpl->display_file($template);


?>