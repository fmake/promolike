<?php
/**
 * 
 * Лайк, размещенная ссылка
 * @author 1
 *
 */
class promoLike_like extends fmakeCore{
	
	public $idField = "id_like";
	public $table = "`like`";
	public $order = "date_placed";
	
        public function getAllNewLikes($id_user){
            $select = $this->dataBase->SelectFromDB(__LINE__);
            $result = $select->addFrom($this->table)
                             ->addWhere("id_user_place = " . (int)$id_user)
                             ->addWhere("status = 3")
                             ->addWhere("date_placed <= " . time()+3600*48)
                             ->queryDB();
            
            return $result[0];
        }
}