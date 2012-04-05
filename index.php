<?php
require('./libs/FController.php');
require './libs/login.php';

if($user->isLogined()){
			header("HTTP/1.1 301 Moved Permanently");
			header('Location: /myprojects.php');
}



$template = "base/index.tpl";
$template = $twig->loadTemplate($template);
$template->display($globalTemplateParam->get()); 
?>