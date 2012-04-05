[[for textlike in textlikes]]
	<tr> 
		<td class="image"><img width="48" src="/images/image_textlike/{textlike.id_text_like}/thumbs/{textlike.image}"></td>
		<td class="text">
			<strong>{textlike.caption}</strong>
			<p>{textlike.text_like}</p>
		</td>
		<td class="button">
			<center>
				<img src="/images/note_edit.png" title="редактировать текст" onclick="xajax_editTextPage({textlike.id_text_like},{id_user},{id_project});return false;"/>
				<img src="/images/note_delete.png" title="удалить текст" onclick="xajax_deleteTextPage({id_page},{textlike.id_text_like},{id_user},{id_project});return false;"/>
				<img src="/images/control_play_blue.png" title="опубликовать " onclick="xajax_publicVKtext({id_page},{textlike.id_text_like},{id_user},{id_project});return false;"/>
				<img src="[[if textlike.active]]/images/on.gif[[else]]/images/off.gif[[endif]]" title="активность текста" id="active{textlike.id_text_like}" onclick="xajax_activeText({id_page},{textlike.id_text_like},{id_user},{id_project});return false;"/>
			</center>
		</td>
	</tr>
[[endfor]]	