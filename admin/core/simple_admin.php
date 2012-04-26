<?php

if (!$admin->isLogined())
	die("Доступ запрещен!");

# Поля
$filds = array(
	'parent'=>'Родитель',
	'caption'=>'Название',
	//'template'=>'Шаблон',
	'redir'=>'url',
	//'users'=>'Пользователи',
	'file'=>'Файл'
);

$sort_filds = array(
	 //'caption'=>true,
	 //'redir'=>true
);

$actions = array(
	'active',
	'edit',
	'delete',
	'move'
);

	$absitem = new fmakeAdminController($request->id);
	
	
	$actions = array('move', 'index', 'inmenu', 'active', 'edit', 'delete');

$group_actions = array('g_active','g_non_active','g_invert_active');
include 'group_action.php';

$absitem->setId($request->id);
	
	
# Actions
switch($request->action)
{
	case 'up':
	case 'down':
	case 'insert':
	case 'update':
	case 'delete':
	case 'active':
	default:
		switch($request->action)
		{
			case 'up': // Вверх 
				$absitem->getUp();
			break;

			case 'down': // Вниз
				$absitem->getDown();
			break;
			
			case 'insert': // Новый
				foreach ($_POST as $key=>$value)
					$absitem ->addParam($key, $value);
				$absitem -> newItem();
				
				$absitem->getUserObj()->getAccesObj()->setAcces($absitem -> id,$request->rols_array);
			break;
		
			case 'update': // Переписать
				foreach ($_POST as $key=>$value)
					$absitem ->addParam($key, $value);
				$absitem -> update();
				
				$absitem->getUserObj()->getAccesObj()->setAcces($absitem -> id,$request->rols_array);
			break;
		
			case 'delete': // Удалить
				$absitem -> delete();
			break;
		
			case 'active': // Включить/выключить
				$absitem -> active();
			break;
			
			case 'index': // Включить/выключить
				$absitem -> setIndex();
			break;
		}

		$items = $absitem -> getAllAsTree();
		
	break;

	case 'edit': // Если редактировать то
		$items = $absitem -> getInfo();
		$checkRols = $absitem->getUserObj()->getAccesObj()->arraySimple($absitem->getUserObj()->getAccesObj()->getByModulId($items['id'],"id_role"),"id_role");
	case 'new': // Далее форма
		$modules = $absitem -> getAllAsTree();
		$rols = $absitem->getUserObj()->getRoleObj()->getAll();
		if(!$checkRols)$checkRols = array();
		
		$dir = new utlDirectories(ROOT.'/admin/modules');
		$files = $dir->listing();
		$core_dir = new utlDirectories(ROOT.'/admin/core');
		$files = array_merge($files, $core_dir->listing());
		$core_dir = new utlDirectories(ROOT.'/template/admin/main_template');
		$templates = $core_dir->listing();
		
		$form = new utlFormEngine($modul, "/admin/index.php?modul=".$request->modul);
		$form->addHidden("action", (($_GET['action'] == 'new')?'insert':'update'));
		$form->addHidden("id", $items['id']);
		$_modul = $form->addSelect("Родитель", "parent");
				$_modul->AddOption(new selectOption(0, "Нет родителя", (($items['parent']==0)? true : false )));
			foreach ($modules as $modul)
				$_modul->AddOption(new selectOption($modul['id'], (($modul['parent']==0)? '':'&nbsp;&nbsp;').$modul['caption'], (($modul['id']==$items['parent'])? true : false )));
		$form->AddElement($_modul);
		foreach ($filds as $key=>$fild)
		{ 
			if($key == 'parent' || $key == 'file' || $key == 'users') continue;
			$form->addVarchar($fild, $key, (($key == 'date' && $_GET['action'] == 'new')? date("Y-m-d") : $items[$key]));
		}
		
		
		//добавляем роли	
		$form->addHtml("Доступ к разделу","");
		for($j=0;$j<count($rols);$j++){
			$form->addCheckBox($rols[$j]['role'],"rols_array[]",$rols[$j]['id'],in_array($rols[$j]['id'],$checkRols));
		}
		
		//$form->addVarchar("<em>Шаблон</em>", "template", $items["template"]);
		
		$_file = $form->addSelect("Шаблон", "template");
			$_file->AddOption(new selectOption("", "Нет файла", (($items['template'] == null)? true : false )));
		
		foreach ($templates as $file)
		{
			$file = substr($file, 0, strrpos($file, '.'));
			$_file->AddOption(new selectOption($file, $file, (($file == $items['template'])? true : false )));
		}
		$form->AddElement($_file);
		
		$_file = $form->addSelect("Файл", "file");
			$_file->AddOption(new selectOption("", "Нет файла", (($items['file'] == null)? true : false )));
		foreach ($files as $file)
		{
			$file = substr($file, 0, strrpos($file, '.'));
			$_file->AddOption(new selectOption($file, $file, (($file == $items['file'])? true : false )));
		}
		
		$form->AddElement($_file);
		$form->addFCKEditor("Текст", "text", $items['text']);
		$form->addSubmit("save", "Сохранить");
		$content .= $form->printForm();
		$block = "admin/edit/simple_edit";
	break;
}

?>