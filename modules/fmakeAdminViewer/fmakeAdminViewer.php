<?php
class fmakeAdminViewer {
	private $objDataBase;
	
	
	function up(){
		
	}
	
	function down(){
		
	}
	
	function insert(){
		
	}

	function update(){
		
	}

	function delete(){
		
	}
	
	function active(){
		echo "active";
	}
	
	function show(){
		global $globalTemplateParam;
		$items = ($this->objDataBase->getAll());
		$globalTemplateParam->set('items',$items);
	}
	
	function switcher(fmakeAdminController &$obj){
		global $globalTemplateParam;
		
		$xmlParser = new xmlParser();
		$modulParams = ($xmlParser->xmlToArray($obj->modul['params']));
		$globalTemplateParam->set('modulParams',$modulParams);
		//printAr($modulParams);
		$this->objDataBase = &$obj;
		global $request;
		switch($request->action){
			case 'up':
				$this->up();
			break;
			case 'down':
				$this->down();
			break;
			case 'insert':
				$this->insert();
			break;
			case 'update':
				$this->update();
			break;
			case 'delete':
				$this->delete();
			break;
			case 'active':
				$this->active();
			break;
			case 'view':
			default:
				$this->show();
			break;
		}
	}
	
}