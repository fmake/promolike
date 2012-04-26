<?php

	define('ROOT', realpath(dirname(__FILE__).'/..'));
	define('REQUEST_SAFETY', false);
	
	
	require_once('pear/PEAR.php');
	require_once('pear/Twig/Autoloader.php');
	Twig_Autoloader::register();
	
	require 'includes/functions.php';
	require 'objectCreater/objectCreater.php';
	//устанавливаем пути к директории и определяем загрузчик
	objectCreater::setDirPaths();
	//загружаем шаблонизатор	
	$loader = new Twig_Loader_Filesystem(ROOT.'/template');
	$twig = new Twig_Environment($loader,array('auto_reload' => true ,'cache' => ROOT.'/template/cache', 'debug' => false,));
	$lexer = new Twig_Lexer($twig, array('tag_comment' => array('/*', '*/'),'tag_block'  => array('[[', ']]'),'tag_variable' => array('{', '}'),));
	$twig->setLexer($lexer);
	$twig->addExtension(new Twig_Project_Extension());
	//$twig->addExtension(new Twig_Extension_Optimizer());

	


	
	
?>