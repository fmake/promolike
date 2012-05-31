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
	function addLike($id_text_like,$count) {
		$fmakeTextLike = new promoLike_textlike();
		
		$fmakeTextLike->setId($id_text_like);
		$text_like = $fmakeTextLike->getInfo();
		
		$fmakeSocial = new promoLike_socialset();
		$social_set = $fmakeSocial->getSocialSetFilter($id_text_like);
		//printAr($social_set);
		foreach ($social_set as $key=>$item){
			if($item['active']){
				$arr_status_1 = $this->getTextPlaceStatus($id_text_like,$key,1);
				$arr_status_2 = $this->getTextPlaceStatus($id_text_like,$key,2);
				$arr_status_3 = $this->getTextPlaceStatus($id_text_like,$key,3);
				$arr_status_4 = $this->getTextPlaceStatus($id_text_like,$key,4);
				$count = intval($item['count']) - (sizeof($arr_status_1)+sizeof($arr_status_3)+sizeof($arr_status_4));
				if($count>0){
					$count_pause_like = sizeof($arr_status_2);
					if($count >= $count_pause_like){
						$count_result = $count - $count_pause_like;
						for($i=0;$i<$count_result;$i++){
							$this->addParam('id_page', $text_like['id_page']);
							$this->addParam('id_place', $key);
							$this->addParam('id_text_like', $text_like['id_text_like']);
							$this->addParam('status', 1);
							//$this->addParam('url', mysql_real_escape_string($page['url']));
							//$this->addParam('like_text', mysql_real_escape_string($text_like['text_like']));
							$this->addParam('date_creation', time());
							$this->newItem();
						}
					}
					else{
						$count_result = $count_pause_like - $count;
						/*удаляем ненужные лайки которые на паузе*/
						for($i=0;$i<$count_result;$i++){
							$this->setId($arr_status_2[$count_pause_like-1-$i][$this->idField]);
							$this->delete();
						}
						/*удаляем ненужные лайки которые на паузе*/
					}
					/*меняем статус на 1*/
					$this->updateTextPlaceStatus($id_text_like,$key,2,1);
					/*меняем статус на 1*/
				}
			}
		}
	}
	
	/**
	 * 
	 * Добавление записи в очередь выполнения
	 * @param int $id_text_like
	 */
	function pauseLike($id_text_like) {
		/*меняем статус на 1*/
		$this->updateTextPlaceStatus($id_text_like,false,1,2);
		/*меняем статус на 1*/	
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
	 * Все лайки в очереди со статусом $status
	 * @param int $status
	 */
	
	function getAllLikeStatus($status) {
		$select = $this->dataBase->SelectFromDB(__LINE__);
		return $select->addFrom("`".$this->table."`")->addWhere("`status` = '{$status}'")->addWhere("`active` = '1'")->queryDB();
	}
	
	
	/**
	 * 
	 * Все лайки страницы в очереди со статусом $status страницы
	 * @param int $id_page
	 * @param int $status
	 */
	
	function getPageStatus($id_page,$status) {
		$select = $this->dataBase->SelectFromDB(__LINE__);
		$fmakePage = new promoLike_page();
		return $select->addFrom("`".$this->table."`")->addWhere("`id_page`='{$id_page}'")->addWhere("`status` = '{$status}'")->addWhere("`active` = '1'")->queryDB();
	}
	
	/**
	 * 
	 * Все лайки текста определенной площядки в очереди со статусом $status страницы
	 * @param int $id_textlike
	 * @param int $id_place
	 * @param int $status
	 */
	
	function getTextPlaceStatus($id_textlike,$id_place,$status,$fields = false) {
		$select = $this->dataBase->SelectFromDB(__LINE__);
		$fmakeTextLike = new promoLike_textlike();
		if($fields)
			$select->addFild($fields);
		return $select->addFrom("`".$this->table."`")->addWhere("`{$fmakeTextLike->idField}`='{$id_textlike}'")->addWhere("`id_place`='{$id_place}'")->addWhere("`status` = '{$status}'")->addWhere("`active` = '1'")->queryDB();
	}
	/**
	 * 
	 * массовая замена статуса у лайков ожидающих очереди публикации
	 * @param unknown_type $id_textlike
	 * @param unknown_type $id_place
	 * @param unknown_type $status
	 * @param unknown_type $status_to
	 */
	function updateTextPlaceStatus($id_textlike,$id_place,$status,$status_to) {
		$update =  $this->dataBase->UpdateDB( __LINE__);
		$fmakeTextLike = new promoLike_textlike();
		if($id_place)
			$update->addWhere("`id_place`='{$id_place}'");
		$update->addTable("`".$this->table."`")->addFild("`status`", $status_to)->addWhere("`{$fmakeTextLike->idField}`='{$id_textlike}'")->addWhere("`status` = '{$status}'")->addWhere("`active` = '1'")->queryDB();
	}
	
	/**
	 * 
	 * все лайки пользователя на определенной площядке
	 * @param unknown_type $id_page
	 * @param unknown_type $status
	 */
	
	function getUserPlaceAll($id_user,$id_place) {
		$select = $this->dataBase->SelectFromDB(__LINE__);
		$fmakePage = new promoLike_page();
		return $select->addFrom("`".$this->table."`")->addWhere("`id_place`='".$id_place."'")->addWhere("`id_user_place` = '".$id_user."'")->addWhere("`active` = '1'")->queryDB();
	}
	
	/**
	 * 
	 * все пользователи у которых уже опубликован лайк
	 * @param unknown_type $id_place
	 * @param unknown_type $id_like
	 */
	
	function getUserPublickLike($id_place,$id_text_like){
		$select = $this->dataBase->SelectFromDB(__LINE__);
		$promoLikeText = new promoLike_textlike();
		return $select->addFild("id_user_place")->addFrom("`".$this->table."`")->addWhere("`id_place`='{$id_place}'")->addWhere("`id_user_place`!='0'")->addWhere("`{$promoLikeText->idField}`='{$id_text_like}'")->queryDB();
	}
}