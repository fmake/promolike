<?php
if (!$admin->isLogined())
	die("Доступ запрещен!");

# Поля
$filds = array(
	 'name'=>'Имя',
	 'email'=>'email'
);

	$id = $admin->id;

	$absitem = new absAdministrators($id);

# Actions
switch($request->action)
{
	case 'update': // Переписать
		foreach ($_POST as $key=>$value) //echo $key.'=>'.$value.'<br>';
			if($key != 'password')
				$absitem ->addParam($key, $value);
			elseif($_POST['password']==$_POST['repassword'])
				$absitem ->addParam($key, md5($value));

			$absitem -> update();
	default: // Если редактировать то...
		$items =  $absitem -> getInfo();
		$form = new utlFormEngine($modul, "/admin/index.php?modul=".$request->modul);
		$form->addHidden("action", (($_GET['action'] == 'new')?'insert':'update'));
		$form->addHidden("id", $items['id']);
		foreach ($filds as $key=>$fild)
			$form->addVarchar($fild, $key, $items[$key]);
		$form->addVarchar("Логин", "login", $items['login']);
		$form->addPassword("Пароль", "password");
		$form->addPassword("Повтор пароль", "repassword");
		$form->addSubmit("save", "Сохранить");
		$content .= $form->printForm();
		$block = "admin/edit/simple_edit";
	break;
}
?>