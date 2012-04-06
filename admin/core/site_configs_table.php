<?php
if (!$admin->isLogined())
	die("Доступ запрещен!");

# Поля
$filds = array(
	 'param'=>'Параметр',
	 'caption'=>'Описание'
//	 'value'=>'Значение'
);

$actions = array('active', 'edit', 'delete');

	$absitem = new globalConfigs($request->id);

# Actions
switch($request->action)
{
	case 'insert':
	case 'update':
	case 'delete':
	case 'active':
	default:
		switch($request->action)
		{
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
		
			case 'active': // Включить/выключить
				$absitem -> active();
			break;
		}

		$items = $absitem -> getAll();
		include('content.php');
	break;

	case 'edit': // Если редактировать то покажем картинку
		$items = $absitem -> getInfo();
	case 'new': // Далее форма
		$form = new utlFormEngine($modul, "/admin/index.php?modul=".$request->modul);
		$form->addHidden("action", (($_GET['action'] == 'new')?'insert':'update'));
		$form->addHidden("id", $items['id']);

		if($request->action == 'new')
		{
			$form->addVarchar("Описание", "caption", $items['caption']);
		}
		else
		{
			$form->AddElement(new formElement("1", "Описание", "caption", "NEWTEXT", "50", $items['caption'], false, "", ""));
		}

		if($request->action == 'new')
		{
			$form->addVarchar("Параметр", "param", $items['param']);
		}
		else
		{
//			$form->AddElement(new formElement("1", "Параметр", "param", "NEWTEXT", "50", $items['param'], false, "", ""));
		}
		
		//$form->addTextArea("Значение", "value", $items['value'], 50, 5);
		$form->addFCKEditor("Текст", "value", $items['value']);
		$form->addSubmit("save", "Сохранить");
		$content .= $form->printForm();
		$block = "admin/edit/simple_edit";
	break;
}
?>