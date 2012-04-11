<?php
class fmakeSiteAdministrator extends fmakeCore{
	
	public $table = "site_administrator";
	public $id; 	// int
	public $login;	// char
	public $role;	// int
	public $status;	// bool
	public $acces;	// char

	
	public static $accesObj = false;
	public static $roleObj = false;
	
	/**
	 * 
	 * @return fmakeAcces_adminModul
	 */
	function getAccesObj(){
		if(!self::$accesObj){
			self::$accesObj = new fmakeAcces_adminModul();
		}
		return self::$accesObj;
	}
	
	/**
	 * 
	 * @return fmakeSiteAdministratorRole
	 */
	function getRoleObj(){
		if(!self::$roleObj){
			self::$roleObj = new fmakeSiteAdministratorRole();
		}
		return self::$roleObj;
	}
	
	
	public function setLogin($id, $login, $role)
	{
		$this->id = $id;
		$this->login = $login;
		$this->role = $role;
		$this->status = true;

		$this->save();
	}
	
	public function logout()
	{
		unset($_SESSION[$this->type]);
		$this->status = false;
	}

	public function isLogined()
	{
		return $this->status;
	}

	public function getRole()
	{
		return $this->role;
	}

	public function load()
	{
		$this->id = $_SESSION[$this->type]['id'];
		$this->login = $_SESSION[$this->type]['login'];
		$this->role = $_SESSION[$this->type]['role'];
		$this->status = $_SESSION[$this->type]['status'];
	}

	public function save()
	{
		$_SESSION[$this->type]['id'] = $this->id;
		$_SESSION[$this->type]['login'] = $this->login;
		$_SESSION[$this->type]['role'] = $this->role;
		$_SESSION[$this->type]['status'] = $this->status;
	}
	
	function login($login, $password){
     	$select = $this->dataBase->SelectFromDB( __LINE__);
		$row = $select -> addFrom($this->table) ->	addWhere("login='".mysql_escape_string($login)."'") -> addWhere("active='1'") -> queryDB();
		$row = $row[0];

		if (md5($password) == $row["password"]){
			return $row;
		}else{
			return false;
		}
	}
	
}