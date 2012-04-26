<?

if(in_array('showlink',$actions))
	$content .= "			<td valign=\"middle\" align=\"center\"><a href=\"/admin/?modul=".$request->modul."&id=".$item[$absitem->idField]."&action=showlink$added\" title=\"".(($item["showlink"]==1)? "Убрать из главных новостей":"Отображать в главных новостях")."\"><img src=\"/images/admin/".(($item["showlink"]==1)?"published":"notpublished").".gif\" width=\"14\" height=\"14\" border=\"0\" alt=\"".(($item["showlink"]==1)? "Убрать из главных новостей":"Отображать в главных новостях")."\"></a></td>\n";

if(in_array('inmain',$actions))
	$content .= "			<td valign=\"middle\" align=\"center\"><a href=\"/admin/?modul=".$request->modul."&id=".$item[$absitem->idField]."&action=inmain$added\" title=\"".(($item["inmain"]==1)? "Убрать из главных новостей":"Отображать в главных новостях")."\"><img src=\"/images/admin/".(($item["inmain"]==1)?"published":"notpublished").".gif\" width=\"14\" height=\"14\" border=\"0\" alt=\"".(($item["inmain"]==1)? "Убрать из главных новостей":"Отображать в главных новостях")."\"></a></td>\n";

if(in_array('inmenu',$actions))
	$content .= "			<td valign=\"middle\" align=\"center\"><a href=\"/admin/?modul=".$request->modul."&id=".$item[$absitem->idField]."&action=inmenu$added\" title=\"".(($item["inmenu"]==1)? "Убрать из меню":"Отображать в меню")."\"><img src=\"/images/admin/".(($item["inmenu"]==1)?"published":"notpublished").".gif\" width=\"14\" height=\"14\" border=\"0\" alt=\"".(($item["inmenu"]==1)? "Убрать из меню":"Отображать в меню")."\"></a></td>\n";

if(in_array('voting_coment',$actions))
	$content .= "			<td valign=\"middle\" align=\"center\"><a href=\"/admin/?modul=voting_coment&show_id=".$item[$absitem->idField]."\" title=\"Ответы\"><img src=\"/images/admin/spec.gif\" width=\"16\" height=\"16\" border=\"0\" alt=\"Ответы\"></a></td>\n";
	
if(in_array('index',$actions))
	$content .= "			<td valign=\"middle\" align=\"center\"><a href=\"/admin/?modul=".$request->modul."&id=".$item[$absitem->idField]."&action=index$added\" title=\"Сделать главной\"><img src=\"/images/admin/".(($item["index"]==1)?"new":"notnew").".gif\" width=\"16\" height=\"16\" border=\"0\" alt=\"Сделать главной\"></a></td>\n";
if(in_array('main',$actions))
	$content .= "			<td valign=\"middle\" align=\"center\"><a href=\"/admin/?modul=".$request->modul."&id=".$item[$absitem->idField]."&action=main$added\" title=\"Сделать текущим\"><img src=\"/images/admin/".(($item["current"]==1)?"new":"notnew").".gif\" width=\"16\" height=\"16\" border=\"0\" alt=\"Сделать текущим\"></a></td>\n";
if(in_array('innew',$actions))
	$content .= "			<td valign=\"middle\" align=\"center\"><a href=\"/admin/?modul=".$request->modul."&id=".$item[$absitem->idField]."&action=innew$added\" title=\"".(($item["innew"]==1)? "Новое предложение":"Убрать из новых")."\"><img src=\"/images/admin/".(($item["innew"]==1)?"spec":"notspec").".gif\" width=\"16\" height=\"16\" border=\"0\" alt=\"".(($item["innew"]==1)? "Новое предложение":"Убрать из новых")."\"></a></td>\n";

if(in_array('spec',$actions))
	$content .= "			<td valign=\"middle\" align=\"center\"><a href=\"/admin/?modul=".$request->modul."&id=".$item[$absitem->idField]."&action=spec$added\" title=\"".(($item["spec"]==1)? "Убрать из спецпредложений":"В спецпредложения")."\"><img src=\"/images/admin/".(($item["spec"]==1)?"estimat":"notestimat").".gif\" width=\"16\" height=\"16\" border=\"0\" alt=\"".(($item["spec"]==1)? "Убрать из спецпредложений":"В спецпредложения")."\"></a></td>\n";

if(in_array('estimat',$actions))
	$content .= "			<td valign=\"middle\" align=\"center\"><a href=\"/admin/?modul=".$request->modul."&id=".$item[$absitem->idField]."&action=estimat$added\" title=\"".(($item["estimat"]==1)? "Убрать из ожидаемых поступлений":"В ожидаемые поступления")."\"><img src=\"/images/admin/".(($item["estimat"]==1)?"estimat":"notestimat").".gif\" width=\"14\" height=\"14\" border=\"0\" alt=\"".(($item["estimat"]==1)? "Убрать из ожидаемых поступлений":"В ожидаемые поступления")."\"></a></td>\n";

if(in_array('move',$actions))
	$content .= "			<td valign=\"middle\" align=\"center\" width='40' ><a href=\"/admin/?modul=".$request->modul."&id=".$item[$absitem->idField]."&action=up$added\" title=\"Вверх\" style='float:left;'><img src=\"/images/admin/icon_up.gif\" width=\"16\" height=\"16\" border=\"0\" alt=\"Вверх\"></a><a href=\"/admin/?modul=".$request->modul."&id=".$item[$absitem->idField]."&action=down$added\" title=\"Вниз\" style='float:right;' ><img src=\"/images/admin/icon_down.gif\" width=\"16\" height=\"16\" border=\"0\" alt=\"\"></a></td>\n";

if(in_array('active',$actions))
	$content .= "			<td valign=\"middle\" align=\"center\"><a href=\"/admin/?modul=".$request->modul."&id=".$item[$absitem->idField]."&action=active$added\" title=\"".(($item["active"]==1)? "Выключить":"Включить")."\"><img src=\"/images/admin/".(($item["active"]==1)?"on":"off").".gif\" width=\"12\" height=\"14\" border=\"0\" alt=\"".(($item["active"]==1)? "Выключить":"Включить")."\"></a></td>\n";

if(in_array('copythis',$actions))
	$content .= "			<td valign=\"middle\" align=\"center\"><a href=\"/admin/?modul=".$request->modul."&id=".$item[$absitem->idField]."&action=copythis$added\" title=\"Копировать размер\"><img src=\"/images/admin/copythis.gif\" width=\"16\" height=\"16\" border=\"0\" alt=\"Копировать размер\"></a></td>\n";

if(in_array('comments',$actions))
	$content .= "			<td valign=\"middle\" align=\"center\"><a href=\"/admin/?modul=".$request->modul."_comment&item_id=".$item[$absitem->idField]."\" title=\"Редактировать комментарии\"><img src=\"/images/admin/edit_char.gif\" width=\"16\" height=\"16\" border=\"0\" alt=\"Редактировать комментарии\"></a></td>\n";

if(in_array('parameters',$actions))
	$content .= "			<td valign=\"middle\" align=\"center\"><a href=\"/admin/?modul=parameters&item_id=".$item[$absitem->idField]."\" title=\"Редактировать параметры\"><img src=\"/images/admin/parameters.gif\" width=\"16\" height=\"16\" border=\"0\" alt=\"Редактировать параметры\"></a></td>\n";

if(in_array('edit',$actions))
	$content .= "			<td valign=\"middle\" align=\"center\"><a href=\"/admin/?modul=".$request->modul."&id=".$item[$absitem->idField]."&action=edit$added\" title=\"Редактировать\"><img src=\"/images/admin/icon_edit.gif\" width=\"16\" height=\"15\" border=\"0\" alt=\"Редактировать\"></a></td>\n";

if(in_array('send_mail',$actions))
	$content .= "			<td valign=\"middle\" align=\"center\"><a href=\"/admin/?modul=".$request->modul."&id=".$item[$absitem->idField]."&action=send_mail$added\" title=\"Отправить заказ\"><img src=\"/images/admin/sendmail.gif\" width=\"15\" height=\"13\" border=\"0\" alt=\"Отправить письмо\"></a></td>\n";
	
if(in_array('adddate',$actions))
	$content .= "			<td valign=\"middle\" align=\"center\"><a href=\"/admin/?modul=datetime&show_id=".$item[$absitem->idField]."\" title=\"Добавить дату\"><img src=\"/images/admin/adddate.gif\" width=\"16\" height=\"15\" border=\"0\" alt=\"Добавить дату\"></a></td>\n";

if(in_array('price',$actions))
	$content .= "			<td valign=\"middle\" align=\"center\"><a href=\"/admin/?modul=prices&show_id=".$item[$absitem->idField]."\" title=\"Цены\"><img src=\"/images/admin/edit_char.gif\" width=\"16\" height=\"16\" border=\"0\" alt=\"Цены\"></a></td>\n";

if(in_array('delete',$actions))
	$content .= "			<td valign=\"middle\" align=\"center\"><a href=\"/admin/?modul=".$request->modul."&id=".$item[$absitem->idField]."&action=delete$added\" title=\"Удалить\" onclick=\"return confirm('Удалить запись?');\"><img src=\"/images/admin/del.gif\" width=\"13\" height=\"16\" border=\"0\" alt=\"Удалить\"></a></td>\n";

	echo $content;
	$content = "";
?>