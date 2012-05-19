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
						<div style="height: 25px;">
							<input type="checkbox" [[if request.socset[item.id_social_set] ]]checked="checked"[[endif]] class="socset_input" style="width: 23px;" value="[[if request.socset[item.id_social_set] ]]1[[else]]0[[endif]]">
							<input type="hidden" class="socset_input_hidden" name="socset[{item.id_social_set}][]" value="0">
					    	[[if request.socset[item.id_social_set] ]]
					    		<img style="margin-top: 3px;" rel="" rel_src="/images/social/no_socialmini{item.id_social_set}.jpg" class="image-socset" src="/images/social/socialmini{item.id_social_set}.jpg">
					    	[[else]]
					    		<img style="margin-top: 3px;" rel="" rel_src="/images/social/socialmini{item.id_social_set}.jpg" class="image-socset" src="/images/social/no_socialmini{item.id_social_set}.jpg">
					    	[[endif]]
					    	<span>
								(<span id="count_like_public_{textpage.id_text_like}">0</span>/<span id="count_like_full_{item.id_social_set}">[[if request.like_count[item.id_social_set] ]]{request.like_count[item.id_social_set]}[[else]]0[[endif]]</span>)
								<span class="add_button_like"> 
									<img src="/images/plus.gif" />
								</span>
								<span class="form_add_like">
									<input class="input_count_like" id_user="{id_user}" id_project="{id_project}" id_place="{item.id_social_set}" id_text_like="{textpage.id_text_like}" type="text" value="{request.like_count[item.id_social_set]}" name="like_count[{item.id_social_set}]">
					    			<button class="button_count_like" onclick="return false;" name="like_count">Ок</button>
					    		</span>
							</span>
						</div>
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
					<div style="height: 25px;">
						<input type="checkbox" class="socset_input" style="width: 23px;" value="1">
						<input type="hidden" class="socset_input_hidden" name="socset[{item.id_social_set}][]" value="0">
				    	<img style="margin-top: 3px;" rel="" rel_src="/images/social/socialmini{item.id_social_set}.jpg" class="image-socset" src="/images/social/no_socialmini{item.id_social_set}.jpg">
			    		<span>
							(<span id="count_like_public_{textpage.id_text_like}">0</span>/<span id="count_like_full_{item.id_social_set}">[[if active_soc_set[item.id_social_set]]]{active_soc_set[item.id_social_set]}[[else]]0[[endif]]</span>)
							<span class="add_button_like"> 
								<img src="/images/plus.gif" />
							</span>
							<span class="form_add_like">
								<input class="input_count_like" id_user="{id_user}" id_project="{id_project}" id_place="{item.id_social_set}" id_text_like="{textpage.id_text_like}" type="text" value="{active_soc_set[item.id_social_set]}" name="like_count[{item.id_social_set}]">
				    			<button class="button_count_like" onclick="return false;" name="like_count">Ок</button>
				    		</span>
						</span>
					</div>
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