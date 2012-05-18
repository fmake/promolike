<?php
/**
 * 
 * социальные сети (площядки для рекламы)
 * @author 1
 *
 */
class promoLike_socialset extends fmakeCore{
	
	public $idField = "id_social_set";
	public $table = "social_set_text_like";
	public $table_name = "social_set";
	
	function isSocialSetFilters($id_social_set,$id_filter){
		$select = $this->dataBase->SelectFromDB(__LINE__);
		$filter = new promoLike_textlike();
		$result = $select->addFild("COUNT(*)")->addFrom($this->table)->addWhere($this->idField." = ".$id_social_set)->addWhere($filter->idField." = ".$id_filter)->queryDB();
		return $result[0]["COUNT(*)"];
	}
	
	function addSocialSet($id_social_set,$id_filter){
		$filter = new promoLike_textlike();
		$this->addParam($this->idField,$id_social_set);
		$this->addParam($filter->idField,$id_filter);
		$this->newItem();
	}
	
	function deleteSocialSet($id_social_set,$id_filter){
		$filter = new promoLike_textlike();
		$this->dataBase->query("DELETE FROM ".$this->table." WHERE ".$this->idField." = ".$id_social_set." AND ".$filter->idField." = ".$id_filter." LIMIT 1",__LINE__);
	}
	
	function getSocialSetFilter($id_filter){
		$select = $this->dataBase->SelectFromDB(__LINE__);
		$filter = new promoLike_textlike();
		$result = $select->addFrom($this->table)->addWhere($filter->idField." = ".$id_filter)->queryDB();
		if($result){
			foreach($result as $res){
				$array[$res[$this->idField]] = $res['count'];
			}
		}
		return $array;
	}
	
	function getSocialSetFirst($id_filter){
		$select = $this->dataBase->SelectFromDB(__LINE__);
		$filter = new promoLike_textlike();
		$result = $select->addFrom($this->table)->addWhere($filter->idField." = ".$id_filter)->addOrder("RAND()")->addLimit(0,1)->queryDB();
		return $result[0];
	}
	
	function getItemParams($id_social_set,$id_filter){
		$select = $this->dataBase->SelectFromDB(__LINE__);
		$filter = new promoLike_textlike();
		$result = $select->addFrom($this->table)->addWhere($filter->idField." = ".$id_filter)->addWhere($this->idField." = ".$id_social_set)->queryDB();
		return $result[0];
	}
	
	function addParamCount($id_social_set,$id_filter,$count){
		$count = intval($count);
		$filter = new promoLike_textlike();
		$this->dataBase->query("UPDATE {$this->table} SET `count` = '{$count}' WHERE `{$this->idField}` = {$id_social_set} AND `{$filter->idField}` = {$id_filter} LIMIT 1 ;",__LINE__);
		return $count;
	}
}