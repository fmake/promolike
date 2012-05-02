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

$id = $user->id;
$api_id = '2629628';

$user_object = new fmakeSiteUser();
$object_likes_from_db = new promoLike_like();
printAr($object_likes_from_db);
$array_likes = $object_likes_from_db->getAllNewLikes($id);

printAr($array_likes);

$user_params = $user_object->getUserSocialParam($id, 2);
$user_token = $user_params['tocken'];

$api_object = new fmakeVkapi($api_id, $user_token);

printAr($user_token);

/*
$globalTemplateParam->set('payments',$payments);

$template = "lk/main.tpl";
$template = $twig->loadTemplate($template);
$template->display($globalTemplateParam->get());
*/
?>
