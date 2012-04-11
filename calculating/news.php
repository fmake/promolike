<?php

	
	function showNews($showId,$linkNews,$page = 2,$section_id = 0){
		$page = intval( $page );
		$section_id = intval ( $section_id );
		if($page > 2) $page = 2;
		
		$noticeObj = new fmakeNotice();
		$noticeObj ->addTemplateNews($section_id,20,$page);
		
		global $twig,$globalTemplateParam;
		$str = $twig->loadTemplate("news/item_main.tpl")->render($globalTemplateParam->get());
		$xajax = new xajax();
		$objResponse = new xajaxResponse();
		$objResponse->addAppend($showId, "innerHTML", $str);
		// делаем переход по ссылки, если уже запрашиватеся вторая страница либо другая секция
		
		// скрываем загрузчик
		$objResponse->addScript("$('#loader-news').hide();");
		
		return $objResponse->getXML();	
	}
	
	$xajax = new xajax();
	$xajax->registerFunction("showNews");
	$xajax->processRequests();
	$globalTemplateParam->set("xajax", $xajax); 

	/**
	 * если рассматриваем отдельную запись
	 */
	if($request->notice_id){
		$request->notice_id = (int)$request->notice_id;
		$noticeObj = new fmakeNotice($request->notice_id);
		$new = $noticeObj->getInfo();
		$modul -> title = $modul -> title . ": " . $new['title'];
		if($request->redir != $new['redir']){
			$modul->error404();
		}
		$globalTemplateParam->set("noticeObj", $noticeObj);
		$globalTemplateParam->set("new", $new);
		$modul->template = "news/item.tpl";
	}
	/**
	 * если рассматриваем все новсти
	 */
	else{
		$noticeObj = new fmakeNotice($request->notice_id);
		$noticeObj -> addTemplateNews(0,20,1);
		
		$modul->template = "news/main.tpl";
	}

