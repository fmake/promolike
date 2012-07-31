<?php
	/**
	*
	* Пользователь системы
	*/

	class fmakeProxy extends fmakeCore{
		
		public $idField = "id";
		public $table = "proxy";
		
	/**
	 * 
	 * берем рандомно прокси из списка
	 */
	function getRandProxy() {
		$select = $this->dataBase->SelectFromDB(__LINE__);
		$result = $select->addFrom($this->table)->addOrder("RAND()")->addLimit(0,1)->queryDB();
		return $result[0];
	}
	/**
	 * 
	 * берем прокси из списка которые не использовались в течении 5 минут 
	 */
	function getProxy() {
		$select = $this->dataBase->SelectFromDB(__LINE__);
		$time = strtotime("-5 minute",time());
		$result = $select->addFrom($this->table)->addWhere("`last_used` < {$time}")->addLimit(0,1)->queryDB();
		
		$this->setId($result[0][$this->idField]);
		$this->addParam("last_used",time());
		$this->update();
		
		return $result[0];
	}
	
}