[[for page in pages]]
	<div class="page" >
		<span class="caption" onclick="xajax_editPage({page.id_page},{project.id_user},{project.id_project});return false;">{page.caption}</span><span class="actions" ><img src="/images/note_edit.png" onclick="xajax_editPage({page.id_page},{project.id_user},{project.id_project});return false;"/></span><span class="actions" ><img src="/images/note_delete.png" onclick="xajax_deletePage({page.id_page},{project.id_user},{project.id_project});return false;"/></span>
	</div>
[[endfor]]