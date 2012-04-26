<?php
/**
 * 
 * Проект рекламодателя
 * @author 1
 *
 */
class promoLike_project extends fmakeCore{
	
	public $idField = "id_project";
	public $table = "project";
	public $order = "position";
	
	/**
	 * 
	 * Есть ли такой проект у пользователя
	 * @param unknown_type $id_user
	 * @param unknown_type $name_project
	 */
	
	function isProject($id_user,$name_project) {
		$select = $this->dataBase->SelectFromDB(__LINE__);
		$fmakeUser = new fmakeSiteUser();
		return $select->addFrom($this->table)->addWhere($fmakeUser->idField.'='.$id_user)->addWhere('caption = "'.$name_project.'"')->queryDB();
	}	
	
	/**
	 * 
	 * Все проекты пользователя
	 * @param unknown_type $id_user
	 */
	
	function getAllProject($id_user) {
		$select = $this->dataBase->SelectFromDB(__LINE__);
		$fmakeUser = new fmakeSiteUser();
		return $select->addFrom($this->table)->addWhere($fmakeUser->idField.'='.$id_user)->queryDB();
	}	
}