[[ extends  TEMPLATE_PATH ~ "base/main.tpl" ]]
[[block content]]
	[[raw]]
			<script type="text/javascript">
			function submitForm()
			{
				document.getElementById("form_create_text").submit();
			}
			function updatePage()
			{
				document.getElementById("form_create_text").submit();
			}
			function Cansel(){
				document.location = document.location;
			}
			function Next(action){
				var r=confirm("Сохранить внесенные данные?")
				
				if (r==true)
				{
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
					</td></tr> 
					</table>
				</div>
				<br />
				
				<div id="create-pages" style="margin-right: 179px;">
					<h1>Уже добавленные тексты:</h1>
					<div id="all_pages">
							<div class="page">
								<table class="page_textlike" id="page_textlike">
									[[ include TEMPLATE_PATH ~ "ajax_tpl/add_text_page.tpl"]]	
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
						[[ include TEMPLATE_PATH ~ "ajax_tpl/form_text_page_edit.tpl"]]
					</table>
				</form>					
				[[else]]
				<form method="POST" action="/project.php?id_project={request.id_project}&action=add_text" id="form_create_text" enctype="multipart/form-data">
					<input type="hidden" name="action_add_text_page" value="add_text">
					<input type="hidden" name="id_project" value="{project.id_project}">
					<input type="hidden" name="id_user" value="{project.id_user}">
					<input type="hidden" name="add_next_button" value="" id="add_next_button">
					<table class="form-table" id="form-table">
						[[ include TEMPLATE_PATH ~ "ajax_tpl/form_text_page.tpl"]]					
					</table>
				</form>
				[[endif]]
				<br />
			</div>
			[[if error.alert]]
				{error.alert|raw} 
			[[endif]]
[[endblock]]