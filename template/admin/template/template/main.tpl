{Include "admin/blocks/head"}
<body class="ltr">

<div id="wrap">
	<div id="page-header">
		<h1>Центр администрирования <a href="http://www.{$hostname}" target="_blanck">www.{$hostname}</a></h1>
		<p><a href="./index.php">Главная</a>  </p>
		<p id="skip"></p>

	</div>
	
	<div id="page-body">
		<div id="tabs">
			<ul>
			
				{Foreach "$menu as $men"}
					{If "$men['id']==$mod['id'] || $men['status']"}
						<li id="activetab"><a href="./?modul={$men['redir']}"><span>{$men['caption']}</span></a></li>
					{elseIf}
						<li><a href="./?modul={$men['redir']}"><span>{$men['caption']}</span></a></li>
					{/}
				{/}
				
						
			</ul>

		</div>

		<div id="acp">
		<div class="panel">
			<span class="corners-top"><span></span></span>
				<div id="content">
					 
					<div id="toggle">
						<a id="toggle-handle" accesskey="m" title="Показать или скрыть боковое меню" onclick="switch_menu(); return false;" href="#"></a></div>

					
					<div id="menu_template">

						<p>Вы вошли как:<br /><strong>admin</strong> [&nbsp;<a href="./?action=logout">Выход</a>&nbsp;]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
						{Include "admin/template/template/left"}
						
						
					</div>
					
					<div id="main">
						<!-- Главный контент -->
						
						{Include "$block"}
					</div>
				</div>
			<span class="corners-bottom"><span></span></span>
			<div class="clear"></div>
		</div>
		</div>
	</div>
	<div id="page-footer">
		
			
			<br />
	</div>
</div>
</body>
</html>