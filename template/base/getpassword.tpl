[[ include TEMPLATE_PATH ~ "blocks/header.tpl"]]
<body>
	<div id="page" >
		<div class="login-head-ru">

</div>



<form id="loginForm" method="POST">
<input type="hidden" name="action" value="getpassword"   >

[[if error]] 
	<div class="errors">
		<h1>Внимание ошибки</h1>
		[[for er in error]]
			<div class="err">{er}</div>
		[[endfor]]	
		<br />
	</div>
[[endif]]

[[if send_password]]
	<h1>Смена пароля завершена, для подтверждения смены пароля зайдите на почту и перейдите по ссылке.</h1>
[[else]]
	<h1>Восстановление пароля</h1>
	<div class="inner">
		
		<p><label for="login">Email</label><br/><input name="email" value="" id="login" /></p>
		
		<div style="height:30px">
			
			
	<table class="bums-btn green-big" align="right"><tr>
		<td class="l"><i/><input type="submit" name="action" value="Login" /></td>
		<td><div unselectable="on" onclick="document.getElementById('loginForm').submit();"  >Выслать пароль</div></td>
	
		<td class="r"><i/></td>
	</tr></table>
	
		</div>
		<p>
	</div>
[[endif]]
</form>

<div class="login-links">
	
</div>
	</div>
</body>
</html>