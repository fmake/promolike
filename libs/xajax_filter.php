<?
require_once ("./libs/xajax/xajax_core/xajax.inc.php");

$xajax = new xajax(); 
$xajax->configure('decodeUTF8Input',true);
//$xajax->configure('debug',true);
$xajax->configure('javascript URI','./libs/xajax/');
$xajax->register(XAJAX_FUNCTION,"changePage");
$xajax->register(XAJAX_FUNCTION,"deleteFilter");
$xajax->register(XAJAX_FUNCTION,"editFilter");
$xajax->register(XAJAX_FUNCTION,"createFilterForm");
$xajax->register(XAJAX_FUNCTION,"Otmena");
$xajax->register(XAJAX_FUNCTION,"attachFilterPage");


function changePage($id_page,$id_user) {
	$promoLikeFilterPage = new promoLike_pagefilter();
	$fmakeFilter = new promoLike_filter();
	$filters_page = $promoLikeFilterPage->getFiltersPageUser($id_page,$id_user);
	
	$filters = $fmakeFilter->getNoUsedFilterUser($id_user,$id_page);
	global $twig,$globalTemplateParam;
	$globalTemplateParam->set('filters',$filters);
	$all_filters = $twig->loadTemplate("ajax_tpl/list_filters.tpl")->render($globalTemplateParam->get());
	
	

	if($filters_page){
		$promoLikeSocialSet = new promoLike_socialset();
		
		foreach($filters_page as $key=>$filt){
			$filters_page[$key]['socialset'] = $promoLikeSocialSet->getSocialSetFilter($filt[$fmakeFilter->idField]); 
		}
	}
	global $twig,$globalTemplateParam;
	$globalTemplateParam->set('filters_page',$filters_page);
	$all_filters_page = $twig->loadTemplate("ajax_tpl/filters.tpl")->render($globalTemplateParam->get());
	
	$objResponse = new xajaxResponse();
	
	$objResponse->assign("id_no_used_filter","innerHTML", $all_filters);
	$objResponse->assign("all_filters_pages","innerHTML", $all_filters_page);
	$objResponse->assign("create_button","innerHTML", '<a onclick="createFilter('.$id_page.');return false;" class="btn primary-padding" href="#">
															<span class="f20 primary-green">
																<span>Создать фильтр</span>
															</span>
														</a>');
	
	
    return $objResponse;
}

function deleteFilter($id_page,$id_filter,$id_user) {
	$promoLikeSocialSet = new promoLike_socialset();
	$fmakeFilter = new promoLike_filter();
	$promoLikeFilterPage = new promoLike_pagefilter();
	
	$promoLikeFilterPage->deleteFilterPageUser($id_page, $id_filter, $id_user);
	
	$filters_page = $promoLikeFilterPage->getFiltersPageUser($id_page,$id_user);

	if($filters_page){
		$promoLikeSocialSet = new promoLike_socialset();
		foreach($filters_page as $key=>$filt){
			$filters_page[$key]['socialset'] = $promoLikeSocialSet->getSocialSetFilter($filt[$fmakeFilter->idField]); 
		}
	}
	global $twig,$globalTemplateParam;
	$globalTemplateParam->set('filters_page',$filters_page);
	$all_filters_page = $twig->loadTemplate("ajax_tpl/filters.tpl")->render($globalTemplateParam->get());
	
	$filters = $fmakeFilter->getNoUsedFilterUser($id_user,$id_page);
	global $twig,$globalTemplateParam;
	$globalTemplateParam->set('filters',$filters);
	$all_filters = $twig->loadTemplate("ajax_tpl/list_filters.tpl")->render($globalTemplateParam->get());
	
	$objResponse = new xajaxResponse();
	
	$objResponse->assign("all_filters_pages","innerHTML", $all_filters_page);
	$objResponse->assign("id_no_used_filter","innerHTML", $all_filters);
	
    return $objResponse;
}

function editFilter($id_filter,$id_page,$id_user) {
	$promoLikeFilter = new promoLike_filter();
	$promoLikeFilter->setId($id_filter);
	$filter_info = $promoLikeFilter->getInfo();
	
	$promoLikeSocialSet = new promoLike_socialset();
	$social_set = $promoLikeSocialSet->getSocialSetFilter($id_filter);
	
	global $twig,$globalTemplateParam;
	$globalTemplateParam->set('id_filter',$id_filter);
	$globalTemplateParam->set('id_page',$id_page);
	$globalTemplateParam->set('id_user',$id_user);
	$globalTemplateParam->set('social_set',$social_set);
	$globalTemplateParam->set('filter_info',$filter_info);
	$form_filter = $twig->loadTemplate("ajax_tpl/form_filter_edit.tpl")->render($globalTemplateParam->get());
		
	$objResponse = new xajaxResponse();
	$objResponse->script('document.getElementById("curtain").style.display="block";document.getElementById("ref_form").style.display="block";');
	$objResponse->assign("create_filter","innerHTML", $form_filter);
	
    return $objResponse;
}

function createFilterForm($id_page) {
	
	global $twig,$globalTemplateParam;
	$globalTemplateParam->set('id_page',$id_page);
	$form_filter = $twig->loadTemplate("ajax_tpl/form_filter_created.tpl")->render($globalTemplateParam->get());
	
	$objResponse = new xajaxResponse();
	$objResponse->script('document.getElementById("curtain").style.display="block";document.getElementById("ref_form").style.display="block";');
	$objResponse->assign("create_filter","innerHTML", $form_filter);
	
    return $objResponse;
}

function Otmena() {
	
	$objResponse = new xajaxResponse();
	$objResponse->script('document.getElementById("curtain").style.display="none";document.getElementById("ref_form").style.display="none";');	
    return $objResponse;
}

function attachFilterPage($param,$id_user){
	$fmakePage = new promoLike_page();
	$fmakePage->setId($id_page);
	$page = $fmakePage->getInfo();
	//if($page['id_user']!=$id_user) return false;
	$fmakePageFilter = new promoLike_pagefilter();
	
	if($fmakePageFilter->isPageFilterUser($param['id_page'],$param['id_filter'],$id_user,false)){
		$fmakePageFilter->undeleteFilterPageUser($param['id_page'],$param['id_filter'],$id_user);
	}
	else{
		$fmakePageFilter->addParam('id_filter', $param['id_filter']);
		$fmakePageFilter->addParam('id_page', $param['id_page']);
		$fmakePageFilter->addParam('id_user', $id_user);
		$fmakePageFilter->addParam('date', time());
		$fmakePageFilter->newItem();
		
	}
	
	$promoLikeFilter = new promoLike_filter();
	$promoLikeFilter->setId($param['id_filter']);
	$filter = $promoLikeFilter->getInfo();
	
	$promoLikeSocialSet = new promoLike_socialset();
	$socialset = $promoLikeSocialSet->getSocialSetFilter($filter[$promoLikeFilter->idField]); 
	$socialset_text ='';
	if($socialset)foreach($socialset as $key=>$socset){
		$socialset_text.= '<img src="/images/social/socialmini'.$key.'.jpg" class="image_social">';
	}
	
	$all_filters_page = '<tr>
						<td class="social">
							'.$socialset_text.'
						</td>
						<td class="caption">'.$filter['caption'].'</td>
						<td class="big cena">'.$filter['budget'].'</td>
						<td class="valuta">рублей</td>
						<td class="actions">
							<img src="/images/note_edit.png" class="image_action" onclick="editFilter('.$param['id_page'].','.$filter['id_filter'].','.$filter['id_user'].');return false;">
							<img src="/images/note_delete.png" class="image_action" onclick="xajax_deleteFilter('.$param['id_page'].','.$filter['id_filter'].','.$filter['id_user'].');return false;">
						</td>
					</tr>';
	
	$filters = $promoLikeFilter->getNoUsedFilterUser($id_user,$param['id_page']);
	global $twig,$globalTemplateParam;
	$globalTemplateParam->set('filters',$filters);
	$all_filters = $twig->loadTemplate("ajax_tpl/list_filters.tpl")->render($globalTemplateParam->get());
		
	$objResponse = new xajaxResponse();
	$objResponse->append("all_filters_pages","innerHTML",$all_filters_page);
	$objResponse->assign("id_no_used_filter","innerHTML", $all_filters);
	$objResponse->alert('фильтр `'.$filter['caption'].'` добавлен');	
	return $objResponse;
}

$xajax->processRequest();


$globalTemplateParam->set('xajax',$xajax);
