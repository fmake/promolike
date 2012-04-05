<?php
/**
 * 
 * фильтры
 * @author 1
 *
 */
class promoLike_pagefilter extends fmakeCore{
	
	public $idField = "id_filter";
	public $table = "page_filter";
	public $order = "position";
	
	/**
	 * 
	 * колличество добавленных одинаковых фильтров на странице 
	 * @param unknown_type $id_page
	 * @param unknown_type $id_filter
	 * @param unknown_type $id_user
	 */
	
	function isPageFilterUser($id_page,$id_filter,$id_user,$delete = true) {
		$select = $this->dataBase->SelectFromDB(__LINE__);
		$user = new fmakeSiteUser();
		$page = new promoLike_page();
		if($delete){
			$select->addWhere("`delete_page` = '0'");
		}
		$result = $select->addFild("COUNT(*)")->addFrom($this->table)->addWhere($user->idField." = ".$id_user)->addWhere($this->idField." = ".$id_filter)->addWhere($page->idField." = ".$id_page)->queryDB();
		return $result[0]["COUNT(*)"];
	}
	
	/**
	 * 
	 * выгружаем все фильтры у страницы пользователя
	 * @param unknown_type $id_page
	 * @param unknown_type $id_user
	 */
	
	function getFiltersPageUser($id_page,$id_user){
		$select = $this->dataBase->SelectFromDB(__LINE__);
		$user = new fmakeSiteUser();
		$page = new promoLike_page();
		$filter = new promoLike_filter();
		return $select->addFrom($filter->table.','.$this->table)->addWhere($filter->table.".".$filter->idField." = ".$this->table.".".$this->idField)->addWhere($this->table.".".$user->idField." = ".$id_user)->addWhere($page->idField." = ".$id_page)->addWhere("`delete_page` = '0'")->queryDB();
	}
	
	/**
	 * 
	 * удаление фильтра на страинце пользователя
	 * @param unknown_type $id_page
	 * @param unknown_type $id_filter
	 * @param unknown_type $id_user
	 */
	function deleteFilterPageUser($id_page,$id_filter,$id_user){
		$update =  $this->dataBase->UpdateDB( __LINE__);
		$user = new fmakeSiteUser();
		$page = new promoLike_page();	
		$update	-> addTable($this->table) -> addFild("`delete_page`", 1) -> addWhere($page->idField."='".$id_page."'")->addWhere($user->idField.'='.$id_user)->addWhere($this->idField.' = '.$id_filter.'') -> queryDB();
	}
	/**
	 * 
	 * возобновление фильтра на страинце пользователя
	 * @param unknown_type $id_page
	 * @param unknown_type $id_filter
	 * @param unknown_type $id_user
	 */
	function undeleteFilterPageUser($id_page,$id_filter,$id_user){
		$update =  $this->dataBase->UpdateDB( __LINE__);
		$user = new fmakeSiteUser();
		$page = new promoLike_page();	
		$update	-> addTable($this->table) -> addFild("`delete_page`", 0) -> addWhere($page->idField."='".$id_page."'")->addWhere($user->idField.'='.$id_user)->addWhere($this->idField.' = '.$id_filter.'') -> queryDB();
	}

}