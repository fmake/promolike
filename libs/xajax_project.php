<?
require_once ("./libs/xajax/xajax_core/xajax.inc.php");

$xajax = new xajax();
$xajax->configure('decodeUTF8Input',true);
//$xajax->configure('debug',true);
$xajax->configure('javascript URI','./libs/xajax/');
$xajax->register(XAJAX_FUNCTION,"addPage");
$xajax->register(XAJAX_FUNCTION,"editPage");
$xajax->register(XAJAX_FUNCTION,"updatePage");
$xajax->register(XAJAX_FUNCTION,"deletePage");
$xajax->register(XAJAX_FUNCTION,"getTextPage");
$xajax->register(XAJAX_FUNCTION,"addTextPage");
$xajax->register(XAJAX_FUNCTION,"editTextPage");
$xajax->register(XAJAX_FUNCTION,"updateTextPage");
$xajax->register(XAJAX_FUNCTION,"deleteTextPage");
$xajax->register(XAJAX_FUNCTION,"publicVKtext");
$xajax->register(XAJAX_FUNCTION,"activeText");
$xajax->register(XAJAX_FUNCTION,"showPagesTable");
$xajax->register(XAJAX_FUNCTION,"showTextsPage");
$xajax->register(XAJAX_FUNCTION,"publicText");
$xajax->register(XAJAX_FUNCTION,"addMoreText");
$xajax->register(XAJAX_FUNCTION,"getPlaceStat");

function getPlaceStat($type,$id,$status){
	$fmakeProject = new promoLike_project();
	$fmakePage = new promoLike_page();
	$fmakeTextLike = new promoLike_textlike();
	$fmakeLike = new promoLike_like();
	/*социальные сети*/
	$SocialSet = new promoLike_socialset();
	$SocialSet->table = $SocialSet->table_name;
	$full_soc_set = $SocialSet->getAll(true);
	/*социальные сети*/	
	switch ($type){
		case 'project':
			if($full_soc_set)foreach ($full_soc_set as $key=>$item){
				if($status == '1') $count_like = $fmakeLike->getQuery("(`status`='1' OR `status`='2') AND `id_place`!='0' AND `id_place`='{$item[$SocialSet->idField]}' AND `{$fmakePage->idField}` in (SELECT `{$fmakePage->idField}` FROM `{$fmakePage->table}` WHERE `{$fmakeProject->idField}`='{$id}')","COUNT(*)",true);
				else $count_like = $fmakeLike->getQuery("(`status`='3' OR `status`='4') AND `id_place`!='0' AND `id_place`='{$item[$SocialSet->idField]}' AND `{$fmakePage->idField}` in (SELECT `{$fmakePage->idField}` FROM `{$fmakePage->table}` WHERE `{$fmakeProject->idField}`='{$id}')","COUNT(*)",true);
				$full_soc_set[$key]['count_like'] = ($count_like[0]['COUNT(*)'])? $count_like[0]['COUNT(*)']:0;
			}
			break;
		case 'page':
			if($full_soc_set)foreach ($full_soc_set as $key=>$item){
				if($status == '1') $count_like = $fmakeLike->getQuery("(`status`='1' OR `status`='2') AND `id_place`!='0' AND `id_place`='{$item[$SocialSet->idField]}' AND `{$fmakePage->idField}`='{$id}'","COUNT(*)",true);
				else $count_like = $fmakeLike->getQuery("(`status`='3' OR `status`='4') AND `id_place`!='0' AND `id_place`='{$item[$SocialSet->idField]}' AND `{$fmakePage->idField}`='{$id}'","COUNT(*)",true);
				$full_soc_set[$key]['count_like'] = ($count_like[0]['COUNT(*)'])? $count_like[0]['COUNT(*)']:0;
			}
			break;
		case 'text':
			if($full_soc_set)foreach ($full_soc_set as $key=>$item){
				if($status == '1') $count_like = $fmakeLike->getQuery("(`status`='1' OR `status`='2') AND `id_place`!='0' AND `id_place`='{$item[$SocialSet->idField]}' AND `{$fmakeTextLike->idField}`='{$id}'","COUNT(*)",true);
				else $count_like = $fmakeLike->getQuery("(`status`='3' OR `status`='4') AND `id_place`!='0' AND `id_place`='{$item[$SocialSet->idField]}' AND `{$fmakeTextLike->idField}`='{$id}'","COUNT(*)",true);
				$full_soc_set[$key]['count_like'] = ($count_like[0]['COUNT(*)'])? $count_like[0]['COUNT(*)']:0;
			}
			break;
		default:
			$count_like = false;
			break;
	}
	//printAr($full_soc_set);
	global $twig,$globalTemplateParam;
	$globalTemplateParam->set('full_soc_set',$full_soc_set);
	$text = $twig->loadTemplate("ajax_tpl/popup_stat_main_place.tpl")->render($globalTemplateParam->get());
	$objResponse = new xajaxResponse();
	$objResponse->assign("popup","innerHTML", $text);
	return $objResponse;
}

function addMoreText(){
	/*социальные сети*/
	$SocialSet = new promoLike_socialset();
	$SocialSet->table = $SocialSet->table_name;
	$full_soc_set = $SocialSet->getAll(true);
	/*социальные сети*/	
	
	global $twig,$globalTemplateParam;
	$globalTemplateParam->set('full_soc_set',$full_soc_set);
	$text = $twig->loadTemplate("ajax_tpl/form_more_text_page.tpl")->render($globalTemplateParam->get());

	$objResponse = new xajaxResponse();
	$objResponse->assign("add_more_text","outerHTML", $text);//('$(\'#form_create_text #add-text\').parent().parent().before('.$text.');');
	return $objResponse;
}

function showPagesTable($id_project,$loop){
	$fmakeProject = new promoLike_project();
	$fmakePage = new promoLike_page();
	$fmakeLike = new promoLike_like();
	$fmakeProject->setId($id_project);
	$project = $fmakeProject->getInfo();
	if($project){
		$pages=$fmakePage->getAllPageUser($project['id_user'], $project[$fmakeProject->idField]);
		if($pages)foreach ($pages as $key=>$item){
			$count_like = $fmakeLike->getQuery("(`status`='3' OR `status`='4') AND `id_place`!='0' AND `{$fmakePage->idField}`='{$item[$fmakePage->idField]}'","COUNT(*)",true);
			$pages[$key]['stat']['count_like'] = ($count_like[0]['COUNT(*)'])? $count_like[0]['COUNT(*)']:0;
			$count_zayavka = $fmakeLike->getQuery("(`status`='1' OR `status`='2') AND `id_place`!='0' AND `{$fmakePage->idField}`='{$item[$fmakePage->idField]}'","COUNT(*)",true);
			$pages[$key]['stat']['count_zayavka'] = ($count_zayavka[0]['COUNT(*)'])? $count_zayavka[0]['COUNT(*)']:0;
		}	
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

function showTextsPage($id_page){
	$fmakeProject = new promoLike_project();
	$fmakeTextLike = new promoLike_textlike();
	$fmakeLike = new promoLike_like();
	$texts = $fmakeTextLike->getAllTextPage($id_page);
	if($texts)foreach ($texts as $key=>$item){
		$count_like = $fmakeLike->getQuery("(`status`='3' OR `status`='4') AND `id_place`!='0' AND `{$fmakeTextLike->idField}`='{$item[$fmakeTextLike->idField]}'","COUNT(*)",true);
		$texts[$key]['stat']['count_like'] = ($count_like[0]['COUNT(*)'])? $count_like[0]['COUNT(*)']:0;
		$count_zayavka = $fmakeLike->getQuery("(`status`='1' OR `status`='2') AND `id_place`!='0' AND `{$fmakeTextLike->idField}`='{$item[$fmakeTextLike->idField]}'","COUNT(*)",true);
		$texts[$key]['stat']['count_zayavka'] = ($count_zayavka[0]['COUNT(*)'])? $count_zayavka[0]['COUNT(*)']:0;
	}
	$fmakePage = new promoLike_page();
	$fmakePage->setId($id_page);
	$page = $fmakePage->getInfo();
	global $twig,$globalTemplateParam;
	$globalTemplateParam->set('texts',$texts);
	$globalTemplateParam->set('page',$page);
	$globalTemplateParam->set('id_project',$page[$fmakeProject->idField]);
	$text = $twig->loadTemplate("ajax_tpl/show_textlike_pages_main_table.tpl")->render($globalTemplateParam->get());

	$objResponse = new xajaxResponse();
	$objResponse->assign("textlikes-page".$id_page,"innerHTML", $text);
	return $objResponse;
}

function publicText($id_page,$id_text_like,$id_user,$id_project) {
	$fmakePage = new promoLike_page();
	$fmakeTekstLike = new promoLike_textlike();
	$fmakeLike = new promoLike_like();
	
	$fmakePage->setId($id_page);
	$page = $fmakePage->getInfo();
	$fmakeTekstLike->setId($id_text_like);
	$text_like_info = $fmakeTekstLike->getInfo();
	
	if(!($page['id_user']==$id_user && $page['id_project']==$id_project)){
		return false;
	}
	else{
		$fmakeTekstLike->setEnum('publick_active');
	}
	if(!$text_like_info['publick_active']){
		$fmakeLike->addLike($id_text_like);
	}
	else{
		$fmakeLike->pauseLike($id_text_like);
	}

	$objResponse = new xajaxResponse();
	if($result_publick->error) $objResponse->assign('error_api','innerHTML','error');
	
	if($text_like_info['publick_active']) $objResponse->assign("text_pub_active".$id_text_like,"src", "/images/control_pause_blue.png");
	else $objResponse->assign("text_pub_active".$id_text_like,"src", "/images/control_play_blue.png");
	return $objResponse;
}

function addTextPage($param,$action = false) {
	$fmakePage = new promoLike_page();
	$fmakeProject = new promoLike_project();
	$fmakeUser = new fmakeSiteUser();
	$fmakeTekstLike = new promoLike_textlike();
	$id_project = $param['id_project'];
	$id_user = $param['id_user'];
	$objResponse = new xajaxResponse();
	$flag = true;
	$count_array_name = sizeof($param['pagetitle']);
	if($count_array_name>1){
		foreach($param['pagetitle'] as $param_name){
			if(!$param_name){
				$flag = false;
				break;
			}  
		}
	}

	if($flag){
		$size = sizeof($param['pagetitle']);
		for($i=0;$i<$size;$i++){
			$fmakeTekstLike->addParam('id_page', $param['id_page']);
			$fmakeTekstLike->addParam('caption', $param['pagetitle'][$i]);
			$fmakeTekstLike->addParam('text_like', $param['text'][$i]);
			$fmakeTekstLike->newItem();		
			$fmakeTekstLike -> addPreviewFoto($_FILES['image'.$i]);
		}
		
		if($action){
			$objResponse->script('document.location = document.getElementById("next_link").href;');
		}
		else{
			
			$pages = $fmakePage->getAllPageUser($id_user,$id_project);
			$textlikes = $fmakeTekstLike->getAllTextPage($param['id_page']);
			
			global $twig,$globalTemplateParam;
			$globalTemplateParam->set('textlikes',$textlikes);
			$all_textpage_user = $twig->loadTemplate("ajax_tpl/add_text_page.tpl")->render($globalTemplateParam->get());
			
			global $twig,$globalTemplateParam;
			$globalTemplateParam->set('pages',$pages);
			$form_textpage = $twig->loadTemplate("ajax_tpl/form_text_page.tpl")->render($globalTemplateParam->get());
			
			$objResponse->assign("page_textlike","innerHTML", $all_textpage_user);
			$objResponse->assign("form-table","innerHTML", $form_textpage);
		}
	}
	else{
		$objResponse->alert('Название текста обязательно для заполнения');
	}
    return $objResponse;
}

function getTextPage($id_page){
	$fmakePage = new promoLike_page();
	$fmakePage->setId($id_page);
	$page = $fmakePage->getInfo();
	$fmakeTekstLike = new promoLike_textlike();
	$textlikes = $fmakeTekstLike->getAllTextPage($id_page);
	if($textlikes){
		global $twig,$globalTemplateParam;
		$globalTemplateParam->set('textlikes',$textlikes);
		$globalTemplateParam->set('id_page',$id_page);
		$globalTemplateParam->set('id_project',$page[id_project]);
		$globalTemplateParam->set('id_user',$page[id_user]);
		$text_likes = $twig->loadTemplate("ajax_tpl/add_text_page.tpl")->render($globalTemplateParam->get());
		
	}
	else{
		$text_likes .='<tr><td colspan="3"><h2>нет страниц</h2></td></tr>'; 
	}
	$objResponse = new xajaxResponse();
	$objResponse->assign("page_textlike","innerHTML", $text_likes);
	return $objResponse;
}

function editTextPage($id_textpage,$id_user,$id_project){
	$fmakePage = new promoLike_page();
	$fmakeProject = new promoLike_project();
	$fmakeUser = new fmakeSiteUser();
	$fmakeTekstLike = new promoLike_textlike();
	
	$fmakeTekstLike->setId($id_textpage);
	$textpage = $fmakeTekstLike->getInfo();

	$pages = $fmakePage->getAllPageUser($id_user,$id_project);

	/*социальные сети*/
	$SocialSet = new promoLike_socialset();
	$SocialSet->table = $SocialSet->table_name;
	$full_soc_set = $SocialSet->getAll(true);
	$SocialSet = new promoLike_socialset();
	$active_soc_set = $SocialSet->getSocialSetFilter($id_textpage);
	
	$promoLike_like = new promoLike_like();
	foreach ($full_soc_set as $item){
		$count = $promoLike_like->getTextPlaceStatus($id_textpage, $item[$SocialSet->idField],4,"COUNT(*)");
		$count2 = $promoLike_like->getTextPlaceStatus($id_textpage, $item[$SocialSet->idField],3,"COUNT(*)");
		$publick_soc_set[$item[$SocialSet->idField]] = $count[0]["COUNT(*)"];
		$chek_publick_soc_set[$item[$SocialSet->idField]] = $count2[0]["COUNT(*)"];	
	}
	
	/*социальные сети*/
	
	global $twig,$globalTemplateParam;
	$globalTemplateParam->set('pages',$pages);
	$globalTemplateParam->set('textpage',$textpage);
	$globalTemplateParam->set('id_project',$id_project);
	$globalTemplateParam->set('id_user',$id_user);
	$globalTemplateParam->set('full_soc_set',$full_soc_set);
	$globalTemplateParam->set('active_soc_set',$active_soc_set);
	$globalTemplateParam->set('publick_soc_set',$publick_soc_set);
	$globalTemplateParam->set('chek_publick_soc_set',$chek_publick_soc_set);
	$all_params_page = $twig->loadTemplate("ajax_tpl/form_text_page_edit.tpl")->render($globalTemplateParam->get());
	
	$objResponse = new xajaxResponse();
	$objResponse->assign("form-table","innerHTML",$all_params_page);
	$objResponse->script("$('body,html').animate({scrollTop: 240}, 800);");
    return $objResponse;
}

function deleteTextPage($id_page,$id_textpage){
	$fmakePage = new promoLike_page();
	$fmakePage->setId($id_page);
	$page = $fmakePage->getInfo();
	$fmakeProject = new promoLike_project();
	$fmakeUser = new fmakeSiteUser();
	$fmakeTekstLike = new promoLike_textlike();
	
	$fmakeTekstLike->setId($id_textpage);
	$textpage = $fmakeTekstLike->getInfo();
	
	$fmakeTekstLike->deleteTextPage($id_textpage,$id_page);
	
	$textlikes = $fmakeTekstLike->getAllTextPage($id_page);
	if($textlikes){
		global $twig,$globalTemplateParam;
		$globalTemplateParam->set('textlikes',$textlikes);
		$globalTemplateParam->set('id_page',$id_page);
		$globalTemplateParam->set('id_project',$page[id_project]);
		$globalTemplateParam->set('id_user',$page[id_user]);
		$text_likes = $twig->loadTemplate("ajax_tpl/add_text_page.tpl")->render($globalTemplateParam->get());		
	}
	else{
		$text_likes .='<tr><td colspan="3"><h2>нет страниц</h2></td></tr>'; 
	}
	$objResponse = new xajaxResponse();
	$objResponse->assign("page_textlike","innerHTML", $text_likes);
	

    return $objResponse;
}

function updateTextPage($param,$action = false){
	$fmakePage = new promoLike_page();
	$fmakeProject = new promoLike_project();
	$fmakeUser = new fmakeSiteUser();
	$fmakeTekstLike = new promoLike_textlike();
	$id_project = $param['id_project'];
	$id_user = $param['id_user'];	
	$fmakePage->setId($param['id_page']);
	if($param['pagetitle']!=''){
		$fmakeTekstLike->setId($param['id_text_page']);
		$fmakeTekstLike->addParam('id_page', $param['id_page']);
		$fmakeTekstLike->addParam('caption', $param['pagetitle']);
		$fmakeTekstLike->addParam('text_like', $param['text']);
		$fmakeTekstLike->update();		
		if($_FILES['image']['name']) $fmakeTekstLike -> addPreviewFoto($_FILES['image']);
		
		$objResponse = new xajaxResponse();
		//$objResponse->alert($param['image']);
		if($action){
			$objResponse->script('document.location = document.getElementById("next_link").href;');
		}
		else{
			$pages = $fmakePage->getAllPageUser($id_user,$id_project);
			global $twig,$globalTemplateParam;
			$globalTemplateParam->set('pages',$pages);
			$all_params_page = $twig->loadTemplate("ajax_tpl/form_text_page.tpl")->render($globalTemplateParam->get());
						
			$textlikes = $fmakeTekstLike->getAllTextPage($param['id_page']);
			if($textlikes){
				global $twig,$globalTemplateParam;
				$globalTemplateParam->set('textlikes',$textlikes);
				$globalTemplateParam->set('id_page',$param['id_page']);
				$globalTemplateParam->set('id_project',$id_project);
				$globalTemplateParam->set('id_user',$id_user);
				$text_likes = $twig->loadTemplate("ajax_tpl/add_text_page.tpl")->render($globalTemplateParam->get());
			}
			
			$objResponse->assign("page_textlike","innerHTML", $text_likes);
			$objResponse->assign("form-table","innerHTML", $all_params_page);
			$objResponse->alert('страница "'.$param['pagetitle'].'" добавлена/отредактирована');
			if($param['update']) $objResponse->script("document.location = '/project.php?id_project=".$id_project."&action=add_text'");
		}
	}
	else{
		$objResponse->alert('Заголовок обязателен для заполнения');
	}
	return $objResponse;
}


function addPage($param,$action = false) {
	$fmakePage = new promoLike_page();
	$fmakeProject = new promoLike_project();
	$fmakeUser = new fmakeSiteUser();
	$fmakeTekstLike = new promoLike_textlike();
	$id_project = $param['id_project'];
	$id_user = $param['id_user'];
	$objResponse = new xajaxResponse();
	$flag = true;
	$count_array_name = sizeof($param['name']);

	foreach($param['name'] as $param_name){
		if(!$param_name){
			$flag = false;
			break;
		}  
	}

	//printAr($param);
	if($flag){
		foreach($param['name'] as $param_name){
			if($fmakePage->isPage($id_user, $id_project, $param_name)){
				$objResponse = new xajaxResponse();
				$objResponse->alert('Смените название страницы. Вы повторяетесь.');		
				return $objResponse;
			}
		}
		$size = $count_array_name;
		for($i=0;$i<$size;$i++){
			$fmakePage->addParam($fmakeProject->idField, $id_project);
			$fmakePage->addParam($fmakeUser->idField, $id_user);
			$fmakePage->addParam('caption', $param['name'][$i]);
			$fmakePage->addParam('url', $param['page_url'][$i]);
			$fmakePage->newItem();	
		}
		
		
		
		
		if($action){
			$objResponse->script('document.location = document.getElementById("next_link").href;');
		}
		else{
			
			$pages = $fmakePage->getAllPageUser($id_user,$id_project);

			global $twig,$globalTemplateParam;
			$globalTemplateParam->set('pages',$pages);
			$globalTemplateParam->set('id_project',$id_project);
			$globalTemplateParam->set('id_user',$id_user);
			$all_page_user = $twig->loadTemplate("ajax_tpl/add_page.tpl")->render($globalTemplateParam->get());
			
			global $twig,$globalTemplateParam;
			$globalTemplateParam->set('id_project',$id_project);
			$add_page = $twig->loadTemplate("ajax_tpl/form_page.tpl")->render($globalTemplateParam->get());
			$objResponse->assign("all_pages","innerHTML", $all_page_user);
			$objResponse->assign("form-table","innerHTML", $add_page);
		}
	}
	else{
		$objResponse->alert('Название страницы обязательно для заполнения');
	}
    return $objResponse;
}

function editPage($id_page,$id_user,$id_project) {
	$fmakePage = new promoLike_page();
	$fmakeProject = new promoLike_project();
	$fmakeUser = new fmakeSiteUser();
	$fmakeTekstLike = new promoLike_textlike();
	
	$fmakePage->setId($id_page);
	$page = $fmakePage->getInfo();
	$alltextlike = $fmakeTekstLike->getAllTextPage($page[$fmakePage->idField]);
	global $twig,$globalTemplateParam;
	$globalTemplateParam->set('page',$page);
	$globalTemplateParam->set('id_project',$id_project);
	$all_params_page = $twig->loadTemplate("ajax_tpl/form_page_edit.tpl")->render($globalTemplateParam->get());
	
	$objResponse = new xajaxResponse();
	$objResponse->assign("form-table","innerHTML",$all_params_page);

    return $objResponse;
}
function deletePage($id_page,$id_user,$id_project) {
	$fmakePage = new promoLike_page();
	$fmakeProject = new promoLike_project();
	$fmakeUser = new fmakeSiteUser();
	$fmakeTekstLike = new promoLike_textlike();
	
	$fmakePage->setId($id_page);
	$pages = $fmakePage->getInfo();
	$alltextlike = $fmakeTekstLike->getAllTextPage($pages[$fmakePage->idField]);

	$fmakePage->deletePage($id_page,$id_user,$id_project);
	
	$pages = $fmakePage->getAllPageUser($id_user,$id_project);

	global $twig,$globalTemplateParam;
	$globalTemplateParam->set('pages',$pages);
	$globalTemplateParam->set('id_project',$id_project);
	$globalTemplateParam->set('id_user',$id_user);
	$all_page_user = $twig->loadTemplate("ajax_tpl/add_page.tpl")->render($globalTemplateParam->get());
	
	
	$objResponse = new xajaxResponse();
	$objResponse->assign("all_pages","innerHTML", $all_page_user);

    return $objResponse;
}

function updatePage($param,$action = false) {
	$fmakePage = new promoLike_page();
	$fmakeProject = new promoLike_project();
	$fmakeUser = new fmakeSiteUser();
	$fmakeTekstLike = new promoLike_textlike();
	$id_project = $param['id_project'];
	$id_user = $param['id_user'];	
	$fmakePage->setId($param['id_page']);
	if($param['name']!=''){
		$fmakePage->addParam($fmakeProject->idField, $id_project);
		$fmakePage->addParam($fmakeUser->idField, $id_user);
		$fmakePage->addParam('caption', $param['name']);
		$fmakePage->addParam('url', $param['page_url']);
		$fmakePage->update();
	
		
		$objResponse = new xajaxResponse();
		if($action){
			$objResponse->script('document.location = document.getElementById("next_link").href;');
		}
		else{
			$pages = $fmakePage->getAllPageUser($id_user,$id_project);
			global $twig,$globalTemplateParam;
			$globalTemplateParam->set('pages',$pages);
			$globalTemplateParam->set('id_project',$id_project);
			$globalTemplateParam->set('id_user',$id_user);
			$all_page_user = $twig->loadTemplate("ajax_tpl/add_page.tpl")->render($globalTemplateParam->get());
				
			global $twig,$globalTemplateParam;
			$globalTemplateParam->set('id_project',$id_project);
			$add_page = $twig->loadTemplate("ajax_tpl/form_page.tpl")->render($globalTemplateParam->get());
		
			$objResponse->assign("all_pages","innerHTML", $all_page_user);
			$objResponse->assign("form-table","innerHTML", $add_page);
			$objResponse->alert('страница "'.$param['name'].'" добавлена/отредактирована');
			if($param['update']) $objResponse->script("document.location = '/project.php?id_project=".$id_project."&action=add_page'");
		}
	}
	else{
		$objResponse->alert('Название страницы обязательно для заполнения');
	}
	return $objResponse;
}

function publicVKtext($id_page,$id_textpage,$id_user,$id_project) {
	$fmakePage = new promoLike_page();
	//$fmakeProject = new promoLike_project();
	$fmakeUserSocial = new fmakeSiteUser();
	$fmakeUserSocial->table = $fmakeUserSocial->table_social;
	$users = $fmakeUserSocial->getAll();
	$fmakeTekstLike = new promoLike_textlike();
	
	$fmakePage->setId($id_page);
	$page = $fmakePage->getInfo();
	$fmakeTekstLike->setId($id_textpage);
	$textpage = $fmakeTekstLike->getInfo();
	
	$api_id = '2629628';
	$vk = new fmakeVkapi();
	//foreach($users as $key=>$user){
		$user['id_user'] = 5;
		$vk->SendMessageWall($api_id,$user['id_user'],2,$textpage,$page['url']);
	//}
	
	
	$objResponse = new xajaxResponse();
	
	$objResponse->alert($textpage['text_like']);
	
	return $objResponse;
}
function activeText($id_page,$id_textpage,$id_user,$id_project) {
	$fmakePage = new promoLike_page();
	$fmakeTekstLike = new promoLike_textlike();
	
	$fmakeTekstLike->setId($id_textpage);
	$textpage = $fmakeTekstLike->getInfo();
	
	$fmakePage->setId($textpage['id_page']);
	$page = $fmakePage->getInfo();
	
	
	if($page['id_user']==$id_user && $page['id_project']==$id_project){
		$fmakeTekstLike->setEnum('active');
	}
	
	$objResponse = new xajaxResponse();
	
	if($textpage['active']) $objResponse->assign("active".$textpage[$fmakeTekstLike->idField],"src", "/images/off.gif");
	else $objResponse->assign("active".$textpage[$fmakeTekstLike->idField],"src", "/images/on.gif");
	
	return $objResponse;
}

$xajax->processRequest();


$globalTemplateParam->set('xajax',$xajax);
