<tr>
	<td class="middle" >
		Название Страницы
	</td>
	<td class="middle" >
		<input type="text" name="name[]" value="{page.caption}" />
	</td>
</tr>
<tr>
	<td class="middle" >
		Адрес
	</td>
	<td class="middle" >
		<input type="text" name="page_url[]" value="{page.url}" />
	</td>
</tr>
<tr>
	<td align="right">
		<a href="./" onclick="Cansel();return false;" class="btn primary-padding"><span class="f20 primary-green" ><span >Отменить</span></span></a>
	</td>
	<td align="right">
		<a href="./" onclick="updatePage();return false;" class="btn primary-padding"><span class="f20 primary-green" ><span >Редактировать</span></span></a>
	</td>
</tr>
<tr>
	<td>
		
	</td>
	<td align="right">
		<br /><br /><br />
		<a href="/project.php?id_project={id_project}" class="btn primary-padding"><span class="f20 primary-green" ><span >Назад</span></span></a>
		<a href="/project.php?id_project={id_project}&action=add_text" id="next_link" onclick="Next(2);return false;" class="btn primary-padding"><span class="f20 primary-green" ><span >Далее</span></span></a>
	</td>
</tr>