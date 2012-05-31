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
[[if texts]]
	<tr class="head-tr" >
		<td class="left" >Название</td>
		<td>Переходов</td>
		<td>Лайков</td>
		<td>Заявок</td>
		<td>Бюджет</td>
		<td class="algn-c" >Активность</td>
		<td class="right" ></td>
	</tr>
	
	[[for text in texts]]
	<tr class="page-tr [[if loop.index%2 == 0]]even[[endif]]" >
		<td class="left" >
			<div class="long_link_box">
				<div class="long_link">
					/*<a href="/project.php?id_project={id_project}&id_page={page.id_page}&action=add_page" title="{page.caption}">{page.caption}</a>*/
					<a href="/project.php?id_project={id_project}&id_textlike={text.id_text_like}&action=add_text">{text.caption}</a>
				</div>
				<div class="long_link_hidder hidder_gray">&nbsp;</div>
			</div>
		</td>
		<td>0</td>
		<td><a href="">0</a></td>
		<td><a href="">0</a></td>
		<td>/*{fmakeFilter.summBudgetPage(user.id,page.id_page,id_project)}*/0</td>
		<td class="algn-c" >
			<img src="[[if text.active]]/images/on.gif[[else]]/images/off.gif[[endif]]" title="активность текста" id="active{text.id_text_like}" onclick="xajax_activeText({page.id_page},{text.id_text_like},{user.id},{id_project});return false;"/>
			<img src="[[if text.publick_active]]/images/control_play_blue.png[[else]]/images/control_pause_blue.png[[endif]]" id="text_pub_active{text.id_text_like}" onclick="xajax_publicText({page.id_page},{text.id_text_like},{user.id},{id_project});return false;"/>
		</td>
		<td class="right" >/*<a href="/filter.php?id_project={id_project}&page={page.id_page}">Добавить фильтры</a>*/</td>
	</tr>
	[[endfor]]
[[else]]
	<tr class="page-tr">
		<td colspan="7">
			<center>Нет текстов на странице.</center>
		</td>
	</tr>
[[endif]]

</tbody>