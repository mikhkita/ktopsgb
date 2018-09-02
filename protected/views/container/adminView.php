<div class="clearfix">
	<h1>Примечания контейнера №<?=$model->number?></h1>
	<a href="<?=$backLink?>" class="b-link-back b-btn">Назад</a>
</div>
<? if( $this->checkAccess("updateBranch", $model->station->branch_id) ): ?><a href="<?php echo $this->createUrl("/note/adminCreate", array("container_id" => $model->id))?>" class="ajax-form ajax-create b-butt b-top-butt">Добавить</a><? endif; ?>
	<table class="b-table" border="1">
		<tr>
			<th><?=$noteLabels["id"]?></th>
			<th><?=$noteLabels["date"]?></th>
			<th><?=$noteLabels["text"]?></th>
			<th><?=$noteLabels["user_id"]?></th>
			<th style="width: 100px;">Действия</th>
		</tr>
		<? if( count($model->notes) ): ?>
			<? foreach ($model->notes as $i => $item): ?>
				<tr>
					<td><?=$item->id?></td>
					<td><?=$item->date?></td>
					<td>
						<?=str_replace("\n", "<br>", $item->text)?>
						<? if( count($item->files) ): ?>
							<div class="b-table-docs">
								<? foreach ($item->files as $key => $file): ?>
								<div class="b-doc-file"><a href="<?=("/".Yii::app()->params['docsFolder']."/".$file->id."/".$file->original)?>" class="b-doc" target="_blank"><?=$file->original?></a><a href="<?=Yii::app()->createUrl('/site/download',array('file_id'=>$file->id))?>" class="b-download"></a></div>
								<? endforeach; ?>
							</div>
						<? endif; ?>
					</td>
					<td><?=$item->user->fio?></td>
					<td>
						<? if( $this->checkAccess("updateBranch", $model->station->branch_id) ): ?><a href="<?php echo Yii::app()->createUrl('/note/adminupdate',array('id'=>$item->id))?>" class="ajax-form ajax-update b-tool b-tool-update" title="Редактировать примечание"></a>
						<a href="<?=Yii::app()->createUrl('/note/admindelete',array('id'=>$item->id))?>" class="ajax-form ajax-delete b-tool b-tool-delete" title="Удалить примечание"></a><? endif; ?>
					</td>
				</tr>
			<? endforeach; ?>
		<? else: ?>
			<tr>
				<td colspan="10">Нет примечаний</td>
			</tr>
		<? endif; ?>
	</table>