<?
require('./libs/FController.php');


switch ($request->action){
	case 'registration':
		
		$userObj = new fmakeSiteUser();
		
		if(!preg_match("#^[a-zA-Z0-9]{5,}$#s", $request ->getEscape('password'))){	
			$error['password_format'] = "Пароль должен быть длиннее 5 символов, состоять из латинских букв и цифр";
		}
		
		if(!$error['password_format'] && $request ->getEscape('password') != $request ->getEscape('password2')){
			$error['password'] = "Пароли не совпадают";
		}
		
		if(!$request ->getEscape('email') || !ereg("^([-a-zA-Z0-9._]+@[-a-zA-Z0-9.]+(\.[-a-zA-Z0-9]+)+)*$", $request ->getEscape('email'))){
			$error['email_format'] = "Неправильный формат email";
		}
		
		if(!$error['email_format'] && $userObj->getByEmail($request ->getEscape('email'))){
			$error['email'] = "Пользователь с таким email уже зарегистрирован";
		}
		$globalTemplateParam->set('error', $error);
		
		if(!$error){
			$userObj->addParam("email", $request ->getEscape('email'));
			$userObj->addParam("password", md5($password = $request ->getEscape('password')));
			$autication = $userObj->getAutication( $request ->getEscape('email') );
			$userObj->addParam("autication", $autication);
			$userObj->newItem();
			
			
			$tmp = $twig->getLoader();
			//$twig->setLoader(new Twig_Loader_String());
			$text = $twig->loadTemplate("mail/registration.tpl") -> render(array('autication'=>$autication,'hostname'=>$hostname,'id_user'=>$userObj->id,'password' => $password));
			$twig->setLoader($tmp);
			
			$mail = new PHPMailer();
			$mail->CharSet = "utf-8";//кодировка
			$mail->From = "info@{$hostname}";
			$mail->FromName = $hostname;
			
			$mail->AddAddress($request ->getEscape('email'));
			
			
			$mail->WordWrap = 50;                                 
			$mail->SetLanguage("ru");
		
			$mail->IsHTML(true);
			
			$mail->Subject = "Подтверждение регистрации {$hostname}";
			$mail->Body    = $text;
			//$mail->AltBody = "Если не поддерживает html";
			
			if(!$mail->Send())
			{
			   echo "Message could not be sent. <p>";
			   echo "Mailer Error: " . $mail->ErrorInfo;
			}
			
			$registration = true;
			$globalTemplateParam->set('registration', $registration);
		}
		
	break;
	case 'autication':
		$id_user = intval($request->id_user);
		if($request->autication && $id_user && is_int($id_user) ){
			$userObj = new fmakeSiteUser($id_user);
			$user = $userObj->getInfo();
			if($user['autication'] == $request->autication && !$user['active']){
				$autication = true;
				$globalTemplateParam->set('autication', $autication);
				$globalTemplateParam->set('email', $user['email']);
				$globalTemplateParam->set('type', $request->type);
				$userObj->addParam("active", 1);
				$userObj->update();
			}else{
				$autication_error = true;
				$globalTemplateParam->set('autication_error', $autication_error);
			}
		}
		
	break;
}





$template = "base/registration.tpl";
$template = $twig->loadTemplate($template);
$template->display($globalTemplateParam->get());

?>