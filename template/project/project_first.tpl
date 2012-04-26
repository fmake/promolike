[[ extends  TEMPLATE_PATH ~ "base/main.tpl" ]]
[[block content]]
			<h1>Добавление новой компании</h1>
			<div id="company-add" >
				
				<div class="action" >
					<table>
					<tr><td>
					<div class="action-item green left-green" >
						[[if request.id_project]]
							<a href="">Название компании</a>
						[[else]]
							Название компании 
						[[endif]]
					</div>
					<div class="action-item [[if request.id_project]]green[[endif]]" >
						[[if request.id_project]]
							<a href="/project.php?id_project={request_tmp.id_project}&action=add_page">Добавление страниц</a>
						[[else]]	
							Добавление страниц
						[[endif]]
					</div>
					<div class="action-item [[if request.id_project and pages]]green right-green[[else]]right[[endif]]" >
						[[if request.id_project and pages]]
							<a href="/project.php?id_project={project.id_project}&action=add_text">Добавление текстов</a>
						[[else]]	
							Добавление текстов
						[[endif]]
					</div>
					</td></tr>
					</table>
				</div>
				<br />
				<form id="form_project" action="[[if request.id_project]]project.php?id_project={request.id_project}[[else]]project.php[[endif]]" method="post">
					<input type="hidden" name="action" value="create">
					<input type="hidden" name="id_project" value="{request.id_project}">
					<table class="form-table" >
						[[if error]]
							<tr>
								<td colspan="2" class="error">
									Внимание имеются ошибки:
									[[for err in error]]
										{err}<br />
									[[endfor]]
								</td>
							</tr>
						[[endif]]
						[[if request.id_project]]
							<tr>
								<td colspan="2">
									<p style="font-size: 25px;">ID project: {request.id_project}</p>
								</td>
							</tr>
						[[endif]]
						<tr>
							<td class="big" >
								Название
							</td>
							<td class="big" >
								<input type="text" name="company_name"  value="[[if project.caption]]{project.caption}[[else]]{name_project}[[endif]]"/>
							</td>
						</tr>
						<tr>
							<td>
								
							</td>
							<td align="right" class="pt5 pb5" >
								<a href="./" class="btn primary-padding" onclick="$('#form_project').submit();return false;"><span class="f20 primary-green" ><span >Далее</span></span></a>
							</td>
						</tr>
					</table>
				</form>
			</div>
[[endblock]]