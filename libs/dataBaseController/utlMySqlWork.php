<?php

// ���������� ��� ������ ��������� �� ������ � ���������� ���������� �������
function errorExit()
{
 echo "</td></tr></table></td></tr></table></td></tr></table></td></tr></table></td></tr></table></td></tr></table></td></tr></table></td></tr></table>\n";
 echo "<br><center><font color=red size=+2><?=_ERROR?></font><br><?=_SORRY?></center>\n";
 exit(); 
}

class utlMySqlWork
{
	private $UserName;
	private $Password ;
	private $DatabaseName;
	private $HostName;
	private $Port ;
	private $DbCharSet	;

	private $ProjectName ;
	private $SelfName = null;
	private $Connection_id = null;
	private $CurrentResult = null;
	private $DoNotFreeResult = null;

	function __construct($FileName,$db_user_name,$db_user_pas,$db_name,$db_host_name,$db_port,$db_crarset,$pr_name ) // ����������� ������
	{
		$this->UserName = $db_user_name;
		$this->Password = $db_user_pas;
		$this->DatabaseName = $db_name;
		$this->HostName = $db_host_name;
		$this->Port = $db_port;
		$this->DbCharSet = $db_crarset;
		$this->ProjectName = $pr_name;
		$this->SelfName=$FileName;
	}
	
	function checkError($ss,$errLine) // �������� �� ������
	{
		if(mysql_errno($this->Connection_id)!=0)
		{ 
			$date=date("y-m-d H:i:s");  
			echo "Project: $this->ProjectName \n\n<br>Date: $date <br>Script: $this->SelfName <br>Line: $errLine <br>Error(".mysql_errno()."):".mysql_error()."\n\n <br>in query: $ss <br><br><br>";
			ErrorExit();
		}                     
	}
	
	function connect($Line) // ������� � ����
	{  
		$this->Connection_id = mysql_connect($this->HostName.":".$this->Port,$this->UserName,$this->Password);
		$this->checkError("Connect to ".$this->HostName,$Line);
		$this->query("SET CHARACTER SET ".$this->DbCharSet,$Line);
		mysql_select_db($this->DatabaseName,$this->Connection_id);
		$this->checkError("Select ".$this->DatabaseName,$Line);
	}

	function query($ss,$Line) // ������ � ����
	{
		global $log;
		$log->add($ss);

		if($this->CurrentResult>1){ if(!$this->DoNotFreeResult){ mysql_free_result($this->CurrentResult); }}
		$this->CurrentResult=mysql_db_query($this->DatabaseName,$ss,$this->Connection_id);
		$this->checkError($ss,$Line);
		return $this->CurrentResult;
	}

	function data_seek($i)
	{
		mysql_data_seek($this->CurrentResult, $i);
	}
 
	function fetch_array($type = MYSQL_BOTH)
	{
		return mysql_fetch_array($this->CurrentResult, $type);
	}

	function fetch_object()
	{
		return mysql_fetch_object($this->CurrentResult);
	}

	function num_rows()
	{
			
		return mysql_num_rows($this->CurrentResult);
	}

	function insert_id()
	{
		return mysql_insert_id($this->Connection_id);
	}

	function disconnect()
	{
		mysql_close($this->Connection_id);
	}
}

