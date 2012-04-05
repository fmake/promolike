[[ extends  TEMPLATE_PATH ~ "base/main.tpl" ]]
[[block content]]
			<h1>Мои компании</h1>
			<a href="/project.php" class="btn primary-padding" style="position: relative;"><span class="f16 primary-green" ><span >+ Добавить компанию</span></span></a>
			<div id="error_api"></div>
			/*<table class="all-stat" >
				<tr>
					<td>Заявок </td>
					<td align="right"><a href="">5000</a></td>
				</tr>
				<tr>
					<td>Всего ссылок</td>
					<td align="right"><a href="">100</a></td>
				</tr>
			</table>*/
			
			<div id="companys" >
				[[for project in projects]]
				<table class="company" >
				<colgroup>
					<col />
					<col width="10%" />
					<col width="10%" />
					<col width="10%" />
					<col width="10%" />
					<col width="120px" />
					<col width="170px" />
				</colgroup>
					<tbody>
						<tr class="head-tr" >
							<td class="nobg" ></td>
							<td>Переходов</td>
							<td>Лайков</td>
							<td>Заявок</td>
							<td>Бюджет</td>
							<td></td>
							<td></td>
						</tr>
						<tr class="head-caption-tr" >
							<td class="left" >
								<img src="/images/minus.gif" alt="раскрыть" class="img-action"  rel="no-active" rel_loop="{loop.index0}" param="{project.id_project}"/> 
								<div class="long_link_box">
									<div class="long_link">
										<span class="pointer" >{project.caption}</span>
									</div>
									<div class="long_link_hidder hidder_gray">&nbsp;</div>
								</div>
							</td>
							<td>956</td>
							<td><a href="">158</a></td>
							<td><a href="">75</a></td>
							<td>5200</td>
							<td></td>
							<td class="right" ><a href="/project.php?id_project={project.id_project}&action=add_page" class="btn primary-padding"><span class="f12 primary-green" ><span>+ Добавить страницу</span></span></a></td>
						</tr>
					</tbody>
				</table>
				<table id="table-project{loop.index0}" class="company-detals" style="display:none;">
					<tr>
						<td class="preloader-table-pages-main"><center><img src="/images/preloader-main-table.gif"></center></td>
					</tr>
				</table>
				[[endfor]]
				
				
			</div>
			
			<br /><br />
[[endblock]]