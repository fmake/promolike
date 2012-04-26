<?php
class InsertInToDB {
	
	private $filds = array();
	private $table = null;
	private $sql = "INSERT INTO ";
	private $line = null;
	private $obj = null;
	
	function __construct($obj, $line) { $this->obj = $obj; $this->line = $line;	}

# Поля и значения
	function addFild($fild, $value) { $this->filds[] = array("fild"=>$fild, "value"=>$value); return $this;}

# Таблица
	function addTable($table) {  global $prefix;$this->table = $prefix.$table;  return $this;}
	
	function insertData() {
		if ($this->table==null) { 
			die("Failed! Line:".$this->line." No table");
		} else {
				$this->sql .= $this->table." ";
		}
		
		if (count($this->filds)!=0) {
			$this->sql .= "SET ";
			$i = 1;
			foreach ($this->filds as $filds) {
				$this->sql .= $filds['fild']."='".$filds['value']."'".(($i==count($this->filds))? " ":", ");
				$i++;
			}			
		}
				
		return $this;
	}
		
	function getData() {
		return $this->sql;
	}
	
	function queryDB() {
		$this->insertData();
		
		return $this->obj->query($this->sql, $this->line);
	}
	function getInsertId() {
		return $this->obj->insert_id();
	}
}
?>