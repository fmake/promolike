[[ extends  TEMPLATE_PATH ~ "base/main.tpl" ]]
[[block content]]
	[[raw]]
			<script type="text/javascript">
			function submitForm()
			{
				//xajax_addTextPage(xajax.getFormValues("form_create_text"));
				document.getElementById("form_create_text").submit();
			}
			function updatePage()
			{
				//xajax_updateTextPage(xajax.getFormValues("form_create_text"));
				document.getElementById("form_create_text").submit();
			}
			function Cansel(){
				document.location = document.location;
			}
			function Next(action){
				//alert(obj.elements.length);
				var r=confirm("Сохранить внесенные данные?")
				
				if (r==true)
				{
					//if(action==1) xajax_addPage(xajax.getFormValues("form_create_page"),true);//alert('add');//submitForm();
					//else if(action==2) xajax_updatePage(xajax.getFormValues("form_create_page"),true);//alert('update');//updatePage();
					if(action==1){
						alert('add');
						document.getElementById("add_next_button").value = 1;
						document.getElementById("form_create_text").submit();
					}
					else if(action==2){
						//alert('update');//add_next_button
						//document.getElementById("add_next_button").value = 1;
					}
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
						<a href="/project.php?id_project={project.id_project}&action=add_page">Добавление страниц</a>
					</div>
					<div class="action-item green right-green" >
							Добавление текстов
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
				
				<div id="create-pages" style="margin-right: 179px;">
					<h1>Уже добавленные тексты:</h1>
					<div id="all_pages">
							<div class="page">
								<table class="page_textlike" id="page_textlike">
									[[if textlikes]]
										[[for textlike in textlikes]]
											<tr> 
												<td class="image"><img width="48" src="/images/image_textlike/{textlike.id_text_like}/thumbs/{textlike.image}"></td>
												<td class="text">
													<strong>{textlike.caption}</strong>
													<p>{textlike.text_like}</p>
												</td>
												<td class="button">
													<center>
														<img src="/images/note_edit.png" title="редактировать текст" onclick="xajax_editTextPage({textlike.id_text_like},{project.id_user},{request.id_project});return false;"/>
														<img src="/images/note_delete.png" title="удалить текст" onclick="xajax_deleteTextPage({pages[0].id_page},{textlike.id_text_like},{project.id_user},{request.id_project});return false;"/>
														<img src="/images/control_play_blue.png" title="опубликовать " onclick="xajax_publicVKtext({pages[0].id_page},{textlike.id_text_like},{project.id_user},{request.id_project});return false;"/>
														<img src="[[if textlike.active]]/images/on.gif[[else]]/images/off.gif[[endif]]" title="активность текста" id="active{textlike.id_text_like}" onclick="xajax_activeText({pages[0].id_page},{textlike.id_text_like},{project.id_user},{request.id_project});return false;"/>
													</center>
												</td>
											</tr>
										[[endfor]]	
									[[else]]
										<tr><td colspan="3"><h2>нет страниц</h2></td></tr>
									[[endif]]
								</table>
							</div>	
					</div>
				</div>
				[[if page]]
				<form method="POST" action="/project.php?id_project={request.id_project}&action=add_text" id="form_create_text" enctype="multipart/form-data">
					<input type="hidden" name="action_add_text_page" value="update_text">
					<input type="hidden" name="id_project" value="{project.id_project}">
					<input type="hidden" name="id_user" value="{project.id_user}">
					<input type="hidden" name="update" value="[[if update]]1[[else]]0[[endif]]">
					<table class="form-table" id="form-table">
						<tr>
							<td class="middle" >
								Страница
							</td>
							<td class="middle" >
								<select name="name" onChange="xajax_getTextPage(this.value);">
									[[for page in pages]]
										<option value="{page.id_page}">{page.caption}</option>
									[[endfor]]
								</select>
							</td>
						</tr>
						<tr>
							<td class="middle" >
								Заголовок
							</td>
							<td class="middle" >
								<input type="text" name="pagetitle" value="{textlike.caption}" />
							</td>
						</tr>
						<tr>
							<td class="text-middle" >
								Адрес картинки
							</td>
							<td class="text-middle" >
								<input class="image_input" type="file" name="image"  />
							</td>
						</tr>
						<tr>
							<td class="text-middle" >
								Текст
							</td>
							<td class="text-middle" >
								<textarea name="text">{textlike.text_like}</textarea>
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
								<a href="" id="add-page" onclick="return false;">Еще страница</a>
							</td>
						</tr> 
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
								<a href="/project.php?id_project={request.id_project}&action=add_page" class="btn primary-padding"><span class="f20 primary-green" ><span >Назад</span></span></a>
								<a href="/myprojects.php" id="next_link" onclick="Next(2,this.form);return false;" class="btn primary-padding"><span class="f20 primary-green" ><span >Далее</span></span></a>
							</td>
						</tr>
					</table>
				</form>					
				[[else]]
				<form method="POST" action="/project.php?id_project={request.id_project}&action=add_text" id="form_create_text" enctype="multipart/form-data">
					<input type="hidden" name="action_add_text_page" value="add_text">
					<input type="hidden" name="id_project" value="{project.id_project}">
					<input type="hidden" name="id_user" value="{project.id_user}">
					<input type="hidden" name="add_next_button" value="" id="add_next_button">
					<table class="form-table" id="form-table">
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
					
					</table>
				</form>
				[[endif]]
				<br />
			</div>
			[[if error.alert]]
				{error.alert|raw} 
			[[endif]]
[[endblock]]