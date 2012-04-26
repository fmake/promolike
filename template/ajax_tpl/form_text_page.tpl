<tr>
	<td class="middle" >
		Страница
	</td>
	<td class="middle" >
		<select name="id_page" onChange="xajax_getTextPage(this.value);">
			[[for page in pages]]
				[[if page.id_page==id_page]]
					<option value="{page.id_page}" selected>{page.caption}</option>
				[[else]]
					<option value="{page.id_page}">{page.caption}</option>
				[[endif]]
			[[endfor]]
		</select>
	</td>
</tr>
[[if error_size]]
	[[for er in 1 .. error_size]]
		[[if loop.index0]]
			<tr style="padding-bottom: 10px;"><td colspan="2" ><div style="border-bottom: 1px dashed;"><a href="#" class="del_block_text" onclick="return false;">del</a></div></td></tr>
		[[endif]]
		<tr>
			<td class="middle" >
				Заголовок
			</td>
			<td class="middle" >
				<input type="text" name="pagetitle[]" value="{request.pagetitle[loop.index0]}" />
			</td>
		</tr>
		<tr>
			<td class="text-middle" >
				Изображение
			</td>
			<td class="text-middle" >
				<input class="image_input" type="file" name="image[]"  />
			</td>
		</tr>
		<tr>
			<td class="text-middle" >
				Текст
			</td>
			<td class="text-middle" >
				<textarea name="text[]">{request.text[loop.index0]}</textarea>
			</td>
		</tr>
		<tr>
			<td class="text-middle">
			    Соц. сети
			</td>
			<td class="text-middle">
				[[for key,item in full_soc_set]]
					<span>
						<input type="checkbox" class="socset_input" style="width: 23px;" value="1">
						<input type="hidden" class="socset_input_hidden" name="socset[{item.id_social_set}][]" value="0">
				    	<img style="margin-top: 3px;" rel="" rel_src="/images/social/socialmini{item.id_social_set}.jpg" class="image-socset" src="/images/social/no_socialmini{item.id_social_set}.jpg">
			    	</span>
			    [[endfor]]
			</td>
		</tr>
	[[endfor]]
	<tr>
		<td align="right" colspan="2" style="padding-top: 10px;padding-bottom: 10px;" >
			<a href="" id="add-text" onclick="return false;">еще текст</a>
		</td>
	</tr>
[[else]]
	<tr>
		<td class="middle" >
			Заголовок
		</td>
		<td class="middle" >
			<input type="text" name="pagetitle[]" value="{textlike.caption}" />
		</td>
	</tr>
	<tr>
		<td class="text-middle" >
			Изображение
		</td>
		<td class="text-middle" >
			<input class="image_input" type="file" name="image[]"  />
		</td>
	</tr>
	<tr>
		<td class="text-middle" >
			Текст
		</td>
		<td class="text-middle" >
			<textarea name="text[]">{textlike.text_like}</textarea>
		</td>
	</tr>
	<tr>
		<td class="text-middle">
		    Соц. сети
		</td>
		<td class="text-middle">
			[[for key,item in full_soc_set]]
				<span>
					<input type="checkbox" class="socset_input" style="width: 23px;" value="1">
					<input type="hidden" class="socset_input_hidden" name="socset[{item.id_social_set}][]" value="0">
			    	<img style="margin-top: 3px;" rel="" rel_src="/images/social/socialmini{item.id_social_set}.jpg" class="image-socset" src="/images/social/no_socialmini{item.id_social_set}.jpg">
		    	</span>
		    [[endfor]]
		</td>
	</tr>
	<tr>
		<td align="right" colspan="2" style="padding-top: 10px;padding-bottom: 10px;" >
			<a href="" id="add-text" onclick="return false;">еще текст</a>
		</td>
	</tr>
[[endif]]
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
		<a href="/myprojects.php" id="next_link" onclick="Next(1);return false;" class="btn primary-padding"><span class="f20 primary-green" ><span >Далее</span></span></a>
	</td>
</tr>