<?php $form=$this->beginWidget("CActiveForm", array("action" => $this->createUrl("/".$this->adminMenu["cur"]->code."/adminupdateall", array("branch_id" => $_GET["branch_id"])))); ?>
<input type="hidden" name="set_filter" value="true">
<? if( !$edit ): ?>
	<div class="b-section-nav clearfix">
		<div class="b-section-nav-back clearfix">
			<span class="left"><b>Филиалы:</b></span>
			<div class="b-branch-select b-filter left">
				<?php echo CHtml::dropDownList('branch_id', $_GET["branch_id"], CHtml::listData($branches, 'id', 'name'), array("class" => "no-clear branch-select select2", "tabindex" => 1)); ?>
			</div>
			<span class="left"><b>Показывать:</b></span>
			<ul class="b-section-menu clearfix left">
				<li><a href="<?=$this->createUrl('/'.$this->adminMenu['cur']->code.'/adminindex', array("current_month" => true, "type_id" => $_GET["type_id"]))?>"<? if($this->isCurrentMonth($filter)): ?> class="active"<? endif; ?>>Текущий месяц</a></li>
				<li><a href="<?=$this->createUrl('/'.$this->adminMenu['cur']->code.'/adminindex', array("current_year" => true, "type_id" => $_GET["type_id"]))?>"<? if($this->isCurrentYear($filter)): ?> class="active"<? endif; ?>>Текущий год</a></li>
			</ul>
			<? if( $this->checkAccess("updateBranch") || Yii::app()->user->checkAccess("updateLocation") ): ?>
				<ul style="margin-left: 32px;" class="b-section-menu clearfix left">
					<? if( $this->checkAccess("updateBranch") ): ?>
						<li><a href="<?=$this->createUrl("/".$this->adminMenu["cur"]->code."/adminupdateall", array("branch_id" => $_GET["branch_id"], "partial" => true))?>" class="ajax-action ajax-update-all require-checkbox">Редактировать</a></li>
					<? endif; ?>
					<? if( Yii::app()->user->checkAccess("updateLocation") ): ?>
						<li><a href="<?=$this->createUrl("/".$this->adminMenu["cur"]->code."/adminlocationall", array("branch_id" => $_GET["branch_id"], "partial" => true))?>" class="ajax-form ajax-update require-checkbox">Указать дислокацию</a></li>
					<? endif; ?>
				</ul>
			<? endif; ?>

			<ul style="margin-left: 32px;" class="b-section-menu clearfix left">
				<li><a href="<?=$this->createUrl("/".$this->adminMenu["cur"]->code."/adminexport", array("branch_id" => $_GET["branch_id"]))?>" class="require-checkbox">Экспорт</a></li>
			</ul>
		</div>
	</div>
<? endif; ?>
<div class="b-with-nav b-top-butt b-left-butt"><? if( $this->checkAccess("updateBranch") && !$edit ): ?><a href="<?php echo $this->createUrl("/".$this->adminMenu["cur"]->code."/admincreate",array("branch_id" => $_GET["branch_id"]))?>" class="ajax-form ajax-create b-butt left">Добавить</a> <a href="<?php echo $this->createUrl("/".$this->adminMenu["cur"]->code."/admincreate",array("branch_id" => $_GET["branch_id"], "many" => true))?>" class="ajax-form ajax-create b-butt left" style="margin-left: 10px;">Добавить несколько</a><? endif; ?></div>
<? if( !$edit ): ?>
	<h1 class="b-with-nav"><?=$this->adminMenu["cur"]->name?></h1>
<? else: ?>
	<h1>Множественное редактирование контейнеров</h1>
<? endif; ?>
<table class="b-table b-sess-checkbox-info<? if( $edit ): ?> b-table-form<? endif; ?>" data-add-url="<?=Yii::app()->createUrl('/container/adminaddcheckbox', array("branch_id" => $_GET["branch_id"]))?>" data-add-many-url="<?=Yii::app()->createUrl('/container/adminaddmanycheckboxes', array("branch_id" => $_GET["branch_id"]))?>" data-remove-many-url="<?=Yii::app()->createUrl('/container/adminremovemanycheckboxes', array("branch_id" => $_GET["branch_id"]))?>" data-remove-url="<?=Yii::app()->createUrl('/container/adminremovecheckbox', array("branch_id" => $_GET["branch_id"]))?>" border="1">
	<tr>
		<? if( !$edit ): ?>
			<th style="width: 33px; max-width: 33px;"></th>
		<? endif; ?>
		<th style="width: 150px; min-width: 150px;"><a href="<?php echo $this->createUrl('/container/adminviewsettings',array("branch_id" => $_GET["branch_id"]))?>" class="ajax-form ajax-update b-tool b-tool-settings" title="Настроить отображение"></a></th>
		<? foreach ($fields as $i => $field): ?>
			<th<? if($i == "issue_date"): ?> style="width: 210px; min-width: 210px;"<? endif; ?>><?=$field["NAME"]?></th>
		<? endforeach; ?>
	</tr>
		<? if( $edit ): ?>
			<tr class="b-set-all">
				<td class="tc" colspan="1">Задать общее значение ></td>
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
				<? if( !$edit ): ?>
					<td class="tc b-checkbox-cont"><input type="checkbox" name="container_id" class="b-sess-checkbox" data-block="#b-sess-checkbox-list" <? if($item->isChecked($_GET["branch_id"])): ?>checked="checked"<? endif; ?> value="<?=$item->id?>"></td>
				<? endif; ?>
				<td class="tc">
					<? if( !$edit ): ?>
						<? if( $this->checkAccess("readBranch") ): ?>
							<a href="<?php echo Yii::app()->createUrl("/".$this->adminMenu["cur"]->code."/adminview",array("id"=>$item->id))?>" class="b-tool b-tool-list" title="Примечания"></a>
							<a href="<?php echo Yii::app()->createUrl("/".$this->adminMenu["cur"]->code."/admincargoindex",array("container_id"=>$item->id))?>" class="b-tool b-tool-box" title="Груз"></a>
						<? endif; ?>
						<? if( Yii::app()->user->checkAccess("updateLocation") ): ?>
							<a href="<?php echo Yii::app()->createUrl("/".$this->adminMenu["cur"]->code."/adminlocation",array("id"=>$item->id, "branch_id" => $_GET["branch_id"]))?>" class="ajax-form ajax-update b-tool b-tool-location" title="Указать дислокацию"></a>
						<? endif; ?>
						<? if( $this->checkAccess("updateBranch") ): ?>
							<a href="<?php echo Yii::app()->createUrl("/".$this->adminMenu["cur"]->code."/adminupdate",array("id"=>$item->id, "branch_id" => $_GET["branch_id"]))?>" class="ajax-form ajax-update b-tool b-tool-update" title="Редактировать <?=$this->adminMenu["cur"]->vin_name?>"></a>
							<a href="<?=Yii::app()->createUrl("/".$this->adminMenu["cur"]->code."/admindelete",array("id"=>$item->id, "branch_id" => $_GET["branch_id"]))?>" class="ajax-form ajax-delete b-tool b-tool-delete" title="Удалить <?=$this->adminMenu["cur"]->vin_name?>"></a>
						<? endif; ?>
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
<div class="row buttons tleft">
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
