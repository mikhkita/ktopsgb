<div class="b-section-nav clearfix">
	<div class="b-section-nav-back clearfix">
		<span class="left"><b>Филиалы:</b></span>
		<ul class="b-section-menu clearfix left">
			<? foreach ($branches as $key => $branch): ?>
				<li><a href="<?=$this->createUrl("/".$this->adminMenu["cur"]->code."/adminindex", array("branch_id" => $branch->id))?>"<? if($branch->id == $_GET["branch_id"]): ?> class="active"<? endif; ?>><?=$branch->name?></a></li>
			<? endforeach; ?>
		</ul>
		<? if( !$edit ): ?>
			<ul style="margin-left: 32px;" class="b-section-menu clearfix left">
				<li><a href="<?=$this->createUrl("/".$this->adminMenu["cur"]->code."/adminupdateall", array("branch_id" => $_GET["branch_id"], "partial" => true))?>" class="ajax-action ajax-update-all require-checkbox">Редактировать</a></li>
				<li><a href="<?=$this->createUrl("/".$this->adminMenu["cur"]->code."/adminlocationall", array("branch_id" => $_GET["branch_id"], "partial" => true))?>" class="ajax-form ajax-update require-checkbox">Указать дислокацию</a></li>
			</ul>

			<ul style="margin-left: 32px;" class="b-section-menu clearfix left">
				<li><a href="<?=$this->createUrl("/".$this->adminMenu["cur"]->code."/adminexport", array("branch_id" => $_GET["branch_id"]))?>" class="require-checkbox">Экспорт</a></li>
			</ul>
		<? endif; ?>
	</div>
</div>
<? if( Yii::app()->user->checkAccess("updateContainer") && !$edit ): ?><a href="<?php echo $this->createUrl("/".$this->adminMenu["cur"]->code."/admincreate",array("branch_id" => $_GET["branch_id"]))?>" class="ajax-form ajax-create b-butt b-top-butt b-with-nav">Добавить</a><? endif; ?>
<h1 class="b-with-nav"><?=$this->adminMenu["cur"]->name?></h1>
<?php $form=$this->beginWidget("CActiveForm", array("action" => $this->createUrl("/".$this->adminMenu["cur"]->code."/adminupdateall", array("branch_id" => $_GET["branch_id"])))); ?>
<input type="hidden" name="branch_id" value="<?=$_GET["branch_id"]?>">
<table class="b-table b-sess-checkbox-info<? if( $edit ): ?> b-table-form<? endif; ?>" data-add-url="<?=Yii::app()->createUrl('/container/adminaddcheckbox', array("branch_id" => $_GET["branch_id"]))?>" data-add-many-url="<?=Yii::app()->createUrl('/container/adminaddmanycheckboxes', array("branch_id" => $_GET["branch_id"]))?>" data-remove-many-url="<?=Yii::app()->createUrl('/container/adminremovemanycheckboxes', array("branch_id" => $_GET["branch_id"]))?>" data-remove-url="<?=Yii::app()->createUrl('/container/adminremovecheckbox', array("branch_id" => $_GET["branch_id"]))?>" border="1">
	<tr>
		<th></th>
		<th style="width: 125px; min-width: 125px;"><a href="<?php echo $this->createUrl('/container/adminviewsettings',array("branch_id" => $_GET["branch_id"]))?>" class="ajax-form ajax-update b-tool b-tool-settings" title="Настроить отображение"></a></th>
		<? foreach ($fields as $i => $field): ?>
			<th><?=$field["NAME"]?></th>
		<? endforeach; ?>
	</tr>
		<? if( $edit ): ?>
		<tr class="b-set-all">
			<td class="tc" colspan="2">Задать общее значение</td>
			<? foreach ($fields as $i => $field): ?>
				<td><? $value = ""; $template = "#"; eval($field["FORM"]); echo $value; ?></td>
			<? endforeach; ?>
		</tr>
		<? else: ?>
		<tr class="b-filter">
			<td class="tc"><a href="<?php echo $this->createUrl('/container/adminremoveallcheckboxes', array("branch_id" => $_GET["branch_id"]))?>" class="b-sess-allcheckbox b-tool b-tool-uncheck" title="Сбросить выделение"></a></td>
			<td class="tc"><a href="#" class="b-clear-filter">Сбросить фильтр</a></td>
			<? foreach ($fields as $i => $field): ?>
				<td><? $item = $filter; $value = ""; $template = "Container[#]"; eval( ( (isset($field["FILTER"]))?$field["FILTER"]:$field["FORM"] ) ); echo $value; ?></td>
			<? endforeach; ?>
		</tr>
		<? endif; ?>
	<? if( count($data) ): ?>
		<? foreach ($data as $i => $item): ?>
			<tr>
				<td class="tc b-checkbox-cont"><input type="checkbox" name="id" class="b-sess-checkbox" data-block="#b-sess-checkbox-list" <? if($item->isChecked($_GET["branch_id"])): ?>checked="checked"<? endif; ?> value="<?=$item->id?>"></td>
				<td class="tc">
					<? if( Yii::app()->user->checkAccess("updateLocation") ): ?>
						<a href="<?php echo Yii::app()->createUrl("/".$this->adminMenu["cur"]->code."/adminlocation",array("id"=>$item->id, "branch_id" => $_GET["branch_id"]))?>" class="ajax-form ajax-update b-tool b-tool-location" title="Указать дислокацию"></a>
					<? endif; ?>
					<? if( Yii::app()->user->checkAccess("updateContainer") ): ?>
						<a href="<?php echo Yii::app()->createUrl("/".$this->adminMenu["cur"]->code."/adminupdate",array("id"=>$item->id, "branch_id" => $_GET["branch_id"]))?>" class="ajax-form ajax-update b-tool b-tool-update" title="Редактировать <?=$this->adminMenu["cur"]->vin_name?>"></a>
						<a href="<?php echo Yii::app()->createUrl("/".$this->adminMenu["cur"]->code."/admincargoindex",array("container_id"=>$item->id))?>" class="b-tool b-tool-box" title="Груз"></a>
						<a href="<?=Yii::app()->createUrl("/".$this->adminMenu["cur"]->code."/admindelete",array("id"=>$item->id))?>" class="ajax-form ajax-delete b-tool b-tool-delete" title="Удалить <?=$this->adminMenu["cur"]->vin_name?>"></a>
					<? endif; ?>
				</td>
				<? foreach ($fields as $i => $field): ?>
					<? if( $edit ): ?>
						<td><? $value = ""; $template = "Container[".$item->id."][#]"; eval($field["FORM"]); echo $value; ?></td>
					<? else: ?>
						<td><? $value = ""; $template = "Container[".$item->id."][#]"; eval($field["VALUE"]); echo $value; ?></td>
					<? endif; ?>
				<? endforeach; ?>
			</tr>
		<? endforeach; ?>
	<? else: ?>
		<tr><td class="tc" colspan=100>Контейнеров не найдено</td></tr>
	<? endif; ?>
</table>
<? if( $edit ): ?>
<div class="row buttons">
	<?php echo CHtml::submitButton($model->isNewRecord ? "Добавить" : "Сохранить"); ?>
	<a href="<?=$this->createUrl("/".$this->adminMenu["cur"]->code."/adminindex", array("branch_id" => $_GET["branch_id"]))?>" type="button" class="button">Отменить</a>
</div>
<? endif; ?>
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
<div class="tl" id="b-sess-checkbox-list"><?=Controller::getTextCheckboxes("container".$_GET["branch_id"]);?></div>
