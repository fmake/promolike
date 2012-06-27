[[ extends  TEMPLATE_PATH ~ "base/main.tpl" ]]
[[block content]]
	
	<a href="/webmaster-creater.php" class="btn primary-padding" style="position: relative;"><span class="f16 primary-green" ><span >+ Добавить соц. сеть</span></span></a>
	
	<table class="company webmaster-socseti" >
	<colgroup>
		<col />
		<col width="10%" />
		<col width="10%" />
		<col width="10%" />
		<col width="10%" />
		<col width="120px" />
		<col width="170px" />
	</colgroup>
		<tbody>
			<tr class="head-caption-tr" >
				<td class="left" > 
					<div class="long_link_box">
						<div class="long_link">
							<span class="pointer" >Соц. сеть</span>
						</div>
						<div class="long_link_hidder hidder_gray">&nbsp;</div>
					</div>
				</td>
				<td>лайки</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td class="right" ><a href="/webmaster-creater.php" class="btn primary-padding"><span class="f12 primary-green" ><span>+ Добавить соц. сеть</span></span></a></td>
			</tr>
		</tbody>
	</table>
	<table class="company-detals" >
		<colgroup>
			<col />
			<col width="10%" />
			<col width="10%" />
			<col width="10%" />
			<col width="10%" />
			<col width="120px" />
			<col width="170px" />
		</colgroup>
		<tbody>
			[[for item in active_socseti]]
				<tr class="page-tr [[if loop.index%2 == 0]]even[[endif]]">
					<td class="left" >
						[[if item.id_social_set==1]][[elseif item.id_social_set==2]]<a target="_blank" href="http://vk.com/id{item.uid}">Перейти на страницу</a>[[elseif item.id_social_set==3]]<a target="_blank" href="https://twitter.com/#!/{item.nickname}">Перейти на страницу</a>[[endif]] ({item.socname})
						[[if not item.active]]
							<br/><span style="color: red;">Обновить токен:</span>
							[[if error_message]]<p style="color: red;">Ошибки: {error_message}</p>[[endif]]
							[[if item.id_social_set==1]]
								
							[[elseif item.id_social_set==2]]
								<form method="post">
									<input type="hidden" name="action" value="update_token_vk">
									<input type="hidden" name="id_us_to" value="{item.id}">
									<table class="">
										<tr>
											<td>ссылка для получения токена</td>
											<td><a href="http://api.vk.com/oauth/authorize?client_id=2675562&redirect_uri=http://api.vk.com/blank.html&scope=1008191&display=page&response_type=token" target="_blank">Авторизация в Vkontakte.ru</a></td>
										</tr>
										<tr>
											<td>Адресная строка</td>
											<td><input type="text" value="" name="text_param_vk" /></td>
										</tr>
										<tr>
											<td></td>
											<td><input type="submit" value="Обновить" /></td>
										</tr>
									</table>
								</form>
							[[elseif item.id_social_set==3]]
								
							[[endif]]
						[[endif]]
					</td>
					<td>0</td>
					<td></td>
					<td colspan="2"><span class="list-actives" place="{item.id_social_set}" user="{user.id}" rel="" load="">Лента активности</span></td>
					<td class="algn-c" ></td>
					<td class="right" ></td>
				</tr>
				<tr id="list-active-place-{item.id_social_set}" class="page-tr list-actives-tr">
					<td colspan="7">
						<div class="table-list">
							<center>
								<img src="/images/preloader-main-table.gif">
							</center>
						</div>
					</td>
				</tr>
			[[endfor]]
		</tbody>
	</table>
	
[[endblock]]