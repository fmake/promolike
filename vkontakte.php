<?
header('Content-type: text/html; charset=utf-8'); 

setlocale(LC_ALL, 'ru_RU.UTF-8');
mb_internal_encoding('UTF-8');

ini_set('display_errors',1);
error_reporting(7);
session_start();

require('./libs/FController.php');

require './libs/login.php';
	
if(!$user->isLogined()){
			header("HTTP/1.1 301 Moved Permanently");
			header('Location: /index.php');
}

$SocialUser = new fmakeSiteUser();

require './modules/APIvk/vkapi.php';
$api_id = '2629628';
$id_user = intval($_GET['id_user']);
$id_soc_set = intval($_GET['id_soc_set']);
$id_textlike = intval($_GET['id_textlike']);
switch($_GET['action']){
	case 'send_message_vk':
		$vk = new fmakeVkapi();
		$fmakeTextLike = new promoLike_textlike();
		$fmakePage = new promoLike_page();
		$fmakeTextLike->setId($id_textlike);
		$textlike = $fmakeTextLike->getInfo();
		$fmakePage->setId($textlike[$fmakePage->idField]);
		$page = $fmakePage->getInfo();
		if($id_user && $id_soc_set && $textlike && $page) $result = $vk->SendMessageWall($api_id, $id_user, $id_soc_set, $textlike, $page['url']);
		else $result = array('error'=>'неполная информация на входе');
	break;
}
//test.promolike.ru/vkontakte.php?id_user=5&id_soc_set=2&id_textlike=1&action=send_message_vk
echo json_encode($result);
//return $result;