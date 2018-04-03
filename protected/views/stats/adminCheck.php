<h1>Сверка оплат</h1>
<table class="b-table" border="1">
	<tr class="b-header">
		<th>Корреспондент</th>
		<th>Сумма отгрузок</th>
		<th>Оборот Дт</th>
		<th>Итого</th>
	</tr>
	<? foreach ($data as $i => $item): ?>
		<tr>
			<td><?=$item->name?></td>
			<td class="tr"><?=number_format( $item->sumWoods, 2, ',', '&nbsp;' )?></td>
			<td class="tr"><?=number_format( $item->sumOrders, 2, ',', '&nbsp;' )?></td>
			<td class="tr <?=(($item->sumTotal < 0)?"red":"green")?>"><?=number_format( $item->sumTotal, 2, ',', '&nbsp;' )?></td>
		</tr>
	<? endforeach; ?>
	<tr>
		<td class="tr"><b>Итого:</b></td>
		<td class="tr"><b><?=number_format( $total->woods, 2, ',', '&nbsp;' )?></b></td>
		<td class="tr"><b><?=number_format( $total->orders, 2, ',', '&nbsp;' )?></b></td>
		<td class="tr <?=(($total->total < 0)?"red":"green")?>"><?=number_format( $total->total, 2, ',', '&nbsp;' )?></td>
	</tr>
</table>
