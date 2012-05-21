<?php
/**
 * 
 * Лайк, размещенная ссылка
 * @author 1
 *
 */
class promoLike_likehistory extends promoLike_like{
	
	public $idField = "id_likehistory";
	public $table = "like_history";
	public $order = "date_placed";
	
	function dublicateHistory($like_info){ 
		if($like_info){
			foreach($like_info as $key=>$item){
				$this->addParam($key,$item);
			}
			$this->newItem();	
		}
	}
}