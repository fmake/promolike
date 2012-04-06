[[ extends  TEMPLATE_PATH ~ "base/main.tpl" ]]
[[block content]]
	<h1>Добавление соц. сети</h1>
	<form method="post" action="/webmaster-creater.php" id="form_create_socialnetwork">
		<table class="form-table create_socialnetwork" id="form-table">
			<tr>
				<td class="middle" >
					Соц. сеть
				</td>
				<td class="middle" >
					<select name="socialnetwork" onchange="xajax_changeFormsSocseti(this.value);">
						<option value="0">Выберете соц. сеть</option>
						[[for item in full_soc_set]]
							[[if not item._active]]<option value="{item.id_social_set}">{item.name}</option>[[endif]]
						[[endfor]]
					</select>
				</td>
			</tr>
		</table>
		<table id="create_socialnetwork_params" class="form-table">
			
		</table>
	</form>
	[[if error_message]] 
		{error_message|raw}
	[[endif]]
[[endblock]]