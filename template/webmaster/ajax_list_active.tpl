<td colspan="7">
	<div class="table-list">
		<table>
			<tr class="dashed">
				<td class="list-active-status">
					Статус
				</td>
				<td class="list-active-date">
					Дата
				</td>
				<td class="list-active-text">
					Рекламный текст
				</td>
			</tr>
			[[for item in likes]]
				<tr class="dashed">
					<td class="list-active-status">
						{item.status}
					</td>
					<td class="list-active-date">
						{df('date','H:i d.m.Y',item.date_placed)}
					</td>
					<td class="list-active-text">
						{item.like_text}
					</td>
				</tr>
			[[else]]
				<tr class="">
					<td style="width: 100%;">
						<center>Небыло публикаций на данной площядке</center>
					</td>
				</tr>
			[[endfor]]
		</table>
	</div>
</td>
