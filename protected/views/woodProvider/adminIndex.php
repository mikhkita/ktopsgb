<? if( Yii::app()->user->checkAccess('updateWood') ): ?><a href="<?php echo $this->createUrl("/".$this->adminMenu["cur"]->code."/adminCreate")?>" class="ajax-form ajax-create b-butt b-top-butt">Добавить</a><? endif; ?>
<h1><?=$this->adminMenu["cur"]->name?></h1>
<?php $form=$this->beginWidget('CActiveForm'); ?>
<table class="b-table" border="1">
	<tr>
		<th style="width: 30px;">№</th>
		<th><? echo $labels["name"]; ?></th>
		<th><? echo $labels["phone"]; ?></th>
		<th><? echo $labels["email"]; ?></th>
		<th><? echo $labels["inn"]; ?></th>
		<th><? echo $labels["sort"]; ?></th>
		<th style="width: 100px;">Действия</th>
	</tr>
	<tr class="b-filter">
		<td></td>
		<td><?php echo CHtml::activeTextField($filter, 'name', array('tabindex' => 1, "placeholder" => "Поиск по наименованию")); ?></td>
		<td><?php echo CHtml::activeTextField($filter, 'phone', array('tabindex' => 2, "placeholder" => "Поиск по телефону")); ?></td>
		<td><?php echo CHtml::activeTextField($filter, 'email', array('tabindex' => 3, "placeholder" => "Поиск по E-mail")); ?></td>
		<td></td>
		<td></td>
		<td><a href="#" class="b-clear-filter">Сбросить</a></td>
	</tr>
	<? foreach ($data as $i => $item): ?>
		<tr>
			<td><? echo $item->id; ?></td>
			<td class="align-left"><? echo $item->name; ?></td>
			<td class="align-left"><? echo $item->phone; ?></td>
			<td class="align-left"><? echo $item->email; ?></td>
			<td class="align-left"><? echo $item->inn; ?></td>
			<td class="align-left"><? echo $item->sort; ?></td>
			<td>
				<? if( Yii::app()->user->checkAccess('updateWood') ): ?><a href="<?php echo Yii::app()->createUrl('/'.$this->adminMenu["cur"]->code.'/adminupdate',array('id'=>$item->id))?>" class="ajax-form ajax-update b-tool b-tool-update" title="Редактировать <?=$this->adminMenu["cur"]->vin_name?>"></a>
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
    <div class="b-lot-count">Всего поставщиков: <?=$woodProviderCount?></div>
</div>
