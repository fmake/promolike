<?
class utlLog
{
	private $data = array();
	private $fhandle = 0;
	private $filename = "";
	
	function __construct($output_filename="")
	{
		if (!$output_filename)
			return;
		$this->filename = $output_filename;
		//chmod($output_filename, octdec('755'));
		$this->fhandle = @fopen($output_filename, "w");
		if (!$this->fhandle)
			throw new Exception("невозможно создать файл <i>$output_filename</i>");
	}
	
	function __destruct()
	{
		if (!$this->fhandle)
			return;
		fwrite($this->fhandle, $this->getTextData());
		fclose($this->fhandle);
	}
	
	function add($data, $status="note")
	{
		switch ($status)
		{
			case "note":
				$this->data[] = "<span style=\"color: #000; font-weight: normal;\">" . $data . "</span>";
			break;
			case "comment":
				$this->data[] = "<span style=\"color: #777; font-weight: normal;\">" . $data . "</span>";
			break;
			case "error":
				$this->data[] = "<span style=\"color: #f00; font-weight: normal;\">" . $data . "</span>";
			break;
			case "constructor":
				$this->data[] = "<span style=\"color: #000; font-weight: bold;\">" . $data . "</span>";
			break;
			case "highlight":
				$this->data[] = "<span style=\"color: #35f; font-weight: normal;\">" . $data . "</span>";
			break;
			default:
				$this->data[] = $data;
			break;
		}
		return 1;
	}
	
	// Синоним для add()
	function insert($data, $status="note")
	{
		return $this->add($data, $status);
	}
	
	function getData()
	{
		return $this->data;
	}
	
	function getTextData()
	{
		$d = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">";
		foreach ($this->data as $data)
		{
			$d .= "<p OnMouseOver=\"this.style.background='#eee';\" OnMouseOut=\"this.style.background='#fff';\">$data</p>\n";
		}
		return $d;
	}
	
	function show()
	{
		print $this->getTextData();
	}
}
?>