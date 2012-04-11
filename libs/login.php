<?php
/**
 * залогиневание пользователя
 */

$user = new fmakeSiteUser();
// если был залогинен, то загружаем его данные
$user -> load();


if(!$user->isLogined() && $_COOKIE['email']){
	$email = $request->getEscapeVal( $_COOKIE['c_email'] );
	$autication = $request->getEscapeVal( $_COOKIE['c_autication'] );
	if( $user->loginCokie($email, $autication)){
		//echo "Залогинен через куку";
		$message['login'] = 'Залогинен через куку';
	}
}
//printAr($user->isLogined());

switch ($request->action){
	case 'login':
		
		// если уже залогинен
		if($user->isLogined()){
			break;
		}
		
		if( $user->login($request->getEscape('email'), $request->password) ){
			
		 	//echo "Вошел";
		 	$message['login'] = 'Вы вошли';
		 	if($request->save){
		 		$cookies = $user -> getAutication($request->email."_cookies");
		 		$user->addParam('cookies', $cookies );
		 		setcookie("c_email", $request->getEscape('email'),time()+3600*24*15,"/");
				setcookie("c_autication", $cookies,time()+3600*24*15,"/");				
		 	}

		}else{
			$error['password'] = "Неверный логин - пароль";
			$globalTemplateParam->set('error', $error);
		}
		
	break;
	case 'logout':
		
		// если не залогинен
		if(!$user->isLogined()){
			header('Location: /');
			break;
		}
		
		$user->logout();
	  	setcookie("c_email",'',time()-3600*24*60,"/");
		setcookie("c_autication",'',time()-3600*24*60,"/");
		header('Location: /');
		
	break;
}
if($user->id){
	$fmakeSiteUser = new fmakeSiteUser();
	$fmakeSiteUser->setId($user->id);
	$user_params = $fmakeSiteUser->getInfo();
}

$globalTemplateParam->set('user', $user);
$globalTemplateParam->set('user_params', $user_params);


	