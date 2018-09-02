<div class="b-section-nav clearfix">
	<div class="b-section-nav-back clearfix">
		<span class="left"><b>Место:</b></span>
		<ul class="b-section-menu clearfix left">
			<? foreach ($places as $key => $place): ?>
				<li><a href="<?=$this->createUrl('/'.$this->adminMenu['cur']->code.'/adminindex', array('place_id' => $place->id))?>"<? if($place->id == $_GET["place_id"]): ?> class="active"<? endif; ?>><?=$place->name?></a></li>
			<? endforeach; ?>
		</ul>

		<span class="left"><b>Показывать:</b></span>
		<ul class="b-section-menu clearfix left">
			<li><a href="<?=$this->createUrl('/'.$this->adminMenu['cur']->code.'/adminindex', array("current_month" => true, "plant_id" => $_GET["plant_id"]))?>"<? if($this->isCurrentMonth($filter)): ?> class="active"<? endif; ?>>Текущий месяц</a></li>
			<li><a href="<?=$this->createUrl('/'.$this->adminMenu['cur']->code.'/adminindex', array("previous" => true, "plant_id" => $_GET["plant_id"]))?>"<? if($this->isPreviousMonth($filter)): ?> class="active"<? endif; ?>>Предыдущий месяц</a></li>
		</ul>
	</div>
</div>
<? if( Yii::app()->user->checkAccess('updateIncoming') ): ?><a href="<?php echo $this->createUrl("/".$this->adminMenu["cur"]->code."/adminCreate",array('place_id' => $_GET["place_id"]))?>" class="ajax-form ajax-create b-butt b-top-butt b-with-nav">Добавить</a><? endif; ?>
<h1 class="b-with-nav"><?=$this->adminMenu["cur"]->name?></h1>
<?php $form=$this->beginWidget('CActiveForm'); ?>
<input type="hidden" name="place_id" value="<?=$_GET["place_id"]?>">
<table class="b-table" border="1">
	<tr>
		<th style="width: 210px; min-width: 210px;"><? echo $labels["date"]; ?></th>
		<th><? echo $labels["car"]; ?></th>
		<th><? echo $labels["cargo"]; ?></th>
		<th style="width: 100px;">Действия</th>
	</tr>
	<tr class="b-filter">
		<td><?php echo CHtml::activeTextField($filter, 'date_from', array('tabindex' => 0, "placeholder" => "От", "class" => "date")); ?><span class="filter-separator">-</span><?php echo CHtml::activeTextField($filter, 'date_to', array('tabindex' => 0, "placeholder" => "До", "class" => "date")); ?></td>
		<td><?php echo CHtml::activeTextField($filter, 'car', array('tabindex' => 1, "placeholder" => "Поиск по номеру авто")); ?></td>
		<td><?php echo CHtml::activeTextField($filter, 'cargo', array('tabindex' => 2, "placeholder" => "Поиск по грузу")); ?></td>
		<td><a href="#" class="b-clear-filter">Сбросить</a></td>
	</tr>
	<? foreach ($data as $i => $item): ?>
		<tr>
			<td class="tc"><? echo $item->date; ?></td>
			<td class="tl"><? echo $item->car; ?></td>
			<td class="tl"><? echo $item->cargo; ?></td>
			<td>
				<? if( Yii::app()->user->checkAccess('updateIncoming') ): ?><a href="<?php echo Yii::app()->createUrl('/'.$this->adminMenu["cur"]->code.'/adminupdate',array('id'=>$item->id))?>" class="ajax-form ajax-update b-tool b-tool-update" title="Редактировать <?=$this->adminMenu["cur"]->vin_name?>"></a>
				<a href="<?=Yii::app()->createUrl('/'.$this->adminMenu["cur"]->code.'/admindelete',array('id'=>$item->id))?>" class="ajax-form ajax-delete b-tool b-tool-delete" title="Удалить <?=$this->adminMenu["cur"]->vin_name?>"></a><? endif; ?>
			</td>
		</tr>
	<? endforeach; ?>
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
    <div class="b-lot-count">Всего записей: <?=$count?></div>
</div>
