<div class="b-link-back">
	<a href="<?=$this->createUrl('/'.$this->adminMenu["cur"]->code.'/adminindex')?>">Назад</a>
</div>
<? if( Yii::app()->user->checkAccess('updateDryerQueue') ): ?>
	<a href="<?=$this->createUrl('/'.$this->adminMenu["cur"]->code.'/adminqueuecreate',array('dryer_id' => $dryer->id))?>" class="ajax-form ajax-create b-butt b-top-butt">Добавить загрузку</a>
<? endif; ?>
<h1>История загрузок сушилки №<?=$dryer->number?></h1>
<table class="b-table" border="1">
	<tr>
		<? /* ?><th style="width: 30px;">№</th><? */ ?>
		<th><?=$labels['start_date']?></th>
		<th><?=$labels['size']?></th>
		<th><?=$labels['cubage']?></th>
		<th><?=$labels['packs']?></th>
		<th><?=$labels['rows']?></th>
		<th><?=$labels['comment']?></th>
		<th><?=$labels['complete_date']?></th>
		<? if( Yii::app()->user->checkAccess('updateDryerQueue') ): ?>
			<th style="width: 100px;">Действия</th>
		<? endif; ?>
	</tr>
	<? if( count($data) ): ?>
		<? foreach ($data as $i => $item): ?>
			<tr>
				<? /* ?><td class="align-left"><? echo $item->id; ?></td><? */ ?>
				<td class="tc"><?=$item->start_date?></td>
				<td class="tl"><?=$item->size?></td>
				<td class="tl"><?=$item->cubage?></td>
				<td class="tl"><?=$item->packs?></td>
				<td class="tl"><?=$item->rows?></td>
				<td class="tl"><?=$item->comment?></td>
				<td class="tc"><?=$item->complete_date?></td>
				<? if( Yii::app()->user->checkAccess('updateDryerQueue') ): ?>
					<td>
						<a href="<?=Yii::app()->createUrl('/'.$this->adminMenu["cur"]->code.'/adminqueueupdate',array('id' => $item->id))?>" class="ajax-form ajax-update b-tool b-tool-update" title="Редактировать загрузку"></a>
						<a href="<?=Yii::app()->createUrl('/'.$this->adminMenu["cur"]->code.'/adminqueuedelete',array('id' => $item->id))?>" class="ajax-form ajax-delete b-tool b-tool-delete" title="Удалить загрузку"></a>
					</td>
				<? endif; ?>
			</tr>
		<? endforeach; ?>
	<? endif; ?>
</table>
