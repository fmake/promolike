<input type="hidden" name="action" value="add_page_filter">
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
						<input type="checkbox" name="fb" class="check" id="fb"  />
					</td>
					<td align="center">
						<input type="checkbox" name="vk" class="check" id="vk" />
					</td>
					<td align="center">
						<input type="checkbox" name="tw" class="check" id="tw" />
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
				<option value="0">больше</option>
				<option value="1">меньше</option>
			</select>
			<input type="text" name="count_friends" onkeyup="return proverkaInt(this);" style="width: 190px;" value="" />
		</td>
	</tr>
	<tr>
		<td class="middle" >
			Сообщений
		</td>
		<td class="middle" >
			<select name="comparison_messages" class="checkselect" >
				<option value="0">больше</option>
				<option value="1">меньше</option>
			</select>
			<input type="text" name="count_messages" onkeyup="return proverkaInt(this);" style="width: 190px;" value="" />
		</td>
	</tr>
	<tr>
		<td class="middle" >
			Активность
		</td>
		<td class="middle" >
			<select class="checkselect" name="activity" style="width: 100%;"  >
				<option value="0">без разницы</option>
				<option value="1">маленькая</option>
				<option value="2">средняя</option>
				<option value="3">большая</option>
			</select>
		</td>
	</tr>
	<tr>
		<td class="big" >
			Бюджет
		</td>
		<td class="big" >
			<input type="text" name="budget" onkeyup="return proverkaInt(this);" value="" />
		</td>
	</tr>
	<tr>
		<td class="middle" >
			Название фильтра
		</td>
		<td class="middle" >
			<input type="text" name="caption" value="" />
		</td>
	</tr>
	<tr>
		<td >
		</td>
		<td align="right" >
			<a href="#" class="btn primary-padding" onclick="xajax_Otmena();return false;"><span class="f20 primary-green" ><span >Отмена</span></span></a>
			<a href="#" class="btn primary-padding" onclick="document.getElementById('create_filter').submit();return false;"><span class="f20 primary-green" ><span >Создать</span></span></a>
		</td>
	</tr>
</table>