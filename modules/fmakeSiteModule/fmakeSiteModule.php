<?php
class fmakeSiteModule extends fmakeCore{
		
	public $table = "site_modul";
	public $setName = "";
	/**
	 * 
	 * 
	 * @var ArrayObject fmakeSiteModule_ExtensionInterface 
	 */
	protected $extensions; 	
	public $order = "position";
	public $tree = array();
	public function __isset($key){
		
 		return isset($this->params[$key]);
  	}
	
	function __get($nm){
		return $this->params[$nm];
		
	}
	
	function getChilds ($id = null, $active = false, $inmenu = false){

		if($id === null)
			$id = $this->id;

		$select = $this->dataBase->SelectFromDB(_LINE_);

		if($active)
			$select -> addWhere("active='1'");
		if($inmenu)
			$select -> addWhere("inmenu='1'");

		return $select -> addFrom($this->table) -> addWhere("parent='".$id."'") -> addOrder($this->order) -> queryDB();	
	}	
		
	function getAllAsTree($parent = 0, $level = 0, $active = false, $inmenu = false){
		$level++;
		$items = $this -> getChilds($parent, $active, $inmenu);
		//printAr($items);
			if($items){
				foreach ($items as $item){
					$item['level'] = $level;
					$this->tree[] = $item;
					$this->getAllAsTree($item['id'], $level, $active, $inmenu);
				}
			}

		return $this->tree;
	}
	
	function Memcache_getAllForMenu($parent = 0, $active = false,&$q,&$flag,$inmenu,$acces = false){
		$m = new Memcache();
		$m->connect('localhost', 11211);
		//$m->flush();
		$menu = ( $m->get('Memcache_getAllForMenu'));
		if(!empty($menu)){
			 //Если объект закэширован, выводим его значение
			// echo "Захешированная пекременная<br />";
			 return $this->addStatus($menu,$q=false,$flag=true);
		 }else{
			 //Если в кэше нет объекта с ключом our_var, создадим его
			 //Объект our_var будет храниться 5 секунд и не будет сжат
			 $m->set('Memcache_getAllForMenu', $menu = $this->getAllForMenu($parent,$active,$q,$flag,$inmenu,$acces,false), false, 60*60);
			 return $this->addStatus($menu,$q=false,$flag=true);
		 }
	}
	/**
	*
	* Добавляем статус для массива меню
	*/
	function addStatus($items,&$q,&$flag){
		if(!$items)	return;
		foreach ($items as $key => $item) {
				if($items[$key]['id'] == $this->id && $this->setName == $this->getName()){
					$q = true;
					$items[$key]['status'] = $q;
					$flag = !$flag;
				}	
				if($flag)$items[$key]['status'] = &$q;
				$items[$key]['child'] = $this->addStatus( $item['child'], $q, $flag );
				if($flag)unset($items[$key]['status'] );
		}
		return $items;
	}
	
	function getAllForMenu($parent = 0, $active = false,&$q,&$flag,$inmenu,$acces = false,$status = true){
		$items = $this->getChilds($parent,$active,$inmenu,$acces);
		if(!$items)	return;
		foreach ($items as $key => $item) {
				if($items[$key]['id'] == $this->id && $this->setName == $this->getName()){
					$q = $status;
					$items[$key]['status'] = $q;
					$flag = !$flag;
				}	
				if($flag)$items[$key]['status'] = &$q;
				$items[$key]['child'] = $this->getAllForMenu($item['id'], true,$q,$flag,$inmenu,$acces,$status);
				if($flag)unset($items[$key]['status'] );
		}
		return $items;
	}
	
	function getModul($modul,$active = true){
		
		$where = array();
		if($modul){
			$where[sizeof($where)] = "`redir` = '".$modul."'";
		}else{
			$where[sizeof($where)] = "`index` = '1'";
		}	
		if($active)
			$where[sizeof($where)] = "`active` = '1'";
		
		$arr = $this->getWhere($where);
		
		if($arr[0]){
			foreach($arr[0] as $key => $mod){
				$this->addParam($key, $mod);
			}
		}
		return $arr;
			
	}
	
	function error404(){
		
		global $globalTemplateParam,$twig;
		HttpError(404);
		$template = $twig->loadTemplate('404.tpl');
		$template->display($globalTemplateParam->get());
		exit();
	}
	
	function getPage($modul,$twig){
		
		$this->getModul($modul);
		// находим страницы из других 
		if(!$this->id && $this->extensions){
			foreach ($this->extensions as $name=>&$obj){
				if($obj->getModul($modul)){
					$this->params = $obj->params;
					$this->setName = $name;
					break;
				}
			}
		}else{
			$this->setName = $this->getName();
		}
		
		if(!$this->id){
			$this->error404();
		}
	}
	
    function addExtension(fmakeSiteModule_ExtensionInterface $extension){
    
        $this->extensions[$extension->getName()] = $extension;
       
    }
    
	function getName(){
    
        return 'siteModul';
       
    }
    
		
}