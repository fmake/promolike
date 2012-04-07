<?PHP

class absSystemNotice extends DAO
{
	public $id;
	public $table = "site_notice";
	public $order = "date";

	function __construct ($id = null)
	{
		if($id)
			$this->id = $id;
	}

	function newNotice($notice) // Достает настройки у переустанавливает в приличный вид
	{
		$this->addParam('text', $notice);
		$this->addParam('date', date("Y-m-d H:i:s"));
		$this->addParam('remote_addr', $_SERVER['REMOTE_ADDR']);

		$this -> newItem();
	}

	function getAll ($active = false) // Выбрать всё из базы
	{
			global $mysql;
		$select = new SelectFromDB($mysql, __LINE__);
		if($this->order)
			$select -> addOrder($this->order, DESC);
		if($active)
			$select -> addWhere("active='1'");
		$arr = $select -> addFrom($this->table) -> queryDB();
		return $arr;
	}
}
?>