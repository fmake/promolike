<?php

class templateController
{
	public static $tplExt 		= ".tpl";
	public static $tplDir 		= "template";

	public static $phpExt 		= ".php";
	public static $phpDir 		= "temp";

	public $data 				= null;
	public $content			= null;

	function __construct() {}

	public function getFileData($tpl_file) 
	{

			if (!is_file($tpl_file))
				$tpl_file = ROOT . "/" .self::$tplDir.DIRECTORY_SEPARATOR.$tpl_file.self::$tplExt;

			if (!is_file($tpl_file))
				die("utlTemplate::parse() - {$tpl_file} file not found.");

		return $this->data = file_get_contents($tpl_file);
	}

	public function parse($data = null) 
	{
		$tpl_content = ($data)?$data:$this->data;
		
		preg_match_all("~\{(.*?)\}~si", $tpl_content, $matches);

		//printAr($matches[1]);
		foreach($matches[1] as $var)
		{
			switch(TRUE)
			{
				case ereg("^\\$([_a-zA-z0-9\(\)\'\>\-]*)$", $var, $var): 
					$replace = "<?PHP echo $" . $var[1] . "; ?>";
					$tpl_content = str_replace('{' . $var[0] . '}' , $replace, $tpl_content);
				break;

				case ereg("^Include \"(.*)\"$", $var, $var): 
					switch(TRUE)
					{
						case ereg("^\\$([\/_a-zA-z0-9\'\>\-]*)$", $var[1], $varNew):
							$replace = $this->parse($this->getFileData($GLOBALS[$varNew[1]]));
							$tpl_content = str_replace('{' . $var[0] . '}' , $replace, $tpl_content);
						break;

						case ereg("^([\/_a-zA-z0-9\-]*)$", $var[1], $varNew):
							$replace = $this->parse($this->getFileData($varNew[1]));
							$tpl_content = str_replace('{' . $var[0] . '}' , $replace, $tpl_content);
						break;
					}
				break;

			case ereg("^If \"(.*)\"$", $var, $var):
				$replace = "<?PHP if (" . $var[1] . ") { ?>";
				$tpl_content = str_replace('{' . $var[0] . '}' , $replace, $tpl_content);
			break;
			
			
			case ereg("^elseIf$", $var, $var): 
				$replace = "<?PHP } else { ?>";
				$tpl_content = str_replace('{' . $var[0] . '}' , $replace, $tpl_content);
			break;

			case ereg("^Foreach \"(.*)\"$", $var, $var): 
				$replace = "<?PHP foreach (" . $var[1] . ") { ?>";
				$tpl_content = str_replace('{' . $var[0] . '}' , $replace, $tpl_content);
			break;

			case ereg("^While \"(.*)\"$", $var, $var): 
				$replace = "<?PHP while (" . $var[1] . ") { ?>";
				$tpl_content = str_replace('{' . $var[0] . '}' , $replace, $tpl_content);
			break;

			case ereg("^For \"(.*)\"$", $var, $var): 
				$replace = "<?PHP for (" . $var[1] . ") { ?>";
				$tpl_content = str_replace('{' . $var[0] . '}' , $replace, $tpl_content);
			break;

			case ereg("^endIf$", $var, $var): 
			case ereg("^endForeach$", $var, $var): 
			case ereg("^endWhile$", $var, $var): 
			case ereg("^endFor$", $var, $var): 
			case ereg("^\/$", $var, $var): 
				$replace = "<?PHP } ?>";
				$tpl_content = str_replace('{' . $var[0] . '}' , $replace, $tpl_content);
			break;
			}
		}
		return $this->content = $tpl_content;
	}

	function display(){
		
		$temp_file = ROOT."/".self::$phpDir.DIRECTORY_SEPARATOR.microtime().self::$phpExt;
		$handle = fopen($temp_file, 'w+');
		fwrite($handle, $this->content);
		fclose($handle);
		
	
	
		reset($GLOBALS);
			
		foreach($GLOBALS as $key => $value)
			$$key = $value;
			
		//printAr($GLOBALS);
		include($temp_file);

		unlink($temp_file);
	}

	function display_file($file_name)
	{
		$this->parse($this->getFileData($file_name));
		$this->display();
	}

	function display_data($data)
	{
		$this->parse($data);
		$this->display();
	}
}

?>