<?php
class fmakeAdminController extends fmakeCore{
	
	public $table = "admin_modul";
	public $modul = false;
	public $order = "position";
	/**
	 * @var fmakeSiteAdministrator
	 */
	public static $userObj;
	public static $adminModulAccessQuery = false;
	
	
	function getUserObj(){
		if(!self::$userObj){
			self::$userObj = new fmakeSiteAdministrator();
		}
		return self::$userObj;
	}
	
	function _getChilds ($id = null, $active = false, $inmenu = false,$role = false){
		if($id === null)
			$id = $this->id;
		// поля которе будем запрашивать для меню	
		$field = array('id','caption','redir','file','`index`');
		$where = array("parent = '".$id."'");
		if($active)
			$where[sizeof($where)] = "active='1'";
		if($inmenu)
			$where[sizeof($where)] = "inmenu='1'";
		// если указана роль пользователя	
		if($role){
			$adminModulAccess = self::$userObj->getAccesObj();
			//$adminModulAccess = new fmakeAcces_adminModul();
			
			// генерируем запрос который будет выгружать доступные модули для пользователя
			if(!fmakeAdminController::$adminModulAccessQuery){
				fmakeAdminController::$adminModulAccessQuery = $adminModulAccess->getAccessStandartQuery($role);
			}
			
			$where[sizeof($where)] = $this->idField." in (".fmakeAdminController::$adminModulAccessQuery.")";
		}	
		return $this->getFieldWhere($field,$where);	
	}
	
	function _getAllForMenu($parent = 0, $active = false,$inmenu = false,$role = false,&$q,&$flag){ // Берем все разделы для меню
		$items = $this->_getChilds($parent,$active,$inmenu,$role);
		if(!$items)	return;
		foreach ($items as $key => $item) {
			if($items[$key][$this->idField] == $this->id){
				$items[$key]['status'] = true;
				$flag = !$flag;
				$q = true;
			}	
			if($flag)$items[$key]['status'] = &$q;
			$items[$key]['child'] = $this->_getAllForMenu($item[$this->idField], $active, $inmenu, $role,$q,$flag);
			if($flag)unset($items[$key]['status'] );
		}
		return $items;
	} 
	
	function getAllAsTree($parent = 0, $level = 0, $active = false, $inmenu = false){
		$level++;
		$items = $this -> _getChilds($parent, $active, $inmenu);

			if($items)
				foreach ($items as $item)
				{
					$item['level'] = $level;
					$this->tree[] = $item;
					$this->getAllAsTree($item['id'], $level, $active, $inmenu);
				}

		return $this->tree;
	}
	
	
	
	function getModul($role,$modul){
		$where = array();
		if($role){
			$adminModulAccess = self::$userObj->getAccesObj();
			//$adminModulAccess = new fmakeAcces_adminModul();
			$where[sizeof($where)] = $this->idField." in (".$adminModulAccess->getAccessStandartQuery($role).")";
		}
		if($modul){
			$where[sizeof($where)] = "`redir` = '".$modul."'";
		}else{
			$where[sizeof($where)] = "`index` = '1'";
		}	
		
		$arr = $this->getWhere($where);
		$arr = $arr[0];
		
		//$arr['params'] = $this->getModulData($arr['id']);
		return $arr;	
	}
	
	function switcher(){
		// запускаем предотображающий класс
		$this->getAdminViewer()->switcher($this);
	}
	
}