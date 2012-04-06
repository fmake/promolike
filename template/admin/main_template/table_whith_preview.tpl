<script type="text/javascript" src="/js/admin/jquery-latest.js"></script>
<script type="text/javascript" src="/js/admin/jquery.tablesorter.js"></script> 

<script type="text/javascript" >
$(document).ready(function(){ 
	
	$("#data").tablesorter({widgets: ["zebra"]});
	
}); 

function check_all(id, name, state){
	
	
	
	var parent = document.getElementById(id);
	
	if (!parent)
	{
		eval('parent = document.' + id);
	}

	if (!parent)
	{
		return;
	}
	
	var rb = parent.getElementsByTagName('input');
	
	for (var r = 0; r < rb.length; r++)
	{
		if (rb[r].name.substr(0, name.length) == name)
		{
			rb[r].checked = state;
		}
	}
}

	function invert_all(id, name){
		var parent = document.getElementById(id);
		if (!parent)
		{
			eval('parent = document.' + id);
		}
	
		if (!parent)
		{
			return;
		}
		
		var rb = parent.getElementsByTagName('input');
		
		for (var r = 0; r < rb.length; r++)
		{
			if (rb[r].name.substr(0, name.length) == name)
			{
				rb[r].checked = !rb[r].checked;
			}
		}		
	}

</script> 

<style>

	table.data_sort thead tr th {
		background-image: url('/images/admin/td_non_sort.gif');
		background-repeat: no-repeat;
		background-position: center right;
		cursor: pointer;
	}

	table.data_sort thead tr .headerSortUp {
		background-image: url('/images/admin/asc.gif');
	}
	table.data_sort thead tr .headerSortDown {
		background-image: url('/images/admin/desc.gif');
	}
	
</style>
	
		<BR><a href="/admin/?modul={$request->modul}&action=new{$added}" title="Добавить">Добавить</a><BR><BR><BR>
	<h1>{$mod['caption']}</h1>
	
	<hr>
	{If "$content"}
		{$content}
		<BR><BR>
		<?$content = '';?>
	{/}
		
	{If "$items"}	
	<table border="0" cellspacing="1" cellpadding="0" class="data_sort" id="data">
	
	<thead>
		<tr>
			<td> <?echo $absitem->getPreviewCaption(); ?> </td>

	{Foreach "$filds as $key=>$fild"}
		{If "$sort_filds[$key]"}
			<th>{$fild}</th>
		{elseIf}
			<td>{$fild}</td>
		{/}
	{/}
		
	<td colspan=<?=count($actions)?>">Управление</td>
	<td><input type="checkbox" name="check_action[]" onclick="check_all('data','check_action',this.checked);" class="radio"   /></td>
	</tr>
	</thead>
	<tbody>
	<form method="POST" action="/admin/index.php?modul={$request->modul}" >
		<input type="hidden" name="modul" value="{$request->modul}" />
		{Foreach "$items as $key=>$item"}
			<tr OnMouseOver="this.className +=' show';" OnMouseOut="this.className = this.className.replace(/\bshow\b/, ' ');">
			{If "$item['level']"}
				<? $padding = 25 * $item["level"];?>
			{/}
			<td height="35px"  ><center><?echo $absitem->getPreview($item); ?></center></td>
			
			{Foreach "$filds as $key=>$fild"}
				<?echo "			<td".(($key == "caption" && $item["level"])? " style='padding-left:".$padding."px;'":"").">".$item[$key]."</td>\n"; ?>	
			{/}
			
			{Include "admin/blocks/actions"}
			
			<td ><center><input type="checkbox" name="check_action[]" value="{$item['id']}"  class="radio" /></center></td>
			
			</tr>
		{/}
	
	
	
	</tbody></table>
	
	<br />
	<hr>

	<fieldset class="quick">
		выберите действие: <select name="group_action" >
			{If "$group_actions"}
				<option value="0"></option>
				{Foreach "$group_actions as $gr_action"}
					<option value="{$gr_action}"><?echo $group_action_val[$gr_action];?></option>
				{/}
			{/}
			</select>
		<input class="button2" value="Выполнить" type="submit">

	</fieldset>

	<fieldset class="quick">
		<input class="button2" name="delall" value="Удалить все" type="submit" onclick="javascript: return confirm('Удалить все записи?');" >&nbsp;
		<input class="button2" name="delmarked" value="Удалить отмеченные" type="submit" onclick="javascript: return confirm('Удалить отмеченные записи?');" ><br>
		<p class="small"><a href="javascript: void(0);" onclick="check_all('data','check_action',true); return false;">Отметить все</a> • <a href="javascript: void(0);" onclick="invert_all('data','check_action',true); return false;">Инвертировать</a> • <a href="javascript: void(0);" onclick="check_all('data','check_action',false); return false;">Снять выделение</a></p>
	</fieldset>
	</form>
	{/}
	<script>makeStripy('data')</script>	
	<BR><BR><a href="/admin/?modul={$request->modul}&action=new{$added}" title="Добавить">Добавить</a>