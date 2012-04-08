<?php
header('Content-type: text/html; charset=utf-8'); 
ini_set('display_errors',1);
error_reporting(7);
session_start();

require 'configs.php';
	
	//коннект к базе данных
	$dataBase = new dataBaseController(
				$_SERVER["PHP_SELF"],
				"root",//пользователь
				"",//пароль
				"fmake",//имя базы
				"localhost",//сервер
				"",
				"utf8",//кодировка
				"pr"//кодировка
			);
			
	$log = new dataBaseController_logFile(ROOT."/template/cache/sql.html");	


	$dataBase->connect(__LINE__);
	
	//глобальные переменные для шаблона
	$globalTemplateParam = new templateController_templateParam();

	//обработчик информации из вне, get, post
	$request = new requestController();
	$globalTemplateParam->set('request',$request);
	
	$hostname = str_replace("www.", "", $_SERVER['HTTP_HOST']);
	$globalTemplateParam->set('hostname',$hostname);
	
	//защита от sql иньекций, если включен защищенный режим
	if(REQUEST_SAFETY){
		$request->allSqlInjectionNone();
	}
	//обработчик сессии
	$session = new sessionController();
	
	//создаем класс глобальных параметров
	$configs = new globalConfigs();
	$globalTemplateParam->set('configs',$configs);

