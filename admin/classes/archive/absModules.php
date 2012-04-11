<?PHP

class absModules extends DAO
{
	public $id;
	public $order = "position";
	public $table = "site_modul";
	public $tree = array();
	public $output = "";
	public $parents = array();
	public $parts = array();
	public $imgFolder = "images/icons/";

	
	function __construct ($id = null)
	{		
		if($id)
			$this->id = $id;

		$this->getFilds();
		return $this;
	}

	function __get($nm) // Вызываем параметр из массива параметров по его наименованию
	{
       if (isset($this->params[$nm]))
           return $this->params[$nm];
	}

	function getByRedir($modul) // Достаем массив по параметру redir
	{
			global $mysql;
		$select = new SelectFromDB($mysql, __LINE__);

		if($modul)
			$modul = $select -> addFrom($this->table) -> addWhere("redir='$modul'") -> queryDB();
		else
			$modul = $select -> addFrom($this->table) -> addWhere("`index`='1'") -> queryDB();

		if(!$modul)
			HttpError(404);

		if($modul[0])	
			foreach($modul[0] as $key => $mod)
				$this->addParam($key, $mod);

		$this->id = $modul[0]['id'];
	}

	function getUp () // Переместить вверх по полю position
	{
			global $mysql;
		$itemInfo = $this->getInfo();
		$order = $itemInfo['position'];
		$parent = $itemInfo['parent'];
		$select = new SelectFromDB($mysql, __LINE__);
		$arr = $select -> addFrom($this->table) -> addWhere("`position` < '$order' ") -> addWhere("`parent` = '$parent' ") -> addOrder('position', 'DESC')  -> addLimit(0, 1) -> queryDB();
		$arr = $arr[0];

		if($arr)
		{
				$update = new UpdateDB($mysql, __LINE__);
			$update	-> addTable($this->table) -> addFild("`position`", $order) -> addWhere("`id` = '".$arr['id']."'") -> queryDB();
			$update	-> addTable($this->table) -> addFild("`position`", $arr['position']) -> addWhere("`id` = '".$this->id."'") -> queryDB();
		}
	}
	
	function getDown () // Переместить вниз по полю position
	{
			global $mysql;
		$itemInfo = $this->getInfo();
		$order = $itemInfo['position'];
		$parent = $itemInfo['parent'];
		$select = new SelectFromDB($mysql, __LINE__);
		$arr = $select -> addFrom($this->table) -> addWhere("`position` > '$order' ") -> addWhere("`parent` = '$parent' ") -> addOrder('position', 'ASC')  -> addLimit(0, 1) -> queryDB();
		$arr = $arr[0];

		if($arr)
		{
				$update = new UpdateDB($mysql, __LINE__);			
			$update	-> addTable($this->table) -> addFild("`position`", $order) -> addWhere("`id` = '".$arr['id']."'") -> queryDB();
			$update	-> addTable($this->table) -> addFild("`position`", $arr['position']) -> addWhere("`id` = '".$this->id."'") -> queryDB();
		}
	}

	function setIndex()
	{
			global $mysql;
		$update = new UpdateDB($mysql, __LINE__);			
		$update	-> addTable($this->table) -> addFild("`index`", '0') -> queryDB();
		$update	-> addTable($this->table) -> addFild("`index`", '1') -> addWhere("`id` = '".$this->id."'") -> queryDB();
	}
	
	function getTop() // Берем все разделы верхнего уровня (парент = 0)
	{
		global $mysql;

		$select = new SelectFromDB($mysql, __LINE__);
		return $select -> addFild("id") -> addFild("caption") -> addFild("redir") -> addFrom($this->table) -> addWhere("active='1'") -> addWhere("parent='0'") -> addOrder($this->order) -> queryDB();
	}

	function getChilds ($id = null, $active = false, $inmenu = false) // Достаем подразделы раздела
	{
		global $mysql;

		if($id === null)
			$id = $this->id;

		$select = new SelectFromDB($mysql, __LINE__);

		if($active)
			$select -> addWhere("active='1'");
		if($inmenu)
			$select -> addWhere("inmenu='1'");

		return $select -> addFrom($this->table) -> addWhere("parent='".$id."'") -> addOrder($this->order) -> queryDB();	
	}
	
	function getParent ($parent) // Берем родителя раздела
	{
		global $mysql;
		$select = new SelectFromDB($mysql, __LINE__);
		$parent = $select -> addFrom($this->table) -> addWhere("active='1'") -> addWhere("id='$parent'") -> addOrder($this->order) -> queryDB();
		return $parent[0];
	}

	function getParents($parents = null)
	{
		if(!$parents)
			$parents = $this->id;
		$arrparents = $this->getParent($parents);
		$this->parents[] = $arrparents;
		if($arrparents['parent']!=='0')
			$this->getParents($arrparents['parent']);
	}

	function getFriends ($parent) // Дети родителя
	{
		global $mysql;
		$select = new SelectFromDB($mysql, __LINE__);
		return $select -> addFrom($this->table) -> addWhere("active='1'") -> addWhere("parent='$parent'") -> addOrder($this->order) -> queryDB();
	}

	function checkArray($froms, $tos, $key) // сравнение массивов по параметру key
	{
		foreach($froms as $from)
			foreach($tos as $to)
				if($from[$key]===$to[$key])
					return true;
	}

	function getAllForMenu($parent = 0, $active = false) // Берем все разделы для меню
	{
				global $mysql;

		$select = new SelectFromDB($mysql, __LINE__);
		$select -> addFrom($this->table) -> addWhere("parent=$parent") -> addWhere("`inmenu`='1'")-> addOrder($this->order);
	
		if($active)	$select -> addWhere("active='1'");
	
		$items = $select -> queryDB();

			if($items)
				foreach ($items as $key => $item) {

				if($items[$key]['id'] == $this->id) $items[$key]['status'] = true;

					$childrens = $this->getChilds($item['id'], $active, 1);

					if($childrens)
						foreach ($childrens as $_key => $_child) {
					
							if($_child['id'] == $this->id) { $items[$key]['status'] = true; $childrens[$_key]['status'] = true; }
					
							$_childrens = $this->getChilds($_child['id'], $active, 1);

							if($_childrens)
								foreach ($_childrens as $___key => $___child)
									if($___child['id'] == $this->id) { $items[$key]['status'] = true; $childrens[$_key]['status'] = true; }

							if($_childrens)
								$childrens[$_key]['child'] = $_childrens;
						}

					if($childrens)
						$items[$key]['child'] = $childrens;
				}

		return $items;
	}
	
	function getAllForMenu_1($parent = 0, $active = false,&$q,&$flag,$inmenu) // Берем все разделы для меню
	{
		$items = $this->getChilds($parent,$active,$inmenu);
		if(!$items)	return;
		foreach ($items as $key => $item) {
				if($items[$key]['id'] == $this->id){
					$items[$key]['status'] = true;
					$flag = !$flag;
					$q = true;
				}	
				if($flag)$items[$key]['status'] = &$q;
				$items[$key]['child'] = $this->getAllForMenu_1($item['id'], true,$q,$flag,$inmenu);
				if($flag)unset($items[$key]['status'] );
		}
		return $items;
	}
	function getAllAsTree($parent = 0, $level = 0, $active = false, $inmenu = false) // Все разделы деревом
	{
		$level++;
		$items = $this -> getChilds($parent, $active, $inmenu);

			if($items)
				foreach ($items as $item)
				{
					$item['level'] = $level;
					$this->tree[] = $item;
					$this->getAllAsTree($item['id'], $level, $active, $inmenu);
				}

		return $this->tree;
	}

	function createImgFolder()
	{
		$dirs = explode("/", $this->imgFolder.$this->id);

		$dirname = ROOT.DIRECTORY_SEPARATOR;
		
		foreach($dirs as $dir)
		{
			$dirname = $dirname.$dir.DIRECTORY_SEPARATOR;
			if(!is_dir($dirname)) mkdir($dirname);
		}

		return $this->folder = $dirname;
	}

	function addImage($image)
	{
		$this->createImgFolder();

		@move_uploaded_file($image, $this->folder."/icon.png");
	}

	function addSmallImage($image)
	{
		$this->createImgFolder();

		@move_uploaded_file($image, $this->folder."/small.jpg");
	}
	
	function deleteImage($name){
		
		if($name && file_exists(ROOT."/".$this->imgFolder.$this->id."/".$name))
			unlink(ROOT."/".$this->imgFolder.$this->id."/".$name);
	}
	
}
?>