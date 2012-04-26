<?php
if (!$admin->isLogined())
	die("Доступ запрещен!");

# Поля
$filds = array(
	'date'=>'Дата',
	'text'=>'Сообщение',
	'remote_addr'=>'IP пользователя'
);

$sort_filds = array(
	 'date'=>true,
); 

$actions = array(
//	'active',
//	'edit',
	'delete'
);

	$absitem = new absSystemNotice($request->id);
	
	$group_actions = array('g_active','g_non_active','g_invert_active');
	include 'group_action.php';
	
	$absitem->setId($request->id);
# Actions
switch($request->action)
{
	case 'insert':
	case 'update':
	case 'delete':
	case 'active':
	case 'deleteall':
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

		
			case 'deleteall': // Удалить все
				$absitem -> truncateTable();
			break;

		
			case 'active': // Включить/выключить
				$absitem -> active();
			break;
		}

		$content = '<div style="width: auto;"><a onclick="return confirm(\'Очистить все?\');" href="/admin/index.php?modul='.$request->modul.'&action=deleteall"><img src="/images/admin/del.gif" align="left" alt="Зонтик" border="0">&nbsp;&nbsp;Удалить все</a></div>';

		$items = $absitem -> getAll();
		//include('content.php');
	break;

	case 'edit': // Если редактировать то покажем картинку
		$items = $absitem -> getInfo();
	case 'new': // Далее форма
		$form = new utlFormEngine($modul, "/admin/index.php?modul=".$request->modul);
		$form->addHidden("action", (($_GET['action'] == 'new')?'insert':'update'));
		$form->addHidden("id", $items['id']);
		$form->addVarchar("Дата время", "date", (($_GET['action'] == 'new')? date("Y-m-d H:i:s") : $items["date"]));
		$form->addTextArea("Сообщение", "text", $items['text'], 50, 5);
		$form->addVarchar("IP пользователя", "remote_addr", (($_GET['action'] == 'new')? $_SERVER['REMOTE_ADDR'] : $items["remote_addr"]));
		$form->addSubmit("save", "Сохранить");
		$content .= $form->printForm();
		$block = "admin/edit/simple_edit";
	break;
}
?>