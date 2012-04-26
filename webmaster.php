<?
require ('./libs/FController.php');
require './libs/login.php';

if(!$user->isLogined()){
			header("HTTP/1.1 301 Moved Permanently");
			header('Location: /index.php');
}

require_once ("./libs/xajax_webmaster.php");

/*социальные сети*/
$SocialUser = new fmakeSiteUser();
$active_socseti = $SocialUser->getActiveSocialUser($user->id);
/*социальные сети*/

$globalTemplateParam->set('active_socseti',$active_socseti);

$template = "webmaster/main.tpl";
$template = $twig->loadTemplate($template);
$template->display($globalTemplateParam->get());
?>