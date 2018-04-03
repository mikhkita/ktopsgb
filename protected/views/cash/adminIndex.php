<div class="b-section-nav clearfix">
	<div class="b-section-nav-back clearfix">
		<span class="left"><b>Группы:</b></span>
		<ul class="b-section-menu clearfix left">
			<? foreach ($types as $key => $type): ?>
				<li><a href="<?=$this->createUrl('/'.$this->adminMenu['cur']->code.'/adminindex', array('type_id' => $type->id))?>"<? if($type->id == $_GET["type_id"]): ?> class="active"<? endif; ?>><?=$type->name?></a></li>
			<? endforeach; ?>
		</ul>

		<span class="left"><b>Показывать:</b></span>
		<ul class="b-section-menu clearfix left">
			<li><a href="<?=$this->createUrl('/'.$this->adminMenu['cur']->code.'/adminindex', array("type_id" => $_GET["type_id"]))?>"<? if($this->isCurrentMonth($filter)): ?> class="active"<? endif; ?>>Текущий месяц</a></li>
			<li><a href="<?=$this->createUrl('/'.$this->adminMenu['cur']->code.'/adminindex', array("previous" => true, "type_id" => $_GET["type_id"]))?>"<? if($this->isPreviousMonth($filter)): ?> class="active"<? endif; ?>>Предыдущий месяц</a></li>
		</ul>
	</div>
</div>
<? if( Yii::app()->user->checkAccess('updateCash') ): ?><a href="<?php echo $this->createUrl('/'.$this->adminMenu["cur"]->code.'/admincreate',array('type_id' => $_GET["type_id"]))?>" class="ajax-form ajax-create b-butt b-top-butt b-with-nav">Добавить</a><? endif; ?>
<h1 class="b-with-nav"><?=$this->adminMenu["cur"]->name?></h1>
<?php $form=$this->beginWidget('CActiveForm'); ?>
<input type="hidden" name="type_id" value="<?=$_GET["type_id"]?>">
<table class="b-table" border="1">
	<tr>
		<? /* ?><th style="width: 30px;">№</th><? */ ?>
		<th style="width: 210px; min-width: 210px;"><?=$labels['date']?></th>
		<th><?=$labels['reason']?></th>
		<th><?=$labels['comment']?></th>
		<th><?=$labels['sum']?></th>
		<th><?=$labels['cheque']?></th>
		<th style="width: 100px;">Действия</th>
	</tr>
	<tr class="b-filter">
		<td><?php echo CHtml::activeTextField($filter, 'date_from', array('tabindex' => 0, "placeholder" => "От", "class" => "date")); ?><span class="filter-separator">-</span><?php echo CHtml::activeTextField($filter, 'date_to', array('tabindex' => 0, "placeholder" => "До", "class" => "date")); ?></td>
		<td><?php echo CHtml::activeTextField($filter, 'reason', array('class'=>'autocomplete', 'tabindex' => 1, "placeholder" => "Поиск по пояснению", 'data-values' => Cash::getReasons($_GET["type_id"]))); ?></td>
		<td><?php echo CHtml::activeTextField($filter, 'comment', array('tabindex' => 2, "placeholder" => "Поиск по комментарию")); ?></td>
		<td></td>
		<td></td>
		<td><a href="#" class="b-clear-filter">Сбросить</a></td>
	</tr>
	<? if( count($data) ): ?>
		<? foreach ($data as $i => $item): ?>
			<tr>
				<? /* ?><td class="align-left"><? echo $item->id; ?></td><? */ ?>
				<td class="tc"><?=$item->date?></td>
				<td><?=$item->reason?></td>
				<td><?=$item->comment?></td>
				<td class="tright <?=(($item->negative)?"red":"green")?>"><?=(($item->negative)?"-":"+")?><?=number_format( $item->sum, 0, ',', '&nbsp;' )?></td>
				<td><?=(($item->cheque)?"Есть":"Отсутствует")?></td>
				<td>
					<? if( Yii::app()->user->checkAccess('updateCash') ): ?>
						<a href="<?php echo Yii::app()->createUrl('/'.$this->adminMenu["cur"]->code.'/adminupdate',array('id'=>$item->id, 'type_id' => $_GET["type_id"]))?>" class="ajax-form ajax-update b-tool b-tool-update" title="Редактировать <?=$this->adminMenu["cur"]->vin_name?>"></a>
						<a href="<?=Yii::app()->createUrl('/'.$this->adminMenu["cur"]->code.'/admindelete',array('id'=>$item->id))?>" class="ajax-form ajax-delete b-tool b-tool-delete" title="Удалить <?=$this->adminMenu["cur"]->vin_name?>"></a>
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
    <div class="b-lot-count">Всего платежей: <?=$cashCount?></div>
    <div class="b-total right">
		<div class="b-total-row">
			<span class="b-total-name">Итого: </span>
			<span class="b-total-bold"><?=number_format( $total, 2, '.', '&nbsp;' )?></span>
		</div>
	</div>
</div>
