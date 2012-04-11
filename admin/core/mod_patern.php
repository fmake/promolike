<?php
	function getFile($path){
		$file = file_get_contents(ROOT.$path);

		
		$objResponse = new xajaxResponse();
		//$objResponse->addAssign("main_text","innerHTML",$file);
		$objResponse->addAssign("template","value",$path);
		//$objResponse->addAssign("caption","innerHTML","Шаблон ".$path);
		//создаем файл
		$objResponse->addScript
		('var new_file= {id: "'.$path.'", text: "'.mysql_escape_string(($file)).'", syntax: \'php\'};
		editAreaLoader.openFile(\'main_text\', new_file);');
		//$objResponse->addScript("alert('".urldecode($qq)."');");
		return $objResponse->getXML();
	}

	function saveFile($path,$content){
		$file = file_get_contents(ROOT.$path);
		$f = fopen(ROOT.$path,"w+");
		fwrite($f,$content);
		
		$objResponse = new xajaxResponse();
		$objResponse->addScript("alert('Файл сохранен');");
		return $objResponse->getXML();
	}
	
	//printAr($_POST);
	
	if($request->action == 'save'){
		//echo "qq";
		//printAr($_POST);
		$f = fopen(ROOT.$request->template,"w+");
		fwrite($f, html_entity_decode($request->content_template,ENT_QUOTES,cp1251));
		fclose($f);
		$save = true;
	}
	
	$xajax = new xajax();
	//$xajax_basket->bDebug = true;
	
	$xajax->registerFunction("getFile");
	$xajax->registerFunction("saveFile");
	$xajax->processRequests();
	
	global $template;
	$template = "admin/template/template/main";
	$block = "admin/template/template/simple_table";
?>