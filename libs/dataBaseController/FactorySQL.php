<?PHP
/*
*	Фабрика объектов для работы с БД
*/
class FactorySQL
{
	private $line = null;
	private $obj = null;

	function __construct($obj, $line)
	{
		 $this->obj = $obj;
		 $this->line = $line;
	}
/*
	function makeAll()
	{
		$this->select = new SelectFromDB($this->obj, $this->line);
		$this->insert = new InsertInToDB($this->obj, $this->line);
		$this->update = new UpdateDB($this->obj, $this->line);
		$this->delete = new DeleteFromDB($this->obj, $this->line);
	}
*/	
	function makeSelect()
	{
		return new SelectFromDB($this->obj, $this->line);
	}
	function makeInsert()
	{
		return new InsertInToDB($this->obj, $this->line);
	}
	function makeUpdate()
	{
		return new UpdateDB($this->obj, $this->line);
	}
	function makeDelete()
	{
		return new DeleteFromDB($this->obj, $this->line);
	}
}
?>