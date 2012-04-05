<?PHP
/*
 * 
 * обработчик информации из массива $_REQUEST
 * 
 */
class requestController{
	
	public function __isset($key){
 		return true;
  	}
	
	/**
	 * получение пареметра
	 * @param string $key имя параметра
	 * @return unknown_type
	 */
	function __get($key)
	{
		return $_REQUEST[$key];
	}
	
	/**
	 * получение пареметра c применение функции mysql_real_escape_string
	 * @param string $key имя параметра
	 * @return unknown_type
	 */
	function getEscape($key){
		return mysql_real_escape_string($_REQUEST[$key]);
	}
	
	function getEscapeVal($val){
		return mysql_real_escape_string($val);
	}
	/**
	 * получение всех пареметров массива c применение функции mysql_real_escape_string,
	 * если вызвать без параметров выполнить для массива $_REQUEST
	 * @param array $array массив
	 * @param string $key имя параметра
	 */
	function allEscape($array = false,$key = false){
		if(!$array)$array = &$_REQUEST;
		
			foreach ($array as $key=>&$value){
				
				if(is_array($value)){
					$value = $this->allEscape($value);
				}else{
					$value = mysql_real_escape_string($value);
				}
				
			}
			
		return $array;
	}
	
	/**
	 * получение слова c применением защиты от инъкций
	 * @param string $word слово
	 */
	function injectionWordNone($word){
		$word = mysql_real_escape_string ($word);
 
	    $word = strip_tags($word);
	         
	    $word = htmlspecialchars($word);
	 
	    $word = stripslashes($word);
	     
	    return addslashes($word); 
	}
	
	/**
	 * получение всех пареметров массива c применение функции allEscape,
	 * если вызвать без параметров выполнить для массива $_REQUEST
	 * @param array $array массив
	 * @param string $key имя параметра
	 */
	function allSqlInjectionNone($array = false,$key = false){
		if(!$array)$array = &$_REQUEST;
		
			foreach ($array as $key=>&$value){
				
				if(is_array($value)){
					$value = $this->allEscape($value);
				}else{
					$value = $this->injectionWordNone($value);
				}
				
			}

		return $array;
	}
	
}
?>