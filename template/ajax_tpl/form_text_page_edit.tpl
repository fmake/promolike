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
				<option [[if textpage.id_page==page.id_page]]selected[[endif]] value="{page.id_page}">{page.caption}</option>
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
				<div style="height: 25px;">
					<input [[if active_soc_set[item.id_social_set]['active'] ]]checked="checked"[[endif]] type="checkbox" class="socset_input" style="width: 23px;" value="1">
					<input type="hidden" class="socset_input_hidden" name="socset[{item.id_social_set}]" value="[[if active_soc_set[item.id_social_set]['active'] ]]1[[else]]0[[endif]]">
			    	[[if active_soc_set[item.id_social_set]['active'] ]]
						<img style="margin-top: 5px;" rel="active" rel_src="/images/social/no_socialmini{item.id_social_set}.jpg" class="image-socset" src="/images/social/socialmini{item.id_social_set}.jpg">
					[[else]]
						<img style="margin-top: 5px;" rel="" rel_src="/images/social/socialmini{item.id_social_set}.jpg" class="image-socset" src="/images/social/no_socialmini{item.id_social_set}.jpg">
					[[endif]]
					<span>
						(<span id="count_like_public_{item.id_social_set}">{publick_soc_set[item.id_social_set]}</span>/<span id="count_like_full_{item.id_social_set}">[[if active_soc_set[item.id_social_set]['count'] ]]{active_soc_set[item.id_social_set]['count']}[[else]]0[[endif]]</span>)
						<span class="add_button_like"> 
							<img src="/images/plus.gif" />
						</span>
						<span class="form_add_like">
							<input class="input_count_like" id_user="{id_user}" id_project="{id_project}" id_place="{item.id_social_set}" id_text_like="{textpage.id_text_like}" type="text" value="{active_soc_set[item.id_social_set]['count']}" name="like_count[{item.id_social_set}]">
			    			<button class="button_count_like" onclick="return false;" name="like_count">Ок</button>
			    		</span>
					</span>
				</div>
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