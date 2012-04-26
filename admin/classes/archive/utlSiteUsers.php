<?

class utlSiteUsers
{
	public $id; 	// int
	public $login;	// char
	public $type;	// char
	public $status;	// bool
	public $acces;	// char

	function __construct($type)
	{
		$this->type = $type;
	}

	public function login($id, $login, $acces)
	{
		$this->id = $id;
		$this->login = $login;
		$this->acces = $acces;
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

	public function getAcces()
	{
		return $this->acces;
	}

	public function load()
	{
		$this->id = $_SESSION[$this->type]['id'];
		$this->login = $_SESSION[$this->type]['login'];
		$this->acces = $_SESSION[$this->type]['acces'];
		$this->status = $_SESSION[$this->type]['status'];
	}

	public function save()
	{
		$_SESSION[$this->type]['id'] = $this->id;
		$_SESSION[$this->type]['login'] = $this->login;
		$_SESSION[$this->type]['acces'] = $this->acces;
		$_SESSION[$this->type]['status'] = $this->status;
	}
}

?>