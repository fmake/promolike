<?PHP

class absAdministrators extends DAO
{
	public $id;
	public $table = "admin_user";
	
	function __construct ($id = null)
	{
		if($id)	$this->id = $id;
	}

	function login($login, $password)
	{
			global $mysql;
     	$select = new SelectFromDB($mysql, __LINE__);
		$row = $select -> addFrom($this->table) ->	addWhere("login='".mysql_escape_string($login)."'") -> addWhere("active='1'") -> queryDB();
		$row = $row[0];

		if (md5($password) == $row["password"])
			return $row;
		else
			return false;
	}

	function getInfoByName($name) // Данные админа по его имени
	{
			global $mysql;
		$select = new SelectFromDB($mysql, __LINE__);
		$arr = $select -> addFrom($this->table) -> addWhere("name='$name'") -> addWhere("id='".$this->id."'") -> queryDB();
		return $arr[0];
	}

	function getAllAdminType() // Все роли
	{
			global $mysql;
		$select = new SelectFromDB($mysql, __LINE__);
		return $select -> addFild("type") -> addFrom($this->table) -> addGroup("type") -> queryDB();
	}
}
?>