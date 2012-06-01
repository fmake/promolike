<tr style="padding-bottom: 10px;">
	<td colspan="2" >
		<div style="border-bottom: 1px dashed;">
			<a href="#" class="del_block_text" onclick="return false;">del</a>
		</div>
	</td>
</tr>
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
		<textarea name="text[]"></textarea>
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
						(<span title="Опубликованные" class="green" >0</span>/<span title="Ожидание проверки" class="red" >0</span>/<span title="Заявки" id="count_like_full_{item.id_social_set}">[[if active_soc_set[item.id_social_set]]]{active_soc_set[item.id_social_set]}[[else]]0[[endif]]</span>)
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