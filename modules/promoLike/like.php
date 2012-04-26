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
	
        public function getAllLikes($id_user){
            $select = $this->dataBase->SelectFromDB(__LINE__);
            $result = $select->addFrom($this->table)->addWhere("id_user_place = '".$id_user."'")->queryDB();
            
            return $result[0];
        }
}