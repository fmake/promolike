<?
require_once ("./libs/xajax/xajax_core/xajax.inc.php");

$xajax = new xajax();
$xajax->configure('decodeUTF8Input',true);
//$xajax->configure('debug',true);
$xajax->configure('javascript URI','./libs/xajax/');
$xajax->register(XAJAX_FUNCTION,"showListActive");

function showListActive($id_user,$id_place) {
	
	$promoLike_like = new promoLike_likehistory();
	$likes = $promoLike_like->getUserPlaceAll($id_user,$id_place);
	
	
	global $twig,$globalTemplateParam;
	$globalTemplateParam->set('likes',$likes);
	$result = $twig->loadTemplate("webmaster/ajax_list_active.tpl")->render($globalTemplateParam->get());
	
	
	$objResponse = new xajaxResponse();
	
	$objResponse->assign("list-active-place-".$id_place,"innerHTML",$result);
	
    return $objResponse;
}


$xajax->processRequest();


$globalTemplateParam->set('xajax',$xajax);
