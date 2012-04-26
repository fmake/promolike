<?PHP

class utlRequest
{
	function __get($key)
	{
		return $_REQUEST[$key];
	}
}
?>