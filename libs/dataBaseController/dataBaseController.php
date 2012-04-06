<?php
class dataBaseController extends utlMySqlWork {

	
	function SelectFromDB($line = false){
		return new SelectFromDB($this, $line);
	}
	
	function InsertInToDB($line = false){
		return new InsertInToDB($this, $line);
	}
	
	function UpdateDB($line = false){
		return new UpdateDB($this, $line);
	}
	function DeleteFromDB($line = false){
		return new DeleteFromDB($this,$line);
	}
	
}