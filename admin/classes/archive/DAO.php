<?
class DAO {

	public $params = array();
	public $filds = array();
	public $new = false;
		
	function getFilds() 
	{
		global $mysql;
		global $prefix;
		$r = $mysql->query("SHOW COLUMNS FROM `".$prefix.$this->table."`", __LINE__);
		
		if ($r && @$mysql->num_rows($r))
			while ($obj = $mysql->fetch_array())
			{
				if(in_array($obj['Field'], $this->filds)) continue;
				$this->filds[] = $obj['Field'];
			}
	}

	function getBySearch($str, $where, $active = false) 
	{
			global $mysql;
		$select = new SelectFromDB($mysql, __LINE__);

		if($active) $select -> addWhere("active='1'");

		$_where = "";
		
		if($where)foreach($where as $key=>$w) {$_where .=$this->table.".".$w.((count($where)>($key+1))?", ":'');}

		$select -> addWhere("MATCH ({$_where}) AGAINST ('".trim($str)."' IN BOOLEAN MODE)");

		return $select -> addFrom($this->table) -> addOrder($this->order) -> queryDB();
	}

	function addParam ($param, $value) 
	{
		$this->params[$param] = $value;
	}
	
	function newItem() 
	{
			global $mysql;
		$insert = new InsertInToDB($mysql, __LINE__);		
		$insert	-> addTable($this->table) -> addFild('active', 1)	-> queryDB();

		$this->id = $insert	-> getInsertId();
		$this->new = true;
		$this->update();
	}

	function setId($id)
	{
		$this->id = $id;
	}

	function delete() 
	{
			global $mysql;
		$delete = new DeleteFromDB($mysql, __LINE__);		
		$delete	-> addTable($this->table) -> addWhere("id='".$this->id."'") -> queryDB();
	}
	
	function update() 
	{
			global $mysql;
		if(!$this->filds)
			$this->getFilds();

		if(($this->new === true) && in_array('position',$this->filds)) 
		{
			$select = new SelectFromDB($mysql, __LINE__);
			$position = $select -> addFild('MAX(`position`) AS `position`') -> addFrom($this->table) -> queryDB();
			$this->params['position'] = $position[0]['position'] + 1;
		}

		foreach($this->filds as $fild)
		{
			if(!isset($this->params[$fild]) || $fild == 'id') continue; 
			$update = new UpdateDB($mysql, __LINE__);
			$update	-> addTable($this->table) -> addFild("`".$fild."`", $this->params[$fild]) -> addWhere("id='".$this->id."'") -> queryDB();
		}
	}

	function setEnum($field)
	{
			global $mysql;
		$update = new UpdateDB($mysql, __LINE__);
		$update	-> addTable($this->table) -> addFild("$field", "IF($field='1','0','1')", false) -> addWhere("id='".$this->id."'") -> queryDB();
	}

	function getThisOrder() 
	{
		$arr = $this->getInfo();
		return $arr['position'];
	}

	function getUp () 
	{
			global $mysql;
		$order = $this->getThisOrder();
		$select = new SelectFromDB($mysql, __LINE__);
		$arr = $select -> addFrom($this->table) -> addWhere("`position` < '$order' ") -> addOrder('position', 'DESC')  -> addLimit(0, 1) -> queryDB();
		$arr = $arr[0];

		if($arr)
		{
				$update = new UpdateDB($mysql, __LINE__);
			$update	-> addTable($this->table) -> addFild("`position`", $order) -> addWhere("`id` = '".$arr['id']."'") -> queryDB();
			$update	-> addTable($this->table) -> addFild("`position`", $arr['position']) -> addWhere("`id` = '".$this->id."'") -> queryDB();
		}
	}
	
	function getDown () 
	{
			global $mysql;
		$order = $this->getThisOrder();
		$select = new SelectFromDB($mysql, __LINE__);
		$arr = $select -> addFrom($this->table) -> addWhere("`position` > '$order' ") -> addOrder('position', 'ASC')  -> addLimit(0, 1) -> queryDB();
		$arr = $arr[0];

		if($arr)
		{
				$update = new UpdateDB($mysql, __LINE__);			
			$update	-> addTable($this->table) -> addFild("`position`", $order) -> addWhere("`id` = '".$arr['id']."'") -> queryDB();
			$update	-> addTable($this->table) -> addFild("`position`", $arr['position']) -> addWhere("`id` = '".$this->id."'") -> queryDB();
		}
	}
	
	function active() 
	{
			global $mysql;
		$update = new UpdateDB($mysql, __LINE__);
		$update	-> addTable($this->table)	-> addFild("active", "NOT(active)", false) -> addWhere("id='".$this->id."'") -> queryDB();
	}
	
	function status_active($status = 0) 
	{
			global $mysql;
		$update = new UpdateDB($mysql, __LINE__);
		$update	-> addTable($this->table)	-> addFild("active", $status, false) -> addWhere("id='".$this->id."'") -> queryDB();
	}
	
	function getInfo () 
	{
			global $mysql;
		$select = new SelectFromDB($mysql, __LINE__);
		$arr = $select -> addFrom($this->table) -> addWhere("id='".$this->id."'") -> queryDB();	
		$arr = $arr[0];
		return $arr;
	}

	function getAll ($active = false) 
	{
			global $mysql;
		$select = new SelectFromDB($mysql, __LINE__);
		if($this->order)
			$select -> addOrder($this->order, (($this->order_as)?$this->order_as:ASC));
		if($active)
			$select -> addWhere("active='1'");
		$arr = $select -> addFrom($this->table) -> queryDB();
		return $arr;
	}

	function getByPage($limit, $page, $active = false) 
	{
			global $mysql;
		$select = new SelectFromDB($mysql, __LINE__);
		if($active)
			$select -> addWhere("active='1'");
		return $select -> addFrom($this->table) -> addOrder($this->order, DESC) -> addLimit((($page-1)*$limit), $limit) -> queryDB();
	}

	function getNumRows($active = false) 
	{
			global $mysql;
		$select = new SelectFromDB($mysql, __LINE__);
		if($active)
			$select -> addWhere("active='1'");
		$count = $select -> addFild("COUNT(*)") -> addFrom($this->table) -> queryDB();
		return $count[0]["COUNT(*)"];
	}

	function truncateTable() 
	{
			global $mysql;
		$SQL = "TRUNCATE TABLE `".$this->table."`";
		$mysql->query($SQL, __LINE__);
	}

	function backUpTable($path) 
	{
		$SQL = "DROP TABLE IF EXISTS `".$this->table."`;\n\n";

		$this -> getFilds();
		$arr = $this -> getAll();

		if($arr) foreach($arr as $row)
		{
			$SQL .= "INSERT INTO `".$this->table."` VALUES (";
			$i = 1;
			foreach($this->filds as $fild)
			{
				$SQL .= "'" . $row[$fild] . "'" . (($i != $this->filds)? ', ':'') . "";
				$i++;
			}
			$SQL .= ");\n";
		}

		$handle = fopen($path . $this->table."_".date("Y-m-d_H-i").".sql", "w+");
		fwrite($handle, $SQL);
		fclose($handle);
	}
}
?>