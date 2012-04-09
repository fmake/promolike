<?php
require ('./libs/FController.php');
require './libs/login.php';

if(!$user->isLogined()){
			header("HTTP/1.1 301 Moved Permanently");
			header('Location: /index.php');
}

/*-------активность главного меню--------*/
$active_menu = 0;
$globalTemplateParam->set('active_menu',$active_menu);
/*-------активность главного меню--------*/

$id = $user->id;

if ($id){

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        
            $amount = !empty($_POST['amount']) ? abs((int)$_POST['amount']) : NULL;
            $balance_obj = promoLike_balancehistory::getInstance();

            $transaction_id = $balance_obj->addRecord($id, "addAmount", $amount, '0');

            $sMerchantLogin = 'fredrsf'; // login
            $sMerchantPass1 = '123'; // пароль
            $nOutSum = number_format($amount, 2); // требуемая к получению сумма.
            $nInvId = (int)$transaction_id; // номер транзакции
            $sInvDesc = 'Пополнение баланса пользователя'; //описание покупки
            $sSignatureValue = md5("$sMerchantLogin:$nOutSum:$nInvId:$sMerchantPass1"); // контрольная сумма MD5(обязательный параметр)
            //$Shp_item = '';
            $sIncCurrLabel = 'PCR'; // предлагаемая валюта платежа.
            $sCulture = 'ru'; // опционально, язык общения с клиентом.  
            
            $form = <<<HEREDOC
 <form action='http://test.robokassa.ru/Index.aspx' method="POST">
<input type="hidden" name="MrchLogin" value="$sMerchantLogin">
<input type="hidden" name="OutSum" value="$nOutSum">
<input type="hidden" name="InvId" value="$nInvId">
<input type="hidden" name="Desc" value="$sInvDesc">
<input type="hidden" name="SignatureValue" value="$sSignatureValue">
<input type="hidden" name="IncCurrLabel" value="$sIncCurrLabel">
<input type="hidden" name="Culture" value="$sCulture">
Баланс будет пополнен на сумму: $amount рублей. <input type="submit" value="Продолжить">
</form>   
HEREDOC;
      echo $form;                   
    }
    else{
        $OutSum = !empty($_REQUEST['OutSum']) ? $_REQUEST['OutSum'] : NULL;
        $InvId = !empty($_REQUEST['InvId']) ? $_REQUEST['InvId'] : NULL;
        $SignatureValue = !empty($_REQUEST['SignatureValue']) ? $_REQUEST['SignatureValue'] : NULL;

        if($OutSum && $InvId && $SignatureValue){
            
            $balance_history_obj = promoLike_balancehistory::getInstance();
            $transaction = $balance_history_obj->getRecord($InvId);
            
            if(!$transaction)
                exit('Error!');
            
            if($transaction['status'] !== '0')
                exit('Error!');
            
            if($OutSum !== $transaction['amount'])
                exit('Error!');
            
            $sMerchantLogin = 'fredrsf'; // login
            $sMerchantPass1 = '123'; // пароль
            $amount = $transaction['amount'];
            $control_sum =     md5("$sMerchantLogin:$amount:$InvId:$sMerchantPass1");

            if($control_sum != $SignatureValue)
                exit('Error!');
            
            $balance_obj = promoLike_balance::getInstance();
            $balance_obj->addAmount($id, $OutSum);
            $balance_history_obj->updateRecord($InvId);
            
            header('Location: /lk.php');
        }
        $template = "lk/robokassa.tpl";
        $template = $twig->loadTemplate($template);
        $template->display($globalTemplateParam->get());
    }

}
?>
