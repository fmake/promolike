<?

//echo "<pre>"; print_r($_SESSION); echo "</pre>";

$admin = $modulObj->getUserObj();
$admin->load();

//printAr($_REQUEST);

if ($request->action=="logout")
{
	$admin->logout();
	Header ("Location: /");
	exit();
}

if ($request->action=="Login")
{
	//$absAdmin = new fmakeSiteAdministrator();
	if ($row = $admin->login($request->login, $request->password)) 
	{
		
		$admin->setLogin($row['id'], $row['login'], $row['role']); //login($id, $login, $acces)
		Header ("Location: /admin/index.php");
	}else{
		$error = true;
	}         
}

if (!$admin->isLogined()) 
{	   
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
 <head>
 <title>Авторизация</title>
 <META HTTP-EQUIV="Content-Type" CONTENT="text/html; CHARSET=Windows-1251">
 <link href="/styles/admin/login.css" type="text/css" rel="stylesheet" />
 
 </head>
 <body>
<div class="login-head-ru">

</div>
<form id="loginForm" method="POST">
<input type="hidden" name="action" value="Login"   >
<?php if($error){?>
<div class="errors">
	<div class="err">Указанный вами пароль неверен.</div>	
</div>
<?php }?>
<div class="inner">
				<p><label for="login">Логин</label><br/><input name="login" value="" id="login" /></p>
	<p><label for="password">Пароль</label><br/><input id="password" name="password"  type="password" value="" /></p>
	<div style="height:30px">
		<input name="save" class="checkbox" type="checkbox" value="1" id="saveCheck" /><label for="saveCheck">&#160;запомнить</label>
		
<table class="bums-btn green-big" align="right"><tr>
	<td class="l"><i/><input type="submit" name="action" value="Login" /></td>
	<td><div unselectable="on" onclick="document.getElementById('loginForm').submit();"  >Войти</div></td>

	<td class="r"><i/></td>
</tr></table>

	</div>
	<p>
</div>
</form>

<div class="login-links">
	<ul class="login-links">
		<li><a href="/">Забыли пароль?</a></li>

	</ul>
</div>

</body>

</html>
<?  
	exit();
}
?>