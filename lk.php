<?
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
    
    $like_obj = new promoLike_like();
    $like = $like_obj->getAllNewLikes($id);
    
    printAr($like);
    
    $like_text = $like['like_text'];
    
    //$balance_obj = promoLike_balance::getInstance();
    
    //$res = $balance_obj->getBalance($id);
    //$balance = $res['amount']; 

    //$globalTemplateParam->set('balance',$balance);

}

$globalTemplateParam->set('payments',$payments);

$template = "lk/main.tpl";
$template = $twig->loadTemplate($template);
$template->display($globalTemplateParam->get());
?>