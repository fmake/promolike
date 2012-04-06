<?php
class DeleteFromDB {
	
	private $where = array();
	private $table = null;
	private $rows = null;
	private $sql = "DELETE FROM ";
	private $line = null;
	private $obj = null;
	
	function __construct($obj, $line) { $this->obj = $obj; $this->line = $line;	}

# Условия
	function addWhere($fild) { $this->where[] = $fild; return $this;}

# Таблица
	function addTable($table) { global $prefix;$this->table = $prefix.$table;  return $this;}

# Количество строк
	function addRows($rows) { $this->rows = $rows;  return $this;}
	
	function deleteData() {
		if ($this->table==null) { 
			die("Failed! Line:".$this->line." No table");
		} else {
				$this->sql .= $this->table." ";
		}
		
	if(count($this->where)>0) {
			$this->sql .= "WHERE ";
			$i = 1;
			foreach ($this->where as $where) {
				$this->sql .= "$where".(($i==count($this->where))? " ":" AND ");
				$i++;
			}
		}
				
		return $this;
	}
		
	function getData() {
		return $this->sql;
	}
	
	function queryDB() {
		$this->deleteData();
		
		return $this->obj->query($this->sql, $this->line);
	}

}
?>