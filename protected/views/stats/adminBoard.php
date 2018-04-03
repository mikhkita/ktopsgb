<h1>Статистика по доскам Чин</h1>
<table class="b-table" border="1">
	<tr class="b-header">
		<th>Месяц</th>
		<th>Кубатура</th>
		<th>Сумма</th>
	</tr>
	<? foreach ($data as $i => $month): ?>
		<tr>
			<td><b><?=$month["name"]?></b></td>
			<td class="tr"><?=number_format( $month["cubage"], 2, '.', '&nbsp;' )?></td>
			<td class="tr"><?=number_format( $month["sum"], 2, '.', '&nbsp;' )?></td>
		</tr>
	<? endforeach; ?>
	<tr>
		<td class="tr"><b>Итого:</b></td>
		<td class="tr"><?=number_format( $total["cubage"], 2, '.', '&nbsp;' )?></td>
		<td class="tr"><?=number_format( $total["sum"], 2, '.', '&nbsp;' )?></td>
	</tr>
</table>
<? /* ?>
<div class="b-pagination-cont clearfix">
    <div class="b-total right">
		<div class="b-total-row">
			<span class="b-total-name">Остаток в кассе: </span>
			<span class="b-total-bold"><?=number_format( $total["finance"], 0, '.', '&nbsp;' )?> руб.</span>
		</div>
	</div>
</div>
<? */ ?>