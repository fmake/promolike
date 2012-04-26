[[ include TEMPLATE_PATH ~ "blocks/header.tpl"]]
<body>
	<div id="vk_api_transport"></div>
	[[raw]]
	<script src="http://vkontakte.ru/js/api/openapi.js?3" type="text/javascript"></script>
	<script src="/js/vk_script.js" type="text/javascript"></script>
	
	<script type="text/javascript">
      window.vkAsyncInit = function() {
        VK.Auth.getLoginStatus(function(response) {
          if (response.session) {
            window.location = baseURL + '?op=main&page=auth';
          }
        });
		VK.Observer.subscribe('auth.login', function(response) {
          loginOpenAPI();
        });
        VK.Observer.subscribe('auth.login', function(response) {
          window.location = baseURL + '?op=main&page=auth';
        });
        VK.Observer.subscribe('auth.logout', function() {
          //console.log('logout');
        });
        VK.Observer.subscribe('auth.statusChange', function(response) {
          //console.log('statusChange');
        });
        VK.Observer.subscribe('auth.sessionChange', function(r) {
          //console.log('sessionChange');
        });
        
        VK.init({
          apiId: 2629628,
          nameTransportPath: '/xd_receiver.html'
        });
      };
      setTimeout(function() {
        var el = document.createElement('script');
        el.type = 'text/javascript';
        el.src = 'http://vkontakte.ru/js/api/openapi.js?3';
        el.async = true;
        document.getElementById('vk_api_transport').appendChild(el);
      }, 0);
	  
	  function doLogin() {
		  VK.Auth.login(
			null,
			VK.access.FRIENDS | VK.access.WIKI
		  );
		}
    </script>
	[[endraw]]
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
			</style>
			[[endraw]]
			<table class="webmaster">
				<tr>
					<td>
						<center><img id="button_vk" src="/images/vk.gif" onclick="doLoginVK()"></center>
						<div id="login_vk" class="logn_soc_set">
							<div id="openapi_block">
								<div id="openapi_userpic" style="text-align: center;">
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
					</td>
					<td>
						<center><img id="button_fb" src="/images/fb.gif" onclick="return false;"></center>
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
					</td>
					<td>
						<center><img id="button_tw" src="/images/tw.gif" onclick="return false;"></center>
						<div id="login_tw" class="logn_soc_set">
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