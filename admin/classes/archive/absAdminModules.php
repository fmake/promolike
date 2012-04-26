<?PHP

class absAdminModules extends absModules
{
	public $id;
	public $order = "position";
	public $table = "admin_modul";

	function __construct ($id = null)
	{
		if($id)
			$this->id = $id;
		return $this;
	}
	
	function getChilds ($id = null, $active = false, $inmenu = false,$acces = false) 
	{
		global $mysql;
		global $prefix;
		if($id === null)
			$id = $this->id;

		$select = new SelectFromDB($mysql, __LINE__);

		if($active)
			$select -> addWhere("active='1'");
		if($inmenu)
			$select -> addWhere("inmenu='1'");
		if($acces)
			$select->addWhere("MATCH (".$prefix.$this->table.".users) AGAINST ('".trim($acces)."' IN BOOLEAN MODE)");
			
			
		return $select -> addFrom($this->table) -> addWhere("parent='".$id."'") -> addOrder($this->order,ASC) -> queryDB();	
	}


	function getAllForMenu_1($parent = 0, $active = false,&$q,&$flag,$inmenu,$acces = false) 
	{
		$items = $this->getChilds($parent,$active,$inmenu,$acces);
		if(!$items)	return;
		foreach ($items as $key => $item) {
				if($items[$key]['id'] == $this->id){
					$items[$key]['status'] = true;
					$flag = !$flag;
					$q = true;
				}	
				if($flag)$items[$key]['status'] = &$q;
				$items[$key]['child'] = $this->getAllForMenu_1($item['id'], true,$q,$flag,$inmenu,$acces);
				if($flag)unset($items[$key]['status'] );
		}
		return $items;
	}
	
	
	function getByRedir($modul, $type) 
	{
			global $mysql;
		$select = new SelectFromDB($mysql, __LINE__);
		if($modul)
			$modul = $select -> addFrom($this->table) -> addWhere("redir='$modul'") -> queryDB();
		else{
			$modul = $select -> addFrom($this->table) -> addWhere("`index`='1'") -> queryDB();
		}
		return $modul[0];
	}
}
?>