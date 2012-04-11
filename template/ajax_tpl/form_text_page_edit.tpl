<tr>
	<td colspan="2">
		<input type="hidden" name="action_add_text_page" value="update_text">
		<input type="hidden" name="id_text_page" value="{textpage.id_text_like}">
	</td>
</tr>
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
		<input type="text" name="pagetitle" value="{textpage.caption}" />
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
		<textarea name="text">{textpage.text_like}</textarea>
	</td>
</tr>
<tr>
	<td class="text-middle">
	    Соц. сети
	</td>
	<td class="text-middle">
		[[for key,item in full_soc_set]]
			<span>
				<input [[if active_soc_set[item.id_social_set]]]checked="checked"[[endif]] type="checkbox" class="socset_input" style="width: 23px;" value="1">
				<input type="hidden" class="socset_input_hidden" name="socset[{item.id_social_set}]" value="[[if active_soc_set[item.id_social_set]]]1[[else]]0[[endif]]">
		    	[[if active_soc_set[item.id_social_set]]]
					<img style="margin-top: 3px;" rel="active" rel_src="/images/social/no_socialmini{item.id_social_set}.jpg" class="image-socset" src="/images/social/socialmini{item.id_social_set}.jpg">
				[[else]]
					<img style="margin-top: 3px;" rel="" rel_src="/images/social/socialmini{item.id_social_set}.jpg" class="image-socset" src="/images/social/no_socialmini{item.id_social_set}.jpg">
				[[endif]]
	    	</span>
	    [[endfor]]
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
		<a href="/project.php?id_project={id_project}&action=add_page" class="btn primary-padding"><span class="f20 primary-green" ><span >Назад</span></span></a>
		<a href="/filter.php?id_project={id_project}" id="next_link" onclick="Next(1);return false;" class="btn primary-padding"><span class="f20 primary-green" ><span >Далее</span></span></a>
	</td>
</tr>