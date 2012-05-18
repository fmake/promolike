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

//$id = $user->id;
$id = 5;
$api_id = '2629628';

$user_object = new fmakeSiteUser();
$object_likes_from_db = new promoLike_like();

$array_likes = $object_likes_from_db->getAllNewLikes($id);

printAr($array_likes);

$user_params = $user_object->getUserSocialParam($id, 2);
$user_token = $user_params['tocken'];

require './modules/APIvk/vkapi.php';
$api_object = new fmakeVkapi($api_id, $user_token);

$k = $api_object->desktop_api('wall.get ', array('count' => 3, 'filter' => 'owner'));
//$k = $api_object->desktop_api('wall.get ');

printAr($k);

/*
$globalTemplateParam->set('payments',$payments);

$template = "lk/main.tpl";
$template = $twig->loadTemplate($template);
$template->display($globalTemplateParam->get());
*/
?>
