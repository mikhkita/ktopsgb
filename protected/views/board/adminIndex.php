<div class="b-section-nav clearfix">
	<div class="b-section-nav-back clearfix">
		<span class="left"><b>Место:</b></span>
		<ul class="b-section-menu clearfix left">
			<? foreach ($plants as $key => $plant): ?>
				<li><a href="<?=$this->createUrl('/'.$this->adminMenu['cur']->code.'/adminindex', array('plant_id' => $plant->id))?>"<? if($plant->id == $_GET["plant_id"]): ?> class="active"<? endif; ?>><?=$plant->name?></a></li>
			<? endforeach; ?>
		</ul>

		<span class="left"><b>Показывать:</b></span>
		<ul class="b-section-menu clearfix left">
			<li><a href="<?=$this->createUrl('/'.$this->adminMenu['cur']->code.'/adminindex', array("plant_id" => $_GET["plant_id"]))?>"<? if($this->isCurrentMonth($filter)): ?> class="active"<? endif; ?>>Текущий месяц</a></li>
			<li><a href="<?=$this->createUrl('/'.$this->adminMenu['cur']->code.'/adminindex', array("previous" => true, "plant_id" => $_GET["plant_id"]))?>"<? if($this->isPreviousMonth($filter)): ?> class="active"<? endif; ?>>Предыдущий месяц</a></li>
		</ul>
	</div>
</div>
<? if( Yii::app()->user->checkAccess('updateBoard') ): ?><a href="<?php echo $this->createUrl('/'.$this->adminMenu["cur"]->code.'/admincreate',array('plant_id' => $_GET["plant_id"]))?>" class="ajax-form ajax-create b-butt b-top-butt b-with-nav">Добавить</a><? endif; ?>
<h1 class="b-with-nav"><?=$this->adminMenu["cur"]->name?></h1>
<?php $form=$this->beginWidget('CActiveForm'); ?>
<input type="hidden" name="plant_id" value="<?=$_GET["plant_id"]?>">
<table class="b-table" border="1">
	<tr>
		<th style="width: 210px; min-width: 210px;"><?=$labels['date']?></th>
		<th><?=$itemLabels['length']?></th>
		<th><?=$itemLabels['thickness']?></th>
		<th><?=$itemLabels['width']?></th>
		<th><?=$itemLabels['count']?></th>
		<th><?=$itemLabels['cubage']?></th>
		<? if( $curPlant->is_price ): ?>
			<th><?=$itemLabels['price']?></th>
		<? endif; ?>
		<? if( $curPlant->is_price ): ?>
			<th><?=$itemLabels['sum']?></th>
			<th><?=$labels['sum']?></th>
		<? endif; ?>
		<th><?=$labels['cubageSum']?></th>
		<th style="width: 90px;">Действия</th>
	</tr>
	<tr class="b-filter">
		<td><?php echo CHtml::activeTextField($filter, 'date_from', array('tabindex' => 0, "placeholder" => "От", "class" => "date")); ?><span class="filter-separator">-</span><?php echo CHtml::activeTextField($filter, 'date_to', array('tabindex' => 0, "placeholder" => "До", "class" => "date")); ?></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<? if( $curPlant->is_price ): ?>
			<td></td>
			<td></td>
			<td></td>
		<? endif; ?>
		<td></td>
		<td><a href="#" class="b-clear-filter">Сбросить</a></td>
	</tr>
	<? if( count($data) ): ?>
		<? foreach ($data as $i => $board): ?>
			<tr>
				<td rowspan="<?=count($board->items)?>" class="tc"><?=$board->date?></td>
				<? if( count($board->items) ): ?>
					<?php $this->renderPartial("_item", array("item" => $board->items[0], "curPlant" => $curPlant)); ?>
				<? else: ?>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<? if( $curPlant->is_price ): ?>
						<td></td>
						<td></td>
						<td></td>
					<? endif; ?>
					<td></td>
				<? endif; ?>
				<? if( $curPlant->is_price ): ?>
					<td rowspan="<?=count($board->items)?>" class="tc"><?=number_format( floor($board->getSum()*100)/100, 2, '.', '&nbsp;' )?></td>
				<? endif; ?>
				<td rowspan="<?=count($board->items)?>" class="tc"><?=number_format( floor($board->getCubageSum()*100)/100, 2, '.', '&nbsp;' )?></td>
				<td rowspan="<?=count($board->items)?>">
					<? if( Yii::app()->user->checkAccess('updateBoard') ): ?>
						<a href="<?php echo Yii::app()->createUrl('/'.$this->adminMenu["cur"]->code.'/adminupdate',array('id'=>$board->id, 'plant_id' => $_GET["plant_id"]))?>" class="ajax-form ajax-update b-tool b-tool-update" title="Редактировать <?=$this->adminMenu["cur"]->vin_name?>"></a>
						<a href="<?=Yii::app()->createUrl('/'.$this->adminMenu["cur"]->code.'/admindelete',array('id'=>$board->id, 'plant_id' => $_GET["plant_id"]))?>" class="ajax-form ajax-delete b-tool b-tool-delete" title="Удалить <?=$this->adminMenu["cur"]->vin_name?>"></a>
					<? endif; ?>
				</td>
			</tr>
			<? if( count($board->items) > 1 ): ?>
				<? for( $i = 1; $i < count($board->items); $i++ ): ?>
					<tr>
						<?php $this->renderPartial("_item", array("item" => $board->items[$i], "curPlant" => $curPlant)); ?>
					</tr>
				<? endfor; ?>
			<? endif; ?>
		<? endforeach; ?>
	<? else: ?>
		<tr><td colspan=12>Записей не найдено</td></tr>
	<? endif; ?>
</table>
<?php $this->endWidget(); ?>
<div class="b-pagination-cont clearfix">
    <?php $this->widget('CLinkPager', array(
        'header' => '',
        'lastPageLabel' => 'последняя &raquo;',
        'firstPageLabel' => '&laquo; первая', 
        'pages' => $pages,
        'prevPageLabel' => '< назад',
        'nextPageLabel' => 'далее >'
    )) ?>
    <div class="b-lot-count">Всего отгрузок: <?=$count?></div>
    <div class="b-total right">
		<div class="b-total-row">
			<span class="b-total-name">Итого кубов: </span>
			<span class="b-total-bold"><?=number_format( $total->cubage, 2, '.', '&nbsp;' )?></span>
		</div>
		<? if( $curPlant->is_price ): ?>
			<div class="b-total-row">
				<span class="b-total-name">Итого денег: </span>
				<span class="b-total-bold"><?=number_format( $total->sum, 2, '.', '&nbsp;' )?></span>
			</div>
		<? endif; ?>
	</div>
</div>
