[[ include TEMPLATE_PATH ~ "blocks/header.tpl"]]
<body>
	<div id="page" >
		<div class="login-head-ru">

</div>



<form id="loginForm" method="POST">
<input type="hidden" name="action" value="login"   >

[[if error]] 
	<div class="errors">
		<h1>Внимание ошибки</h1>
		[[for er in error]]
			<div class="err">{er}</div>
		[[endfor]]	
		<br />
	</div>
[[endif]]

<div class="inner">
				<p><label for="login">Логин</label><br/><input name="email" value="" id="login" /></p>
	<p><label for="password">Пароль</label><br/><input id="password" name="password"  type="password" value="" /></p>
	<div style="height:30px">
		<input name="save" class="checkbox" type="checkbox" value="1" id="saveCheck" /><label for="saveCheck">&#160;запомнить</label>
		
<table class="bums-btn green-big" align="right"><tr>
	<td class="l"><i/><input type="submit" name="" value="" /></td>
	<td><div unselectable="on" onclick="document.getElementById('loginForm').submit();"  >Войти</div></td>

	<td class="r"><i/></td>
</tr></table>

	</div>
	<p>
</div>
</form>

<div class="login-links">
	<ul class="login-links">
		<li><a href="/getpassword.php">Забыли пароль?</a></li>
		<li> <a href="/registration.php" class="f20" >Регистрация в системе</a></li>

	</ul>
</div>
	</div>
</body>
</html>