<script language="Javascript" type="text/javascript" src="/admin/edit_area/edit_area_full.js"></script>
<script language="Javascript" type="text/javascript">
		
		editAreaLoader.init({
			id: "main_text"	// id of the textarea to transform	
			,start_highlight: true
			,allow_toggle: false
			,language: "ru"
			,syntax: "html"	
			,toolbar: "search,save, go_to_line, |, undo, redo, |, select_font, |, syntax_selection, |, change_smooth_selection, highlight, reset_highlight"
			,syntax_selection_allow: "css,html,js,php,sql"
			,is_multi_files: true
			,EA_load_callback: "editAreaLoaded"
			,save_callback: "my_save"
			,show_line_colors: true
		});
		
		function my_save(id, content){
			var tmpFile = editAreaLoader.getCurrentFile(id);
			xajax_saveFile(tmpFile['id'],tmpFile['text'])
			//alert("Here is the content of the EditArea '"+ id +"' as received by the save callback function:\n"+content);
		}
		
</script>


	<h2 id="caption" >&nbsp;{If "$save"}Шаблон {$request->template} изменен{/}</h2>
	{$mod['text']}
	<hr>
	<form method="POST" >
		<input type="hidden" name="action" value="save"  />
		<input type="hidden" name="template" value="" id="template"  /> 
		<textarea id="main_text" rows="35" style="width: 100%;margin: 0 20px 0 0;" name="content_template"  ></textarea>
	</form>
	<BR><BR>
