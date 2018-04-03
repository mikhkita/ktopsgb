<? if( Yii::app()->user->checkAccess("updateContainer") ): ?><a href="<?php echo $this->createUrl("/".$this->adminMenu["cur"]->code."/admincargocreate",array("container_id" => $_GET["container_id"]))?>" class="ajax-form ajax-create b-butt b-top-butt">Добавить</a><? endif; ?>
<h1>Груз контейнера №<?=$container->number?></h1>
<table class="b-table" border="1">
	<tr>
		<th><?=$labels["id"]?></th>
		<th><?=$labels["type_id"]?></th>
		<th><?=$labels["length"]?></th>
		<th><?=$labels["thickness"]?></th>
		<th><?=$labels["cubage"]?></th>
		<th><?=$labels["count"]?></th>
		<th><?=$labels["price"]?></th>
		<th><?=$labels["sum"]?></th>
		<th style="width: 150px;">Действия</th>
	</tr>
	<? if( count($data) ): ?>
		<? foreach ($data as $i => $item): ?>
			<tr>
				<td><?=$item->id?></td>
				<td><?=$item->type->name?></td>
				<td><?=$item->length?></td>
				<td><?=$item->thickness?></td>
				<td><?=$item->cubage?></td>
				<td><?=$item->count?></td>
				<td><?=$item->price?></td>
				<td><?=number_format( $item->price*$item->cubage, 2, '.', '&nbsp;' )?></td>
				<td>
					<? if( Yii::app()->user->checkAccess("updateContainer") ): ?>
						<a href="<?php echo Yii::app()->createUrl("/".$this->adminMenu["cur"]->code."/admincargoupdate",array("id"=>$item->id, "container_id" => $_GET["container_id"]))?>" class="ajax-form ajax-update b-tool b-tool-update" title="Редактировать груз"></a>
						<a href="<?=Yii::app()->createUrl("/".$this->adminMenu["cur"]->code."/admincargodelete",array("id"=>$item->id, "container_id" => $_GET["container_id"]))?>" class="ajax-form ajax-delete b-tool b-tool-delete" title="Удалить груз"></a>
					<? endif; ?>
				</td>
			</tr>
		<? endforeach; ?>
	<? else: ?>
		<tr><td colspan=100>Позиций не найдено</td></tr>
	<? endif; ?>
</table>
<div class="b-pagination-cont clearfix">
    <div class="b-lot-count">Всего позиций: <?=count($data)?></div>
    <div class="b-total right">
		<div class="b-total-row">
			<span class="b-total-name">Общая сумма: </span>
			<span class="b-total-bold"><?=number_format( $total->sum, 2, '.', '&nbsp;' )?></span>
		</div>
		<div class="b-total-row">
			<span class="b-total-name">Общая кубатура: </span>
			<span class="b-total-bold"><?=number_format( $total->cubage, 2, '.', '&nbsp;' )?></span>
		</div>
	</div>
</div>
