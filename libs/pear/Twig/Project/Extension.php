<?php

	

class Twig_Project_Extension extends Twig_Extension
	{
		
	static function callObj($vars,$string)
	{
		global $twig;
		$template = $twig->loadTemplate('news/item.tpl');
		echo $template->render(array());
	  	return true;
	}	
		
	static function addGlobals($twig,$value,$name){
		global $templateGlobalParams;
		$templateGlobalParams[$name] = $value;
		//printAr($templateGlobalParams[$name]);
		//$globalTemplate[$name] = $value;
		//exit;
	  	return true;
	}
	
	static function twig_addGlobals($twig,$name){
		global $templateGlobalParams;
		return $templateGlobalParams[$name];
	}
	

	
	static function standartFunction(){
		func_num_args();
		$arr = func_get_args();
		return call_user_func_array($arr[0], array_slice($arr,1));
	}
	
	function compileFunction(Twig_Environment $twig,$value,$context){
		//printAr($context);
		//echo $value;
//		$loader = new Twig_Loader_String();
//		$twig = new Twig_Environment($loader, array('auto_reload' => true ,'cache' => ROOT.'/template/cache', 'debug' => true));
//		$lexer = new Twig_Lexer($twig, array('tag_comment' => array('/*', '*/'),'tag_block'  => array('[[', ']]'),'tag_variable' => array('{', '}'),));
//		$twig->setLexer($lexer);
//		$twig->addExtension(new Twig_Project_Extension());
//		$template = $twig->loadTemplate($value);
//		$template->display($context);
		$tmp = $twig->getLoader();
		$twig->setLoader(new Twig_Loader_String());
		$template = $twig->loadTemplate($value)->display($context);
		$twig->setLoader($tmp);
	}
	
	public function getName(){
		return 'project';
	}
	  
	public function getFilters(){
		return array(
			'callObj' => new Twig_Filter_Method($this, 'callObj',array('needs_environment' => true)),
			'addGlobals' => new Twig_Filter_Method($this, 'twig_addGlobals',array('needs_environment' => true)),
			'getGlobals' => new Twig_Filter_Method($this, 'getGlobals',array('needs_environment' => true)),
		);
	}
  
	public function getFunctions()
    {
		return array(
			'df' => new Twig_Filter_Method($this, 'standartFunction'),
			'compile' => new Twig_Filter_Method($this, 'compileFunction',array('needs_environment' => true))
		);
    }
	
	  public function getTokenParsers()
	  {
	    return array(new Twig_Project_TokenCodeParser());
	  }
	  
	  
	}