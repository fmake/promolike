<?php
	/**
	*
	* Пользователь системы
	*/

	class fmakeProxy extends fmakeCore{
		
		public $idField = "id";
		public $table = "proxy";
		

	function getRandProxy() {
		$select = $this->dataBase->SelectFromDB(__LINE__);
		$result = $select->addFrom($this->table)->addOrder("RAND()")->addLimit(0,1)->queryDB();
		return $result[0];
	}
	
}