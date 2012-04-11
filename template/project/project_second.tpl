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
					</td></tr> 
					</table>
				</div>
				<br />
				
				<div id="create-pages">
					<h1>Уже созданные страницы:</h1>
					<div id="all_pages">
						[[ include TEMPLATE_PATH ~ "ajax_tpl/add_page.tpl"]]				
					</div>

					
				</div>
				[[if page]]
				<form method="get" id="form_create_page">
					<input type="hidden" name="id_project" value="{project.id_project}">
					<input type="hidden" name="id_user" value="{project.id_user}">
					/*<input type="hidden" name="id_page" value="{page.id_page}">*/
					<input type="hidden" name="update" value="[[if update]]1[[else]]0[[endif]]">
					<table class="form-table" id="form-table">
						[[ include TEMPLATE_PATH ~ "ajax_tpl/form_page_edit.tpl"]]
					</table>
				</form>					
				[[else]]
				<form method="get" id="form_create_page">
					<input type="hidden" name="id_project" value="{project.id_project}">
					<input type="hidden" name="id_user" value="{project.id_user}">
					<table class="form-table" id="form-table">
						[[ include TEMPLATE_PATH ~ "ajax_tpl/form_page.tpl"]]
					</table>
				</form>
				[[endif]]
				<br />
			</div>
[[endblock]]