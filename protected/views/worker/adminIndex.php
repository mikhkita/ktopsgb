<? if( Yii::app()->user->checkAccess('updateSaw') ): ?><a href="<?php echo $this->createUrl("/".$this->adminMenu["cur"]->code."/adminCreate")?>" class="ajax-form ajax-create b-butt b-top-butt">Добавить</a><? endif; ?>
<h1><?=$this->adminMenu["cur"]->name?></h1>
<?php $form=$this->beginWidget('CActiveForm'); ?>
<table class="b-table" border="1">
	<tr>
		<th><? echo $labels["name"]; ?></th>
		<? foreach ($plankGroups as $key => $plankGroup): ?>
			<th><?=$plankGroup->name?></th>
		<? endforeach; ?>
		<th><? echo $labels["salary"]; ?></th>
		<th style="width: 100px;">Действия</th>
	</tr>
	<tr class="b-filter">
		<td><?php echo CHtml::activeTextField($filter, 'name', array('tabindex' => 1, "placeholder" => "Поиск по имени")); ?></td>
		<? foreach ($plankGroups as $key => $plankGroup): ?>
			<td></td>
		<? endforeach; ?>
		<td></td>
		<td><a href="#" class="b-clear-filter">Сбросить</a></td>
	</tr>
	<? foreach ($data as $i => $item): ?>
		<? $item->getCubages(); ?>
		<tr>
			<td class="align-left"><? echo $item->name; ?></td>
			<? foreach ($plankGroups as $key => $plankGroup): ?>
				<td><? if( isset($item->cubages[$plankGroup->id]) ): ?><?=number_format( $item->cubages[$plankGroup->id], 2, '.', '&nbsp;' )?><? endif; ?></td>
			<? endforeach; ?>
			<td class="tr"><?=number_format( $item->getMoney(), 2, '.', '&nbsp;' )?></td>
			<td>
				<? if( Yii::app()->user->checkAccess('updateSaw') ): ?><a href="<?php echo Yii::app()->createUrl('/'.$this->adminMenu["cur"]->code.'/adminupdate',array('id'=>$item->id))?>" class="ajax-form ajax-update b-tool b-tool-update" title="Редактировать <?=$this->adminMenu["cur"]->vin_name?>"></a>
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
    <div class="b-lot-count">Всего рабочих: <?=$count?></div>
    <div class="b-total right">
		<div class="b-total-row">
			<span class="b-total-name">Итого зарплата: </span>
			<span class="b-total-bold"><?=number_format( $total, 2, '.', '&nbsp;' )?></span>
		</div>
	</div>
</div>
