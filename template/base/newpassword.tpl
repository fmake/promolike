[[ include TEMPLATE_PATH ~ "blocks/header.tpl"]]
<body>
	<div id="page" >
		<div class="login-head-ru">

</div>



<form id="loginForm" method="POST">
<input type="hidden" name="action" value="Login"   >

<!-- 
<div class="errors">
	<div class="err">Указанный вами пароль неверен.</div>	
</div>
 -->
<h1>Восстановление пароля</h1>
<div class="inner">
	
	<p><label for="login">Email</label><br/><input name="login" value="" id="login" /></p>
	
	<div style="height:30px">
		
		
<table class="bums-btn green-big" align="right"><tr>
	<td class="l"><i/><input type="submit" name="action" value="Login" /></td>
	<td><div unselectable="on" onclick="document.getElementById('loginForm').submit();"  >Выслать пароль</div></td>

	<td class="r"><i/></td>
</tr></table>

	</div>
	<p>
</div>
</form>

<div class="login-links">
	
</div>
	</div>
</body>
</html>