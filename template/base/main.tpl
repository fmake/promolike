[[ include TEMPLATE_PATH ~ "blocks/header.tpl"]]
<body>
	<div id="page" >
		
		<div id="header" >
			
[[ include TEMPLATE_PATH ~ "blocks/menu.tpl"]]
			
		[[ include TEMPLATE_PATH ~ "blocks/block_lk.tpl"]]	
			
		</div>
		
		<div id="content" >
		[[block content]]
			
		[[endblock]]
		</div>
		
	</div>
	[[block curtain]]
		
	[[endblock]]
</body>
</html>