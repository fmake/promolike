<?php
class UpdateDB {
	
	private $filds = array();
	private $where = array();
	private $table = null;
	private $sql = "UPDATE ";
	private $line = null;
	private $obj = null;
	
	function __construct($obj, $line) { $this->obj = $obj; $this->line = $line;	}

# ���� � ��������
	function addFild($fild, $value, $slash = true) { $this->filds[] = array("fild"=>$fild, "value"=>$value, "slash"=>$slash); return $this;}

# �������	
	function addWhere($fild) { $this->where[] = $fild; return $this;}

# �������
	function addTable($table) { global $prefix;$this->table = $prefix.$table;  return $this;}
	
	function updateData() {
		
		if ($this->table==null) { 
			die("Failed! Line:".$this->line." No table");
		} else {
				$this->sql .= $this->table." ";
		}
		
		if (count($this->filds)!=0) {
			$this->sql .= "SET ";
			$i = 1;
			foreach ($this->filds as $filds) {
					if ($filds['slash']==true) { $this->sql .= $filds['fild']."='".$filds['value']."'".(($i==count($this->filds))? " ":", "); }
				elseif ($filds['slash']==false) { $this->sql .= $filds['fild']."=".$filds['value'].(($i==count($this->filds))? " ":", "); }
				$i++;
			}			
		}
				
		if(count($this->where)!=0) {
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
		$this->updateData();
		//echo $this->sql."<br>";
		$this->obj->query($this->sql, $this->line);
		
		$this->filds = array();
		$this->where = array();
		$this->table = null;
		$this->sql = "UPDATE ";
	}
}
?>