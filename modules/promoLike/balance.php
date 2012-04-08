<?php

/**
 * Баланс пользователя в системе
 *
 * @author fredrsf
 */
class promoLike_balance extends fmakeCore {

    private static $instance; // экземпляр класса
    protected $user_id; // id пользователя
    public $table = "balance";// таблица в бд
    public $order = false;
    public $idField = "id_balance";
    protected $message;
    public $history;
    public $transaction_id;

    /**
     * @static метод синглтон для получения единственного экземпляра объекта
     * @return Object экземпляр класса promoLike_balance
     */
    public static function getInstance() {
        if (self::$instance == null)
            self::$instance = new promoLike_balance ();

        return self::$instance;
    }

    /**
     * @method setUser - устанавливаем текущего пользователя
     * 
     * @param int $user_id
     * @return boolean 
     */
    private function setUser($user_id) {
        if (!$user_id)
            return false;

        $this->user_id = $user_id;

        return true;
    }

    /**
     * @method createBalance - создание баланса для пользователя
     * 
     * @param type $user_id
     * @return boolean
     */
    public function createBalance($user_id) {

        if (!$user_id)
            return false;

        if (!$this->setUser($user_id))
            return false;

        $balance = $this->getBalance($this->user_id);

        if ($balance)
            return false;
        
        $this->addParam("id_user", $this->user_id);
        $this->addParam("amount", 0.00);
        $this->addParam("unique_key", mt_rand(5, 10)); // нужно подумать и дописать проверочки
        
        $this->id = FALSE;
        
        $this->newItem();
        
        if (!$this->id)
            return FALSE;
        
        $this->history = promoLike_balancehistory::getInstance();
         
        $this->history->addRecord($this->user_id, "create");
  	
        return TRUE;
    }

    /**
     * @method setBalance - установить баланс пользователю
     * 
     * @param int $user_id
     * @param float $amount
     * @return boolean
     */
    private function setBalance($user_id, $amount) {

        if (!$user_id)
            return false;

        if (!$this->user_id)
            $this->setUser($user_id);

        $balance = $this->getBalance($this->user_id);

        if (!$balance)
            return false;
    
        $this->addParam("amount", $amount);
        
        $this->updateWithParam("id_user", $this->user_id);
        
        return TRUE;
    }

    /**
     * @method getBalance - получить баланс пользователя
     * 
     * @param int $user_id
     * @return array
     */
    public function getBalance($user_id) {
        if (!$user_id)
            return false;

        if (!$this->user_id)
            $this->setUser($user_id);
        
        $select = $this->dataBase->SelectFromDB(__LINE__);
        
	$balance =  $select->addFrom($this->table)->addWhere('id_user = ' . $this->user_id)->queryDB();
        
        if (!$balance)
           return FALSE;
        
        return $balance[0];
    }

    /**
     * @method addLike - добавить пользователю сумму равную 1 лайку
     * 
     * @param int $user_id
     * @param float $amount
     * @return boolean 
     */
    public function addAmount($user_id, $amount) {

        if (!$user_id)
            return false;

        if (!$this->user_id)
            $this->setUser($user_id);

        $balance = $this->getBalance($this->user_id);
        
        if(!$balance)
            return FALSE;
        
        $amount_old = $amount;
        
        $amount = (float)$balance['amount'] + (float)$amount;

        $this->setBalance($this->user_id, $amount);
        
        $this->history = promoLike_balancehistory::getInstance();
         
        $this->transaction_id = $this->history->addRecord($this->user_id, "addAmount", $amount_old);
        
        return TRUE;
    }

    /**
     * @method removeLike - удалить из суммы пользователя сумму равную одному лайку
     * 
     * @param int $user_id
     * @param float $amount
     * @return boolean 
     */
    public function removeAmount($user_id, $amount) {

        if (!$user_id)
            return false;

        if (!$this->user_id)
            $this->setUser($user_id);

        $balance = $this->getBalance($this->user_id);

        if(!$balance)
            return FALSE;
        
        $amount_old = $amount;

        $amount = (float)$balance['amount'] - (float)$amount;

        $this->setBalance($this->user_id, $amount);
        
        $this->history = promoLike_balancehistory::getInstance();
         
        $this->history->addRecord($this->user_id, "removeAmount", $amount_old);
        
        return TRUE;
    }

}
?>
