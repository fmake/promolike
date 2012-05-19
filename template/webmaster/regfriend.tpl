[[ include TEMPLATE_PATH ~ "blocks/header.tpl"]]
<body>
	[[raw]]
		<style>
			.inner TABLE TD {padding: 10px 5px;}
		</style>
	[[endraw]]
	<div id="page" >
		<div class="login-head-ru">

		</div>
		<form id="loginForm" method="POST">
		<h1>Регистрация в приложении Вконтакте</h1>
		[[if error_message]]
			<p style="color: red;">{error_message}</p>
		[[endif]]
		<div class="inner">
			<table>
				<tr>
					<td class="middle" >
						Ссылка для регистрации
					</td>
					<td class="middle" >
						<a href="http://api.vk.com/oauth/authorize?client_id=2675562&redirect_uri=http://api.vk.com/blank.html&scope=1008191&display=page&response_type=token" target="_blank">Авторизация в Vkontakte.ru</a>
					</td>
				</tr>
				<tr>
					<td class="middle" >
						Параметры
					</td>
					<td class="middle" >
						<input type="hidden" name="action" value="register_vk">
						<input type="text" name="text_param_vk">
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
					<td align="right">
						<a href="./" onclick="$('#loginForm').submit();return false;" class="btn primary-padding"><span class="f20 primary-green" ><span >Добавить</span></span></a>
					</td>
				</tr>
			</table>
		</div>
		</form>
	</div>
</body>
</html>