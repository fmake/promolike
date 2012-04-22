<?php
	/**
	*
	* Пользователь системы
	*/

	class fmakeSiteUser extends fmakeCore{
		
		public $idField = "id_user";
		public $table = "user";
		public $table_social = "user_social_set_params";
		public $symbols = "23456789abcdeghkmnpqsuvxyz";
		
		public $id; 	// int
		public $login;	// char
		public $type = 'user';	// char
		public $status;	// bool
		
		
	/**
	 * 
	 * поиск по email 
	 * @param string $email что ищем
	 */
	function getByEmail($email){
		$user = $this->getWhere(array("email = '{$email}'"));
		return $user[0];	
	}
	
	
	
	/**
	 * 
	 * сгенерить пароль
	 */
	function getNewPassword(){
		$length = rand(6, 7);
		$password = '';
		for($i=1; $i<=$length; $i++){
			$password  .= $this->symbols[rand(0, strlen($this->symbols))];
		}	
		return $password;
	}
	
	/**
	 * 
	 * получить хеш подтверждения регистрации
	 * @param string $email что ищем
	 */
	function getAutication($email){
		return md5( $email.rand(1, 20000) );
	}

	
	/**
	 * 
	 * залогинить пользователя
	 * @param string $email
	 * @param string $password
	 */
	function login($email,$password){
		$user = $this -> getByEmail($email);
		if(!$user){
			return false;
		}
		
		if($user['password'] == md5($password)){
			$this->id = $user[$this->idField];
			$this->login = $user['email'];
			//
			$this->status = true;
			$this -> save();
			return true;
		}
		return false;
	}
	
		/**
	 * 
	 * залогинить пользователя
	 * @param string $email
	 * @param string $password
	 */
	function loginCokie($email,$autication){
		$user = $this -> getByEmail($email);
		if(!$user){
			return false;
		}
		
		if($user['cookies'] == $autication){
			$this->id = $user[$this->idField];
			$this->login = $user['email'];
			$this->status = true;
			$this -> save();
			return true;
		}
		return false;
	}
	
	/**
	 * 
	 * разлогинеться
	 */
	public function logout()
	{
		unset($_SESSION[$this->type]);
		$this->status = false;
	}
	/**
	 * 
	 * статус
	 */
	public function isLogined()
	{
		return $this->status;
	}

	
	/**
	 * 
	 * загрузить данные
	 */
	public function load()
	{
		$this->id = $_SESSION[$this->type]['id'];
		$this->login = $_SESSION[$this->type]['login'];
		$this->status = $_SESSION[$this->type]['status'];
	}

	/**
	 * 
	 * сохранить данные
	 */
	public function save()
	{
		$_SESSION[$this->type]['id'] = $this->id;
		$_SESSION[$this->type]['login'] = $this->login;
		$_SESSION[$this->type]['status'] = $this->status;
	}
	
	/**
	 * 
	 * Выбираем рандомно пользователя социальной сети
	 * @param unknown_type $id_social_set
	 */
	
	function getUserRand($id_social_set) {
		$select = $this->dataBase->SelectFromDB(__LINE__);
		$result = $select->addFrom($this->table_social)->addWhere("id_social_set = ".$id_social_set)->addOrder("RAND()")->queryDB();
		return $result[0];
	}
	
	function getUserSocialParam($id_user,$id_social_set) {
		$select = $this->dataBase->SelectFromDB(__LINE__);
		$result = $select->addFrom($this->table_social)->addWhere($this->idField.' = '.$id_user)->addWhere("id_social_set = ".$id_social_set)->queryDB();
		return $result[0];
	}
	
	function getActiveSocialUser($id_user) {
		$select = $this->dataBase->SelectFromDB(__LINE__);
		$SocialSet = new promoLike_socialset();
		$result = $select->addFild($this->table_social.".id,".$this->table_social.".id_user,".$this->table_social.".id_social_set,".$this->table_social.".uid,".$this->table_social.".nickname,".$SocialSet->table_name.".name as socname")->addFrom($this->table_social." LEFT JOIN ".$SocialSet->table_name." ON ".$this->table_social.".".$SocialSet->idField." = ".$SocialSet->table_name.".".$SocialSet->idField)->addWhere($this->idField.' = '.$id_user)->queryDB();
		return $result;
	}
	
	function isUserSocSetDuble($uid,$ind_socset) {
		$select = $this->dataBase->SelectFromDB(__LINE__);
		switch ($ind_socset){
			case 2:
				$select->addWhere('uid = '.$uid);
				break;
			case 3:
				$select->addWhere('nickname = "'.$uid.'"');
				break;
		}
		$result = $select->addFild("COUNT(*)")->addFrom($this->table_social)->queryDB();
		return $result[0]["COUNT(*)"];
	}
	function isUserSocSetDB($uid,$ind_socset) {
		$select = $this->dataBase->SelectFromDB(__LINE__);
		$result = $select->addFild("COUNT(*)")->addFrom($this->table_social)->addWhere('id_user = '.$uid)->addWhere('id_social_set = '.$ind_socset)->queryDB();
		return $result[0]["COUNT(*)"];
	}
	
}