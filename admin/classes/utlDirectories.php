<?PHP

class utlDirectories {

	public $dir = null;
	public $path = null;
	public $files = array();

	function __construct($dirpath)
	{
		$this->setDir($dirpath);
	}
	
	function setDir ($dirpath)  
	{
		
		if(is_dir($dirpath))
		{
			$this->dir = opendir($dirpath);
			$this->path = $dirpath;
			
		}
	}
	
	function listing($ext = array()) 
	{
		
		while (false !== ($file = readdir($this->dir)))
			if ($file != "." && $file != "..")
			{
				if(!$ext)
					$this->files[] = $file;
				elseif(in_array(substr($file, strrpos($file, '.')), $ext))
					$this->files[] = $file;
			}
		return $this->files;
	}
	
	function delDir() 
	{		
		foreach ($this->listing() as $file)
		{
			if(is_file($this->path."/".$file))
				utlFile::delFile($this->path."/".$file);
			if(is_dir($this->path."/".$file))
				$this->delDir();
		}

		closedir($this->dir);
		rmdir($this->path);
	}
}

?>