<?php

if (!$admin->isLogined())
	die("Доступ запрещен!");

# Поля
$filds = array(
	 'caption'=>'Название',
);

$absitem = new fmakeSection($request->id);
	
$actions = array('move',  'active', 'edit', 'delete');


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
			case 'inmain':
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
			break;
		
			case 'delete': // Удалить
				$absitem -> delete();
			break;
			
		}

		
		$items = $absitem -> getAll();
		include('content.php');
	break;
	case 'edit':
		$items = $absitem -> getInfo();
	case 'new': // Далее форма
		
		$form = new utlFormEngine($modul, "/admin/index.php?modul=".$request->modul, "POST", "multipart/form-data");
	
		$form->addHidden("action", (($_GET['action'] == 'new')?'insert':'update'));
		$form->addHidden("id", $items[$absitem->idField]);
		
		foreach ($filds as $key=>$fild)
		{
			if($key == 'file') continue;
			$form->addVarchar($fild, $key, (($key == 'date' && $_GET['action'] == 'new')? date("Y-m-d") : $items[$key]));
		}
		
		//$form->addFCKEditor("Текст", "text", $items['text']);
		
		$form->addSubmit("save", "Сохранить");
		$content .= $form->printForm();
		
		$block = "admin/edit/simple_edit";
		
	break;
}
?>