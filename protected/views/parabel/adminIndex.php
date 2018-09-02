<div class="b-section-nav clearfix">
	<div class="b-section-nav-back clearfix">
		<span class="left"><b>Показывать:</b></span>
		<ul class="b-section-menu clearfix left">
			<li><a href="<?=$this->createUrl('/'.$this->adminMenu['cur']->code.'/adminindex', array("current_month" => true))?>"<? if($this->isCurrentMonth($filter)): ?> class="active"<? endif; ?>>Текущий месяц</a></li>
			<li><a href="<?=$this->createUrl('/'.$this->adminMenu['cur']->code.'/adminindex', array("previous" => true))?>"<? if($this->isPreviousMonth($filter)): ?> class="active"<? endif; ?>>Предыдущий месяц</a></li>
		</ul>
	</div>
</div>
<? if( Yii::app()->user->checkAccess('updateParabel') ): ?><a href="<?php echo $this->createUrl('/'.$this->adminMenu["cur"]->code.'/admincreate',array('payment_id' => $_GET["payment_id"]))?>" class="ajax-form ajax-create b-butt b-top-butt b-with-nav">Добавить</a><? endif; ?>
<h1 class="b-with-nav"><?=$this->adminMenu["cur"]->name?></h1>
<?php $form=$this->beginWidget('CActiveForm'); ?>
<table class="b-table" border="1">
	<tr>
		<th style="width: 210px;"><?=$labels['date']?></th>
		<th><?=$labels['type_id']?></th>
		<? foreach ($providers as $key => $provider): ?>
			<th><?=$provider->name?></th>
		<? endforeach; ?>
		<th style="width: 100px;">Действия</th>
	</tr>
	<tr class="b-filter">
		<td><?php echo CHtml::activeTextField($filter, 'date_from', array('tabindex' => 0, "placeholder" => "От", "class" => "date")); ?><span class="filter-separator">-</span><?php echo CHtml::activeTextField($filter, 'date_to', array('tabindex' => 0, "placeholder" => "До", "class" => "date")); ?></td>
		<td><?php echo CHtml::activeDropDownList($filter, 'type_id', CHtml::listData(ParabelType::model()->findAll(), 'id', 'name'), array("class" => "select2", "empty" => "Все типы грузов", "tabindex" => 1, "placeholder" => "Поиск по типу груза")); ?></td>
		<? foreach ($providers as $key => $provider): ?>
			<td></td>
		<? endforeach; ?>
		<td><a href="#" class="b-clear-filter">Сбросить</a></td>
	</tr>
	<? if( count($data) ): ?>
		<? foreach ($data as $i => $item): ?>
			<? $item->getCubages(); ?>
			<tr>
				<? /* ?><td class="align-left"><? echo $item->id; ?></td><? */ ?>
				<td class="tc"><?=$item->date?></td>
				<td><?=$item->type->name?></td>
				<? foreach ($providers as $key => $provider): ?>
					<td class="tr"><? if( isset($item->cubages[$provider->id]) ): ?><?=$item->cubages[$provider->id]?><? endif; ?></td>
				<? endforeach; ?>
				<td>
					<? if( Yii::app()->user->checkAccess('updateParabel') ): ?>
						<a href="<?php echo Yii::app()->createUrl('/'.$this->adminMenu["cur"]->code.'/adminupdate',array('id'=>$item->id, 'payment_id' => $_GET["payment_id"]))?>" class="ajax-form ajax-update b-tool b-tool-update" title="Редактировать <?=$this->adminMenu["cur"]->vin_name?>"></a>
						<a href="<?=Yii::app()->createUrl('/'.$this->adminMenu["cur"]->code.'/admindelete',array('id'=>$item->id, 'payment_id' => $_GET["payment_id"]))?>" class="ajax-form ajax-delete b-tool b-tool-delete" title="Удалить <?=$this->adminMenu["cur"]->vin_name?>"></a>
					<? endif; ?>
				</td>
			</tr>
		<? endforeach; ?>
	<? else: ?>
		<tr><td colspan=10>Записей не найдено</td></tr>
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
    <div class="b-lot-count">Всего отгрузок: <?=$parabelCount?></div>
    <div class="b-total right">
		<div class="b-total-row">
			<span class="b-total-name">Итого кубов: </span>
			<span class="b-total-bold"><?=number_format( $total, 2, '.', '&nbsp;' )?></span>
		</div>
	</div>
</div>
