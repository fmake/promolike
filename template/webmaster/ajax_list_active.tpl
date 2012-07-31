<td colspan="7">
	<div class="table-list">
		<table>
			[[if likes]]
				<tr class="dashed bg-title">
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
							[[if item.status==3]]
								Опубликован и ожидает проверки (примерно 2-3 дня)
							[[elseif item.status==4]]	
								Опубликован и засчинан
							[[elseif item.status==5]]	
								Удалена
							[[endif]]
						</td>
						<td class="list-active-date">
							[[if item.date_history]]
								{df('date','H:i d.m.Y',item.date_history)}
							[[else]]
								{df('date','H:i d.m.Y',item.date_placed)}
							[[endif]]
						</td>
						<td class="list-active-text">
							{item.like_text}
						</td>
					</tr>
				[[endfor]]
			[[else]]
					<tr>
						<td class="list-active-status">
						</td>
						<td class="list-active-date">
						</td>
						<td  class="list-active-text">
							Небыло публикаций на данной площядке
						</td>
					</tr>
			[[endif]]
		</table>
	</div>
</td>
