[[ extends  TEMPLATE_PATH ~ "base/main.tpl" ]]
[[block content]]
	[[raw]]
	<script>
		function changePage(id_user){
			//alert(document.getElementById("id_page").value);
			xajax_changePage(document.getElementById("id_page").value,id_user);
		}
		function editFilter(id_filter,id_user){
			xajax_editFilter(id_filter,id_user);
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
					<h1>Фильтры на страинце:</h1>
					<div id="all_filters_pages">
						[[for f_page in filters_page]]
							<div class="page" >
								<span class="caption" onclick="editFilter({f_page.id_filter},{f_page.id_user});return false;">{f_page.caption}</span><span class="actions" ><img src="/images/note_delete.png" onclick="xajax_deleteFilter({f_page.id_page},{f_page.id_filter},{id_user});return false;"/></span>
							</div>
						[[endfor]]			
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
						Установить готовый фильтр 
						<select id="all_filters_select" name="id_filter" class="select-filter" >
							[[for filter in filters]]
								<option value="{filter.id_filter}">{filter.caption}</option>
							[[endfor]]
						</select>
						<a href="#" class="btn primary-padding" onclick="document.getElementById('add_page_filter').submit();return false;"><span class="f12 primary-green" ><span >Применить</span></span></a>
					</div> 
				</form>
				[[if error.namefilter]]
					<div class="error"><span>{error.namefilter}</span></div>
				[[endif]]

				<form id="create_filter" action="/filter.php[[if request.id_project]]?id_project={request.id_project}[[if request.page]]&page={request.page}[[endif]][[endif]]" method="POST" >
				<input type="hidden" name="action" value="create_filter">
				[[if update]]
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
										<input type="checkbox" name="fb" checked="checked" class="check" id="fb"  />
									</td>
									<td align="center">
										<input type="checkbox" name="vk" checked="checked" class="check" id="vk" />
									</td>
									<td align="center">
										<input type="checkbox" name="tw" checked="checked" class="check" id="tw" />
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
								<option [[if error.namefilter and request.comparison_friends==0]]selected="selected"[[endif]] value="0">больше</option>
								<option [[if error.namefilter and request.comparison_friends==1]]selected="selected"[[endif]] value="1">меньше</option>
							</select>
							<input type="text" name="count_friends" style="width: 190px;" value="[[if error.namefilter]]{request.count_friends}[[endif]]" />
						</td>
					</tr>
					<tr>
						<td class="middle" >
							Сообщений
						</td>
						<td class="middle" >
							<select name="comparison_messages" class="checkselect" >
								<option [[if error.namefilter and request.comparison_messages==0]]selected="selected"[[endif]] value="0">больше</option>
								<option [[if error.namefilter and request.comparison_messages==1]]selected="selected"[[endif]] value="1">меньше</option>
							</select>
							<input type="text" name="count_messages" style="width: 190px;" value="[[if error.namefilter]]{request.count_messages}[[endif]]" />
						</td>
					</tr>
					<tr>
						<td class="middle" >
							Активность
						</td>
						<td class="middle" >
							<select class="checkselect" name="activity" style="width: 100%;"  >
								<option [[if error.namefilter and request.activity==0]]selected="selected"[[endif]] value="0">без разницы</option>
								<option [[if error.namefilter and request.activity==1]]selected="selected"[[endif]] value="1">маленькая</option>
								<option [[if error.namefilter and request.activity==2]]selected="selected"[[endif]] value="2">средняя</option>
								<option [[if error.namefilter and request.activity==3]]selected="selected"[[endif]] value="3">большая</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="big" >
							Бюджет
						</td>
						<td class="big" >
							<input type="text" name="budget" value="[[if error.namefilter]]{request.budget}[[endif]]" />
						</td>
					</tr>
					<tr>
						<td class="middle" >
							Название фильтра
						</td>
						<td class="middle" >
							<input type="text" name="caption" value="[[if error.namefilter]]{request.caption}[[endif]]" />
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
								<a href="#" class="btn primary-padding" onclick="document.getElementById('create_filter').submit();return false;"><span class="f20 primary-green" ><span >Применить</span></span></a>
							[[endif]]
						</td>
					</tr>
				</table>
				</form>
				[[if error.alert]]
					{compile(error.alert,_context)}
				[[endif]]
				<br /><br />
			</div>
[[endblock]]
