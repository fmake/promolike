<?php
class SelectFromDB {
	
	private $filds = array();
	private $from = array();
	private $where = array();
	private $order = array();
	private $group = array(); // ����� AND
	private $groupwhere = array(); // ����� OR
	private $sql = "SELECT ";
	private $line = null;
	private $obj = null;
	private $limit_ofset = null;
	private $limit_rows = null;
	private $numrows = null;
	
	function __construct($obj, $line) { $this->obj = $obj; $this->line = $line;	}

# ���� �������	
	function addFild($fild) {  $this->filds[] = $fild; return $this;}

# �������	
	function addFrom($from) { global $prefix;$this->from[] = $prefix.$from;  return $this;}

# �������	
	function addWhere($where) { $this->where[] = $where;  return $this;}

	function addGroupWhere($group, $arr) {$this->groupwhere[] = array('name'=>$group, 'arr'=>$arr); return $this;}

# ����������
	function addOrder($order, $by="ASC") { $this->order[] = array("order"=>$order, "by"=>$by);  return $this;}

# �����������
	function addGroup($group) { $this->group[] = $group;  return $this;}

# ������
	function addLimit($ofset, $rows) { $this->limit_ofset = $ofset; $this->limit_rows = $rows;  return $this;}
	
	function selectData()
	{
		if (count($this->filds)==0)
		{
			$this->sql .= "* ";
		}
		else
		{
			$i = 1;
			foreach ($this->filds as $filds)
			{
				$this->sql .= "$filds".(($i==count($this->filds))? " ":", ");
				$i++;
			}			
		}
		
		if (count($this->from)==0)
		{
			die("Failed! Line:".$this->line." No table");
		}
		else
		{
			$this->sql .= "FROM ";
			$i = 1;
			foreach ($this->from as $from)
			{	
				$this->sql .= "$from".(($i==count($this->from))? " ":", ");
				$i++;
			}
		}
		if(count($this->where)!=0)
		{
			$this->sql .= "WHERE ";
			$i = 1;
			foreach ($this->where as $where)
			{

				$this->sql .= $where.(($i==count($this->where))? " ":" AND ");
				$i++;
			}
		}

		if($this->groupwhere)
		{
			foreach($this->groupwhere as $groupwhere)
			{
				$i = 1;
				$this->sql .= "AND (";
				$count = count($groupwhere['arr']);
				foreach($groupwhere['arr'] as $where)
				{
					$this->sql .= $groupwhere['name']." = '$where'".(($i==$count)? " ":" OR ");
					$i++;
				}
				$this->sql .= ") ";
			}
		}

		if(count($this->group)!=0)
		{
			$this->sql .= "GROUP BY ";
			$i = 1;
			foreach ($this->group as $group)
			{
				$this->sql .= "$group".(($i==count($this->group))? " ":", ");
				$i++;
			}
		}

		if(count($this->order)!=0)
		{
			$this->sql .= "ORDER BY ";
			$i = 1;
			foreach ($this->order as $order)
			{
				$this->sql .= $order['order']." ".$order['by'].(($i==count($this->order))? " ":", ");
				$i++;
			}
		}

		if(($this->limit_ofset!==null) && ($this->limit_rows!==null))
		{
			$this->sql .= "LIMIT ".$this->limit_ofset.", ".$this->limit_rows;
		}
		
		return $this;
	}

	function sortData($order, $by="ASC")
	{
		$this->sql .= " ORDER BY $order $by";
		return $this->sql;
	}
	
	function getData()
	{
		return $this->sql;
	}
	
	function queryDB($type = MYSQL_ASSOC)
	{
		$this->selectData();

		//echo $this->sql."<br>";
		
		if($this->obj->query($this->sql, $this->line))
		{
			// SET this as null
			$this->filds = array();
			$this->from = array();
			$this->where = array();
			$this->order = array();
			$this->group = array();
			$this->sql = "SELECT ";
			$this->limit_ofset = null;
			$this->limit_rows = null;
		}
		
		if($this->obj->num_rows()==0)
		{
			return null;
		}
		elseif ($this->obj->num_rows()==1)
		{
			return array($this->obj->fetch_array($type));
		}
		elseif ($this->obj->num_rows()>1)
		{
			for($i=0; $i<$this->obj->num_rows(); $i++)
				$rows[] = $this->obj->fetch_array($type);
			
			$this->numrows = $this->obj->num_rows();
			return $rows;
		}
	}
	
	function num_rowsDB()
	{
		return $this->numrows;
	}
}
?>