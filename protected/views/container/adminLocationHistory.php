<div class="b-link-back">
	<a href="<?=$this->createUrl("/".$this->adminMenu["cur"]->code."/adminindex", array("branch_id" => $_GET["branch_id"]))?>">Назад</a>
</div>
<? if( Yii::app()->user->checkAccess("updateLocation") ): ?><a href="<?php echo $this->createUrl("/container/adminlocation", array("id" => $container->id))?>" class="ajax-form ajax-create b-butt b-top-butt">Добавить</a><? endif; ?>
<h1>Дислокация контейнера №<?=$container->number?></h1>
<table class="b-table" border="1">
	<tr>
		<th><?=$labels["date"]?></th>
		<th><?=$labels["name"]?></th>
		<th><?=$labels["user_id"]?></th>
		<? if( Yii::app()->user->checkAccess("updateLocation") ): ?>
			<th style="width: 120px;">Действия</th>
		<? endif; ?>
	</tr>
	<? foreach ($data as $i => $item): ?>
		<tr>
			<td class="align-left"><?=$item->date?></td>
			<td class="align-left"><?=$item->name?></td>
			<td class="align-left"><?=$item->user->name?></td>
			<? if( Yii::app()->user->checkAccess("updateLocation") ): ?>
				<td>
					<a href="<?=Yii::app()->createUrl("/".$this->adminMenu["cur"]->code."/adminlocationdelete",array("id" => $item->id, "branch_id" => $_GET["branch_id"]))?>" class="ajax-form ajax-delete b-tool b-tool-delete" title="Удалить дислокацию"></a>
				</td>
			<? endif; ?>
		</tr>
	<? endforeach; ?>
</table>
