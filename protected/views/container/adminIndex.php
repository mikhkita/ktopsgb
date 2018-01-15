<div class="b-section-nav clearfix">
	<div class="b-section-nav-back clearfix">
		<span class="left"><b>Филиалы:</b></span>
		<ul class="b-section-menu clearfix left">
			<? foreach ($branches as $key => $branch): ?>
				<li><a href="<?=$this->createUrl("/".$this->adminMenu["cur"]->code."/adminindex", array("branch_id" => $branch->id))?>"<? if($branch->id == $_GET["branch_id"]): ?> class="active"<? endif; ?>><?=$branch->name?></a></li>
			<? endforeach; ?>
		</ul>
	</div>
</div>
<? if( Yii::app()->user->checkAccess("updateContainer") ): ?><a href="<?php echo $this->createUrl("/".$this->adminMenu["cur"]->code."/admincreate",array("branch_id" => $_GET["branch_id"]))?>" class="ajax-form ajax-create b-butt b-top-butt b-with-nav">Добавить</a><? endif; ?>
<h1 class="b-with-nav"><?=$this->adminMenu["cur"]->name?></h1>
<?php $form=$this->beginWidget("CActiveForm"); ?>
<input type="hidden" name="branch_id" value="<?=$_GET["branch_id"]?>">
<table class="b-table" border="1">
	<tr>
		<th><?=$labels["exporter_id"]?></th>
		<th><?=$labels["way_id"]?></th>
		<th><?=$labels["number"]?></th>
		<th><?=$labels["owner_id"]?></th>
		<th><?=$labels["carrier_id"]?></th>
		<th><?=$labels["loading_date"]?></th>
		<th><?=$labels["issue_date"]?></th>
		<th><?=$labels["location"]?></th>
		<th style="width: 120px;">Действия</th>
	</tr>
	<tr class="b-filter">
		<td><?php echo CHtml::activeDropDownList($filter, "exporter_group_id", CHtml::listData(ExporterGroup::model()->with("branches")->findAll("branches.branch_id=".$_GET["branch_id"]), "id", "name"), array("class" => "select2", "empty" => "Все группы", "tabindex" => 1)); ?></td>
		<td></td>
		<td><?php echo CHtml::activeTextField($filter, "number", array("tabindex" => 2, "placeholder" => "Поиск по номеру")); ?></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td><a href="#" class="b-clear-filter">Сбросить</a></td>
	</tr>
	<? if( count($data) ): ?>
		<? foreach ($data as $i => $item): ?>
			<tr>
				<td><?=(($item->exporter->name)?$item->exporter->name:$item->exporterGroup->name)?></td>
				<td><?=$item->station->name?>-<?=$item->way->name?></td>
				<td><?=$item->number?></td>
				<td><?=$item->owner->name?></td>
				<td><?=$item->carrier->name?></td>
				<td class="tc"><?=$item->loading_date?></td>
				<td class="tc"><?=$item->issue_date?></td>
				<td><a href="<?php echo Yii::app()->createUrl("/".$this->adminMenu["cur"]->code."/adminlocationhistory",array("id"=>$item->id, "branch_id" => $_GET["branch_id"]))?>" title="История изменений дислокации" target="_blank" class="b-help"><?=$item->locations[0]->name?></a></td>
				<td>
					<? if( Yii::app()->user->checkAccess("updateLocation") ): ?>
						<a href="<?php echo Yii::app()->createUrl("/".$this->adminMenu["cur"]->code."/adminlocation",array("id"=>$item->id, "branch_id" => $_GET["branch_id"]))?>" class="ajax-form ajax-update b-tool b-tool-location" title="Указать дислокацию"></a>
					<? endif; ?>
					<? if( Yii::app()->user->checkAccess("updateContainer") ): ?>
						<a href="<?php echo Yii::app()->createUrl("/".$this->adminMenu["cur"]->code."/adminupdate",array("id"=>$item->id, "branch_id" => $_GET["branch_id"]))?>" class="ajax-form ajax-update b-tool b-tool-update" title="Редактировать <?=$this->adminMenu["cur"]->vin_name?>"></a>
						<a href="<?=Yii::app()->createUrl("/".$this->adminMenu["cur"]->code."/admindelete",array("id"=>$item->id))?>" class="ajax-form ajax-delete b-tool b-tool-delete" title="Удалить <?=$this->adminMenu["cur"]->vin_name?>"></a>
					<? endif; ?>
				</td>
			</tr>
		<? endforeach; ?>
	<? else: ?>
		<tr><td colspan=100>Контейнеров не найдено</td></tr>
	<? endif; ?>
</table>
<?php $this->endWidget(); ?>
<div class="b-pagination-cont clearfix">
    <?php $this->widget("CLinkPager", array(
        "header" => "",
        "lastPageLabel" => "последняя &raquo;",
        "firstPageLabel" => "&laquo; первая", 
        "pages" => $pages,
        "prevPageLabel" => "< назад",
        "nextPageLabel" => "далее >"
    )) ?>
    <div class="b-lot-count">Всего контейнеров: <?=$count?></div>
</div>
