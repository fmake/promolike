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
[[if pages]]
	<tr class="head-tr" >
		<td class="left" > Страница</td>
		<td>Переходов</td>
		<td>Лайков</td>
		<td>Заявок</td>
		<td>Бюджет</td>
		<td class="algn-c" >Активность</td>
		<td class="right" ></td>
	</tr>
	
	[[for page in pages]]
	<tr class="page-tr [[if loop.index%2 == 0]]even[[endif]]" >
		<td class="left" >
			<div class="long_link_box">
				<div class="long_link">
					<a href="/project.php?id_project={id_project}&id_page={page.id_page}&action=add_page" title="{page.caption}">{page.caption}</a>
				</div>
				<div class="long_link_hidder hidder_gray">&nbsp;</div>
			</div>
		</td>
		<td>0</td>
		<td><a href="">0</a></td>
		<td><a href="">0</a></td>
		<td>/*{fmakeFilter.summBudgetPage(user.id,page.id_page,id_project)}*/0</td>
		<td class="algn-c" >/*<a href=""><img src="[[if page.active]]/images/control_play_blue.png[[else]]/images/control_pause_blue.png[[endif]]" id="active{page.id_page}" onclick="xajax_publicText({page.id_page},0,{user.id},{id_project});return false;"/> </a>*/</td>
		<td class="right" ><span class="dashed page-textlikes" page="{page.id_page}" load="" rel="">Показать тексты</span>/*<a href="/filter.php?id_project={id_project}&page={page.id_page}">Добавить фильтры</a>*/</td>
	</tr>
	<tr class="page-tr" style="display:none;">
		<td colspan="7" >
			<table id="textlikes-page{page.id_page}" class="company-detals">
				<tr><td class="preloader-table-pages-main"><center><img src="/images/preloader-main-table.gif"></center></td></tr>
			</table>
		</td>
	</tr>
	[[endfor]]
[[else]]
	<tr class="page-tr">
		<td colspan="7">
			<center>Нет страниц в компании.</center>
		</td>
	</tr>
[[endif]]

</tbody>