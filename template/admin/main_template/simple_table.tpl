	
	
	<BR><a href="/admin/?modul={$request->modul}&action=new{$added}" title="Добавить">Добавить</a><BR><BR><BR>

	<h1>{$mod['caption']}</h1>
	{$mod['text']}
	<hr>
	{If "$content"}
		{$content}
		<BR><BR>
		<?$content = '';?>
	{/}
	{If "$items"}
	<table border="0" cellspacing="1" cellpadding="0" class="data" id="data">
	<thead>
		<tr>
			<td>id</td>
	{Foreach "$filds as $fild"}
		<td>{$fild}</td>
	{/}
	
	<td colspan=<?=count($actions)?>">Управление</td>
	</tr>
	</thead>
	<tbody>
		{Foreach "$items as $key=>$item"}
			<tr OnMouseOver="this.className +=' show';" OnMouseOut="this.className = this.className.replace(/\bshow\b/, ' ');">
			{If "$item['level']"}
				<? $padding = 25 * $item["level"];?>
			{/}
			<td height="35px"><?php echo  $item[$absitem->idField];?></td>
			
			{Foreach "$filds as $key=>$fild"}
				<?echo "			<td".(($key == "caption" && $item["level"])? " style='padding-left:".$padding."px;'":"").">".$item[$key]."</td>\n"; ?>	
			{/}
			
			{Include "admin/blocks/actions"}
			
			</tr>
		{/}	
	</tbody></table><script>makeStripy('data')</script>	
	<BR><BR><a href="/admin/?modul={$request->modul}&action=new{$added}" title="Добавить">Добавить</a>
	{/}