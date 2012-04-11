<?
require ('./libs/FController.php');
require './libs/login.php';

if(!$user->isLogined()){
			header("HTTP/1.1 301 Moved Permanently");
			header('Location: /index.php');
}

require './modules/APIvk/vkapi.php';
$api_id = '2629628';

$SocialUser = new fmakeSiteUser();

switch($request->action){
	case 'register_vk':
		$text_param = $request->getEscape('text_param_vk');
		preg_match_all('/access_token=(.*)&expires_in=(.*)&user_id=(.*)/',$text_param,$array_result);
		//printAr($array_result);
		$SocialUser = new fmakeSiteUser();
		$SocialUser->table = $SocialUser->table_social;
		$SocialUser->addParam($SocialUser->idField,$user->id);
		$SocialUser->addParam('id_social_set','2');
		$SocialUser->addParam('uid',$array_result[3][0]);
		$SocialUser->addParam('tocken',$array_result[1][0]);
		$SocialUser->newItem();
	break;
	case 'send_message_vk':
		$params_user_vk = $SocialUser->getUserSocialParam($user->id,2);
		$vk = new fmakeVkapi($api_id,$params_user_vk['tocken']);
		$message = urlencode($request->getEscape('text_message_vk'));
		$array_param = array('owner_id'=>$params_user_vk['uid'],'message'=>$message);
		
		if($request->getEscape('photo_message_vk')){
			$photo_vk_wall_messages = $vk->desktop_api('photos.getWallUploadServer', array('uid'=>$params_user_vk['uid']));
			$resp = $photo_vk_wall_messages->response;
			
			$ch = curl_init($resp->upload_url);  
			curl_setopt($ch, CURLOPT_POST, 1);
			$filename = '@'.ROOT.'/images/Koala.jpg';
			curl_setopt($ch, CURLOPT_POSTFIELDS, array('photo'=>"".$filename));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$result = curl_exec($ch);
			curl_close($ch);
			$result = json_decode($result);
			//printAr($result);
			$photo_vk_upload = $vk->desktop_api('photos.saveWallPhoto', array('server'=>$result->server,'photo'=>$result->photo,'hash'=>$result->hash));
			//printAr($photo_vk_upload);
			$photo_params = $photo_vk_upload->response[0];
			$array_param['attachments'] = $photo_params->id.',';
		}
		if($request->getEscape('link_message_vk')) $array_param['attachments'] .= $request->getEscape('link_message_vk');
		
		$send_vk_wall_messages = $vk->desktop_api('wall.post', $array_param);
		//printAr($send_vk_wall_messages);
	break;
}
/*---------------vk.ru-------------------*/
$params_user_vk = $SocialUser->getUserSocialParam($user->id,2);
$vk = new fmakeVkapi($api_id,$params_user_vk['tocken']);
$error = $vk->isUserTokenVK($api_id, $user->id, 2);
if($error->error){
	switch($error->error['error_code']){
		case '5':
			$error_stat = true;
			$globalTemplateParam->set('error_stat',$error_stat);
			break;
		default:
			$error_stat = true;
			$globalTemplateParam->set('error_stat',$error_stat);
			break;
	}
}
else{
	$array_vk_user = $vk->desktop_api('getProfiles', array('uids'=>$params_user_vk['uid'],'fields'=>'first_name,last_name,nickname,photo'));
	$array_vk_friends = $vk->desktop_api('friends.get', array('uids'=>$params_user_vk['uid']));
	$array_vk_wall_messages = $vk->desktop_api('wall.get', array('owner_id'=>$params_user_vk['uid']));
	$globalTemplateParam->set('params_user_vk',$params_user_vk); 
	$globalTemplateParam->set('params_user_friend_count',sizeof($array_vk_friends->response)); 
	$globalTemplateParam->set('array_vk_user',$array_vk_user->response[0]); 
	$globalTemplateParam->set('count_vk_message',$array_vk_wall_messages->response[0]);
}
/*---------------vk.ru-------------------*/
/*---------------twitter.com-------------------*/
$params_user_tw = $SocialUser->getUserSocialParam($user->id,3);
//printAr($params_user_tw);
if($params_user_tw['tocken'] && $params_user_tw['secret_tocken']){
	$globalTemplateParam->set('params_user_tw',$params_user_tw);
}
else{
	$twitter_reg = "http://".$hostname."/twitter.php?action=link";
	$globalTemplateParam->set('twitter_reg',$twitter_reg);
}
/*---------------twitter.com-------------------*/
 

$template = "webmaster/main2.tpl";
$template = $twig->loadTemplate($template);
$template->display($globalTemplateParam->get());
?>