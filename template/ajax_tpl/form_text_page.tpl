<tr>
	<td class="middle" >
		Страница
	</td>
	<td class="middle" >
		<select name="id_page" onChange="xajax_getTextPage(this.value);">
			[[for page in pages]]
				<option value="{page.id_page}">{page.caption}</option>
			[[endfor]]
		</select>
	</td>
</tr>
<tr>
	<td class="middle" >
		Заголовок
	</td>
	<td class="middle" >
		<input type="text" name="pagetitle[]" value="" />
	</td>
</tr>
<tr>
	<td class="text-middle" >
		Изображение
	</td>
	<td class="text-middle" >
		<input class="image_input" type="file" name="image0"  />
	</td>
</tr>
<tr>
	<td class="text-middle" >
		Текст
	</td>
	<td class="text-middle" >
		<textarea name="text[]"></textarea>
	</td>
</tr>
<tr>
	<td align="right" colspan="2" style="padding-top: 10px;padding-bottom: 10px;" >
		<a href="" id="add-text" onclick="return false;">еще текст</a>
	</td>
</tr>
<tr>
	<td>
		
	</td>
	<td align="right">
		<a href="./" onclick="submitForm();return false;" class="btn primary-padding"><span class="f20 primary-green" ><span >Добавить</span></span></a>
	</td>
</tr>
<tr>
	<td>
		
	</td>
	<td align="right">
		<br /><br /><br />
		<a href="/project.php?id_project={request.id_project}&action=add_page" class="btn primary-padding"><span class="f20 primary-green" ><span >Назад</span></span></a>
		<a href="/filter.php?id_project={request.id_project}" id="next_link" onclick="Next(1);return false;" class="btn primary-padding"><span class="f20 primary-green" ><span >Далее</span></span></a>
	</td>
</tr>