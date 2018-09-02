<div class="b-section-nav clearfix">
	<div class="b-section-nav-back clearfix">
		<span class="left"><b>Тип:</b></span>
		<ul class="b-section-menu clearfix left">
			<? foreach ($payments as $key => $payment): ?>
				<li><a href="<?=$this->createUrl('/'.$this->adminMenu['cur']->code.'/adminindex', array('payment_id' => $payment->id))?>"<? if($payment->id == $_GET["payment_id"]): ?> class="active"<? endif; ?>><?=$payment->name?></a></li>
			<? endforeach; ?>
		</ul>

		<span class="left"><b>Показывать:</b></span>
		<ul class="b-section-menu clearfix left">
			<li><a href="<?=$this->createUrl('/'.$this->adminMenu['cur']->code.'/adminindex', array("current_month" => true, "payment_id" => $_GET["payment_id"]))?>"<? if($this->isCurrentMonth($filter)): ?> class="active"<? endif; ?>>Текущий месяц</a></li>
			<li><a href="<?=$this->createUrl('/'.$this->adminMenu['cur']->code.'/adminindex', array("previous" => true, "payment_id" => $_GET["payment_id"]))?>"<? if($this->isPreviousMonth($filter)): ?> class="active"<? endif; ?>>Предыдущий месяц</a></li>
		</ul>
	</div>
</div>
<? if( Yii::app()->user->checkAccess('updateWood') ): ?><a href="<?php echo $this->createUrl('/'.$this->adminMenu["cur"]->code.'/admincreate',array('payment_id' => $_GET["payment_id"]))?>" class="ajax-form ajax-create b-butt b-top-butt b-with-nav">Добавить</a><? endif; ?>
<h1 class="b-with-nav"><?=$this->adminMenu["cur"]->name?></h1>
<?php $form=$this->beginWidget('CActiveForm'); ?>
<input type="hidden" name="payment_id" value="<?=$_GET["payment_id"]?>">
<table class="b-table" border="1">
	<tr>
		<? /* ?><th style="width: 30px;">№</th><? */ ?>
		<th style="width: 210px; min-width: 210px;"><?=$labels['date']?></th>
		<? if($_GET["payment_id"] != 1): ?>
			<th><?=$labels['provider_id']?></th>
		<? endif; ?>
		<th><?=$labels['species_id']?></th>
		<th><?=$labels['cubage']?></th>
		<th><?=$labels['price']?></th>
		<th><?=$labels['sum']?></th>
		<th><?=$labels['car']?></th>
		<? if($_GET["payment_id"] == 1): ?>
			<th><?=$labels['group_id']?></th>
		<? else: ?>
			<th><?=$labels['paid']?></th>
		<? endif; ?>
		<th><?=$labels['comment']?></th>
		<th style="width: 100px;">Действия</th>
	</tr>
	<tr class="b-filter">
		<td><?php echo CHtml::activeTextField($filter, 'date_from', array('tabindex' => 0, "placeholder" => "От", "class" => "date")); ?><span class="filter-separator">-</span><?php echo CHtml::activeTextField($filter, 'date_to', array('tabindex' => 0, "placeholder" => "До", "class" => "date")); ?></td>
		<? if($_GET["payment_id"] != 1): ?>
			<td><?php echo CHtml::activeDropDownList($filter, 'provider_id', CHtml::listData(Correspondent::model()->providers()->findAll(), 'id', 'name'), array("class" => "select2", "empty" => "Все поставщики", "tabindex" => 1, "placeholder" => "Поиск по поставщику")); ?></td>
		<? endif; ?>
		<td><?php echo CHtml::activeDropDownList($filter, 'species_id', CHtml::listData(Species::model()->findAll(), 'id', 'name'), array("class" => "select2", "empty" => "Любая порода", "tabindex" => 1, "placeholder" => "Поиск по породе")); ?></td>
		<td></td>
		<td></td>
		<td></td>
		<td><?php echo CHtml::activeTextField($filter, 'car', array('tabindex' => 2, "placeholder" => "Поиск по авто")); ?></td>
		<? if($_GET["payment_id"] == 1): ?>
			<td><?php echo CHtml::activeDropDownList($filter, 'group_id', CHtml::listData(WoodGroup::model()->sorted()->findAll(), 'id', 'name'), array("class" => "select2", "empty" => "Все группы", "tabindex" => 1, "placeholder" => "Поиск по группе")); ?></td>
		<? else: ?>
			<td><?php echo CHtml::activeDropDownList($filter, 'paid', array( "" => "Не важно", 0 => "Нет", 1 => "Да"), array("class" => "select2", 'tabindex' => 3)); ?></td>
		<? endif; ?>
		<td></td>
		<td><a href="#" class="b-clear-filter">Сбросить</a></td>
	</tr>
	<? if( count($data) ): ?>
		<? foreach ($data as $i => $item): ?>
			<tr>
				<? /* ?><td class="align-left"><? echo $item->id; ?></td><? */ ?>
				<td class="tc"><?=$item->date?></td>
				<? if($_GET["payment_id"] != 1): ?>
					<td><?=$item->provider->name?></td>
				<? endif; ?>
				<td class="tr"><?=$item->species->name?></td>
				<td class="tr"><?=$item->cubage?></td>
				<td class="tr"><?=number_format( $item->price, 0, ',', '&nbsp;' )?></td>
				<td class="tr"><?=number_format( $item->sum, 0, ',', '&nbsp;' )?></td>
				<td><?=$item->car?></td>
				<? if($_GET["payment_id"] == 1): ?>
					<td><?=$item->group->name?></td>
				<? else: ?>
					<td><?=(($item->paid)?"Да":"Нет")?></td>
				<? endif; ?>
				<td class="tr"><?=$item->comment?></td>
				<td>
					<? if( Yii::app()->user->checkAccess('updateWood') ): ?>
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
    <div class="b-lot-count">Всего отгрузок: <?=$woodCount?></div>
    <div class="b-total right">
		<div class="b-total-row">
			<span class="b-total-name">Итого кубов: </span>
			<span class="b-total-bold"><?=number_format( $totals->cubage, 2, '.', '&nbsp;' )?></span>
		</div>
		<div class="b-total-row">
			<span class="b-total-name">Итого денег: </span>
			<span class="b-total-bold"><?=number_format( round($totals->sum), 2, '.', '&nbsp;' )?></span>
		</div>
	</div>
</div>
