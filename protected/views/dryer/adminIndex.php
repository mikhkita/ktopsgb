<? if( Yii::app()->user->checkAccess('updateDryer') ): ?><a href="<?php echo $this->createUrl('/'.$this->adminMenu["cur"]->code.'/admincreate')?>" class="ajax-form ajax-create b-butt b-top-butt">Добавить</a><? endif; ?>
<h1><?=$this->adminMenu["cur"]->name?></h1>

<table class="b-table" border="1">
	<tr>
		<? /* ?><th style="width: 30px;">№</th><? */ ?>
		<th><?=$labels['number']?></th>
		<th><?=$queueLabels['start_date']?></th>
		<th><?=$queueLabels['size']?></th>
		<th><?=$queueLabels['cubage']?></th>
		<th><?=$queueLabels['packs']?></th>
		<th><?=$queueLabels['rows']?></th>
		<th><?=$queueLabels['comment']?></th>
		<th style="width: 130px;">Действия</th>
	</tr>
	<? foreach ($data as $i => $item): ?>
		<tr>
			<? /* ?><td class="align-left"><? echo $item->id; ?></td><? */ ?>
			<td class="align-center"><?=$item->number?></td>
			<? if( count($item->queue) > 0 ): ?>
				<td class="tc"><?=$item->queue[0]->start_date?></td>
				<td><?=$item->queue[0]->size?></td>
				<td><?=$item->queue[0]->cubage?></td>
				<td><?=$item->queue[0]->packs?></td>
				<td><?=$item->queue[0]->rows?></td>
				<td><?=$item->queue[0]->comment?></td>
			<? else: ?>
				<td colspan="6" class="orange">Не загружена</td>
			<? endif; ?>
			<td>
				<? if( Yii::app()->user->checkAccess('updateDryerQueue') ): ?>
					<? if( count($item->queue) > 0 ): ?>
						<a href="<?=Yii::app()->createUrl('/'.$this->adminMenu["cur"]->code.'/adminqueueupdate',array('id' => $item->queue[0]->id, 'dryers' => true))?>" class="ajax-form ajax-update b-tool b-tool-update" title="Править загрузку"></a>
						<a href="<?php echo Yii::app()->createUrl('/'.$this->adminMenu["cur"]->code.'/adminqueuecomplete',array('id' => $item->queue[0]->id))?>" class="ajax-form ajax-update b-tool b-tool-out" title="Добавить выгрузку"></a>
					<? else: ?>
						<a href="<?=$this->createUrl('/'.$this->adminMenu["cur"]->code.'/adminqueuecreate',array('dryer_id' => $item->id, 'dryers' => true))?>" class="ajax-form ajax-create b-tool b-tool-in" title="Добавить загрузку"></a>
					<? endif; ?>
				<? endif; ?>
				<a href="<?=Yii::app()->createUrl('/'.$this->adminMenu["cur"]->code.'/admindetail',array('dryerID'=>$item->id))?>" class="b-tool b-tool-list" title="История загрузок"></a>
				<? if( Yii::app()->user->checkAccess('updateDryer') && 0 ): ?><a href="<?php echo Yii::app()->createUrl('/'.$this->adminMenu["cur"]->code.'/adminupdate',array('id'=>$item->id))?>" class="ajax-form ajax-update b-tool b-tool-update" title="Редактировать <?=$this->adminMenu["cur"]->vin_name?>"></a>
				<a href="<?=Yii::app()->createUrl('/'.$this->adminMenu["cur"]->code.'/admindelete',array('id'=>$item->id))?>" class="ajax-form ajax-delete b-tool b-tool-delete" title="Удалить <?=$this->adminMenu["cur"]->vin_name?>"></a><? endif; ?>
			</td>
		</tr>
	<? endforeach; ?>
</table>
