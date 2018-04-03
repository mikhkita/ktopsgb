<td class="tr"><?=round($item->length, 3)?></td>
<td class="tr"><?=round($item->thickness, 3)?></td>
<td class="tr"><?=round($item->width, 3)?></td>
<td class="tr"><?=round($item->count, 3)?></td>
<td class="tr"><?=floor($item->thickness*$item->width*$item->length*$item->count*100)/100?></td>
<? if( $curPlant->is_price ): ?>
	<td class="tr"><?=round($item->price, 3)?></td>
	<td class="tr"><?=number_format( floor($item->price*$item->count*100)/100, 2, '.', '&nbsp;' )?></td>
<? endif; ?>