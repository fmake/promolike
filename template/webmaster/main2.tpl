[[ include TEMPLATE_PATH ~ "blocks/header.tpl"]]
<body>
	<div id="vk_api_transport"></div>
	
	/*2629628*/
	<div id="page" >
		
		<div id="header" >
			
[[ include TEMPLATE_PATH ~ "blocks/menu.tpl"]]
			
			
			<div class="topic" id="balans" >
				<div class="login" >
					<a href="/">Future</a> ( <a href="?action=logout" class="small" >выйти</a> )
				</div>
				<div class="hr" ></div>
				<table width="100%">
					<tr>
						<td>Расход</td>
						<td align="right">-100</td>
					</tr>
					<tr>
						<td>Доход</td>
						<td align="right">0</td>
					</tr>
					<tr>
						<td>Партнер</td>
						<td align="right">500</td>
					</tr>
					<tr>
						<td>Итого</td>
						<td align="right">400</td>
					</tr>
				</table>
				<br/>
				<center>
					<a href="./" class="btn primary-padding"><span class="f14 primary-green" ><span>Пополнить баланс</span></span></a>
				</center>
				<br/>
			</div>
		</div>
		
		<div id="content" >
		[[block content]]
			[[raw]]
			<style>
				table.webmaster TD {width: 235px;min-height: 200px;}
				#openapi_actions span {cursor: pointer;}
				table.webmaster .logn_soc_set {
					display:none;
					border: 1px solid;
					padding: 10px;
					border-radius: 10px;
					-moz-border-radius: 10px;
					-webkit-border-radius: 10px;
				}
				table.webmaster .soc_set_button {cursor: pointer;}
			</style>
			[[endraw]]
			{result|raw}
			<table class="webmaster">
				<tr>
					<td>
						<center><img id="button_vk" onclick="[[if params_user_vk.tocken]][[raw]]$('#popup_register_vk').css('display','block');[[endraw]]return false;[[endif]]" class="soc_set_button" src="/images/vk.gif"></center>
						[[if error_stat]]
							<div id="popup_register_vk" style="border: 1px;">
								<a href="http://api.vk.com/oauth/authorize?client_id=2675562&redirect_uri=http://api.vk.com/blank.html&scope=1008191&display=page&response_type=token" target="_blank">Пройдите авторизацию в контакте</a>
								<form action="" method="post">
									<input type="hidden" name="action" value="register_vk">
									<input type="text" name="text_param_vk">
									<input type="submit" value="Отправить">
								</form>
							</div>
						[[endif]]
						<div id="login_vk" class="logn_soc_set" [[if params_user_vk.tocken]]style="display:block;"[[endif]]>
							<div id="openapi_block">
								<div id="openapi_userpic" style="text-align: center;">
									<a href="#" id="openapi_userlink">[[if array_vk_user.photo]]<img src="{array_vk_user.photo}" id="openapi_userphoto" />[[else]]<img src="http://vkontakte.ru/images/question_c.gif" id="openapi_userphoto" />[[endif]]</a>
								</div>
								<div id="openapi_profile">
									<div id="openapi_greeting">ФИО: <span id="openapi_user">{array_vk_user.first_name} {array_vk_user.last_name}</span></div>
									<p>Количество друзей: <span id="size_friends">{params_user_friend_count}</span></p>
									<p>Количество сообщений на стене: <span id="size_messages_wall">{count_vk_message}</span></p>
									/*<p><b>отправить сообщение на свою стенку:</b></p>
									<form method="post" id="vk_message">
										<input type="hidden" name="action" value="send_message_vk">
										текст:<br/>
										<textarea name="text_message_vk"></textarea><br/>
										линк:<br/>
										<input type="text" name="link_message_vk"> <br/>
										c фото : <input type="checkbox" name="photo_message_vk"> <br/>
										<input type="submit" value="отправить">
									</form>*/
								</div>
							</div>
							
						</div>
					</td>
					/*<td>
						<center><img id="button_fb" class="soc_set_button" src="/images/fb.gif" onclick="return false;"></center>
						<div id="login_fb" class="logn_soc_set">
							<div id="openapi_block">
								<div id="openapi_userpic">
									<a href="#" id="openapi_userlink"><img src="http://vkontakte.ru/images/question_c.gif" id="openapi_userphoto" /></a>
								</div>
								<div id="openapi_profile">
									<div id="openapi_greeting">ФИО: <span id="openapi_user"></span></div>
									<p>Количество друзей: <span id="size_friends"></span></p>
									<p>Количество сообщений на стене: <span id="size_messages_wall"></span></p>
									<div id="openapi_actions"><span onclick="doLogout();">Выход</span></div>
								</div>
							</div>
						</div>
					</td>*/
					<td>
						<center>[[if twitter_reg]]<a href="{twitter_reg}"><img id="button_tw" class="soc_set_button" src="/images/tw.gif"></a>[[else]]<img id="button_tw" class="soc_set_button" src="/images/tw.gif">[[endif]]</center>
						<div id="login_tw" class="logn_soc_set" [[if params_user_tw]]style="display:block;"[[endif]]>
							[[if params_user_tw]]
								<div id="openapi_block">
									Активна учетная запись <br/> <a target="_blank" href="https://twitter.com/#!/{params_user_tw.nickname}">@{params_user_tw.nickname}</a>
								</div>
							[[endif]]
						</div>
					</td>
				</tr>
			</table>
		[[endblock]]
		</div>
		
	</div>
	[[block curtain]]
		
	[[endblock]]
</body>
</html>