<?
require ('./libs/FController.php');
require './libs/login.php';

if(!$user->isLogined()){
			header("HTTP/1.1 301 Moved Permanently");
			header('Location: /index.php');
}

/*---------------------xajax---------------------------------*/

require_once ("./libs/xajax/xajax_core/xajax.inc.php");

$xajax = new xajax();
$xajax->configure('decodeUTF8Input',true);
//$xajax->configure('debug',true);
$xajax->configure('javascript URI','./libs/xajax/');
$xajax->register(XAJAX_FUNCTION,"changeFormsSocseti");

function changeFormsSocseti($id_socset){
	
	switch ($id_socset){
		case 1://fasebook
			break;
		case 2://vk.com
			$text = '<tr>
						<td class="middle" >
							Ссылка для регистрации
						</td>
						<td class="middle" >
							<a href="http://api.vk.com/oauth/authorize?client_id=2675562&redirect_uri=http://api.vk.com/blank.html&scope=1008191&display=page&response_type=token" target="_blank">Авторизация в Vkontakte.ru</a>
						</td>
					</tr>
					<tr>
						<td class="middle" >
							Параметры
						</td>
						<td class="middle" >
							<input type="hidden" name="action" value="register_vk">
							<input type="text" name="text_param_vk">
						</td>
					</tr>
					<tr>
						<td>
							
						</td>
						<td align="right">
							<a href="./" onclick="$(\'#form_create_socialnetwork\').submit();return false;" class="btn primary-padding"><span class="f20 primary-green" ><span >Добавить</span></span></a>
						</td>
					</tr>';
			break;
		case 3://twitter.com
			$text = '<tr>
						<td class="middle" >
							Ссылка для регистрации
						</td>
						<td class="middle" >
							<a href="/twitter.php?action=link">Авторизация в Twitter.com</a>
						</td>
					</tr>';
			break;
		default:
			$text = '';
			break;
	}
	
	$objResponse = new xajaxResponse();
	$objResponse->assign("create_socialnetwork_params","innerHTML", $text);
	return $objResponse;
}

$xajax->processRequest();
$globalTemplateParam->set('xajax',$xajax);

/*---------------------xajax---------------------------------*/

/*-------активность главного меню--------*/
$active_menu = 1;
$globalTemplateParam->set('active_menu',$active_menu);
/*-------активность главного меню--------*/


switch($request->action){
	case 'register_vk':
		$text_param = $request->getEscape('text_param_vk');
		preg_match_all('/access_token=(.*)&expires_in=(.*)&user_id=(.*)/',$text_param,$array_result);
		//printAr($array_result);
		$SocialUser = new fmakeSiteUser();
		if(!$SocialUser->isUserSocSetDuble($array_result[3][0],2)){
			$SocialUser->table = $SocialUser->table_social;
			$SocialUser->addParam($SocialUser->idField,$user->id);
			$SocialUser->addParam('id_social_set','2');
			$SocialUser->addParam('uid',$array_result[3][0]);
			$SocialUser->addParam('tocken',$array_result[1][0]);
			$SocialUser->newItem();
		}
		else{
			$error_message = '<script>
									alert("пользователь с этой учетной записью уже зарегистрирован в системе");
								</script>';
			$globalTemplateParam->set('error_message',$error_message);
		}
		
	break;
}
if($request->error){
	$error_message = '<script>
							alert("пользователь с этой учетной записью уже зарегистрирован в системе");
						</script>';
	$globalTemplateParam->set('error_message',$error_message);
}

/*социальные сети*/
$SocialUser = new fmakeSiteUser();
$SocialSet = new promoLike_socialset();
$SocialSet->table = $SocialSet->table_name;
$full_soc_set = $SocialSet->getAll(true);
foreach ($full_soc_set as $key=>$item){
	$full_soc_set[$key]['_active'] = $SocialUser->isUserSocSetDB($user->id,$item[$SocialSet->idField]);
}
/*социальные сети*/

$globalTemplateParam->set('full_soc_set',$full_soc_set);

$template = "webmaster/creater.tpl";
$template = $twig->loadTemplate($template);
$template->display($globalTemplateParam->get());
?>