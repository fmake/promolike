<tr>
	<th class="social">Соц. сети</td>
	<th class="caption">Название</th>
	<th class="big cena">Бюджет</th>
	<th class="valuta">Валюта</th>
	<th class="actions">Действия</th>
</tr>
[[for f_page in filters_page]]
	<tr>
		<td class="social">
			[[for key,socialset in f_page['socialset']]]
					<img src="/images/social/socialmini{key}.jpg" class="image_social">
			[[endfor]]
		</td>
		<td class="caption">{f_page.caption}</td>
		<td class="big cena">{f_page.budget}</td>
		<td class="valuta">рублей</td>
		<td class="actions">
			<img src="/images/note_edit.png" class="image_action" onclick="editFilter({f_page.id_page},{f_page.id_filter},{f_page.id_user});return false;">
			<img src="/images/note_delete.png" class="image_action" onclick="xajax_deleteFilter({f_page.id_page},{f_page.id_filter},{f_page.id_user});return false;">
		</td>
	</tr>
[[endfor]]