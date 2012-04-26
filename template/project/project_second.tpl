[[ extends  TEMPLATE_PATH ~ "base/main.tpl" ]]
[[block content]]
	[[raw]]
			<script type="text/javascript">
			function submitForm()
			{
				xajax_addPage(xajax.getFormValues("form_create_page"));
			}
			function updatePage()
			{
				xajax_updatePage(xajax.getFormValues("form_create_page"));
			}
			function Cansel(){
				document.location = '/project.php?id_project=[[endraw]]{request.id_project}[[raw]]&action=[[endraw]]{request.action}[[raw]]';
			}
			function Next(action){
				//alert(obj.elements.length);
				var r=confirm("Сохранить внесенные данные?")
				
				if (r==true)
				{
					if(action==1) xajax_addPage(xajax.getFormValues("form_create_page"),true);//alert('add');//submitForm();
					else if(action==2) xajax_updatePage(xajax.getFormValues("form_create_page"),true);//alert('update');//updatePage();
				}
				else{
					document.location = document.getElementById("next_link").href;
				}

			}

			</script>
	[[endraw]]
			<h1>Добавление новой компании</h1>
			<div id="company-add" >
				
				<div class="action" >
					<table>
					<tr><td>
					<div class="action-item green left-green" >
						<a href="/project.php?id_project={project.id_project}">Название компании</a>
					</div>
					<div class="action-item green" >
						Добавление страниц
					</div>
					<div class="action-item [[if request.id_project and pages]]green right-green[[else]]right[[endif]]" >
						[[if request.id_project and pages]]
							<a href="/project.php?id_project={project.id_project}&action=add_text">Добавление текстов</a>
						[[else]]	
							Добавление текстов
						[[endif]]
					</div>
					/*<div class="action-item [[if request.id_project]]green right-green[[else]]right[[endif]]" >
						[[if request.id_project]]
							<a href="/filter.php?id_project={request_tmp.id_project}">Настройка фильтров</a>
						[[else]]	
							Настройка фильтров
						[[endif]]
					</div>*/
					</td></tr> 
					</table>
				</div>
				<br />
				
				<div id="create-pages">
					<h1>Уже созданные страницы:</h1>
					<div id="all_pages">
						[[for page in pages]]
							<div class="page" >
								<span class="caption" onclick="xajax_editPage({page.id_page},{project.id_user},{project.id_project});return false;">{page.caption}</span><span class="actions" ><img src="/images/note_edit.png" onclick="xajax_editPage({page.id_page},{project.id_user},{project.id_project});return false;"/></span><span class="actions" ><img src="/images/note_delete.png" onclick="xajax_deletePage({page.id_page},{project.id_user},{project.id_project});return false;"/></span>
							</div>
						[[endfor]]				
					</div>

					
				</div>
				[[if page]]
				<form method="get" id="form_create_page">
					<input type="hidden" name="id_project" value="{project.id_project}">
					<input type="hidden" name="id_user" value="{project.id_user}">
					<input type="hidden" name="id_page" value="{page.id_page}">
					<input type="hidden" name="update" value="[[if update]]1[[else]]0[[endif]]">
					<table class="form-table" id="form-table">
						<tr>
							<td class="middle" >
								Название Страницы
							</td>
							<td class="middle" >
								<input type="text" name="name" value="{page.caption}" />
							</td>
						</tr>
						<tr>
							<td class="middle" >
								Адрес
							</td>
							<td class="middle" >
								<input type="text" name="page_url" value="{page.url}" />
							</td>
						</tr>
						<!-- [[for textlike in textlikes]]
						<tr>
							<td class="text-caption" colspan="2">
								<div>текст ссылки №{loop.index}</div>
							</td>
						</tr>
						<tr>
							<td class="text-middle" >
								Заголовок
							</td>
							<td class="text-middle" >
								<input type="text" name="pagetitle[]" value="{textlike.caption}" />
							</td>
						</tr>
						<tr>
							<td class="text-middle" >
								Адрес картинки
							</td>
							<td class="text-middle" >
								<input type="text" name="image_url[]" value="{textlike.url}" />
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
						[[endfor]] -->
						<!-- <tr>
							<td align="right" colspan="2" style="padding-top: 10px;padding-bottom: 10px;" >
								<a href="" id="add-page" onclick="return false;">Еще страница</a>
							</td>
						</tr>  -->
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
								<a href="/project.php?id_project={request.id_project}" class="btn primary-padding"><span class="f20 primary-green" ><span >Назад</span></span></a>
								<a href="/project.php?id_project={request.id_project}&action=add_text" id="next_link" onclick="Next(2,this.form);return false;" class="btn primary-padding"><span class="f20 primary-green" ><span >Далее</span></span></a>
							</td>
						</tr>
					</table>
				</form>					
				[[else]]
				<form method="get" id="form_create_page">
					<input type="hidden" name="id_project" value="{project.id_project}">
					<input type="hidden" name="id_user" value="{project.id_user}">
					<table class="form-table" id="form-table">
						<tr>
							<td class="middle" >
								Название Страницы
							</td>
							<td class="middle" >
								<input type="text" name="name[]"  />
							</td>
						</tr>
						<tr>
							<td class="middle" >
								Адрес
							</td>
							<td class="middle" >
								<input type="text" name="page_url[]"  />
							</td>
						</tr>
						<tr>
							<td align="right" colspan="2" style="padding-top: 10px;padding-bottom: 10px;" >
								<a href="" id="add-page" onclick="return false;">Еще страница</a>
							</td>
						</tr>
						<tr>
							<td>
								
							</td>
							<td align="right">
								<a href="./" onclick="submitForm();return false;" class="btn primary-padding"><span class="f20 primary-green" ><span >Добавить страницу</span></span></a>
							</td>
						</tr>
						<tr>
							<td>
								
							</td>
							<td align="right">
								<br /><br /><br />
								<a href="/project.php?id_project={request.id_project}" class="btn primary-padding"><span class="f20 primary-green" ><span >Назад</span></span></a>
								<a href="/project.php?id_project={request.id_project}&action=add_text" id="next_link" onclick="Next(1);return false;" class="btn primary-padding"><span class="f20 primary-green" ><span >Далее</span></span></a>
							</td>
						</tr>
					</table>
				</form>
				[[endif]]
				<br />
			</div>
[[endblock]]