<?
require('./libs/FController.php');
require './libs/login.php';
	
if(!$user->isLogined()){
			header("HTTP/1.1 301 Moved Permanently");
			header('Location: /index.php');
}

require './modules/APIvk/vkapi.php';

/*---------------------xajax---------------------------------*/

require_once ("./libs/xajax/xajax_core/xajax.inc.php");

$xajax = new xajax();
$xajax->configure('decodeUTF8Input',true);
//$xajax->configure('debug',true);
$xajax->configure('javascript URI','./libs/xajax/');
$xajax->register(XAJAX_FUNCTION,"showPagesTable");
$xajax->register(XAJAX_FUNCTION,"publicText");

function showPagesTable($id_project,$loop){
	$fmakeProject = new promoLike_project();
	$fmakePage = new promoLike_page();
	$fmakeProject->setId($id_project);
	$project = $fmakeProject->getInfo();
	if($project){
		$pages=$fmakePage->getAllPageUser($project['id_user'], $project[$fmakeProject->idField]);	
		global $twig,$globalTemplateParam;
		$globalTemplateParam->set('pages',$pages);
		$globalTemplateParam->set('id_project',$id_project);
		$text = $twig->loadTemplate("ajax_tpl/show_pages_main_table.tpl")->render($globalTemplateParam->get());
	}
	else{
		$text = '';
	}
	$objResponse = new xajaxResponse();
	$objResponse->assign("table-project".$loop,"innerHTML", $text);
	return $objResponse;
}

function publicText($id_page,$id_user,$id_project) {
	$fmakePage = new promoLike_page();
	$fmakeTekstLike = new promoLike_textlike();
	$fmakeLike = new promoLike_like();
	
	$fmakePage->setId($id_page);
	$page = $fmakePage->getInfo();
	
	
	if($page['id_user']==$id_user && $page['id_project']==$id_project){
		$fmakePage->setEnum('active');
	}
	else{
		return false;
	}
	
	if(!$page['active']){
		/*$api_id = '2629628';
		$vk = new fmakeVkapi();
		//foreach($users as $key=>$user){
			$textpage = $fmakeTekstLike->getRandTextActive($page[$fmakePage->idField]);
			$user['id_user'] = 5;
			$result_publick = $vk->SendMessageWall($api_id,$user['id_user'],2,$textpage,$page['url']);
			
			
		//}
		 */
		$textpages_active = $fmakeTekstLike->getAllTextPage($id_page,true);
		if($textpages_active){
			foreach($textpages_active as $key=>$item){
				$isItem = $fmakeLike->isTextLikeStatus($item[$fmakeTekstLike->idField],'2');
				if(!$isItem['count']){
					$fmakeLike->addLike($item[$fmakeTekstLike->idField]);
				}
				else{
					$fmakeLike->setId($isItem[$fmakeLike->idField]);
					$fmakeLike->changeStatus(1);
				}
			}
		}
		else{
			$fmakePage->setEnum('active');
		}
	}
	else{
		$likes_page = $fmakeLike->getPageStatus($id_page,1);
		if($likes_page)foreach ($likes_page as $key=>$item){
			$fmakeLike->setId($item[$fmakeLike->idField]);
			$fmakeLike->changeStatus(2);
		}
	}
	
	
	$objResponse = new xajaxResponse();
	if($result_publick->error) $objResponse->assign('error_api','innerHTML','error');
	if($page['active']) $objResponse->assign("active".$page[$fmakePage->idField],"src", "/images/control_pause_blue.png");
	else $objResponse->assign("active".$page[$fmakePage->idField],"src", "/images/control_play_blue.png");
	
	return $objResponse;
}

$xajax->processRequest();
$globalTemplateParam->set('xajax',$xajax);

/*---------------------xajax---------------------------------*/

$fmakeFilter = new promoLike_filter();

$fmakeProject = new promoLike_project();
$fmakePage = new promoLike_page();
$projects = $fmakeProject->getAllProject($user->id);
$size = sizeof($projects);
/*for($i=0;$i<$size;$i++){
	$pages[$i]=$fmakePage->getAllPageUser($user->id, $projects[$i][$fmakeProject->idField]);
}*/
//printAr($pages);
//echo($fmakeFilter->summBudgetPage(5,1));
//exit();
$globalTemplateParam->set('projects',$projects);
//$globalTemplateParam->set('pages',$pages);
$globalTemplateParam->set('fmakeFilter',$fmakeFilter);

$template = "project/index.tpl";
$template = $twig->loadTemplate($template);
$template->display($globalTemplateParam->get());
?>