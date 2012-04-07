<?php 
class fmakeWhereSelector{
		/**
	 * @var dataBaseController
	 */
	public $dataBase;
	
	private function addWhereInObj(&$select,$where){
		
		for($i = 0;$i < sizeof($where);$i++){
			$select -> addWhere($where[$i]);
		}
	}
	
	private function addFieldInObj(&$select,$field){
		
		for($i = 0;$i < sizeof($field);$i++){
			$select -> addFild($field[$i]);
		}
		
	}
	
	function getWhere($where = array()){
		
		$select = $this->dataBase->SelectFromDB( __LINE__);
		if($this->order)
			$select -> addOrder($this->order, (($this->order_as)?$this->order_as:ASC));
			
		$this->addWhereInObj($select,$where);
		return $select -> addFrom($this->table) -> queryDB();
				
	}
	
	function getWhereSqlQuery($where = array()){
		
		$select = $this->dataBase->SelectFromDB( __LINE__);
		if($this->order)
			$select -> addOrder($this->order, (($this->order_as)?$this->order_as:ASC));
			
		$this->addWhereInObj($select,$where);
		
		return $select -> addFrom($this->table) -> selectData() -> getData();
				
	}
	
	function getFieldWhere($field = array(),$where = array()){
			
		$select = $this->dataBase->SelectFromDB( __LINE__);
		if($this->order)
			$select -> addOrder($this->order, (($this->order_as)?$this->order_as:ASC));
			
		$this->addWhereInObj($select,$where);
		$this->addFieldInObj($select,$field);
		
		return $select -> addFrom($this->table) -> queryDB();
				
	}
	
	function getFieldWhereSqlQuery($field = array(),$where = array()){
			
		$select = $this->dataBase->SelectFromDB( __LINE__);
		if($this->order)
			$select -> addOrder($this->order, (($this->order_as)?$this->order_as:ASC));
			
		$this->addWhereInObj($select,$where);
		$this->addFieldInObj($select,$field);
		
		return $select -> addFrom($this->table) -> selectData() -> getData();
				
	}
	
}

?>