<?PHP

class utlFile {

	public $file = null;
	public $path = null;
	public $name = null;

	function __construct($filepath = "")
	{
		$this->setFile($filepath);
	}

	function setFile ($filepath) // Установка файла
	{
		if(is_file($filepath))
		{
			$this->file = fopen($filepath);
			$this->path = $filepath;
			$this->name = basename($filepath);
		}
	}

	function delFile ($filepath = null) // Удалить файл
	{
		if($filepath && is_file($filepath))
			return unlink($filepath);

		fclose($this->file);
		unlink($this->path);
	}

	function setUseFile() // Установить права использования файла
	{
		chmod($this->file, 0777);
	}	
}

?>