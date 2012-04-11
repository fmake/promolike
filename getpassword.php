<?
require('./libs/FController.php');

switch ($request->action){
	case 'getpassword':
		$userObj = new fmakeSiteUser();
		$user = $userObj->getByEmail($request->getEscape('email'));
		//printAr($user);
		
		if(!$user){
			$error['user'] = "Пользователь с таким email не найден";
		}
		/*
		if(!$user['active']){
			$error['user'] = "Пользователь с таким email не активировал свою запись, через 4 дня она удалиться";
		}
		*/
		$globalTemplateParam->set('error', $error);
		
		if(!$error){
			
			$userObj->setId($user[$userObj->idField]);
			$userObj->addParam("active", "0");
			$password = $userObj->getNewPassword();
			$userObj->addParam("password", md5($password));
			$autication = $userObj->getAutication( $request ->getEscape('email') );
			$userObj->addParam("autication", $autication);
			$userObj->update();
			
			
			$tmp = $twig->getLoader();
			//$twig->setLoader(new Twig_Loader_String());
			$text = $twig->loadTemplate("mail/getpasword.tpl") -> render(array('autication'=>$autication,'hostname'=>$hostname,'id_user'=>$userObj->id,'password' => $password ));
			$twig->setLoader($tmp);
			
			$mail = new PHPMailer();
			$mail->CharSet = "utf-8";//кодировка
			$mail->From = "info@{$hostname}";
			$mail->FromName = $hostname;
			
			$mail->AddAddress($request ->getEscape('email'));
			
			
			$mail->WordWrap = 50;                                 
			$mail->SetLanguage("ru");
		
			$mail->IsHTML(true);
			
			$mail->Subject = "Смена пароля {$hostname}";
			$mail->Body    = $text;
			//$mail->AltBody = "Если не поддерживает html";
			
			if(!$mail->Send())
			{
			   echo "Message could not be sent. <p>";
			   echo "Mailer Error: " . $mail->ErrorInfo;
			}
			
			$send_password = true;
			$globalTemplateParam->set('send_password', $send_password);
		}
		
	break;
}





$template = "base/getpassword.tpl";
$template = $twig->loadTemplate($template);
$template->display($globalTemplateParam->get());
