<?PHP

class utlCacheTemplate
{
	public $cacheDir = 'cache/';
	public $dump = null;
	public $path = null;
	public $extension = 'html';
	public $content = null;
	
	function __construct($url)
	{
		$this->path = ROOT.$this->cacheDir.md5($url);
	}

	function writeCache()
	{
		$handle = fopen($this->path . "." . $this->extension, 'w+');
		fwrite($handle, $this->content);
		fclose($handle);
	}

	function cacheExists()
	{
		if(file_exists($this->path . "." . $this->extension) && CACHECONTROL)
			return true;
		else
			return false;
	}

	function printCache()
	{
		include($this->path . "." . $this->extension);
		exit;
	}

	function startCache()
	{
		ob_start();
	}

	function stopCache()
	{
		$this->content = ob_get_contents();	
		ob_end_clean();
	}
}

?>