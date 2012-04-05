<?php

if (!$admin->isLogined())
	die("Доступ запрещен!");

# Поля
$filds = array(
//	 'parent'=>'Родитель',
	 'caption'=>'Название',
//	 'text'=>'Текст',
	 'redir'=>'url',
	 'file'=>'Шаблон'
);

/*
$sort_filds = array(
	 'caption'=>true,
	 'redir'=>true
); 
*/


	$absitem = new fmakeSiteModule();
	
$actions = array('move', 'index', 'inmenu', 'active', 'edit', 'delete');

$group_actions = array('g_active','g_non_active','g_invert_active');
include 'group_action.php';

$absitem->setId($request->id);
$absitem->tree = false;
# Actions
switch($request->action)
{
	case 'up':
	case 'down':
	case 'insert':
	case 'update':
	case 'delete':
	case 'index':
	case 'inmenu':
	case 'active':
	default:
		switch($request->action)
		{
			case 'index':
				$absitem->setIndex();
			break;

			case 'inmenu':
			case 'active':
				$absitem->setEnum($request->action);
			break;

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
				
				
			break;
		
			case 'update': // Переписать
				foreach ($_POST as $key=>$value)
					$absitem ->addParam($key, $value);
				$absitem -> update();

				//echo $_FILES['icon']['tmp_name'];
				//printAr($_FILES);
			break;
		
			case 'delete': // Удалить
				$absitem -> delete();
			break;
			
		}

		$items = $absitem -> getAllAsTree();
		
		for($i=0;$i<count($items);$i++){
			$items[$i]['file'] = $modulNameSpace[$items[$i]['file']];
		}


		include('content.php');
	break;
	case 'delimg':
		$absitem -> deleteImage($name = 'icon.png');
	case 'edit':
		$items = $absitem -> getInfo();
	case 'new': // Далее форма
		$modules = $absitem -> getAllAsTree();
	
		$dir = new utlDirectories(ROOT.'/calculating');
		$files = $dir->listing();
		
		$form = new utlFormEngine($modul, "/admin/index.php?modul=".$request->modul, "POST", "multipart/form-data");
	
		$form->addHidden("action", (($_GET['action'] == 'new')?'insert':'update'));
		$form->addHidden("id", $items['id']);
		$_modul = $form->addSelect("Родитель", "parent");
				$_modul->AddOption(new selectOption(0, "Нет родителя", (($items['parent']==0)? true : false )));
			if($modules) foreach ($modules as $modul)
			{
				if($modul['id'] == $items['id']) continue;
				$_modul->AddOption(new selectOption($modul['id'], blankprint($modul['level']).$modul['caption'], (($modul['id']==$items['parent'])? true : false )));
			}
		
		$form->AddElement($_modul);
		$form->addVarchar("<em>Заголовок</em>", "title", $items["title"]);
		$form->addVarchar("<em>Ключевые</em>", "keywords", $items["keywords"],50,false,"Ключевые слова, как правило используються для того что бы рассказать поисковой сиситеме о вашем сайте");
		$form->addVarchar("<em>Описание</em>", "description", $items["description"]);
		foreach ($filds as $key=>$fild)
		{
			if($key == 'file') continue;
			$form->addVarchar($fild, $key, (($key == 'date' && $_GET['action'] == 'new')? date("Y-m-d") : $items[$key]));
		}
	
		$_file = $form->addSelect("Шаблон", "file");
			$_file->AddOption(new selectOption("", "Нет файла", (($items['file'] == null)? true : false )));
	
		foreach ($files as $file)
		{
			$file = substr($file, 0, strrpos($file, '.'));
			$_file->AddOption(new selectOption($file, $modulNameSpace[$file], (($file == $items['file'])? true : false )));
		}
		$form->AddElement($_file);
		
		
		$form->addFCKEditor("Текст", "text", $items['text']);
		

		$form->addSubmit("save", "Сохранить");
		$content .= $form->printForm();
		
		$block = "admin/edit/simple_edit";
		
	break;
}
?>