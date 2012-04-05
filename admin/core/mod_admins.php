<?php
if (!$admin->isLogined())
	die("Доступ запрещен!");

# Поля
$filds = array(
	'name'=>'Имя',
	'login'=>'Логин',
	'email'=>'email'
);

$actions = array(
	'active',
	'edit',
	'delete'
);

	$absitem = new fmakeSiteAdministrator($request->id);
	//$roleObj = new fmakeSiteAdministratorRole();
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
					$absitem ->addParam($key, (($key == "password")? md5($value) : $value ));
				$absitem -> newItem();
			break;
		
			case 'update': // Переписать
				foreach ($_POST as $key=>$value)
					$absitem ->addParam($key, (($key == "password")? md5($value) : $value ));
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
		
	break;

	case 'edit': // Если редактировать то покажем картинку
		$items = $absitem -> getInfo();
	case 'new': // Далее форма
		$rols = $absitem->getRoleObj()->getRols();
		
		//printAr($rols);
		$form = new utlFormEngine($modul, "/admin/index.php?modul=".$request->modul);
		$form->addHidden("action", (($request->action == 'new')?'insert':'update'));
		$form->addHidden("id", $items['id']);
		
		$_modul = $form->addSelect("Тип", "role");
		//$_modul->AddOption(new selectOption(0, "Без Отдела", (($items['role']==0)? true : false )));
		
		if($rols) foreach ($rols as $modul)
		{
			$_modul->AddOption(new selectOption($modul['id'], blankprint($modul['level']).$modul['role'], (($modul['id']==$items['role'])? true : false )));
		}
		$form->AddElement($_modul);
		
		
		foreach ($filds as $key=>$fild)
			$form->addVarchar($fild, $key, $items[$key]);

		//$form->addVarchar("Тип", "type", $items['type']);
		$form->addVarchar("Пароль", "password", "");
		$form->addSubmit("save", "Сохранить");
		$content .= $form->printForm();
		$block = "admin/edit/simple_edit";
	break;
}
?>