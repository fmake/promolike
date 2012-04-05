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

					
					<div id="menu">

						<p>Вы вошли как:<br /><strong>admin</strong> [&nbsp;<a href="./?action=logout">Выход</a>&nbsp;]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
						<ul>
						
							
						{Foreach "$menu as $men"}
							{If "$men['status'] &&  $men['child']"}
								{Foreach "$men['child'] as $sub"}
									{If "!$sub['redir']"}
										<li class="header">{$sub['caption']}</li>
										<?continue;?>
									{/}
									{If "$sub['status'] && $sub['id']==$mod['id']"}
										<li id="activemenu" ><a href="./?modul={$sub['redir']}" ><span>{$sub['caption']}</span></a></li>
									{elseIf}
										<li><a href="./?modul={$sub['redir']}" ><span>{$sub['caption']}</span></a></li>
									{/}
									{If "$sub['child']"}
										{Foreach "$sub['child'] as $sub2"}
											{If "$sub2['status']"}
												<li id="activemenu" ><a href="./?modul={$sub2['redir']}"  ><span style="padding-left:20px;">{$sub2['caption']}</span></a></li>
											{elseIf}
												<li ><a href="./?modul={$sub2['redir']}" ><span  style="padding-left:20px;" >{$sub2['caption']}</span></a></li>
											{/}
										{/}
									{/}
								{/}
							{/}
						{/}
						</ul>
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
		
			
			
	</div>
</div>
</body>
</html>