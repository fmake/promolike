[[ extends  TEMPLATE_PATH ~ "base/main.tpl" ]]
[[block content]]
	[[raw]]
	<script>
		function changePage(id_user){
			//alert(document.getElementById("id_page").value);
			xajax_changePage(document.getElementById("id_page").value,id_user);
		}
		function editFilter(id_page,id_filter,id_user){
			xajax_editFilter(id_filter,id_page,id_user);
		}
		function createFilter(id_page){
			xajax_createFilterForm(id_page);
		}
		function attachFilterPage(id_user){
			xajax_attachFilterPage(xajax.getFormValues("add_page_filter"),id_user);
		}
	</script>
	[[endraw]] 
			<h1>Добавление нового фильтра</h1>
			<div id="company-add" >
				
				<div class="action" >
					<table>
					<tr><td>
					<div class="action-item green left-green" >
						<a href="/project.php[[if request.id_project]]?id_project={request.id_project}[[endif]]">Название компании</a>
					</div>
					<div class="action-item green" >
						<a href="/project.php[[if request.id_project]]?id_project={request.id_project}&action=add_page[[endif]]">Добавление страниц</a>
					</div>
					<div class="action-item green" >
						<a href="/project.php[[if request.id_project]]?id_project={request.id_project}&action=add_text[[endif]]">Добавление текстов</a>
					</div>
					<div class="action-item green right-green" >
						Настройка фильтров
					</div>
					</td></tr>
					</table>
				</div>
				<br />
				<div id="create-pages">
					<div id="create_button">
						<a onclick="createFilter({pages[0].id_page});return false;" class="btn primary-padding" href="#">
							<span class="f20 primary-green">
								<span>Создать фильтр</span>
							</span>
						</a>
					</div>

					
				</div>
				<form id="add_page_filter" action="/filter.php[[if request.id_project]]?id_project={request.id_project}[[endif]]" method="POST" >
					<input type="hidden" name="action" value="add_page_filter">
					<div class="page-conteiner" >
						<div class="pages" >
							Страница:
							<select id="id_page" name="id_page" class="select-filter" onchange="changePage({id_user});" style="width: 200px; margin-left: 52px; margin-bottom: 2px;">
								[[for page in pages]]
									<option value="{page.id_page}" [[if act_page==page.id_page ]]selected[[endif]]>{page.caption}</option>
								[[endfor]]
							</select>
						</div>
						<div class="pages" >
							Фильтры:
							<select id="id_no_used_filter" name="id_filter" class="select-filter" style="width: 200px; margin-left: 52px; margin-bottom: 2px;">
								[[for filter in filters]]
									<option value="{filter.id_filter}">{filter.caption}</option>
								[[endfor]]
							</select>
							<input type="submit" value="Применить" id="attach_filter_page" onclick="attachFilterPage({id_user});return false;">
						</div>
					</div> 
				</form>
				<div class="title_filter"><h1>Управление фильтрами</h1></div>
				<div class="table_filters">
					<table id="all_filters_pages">
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
									<img src="/images/note_delete.png" class="image_action" onclick="xajax_deleteFilter({f_page.id_page},{f_page.id_filter},{id_user});return false;">
								</td>
							</tr>
						[[endfor]]
					</table>
				</div>
				<!-- [[if error.namefilter]]
					<div class="error"><span>{error.namefilter}</span></div>
				[[endif]]

				-->
				
				
				<br /><br />
			</div>
[[endblock]]

[[block curtain]]
	<div id="curtain"></div>
	<div id="ref_form">
		<form id="create_filter" action="/filter.php[[if request.id_project]]?id_project={request.id_project}[[endif]]" method="POST" >
		<input type="hidden" name="action" value="[[if request.action=='add_page_filter']]add_page_filter[[else]]create_filter[[endif]]">
		<input type="hidden" name="id_page" value="{request.id_page}">
		[[if update or request.update]]
			<input type="hidden" name="update" value="1">
			<input type="hidden" name="id_filter" value="{request.id_filter}">
		[[endif]]
		<table class="form-table filter" > 
			<tr>
				<td class="middle" >
					Социальная сеть
				</td>
				<td class="middle" >
					<table>
						<tr>
							<td>
								<label for="fb">
									<img src="/images/fb.gif" alt="" />
								</label>
							</td>
							<td>
								<label for="vk">
									<img src="/images/vk.gif" alt="" />
								</label>	
							</td>
							<td>
								<label for="tw" >
									<img src="/images/tw.gif" alt="" />
								</label>	
							</td>
						</tr>
						<tr>
							<td align="center">
								<input type="checkbox" [[if error and request.fb]]checked="checked"[[endif]] name="fb" class="check" id="fb"  />
							</td>
							<td align="center">
								<input type="checkbox" [[if error and request.vk]]checked="checked"[[endif]] name="vk" class="check" id="vk" />
							</td>
							<td align="center">
								<input type="checkbox" [[if error and request.tw]]checked="checked"[[endif]] name="tw" class="check" id="tw" />
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td class="middle" >
					Кол-во друзей
				</td>
				<td class="middle" >
					<select name="comparison_friends" class="checkselect" >
						<option [[if error and request.comparison_friends==0]]selected="selected"[[endif]] value="0">больше</option>
						<option [[if error and request.comparison_friends==1]]selected="selected"[[endif]] value="1">меньше</option>
					</select>
					<input type="text" name="count_friends" onkeyup="return proverkaInt(this);" style="width: 190px;" value="[[if error]]{request.count_friends}[[endif]]" />
				</td>
			</tr>
			<tr>
				<td class="middle" >
					Сообщений
				</td>
				<td class="middle" >
					<select name="comparison_messages" class="checkselect" >
						<option [[if error and request.comparison_messages==0]]selected="selected"[[endif]] value="0">больше</option>
						<option [[if error and request.comparison_messages==1]]selected="selected"[[endif]] value="1">меньше</option>
					</select>
					<input type="text" name="count_messages" onkeyup="return proverkaInt(this);" style="width: 190px;" value="[[if error]]{request.count_messages}[[endif]]" />
				</td>
			</tr>
			<tr>
				<td class="middle" >
					Активность
				</td>
				<td class="middle" >
					<select class="checkselect" name="activity" style="width: 100%;"  >
						<option [[if error and request.activity==0]]selected="selected"[[endif]] value="0">без разницы</option>
						<option [[if error and request.activity==1]]selected="selected"[[endif]] value="1">маленькая</option>
						<option [[if error and request.activity==2]]selected="selected"[[endif]] value="2">средняя</option>
						<option [[if error and request.activity==3]]selected="selected"[[endif]] value="3">большая</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="big" >
					Бюджет
				</td>
				<td class="big" >
					<input type="text" name="budget" onkeyup="return proverkaInt(this);" value="[[if error]]{request.budget}[[endif]]" />
				</td>
			</tr>
			<tr>
				<td class="middle" >
					Название фильтра
				</td>
				<td class="middle" >
					<input type="text" name="caption" value="[[if error]]{request.caption}[[endif]]" />
				</td>
			</tr>
			<tr>
				<td >
				</td>
				<td align="right" >
					[[if update]]
						<a href="#" class="btn primary-padding" onclick="xajax_Otmena();return false;"><span class="f20 primary-green" ><span >Отмена</span></span></a>
						<a href="#" class="btn primary-padding" onclick="document.getElementById('create_filter').submit();return false;"><span class="f20 primary-green" ><span >Редактировать</span></span></a>
					[[else]]
						<a href="#" class="btn primary-padding" onclick="xajax_Otmena();return false;"><span class="f20 primary-green" ><span >Отмена</span></span></a>
						<a href="#" class="btn primary-padding" onclick="document.getElementById('create_filter').submit();return false;"><span class="f20 primary-green" ><span >Создать</span></span></a>
					[[endif]]
				</td>
			</tr>
		</table>
		</form>
		
		[[if error.alert]]
			{error.alert|raw}
		[[endif]]
	</div>
[[endblock]]