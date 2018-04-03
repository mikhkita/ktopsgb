<h1>Статистика по безналу</h1>
<table class="b-table" border="1">
	<tr class="b-header">
		<th>Месяц</th>
		<? foreach ($data[1]["order"] as $i => $col): ?>
			<th><?=$col["name"]?></th>
		<? endforeach; ?>
	</tr>
	<? foreach ($data as $i => $month): ?>
		<tr>
			<td><b><?=$month["name"]?></b></td>
			<? foreach ($month["order"] as $i => $col): ?>
				<td class="tr"><?=number_format( $col["sum"], 2, '.', '&nbsp;' )?></td>
			<? endforeach; ?>
		</tr>
	<? endforeach; ?>
	<tr>
		<td class="tr"><b>Итого:</b></td>
		<? foreach ($data[1]["order"] as $i => $col): ?>
			<td class="tr"><b><?=number_format( $total[$i], 2, '.', '&nbsp;' )?></b></td>
		<? endforeach; ?>
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