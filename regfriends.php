<?
require('./libs/FController.php');
require './libs/login.php';
	
/*if(!$user->isLogined()){
			header("HTTP/1.1 301 Moved Permanently");
			header('Location: /index.php');
}*/

switch($request->action){
	case 'register_vk':
		$text_param = $request->getEscape('text_param_vk');
		preg_match_all('/access_token=(.*)&expires_in=(.*)&user_id=(.*)/',$text_param,$array_result);
		//printAr($array_result);
		$SocialUser = new fmakeSiteUser();
		
		$api_id = '2629628';
		$fmakeVk = new fmakeVkapi($api_id,$array_result[1][0]);
		$array_param = array('uids'=>$array_result[3][0]);
		$isuservk = $this->desktop_api('users.get', $array_param);
		$result = $isuservk;
		if($result->error){
			$error_message = 'Неправильно скопировали строку.';
			$globalTemplateParam->set('error_message',$error_message);
		}
		else{
			if(!$SocialUser->isUserSocSetDuble($array_result[3][0],2)){
				$SocialUser->table = $SocialUser->table_social;
				//$SocialUser->addParam($SocialUser->idField,$user->id);
				$SocialUser->addParam('id_social_set','2');
				$SocialUser->addParam('uid',$array_result[3][0]);
				$SocialUser->addParam('tocken',$array_result[1][0]);
				$SocialUser->newItem();
			}
			else{
				$error_message = 'Пользователь с этой учетной записью уже зарегистрирован в системе.';
				$globalTemplateParam->set('error_message',$error_message);
			}
		}
		
	break;
}
if($request->error){
	$error_message = '<script>
							alert("пользователь с этой учетной записью уже зарегистрирован в системе");
						</script>';
	$globalTemplateParam->set('error_message',$error_message);
}

$template = "webmaster/regfriend.tpl";
$template = $twig->loadTemplate($template);
$template->display($globalTemplateParam->get());
?>