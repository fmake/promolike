<?php
/**
 * параметры доступные в любом месте сайта
 */
class globalConfigs extends fmakeCore{
	
	public $table = "site_config";

	/**
	 * получение параметра
	 * @param string $key ключ
	 */
	function __get($key){
		
		return $this->getByParam($key);
	}

	public function __isset($key){
 		return true;
  	}
	
	/**
	 * обновление параметра по ключу
	 * @param string $key ключ
	 * @param string $value значение
	 */
	function udateByValue($key,$value){
		$item = $this->getByParam($key,false);
		$this->id = $item['id'];
		$this->addParam("param",$key);
		$this->addParam("value",$value);
		return $this->update();
	}
	
	/**
	 * получение параметра
	 * @param string $key ключ
	 * @param string $value вернуть значение лобо целиком
	 * @return параметр
	 */
	function getByParam($key,$value = true){
		$select = $this->dataBase->SelectFromDB(__LINE__);
		$arr = $select-> addWhere("param='".$key."'") -> addFrom($this->table) -> queryDB();
		if($value){
			return $arr[0]['value'];
		}else{
			return $arr[0];
		}
		
	}
	
	/**
	 * выгрузка всей таблицы в память устаревший
	 */
	function getSiteConfigs() 
	{
		$siteconfig = $this->getAll(true);
		if($siteconfig)
			foreach($siteconfig as $conf)
				$this->{$conf['param']} = $conf['value'];
	}
}

?>