<?
require('./libs/FController.php');
require './libs/login.php';
	
if(!$user->isLogined()){
			header("HTTP/1.1 301 Moved Permanently");
			header('Location: /index.php');
}

require './modules/APIvk/vkapi.php';

require_once ("./libs/xajax_project.php");

//$fmakeFilter = new promoLike_filter();

$fmakeProject = new promoLike_project();
$fmakePage = new promoLike_page();
$projects = $fmakeProject->getAllProject($user->id);
//$size = sizeof($projects);

$fmakeLike = new promoLike_like();

if($projects)foreach ($projects as $key=>$item){
	$count_like = $fmakeLike->getQuery("(`status`='3' OR `status`='4') AND `id_place`!='0' AND `{$fmakePage->idField}` in (SELECT `{$fmakePage->idField}` FROM `{$fmakePage->table}` WHERE `{$fmakeProject->idField}`='{$item[$fmakeProject->idField]}')","COUNT(*)",true);
	$projects[$key]['stat']['count_like'] = ($count_like[0]['COUNT(*)'])? $count_like[0]['COUNT(*)']:0;
	$count_zayavka = $fmakeLike->getQuery("(`status`='1' OR `status`='2') AND `id_place`!='0' AND `{$fmakePage->idField}` in (SELECT `{$fmakePage->idField}` FROM `{$fmakePage->table}` WHERE `{$fmakeProject->idField}`='{$item[$fmakeProject->idField]}')","COUNT(*)",true);
	$projects[$key]['stat']['count_zayavka'] = ($count_zayavka[0]['COUNT(*)'])? $count_zayavka[0]['COUNT(*)']:0;
}

$globalTemplateParam->set('projects',$projects);
//$globalTemplateParam->set('pages',$pages);
//$globalTemplateParam->set('fmakeFilter',$fmakeFilter);

$template = "project/index.tpl";
$template = $twig->loadTemplate($template);
$template->display($globalTemplateParam->get());
?>