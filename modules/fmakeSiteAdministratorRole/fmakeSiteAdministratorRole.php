<?php
class fmakeSiteAdministratorRole extends fmakeCore{
	
	public $table = "site_administrator_role";
	
	function getRols(){
		$select = $this->dataBase->SelectFromDB(__LINE__);
		return $select -> addFild("id,role") -> addFrom($this->table) -> addGroup("role") -> queryDB();
	}
	
}