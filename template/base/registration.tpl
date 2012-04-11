[[ include TEMPLATE_PATH ~ "blocks/header.tpl"]]
<body>
	<div id="page" >
		<div class="login-head-ru">

</div>



<form id="loginForm" method="POST">
<input type="hidden" name="action" value="registration"   >


[[if error]] 
	<div class="errors">
		<h1>Внимание ошибки</h1>
		[[for er in error]]
			<div class="err">{er}</div>
		[[endfor]]	
		<br />
	</div>
[[endif]]
[[if registration]]
	<h1>Рeгистрация завершена, для подтверждения регистрации зайдите на почту.</h1>
[[elseif autication]]
	[[if type=='register']]
		<h1>{email} Вы подтвердили регистрацию, можете <a href="/">войти в систему</a> </h1>
	[[else]]
		<h1>Смена пароля прошла успешно, теперь Вы можете <a href="/">войти в систему</a></h1>
	[[endif]]	
[[elseif autication_error]]
	<h1>Попытка подтверждения регистрации не удалась, возможно ваше письмо устарело, попробуйте <a href="/getpassword.php">восстановить пароль</a></h1>		
[[else]]
<h1>Регистрация в системе</h1>
<div class="inner">
	
	<p><label for="login">Email</label><br/><input name="email" value="{request.email}" id="login" /></p>
	<p><label for="password">Пароль</label><br/><input id="password" name="password"  type="password" value="" /></p>
	<p><label for="password2">Повторите пароль</label><br/><input id="password2" name="password2"  type="password" value="" /></p>
	
	<div style="height:30px">
		
		
<table class="bums-btn green-big" align="right"><tr>
	<td class="l"><i/><input type="submit" /></td>
	<td><div unselectable="on" onclick="document.getElementById('loginForm').submit();"  >Регистрация</div></td>

	<td class="r"><i/></td>
</tr></table>

	</div>
	<p>
</div>
[[endif]]
</form>

<div class="login-links">
	<ul class="login-links">
		<li><a href="/getpassword.php">Забыли пароль?</a></li>
	</ul>
</div>
	</div>
</body>
</html>