[[ extends  TEMPLATE_PATH ~ "base/main.tpl" ]]

[[block content]]
	
	<a href="#" class="btn primary-padding" style="position: relative;"><span class="f16 primary-green" ><span >+ Пополнить счет</span></span></a>
	
	<h1>Платежи:</h1>
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
							<span >Дата и время платежа</span>
						</div>
						<div class="long_link_hidder hidder_gray">&nbsp;</div>
					</div>
				</td>
				<td>Внесение</td>
				<td>Расход</td>
				<td></td>
				<td></td>
				<td></td>
				<td class="right" ><a href="#" class="btn primary-padding"><span class="f12 primary-green" ><span>+ Пополнить счет</span></span></a></td>
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
			[[for item in payments]]
				<tr class="page-tr [[if loop.index%2 == 0]]even[[endif]]">
					<td class="left" >[[if item.id_social_set==1]][[elseif item.id_social_set==2]]<a target="_blank" href="http://vk.com/id{item.uid}">Перейти на страницу</a>[[elseif item.id_social_set==3]]<a target="_blank" href="https://twitter.com/#!/{item.nickname}">Перейти на страницу</a>[[endif]] ({item.socname})</td>
					<td>0</td>
					<td></td>
					<td></td>
					<td></td>
					<td class="algn-c" ></td>
					<td class="right" ></td>
				</tr>
			[[else]]
				<tr>
					<td colspan="7"><center><b>Нет платежей</b></center></td>
				</tr>
			[[endfor]]
		</tbody>
	</table>

[[endblock]]