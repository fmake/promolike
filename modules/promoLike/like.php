<?php
/**
 * 
 * Лайк, размещенная ссылка
 * @author 1
 *
 */
class promoLike_like extends fmakeCore{
	
	public $idField = "id_like";
	public $table = "like";
	public $order = "date_placed";
	
	
	function isTextLikeStatus($id_text_like,$status) {
		$select = $this->dataBase->SelectFromDB(__LINE__);
		$fmaketextLike = new promoLike_textlike();
		$result = $select->addFild("*,COUNT(*) as count")->addFrom("`".$this->table."`")->addWhere("`".$fmaketextLike->idField."`='".$id_text_like."'")->addWhere("`status` = ".$status)->addWhere("`active` = '1'")->queryDB();
		return $result[0];
	}
	
	/**
	 * 
	 * Добавление записи в очередь выполнения
	 * @param int $id_text_like
	 */
	function addLike($id_text_like) {
		$fmakePage = new promoLike_page();
		$fmakeTextLike = new promoLike_textlike();
		
		$fmakeTextLike->setId($id_text_like);
		$text_like = $fmakeTextLike->getInfo();
		
		$fmakePage->setId($text_like['id_page']);
		$page = $fmakePage->getInfo();
		
		$fmakeSocial = new promoLike_socialset();
		$social_set = $fmakeSocial->getSocialSetFirst($id_text_like);
		
		$this->addParam('id_page', $text_like['id_page']);
		$this->addParam('id_place', $social_set[$fmakeSocial->idField]);
		$this->addParam('id_text_like', $text_like['id_text_like']);
		$this->addParam('status', 1);
		$this->addParam('url', mysql_real_escape_string($page['url']));
		$this->addParam('like_text', mysql_real_escape_string($text_like['text_like']));
		$this->addParam('date_creation', time());
		$this->newItem();
	}
	
	
	/**
	 * 
	 * Смена статуса
	 * @param int $status
	 * 
	 * status - 1(новый);2(пауза);3(ожидание проверки 2 дней на удаление);4(опубликован);
	 */
	function changeStatus($status) {
		$this->addParam('status',$status);
		$this->update();
	}
	
	/**
	 * 
	 * Все лайки в очереди со статусом $status страницы
	 * @param int $id_page
	 * @param int $status
	 */
	
	function getPageStatus($id_page,$status) {
		$select = $this->dataBase->SelectFromDB(__LINE__);
		$fmakePage = new promoLike_page();
		return $select->addFrom("`".$this->table."`")->addWhere("`id_page`='".$id_page."'")->addWhere("`status` = '1'")->addWhere("`active` = '1'")->queryDB();
	}
}