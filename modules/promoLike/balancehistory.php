<?php
/**
 * История баланса пользователя
 *
 * @author fredrsf
 */
class promoLike_balancehistory extends promoLike_balance {

    private static $instance; // экземпляр класса
    public $table = "balance";// таблица в бд
    public $order = false;
    public $idField = "id_transaction";

    /**
     * @static метод синглтон для получения единственного экземпляра объекта
     * @return Object экземпляр класса promoLike_balance
     */    
    public static function getInstance() {
        if (self::$instance == null)
            self::$instance = new promoLike_balanceHistory();

        return self::$instance;
    }
    
    public function addRecord($user_id, $operation = "change", $amount = 0.00, $status = '2'){
        
        if (!$user_id)
            return FALSE;

        $select = $this->dataBase->SelectFromDB(__LINE__);
        
	$balance =  $select->addFrom($this->table)->addWhere('id_user = ' . $user_id)->queryDB();
        
        if (!$balance)
            return FALSE;
        
        $this->table = "balance_history";
        
        $id_balance = $balance[0]['id_balance'];
        
        $this->addParam("id_balance", $id_balance);
        $this->addParam("date_transaction", date("Y-m-d H:i:s", time()));
        $this->addParam("message", $this->generateMessage($operation));
        $this->addParam("amount", $amount);
        $this->addParam("status", $status);
        
        $this->id = FALSE;
        
        $this->newItem();
        
        $this->table = "balance";
        
        if (!$this->id)
            return FALSE;
  	
        return $this->id;
    }
    
    public function getRecord($id){
        if (!$id)
            return FALSE;
        
        $select = $this->dataBase->SelectFromDB(__LINE__);
        $this->table = "balance_history";
        
	$result =  $select->addFrom($this->table)->addWhere('id_transaction = ' . $id)->queryDB();
        
        if(!$result)
            return false;
        
        $this->table = "balance";
        
        return $result[0];
    }
    
    public function updateRecord($id){
        if (!$id)
            return FALSE;
        
        $this->table = "balance_history";
        
        $this->addParam("status", '1');
        
        $this->updateWithParam("id_transaction", $id);
        
        $this->table = "balance";
        
        return TRUE;
    }
    
    private function generateMessage($operation){
        
        if(!$operation)
            $operation = "change";
        
        switch ($operation){
            case "create" : $this->message = "Создание балланса.";
                break;
            case "change" : $this->message = "Изменение балланса.";
                break;
            case "addAmount" : $this->message = "Добавление к текущему балансу.";
                break;
            case "removeAmount" : $this->message = "Удаление из текущего баланса.";
        }
        
        return $this->message;
    }

}
?>
