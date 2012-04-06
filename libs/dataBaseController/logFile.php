<?php
/**
 * 
 * Log файл для просмотра запросов базы данных *
 */
class dataBaseController_logFile {
	/**
	 * 
	 * Enter description here ...
	 * @var string
	 */
	private $data = "";
	/**
	 * 
	 * дескриптор файла
	 * @var int
	 */
	private $fhandle = 0;
	/**
	 * 
	 * имя фала
	 * @var string
	 */
	private $filename = "";
	
	/**
	 * Конструктор
	 * @param string $output_filename имя фала
	 */
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
	/**
	 * Деструктор
	 */
	function __destruct()
	{
		if (!$this->fhandle)
			return;
		
		fclose($this->fhandle);
	}
	/**
	 * 
	 * Добавляем запись в файлы
	 * @param string $data то что добавляем
	 * @param string $status тип записи
	 */
	function add($data, $status="note")
	{
		//return 1;
		switch ($status)
		{
			case "note":
				$this->data = "<span style=\"color: #000; font-weight: normal;\">" . $data . "</span>";
			break;
			case "comment":
				$this->data = "<span style=\"color: #777; font-weight: normal;\">" . $data . "</span>";
			break;
			case "error":
				$this->data = "<span style=\"color: #f00; font-weight: normal;\">" . $data . "</span>";
			break;
			case "constructor":
				$this->data = "<span style=\"color: #000; font-weight: bold;\">" . $data . "</span>";
			break;
			case "highlight":
				$this->data = "<span style=\"color: #35f; font-weight: normal;\">" . $data . "</span>";
			break;
			default:
				$this->data = $data;
			break;
		}
		fwrite($this->fhandle, $this->getTextData());
		return 1;
	}
	
	/**
	 * 
	 * Синоним для add()
	 * @param string $data то что добавляем
	 * @param string $status тип записи
	 */
	function insert($data, $status="note")
	{
		return $this->add($data, $status);
	}
	/**
	 * 
	 * получаем последнюю запись
	 * @return string
	 */
	function getData()
	{
		return $this->data;
	}
	/**
	 * 
	 * получаем последнюю запись в html виде
	 * @return string
	 */
	function getTextData()
	{
		//$d = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">";
		$d .= "<p OnMouseOver=\"this.style.background='#eee';\" OnMouseOut=\"this.style.background='#fff';\">$this->data</p>\n";

		return $d;
	}
	/**
	 * 
	 * печатаем последнюю запись в html виде
	 * @return string
	 */
	function show()
	{
		print $this->getTextData();
	}
}