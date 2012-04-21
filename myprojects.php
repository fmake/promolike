<?
require('./libs/FController.php');
require './libs/login.php';
	
if(!$user->isLogined()){
			header("HTTP/1.1 301 Moved Permanently");
			header('Location: /index.php');
}

require './modules/APIvk/vkapi.php';

require_once ("./libs/xajax_project.php");

$fmakeFilter = new promoLike_filter();

$fmakeProject = new promoLike_project();
$fmakePage = new promoLike_page();
$projects = $fmakeProject->getAllProject($user->id);
$size = sizeof($projects);

$globalTemplateParam->set('projects',$projects);
//$globalTemplateParam->set('pages',$pages);
$globalTemplateParam->set('fmakeFilter',$fmakeFilter);

$template = "project/index.tpl";
$template = $twig->loadTemplate($template);
$template->display($globalTemplateParam->get());
?>