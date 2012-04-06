<?php
/**
 * параметры для шаблонизатора
 * 
 */
class templateController_templateParam{
	/**
	 * 
	 * Массив всех параметров
	 * @var array
	 */
	private $params = array();
	
	function __construct(){;}
	
	/**
	 * полчение всех раметров
	 * @return array
	 */
	function get(){
		return $this->params;
	}
	
	/**
	 *  добавляем параметр по указателю
	 *  @param string $name имя в шаблонизаторе
	 *  @param type $value значение принимается по указателю
	 */
	function set($name,&$value){
		$this->params[$name] = $value;
	}
	/**
	 *  добавляем параметр без указателя, она попадет в балон именно в текущем состоянии
	 *  @param string $name имя в шаблонизаторе
	 *  @param type $value значение
	 */
	function setNonPointer($name,$value){
		$this->params[$name] = $value;
	}
}