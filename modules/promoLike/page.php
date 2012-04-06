<?php
/**
 * 
 * Страница проекта
 * @author 1
 *
 */
class promoLike_page extends fmakeCore{
	
	public $idField = "id_page";
	public $table = "page";
	public $order = "position";
	
	/**
	 * 
	 * выбрать все страницы заданного проекта у пользователя
	 * @param unknown_type $id_user
	 * @param unknown_type $id_project
	 */
	
	function getAllPageUser($id_user,$id_project) {
		$select = $this->dataBase->SelectFromDB(__LINE__);
		$fmakeProject = new promoLike_project();
		$fmakeUser = new fmakeSiteUser();
		return $select->addFrom($this->table)->addWhere($fmakeUser->idField.'='.$id_user)->addWhere($fmakeProject->idField.' = '.$id_project.'')->addWhere("`delete_page` = '0'")->queryDB();
	}

	/**
	 * 
	 * Выбрать все страницы проекта пользователя
	 * @param unknown_type $id_project
	 * @param unknown_type $id_user
	 */
	
	function getPageProjectUser($id_project,$id_user) {
		$select = $this->dataBase->SelectFromDB(__LINE__);
		$fmakeUser = new fmakeSiteUser();
		$fmakeProject = new promoLike_project();
		if($id_project)
			$select = $select->addWhere($fmakeProject->idField.' = '.$id_project);
		return $select->addFrom($this->table)->addWhere($fmakeUser->idField.'='.$id_user)->addWhere("`delete_page` = '0'")->queryDB();
	}	
	
	/**
	 * 
	 * проверка есть ли такая страница в проекте у данного пользователя
	 * @param unknown_type $id_user
	 * @param unknown_type $id_project
	 * @param unknown_type $name_page
	 */
	
	function isPage($id_user,$id_project,$name_page) {
		$select = $this->dataBase->SelectFromDB(__LINE__);
		$fmakeProject = new promoLike_project();
		$fmakeUser = new fmakeSiteUser();
		return $select->addFrom($this->table)->addWhere($fmakeUser->idField.'='.$id_user)->addWhere($fmakeProject->idField.' = '.$id_project.'')->addWhere('caption = "'.$name_page.'"')->addWhere("`delete_page` = '0'")->queryDB();
	}	
	
	/**
	 * 
	 * Удаление записи
	 */
	function deletePage($id_page,$id_user,$id_project){
		$update =  $this->dataBase->UpdateDB( __LINE__);
		$fmakeUser = new fmakeSiteUser();
		$fmakeProject = new promoLike_project();		
		$update	-> addTable($this->table) -> addFild("`delete_page`", 1) -> addWhere($this->idField."='".$id_page."'")->addWhere($fmakeUser->idField.'='.$id_user)->addWhere($fmakeProject->idField.' = '.$id_project.'') -> queryDB();
	}
}