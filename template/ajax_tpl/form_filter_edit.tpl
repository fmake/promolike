<input type="hidden" name="action" value="create_filter">
<input type="hidden" name="update" value="1">
<input type="hidden" name="id_filter" value="{id_filter}">
<input type="hidden" name="id_page" value="{id_page}">
[[if update or request.update]]
	<input type="hidden" name="update" value="1">
	<input type="hidden" name="id_filter" value="{id_filter}">
[[endif]]
<table class="form-table filter" > 
	<tr>
		<td class="middle" >
			Социальная сеть
		</td>
		<td class="middle" >
			<table>
				<tr>
					<td>
						<label for="fb">
							<img src="/images/fb.gif" alt="" />
						</label>
					</td>
					<td>
						<label for="vk">
							<img src="/images/vk.gif" alt="" />
						</label>	
					</td>
					<td>
						<label for="tw" >
							<img src="/images/tw.gif" alt="" />
						</label>	
					</td>
				</tr>
				<tr>
					<td align="center">
						<input type="checkbox" [[if social_set[1]]]checked="checked"[[endif]] name="fb" class="check" id="fb"  />
					</td>
					<td align="center">
						<input type="checkbox" [[if social_set[2]]]checked="checked"[[endif]] name="vk" class="check" id="vk" />
					</td>
					<td align="center">
						<input type="checkbox" [[if social_set[3]]]checked="checked"[[endif]] name="tw" class="check" id="tw" />
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td class="middle" >
			Кол-во друзей
		</td>
		<td class="middle" >
			<select name="comparison_friends" class="checkselect" >
				<option [[if filter_info.comparison_friends==0]]selected="selected"[[endif]] value="0">больше</option>
				<option [[if filter_info.comparison_friends==1]]selected="selected"[[endif]] value="1">меньше</option>
			</select>
			<input type="text" name="count_friends" onkeyup="return proverkaInt(this);" style="width: 190px;" value="[[if error]]{request.count_friends}[[endif]]" />
		</td>
	</tr>
	<tr>
		<td class="middle" >
			Сообщений
		</td>
		<td class="middle" >
			<select name="comparison_messages" class="checkselect" >
				<option [[if filter_info.comparison_messages==0]]selected="selected"[[endif]] value="0">больше</option>
				<option [[if filter_info.comparison_messages==1]]selected="selected"[[endif]] value="1">меньше</option>
			</select>
			<input type="text" name="count_messages" onkeyup="return proverkaInt(this);" style="width: 190px;" value="[[if error]]{request.count_messages}[[endif]]" />
		</td>
	</tr>
	<tr>
		<td class="middle" >
			Активность
		</td>
		<td class="middle" >
			<select class="checkselect" name="activity" style="width: 100%;"  >
				<option [[if filter_info.activity==0]]selected="selected"[[endif]] value="0">без разницы</option>
				<option [[if filter_info.activity==1]]selected="selected"[[endif]] value="1">маленькая</option>
				<option [[if filter_info.activity==2]]selected="selected"[[endif]] value="2">средняя</option>
				<option [[if filter_info.activity==3]]selected="selected"[[endif]] value="3">большая</option>
			</select>
		</td>
	</tr>
	<tr>
		<td class="big" >
			Бюджет
		</td>
		<td class="big" >
			<input type="text" name="budget" onkeyup="return proverkaInt(this);" value="{filter_info.budget}" />
		</td>
	</tr>
	<tr>
		<td class="middle" >
			Название фильтра
		</td>
		<td class="middle" >
			<input type="text" name="caption" value="{filter_info.caption}" />
		</td>
	</tr>
	<tr>
		<td >
		</td>
		<td align="right" >
			<a href="#" class="btn primary-padding" onclick="xajax_Otmena();return false;"><span class="f20 primary-green" ><span >Отмена</span></span></a>
			<a href="#" class="btn primary-padding" onclick="document.getElementById('create_filter').submit();return false;"><span class="f20 primary-green" ><span >Редактировать</span></span></a>
		</td>
	</tr>
</table>