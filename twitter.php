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

$consumer_key = "EU5xpg2baBbwuA4P0Kb1nQ";
$consumer_secret = "dYhTyNUEo4XHWim2dvDGZreB5FYKwSavjUgizyQ0E";
$callback_url = "http://".$hostname."/twitter.php";

//$globalConfigsTwitter = new globalConfigs();


switch($_GET['action']){
	case 'link':
		//$globalConfigsTwitter = new globalConfigs();
		$oauth = new TwitterOAuth($consumer_key, $consumer_secret);
		// получаем временные ключи для получения PIN'а
		$token = $oauth->getRequestToken($callback_url);
		$request_token = $token['oauth_token'];
		$request_token_secret = $token['oauth_token_secret'];
		
		// сохраняем их во временную переменную
				
		SetCookie("request_token",$request_token,time()+3600);
		SetCookie("request_token_secret",$request_token_secret,time()+3600);
		
		//$globalConfigsTwitter ->udateByValue('token_twitter_temp', $request_token);
		//$globalConfigsTwitter ->udateByValue('token_secret_twitter_temp', $request_token_secret);
		
		//echo("token = ".$request_token."<br/> secret_token = ".$request_token_secret."<br/>");
		// а теперь создаем ссылку для получения PIN'а
		$request_link = $oauth->getAuthorizeURL($token);

		// и на этом этапе заканчиваем выполнение скрипта
		// выведя необходимую ссылку
		//die("Перейдите по ссылке: <a href=\"{$request_link}\" >авторизация в Twitter</a> \n");
		if($request_link){
			header("HTTP/1.1 301 Moved Permanently");
			header('Location: '.$request_link);
		}
		break;
	case 'post_message':
		$id_user = intval($_GET['id_user']);
		$id_soc_set = intval($_GET['id_soc_set']);
		$id_textlike = $_GET['id_textlike'];
		$user_params = $SocialUser->getUserSocialParam($id_user,3);
		if($user_params['tocken'] && $user_params['secret_tocken'] && $_GET['key']=='1029384756' && $_GET['id_textlike']){
			$access_token = $user_params['tocken'];
			$access_token_secret = $user_params['secret_tocken'];
			// А теперь можно проверить
			$twitter = new TwitterOAuth($consumer_key,$consumer_secret,$access_token,$access_token_secret);
			
			
			$fmakeTextLike = new promoLike_textlike();
			$fmakePage = new promoLike_page();
			$fmakeTextLike->setId($id_textlike);
			$textlike = $fmakeTextLike->getInfo();
			$fmakePage->setId($textlike[$fmakePage->idField]);
			$page = $fmakePage->getInfo();
			
			/*параметры твита*/
			$link = $page['url'];
			$text = $textlike['text_like'];
			
			$params = array("status"=>$text." ".$link);
			/*параметры твита*/
			
			$result = $twitter->post("statuses/update",$params);   
			//printAr($result);
		}
		break;
	case 'get_posts_wall':
		$id_user = intval($_GET['id_user']);
		$id_soc_set = intval($_GET['id_soc_set']);
		//$id_like = $_GET['id_like'];
		$user_params = $SocialUser->getUserSocialParam($id_user,3);
		if($user_params['tocken'] && $user_params['secret_tocken'] && $_GET['key']=='1029384756'){
			$access_token = $user_params['tocken'];
			$access_token_secret = $user_params['secret_tocken'];
			// А теперь можно проверить
			$twitter = new TwitterOAuth($consumer_key,$consumer_secret,$access_token,$access_token_secret);
			
			
			/*параметры твита*/
			//$link = $page['url'];
			//$text = $textlike['text_like'];
			
			$params = array("include_entities"=>true,"screen_name"=>$user_params['nickname'],"count"=>100);
			/*параметры твита*/
			
			$result = $twitter->get("statuses/user_timeline",$params);  
			echo json_encode($result);
			//printAr($result);
		}
		break;
}
if($_GET['oauth_verifier'] && $_GET['oauth_token']){
	// сначала получим сохраненные временные ключи
	
	//$params_user_tw = $SocialUser->getUserSocialParam($user->id,3);
	
	$request_token = $_COOKIE['request_token'];
	$request_token_secret = $_COOKIE['request_token_secret'];
	$pin = $_GET['oauth_verifier'];
	// создаем объект авторизации, третим и четвертым параметром
	// передаем временные ключи авторизации
	$oauth = new TwitterOAuth($consumer_key, $consumer_secret,
	$request_token, $request_token_secret);
	 
	
	// получаем постоянные ключи авторизации
	// используя PIN
	
	$request = $oauth->getAccessToken($pin);
	 
	$access_token = $request['oauth_token'];
	$access_token_secret = $request['oauth_token_secret'];
	 
	//$globalConfigsTwitter ->udateByValue('request_token_twitter', $access_token);
	//$globalConfigsTwitter ->udateByValue('request_token_secret_twitter', $access_token_secret);
	
	// А теперь можно проверить
	$twitter = new TwitterOAuth($consumer_key, $consumer_secret,
	$access_token, $access_token_secret);
	 
	$credentials = $oauth->get("account/verify_credentials");   
	 
	 // сохраняем токен в таблицу
	
	
	 //$globalConfigsTwitter ->udateByValue('user_twitter', $credentials->screen_name);
	if(!$SocialUser->isUserSocSetDuble($credentials->screen_name,3)){
		$SocialUser->table = $SocialUser->table_social;
		$SocialUser->addParam($SocialUser->idField,$user->id);
		$SocialUser->addParam('id_social_set','3');
		$SocialUser->addParam('nickname',$credentials->screen_name);
		$SocialUser->addParam('tocken',$access_token);
		$SocialUser->addParam('secret_tocken',$access_token_secret);
		$SocialUser->newItem();
		header("HTTP/1.1 301 Moved Permanently");
		header('Location: http://'.$hostname.'/webmaster.php');
	}
	else{
		header("HTTP/1.1 301 Moved Permanently");
		header('Location: http://'.$hostname.'/webmaster-creater.php?error=1');
	}
	//echo "Вы аторизовались под ником: @". $credentials->screen_name ."\n"; 
} 

