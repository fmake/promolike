<?php
require ('./libs/FController.php');
require './libs/login.php';

if(!$user->isLogined()){
			header("HTTP/1.1 301 Moved Permanently");
			header('Location: /index.php');
}

/*-------активность главного меню--------*/
$active_menu = 0;
$globalTemplateParam->set('active_menu',$active_menu);
/*-------активность главного меню--------*/


$globalTemplateParam->set('qqq',$qqq);
$globalTemplateParam->set('payments',$payments);

$template = "lk/main.tpl";
$template = $twig->loadTemplate($template);
$template->display($globalTemplateParam->get());
