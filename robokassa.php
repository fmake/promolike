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
    
        $balance_obj->addAmount($id, 0.00);
        $transaction_id = $balance_obj->transaction_id;
        
        $sMerchantLogin = 'demo'; // login
        $sMerchantPass1 = '123'; // пароль
        $nOutSum = ''; // требуемая к получению сумма.
        $nInvId = (int)$transaction_id; // номер транзакции
        $sInvDesc = 'Пополнение баланса пользователя'; //описание покупки
        $sSignatureValue = md5("$sMerchantLogin:$nOutSum:$nInvId:$sMerchantPass1"); // контрольная сумма MD5(обязательный параметр)
        //$Shp_item = '';
        $sIncCurrLabel = 'PCR'; // предлагаемая валюта платежа.
        $sCulture = 'ru'; // опционально, язык общения с клиентом.

/*
 <form action='https://merchant.roboxchange.com/Index.aspx' method="POST">
<input type="hidden" name="MrchLogin" value="{sMerchantLogin}">
<input type="hidden" name="OutSum" value="{nOutSum}">
<input type="hidden" name="InvId" value="{nInvId}">
<input type="hidden" name="Desc" value="{sInvDesc}">
<input type="hidden" name="SignatureValue" value="{sSignatureValue}">
<input type="hidden" name="IncCurrLabel" value="{sIncCurrLabel}">
<input type="hidden" name="Culture" value="{sCulture}">
<input type="submit" value="Пополнить баланс">
</form>
 */



// коннект к робокассе конец

$globalTemplateParam->set('balance',$balance);

}

$globalTemplateParam->set('payments',$payments);

$template = "lk/main.tpl";
$template = $twig->loadTemplate($template);
$template->display($globalTemplateParam->get());
?>
