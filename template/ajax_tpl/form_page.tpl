<tr>
	<td class="middle" >
		Название Страницы
	</td>
	<td class="middle" >
		<input type="text" name="name[]"  />
	</td>
</tr>
<tr>
	<td class="middle" >
		Адрес
	</td>
	<td class="middle" >
		<input type="text" name="page_url[]"  />
	</td>
</tr>
<tr>
	<td align="right" colspan="2" style="padding-top: 10px;padding-bottom: 10px;" >
		<a href="" id="add-page" onclick="return false;">Еще страница</a>
	</td>
</tr>
<tr>
	<td>
		
	</td>
	<td align="right">
		<a href="./" onclick="submitForm();return false;" class="btn primary-padding"><span class="f20 primary-green" ><span >Добавить страницу</span></span></a>
	</td>
</tr>
<tr>
	<td>
		
	</td>
	<td align="right">
		<br /><br /><br />
		<a href="/project.php?id_project={id_project}" class="btn primary-padding"><span class="f20 primary-green" ><span >Назад</span></span></a>
		<a href="/project.php?id_project={id_project}&action=add_text" id="next_link" onclick="Next(1);return false;" class="btn primary-padding"><span class="f20 primary-green" ><span >Далее</span></span></a>
	</td>
</tr>