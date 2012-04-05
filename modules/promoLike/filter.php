<?php
/**
 * 
 * фильтры
 * @author 1
 *
 */
class promoLike_filter extends fmakeCore{
	
	public $idField = "id_filter";
	public $table = "filter";
	public $order = "position";
	
	/**
	 * 
	 * Выбираем все фильтры пользователя
	 * @param unknown_type $id_user
	 */
	
	function getFilterUser($id_user) {
		$select = $this->dataBase->SelectFromDB(__LINE__);
		$fmakeUser = new fmakeSiteUser();
		return $select->addFrom($this->table)->addWhere($fmakeUser->idField.' = '.$id_user)->queryDB();
	}
	/**
	 * 
	 * Выбираем все незадействованные фильтры пользователя
	 * @param unknown_type $id_user
	 */
	
	function getNoUsedFilterUser($id_user,$id_page) {
		$select = $this->dataBase->SelectFromDB(__LINE__);
		$fmakeUser = new fmakeSiteUser();
		$PageFilter = new promoLike_pagefilter();
		return $select->addFrom($this->table)->addWhere($this->idField." not in (SELECT ".$PageFilter->idField." FROM ".$PageFilter->table." WHERE ".$fmakeUser->idField." = ".$id_user." AND `id_page` = ".$id_page." AND `delete_page` = '0') ")->addWhere($fmakeUser->idField.' = '.$id_user)->queryDB();
	}		
	/**
	 * 
	 * колличество одинаковых фильтров у пользователя
	 * @param unknown_type $id_user
	 * @param unknown_type $namefilter
	 */
	function countFilterUser($id_user,$namefilter) {
		$select = $this->dataBase->SelectFromDB(__LINE__);
		$fmakeUser = new fmakeSiteUser();
		$result=$select->addFild("COUNT(*)")->addFrom($this->table)->addWhere($fmakeUser->idField.' = '.$id_user)->addWhere('caption = "'.$namefilter.'"')->queryDB();
		return $result[0]["COUNT(*)"];
	}
	/**
	 * 
	 * общий бюджет страницы
	 * @param unknown_type $id_user
	 * @param unknown_type $id_page
	 * @param unknown_type $id_project
	 */
	function summBudgetPage($id_user,$id_page) {
		$select = $this->dataBase->SelectFromDB(__LINE__);
		$fmakeUser = new fmakeSiteUser();
		$PageFilter = new promoLike_pagefilter();
		$result=$select->addFild("SUM(budget)")->addFrom($this->table)->addWhere($this->idField." in (SELECT ".$PageFilter->idField." FROM ".$PageFilter->table." WHERE ".$fmakeUser->idField." = ".$id_user." AND `id_page` = ".$id_page." AND `delete_page` = '0') ")->addWhere($fmakeUser->idField.' = '.$id_user)->queryDB();
		return $result[0]["SUM(budget)"];
	}
}