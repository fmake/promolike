<?
require ('./libs/FController.php');
require './libs/login.php';
require('./modules/APIvk/vkapi.php');

if(!$user->isLogined()){
			header("HTTP/1.1 301 Moved Permanently");
			header('Location: /index.php');
}

require_once ("./libs/xajax_webmaster.php");

switch($request->action){
	case 'update_token_vk':
		$text_param = $request->getEscape('text_param_vk');
		preg_match_all('/access_token=(.*)&expires_in=(.*)&user_id=(.*)/',$text_param,$array_result);
		//printAr($array_result);
		$SocialUser = new fmakeSiteUser();
		
		$api_id = '2629628';
		$fmakeVk = new fmakeVkapi($api_id,$array_result[1][0]);
		$array_param = array('uids'=>$array_result[3][0]);
		$isuservk = $fmakeVk->desktop_api('users.get', $array_param);
		$result = $isuservk;
		if($result->error){
			$error_message = 'Неправильно скопировали строку.';
			$globalTemplateParam->set('error_message',$error_message);
		}
		else{
			$SocialUser->idField = "id";
			$SocialUser->table = $SocialUser->table_social;
			$SocialUser->setId($request->getEscape("id_us_to"));
			$SocialUser->addParam('uid',$array_result[3][0]);
			$SocialUser->addParam('tocken',$array_result[1][0]);
			$SocialUser->addParam('active',1);
			$SocialUser->update();
		}
		
	break;
}

/*социальные сети*/
$SocialUser = new fmakeSiteUser();
$active_socseti = $SocialUser->getActiveSocialUser($user->id);
/*социальные сети*/

$globalTemplateParam->set('active_socseti',$active_socseti);

$template = "webmaster/main.tpl";
$template = $twig->loadTemplate($template);
$template->display($globalTemplateParam->get());
?>